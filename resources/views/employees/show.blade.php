@extends('layout.app')

@section('title', 'Employee Details - ' . $employee->emp_name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Employee Details') }}</h1>
                <p class="text-gray-600">{{ __('View detailed information about') }} {{ $employee->emp_name }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('employees.edit', $employee) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Employee') }}
                </a>
                <a href="{{ route('employees.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-6 gap-8">
        <!-- Employee Profile Card -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-8 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($employee->emp_name, 0, 2)) }}
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $employee->emp_name }}</h2>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-white/20 text-white">
                        {{ ucfirst(str_replace('_', ' ', $employee->role)) }}
                    </span>
                </div>

                <!-- Profile Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Employee ID') }}</span>
                            <span class="text-sm font-semibold text-gray-900">#{{ $employee->emp_id }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Role') }}</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($employee->role == 'cutter') bg-blue-100 text-blue-800
                                @elseif($employee->role == 'salaye') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($employee->role) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Type') }}</span>
                            @if($employee->type)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($employee->type == 'cloth') bg-orange-100 text-orange-800
                                    @elseif($employee->type == 'vest') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($employee->type) }}
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-500">
                                    {{ __('General') }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Specialized Rates -->
                        <div class="py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500 block mb-2">{{ __('Rates') }}</span>
                            <div class="space-y-1">
                                @if($employee->isCutter())
                                    @if($employee->cutter_s_rate)
                                        <div class="flex justify-between">
                                            <span class="text-xs text-blue-600">Small Cutting:</span>
                                            <span class="text-sm font-semibold text-blue-600">${{ number_format($employee->cutter_s_rate, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($employee->cutter_l_rate)
                                        <div class="flex justify-between">
                                            <span class="text-xs text-blue-800">Large Cutting:</span>
                                            <span class="text-sm font-semibold text-blue-800">${{ number_format($employee->cutter_l_rate, 2) }}</span>
                                        </div>
                                    @endif
                                @elseif($employee->isSalaryWorker())
                                    @if($employee->salaye_s_rate)
                                        <div class="flex justify-between">
                                            <span class="text-xs text-green-700">Small Salaye:</span>
                                            <span class="text-sm font-semibold text-green-700">${{ number_format($employee->salaye_s_rate, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($employee->salaye_l_rate)
                                        <div class="flex justify-between">
                                            <span class="text-xs text-green-800">Large Salaye:</span>
                                            <span class="text-sm font-semibold text-green-800">${{ number_format($employee->salaye_l_rate, 2) }}</span>
                                        </div>
                                    @endif
                                @endif
                                @if((!$employee->isCutter() || (!$employee->cutter_s_rate && !$employee->cutter_l_rate)) && 
                                    (!$employee->isSalaryWorker() || (!$employee->salaye_s_rate && !$employee->salaye_l_rate)))
                                    <span class="text-xs text-gray-400">No rates configured</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('User Account') }}</span>
                            @if($employee->user)
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-gray-900">{{ $employee->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $employee->user->email }}</div>
                                    @if($employee->user->isAdmin())
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 mt-1">
                                            {{ __('Admin') }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-sm text-gray-400">{{ __('No Account') }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-medium text-gray-500">{{ __('Status') }}</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ __('Active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('cloth-assignments.index', ['employee' => $employee->emp_id]) }}" 
                       class="flex items-center p-3 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('View Assignments') }}
                    </a>
                    
                    <a href="{{ route('payments.index', ['employee' => $employee->emp_id]) }}" 
                       class="flex items-center p-3 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        {{ __('Payment History') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Total Assignments') }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $employee->clothAssignments->count() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Completed') }}</p>
                            <p class="text-2xl font-bold text-green-600">{{ $employee->clothAssignments->where('status', 'complete')->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Total Earnings') }}</p>
                            <p class="text-2xl font-bold text-purple-600">
                                ${{ number_format($employee->payments->sum('amount'), 2) }}
                            </p>
                        </div>
                        <div class="bg-purple-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Assignments -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Recent Assignments') }}</h3>
                        <a href="{{ route('cloth-assignments.index', ['employee' => $employee->emp_id]) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            {{ __('View All') }}
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assignment') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Work Type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rate') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($employee->clothAssignments->take(5) as $assignment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $assignment->ca_id }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if($assignment->clothMeasurement)
                                            {{ __('Cloth') }} - {{ $assignment->clothMeasurement->customer->cus_name }}
                                        @elseif($assignment->vestMeasurement)
                                            {{ __('Vest') }} - {{ $assignment->vestMeasurement->customer->cus_name }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($assignment->work_type == 'cutting') bg-orange-100 text-orange-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($assignment->work_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($assignment->rate_at_assign, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($assignment->status == 'complete') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($assignment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $assignment->assigned_at->format('M d, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    {{ __('No assignments found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Recent Payments') }}</h3>
                        <a href="{{ route('payments.index', ['employee' => $employee->emp_id]) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            {{ __('View All') }}
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Payment ID') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Method') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Note') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($employee->payments->take(5) as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $payment->pay_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">${{ number_format($payment->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($payment->method == 'cash') bg-green-100 text-green-800
                                        @elseif($payment->method == 'card') bg-blue-100 text-blue-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($payment->method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->paid_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->note ?: __('No note') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    {{ __('No payments found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
