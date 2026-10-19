<x-layouts.app :title="$task->name">
    <div class="show-header">
        <div>
            <p class="muted" style="margin: 0;">{{ $task->project->name }}</p>
            <h1 style="margin-top: 0.25rem; font-size: 1.5rem;">{{ $task->name }}</h1>
        </div>
        <div class="actions">
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-secondary">Edit</a>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>

    <dl>
        <div>
            <dt>Priority</dt>
            <dd>{{ $task->priority }}</dd>
        </div>
        <div>
            <dt>Description</dt>
            <dd>{{ $task->description ?: '—' }}</dd>
        </div>
    </dl>
</x-layouts.app>
