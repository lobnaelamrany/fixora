@extends('layouts.fixora')

@section('title', __('app.professional.dashboard_title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">
                    {{ __('app.professional.dashboard_welcome') }}, {{ auth()->user()->providerProfile?->business_name ?? auth()->user()->name }}!
                </h1>
                <p class="text-fixora-slate mt-1">{{ __('app.professional.dashboard_subtitle') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pro.profile.edit') }}"
                   class="bg-white text-fixora-maroon px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-beige border border-fixora-beige-dark/50 transition-smooth shadow-soft">
                    {{ __('app.professional.edit_profile') }}
                </a>
                <a href="{{ route('pro.requests.index') }}"
                   class="bg-fixora-maroon text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                    {{ __('app.professional.view_all_requests') }}
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <a href="{{ route('pro.requests.index', ['status' => 'pending']) }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.professional.stats.new') }}</p>
                <p class="text-3xl font-bold text-fixora-amber group-hover:scale-110 transition-smooth origin-left">{{ $stats['new'] }}</p>
            </a>
            <a href="{{ route('pro.requests.index', ['status' => 'accepted']) }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.professional.stats.accepted') }}</p>
                <p class="text-3xl font-bold text-fixora-orange group-hover:scale-110 transition-smooth origin-left">{{ $stats['accepted'] }}</p>
            </a>
            <a href="{{ route('pro.requests.index', ['status' => 'in_progress']) }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.professional.stats.in_progress') }}</p>
                <p class="text-3xl font-bold text-fixora-pink group-hover:scale-110 transition-smooth origin-left">{{ $stats['in_progress'] }}</p>
            </a>
            <a href="{{ route('pro.requests.index', ['status' => 'completed']) }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.professional.stats.completed') }}</p>
                <p class="text-3xl font-bold text-fixora-olive group-hover:scale-110 transition-smooth origin-left">{{ $stats['completed'] }}</p>
            </a>
            <div class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.professional.stats.rating') }}</p>
                <p class="text-3xl font-bold text-fixora-maroon">★ {{ number_format($stats['rating'], 1) }}</p>
            </div>
        </div>

        {{-- Complete Profile CTA --}}
        @if (!$profile || !$profile->services->count() || !$profile->areas->count())
            <div class="bg-fixora-orange/10 border border-fixora-orange rounded-2xl p-6 mb-8">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-fixora-orange/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.professional.complete_profile_title') }}</h2>
                        <p class="text-fixora-slate mb-4">{{ __('app.professional.complete_profile_desc') }}</p>
                        <a href="{{ route('pro.profile.edit') }}"
                           class="inline-block bg-fixora-orange text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-maroon transition-smooth shadow-card">
                            {{ __('app.professional.complete_profile') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Recent Requests --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-fixora-maroon">{{ __('app.professional.recent_requests') }}</h2>
                @if ($recentRequests->isNotEmpty())
                    <a href="{{ route('pro.requests.index') }}" class="text-sm text-fixora-orange font-semibold hover:text-fixora-maroon">
                        {{ __('app.customer.view_all') }} →
                    </a>
                @endif
            </div>

            @if ($recentRequests->isEmpty())
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-fixora-beige rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-fixora-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-fixora-slate font-medium mb-2">{{ __('app.professional.no_requests') }}</p>
                    <p class="text-sm text-fixora-mist">{{ __('app.professional.complete_profile_desc') }}</p>
                </div>
            @else
                @php
                    $statusColors = [
                        'pending' => 'bg-fixora-amber/10 text-fixora-amber',
                        'accepted' => 'bg-fixora-orange/10 text-fixora-orange',
                        'in_progress' => 'bg-fixora-pink/10 text-fixora-pink',
                        'completed' => 'bg-fixora-olive/10 text-fixora-olive',
                        'declined' => 'bg-red-100 text-red-700',
                        'cancelled' => 'bg-gray-100 text-gray-600',
                    ];
                @endphp
                <div class="space-y-3">
                    @foreach ($recentRequests as $req)
                        <a href="{{ route('pro.requests.show', $req) }}"
                           class="block p-4 rounded-xl bg-fixora-beige-light hover:bg-fixora-beige transition-smooth border border-transparent hover:border-fixora-beige-dark/50">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex-1">
                                    <p class="font-semibold text-fixora-maroon">{{ $req->service_title }}</p>
                                    <p class="text-sm text-fixora-slate">
                                        {{ $req->customer->name }} · {{ $req->city }} · {{ $req->serviceCategory->name }}
                                    </p>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusColors[$req->status] ?? '' }} flex-shrink-0">
                                    {{ __('app.status.' . $req->status) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
