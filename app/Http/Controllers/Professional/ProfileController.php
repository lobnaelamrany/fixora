<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ProviderAvailability;
use App\Models\ServiceArea;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->providerProfile;

        if (!$profile) {
            $profile = $user->providerProfile()->create([
                'verification_status' => 'pending',
            ]);
        }

        $profile->load(['services', 'areas', 'availabilities']);

        $categories = ServiceCategory::active()->root()->get();
        $areas = ServiceArea::active()->orderBy('city')->get();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('professional.profile.edit', compact('profile', 'categories', 'areas', 'days'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'business_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'languages' => ['nullable'], // نقبلو string ولا array
            'is_available_now' => ['nullable', 'boolean'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        // Convert languages string (JSON) to array
        if (isset($data['languages']) && is_string($data['languages'])) {
            $decoded = json_decode($data['languages'], true);
            $data['languages'] = is_array($decoded) ? $decoded : [];
        } elseif (!isset($data['languages'])) {
            $data['languages'] = [];
        }

        $profile = $request->user()->providerProfile;

        if (!$profile) {
            return back()->with('error', 'Provider profile not found.');
        }

        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
            if ($profile->profile_photo && Storage::disk('public')->exists($profile->profile_photo)) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Handle cover photo
        if ($request->hasFile('cover_photo')) {
            if ($profile->cover_photo && Storage::disk('public')->exists($profile->cover_photo)) {
                Storage::disk('public')->delete($profile->cover_photo);
            }
            $data['cover_photo'] = $request->file('cover_photo')->store('covers', 'public');
        }

        $data['is_available_now'] = $request->boolean('is_available_now');

        $profile->update($data);

        return redirect()
            ->route('pro.profile.edit', ['tab' => 'general'])
            ->with('success', 'Profile updated successfully.');
    }

    public function updateServices(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'services' => ['required', 'array', 'min:1'],
            'services.*' => ['exists:service_categories,id'],
        ]);

        $request->user()->providerProfile->services()->sync($data['services']);

        return redirect()
            ->route('pro.profile.edit', ['tab' => 'services'])
            ->with('success', 'Services updated successfully.');
    }

    public function updateAreas(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'areas' => ['required', 'array', 'min:1'],
            'areas.*' => ['exists:service_areas,id'],
        ]);

        $request->user()->providerProfile->areas()->sync($data['areas']);

        return redirect()
            ->route('pro.profile.edit', ['tab' => 'areas'])
            ->with('success', 'Service areas updated successfully.');
    }

    public function updateAvailability(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'availability' => ['required', 'array'],
            'availability.*.start_time' => ['nullable', 'date_format:H:i'],
            'availability.*.end_time' => ['nullable', 'date_format:H:i'],
            'availability.*.is_available' => ['nullable', 'boolean'],
        ]);

        $profile = $request->user()->providerProfile;

        foreach ($data['availability'] as $day => $values) {
            ProviderAvailability::updateOrCreate(
                [
                    'provider_profile_id' => $profile->id,
                    'day_of_week' => $day,
                ],
                [
                    'start_time' => $values['start_time'] ?? '09:00',
                    'end_time' => $values['end_time'] ?? '18:00',
                    'is_available' => isset($values['is_available']) && $values['is_available'] ? true : false,
                ]
            );
        }

        return redirect()
            ->route('pro.profile.edit', ['tab' => 'availability'])
            ->with('success', 'Availability updated successfully.');
    }
}
