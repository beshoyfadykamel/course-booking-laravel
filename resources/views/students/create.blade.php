@extends('master')
@section('title')
    {{ __('messages.dashboard') }} | {{ __('messages.students_management') }}
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
                        <li class="breadcrumb-item"><a href="#">{{ __('messages.add_student') }}</a></li>
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
                <h5 class="m-0">{{ __('messages.add_new_student') }}</h5>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{ __('messages.student_name') }}</label>
                        <input type="text" class="form-control" id="name"
                            placeholder="{{ __('messages.enter_student_name') }}" name="name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('messages.student_email') }}</label>
                        <input type="email" class="form-control" id="email"
                            placeholder="{{ __('messages.enter_student_email') }}" name="email" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="country_id">{{ __('messages.student_country') }}</label>

                        <select class="form-control" id="country_id" name="country_id">
                            <option value="">{{ __('messages.select_country') }}</option>

                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('country_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('messages.status') }}</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">{{ __('messages.choose_status') }}</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                {{ __('messages.active') }}
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                {{ __('messages.inactive') }}
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">{{ __('messages.image_optional') }}</label>
                        <div class="input-group">
                            <input type="file" class="w-100 form-control" id="exampleInputFile" name="image">
                        </div>
                    </div>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
            // Fallback for custom file input since plugin is missing
            $('.custom-file-input').on('change', function () {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endsection