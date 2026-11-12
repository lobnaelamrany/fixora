@extends('layouts.fixora')

@section('title', __('app.admin.verification_title') . ' — Admin')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-fixora-slate hover:text-fixora-orange font-medium mb-2 inline-block">← {{ __('app.nav.admin') }}</a>
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.admin.verification_title') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.admin.verification_subtitle') }}</p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach (['pending' => __('app.status.pending'), 'verified' => __('app.professionals.verified'), 'rejected' => __('app.status.declined')] as $key => $label)
                <a href="{{ route('admin.verification.index', ['status' => $key]) }}"
                   class="px-4 py-2 rounded-xl font-semibold text-sm transition-smooth
                          {{ $status === $key ? 'bg-fixora-maroon text-white shadow-card' : 'bg-white text-fixora-slate hover:bg-fixora-beige border border-fixora-beige-dark/50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($providers->isEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-12 text-center">
                <div class="w-20 h-20 bg-fixora-beige rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-fixora-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.professionals.no_results') }}</h3>
                <p class="text-fixora-slate">{{ __('app.professionals.try_adjust') }}</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($providers as $provider)
                    <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                        <div class="flex flex-col md:flex-row md:items-start gap-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white text-2xl font-bold shadow-card flex-shrink-0 overflow-hidden">
                                @if ($provider->profile_photo_url)
                                    <img src="{{ $provider->profile_photo_url }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($provider->display_name, 0, 1)) }}
                                @endif
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-lg font-bold text-fixora-maroon">{{ $provider->display_name }}</h3>
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                        @if ($provider->verification_status === 'verified') bg-fixora-olive/10 text-fixora-olive
                                        @elseif ($provider->verification_status === 'pending') bg-fixora-amber/10 text-fixora-amber
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ $provider->verification_status === 'verified' ? __('app.professionals.verified') : ucfirst($provider->verification_status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-fixora-slate mb-2">{{ $provider->user->email }}</p>
                                <p class="text-sm text-fixora-slate mb-3 line-clamp-2">{{ $provider->description }}</p>

                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach ($provider->services as $service)
                                        <span class="text-xs bg-fixora-orange/10 text-fixora-orange px-2 py-1 rounded-full font-medium">
                                            {{ $service->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    @foreach ($provider->areas as $area)
                                        <span class="text-xs bg-fixora-beige text-fixora-slate px-2 py-1 rounded-full font-medium">
                                            📍 {{ $area->city }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                @if ($provider->verification_status === 'pending')
                                    <form method="POST" action="{{ route('admin.verification.verify', $provider) }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-fixora-olive text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-olive/80 transition-smooth text-sm">
                                            ✓ {{ __('app.admin.verify') }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.verification.reject', $provider) }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-red-50 text-red-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-red-100 transition-smooth text-sm">
                                            ✗ {{ __('app.admin.reject') }}
                                        </button>
                                    </form>
                                @elseif ($provider->verification_status === 'verified')
                                    <form method="POST" action="{{ route('admin.verification.reject', $provider) }}">
                                        @csrf
                                        <button type="submit"
                                                class="bg-red-50 text-red-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-red-100 transition-smooth text-sm">
                                            {{ __('app.admin.revoke') }}
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.verification.verify', $provider) }}">
                                        @csrf
                                        <button type="submit"
                                                class="bg-fixora-olive text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-olive/80 transition-smooth text-sm">
                                            {{ __('app.admin.verify') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $providers->links() }}</div>
        @endif

    </div>
</div>
@endsection
