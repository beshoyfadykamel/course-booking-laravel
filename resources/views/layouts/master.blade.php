<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('messages.dashboard'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>

<body class="font-sans antialiased bg-gray-50 h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 md:hidden"
        style="display: none;"></div>

    <!-- Sidebar - Fixed position always, shown on desktop via md:translate-x-0 -->
    <aside :class="sidebarOpen ? 'translate-x-0' : (document.documentElement.dir === 'rtl' ? 'translate-x-full' : '-translate-x-full')"
        class="fixed inset-y-0 start-0 z-30 w-64 bg-white shadow-lg transition-transform duration-300 overflow-y-auto flex flex-col md:translate-x-0">

        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 shrink-0">
            <a href="{{ route('home') }}" class="flex items-center space-x-2 rtl:space-x-reverse">
                <i class="fas fa-graduation-cap text-indigo-600 text-2xl"></i>
                <span class="text-lg font-bold text-gray-900">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="p-4 space-y-2 flex-1">

            <a href="{{ route('home') }}"
                class="flex items-center space-x-3 rtl:space-x-reverse px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('home') || request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-chart-line w-5"></i>
                <span class="font-medium">{{ __('messages.home') }}</span>
            </a>

            @can('access-admin')
                <a href="{{ route('users.index') }}"
                    class="flex items-center space-x-3 rtl:space-x-reverse px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-user-shield w-5"></i>
                    <span class="font-medium">{{ __('messages.users_management') }}</span>
                </a>
            @endcan

            <a href="{{ route('courses.index') }}"
                class="flex items-center space-x-3 rtl:space-x-reverse px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('courses.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-book w-5"></i>
                <span class="font-medium">{{ __('messages.courses_management') }}</span>
            </a>

            <a href="{{ route('students.index') }}"
                class="flex items-center space-x-3 rtl:space-x-reverse px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('students.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-users w-5"></i>
                <span class="font-medium">{{ __('messages.students_management') }}</span>
            </a>

            <a href="{{ route('bookings.index') }}"
                class="flex items-center space-x-3 rtl:space-x-reverse px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('bookings.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-calendar-check w-5"></i>
                <span class="font-medium">{{ __('messages.bookings_management') }}</span>
            </a>

        </nav>

        <!-- Language Switcher -->
        <div class="p-4 border-t border-gray-200 bg-gray-50 shrink-0">
            <form id="langForm" action="{{ route('lang.set') }}" method="POST">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.language') }}</label>
                <select name="locale"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix"
                    onchange="document.getElementById('langForm').submit()">
                    <option value="en" @selected(app()->getLocale() == 'en')>English</option>
                    <option value="ar" @selected(app()->getLocale() == 'ar')>العربية</option>
                </select>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="fixed inset-0 md:ms-64 flex flex-col overflow-hidden">

        <!-- Top Navigation Bar -->
        <nav class="bg-white border-b border-gray-200 shadow-sm z-10 flex-shrink-0">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse min-w-0 flex-1">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none shrink-0">
                            <i class="fas fa-bars text-lg"></i>
                        </button>
                        <span class="text-lg font-semibold text-gray-900 truncate">@yield('title', __('messages.dashboard'))</span>
                    </div>

                    <!-- User Menu -->
                    <div x-data="{ userOpen: false }" class="relative shrink-0">
                        <button @click="userOpen = !userOpen"
                            class="flex items-center space-x-3 rtl:space-x-reverse px-3 py-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                            <div class="text-end hidden sm:block">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                alt="Avatar" class="w-8 h-8 rounded-full">
                        </button>

                        <div x-show="userOpen" @click.outside="userOpen = false" x-transition
                            class="absolute end-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-20 border border-gray-100"
                            style="display: none;">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg">
                                <i class="fas fa-user me-2"></i>{{ __('messages.profile') }}
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit"
                                    class="w-full text-start px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-lg">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('messages.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto min-h-0">
            <div class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4 shrink-0">
            <div class="px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    @yield('scripts')
</body>

</html>