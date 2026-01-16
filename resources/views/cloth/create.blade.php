@extends('layout.app')

@section('title', 'Add New Cloth Order')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        {{ __('New Tailoring Order') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Create a comprehensive tailoring order with measurements and details') }}</p>
                </div>
                
                <!-- Navigation Tabs -->
                <div class="flex bg-gray-100 rounded-2xl p-1 shadow-inner">
                    <button id="single-tab" class="tab-btn px-6 py-3 bg-white text-indigo-600 font-semibold rounded-xl shadow-sm border border-indigo-100 transition-all duration-200" data-tab="single">
                        {{ __('Single') }}
                    </button>
                    <button id="family-tab" class="tab-btn px-6 py-3 text-gray-600 font-semibold rounded-xl hover:bg-white/50 transition-all duration-200" data-tab="family">
                        {{ __('Family') }}
                    </button>
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
        <form method="POST" action="{{ route('cloth.store') }}" class="space-y-6" id="tailoring-form">
            @csrf
            <input type="hidden" id="form-mode" name="form_mode" value="single">

            <!-- Payment Details Section - Moved to Top -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        {{ __('Payment Details') }}
                    </h2>
                    <p class="text-emerald-100 mt-1 text-sm">{{ __('Order pricing and payment information') }}</p>
                </div>
                
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <!-- Total Amount -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-3 border border-blue-200">
                            <label class="block text-xs font-bold text-blue-800 mb-1 flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('Total') }}
                                </span>
                                <span class="text-blue-600 text-xs">مجموعه</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       name="Total"
                                       id="total"
                                       class="w-full px-3 py-2 border border-blue-300 rounded-md focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 text-sm font-semibold text-blue-900 bg-white hover:bg-blue-50 total"
                                       placeholder="{{ __('Enter total') }}"
                                       value="{{ old('Total') }}"
                                       required>
                            </div>
                        </div>

                        <!-- Paid Amount -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-3 border border-green-200">
                            <label class="block text-xs font-bold text-green-800 mb-1 flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('Paid') }}
                                </span>
                                <span class="text-green-600 text-xs">رسید</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="Paid" 
                                       id="paid" 
                                       class="w-full px-3 py-2 border border-green-300 rounded-md focus:ring-1 focus:ring-green-400 focus:border-green-400 transition-all duration-200 text-sm font-semibold text-green-900 bg-white hover:bg-green-50 paid" 
                                       placeholder="{{ __('Enter paid') }}" 
                                       value="{{ old('Paid') }}"
                                       required>
                            </div>
                        </div>

                        <!-- Remaining Amount -->
                        <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-lg p-3 border border-red-200">
                            <label class="block text-xs font-bold text-red-800 mb-1 flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('Remain') }}
                                </span>
                                <span class="text-red-600 text-xs">باقی</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="Remian" 
                                       id="remain" 
                                       class="w-full px-3 py-2 border border-red-300 rounded-md bg-red-100 text-red-900 font-semibold text-sm remain" 
                                       placeholder="{{ __('Remaining') }}" 
                                       readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status Indicator with Action Buttons -->
                    <div class="mt-3 bg-gray-50 rounded-lg p-3 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div id="payment-status" class="w-2 h-2 rounded-full bg-gray-400"></div>
                                <span id="payment-status-text" class="text-xs font-medium text-gray-600">{{ __('Payment Status') }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between gap-4 flex-1 ml-4">
                                <div class="text-xs text-gray-500">
                                    {{ __('Auto-calculated') }}
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-md text-xs">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family Phone Section (shown only in family mode) -->
            <div id="family-phone-section" class="bg-white rounded-2xl shadow-xl overflow-hidden border border-white/20" style="display: none;">
                <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.121L16.5 14l-2.5-2.5L12 13.5l-2-2L8.5 14l-.304 1.879A3 3 0 003 18v2h5m9 0v-5a2 2 0 00-2-2h-1m-3.5-2l2.5 2.5L16.5 14"></path>
                        </svg>
                        {{ __('Family Information') }}
                    </h2>
                    <p class="text-purple-100 mt-1 text-sm">{{ __('Shared family details for all members') }}</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Family Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Family Name') }} <span class="text-red-500">*</span>
                                <span class="float-right text-gray-500 text-sm">نام خانواده</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    id="family-name"
                                    name="family_name" 
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
                                    placeholder="{{ __('Enter family name') }}">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.121L16.5 14l-2.5-2.5L12 13.5l-2-2L8.5 14l-.304 1.879A3 3 0 003 18v2h5m9 0v-5a2 2 0 00-2-2h-1m-3.5-2l2.5 2.5L16.5 14"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Family Phone Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Family Phone Number') }} <span class="text-red-500">*</span>
                                <span class="float-right text-gray-500 text-sm">شماره خانواده</span>
                            </label>
                            <div class="relative">
                                <input type="tel" 
                                    id="family-phone"
                                    name="family_phone" 
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
                                    placeholder="(xxx) xxx-xxxx"
                                    maxlength="15">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502ل4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div id="family-phone-message" class="mt-1 text-sm"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Measurements Section -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                                {{ __('Cloth Measurements') }}
                            </h2>
                            <p class="text-emerald-100 mt-1">{{ __('Detailed measurements for perfect vest fitting') }}</p>
                        </div>
                        
                        <!-- Add Measurement Button -->
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-white">
                                Total Measurements: <span id="measurement-count" class="font-semibold bg-white/20 px-2 py-1 rounded">1</span>
                            </div>
                            <button type="button" id="add-measurement" class="px-4 py-2 bg-white text-emerald-600 rounded-lg hover:bg-emerald-50 transition-all duration-200 flex items-center gap-2 font-semibold shadow-lg hover:scale-105 active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span>Add Measurement</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Measurement Sections Container -->
                    <div id="measurement-sections">
                        <!-- Single Measurement Section -->
                        <div class="measurement-section bg-white rounded-xl shadow-lg p-6 mb-6">
                            <!-- Customer Information inside section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Customer Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Customer Name') }} <span class="text-red-500">*</span>
                                        <span class="float-right text-gray-500 text-sm">اسم</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text"
                                            name="custname[]"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
                                            placeholder="{{ __('Enter customer name') }}"
                                            required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone Number (hidden in family mode) -->
                                <div class="individual-phone-field">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Phone Number') }}
                                        <span class="float-right text-gray-500 text-sm">شماره تماس</span>
                                    </label>
                                    <div class="relative">
                                        <input type="tel"
                                            name="phone[]"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
                                            placeholder="(xxx) xxx-xxxx"
                                            maxlength="15"
                                            required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502ل4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="phone-message mt-1 text-sm"></div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Column 1: Basic Measurements -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">{{ __('Basic Measurements') }}</h3>
                            
                            <!-- Clothes Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Clothes Type') }}
                                </label>
                                <select name="cloth_size[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select Size') }}</option>
                                    <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>{{ __('Large') }}</option>
                                    <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>{{ __('Small') }}</option>
                                </select>
                            </div>

                            <!-- Height -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Height') }}
                                    <span class="float-right text-gray-500 text-xs">قد</span>
                                </label>
                                <input type="text" name="Height[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter height') }}" required>
                            </div>

                            <!-- Shoulder -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shoulder') }}
                                    <span class="float-right text-gray-500 text-xs">شانه</span>
                                </label>
                                <input type="text" name="Shoulder[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter shoulder measurement') }}" required>
                            </div>

                            <!-- Sleeve -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Sleeve') }}
                                    <span class="float-right text-gray-500 text-xs">آستین</span>
                                </label>
                                <input type="text" name="Sleeve[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter sleeve measurement') }}" required>
                            </div>

                            <!-- Collar -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Collar') }}
                                    <span class="float-right text-gray-500 text-xs">یخن</span>
                                </label>
                                <input type="text" name="Collar[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter collar measurement') }}" required>
                            </div>

                            <!-- Armpit -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Armpit') }}
                                    <span class="float-right text-gray-500 text-xs">بغل</span>
                                </label>
                                <input type="text" name="Armpit[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter armpit measurement') }}" required>
                            </div>
                        </div>

                        <!-- Column 2: Body Measurements -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">{{ __('Body Details') }}</h3>
                            
                            <!-- Chati -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Chati') }}
                                    <span class="float-right text-gray-500 text-xs">چهاتی</span>
                                </label>
                                <input type="text" name="chati[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter chati measurement') }}" required>
                            </div>

                            <!-- Skirt -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Skirt') }}
                                    <span class="float-right text-gray-500 text-xs">دامن</span>
                                </label>
                                <input type="text" name="Skirt[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter skirt measurement') }}" required>
                            </div>

                            <!-- Trousers -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Trousers') }}
                                    <span class="float-right text-gray-500 text-xs">قد تنبان</span>
                                </label>
                                <input type="text" name="Trouser[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter trouser measurement') }}" required>
                            </div>

                            <!-- Leg Opening -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Leg Opening') }}
                                    <span class="float-right text-gray-500 text-xs">پاچه</span>
                                </label>
                                <input type="text" name="pacha[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter leg opening measurement') }}" required>
                            </div>
                        </div>

                        <!-- Column 3: Style Options -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">{{ __('Style Options') }}</h3>
                            
                            <!-- Kaff Type with Size -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Kaff Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع کف</span>
                                </label>
                                <div class="flex space-x-1">
                                    <input type="text" name="Kaff[]" list="kaff-options" class="flex-1 px-1 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Select kaff type') }}" required>
                                    <input type="text" name="size_kaf[]" class="w-10 px-1 py-3 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Size') }}">
                                </div>
                                <datalist id="kaff-options">
                                    <option value="null">null</option>
                                    <option value="گول کف">گول کف</option>
                                    <option value="چورس کف">چورس کف</option>
                                    <option value="گول پلیتدار کف">گول پلیتدار کف</option>
                                    <option value="چورس پلیت دار کف">چورس پلیت دار کف</option>
                                </datalist>
                            </div>

                            <!-- Sleeve Type with Size -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1 mt-1">
                                    {{ __('Sleeve Type') }}
                                    <span class="float-right text-gray-500 text-xs">أنواع أستين</span>
                                </label>
                                <div class="flex space-x-2">
                                    <input type="text" name="sleeve_type[]" list="sleeve-options" class="flex-1 px-1 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Select sleeve type') }}" required>
                                    <input type="text" name="size_sleve[]" class="w-10 px-1 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Size') }}">
                                </div>
                                <datalist id="sleeve-options">
                                    <option value="null">null</option>
                                    <option value="ساده">ساده</option>
                                    <option value="مژه دار">مژه دار</option>
                                    <option value="دانه دار">دانه دار</option>
                                    <option value="سه توكمه">سه توكمه</option>
                                    <option value="یو اینچ خط">یو اینچ خط</option>
                                    <option value="نیم اینچ خط">نیم اینچ خط</option>
                                </datalist>
                            </div>

                            <!-- Kalar Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Kalar Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع کالر</span>
                                </label>
                                <select name="Kalar[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="هندی">هندی</option>
                                    <option value="قاسمی">قاسمی</option>
                                    <option value="سینه پور">سینه پور</option>
                                    <option value="کالر">کالر</option>
                                    <option value="پوره بین">پوره بین</option>
                                    <option value="نیمه بین">نیمه بین</option>
                                    <option value="عریی">عریی</option>
                                </select>
                            </div>

                            <!-- Shalwar Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shalwar Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع تنبان</span>
                                </label>
                                <select name="Shalwar[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="ساده">ساده</option>
                                    <option value="نیمه گیبی">نیمه گیبی</option>
                                    <option value="پول گیبی">پول گیبی</option>
                                    <option value="سه درزه">سه درزه</option>
                                </select>
                            </div>

                            <!-- Daman Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Daman Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع دامن</span>
                                </label>
                                <select name="Daman[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="گول">گول</option>
                                    <option value="چهار کنج">چهار کنج</option>
                                    <option value="دوه اینچ قات">دوه اینچ قات</option>
                                    <option value="دری اینچ قات">دری اینچ قات</option>
                                </select>
                            </div>
                        </div>

                        <!-- Column 4: Order Details -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">{{ __('Order Details') }}</h3>
                            
                            <!-- Jeb Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Jeb Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع جیب</span>
                                </label>
                                <input type="text" name="Jeb[]" class="jeb-input w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50 mb-2" placeholder="{{ __('Selected jeb types') }}">
                                <select class="jeb-select w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50">
                                    <option value="" disabled selected>{{ __('Select jeb type') }}</option>
                                    <option value="روي">روي</option>
                                    <option value="بغل">بغل</option>
                                    <option value="تنبان">تنبان</option>
                                    <option value="بلوچی تنبان">بلوچی جيب</option>
                                </select>
                            </div>
                            
                            <div class="bg-blue-100 backdrop-blur-md rounded-xl p-4 shadow-inner border border-gray-200">
                                <!-- Order Date -->
                                <div class="">
                                    <label class="block text-xs font-medium text-gray-700 mb-1 mt-3">
                                        {{ __('Order Date') }}
                                        <span class="float-right text-gray-500 text-xs">تاریخ فرمایش</span>
                                    </label>
                                    <input type="date" name="O_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" required>
                                </div>

                                <!-- Receive Date -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Receive Date') }}
                                        <span class="float-right text-gray-500 text-xs">تاریخ دریافت</span>
                                    </label>
                                    <input type="date" name="R_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" required>
                                </div>

                                <!-- Code & Rate in one row -->
                                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                                    <!-- Code -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ __('Code') }}
                                            <span class="float-right text-gray-500 text-xs">کود </span>
                                        </label>
                                        <input list="codeList" id="codeInput" name="code" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" placeholder="{{ __('code ...') }}" autocomplete="off" value="{{ old('code') }}">
                                        <datalist id="codeList">
                                            <!-- PHP code will populate this -->
                                        </datalist>
                                    </div>

                                    <!-- Rate -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ __('Rate') }}
                                            <span class="float-right text-gray-500 text-xs">نرخ</span>
                                        </label>
                                        <input type="number" name="Rate[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" placeholder="{{ __('rate') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Required fields note -->
            <div class="bg-white rounded-2xl shadow-xl p-4 border border-white/20">
                <div class="text-center text-xs text-gray-500">
                    <span class="text-red-500 text-sm">*</span> {{ __('Required fields') }}
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Tab functionality
    let currentMode = 'single';
    const formMode = document.getElementById('form-mode');
    const familyPhoneSection = document.getElementById('family-phone-section');
    const familyPhone = document.getElementById('family-phone');
    const familyName = document.getElementById('family-name');

    // Tab switching functionality
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabType = this.getAttribute('data-tab');
            switchTab(tabType);
        });
    });

    function switchTab(tabType) {
        currentMode = tabType;
        formMode.value = tabType;

        // Update tab appearance
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'text-indigo-600', 'border-indigo-100');
            btn.classList.add('text-gray-600');
        });
        
        const activeTab = document.querySelector(`[data-tab="${tabType}"]`);
        activeTab.classList.add('bg-white', 'text-indigo-600', 'border-indigo-100');
        activeTab.classList.remove('text-gray-600');

        // Show/hide family phone section
        if (tabType === 'family') {
            familyPhoneSection.style.display = 'block';
            // Hide individual phone fields
            document.querySelectorAll('.individual-phone-field').forEach(field => {
                field.style.display = 'none';
                // Remove required from individual phone inputs
                field.querySelector('input[name="phone_number"]').removeAttribute('required');
            });
            // Make family fields required
            if (familyPhone) familyPhone.setAttribute('required', 'required');
            if (familyName) familyName.setAttribute('required', 'required');
        } else {
            familyPhoneSection.style.display = 'none';
            // Show individual phone fields
            document.querySelectorAll('.individual-phone-field').forEach(field => {
                field.style.display = 'block';
                // Add required back to individual phone inputs
                field.querySelector('input[name="phone_number"]').setAttribute('required', 'required');
            });
            // Remove required from family fields
            if (familyPhone) familyPhone.removeAttribute('required');
            if (familyName) familyName.removeAttribute('required');
        }
    }

    // Total, Paid, Remain calculation
    const totalInput = document.getElementById('total');
    const paidInputGlobal = document.getElementById('paid');
    const remainInputGlobal = document.getElementById('remain');
    
    function updateTotal() {
        const rates = Array.from(document.querySelectorAll('input[name="Rate[]"]'))
            .map(input => parseFloat(input.value) || 0);
        const total = rates.reduce((sum, rate) => sum + rate, 0);
        if (totalInput) {
            totalInput.value = total;
            // Update remain live based on current Paid
            updateRemaining();
        }
    }
    
    function updateRemaining() {
        if (totalInput && paidInputGlobal && remainInputGlobal) {
            const total = parseFloat(totalInput.value) || 0;
            const paid = parseFloat(paidInputGlobal.value) || 0;
            const remaining = total - paid;
            
            remainInputGlobal.value = remaining;
            
            // Update payment status indicator
            const statusIndicator = document.getElementById('payment-status');
            const statusText = document.getElementById('payment-status-text');
            
            if (remaining > 0) {
                remainInputGlobal.classList.add('text-red-900', 'bg-red-100', 'border-red-300');
                remainInputGlobal.classList.remove('text-emerald-900', 'bg-emerald-100', 'border-emerald-300', 'text-blue-900', 'bg-blue-100', 'border-blue-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
                if (statusText) {
                    statusText.textContent = 'Partial Payment';
                    statusText.className = 'text-sm font-medium text-yellow-700';
                }
            } else if (remaining === 0 && total > 0) {
                remainInputGlobal.classList.add('text-emerald-900', 'bg-emerald-100', 'border-emerald-300');
                remainInputGlobal.classList.remove('text-red-900', 'bg-red-100', 'border-red-300', 'text-blue-900', 'bg-blue-100', 'border-blue-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-green-500';
                if (statusText) {
                    statusText.textContent = 'Fully Paid';
                    statusText.className = 'text-sm font-medium text-green-700';
                }
            } else if (remaining < 0) {
                remainInputGlobal.classList.add('text-blue-900', 'bg-blue-100', 'border-blue-300');
                remainInputGlobal.classList.remove('text-red-900', 'bg-red-100', 'border-red-300', 'text-emerald-900', 'bg-emerald-100', 'border-emerald-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-blue-500';
                if (statusText) {
                    statusText.textContent = 'Overpaid';
                    statusText.className = 'text-sm font-medium text-blue-700';
                }
            } else {
                remainInputGlobal.classList.remove('text-red-900', 'bg-red-100', 'border-red-300', 'text-emerald-900', 'bg-emerald-100', 'border-emerald-300', 'text-blue-900', 'bg-blue-100', 'border-blue-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-gray-400';
                if (statusText) {
                    statusText.textContent = 'No Payment';
                    statusText.className = 'text-sm font-medium text-gray-600';
                }
            }
        }
    }

    // Add live event listeners for Rate inputs to update Total
    document.addEventListener('input', function(e) {
        if (e.target.matches('input[name="Rate[]"]')) {
            updateTotal();
        }
    });
    
    // Add live event listeners for Paid input
    if (paidInputGlobal) {
        paidInputGlobal.addEventListener('input', updateRemaining);
        paidInputGlobal.addEventListener('change', updateRemaining);
    }
    
    // Initialize totals if fields are pre-filled
    updateTotal();

    // Phone number validation
    document.addEventListener('input', function(e) {
        if (e.target.matches('input[name="phone_number"]') || e.target.id === 'family-phone') {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
            
            let messageDiv;
            if (e.target.id === 'family-phone') {
                messageDiv = document.getElementById('family-phone-message');
            } else {
                messageDiv = e.target.closest('div').querySelector('.phone-message');
            }
            
            if (messageDiv) {
                if (value === '') {
                    messageDiv.innerHTML = '';
                    e.target.classList.remove('border-red-400', 'border-emerald-400', 'border-purple-400');
                } else if (value.length < 10) {
                    messageDiv.innerHTML = '<span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>Invalid phone number</span>';
                    e.target.classList.add('border-red-400');
                    e.target.classList.remove('border-emerald-400', 'border-purple-400');
                } else {
                    if (e.target.id === 'family-phone') {
                        messageDiv.innerHTML = '<span class="text-purple-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Valid family phone number</span>';
                        e.target.classList.remove('border-red-400');
                        e.target.classList.add('border-purple-400');
                    } else {
                        messageDiv.innerHTML = '<span class="text-emerald-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Valid phone number</span>';
                        e.target.classList.remove('border-red-400');
                        e.target.classList.add('border-emerald-400');
                    }
                }
            }
        }
    });

    // Jeb type multi-select functionality (works with multiple measurement sections)
    document.addEventListener('change', function(e) {
        if (e.target.matches('.jeb-select')) {
            const jebSelect = e.target;
            const measurementSection = jebSelect.closest('.measurement-section');
            if (measurementSection) {
                const jebInput = measurementSection.querySelector('.jeb-input');
                if (jebInput) {
                    const selectedValue = jebSelect.value;
                    if (selectedValue) {
                        const currentValues = jebInput.value ? jebInput.value.split(', ') : [];
                        
                        if (!currentValues.includes(selectedValue)) {
                            currentValues.push(selectedValue);
                            jebInput.value = currentValues.join(', ');
                            
                            jebInput.classList.add('border-emerald-400', 'bg-emerald-50');
                            setTimeout(() => {
                                jebInput.classList.remove('bg-emerald-50');
                            }, 1000);
                        }
                    }
                    
                    jebSelect.selectedIndex = 0;
                }
            }
        }
    });

    // Initialize
    updateRemaining();

    // Measurement section duplication functionality
    let measurementCount = 1;
    const measurementSections = document.getElementById('measurement-sections');
    const addMeasurementBtn = document.getElementById('add-measurement');
    const measurementCountDisplay = document.getElementById('measurement-count');
    
    // Initialize count from existing sections
    if (measurementSections) {
        measurementCount = measurementSections.querySelectorAll('.measurement-section').length;
        if (measurementCountDisplay) {
            measurementCountDisplay.textContent = measurementCount;
        }
    }

    function updateMeasurementCountDisplay() {
        const countDisplay = document.getElementById('measurement-count');
        if (countDisplay) {
            if (currentMode === 'family') {
                countDisplay.textContent = measurementCount + ' Family Members';
            } else {
                countDisplay.textContent = measurementCount;
            }
        }
    }

    function createRemoveButton() {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'absolute top-4 right-4 p-2 bg-red-100 text-red-500 rounded-full hover:bg-red-200 hover:text-red-600 transition-all duration-200 transform hover:scale-110';
        button.innerHTML = `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        `;
        button.onclick = function() {
            const section = this.closest('.measurement-section');
            if (section && measurementCount > 1) {
                section.remove();
                measurementCount--;
                updateMeasurementCountDisplay();
                // Recalculate totals after removing a section
                updateTotal();
            }
        };
        return button;
    }

    if (addMeasurementBtn && measurementSections) {
        addMeasurementBtn.addEventListener('click', function() {
            const originalSection = measurementSections.querySelector('.measurement-section');
            if (originalSection) {
                const newSection = originalSection.cloneNode(true);
                
                // Add remove button
                const removeBtn = createRemoveButton();
                newSection.style.position = 'relative';
                newSection.appendChild(removeBtn);
                
                // Clear all input values in the new section
                newSection.querySelectorAll('input, select').forEach(input => {
                    if (input.type === 'text' || input.type === 'number' || input.type === 'date') {
                        input.value = '';
                    } else if (input.type === 'select-one') {
                        input.selectedIndex = 0;
                    }
                });
                
                // Handle family mode - hide phone fields in new sections
                if (currentMode === 'family') {
                    const phoneField = newSection.querySelector('.individual-phone-field');
                    if (phoneField) {
                        phoneField.style.display = 'none';
                        const phoneInput = phoneField.querySelector('input[name="phone[]"]');
                        if (phoneInput) phoneInput.removeAttribute('required');
                    }
                }
                
                // Add to container
                measurementSections.appendChild(newSection);
                
                // Update counter
                measurementCount++;
                updateMeasurementCountDisplay();
                
                // Recalculate totals immediately for live updates
                updateTotal();
                
                // Scroll the new section into view
                newSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                
                // Add highlight effect
                newSection.classList.add('bg-emerald-50');
                setTimeout(() => {
                    newSection.classList.remove('bg-emerald-50');
                }, 1000);
            }
        });
    }

    // Add remove button to first section if there are multiple sections
    if (measurementSections && measurementCount > 1) {
        const firstSection = measurementSections.querySelector('.measurement-section');
        if (firstSection && !firstSection.querySelector('.absolute.top-4.right-4')) {
            const removeBtn = createRemoveButton();
            firstSection.style.position = 'relative';
            firstSection.appendChild(removeBtn);
        }
    }
</script>
@endsection

