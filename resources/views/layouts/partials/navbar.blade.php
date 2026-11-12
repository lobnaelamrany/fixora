<nav class="bg-fixora-beige-light/95 backdrop-blur-md border-b border-fixora-beige-dark sticky top-0 z-50 shadow-soft" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group flex-shrink-0">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white font-bold text-lg transition-smooth group-hover:scale-105 shadow-card">
                    F
                </div>
                <span class="text-xl font-bold text-fixora-maroon tracking-tight">FIXORA</span>
            </a>

            {{-- Desktop Links --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('categories.index') }}"
                   class="text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige {{ request()->routeIs('categories.*') ? 'text-fixora-orange bg-fixora-beige' : '' }}">
                    {{ __('app.nav.services') }}
                </a>
                <a href="{{ route('professionals.index') }}"
                   class="text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige {{ request()->routeIs('professionals.*') ? 'text-fixora-orange bg-fixora-beige' : '' }}">
                    {{ __('app.nav.professionals') }}
                </a>
                <a href="{{ route('about') }}"
                   class="text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige {{ request()->routeIs('about') ? 'text-fixora-orange bg-fixora-beige' : '' }}">
                    {{ __('app.nav.about') }}
                </a>
                <a href="{{ route('contact') }}"
                   class="text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige {{ request()->routeIs('contact') ? 'text-fixora-orange bg-fixora-beige' : '' }}">
                    {{ __('app.nav.contact') }}
                </a>
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-2">

                {{-- Language Switcher --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-1 text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige text-sm">
                        {{ strtoupper(app()->getLocale()) }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-hover border border-fixora-beige-dark/50 py-1 z-50">
                        @foreach (['fr' => 'Français', 'en' => 'English', 'de' => 'Deutsch'] as $code => $name)
                            <a href="{{ route('lang.switch', $code) }}"
                               class="block px-4 py-2 text-sm hover:bg-fixora-beige transition-smooth {{ app()->getLocale() === $code ? 'text-fixora-orange font-semibold' : 'text-fixora-slate' }}">
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @auth
                    {{-- Messages — غير للـ Customer و Professional (ماشي Admin) --}}
                    @unless (auth()->user()->isAdmin())
                        <a href="{{ route('conversations.index') }}"
                           class="hidden md:inline-flex items-center gap-1.5 text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige {{ request()->routeIs('conversations.*') ? 'text-fixora-orange bg-fixora-beige' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            {{ __('app.nav.messages') }}
                        </a>
                    @endunless

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}"
                       class="hidden md:inline-block text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige {{ request()->routeIs('dashboard') ? 'text-fixora-orange bg-fixora-beige' : '' }}">
                        {{ __('app.nav.dashboard') }}
                    </a>

                    {{-- Admin link --}}
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="hidden md:inline-flex items-center gap-1.5 text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2 rounded-lg hover:bg-fixora-beige {{ request()->routeIs('admin.*') ? 'text-fixora-orange bg-fixora-beige' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            {{ __('app.nav.admin') }}
                        </a>
                    @endif

                    {{-- Role CTA --}}
                    @if (auth()->user()->isCustomer())
                        <a href="{{ route('customer.requests.create') }}"
                           class="hidden sm:inline-block bg-fixora-orange text-white px-4 py-2 rounded-xl font-semibold hover:bg-fixora-maroon transition-smooth shadow-card text-sm">
                            + {{ __('app.nav.new_request') }}
                        </a>
                    @endif

                    {{-- Profile Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 p-1 rounded-xl hover:bg-fixora-beige transition-smooth">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white font-bold text-sm shadow-card">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-fixora-slate hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-transition x-cloak
                             class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-hover border border-fixora-beige-dark/50 py-2 z-50">

                            {{-- User info --}}
                            <div class="px-4 py-3 border-b border-fixora-beige-dark/50">
                                <p class="text-sm font-semibold text-fixora-maroon truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-fixora-mist truncate">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-2 text-xs font-semibold px-2 py-0.5 rounded-full bg-fixora-orange/10 text-fixora-orange">
                                    {{ __('app.roles.' . auth()->user()->role) }}
                                </span>
                            </div>

                            {{-- Links --}}
                            @if (auth()->user()->isCustomer())
                                <a href="{{ route('customer.requests.index') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">
                                    {{ __('app.nav.my_requests') }}
                                </a>
                            @endif

                            @if (auth()->user()->isProfessional())
                                <a href="{{ route('pro.requests.index') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">
                                    {{ __('app.nav.my_requests') }}
                                </a>
                                <a href="{{ route('pro.profile.edit') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">
                                    {{ __('app.nav.edit_profile') }}
                                </a>
                            @endif

                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">
                                {{ __('app.nav.dashboard') }}
                            </a>

                            @unless (auth()->user()->isAdmin())
                                <a href="{{ route('conversations.index') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">
                                    {{ __('app.nav.messages') }}
                                </a>
                            @endunless

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">
                                {{ __('app.nav.account_settings') }}
                            </a>

                            {{-- Admin links --}}
                            @if (auth()->user()->isAdmin())
                                <div class="border-t border-fixora-beige-dark/50 mt-1 pt-1">
                                    <p class="px-4 py-2 text-xs font-semibold text-fixora-mist uppercase tracking-wider">Admin Panel</p>
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">Dashboard</a>
                                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">Users</a>
                                    <a href="{{ route('admin.verification.index') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">Verifications</a>
                                    <a href="{{ route('admin.requests.index') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">Requests</a>
                                    <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 text-sm text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth">Categories</a>
                                </div>
                            @endif

                            {{-- Logout --}}
                            <div class="border-t border-fixora-beige-dark/50 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-smooth">
                                        {{ __('app.nav.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="text-fixora-slate hover:text-fixora-orange font-medium transition-smooth px-3 py-2">
                        {{ __('app.nav.login') }}
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-fixora-maroon text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
                        {{ __('app.nav.register') }}
                    </a>
                @endauth

                {{-- Mobile menu button --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-lg hover:bg-fixora-beige transition-smooth">
                    <svg x-show="!mobileOpen" class="w-6 h-6 text-fixora-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6 text-fixora-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen" x-transition x-cloak class="md:hidden border-t border-fixora-beige-dark py-4">
            <div class="space-y-1">
                <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                    {{ __('app.nav.services') }}
                </a>
                <a href="{{ route('professionals.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                    {{ __('app.nav.professionals') }}
                </a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                    {{ __('app.nav.about') }}
                </a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                    {{ __('app.nav.contact') }}
                </a>

                @auth
                    <div class="border-t border-fixora-beige-dark pt-2 mt-2 space-y-1">
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                            {{ __('app.nav.dashboard') }}
                        </a>

                        @unless (auth()->user()->isAdmin())
                            <a href="{{ route('conversations.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                                {{ __('app.nav.messages') }}
                            </a>
                        @endunless

                        @if (auth()->user()->isCustomer())
                            <a href="{{ route('customer.requests.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                                {{ __('app.nav.my_requests') }}
                            </a>
                        @endif

                        @if (auth()->user()->isProfessional())
                            <a href="{{ route('pro.requests.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                                {{ __('app.nav.my_requests') }}
                            </a>
                            <a href="{{ route('pro.profile.edit') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">
                                {{ __('app.nav.edit_profile') }}
                            </a>
                        @endif

                        @if (auth()->user()->isAdmin())
                            <div class="border-t border-fixora-beige-dark pt-2 mt-2 space-y-1">
                                <p class="px-3 py-2 text-xs font-semibold text-fixora-mist uppercase">Admin Panel</p>
                                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">Admin Dashboard</a>
                                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">Users</a>
                                <a href="{{ route('admin.verification.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">Verifications</a>
                                <a href="{{ route('admin.requests.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">Requests</a>
                                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded-lg text-fixora-slate hover:bg-fixora-beige hover:text-fixora-orange transition-smooth font-medium">Categories</a>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 transition-smooth font-medium">
                                {{ __('app.nav.logout') }}
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-fixora-beige-dark pt-2 mt-2 flex gap-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center px-3 py-2 rounded-lg text-fixora-maroon border-2 border-fixora-beige-dark font-semibold">
                            {{ __('app.nav.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="flex-1 text-center px-3 py-2 rounded-lg bg-fixora-maroon text-white font-semibold">
                            {{ __('app.nav.register') }}
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
