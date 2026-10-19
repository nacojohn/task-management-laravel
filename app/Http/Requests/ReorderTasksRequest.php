<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ReorderTasksRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'order' => ['required', 'list', 'min:1'],
            'order.*' => ['integer', 'distinct', 'exists:tasks,id'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->hasAny(['project_id', 'order'])) {
                    return;
                }

                $projectId = $this->integer('project_id');
                $order = collect($this->input('order', []))
                    ->map(fn (mixed $id): int => (int) $id)
                    ->values();

                $projectTaskIds = Task::query()
                    ->where('project_id', $projectId)
                    ->pluck('id')
                    ->map(fn (mixed $id): int => (int) $id)
                    ->sort()
                    ->values();

                if ($order->sort()->values()->all() !== $projectTaskIds->all()) {
                    $validator->errors()->add(
                        'order',
                        'The order must include every task for this project.',
                    );
                }
            },
        ];
    }
}
