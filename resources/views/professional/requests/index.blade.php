@extends('layouts.fixora')

@section('title', __('app.professional.requests_title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.nav.dashboard') }}
            </a>
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.professional.requests_title') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.professional.requests_subtitle') }}</p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach (['all', 'pending', 'accepted', 'in_progress', 'completed', 'declined'] as $key)
                <a href="{{ route('pro.requests.index', ['status' => $key]) }}"
                   class="px-4 py-2 rounded-xl font-semibold text-sm transition-smooth
                          {{ $status === $key ? 'bg-fixora-maroon text-white shadow-card' : 'bg-white text-fixora-slate hover:bg-fixora-beige border border-fixora-beige-dark/50' }}">
                    {{ __('app.professional.filters.' . $key) }}
                </a>
            @endforeach
        </div>

        @if ($requests->isEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-12 text-center">
                <p class="text-fixora-slate">{{ __('app.professional.no_requests') }}</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($requests as $req)
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
                    <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2 flex-wrap">
                                    <span class="font-mono text-sm text-fixora-mist">{{ $req->reference_number }}</span>
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColors[$req->status] ?? '' }}">
                                        {{ __('app.status.' . $req->status) }}
                                    </span>
                                    @if ($req->urgency_level === 'urgent')
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-700">
                                            {{ __('app.customer.urgency_urgent') }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold text-fixora-maroon mb-1">{{ $req->service_title }}</h3>
                                <p class="text-sm text-fixora-slate mb-3 line-clamp-2">{{ $req->description }}</p>
                                <div class="flex flex-wrap gap-3 text-sm text-fixora-slate">
                                    <span>👤 {{ $req->customer->name }}</span>
                                    <span>📍 {{ $req->city }}</span>
                                    <span>🔧 {{ $req->serviceCategory->name }}</span>
                                    <span>📅 {{ $req->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('pro.requests.show', $req) }}"
                                   class="bg-fixora-beige text-fixora-maroon px-4 py-2 rounded-xl font-semibold text-sm hover:bg-fixora-beige-dark transition-smooth">
                                    {{ __('app.professional.view') }}
                                </a>
                                @if ($req->status === 'pending')
                                    <form method="POST" action="{{ route('pro.requests.accept', $req) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="bg-fixora-olive text-white px-4 py-2 rounded-xl font-semibold text-sm hover:bg-fixora-olive/80 transition-smooth">
                                            {{ __('app.professional.accept') }}
                                        </button>
                                    </form>
                                @elseif ($req->status === 'accepted')
                                    <form method="POST" action="{{ route('pro.requests.start', $req) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="bg-fixora-pink text-white px-4 py-2 rounded-xl font-semibold text-sm hover:bg-fixora-pink/80 transition-smooth">
                                            {{ __('app.professional.start') }}
                                        </button>
                                    </form>
                                @elseif ($req->status === 'in_progress')
                                    <form method="POST" action="{{ route('pro.requests.complete', $req) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="bg-fixora-maroon text-white px-4 py-2 rounded-xl font-semibold text-sm hover:bg-fixora-orange transition-smooth">
                                            {{ __('app.professional.complete') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $requests->links() }}</div>
        @endif

    </div>
</div>
@endsection
