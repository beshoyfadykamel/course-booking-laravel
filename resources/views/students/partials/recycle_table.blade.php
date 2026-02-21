@foreach ($students as $student)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 text-sm text-gray-900">{!! highlight($student->id, $searchTerm) !!}</td>
        <td class="px-6 py-4 text-sm">
            @if ($student->image)
                <img src="{{ asset('storage/' . $student->image) }}" alt="{{ __('messages.student_image') }}"
                    class="w-10 h-10 rounded-full object-cover">
            @else
                <span class="text-gray-400 text-xs">{{ __('messages.no_image') }}</span>
            @endif
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">{!! highlight($student->name, $searchTerm) !!}</td>
        <td class="px-6 py-4 text-sm">
            @if ($student->status == 'active')
                <span
                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($student->status, $searchTerm) !!}</span>
            @else
                <span
                    class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($student->status, $searchTerm) !!}</span>
            @endif
        </td>
        @if (auth()->user()->isAdmin())
            <td class="px-6 py-4 text-sm text-gray-600">
                <div class="flex flex-col">
                    <a href="{{ $student->user ? route('users.show', $student->user->id) : '#' }}"
                        class="text-gray-900 hover:underline">
                        <span class="font-medium text-gray-900">{{ $student->user->name ?? '' }}</span>
                        <span class="text-xs text-gray-400 block">{{ $student->user->email ?? '' }}</span>
                    </a>
                </div>
            </td>
        @endif
        <td class="px-6 py-4 text-sm">
            <div class="flex items-center gap-1.5 flex-nowrap">
                <a href="{{ route('students.show', $student->id) }}"
                    class="inline-flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition shadow-sm"
                    title="{{ __('messages.view') }}"><i class="fas fa-eye text-xs"></i></a>
                <form action="{{ route('students.restore', $student->id) }}" method="POST" class="inline-flex">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full hover:bg-green-700 transition shadow-sm"
                        title="{{ __('messages.restore') }}"><i class="fas fa-undo text-xs"></i></button>
                </form>
                <form action="{{ route('students.delete-permanently', $student->id) }}" method="POST"
                    class="inline-flex" onsubmit="return confirm('{{ __('messages.confirm_permanent_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center w-8 h-8 bg-red-700 text-white rounded-full hover:bg-red-800 transition shadow-sm"
                        title="{{ __('messages.permanent_deletion') }}"><i class="fas fa-trash text-xs"></i></button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
