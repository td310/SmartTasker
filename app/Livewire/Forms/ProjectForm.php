<?php

namespace App\Livewire\Forms;

use App\Models\Project;
use App\Services\ChronoService;
use Illuminate\Support\Str;
use Livewire\Form;
use App\Services\Flash;
use Illuminate\Support\Facades\Log;

class ProjectForm extends Form
{
    public ?Project $project;
    public $name = '';
    public $description = '';
    public $slug = '';

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string',],
        ];
    }

    public function setProject(Project $project)
    {
        $this->project = $project;

        $this->name = $project->name;
        $this->description = $project->description;
        $this->slug = $project->slug;
    }

    public function store()
    {
        $this->validate();
    
        $flash = new Flash();
        $isIT = $flash->isITProject($this->name, $this->description);
        Log::info('ProjectForm::store isITProject result', [
            'title' => $this->name,
            'description' => $this->description,
            'isIT' => $isIT
        ]);
    
        if (!$isIT) {
            $this->addError('name', 'This project is not related to the Information Technology (IT) field.');
            return false;
        }
    
        $chrono = new ChronoService();
        $code = $chrono->generateCode(new Project());
    
        Project::create([
            'user_id' => auth()->id(),
            'slug' => Str::slug($this->name) . time(),
            'name' => $this->name,
            'code' => $code,
            'description' => $this->description,
        ]);
    
        $this->reset();
        return true;
    }
    
    public function update()
    {
        $this->validate();
        $flash = new Flash();
        $isIT = $flash->isITProject($this->name, $this->description);
        
        Log::info('ProjectForm::update isITProject result', [
            'title' => $this->name,
            'description' => $this->description,
            'isIT' => $isIT
        ]);
    
        if (!$isIT) {
            $this->addError('name', 'This project is not related to the Information Technology (IT) field.');
            return;
        }
    
        if (auth()->id() != $this->project->user_id) {
            abort(401);
        }
    
        $this->project->update([
            'slug' => Str::slug($this->name) . time(),
            'name' => $this->name,
            'description' => $this->description,
        ]);
    
        $this->reset();
    }
    
}
