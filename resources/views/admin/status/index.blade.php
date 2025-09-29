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
                        <div class="text-sm font-medium text-blue-600">Total Assignments</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">Cloth:</span>
                        <span class="font-semibold text-blue-800">{{ $statusCounts['cloth_assignments'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-blue-700">Vest:</span>
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
                        <div class="text-sm font-medium text-green-600">Completed</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-green-700">Cloth:</span>
                        <span class="font-semibold text-green-800">{{ $statusCounts['cloth_completed'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-green-700">Vest:</span>
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
                        <div class="text-sm font-medium text-yellow-600">Pending</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-yellow-700">Cloth:</span>
                        <span class="font-semibold text-yellow-800">{{ $statusCounts['cloth_pending'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-yellow-700">Vest:</span>
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
                        <div class="text-sm font-medium text-purple-600">Completion Rate</div>
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
                        <div class="text-sm font-medium text-teal-600">Total Records</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-teal-700">Cloth Records:</span>
                        <span class="font-semibold text-teal-800">{{ $statusCounts['total_cloth_records'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-teal-700">Vest Records:</span>
                        <span class="font-semibold text-teal-800">{{ $statusCounts['total_vest_records'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Search Assignments</h3>
                    <p class="text-gray-600">Search by Assignment ID, Cloth ID, or Vest ID</p>
                </div>
            </div>

            <form action="{{ route('admin.status.search') }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="search_id" 
                               value="{{ $searchTerm ?? '' }}"
                               placeholder="Enter Assignment ID, Cloth ID, or Vest ID..." 
                               class="w-full px-6 py-4 text-lg border border-gray-300 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 shadow-lg"
                               required>
                    </div>
                    <button type="submit" 
                            class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-2xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                </div>
            </form>

            @if(isset($searchTerm))
                <div class="mt-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <p class="text-blue-800">
                        <strong>Search Results for:</strong> "{{ $searchTerm }}" 
                        ({{ $assignments->total() }} {{ $assignments->total() == 1 ? 'result' : 'results' }} found)
                    </p>
                    <a href="{{ route('admin.status.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Clear Search & Show All
                    </a>
                </div>
            @endif
        </div>

        <!-- Assignments Table -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                <h3 class="text-2xl font-bold text-white">All Assignments</h3>
                <p class="text-indigo-100 mt-1">{{ $assignments->total() }} total assignments</p>
            </div>

            @if($assignments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Measure ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Work Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                                    @if($assignment->status == 'pending')
                                        @if($assignment->assignment_type == 'cloth')
                                            <form method="POST" action="{{ route('admin.status.update.cloth', $assignment->F_cm_id) }}" style="display: inline;">
                                        @else
                                            <form method="POST" action="{{ route('admin.status.update.vest', $assignment->F_vm_id) }}" style="display: inline;">
                                        @endif
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="complete">
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Mark Complete
                                            </button>
                                        </form>
                                    @else
                                        @if($assignment->assignment_type == 'cloth')
                                            <form method="POST" action="{{ route('admin.status.update.cloth', $assignment->F_cm_id) }}" style="display: inline;">
                                        @else
                                            <form method="POST" action="{{ route('admin.status.update.vest', $assignment->F_vm_id) }}" style="display: inline;">
                                        @endif
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition-colors duration-200 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Mark Pending
                                            </button>
                                        </form>
                                    @endif
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
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No Assignments Found</h3>
                    <p class="text-gray-500">
                        @if(isset($searchTerm))
                            No assignments found for "{{ $searchTerm }}". Try a different search term.
                        @else
                            No assignments have been created yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>


@endsection
