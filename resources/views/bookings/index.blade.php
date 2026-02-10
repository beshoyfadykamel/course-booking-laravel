@extends('master')
@section('title')
    {{ __('messages.dashboard') }} | {{ __('messages.bookings_management') }}
@endsection

@if (@isset($bookings) && !@empty($bookings))

    @section('content-header')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark d-inline-block">{{ __('messages.dashboard') }}
                            <a href="{{ route('bookings.recycle') }}" class="btn btn-danger btn-sm ml-2"> <i
                                    class="fas fa-trash"></i> {{ __('messages.recycle_bin') }} ({{ $recycleCount }})</a>

                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.bookings_management') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
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
                    <h5 class="m-0">{{ __('messages.bookings_table') }} <span class="badge badge-primary"
                            id="bookings_count">({{ $bookings_count }})</span>
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
                                    <option value="course_name">{{ __('messages.course_name') }}</option>
                                    <option value="student_name">{{ __('messages.student_name') }}</option>
                                    <option value="status">{{ __('messages.status') }}</option>
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
                                <th>{{ __('messages.course_name') }}</th>
                                <th>{{ __('messages.student_name') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>
                                        @if ($booking->course)
                                            <a
                                                href="{{ route('courses.show', $booking->course->id) }}">{{ $booking->course->title }}</a>
                                        @else
                                            <span class="text-danger">{{ __('messages.course_deleted') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($booking->student)
                                            <a
                                                href="{{ route('students.show', $booking->student->id) }}">{{ $booking->student->name }}</a>
                                        @else
                                            <span class="text-danger">{{ __('messages.student_deleted') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->status }}</td>
                                    <td>
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-eye"></i> {{ __('messages.view') }}</a>
                                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning"><i
                                                    class="fas fa-pencil-alt"></i> {{ __('messages.edit') }}</a>
                                            <a href="{{ route('bookings.destroy', $booking->id) }}" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i> {{ __('messages.delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix" id="pagination_links">
                    {{ $bookings->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    @endsection
    @section('scripts')
        <script>
            $(document).ready(function () {

                let debounceTimer;
                let ajaxRequest;

                function fetchResults(page = 1, pushState = true) {
                    var search = $('#table_search').val().trim();
                    var search_by = $('#search_by').val();

                    if (ajaxRequest) {
                        ajaxRequest.abort();
                    }

                    $('#example1 tbody').css('opacity', '0.5');

                    ajaxRequest = $.ajax({
                        url: "{{ route('bookings.search') }}",
                        method: 'get',
                        dataType: 'json',
                        data: {
                            search_by: search_by,
                            search: search,
                            page: page
                        },
                        success: function (data) {
                            $('#example1 tbody').html(data.html);
                            $('#bookings_count').text('(' + data.count + ')');
                            $('#pagination_links').html(data.pagination);
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
                        error: function (xhr, status) {
                            if (status !== 'abort') {
                                console.log('STATUS:', xhr.status);
                                console.log('RESPONSE:', xhr.responseText);
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

                    if (search !== '' || search_by !== 'all' || page > 1) {
                        $('#table_search').val(search);
                        $('#search_by').val(search_by);
                        fetchResults(page, false);
                    }
                }

                handleUrlParams();

                window.onpopstate = function () {
                    handleUrlParams();
                };
            });
        </script>
    @endsection
@else
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert"
        style="background-color: #dc3545; color: white; border-color: #dc3545;">
        {{ __('messages.booking_not_found') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            style="color: white; opacity: 1; outline: none; box-shadow: none;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif