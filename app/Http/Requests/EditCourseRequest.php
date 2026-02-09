<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCourseRequest extends FormRequest
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
            'title' => 'required|string|max:255|min:3|unique:courses,title,' . $this->route('id'),
            'description' => 'required|string|max:1000|min:10',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The course title is required.',
            'title.string' => 'The course title must be a string.',
            'title.max' => 'The course title may not be greater than 255 characters.',
            'title.min' => 'The course title must be at least 3 characters.',
            'title.unique' => 'The course title has already been taken.',
            'description.required' => 'The course description is required.',
            'description.string' => 'The course description must be a string.',
            'description.max' => 'The course description may not be greater than 1000 characters.',
            'description.min' => 'The course description must be at least 10 characters.',
            'status.required' => 'The course status is required.',
            'status.in' => 'The selected status is invalid. Allowed values are active or inactive.',
        ];
    }
}
