<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Mi Tablero Kanban</h1>
        <button 
            wire:click="toggleCreateForm"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Nueva Tarea
        </button>
    </div>

    <!-- Create Task Form Modal -->
    @if($showCreateForm)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            @livewire('create-task-form')
            <div class="flex justify-end mt-4">
                <button 
                    wire:click="toggleCreateForm"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors"
                >
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="kanban-board">
        <!-- Pendiente Column -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                    <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                    Pendiente
                    <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded-full text-sm">{{ count($tasks['pending']) }}</span>
                </h2>
            </div>
            <div class="space-y-3 min-h-[200px]" data-status="pending">
                @foreach($tasks['pending'] as $task)
                    @livewire('task-card', ['task' => $task], key($task->id))
                @endforeach
            </div>
        </div>

        <!-- En Progreso Column -->
        <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-blue-700 flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    En Progreso
                    <span class="bg-blue-200 text-blue-600 px-2 py-1 rounded-full text-sm">{{ count($tasks['in_progress']) }}</span>
                </h2>
            </div>
            <div class="space-y-3 min-h-[200px]" data-status="in_progress">
                @foreach($tasks['in_progress'] as $task)
                    @livewire('task-card', ['task' => $task], key($task->id))
                @endforeach
            </div>
        </div>

        <!-- Completado Column -->
        <div class="bg-green-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-green-700 flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    Completado
                    <span class="bg-green-200 text-green-600 px-2 py-1 rounded-full text-sm">{{ count($tasks['completed']) }}</span>
                </h2>
            </div>
            <div class="space-y-3 min-h-[200px]" data-status="completed">
                @foreach($tasks['completed'] as $task)
                    @livewire('task-card', ['task' => $task], key($task->id))
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const columns = document.querySelectorAll('[data-status]');
        
        columns.forEach(column => {
            new Sortable(column, {
                group: 'kanban',
                animation: 150,
                ghostClass: 'opacity-50',
                dragClass: 'rotate-3',
                onEnd: function(evt) {
                    const taskId = evt.item.dataset.taskId;
                    const newStatus = evt.to.dataset.status;
                    const newOrder = evt.newIndex + 1;
                    
                    @this.call('handleTaskMoved', taskId, newStatus, newOrder);
                }
            });
        });
    });
</script>
@endpush
