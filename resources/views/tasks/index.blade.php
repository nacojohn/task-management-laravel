<x-layouts.app :title="$selectedProject ? $selectedProject->name.' Tasks' : 'Projects'">
    <h1>{{ $selectedProject ? $selectedProject->name : 'Projects' }}</h1>

    <form method="GET" action="{{ route('tasks.index') }}" class="project-picker stack" style="margin-bottom: 1.5rem;">
        <div>
            <label for="project">Select a project</label>
            <div class="actions" style="align-items: center;">
                <select id="project" name="project" required style="max-width: 24rem;">
                    <option value="">Choose a project…</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected((string) old('project', $selectedProject?->id) === (string) $project->id)>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">View tasks</button>
            </div>
        </div>
    </form>

    @if ($selectedProject)
        @if ($tasks->isEmpty())
            <p class="muted">No tasks in this project yet. <a href="{{ route('tasks.create') }}">Create one</a>.</p>
        @else
            <p class="muted" style="margin-bottom: 1rem;">Drag the handle to rearrange priority.</p>

            <ul id="task-list" class="list-group" data-project="{{ $selectedProject->id }}">
                @foreach ($tasks as $task)
                    <li class="list-group-item d-flex align-items-center" data-id="{{ $task->id }}">
                        <span class="handle me-3" style="cursor:grab">⠿</span>
                        <span class="badge bg-secondary me-3 priority">{{ $task->priority }}</span>
                        <a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a>
                    </li>
                @endforeach
            </ul>

            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
            <script>
                const list = document.getElementById('task-list');
                Sortable.create(list, {
                    handle: '.handle',
                    animation: 150,
                    onEnd: () => {
                        const order = [...list.children].map(li => li.dataset.id);
                        fetch('{{ route('tasks.reorder') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ project_id: Number(list.dataset.project), order }),
                        }).then((response) => {
                            if (!response.ok) {
                                throw new Error('Unable to save order');
                            }

                            list.querySelectorAll('.priority').forEach((b, i) => b.textContent = i + 1);
                        }).catch(() => {
                            window.location.reload();
                        });
                    },
                });
            </script>
        @endif
    @elseif ($projects->isEmpty())
        <p class="muted">No projects yet. Seed projects or create them first.</p>
    @else
        <p class="muted">Select a project to view and rearrange its tasks.</p>
    @endif
</x-layouts.app>
