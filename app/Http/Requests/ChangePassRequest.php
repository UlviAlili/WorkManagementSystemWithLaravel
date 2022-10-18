<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePassRequest extends FormRequest
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
            'password' => ['required', 'string', Password::min(6)->mixedCase()->numbers(), 'confirmed'],
            'oldPassword' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'oldPassword' => 'Old Password',
            'password' => 'New Password'
        ];
    }
}
