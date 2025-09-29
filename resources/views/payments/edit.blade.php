@extends('layout.app')

@section('title', 'Edit Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Edit Payment #') }}{{ $payment->pay_id }}</h1>
                <p class="text-gray-600">{{ __('Update payment information and details') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('payments.show', $payment) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ __('View Payment') }}
                </a>
                <a href="{{ route('payments.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Payments') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Form -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <form action="{{ route('payments.update', $payment) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Payment Type Display (Read-only) -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment Type') }}</h3>
                <div class="flex items-center space-x-4">
                    @if($payment->payment_type == 'customer')
                        <div class="flex items-center space-x-3 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-blue-900">{{ __('Customer Payment') }}</h4>
                                <p class="text-blue-600 text-sm">{{ __('Payment received from customer') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-3 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-green-900">{{ __('Employee Payment') }}</h4>
                                <p class="text-green-600 text-sm">{{ __('Payment made to employee') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recipient Information (Read-only) -->
            <div class="border-b border-gray-200 pb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    @if($payment->payment_type == 'customer')
                        {{ __('Customer Information') }}
                    @else
                        {{ __('Employee Information') }}
                    @endif
                </h3>
                
                @if($payment->payment_type == 'customer' && $payment->invoice && $payment->invoice->customers)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Customer Name') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $payment->invoice->customers->cus_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Invoice ID') }}</label>
                            <p class="text-lg font-semibold text-gray-900">#{{ $payment->invoice->inc_id }}</p>
                        </div>
                    </div>
                @elseif($payment->payment_type == 'employee' && $payment->employee)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Employee Name') }}</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $payment->employee->emp_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Employee ID') }}</label>
                            <p class="text-lg font-semibold text-gray-900">#{{ $payment->employee->emp_id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Role') }}</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $payment->employee->role_display }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Type') }}</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $payment->employee->type_display }}
                            </span>
                        </div>
                    </div>
                @endif
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
                                   value="{{ old('amount', $payment->amount) }}" required
                                   class="w-full border border-gray-300 rounded-xl pl-8 pr-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="0.00">
                        </div>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="method" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Payment Method') }}</label>
                        <select name="method" id="method" 
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="cash" {{ old('method', $payment->method) == 'cash' ? 'selected' : '' }}>{{ __('Cash') }}</option>
                            <option value="card" {{ old('method', $payment->method) == 'card' ? 'selected' : '' }}>{{ __('Card') }}</option>
                            <option value="bank" {{ old('method', $payment->method) == 'bank' ? 'selected' : '' }}>{{ __('Bank Transfer') }}</option>
                        </select>
                        @error('method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Note') }}</label>
                    <textarea name="note" id="note" rows="3" 
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="{{ __('Add any additional notes about this payment...') }}">{{ old('note', $payment->note) }}</textarea>
                    @error('note')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-6">
                    <label for="paid_at" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Payment Date') }}</label>
                    <input type="datetime-local" name="paid_at" id="paid_at" 
                           value="{{ old('paid_at', $payment->paid_at ? $payment->paid_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('paid_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('payments.show', $payment) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Update Payment') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Information -->
    <div class="mt-8 bg-white rounded-2xl shadow-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment History') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <div class="text-2xl font-bold text-gray-900">{{ $payment->created_at->format('M d, Y') }}</div>
                <div class="text-sm text-gray-500">{{ __('Created') }}</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <div class="text-2xl font-bold text-gray-900">{{ $payment->updated_at->format('M d, Y') }}</div>
                <div class="text-sm text-gray-500">{{ __('Last Updated') }}</div>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <div class="text-2xl font-bold text-gray-900">{{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : 'N/A' }}</div>
                <div class="text-sm text-gray-500">{{ __('Payment Date') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any additional JavaScript functionality here
    console.log('Payment edit page loaded');
    
    // Form validation
    const form = document.querySelector('form');
    const amountInput = document.getElementById('amount');
    
    form.addEventListener('submit', function(e) {
        if (!amountInput.value || parseFloat(amountInput.value) <= 0) {
            e.preventDefault();
            alert('Please enter a valid amount greater than 0.');
            amountInput.focus();
        }
    });
});
</script>
@endsection
