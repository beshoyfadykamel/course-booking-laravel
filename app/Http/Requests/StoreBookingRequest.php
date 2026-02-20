<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isAdmin = Auth::user()->isAdmin();

        return [
            'student_id' => ['required', 'integer', Rule::exists('students', 'id')->where(fn($q) => $q->where('user_id', Auth::id())),],
            'course_id'  => ['required', 'integer', Rule::exists('courses', 'id')->where(fn($q) => $q->where('user_id', Auth::id())),],
            'status'     => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    /**
     * Custom validator for (student_id + course_id) pair.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {

            if (! $this->student_id || ! $this->course_id) {
                return;
            }

            $exists = Booking::where('student_id', $this->student_id)
                ->where('course_id', $this->course_id)
                ->whereNull('deleted_at')
                ->exists();

            if ($exists) {
                // ربط الرسالة بحقل الطالب
                $validator->errors()->add(
                    'student_id',
                    __('validation.student_id.duplicate_enrollment')
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'student_id.required' => __('validation.student_id.required'),
            'student_id.exists'   => __('validation.student_id.exists'),

            'course_id.required' => __('validation.course_id.required'),
            'course_id.exists'   => __('validation.course_id.exists'),

            'status.required' => __('validation.status.required'),
            'status.in'       => __('validation.status.in'),
        ];
    }
}
