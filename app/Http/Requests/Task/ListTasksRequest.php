<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListTasksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(TaskPolicy::VIEW);
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'status' => ['nullable', Rule::in(TaskStatus::values())],
            'per_page' => 'integer|min:1|max:100',
        ];
    }
}
