<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => 'required|min:3|max:30|string',
            'status' => 'required',
            'member' => 'max:255',
            'contents' => 'required|min:2'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Project Name',
            'status' => 'Status',
            'contents' => 'Project Description'
        ];
    }
}
