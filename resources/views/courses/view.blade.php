@extends('master')
@section('title')
    {{ __('messages.view_course') }} | {{ __('messages.courses_management') }}
@endsection

@if (@isset($course) && !@empty($course))
    @section('content-header')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ __('messages.view_course') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('courses.index') }}">{{ __('messages.courses_management') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.view_course') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    @endsection

    @section('content')
        <div class="col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert"
                    style="background-color: #28a745; color: white; border-color: #28a745;">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">{{ __('messages.course_details') }} "{{ $course->title }}"</h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 120px;">
                    <table id="example2" class="table table-head-fixed text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.id') }}</th>
                                <th>{{ __('messages.course_title') }}</th>
                                <th>{{ __('messages.course_description') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.created_at') }}</th>
                                <th>{{ __('messages.updated_at') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->description }}</td>
                                <td>{{ $course->status }}</td>
                                <td>{{ $course->created_at }}</td>
                                <td>{{ $course->updated_at }}</td>
                                <td>
                                        @if ($course->trashed())
                                            <a href="{{ route('courses.restore', $course->id) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-undo"></i>
                                                {{ __('messages.restore') }}</a>
                                            <a href="{{ route('courses.delete-permanently', $course->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Permanent
                                                deletion</a>
                                        @else
                                            <a href="{{ route('courses.edit', $course->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i>
                                                {{ __('messages.edit') }}</a>
                                            <a href="{{ route('courses.destroy', $course->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                {{ __('messages.delete') }}</a>
                                        @endif
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0"> {{ __('messages.course') }} "{{ $course->title }}"
                        {{ __('messages.student_enrollment_table') }} <span id="course_count"
                            class="badge badge-primary">({{ count($course->students) }})</span>
                    </h5>
                </div>
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <a href="{{ route('bookings.create') }}" class="btn btn-success btn-block btn-sm"><i
                                    class="fas fa-plus"></i> {{ __('messages.add_booking') }}</a>
                        </div>
                        <div class="col-6 col-md-2 mt-2 mt-md-0">
                            <div class="input-group input-group-sm">

                                <select name="search_by" id="search_by" class="form-control w-25">
                                    <option value="all">{{ __('messages.search_by_all') }}</option>
                                    <option value="id">{{ __('messages.id') }}</option>
                                    <option value="name">{{ __('messages.name') }}</option>
                                    <option value="status">{{ __('messages.enrollment_status') }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-6 col-md-4 mt-2 mt-md-0">
                            <div class="input-group input-group-sm">
                                <input type="text" id="table_search" class="form-control"
                                    placeholder="{{ __('messages.search') }}" name="search">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table id="example1" class="table table-head-fixed text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.id') }}</th>
                                <th>{{ __('messages.image') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.enrollment_status') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($students) && !empty($students))
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>

                                        <td>
                                            @if ($student->image)
                                                <a href="{{ asset('storage/' . $student->image) }}" data-toggle="lightbox"
                                                    data-title="{{ $student->name }} - {{ $student->id }}">
                                                    <img src="{{ asset('storage/' . $student->image) }}"
                                                        alt="{{ __('messages.student_image') }}" class="img-thumbnail"
                                                        width="50" height="50">
                                                </a>
                                            @else
                                                <span>{{ __('messages.no_image') }}</span>
                                            @endif
                                        </td>

                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->pivot->status }}</td>
                                        <td>
                                            <div class="btn-group-responsive">
                                                <a href="{{ route('students.show', $student->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="fas fa-eye"></i>
                                                    {{ __('messages.view_student') }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix" id="pagination_links">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script>
            $(function() {
                $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                    event.preventDefault();
                    $(this).ekkoLightbox({
                        alwaysShowClose: true
                    });
                });
            });

            $(document).ready(function() {

                let debounceTimer;
                let ajaxRequest;

                // Reusable function for fetching results
                function fetchResults(page = 1, pushState = true) {
                    var search = $('#table_search').val().trim();
                    var search_by = $('#search_by').val();
                    var course_id = "{{ $course->id }}";

                    if (ajaxRequest) {
                        ajaxRequest.abort();
                    }

                    $('#example1 tbody').css('opacity', '0.5');

                    ajaxRequest = $.ajax({
                        url: "{{ route('courses.enrollment.search') }}",
                        method: 'get',
                        dataType: 'json',
                        data: {
                            search_by: search_by,
                            search: search,
                            course_id: course_id,
                            page: page
                        },
                        success: function(data) {
                            console.log('Search Success:', data);
                            if (data.html !== undefined) {
                                $('#example1 tbody').html(data.html);
                            }
                            if (data.count !== undefined) {
                                $('#course_count').text('(' + data.count + ')');
                            }
                            if (data.pagination !== undefined) {
                                $('#pagination_links').html(data.pagination);
                            } else {
                                $('#pagination_links').html('');
                            }
                            $('#example1 tbody').css('opacity', '1');

                            if (pushState) {
                                let url = new URL(window.location.href);

                                if (search) {
                                    url.searchParams.set('search', search);
                                } else {
                                    url.searchParams.delete('search');
                                }

                                if (search_by !== 'all') {
                                    url.searchParams.set('search_by', search_by);
                                } else {
                                    url.searchParams.delete('search_by');
                                }

                                if (page > 1) {
                                    url.searchParams.set('page', page);
                                } else {
                                    url.searchParams.delete('page');
                                }

                                window.history.pushState({}, '', url);
                            }
                        },
                        error: function(xhr, status, error) {
                            if (status !== 'abort') {
                                console.error('Search Error:', {
                                    status: xhr.status,
                                    error: error,
                                    response: xhr.responseText
                                });
                            }
                            $('#example1 tbody').css('opacity', '1');
                        }
                    });
                }

                $(document).on('change', '#search_by', function() {
                    $('#table_search').trigger('input');
                });

                $(document).on('input', '#table_search', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function() {
                        // Reset to page 1 for new search
                        fetchResults(1, true);
                    }, 500);
                });

                $(document).on('click', '#pagination_links .pagination a', function(e) {
                    e.preventDefault();
                    var href = $(this).attr('href');
                    var pageMatch = href.match(/page=(\d+)/);
                    var page = pageMatch ? pageMatch[1] : 1;
                    fetchResults(page, true);
                });

                // Initialize from URL
                function handleUrlParams() {
                    let urlParams = new URLSearchParams(window.location.search);
                    let search = urlParams.get('search') || '';
                    let search_by = urlParams.get('search_by') || 'all';
                    let page = urlParams.get('page') || 1;

                    // Only trigger if there's actual state to restore
                    if (search !== '' || search_by !== 'all' || page > 1) {
                        $('#table_search').val(search);
                        $('#search_by').val(search_by);
                        fetchResults(page, false); // false = don't push state
                    }
                }

                handleUrlParams();

                // Handle Browser Back/Forward buttons
                window.onpopstate = function() {
                    handleUrlParams();
                };
            });
        </script>
    @endsection
@else
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert"
        style="background-color: #dc3545; color: white; border-color: #dc3545;">
        {{ __('messages.course_not_found') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            style="color: white; opacity: 1; outline: none; box-shadow: none;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif
