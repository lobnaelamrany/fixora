<x-guest-layout>
    <div class="mb-8">
        <div class="w-16 h-16 bg-fixora-orange/10 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight mb-2">{{ __('app.auth.verify_email_title') }}</h1>
        <p class="text-fixora-slate">{{ __('app.auth.verify_email_subtitle') }}</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 bg-fixora-olive/10 border border-fixora-olive text-fixora-olive px-4 py-3 rounded-xl">
            ✓ {{ __('app.auth.verification_sent') }}
        </div>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-fixora-maroon text-white py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
                {{ __('app.auth.resend_verification') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-white border-2 border-fixora-beige-dark text-fixora-maroon py-3.5 rounded-xl font-semibold hover:border-fixora-orange hover:text-fixora-orange transition-smooth">
                {{ __('app.auth.logout') }}
            </button>
        </form>
    </div>
</x-guest-layout>
