@extends('layout.app')

@section('title', 'Assignment Status Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        {{ __('Assignment Status Management') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Monitor and update all cloth and vest assignment statuses') }}</p>
                </div>
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-3 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Status Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Assignments -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl p-6 border border-blue-200/50 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-blue-700">{{ $statusCounts['total_assignments'] }}</div>
                        <div class="text-sm font-medium text-blue-600">{{ __('Total Assignments') }}</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">{{ __('Cloth') }}:</span>
                        <span class="font-semibold text-blue-800">{{ $statusCounts['cloth_assignments'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">{{ __('Vest') }}:</span>
                        <span class="font-semibold text-blue-800">{{ $statusCounts['vest_assignments'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Completed Assignments -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-6 border border-green-200/50 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-green-700">{{ $statusCounts['completed_assignments'] }}</div>
                        <div class="text-sm font-medium text-green-600">{{ __('Completed') }}</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-green-700">{{ __('Cloth') }}:</span>
                        <span class="font-semibold text-green-800">{{ $statusCounts['cloth_completed'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-green-700">{{ __('Vest') }}:</span>
                        <span class="font-semibold text-green-800">{{ $statusCounts['vest_completed'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Pending Assignments -->
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-3xl p-6 border border-yellow-200/50 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-yellow-700">{{ $statusCounts['pending_assignments'] }}</div>
                        <div class="text-sm font-medium text-yellow-600">{{ __('Pending') }}</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-yellow-700">{{ __('Cloth') }}:</span>
                        <span class="font-semibold text-yellow-800">{{ $statusCounts['cloth_pending'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-yellow-700">{{ __('Vest') }}:</span>
                        <span class="font-semibold text-yellow-800">{{ $statusCounts['vest_pending'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Completion Rate -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-6 border border-purple-200/50 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        @php
                            $completionRate = $statusCounts['total_assignments'] > 0 ? round(($statusCounts['completed_assignments'] / $statusCounts['total_assignments']) * 100, 1) : 0;
                        @endphp
                        <div class="text-3xl font-bold text-purple-700">{{ $completionRate }}%</div>
                        <div class="text-sm font-medium text-purple-600">{{ __('Completion Rate') }}</div>
                    </div>
                </div>
                <div class="w-full bg-purple-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-3 rounded-full" style="width: {{ $completionRate }}%"></div>
                </div>
            </div>

            <!-- Total Records -->
            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-3xl p-6 border border-teal-200/50 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-teal-700">{{ $statusCounts['total_records'] }}</div>
                        <div class="text-sm font-medium text-teal-600">{{ __('Total Records') }}</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-teal-700">{{ __('Cloth Records') }}:</span>
                        <span class="font-semibold text-teal-800">{{ $statusCounts['total_cloth_records'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-teal-700">{{ __('Vest Records') }}:</span>
                        <span class="font-semibold text-teal-800">{{ $statusCounts['total_vest_records'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-time Search Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ __('Search Assignments') }}</h3>
                    <p class="text-gray-600">{{ __('Real-time search by Assignment ID, Cloth ID, or Vest ID') }}</p>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-3 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="relative">
                <input type="text"
                       id="realtime-search"
                       placeholder="{{ __('Type to search by Assignment ID, Cloth ID, or Vest ID...') }}"
                       class="w-full px-6 py-4 pr-16 text-lg border border-gray-300 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 shadow-lg"
                       autocomplete="off">
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 flex items-center gap-2">
                    <button type="button"
                            id="clear-search-btn"
                            class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 opacity-0 invisible rounded-lg hover:bg-gray-100"
                            title="Clear search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="w-6 h-6 text-gray-400">
                        <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div id="search-results-info" class="hidden mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                <p class="text-blue-800">
                    <strong id="results-count">0</strong> {{ __('assignments found matching your search') }}
                    <span id="clear-search" class="text-blue-600 hover:text-blue-800 text-sm font-medium cursor-pointer ml-2">
                        ({{ __('Clear search') }})
                    </span>
                </p>
            </div>
        </div>

        <!-- Assignments Table -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                <h3 class="text-2xl font-bold text-white">{{ __('All Assignments') }}</h3>
                <p class="text-indigo-100 mt-1">{{ $assignments->total() }} {{ __('total assignments') }}</p>
            </div>

            @if($assignments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Measure ID') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Employee') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Work Type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($assignments as $assignment)
                            <tr class="hover:bg-gray-50" id="assignment-{{ $assignment->F_cm_id ?? $assignment->F_vm_id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $assignment->ca_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                        @if($assignment->assignment_type == 'cloth') bg-blue-100 text-blue-800
                                        @else bg-orange-100 text-orange-800 @endif">
                                        {{ ucfirst($assignment->assignment_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">
                                    {{ $assignment->F_cm_id ?? $assignment->F_vm_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($assignment->assignableItem && $assignment->assignableItem->customer)
                                        {{ $assignment->assignableItem->customer->cus_name }}
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $assignment->employee->emp_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ucfirst($assignment->work_type) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                        @if($assignment->status == 'complete') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($assignment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="assignment-actions" data-assignment-id="{{ $assignment->ca_id }}" data-current-status="{{ $assignment->status }}">
                                        @if($assignment->status == 'pending')
                                            <button type="button" onclick="updateAssignmentStatus({{ $assignment->ca_id }}, 'complete')"
                                                    class="status-update-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ __('Mark Complete') }}
                                            </button>
                                        @else
                                            <button type="button" onclick="updateAssignmentStatus({{ $assignment->ca_id }}, 'pending')"
                                                    class="status-update-btn bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ __('Mark Pending') }}
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $assignments->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">{{ __('No Assignments Found') }}</h3>
                    <p class="text-gray-500">
                        @if(isset($searchTerm))
                            {{ __('No assignments found for') }} "{{ $searchTerm }}". {{ __('Try a different search term.') }}
                        @else
                            {{ __('No assignments have been created yet') }}
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Function to update assignment status via AJAX using pure JavaScript
    function updateAssignmentStatus(assignmentId, newStatus) {
        const actionContainer = document.querySelector(`[data-assignment-id="${assignmentId}"]`);
        const button = actionContainer.querySelector('.status-update-btn');
        const originalHtml = button.innerHTML;

        // Disable button and show loading state
        button.disabled = true;
        button.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            {{ __('Updating...') }}
        `;

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Make AJAX request using fetch
        fetch(`/admin/status/update-assignment/${assignmentId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the status badge
                updateStatusBadge(assignmentId, newStatus);

                // Update the button
                updateActionButton(assignmentId, newStatus);

                // Show success message
                showMessage('success', data.message || '{{ __('Status updated successfully!') }}');
            } else {
                showMessage('error', data.message || '{{ __('Failed to update status') }}');
                // Restore button
                button.disabled = false;
                button.innerHTML = originalHtml;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('error', '{{ __('An error occurred while updating the status') }}');
            // Restore button
            button.disabled = false;
            button.innerHTML = originalHtml;
        });
    }

    // Function to update the status badge
    function updateStatusBadge(assignmentId, newStatus) {
        const row = document.querySelector(`[data-assignment-id="${assignmentId}"]`).closest('tr');
        const statusBadge = row.querySelector('.status-badge');

        if (newStatus === 'complete') {
            statusBadge.className = statusBadge.className.replace('bg-yellow-100 text-yellow-800', 'bg-green-100 text-green-800');
            statusBadge.textContent = '{{ __('Complete') }}';
        } else {
            statusBadge.className = statusBadge.className.replace('bg-green-100 text-green-800', 'bg-yellow-100 text-yellow-800');
            statusBadge.textContent = '{{ __('Pending') }}';
        }
    }

    // Function to update the action button
    function updateActionButton(assignmentId, newStatus) {
        const actionContainer = document.querySelector(`[data-assignment-id="${assignmentId}"]`);
        actionContainer.setAttribute('data-current-status', newStatus);

        if (newStatus === 'pending') {
            // Show "Mark Complete" button
            actionContainer.innerHTML = `
                <button type="button" onclick="updateAssignmentStatus(${assignmentId}, 'complete')"
                        class="status-update-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Mark Complete') }}
                </button>
            `;
        } else {
            // Show "Mark Pending" button
            actionContainer.innerHTML = `
                <button type="button" onclick="updateAssignmentStatus(${assignmentId}, 'pending')"
                        class="status-update-btn bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Mark Pending') }}
                </button>
            `;
        }
    }

    // Function to show messages
    function showMessage(type, message) {
        // Remove any existing messages
        const existingMessages = document.querySelectorAll('.message-alert');
        existingMessages.forEach(msg => msg.remove());

        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = `message-alert fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;

        const iconPath = type === 'success'
            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';

        messageDiv.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${iconPath}
                </svg>
                <span>${message}</span>
            </div>
        `;

        // Add to page
        document.body.appendChild(messageDiv);

        // Auto-hide after 3 seconds
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.style.opacity = '0';
                setTimeout(() => {
                    if (messageDiv.parentNode) {
                        messageDiv.parentNode.removeChild(messageDiv);
                    }
                }, 300);
            }
        }, 3000);
    }

    // Real-time search functionality using pure JavaScript
    function performSearch() {
        const searchTerm = document.getElementById('realtime-search').value.toLowerCase().trim();
        const tableBody = document.querySelector('tbody');
        const rows = tableBody.querySelectorAll('tr');
        let visibleCount = 0;

        // Show/hide clear button
        const clearBtn = document.getElementById('clear-search-btn');
        if (searchTerm.length > 0) {
            clearBtn.classList.remove('opacity-0', 'invisible');
            clearBtn.classList.add('opacity-100', 'visible');
        } else {
            clearBtn.classList.remove('opacity-100', 'visible');
            clearBtn.classList.add('opacity-0', 'invisible');
        }

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();

            if (searchTerm === '' || rowText.includes(searchTerm)) {
                row.style.display = 'table-row';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update results info
        updateSearchResults(searchTerm, visibleCount, rows.length);
    }

    // Function to update search results info
    function updateSearchResults(searchTerm, visibleCount, totalCount) {
        const resultsInfo = document.getElementById('search-results-info');
        const resultsCount = document.getElementById('results-count');

        if (searchTerm.length > 0) {
            resultsCount.textContent = visibleCount;
            resultsInfo.classList.remove('hidden');
        } else {
            resultsInfo.classList.add('hidden');
        }
    }

    // Function to clear search
    function clearSearch() {
        document.getElementById('realtime-search').value = '';
        document.getElementById('clear-search-btn').classList.remove('opacity-100', 'visible');
        document.getElementById('clear-search-btn').classList.add('opacity-0', 'invisible');
        document.getElementById('search-results-info').classList.add('hidden');

        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = 'table-row';
        });

        // Trigger search to update UI
        performSearch();
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin status page loaded with pure JavaScript AJAX functionality');

        const searchInput = document.getElementById('realtime-search');
        const clearBtn = document.getElementById('clear-search-btn');
        const clearLink = document.getElementById('clear-search');

        // Real-time search event listeners
        if (searchInput) {
            searchInput.addEventListener('input', performSearch);
        }

        // Clear search button
        if (clearBtn) {
            clearBtn.addEventListener('click', clearSearch);
        }

        // Clear search link in results info
        if (clearLink) {
            clearLink.addEventListener('click', clearSearch);
        }
    });
</script>
@endsection
