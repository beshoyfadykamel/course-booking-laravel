@extends('master')
@section('title')
    Dashboard | Students Manegment
@endsection

@if (@isset($students) && !@empty($students))
    @section('content-header')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark d-inline-block">Dashboard
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Recycle Bin</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    @endsection

    @section('content')
        <div class="col-12">
            <div class="card">
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
                <div class="card-header">
                    <h3 class="card-title"> Deleted Students Table <span class="badge badge-danger"
                            id="students_count">({{ $studentsCount }})</span></h3>
                </div>
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-4 col-md-4 mt-2 mt-md-0">
                            <div class="input-group input-group-sm">

                                <select name="search_by" id="search_by" class="form-control w-25">
                                    <option value="all">Search by all</option>
                                    <option value="id">ID</option>
                                    <option value="name">Name</option>
                                    <option value="status">Status</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-8 col-md-8 mt-2 mt-md-0">
                            <div class="input-group input-group-sm">
                                <input type="text" id="table_search" class="form-control" placeholder="Search" name="search">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table id="example1" class="table table-bordered table-striped table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($students as $student)
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
                                    <td>{{ $student->status }}</td>
                                    <td>
                                        <div class="btn-group-responsive">
                                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-eye"></i> View</a>
                                            <a href="{{ route('students.restore', $student->id) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Restore</a>
                                            <a href="{{ route('students.delete-permanently', $student->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Permanent
                                                deletion</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix" id="pagination_links">
                    {{ $students->links() }}
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
                            url: "{{ route('students.recycle.search') }}",
                            method: 'get',
                            dataType: 'json',
                            data: {
                                search_by: search_by,
                                search: search,
                                page: page
                            },
                            success: function (data) {
                                $('#example1 tbody').html(data.html);
                                $('#students_count').text('(' + data.count + ')');
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
            Course not found.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                style="color: white; opacity: 1; outline: none; box-shadow: none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    @endif