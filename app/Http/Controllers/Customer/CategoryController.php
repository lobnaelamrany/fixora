<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = ServiceCategory::active()
            ->root()
            ->withCount('providers')
            ->get();

        return view('customer.categories.index', compact('categories'));
    }

    public function show(ServiceCategory $category): View
    {
        $professionals = $category->providers()
            ->where('verification_status', 'verified')
            ->whereHas('user', fn($q) => $q->where('account_status', 'active'))
            ->with(['user', 'areas', 'availabilities'])
            ->withCount('reviews')
            ->get();

        return view('customer.categories.show', compact('category', 'professionals'));
    }
}
