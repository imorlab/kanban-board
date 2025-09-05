<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('front.audit_log') }}</h1>
            <p class="text-sm text-gray-600 mt-1">{{ __('front.system_activity_tracking') }}</p>
        </div>

        <!-- Search -->
        <div class="w-80">
            <input
                wire:model.debounce.300ms="search"
                type="text"
                placeholder="{{ __('front.search_activities') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
        </div>
    </div>

    <!-- Activity Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('front.event') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Description') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('front.user') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('front.date') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('front.changes') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $activity->event === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $activity->event === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $activity->event === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ ucfirst($activity->event) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $activity->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $activity->causer?->name ?? 'System' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $activity->causer?->email ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $activity->created_at->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $activity->created_at->format('H:i:s') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($activity->changes()->count() > 0)
                                    <div class="text-xs space-y-1">
                                        @foreach($activity->changes() as $key => $change)
                                            @if($key === 'attributes')
                                                <div class="text-green-600">
                                                    <strong>New:</strong>
                                                    @foreach($change as $field => $value)
                                                        <span class="block">{{ $field }}: {{ $value }}</span>
                                                    @endforeach
                                                </div>
                                            @elseif($key === 'old')
                                                <div class="text-red-600">
                                                    <strong>Old:</strong>
                                                    @foreach($change as $field => $value)
                                                        <span class="block">{{ $field }}: {{ $value }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">{{ __('front.no_changes_recorded') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="mt-2 text-sm">{{ __('front.no_activity_logs_found') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($activities->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
