@extends('layouts.master')
@section('title')
    {{ __('messages.home') }}
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Courses Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 px-6 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">{{ __('messages.total_courses') }}</p>
                        <h3 class="text-4xl font-bold text-white mt-2">{{ $coursesCount }}</h3>
                    </div>
                    <i class="fas fa-book text-blue-200 text-5xl opacity-30"></i>
                </div>
            </div>
            <div class="px-6 py-4">
                <a href="{{ roleRoute('courses.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                    {{ __('messages.more_info') }}
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Students Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-br from-green-500 to-green-600 px-6 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">{{ __('messages.total_students') }}</p>
                        <h3 class="text-4xl font-bold text-white mt-2">{{ $studentsCount }}</h3>
                    </div>
                    <i class="fas fa-users text-green-200 text-5xl opacity-30"></i>
                </div>
            </div>
            <div class="px-6 py-4">
                <a href="{{ roleRoute('students.index') }}" class="inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm">
                    {{ __('messages.more_info') }}
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 px-6 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">{{ __('messages.total_bookings') }}</p>
                        <h3 class="text-4xl font-bold text-white mt-2">{{ $bookingsCount }}</h3>
                    </div>
                    <i class="fas fa-calendar-check text-amber-200 text-5xl opacity-30"></i>
                </div>
            </div>
            <div class="px-6 py-4">
                <a href="{{ roleRoute('bookings.index') }}" class="inline-flex items-center text-amber-600 hover:text-amber-700 font-medium text-sm">
                    {{ __('messages.more_info') }}
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.quick_actions') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ roleRoute('courses.create') }}" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-plus-circle text-indigo-600 text-xl"></i>
                <span class="text-sm font-medium text-gray-700">{{ __('messages.add_course') }}</span>
            </a>
            <a href="{{ roleRoute('students.create') }}" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-plus-circle text-green-600 text-xl"></i>
                <span class="text-sm font-medium text-gray-700">{{ __('messages.add_student') }}</span>
            </a>
            <a href="{{ roleRoute('bookings.create') }}" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-plus-circle text-amber-600 text-xl"></i>
                <span class="text-sm font-medium text-gray-700">{{ __('messages.add_booking') }}</span>
            </a>
            <a href="{{ roleRoute('students.index') }}" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                <span class="text-sm font-medium text-gray-700">{{ __('messages.view_reports') }}</span>
            </a>
        </div>
    </div>
@endsection