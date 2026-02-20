@foreach ($courses as $course)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($course->id, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm text-gray-900">{!! highlight($course->title, $searchTerm) !!}</td>
        <td class="px-6 py-3 text-sm">
            @if ($course->status == 'active')
                <span
                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{!! highlight($course->status, $searchTerm) !!}</span>
            @else
                <span
                    class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{!! highlight($course->status, $searchTerm) !!}</span>
            @endif
        </td>
        @if (auth()->user()->isAdmin())
            <td class="px-6 py-3 text-sm text-gray-600">
                <div class="flex flex-col">
                    <a href="{{ $course->user ? route('admin.users.show', $course->user->id) : '#' }}"
                        class="text-gray-900 hover:underline">
                        <span class="font-medium text-gray-900">{{ $course->user->name ?? '' }}</span>
                        <span class="text-xs text-gray-400 block">{{ $course->user->email ?? '' }}</span>
                    </a>
                </div>
            </td>
        @endif
        <td class="px-6 py-3 text-sm">
            <div class="flex items-center gap-1.5 flex-nowrap">
                <a href="{{ roleRoute('courses.show', $course->id) }}"
                    class="inline-flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition shadow-sm"
                    title="{{ __('messages.view') }}"><i class="fas fa-eye text-xs"></i></a>
                <form action="{{ roleRoute('courses.restore', $course->id) }}" method="POST" class="inline-flex">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full hover:bg-green-700 transition shadow-sm"
                        title="{{ __('messages.restore') }}"><i class="fas fa-undo text-xs"></i></button>
                </form>
                <form action="{{ roleRoute('courses.delete-permanently', $course->id) }}" method="POST"
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
