@extends('layout.app')

@section('title', 'Create Vest Assignment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Create New Vest Assignment') }}</h1>
                    <p class="text-gray-600">{{ __('Assign vest work to employees') }}</p>
                </div>
                <a href="{{ route('vest-assignments.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <form action="{{ route('vest-assignments.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Vest Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="vest_measurement" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Select Vest Measurement') }}
                        </label>
                        <select name="vest_measurement" id="vest_measurement" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">{{ __('Choose a vest measurement...') }}</option>
                            @foreach($vestMeasurements as $vest)
                                <option value="{{ $vest->V_M_ID }}" 
                                        data-size="{{ $vest->size }}"
                                        data-rate="{{ $vest->vest_rate }}"
                                        data-customer="{{ $vest->customer->cus_name }}">
                                    {{ $vest->customer->cus_name }} - {{ $vest->Vest_Type ?? 'Standard' }} ({{ $vest->size }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Vest Details') }}
                        </label>
                        <div id="vest-details" class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">{{ __('Select a vest measurement to see details') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Employee Assignments -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Employee Assignments') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cutter Assignment -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">{{ __('Cutter Assignment') }}</h4>
                            
                            <div>
                                <label for="cutter_employee" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Select Cutter') }}
                                </label>
                                <select name="emp_id_C" id="cutter_employee" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">{{ __('Choose a cutter...') }}</option>
                                    @foreach($employees as $employee)
                                        @if($employee->role === 'cutter' && $employee->type === 'vest')
                                            <option value="{{ $employee->emp_id }}" 
                                                    data-s-rate="{{ $employee->cutter_s_rate }}" 
                                                    data-l-rate="{{ $employee->cutter_l_rate }}">
                                                {{ $employee->emp_name }} (ID: {{ $employee->emp_id }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="cutter_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Rate') }}
                                </label>
                                <input type="text" name="rateC" id="cutter_rate" readonly
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-gray-700"
                                       placeholder="{{ __('Rate will be auto-filled') }}">
                            </div>
                        </div>

                        <!-- Salaye Assignment -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-700">{{ __('Salaye Assignment') }}</h4>
                            
                            <div>
                                <label for="salaye_employee" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Select Salaye') }}
                                </label>
                                <select name="emp_id_S" id="salaye_employee" 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="">{{ __('Choose a salaye...') }}</option>
                                    @foreach($employees as $employee)
                                        @if($employee->role === 'salaye' && $employee->type === 'vest')
                                            <option value="{{ $employee->emp_id }}" 
                                                    data-s-rate="{{ $employee->salaye_s_rate }}" 
                                                    data-l-rate="{{ $employee->salaye_l_rate }}">
                                                {{ $employee->emp_name }} (ID: {{ $employee->emp_id }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="salaye_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Rate') }}
                                </label>
                                <input type="text" name="rateS" id="salaye_rate" readonly
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-gray-700"
                                       placeholder="{{ __('Rate will be auto-filled') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="F_vm_id" id="F_vm_id">

                <!-- Submit Button -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Create Assignment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const vestSelect = document.getElementById('vest_measurement');
        const vestDetails = document.getElementById('vest-details');
        const F_vm_id = document.getElementById('F_vm_id');
        const cutterEmployee = document.getElementById('cutter_employee');
        const salayeEmployee = document.getElementById('salaye_employee');
        const cutterRate = document.getElementById('cutter_rate');
        const salayeRate = document.getElementById('salaye_rate');

        // Update vest details when selection changes
        vestSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const size = selectedOption.getAttribute('data-size');
                const rate = selectedOption.getAttribute('data-rate');
                const customer = selectedOption.getAttribute('data-customer');
                
                F_vm_id.value = selectedOption.value;
                
                vestDetails.innerHTML = `
                    <div class="space-y-2">
                        <p class="text-sm"><strong>Customer:</strong> ${customer}</p>
                        <p class="text-sm"><strong>Size:</strong> ${size === 'S' ? 'Small' : 'Large'}</p>
                        <p class="text-sm"><strong>Rate:</strong> $${parseFloat(rate).toFixed(2)}</p>
                    </div>
                `;
                
                // Update rates based on size
                updateRates();
            } else {
                vestDetails.innerHTML = '<p class="text-gray-500 text-sm">{{ __("Select a vest measurement to see details") }}</p>';
                F_vm_id.value = '';
                cutterRate.value = '';
                salayeRate.value = '';
            }
        });

        // Update rates when employee selection changes
        function updateRates() {
            const selectedVest = vestSelect.options[vestSelect.selectedIndex];
            if (!selectedVest.value) return;
            
            const size = selectedVest.getAttribute('data-size');
            
            // Update cutter rate
            if (cutterEmployee.value) {
                const selectedCutter = cutterEmployee.options[cutterEmployee.selectedIndex];
                const sRate = selectedCutter.getAttribute('data-s-rate');
                const lRate = selectedCutter.getAttribute('data-l-rate');
                
                if (size === 'S' && sRate) {
                    cutterRate.value = '$' + parseFloat(sRate).toFixed(2);
                } else if (size === 'L' && lRate) {
                    cutterRate.value = '$' + parseFloat(lRate).toFixed(2);
                } else {
                    cutterRate.value = 'No rate available';
                }
            }
            
            // Update salaye rate
            if (salayeEmployee.value) {
                const selectedSalaye = salayeEmployee.options[salayeEmployee.selectedIndex];
                const sRate = selectedSalaye.getAttribute('data-s-rate');
                const lRate = selectedSalaye.getAttribute('data-l-rate');
                
                if (size === 'S' && sRate) {
                    salayeRate.value = '$' + parseFloat(sRate).toFixed(2);
                } else if (size === 'L' && lRate) {
                    salayeRate.value = '$' + parseFloat(lRate).toFixed(2);
                } else {
                    salayeRate.value = 'No rate available';
                }
            }
        }

        // Add event listeners for employee selection changes
        cutterEmployee.addEventListener('change', updateRates);
        salayeEmployee.addEventListener('change', updateRates);
    });
</script>
@endsection
