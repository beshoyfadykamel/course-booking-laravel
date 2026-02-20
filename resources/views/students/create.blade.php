@extends('layouts.master')

@section('title')
    {{ __('messages.add_student') }}
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.add_new_student') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('messages.add_new_student') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <!-- Success Message -->
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ roleRoute('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Name Field -->
                <div>
                    <x-input-label for="name" :value="__('messages.student_name')" />
                    <x-text-input 
                        id="name" 
                        class="block mt-1 w-full @error('name') border-red-500 @enderror" 
                        type="text" 
                        name="name"
                        placeholder="{{ __('messages.enter_student_name') }}"
                        :value="old('name')" 
                        required 
                        autofocus />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <x-input-label for="email" :value="__('messages.student_email')" />
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full @error('email') border-red-500 @enderror" 
                        type="email" 
                        name="email"
                        placeholder="{{ __('messages.enter_student_email') }}"
                        :value="old('email')"
                        required />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country Field -->
                <div>
                    <x-input-label for="country_id" :value="__('messages.student_country')" />
                    <select 
                        id="country_id" 
                        name="country_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix @error('country_id') border-red-500 @enderror">
                        <option value="">{{ __('messages.select_country') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Field -->
                <div>
                    <x-input-label for="status" :value="__('messages.status')" />
                    <select 
                        id="status" 
                        name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix @error('status') border-red-500 @enderror"
                        required>
                        <option value="">{{ __('messages.choose_status') }}</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                            {{ __('messages.active') }}
                        </option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                            {{ __('messages.inactive') }}
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Field -->
                <div>
                    <x-input-label for="image" :value="__('messages.image_optional')" />
                    <input 
                        type="file" 
                        id="image" 
                        name="image"
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('image') border-red-500 @enderror" />
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
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