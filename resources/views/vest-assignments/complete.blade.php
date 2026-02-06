@extends('layout.app')

@section('title', 'Complete Vest Assignments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Success Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <div class="flex items-center mb-2">
                    <a href="{{ route('vest-assignments.index') }}" class="mr-4 text-blue-600 hover:text-blue-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('Complete Vest Assignments') }}</h1>
                </div>
                <p class="text-gray-600">{{ __('View all completed vest work assignments') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('vest-assignments.create') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Assign New Vest Work') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">{{ __('Completed Vest Assignments') }}</p>
                <p class="text-4xl font-bold">{{ $completeCustomers->count() ?? 0 }}</p>
                <p class="text-green-100 text-sm">{{ __('assignments successfully completed') }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-4">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Complete Assignments Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold text-gray-900">{{ __('Complete Vest Assignments') }}</h2>
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="{{ __('Search assignments...') }}" 
                               class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assignment') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Contact') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Vest Type') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Cutter') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Salaye') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="assignments-tbody">
                    @forelse($completeCustomers as $cust)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center text-white font-semibold">
                                        #{{ $cust->cus_id }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $cust->cus_name }}</div>
                                    <div class="text-sm text-gray-500">Customer ID: {{ $cust->cus_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $cust->phone->pho_no ?? 'No Phone' }}</div>
                            <div class="text-sm text-gray-500">Contact</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($cust->vestMeasurements->count() > 0)
                                @foreach($cust->vestMeasurements as $vm)
                                    <div class="text-sm font-medium text-gray-900">{{ $vm->Vest_Type ?? 'Standard' }}</div>
                                @endforeach
                            @else
                                <span class="text-gray-400">No measurements</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $cutterAssignment = $cust->vestMeasurements->flatMap->clothAssignments->where('work_type', 'cutting')->first();
                            @endphp
                            @if($cutterAssignment)
                                <div class="text-green-600 font-medium">✓ Assigned</div>
                                <div class="text-xs text-gray-500">
                                    @php
                                        $cutterEmployee = \App\Models\Employee::find($cutterAssignment->F_emp_id);
                                    @endphp
                                    {{ $cutterEmployee ? $cutterEmployee->emp_name : 'Unknown' }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    ${{ number_format($cutterAssignment->rate_at_assign ?? 0, 2) }}
                                </div>
                            @else
                                <span class="text-gray-400">Not assigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $salayeAssignment = $cust->vestMeasurements->flatMap->clothAssignments->where('work_type', 'salaye')->first();
                            @endphp
                            @if($salayeAssignment)
                                <div class="text-green-600 font-medium">✓ Assigned</div>
                                <div class="text-xs text-gray-500">
                                    @php
                                        $salayeEmployee = \App\Models\Employee::find($salayeAssignment->F_emp_id);
                                    @endphp
                                    {{ $salayeEmployee ? $salayeEmployee->emp_name : 'Unknown' }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    ${{ number_format($salayeAssignment->rate_at_assign ?? 0, 2) }}
                                </div>
                            @else
                                <span class="text-gray-400">Not assigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ __('Complete') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200" onclick="viewCustomerAssignments({{ $cust->cus_id }})" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <a href="{{ route('vest-assignments.edit-customer', $cust->cus_id) }}" class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200" title="Update Assignments">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No completed vest assignments') }}</h3>
                                <p class="text-gray-500 mb-4">{{ __('No vest assignments have been completed yet.') }}</p>
                                <a href="{{ route('vest-assignments.pending') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    {{ __('View Pending Assignments') }}
                                </a>
                            </div>
                        </td>
                   </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const tbody = document.getElementById('assignments-tbody');

        if (searchInput && tbody) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = tbody.querySelectorAll('tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? 'table-row' : 'none';
                });
            });
        }
    });

    // Function to view customer assignments
    function viewCustomerAssignments(customerId) {
        // For now, just show an alert. In a real application, this could redirect to a customer detail page
        alert('Viewing vest assignments for customer ID: ' + customerId);
        // You could redirect to a customer detail page:
        // window.location.href = '/customers/' + customerId;
    }
</script>
@endsection
