@extends('layouts.master')

@section('title')
    {{ __('messages.profile') }}
@endsection

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.profile') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ __('messages.profile_subtitle') }}</p>
            </div>
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=64&background=6366f1&color=fff"
                    alt="Avatar" class="w-16 h-16 rounded-full ring-4 ring-indigo-100">
            </div>
        </div>

        <!-- Profile Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-indigo-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('messages.profile_information') }}</h2>
                        <p class="text-sm text-gray-500">{{ __('messages.profile_information_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-gray-200">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lock text-amber-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('messages.update_password') }}</h2>
                        <p class="text-sm text-gray-500">{{ __('messages.update_password_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-red-200">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-red-900">{{ __('messages.delete_account') }}</h2>
                        <p class="text-sm text-red-500">{{ __('messages.delete_account_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
