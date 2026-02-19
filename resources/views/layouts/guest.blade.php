<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Tech') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-950 text-white">
        <div class="min-h-screen flex">
            <!-- Left Panel - Branding -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500"></div>
                <div class="absolute inset-0">
                    <div class="absolute top-20 left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-20 right-20 w-96 h-96 bg-black/10 rounded-full blur-3xl"></div>
                </div>
                <div class="relative z-10 flex flex-col justify-center px-16">
                    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse mb-12">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-white">Tech</span>
                    </a>
                    <h1 class="text-4xl font-bold text-white leading-tight mb-6">
                        Manage Your Learning Platform with Ease
                    </h1>
                    <p class="text-lg text-white/70 leading-relaxed mb-10">
                        Courses, students, and bookings — all in one powerful dashboard designed for modern educators.
                    </p>
                    <div class="flex items-center space-x-6 rtl:space-x-reverse">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse text-white/80">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm">Course Management</span>
                        </div>
                        <div class="flex items-center space-x-2 rtl:space-x-reverse text-white/80">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm">Student Tracking</span>
                        </div>
                        <div class="flex items-center space-x-2 rtl:space-x-reverse text-white/80">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm">Booking System</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 sm:px-12 py-12 bg-gray-950">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8">
                    <a href="/" class="flex items-center space-x-2 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">Tech</span>
                    </a>
                </div>

                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>

                <p class="mt-10 text-center text-xs text-gray-600">&copy; {{ date('Y') }} Tech. {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </div>
    </body>
</html>
