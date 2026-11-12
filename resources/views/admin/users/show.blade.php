@extends('layouts.fixora')

@section('title', $user->name . ' — Admin')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.admin.users_title') }}
            </a>
        </div>

        {{-- User Card --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-start gap-6">
                <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white text-4xl font-bold shadow-card flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-fixora-maroon mb-1">{{ $user->name }}</h1>
                    <p class="text-fixora-slate">{{ $user->email }}</p>

                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            @if ($user->role === 'admin') bg-red-100 text-red-700
                            @elseif ($user->role === 'professional') bg-fixora-olive/10 text-fixora-olive
                            @else bg-fixora-orange/10 text-fixora-orange @endif">
                            {{ __('app.roles.' . $user->role) }}
                        </span>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            {{ $user->account_status === 'active' ? 'bg-fixora-olive/10 text-fixora-olive' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($user->account_status) }}
                        </span>
                        @if ($user->customer_type)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-fixora-beige text-fixora-slate">
                                {{ ucfirst($user->customer_type) }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-4 text-sm text-fixora-mist">
                        <p>{{ __('app.admin.joined') }}: {{ $user->created_at->format('M d, Y') }}</p>
                        <p>{{ __('app.admin.email_verified') }}: {{ $user->email_verified_at?->format('M d, Y') ?? __('app.admin.no') }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    @if ($user->account_status === 'active' && !$user->isAdmin())
                        <form method="POST" action="{{ route('admin.users.suspend', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="w-full bg-red-50 text-red-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-red-100 transition-smooth text-sm">
                                {{ __('app.admin.suspend_user') }}
                            </button>
                        </form>
                    @elseif ($user->account_status === 'suspended')
                        <form method="POST" action="{{ route('admin.users.activate', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="w-full bg-fixora-olive text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-olive/80 transition-smooth text-sm">
                                {{ __('app.admin.activate_user') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Professional Profile --}}
        @if ($user->isProfessional() && $user->providerProfile)
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 mb-6">
                <h2 class="text-xl font-bold text-fixora-maroon mb-4">{{ __('app.admin.professional_profile') }}</h2>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.admin.business_name') }}</p>
                        <p class="font-medium text-fixora-maroon">{{ $user->providerProfile->business_name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.admin.verification_status') }}</p>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            @if ($user->providerProfile->verification_status === 'verified') bg-fixora-olive/10 text-fixora-olive
                            @elseif ($user->providerProfile->verification_status === 'pending') bg-fixora-amber/10 text-fixora-amber
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($user->providerProfile->verification_status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.admin.experience') }}</p>
                        <p class="font-medium text-fixora-maroon">{{ $user->providerProfile->experience_years }} {{ __('app.professionals.years_exp') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.admin.rating') }}</p>
                        <p class="font-medium text-fixora-maroon">★ {{ number_format($user->providerProfile->average_rating, 1) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.admin.completed_services') }}</p>
                        <p class="font-medium text-fixora-maroon">{{ $user->providerProfile->completed_services_count }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.admin.phone') }}</p>
                        <p class="font-medium text-fixora-maroon">{{ $user->providerProfile->phone ?? '—' }}</p>
                    </div>
                </div>

                @if ($user->providerProfile->services->count() > 0)
                    <div class="mb-4">
                        <p class="text-sm text-fixora-mist mb-2">{{ __('app.admin.services') }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($user->providerProfile->services as $service)
                                <span class="text-xs bg-fixora-orange/10 text-fixora-orange px-3 py-1 rounded-full font-medium">
                                    {{ $service->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($user->providerProfile->areas->count() > 0)
                    <div>
                        <p class="text-sm text-fixora-mist mb-2">{{ __('app.admin.areas') }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($user->providerProfile->areas as $area)
                                <span class="text-xs bg-fixora-beige text-fixora-slate px-3 py-1 rounded-full font-medium">
                                    📍 {{ $area->city }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Recent Requests --}}
        @if ($user->serviceRequests->count() > 0)
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                <h2 class="text-xl font-bold text-fixora-maroon mb-4">{{ __('app.admin.recent_requests') }} ({{ $user->serviceRequests->count() }})</h2>
                <div class="space-y-3">
                    @foreach ($user->serviceRequests->take(5) as $req)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-fixora-beige-light">
                            <div>
                                <p class="font-semibold text-fixora-maroon text-sm">{{ $req->service_title }}</p>
                                <p class="text-xs text-fixora-mist">{{ $req->reference_number }} · {{ $req->city }}</p>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                @if ($req->status === 'completed') bg-fixora-olive/10 text-fixora-olive
                                @elseif ($req->status === 'pending') bg-fixora-amber/10 text-fixora-amber
                                @elseif ($req->status === 'cancelled') bg-gray-100 text-gray-600
                                @else bg-fixora-orange/10 text-fixora-orange @endif">
                                {{ __('app.status.' . $req->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
