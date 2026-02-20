@extends('layouts.master')

@section('title')
    {{ __('messages.view_user') }} | {{ __('messages.users_management') }}
@endsection

@section('content')
    @if (isset($user))
        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- User Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('messages.user_details') }}</h2>
                <div class="flex gap-2 mt-2 sm:mt-0">
                    @if ($user->trashed())
                        <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                <i class="fas fa-undo me-1"></i> {{ __('messages.restore') }}
                            </button>
                        </form>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.delete-permanently', $user->id) }}" method="POST"
                                class="inline-flex" onsubmit="return confirm('{{ __('messages.confirm_permanent_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-700 text-white rounded-lg hover:bg-red-800 transition text-sm font-medium">
                                    <i class="fas fa-trash me-1"></i> {{ __('messages.permanent_deletion') }}
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                            class="inline-flex items-center px-3 py-1.5 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm font-medium">
                            <i class="fas fa-pencil-alt me-1"></i> {{ __('messages.edit') }}
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-flex"
                                onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                    <i class="fas fa-trash me-1"></i> {{ __('messages.delete') }}
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- User Avatar -->
                    <div class="shrink-0 text-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=112"
                            alt="{{ $user->name }}" class="w-28 h-28 rounded-full border-2 border-gray-200">
                    </div>
                    <!-- User Info -->
                    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 flex-1">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.id') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.name') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.email') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.role') }}</dt>
                            <dd class="mt-1">
                                @if($user->role === 'admin')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">{{ __('messages.admin') }}</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ __('messages.user') }}</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.email_verified') }}</dt>
                            <dd class="mt-1">
                                @if($user->email_verified_at)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">{{ __('messages.verified') }}</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">{{ __('messages.unverified') }}</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.created_at') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.updated_at') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- User Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('messages.total_students') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $studentsCount }}</h3>
                    </div>
                    <i class="fas fa-users text-green-400 text-3xl"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('messages.total_courses') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $coursesCount }}</h3>
                    </div>
                    <i class="fas fa-book text-blue-400 text-3xl"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ __('messages.total_bookings') }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $bookingsCount }}</h3>
                    </div>
                    <i class="fas fa-calendar-check text-amber-400 text-3xl"></i>
                </div>
            </div>
        </div>
    @else
        <div class="p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ __('messages.user_not_found') }}
        </div>
    @endif
@endsection
