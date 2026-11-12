@extends('layouts.fixora')

@section('title', __('app.professionals.title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.professionals.title') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.professionals.subtitle') }}</p>
        </div>

        <form method="GET" action="{{ route('professionals.index') }}"
              class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-5 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="{{ __('app.professionals.search') }}"
                           class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                </div>

                <select name="category"
                        class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    <option value="">{{ __('app.professionals.all_categories') }}</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <select name="city"
                        class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    <option value="">{{ __('app.professionals.all_cities') }}</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') == $city)>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-4 border-t border-fixora-beige-dark">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-fixora-mist">{{ __('app.professionals.sort_by') }}</span>
                    @foreach (['rating' => __('app.professionals.rating'), 'experience' => __('app.professionals.experience'), 'services' => __('app.professionals.services')] as $key => $label)
                        <a href="{{ route('professionals.index', array_merge(request()->query(), ['sort' => $key])) }}"
                           class="px-3 py-1.5 rounded-lg font-semibold text-xs transition-smooth
                                  {{ $sort === $key ? 'bg-fixora-maroon text-white' : 'bg-fixora-beige text-fixora-slate hover:bg-fixora-beige-dark' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <div class="flex gap-2">
                    @if (request()->hasAny(['q', 'category', 'city', 'sort']))
                        <a href="{{ route('professionals.index') }}"
                           class="px-4 py-2 rounded-xl font-semibold text-sm text-fixora-slate hover:bg-fixora-beige transition-smooth">
                            {{ __('app.buttons.clear') }}
                        </a>
                    @endif
                    <button type="submit"
                            class="bg-fixora-maroon text-white px-5 py-2 rounded-xl font-semibold text-sm hover:bg-fixora-orange transition-smooth shadow-card">
                        {{ __('app.buttons.search') }}
                    </button>
                </div>
            </div>
        </form>

        <div class="mb-4">
            <p class="text-sm text-fixora-mist">
                <span class="font-semibold text-fixora-maroon">{{ $professionals->total() }}</span>
                {{ __('app.professionals.found') }}
            </p>
        </div>

        @if ($professionals->isEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-12 text-center">
                <div class="w-20 h-20 bg-fixora-beige rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-fixora-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.professionals.no_results') }}</h3>
                <p class="text-fixora-slate mb-6">{{ __('app.professionals.try_adjust') }}</p>
                <a href="{{ route('professionals.index') }}"
                   class="inline-block bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                    {{ __('app.professionals.reset') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($professionals as $pro)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-hover hover-lift transition-smooth border border-fixora-beige-dark/50">
                        <div class="relative h-44 overflow-hidden bg-gradient-to-br from-fixora-maroon via-fixora-orange to-fixora-pink">
                            @if ($pro->cover_photo_url)
                                <img src="{{ $pro->cover_photo_url }}" alt="{{ $pro->display_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-smooth">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>

                            @if ($pro->is_available_now)
                                <div class="absolute top-3 right-3 inline-flex items-center gap-1.5 bg-white/95 backdrop-blur px-3 py-1.5 rounded-full shadow-card">
                                    <span class="w-2 h-2 bg-fixora-olive rounded-full animate-pulse"></span>
                                    <span class="text-xs font-semibold text-fixora-olive">{{ __('app.professionals.available_now') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="relative -mt-14 px-6">
                            <div class="w-24 h-24 rounded-2xl border-4 border-white shadow-card overflow-hidden bg-white flex-shrink-0">
                                @if ($pro->profile_photo_url)
                                    <img src="{{ $pro->profile_photo_url }}" alt="{{ $pro->display_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white text-3xl font-bold">
                                        {{ strtoupper(substr($pro->display_name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="px-6 pt-3 pb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-lg font-bold text-fixora-maroon line-clamp-1">
                                    {{ $pro->display_name }}
                                </h3>
                                @if ($pro->verification_status === 'verified')
                                    <svg class="w-4 h-4 text-fixora-olive flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 mb-3">
                                <div class="flex items-center gap-1">
                                    <span class="text-fixora-orange font-bold">★</span>
                                    <span class="font-bold text-fixora-maroon text-sm">{{ number_format($pro->average_rating, 1) }}</span>
                                </div>
                                <span class="text-xs text-fixora-mist">({{ $pro->reviews_count }} {{ __('app.professionals.reviews') }})</span>
                                <span class="text-xs text-fixora-mist">•</span>
                                <span class="text-xs text-fixora-mist">{{ $pro->experience_years }} {{ __('app.professionals.years_exp') }}</span>
                            </div>

                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach ($pro->services->take(2) as $service)
                                    <span class="text-xs bg-fixora-orange/10 text-fixora-orange px-2 py-1 rounded-full font-medium">
                                        {{ $service->name }}
                                    </span>
                                @endforeach
                                @if ($pro->services->count() > 2)
                                    <span class="text-xs bg-fixora-beige text-fixora-slate px-2 py-1 rounded-full font-medium">
                                        +{{ $pro->services->count() - 2 }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach ($pro->areas->take(2) as $area)
                                    <span class="text-xs bg-fixora-beige text-fixora-slate px-2 py-1 rounded-full font-medium">
                                        📍 {{ $area->city }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('professionals.show', $pro) }}"
                                   class="flex-1 text-center bg-fixora-beige text-fixora-maroon px-4 py-2.5 rounded-xl font-semibold hover:bg-fixora-beige-dark transition-smooth text-sm">
                                    {{ __('app.professionals.view_profile') }}
                                </a>
                                <a href="{{ route('customer.requests.create', ['provider' => $pro->id]) }}"
                                   class="flex-1 text-center bg-fixora-orange text-white px-4 py-2.5 rounded-xl font-semibold hover:bg-fixora-maroon transition-smooth text-sm">
                                    {{ __('app.professionals.request') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">{{ $professionals->links() }}</div>
        @endif

    </div>
</div>
@endsection
