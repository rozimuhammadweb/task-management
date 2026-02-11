<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(TaskStatus::cases())],
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'integer|exists:users,id',
            'deadline' => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
