@extends('layout.app')

@section('title', __('Add New Vest Order'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
    <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                        {{ __('New Vest Order') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Create a comprehensive vest order with measurements and details') }}</p>
                </div>
                
                <!-- Navigation Tabs -->
                <div class="flex bg-gray-100 rounded-2xl p-1 shadow-inner">
                    <button id="single-tab" class="tab-btn px-6 py-3 bg-white text-orange-600 font-semibold rounded-xl shadow-sm border border-orange-100 transition-all duration-200" data-tab="single">
                        {{ __('Single') }}
                    </button>
                    <button id="family-tab" class="tab-btn px-6 py-3 text-gray-600 font-semibold rounded-xl hover:bg-white/50 transition-all duration-200" data-tab="family">
                        {{ __('Family') }}
                    </button>
            </div>
        </div>
    </div>

                    <!-- Main Form -->
        <form method="POST" action="{{ route('vests.store') }}" class="space-y-6" id="vest-form">
            @csrf
            <input type="hidden" id="form-mode" name="form_mode" value="single">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
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

            <!-- Success Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-green-800 font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            
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
                                    <button type="button" id="print-btn" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-black font-semibold rounded-lg hover:from-amber-600 hover:to-orange-600 transform hover:scale-105 transition-all duration-200 shadow-md text-xs" disabled>
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ __('Print') }}
                                    </button>
                                    
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold rounded-lg hover:from-orange-700 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-md text-xs">
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

            <!-- Measurements Section -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                                {{ __('Vest Measurements') }}
                            </h2>
                            <p class="text-orange-100 mt-1">{{ __('Detailed measurements for perfect vest fitting') }}</p>
                        </div>
                        
                        <!-- Add Measurement Button -->
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-white">
                                Total Measurements: <span id="measurement-count" class="font-semibold bg-white/20 px-2 py-1 rounded">1</span>
                            </div>
                            <button type="button" id="add-measurement" class="px-4 py-2 bg-white text-orange-600 rounded-lg hover:bg-orange-50 transition-all duration-200 flex items-center gap-2 font-semibold shadow-lg hover:scale-105 active:scale-95">
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
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
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
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
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
                                <select name="Clothes_Size[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled selected>{{ __('Select Size') }}</option>
                                    <option value="l">{{ __('Large') }}</option>
                                    <option value="s">{{ __('Small') }}</option>
                                </select>
                            </div>

                            <!-- Vest Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Vest Type') }}
                                </label>
                                <select name="Vest_Type[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled selected>{{ __('Select') }}</option>
                                    <option value="واسكت">واسكت</option>
                                    <option value="كورتي">كورتي</option>
                                </select>
                            </div>

                            <!-- Height -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Height') }}
                                    <span class="float-right text-gray-500 text-xs">قد</span>
                                </label>
                                <input type="text" name="Height[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter height') }}" required>
                            </div>

                            <!-- Shoulder -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shoulder') }}
                                    <span class="float-right text-gray-500 text-xs">شانه</span>
                                </label>
                                <input type="number" name="Shoulder[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter shoulder measurement') }}" required>
                            </div>

                            <!-- Armpit -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Armpit') }}
                                    <span class="float-right text-gray-500 text-xs">بغل</span>
                                </label>
                                <input type="number" name="Armpit[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter armpit measurement') }}" required>
                            </div>
                        </div>

                        <!-- Column 2: Body Measurements -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">{{ __('Body Details') }}</h3>
                            
                            <!-- Waist -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Waist') }}
                                    <span class="float-right text-gray-500 text-xs">کمر</span>
                                </label>
                                <input type="number" name="Waist[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter waist measurement') }}" required>
                            </div>

                            <!-- Shana Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shana Type') }}
                                    <span class="float-right text-gray-500 text-xs">نوع شانه</span>
                                </label>
                                <select name="Shana[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled selected>{{ __('Select') }}</option>
                                    <option value="سیده">سیده</option>
                                    <option value="نیمه دون">نیمه دون</option>
                                    <option value="فول دون">فول دون</option>
                                </select>
                            </div>

                            <!-- Kalar Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Kalar Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع کالر</span>
                                </label>
                                <select name="Kalar[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled selected>{{ __('Select') }}</option>
                                    <option value="هفت">هفت</option>
                                    <option value="گول">گول</option>
                                    <option value="بین">بین</option>
                                </select>
                            </div>

                            <!-- Daman Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Daman Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع دامن</span>
                                </label>
                                <select name="Daman[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled selected>{{ __('Select') }}</option>
                                    <option value="چهار کنج">چهار کنج</option>
                                    <option value="گول">گول</option>
                                </select>
                            </div>

                            <!-- NawaWaskat Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('NawaWaskat Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع واسکت</span>
                                </label>
                                <select name="NawaWaskat[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled selected>{{ __('Select') }}</option>
                                    <option value="چرمه دار">چرمه دار</option>
                                    <option value="سلمه دوزی">سلمه دوزی</option>
                                    <option value="کلاباتون">کلاباتون</option>
                                </select>
                            </div>
                        </div>

                        <!-- Column 3: Style Options -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">{{ __('Order Details') }}</h3>
                            
                            <div class="bg-orange-100 backdrop-blur-md rounded-xl p-4 shadow-inner border border-gray-200">
                                <!-- Order Date -->
                                <div class="">
                                    <label class="block text-xs font-medium text-gray-700 mb-1 mt-3">
                                        {{ __('Order Date') }}
                                        <span class="float-right text-gray-500 text-xs">تاریخ فرمایش</span>
                                    </label>
                                    <input type="date" name="O_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" required>
                                </div>

                                <!-- Receive Date -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Receive Date') }}
                                        <span class="float-right text-gray-500 text-xs">تاریخ دریافت</span>
                                    </label>
                                    <input type="date" name="R_date[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" required>
                                </div>

                                <!-- Code & Rate in one row -->
                                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                                    <!-- Code -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ __('Code') }}
                                            <span class="float-right text-gray-500 text-xs">کود</span>
                                        </label>
                                        <input list="codeList" id="codeInput" name="cust_name[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" placeholder="{{ __('code ...') }}" autocomplete="off">
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
                                        <input type="number" name="Rate[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" placeholder="{{ __('rate') }}">
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
            btn.classList.remove('bg-white', 'text-orange-600', 'border-orange-100');
            btn.classList.add('text-gray-600');
        });
        
        const activeTab = document.querySelector(`[data-tab="${tabType}"]`);
        activeTab.classList.add('bg-white', 'text-orange-600', 'border-orange-100');
        activeTab.classList.remove('text-gray-600');

        // Show/hide family phone section
        if (tabType === 'family') {
            familyPhoneSection.style.display = 'block';
            // Hide individual phone fields
            document.querySelectorAll('.individual-phone-field').forEach(field => {
                field.style.display = 'none';
                // Remove required from individual phone inputs
                field.querySelector('input[name="phone[]"]').removeAttribute('required');
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
                field.querySelector('input[name="phone[]"]').setAttribute('required', 'required');
            });
            // Remove required from family fields
            if (familyPhone) familyPhone.removeAttribute('required');
            if (familyName) familyName.removeAttribute('required');
        }

        // Update measurement count display
        updateMeasurementCountDisplay();
    }

    function updateMeasurementCountDisplay() {
        const countDisplay = document.getElementById('measurement-count');
        if (countDisplay) {
            if (currentMode === 'family') {
                countDisplay.textContent = measurementCount + ' {{ __('Family Members') }}';
            } else {
                countDisplay.textContent = measurementCount;
            }
        }
    }

    // Measurement section duplication functionality
    let measurementCount = 1;
    const measurementSections = document.getElementById('measurement-sections');
    const addMeasurementBtn = document.getElementById('add-measurement');
    const measurementCountDisplay = document.getElementById('measurement-count');
    const totalInput = document.getElementById('total');
    const paidInputGlobal = document.getElementById('paid');
    const remainInputGlobal = document.getElementById('remain');
    
    // Initialize count from existing sections
    if (measurementSections) {
        measurementCount = measurementSections.querySelectorAll('.measurement-section').length;
        if (measurementCountDisplay) {
            measurementCountDisplay.textContent = measurementCount;
        }
    }

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
            
            // Visual feedback for remaining amount and status
            if (remaining > 0) {
                remainInputGlobal.classList.add('text-red-900', 'bg-red-100', 'border-red-300');
                remainInputGlobal.classList.remove('text-emerald-900', 'bg-emerald-100', 'border-emerald-300', 'text-blue-900', 'bg-blue-100', 'border-blue-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
                if (statusText) {
                    statusText.textContent = '{{ __('Partial Payment') }}';
                    statusText.className = 'text-sm font-medium text-yellow-700';
                }
            } else if (remaining === 0 && total > 0) {
                remainInputGlobal.classList.add('text-emerald-900', 'bg-emerald-100', 'border-emerald-300');
                remainInputGlobal.classList.remove('text-red-900', 'bg-red-100', 'border-red-300', 'text-blue-900', 'bg-blue-100', 'border-blue-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-green-500';
                if (statusText) {
                    statusText.textContent = '{{ __('Fully Paid') }}';
                    statusText.className = 'text-sm font-medium text-green-700';
                }
            } else if (remaining < 0) {
                remainInputGlobal.classList.add('text-blue-900', 'bg-blue-100', 'border-blue-300');
                remainInputGlobal.classList.remove('text-red-900', 'bg-red-100', 'border-red-300', 'text-emerald-900', 'bg-emerald-100', 'border-emerald-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-blue-500';
                if (statusText) {
                    statusText.textContent = '{{ __('Overpaid') }}';
                    statusText.className = 'text-sm font-medium text-blue-700';
                }
            } else {
                remainInputGlobal.classList.remove('text-red-900', 'bg-red-100', 'border-red-300', 'text-emerald-900', 'bg-emerald-100', 'border-emerald-300', 'text-blue-900', 'bg-blue-100', 'border-blue-300');
                
                if (statusIndicator) statusIndicator.className = 'w-3 h-3 rounded-full bg-gray-400';
                if (statusText) {
                    statusText.textContent = '{{ __('No Payment') }}';
                    statusText.className = 'text-sm font-medium text-gray-600';
                }
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
                updateTotal();
            }
        };
        return button;
    }

    function initializeInputMasks(container) {
        // Add any input masks or special input handling here
        container.querySelectorAll('input[type="tel"]').forEach(input => {
            input.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length >= 10) {
                    value = value.match(/(\d{3})(\d{3})(\d{4})/);
                    this.value = '(' + value[1] + ') ' + value[2] + '-' + value[3];
                }
            });
        });
    }

    if (addMeasurementBtn) {
        addMeasurementBtn.addEventListener('click', function() {
            const originalSection = measurementSections.querySelector('.measurement-section');
            if (originalSection) {
                const newSection = originalSection.cloneNode(true);
                
                // Add remove button
                const removeBtn = createRemoveButton();
                newSection.style.position = 'relative';
                newSection.appendChild(removeBtn);
                
                // Handle family mode - hide phone fields in new sections
                if (currentMode === 'family') {
                    const phoneField = newSection.querySelector('.individual-phone-field');
                    if (phoneField) {
                        phoneField.style.display = 'none';
                        phoneField.querySelector('input[name="phone[]"]').removeAttribute('required');
                    }
                }
                
                // Keep existing values so the clone is pre-filled
                // Initialize input masks (keeps existing values)
                initializeInputMasks(newSection);
                
                // Add event listeners for live rate calculation
                newSection.querySelectorAll('input[name="Rate[]"]').forEach(input => {
                    input.addEventListener('input', updateTotal);
                    input.addEventListener('change', updateTotal);
                });
                
                // Add to container at the top (prepend)
                if (measurementSections.firstElementChild) {
                    measurementSections.insertBefore(newSection, measurementSections.firstElementChild);
                } else {
                    measurementSections.appendChild(newSection);
                }
                
                // Update counter
                measurementCount++;
                updateMeasurementCountDisplay();
                
                // Scroll the new section into view at the top
                newSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                
                // Add highlight effect
                newSection.classList.add('bg-orange-50');
                setTimeout(() => {
                    newSection.classList.remove('bg-orange-50');
                }, 1000);

                // Recalculate totals immediately for live updates
                updateTotal();
            }
        });
    }

    // Initialize the first section
    document.querySelectorAll('input[name="Rate[]"]').forEach(input => {
        input.addEventListener('input', updateTotal);
        input.addEventListener('change', updateTotal);
    });
    
    // Add live event listeners for Paid input
    if (paidInputGlobal) {
        paidInputGlobal.addEventListener('input', updateRemaining);
        paidInputGlobal.addEventListener('change', updateRemaining);
    }
    
    initializeInputMasks(document);
    // Calculate initial totals if fields are pre-filled
    updateTotal();
    
    document.addEventListener('DOMContentLoaded', function() {
        // Modern form validation with visual feedback
        const form = document.querySelector('#vest-form');
        const inputs = form.querySelectorAll('input[required], select[required]');
        
        // Add real-time validation
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('border-red-400')) {
                    validateField(this);
                }
            });
        });
        
        function validateField(field) {
            const isValid = field.value.trim() !== '';
            
            if (isValid) {
                field.classList.remove('border-red-400', 'bg-red-50');
                field.classList.add('border-orange-400', 'bg-orange-50');
            } else {
                field.classList.remove('border-orange-400', 'bg-orange-50');
                field.classList.add('border-red-400', 'bg-red-50');
            }
        }
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('input[required], select[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-400', 'bg-red-50');
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showAlert('{{ __('Please fill in all required fields') }}', 'error');
                const firstInvalid = form.querySelector('.border-red-400');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
                return false;
            }
        });

        // Phone number validation and formatting for all phone inputs
        document.addEventListener('input', function(e) {
            if (e.target.matches('input[name="phone[]"]') || e.target.id === 'family-phone') {
                // Format phone number - only keep digits
                let value = e.target.value.replace(/\D/g, '');
                e.target.value = value;
                
                // Basic phone validation for format only
                let messageDiv;
                if (e.target.id === 'family-phone') {
                    messageDiv = document.getElementById('family-phone-message');
                } else {
                    messageDiv = e.target.closest('div').querySelector('.phone-message');
                }
                
                if (messageDiv) {
                    if (value === '') {
                        messageDiv.innerHTML = '';
                        e.target.classList.remove('border-red-400', 'border-orange-400', 'border-purple-400');
                    } else if (value.length < 10) {
                        messageDiv.innerHTML = '<span class="text-red-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ __('Invalid phone number') }}</span>';
                        e.target.classList.add('border-red-400');
                        e.target.classList.remove('border-orange-400', 'border-purple-400');
                    } else {
                        if (e.target.id === 'family-phone') {
                            messageDiv.innerHTML = '<span class="text-purple-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>{{ __('Valid family phone number') }}</span>';
                            e.target.classList.remove('border-red-400');
                            e.target.classList.add('border-purple-400');
                        } else {
                            messageDiv.innerHTML = '<span class="text-orange-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>{{ __('Valid phone number') }}</span>';
                            e.target.classList.remove('border-red-400');
                            e.target.classList.add('border-orange-400');
                        }
                    }
                }
            }
        });

        // Auto-focus next field functionality
        inputs.forEach((input, index) => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const nextInput = inputs[index + 1];
                    if (nextInput) {
                        nextInput.focus();
                    }
                }
            });
        });

        // Modern alert function
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            const bgColor = type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-orange-500' : 'bg-blue-500';
            
            alertDiv.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-2xl shadow-2xl z-50 transform transition-all duration-300 translate-x-full`;
            alertDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                alertDiv.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(alertDiv);
                }, 300);
            }, 4000);
        }

        // Add loading states to buttons
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalSubmitText = submitBtn.innerHTML;
        
        form.addEventListener('submit', function(e) {
            if (this.checkValidity()) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Processing...') }}
                `;
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalSubmitText;
                }, 10000);
            }
        });

        // Add smooth animations on focus
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
                this.style.transition = 'all 0.2s ease-in-out';
            });
            
            input.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Initialize form
        showAlert('{{ __("Vest form loaded successfully!") }}', 'success');
    });
</script>
@endsection
