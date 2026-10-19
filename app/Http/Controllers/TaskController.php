<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReorderTasksRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $projects = Project::query()->orderBy('name')->get();
        $selectedProject = null;
        $tasks = collect();

        if ($request->filled('project')) {
            $selectedProject = Project::query()->findOrFail($request->integer('project'));
            $tasks = $selectedProject->tasks()->orderBy('priority')->get();
        }

        return view('tasks.index', [
            'projects' => $projects,
            'selectedProject' => $selectedProject,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tasks.create', [
            'projects' => Project::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = Task::query()->create($request->validated());

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): View
    {
        $task->load('project');

        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task' => $task,
            'projects' => Project::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()
            ->route('tasks.index', ['project' => $task->project_id])
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Persist a new priority order for a project's tasks.
     */
    public function reorder(ReorderTasksRequest $request): JsonResponse
    {
        $projectId = $request->integer('project_id');
        /** @var list<int|string> $order */
        $order = $request->validated('order');

        DB::transaction(function () use ($projectId, $order): void {
            foreach ($order as $index => $taskId) {
                Task::query()
                    ->whereKey($taskId)
                    ->where('project_id', $projectId)
                    ->update(['priority' => $index + 1]);
            }
        });

        return response()->json(['ok' => true]);
    }
}
