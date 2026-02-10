<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'course_id'  => ['required', 'integer', 'exists:courses,id'],
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

            $exists = \App\Models\Booking::where('student_id', $this->student_id)
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
