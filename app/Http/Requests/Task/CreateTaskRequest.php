<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(TaskPolicy::CREATE);
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(TaskStatus::values())],
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'integer|exists:users,id',
            'deadline' => 'nullable|date',
        ];
    }
}
