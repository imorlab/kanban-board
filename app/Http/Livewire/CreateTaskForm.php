<?php

namespace App\Http\Livewire;

use App\Enums\TaskStatus;
use App\Models\Task;
use Livewire\Component;

class CreateTaskForm extends Component
{
    public $title = '';
    public $description = '';
    public $status = 'pending';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'status' => 'required|in:pending,in_progress,completed',
    ];

    public function mount()
    {
        $this->status = TaskStatus::PENDING->value;
    }

    public function createTask()
    {
        $this->validate();

        $user = auth()->user();
        
        // Get the next sort order for the selected status
        $maxOrder = $user->tasks()
            ->where('status', $this->status)
            ->max('sort_order') ?? 0;

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'sort_order' => $maxOrder + 1,
            'user_id' => $user->id,
        ]);

        // Reset form
        $this->reset(['title', 'description']);
        $this->status = TaskStatus::PENDING->value;

        // Emit event to refresh parent component
        $this->emit('taskCreated');

        session()->flash('message', 'Tarea creada correctamente.');
    }

    public function render()
    {
        return view('livewire.create-task-form');
    }
}
