@foreach ($bookings as $booking)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($booking->id, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm text-gray-900">
            @if ($booking->course)
                <a href="{{ route('courses.show', $booking->course->id) }}" class="text-indigo-600 hover:underline">{!! highlight($booking->course->title, $searchTerm) !!}</a>
            @else
                <span class="text-red-600">{{ __('messages.course_deleted') }}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm text-gray-900">
            @if ($booking->student)
                <a href="{{ route('students.show', $booking->student->id) }}" class="text-indigo-600 hover:underline">{!! highlight($booking->student->name, $searchTerm) !!}</a>
            @else
                <span class="text-red-600">{{ __('messages.student_deleted') }}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            @if($booking->status == 'active')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($booking->status, $searchTerm) !!}</span>
            @else
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($booking->status, $searchTerm) !!}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            <div class="flex items-center gap-2">
                <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center px-2.5 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-xs"><i class="fas fa-eye me-1"></i> {{ __('messages.view') }}</a>
                <form action="{{ route('bookings.restore', $booking->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-2.5 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-xs"><i class="fas fa-undo me-1"></i> {{ __('messages.restore') }}</button>
                </form>
                <form action="{{ route('bookings.delete-permanently', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-2.5 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs"><i class="fas fa-trash me-1"></i> {{ __('messages.permanent_deletion') }}</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach