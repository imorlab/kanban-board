<?php

namespace App\Http\Livewire;

use App\Enums\TaskStatus;
use App\Models\Task;
use Livewire\Component;

class KanbanBoard extends Component
{
    public $showCreateForm = false;

    protected $listeners = [
        'taskCreated' => 'handleTaskCreated',
        'taskUpdated' => 'refreshTasks',
        'taskMoved' => 'handleTaskMoved',
        'closeCreateForm' => 'handleCloseForm',
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

    public function handleTaskCreated()
    {
        $this->showCreateForm = false; // Close the sidebar
        $this->refreshTasks(); // Refresh the tasks

        // Emit SweetAlert notification
        $this->dispatchBrowserEvent('swal:success', [
            'title' => __('front.task_created_title'),
            'text' => __('front.task_created_text'),
            'timer' => 3000
        ]);
    }

    public function handleCloseForm()
    {
        $this->showCreateForm = false; // Close the sidebar without success message
    }

    public function handleTaskMoved($taskId, $newStatus, $newOrder)
    {
        $task = Task::findOrFail($taskId);

        // Check if user owns the task
        if ($task->user_id !== auth()->id()) {
            return;
        }

        $oldStatus = $task->status;

        $task->update([
            'status' => $newStatus,
            'sort_order' => $newOrder,
        ]);

        $this->refreshTasks();

        // Show notification about status change
        $statusNames = [
            'pending' => __('front.status_pending'),
            'in_progress' => __('front.status_in_progress'),
            'completed' => __('front.status_completed')
        ];

        $this->dispatchBrowserEvent('swal:success', [
            'title' => __('front.task_moved_title'),
            'text' => __('front.task_moved_text', ['status' => $statusNames[$newStatus]]),
            'timer' => 2000,
            'showConfirmButton' => false,
            'toast' => true,
            'position' => 'top-end'
        ]);
    }

    public function toggleCreateForm()
    {
        $this->showCreateForm = !$this->showCreateForm;
    }

    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);

        // Check if user owns the task
        if ($task->user_id !== auth()->id()) {
            return;
        }

        $task->delete();
        $this->refreshTasks();

        // Emit SweetAlert notification
        $this->dispatchBrowserEvent('swal:success', [
            'title' => __('front.task_deleted_title'),
            'text' => __('front.task_deleted_text'),
            'timer' => 2000,
            'toast' => true,
            'position' => 'top-end',
            'showConfirmButton' => false
        ]);
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
