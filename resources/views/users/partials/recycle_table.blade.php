@foreach ($users as $user)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 text-sm text-gray-900">{!! highlight($user->id, $searchTerm) !!}</td>
        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{!! highlight($user->name, $searchTerm) !!}</td>
        <td class="px-6 py-4 text-sm text-gray-900">{!! highlight($user->email, $searchTerm) !!}</td>
        <td class="px-6 py-4 text-sm">
            @if($user->role === 'admin')
                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">{!! highlight(__('messages.admin'), $searchTerm) !!}</span>
            @else
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{!! highlight(__('messages.user'), $searchTerm) !!}</span>
            @endif
        </td>
        <td class="px-6 py-4 text-sm">
            <div class="flex items-center gap-1.5 flex-nowrap">
                <a href="{{ route('admin.users.show', $user->id) }}"
                    class="inline-flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition shadow-sm"
                    title="{{ __('messages.view') }}">
                    <i class="fas fa-eye text-xs"></i>
                </a>
                <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="inline-flex">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full hover:bg-green-700 transition shadow-sm"
                        title="{{ __('messages.restore') }}">
                        <i class="fas fa-undo text-xs"></i>
                    </button>
                </form>
                <form action="{{ route('admin.users.delete-permanently', $user->id) }}" method="POST" class="inline-flex"
                    onsubmit="return confirm('{{ __('messages.confirm_permanent_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center w-8 h-8 bg-red-700 text-white rounded-full hover:bg-red-800 transition shadow-sm"
                        title="{{ __('messages.permanent_deletion') }}">
                        <i class="fas fa-trash text-xs"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
