<?php

namespace App\Livewire\Project;

use App\Livewire\Forms\ProjectForm;
use Livewire\Component;

class Create extends Component
{

    public ProjectForm $form;

    public function save()
    {
        $result = $this->form->store();
    
        if (!$result) {
            return;
        }
    
        session()->flash('message', 'Project added successfully.');
        return to_route('projects.index');
    }
    
    
    
    public function render()
    {
        return view('livewire.project.create');
    }
}
