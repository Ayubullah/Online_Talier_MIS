@extends('layout.app')



@section('title', __('Customer Details') . ' - ' . __('Phone') . ': ' . $phoneNumber)



@section('content')

<div class="container mx-auto px-4 py-8">

    <!-- Header Section -->

    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between">

            <div class="mb-4 md:mb-0">

                <div class="flex items-center space-x-4">

                    <div class="flex-shrink-0 h-20 w-20">

                        <div class="h-20 w-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-2xl">

                            📞

                        </div>

                    </div>

                    <div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Phone') }}: {{ $phoneNumber }}</h1>

                        <div class="flex items-center space-x-4">

                            <span class="text-gray-500">{{ $customers->count() }} {{ __('Customer(s) Found') }}</span>

                            @if($primaryCustomer->phone)

                                <span class="text-gray-500">{{ __('Phone') }}: {{ $primaryCustomer->phone->pho_no }}</span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            <div class="flex items-center space-x-3">

                <a href="{{ route('search.index') }}" 

                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200">

                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>

                    </svg>

                    {{ __('Back to Search') }}

                </a>

                <a href="{{ route('customer-payments.create', ['customer_id' => $primaryCustomer->cus_id]) }}" 

                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors duration-200">

                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>

                    </svg>

                    {{ __('Record Payment') }}

                </a>

                <a href="{{ route('customers.edit', $primaryCustomer) }}" 

                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200">

                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>

                    </svg>

                    {{ __('Edit Customer') }}

                </a>

            </div>

        </div>

    </div>



    <!-- Financial Summary Cards -->

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-green-100 text-sm font-medium">{{ __('Total Order Value') }}</p>

                    <p class="text-3xl font-bold">${{ number_format($financialSummary['total_order_value'], 2) }}</p>

                </div>

                <div class="bg-white/20 rounded-xl p-3">

                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>

                    </svg>

                </div>

            </div>

        </div>

        

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-blue-100 text-sm font-medium">{{ __('Total Paid') }}</p>

                    <p class="text-3xl font-bold">${{ number_format($financialSummary['total_paid'], 2) }}</p>

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

                    <p class="text-orange-100 text-sm font-medium">{{ __('Remaining Balance') }}</p>

                    <p class="text-3xl font-bold">${{ number_format($financialSummary['remaining_balance'], 2) }}</p>

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

                    <p class="text-purple-100 text-sm font-medium">{{ __('Total Orders') }}</p>

                    <p class="text-3xl font-bold">{{ $orderStats['total_orders'] }}</p>

                </div>

                <div class="bg-white/20 rounded-xl p-3">

                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                    </svg>

                </div>

            </div>

        </div>

    </div>



    <!-- Order Statistics -->

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <!-- Order Stats -->

        <div class="bg-white rounded-2xl shadow-xl p-6 lg:col-span-2">

            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('Order Statistics') }}</h3>

            

            <!-- Total Orders Overview -->

            <div class="grid grid-cols-2 gap-4 mb-6">

                <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">

                <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-blue-800">{{ __('Total Orders') }}</p>

                            <p class="text-2xl font-bold text-blue-600">{{ $orderStats['total_orders'] }}</p>

                        </div>

                        <div class="bg-blue-200 rounded-full p-3">

                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>

                            </svg>

                        </div>

                    </div>

                </div>

                

                <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-4 border border-green-200">

                <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-green-800">{{ __('Completed Orders') }}</p>

                            <p class="text-2xl font-bold text-green-600">{{ $orderStats['completed_orders'] }}</p>

                        </div>

                        <div class="bg-green-200 rounded-full p-3">

                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>

                            </svg>

                        </div>

                    </div>

                </div>

            </div>



            <!-- Cloth Orders Breakdown -->

            <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-4 mb-4 border border-orange-200">

                <div class="flex items-center justify-between mb-3">

                    <h4 class="text-lg font-semibold text-orange-800 flex items-center">

                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>

                        </svg>

                        {{ __('Cloth Orders') }}

                    </h4>

                    <span class="text-2xl font-bold text-orange-600">{{ $orderStats['cloth_orders'] }}</span>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div class="bg-white/60 rounded-lg p-3">

                <div class="flex items-center justify-between">

                            <span class="text-sm font-medium text-orange-700">{{ __('Pending') }}</span>

                            <span class="text-lg font-bold text-yellow-600 bg-yellow-200 px-3 py-1 rounded-full">

                                {{ $customers->sum(function($customer) { return $customer->clothMeasurements->whereIn('order_status', ['pending', 'in_progress'])->count(); }) }}

                            </span>

                        </div>

                </div>

                    <div class="bg-white/60 rounded-lg p-3">

                <div class="flex items-center justify-between">

                            <span class="text-sm font-medium text-orange-700">{{ __('Complete') }}</span>

                            <span class="text-lg font-bold text-green-600 bg-green-200 px-3 py-1 rounded-full">

                                {{ $customers->sum(function($customer) { return $customer->clothMeasurements->where('order_status', 'complete')->count(); }) }}

                            </span>

                </div>

                </div>

            </div>

        </div>



            <!-- Vest Orders Breakdown -->

            <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">

                <div class="flex items-center justify-between mb-3">

                    <h4 class="text-lg font-semibold text-purple-800 flex items-center">

                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>

                        </svg>

                        {{ __('Vest Orders') }}

                    </h4>

                    <span class="text-2xl font-bold text-purple-600">{{ $orderStats['vest_orders'] }}</span>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div class="bg-white/60 rounded-lg p-3">

                <div class="flex items-center justify-between">

                            <span class="text-sm font-medium text-purple-700">{{ __('Pending') }}</span>

                            <span class="text-lg font-bold text-yellow-600 bg-yellow-200 px-3 py-1 rounded-full">

                                {{ $customers->sum(function($customer) { return $customer->vestMeasurements->whereIn('Status', ['pending', 'in_progress'])->count(); }) }}

                            </span>

                        </div>

                </div>

                    <div class="bg-white/60 rounded-lg p-3">

                <div class="flex items-center justify-between">

                            <span class="text-sm font-medium text-purple-700">{{ __('Complete') }}</span>

                            <span class="text-lg font-bold text-green-600 bg-green-200 px-3 py-1 rounded-full">

                                {{ $customers->sum(function($customer) { return $customer->vestMeasurements->where('Status', 'complete')->count(); }) }}

                            </span>

                        </div>

                    </div>

                </div>

                </div>

                </div>



        <!-- Customer Information Table -->

        <div class="bg-white rounded-2xl shadow-xl p-6">

            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('All Customers with Phone: ') }}{{ $phoneNumber }}</h3>

            <div class="max-h-48 overflow-y-auto pr-2" style="height: 200px;">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50 sticky top-0">

                            <tr>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Phone') }}</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Invoice') }}</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Cloth') }}</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Vest') }}</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Payments') }}</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Created') }}</th>

                            </tr>

                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">

                            @foreach($customers as $customer)

                            <tr class="hover:bg-gray-50">

                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->cus_name }}</td>

                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $customer->cus_id }}</td>

                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">{{ $customer->phone ? $customer->phone->pho_no : __('No phone') }}</td>

                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">{{ $customer->invoice ? $customer->invoice->inc_id : __('No invoice') }}</td>

                                <td class="px-3 py-2 whitespace-nowrap text-sm text-center">

                                    @if($customer->clothMeasurements->count() > 0)

                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-green-100 text-green-600">

                                            ✓

                                        </span>

                                    @else

                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-gray-100 text-gray-400">

                                            ✗

                                        </span>

                                    @endif

                                </td>

                                <td class="px-3 py-2 whitespace-nowrap text-sm text-center">

                                    @if($customer->vestMeasurements->count() > 0)

                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-green-100 text-green-600">

                                            ✓

                                        </span>

                                    @else

                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-gray-100 text-gray-400">

                                            ✗

                                        </span>

                                    @endif

                                </td>

                                <td class="px-3 py-2 whitespace-nowrap text-sm text-center">

                                    @if($customer->customerPayments->count() > 0)

                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-green-100 text-green-600">

                                            ✓

                                        </span>

                                    @else

                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-gray-100 text-gray-400">

                                            ✗

                                        </span>

                                    @endif

                                </td>

                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $customer->created_at->format('M d, Y') }}</td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>



            <!-- Financial Breakdown -->

            <div class="pt-6 border-t border-gray-200">

                <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Financial Breakdown') }}</h4>

                <div class="space-y-2">

                    <div class="flex justify-between">

                        <span class="text-gray-600">{{ __('Cloth Total') }}</span>

                        <span class="font-medium text-orange-600">${{ number_format($financialSummary['cloth_total'], 2) }}</span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-gray-600">{{ __('Vest Total') }}</span>

                        <span class="font-medium text-purple-600">${{ number_format($financialSummary['vest_total'], 2) }}</span>

                    </div>

                    <div class="flex justify-between border-t border-gray-200 pt-2">

                        <span class="font-semibold text-gray-900">{{ __('Grand Total') }}</span>

                        <span class="font-bold text-blue-600">${{ number_format($financialSummary['total_order_value'], 2) }}</span>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- Navigation Tabs -->

    <div class="bg-white rounded-2xl shadow-xl mb-8">

        <div class="border-b border-gray-200">

            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">

                <button onclick="showTab('orders')" 

                        class="tab-button active py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap" 

                        id="orders-tab">

                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>

                    </svg>

                    {{ __('Orders') }} ({{ $orderStats['total_orders'] }})

                </button>

                <button onclick="showTab('payments')" 

                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap" 

                        id="payments-tab">

                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>

                    </svg>

                    {{ __('Payments') }} ({{ $customers->sum(function($customer) { return $customer->customerPayments->count(); }) }})

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

            <!-- Orders Tab -->

            <div id="orders-content" class="tab-content">

                <div class="flex items-center justify-between mb-6">

                    <h3 class="text-lg font-semibold text-gray-900">{{ __('All Orders') }}</h3>

                </div>

                

                @php

                    $hasAnyOrders = false;

                    foreach($customers as $customer) {

                        if($customer->clothMeasurements->count() > 0 || $customer->vestMeasurements->count() > 0) {

                            $hasAnyOrders = true;

                            break;

                        }

                    }

                @endphp



                @if($hasAnyOrders)

                    <div class="space-y-6">

                        <!-- Cloth Orders from All Customers -->

                        @php

                            $allClothOrders = collect();

                            foreach($customers as $customer) {

                                $clothOrders = $customer->clothMeasurements->map(function($order) use ($customer) {

                                    $order->customer_name = $customer->cus_name;

                                    $order->customer_id = $customer->cus_id;

                                    return $order;

                                });

                                $allClothOrders = $allClothOrders->concat($clothOrders);

                            }

                        @endphp

                        
                        @if($allClothOrders->count() > 0)

                        @if(session('error'))
                            <div class="mb-4 text-red-600 font-semibold">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-semibold text-gray-800">{{ __('All Cloth Orders') }} ({{ $allClothOrders->count() }})</h4>
                                <div class="flex items-center space-x-2">
                                    <input type="text" id="clothSearchInput" placeholder="{{ __('Search by ID') }}..." 
                                           class="px-3 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <button type="button" onclick="clearClothSearch()" 
                                            class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                        {{ __('Clear') }}
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('search.send-cloth-details') }}">
                                @csrf

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200" id="clothOrdersTable">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    <input type="checkbox" id="selectAllCloth" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Size') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rate') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order Date') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Delivery Date') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Days') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Details') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($allClothOrders as $order)
                                            <tr class="hover:bg-gray-50 cloth-order-row" data-id="{{ $order->cm_id }}">
                                                <td class="px-6 py-4 text-center">
                                                    <input type="checkbox"
                                                        name="cloth_ids[]"
                                                        value="{{ $order->cm_id }}"
                                                        class="cloth-order-checkbox rounded border-gray-300 text-blue-600 shadow-sm">
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->cm_id }}</td>
                                                <td class="px-6 py-4 text-sm text-blue-600">{{ $order->customer_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->size }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($order->cloth_rate, 2) }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                        @if($order->order_status == 'complete') bg-green-100 text-green-800
                                                        @elseif($order->order_status == 'pending') bg-yellow-100 text-yellow-800
                                                        @else bg-blue-100 text-blue-800 @endif">
                                                        {{ ucfirst($order->order_status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $order->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $order->R_date ? $order->R_date->format('M d, Y') : __('Not set') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    @if($order->R_date)
                                                        @php
                                                            $orderDate = $order->created_at->startOfDay();
                                                            $deliveryDate = $order->R_date->startOfDay();
                                                            $days = $orderDate->diffInDays($deliveryDate, false);
                                                            $days = max(0, $days); // Ensure no negative values
                                                        @endphp
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                            @if($days <= 7) bg-green-100 text-green-800
                                                            @elseif($days <= 14) bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ $days }} 
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    <button type="button" onclick="showClothDetails({{ $order->cm_id }})"
                                                            class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                                        {{ __('View') }}
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
                                    {{ __('Send Selected Cloths') }}
                                </button>
                            </form>
                        </div>

                        </div>

                        @endif



                        <!-- Vest Orders from All Customers -->

                        @php

                            $allVestOrders = collect();

                            foreach($customers as $customer) {

                                $vestOrders = $customer->vestMeasurements->map(function($order) use ($customer) {

                                    $order->customer_name = $customer->cus_name;

                                    $order->customer_id = $customer->cus_id;

                                    return $order;

                                });

                                $allVestOrders = $allVestOrders->concat($vestOrders);

                            }

                        @endphp

                        

                        @if($allVestOrders->count() > 0)

                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-semibold text-gray-800">{{ __('All Vest Orders') }} ({{ $allVestOrders->count() }})</h4>
                                <div class="flex items-center space-x-2">
                                    <input type="text" id="vestSearchInput" placeholder="{{ __('Search by ID') }}..." 
                                           class="px-3 py-1 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <button type="button" onclick="clearVestSearch()" 
                                            class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                        {{ __('Clear') }}
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('search.send-vest-details') }}">
                                @csrf

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200" id="vestOrdersTable">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    <input type="checkbox" id="selectAllVest"
                                                        class="rounded border-gray-300 text-blue-600 shadow-sm">
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ID') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Size') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rate') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order Date') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Delivery Date') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Days') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Details') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($allVestOrders as $order)
                                            <tr class="hover:bg-gray-50 vest-order-row" data-id="{{ $order->V_M_ID }}">
                                                <td class="px-6 py-4 text-center">
                                                    <input type="checkbox"
                                                        name="vest_ids[]"
                                                        value="{{ $order->V_M_ID }}"
                                                        class="vest-order-checkbox rounded border-gray-300 text-blue-600 shadow-sm">
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->V_M_ID }}</td>
                                                <td class="px-6 py-4 text-sm text-blue-600">{{ $order->customer_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->size }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($order->vest_rate, 2) }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                        @if($order->Status == 'complete') bg-green-100 text-green-800
                                                        @elseif($order->Status == 'pending') bg-yellow-100 text-yellow-800
                                                        @else bg-blue-100 text-blue-800 @endif">
                                                        {{ ucfirst($order->Status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $order->O_date ? \Carbon\Carbon::parse($order->O_date)->format('M d, Y') : __('N/A') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $order->R_date ? $order->R_date->format('M d, Y') : __('Not set') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    @if($order->R_date && $order->O_date)
                                                        @php
                                                            $orderDate = \Carbon\Carbon::parse($order->O_date)->startOfDay();
                                                            $deliveryDate = $order->R_date->startOfDay();
                                                            $days = $orderDate->diffInDays($deliveryDate, false);
                                                            $days = max(0, $days); // Ensure no negative values
                                                        @endphp
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                            @if($days <= 7) bg-green-100 text-green-800
                                                            @elseif($days <= 14) bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            {{ $days }} 
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    <button type="button" onclick="showVestDetails({{ $order->V_M_ID }})"
                                                            class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">
                                                        {{ __('View') }}
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <button type="submit" class="mt-4 px-4 py-2 bg-purple-600 text-white rounded">
                                    {{ __('Send Selected Vests') }}
                                </button>
                            </form>
                        </div>

                        @endif

                    </div>

                @else

                    <div class="text-center py-12">

                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>

                        </svg>

                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No orders found') }}</h3>

                        <p class="text-gray-500">{{ __('This customer has no orders yet.') }}</p>

                    </div>

                @endif

            </div>



            <!-- Payments Tab -->

            <div id="payments-content" class="tab-content hidden">

                <div class="flex items-center justify-between mb-6">

                    <h3 class="text-lg font-semibold text-gray-900 ml-4">{{ __('All Payments') }}</h3>

                </div>

                

                @php

                    $allPayments = collect();

                    foreach($customers as $customer) {

                        $payments = $customer->customerPayments->map(function($payment) use ($customer) {

                            $payment->customer_name = $customer->cus_name;

                            $payment->customer_id = $customer->cus_id;

                            return $payment;

                        });

                        $allPayments = $allPayments->concat($payments);

                    }

                @endphp



                @if($allPayments->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Method') }}</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Reference') }}</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Notes') }}</th>

                                </tr>

                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @foreach($allPayments->sortByDesc('payment_date') as $payment)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">{{ $payment->customer_name }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">${{ number_format($payment->amount, 2) }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 

                                            @if($payment->payment_method == 'cash') bg-green-100 text-green-800

                                            @elseif($payment->payment_method == 'card') bg-blue-100 text-blue-800

                                            @else bg-purple-100 text-purple-800 @endif">

                                            {{ ucfirst($payment->payment_method) }}

                                        </span>

                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->reference_number ?: 'N/A' }}</td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->payment_date->format('M d, Y') }}</td>

                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $payment->notes ?: 'No notes' }}</td>

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

                        <p class="text-gray-500">{{ __('This customer has no payments yet.') }}</p>

                    </div>

                @endif

            </div>



            <!-- Recent Activity Tab -->

            <div id="recent-content" class="tab-content hidden">

                <h3 class="text-lg font-semibold text-gray-900 mb-6 ml-3">{{ __('Recent Activity') }}</h3>

                

                <div class="space-y-4">

                    @foreach($recentActivity['recent_orders'] as $order)

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

                                {{ __('New order') }} - {{ $order->order_type == 'cloth' ? __('Cloth') : __('Vest') }} ({{ $order->size }}) - {{ $order->customer_name }}

                            </p>

                            <p class="text-sm text-gray-500">{{ $order->sort_date->diffForHumans() }}</p>

                        </div>

                        <div class="flex-shrink-0">

                            <span class="text-sm font-medium text-blue-600">${{ number_format($order->order_type == 'cloth' ? $order->cloth_rate : $order->vest_rate, 2) }}</span>

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

                                {{ __('Payment received') }} - ${{ number_format($payment->amount, 2) }} ({{ ucfirst($payment->payment_method) }}) - {{ $payment->customer_name }}

                            </p>

                            <p class="text-sm text-gray-500">{{ $payment->payment_date->diffForHumans() }}</p>

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



    <!-- Measurement Details Modal -->

    <div id="measurementModal" class="fixed inset-0 h-full w-full hidden z-50 flex items-center justify-center p-8 overflow-y-auto">

        <div class="relative max-w-6xl mx-auto max-h-[75vh] shadow-2xl rounded-2xl bg-white overflow-hidden flex flex-col">

            <!-- Modal Header -->

            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6 text-white">

                <div class="flex items-center justify-between">

                    <div class="flex items-center space-x-3">

                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">

                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>

                            </svg>

                        </div>

                        <div>

                            <h3 class="text-2xl font-bold" id="modalTitle">{{ __('Measurement Details') }}</h3>

                            <p class="text-blue-100 text-sm">{{ __('Complete measurement information') }}</p>

                        </div>

                    </div>

                    <button onclick="closeModal()" class="w-10 h-10 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-200 group">

                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>

                        </svg>

                    </button>

                </div>

            </div>

            

            <!-- Modal Content -->

            <div class="p-6 flex-1 overflow-y-auto" id="modalContent">

                <div class="text-center py-12">

                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">

                        <div class="animate-spin rounded-full h-8 w-8 border-2 border-white border-t-transparent"></div>

                    </div>

                    <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ __('Loading Details') }}</h3>

                    <p class="text-gray-500">{{ __('Please wait while we fetch the measurement information') }}...</p>

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



    // Cloth Orders Checkbox functionality

    function toggleAllClothOrders(selectAllCheckbox) {

        const clothOrderCheckboxes = document.querySelectorAll('.cloth-order-checkbox');

        clothOrderCheckboxes.forEach(checkbox => {

            checkbox.checked = selectAllCheckbox.checked;

        });

    }



    function updateSelectAllCloth() {

        const selectAllCheckbox = document.getElementById('selectAllCloth');

        const clothOrderCheckboxes = document.querySelectorAll('.cloth-order-checkbox');

        const checkedCount = document.querySelectorAll('.cloth-order-checkbox:checked').length;

        

        if (checkedCount === 0) {

            selectAllCheckbox.checked = false;

            selectAllCheckbox.indeterminate = false;

        } else if (checkedCount === clothOrderCheckboxes.length) {

            selectAllCheckbox.checked = true;

            selectAllCheckbox.indeterminate = false;

        } else {

            selectAllCheckbox.checked = false;

            selectAllCheckbox.indeterminate = true;

        }

    }



    // Vest Orders Checkbox functionality

    function toggleAllVestOrders(selectAllCheckbox) {

        const vestOrderCheckboxes = document.querySelectorAll('.vest-order-checkbox');

        vestOrderCheckboxes.forEach(checkbox => {

            checkbox.checked = selectAllCheckbox.checked;

        });

    }



    function updateSelectAllVest() {

        const selectAllCheckbox = document.getElementById('selectAllVest');

        const vestOrderCheckboxes = document.querySelectorAll('.vest-order-checkbox');

        const checkedCount = document.querySelectorAll('.vest-order-checkbox:checked').length;

        

        if (checkedCount === 0) {

            selectAllCheckbox.checked = false;

            selectAllCheckbox.indeterminate = false;

        } else if (checkedCount === vestOrderCheckboxes.length) {

            selectAllCheckbox.checked = true;

            selectAllCheckbox.indeterminate = false;

        } else {

            selectAllCheckbox.checked = false;

            selectAllCheckbox.indeterminate = true;

        }

    }



    // Add event listeners when the page loads

    document.addEventListener('DOMContentLoaded', function() {

        // Cloth Orders Select All

        const selectAllCloth = document.getElementById('selectAllCloth');

        if (selectAllCloth) {

            selectAllCloth.addEventListener('change', function() {

                toggleAllClothOrders(this);

            });

        }



        // Individual Cloth Order checkboxes

        document.querySelectorAll('.cloth-order-checkbox').forEach(checkbox => {

            checkbox.addEventListener('change', updateSelectAllCloth);

        });



        // Vest Orders Select All

        const selectAllVest = document.getElementById('selectAllVest');

        if (selectAllVest) {

            selectAllVest.addEventListener('change', function() {

                toggleAllVestOrders(this);

            });

        }



        // Individual Vest Order checkboxes

        document.querySelectorAll('.vest-order-checkbox').forEach(checkbox => {

            checkbox.addEventListener('change', updateSelectAllVest);

        });

    });



    // Modal Functions

    function closeModal() {

        document.getElementById('measurementModal').classList.add('hidden');

    }



    function showClothDetails(measurementId) {

        document.getElementById('modalTitle').textContent = '{{ __('Cloth Measurement Details') }}';

        document.getElementById('measurementModal').classList.remove('hidden');

        

        // Show loading state

        document.getElementById('modalContent').innerHTML = `

            <div class="text-center py-8">

                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>

                <p class="mt-2 text-gray-600">{{ __('Loading cloth measurement details') }}...</p>

            </div>

        `;

        

        // Fetch cloth measurement details

        fetch(`/api/cloth-measurement/${measurementId}`)

            .then(response => response.json())

            .then(data => {

                if (data.success) {

                    displayClothDetails(data.measurement);

                } else {

                    displayError(data.message || 'Failed to load measurement details');

                }

            })

            .catch(error => {

                console.error('Error:', error);

                displayError('Failed to load measurement details');

            });

    }



    function showVestDetails(measurementId) {

        document.getElementById('modalTitle').textContent = '{{ __('Vest Measurement Details') }}';

        document.getElementById('measurementModal').classList.remove('hidden');

        

        // Show loading state

        document.getElementById('modalContent').innerHTML = `

            <div class="text-center py-8">

                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div>

                <p class="mt-2 text-gray-600">{{ __('Loading vest measurement details') }}...</p>

            </div>

        `;

        

        // Fetch vest measurement details

        fetch(`/api/vest-measurement/${measurementId}`)

            .then(response => response.json())

            .then(data => {

                if (data.success) {

                    displayVestDetails(data.measurement);

                } else {

                    displayError(data.message || 'Failed to load measurement details');

                }

            })

            .catch(error => {

                console.error('Error:', error);

                displayError('Failed to load measurement details');

            });

    }



    function displayClothDetails(measurement) {

        document.getElementById('modalContent').innerHTML = `

            <div class="space-y-4">

                <!-- Header Card -->

                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-4 mt-5">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center space-x-4">

                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center">

                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-2xl font-bold text-gray-900">{{ __('Cloth Measurement') }}</h2>

                                <p class="text-gray-600">ID: ${measurement.cm_id} • ${measurement.customer_name}</p>

                            </div>

                        </div>

                        <div class="text-right">

                            <div class="text-3xl font-bold text-blue-600">$${parseFloat(measurement.cloth_rate).toFixed(2)}</div>

                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${measurement.order_status === 'complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">

                                <div class="w-2 h-2 rounded-full mr-2 ${measurement.order_status === 'complete' ? 'bg-green-500' : 'bg-yellow-500'}"></div>

                                ${measurement.order_status.charAt(0).toUpperCase() + measurement.order_status.slice(1)}

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Main Content Grid -->

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    <!-- Basic Information -->

                    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">

                        <div class="flex items-center mb-4">

                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">

                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                </svg>

                            </div>

                            <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>

                        </div>

                        <div class="space-y-3">

                            <div class="flex items-center justify-between py-2 border-b border-gray-100">

                                <span class="text-gray-600 flex items-center">

                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>

                                    </svg>

                                    {{ __('Size') }}

                                </span>

                                <span class="font-semibold text-gray-900">${measurement.size}</span>

                            </div>

                            <div class="flex items-center justify-between py-2 border-b border-gray-100">

                                <span class="text-gray-600 flex items-center">

                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>

                                    </svg>

                                    {{ __('Rate') }}

                                </span>

                                <span class="font-semibold text-green-600">$${parseFloat(measurement.cloth_rate).toFixed(2)}</span>

                            </div>

                            <div class="flex items-center justify-between py-2">

                                <span class="text-gray-600 flex items-center">

                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                    </svg>

                                    {{ __('Status') }}

                                </span>

                                <span class="font-semibold capitalize">${measurement.order_status}</span>

                            </div>

                        </div>

                    </div>



                    <!-- Measurements -->

                    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">

                        <div class="flex items-center mb-4">

                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">

                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>

                                </svg>

                            </div>

                            <h3 class="text-lg font-semibold text-gray-900">Measurements</h3>

                        </div>

                        <div class="grid grid-cols-2 gap-2">

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">Height</div>

                                <div class="font-semibold text-gray-900">${measurement.Height || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">{{ __('Chest') }}</div>

                                <div class="font-semibold text-gray-900">${measurement.chati || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">{{ __('Sleeve') }}</div>

                                <div class="font-semibold text-gray-900">${measurement.Sleeve || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">Shoulder</div>

                                <div class="font-semibold text-gray-900">${measurement.Shoulder || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">{{ __('Collar') }}</div>

                                <div class="font-semibold text-gray-900">${measurement.Collar || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">Armpit</div>

                                <div class="font-semibold text-gray-900">${measurement.Armpit || 'N/A'}</div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Style Options -->

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">

                    <div class="flex items-center mb-4">

                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-3">

                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>

                            </svg>

                        </div>

                        <h3 class="text-lg font-semibold text-gray-900">Style Options</h3>

                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-3">

                            <div class="text-sm text-orange-600 font-medium mb-1">{{ __('Kaff') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.Kaff || 'N/A'}</div>

                        </div>

                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-3">

                            <div class="text-sm text-orange-600 font-medium mb-1">{{ __('Sleeve Type') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.sleeve_type || 'N/A'}</div>

                        </div>

                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-3">

                            <div class="text-sm text-orange-600 font-medium mb-1">{{ __('Kalar') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.Kalar || 'N/A'}</div>

                        </div>

                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-3">

                            <div class="text-sm text-orange-600 font-medium mb-1">{{ __('Shalwar') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.Shalwar || 'N/A'}</div>

                        </div>

                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-3">

                            <div class="text-sm text-orange-600 font-medium mb-1">{{ __('Daman') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.Daman || 'N/A'}</div>

                        </div>

                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl p-3">

                            <div class="text-sm text-orange-600 font-medium mb-1">{{ __('Jeb') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.Jeb || 'N/A'}</div>

                        </div>

                    </div>

                </div>



                <!-- Additional Details -->

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">

                    <div class="flex items-center mb-4">

                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mr-3">

                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>

                            </svg>

                        </div>

                        <h3 class="text-lg font-semibold text-gray-900">Additional Details</h3>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Order Date</div>

                                <div class="font-semibold text-gray-900">${measurement.O_date ? new Date(measurement.O_date).toLocaleDateString() : 'N/A'}</div>

                            </div>

                        </div>

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Delivery Date</div>

                                <div class="font-semibold text-gray-900">${measurement.R_date ? new Date(measurement.R_date).toLocaleDateString() : 'Not set'}</div>

                            </div>

                        </div>

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Customer</div>

                                <div class="font-semibold text-gray-900">${measurement.customer_name || 'N/A'}</div>

                            </div>

                        </div>

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Created</div>

                                <div class="font-semibold text-gray-900">${measurement.created_at ? new Date(measurement.created_at).toLocaleDateString() : 'N/A'}</div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        `;

    }



    function displayVestDetails(measurement) {

        document.getElementById('modalContent').innerHTML = `

            <div class="space-y-4">

                <!-- Header Card -->

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-2xl p-4">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center space-x-4">

                            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center">

                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-2xl font-bold text-gray-900">{{ __('Vest Measurement') }}</h2>

                                <p class="text-gray-600">ID: ${measurement.V_M_ID} • ${measurement.customer_name}</p>

                            </div>

                        </div>

                        <div class="text-right">

                            <div class="text-3xl font-bold text-purple-600">$${parseFloat(measurement.vest_rate).toFixed(2)}</div>

                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${measurement.Status === 'complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">

                                <div class="w-2 h-2 rounded-full mr-2 ${measurement.Status === 'complete' ? 'bg-green-500' : 'bg-yellow-500'}"></div>

                                ${measurement.Status.charAt(0).toUpperCase() + measurement.Status.slice(1)}

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Main Content Grid -->

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    <!-- Basic Information -->

                    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">

                        <div class="flex items-center mb-4">

                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">

                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                </svg>

                            </div>

                            <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>

                        </div>

                        <div class="space-y-3">

                            <div class="flex items-center justify-between py-2 border-b border-gray-100">

                                <span class="text-gray-600 flex items-center">

                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>

                                    </svg>

                                    {{ __('Size') }}

                                </span>

                                <span class="font-semibold text-gray-900">${measurement.size}</span>

                            </div>

                            <div class="flex items-center justify-between py-2 border-b border-gray-100">

                                <span class="text-gray-600 flex items-center">

                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>

                                    </svg>

                                    {{ __('Rate') }}

                                </span>

                                <span class="font-semibold text-green-600">$${parseFloat(measurement.vest_rate).toFixed(2)}</span>

                            </div>

                            <div class="flex items-center justify-between py-2">

                                <span class="text-gray-600 flex items-center">

                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                    </svg>

                                    {{ __('Status') }}

                                </span>

                                <span class="font-semibold capitalize">${measurement.Status}</span>

                            </div>

                        </div>

                    </div>



                    <!-- Measurements -->

                    <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow duration-200">

                        <div class="flex items-center mb-4">

                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">

                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>

                                </svg>

                            </div>

                            <h3 class="text-lg font-semibold text-gray-900">Measurements</h3>

                        </div>

                        <div class="grid grid-cols-2 gap-2">

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">Height</div>

                                <div class="font-semibold text-gray-900">${measurement.Height || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">Shoulder</div>

                                <div class="font-semibold text-gray-900">${measurement.Shoulder || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">Armpit</div>

                                <div class="font-semibold text-gray-900">${measurement.Armpit || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">{{ __('Waist') }}</div>

                                <div class="font-semibold text-gray-900">${measurement.Waist || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">{{ __('Shana') }}</div>

                                <div class="font-semibold text-gray-900">${measurement.Shana || 'N/A'}</div>

                            </div>

                            <div class="bg-gray-50 rounded-xl p-2">

                                <div class="text-xs text-gray-500 mb-1">Kalar</div>

                                <div class="font-semibold text-gray-900">${measurement.Kalar || 'N/A'}</div>

                            </div>

                        </div>

                    </div>

                </div>



                <!-- Style Options -->

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">

                    <div class="flex items-center mb-4">

                        <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center mr-3">

                            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>

                            </svg>

                        </div>

                        <h3 class="text-lg font-semibold text-gray-900">Style Options</h3>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 border border-pink-200 rounded-xl p-4">

                            <div class="text-sm text-pink-600 font-medium mb-1">{{ __('Daman') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.Daman || 'N/A'}</div>

                        </div>

                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 border border-pink-200 rounded-xl p-4">

                            <div class="text-sm text-pink-600 font-medium mb-1">{{ __('Nawa Waskat') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.NawaWaskat || 'N/A'}</div>

                        </div>

                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 border border-pink-200 rounded-xl p-4">

                            <div class="text-sm text-pink-600 font-medium mb-1">{{ __('Vest Type') }}</div>

                            <div class="text-gray-900 font-semibold">${measurement.Vest_Type || 'N/A'}</div>

                        </div>

                    </div>

                </div>



                <!-- Additional Details -->

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow duration-200">

                    <div class="flex items-center mb-4">

                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mr-3">

                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>

                            </svg>

                        </div>

                        <h3 class="text-lg font-semibold text-gray-900">Additional Details</h3>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Order Date</div>

                                <div class="font-semibold text-gray-900">${measurement.O_date ? new Date(measurement.O_date).toLocaleDateString() : 'N/A'}</div>

                            </div>

                        </div>

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Delivery Date</div>

                                <div class="font-semibold text-gray-900">${measurement.R_date ? new Date(measurement.R_date).toLocaleDateString() : 'Not set'}</div>

                            </div>

                        </div>

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Customer</div>

                                <div class="font-semibold text-gray-900">${measurement.customer_name || 'N/A'}</div>

                            </div>

                        </div>

                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-xl">

                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">

                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                                </svg>

                            </div>

                            <div>

                                <div class="text-sm text-gray-500">Created</div>

                                <div class="font-semibold text-gray-900">${measurement.created_at ? new Date(measurement.created_at).toLocaleDateString() : 'N/A'}</div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        `;

    }



    function displayError(message) {

        document.getElementById('modalContent').innerHTML = `

            <div class="text-center py-12">

                <div class="w-20 h-20 bg-gradient-to-r from-red-100 to-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-6">

                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>

                    </svg>

                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('Oops! Something went wrong') }}</h3>

                <p class="text-gray-600 text-lg mb-6">${message}</p>

                <button onclick="closeModal()" 

                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors duration-200">

                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>

                    </svg>

                    {{ __('Close') }}

                </button>

            </div>

        `;

    }



    // Close modal when clicking outside

    document.addEventListener('click', function(event) {

        const modal = document.getElementById('measurementModal');

        if (event.target === modal) {

            closeModal();

        }

    });



    // Close modal with Escape key

    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            closeModal();

        }

    });

    // Search functionality for cloth orders
    function searchClothOrders() {
        const searchInput = document.getElementById('clothSearchInput');
        const searchTerm = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('.cloth-order-row');
        
        rows.forEach(row => {
            const id = row.getAttribute('data-id').toString();
            if (id.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function clearClothSearch() {
        document.getElementById('clothSearchInput').value = '';
        const rows = document.querySelectorAll('.cloth-order-row');
        rows.forEach(row => {
            row.style.display = '';
        });
    }

    // Search functionality for vest orders
    function searchVestOrders() {
        const searchInput = document.getElementById('vestSearchInput');
        const searchTerm = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('.vest-order-row');
        
        rows.forEach(row => {
            const id = row.getAttribute('data-id').toString();
            if (id.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function clearVestSearch() {
        document.getElementById('vestSearchInput').value = '';
        const rows = document.querySelectorAll('.vest-order-row');
        rows.forEach(row => {
            row.style.display = '';
        });
    }

    // Add event listeners for search inputs
    document.addEventListener('DOMContentLoaded', function() {
        const clothSearchInput = document.getElementById('clothSearchInput');
        const vestSearchInput = document.getElementById('vestSearchInput');
        
        if (clothSearchInput) {
            clothSearchInput.addEventListener('input', searchClothOrders);
        }
        
        if (vestSearchInput) {
            vestSearchInput.addEventListener('input', searchVestOrders);
        }
    });

</script>

@endsection



