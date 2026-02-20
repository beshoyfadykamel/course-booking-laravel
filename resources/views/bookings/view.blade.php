@extends('layouts.master')
@section('title')
    {{ __('messages.view_booking') }} | {{ __('messages.bookings_management') }}
@endsection

@section('content')
    @if (isset($booking))
        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Booking Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('messages.booking_details') }}</h2>
                <div class="flex gap-2 mt-2 sm:mt-0">
                    @if ($booking->trashed())
                        <form action="{{ roleRoute('bookings.restore', $booking->id) }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                                <i class="fas fa-undo me-1"></i> {{ __('messages.restore') }}
                            </button>
                        </form>
                        <form action="{{ roleRoute('bookings.delete-permanently', $booking->id) }}" method="POST" class="inline-flex" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                <i class="fas fa-trash me-1"></i> {{ __('messages.permanent_deletion') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ roleRoute('bookings.edit', $booking->id) }}" class="inline-flex items-center px-3 py-1.5 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm">
                            <i class="fas fa-pencil-alt me-1"></i> {{ __('messages.edit') }}
                        </a>
                        <form action="{{ roleRoute('bookings.destroy', $booking->id) }}" method="POST" class="inline-flex" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                <i class="fas fa-trash me-1"></i> {{ __('messages.delete') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('messages.id') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('messages.course_name') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if ($booking->course)
                                <a href="{{ roleRoute('courses.show', $booking->course->id) }}" class="text-indigo-600 hover:underline">{{ $booking->course->title }}</a>
                            @else
                                <span class="text-red-600">{{ __('messages.course_deleted') }}</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('messages.student_name') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if ($booking->student)
                                <a href="{{ roleRoute('students.show', $booking->student->id) }}" class="text-indigo-600 hover:underline">{{ $booking->student->name }}</a>
                            @else
                                <span class="text-red-600">{{ __('messages.student_deleted') }}</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('messages.status') }}</dt>
                        <dd class="mt-1">
                            @if($booking->status == 'active')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">{{ __('messages.active') }}</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">{{ __('messages.inactive') }}</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('messages.created_at') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->created_at?->format('Y-m-d H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('messages.updated_at') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->updated_at?->format('Y-m-d H:i') }}</dd>
                    </div>
                    @if(auth()->user()->isAdmin())
                    <div>
                        <dt class="text-sm font-medium text-gray-500">{{ __('messages.owner') }}</dt>
                        <dd class="mt-1 text-sm">
                            <a href="{{ $booking->user ? route('admin.users.show', $booking->user->id) : '#' }}" class="text-gray-900 hover:underline">
                                <span class="font-medium text-gray-900">{{ $booking->user->name ?? '�' }}</span>
                                <span class="text-xs text-gray-400 block">{{ $booking->user->email ?? '' }}</span>
                            </a>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    @else
        <div class="p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ __('messages.booking_not_found') }}
        </div>
    @endif
@endsection
