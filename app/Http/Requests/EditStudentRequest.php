<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditStudentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $this->route('id'),
            'country_id' => 'required|exists:countries,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'The student name is required.',
            'email.required' => 'The student email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken by another student.',
            'country_id.required' => 'Please select a country.',
            'country_id.exists' => 'The selected country is invalid.',
            'status.required' => 'Please select a status.',
            'status.in' => 'The status must be either active or inactive.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
