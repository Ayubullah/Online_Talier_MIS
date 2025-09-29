@extends('layout.app')

@section('title', 'Edit Customer Order')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
    <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        {{ __('Edit Customer Order') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Update customer information and measurements') }}</p>
            </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('customers.show', $customer) }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ __('View Details') }}
                </a>
                    <a href="{{ route('customers.index') }}" class="px-6 py-3 bg-gradient-to-r from-gray-600 to-slate-600 text-white font-semibold rounded-xl hover:from-gray-700 hover:to-slate-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </div>

        <!-- Main Form -->
        <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-6" id="tailoring-form">
            @csrf
            @method('PUT')
            
            <!-- Measurements Section -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-black flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                                </svg>
                                {{ __('Body Measurements') }}
                            </h2>
                            <p class="text-emerald-100 mt-1">{{ __('Detailed measurements for perfect fitting') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @php
                        $clothMeasurement = $customer->clothMeasurements->first();
                    @endphp
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
                               value="{{ old('cus_name', $customer->cus_name) }}"
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

                <!-- Phone Number -->
                <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Phone Number') }}
                                <span class="float-right text-gray-500 text-sm">شماره تماس</span>
                    </label>
                    <div class="relative">
                        <input type="tel" 
                               name="phone_number" 
                               value="{{ old('phone_number', $customer->phone ? $customer->phone->pho_no : '') }}"
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-base bg-white hover:bg-gray-50"
                                    placeholder="(xxx) xxx-xxxx"
                                    maxlength="15"
                                    required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                    </div>
                            <div class="phone-message mt-1 text-sm"></div>
                        </div>
                    </div>

                    <!-- Measurement Sections Container -->
                    <div id="measurement-sections">
                        <!-- Single Measurement Section -->
                        <div class="measurement-section bg-white rounded-xl shadow-lg p-6 mb-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Column 1: Basic Measurements -->
                            <div class="space-y-4">
                            <h3 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">{{ __('Basic Measurements') }}</h3>

                            <!-- Clothes Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Clothes Type') }}
                                </label>
                                <select name="cloth_size" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select Size') }}</option>
                                    <option value="l" {{ old('cloth_size', $clothMeasurement ? $clothMeasurement->size : '') == 'l' ? 'selected' : '' }}>{{ __('Large') }}</option>
                                    <option value="s" {{ old('cloth_size', $clothMeasurement ? $clothMeasurement->size : '') == 's' ? 'selected' : '' }}>{{ __('Small') }}</option>
                                </select>
                            </div>

                            <!-- Height -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Height') }}
                                    <span class="float-right text-gray-500 text-xs">قد</span>
                                </label>
                                <input type="text" name="Height" value="{{ old('Height', $clothMeasurement ? $clothMeasurement->Height : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter height') }}" required>
                            </div>

                            <!-- Shoulder -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shoulder') }}
                                    <span class="float-right text-gray-500 text-xs">شانه</span>
                                </label>
                                <input type="text" name="Shoulder" value="{{ old('Shoulder', $clothMeasurement ? $clothMeasurement->Shoulder : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter shoulder measurement') }}" required>
                            </div>

                            <!-- Sleeve -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Sleeve') }}
                                    <span class="float-right text-gray-500 text-xs">آستین</span>
                                </label>
                                <input type="text" name="Sleeve" value="{{ old('Sleeve', $clothMeasurement ? $clothMeasurement->Sleeve : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter sleeve measurement') }}" required>
                            </div>

                            <!-- Collar -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Collar') }}
                                    <span class="float-right text-gray-500 text-xs">یخن</span>
                                </label>
                                <input type="text" name="Collar" value="{{ old('Collar', $clothMeasurement ? $clothMeasurement->Collar : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter collar measurement') }}" required>
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
                                <input type="text" name="chati" value="{{ old('chati', $clothMeasurement ? $clothMeasurement->chati : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter chati measurement') }}" required>
                            </div>

                            <!-- Armpit -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Armpit') }}
                                    <span class="float-right text-gray-500 text-xs">بغل</span>
                                </label>
                                <input type="text" name="Armpit" value="{{ old('Armpit', $clothMeasurement ? $clothMeasurement->Armpit : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter armpit measurement') }}" required>
                            </div>

                            <!-- Skirt -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Skirt') }}
                                    <span class="float-right text-gray-500 text-xs">دامن</span>
                                </label>
                                <input type="text" name="Skirt" value="{{ old('Skirt', $clothMeasurement ? $clothMeasurement->Skirt : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter skirt measurement') }}" required>
                            </div>

                            <!-- Trousers -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Trousers') }}
                                    <span class="float-right text-gray-500 text-xs">قد تنبان</span>
                                </label>
                                <input type="text" name="Trouser" value="{{ old('Trouser', $clothMeasurement ? $clothMeasurement->Trousers : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter trouser measurement') }}" required>
                </div>

                            <!-- Leg Opening -->
                <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Leg Opening') }}
                                    <span class="float-right text-gray-500 text-xs">پاچه</span>
                    </label>
                                <input type="text" name="pacha" value="{{ old('pacha', $clothMeasurement ? $clothMeasurement->Pacha : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('Enter leg opening measurement') }}" required>
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
                                    <input type="text" name="Kaff" list="kaff-options" value="{{ old('Kaff', $clothMeasurement ? $clothMeasurement->Kaff : '') }}" class="flex-1 px-1 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Select kaff type') }}" required>
                                    <input type="text" name="size_kaf" value="{{ old('size_kaf', $clothMeasurement ? $clothMeasurement->size_kaf : '') }}" class="w-10 px-1 py-3 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Size') }}">
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
                                    <input type="text" name="sleeve_type" list="sleeve-options" value="{{ old('sleeve_type', $clothMeasurement ? $clothMeasurement->sleeve_type : '') }}" class="flex-1 px-1 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Select sleeve type') }}" required>
                                    <input type="text" name="size_sleve" value="{{ old('size_sleve', $clothMeasurement ? $clothMeasurement->size_sleve : '') }}" class="w-10 px-1 py-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400 text-xs bg-white hover:bg-gray-50" placeholder="{{ __('Size') }}">
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
                                <select name="Kalar" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="" disabled>{{ __('Select') }}</option>
                                    <option value="هندی" {{ old('Kalar', $clothMeasurement ? $clothMeasurement->Kalar : '') == 'هندی' ? 'selected' : '' }}>هندی</option>
                                    <option value="قاسمی" {{ old('Kalar', $clothMeasurement ? $clothMeasurement->Kalar : '') == 'قاسمی' ? 'selected' : '' }}>قاسمی</option>
                                    <option value="سینه پور" {{ old('Kalar', $clothMeasurement ? $clothMeasurement->Kalar : '') == 'سینه پور' ? 'selected' : '' }}>سینه پور</option>
                                    <option value="کالر" {{ old('Kalar', $clothMeasurement ? $clothMeasurement->Kalar : '') == 'کالر' ? 'selected' : '' }}>کالر</option>
                                    <option value="پوره بین" {{ old('Kalar', $clothMeasurement ? $clothMeasurement->Kalar : '') == 'پوره بین' ? 'selected' : '' }}>پوره بین</option>
                                    <option value="نیمه بین" {{ old('Kalar', $clothMeasurement ? $clothMeasurement->Kalar : '') == 'نیمه بین' ? 'selected' : '' }}>نیمه بین</option>
                                    <option value="عریی" {{ old('Kalar', $clothMeasurement ? $clothMeasurement->Kalar : '') == 'عریی' ? 'selected' : '' }}>عریی</option>
                                </select>
                            </div>

                            <!-- Shalwar Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Shalwar Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع تنبان</span>
                                </label>
                                <select name="Shalwar" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="ساده" {{ old('Shalwar', $clothMeasurement ? $clothMeasurement->Shalwar : 'ساده') == 'ساده' ? 'selected' : '' }}>ساده</option>
                                    <option value="نیمه گیبی" {{ old('Shalwar', $clothMeasurement ? $clothMeasurement->Shalwar : '') == 'نیمه گیبی' ? 'selected' : '' }}>نیمه گیبی</option>
                                    <option value="پول گیبی" {{ old('Shalwar', $clothMeasurement ? $clothMeasurement->Shalwar : '') == 'پول گیبی' ? 'selected' : '' }}>پول گیبی</option>
                                    <option value="سه درزه" {{ old('Shalwar', $clothMeasurement ? $clothMeasurement->Shalwar : '') == 'سه درزه' ? 'selected' : '' }}>سه درزه</option>
                                </select>
                    </div>

                            <!-- Daman Type -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Daman Type') }}
                                    <span class="float-right text-gray-500 text-xs">انواع دامن</span>
                                </label>
                                <select name="Daman" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                                    <option value="گول" {{ old('Daman', $clothMeasurement ? $clothMeasurement->Daman : 'گول') == 'گول' ? 'selected' : '' }}>گول</option>
                                    <option value="چهار کنج" {{ old('Daman', $clothMeasurement ? $clothMeasurement->Daman : '') == 'چهار کنج' ? 'selected' : '' }}>چهار کنج</option>
                                    <option value="دوه اینچ قات" {{ old('Daman', $clothMeasurement ? $clothMeasurement->Daman : '') == 'دوه اینچ قات' ? 'selected' : '' }}>دوه اینچ قات</option>
                                    <option value="دری اینچ قات" {{ old('Daman', $clothMeasurement ? $clothMeasurement->Daman : '') == 'دری اینچ قات' ? 'selected' : '' }}>دری اینچ قات</option>
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
                                <input type="text" id="jeb-input" name="Jeb" value="{{ old('Jeb', $clothMeasurement ? $clothMeasurement->Jeb : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50 mb-2" placeholder="{{ __('Selected jeb types') }}">
                                <select id="jeb-select" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50">
                                    <option value="" disabled selected>{{ __('Select jeb type') }}</option>
                                    <option value="روي">روي</option>
                                    <option value="بغل">بغل</option>
                                    <option value="تنبان">تنبان</option>
                                    <option value="بلوچی تنبان">بلوچی جيب</option>
                                </select>
                    </div>

                            <!-- Order Date -->
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">
                                    {{ __('Order Date') }}
                                    <span class="float-right text-gray-500 text-xs">تاریخ فرمایش</span>
                                </label>
                                <input type="date" name="O_date" value="{{ old('O_date', $clothMeasurement && $clothMeasurement->O_date ? $clothMeasurement->O_date->format('Y-m-d') : date('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                            </div>

                            <!-- Receive Date -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    {{ __('Receive Date') }}
                                    <span class="float-right text-gray-500 text-xs">تاریخ دریافت</span>
                                </label>
                                <input type="date" name="R_date" value="{{ old('R_date', $clothMeasurement && $clothMeasurement->R_date ? $clothMeasurement->R_date->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" required>
                            </div>

                            <!-- Rate & Code in one row -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <!-- Code -->
                                <div class="flex-1">
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Code') }}
                                        <span class="float-right text-gray-500 text-xs">کود </span>
                                    </label>
                                    <input list="codeList" id="codeInput" name="cust_name" value="{{ old('cust_name', $clothMeasurement ? $clothMeasurement->cust_name : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('code ...') }}" autocomplete="off">
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
                                    <input type="number" name="cloth_rate" value="{{ old('cloth_rate', $clothMeasurement ? $clothMeasurement->cloth_rate : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm bg-white hover:bg-gray-50" placeholder="{{ __('rate') }}">
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

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <span class="text-red-500">*</span> {{ __('Required fields') }}
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('customers.show', $customer) }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('Update Customer Order') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Jeb type multi-select functionality
    const jebSelect = document.getElementById('jeb-select');
    const jebInput = document.getElementById('jeb-input');

    jebSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        const currentValues = jebInput.value ? jebInput.value.split(', ') : [];

        if (selectedValue && !currentValues.includes(selectedValue)) {
            currentValues.push(selectedValue);
            jebInput.value = currentValues.join(', ');

            jebInput.classList.add('border-emerald-400', 'bg-emerald-50');
            setTimeout(() => {
                jebInput.classList.remove('bg-emerald-50');
            }, 1000);
        }

        this.selectedIndex = 0;
    });

    // Phone number validation and formatting for all phone inputs
    document.addEventListener('input', function(e) {
        if (e.target.matches('input[name="phone_number"]')) {
            // Format phone number - only keep digits
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;

            // Basic phone validation for format only
            let messageDiv;
            if (e.target.name === 'phone_number') {
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
                    messageDiv.innerHTML = '<span class="text-emerald-500 text-sm flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>Valid phone number</span>';
                    e.target.classList.remove('border-red-400');
                    e.target.classList.add('border-emerald-400');
                }
            }
        }
    });

    // Add smooth animations on focus
    document.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'all 0.2s ease-in-out';
        });

        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Initialize form
    document.addEventListener('DOMContentLoaded', function() {
        // Modern form validation with visual feedback
        const form = document.querySelector('#tailoring-form');
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
                field.classList.add('border-emerald-400', 'bg-emerald-50');
            } else {
                field.classList.remove('border-emerald-400', 'bg-emerald-50');
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
                showAlert('Please fill in all required fields', 'error');
                const firstInvalid = form.querySelector('.border-red-400');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
                return false;
            }
        });

        // Modern alert function
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            const bgColor = type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-emerald-500' : 'bg-blue-500';

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

        showAlert('{{ __("Form loaded successfully!") }}', 'success');
    });
</script>
@endsection