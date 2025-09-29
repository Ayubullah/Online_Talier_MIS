@extends('layout.app')

@section('title', 'Edit Vest Order')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-orange-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                        {{ __('Edit Vest Order') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Customer: ') . $vest->customer->cus_name }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('vests.show', $vest) }}" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('vests.update', $vest) }}" class="space-y-6" id="vest-form">
            @csrf
            @method('PUT')
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
                                            name="cus_name"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
                                            placeholder="{{ __('Enter customer name') }}"
                                            value="{{ $vest->customer->cus_name ?? '' }}"
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
                                            name="phone_number"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
                                            placeholder="(xxx) xxx-xxxx"
                                            maxlength="15"
                                            value="{{ $vest->customer->phone->pho_no ?? '' }}"
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
                                <select name="size" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select Size') }}</option>
                                    <option value="L" {{ $vest->size == 'L' ? 'selected' : '' }}>{{ __('Large') }}</option>
                                    <option value="S" {{ $vest->size == 'S' ? 'selected' : '' }}>{{ __('Small') }}</option>
                                </select>
                            </div>

                            <!-- Vest Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Vest Type') }}
                                </label>
                                <select name="Vest_Type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="واسكت" {{ $vest->Vest_Type == 'واسكت' ? 'selected' : '' }}>واسكت</option>
                                    <option value="كورتي" {{ $vest->Vest_Type == 'كورتي' ? 'selected' : '' }}>كورتي</option>
                                </select>
                            </div>

                            <!-- Height -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Height') }}
                                    <span class="float-right text-gray-500 text-xs">قد</span>
                                </label>
                                <input type="text" name="Height" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter height') }}" value="{{ $vest->Height ?? '' }}" required>
                            </div>

                            <!-- Shoulder -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shoulder') }}
                                    <span class="float-right text-gray-500 text-xs">شانه</span>
                                </label>
                                <input type="number" name="Shoulder" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter shoulder measurement') }}" value="{{ $vest->Shoulder ?? '' }}" required>
                            </div>

                            <!-- Armpit -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Armpit') }}
                                    <span class="float-right text-gray-500 text-xs">بغل</span>
                                </label>
                                <input type="number" name="Armpit" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter armpit measurement') }}" value="{{ $vest->Armpit ?? '' }}" required>
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
                                <input type="number" name="Waist" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter waist measurement') }}" value="{{ $vest->Waist ?? '' }}" required>
                            </div>

                            <!-- Shana Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shana Type') }}
                                    <span class="float-right text-gray-500 text-xs">نوع شانه</span>
                                </label>
                                <select name="Shana" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="سیده" {{ $vest->Shana == 'سیده' ? 'selected' : '' }}>سیده</option>
                                    <option value="نیمه دون" {{ $vest->Shana == 'نیمه دون' ? 'selected' : '' }}>نیمه دون</option>
                                    <option value="فول دون" {{ $vest->Shana == 'فول دون' ? 'selected' : '' }}>فول دون</option>
                                </select>
                            </div>

                            <!-- Kalar Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Kalar Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع کالر</span>
                                </label>
                                <select name="Kalar" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="هفت" {{ $vest->Kalar == 'هفت' ? 'selected' : '' }}>هفت</option>
                                    <option value="گول" {{ $vest->Kalar == 'گول' ? 'selected' : '' }}>گول</option>
                                    <option value="بین" {{ $vest->Kalar == 'بین' ? 'selected' : '' }}>بین</option>
                                </select>
                            </div>

                            <!-- Daman Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Daman Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع دامن</span>
                                </label>
                                <select name="Daman" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="چهار کنج" {{ $vest->Daman == 'چهار کنج' ? 'selected' : '' }}>چهار کنج</option>
                                    <option value="گول" {{ $vest->Daman == 'گول' ? 'selected' : '' }}>گول</option>
                                </select>
                            </div>

                            <!-- NawaWaskat Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('NawaWaskat Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع واسکت</span>
                                </label>
                                <select name="NawaWaskat" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="چرمه دار" {{ $vest->NawaWaskat == 'چرمه دار' ? 'selected' : '' }}>چرمه دار</option>
                                    <option value="سلمه دوزی" {{ $vest->NawaWaskat == 'سلمه دوزی' ? 'selected' : '' }}>سلمه دوزی</option>
                                    <option value="کلاباتون" {{ $vest->NawaWaskat == 'کلاباتون' ? 'selected' : '' }}>کلاباتون</option>
                                </select>
                            </div>
                        </div>

                        <!-- Column 3: Style Options -->
                        <div class="space-y-3 col-span-2 ">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2 ">{{ __('Order Details') }}</h3>
                            
                            <div class="bg-orange-100 backdrop-blur-md rounded-xl p-4 shadow-inner border border-gray-200 mt-6">
                                <!-- Order Date -->
                                <div class="">
                                    <label class="block text-xs font-medium text-gray-700 mb-1 mt-3">
                                        {{ __('Order Date') }}
                                        <span class="float-right text-gray-500 text-xs">تاریخ فرمایش</span>
                                    </label>
                                    <input type="date" name="O_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" value="{{ $vest->O_date ? \Carbon\Carbon::parse($vest->O_date)->format('Y-m-d') : '' }}" required>
                                </div>

                                <!-- Receive Date -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Receive Date') }}
                                        <span class="float-right text-gray-500 text-xs">تاریخ دریافت</span>
                                    </label>
                                    <input type="date" name="R_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" value="{{ $vest->R_date ? \Carbon\Carbon::parse($vest->R_date)->format('Y-m-d') : '' }}" required>
                                </div>

                                <!-- Code & Rate in one row -->
                                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                                    <!-- Status -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ __('Status') }}
                                            <span class="float-right text-gray-500 text-xs">وضعیت</span>
                                        </label>
                                        <select name="Status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" required>
                                            <option value="pending" {{ $vest->Status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                            <option value="complete" {{ $vest->Status == 'complete' ? 'selected' : '' }}>{{ __('Complete') }}</option>
                                        </select>
                                    </div>

                                    <!-- Rate -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ __('Rate') }}
                                            <span class="float-right text-gray-500 text-xs">نرخ</span>
                                        </label>
                                        <input type="number" name="vest_rate" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" placeholder="{{ __('rate') }}" value="{{ $vest->vest_rate ?? '' }}">
                                    </div>

                                </div>

                                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                                    <!-- Code -->
                                    <div class="flex-1">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                                            {{ __('Code') }}
                                            <span class="float-right text-gray-500 text-xs">کود</span>
                                        </label>
                                        <input list="codeList" id="codeInput" name="code" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm bg-white/80 hover:bg-gray-50" placeholder="{{ __('code ...') }}" autocomplete="off" value="{{ $vest->customer->code ?? '' }}">
                                        <datalist id="codeList">
                                            <!-- PHP code will populate this -->
                                        </datalist>
                                    </div>

                                    <!-- Empty div for spacing -->
                                    <div class="flex-1">
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

            <!-- Submit Button -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-white/20 mt-6">
                <div class="flex justify-center">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold rounded-xl hover:from-orange-700 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('Update Vest Order') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


