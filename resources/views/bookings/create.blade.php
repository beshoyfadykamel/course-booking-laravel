@extends('layouts.master')

@section('title')
    {{ __('messages.add_booking') }}
@endsection

@section('content')
<div x-data="bookingForm()">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.add_new_booking') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('messages.add_new_booking') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <!-- Success Message -->
            @if (session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Course Selection -->
                <div>
                    <x-input-label for="course_id" :value="__('messages.select_course')" />
                    <div class="flex gap-2 mt-1">
                        <select 
                            id="course_id" 
                            name="course_id"
                            @change="fillCourseDetails()"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix @error('course_id') border-red-500 @enderror">
                            <option value="">{{ __('messages.select_course') }}</option>
                            @foreach ($courses as $course)
                                <option 
                                    value="{{ $course->id }}" 
                                    data-course-id="{{ $course->id }}"
                                    data-course-name="{{ $course->title }}"
                                    data-course-description="{{ $course->description }}"
                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }} ({{ $course->id }})
                                </option>
                            @endforeach
                        </select>
                        <button 
                            type="button" 
                            @click="openCourseModal()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('course_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Student Selection -->
                <div>
                    <x-input-label for="student_id" :value="__('messages.select_student')" />
                    <div class="flex gap-2 mt-1">
                        <select 
                            id="student_id" 
                            name="student_id"
                            @change="fillStudentDetails()"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix @error('student_id') border-red-500 @enderror">
                            <option value="">{{ __('messages.select_student') }}</option>
                            @foreach ($students as $student)
                                <option 
                                    value="{{ $student->id }}" 
                                    data-student-id="{{ $student->id }}"
                                    data-student-name="{{ $student->name }}"
                                    data-student-email="{{ $student->email }}"
                                    data-student-image="{{ asset('storage/' . $student->image) }}"
                                    data-student-country="{{ $student->country->name ?? 'N/A' }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->id }})
                                </option>
                            @endforeach
                        </select>
                        <button 
                            type="button" 
                            @click="openStudentModal()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('student_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Field -->
                <div>
                    <x-input-label for="status" :value="__('messages.status')" />
                    <select 
                        id="status" 
                        name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 select-rtl-fix @error('status') border-red-500 @enderror">
                        <option value="">{{ __('messages.choose_status') }}</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                            {{ __('messages.active') }}
                        </option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                            {{ __('messages.inactive') }}
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <x-primary-button type="submit" class="flex-1">
                        <i class="fas fa-save me-2"></i>{{ __('messages.submit') }}
                    </x-primary-button>
                    <x-secondary-button type="button" onclick="window.history.back()" class="flex-1">
                        <i class="fas fa-times me-2"></i>{{ __('messages.cancel') }}
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Student Details Modal -->
    <div 
        x-show="showStudentModal" 
        x-transition 
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center"
        style="display: none;">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50" @click="showStudentModal = false"></div>
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full h-auto m-4 z-10">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.student_details') }}</h3>
                <button @click="showStudentModal = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-6 py-4 max-h-96 overflow-y-auto space-y-3">
                <div class="text-center mb-4">
                    <img id="studentImage" src="" alt="Student"
                        class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-gray-300" x-show="studentImage">
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="font-medium text-gray-600">{{ __('messages.id') }}:</span><span id="studentId">-</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">{{ __('messages.name') }}:</span><span id="studentName">-</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">{{ __('messages.email') }}:</span><span id="studentEmail">-</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">{{ __('messages.country') }}:</span><span id="studentCountry">-</span></div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button @click="showStudentModal = false" class="px-4 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400">
                    {{ __('messages.close') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Course Details Modal -->
    <div 
        x-show="showCourseModal" 
        x-transition 
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center"
        style="display: none;">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50" @click="showCourseModal = false"></div>
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full h-auto m-4 z-10">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.course_details') }}</h3>
                <button @click="showCourseModal = false" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="px-6 py-4 max-h-96 overflow-y-auto space-y-3">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="font-medium text-gray-600">{{ __('messages.id') }}:</span><span id="courseId">-</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">{{ __('messages.name') }}:</span><span id="courseName">-</span></div>
                    <div class="flex justify-between"><span class="font-medium text-gray-600">{{ __('messages.description') }}:</span><span id="courseDescription">-</span></div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button @click="showCourseModal = false" class="px-4 py-2 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400">
                    {{ __('messages.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        function bookingForm() {
            return {
                showStudentModal: false,
                showCourseModal: false,
                studentImage: false,
                
                openStudentModal() {
                    const select = document.getElementById('student_id');
                    if (!select || !select.value) {
                        alert('{{ __('messages.please_select_student') }}');
                        return;
                    }
                    this.fillStudentDetails();
                    this.showStudentModal = true;
                },
                
                openCourseModal() {
                    const select = document.getElementById('course_id');
                    if (!select || !select.value) {
                        alert('{{ __('messages.please_select_course') }}');
                        return;
                    }
                    this.fillCourseDetails();
                    this.showCourseModal = true;
                },
                
                fillStudentDetails() {
                    const select = document.getElementById('student_id');
                    if (!select || !select.value) return;
                    
                    const option = select.options[select.selectedIndex];
                    if (!option) return;
                    
                    // تحديث البيانات النصية بشكل آمن
                    const studentIdEl = document.getElementById('studentId');
                    const studentNameEl = document.getElementById('studentName');
                    const studentEmailEl = document.getElementById('studentEmail');
                    const studentCountryEl = document.getElementById('studentCountry');
                    const studentImageEl = document.getElementById('studentImage');
                    
                    if (studentIdEl) studentIdEl.textContent = option.dataset.studentId || '-';
                    if (studentNameEl) studentNameEl.textContent = option.dataset.studentName || '-';
                    if (studentEmailEl) studentEmailEl.textContent = option.dataset.studentEmail || '-';
                    if (studentCountryEl) studentCountryEl.textContent = option.dataset.studentCountry || '-';
                    
                    // تحديث الصورة إذا كانت موجودة
                    if (studentImageEl && option.dataset.studentImage) {
                        studentImageEl.src = option.dataset.studentImage;
                        this.studentImage = true;
                    } else {
                        this.studentImage = false;
                    }
                },
                
                fillCourseDetails() {
                    const select = document.getElementById('course_id');
                    if (!select || !select.value) return;
                    
                    const option = select.options[select.selectedIndex];
                    if (!option) return;
                    
                    // تحديث البيانات النصية بشكل آمن
                    const courseIdEl = document.getElementById('courseId');
                    const courseNameEl = document.getElementById('courseName');
                    const courseDescEl = document.getElementById('courseDescription');
                    
                    if (courseIdEl) courseIdEl.textContent = option.dataset.courseId || '-';
                    if (courseNameEl) courseNameEl.textContent = option.dataset.courseName || '-';
                    if (courseDescEl) courseDescEl.textContent = option.dataset.courseDescription || '-';
                }
            };
        }
    </script>
@endsection