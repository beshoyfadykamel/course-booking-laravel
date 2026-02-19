@foreach ($students as $student)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($student->id, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm">
            @if ($student->image)
                <img src="{{ asset('storage/' . $student->image) }}" alt="{{ __('messages.student_image') }}" class="w-10 h-10 rounded-full object-cover">
            @else
                <span class="text-gray-400 text-xs">{{ __('messages.no_image') }}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($student->name, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm">
            @if($student->status == 'active')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($student->status, $searchTerm) !!}</span>
            @else
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($student->status, $searchTerm) !!}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            <div class="flex items-center gap-2">
                <a href="{{ route('students.show', $student->id) }}" class="inline-flex items-center px-2.5 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-xs"><i class="fas fa-eye me-1"></i> {{ __('messages.view') }}</a>
                <a href="{{ route('students.edit', $student->id) }}" class="inline-flex items-center px-2.5 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition text-xs"><i class="fas fa-pencil-alt me-1"></i> {{ __('messages.edit') }}</a>
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-2.5 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-xs"><i class="fas fa-trash me-1"></i> {{ __('messages.delete') }}</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach