@extends('layout.app')

@section('title', 'Cloth Assignments Management')

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
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Cloth Assignments Management') }}</h1>
                <p class="text-gray-600">{{ __('Assign work to employees and track progress') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('cloth-assignments.create') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold rounded-xl shadow-lg hover:from-orange-700 hover:to-red-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Assign New Work') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">{{ __('Total Assignments') }}</p>
                    <p class="text-3xl font-bold" id="total-assignments">{{ ($pendingCustomers->count() ?? 0) + ($completeCustomers->count() ?? 0) }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">{{ __('Completed') }}</p>
                    <p class="text-3xl font-bold" id="completed-assignments">{{ $completeCustomers->count() ?? 0 }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-yellow-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">{{ __('Pending') }}</p>
                    <p class="text-3xl font-bold" id="pending-assignments">{{ $pendingCustomers->count() ?? 0 }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">{{ __('Total Value') }}</p>
                    <p class="text-3xl font-bold" id="total-value">$0</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Pending Assignments Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">{{ __('Pending Assignments') }}</h3>
                        <p class="text-yellow-100">{{ __('Manage work that needs to be assigned') }}</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-3xl font-bold text-gray-900">{{ $pendingCustomers->count() ?? 0 }}</span>
                    <span class="text-sm text-gray-500">{{ __('pending assignments') }}</span>
                    </div>
                <a href="{{ route('cloth-assignments.pending') }}" 
                   class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:from-yellow-600 hover:to-orange-700 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    {{ __('View Pending') }}
                </a>
                    </div>
        </div>

        <!-- Complete Assignments Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">{{ __('Complete Assignments') }}</h3>
                        <p class="text-green-100">{{ __('View completed work assignments') }}</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-3xl font-bold text-gray-900">{{ $completeCustomers->count() ?? 0 }}</span>
                    <span class="text-sm text-gray-500">{{ __('completed assignments') }}</span>
                </div>
                <a href="{{ route('cloth-assignments.complete-view') }}" 
                   class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    {{ __('View Complete') }}
                </a>
                </div>
            </div>
    </div>

    <!-- Quick Overview Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">{{ __('Recent Assignments Overview') }}</h2>
            <p class="text-gray-600 mt-1">{{ __('Quick view of recent assignments') }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Last Updated') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingCustomers->take(5) as $cust)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-orange-500 to-red-500 flex items-center justify-center text-white font-semibold text-sm">
                                        #{{ $cust->cus_id }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $cust->cus_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $cust->phone->pho_no ?? 'No Phone' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ __('Pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ __('Recently added') }}
                            </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('cloth-assignments.pending') }}" class="text-orange-600 hover:text-orange-900">
                                {{ __('View Details') }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            {{ __('No pending assignments found') }}
                        </td>
                   </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
