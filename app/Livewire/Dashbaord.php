<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Collection;

class Dashbaord extends Component
{
    public Collection  $tasks;
    public  $project_name;

    public function showTask($project_id)
    {
    }

    public function updatedProjectName(): void
    {
        $this->tasks = Task::with('project')->where([
            'user_id' => auth()->id(),
            'project_id' => $this->project_name,
        ])
            ->orderBy('priority')
            ->get();

        // dd($this->tasks);
    }

    public function render()
    {
        $totalProjects = auth()->user()->accessibleProjects()->count();
        $totalTasks = Task::where('user_id', auth()->id())->count();
        $projects = auth()->user()->accessibleProjects();

        return view('livewire.dashbaord', compact('totalProjects', 'totalTasks', 'projects'));
    }
}