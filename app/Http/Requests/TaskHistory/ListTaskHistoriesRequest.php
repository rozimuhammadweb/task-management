<?php

namespace App\Http\Requests\TaskHistory;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListTaskHistoriesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'status' => ['nullable', Rule::enum(TaskStatus::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
