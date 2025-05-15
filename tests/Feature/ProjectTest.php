<?php

use App\Livewire\Forms\ProjectForm;
use App\Livewire\Project\Create;
use App\Livewire\Project\Edit;
use App\Livewire\Project\Index;
use App\Livewire\Task\Index as TaskIndex;
use App\Models\Project;
use App\Models\User;
use Livewire\Livewire;

test('index project screen can be rendered with the Index Component', function () {
    $this->actingAs($user = User::factory()->create());

    $response = $this->get('/projects');
    $response->assertSeeLivewire(Index::class);
    $response->assertStatus(200);
});

test('create project screen can be rendered with the create component', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/projects/create');
    $response->assertSeeLivewire(Create::class);
    $response->assertStatus(200);
});

test('edit project screen can be rendered with the edit component', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $project = Project::factory(['user_id' => $user->id])->create();

    $response = $this->get('/projects/' . $project->id . '/edit');
    $response->assertSeeLivewire(Edit::class, ['project' => $project]);
    $response->assertStatus(200);
});


test('all field are required', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('form.name', '')
        ->set('form.description', '')
        ->call('save')
        ->assertHasErrors('form.name');
});

test('redirected to all project after creating a project', function () {
    $this->actingAs($user = User::factory()->create());
    $this->assertEquals(0, Project::count());

    Livewire::test(Create::class)
        ->set('form.name', 'New Project')
        ->set('form.description', 'Living the lavender description')
        ->call('save')
        ->assertRedirect('/projects');

    $this->assertEquals(1, Project::count());
});

test('redirected to all project after Editing a project', function () {
    $user = User::factory()->create();
    $project = Project::factory(['user_id' => $user->id])->create();

    Livewire::actingAs($user)
        ->test(Edit::class, ['project' => $project])
        ->set('form.name', 'Living the lavender life')
        ->set('form.description', 'Living the lavender description')
        ->call('save')
        ->assertRedirect('/projects');
});

test('cannot Edit  someone project', function () {
    $user = User::factory()->create();
    $stranger = User::factory()->create();
    $project = Project::factory()->for($stranger)->create();

    Livewire::actingAs($user)
        ->test(Edit::class, ['project' => $project])
        ->set('form.name', 'Living the lavender life')
        ->set('form.description', 'Living the lavender description')
        ->call('save')
        ->assertUnauthorized();
});

test('can delete project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test(Index::class)
        ->call('delete', $project->id)
        ->assertStatus(200);
});

test('cannot delete  someone project', function () {
    $user = User::factory()->create();
    $stranger = User::factory()->create();
    $project = Project::factory()->for($stranger)->create();

    Livewire::actingAs($user)
        ->test(Index::class)
        ->call('delete', $project->id)
        ->assertUnauthorized();
});

test('can view single project detail', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $project = Project::factory(['user_id' => $user->id])->create();

    $response = $this->get('/projects/' . $project->id);
    $response->assertSeeLivewire(TaskIndex::class, ['project' => $project]);
    $response->assertStatus(200);
});

test('can invite a user', function () {

    $this->actingAs($user = User::factory()->create());
    $project = Project::factory(['user_id' => $user->id])->create();

    $project->invite($newUser = User::factory()->create());

    $this->assertTrue($project->members->contains($newUser));
});