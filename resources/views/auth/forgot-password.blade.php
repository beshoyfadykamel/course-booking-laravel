<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">{{ __('Forgot password?') }}</h2>
        <p class="text-gray-400 mt-2 text-sm">
            {{ __('No problem. Enter your email address and we\'ll send you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1.5">{{ __('Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <i class="fas fa-envelope text-gray-500 text-sm"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full ps-10 pe-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    placeholder="you@example.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg shadow-indigo-500/25 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-950">
            <i class="fas fa-paper-plane me-2"></i>{{ __('Email Password Reset Link') }}
        </button>
    </form>

    <!-- Back to Login -->
    <p class="mt-8 text-center text-sm text-gray-400">
        {{ __('Remember your password?') }}
        <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-medium transition">{{ __('Log in') }}</a>
    </p>
</x-guest-layout>
