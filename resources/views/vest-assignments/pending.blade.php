@extends('layout.app')

@section('title', 'Pending Vest Assignments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Success Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <ul class="list-disc list-inside text-sm text-red-800">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <div class="flex items-center mb-2">
                    <a href="{{ route('vest-assignments.index') }}" class="mr-4 text-blue-600 hover:text-blue-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('Pending Vest Assignments') }}</h1>
                </div>
                <p class="text-gray-600">{{ __('Assign vest work to employees and track progress') }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('vest-assignments.create') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Assign New Vest Work') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="bg-gradient-to-r from-yellow-500 to-orange-600 rounded-2xl shadow-lg p-6 mb-8 text-white">
        <!-- Debug Info (remove in production) -->
        @if(config('app.debug'))
        <div class="mb-4 p-3 bg-white/20 rounded-lg text-sm">
            <div class="grid grid-cols-2 gap-4 text-white">
                <div><strong>Vest Cutter Employees:</strong> {{ \App\Models\Employee::where('role', 'cutter')->where('type', 'vest')->count() }}</div>
                <div><strong>Vest Salaye Employees:</strong> {{ \App\Models\Employee::where('role', 'salaye')->where('type', 'vest')->count() }}</div>
            </div>
        </div>
        @endif
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium">{{ __('Pending Vest Assignments') }}</p>
                <p class="text-4xl font-bold">{{ $pendingCustomers->count() ?? 0 }}</p>
                <p class="text-yellow-100 text-sm">{{ __('assignments waiting to be assigned') }}</p>
            </div>
            <div class="bg-white/20 rounded-xl p-4">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Assignments Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold text-gray-900">{{ __('Pending Vest Assignments') }}</h2>
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="{{ __('Search assignments...') }}" 
                               class="search-input pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assignment') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Contact') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Vest Type') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Cutter') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Salaye') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="assignments-tbody">
                    @forelse($pendingCustomers as $cust)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold">
                                        #{{ $cust->cus_id }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $cust->cus_name }}</div>
                                    <div class="text-sm text-gray-500">Customer ID: {{ $cust->cus_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $cust->phone->pho_no ?? 'No Phone' }}</div>
                            <div class="text-sm text-gray-500">Contact</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($cust->vestMeasurements->count() > 0)
                                @foreach($cust->vestMeasurements as $vm)
                                    <div class="text-sm font-medium text-gray-900">{{ $vm->Vest_Type ?? 'Standard' }}</div>
                                @endforeach
                            @else
                                <span class="text-gray-400">No measurements</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $hasCutter = $cust->hasCutter ?? false;
                            @endphp
                            @if($hasCutter)
                                <div class="text-green-600 font-medium">✓ Assigned</div>
                                <div class="text-xs text-gray-500">
                                    @php
                                        $cutterAssignment = $cust->vestMeasurements->flatMap->clothAssignments->where('work_type', 'cutting')->first();
                                        $cutterEmployee = $cutterAssignment ? \App\Models\Employee::find($cutterAssignment->F_emp_id) : null;
                                    @endphp
                                    {{ $cutterEmployee ? $cutterEmployee->emp_name : 'Unknown' }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    @if($cutterAssignment)
                                        ${{ number_format($cutterAssignment->rate_at_assign ?? 0, 2) }}
                                    @endif
                                </div>
                            @else
                                @php
                                    $cutterVestEmployees = \App\Models\Employee::where('role', 'cutter')->where('type', 'vest')->get();
                                @endphp
                                <select name="emp_id_C" class="cutter-select border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        data-customer-id="{{ $cust->cus_id }}">
                                    <option value="">{{ __('Select Cutter') }}</option>
                                    @foreach($cutterVestEmployees as $employee)
                                        @php
                                            $rate = $employee->cutter_s_rate ?: $employee->cutter_l_rate ?: 0;
                                        @endphp
                                        <option value="{{ $employee->emp_id }}" 
                                                data-rate="{{ $rate ?? 0 }}">
                                            {{ $employee->emp_name }} - ${{ number_format($rate ?? 0, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="rateC" class="cutter-rate-input border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent mt-2" 
                                       placeholder="{{ __('Rate will be auto-filled') }}" readonly>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $hasSalaye = $cust->hasSalaye ?? false;
                            @endphp
                            @if($hasSalaye)
                                <div class="text-green-600 font-medium">✓ Assigned</div>
                                <div class="text-xs text-gray-500">
                                    @php
                                        $salayeAssignment = $cust->vestMeasurements->flatMap->clothAssignments->where('work_type', 'salaye')->first();
                                        $salayeEmployee = $salayeAssignment ? \App\Models\Employee::find($salayeAssignment->F_emp_id) : null;
                                    @endphp
                                    {{ $salayeEmployee ? $salayeEmployee->emp_name : 'Unknown' }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    @if($salayeAssignment)
                                        ${{ number_format($salayeAssignment->rate_at_assign ?? 0, 2) }}
                                    @endif
                                </div>
                            @else
                                @php
                                    $salayeVestEmployees = \App\Models\Employee::where('role', 'salaye')->where('type', 'vest')->get();
                                @endphp
                                <select name="emp_id_S" class="salaye-select border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                        data-customer-id="{{ $cust->cus_id }}">
                                    <option value="">{{ __('Select Salaye') }}</option>
                                    @foreach($salayeVestEmployees as $employee)
                                        @php
                                            $rate = $employee->salaye_s_rate ?: $employee->salaye_l_rate ?: 0;
                                        @endphp
                                        <option value="{{ $employee->emp_id }}" 
                                                data-rate="{{ $rate ?? 0 }}">
                                            {{ $employee->emp_name }} - ${{ number_format($rate ?? 0, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="rateS" class="salaye-rate-input border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent mt-2" 
                                       placeholder="{{ __('Rate will be auto-filled') }}" readonly>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $hasCutter = $cust->hasCutter ?? false;
                                $hasSalaye = $cust->hasSalaye ?? false;
                            @endphp
                            @if(!$hasCutter || !$hasSalaye)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ __('Pending') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ __('Ready') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                @php
                                    $hasCutter = $cust->hasCutter ?? false;
                                    $hasSalaye = $cust->hasSalaye ?? false;
                                @endphp
                                @if(!$hasCutter || !$hasSalaye)
                                    <form action="{{ route('vest-assignments.store') }}" method="POST" class="inline assignment-form" data-customer-id="{{ $cust->cus_id }}">
                                        @csrf
                                        @if($cust->vestMeasurements->count() > 0)
                                            <input type="hidden" name="F_vm_id" value="{{ $cust->vestMeasurements->first()->V_M_ID }}">
                                        @endif
                                        
                                        <!-- Hidden inputs for employee IDs and rates -->
                                        <input type="hidden" name="emp_id_C" class="cutter-emp-id">
                                        <input type="hidden" name="emp_id_S" class="salaye-emp-id">
                                        <input type="hidden" name="rateC" class="cutter-rate-hidden">
                                        <input type="hidden" name="rateS" class="salaye-rate-hidden">
                                        
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg transition-colors duration-200 assign-btn cursor-not-allowed opacity-50" disabled>
                                            {{ __('Select Both Employees') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600 font-medium">{{ __('Complete') }}</span>
                                @endif
                                <a href="#" class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No pending vest assignments') }}</h3>
                                <p class="text-gray-500 mb-4">{{ __('All vest assignments are complete.') }}</p>
                                <a href="{{ route('vest-assignments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    {{ __('Create New Vest Assignment') }}
                                </a>
                            </div>
                        </td>
                   </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const tbody = document.getElementById('assignments-tbody');
        
        if (searchInput && tbody) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = tbody.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? 'table-row' : 'none';
                });
            });
        }

        // Function to update rate based on employee selection
        function updateRate(selectElement, rateInput) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            
            if (selectedOption.value) {
                const rate = selectedOption.getAttribute('data-rate');
                if (rate) {
                    rateInput.value = '$' + parseFloat(rate).toFixed(2);
                    rateInput.style.backgroundColor = '#f0f9ff';
                } else {
                    rateInput.value = 'No rate available';
                    rateInput.style.backgroundColor = '#fef2f2';
                }
            } else {
                rateInput.value = '';
                rateInput.style.backgroundColor = '';
            }
        }

        // Add event listeners to all cutter selects
        document.querySelectorAll('.cutter-select').forEach(function(select) {
            select.addEventListener('change', function() {
                const rateInput = this.closest('td').querySelector('.cutter-rate-input');
                updateRate(this, rateInput);
                updateFormState();
            });
        });

        // Add event listeners to all salaye selects
        document.querySelectorAll('.salaye-select').forEach(function(select) {
            select.addEventListener('change', function() {
                const rateInput = this.closest('td').querySelector('.salaye-rate-input');
                updateRate(this, rateInput);
                updateFormState();
            });
        });

        // Function to update form state and enable/disable assign button
        function updateFormState() {
            document.querySelectorAll('.assignment-form').forEach(function(form) {
                const customerId = form.getAttribute('data-customer-id');
                const row = form.closest('tr');
                
                // Get cutter and salaye selections for this customer
                const cutterSelect = row.querySelector('.cutter-select');
                const salayeSelect = row.querySelector('.salaye-select');
                const cutterRateInput = row.querySelector('.cutter-rate-input');
                const salayeRateInput = row.querySelector('.salaye-rate-input');
                
                // Get hidden inputs
                const cutterEmpId = form.querySelector('.cutter-emp-id');
                const salayeEmpId = form.querySelector('.salaye-emp-id');
                const cutterRateHidden = form.querySelector('.cutter-rate-hidden');
                const salayeRateHidden = form.querySelector('.salaye-rate-hidden');
                const assignBtn = form.querySelector('.assign-btn');
                
                // Check if both are selected
                const hasCutter = cutterSelect && cutterSelect.value !== '';
                const hasSalaye = salayeSelect && salayeSelect.value !== '';
                
                console.log('Form state check:', {
                    customerId: customerId,
                    hasCutter: hasCutter,
                    cutterValue: cutterSelect ? cutterSelect.value : 'no select',
                    hasSalaye: hasSalaye,
                    salayeValue: salayeSelect ? salayeSelect.value : 'no select'
                });
                
                if (hasCutter && hasSalaye) {
                    // Enable button and populate hidden fields
                    assignBtn.disabled = false;
                    assignBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                    assignBtn.classList.add('bg-green-600', 'hover:bg-green-700');
                    assignBtn.textContent = 'Assign Both';
                    
                    // Populate hidden fields
                    if (cutterEmpId) cutterEmpId.value = cutterSelect.value;
                    if (salayeEmpId) salayeEmpId.value = salayeSelect.value;
                    
                    // Get rates from the selected options
                    const cutterRate = cutterSelect.options[cutterSelect.selectedIndex].getAttribute('data-rate');
                    const salayeRate = salayeSelect.options[salayeSelect.selectedIndex].getAttribute('data-rate');
                    
                    if (cutterRateHidden) cutterRateHidden.value = cutterRate || '';
                    if (salayeRateHidden) salayeRateHidden.value = salayeRate || '';
                    
                    console.log('Button enabled for customer:', customerId);
                } else {
                    // Disable button
                    assignBtn.disabled = true;
                    assignBtn.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                    assignBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
                    assignBtn.textContent = 'Select Both Employees';
                    
                    console.log('Button disabled for customer:', customerId);
                }
            });
        }

        // Initialize form state on page load
        updateFormState();

        // Add form submission debugging
        document.querySelectorAll('.assignment-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const formData = new FormData(this);
                console.log('Form data being submitted:', Object.fromEntries(formData));
                
                // Check if required fields are filled
                const hasCutter = formData.get('emp_id_C');
                const hasSalaye = formData.get('emp_id_S');
                const hasRateC = formData.get('rateC');
                const hasRateS = formData.get('rateS');
                
                console.log('Validation check:', {
                    hasCutter: !!hasCutter,
                    hasSalaye: !!hasSalaye,
                    hasRateC: !!hasRateC,
                    hasRateS: !!hasRateS
                });
                
                if (!hasCutter || !hasSalaye || !hasRateC || !hasRateS) {
                    e.preventDefault();
                    alert('Please select both cutter and salaye employees before submitting.');
                    return false;
                }
            });
        });
    });
</script>
@endsection
