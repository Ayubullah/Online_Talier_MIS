@extends('layout.app')

@section('title', 'Cloth Order Details' . ($clothM->customer ? ' - ' . $clothM->customer->cus_name : ''))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Cloth Order Details') }}</h1>
                <p class="text-gray-600">{{ __('View detailed information about') }} {{ $clothM->customer ? $clothM->customer->cus_name : __('Customer') }} {{ __('\'s cloth order') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                @if($clothM && $clothM->cm_id)
                <a href="{{ route('cloth.edit', $clothM->cm_id) }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-700 hover:to-blue-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('Edit Cloth Order') }}
                </a>
                <a href="{{ route('cloth.print-size', $clothM->cm_id) }}" target="_blank"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:from-green-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('Print Size') }}
                </a>
                <a href="{{ route('cloth.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to List') }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Summary Card -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ __('Order Summary') }}</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Size') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rate') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assigned To') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-teal-500 to-cyan-500 flex items-center justify-center text-white font-semibold">
                                        #{{ $clothM->cm_id }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Order #{{ $clothM->cm_id }}</div>
                                    <div class="text-sm text-gray-500">{{ $clothM->O_date ? $clothM->O_date->format('M d, Y') : ($clothM->created_at ? $clothM->created_at->format('M d, Y') : 'N/A') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($clothM->customer)
                            <div class="text-sm font-medium text-gray-900">{{ $clothM->customer->cus_name }}</div>
                            <div class="text-sm text-gray-500">ID: {{ $clothM->customer->cus_id }}</div>
                            @else
                            <div class="text-sm font-medium text-gray-400">{{ __('Unknown Customer') }}</div>
                            <div class="text-sm text-gray-400">ID: N/A</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                @if($clothM->size == 'S') bg-blue-100 text-blue-800
                                @elseif($clothM->size == 'L') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ strtoupper($clothM->size) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($clothM->cloth_rate, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($clothM->order_status == 'complete') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($clothM->order_status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($clothM->clothAssignments->count() > 0)
                                <div class="space-y-1">
                                    @foreach($clothM->clothAssignments as $assignment)
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                            {{ $assignment->employee->emp_name ?? 'Unknown' }}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400">{{ __('Not Assigned') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($clothM && $clothM->cm_id)
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('cloth.edit', $clothM->cm_id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors duration-200" title="{{ __('Edit') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('cloth.print-size', $clothM->cm_id) }}" target="_blank"
                                   class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50 transition-colors duration-200" title="{{ __('Print Size') }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                </a>
                            </div>
                            @else
                            <span class="text-gray-400">{{ __('N/A') }}</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

        <div class="grid grid-cols-1 lg:grid-cols-6 gap-8">
        <!-- Cloth Profile Card -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-8 text-center">
                    @if($clothM->customer)
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($clothM->customer->cus_name, 0, 2)) }}
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $clothM->customer->cus_name }}</h2>
                    @else
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                        ??
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">{{ __('Unknown Customer') }}</h2>
                    @endif
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-white/20 text-white">
                        {{ __('Cloth Order') }}
                    </span>
                </div>

                <!-- Profile Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Order ID') }}</span>
                            <span class="text-sm font-semibold text-gray-900">#{{ $clothM->cm_id }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Phone Number') }}</span>
                            @if($clothM->customer && $clothM->customer->phone)
                                <span class="text-sm font-semibold text-gray-900">{{ $clothM->customer->phone->pho_no }}</span>
                            @else
                                <span class="text-sm text-gray-400">{{ __('No phone') }}</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Size') }}</span>
                            <span class="text-sm font-semibold text-gray-900">{{ strtoupper($clothM->size) }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-500">{{ __('Rate') }}</span>
                            <span class="text-lg font-bold text-blue-600">${{ number_format($clothM->cloth_rate, 2) }}</span>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-medium text-gray-500">{{ __('Status') }}</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $clothM->order_status === 'complete' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($clothM->order_status ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Measurement Details -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                    {{ __('Measurements') }}
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Height') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Height ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Chati') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->chati ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Sleeve') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Sleeve ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Shoulder') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Shoulder ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Collar') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Collar ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Armpit') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Armpit ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Skirt') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Skirt ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Trousers') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Trousers ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Kaff') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Kaff ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Pacha') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Pacha ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Kalar') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Kalar ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Shalwar') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Shalwar ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Yakhan') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Yakhan ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Daman') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Daman ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ __('Jeb') }}</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $clothM->Jeb ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('Order Information') }}
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-500">{{ __('Order Date') }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $clothM->O_date ? $clothM->O_date->format('M d, Y') : 'N/A' }}</span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-500">{{ __('Receive Date') }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $clothM->R_date ? $clothM->R_date->format('M d, Y') : 'N/A' }}</span>
                    </div>

                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium text-gray-500">{{ __('Created At') }}</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $clothM->created_at ? $clothM->created_at->format('M d, Y H:i') : 'N/A' }}</span>
                    </div>
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
                            <p class="text-sm font-medium text-gray-500">{{ __('Order Value') }}</p>
                            <p class="text-2xl font-bold text-blue-600">${{ number_format($clothM->cloth_rate, 2) }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Order Status') }}</p>
                            <p class="text-2xl font-bold {{ $clothM->order_status === 'complete' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($clothM->order_status) }}
                            </p>
                        </div>
                        <div class="{{ $clothM->order_status === 'complete' ? 'bg-green-100' : 'bg-yellow-100' }} rounded-xl p-3">
                            <svg class="w-6 h-6 {{ $clothM->order_status === 'complete' ? 'text-green-600' : 'text-yellow-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($clothM->order_status === 'complete')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @endif
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Customer Information') }}</h3>
                        @if($clothM->customer && $clothM->customer->cus_id)
                        <a href="{{ route('customers.show', $clothM->customer->cus_id) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            {{ __('View Full Profile') }}
                        </a>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Full Name') }}</h4>
                            <p class="text-lg font-semibold text-gray-900">{{ $clothM->customer ? $clothM->customer->cus_name : __('Unknown Customer') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Phone Number') }}</h4>
                            @if($clothM->customer && $clothM->customer->phone)
                                <p class="text-lg font-semibold text-gray-900">{{ $clothM->customer->phone->pho_no }}</p>
                            @else
                                <p class="text-gray-400">{{ __('No phone number provided') }}</p>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Customer ID') }}</h4>
                            <p class="text-lg font-semibold text-gray-900">#{{ $clothM->customer ? $clothM->customer->cus_id : 'N/A' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">{{ __('Invoice ID') }}</h4>
                            @if($clothM->customer && $clothM->customer->invoice)
                                <p class="text-lg font-semibold text-gray-900">#{{ $clothM->customer->invoice->inc_id }}</p>
                            @else
                                <p class="text-gray-400">{{ __('No invoice linked') }}</p>
                            @endif
                        </div>
                    </div>

                    @if($clothM->customer && $clothM->customer->invoice)
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-700 mb-2">{{ __('Invoice Details') }}</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-blue-600">{{ __('Total Amount') }}:</span>
                                <span class="font-semibold">${{ number_format($clothM->customer->invoice->total_amt ?? 0, 2) }}</span>
                            </div>
                            <div>
                                <span class="text-blue-600">{{ __('Status') }}:</span>
                                <span class="font-semibold">{{ ucfirst($clothM->customer->invoice->status ?? 'unknown') }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Assignment Information -->
            @if($clothM->clothAssignments->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Assigned Employees') }}</h3>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($clothM->clothAssignments as $assignment)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $assignment->employee->emp_name ?? 'Unknown Employee' }}</p>
                                    <p class="text-sm text-gray-500">{{ $assignment->assigned_at ? $assignment->assigned_at->format('M d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $assignment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($assignment->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Quick Actions') }}</h3>
                <div class="space-y-3">
                    @if($clothM && $clothM->cm_id)
                    <a href="{{ route('cloth.edit', $clothM->cm_id) }}"
                       class="flex items-center p-3 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('Edit Cloth Order') }}
                    </a>

                    @if($clothM->customer && $clothM->customer->cus_id)
                    <a href="{{ route('cloth-measurements.create', ['customer' => $clothM->customer->cus_id]) }}"
                       class="flex items-center p-3 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('Add Cloth Measurement') }}
                    </a>
                    @endif

                    @if($clothM->customer && $clothM->customer->cus_id)
                    <a href="{{ route('customer-payments.create', ['customer_id' => $clothM->customer->cus_id]) }}"
                       class="flex items-center p-3 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        {{ __('Record Payment') }}
                    </a>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
