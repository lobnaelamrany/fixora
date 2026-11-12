<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestStatusHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');

        $query = ServiceRequest::forCustomer($request->user()->id)
            ->with(['serviceCategory', 'providerProfile.user'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $requests = $query->paginate(10);

        return view('customer.requests.index', compact('requests', 'status'));
    }

    public function create(Request $request): View
    {
        $categories = ServiceCategory::active()->root()->get();
        $provider = null;

        if ($request->filled('provider')) {
            $provider = ProviderProfile::with('user', 'services', 'areas')
                ->findOrFail($request->input('provider'));
        }

        return view('customer.requests.create', compact('categories', 'provider'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'provider_profile_id' => ['nullable', 'exists:provider_profiles,id'],
            'service_title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'customer_type' => ['required', 'in:individual,business'],
            'company_name' => ['nullable', 'string', 'max:255', 'required_if:customer_type,business'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'preferred_time' => ['nullable', 'date_format:H:i'],
            'urgency_level' => ['required', 'in:normal,urgent'],
        ]);

        $serviceRequest = DB::transaction(function () use ($request, $data) {
            return ServiceRequest::create([
                ...$data,
                'reference_number' => 'FXR-'.now()->format('Ymd').'-'.strtoupper(Str::random(6)),
                'customer_id' => $request->user()->id,
                'status' => 'pending',
                'submitted_at' => now(),
            ]);
        });

        return redirect()
            ->route('customer.requests.show', $serviceRequest)
            ->with('success', 'Service request created successfully.');
    }

    public function show(Request $request, ServiceRequest $serviceRequest): View
    {
        abort_unless($serviceRequest->customer_id === $request->user()->id, 403);

        $serviceRequest->load([
            'serviceCategory',
            'providerProfile.user',
            'attachments',
            'statusHistory.changedBy',
            'review', // ✅ زيدنا هاد السطر
        ]);

        return view('customer.requests.show', compact('serviceRequest'));
    }

    public function cancel(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->customer_id === $request->user()->id, 403);
        abort_unless(in_array($serviceRequest->status, ['pending', 'accepted']), 422, 'This request cannot be cancelled.');

        $data = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($serviceRequest, $request, $data) {
            ServiceRequestStatusHistory::create([
                'service_request_id' => $serviceRequest->id,
                'changed_by' => $request->user()->id,
                'old_status' => $serviceRequest->status,
                'new_status' => 'cancelled',
                'note' => $data['cancellation_reason'] ?? 'Cancelled by customer',
            ]);

            $serviceRequest->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $data['cancellation_reason'] ?? null,
            ]);
        });

        return redirect()
            ->route('customer.requests.show', $serviceRequest)
            ->with('success', 'Request cancelled successfully.');
    }
}
