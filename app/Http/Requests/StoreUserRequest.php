<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', Rule::in(['admin', 'user'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => __('validation.name.required'),
            'email.required'    => __('validation.email.required'),
            'email.email'       => __('validation.email.email'),
            'email.unique'      => __('validation.email.unique'),
            'password.required' => __('validation.password.required'),
            'password.confirmed'=> __('validation.password.confirmed'),
            'role.required'     => __('validation.role.required'),
            'role.in'           => __('validation.role.in'),
        ];
    }
}
