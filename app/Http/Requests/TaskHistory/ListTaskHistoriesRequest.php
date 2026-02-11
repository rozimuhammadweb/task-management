<?php

namespace App\Http\Requests\TaskHistory;

use App\Enums\TaskStatus;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListTaskHistoriesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(TaskPolicy::VIEW_HISTORY);
    }
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'status' => ['sometimes', Rule::in(TaskStatus::values())],
        ];
    }
}
