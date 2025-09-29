@extends('layout.app')

@section('title', 'Create New Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Create New Payment') }}</h1>
                <p class="text-gray-600">{{ __('Add a new payment transaction for employee') }}</p>
            </div>
            <a href="{{ route('payments.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Payments') }}
            </a>
        </div>
    </div>

    <!-- Payment Form -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form action="{{ route('payments.store') }}" method="POST" class="space-y-8">
            @csrf
            

            
            <!-- Employee Selection -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Employee Information') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="F_emp_id" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Employee') }} <span class="text-red-500">*</span></label>
                        <select name="F_emp_id" id="F_emp_id" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="">{{ __('Select Employee') }}</option>
                            @foreach(\App\Models\Employee::all() as $employee)
                                <option value="{{ $employee->emp_id }}" 
                                    {{ (old('F_emp_id') == $employee->emp_id) || (isset($selectedEmployee) && $selectedEmployee && $selectedEmployee->emp_id == $employee->emp_id) ? 'selected' : '' }}>
                                    {{ $employee->emp_name }} ({{ $employee->role_display }} - {{ $employee->type_display }})
                                </option>
                            @endforeach
                        </select>
                        @error('F_emp_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="employee_role" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Employee Role') }}</label>
                        <input type="text" id="employee_role" readonly 
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 text-gray-500">
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment Details') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Amount') }} <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" name="amount" id="amount" step="0.01" min="0" 
                                   value="{{ old('amount') }}" required
                                   class="w-full border border-gray-300 rounded-xl pl-8 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                   placeholder="0.00">
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="method" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Payment Method') }}</label>
                        <select name="method" id="method" 
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>{{ __('Cash') }}</option>
                            <option value="card" {{ old('method') == 'card' ? 'selected' : '' }}>{{ __('Card') }}</option>
                            <option value="bank" {{ old('method') == 'bank' ? 'selected' : '' }}>{{ __('Bank Transfer') }}</option>
                        </select>
                        @error('method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Note') }}</label>
                    <textarea name="note" id="note" rows="3" 
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                              placeholder="{{ __('Add any additional notes about this payment...') }}">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-6">
                    <label for="paid_at" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Payment Date') }}</label>
                    <input type="datetime-local" name="paid_at" id="paid_at" 
                           value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    @error('paid_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="print_invoice" value="1" 
                               class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-300 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">{{ __('Print invoice immediately after payment') }}</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500">{{ __('Check this to automatically open the printable invoice after creating the payment') }}</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('payments.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:from-emerald-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Create Payment') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const employeeSelect = document.getElementById('F_emp_id');
    const employeeRole = document.getElementById('employee_role');
    
    // Function to update employee role
    function updateEmployeeRole() {
        if (employeeSelect.value) {
            const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
            const roleText = selectedOption.text.match(/\((.*?)\)/);
            if (roleText) {
                employeeRole.value = roleText[1];
            }
        } else {
            employeeRole.value = '';
        }
    }
    
    // Employee selection for employee payments
    if (employeeSelect) {
        employeeSelect.addEventListener('change', updateEmployeeRole);
        
        // Update role on page load if employee is pre-selected
        updateEmployeeRole();
    }
});
</script>
@endsection
