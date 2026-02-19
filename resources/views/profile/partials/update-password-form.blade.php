<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-key text-gray-400 me-1"></i>{{ __('messages.current_password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-lock text-gray-400 me-1"></i>{{ __('messages.new_password') }}
            </label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                <i class="fas fa-lock text-gray-400 me-1"></i>{{ __('messages.confirm_password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                <i class="fas fa-save me-2"></i>{{ __('messages.save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 font-medium">
                    <i class="fas fa-check-circle me-1"></i>{{ __('messages.saved') }}
                </p>
            @endif
        </div>
    </form>
</section>
