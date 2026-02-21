@extends('layouts.master')

@section('title')
    {{ __('messages.users_management') }}
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Header with Title and Actions -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.users_management') }}</h1>
        <div class="flex gap-3 mt-4 md:mt-0">
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                <i class="fas fa-plus me-2"></i>
                {{ __('messages.add_user') }}
            </a>
            <a href="{{ route('users.recycle') }}"
                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                <i class="fas fa-trash me-2"></i>
                {{ __('messages.recycle_bin') }}
                <span class="ms-2 bg-red-800 px-2 py-0.5 rounded-full text-xs">{{ $recycleCount }}</span>
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.search_by') }}</label>
                <select name="search_by" id="search_by"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix">
                    <option value="all">{{ __('messages.search_by_all') }}</option>
                    <option value="id">{{ __('messages.id') }}</option>
                    <option value="name">{{ __('messages.name') }}</option>
                    <option value="email">{{ __('messages.email') }}</option>
                    <option value="role">{{ __('messages.role') }}</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.search') }}</label>
                <input type="text" id="table_search"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="{{ __('messages.search') }}...">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table id="data_table" class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.id') }}</th>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.name') }}</th>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.email') }}</th>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.role') }}</th>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if (isset($users) && $users->count() > 0)
                        @include('users.partials.user_table', ['users' => $users, 'searchTerm' => ''])
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-users text-3xl mb-2 block text-gray-300"></i>
                                {{ __('messages.user_not_found') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination_links" class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let debounceTimer;
            let ajaxRequest;

            function fetchResults(page = 1, pushState = true) {
                var search = $('#table_search').val().trim();
                var search_by = $('#search_by').val();

                if (ajaxRequest) { ajaxRequest.abort(); }
                $('#data_table tbody').css('opacity', '0.5');

                ajaxRequest = $.ajax({
                    url: "{{ route('users.search') }}",
                    method: 'get',
                    dataType: 'json',
                    data: { search_by: search_by, search: search, page: page },
                    success: function(data) {
                        $('#data_table tbody').html(data.html);
                        $('#pagination_links').html(data.pagination);
                        $('#data_table tbody').css('opacity', '1');

                        if (pushState) {
                            let url = new URL(window.location.href);
                            if (search) { url.searchParams.set('search', search); } else { url.searchParams.delete('search'); }
                            if (search_by !== 'all') { url.searchParams.set('search_by', search_by); } else { url.searchParams.delete('search_by'); }
                            if (page > 1) { url.searchParams.set('page', page); } else { url.searchParams.delete('page'); }
                            window.history.pushState({}, '', url);
                        }
                    },
                    error: function(xhr, status) {
                        if (status !== 'abort') { console.error('Search Error:', xhr.status); }
                        $('#data_table tbody').css('opacity', '1');
                    }
                });
            }

            $(document).on('change', '#search_by', function() { $('#table_search').trigger('input'); });
            $(document).on('input', '#table_search', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function() { fetchResults(1, true); }, 500);
            });
            $(document).on('click', '#pagination_links a', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                var pageMatch = href.match(/page=(\d+)/);
                var page = pageMatch ? pageMatch[1] : 1;
                fetchResults(page, true);
            });

            function handleUrlParams() {
                let urlParams = new URLSearchParams(window.location.search);
                let search = urlParams.get('search') || '';
                let search_by = urlParams.get('search_by') || 'all';
                let page = urlParams.get('page') || 1;
                if (search !== '' || search_by !== 'all' || page > 1) {
                    $('#table_search').val(search);
                    $('#search_by').val(search_by);
                    fetchResults(page, false);
                }
            }
            handleUrlParams();
            window.onpopstate = function() { handleUrlParams(); };
        });
    </script>
@endsection
