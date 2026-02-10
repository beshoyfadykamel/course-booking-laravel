@extends('master')
@section('title')
    {{ __('messages.dashboard') }} | {{ __('messages.courses_management') }}
@endsection


@section('content-header')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark d-inline-block">{{ __('messages.dashboard') }}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('messages.add_course') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection

@section('content')
    <div class="col-md-8 m-auto">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="m-0">{{ __('messages.add_new_course') }}</h5>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">{{ __('messages.course_title') }}</label>
                        <input type="text" class="form-control" id="title"
                            placeholder="{{ __('messages.enter_course_title') }}" name="title" value="{{ old('title') }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('messages.description') }}</label>
                        <input type="text" class="form-control" id="description"
                            placeholder="{{ __('messages.enter_description') }}" name="description"
                            value="{{ old('description') }}">
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('messages.status') }}</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">{{ __('messages.choose_status') }}</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                {{ __('messages.active') }}</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                {{ __('messages.inactive') }}</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary  w-100">{{ __('messages.submit') }}</button>
                </div>
            </form>
        </div>
        <!-- /.card -->


    </div>
@endsection