<x-layouts.app :title="'Create Task'">
    <h1>Create Task</h1>

    <form method="POST" action="{{ route('tasks.store') }}" class="stack">
        @csrf
        @include('tasks._form', ['task' => null, 'projects' => $projects])

        <div class="actions">
            <button type="submit" class="btn btn-primary">Create Task</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</x-layouts.app>
