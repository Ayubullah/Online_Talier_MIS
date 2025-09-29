@extends('layout.app')
@section('title', __('Record Customer Payment'))

@section('content')
<div class="flex-1 overflow-hidden">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 text-white px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ __('Record Customer Payment') }}</h1>
                <p class="text-green-100 text-lg">{{ __('Add a new payment record for customer') }}</p>
            </div>
            <div class="text-right">
                @if($customer)
                    <p class="text-green-100 text-sm">{{ __('Customer') }}</p>
                    <p class="text-white font-semibold text-lg">{{ $customer->cus_name }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="p-6 space-y-8">
        @if($customer)
        <!-- Customer Summary -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Customer Summary') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-xl">
                    <p class="text-sm text-gray-600">{{ __('Total Orders') }}</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $customer->clothMeasurements->count() + $customer->vestMeasurements->count() }}</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-xl">
                    <p class="text-sm text-gray-600">{{ __('Total Value') }}</p>
                    <p class="text-2xl font-bold text-purple-600">AFN {{ number_format($customer->total_order_value, 2) }}</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-xl">
                    <p class="text-sm text-gray-600">{{ __('Total Paid') }}</p>
                    <p class="text-2xl font-bold text-green-600">AFN {{ number_format($customer->total_paid, 2) }}</p>
                </div>
                <div class="text-center p-4 bg-orange-50 rounded-xl">
                    <p class="text-sm text-gray-600">{{ __('Remaining') }}</p>
                    <p class="text-2xl font-bold text-orange-600">AFN {{ number_format($customer->total_owed, 2) }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment Form -->
        <div class="bg-white rounded-2xl p-6 border border-gray-200/60 shadow-lg">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ __('Payment Information') }}</h3>
            
            <form method="POST" action="{{ route('customer-payments.store') }}" class="space-y-6">
                @csrf
                
                <!-- Customer Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_search" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Search Customer by Phone') }}
                        </label>
                        <div class="relative">
                            <input type="text" id="customer_search" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm" 
                                   placeholder="{{ __('Enter phone number to search') }}">
                            <div id="customer_search_results" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg hidden max-h-60 overflow-y-auto"></div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Selected Customer') }}
                        </label>
                        <select id="customer_id" name="customer_id" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm">
                            <option value="">{{ __('Select a customer') }}</option>
                            @if($customer)
                                <option value="{{ $customer->cus_id }}" selected>{{ $customer->cus_name }} ({{ $customer->phone ? $customer->phone->pho_no : 'No phone' }})</option>
                            @endif
                        </select>
                        @error('customer_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Payment Amount') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="amount" name="amount" step="0.01" min="0.01" required
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm"
                               placeholder="{{ __('Enter payment amount') }}">
                        @error('amount')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Payment Method') }} <span class="text-red-500">*</span>
                        </label>
                        <select id="payment_method" name="payment_method" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm">
                            <option value="">{{ __('Select payment method') }}</option>
                            <option value="cash">{{ __('Cash') }}</option>
                            <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                            <option value="mobile_money">{{ __('Mobile Money') }}</option>
                            <option value="card">{{ __('Card') }}</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Payment Date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="payment_date" name="payment_date" required
                               value="{{ old('payment_date', date('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm">
                        @error('payment_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Reference Number') }}
                        </label>
                        <input type="text" id="reference_number" name="reference_number"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm"
                               placeholder="{{ __('Enter reference number (optional)') }}">
                        @error('reference_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Notes') }}
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm"
                              placeholder="{{ __('Enter any additional notes (optional)') }}"></textarea>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ $customer ? route('customers.show', $customer->cus_id) : route('customers.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                        {{ __('Cancel') }}
                    </a>
                    
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        {{ __('Record Payment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerSearch = document.getElementById('customer_search');
    const customerSelect = document.getElementById('customer_id');
    const searchResults = document.getElementById('customer_search_results');
    
    let searchTimeout;
    
    customerSearch.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 3) {
            searchResults.classList.add('hidden');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            fetch(`{{ route('customer-payments.search-by-phone') }}?phone_number=${encodeURIComponent(query)}`)
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
                     onclick="selectCustomer(${customer.id}, '${customer.name}', '${customer.phone}')">
                    <div class="font-semibold text-gray-900">${customer.name}</div>
                    <div class="text-sm text-gray-600">Phone: ${customer.phone}</div>
                    <div class="text-sm text-gray-500">
                        Orders: ${customer.cloth_orders + customer.vest_orders} | 
                        Owed: AFN ${customer.total_owed.toFixed(2)}
                    </div>
                </div>
            `).join('');
        }
        
        searchResults.classList.remove('hidden');
    }
    
    window.selectCustomer = function(customerId, customerName, customerPhone) {
        customerSelect.innerHTML = `<option value="${customerId}" selected>${customerName} (${customerPhone})</option>`;
        searchResults.classList.add('hidden');
        customerSearch.value = '';
    };
    
    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!customerSearch.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection
