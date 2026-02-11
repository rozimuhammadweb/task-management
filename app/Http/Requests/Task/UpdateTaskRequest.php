<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'deadline' => 'nullable|date',

            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'integer|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
