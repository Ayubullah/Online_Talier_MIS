@extends('layout.app_user')

@section('title', 'Vest Size Information')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-orange-50 py-8 px-4">
    <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8 border border-white/20 backdrop-blur-sm">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                        {{ __('Vest Size Information') }}
                    </h1>
                    <p class="text-gray-600 text-lg">{{ __('Detailed vest measurements and specifications') }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('online-employee-details.index') }}" class="px-6 py-3 bg-gradient-to-r from-gray-600 to-slate-600 text-white font-semibold rounded-xl hover:from-gray-700 hover:to-slate-700 transform hover:scale-105 transition-all duration-200 shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Back to Dashboard') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20 mb-6">
            <div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ __('Customer Information') }}
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-orange-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-orange-700">Customer Name</div>
                        <div class="text-lg font-bold text-orange-900">{{ $vestMeasurement->customer->cus_name ?? 'N/A' }}</div>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-red-700">Phone Number</div>
                        <div class="text-lg font-bold text-red-900">{{ $vestMeasurement->customer->phone->pho_no ?? 'N/A' }}</div>
                    </div>
                    <div class="bg-pink-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-pink-700">Size</div>
                        <div class="text-lg font-bold text-pink-900">{{ $vestMeasurement->size ?? 'N/A' }}</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="text-sm font-medium text-purple-700">Rate</div>
                        <div class="text-lg font-bold text-purple-900">${{ number_format($vestMeasurement->vest_rate ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Measurements Section -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/20">
            <div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                    {{ __('Vest Measurements') }}
                </h2>
                <p class="text-orange-100 mt-1">{{ __('Detailed measurements for perfect vest fitting') }}</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Column 1: Basic Measurements -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-2 mb-4">{{ __('Basic Measurements') }}</h3>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Vest Type') }}</div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Vest_Type ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Height') }} <span class="float-right text-gray-500">قد</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Height ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Shoulder') }} <span class="float-right text-gray-500">شانه</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Shoulder ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Armpit') }} <span class="float-right text-gray-500">بغل</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Armpit ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Column 2: Body Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-2 mb-4">{{ __('Body Details') }}</h3>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Waist') }} <span class="float-right text-gray-500">کمر</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Waist ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Shana Type') }} <span class="float-right text-gray-500">نوع شانه</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Shana ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Kalar Type') }} <span class="float-right text-gray-500">انواع کالر</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Kalar ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Daman Type') }} <span class="float-right text-gray-500">انواع دامن</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->Daman ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <!-- Column 3: Style & Order Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-2 mb-4">{{ __('Style & Order Details') }}</h3>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('NawaWaskat Type') }} <span class="float-right text-gray-500">انواع واسکت</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->NawaWaskat ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Order Date') }} <span class="float-right text-gray-500">تاریخ فرمایش</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->O_date ? $vestMeasurement->O_date->format('M d, Y') : 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Receive Date') }} <span class="float-right text-gray-500">تاریخ دریافت</span></div>
                            <div class="text-lg font-bold text-gray-900">{{ $vestMeasurement->R_date ? $vestMeasurement->R_date->format('M d, Y') : 'N/A' }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">{{ __('Order Status') }} <span class="float-right text-gray-500">وضعیت</span></div>
                            <div class="text-lg font-bold">
                                <span class="inline-flex px-3 py-1 text-sm rounded-full
                                    @if($vestMeasurement->Status == 'complete') bg-green-100 text-green-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($vestMeasurement->Status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignment Action -->
        <div class="relative overflow-hidden bg-gradient-to-br from-white via-orange-50/30 to-red-50/50 rounded-3xl shadow-2xl border border-white/40 mt-8 backdrop-blur-sm">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/5 via-red-500/5 to-pink-500/5"></div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-orange-400/10 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-red-400/10 to-transparent rounded-full translate-y-12 -translate-x-12"></div>
            
            <div class="relative p-8">
                @if($assignment->status !== 'complete')
                <!-- Complete Assignment Form -->
                <div class="text-center space-y-6">
                    <div class="space-y-3">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 rounded-2xl shadow-lg ring-4 ring-orange-100/50">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 via-orange-800 to-red-800 bg-clip-text text-transparent">
                            Ready to Complete?
                        </h3>
                        <p class="text-gray-600 max-w-md mx-auto leading-relaxed">
                            Mark this vest assignment as completed to update your progress and notify the system.
                        </p>
                    </div>
                    
                    <form action="{{ route('online-employee-details.complete-vest-assignment', $assignment->F_vm_id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to complete this vest assignment? This action cannot be undone.')"
                                class="group relative inline-flex items-center justify-center px-12 py-4 text-lg font-semibold text-white bg-gradient-to-r from-orange-600 via-red-600 to-pink-600 rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-out overflow-hidden">
                            <!-- Button shine effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-out"></div>
                            
                            <!-- Button content -->
                            <div class="relative flex items-center gap-3">
                                <svg class="w-6 h-6 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="tracking-wide">{{ __('Complete Vest Assignment') }}</span>
                                <div class="w-2 h-2 bg-white/40 rounded-full animate-pulse"></div>
                            </div>
                        </button>
                    </form>
                    
                    <!-- Measure ID Display -->
                    <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-1.414 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span>Measure ID: <span class="font-mono font-medium text-orange-600">{{ $assignment->F_vm_id }}</span></span>
                    </div>
                </div>
                @else
                <!-- Completed State -->
                <div class="text-center space-y-6">
                    <div class="space-y-3">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-400 via-green-500 to-teal-600 rounded-3xl shadow-xl ring-4 ring-emerald-100/50">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 bg-clip-text text-transparent">
                            Vest Assignment Completed!
                        </h3>
                        <p class="text-gray-600 max-w-md mx-auto leading-relaxed">
                            Excellent work! This vest assignment has been successfully completed and recorded in the system.
                        </p>
                    </div>
                    
                    <!-- Completion Badge -->
                    <div class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-emerald-50 via-green-50 to-teal-50 border border-emerald-200/50 rounded-2xl shadow-lg">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                            <span class="text-emerald-800 font-semibold">Status: Completed</span>
                        </div>
                        <div class="w-px h-6 bg-emerald-200"></div>
                        <div class="flex items-center gap-2 text-sm text-emerald-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $assignment->completed_at ? $assignment->completed_at->format('M d, Y - H:i') : 'Recently' }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print, .no-print * {
        display: none !important;
    }
}
</style>
@endsection

