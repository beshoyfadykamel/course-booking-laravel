@foreach ($bookings as $booking)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($booking->id, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm text-gray-900">
            @if ($booking->course)
                <a href="{{ roleRoute('courses.show', $booking->course->id) }}"
                    class="text-indigo-600 hover:underline">{!! highlight($booking->course->title, $searchTerm) !!}</a>
            @else
                <span class="text-red-600">{{ __('messages.course_deleted') }}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm text-gray-900">
            @if ($booking->student)
                <a href="{{ roleRoute('students.show', $booking->student->id) }}"
                    class="text-indigo-600 hover:underline">{!! highlight($booking->student->name, $searchTerm) !!}</a>
            @else
                <span class="text-red-600">{{ __('messages.student_deleted') }}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            @if ($booking->status == 'active')
                <span
                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($booking->status, $searchTerm) !!}</span>
            @else
                <span
                    class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($booking->status, $searchTerm) !!}</span>
            @endif
        </td>
        @if (auth()->user()->isAdmin())
            <td class="px-6 py-3 text-sm text-gray-600">
                <div class="flex flex-col">
                    <a href="{{ $booking->user ? route('admin.users.show', $booking->user->id) : '#' }}"
                        class="text-gray-900 hover:underline">
                        <span class="font-medium text-gray-900">{{ $booking->user->name ?? '�' }}</span>
                        <span class="text-xs text-gray-400 block">{{ $booking->user->email ?? '' }}</span>
                    </a>
                </div>
            </td>
        @endif
        <td class="px-6 py-3 text-sm">
            <div class="flex items-center gap-1.5 flex-nowrap">
                <a href="{{ roleRoute('bookings.show', $booking->id) }}"
                    class="inline-flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition shadow-sm"
                    title="{{ __('messages.view') }}"><i class="fas fa-eye text-xs"></i></a>
                <a href="{{ roleRoute('bookings.edit', $booking->id) }}"
                    class="inline-flex items-center justify-center w-8 h-8 bg-orange-500 text-white rounded-full hover:bg-orange-600 transition shadow-sm"
                    title="{{ __('messages.edit') }}"><i class="fas fa-pencil-alt text-xs"></i></a>
                <form action="{{ roleRoute('bookings.destroy', $booking->id) }}" method="POST" class="inline-flex"
                    onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center w-8 h-8 bg-red-600 text-white rounded-full hover:bg-red-700 transition shadow-sm"
                        title="{{ __('messages.delete') }}"><i class="fas fa-trash text-xs"></i></button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
