<?php

use App\Livewire\Task\Index;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;

test('a project owner can invite users', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $project = Project::factory(['user_id' => $user->id])->create();

    $project->invite($newUser = User::factory()->create());

    $current = Carbon::now();

    Livewire::actingAs($newUser)
        ->test(Index::class, ['project' => $project])
        ->set('form.name', 'New Task')
        ->set('form.project_name', 1)
        ->set('form.deadline', $current->addDays(rand(1, 10)))
        ->set('form.description', 'new task')
        ->call('save');

    $this->assertEquals(1, Task::count());
});