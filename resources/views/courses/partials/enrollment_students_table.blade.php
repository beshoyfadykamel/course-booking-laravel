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
            @if($student->pivot->status == 'active')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($student->pivot->status, $searchTerm) !!}</span>
            @else
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($student->pivot->status, $searchTerm) !!}</span>
            @endif
        </td>
        <td class="px-6 py-3 text-sm">
            <a href="{{ route('students.show', $student->id) }}" class="inline-flex items-center px-2.5 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-xs"><i class="fas fa-eye me-1"></i> {{ __('messages.view_student') }}</a>
        </td>
    </tr>
@endforeach