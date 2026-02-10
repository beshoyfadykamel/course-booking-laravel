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
            'title.required' => __('validation.title.required'),
            'title.string' => __('validation.title.string'),
            'title.max' => __('validation.title.max'),
            'title.min' => __('validation.title.min'),
            'title.unique' => __('validation.title.unique'),
            'description.required' => __('validation.description.required'),
            'description.string' => __('validation.description.string'),
            'description.max' => __('validation.description.max'),
            'description.min' => __('validation.description.min'),
            'status.required' => __('validation.status.required'),
            'status.in' => __('validation.status.in'),
        ];
    }
}
