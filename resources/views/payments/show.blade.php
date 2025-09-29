@extends('layout.app')

@section('title', 'Payment Details')

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
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Payment #') }}{{ $payment->pay_id }}</h1>
                        <p class="text-gray-600">{{ __('Payment Details and Information') }}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('payments.edit', $payment) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Payment') }}
                </a>
                <a href="{{ route('payments.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Payments') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Information Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Main Payment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Summary Card -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Payment Summary') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Payment ID') }}</label>
                            <p class="text-lg font-semibold text-gray-900">#{{ $payment->pay_id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Amount') }}</label>
                            <p class="text-3xl font-bold text-green-600">${{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Payment Method') }}</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($payment->method == 'cash') bg-green-100 text-green-800
                                @elseif($payment->method == 'card') bg-blue-100 text-blue-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ $payment->payment_method_display }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Payment Type') }}</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($payment->payment_type == 'customer') bg-purple-100 text-purple-800
                                @else bg-orange-100 text-orange-800 @endif">
                                {{ ucfirst($payment->payment_type) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Payment Date') }}</label>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : $payment->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Created') }}</label>
                            <p class="text-sm text-gray-900">{{ $payment->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
                
                @if($payment->note)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-500 mb-2">{{ __('Note') }}</label>
                    <p class="text-gray-900 bg-gray-50 rounded-xl p-4">{{ $payment->note }}</p>
                </div>
                @endif


            </div>

            <!-- Recipient Information -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">
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
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Customer Phone') }}</label>
                            <p class="text-gray-900">{{ $payment->invoice->customers->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Invoice Date') }}</label>
                            <p class="text-gray-900">{{ $payment->invoice->created_at ? $payment->invoice->created_at->format('M d, Y') : 'N/A' }}</p>
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
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Cutting Rate (Small)') }}</label>
                            <p class="text-gray-900">${{ number_format($payment->employee->cutter_s_rate ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Cutting Rate (Large)') }}</label>
                            <p class="text-gray-900">${{ number_format($payment->employee->cutter_l_rate ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Salaye Rate (Small)') }}</label>
                            <p class="text-gray-900">${{ number_format($payment->employee->salaye_s_rate ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">{{ __('Salaye Rate (Large)') }}</label>
                            <p class="text-gray-900">${{ number_format($payment->employee->salaye_l_rate ?? 0, 2) }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
                        </svg>
                        <p class="text-gray-500">{{ __('Recipient information not available') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('payments.edit', $payment) }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('Edit Payment') }}
                    </a>
                    
                    <form method="POST" action="{{ route('payments.destroy', $payment) }}" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('{{ __('Are you sure you want to delete this payment? This action cannot be undone.') }}')"
                                class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('Delete Payment') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Statistics -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment Statistics') }}</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ __('Total Payments') }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ \App\Models\Payment::count() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ __('Total Amount') }}</span>
                        <span class="text-sm font-semibold text-green-600">${{ number_format(\App\Models\Payment::sum('amount'), 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ __('This Month') }}</span>
                        <span class="text-sm font-semibold text-blue-600">${{ number_format(\App\Models\Payment::whereMonth('created_at', now()->month)->sum('amount'), 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Recent Payments') }}</h3>
                <div class="space-y-3">
                    @foreach(\App\Models\Payment::latest()->take(5)->get() as $recentPayment)
                        @if($recentPayment->pay_id != $payment->pay_id)
                        <a href="{{ route('payments.show', $recentPayment) }}" 
                           class="block p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">#{{ $recentPayment->pay_id }}</p>
                                    <p class="text-xs text-gray-500">{{ $recentPayment->created_at->format('M d, Y') }}</p>
                                </div>
                                <span class="text-sm font-semibold text-green-600">${{ number_format($recentPayment->amount, 2) }}</span>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any additional JavaScript functionality here
    console.log('Payment details page loaded');
});
</script>
@endsection
