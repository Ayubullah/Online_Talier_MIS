@extends('layout.app')

@section('title', 'Add New Employee')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Add New Employee') }}</h1>
                <p class="text-gray-600">{{ __('Create a new employee profile for your tailoring team') }}</p>
            </div>
            <a href="{{ route('employees.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to List') }}
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-purple-600">
            <h2 class="text-xl font-semibold text-white">{{ __('Employee Information') }}</h2>
        </div>

        <form method="POST" action="{{ route('employees.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Employee Name -->
                <div class="md:col-span-2">
                    <label for="emp_name" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Employee Name') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="emp_name" 
                               name="emp_name" 
                               value="{{ old('emp_name') }}"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('emp_name') border-red-500 @enderror"
                               placeholder="{{ __('Enter employee full name') }}" 
                               required>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('emp_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Selection -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Employee Role') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="role" 
                                name="role" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('role') border-red-500 @enderror appearance-none"
                                required>
                            <option value="">{{ __('Select employee role') }}</option>
                            <option value="cutter" {{ old('role') == 'cutter' ? 'selected' : '' }}>
                                {{ __('Cutter') }} ({{ __('کشر') }})
                            </option>
                            <option value="salaye" {{ old('role') == 'salaye' ? 'selected' : '' }}>
                                {{ __('Salaye') }} ({{ __('سلایه') }})
                            </option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V6a2 2 0 012 2v6.294a18.916 18.916 0 01-9 2.294 18.916 18.916 0 01-9-2.294V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Employee Type (Optional) -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Employee Type') }} <span class="text-gray-400 text-xs">({{ __('Optional') }})</span>
                    </label>
                    <div class="relative">
                        <select id="type" 
                                name="type" 
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('type') border-red-500 @enderror appearance-none">
                            <option value="">{{ __('Select type (optional)') }}</option>
                            <option value="cloth" {{ old('type') == 'cloth' ? 'selected' : '' }}>
                                {{ __('Cloth') }} ({{ __('کپڑے') }})
                            </option>
                            <option value="vest" {{ old('type') == 'vest' ? 'selected' : '' }}>
                                {{ __('Vest') }} ({{ __('واسکٹ') }})
                            </option>
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cutter Rates (shown only for cutter roles) -->
                <div id="cutter_rates" class="md:col-span-2 hidden">
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15"></path>
                            </svg>
                            {{ __('Cutting Rates (Optional)') }}
                        </h3>
                        <p class="text-sm text-blue-700 mb-4">{{ __('Set specific rates for small and large cutting tasks') }}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Small Cutting Rate -->
                            <div>
                                <label for="cutter_s_rate" class="block text-sm font-medium text-blue-700 mb-2">
                                    {{ __('Small Cutting Rate') }}
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="cutter_s_rate" 
                                           name="cutter_s_rate" 
                                           value="{{ old('cutter_s_rate') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-10 pr-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('cutter_s_rate') border-red-500 @enderror"
                                           placeholder="{{ __('0.00') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-blue-400 font-medium">$</span>
                                    </div>
                                </div>
                                @error('cutter_s_rate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Large Cutting Rate -->
                <div>
                                <label for="cutter_l_rate" class="block text-sm font-medium text-blue-700 mb-2">
                                    {{ __('Large Cutting Rate') }}
                    </label>
                    <div class="relative">
                        <input type="number" 
                                           id="cutter_l_rate" 
                                           name="cutter_l_rate" 
                                           value="{{ old('cutter_l_rate') }}"
                               step="0.01"
                               min="0"
                                           class="w-full pl-10 pr-4 py-3 border border-blue-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('cutter_l_rate') border-red-500 @enderror"
                                           placeholder="{{ __('0.00') }}">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-blue-400 font-medium">$</span>
                                    </div>
                                </div>
                                @error('cutter_l_rate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Salary Rates (shown only for salary roles) -->
                <div id="salary_rate_section" class="md:col-span-2 hidden">
                    <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                        <h3 class="text-lg font-semibold text-green-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            {{ __('Salaye Rates (Optional)') }}
                        </h3>
                        <p class="text-sm text-green-700 mb-4">{{ __('Set specific rates for small and large tailoring tasks') }}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Small Salaye Rate -->
                            <div>
                                <label for="salaye_s_rate" class="block text-sm font-medium text-green-700 mb-2">
                                    {{ __('Small Salaye Rate') }}
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="salaye_s_rate" 
                                           name="salaye_s_rate" 
                                           value="{{ old('salaye_s_rate') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-10 pr-4 py-3 border border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('salaye_s_rate') border-red-500 @enderror"
                                           placeholder="{{ __('0.00') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-green-400 font-medium">$</span>
                                    </div>
                                </div>
                                @error('salaye_s_rate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Large Salaye Rate -->
                            <div>
                                <label for="salaye_l_rate" class="block text-sm font-medium text-green-700 mb-2">
                                    {{ __('Large Salaye Rate') }}
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="salaye_l_rate" 
                                           name="salaye_l_rate" 
                                           value="{{ old('salaye_l_rate') }}"
                                           step="0.01"
                                           min="0"
                                           class="w-full pl-10 pr-4 py-3 border border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 @error('salaye_l_rate') border-red-500 @enderror"
                                           placeholder="{{ __('0.00') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-green-400 font-medium">$</span>
                                    </div>
                                </div>
                                @error('salaye_l_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Account Section -->
                <div class="md:col-span-2">
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl p-6 border border-purple-200">
                        <h3 class="text-lg font-semibold text-purple-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('User Account Creation') }} <span class="text-red-500">*</span>
                        </h3>
                        <p class="text-sm text-purple-700 mb-6">{{ __('Create a user account for this employee to access the system') }}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email Address -->
                            <div>
                                <label for="emp_email" class="block text-sm font-medium text-purple-700 mb-2">
                                    {{ __('Email Address') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email" 
                                           id="emp_email" 
                                           name="emp_email" 
                                           value="{{ old('emp_email') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-purple-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('emp_email') border-red-500 @enderror"
                                           placeholder="{{ __('employee@example.com') }}" 
                                           required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('emp_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="emp_password" class="block text-sm font-medium text-purple-700 mb-2">
                                    {{ __('Password') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="emp_password" 
                                           name="emp_password" 
                                           class="w-full pl-10 pr-4 py-3 border border-purple-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('emp_password') border-red-500 @enderror"
                                           placeholder="{{ __('Minimum 8 characters') }}" 
                                           required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('emp_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- User Role -->
                            <div class="md:col-span-2">
                                <label for="emp_role" class="block text-sm font-medium text-purple-700 mb-2">
                                    {{ __('User Role') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="emp_role" 
                                            name="emp_role" 
                                            class="w-full pl-10 pr-4 py-3 border border-purple-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('emp_role') border-red-500 @enderror appearance-none"
                                            required>
                                        <option value="">{{ __('Select user role') }}</option>
                                        <option value="user" {{ old('emp_role') == 'user' ? 'selected' : '' }}>
                                            {{ __('User') }} - {{ __('Standard access') }}
                                        </option>
                                        <option value="admin" {{ old('emp_role') == 'admin' ? 'selected' : '' }}>
                                            {{ __('Admin') }} - {{ __('Full system access') }}
                                        </option>
                                        <option value="agent" {{ old('emp_role') == 'agent' ? 'selected' : '' }}>
                                            {{ __('Agent') }} - {{ __('Limited access') }}
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('emp_role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Account Info -->
                        <div class="mt-4 p-4 bg-purple-100 rounded-lg border border-purple-200">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-purple-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-sm text-purple-800">
                                    <p class="font-medium mb-1">{{ __('Account Information') }}</p>
                                    <ul class="list-disc list-inside space-y-1 text-purple-700">
                                        <li>{{ __('The user account will be created automatically with the employee profile') }}</li>
                                        <li>{{ __('Employee can login using the email and password provided above') }}</li>
                                        <li>{{ __('User role determines system access permissions') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Description -->
            <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-200">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">{{ __('Role Descriptions') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                    <div>
                        <strong>{{ __('Cutters') }}:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>{{ __('Small Cutter: Handles small size garments') }}</li>
                            <li>{{ __('Large Cutter: Handles large size garments') }}</li>
                        </ul>
                    </div>
                    <div>
                        <strong>{{ __('Tailors (Salaye)') }}:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>{{ __('Small Tailor: Stitches small size garments') }}</li>
                            <li>{{ __('Large Tailor: Stitches large size garments') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <span class="text-red-500">*</span> {{ __('Required fields') }}
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('employees.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Create Employee') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Role selection change handler
        const roleSelect = document.getElementById('role');
        
        roleSelect.addEventListener('change', function() {
            const selectedRole = this.value;
            const cutterRatesSection = document.getElementById('cutter_rates');
            const salaryRateSection = document.getElementById('salary_rate_section');
            
            // Hide all sections first
            cutterRatesSection.classList.add('hidden');
            salaryRateSection.classList.add('hidden');
            
            // Show appropriate section based on role
            if (selectedRole === 'cutter') {
                cutterRatesSection.classList.remove('hidden');
            } else if (selectedRole === 'salaye') {
                salaryRateSection.classList.remove('hidden');
            }
        });
        
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const empName = document.getElementById('emp_name').value.trim();
            const role = document.getElementById('role').value;
            const empEmail = document.getElementById('emp_email').value.trim();
            const empPassword = document.getElementById('emp_password').value;
            const empRole = document.getElementById('emp_role').value;
            
            // Check required fields
            if (!empName || !role || !empEmail || !empPassword || !empRole) {
                e.preventDefault();
                alert('{{ __("Please fill in all required fields.") }}');
                return false;
            }
            
            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(empEmail)) {
                e.preventDefault();
                alert('{{ __("Please enter a valid email address.") }}');
                return false;
            }
            
            // Validate password length
            if (empPassword.length < 8) {
                e.preventDefault();
                alert('{{ __("Password must be at least 8 characters long.") }}');
                return false;
            }
            
            // Check if at least one rate is provided for the role
            let hasRate = false;
            
            if (role === 'cutter') {
                const cutterSRate = parseFloat(document.getElementById('cutter_s_rate').value) || 0;
                const cutterLRate = parseFloat(document.getElementById('cutter_l_rate').value) || 0;
                hasRate = cutterSRate > 0 || cutterLRate > 0;
            } else if (role === 'salaye') {
                const salayeSRate = parseFloat(document.getElementById('salaye_s_rate').value) || 0;
                const salayeLRate = parseFloat(document.getElementById('salaye_l_rate').value) || 0;
                hasRate = salayeSRate > 0 || salayeLRate > 0;
            }
            
            if (!hasRate) {
                e.preventDefault();
                alert('{{ __("Please set at least one rate for this employee.") }}');
                return false;
            }
        });
    });
</script>
@endsection
