@extends('layout.app')

@section('title', 'Customer Details - ' . $customer->cus_name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Search Customer by Phone') }}</h2>
        <div class="relative">
            <input type="text" id="phone_search" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm" 
                   placeholder="{{ __('Enter phone number to search for customer records') }}">
            <div id="phone_search_results" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg hidden max-h-60 overflow-y-auto"></div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Customer Details') }}</h1>
                <p class="text-gray-600">{{ __('View detailed information about') }} {{ $customer->cus_name }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('customers.edit', $customer) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Customer') }}
                </a>
                <a href="{{ route('customers.index') }}" 
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
        <!-- Customer Profile Card -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-8 text-center">
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($customer->cus_name, 0, 2)) }}
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $customer->cus_name }}</h2>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-white/20 text-white">
                        {{ __('Customer') }}
                    </span>
                </div>

                <!-- Profile Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Customer ID') }}</span>
                            <span class="text-sm font-semibold text-gray-900">#{{ $customer->cus_id }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Phone Number') }}</span>
                            @if($customer->phone)
                                <span class="text-sm font-semibold text-gray-900">{{ $customer->phone->pho_no }}</span>
                            @else
                                <span class="text-sm text-gray-400">{{ __('No phone') }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Invoice ID') }}</span>
                            @if($customer->invoice)
                                <span class="text-sm font-semibold text-gray-900">#{{ $customer->invoice->inc_id }}</span>
                            @else
                                <span class="text-sm text-gray-400">{{ __('No invoice') }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Total Orders') }}</span>
                            <span class="text-lg font-bold text-indigo-600">{{ $customer->clothMeasurements->count() + $customer->vestMeasurements->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-medium text-gray-500">{{ __('Status') }}</span>
                            @php
                                $pendingOrders = $customer->clothMeasurements->where('order_status', 'pending')->count() + 
                                               $customer->vestMeasurements->where('Status', 'pending')->count();
                            @endphp
                            @if($pendingOrders > 0)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $pendingOrders }} {{ __('Pending') }}
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ __('All Complete') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    {{ __('Payment Summary') }}
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-500">{{ __('Total Order Value') }}</span>
                        <span class="text-lg font-bold text-blue-600">AFN {{ number_format($customer->total_order_value, 2) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-500">{{ __('Total Paid') }}</span>
                        <span class="text-lg font-bold text-green-600">AFN {{ number_format($customer->total_paid, 2) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium text-gray-500">{{ __('Remaining Balance') }}</span>
                        <span class="text-lg font-bold {{ $customer->total_owed > 0 ? 'text-red-600' : 'text-green-600' }}">
                            AFN {{ number_format($customer->total_owed, 2) }}
                        </span>
                    </div>
                    
                    @if($customer->total_owed > 0)
                    <div class="pt-3 border-t border-gray-100">
                        <a href="{{ route('customer-payments.create', ['customer_id' => $customer->cus_id]) }}" 
                           class="w-full flex items-center justify-center p-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 text-white hover:from-green-700 hover:to-emerald-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Record Payment') }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
                <div class="space-y-3">
                    <a href="{{ route('cloth-measurements.create', ['customer' => $customer->cus_id]) }}" 
                       class="flex items-center p-3 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('Add Cloth Measurement') }}
                    </a>
                    
                    <a href="{{ route('vests.create', ['customer' => $customer->cus_id]) }}" 
                       class="flex items-center p-3 rounded-xl bg-teal-50 text-teal-700 hover:bg-teal-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        {{ __('Add Vest Measurement') }}
                    </a>
                    
                    <a href="{{ route('customer-payments.create', ['customer_id' => $customer->cus_id]) }}" 
                       class="flex items-center p-3 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        {{ __('Record Payment') }}
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
                            <p class="text-sm font-medium text-gray-500">{{ __('Cloth Orders') }}</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $customer->clothMeasurements->count() }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Vest Orders') }}</p>
                            <p class="text-2xl font-bold text-teal-600">{{ $customer->vestMeasurements->count() }}</p>
                        </div>
                        <div class="bg-teal-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Pending Orders') }}</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $pendingOrders }}</p>
                        </div>
                        <div class="bg-orange-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Recent Orders') }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('customers.index', ['customer' => $customer->cus_id]) }}" 
                               class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                {{ __('View Cloth') }}
                            </a>
                            <span class="text-gray-400">|</span>
                            <a href="{{ route('vests.index', ['customer' => $customer->cus_id]) }}" 
                               class="text-teal-600 hover:text-teal-800 text-sm font-medium">
                                {{ __('View Vest') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Size') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customer->getAllOrdersAttribute()->take(5) as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        @if($order->order_type == 'cloth')
                                            #{{ $order->cm_id }}
                                        @else
                                            #{{ $order->vm_id }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($order->order_type == 'cloth') bg-purple-100 text-purple-800
                                        @else bg-teal-100 text-teal-800 @endif">
                                        {{ ucfirst($order->order_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ strtoupper($order->size) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $status = $order->order_type == 'cloth' ? $order->order_status : $order->Status;
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($status == 'complete') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    {{ __('No orders found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Payment History') }}</h3>
                        <a href="{{ route('customer-payments.create', ['customer_id' => $customer->cus_id]) }}" 
                           class="text-green-600 hover:text-green-800 text-sm font-medium">
                            {{ __('Add Payment') }}
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Method') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Reference') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customer->customerPayments->take(5) as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->payment_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                    AFN {{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $payment->payment_method_display }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->reference_number ?: '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    {{ __('No payments recorded yet') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($customer->customerPayments->count() > 5)
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 text-center">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        {{ __('View all payments') }} ({{ $customer->customerPayments->count() }})
                    </a>
                </div>
                @endif
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Contact Information') }}</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Phone Number') }}</h4>
                            @if($customer->phone)
                                <p class="text-lg font-semibold text-gray-900">{{ $customer->phone->pho_no }}</p>
                            @else
                                <p class="text-gray-400">{{ __('No phone number provided') }}</p>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Invoice Information') }}</h4>
                            @if($customer->invoice)
                                <p class="text-lg font-semibold text-gray-900">Invoice #{{ $customer->invoice->inc_id }}</p>
                                <p class="text-sm text-gray-500">{{ $customer->invoice->created_at->format('M d, Y') }}</p>
                            @else
                                <p class="text-gray-400">{{ __('No invoice linked') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const phoneSearch = document.getElementById('phone_search');
    const searchResults = document.getElementById('phone_search_results');
    
    let searchTimeout;
    
    phoneSearch.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 3) {
            searchResults.classList.add('hidden');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            fetch(`{{ route('customers.search-by-phone') }}?phone_number=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data.customers);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300);
    });
    
    function displaySearchResults(customers) {
        if (customers.length === 0) {
            searchResults.innerHTML = '<div class="p-4 text-gray-500 text-center">No customers found</div>';
        } else {
            searchResults.innerHTML = customers.map(customer => `
                <div class="p-4 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0" 
                     onclick="viewCustomer(${customer.id})">
                    <div class="font-semibold text-gray-900">${customer.name}</div>
                    <div class="text-sm text-gray-600">Phone: ${customer.phone}</div>
                    <div class="text-sm text-gray-500">
                        Orders: ${customer.cloth_orders + customer.vest_orders} | 
                        Owed: AFN ${customer.total_owed.toFixed(2)} | 
                        Paid: AFN ${customer.total_paid.toFixed(2)}
                    </div>
                </div>
            `).join('');
        }
        
        searchResults.classList.remove('hidden');
    }
    
    window.viewCustomer = function(customerId) {
        window.location.href = `/customers/${customerId}`;
    };
    
    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!phoneSearch.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection
