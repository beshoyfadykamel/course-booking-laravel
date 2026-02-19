<section class="space-y-5">
    <p class="text-sm text-gray-600 leading-relaxed">
        <i class="fas fa-info-circle text-red-400 me-1"></i>
        {{ __('messages.delete_account_warning') }}
    </p>

    <button type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
        <i class="fas fa-trash-alt me-2"></i>{{ __('messages.delete_account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center space-x-3 rtl:space-x-reverse mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('messages.confirm_delete_account') }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ __('messages.confirm_delete_account_desc') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                    <i class="fas fa-lock text-gray-400 me-1"></i>{{ __('messages.password') }}
                </label>
                <input id="password" name="password" type="password"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    placeholder="{{ __('messages.enter_password_to_confirm') }}">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 transition">
                    {{ __('messages.cancel') }}
                </button>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium text-sm rounded-lg transition">
                    <i class="fas fa-trash-alt me-2"></i>{{ __('messages.delete_account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
