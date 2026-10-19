<?php

use App\Models\Project;
use App\Models\Task;

test('index lists projects for selection', function () {
    $task = Task::factory()->create(['name' => 'Ship MVP']);

    $this->get(route('tasks.index'))
        ->assertOk()
        ->assertSee($task->project->name)
        ->assertSee('Select a project')
        ->assertDontSee('Ship MVP');
});

test('index displays tasks for the selected project', function () {
    $task = Task::factory()->create(['name' => 'Ship MVP']);

    $this->get(route('tasks.index', ['project' => $task->project_id]))
        ->assertOk()
        ->assertSee('Ship MVP')
        ->assertSee($task->project->name);
});

test('create displays the task form', function () {
    $project = Project::factory()->create();

    $this->get(route('tasks.create'))
        ->assertOk()
        ->assertSee('Create Task')
        ->assertSee($project->name);
});

test('store creates a task with validated data', function () {
    $project = Project::factory()->create();

    $response = $this->post(route('tasks.store'), [
        'project_id' => $project->id,
        'name' => 'Write tests',
        'priority' => 2,
        'description' => 'Cover the task endpoints',
    ]);

    $task = Task::query()->where('name', 'Write tests')->first();

    expect($task)->not->toBeNull()
        ->and($task->project_id)->toBe($project->id)
        ->and($task->priority)->toBe(2);

    $response->assertRedirect(route('tasks.show', $task))
        ->assertSessionHas('success');
});

test('store rejects invalid task data', function () {
    $this->from(route('tasks.create'))
        ->post(route('tasks.store'), [])
        ->assertRedirect(route('tasks.create'))
        ->assertSessionHasErrors(['project_id', 'name', 'priority']);
});

test('show displays a task', function () {
    $task = Task::factory()->create([
        'name' => 'Review pull request',
        'description' => 'Check the form requests',
    ]);

    $this->get(route('tasks.show', $task))
        ->assertOk()
        ->assertSee('Review pull request')
        ->assertSee('Check the form requests');
});

test('update changes a task with validated data', function () {
    $task = Task::factory()->create([
        'name' => 'Old name',
    ]);
    $project = Project::factory()->create();

    $this->put(route('tasks.update', $task), [
        'project_id' => $project->id,
        'name' => 'Updated name',
        'priority' => 5,
        'description' => 'Updated description',
    ])->assertRedirect(route('tasks.show', $task))
        ->assertSessionHas('success');

    $task->refresh();

    expect($task->name)->toBe('Updated name')
        ->and($task->project_id)->toBe($project->id)
        ->and($task->priority)->toBe(5);
});

test('destroy deletes a task', function () {
    $task = Task::factory()->create();

    $this->delete(route('tasks.destroy', $task))
        ->assertRedirect(route('tasks.index', ['project' => $task->project_id]))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});
