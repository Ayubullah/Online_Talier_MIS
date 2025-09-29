@extends('layout.app')

@section('title', 'Employee Search Results')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Search Results') }}</h1>
                <p class="text-gray-600">{{ __('Results for:') }} "<span class="font-semibold text-blue-600">{{ $query }}</span>"</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('employee-details.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('New Search') }}
                </a>
            </div>
        </div>
    </div>

    @if($employees->count() > 0)
        <!-- Results Count -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-blue-800 font-medium">{{ $employees->count() }} {{ __('employee(s) found') }}</p>
            </div>
        </div>

        <!-- Employee Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($employees as $employee)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <!-- Employee Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-6 text-white">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-16 w-16">
                            <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr($employee->emp_name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-bold truncate">{{ $employee->emp_name }}</h3>
                            <p class="text-blue-100 text-sm">ID: {{ $employee->emp_id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Employee Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Role & Type -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($employee->role == 'cutter') bg-blue-100 text-blue-800
                                    @elseif($employee->role == 'salaye') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($employee->role) }}
                                </span>
                                @if($employee->type)
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($employee->type == 'cloth') bg-orange-100 text-orange-800
                                        @elseif($employee->type == 'vest') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($employee->type) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Rates -->
                        <div class="space-y-2">
                            <h4 class="text-sm font-semibold text-gray-700">{{ __('Rates') }}</h4>
                            @if($employee->isCutter())
                                <div class="space-y-1">
                                    @if($employee->cutter_s_rate)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ __('Small') }}:</span>
                                            <span class="font-medium text-blue-600">${{ number_format($employee->cutter_s_rate, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($employee->cutter_l_rate)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ __('Large') }}:</span>
                                            <span class="font-medium text-blue-600">${{ number_format($employee->cutter_l_rate, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @elseif($employee->isSalaryWorker())
                                <div class="space-y-1">
                                    @if($employee->salaye_s_rate)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ __('Small') }}:</span>
                                            <span class="font-medium text-green-600">${{ number_format($employee->salaye_s_rate, 2) }}</span>
                                        </div>
                                    @endif
                                    @if($employee->salaye_l_rate)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ __('Large') }}:</span>
                                            <span class="font-medium text-green-600">${{ number_format($employee->salaye_l_rate, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-400">{{ __('No rates set') }}</p>
                            @endif
                        </div>

                        <!-- User Account Status -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ __('User Account') }}:</span>
                            @if($employee->user)
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    <span class="text-sm font-medium text-green-600">{{ $employee->user->name }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400">{{ __('No Account') }}</span>
                            @endif
                        </div>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">{{ $employee->clothAssignments->count() }}</p>
                                <p class="text-xs text-gray-500">{{ __('Assignments') }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-green-600">${{ number_format($employee->payments->sum('amount'), 0) }}</p>
                                <p class="text-xs text-gray-500">{{ __('Total Paid') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="px-6 pb-6">
                    <a href="{{ route('employee-details.show', $employee->emp_id) }}" 
                       class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-3 px-4 rounded-xl shadow-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ __('View Details') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- No Results -->
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('No employees found') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('No employees match your search criteria. Try a different search term.') }}</p>
                <div class="space-y-3">
                    <a href="{{ route('employee-details.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        {{ __('Try New Search') }}
                    </a>
                    <div>
                        <a href="{{ route('employees.index') }}" 
                           class="text-gray-600 hover:text-gray-800 font-medium">
                            {{ __('View All Employees') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
