<?php

namespace App\Livewire\Project;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Livewire\Component;

class Edit extends Component
{

    public Project $project;
    public ProjectForm $form;

    public function mount()
    {
        $this->form->setProject($this->project);
    }

    public function save()
    {

        $this->form->update();
        session()->flash('message', 'Project update successfully.');
        return to_route('projects.index');
    }


    public function render()
    {
        return view('livewire.project.edit');
    }
}
