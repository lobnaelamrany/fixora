@extends('layouts.fixora')

@section('title', __('app.admin.requests_admin_title') . ' — Admin')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-fixora-slate hover:text-fixora-orange font-medium mb-2 inline-block">← {{ __('app.nav.admin') }}</a>
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.admin.requests_admin_title') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.admin.requests_admin_subtitle') }}</p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach (['all', 'pending', 'accepted', 'in_progress', 'completed', 'cancelled'] as $key)
                <a href="{{ route('admin.requests.index', ['status' => $key]) }}"
                   class="px-4 py-2 rounded-xl font-semibold text-sm transition-smooth
                          {{ $status === $key ? 'bg-fixora-maroon text-white shadow-card' : 'bg-white text-fixora-slate hover:bg-fixora-beige border border-fixora-beige-dark/50' }}">
                    {{ __('app.customer.filters.' . $key) }}
                </a>
            @endforeach
        </div>

        {{-- Search --}}
        <form method="GET" class="mb-6">
            <input type="text" name="q" value="{{ $search }}" placeholder="{{ __('app.admin.search_placeholder') }}"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
        </form>

        @if ($requests->isEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-12 text-center">
                <p class="text-fixora-slate">{{ __('app.admin.no_requests') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($requests as $req)
                    <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-5">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <span class="font-mono text-xs text-fixora-mist">{{ $req->reference_number }}</span>
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                        @if ($req->status === 'completed') bg-fixora-olive/10 text-fixora-olive
                                        @elseif ($req->status === 'pending') bg-fixora-amber/10 text-fixora-amber
                                        @elseif ($req->status === 'cancelled') bg-gray-100 text-gray-600
                                        @elseif ($req->status === 'declined') bg-red-100 text-red-700
                                        @else bg-fixora-orange/10 text-fixora-orange @endif">
                                        {{ __('app.status.' . $req->status) }}
                                    </span>
                                    @if ($req->urgency_level === 'urgent')
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-red-100 text-red-700">{{ __('app.customer.urgency_urgent') }}</span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-fixora-maroon">{{ $req->service_title }}</h3>
                                <p class="text-sm text-fixora-slate">
                                    {{ $req->customer->name }} · {{ $req->city }} · {{ $req->serviceCategory->name }}
                                    @if ($req->providerProfile)
                                        · {{ $req->providerProfile->display_name }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-xs text-fixora-mist text-right flex-shrink-0">
                                <p>{{ $req->created_at->format('M d, Y') }}</p>
                                <p>{{ $req->created_at->diffForHumans() }}</p>
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
