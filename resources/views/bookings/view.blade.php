@extends('master')
@section('title')
    {{ __('messages.view_booking') }} | {{ __('messages.bookings_management') }}
@endsection

@if (@isset($booking) && !@empty($booking))

    @section('content-header')
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ __('messages.view_booking') }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('messages.bookings_management') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.view_booking') }}</li>
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
                    <h5 class="m-0">{{ __('messages.booking_details') }}</h5>
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
                                <th>{{ __('messages.id') }}</th>
                                <th>{{ __('messages.course_name') }}</th>
                                <th>{{ __('messages.student_name') }}</th>
                                <th>{{ __('messages.status') }}</th>
                                <th>{{ __('messages.created_at') }}</th>
                                <th>{{ __('messages.updated_at') }}</th>
                                <th>{{ __('messages.actions') }}</th>
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
                                <td>{{ $booking->created_at }}</td>
                                <td>{{ $booking->updated_at }}</td>
                                <td>

                                    @if ($booking->trashed())
                                        <a href="{{ route('bookings.restore', $booking->id) }}"
                                            class="btn btn-sm btn-success"><i class="fas fa-undo"></i>
                                            {{ __('messages.restore') }}</a>
                                        <a href="{{ route('bookings.delete-permanently', $booking->id) }}"
                                            class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                            {{ __('messages.permanent_deletion') }}</a>
                                    @else
                                        <a href="{{ route('bookings.edit', $booking->id) }}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i>
                                            {{ __('messages.edit') }}</a>
                                        <a href="{{ route('bookings.destroy', $booking->id) }}"
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
        </div>
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
