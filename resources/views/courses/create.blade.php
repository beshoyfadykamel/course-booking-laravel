@extends('layouts.master')

@section('title')
    {{ __('messages.add_course') }}
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.add_new_course') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('messages.add_new_course') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <!-- Success Message -->
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title Field -->
                <div>
                    <x-input-label for="title" :value="__('messages.course_title')" />
                    <x-text-input 
                        id="title" 
                        class="block mt-1 w-full @error('title') border-red-500 @enderror" 
                        type="text" 
                        name="title"
                        placeholder="{{ __('messages.enter_course_title') }}"
                        :value="old('title')" 
                        required 
                        autofocus />
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div>
                    <x-input-label for="description" :value="__('messages.description')" />
                    <textarea 
                        id="description" 
                        name="description"
                        rows="4"
                        placeholder="{{ __('messages.enter_description') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
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