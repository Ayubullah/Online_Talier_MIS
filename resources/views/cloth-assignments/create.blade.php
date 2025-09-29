@extends('layout.app')

@section('title', 'Create Cloth Assignment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Create New Assignment') }}</h1>
                <p class="text-gray-600">{{ __('Assign work to employees and set delivery expectations') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('cloth-assignments.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Assignments') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Assignment Form -->
    <form method="POST" action="{{ route('cloth-assignments.store') }}" class="space-y-6">
        @csrf

        <!-- Error Display -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-center mb-2">
                    <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-sm font-medium text-red-800">{{ __('Please correct the following errors:') }}</h3>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Assignment Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    {{ __('Assignment Details') }}
                </h2>
                <p class="text-orange-100 mt-1 text-sm">{{ __('Configure work assignment parameters') }}</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Employee Selection -->
                    <div class="md:col-span-2">
                        <label for="F_emp_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Assign to Employee') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="F_emp_id" id="F_emp_id" 
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                    required>
                                <option value="">{{ __('Select an employee') }}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->emp_id }}" {{ old('F_emp_id') == $employee->emp_id ? 'selected' : '' }}>
                                        {{ $employee->emp_name }} - {{ $employee->role ?? 'Employee' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('F_emp_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Work Type -->
                    <div>
                        <label for="work_type" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Work Type') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="work_type" id="work_type" 
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white"
                                    required>
                                <option value="">{{ __('Select work type') }}</option>
                                <option value="cutting" {{ old('work_type') == 'cutting' ? 'selected' : '' }}>{{ __('Cutting') }}</option>
                                <option value="salaye" {{ old('work_type') == 'salaye' ? 'selected' : '' }}>{{ __('Salaye') }}</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 7.172V5L8 4z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('work_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Status') }}
                        </label>
                        <div class="relative">
                            <select name="status" id="status" 
                                    class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 bg-white">
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="complete" {{ old('status') == 'complete' ? 'selected' : '' }}>{{ __('Complete') }}</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="qty" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Quantity') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="qty" id="qty" min="1" 
                                   value="{{ old('qty', 1) }}"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                   placeholder="{{ __('Enter quantity') }}" required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                        </div>
                        @error('qty')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rate at Assignment -->
                    <div>
                        <label for="rate_at_assign" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Rate at Assignment') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="rate_at_assign" id="rate_at_assign" step="0.01" min="0" 
                                   value="{{ old('rate_at_assign') }}"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200"
                                   placeholder="{{ __('Enter rate') }}" required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        @error('rate_at_assign')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assignment Date -->
                    <div class="md:col-span-2">
                        <label for="assigned_at" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Assignment Date') }}
                        </label>
                        <div class="relative">
                            <input type="datetime-local" name="assigned_at" id="assigned_at" 
                                   value="{{ old('assigned_at', now()->format('Y-m-d\TH:i')) }}"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('assigned_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Selection -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    {{ __('Select Item to Assign') }}
                </h2>
                <p class="text-blue-100 mt-1 text-sm">{{ __('Choose either a cloth measurement or vest measurement (not both)') }}</p>
            </div>

            <div class="p-6">
                <!-- Item Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Item Type') }} <span class="text-red-500">*</span></label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="item_type" value="cloth" class="form-radio text-blue-600" 
                                   {{ old('item_type') == 'cloth' ? 'checked' : '' }} onchange="toggleItemSelection()">
                            <span class="ml-2 text-sm text-gray-700">{{ __('Cloth Measurement') }}</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="item_type" value="vest" class="form-radio text-blue-600" 
                                   {{ old('item_type') == 'vest' ? 'checked' : '' }} onchange="toggleItemSelection()">
                            <span class="ml-2 text-sm text-gray-700">{{ __('Vest Measurement') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Cloth Measurements Selection -->
                <div id="cloth-selection" class="hidden">
                    <label for="F_cm_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Select Cloth Measurement') }}
                    </label>
                    <select name="F_cm_id" id="F_cm_id" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        <option value="">{{ __('Select a cloth measurement') }}</option>
                        @foreach($clothMeasurements as $cloth)
                            <option value="{{ $cloth->cm_id }}" {{ old('F_cm_id') == $cloth->cm_id ? 'selected' : '' }}>
                                {{ $cloth->customer->cus_name }} - Cloth #{{ $cloth->cm_id }} ({{ $cloth->size }}) - ${{ $cloth->cloth_rate }}
                            </option>
                        @endforeach
                    </select>
                    @error('F_cm_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vest Measurements Selection -->
                <div id="vest-selection" class="hidden">
                    <label for="F_vm_id" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Select Vest Measurement') }}
                    </label>
                    <select name="F_vm_id" id="F_vm_id" 
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white">
                        <option value="">{{ __('Select a vest measurement') }}</option>
                        @foreach($vestMeasurements as $vest)
                            <option value="{{ $vest->V_M_ID }}" {{ old('F_vm_id') == $vest->V_M_ID ? 'selected' : '' }}>
                                {{ $vest->customer->cus_name }} - Vest #{{ $vest->V_M_ID }} ({{ $vest->size }}) - ${{ $vest->vest_rate }}
                            </option>
                        @endforeach
                    </select>
                    @error('F_vm_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @error('assignment')
                    <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    </div>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    <span class="text-red-500">*</span> {{ __('Required fields') }}
                </p>
                <div class="flex items-center gap-3">
                    <a href="{{ route('cloth-assignments.index') }}" 
                       class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all duration-200">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white font-semibold rounded-lg hover:from-orange-700 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Create Assignment') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleItemSelection() {
        const itemType = document.querySelector('input[name="item_type"]:checked');
        const clothSelection = document.getElementById('cloth-selection');
        const vestSelection = document.getElementById('vest-selection');
        const clothSelect = document.getElementById('F_cm_id');
        const vestSelect = document.getElementById('F_vm_id');

        // Hide both sections first
        clothSelection.classList.add('hidden');
        vestSelection.classList.add('hidden');
        
        // Clear selections
        clothSelect.value = '';
        vestSelect.value = '';

        if (itemType) {
            if (itemType.value === 'cloth') {
                clothSelection.classList.remove('hidden');
            } else if (itemType.value === 'vest') {
                vestSelection.classList.remove('hidden');
            }
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleItemSelection();
        
        // Add change event listeners
        document.querySelectorAll('input[name="item_type"]').forEach(radio => {
            radio.addEventListener('change', toggleItemSelection);
        });

        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const itemType = document.querySelector('input[name="item_type"]:checked');
            const clothId = document.getElementById('F_cm_id').value;
            const vestId = document.getElementById('F_vm_id').value;

            if (!itemType) {
                e.preventDefault();
                alert('{{ __("Please select an item type (Cloth or Vest)") }}');
                return false;
            }

            if (itemType.value === 'cloth' && !clothId) {
                e.preventDefault();
                alert('{{ __("Please select a cloth measurement") }}');
                return false;
            }

            if (itemType.value === 'vest' && !vestId) {
                e.preventDefault();
                alert('{{ __("Please select a vest measurement") }}');
                return false;
            }

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ __('Creating...') }}
            `;
        });
    });
</script>
@endsection
