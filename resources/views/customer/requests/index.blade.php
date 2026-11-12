@extends('layouts.fixora')

@section('title', __('app.customer.requests_title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.customer.requests_title') }}</h1>
                <p class="text-fixora-slate mt-1">{{ __('app.customer.requests_subtitle') }}</p>
            </div>
            <a href="{{ route('customer.requests.create') }}"
               class="inline-flex items-center gap-2 bg-fixora-maroon text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('app.customer.new_request') }}
            </a>
        </div>

        <div class="flex flex-wrap gap-2 mb-6">
            @foreach (['all', 'pending', 'accepted', 'in_progress', 'completed'] as $key)
                <a href="{{ route('customer.requests.index', ['status' => $key]) }}"
                   class="px-4 py-2 rounded-xl font-semibold text-sm transition-smooth
                          {{ $status === $key ? 'bg-fixora-maroon text-white shadow-card' : 'bg-white text-fixora-slate hover:bg-fixora-beige border border-fixora-beige-dark/50' }}">
                    {{ __('app.customer.filters.' . $key) }}
                </a>
            @endforeach
        </div>

        @if ($requests->isEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-12 text-center">
                <div class="w-20 h-20 bg-fixora-beige rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-fixora-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.customer.no_requests') }}</h3>
                <a href="{{ route('customer.requests.create') }}"
                   class="inline-flex items-center gap-2 bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                    {{ __('app.customer.create_first') }}
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($requests as $req)
                    @php
                        $statusConfig = [
                            'pending' => ['bg' => 'bg-fixora-amber/10', 'text' => 'text-fixora-amber', 'icon' => '⏳'],
                            'accepted' => ['bg' => 'bg-fixora-orange/10', 'text' => 'text-fixora-orange', 'icon' => '✓'],
                            'in_progress' => ['bg' => 'bg-fixora-pink/10', 'text' => 'text-fixora-pink', 'icon' => '⚙'],
                            'completed' => ['bg' => 'bg-fixora-olive/10', 'text' => 'text-fixora-olive', 'icon' => '🎉'],
                            'declined' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'icon' => '✗'],
                            'cancelled' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => '⊘'],
                        ];
                        $status = $statusConfig[$req->status] ?? $statusConfig['pending'];
                    @endphp

                    <a href="{{ route('customer.requests.show', $req) }}"
                       class="group block bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 overflow-hidden hover:shadow-hover hover-lift transition-smooth">
                        <div class="h-1 {{ $status['bg'] }}"></div>
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-3">
                                        <span class="font-mono text-xs text-fixora-mist bg-fixora-beige px-2 py-1 rounded">
                                            {{ $req->reference_number }}
                                        </span>
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                                            {{ $status['icon'] }} {{ __('app.status.' . $req->status) }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-bold text-fixora-maroon mb-2 group-hover:text-fixora-orange transition-smooth">
                                        {{ $req->service_title }}
                                    </h3>

                                    <div class="flex flex-wrap items-center gap-3 text-sm text-fixora-slate">
                                        <span class="inline-flex items-center gap-1">
                                            {{ $req->serviceCategory->name }}
                                        </span>
                                        <span class="inline-flex items-center gap-1">
                                            📍 {{ $req->city }}
                                        </span>
                                        @if ($req->providerProfile)
                                            <span class="inline-flex items-center gap-1">
                                                👤 {{ $req->providerProfile->display_name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <div class="text-right">
                                        <p class="text-xs text-fixora-mist">{{ $req->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-fixora-mist">{{ $req->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">{{ $requests->links() }}</div>
        @endif
    </div>
</div>
@endsection
