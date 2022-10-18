<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:6|max:30|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'string', Password::min(6)->mixedCase()->numbers(), 'confirmed']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'password' => 'Password'
        ];
    }
}
