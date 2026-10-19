<x-layouts.app :title="'Edit Task'">
    <h1>Edit Task</h1>

    <form method="POST" action="{{ route('tasks.update', $task) }}" class="stack">
        @csrf
        @method('PUT')
        @include('tasks._form', ['task' => $task, 'projects' => $projects])

        <div class="actions">
            <button type="submit" class="btn btn-primary">Update Task</button>
            <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</x-layouts.app>
