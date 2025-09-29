@extends('layout.app')

@section('title', 'Employee Details - ' . $employee->emp_name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 h-20 w-20">
                        <div class="h-20 w-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-2xl">
                            {{ strtoupper(substr($employee->emp_name, 0, 2)) }}
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $employee->emp_name }}</h1>
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($employee->role == 'cutter') bg-blue-100 text-blue-800
                                @elseif($employee->role == 'salaye') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($employee->role) }}
                            </span>
                            @if($employee->type)
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    @if($employee->type == 'cloth') bg-orange-100 text-orange-800
                                    @elseif($employee->type == 'vest') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($employee->type) }}
                                </span>
                            @endif
                            <span class="text-gray-500">ID: {{ $employee->emp_id }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('employee-details.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Search') }}
                </a>
                <a href="{{ route('payments.create', ['employee_id' => $employee->emp_id]) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    {{ __('Pay Employee') }}
                </a>
                <a href="{{ route('employees.edit', $employee) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Employee') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">{{ __('Total Earnings') }}</p>
                    <p class="text-3xl font-bold">${{ number_format($financialSummary['total_earnings'], 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">{{ __('Total Payments') }}</p>
                    <p class="text-3xl font-bold">${{ number_format($financialSummary['total_payments'], 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">{{ __('Outstanding Balance') }}</p>
                    <p class="text-3xl font-bold">${{ number_format($financialSummary['outstanding_balance'], 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">{{ __('Pending Value') }}</p>
                    <p class="text-3xl font-bold">${{ number_format($financialSummary['pending_value'], 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Assignment Stats -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('Assignment Statistics') }}</h3>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Total Assignments') }}</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $assignmentStats['total_assignments'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Completed') }}</span>
                    <span class="text-2xl font-bold text-green-600">{{ $assignmentStats['completed_assignments'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Pending') }}</span>
                    <span class="text-2xl font-bold text-orange-600">{{ $assignmentStats['pending_assignments'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Completion Rate') }}</span>
                    <span class="text-2xl font-bold text-purple-600">{{ $assignmentStats['completion_rate'] }}%</span>
                </div>
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">{{ __('Cloth Assignments') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $assignmentStats['cloth_assignments'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ __('Vest Assignments') }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $assignmentStats['vest_assignments'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Information -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('Employee Information') }}</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Employee ID') }}</span>
                    <span class="font-medium text-gray-900">{{ $employee->emp_id }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Role') }}</span>
                    <span class="font-medium text-gray-900">{{ ucfirst($employee->role) }}</span>
                </div>
                @if($employee->type)
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Type') }}</span>
                    <span class="font-medium text-gray-900">{{ ucfirst($employee->type) }}</span>
                </div>
                @endif
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('User Account') }}</span>
                    @if($employee->user)
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                            <span class="font-medium text-green-600">{{ $employee->user->name }}</span>
                        </div>
                    @else
                        <span class="text-gray-400">{{ __('No Account') }}</span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Created') }}</span>
                    <span class="font-medium text-gray-900">{{ $employee->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <!-- Rates Section -->
            @if($employee->isCutter() || $employee->isSalaryWorker())
            <div class="pt-6 border-t border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Rates') }}</h4>
                @if($employee->isCutter())
                    <div class="space-y-2">
                        @if($employee->cutter_s_rate)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Small Rate') }}</span>
                                <span class="font-medium text-blue-600">${{ number_format($employee->cutter_s_rate, 2) }}</span>
                            </div>
                        @endif
                        @if($employee->cutter_l_rate)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Large Rate') }}</span>
                                <span class="font-medium text-blue-600">${{ number_format($employee->cutter_l_rate, 2) }}</span>
                            </div>
                        @endif
                    </div>
                @elseif($employee->isSalaryWorker())
                    <div class="space-y-2">
                        @if($employee->salaye_s_rate)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Small Rate') }}</span>
                                <span class="font-medium text-green-600">${{ number_format($employee->salaye_s_rate, 2) }}</span>
                            </div>
                        @endif
                        @if($employee->salaye_l_rate)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Large Rate') }}</span>
                                <span class="font-medium text-green-600">${{ number_format($employee->salaye_l_rate, 2) }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-2xl shadow-xl mb-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="showTab('assignments')" 
                        class="tab-button active py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap" 
                        id="assignments-tab">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    {{ __('Assignments') }} ({{ $employee->clothAssignments->count() }})
                </button>
                <button onclick="showTab('payments')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap" 
                        id="payments-tab">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    {{ __('Payments') }} ({{ $employee->payments->count() }})
                </button>
                <button onclick="showTab('recent')" 
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap" 
                        id="recent-tab">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('Recent Activity') }}
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Assignments Tab -->
            <div id="assignments-content" class="tab-content">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('All Assignments') }}</h3>
                    <a href="{{ route('employee-details.assignments', $employee->emp_id) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        {{ __('View All') }}
                    </a>
                </div>
                
                @if($employee->clothAssignments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Work Type') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Quantity') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rate') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($employee->clothAssignments->take(10) as $assignment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($assignment->assignment_type == 'cloth') bg-orange-100 text-orange-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ ucfirst($assignment->assignment_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($assignment->assignableItem && $assignment->assignableItem->customer)
                                            {{ $assignment->assignableItem->customer->cus_name }}
                                        @else
                                            <span class="text-gray-400">{{ __('N/A') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($assignment->work_type == 'cutting') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($assignment->work_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->qty }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($assignment->rate_at_assign, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ number_format($assignment->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($assignment->status == 'complete') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($assignment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $assignment->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No assignments found') }}</h3>
                        <p class="text-gray-500">{{ __('This employee has no assignments yet.') }}</p>
                    </div>
                @endif
            </div>

            <!-- Payments Tab -->
            <div id="payments-content" class="tab-content hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('All Payments') }}</h3>
                    <a href="{{ route('employee-details.payments', $employee->emp_id) }}" 
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        {{ __('View All') }}
                    </a>
                </div>
                
                @if($employee->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Method') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Note') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($employee->payments->take(10) as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">${{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($payment->method == 'cash') bg-green-100 text-green-800
                                            @elseif($payment->method == 'card') bg-blue-100 text-blue-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ ucfirst($payment->method) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $payment->note ?: __('No note') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->paid_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No payments found') }}</h3>
                        <p class="text-gray-500">{{ __('This employee has no payments yet.') }}</p>
                    </div>
                @endif
            </div>

            <!-- Recent Activity Tab -->
            <div id="recent-content" class="tab-content hidden">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Recent Activity') }}</h3>
                
                <div class="space-y-4">
                    @foreach($recentActivity['recent_assignments'] as $assignment)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ __('New assignment') }} - {{ ucfirst($assignment->assignment_type) }} {{ ucfirst($assignment->work_type) }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $assignment->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($assignment->status == 'complete') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($assignment->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach

                    @foreach($recentActivity['recent_payments'] as $payment)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ __('Payment received') }} - ${{ number_format($payment->amount, 2) }} ({{ ucfirst($payment->method) }})
                            </p>
                            <p class="text-sm text-gray-500">{{ $payment->paid_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="text-sm font-medium text-green-600">${{ number_format($payment->amount, 2) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'border-blue-500', 'text-blue-600');
            button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
        
        // Show selected tab content
        document.getElementById(tabName + '-content').classList.remove('hidden');
        
        // Add active class to selected tab
        const activeTab = document.getElementById(tabName + '-tab');
        activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
        activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    }

</script>
@endsection
