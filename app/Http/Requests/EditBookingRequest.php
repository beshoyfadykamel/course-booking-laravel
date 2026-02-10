<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Booking;

class EditBookingRequest extends FormRequest
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
            'status'     => ['required', 'in:active,inactive'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {

            if (! $this->student_id || ! $this->course_id) {
                return;
            }

            $bookingId = $this->route('id');

            $exists = Booking::withTrashed()
                ->where('student_id', $this->student_id)
                ->where('course_id', $this->course_id)
                ->where('id', '!=', $bookingId)     
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'student_id',
                    __('validation.student_id.duplicate_enrollment_trash')
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
