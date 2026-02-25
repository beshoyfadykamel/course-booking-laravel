@foreach ($bookings as $booking)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($booking->course->id, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($booking->course->title, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm">
            @if ($booking->status == 'active')
                <span
                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($booking->status, $searchTerm) !!}</span>
            @else
                <span
                    class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($booking->status, $searchTerm) !!}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            <a href="{{ route('courses.show', $booking->course->id) }}"
                class="inline-flex items-center px-2.5 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-xs"><i
                    class="fas fa-eye me-1"></i> {{ __('messages.view_course') }}</a>
        </td>
    </tr>
@endforeach
