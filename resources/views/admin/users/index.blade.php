@extends('layouts.fixora')

@section('title', __('app.admin.users_title') . ' — Admin')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-fixora-slate hover:text-fixora-orange font-medium mb-2 inline-block">← {{ __('app.nav.admin') }}</a>
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.admin.users_title') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.admin.users_subtitle') }}</p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach (['all' => __('app.customer.filters.all'), 'customer' => __('app.roles.customer'), 'professional' => __('app.roles.professional'), 'admin' => __('app.roles.admin')] as $key => $label)
                <a href="{{ route('admin.users.index', ['role' => $key]) }}"
                   class="px-4 py-2 rounded-xl font-semibold text-sm transition-smooth
                          {{ $role === $key ? 'bg-fixora-maroon text-white shadow-card' : 'bg-white text-fixora-slate hover:bg-fixora-beige border border-fixora-beige-dark/50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Search --}}
        <form method="GET" class="mb-6">
            <input type="text" name="q" value="{{ $search }}" placeholder="{{ __('app.admin.search_placeholder') }}"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
        </form>

        {{-- Users Table --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 overflow-hidden">
            <table class="w-full">
                <thead class="bg-fixora-beige-light border-b border-fixora-beige-dark">
                    <tr>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-fixora-maroon">{{ __('app.admin.table.name') }}</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-fixora-maroon">{{ __('app.admin.table.email') }}</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-fixora-maroon">{{ __('app.admin.table.role') }}</th>
                        <th class="text-left px-6 py-4 text-sm font-semibold text-fixora-maroon">{{ __('app.admin.table.status') }}</th>
                        <th class="text-right px-6 py-4 text-sm font-semibold text-fixora-maroon">{{ __('app.admin.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-fixora-beige-dark/50 last:border-0 hover:bg-fixora-beige-light/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-fixora-maroon">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-fixora-slate">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                    @if ($user->role === 'admin') bg-red-100 text-red-700
                                    @elseif ($user->role === 'professional') bg-fixora-olive/10 text-fixora-olive
                                    @else bg-fixora-orange/10 text-fixora-orange @endif">
                                    {{ __('app.roles.' . $user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                    {{ $user->account_status === 'active' ? 'bg-fixora-olive/10 text-fixora-olive' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($user->account_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-sm text-fixora-orange hover:text-fixora-maroon font-semibold">{{ __('app.buttons.view') }}</a>
                                    @if ($user->account_status === 'active' && !$user->isAdmin())
                                        <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold">{{ __('app.admin.suspend') }}</button>
                                        </form>
                                    @elseif ($user->account_status === 'suspended')
                                        <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-sm text-fixora-olive hover:text-green-800 font-semibold">{{ __('app.admin.activate') }}</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $users->links() }}</div>

    </div>
</div>
@endsection
