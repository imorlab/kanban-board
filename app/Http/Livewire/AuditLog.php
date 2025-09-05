<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class AuditLog extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 20;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Only allow admin users
        $user = auth()->user();
        if (!$user instanceof User || !$user->isAdmin()) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $activities = Activity::query()
            ->with(['subject', 'causer'])
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhere('event', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.audit-log', [
            'activities' => $activities,
        ]);
    }
}
