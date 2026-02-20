<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Booking;
use Illuminate\Validation\Rule;

class EditBookingRequest extends FormRequest
{
    // Cache the booking so the DB is hit only once
    private ?Booking $resolvedBooking = null;

    private function resolveBooking(): Booking
    {
        if ($this->resolvedBooking === null) {
            $this->resolvedBooking = Booking::findOrFail($this->route('id'));
        }

        return $this->resolvedBooking;
    }

    public function authorize(): bool
    {
        return $this->user()->can('update', $this->resolveBooking());
    }

    public function rules(): array
    {
        $ownerId = $this->resolveBooking()->user_id;

        return [
            'student_id' => [
                'required', 'integer',
                Rule::exists('students', 'id')->where(fn($q) => $q->where('user_id', $ownerId)),
            ],
            'course_id' => [
                'required', 'integer',
                Rule::exists('courses', 'id')->where(fn($q) => $q->where('user_id', $ownerId)),
            ],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {

            if (! $this->student_id || ! $this->course_id) {
                return;
            }

            $exists = Booking::withTrashed()
                ->where('student_id', $this->student_id)
                ->where('course_id', $this->course_id)
                ->where('id', '!=', $this->route('id'))
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
