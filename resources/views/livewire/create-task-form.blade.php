<div class="space-y-4">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Nueva Tarea</h3>
    
    <form wire:submit.prevent="createTask" class="space-y-4">
        <!-- Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                Título *
            </label>
            <input 
                wire:model="title"
                type="text" 
                id="title"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Ingresa el título de la tarea"
                required
            >
            @error('title') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                Descripción
            </label>
            <textarea 
                wire:model="description"
                id="description"
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                placeholder="Describe los detalles de la tarea (opcional)"
            ></textarea>
            @error('description') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                Estado Inicial
            </label>
            <select 
                wire:model="status"
                id="status"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
                <option value="pending">Pendiente</option>
                <option value="in_progress">En Progreso</option>
                <option value="completed">Completado</option>
            </select>
            @error('status') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
            <button 
                type="submit"
                class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
            >
                Crear Tarea
            </button>
        </div>
    </form>

    @if (session()->has('message'))
        <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
