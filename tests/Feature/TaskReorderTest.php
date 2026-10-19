<?php

use App\Models\Project;
use App\Models\Task;

test('index prompts for a project when none is selected', function () {
    $project = Project::factory()->create(['name' => 'Alpha']);

    $this->get(route('tasks.index'))
        ->assertOk()
        ->assertSee('Select a project')
        ->assertSee('Alpha')
        ->assertDontSee('Drag the handle');
});

test('index shows sortable tasks for the selected project', function () {
    $project = Project::factory()->create(['name' => 'Beta']);
    $task = Task::factory()->for($project)->create([
        'name' => 'First task',
        'priority' => 1,
    ]);
    Task::factory()->create(['name' => 'Other project task']);

    $this->get(route('tasks.index', ['project' => $project->id]))
        ->assertOk()
        ->assertSee('Beta')
        ->assertSee('First task')
        ->assertSee('Drag the handle')
        ->assertDontSee('Other project task')
        ->assertSee('data-project="'.$project->id.'"', false)
        ->assertSee('data-id="'.$task->id.'"', false);
});

test('reorder updates task priorities for a project', function () {
    $project = Project::factory()->create();
    $first = Task::factory()->for($project)->create(['priority' => 1, 'name' => 'One']);
    $second = Task::factory()->for($project)->create(['priority' => 2, 'name' => 'Two']);
    $third = Task::factory()->for($project)->create(['priority' => 3, 'name' => 'Three']);

    $this->postJson(route('tasks.reorder'), [
        'project_id' => $project->id,
        'order' => [$third->id, $first->id, $second->id],
    ])->assertOk()
        ->assertJson(['ok' => true]);

    expect($third->fresh()->priority)->toBe(1)
        ->and($first->fresh()->priority)->toBe(2)
        ->and($second->fresh()->priority)->toBe(3);
});

test('reorder rejects order that mixes tasks from another project', function () {
    $project = Project::factory()->create();
    $ownTask = Task::factory()->for($project)->create(['priority' => 1]);
    $foreignTask = Task::factory()->create(['priority' => 1]);

    $this->postJson(route('tasks.reorder'), [
        'project_id' => $project->id,
        'order' => [$ownTask->id, $foreignTask->id],
    ])->assertUnprocessable()
        ->assertJsonValidationErrors(['order']);
});
