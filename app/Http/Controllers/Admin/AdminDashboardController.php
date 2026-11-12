<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use App\Models\ServiceCategory;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'customers' => User::where('role', 'customer')->count(),
            'professionals' => User::where('role', 'professional')->count(),
            'pending_verifications' => ProviderProfile::where('verification_status', 'pending')->count(),
            'verified_professionals' => ProviderProfile::where('verification_status', 'verified')->count(),
            'requests' => ServiceRequest::count(),
            'pending_requests' => ServiceRequest::where('status', 'pending')->count(),
            'completed_requests' => ServiceRequest::where('status', 'completed')->count(),
            'categories' => ServiceCategory::count(),
        ];

        $recentRequests = ServiceRequest::with(['customer', 'serviceCategory'])
            ->latest()
            ->limit(5)
            ->get();

        $recentUsers = User::latest()->limit(5)->get();

        $pendingProviders = ProviderProfile::where('verification_status', 'pending')
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'recentUsers', 'pendingProviders'));
    }
}
