@extends('layout.app')

@section('title', 'Cloth Orders')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-orange-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                        {{ __('Cloth Orders') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Manage all cloth tailoring orders') }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('cloth-assignments.index') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Cloth Assignments') }}
                    </a>
                    <a href="{{ route('cloth.create') }}" class="px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold rounded-xl hover:from-orange-700 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('New Cloth Order') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Messages -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-green-800 font-semibold">{{ session('success') }}</span>
                    </div>
                    
                    @if(session('invoice_id'))
                        <a href="{{ route('cloth.print', session('invoice_id')) }}" target="_blank" class="px-4 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold rounded-lg hover:from-orange-700 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Print Invoice') }}
                        </a>
                    @endif
                </div>
            </div>
        @endif
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-teal-100 text-sm font-medium">{{ __('Total Orders') }}</p>
                    <p class="text-3xl font-bold">{{ $clothMeasurements->total() }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">{{ __('Completed') }}</p>
                    <p class="text-3xl font-bold">{{ $clothMeasurements->where('order_status', 'complete')->count() }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-yellow-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">{{ __('Pending') }}</p>
                    <p class="text-3xl font-bold">{{ $clothMeasurements->where('order_status', 'pending')->count() }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">{{ __('Assigned') }}</p>
                    <p class="text-3xl font-bold">{{ $clothMeasurements->whereNotNull('clothAssignments')->count() }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Cloth Measurements Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold text-gray-900">{{ __('Cloth Orders List') }}</h2>
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" id="realtime-search" placeholder="{{ __('Search orders...') }}"
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <select id="status-filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="complete">{{ __('Complete') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-hover">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Size') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rate') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assigned To') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($clothMeasurements as $measurement)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-teal-500 to-cyan-500 flex items-center justify-center text-white font-semibold">
                                        #{{ $measurement->cm_id }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Order #{{ $measurement->cm_id }}</div>
                                    <div class="text-sm text-gray-500">{{ $measurement->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $measurement->customer->cus_name }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $measurement->customer->cus_id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                @if($measurement->size == 'S') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ strtoupper($measurement->size) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($measurement->cloth_rate, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($measurement->order_status == 'complete') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($measurement->order_status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($measurement->clothAssignments->count() > 0)
                                @foreach($measurement->clothAssignments as $assignment)
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                        {{ $assignment->employee->emp_name ?? 'Unknown' }}
                                    </div>
                                @endforeach
                            @else
                                <span class="text-gray-400">{{ __('Not Assigned') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('cloth.show', $measurement->cm_id) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('cloth.edit', $measurement) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Print Button -->
                                <a href="{{ route('cloth.print-size', $measurement->cm_id) }}" target="_blank"
                                   class="group relative inline-flex items-center justify-center w-8 h-8 bg-green-50 hover:bg-green-100 text-green-600 hover:text-green-700 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                    <!-- Tooltip -->
                                    <div class="absolute bottom-full mb-2 hidden group-hover:block">
                                        <div class="bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                            Print Size
                                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
                                        </div>
                                    </div>
                                </a>
                                <form method="POST" action="{{ route('cloth.destroy', $measurement) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('{{ __('Are you sure you want to delete this measurement?') }}')"
                                            class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No cloth measurements found') }}</h3>
                                <p class="text-gray-500 mb-4">{{ __('Get started by adding your first cloth measurement.') }}</p>
                                <a href="{{ route('cloth.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                    {{ __('Add First Measurement') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clothMeasurements->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $clothMeasurements->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Real-time filtering functionality using pure JavaScript
    function performFiltering() {
        const searchInput = document.getElementById('realtime-search');
        const statusSelect = document.getElementById('status-filter');
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusFilter = statusSelect.value;

        const tableBody = document.querySelector('tbody');
        const rows = tableBody.querySelectorAll('tr');
        let visibleCount = 0;

        rows.forEach(row => {
            // Skip empty state row
            if (row.querySelector('td[colspan]')) {
                return;
            }

            const rowText = row.textContent.toLowerCase();
            const statusBadge = row.querySelector('.status-badge');
            const currentStatus = statusBadge ? statusBadge.textContent.toLowerCase().trim() : '';

            let showRow = true;

            // Text search filter
            if (searchTerm !== '' && !rowText.includes(searchTerm)) {
                showRow = false;
            }

            // Status filter
            if (statusFilter !== '' && currentStatus !== statusFilter.toLowerCase()) {
                showRow = false;
            }

            if (showRow) {
                row.style.display = 'table-row';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update results info
        updateSearchResults(searchTerm, statusFilter, visibleCount, rows.length);
    }

    // Function to update search results info
    function updateSearchResults(searchTerm, statusFilter, visibleCount, totalCount) {
        // You can add a results info section if needed
        console.log(`Filtered ${visibleCount} out of ${totalCount} results`);
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

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Cloth orders page loaded with pure JavaScript real-time filtering');

        const searchInput = document.getElementById('realtime-search');
        const statusSelect = document.getElementById('status-filter');

        // Real-time search event listeners
        if (searchInput) {
            searchInput.addEventListener('input', performFiltering);
        }

        // Status filter event listener
        if (statusSelect) {
            statusSelect.addEventListener('change', performFiltering);
        }
    });
</script>
@endsection
