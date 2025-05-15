<?php

use App\Enums\StatusType;
use App\Livewire\Forms\ProjectForm;
use App\Livewire\Forms\TaskForm;
use App\Livewire\Task\Create;
use App\Livewire\Task\Edit;
use App\Livewire\Task\Index;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;


test('all field are required', function () {
    $user = User::factory()->create();
    $project = Project::factory(['user_id' => $user->id])->create();

    Livewire::actingAs($user)
        ->test(Index::class, ['project' => $project])
        ->set('form.name', '')
        ->set('form.deadline', '')
        ->call('save')
        ->assertHasErrors('form.name')
        ->assertHasErrors('form.deadline');
});

test('close the modal task after creating a task', function () {
    $this->actingAs($user = User::factory()->create());
    $this->assertEquals(0, Task::count());
    $current = Carbon::now();
    $project = Project::factory(['user_id' => $user->id])->create();

    Livewire::test(Index::class, ['project' => $project])
        ->set('form.name', 'New Task')
        ->set('form.project_name', 1)
        ->set('form.deadline', $current->addDays(rand(1, 10)))
        ->set('form.description', 'new task')
        ->call('save');

    $this->assertEquals(1, Task::count());
});

test('close modal task after Editing a task', function () {
    $user = User::factory()->create();
    $project = Project::factory(['user_id' => $user->id])->create();
    $task = Task::factory(['user_id' => $user->id, 'project_id' => $project->id])->create();
    $current = Carbon::now();

    Livewire::actingAs($user)
        ->test(Index::class, ['task' => $task, 'project' => $project])
        ->set('form.name', 'New Task')
        ->set('form.project_name', 1)
        ->set('form.status', StatusType::STARTED->value)
        ->set('form.deadline', $current->addDays(rand(1, 10)))
        ->set('form.description', 'new task')
        ->call('save')
        ->assertSee('New Task', $task->name);
});

test('cannot Edit  someone task', function () {
    $user = User::factory()->create();
    $stranger = User::factory()->create();
    $project = Project::factory(['user_id' => $user->id])->create();
    $task = Task::factory(['project_id' => $project->id])->for($stranger)->create();
    $current = Carbon::now();

    Livewire::actingAs($user)
        ->test(Index::class, ['task' => $task, 'project' => $project, 'editMode' => true])
        ->set('form.name', 'New Task')
        ->set('form.deadline', $current->addDays(rand(1, 10)))
        ->set('form.description', 'new task')
        ->call('edit', ['task' => $task->id,])
        ->call('save')
        ->assertUnauthorized();
});

test('can delete project', function () {
    $user = User::factory()->create();
    $project = Project::factory(['user_id' => $user->id])->create();
    $task = Task::factory(['project_id' => $project->id])->for($user)->create();

    Livewire::actingAs($user)
        ->test(Index::class, ['project' => $project])
        ->call('delete', $task->id)
        ->assertStatus(200);
});

test('cannot delete  someone project', function () {
    $user = User::factory()->create();
    $stranger = User::factory()->create();

    $project = Project::factory(['user_id' => $stranger->id])->create();
    $task = Task::factory(['project_id' => $project->id])->for($stranger)->create();

    Livewire::actingAs($user)
        ->test(Index::class, ['project' => $project])
        ->call('delete', $task->id)
        ->assertUnauthorized();
});
