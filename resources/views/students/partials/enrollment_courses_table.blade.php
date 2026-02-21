@foreach ($courses as $course)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($course->id, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($course->title, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm">
            @if($course->pivot->status == 'active')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($course->pivot->status, $searchTerm) !!}</span>
            @else
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($course->pivot->status, $searchTerm) !!}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center px-2.5 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-xs"><i class="fas fa-eye me-1"></i> {{ __('messages.view_course') }}</a>
        </td>
    </tr>
@endforeach