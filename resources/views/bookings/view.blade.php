@extends('master')
@section('title')
    View Booking | Booking Manegment
@endsection

@if (@isset($booking) && !@empty($booking))

    @section('content-header')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">View Booking</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Booking Manegment</a></li>
                            <li class="breadcrumb-item active">View Booking</li>
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
                    <h3 class="card-title">Booking Table</h3>
                </div>
                <div class="card-header">
                    <div class="row w-100">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 130px;">
                    <table id="example2" class="table table-head-fixed text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Create Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>
                                    @if ($booking->course)
                                        <a
                                            href="{{ route('courses.show', $booking->course->id) }}">{{ $booking->course->title }}</a>
                                    @else
                                        <span class="text-danger">Course Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($booking->student)
                                        <a
                                            href="{{ route('students.show', $booking->student->id) }}">{{ $booking->student->name }}</a>
                                    @else
                                        <span class="text-danger">Student Deleted</span>
                                    @endif
                                </td>
                                <td>{{ $booking->status }}</td>
                                <td>{{ $booking->created_at }}</td>
                                <td>{{ $booking->updated_at }}</td>
                                <td>
                                    <div class="btn-group-responsive">
                                        @if ($booking->trashed())
                                            <a href="{{ route('bookings.restore', $booking->id) }}"
                                                class="btn btn-sm btn-success"><i class="fas fa-undo"></i> Restore</a>
                                            <a href="{{ route('bookings.delete-permanently', $booking->id) }}"
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Permanent
                                                deletion</a>
                                        @else
                                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning"><i
                                                    class="fas fa-pencil-alt"></i> Edit</a>
                                            <a href="{{ route('bookings.destroy', $booking->id) }}" class="btn btn-sm btn-danger"><i
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
        </div>
    @endsection
@else
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert"
        style="background-color: #dc3545; color: white; border-color: #dc3545;">
        Booking not found.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
            style="color: white; opacity: 1; outline: none; box-shadow: none;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif