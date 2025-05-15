<?php

namespace App\Livewire\Forms;

use App\Enums\StatusType;
use App\Models\Task;
use App\Models\Project;
use App\Services\Flash;
use App\Services\ChronoService;
use Illuminate\Support\Str;
use Livewire\Form;

class TaskForm extends Form
{
    public ?Task $task;

    public $name = '';
    public $project_name = '';
    public $slug = '';
    public $deadline = '';
    public $status = '';
    public $priority = 'low';
    public $description = '';
    public $errorMessage = '';

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],
            'priority' => ['required', 'in:low,medium,high'],
            'description' => ['nullable'],
        ];
    }

    public function setProjectId($project)
    {
        $this->project_name = $project->id;
    }

    public function setTask(Task $task)
    {
        $this->task = $task;
        $this->name = $task->name;
        $this->project_name = $task->project_id;
        $this->status = $task->status;
        $this->priority = $task->priority;
        $this->description = $task->description;
        $this->deadline = $task->deadline->format('Y-m-d');
    }

    public function store()
    {
        $this->validate();
    
        $isValidTask = $this->checkTaskValidity($this->name, $this->project_name);
    
        if (!$isValidTask) {
            $this->errorMessage = 'This task does not belong to the project.';
            return;
        }
    
        $project = Project::find($this->project_name);
    
        $predictedPriority = $this->predictPriority(
            $this->name,
            $this->description,
            $project->name,
            $project->description,
            $this->deadline
        );
    
        if (!$predictedPriority) {
            $this->errorMessage = 'Unable to determine task priority. Please check the task details for completeness or clarity.';
            return;
        }
    
        $this->priority = $predictedPriority;
    
        $chrono = new ChronoService();
        $code = $chrono->generateCode(new Task());
    
        Task::create([
            'user_id' => auth()->id(),
            'slug' => Str::slug($this->name) . time(),
            'code' => $code,
            'name' => $this->name,
            'project_id' => $this->project_name,
            'priority' => $this->priority,
            'status' => StatusType::STARTED->value,
            'deadline' => $this->deadline,
            'description' => $this->description,
        ]);
    
        $this->reset();
    }
    
    public function update()
    {
        $this->validate();
        if (auth()->id() != $this->task->user_id) {
            abort(401);
        }

        $project = Project::find($this->task->project_id);
        $predictedPriority = $this->predictPriority(
            $this->name,
            $this->description,
            $project->name,
            $project->description,
            $this->deadline
        );
        $this->priority = $predictedPriority ?? $this->task->priority;

        $this->task->update([
            'slug' => Str::slug($this->name) . time(),
            'name' => $this->name,
            'project_id' => $this->project_name,
            'status' => $this->status,
            'priority' => $this->priority,
            'deadline' => $this->deadline,
            'description' => $this->description,
        ]);

        $this->reset();
    }


    private function checkTaskValidity($taskName, $projectId)
    {
        $project = Project::find($projectId);
        if (!$project) {
            return false;
        }
        $flashModel = new Flash();
        $isValid = $flashModel->validateTaskForProject($taskName, $project);
        return $isValid;
    }

    private function predictPriority($taskName, $description)
    {
        $project = Project::find($this->project_name);
        return (new Flash())->predictPriority(
            $taskName,
            $description,
            $project->name,
            $project->description,
            $this->deadline
        );
    }
}
