<div
    class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 cursor-move hover:shadow-md transition-shadow"
    data-task-id="{{ $task->id }}"
>
    @if(!$showEditForm)
        <!-- Task Display -->
        <div class="space-y-2">
            <h3 class="font-medium text-gray-900">{{ $task->title }}</h3>
            @if($task->description)
                <p class="text-sm text-gray-600 line-clamp-3">{{ $task->description }}</p>
            @endif

            <div class="flex justify-between items-center pt-2">
                <span class="text-xs text-gray-500">
                    {{ $task->created_at->diffForHumans() }}
                </span>

                <div class="flex gap-1">
                    <button
                        wire:click="toggleEdit"
                        class="p-1 text-gray-400 hover:text-blue-500 transition-colors"
                        title="{{ __('front.edit') }}"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>

                    <button
                        onclick="confirmDelete({{ $task->id }})"
                        class="p-1 text-gray-400 hover:text-red-500 transition-colors"
                        title="{{ __('front.delete') }}"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- Task Edit Form -->
        <form wire:submit.prevent="updateTask" class="space-y-3">
            <div>
                <input
                    wire:model="title"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{ __('front.title_placeholder') }}"
                    required
                >
                @error('title')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <textarea
                    wire:model="description"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                    rows="3"
                    placeholder="{{ __('front.description_optional') }}"
                ></textarea>
                @error('description')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-2 pt-2">
                <button
                    type="submit"
                    class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition-colors"
                >
                    {{ __('front.save') }}
                </button>
                <button
                    type="button"
                    wire:click="toggleEdit"
                    class="px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400 transition-colors"
                >
                    {{ __('front.cancel') }}
                </button>
            </div>
        </form>
    @endif
</div>
