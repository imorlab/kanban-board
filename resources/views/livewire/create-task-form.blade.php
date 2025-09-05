<div class="h-full flex flex-col">
    <form wire:submit.prevent="createTask" class="flex-1 space-y-6">
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                {{ __('front.task_title') }}
            </label>
            <input
                wire:model="title"
                type="text"
                id="title"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                placeholder="{{ __('front.task_title_placeholder') }}"
                required
                autofocus
            >
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                {{ __('front.description') }}
            </label>
            <textarea
                wire:model="description"
                id="description"
                rows="4"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none transition-colors"
                placeholder="{{ __('front.description_placeholder') }}"
            ></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-gray-900 mb-2">
                {{ __('front.initial_status') }}
            </label>
            <select
                wire:model="status"
                id="status"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
            >
                <option value="pending" class="flex items-center">
                    {{ __('front.pending_option') }}
                </option>
                <option value="in_progress">
                    {{ __('front.in_progress_option') }}
                </option>
                <option value="completed">
                    {{ __('front.completed_option') }}
                </option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </form>

    <!-- Footer with actions -->
    <div class="flex-shrink-0 border-t border-gray-200 px-0 py-4">
        <div class="flex justify-end space-x-3">
            <button
                type="button"
                wire:click="$emit('toggleCreateForm')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
            >
                {{ __('front.cancel') }}
            </button>
            <button
                type="submit"
                wire:click="createTask"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
            >
                <span wire:loading.remove>{{ __('front.create_task') }}</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('front.creating') }}
                </span>
            </button>
        </div>
    </div>
</div>
