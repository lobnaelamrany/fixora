<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use App\Models\ServiceArea;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfessionalController extends Controller
{
    public function index(Request $request): View
    {
        $query = ProviderProfile::query()
            ->where('verification_status', 'verified')
            ->whereHas('user', fn($q) => $q->where('account_status', 'active'))
            ->with(['user', 'services', 'areas'])
            ->withCount('reviews');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('services', fn($q) => $q->where('service_categories.id', $request->category));
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->whereHas('areas', fn($q) => $q->where('city', $request->city));
        }

        // Search by name
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        // Sort
        $sort = $request->query('sort', 'rating');
        match ($sort) {
            'rating' => $query->orderByDesc('average_rating'),
            'experience' => $query->orderByDesc('experience_years'),
            'services' => $query->orderByDesc('completed_services_count'),
            default => $query->orderByDesc('average_rating'),
        };

        $professionals = $query->paginate(12);
        $categories = ServiceCategory::active()->root()->get();
        $cities = ServiceArea::active()->orderBy('city')->pluck('city');

        return view('customer.professionals.index', compact('professionals', 'categories', 'cities', 'sort'));
    }

    public function show(ProviderProfile $provider): View
    {
        abort_unless(
            $provider->verification_status === 'verified'
            && $provider->user->account_status === 'active',
            404
        );

        $provider->load([
            'user',
            'services',
            'areas',
            'availabilities',
            'reviews' => fn($q) => $q->with('customer')->latest()->limit(10),
        ]);

        $stats = [
            'total_reviews' => $provider->reviews()->count(),
            'five_star' => $provider->reviews()->where('rating', 5)->count(),
            'four_star' => $provider->reviews()->where('rating', 4)->count(),
            'three_star' => $provider->reviews()->where('rating', 3)->count(),
            'two_star' => $provider->reviews()->where('rating', 2)->count(),
            'one_star' => $provider->reviews()->where('rating', 1)->count(),
        ];

        return view('customer.professionals.show', compact('provider', 'stats'));
    }
}
