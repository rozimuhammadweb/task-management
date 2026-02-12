<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ($task = Task::find($this->route('id'))) && $this->user()->can('createComment', $task); // TODO refactoring
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:1000',
        ];
    }
}
