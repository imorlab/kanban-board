<?php

namespace App\Http\Livewire;

use App\Enums\TaskStatus;
use App\Models\Task;
use Livewire\Component;

class KanbanBoard extends Component
{
    public $showCreateForm = false;

    protected $listeners = [
        'taskCreated' => 'refreshTasks',
        'taskUpdated' => 'refreshTasks',
        'taskMoved' => 'handleTaskMoved',
    ];

    public function mount()
    {
        // Initialize component
    }

    public function refreshTasks()
    {
        // This method will trigger a re-render
        $this->emit('tasksRefreshed');
    }

    public function handleTaskMoved($taskId, $newStatus, $newOrder)
    {
        $task = Task::findOrFail($taskId);
        
        // Check if user owns the task
        if ($task->user_id !== auth()->id()) {
            return;
        }

        $task->update([
            'status' => $newStatus,
            'sort_order' => $newOrder,
        ]);

        $this->refreshTasks();
    }

    public function toggleCreateForm()
    {
        $this->showCreateForm = !$this->showCreateForm;
    }

    public function render()
    {
        $user = auth()->user();
        
        $tasks = [
            'pending' => $user->tasks()->ofStatus(TaskStatus::PENDING)->ordered()->get(),
            'in_progress' => $user->tasks()->ofStatus(TaskStatus::IN_PROGRESS)->ordered()->get(),
            'completed' => $user->tasks()->ofStatus(TaskStatus::COMPLETED)->ordered()->get(),
        ];

        return view('livewire.kanban-board', compact('tasks'));
    }
}
