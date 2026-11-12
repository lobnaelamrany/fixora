@extends('layouts.fixora')

@section('title', __('app.admin.categories_title') . ' — Admin')

@section('content')
<div class="bg-autumn min-h-screen py-10" x-data="{ showForm: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-fixora-slate hover:text-fixora-orange font-medium mb-2 inline-block">← {{ __('app.nav.admin') }}</a>
                <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.admin.categories_title') }}</h1>
                <p class="text-fixora-slate mt-1">{{ __('app.admin.categories_subtitle') }}</p>
            </div>
            <button @click="showForm = !showForm"
                    class="bg-fixora-maroon text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                + {{ __('app.admin.new_category') }}
            </button>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-fixora-olive/10 border border-fixora-olive text-fixora-olive px-4 py-3 rounded-xl">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- Create Form --}}
        <div x-show="showForm" x-transition x-cloak class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 mb-6">
            <h2 class="text-xl font-bold text-fixora-maroon mb-4">{{ __('app.admin.new_category') }}</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.admin.category_name_fr') }} *</label>
                        <input type="text" name="name_fr" required
                               class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.admin.category_name_en') }} *</label>
                        <input type="text" name="name_en" required
                               class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.admin.category_name_de') }}</label>
                        <input type="text" name="name_de"
                               class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.admin.category_desc_fr') }}</label>
                    <textarea name="description_fr" rows="2"
                              class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none resize-none"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                        {{ __('app.admin.create_category') }}
                    </button>
                    <button type="button" @click="showForm = false"
                            class="bg-fixora-beige text-fixora-maroon px-6 py-3 rounded-xl font-semibold hover:bg-fixora-beige-dark transition-smooth">
                        {{ __('app.buttons.cancel') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Categories List --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($categories as $cat)
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-5">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-bold text-fixora-maroon">{{ $cat->name }}</h3>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $cat->is_active ? 'bg-fixora-olive/10 text-fixora-olive' : 'bg-gray-100 text-gray-600' }}">
                            {{ $cat->is_active ? __('app.admin.active') : __('app.admin.inactive') }}
                        </span>
                    </div>
                    <p class="text-sm text-fixora-slate mb-3 line-clamp-2">{{ $cat->description }}</p>
                    <p class="text-xs text-fixora-mist mb-3">{{ $cat->providers_count }} {{ __('app.categories.professionals') }}</p>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                          onsubmit="return confirm('{{ __('app.admin.delete_category') }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-sm text-red-600 hover:text-red-800 font-semibold">
                            {{ __('app.admin.delete_category') }}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
