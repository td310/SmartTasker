<?php

namespace App\Livewire\Task;

use App\Livewire\Forms\TaskForm;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public Collection $tasks;
    public Project $project;
    public Task $task;
    public bool $showModal = false;
    public bool $editMode = false;
    public TaskForm $form;

    public function mount()
    {
        $this->form->setProjectId($this->project);
    }

    public function edit($taskId)
    {

        $this->task = Task::where('id', $taskId)->first();
        $this->form->setTask($this->task);
        $this->showModal = true;
        $this->editMode = true;
    }

    public function openModal($project)
    {
        $this->reset('editMode', 'showModal');

        $this->form->project_name = $project['id'];
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->form->update();
            session()->flash('message', 'Task update successfully.');
        } else {
            $this->form->store();
            session()->flash('message', 'Task added successfully.');
        }

        $this->reset('editMode', 'showModal');
    }

    public function delete($id)
    {
        $task = Task::where('id', $id)->firstOrFail();
        if (auth()->id() != $task->user_id) {
            abort(401);
        }

        $task->delete();

        session()->flash('message', 'Task delete successfully.');
    }

    public function updateOrder($list): void
    {
        foreach ($list as $item) {

            $task = $this->tasks->firstWhere('id', $item['value']);

            if ($task->priority != $item['order']) {
                Task::where(['id' => $item['value']])->update(['priority' => $item['order']]);
            }
        }
    }
    #[On('resetModal')]
    public function resetModal(): void
    {
        $this->reset('editMode', 'showModal');
    }

    public function render()
    {

        $this->tasks = Task::where(['user_id' => auth()->id(), 'project_id' =>  $this->project->id])->orderBy('priority')->get();

        return view('livewire.task.index');
    }
}