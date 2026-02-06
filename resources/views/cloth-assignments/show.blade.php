@extends('layout.app')

@section('title', 'Cloth Assignment Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Cloth Assignment Details') }}</h1>
                    <p class="text-gray-600">{{ __('View and manage cloth assignment information') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('cloth-assignments.edit', $clothAssignment) }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('Edit') }}
                    </a>
                    <a href="{{ route('cloth-assignments.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Back to List') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Assignment Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Assignment Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Assignment Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Assignment Information') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Assignment ID') }}</label>
                            <p class="text-lg font-semibold text-gray-900">#{{ $clothAssignment->ca_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Status') }}</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $clothAssignment->status === 'complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($clothAssignment->status) }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Work Type') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ ucfirst($clothAssignment->work_type) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Rate at Assignment') }}</label>
                            <p class="text-lg font-semibold text-green-600">${{ number_format($clothAssignment->rate_at_assign, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Assigned At') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $clothAssignment->assigned_at ? $clothAssignment->assigned_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>

                        @if($clothAssignment->completed_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Completed At') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $clothAssignment->completed_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Cloth Details Card -->
                @if($clothAssignment->clothMeasurement)
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Cloth Details') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Customer Name') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $clothAssignment->clothMeasurement->customer->cus_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Cloth Type') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $clothAssignment->clothMeasurement->cloth_type ?? 'Standard' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Size') }}</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $clothAssignment->clothMeasurement->size === 'S' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $clothAssignment->clothMeasurement->size === 'S' ? 'Small' : 'Large' }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Cloth Rate') }}</label>
                            <p class="text-lg font-semibold text-green-600">${{ number_format($clothAssignment->clothMeasurement->rate, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Order Date') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $clothAssignment->clothMeasurement->O_date ? date('M d, Y', strtotime($clothAssignment->clothMeasurement->O_date)) : 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Return Date') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $clothAssignment->clothMeasurement->R_date ? date('M d, Y', strtotime($clothAssignment->clothMeasurement->R_date)) : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Employee Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Assigned Employee') }}</h3>

                    @if($clothAssignment->employee)
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($clothAssignment->employee->emp_name, 0, 1) }}
                        </div>

                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $clothAssignment->employee->emp_name }}</h4>
                        <p class="text-sm text-gray-500 mb-2">ID: {{ $clothAssignment->employee->emp_id }}</p>
                        <p class="text-sm text-gray-500 mb-4">{{ ucfirst($clothAssignment->employee->role) }} - {{ ucfirst($clothAssignment->employee->type) }}</p>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Small Rate:</span>
                                <span class="font-medium">${{ number_format($clothAssignment->employee->cutter_s_rate ?? $clothAssignment->employee->salaye_s_rate ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Large Rate:</span>
                                <span class="font-medium">${{ number_format($clothAssignment->employee->cutter_l_rate ?? $clothAssignment->employee->salaye_l_rate ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-500 text-center">{{ __('No employee assigned') }}</p>
                    @endif
                </div>

                <!-- Actions Card -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Actions') }}</h3>

                    <div class="space-y-3">
                        @if($clothAssignment->status !== 'complete')
                        <form action="{{ route('cloth-assignments.complete', $clothAssignment) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Mark Complete') }}
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('cloth-assignments.destroy', $clothAssignment) }}" method="POST" class="w-full"
                              onsubmit="return confirm('{{ __('Are you sure you want to delete this assignment?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                {{ __('Delete Assignment') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

