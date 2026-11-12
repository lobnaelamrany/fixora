<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ServiceCategory::withCount('providers')->latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name_fr' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_de' => ['nullable', 'string', 'max:255'],
            'description_fr' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'description_de' => ['nullable', 'string'],
        ]);

        ServiceCategory::create([
            'name' => [
                'fr' => $data['name_fr'],
                'en' => $data['name_en'],
                'de' => $data['name_de'] ?? $data['name_en'],
            ],
            'slug' => Str::slug($data['name_en']),
            'description' => [
                'fr' => $data['description_fr'] ?? '',
                'en' => $data['description_en'] ?? '',
                'de' => $data['description_de'] ?? '',
            ],
            'is_active' => true,
        ]);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, ServiceCategory $category): RedirectResponse
    {
        $data = $request->validate([
            'name_fr' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'name_de' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $category->update([
            'name' => [
                'fr' => $data['name_fr'],
                'en' => $data['name_en'],
                'de' => $data['name_de'] ?? $data['name_en'],
            ],
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(ServiceCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
