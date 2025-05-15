<?php

use App\Models\Project;
use App\Models\User;

// test('guests cannot manage projects', function () {
//     $project = Project::factory()->create();

//     $this->get('/projects')->assertRedirect('login');
//     $this->get('/projects/create')->assertRedirect('login');
//     $this->get($project->path() . '/edit')->assertRedirect('login');
//     $this->get($project->path())->assertRedirect('login');
//     $this->post('/projects', $project->toArray())->assertRedirect('login');
// });
test('a user can see all projects they have been invited to on their dashboard', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    $project = tap(Project::factory(['user_id' => $user->id])->create())->invite(User::factory()->create());

    $this->get('/projects')
        ->assertSee($project->title);
});