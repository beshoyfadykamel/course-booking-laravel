@extends('layouts.master')
@section('title')
    {{ __('messages.recycle_bin') }} | {{ __('messages.students_management') }}
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('messages.deleted_students_table') }}
                <span id="students_count" class="ms-2 px-2 py-1 bg-red-100 text-red-700 rounded-full text-sm">({{ $studentsCount }})</span>
            </h2>
        </div>

        <!-- Search -->
        <div class="px-6 py-3 border-b border-gray-100 bg-gray-50">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <select name="search_by" id="search_by" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix">
                    <option value="all">{{ __('messages.search_by_all') }}</option>
                    <option value="id">{{ __('messages.id') }}</option>
                    <option value="name">{{ __('messages.name') }}</option>
                    <option value="status">{{ __('messages.status') }}</option>
                </select>
                <input type="text" id="table_search" class="sm:col-span-2 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="{{ __('messages.search') }}...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="data_table" class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.id') }}</th>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.image') }}</th>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.name') }}</th>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.status') }}</th>
                        @if(auth()->user()->isAdmin())
                            <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.owner') }}</th>
                        @endif
                        <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if (isset($students) && $students->count() > 0)
                        @include('students.partials.recycle_table', ['students' => $students, 'searchTerm' => ''])
                    @endif
                </tbody>
            </table>
        </div>

        <div id="pagination_links" class="px-6 py-4 border-t border-gray-200">
            {{ $students->links() }}
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
                    url: "{{ route('students.recycle.search') }}",
                    method: 'get',
                    dataType: 'json',
                    data: { search_by: search_by, search: search, page: page },
                    success: function(data) {
                        if (data.html !== undefined) { $('#data_table tbody').html(data.html); }
                        if (data.count !== undefined) { $('#students_count').text('(' + data.count + ')'); }
                        if (data.pagination !== undefined) { $('#pagination_links').html(data.pagination); }
                        $('#data_table tbody').css('opacity', '1');

                        if (pushState) {
                            let url = new URL(window.location.href);
                            search ? url.searchParams.set('search', search) : url.searchParams.delete('search');
                            search_by !== 'all' ? url.searchParams.set('search_by', search_by) : url.searchParams.delete('search_by');
                            page > 1 ? url.searchParams.set('page', page) : url.searchParams.delete('page');
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
                var page = $(this).attr('href').match(/page=(\d+)/);
                fetchResults(page ? page[1] : 1, true);
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
