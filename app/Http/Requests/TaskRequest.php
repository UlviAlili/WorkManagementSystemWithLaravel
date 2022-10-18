<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'title' => 'required|min:3|max:30',
            'project' => 'required',
            'member' => 'max:255',
            'contents' => 'required|min:3|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Task Name',
            'status' => 'Status',
            'project' => 'Project Name',
            'member' => 'Task Member',
            'contents' => 'Task Description'
        ];
    }
}
