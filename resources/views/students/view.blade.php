@extends('master')
@section('title')
    View Student | Student Manegment
@endsection


@if (@isset($student) && !@empty($student))

    @section('content-header')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">View Student</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Student Manegment</a></li>
                            <li class="breadcrumb-item active">View Student</li>
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
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                        style="color: white; opacity: 1; outline: none; box-shadow: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Student Details</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 150px;">
                    <table id="example2" class="table table-head-fixed text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Create Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>
                                    @if ($student->image)
                                        <a href="{{ asset('storage/' . $student->image) }}" data-toggle="lightbox"
                                            data-title="Student Image - {{ $student->id }}">
                                            <img src="{{ asset('storage/' . $student->image) }}" alt="Student Image"
                                                class="img-thumbnail" width="50" height="50">
                                        </a>
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->country->name ?? 'N/A' }}</td>
                                <td>{{ $student->status }}</td>
                                <td>{{ $student->created_at }}</td>
                                <td>{{ $student->updated_at }}</td>
                                <td>
                                    <div class="btn-group-responsive">
                                        @if ($student->trashed())
                                            <a href="{{ route('students.restore', $student->id) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Restore</a>
                                            <a href="{{ route('students.delete-permanently', $student->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Permanent
                                                deletion</a>
                                        @else
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning"><i
                                                    class="fas fa-pencil-alt"></i> Edit</a>
                                            <a href="{{ route('students.destroy', $student->id) }}" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i> Delete</a>
                                        @endif
                                    </div>
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
                    <h3 class="card-title"> Student "{{ $student->name }}" Enrollment Table <span class="badge badge-primary"
                            id="courses_count">({{ $coursesCount }})</span></h3>
                </div>
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-12 col-md-6 mb-2 mb-md-0">
                            <a href="{{ route('bookings.create') }}" class="btn btn-success btn-block btn-sm"><i
                                    class="fas fa-plus"></i> Add Booking</a>
                        </div>
                        <div class="col-6 col-md-2 mt-2 mt-md-0">
                            <div class="input-group input-group-sm">

                                <select name="search_by" id="search_by" class="form-control w-25">
                                    <option value="all">Search by all</option>
                                    <option value="id">ID</option>
                                    <option value="title">Title</option>
                                    <option value="status">Enrollment Status</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-6 col-md-4 mt-2 mt-md-0">
                            <div class="input-group input-group-sm">
                                <input type="text" id="table_search" class="form-control" placeholder="Search" name="search">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table id="example1" class="table table-head-fixed text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Enrollment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (@isset($student->courses) && !@empty($student->courses))
                                @include('students.partials.enrollment_courses_table', ['courses' => $courses, 'searchTerm' => ''])
                            @endif

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix" id="pagination_links">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            $(function () {
                $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                    event.preventDefault();
                    $(this).ekkoLightbox({
                        alwaysShowClose: true
                    });
                });
            });

            $(document).ready(function () {

                let debounceTimer;
                let ajaxRequest;

                // Reusable function for fetching results
                function fetchResults(page = 1, pushState = true) {
                    var search = $('#table_search').val().trim();
                    var search_by = $('#search_by').val();
                    var student_id = "{{ $student->id }}";

                    if (ajaxRequest) {
                        ajaxRequest.abort();
                    }

                    $('#example1 tbody').css('opacity', '0.5');

                    ajaxRequest = $.ajax({
                        url: "{{ route('students.enrollment.search') }}",
                        method: 'get',
                        dataType: 'json',
                        data: {
                            search_by: search_by,
                            search: search,
                            student_id: student_id,
                            page: page
                        },
                        success: function (data) {
                            console.log('Search Success:', data);
                            if (data.html !== undefined) {
                                $('#example1 tbody').html(data.html);
                            }
                            if (data.count !== undefined) {
                                $('#courses_count').text('(' + data.count + ')');
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
                        error: function (xhr, status, error) {
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

                $(document).on('change', '#search_by', function () {
                    $('#table_search').trigger('input');
                });

                $(document).on('input', '#table_search', function () {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function () {
                        // Reset to page 1 for new search
                        fetchResults(1, true);
                    }, 500);
                });

                $(document).on('click', '#pagination_links .pagination a', function (e) {
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
                window.onpopstate = function () {
                    handleUrlParams();
                };
            });
        </script>
    @endsection
@else
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert"
        style="background-color: #dc3545; color: white; border-color: #dc3545;">
        Course not found.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            style="color: white; opacity: 1; outline: none; box-shadow: none;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif