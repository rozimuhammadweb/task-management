<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class ShowTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewTask', Task::findOrFail($this->route('id'))); // TODO refactoring
    }

    public function rules(): array
    {
        return [];
    }
}
