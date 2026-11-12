<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        // ✅ Authorization: فقط Customer صاحب الـ request
        abort_unless($serviceRequest->customer_id === $request->user()->id, 403);

        // ✅ فقط بعد Completed
        abort_unless($serviceRequest->status === 'completed', 422, 'You can only review completed requests.');

        // ✅ منع duplicate
        abort_if($serviceRequest->review()->exists(), 422, 'You already reviewed this request.');

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($serviceRequest, $request, $data) {
            // Create review
            $serviceRequest->review()->create([
                'customer_id' => $request->user()->id,
                'provider_profile_id' => $serviceRequest->provider_profile_id,
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
            ]);

            // ✅ Update provider average rating
            $provider = $serviceRequest->providerProfile;

            if ($provider) {
                $provider->update([
                    'average_rating' => round($provider->reviews()->avg('rating'), 2),
                ]);
            }
        });

        return redirect()
            ->route('customer.requests.show', $serviceRequest)
            ->with('success', 'Thank you for your review!');
    }
}
