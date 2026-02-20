@extends('layouts.master')
@section('title')
    {{ __('messages.view_student') }} | {{ __('messages.students_management') }}
@endsection

@section('content')
    @if (isset($student))
        @if (session()->has('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Student Details Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('messages.student_details') }}</h2>
                <div class="flex gap-2 mt-2 sm:mt-0">
                    @if ($student->trashed())
                        <form action="{{ roleRoute('students.restore', $student->id) }}" method="POST" class="inline-flex">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                                <i class="fas fa-undo me-1"></i> {{ __('messages.restore') }}
                            </button>
                        </form>
                        <form action="{{ roleRoute('students.delete-permanently', $student->id) }}" method="POST"
                            class="inline-flex" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                <i class="fas fa-trash me-1"></i> {{ __('messages.permanent_deletion') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ roleRoute('students.edit', $student->id) }}"
                            class="inline-flex items-center px-3 py-1.5 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm">
                            <i class="fas fa-pencil-alt me-1"></i> {{ __('messages.edit') }}
                        </a>
                        <form action="{{ roleRoute('students.destroy', $student->id) }}" method="POST" class="inline-flex"
                            onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                <i class="fas fa-trash me-1"></i> {{ __('messages.delete') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- Student Image -->
                    <div class="shrink-0 text-center">
                        @if ($student->image)
                            <img src="{{ asset('storage/' . $student->image) }}" alt="{{ __('messages.student_image') }}"
                                class="w-28 h-28 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-28 h-28 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <!-- Student Info -->
                    <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 flex-1">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.id') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.name') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $student->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.email') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.country') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->country->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.status') }}</dt>
                            <dd class="mt-1">
                                @if ($student->status == 'active')
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">{{ __('messages.active') }}</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">{{ __('messages.inactive') }}</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.created_at') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->created_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('messages.updated_at') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student->updated_at?->format('Y-m-d H:i') }}</dd>
                        </div>
                        @if (auth()->user()->isAdmin())
                            <div>
                                <dt class="text-sm font-medium text-gray-500">{{ __('messages.owner') }}</dt>
                                <dd class="mt-1 text-sm">
                                    <a href="{{ $student->user ? route('admin.users.show', $student->user->id) : '#' }}"
                                        class="text-gray-900 hover:underline">
                                        <span class="font-medium text-gray-900">{{ $student->user->name ?? '' }}</span>
                                        <span class="text-xs text-gray-400 block">{{ $student->user->email ?? '' }}</span>
                                    </a>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h2 class="text-lg font-semibold text-gray-900">
                        {{ __('messages.student_enrollment') }} "{{ $student->name }}"
                        <span id="courses_count"
                            class="ms-2 px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">({{ $coursesCount }})</span>
                    </h2>
                    <a href="{{ roleRoute('bookings.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                        <i class="fas fa-plus me-2"></i> {{ __('messages.add_booking') }}
                    </a>
                </div>
            </div>

            <!-- Search -->
            <div class="px-6 py-3 border-b border-gray-100 bg-gray-50">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <select name="search_by" id="search_by"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix">
                        <option value="all">{{ __('messages.search_by_all') }}</option>
                        <option value="id">{{ __('messages.id') }}</option>
                        <option value="title">{{ __('messages.course_name') }}</option>
                        <option value="status">{{ __('messages.enrollment_status') }}</option>
                    </select>
                    <input type="text" id="table_search"
                        class="sm:col-span-2 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="{{ __('messages.search') }}...">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="enrollment_table" class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">{{ __('messages.id') }}
                            </th>
                            <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">
                                {{ __('messages.course_name') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">
                                {{ __('messages.enrollment_status') }}</th>
                            <th class="px-6 py-3 text-start text-sm font-semibold text-gray-900">
                                {{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if (isset($courses) && $courses->count() > 0)
                            @include('students.partials.enrollment_courses_table', [
                                'courses' => $courses,
                                'searchTerm' => '',
                            ])
                        @endif
                    </tbody>
                </table>
            </div>

            <div id="pagination_links" class="px-6 py-4 border-t border-gray-200">
                {{ $courses->links() }}
            </div>
        </div>
    @else
        <div class="p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ __('messages.student_not_found') }}
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let debounceTimer;
            let ajaxRequest;

            function fetchResults(page = 1, pushState = true) {
                var search = $('#table_search').val().trim();
                var search_by = $('#search_by').val();
                var student_id = "{{ $student->id ?? '' }}";

                if (ajaxRequest) {
                    ajaxRequest.abort();
                }
                $('#enrollment_table tbody').css('opacity', '0.5');

                ajaxRequest = $.ajax({
                    url: "{{ roleRoute('students.enrollment.search') }}",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        search_by: search_by,
                        search: search,
                        student_id: student_id,
                        page: page
                    },
                    success: function(data) {
                        if (data.html !== undefined) {
                            $('#enrollment_table tbody').html(data.html);
                        }
                        if (data.count !== undefined) {
                            $('#courses_count').text('(' + data.count + ')');
                        }
                        if (data.pagination !== undefined) {
                            $('#pagination_links').html(data.pagination);
                        }
                        $('#enrollment_table tbody').css('opacity', '1');

                        if (pushState) {
                            let url = new URL(window.location.href);
                            search ? url.searchParams.set('search', search) : url.searchParams.delete(
                                'search');
                            search_by !== 'all' ? url.searchParams.set('search_by', search_by) : url
                                .searchParams.delete('search_by');
                            page > 1 ? url.searchParams.set('page', page) : url.searchParams.delete(
                                'page');
                            window.history.pushState({}, '', url);
                        }
                    },
                    error: function(xhr, status) {
                        if (status !== 'abort') {
                            console.error('Search Error:', xhr.status);
                        }
                        $('#enrollment_table tbody').css('opacity', '1');
                    }
                });
            }

            $(document).on('change', '#search_by', function() {
                $('#table_search').trigger('input');
            });
            $(document).on('input', '#table_search', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function() {
                    fetchResults(1, true);
                }, 500);
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
            window.onpopstate = function() {
                handleUrlParams();
            };
        });
    </script>
@endsection
