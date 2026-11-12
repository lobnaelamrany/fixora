<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');

        $providers = ProviderProfile::where('verification_status', $status)
            ->with(['user', 'services', 'areas'])
            ->latest()
            ->paginate(15);

        return view('admin.verification.index', compact('providers', 'status'));
    }

    public function verify(ProviderProfile $provider): RedirectResponse
    {
        $provider->update(['verification_status' => 'verified']);

        return back()->with('success', "{$provider->display_name} verified.");
    }

    public function reject(Request $request, ProviderProfile $provider): RedirectResponse
    {
        $provider->update(['verification_status' => 'rejected']);

        return back()->with('success', "{$provider->display_name} rejected.");
    }
}
