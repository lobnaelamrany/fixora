@extends('layouts.fixora')

@section('title', __('app.admin.dashboard_title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.admin.dashboard_title') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.admin.dashboard_subtitle') }}</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('admin.users.index') }}" class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.admin.stats.users') }}</p>
                <p class="text-3xl font-bold text-fixora-maroon">{{ $stats['users'] }}</p>
                <p class="text-xs text-fixora-mist mt-1">{{ $stats['customers'] }} {{ __('app.admin.stats.customers') }} · {{ $stats['professionals'] }} {{ __('app.admin.stats.pros') }}</p>
            </a>
            <a href="{{ route('admin.verification.index') }}" class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.admin.stats.pending_verification') }}</p>
                <p class="text-3xl font-bold text-fixora-amber">{{ $stats['pending_verifications'] }}</p>
                <p class="text-xs text-fixora-mist mt-1">{{ $stats['verified_professionals'] }} {{ __('app.admin.stats.verified') }}</p>
            </a>
            <a href="{{ route('admin.requests.index') }}" class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.admin.stats.requests') }}</p>
                <p class="text-3xl font-bold text-fixora-orange">{{ $stats['requests'] }}</p>
                <p class="text-xs text-fixora-mist mt-1">{{ $stats['completed_requests'] }} {{ __('app.admin.stats.completed') }}</p>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50 hover:shadow-hover hover-lift transition-smooth">
                <p class="text-sm text-fixora-mist mb-1">{{ __('app.admin.stats.categories') }}</p>
                <p class="text-3xl font-bold text-fixora-pink">{{ $stats['categories'] }}</p>
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Pending Verifications --}}
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-fixora-maroon">{{ __('app.admin.pending_verifications') }}</h2>
                    <a href="{{ route('admin.verification.index') }}" class="text-sm text-fixora-orange font-semibold hover:text-fixora-maroon">{{ __('app.customer.view_all') }} →</a>
                </div>
                @if ($pendingProviders->isEmpty())
                    <p class="text-sm text-fixora-mist text-center py-6">{{ __('app.admin.no_pending') }}</p>
                @else
                    <div class="space-y-3">
                        @foreach ($pendingProviders as $pro)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-fixora-beige-light">
                                <div class="w-10 h-10 rounded-full bg-fixora-orange flex items-center justify-center text-white font-bold flex-shrink-0">
                                    {{ strtoupper(substr($pro->display_name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-fixora-maroon truncate">{{ $pro->display_name }}</p>
                                    <p class="text-xs text-fixora-mist truncate">{{ $pro->user->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent Requests --}}
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-fixora-maroon">{{ __('app.admin.recent_requests') }}</h2>
                    <a href="{{ route('admin.requests.index') }}" class="text-sm text-fixora-orange font-semibold hover:text-fixora-maroon">{{ __('app.customer.view_all') }} →</a>
                </div>
                @if ($recentRequests->isEmpty())
                    <p class="text-sm text-fixora-mist text-center py-6">{{ __('app.admin.no_requests') }}</p>
                @else
                    <div class="space-y-3">
                        @foreach ($recentRequests as $req)
                            <div class="p-3 rounded-xl bg-fixora-beige-light">
                                <p class="font-semibold text-fixora-maroon text-sm truncate">{{ $req->service_title }}</p>
                                <p class="text-xs text-fixora-mist truncate">{{ $req->customer->name }} · {{ $req->serviceCategory->name }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent Users --}}
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-fixora-maroon">{{ __('app.admin.recent_users') }}</h2>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-fixora-orange font-semibold hover:text-fixora-maroon">{{ __('app.customer.view_all') }} →</a>
                </div>
                @if ($recentUsers->isEmpty())
                    <p class="text-sm text-fixora-mist text-center py-6">{{ __('app.admin.no_users') }}</p>
                @else
                    <div class="space-y-3">
                        @foreach ($recentUsers as $user)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-fixora-beige-light">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-fixora-maroon truncate text-sm">{{ $user->name }}</p>
                                    <p class="text-xs text-fixora-mist truncate">{{ __('app.roles.' . $user->role) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
