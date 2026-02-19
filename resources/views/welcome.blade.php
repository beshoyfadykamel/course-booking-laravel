<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech - Learning Management Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-950 text-white">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-gray-950/80 backdrop-blur-xl border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2 rtl:space-x-reverse">
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">Tech</span>
            </a>
            <div class="flex items-center space-x-3 rtl:space-x-reverse">
                @auth
                    <a href="{{ route('home') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                        {{ __('messages.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-medium text-gray-300 hover:text-white transition">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                        {{ __('Register') }}
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <!-- Background Glow -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
            <div class="inline-flex items-center px-4 py-2 bg-indigo-500/10 border border-indigo-500/20 rounded-full text-indigo-400 text-sm font-medium mb-8">
                <i class="fas fa-rocket me-2"></i> {{ __('messages.welcome') }} — Learning Management Platform
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-tight mb-6">
                Manage Your
                <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Learning</span>
                Platform
            </h1>

            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                A powerful system to manage courses, students, and bookings with ease. Built for educators and administrators who demand efficiency.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg shadow-indigo-500/25">
                        <i class="fas fa-chart-line me-2"></i> {{ __('messages.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition shadow-lg shadow-indigo-500/25">
                        <i class="fas fa-user-plus me-2"></i> {{ __('Register') }}
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-white/5 hover:bg-white/10 border border-gray-700 text-white font-semibold rounded-xl transition">
                        <i class="fas fa-sign-in-alt me-2"></i> {{ __('Log in') }}
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="relative py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold mb-4">Everything You Need</h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">Comprehensive tools to streamline your learning management workflow.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Courses -->
                <div class="group p-8 bg-gray-900/50 border border-gray-800 rounded-2xl hover:border-indigo-500/50 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ __('messages.courses_management') }}</h3>
                    <p class="text-gray-400 leading-relaxed">Create, organize, and manage your courses with an intuitive interface. Track course status and enrollment.</p>
                </div>

                <!-- Students -->
                <div class="group p-8 bg-gray-900/50 border border-gray-800 rounded-2xl hover:border-purple-500/50 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ __('messages.students_management') }}</h3>
                    <p class="text-gray-400 leading-relaxed">Manage student profiles, track enrollments, and monitor progress across all courses.</p>
                </div>

                <!-- Bookings -->
                <div class="group p-8 bg-gray-900/50 border border-gray-800 rounded-2xl hover:border-pink-500/50 transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">{{ __('messages.bookings_management') }}</h3>
                    <p class="text-gray-400 leading-relaxed">Handle bookings efficiently with status tracking, search, and a built-in recycle bin.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-800 py-8 px-6">
        <div class="max-w-7xl mx-auto text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Tech. {{ __('messages.all_rights_reserved') }}</p>
        </div>
    </footer>

</body>
</html>