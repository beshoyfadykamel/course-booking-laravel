@foreach ($courses as $course)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($course->id, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($course->title, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm">
            @if($course->status == 'active')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($course->status, $searchTerm) !!}</span>
            @else
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($course->status, $searchTerm) !!}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            <div class="flex items-center gap-2">
                <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center px-2.5 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-xs"><i class="fas fa-eye me-1"></i> {{ __('messages.view') }}</a>
                <a href="{{ route('courses.edit', $course->id) }}" class="inline-flex items-center px-2.5 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition text-xs"><i class="fas fa-pencil-alt me-1"></i> {{ __('messages.edit') }}</a>
                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-2.5 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs"><i class="fas fa-trash me-1"></i> {{ __('messages.delete') }}</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach