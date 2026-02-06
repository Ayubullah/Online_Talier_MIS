@extends('layout.app')

@section('title', 'Edit Customer Vest Assignments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Edit Vest Assignments for') }} {{ $customer->cus_name }}</h1>
                    <p class="text-gray-600">{{ __('Update employee assignments and status') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('vest-assignments.complete-view') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('Back to Complete Vest Assignments') }}
                    </a>
                </div>
            </div>
        </div>

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

        <!-- Form -->
        <form action="{{ route('vest-assignments.update-customer', $customer) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            @foreach($vestMeasurements as $vestMeasurement)
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">
                        {{ __('Vest Measurement') }} #{{ $vestMeasurement->V_M_ID }}
                        <span class="text-sm font-normal text-gray-500">({{ $vestMeasurement->size }}, {{ $vestMeasurement->Vest_Type ?? 'Standard' }})</span>
                    </h3>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($vestMeasurement->clothAssignments as $assignment)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">
                                    {{ ucfirst($assignment->work_type) }} Assignment
                                </h4>

                                <div class="space-y-4">
                                    <!-- Employee Selection -->
                                    <div>
                                        <label for="assignments[{{ $assignment->ca_id }}][F_emp_id]" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('Assigned Employee') }}
                                        </label>
                                        <select name="assignments[{{ $assignment->ca_id }}][F_emp_id]"
                                                id="assignments[{{ $assignment->ca_id }}][F_emp_id]"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">{{ __('Select Employee') }}</option>
                                            @foreach($employees as $employee)
                                                @if($assignment->work_type === 'cutting' && $employee->role === 'cutter' && $employee->type === 'vest')
                                                    <option value="{{ $employee->emp_id }}"
                                                            {{ $assignment->F_emp_id == $employee->emp_id ? 'selected' : '' }}>
                                                        {{ $employee->emp_name }} ({{ ucfirst($employee->role) }})
                                                    </option>
                                                @elseif($assignment->work_type === 'salaye' && $employee->role === 'salaye' && $employee->type === 'vest')
                                                    <option value="{{ $employee->emp_id }}"
                                                            {{ $assignment->F_emp_id == $employee->emp_id ? 'selected' : '' }}>
                                                        {{ $employee->emp_name }} ({{ ucfirst($employee->role) }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Status Selection -->
                                    <div>
                                        <label for="assignments[{{ $assignment->ca_id }}][status]" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('Status') }}
                                        </label>
                                        <select name="assignments[{{ $assignment->ca_id }}][status]"
                                                id="assignments[{{ $assignment->ca_id }}][status]"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="pending" {{ $assignment->status === 'pending' ? 'selected' : '' }}>
                                                {{ __('Pending') }}
                                            </option>
                                            <option value="completed" {{ $assignment->status === 'completed' ? 'selected' : '' }}>
                                                {{ __('Completed') }}
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Current Information -->
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <h5 class="text-sm font-medium text-gray-700 mb-2">{{ __('Current Information') }}</h5>
                                        <div class="text-sm text-gray-600 space-y-1">
                                            <p><strong>{{ __('Rate') }}:</strong> ${{ number_format($assignment->rate_at_assign, 2) }}</p>
                                            <p><strong>{{ __('Assigned At') }}:</strong> {{ $assignment->assigned_at ? $assignment->assigned_at->format('M d, Y H:i') : 'N/A' }}</p>
                                            @if($assignment->completed_at)
                                                <p><strong>{{ __('Completed At') }}:</strong> {{ $assignment->completed_at->format('M d, Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Delete Option -->
                                    <div class="pt-3 border-t border-gray-200">
                                        <button type="button"
                                                onclick="confirmDeleteAssignment({{ $assignment->ca_id }}, '{{ $assignment->work_type }}')"
                                                class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            {{ __('Delete Assignment') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Submit Buttons -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('vest-assignments.complete-view') }}"
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('Update All Vest Assignments') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Function to confirm assignment deletion
    function confirmDeleteAssignment(assignmentId, workType) {
        if (confirm(`Are you sure you want to delete this ${workType} assignment? This action cannot be undone.`)) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/vest-assignments/delete-assignment/${assignmentId}`;

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);

            // Add method spoofing
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection

