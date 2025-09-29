@extends('layout.app')

@section('title', __('Search Results'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Search Results') }}</h1>
                <p class="text-gray-600">{{ __('All customers with phone number') }}: <span class="font-semibold text-blue-600">{{ $phoneNumber }}</span></p>
                <p class="text-sm text-gray-500 mt-1">{{ __('Found') }} {{ $customers->count() }} {{ __('customer(s)') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('search.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('New Search') }}
                </a>
                <a href="{{ route('customers.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-600 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"></path>
                    </svg>
                    {{ __('All Customers') }}
                </a>
            </div>
        </div>
    </div>

    @if($customers->count() > 0)
        <!-- Results Count -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $customers->count() }} {{ __('Customer(s) Found') }}</h3>
                        <p class="text-gray-600">{{ __('Matching phone number') }}: {{ $phoneNumber }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Results -->
        <div class="space-y-8">
            @foreach($customers as $customer)
                @php
                    $totalClothRate = $customer->clothMeasurements->sum('cloth_rate');
                    $totalVestRate = $customer->vestMeasurements->sum('vest_rate');
                    $totalPaid = $customer->customerPayments->sum('amount');
                    $totalOrderValue = $totalClothRate + $totalVestRate;
                    $remainingBalance = $totalOrderValue - $totalPaid;
                    $totalOrders = $customer->clothMeasurements->count() + $customer->vestMeasurements->count();
                    $pendingOrders = $customer->clothMeasurements->where('order_status', 'pending')->count() + 
                                   $customer->vestMeasurements->where('Status', 'pending')->count();
                @endphp

                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200/60">
                    <!-- Customer Header -->
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-6 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold">
                                    {{ strtoupper(substr($customer->cus_name, 0, 2)) }}
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold">{{ $customer->cus_name }}</h2>
                                    <p class="text-emerald-100">{{ $customer->phone ? $customer->phone->pho_no : 'No phone' }}</p>
                                    @if($customer->invoice)
                                        <p class="text-emerald-100 text-sm">Invoice #{{ $customer->invoice->inc_id }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold">AFN {{ number_format($remainingBalance, 2) }}</div>
                                <div class="text-emerald-100">{{ $remainingBalance > 0 ? 'Outstanding Balance' : 'Fully Paid' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Financial Summary -->
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                            <div class="text-center p-6 bg-blue-50 rounded-xl">
                                <div class="text-2xl font-bold text-blue-600">AFN {{ number_format($totalOrderValue, 2) }}</div>
                                <div class="text-sm text-gray-600">Total Order Value</div>
                            </div>
                            <div class="text-center p-6 bg-green-50 rounded-xl">
                                <div class="text-2xl font-bold text-green-600">AFN {{ number_format($totalPaid, 2) }}</div>
                                <div class="text-sm text-gray-600">Total Paid</div>
                            </div>
                            <div class="text-center p-6 bg-purple-50 rounded-xl">
                                <div class="text-2xl font-bold text-purple-600">{{ $totalOrders }}</div>
                                <div class="text-sm text-gray-600">Total Orders</div>
                            </div>
                            <div class="text-center p-6 bg-orange-50 rounded-xl">
                                <div class="text-2xl font-bold text-orange-600">{{ $pendingOrders }}</div>
                                <div class="text-sm text-gray-600">Pending Orders</div>
                            </div>
                        </div>
                        
                        <!-- Orders Section -->
                        @if($customer->clothMeasurements->count() > 0 || $customer->vestMeasurements->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('Order Records') }}
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order ID') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Size') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rate') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order Date') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Delivery Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($customer->clothMeasurements as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->cm_id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ __('Cloth') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->size }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">AFN {{ number_format($order->cloth_rate, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $order->order_status === 'complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->R_date ? $order->R_date->format('M d, Y') : 'Not set' }}</td>
                                        </tr>
                                        @endforeach
                                        @foreach($customer->vestMeasurements as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->V_M_ID }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-800">
                                                    {{ __('Vest') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->size }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">AFN {{ number_format($order->vest_rate, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $order->Status === 'complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($order->Status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->R_date ? $order->R_date->format('M d, Y') : 'Not set' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Payment History -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                {{ __('Payment History') }}
                            </h3>
                            @if($customer->customerPayments->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Method') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Reference') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Notes') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($customer->customerPayments as $payment)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->payment_date->format('M d, Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">AFN {{ number_format($payment->amount, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        {{ $payment->payment_method_display }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->reference_number ?: '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->notes ?: '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    <p>{{ __('No payments recorded yet') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4 justify-center">
                            <a href="{{ route('search.show', $customer->phone->pho_no) }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ __('View Full Profile') }}
                            </a>
                            @if($remainingBalance > 0)
                                <a href="{{ route('customer-payments.create', ['customer_id' => $customer->cus_id]) }}" class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    {{ __('Pay Remaining Balance') }}
                                </a>
                            @endif
                            <a href="{{ route('cloth-measurements.create', ['customer' => $customer->cus_id]) }}" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('Add Cloth Order') }}
                            </a>
                            <a href="{{ route('vest-measurements.create', ['customer' => $customer->cus_id]) }}" class="px-6 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                {{ __('Add Vest Order') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- No Results -->
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('No Customers Found') }}</h3>
            <p class="text-gray-600 text-lg mb-6">{{ __('No customers found with the phone number') }}: <span class="font-semibold text-blue-600">{{ $phoneNumber }}</span></p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('search.index') }}" class="px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors duration-200">
                    {{ __('Try Another Search') }}
                </a>
                <a href="{{ route('customers.create') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200">
                    {{ __('Add New Customer') }}
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
