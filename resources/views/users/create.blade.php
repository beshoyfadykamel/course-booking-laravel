@extends('layouts.master')

@section('title')
    {{ __('messages.add_user') }}
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.add_new_user') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('messages.add_new_user_desc') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('messages.name')" />
                    <x-text-input id="name" class="block mt-1 w-full @error('name') border-red-500 @enderror"
                        type="text" name="name" placeholder="{{ __('messages.enter_name') }}" :value="old('name')"
                        required autofocus />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="email" :value="__('messages.email')" />
                    <x-text-input id="email" class="block mt-1 w-full @error('email') border-red-500 @enderror"
                        type="email" name="email" placeholder="{{ __('messages.enter_email') }}" :value="old('email')"
                        required />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="role" :value="__('messages.role')" />
                    <select id="role" name="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix @error('role') border-red-500 @enderror"
                        required>
                        <option value="">{{ __('messages.choose_role') }}</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>{{ __('messages.user') }}</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>{{ __('messages.admin') }}</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="password" :value="__('messages.password')" />
                    <x-text-input id="password" class="block mt-1 w-full @error('password') border-red-500 @enderror"
                        type="password" name="password" placeholder="{{ __('messages.enter_password') }}" required />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('messages.confirm_password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" placeholder="{{ __('messages.confirm_password') }}" required />
                </div>

                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <x-primary-button type="submit" class="flex-1">
                        <i class="fas fa-save me-2"></i>{{ __('messages.submit') }}
                    </x-primary-button>
                    <x-secondary-button type="button" onclick="window.history.back()" class="flex-1">
                        <i class="fas fa-times me-2"></i>{{ __('messages.cancel') }}
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
