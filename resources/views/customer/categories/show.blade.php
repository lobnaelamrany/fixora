@extends('layouts.fixora')

@section('title', $category->name . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen">
    {{-- Header --}}
    <section class="relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-fixora-orange/15 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-fixora-pink/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-12">
            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.categories.all') }}
            </a>

            <div class="max-w-2xl">
                <h1 class="text-4xl lg:text-5xl font-bold text-fixora-maroon mb-4 tracking-tight">
                    {{ $category->name }}
                </h1>
                <p class="text-lg text-fixora-slate">
                    {{ $category->description }}
                </p>
            </div>
        </div>
    </section>

    {{-- Professionals Grid --}}
    <section class="pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($professionals->isEmpty())
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-12 text-center">
                    <div class="w-20 h-20 bg-fixora-beige rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-fixora-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.professionals.no_results') }}</h3>
                    <p class="text-fixora-slate">{{ __('app.professionals.try_adjust') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($professionals as $pro)
                        <div class="group bg-white rounded-2xl overflow-hidden shadow-card hover:shadow-hover hover-lift transition-smooth border border-fixora-beige-dark/50">

                            <div class="relative h-32 overflow-hidden bg-gradient-to-br from-fixora-maroon via-fixora-orange to-fixora-pink">
                                @if ($pro->cover_photo_url)
                                    <img src="{{ $pro->cover_photo_url }}" alt="{{ $pro->display_name }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-smooth">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-fixora-maroon/60 to-transparent"></div>

                                @if ($pro->is_available_now)
                                    <div class="absolute top-3 right-3 inline-flex items-center gap-1 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full">
                                        <span class="w-2 h-2 bg-fixora-olive rounded-full animate-pulse"></span>
                                        <span class="text-xs font-semibold text-fixora-olive">{{ __('app.professionals.available_now') }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="relative -mt-10 px-6">
                                <div class="w-20 h-20 rounded-2xl border-4 border-white shadow-card overflow-hidden bg-white">
                                    @if ($pro->profile_photo_url)
                                        <img src="{{ $pro->profile_photo_url }}" alt="{{ $pro->display_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-fixora-orange flex items-center justify-center text-white text-2xl font-bold">
                                            {{ strtoupper(substr($pro->display_name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="px-6 pt-3 pb-6">
                                <div class="flex items-center gap-2 mb-1">
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

                                <p class="text-sm text-fixora-slate mb-3 line-clamp-2 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($pro->description, 90) }}
                                </p>

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
            @endif
        </div>
    </section>
</div>
@endsection
