@extends('layout.app')

@section('title', 'Add New Cloth Order')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        {{ __('New Cloth Order') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Create a comprehensive cloth order with measurements and details') }}</p>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md mb-6">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <h3 class="text-red-800 font-semibold">{{ __('Validation Errors') }}</h3>
                </div>
                <ul class="text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form -->
        <form method="POST" action="{{ route('cloth-measurements.store') }}" class="space-y-6">
            @csrf

            <!-- Customer & Order Information Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Customer & Order Information') }}
                    </h2>
                    <p class="text-blue-100 mt-1 text-sm">{{ __('Basic order and customer details') }}</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Customer Selection -->
                        <div>
                            <label for="F_cus_id" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Customer') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="F_cus_id" id="F_cus_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" required>
                                <option value="">{{ __('Select Customer') }}</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->cus_id }}" {{ old('F_cus_id') == $customer->cus_id ? 'selected' : '' }}>
                                        {{ $customer->cus_name }} 
                                        @if($customer->phone)
                                            - {{ $customer->phone->pho_no }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Size -->
                        <div>
                            <label for="size" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Size') }} <span class="text-red-500">*</span>
                            </label>
                            <select name="size" id="size" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" required>
                                <option value="">{{ __('Select Size') }}</option>
                                <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>{{ __('Small') }}</option>
                                <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>{{ __('Large') }}</option>
                            </select>
                        </div>

                        <!-- Cloth Rate -->
                        <div>
                            <label for="cloth_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Cloth Rate') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="cloth_rate" 
                                   id="cloth_rate" 
                                   step="0.01" 
                                   min="0"
                                   value="{{ old('cloth_rate') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white" 
                                   placeholder="0.00"
                                   required>
                        </div>

                        <!-- Order Status -->
                        <div>
                            <label for="order_status" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Order Status') }}
                            </label>
                            <select name="order_status" id="order_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                                <option value="pending" {{ old('order_status', 'pending') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="complete" {{ old('order_status') == 'complete' ? 'selected' : '' }}>{{ __('Complete') }}</option>
                            </select>
                        </div>

                        <!-- Order Date -->
                        <div>
                            <label for="O_date" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Order Date') }}
                            </label>
                            <input type="date" 
                                   name="O_date" 
                                   id="O_date" 
                                   value="{{ old('O_date', date('Y-m-d')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        </div>

                        <!-- Receive Date -->
                        <div>
                            <label for="R_date" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Receive Date') }}
                            </label>
                            <input type="date" 
                                   name="R_date" 
                                   id="R_date" 
                                   value="{{ old('R_date') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body Measurements Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                        {{ __('Body Measurements') }}
                    </h2>
                    <p class="text-emerald-100 mt-1 text-sm">{{ __('Detailed measurements for perfect fitting') }}</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Height -->
                        <div>
                            <label for="Height" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Height') }}
                            </label>
                            <input type="text" 
                                   name="Height" 
                                   id="Height" 
                                   value="{{ old('Height') }}"
                                   maxlength="10"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter height') }}">
                        </div>

                        <!-- Chati -->
                        <div>
                            <label for="chati" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Chati') }}
                            </label>
                            <input type="text" 
                                   name="chati" 
                                   id="chati" 
                                   value="{{ old('chati') }}"
                                   maxlength="255"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter chati') }}">
                        </div>

                        <!-- Sleeve -->
                        <div>
                            <label for="Sleeve" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Sleeve') }}
                            </label>
                            <input type="number" 
                                   name="Sleeve" 
                                   id="Sleeve" 
                                   value="{{ old('Sleeve') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter sleeve') }}">
                        </div>

                        <!-- Shoulder -->
                        <div>
                            <label for="Shoulder" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Shoulder') }}
                            </label>
                            <input type="number" 
                                   name="Shoulder" 
                                   id="Shoulder" 
                                   value="{{ old('Shoulder') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter shoulder') }}">
                        </div>

                        <!-- Collar -->
                        <div>
                            <label for="Collar" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Collar') }}
                            </label>
                            <input type="text" 
                                   name="Collar" 
                                   id="Collar" 
                                   value="{{ old('Collar') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter collar') }}">
                        </div>

                        <!-- Armpit -->
                        <div>
                            <label for="Armpit" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Armpit') }}
                            </label>
                            <input type="text" 
                                   name="Armpit" 
                                   id="Armpit" 
                                   value="{{ old('Armpit') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter armpit') }}">
                        </div>

                        <!-- Skirt -->
                        <div>
                            <label for="Skirt" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Skirt') }}
                            </label>
                            <input type="text" 
                                   name="Skirt" 
                                   id="Skirt" 
                                   value="{{ old('Skirt') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter skirt') }}">
                        </div>

                        <!-- Trousers -->
                        <div>
                            <label for="Trousers" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Trousers') }}
                            </label>
                            <input type="text" 
                                   name="Trousers" 
                                   id="Trousers" 
                                   value="{{ old('Trousers') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter trousers') }}">
                        </div>

                        <!-- Kaff -->
                        <div>
                            <label for="Kaff" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Kaff') }}
                            </label>
                            <input type="text" 
                                   name="Kaff" 
                                   id="Kaff" 
                                   value="{{ old('Kaff') }}"
                                   maxlength="40"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter kaff') }}">
                        </div>

                        <!-- Pacha -->
                        <div>
                            <label for="Pacha" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Pacha') }}
                            </label>
                            <input type="text" 
                                   name="Pacha" 
                                   id="Pacha" 
                                   value="{{ old('Pacha') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter pacha') }}">
                        </div>

                        <!-- Sleeve Type -->
                        <div>
                            <label for="sleeve_type" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Sleeve Type') }}
                            </label>
                            <input type="text" 
                                   name="sleeve_type" 
                                   id="sleeve_type" 
                                   value="{{ old('sleeve_type') }}"
                                   maxlength="40"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter sleeve type') }}">
                        </div>

                        <!-- Kalar -->
                        <div>
                            <label for="Kalar" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Kalar') }}
                            </label>
                            <input type="text" 
                                   name="Kalar" 
                                   id="Kalar" 
                                   value="{{ old('Kalar') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter kalar') }}">
                        </div>

                        <!-- Shalwar -->
                        <div>
                            <label for="Shalwar" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Shalwar') }}
                            </label>
                            <input type="text" 
                                   name="Shalwar" 
                                   id="Shalwar" 
                                   value="{{ old('Shalwar') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter shalwar') }}">
                        </div>

                        <!-- Yakhan -->
                        <div>
                            <label for="Yakhan" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Yakhan') }}
                            </label>
                            <input type="text" 
                                   name="Yakhan" 
                                   id="Yakhan" 
                                   value="{{ old('Yakhan') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter yakhan') }}">
                        </div>

                        <!-- Daman -->
                        <div>
                            <label for="Daman" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Daman') }}
                            </label>
                            <input type="text" 
                                   name="Daman" 
                                   id="Daman" 
                                   value="{{ old('Daman') }}"
                                   maxlength="15"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter daman') }}">
                        </div>

                        <!-- Jeb -->
                        <div>
                            <label for="Jeb" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Jeb') }}
                            </label>
                            <input type="text" 
                                   name="Jeb" 
                                   id="Jeb" 
                                   value="{{ old('Jeb') }}"
                                   maxlength="60"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-white" 
                                   placeholder="{{ __('Enter jeb') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('cloth-measurements.index') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    {{ __('Create Cloth Order') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


