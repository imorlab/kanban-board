<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class TaskCard extends Component
{
    public Task $task;
    public $showEditForm = false;
    public $title;
    public $description;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
    }

    public function toggleEdit()
    {
        $this->showEditForm = !$this->showEditForm;

        if (!$this->showEditForm) {
            // Reset to original values if cancelled
            $this->title = $this->task->title;
            $this->description = $this->task->description;
        }
    }

    public function updateTask()
    {
        $this->validate();

        // Check if user owns the task
        if ($this->task->user_id !== auth()->id()) {
            return;
        }

        $this->task->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->showEditForm = false;
        $this->emit('taskUpdated');

        // Emit SweetAlert notification
        $this->dispatchBrowserEvent('swal:success', [
            'title' => __('front.task_updated_title'),
            'text' => __('front.task_updated_text'),
            'timer' => 2000,
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false
        ]);
    }

    public function render()
    {
        return view('livewire.task-card');
    }
}
