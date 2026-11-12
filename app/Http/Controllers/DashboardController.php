<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'professional' => $this->professionalDashboard($user),
            default => $this->customerDashboard($user),
        };
    }

    private function customerDashboard($user): View
    {
        $requests = ServiceRequest::forCustomer($user->id);

        $stats = [
            'total' => $requests->count(),
            'pending' => $requests->where('status', 'pending')->count(),
            'accepted' => $requests->where('status', 'accepted')->count(),
            'in_progress' => $requests->where('status', 'in_progress')->count(),
            'completed' => $requests->where('status', 'completed')->count(),
        ];

        $recentRequests = ServiceRequest::forCustomer($user->id)
            ->with(['serviceCategory', 'providerProfile'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.customer', compact('stats', 'recentRequests'));
    }

    private function professionalDashboard($user): View
    {
        $profile = $user->providerProfile;

        if (!$profile) {
            return view('dashboard.professional', [
                'stats' => [
                    'new' => 0,
                    'accepted' => 0,
                    'in_progress' => 0,
                    'completed' => 0,
                    'rating' => 0,
                ],
                'recentRequests' => collect(),
                'profile' => null,
            ]);
        }

        $requests = ServiceRequest::where('provider_profile_id', $profile->id);

        $stats = [
            'new' => (clone $requests)->where('status', 'pending')->count(),
            'accepted' => (clone $requests)->where('status', 'accepted')->count(),
            'in_progress' => (clone $requests)->where('status', 'in_progress')->count(),
            'completed' => (clone $requests)->where('status', 'completed')->count(),
            'rating' => $profile->average_rating,
        ];

        $recentRequests = ServiceRequest::where('provider_profile_id', $profile->id)
            ->with(['customer', 'serviceCategory'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.professional', compact('stats', 'recentRequests', 'profile'));
    }

    private function adminDashboard(): View
    {
        $stats = [
            'users' => User::count(),
            'professionals' => User::where('role', 'professional')->count(),
            'requests' => ServiceRequest::count(),
            'categories' => ServiceCategory::count(),
        ];

        $recentRequests = ServiceRequest::with(['customer', 'serviceCategory'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentRequests'));
    }
}
