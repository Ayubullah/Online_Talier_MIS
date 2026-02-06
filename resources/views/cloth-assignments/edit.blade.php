@extends('layout.app')

@section('title', 'Edit Cloth Assignment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Edit Cloth Assignment') }}</h1>
                    <p class="text-gray-600">{{ __('Update cloth assignment information') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('cloth-assignments.show', $clothAssignment) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ __('View Details') }}
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

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <form action="{{ route('cloth-assignments.update', $clothAssignment) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Assignment Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Assignment Information') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Status') }}
                            </label>
                            <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="pending" {{ $clothAssignment->status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="complete" {{ $clothAssignment->status === 'complete' ? 'selected' : '' }}>{{ __('Complete') }}</option>
                            </select>
                        </div>

                        <div>
                            <label for="work_type" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Work Type') }}
                            </label>
                            <select name="work_type" id="work_type"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="cutting" {{ $clothAssignment->work_type === 'cutting' ? 'selected' : '' }}>{{ __('Cutting') }}</option>
                                <option value="salaye" {{ $clothAssignment->work_type === 'salaye' ? 'selected' : '' }}>{{ __('Salaye') }}</option>
                            </select>
                        </div>

                        <div>
                            <label for="rate_at_assign" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Rate at Assignment') }}
                            </label>
                            <input type="number" name="rate_at_assign" id="rate_at_assign" step="0.01" min="0"
                                   value="{{ $clothAssignment->rate_at_assign }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="assigned_at" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Assigned At') }}
                            </label>
                            <input type="datetime-local" name="assigned_at" id="assigned_at"
                                   value="{{ $clothAssignment->assigned_at ? $clothAssignment->assigned_at->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="qty" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Quantity') }}
                            </label>
                            <input type="number" name="qty" id="qty" min="1"
                                   value="{{ $clothAssignment->qty }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Employee Assignment -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Employee Assignment') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="F_emp_id" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Employee') }}
                            </label>
                            <select name="F_emp_id" id="F_emp_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">{{ __('Choose an employee...') }}</option>
                                @foreach($employees as $employee)
                                    @if(($employee->role === 'cutter' || $employee->role === 'salaye') && $employee->type === 'cloth')
                                        <option value="{{ $employee->emp_id }}"
                                                {{ $clothAssignment->F_emp_id == $employee->emp_id ? 'selected' : '' }}>
                                            {{ $employee->emp_name }} ({{ ucfirst($employee->role) }} - {{ ucfirst($employee->type) }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Current Employee') }}
                            </label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                @if($clothAssignment->employee)
                                    <p class="text-sm font-medium text-gray-900">{{ $clothAssignment->employee->emp_name }}</p>
                                    <p class="text-sm text-gray-500">{{ ucfirst($clothAssignment->employee->role) }} - {{ ucfirst($clothAssignment->employee->type) }}</p>
                                @else
                                    <p class="text-sm text-gray-500">{{ __('No employee assigned') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cloth Information (Read-only) -->
                @if($clothAssignment->clothMeasurement)
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Cloth Information (Read-only)') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Customer Name') }}
                            </label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-900">{{ $clothAssignment->clothMeasurement->customer->cus_name }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Cloth Type') }}
                            </label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-900">{{ $clothAssignment->clothMeasurement->cloth_type ?? 'Standard' }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Size') }}
                            </label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $clothAssignment->clothMeasurement->size === 'S' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $clothAssignment->clothMeasurement->size === 'S' ? 'Small' : 'Large' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Cloth Rate') }}
                            </label>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-900">${{ number_format($clothAssignment->clothMeasurement->rate, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('cloth-assignments.show', $clothAssignment) }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('Update Assignment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript functionality here if needed
        console.log('Cloth assignment edit form loaded');
    });
</script>
@endsection

