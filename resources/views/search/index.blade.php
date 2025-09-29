@extends('layout.app')

@section('title', __('Customer Search & Records'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Error Messages -->
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Customer Search & Records') }}</h1>
                <p class="text-gray-600">{{ __('Search customers by phone number and view comprehensive records') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('customers.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Customers') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Search Customer by Phone') }}</h2>
                <p class="text-gray-600">{{ __('Enter phone number to find customer records and view detailed information') }}</p>
            </div>

            <form action="{{ route('search.by-phone') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-4 gap-3 items-center">
                    <div class="relative col-span-2">
                        <div class="absolute inset-y-0 left-0 pl-1  flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                               name="phone_number" 
                               placeholder="{{ __('Enter phone number to search for customer records') }}"
                               class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200"
                               value="{{ request('phone_number') }}"
                               required>
                    </div>
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-2 px-3 rounded-lg shadow hover:from-blue-700 hover:to-purple-700 transition-all duration-200 flex items-center justify-center text-sm">
                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        {{ __('Search Customer') }}
                    </button>
                    <button type="button" 
                            onclick="document.querySelector('input[name=phone_number]').value = ''; document.querySelector('input[name=phone_number]').focus();"
                            class="px-3 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm">
                        {{ __('Clear') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">{{ __('Total Customers') }}</p>
                    <p class="text-3xl font-bold">{{ \App\Models\Customer::count() }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.196M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a3 3 0 11-6 0 3 3 0 016 0zm-1 4a3 3 0 00-3 3v2h8v-2a3 3 0 00-3-3z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">{{ __('Active Orders') }}</p>
                    <p class="text-3xl font-bold">{{ \App\Models\ClothM::where('order_status', 'pending')->count() + \App\Models\VestM::where('Status', 'pending')->count() }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">{{ __('Total Payments') }}</p>
                    <p class="text-3xl font-bold">${{ number_format(\App\Models\CustomerPayment::sum('amount'), 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-xl p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Customers -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900">{{ __('Recent Customers') }}</h3>
            <a href="{{ route('customers.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                {{ __('View All') }}
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach(\App\Models\Customer::latest()->limit(6)->get() as $customer)
            <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors duration-200 cursor-pointer"
                 onclick="window.location.href='{{ route('search.show', $customer->phone->pho_no) }}'">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 h-10 w-10">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr($customer->cus_name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $customer->cus_name }}</p>
                        <p class="text-xs text-gray-500">{{ $customer->phone ? $customer->phone->pho_no : 'No phone' }} • ID: {{ $customer->cus_id }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Search Instructions -->
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200/60">
        <div class="text-center">
            <div class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('How to Search') }}</h2>
            <p class="text-gray-600 text-lg mb-6">{{ __('Enter a customer phone number in the search box above to find all their records, orders, and payment information.') }}</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('Order Records') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('View all cloth and vest measurements with status') }}</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('Payment History') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Track all payments and remaining balance') }}</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('Quick Actions') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Record payments and manage orders') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name=phone_number]');
        
        if (searchInput) {
            // Focus on search input when page loads
            searchInput.focus();
            
            // Add enter key support
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.closest('form').submit();
                }
            });
        }
    });
</script>
@endsection
