@extends('layouts.fixora')

@section('title', __('app.customer.dashboard_title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">
                    {{ __('app.customer.dashboard_welcome') }}, {{ auth()->user()->name }}!
                </h1>
                <p class="text-fixora-slate mt-1">{{ __('app.customer.dashboard_subtitle') }}</p>
            </div>
            <a href="{{ route('customer.requests.create') }}"
               class="bg-fixora-maroon text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                + {{ __('app.customer.new_request') }}
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('customer.requests.index') }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.customer.stats.total') }}</p>
                <p class="text-3xl font-bold text-fixora-maroon group-hover:scale-110 transition-smooth origin-left">{{ $stats['total'] }}</p>
            </a>
            <a href="{{ route('customer.requests.index', ['status' => 'pending']) }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.customer.stats.pending') }}</p>
                <p class="text-3xl font-bold text-fixora-amber group-hover:scale-110 transition-smooth origin-left">{{ $stats['pending'] }}</p>
            </a>
            <a href="{{ route('customer.requests.index', ['status' => 'accepted']) }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.customer.stats.accepted') }}</p>
                <p class="text-3xl font-bold text-fixora-orange group-hover:scale-110 transition-smooth origin-left">{{ $stats['accepted'] }}</p>
            </a>
            <a href="{{ route('customer.requests.index', ['status' => 'completed']) }}"
               class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth group">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.customer.stats.completed') }}</p>
                <p class="text-3xl font-bold text-fixora-olive group-hover:scale-110 transition-smooth origin-left">{{ $stats['completed'] }}</p>
            </a>
        </div>

        {{-- CTA --}}
        <div class="bg-fixora-orange/10 border border-fixora-orange rounded-2xl p-6 mb-8">
            <h2 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.customer.need_something') }}</h2>
            <p class="text-fixora-slate mb-4">{{ __('app.customer.need_something_desc') }}</p>
            <a href="{{ route('customer.requests.create') }}"
               class="inline-block bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                + {{ __('app.customer.new_request') }}
            </a>
        </div>

        {{-- Recent Requests --}}
        @if ($recentRequests->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-fixora-maroon">{{ __('app.customer.recent_requests') }}</h2>
                    <a href="{{ route('customer.requests.index') }}" class="text-sm text-fixora-orange font-semibold hover:text-fixora-maroon">
                        {{ __('app.customer.view_all') }} →
                    </a>
                </div>

                <div class="space-y-3">
                    @foreach ($recentRequests as $req)
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
                        <a href="{{ route('customer.requests.show', $req) }}"
                           class="block p-4 rounded-xl bg-fixora-beige-light hover:bg-fixora-beige transition-smooth">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-fixora-maroon">{{ $req->service_title }}</p>
                                    <p class="text-sm text-fixora-slate">
                                        {{ $req->serviceCategory->name }} · {{ $req->city }}
                                        @if ($req->providerProfile)
                                            · {{ $req->providerProfile->business_name ?? $req->providerProfile->user->name }}
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusColors[$req->status] ?? '' }}">
                                    {{ __('app.status.' . $req->status) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
