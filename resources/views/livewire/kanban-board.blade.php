<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('front.kanban_title') }}</h1>
        <button
            wire:click="toggleCreateForm"
            class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            {{ __('front.new_task') }}
        </button>
    </div>

    <!-- Create Task Form Sidebar -->
    <div class="min-h-screen"
     x-data="{
         showCreateForm: @entangle('showCreateForm'),
         disableInteractions() {
             this.$nextTick(() => disableKanbanInteractions());
         },
         enableInteractions() {
             this.$nextTick(() => enableKanbanInteractions());
         }
     }"
     x-init="$watch('showCreateForm', value => value ? disableInteractions() : enableInteractions())">
    <div class="container mx-auto px-4 py-8">

        <!-- Background overlay -->
        <div x-show="showCreateForm"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-75 z-[100]"
             @click="$wire.set('showCreateForm', false)"
             style="display: none;"></div>

        <!-- Sidebar -->
        <div x-show="showCreateForm"
             x-transition:enter="transform transition ease-in-out duration-500"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-500"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16 z-[110]"
             style="display: none;">
            <div class="w-screen max-w-md">

                <div class="flex h-full flex-col bg-white shadow-xl relative z-[110]">
                    <!-- Header -->
                    <div class="bg-purple-600 px-4 py-6 sm:px-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-white">{{ __('front.new_task_title') }}</h2>
                            <div class="ml-3 flex h-7 items-center">
                                <button type="button"
                                        @click="$wire.set('showCreateForm', false)"
                                        class="rounded-md bg-purple-600 text-purple-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                    <span class="sr-only">{{ __('front.close_panel') }}</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-1">
                            <p class="text-sm text-purple-300">{{ __('front.new_task_description') }}</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="relative flex-1 px-4 py-6 sm:px-6">
                        @if($showCreateForm)
                            @livewire('create-task-form')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="kanban-board">
        <!-- Pendiente Column -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                    <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                    {{ __('front.pending') }}
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
                    {{ __('front.in_progress') }}
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
                    {{ __('front.completed') }}
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

    function disableKanbanInteractions() {
        const kanbanBoard = document.getElementById('kanban-board');
        if (kanbanBoard) {
            kanbanBoard.style.pointerEvents = 'none';
        }
    }

    function enableKanbanInteractions() {
        const kanbanBoard = document.getElementById('kanban-board');
        if (kanbanBoard) {
            kanbanBoard.style.pointerEvents = 'auto';
        }
    }

    // SweetAlert2 event listeners
    window.addEventListener('swal:success', event => {
        const config = {
            icon: 'success',
            ...event.detail
        };

        if (config.toast) {
            Swal.fire({
                toast: true,
                position: config.position || 'top-end',
                showConfirmButton: false,
                timer: config.timer || 3000,
                timerProgressBar: true,
                icon: config.icon || 'success',
                title: config.title,
                text: config.text
            });
        } else {
            Swal.fire(config);
        }
    });

    // Confirmation for delete task
    function confirmDelete(taskId) {
        Swal.fire({
            title: '{{ __("front.confirm_delete_title") }}',
            text: '{{ __("front.confirm_delete_text") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '{{ __("front.confirm_delete_button") }}',
            cancelButtonText: '{{ __("front.cancel_button") }}',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('deleteTask', taskId);
            }
        });
    }
</script>
@endpush
