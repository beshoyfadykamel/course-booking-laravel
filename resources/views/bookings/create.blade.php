@extends('master')
@section('title')
    {{ __('messages.dashboard') }} | {{ __('messages.bookings_management') }}
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
                        <li class="breadcrumb-item"><a href="#">{{ __('messages.add_booking') }}</a></li>
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
                <h5 class="m-0">{{ __('messages.add_new_booking') }}</h5>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="course_id">{{ __('messages.select_course') }}</label>
                        <div class="input-group">
                            <select class="form-control" id="course_id" name="course_id">
                                <option value="">{{ __('messages.select_course') }}</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" data-course-id="{{ $course->id }}"
                                        data-course-title="{{ $course->title }}"
                                        data-course-description="{{ $course->description }}"
                                        data-course-status="{{ $course->status }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title . "  (" . $course->id . ")" }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" id="viewCourseBtn">
                                    <i class="fas fa-eye"></i> {{ __('messages.view') }}
                                </button>
                            </div>
                        </div>
                        @error('course_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="student_id">{{ __('messages.select_student') }}</label>
                        <div class="input-group">
                            <select class="form-control" id="student_id" name="student_id">
                                <option value="">{{ __('messages.select_student') }}</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}" data-student-id="{{ $student->id }}"
                                        data-student-name="{{ $student->name }}" data-student-email="{{ $student->email }}"
                                        data-student-image="{{ asset('storage/' . $student->image) }}"
                                        data-student-country="{{ $student->country->name ?? 'N/A' }}"
                                        data-student-status="{{ $student->status }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name . "  (" . $student->id . ")" }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" id="viewStudentBtn">
                                    <i class="fas fa-eye"></i> {{ __('messages.view') }}
                                </button>
                            </div>
                        </div>
                        @error('student_id')
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

    <!-- Student Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">{{ __('messages.student_details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="outline:none;border:none;background:none;box-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="max-height:400px;overflow-y:auto;">
                    <div class="text-center mb-3">
                        <img id="studentImage" src="" alt="Student Image" class="img-thumbnail"
                            style="max-width:200px;height:200px;">
                    </div>

                    <table class="table table-bordered" style="table-layout: fixed;">
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.id') }}:</th>
                            <td id="studentId" style="word-break:break-word;"></td>
                        </tr>
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.name') }}:</th>
                            <td id="studentName" style="word-break:break-word;"></td>
                        </tr>
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.email') }}:</th>
                            <td id="studentEmail" style="word-break:break-word;"></td>
                        </tr>
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.country') }}:</th>
                            <td id="studentCountry" style="word-break:break-word;"></td>
                        </tr>
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.status') }}:</th>
                            <td id="studentStatus" style="word-break:break-word;"></td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Course Modal -->
    <div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="courseModalLabel">{{ __('messages.course_details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="outline:none;border:none;background:none;box-shadow:none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="max-height:400px;overflow-y:auto;">
                    <table class="table table-bordered" style="table-layout: fixed;">
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.id') }}:</th>
                            <td id="courseId" style="word-break:break-word;"></td>
                        </tr>
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.course_title') }}:</th>
                            <td id="courseTitle" style="word-break:break-word;"></td>
                        </tr>
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.description') }}:</th>
                            <td id="courseDescription" style="word-break:break-word;"></td>
                        </tr>
                        <tr>
                            <th style="word-wrap:break-word;">{{ __('messages.status') }}:</th>
                            <td id="courseStatus" style="word-break:break-word;"></td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>

            </div>
        </div>
    </div>



    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Elements (may not exist on every page, so we guard)
                const studentSelect = document.getElementById('student_id');
                const courseSelect = document.getElementById('course_id');
                const viewStudentBtn = document.getElementById('viewStudentBtn');
                const viewCourseBtn = document.getElementById('viewCourseBtn');

                // Helpers
                function setText(id, value) {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.textContent = (value !== undefined && value !== null && value !== '') ? value : 'N/A';
                }

                function setStudentImage(url) {
                    const img = document.getElementById('studentImage');
                    if (!img) return;

                    if (url && url.trim() !== '') {
                        img.src = url;
                        img.style.display = 'block';
                    } else {
                        img.src = '';
                        img.style.display = 'none';
                    }
                }

                function clearStudentUI() {
                    setText('studentId', '');
                    setText('studentName', '');
                    setText('studentEmail', '');
                    setText('studentCountry', '');
                    setText('studentStatus', '');
                    setStudentImage('');
                }

                function clearCourseUI() {
                    setText('courseId', '');
                    setText('courseTitle', '');
                    setText('courseDescription', '');
                    setText('courseStatus', '');
                }

                function fillStudentFromOption(option) {
                    if (!option) return;

                    // IMPORTANT: these map to data-student-id, data-student-name... etc (dashes)
                    setText('studentId', option.dataset.studentId);
                    setText('studentName', option.dataset.studentName);
                    setText('studentEmail', option.dataset.studentEmail);
                    setText('studentCountry', option.dataset.studentCountry);
                    setText('studentStatus', option.dataset.studentStatus);

                    setStudentImage(option.dataset.studentImage || '');
                }

                function fillCourseFromOption(option) {
                    if (!option) return;

                    setText('courseId', option.dataset.courseId);
                    setText('courseTitle', option.dataset.courseTitle);
                    setText('courseDescription', option.dataset.courseDescription);
                    setText('courseStatus', option.dataset.courseStatus);
                }

                // Student select change
                if (studentSelect) {
                    studentSelect.addEventListener('change', function () {
                        if (!this.value) {
                            clearStudentUI();
                            return;
                        }
                        const option = this.options[this.selectedIndex];
                        fillStudentFromOption(option);
                    });
                }

                // Course select change
                if (courseSelect) {
                    courseSelect.addEventListener('change', function () {
                        if (!this.value) {
                            clearCourseUI();
                            return;
                        }
                        const option = this.options[this.selectedIndex];
                        fillCourseFromOption(option);
                    });
                }

                // View Student button
                    if (viewStudentBtn) {
                        viewStudentBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (!studentSelect || !studentSelect.value) {
                                alert('{{ __('messages.please_select_student') }}');
                                return;
                            }
                            const option = studentSelect.options[studentSelect.selectedIndex];
                            fillStudentFromOption(option);
                            if (window.$ && $('#studentModal').modal) {
                                $('#studentModal').modal('show');
                            } else {
                                document.getElementById('studentModal')?.classList.add('show');
                            }
                        });
                    }

                // View Course button
                    if (viewCourseBtn) {
                        viewCourseBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            if (!courseSelect || !courseSelect.value) {
                                alert('{{ __('messages.please_select_course') }}');
                                return;
                            }
                            const option = courseSelect.options[courseSelect.selectedIndex];
                            fillCourseFromOption(option);
                            if (window.$ && $('#courseModal').modal) {
                                $('#courseModal').modal('show');
                            } else {
                                document.getElementById('courseModal')?.classList.add('show');
                            }
                        });
                    }

                // If page loads with pre-selected values, fill UI once
                if (studentSelect && studentSelect.value) {
                    fillStudentFromOption(studentSelect.options[studentSelect.selectedIndex]);
                } else {
                    clearStudentUI();
                }

                if (courseSelect && courseSelect.value) {
                    fillCourseFromOption(courseSelect.options[courseSelect.selectedIndex]);
                } else {
                    clearCourseUI();
                }
            });
        </script>
    @endsection


@endsection