<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelectRequest extends FormRequest
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
            'project' => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
          'project' => 'Project Name'
        ];
    }
}
