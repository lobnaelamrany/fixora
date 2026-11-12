<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestStatusHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(Request $request): View
    {
        $profile = $request->user()->providerProfile;

        $status = $request->query('status', 'all');

        $query = ServiceRequest::where('provider_profile_id', $profile->id)
            ->with(['customer', 'serviceCategory', 'attachments'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $requests = $query->paginate(10);

        return view('professional.requests.index', compact('requests', 'status'));
    }

    public function show(Request $request, ServiceRequest $serviceRequest): View
    {
        $profile = $request->user()->providerProfile;

        abort_unless($serviceRequest->provider_profile_id === $profile->id, 403);

        $serviceRequest->load([
            'customer',
            'serviceCategory',
            'attachments',
            'statusHistory.changedBy',
        ]);

        return view('professional.requests.show', compact('serviceRequest'));
    }

   public function accept(Request $request, ServiceRequest $serviceRequest): RedirectResponse
{
    $profile = $request->user()->providerProfile;

    abort_unless($serviceRequest->provider_profile_id === $profile->id, 403);
    abort_unless($serviceRequest->status === 'pending', 422, 'Request is not pending.');

    $conversation = DB::transaction(function () use ($serviceRequest, $request) {
        $this->changeStatus($serviceRequest, 'accepted', $request->user()->id, 'Request accepted');
        $serviceRequest->update(['accepted_at' => now()]);

        // Create conversation if not exists
        $conversation = $serviceRequest->conversation;

        if (!$conversation) {
            $conversation = \App\Models\Conversation::create([
                'service_request_id' => $serviceRequest->id,
                'customer_id' => $serviceRequest->customer_id,
                'provider_profile_id' => $serviceRequest->provider_profile_id,
            ]);
        }

        return $conversation;
    });

    // ✅ Redirect to conversation
    return redirect()
        ->route('conversations.show', $conversation)
        ->with('success', 'Request accepted! You can now chat with the customer.');
}
    public function decline(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $profile = $request->user()->providerProfile;

        abort_unless($serviceRequest->provider_profile_id === $profile->id, 403);
        abort_unless($serviceRequest->status === 'pending', 422, 'Request is not pending.');

        $data = $request->validate([
            'decline_reason' => ['required', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($serviceRequest, $request, $data) {
            $this->changeStatus($serviceRequest, 'declined', $request->user()->id, 'Request declined: '.$data['decline_reason']);
            $serviceRequest->update(['decline_reason' => $data['decline_reason']]);
        });

        return back()->with('success', 'Request declined.');
    }

    public function start(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $profile = $request->user()->providerProfile;

        abort_unless($serviceRequest->provider_profile_id === $profile->id, 403);
        abort_unless($serviceRequest->status === 'accepted', 422, 'Request must be accepted first.');

        DB::transaction(function () use ($serviceRequest, $request) {
            $this->changeStatus($serviceRequest, 'in_progress', $request->user()->id, 'Service started');
        });

        return back()->with('success', 'Service started.');
    }

    public function complete(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $profile = $request->user()->providerProfile;

        abort_unless($serviceRequest->provider_profile_id === $profile->id, 403);
        abort_unless($serviceRequest->status === 'in_progress', 422, 'Request must be in progress.');

        DB::transaction(function () use ($serviceRequest, $request) {
            $this->changeStatus($serviceRequest, 'completed', $request->user()->id, 'Service completed');
            $serviceRequest->update(['completed_at' => now()]);

            // Update provider stats
            $profile = $serviceRequest->providerProfile;
            $profile->increment('completed_services_count');
        });

        return back()->with('success', 'Service completed!');
    }

    private function changeStatus(ServiceRequest $serviceRequest, string $newStatus, int $changedBy, string $note = ''): void
    {
        $oldStatus = $serviceRequest->status;

        ServiceRequestStatusHistory::create([
            'service_request_id' => $serviceRequest->id,
            'changed_by' => $changedBy,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'note' => $note,
        ]);

        $serviceRequest->update(['status' => $newStatus]);
    }
}
