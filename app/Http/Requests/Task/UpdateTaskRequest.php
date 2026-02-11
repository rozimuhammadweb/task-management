<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(TaskPolicy::UPDATE);
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'nullable',
            'status' => ['sometimes', Rule::in(TaskStatus::values())],
            'deadline' => 'nullable|date',
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'integer|exists:users,id',
        ];
    }
}
