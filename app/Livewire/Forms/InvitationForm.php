<?php

namespace App\Livewire\Forms;

use App\Models\Project;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;

class InvitationForm extends Form
{
    public ?Project $project;
    public $email = '';
    public $project_id = '';

    public function rules()
    {
        return [
            'email' => ['required', Rule::exists('users', 'email')],

        ];
    }

    public function setProject(Project $project)
    {
        $this->project = $project;
        $this->project_id = $project->id;
    }


    public function store()
    {

        if (auth()->id() != $this->project->user_id) {
            abort(401);
        }
        $this->validate();
        $user = User::whereEmail($this->email)->first();
        $this->project->invite($user);

        $this->reset('email', 'project_id');
    }
}