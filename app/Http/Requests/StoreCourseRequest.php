<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3|unique:courses,title',
            'description' => 'required|string|max:1000|min:10',
            'status' => 'required|in:active,inactive',
        ];

        }
        public function messages()
        {
            return [
                'title.required' => 'The course title is required.',
                'title.min' => 'The course title must be at least 3 characters.',
                'title.unique' => 'The course title already exists.',
                'description.required' => 'The course description is required.',
                'description.min' => 'The course description must be at least 10 characters.',
                'status.required' => 'The course status is required.',
                'status.in' => 'The course status must be either active or inactive.',
            ];
        }
}
