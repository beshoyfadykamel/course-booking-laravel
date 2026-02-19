<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">{{ __('Verify Email') }}</h2>
        <p class="text-gray-400 mt-2 text-sm">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-sm text-green-400">
            <i class="fas fa-check-circle me-2"></i>
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="py-3 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg shadow-indigo-500/25 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-950 text-sm">
                <i class="fas fa-paper-plane me-2"></i>{{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-400 hover:text-white transition">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
