<div>
    <label for="project_id">Project</label>
    <select id="project_id" name="project_id" required>
        <option value="">Select a project</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}" @selected(old('project_id', $task?->project_id) == $project->id)>
                {{ $project->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label for="name">Name</label>
    <input id="name" name="name" type="text" required value="{{ old('name', $task?->name) }}">
</div>

<div>
    <label for="priority">Priority</label>
    <input id="priority" name="priority" type="number" min="1" required value="{{ old('priority', $task?->priority ?? 1) }}">
</div>

<div>
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4">{{ old('description', $task?->description) }}</textarea>
</div>
