<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Payment Invoice') }} - {{ $payment->employee->emp_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
            .invoice-container { box-shadow: none; margin: 0; }
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .company-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .payment-details {
            background: #f8fafc;
        }
        
        .signature-line {
            border-bottom: 1px solid #374151;
            width: 200px;
            margin-top: 40px;
        }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <div class="invoice-container">
        <!-- Company Header -->
        <div class="company-header p-8 text-center">
            <h1 class="text-3xl font-bold mb-2">{{ __('Medical Store Management System') }}</h1>
            <p class="text-lg opacity-90">{{ __('Employee Payment Invoice') }}</p>
            <div class="mt-4 text-sm opacity-75">
                <p>{{ __('Date') }}: {{ now()->format('M d, Y') }}</p>
                <p>{{ __('Invoice') }} #: PAY-{{ str_pad($payment->pay_id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="p-8">
            <!-- Employee Information -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                    {{ __('Employee Information') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Employee Name') }}</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $payment->employee->emp_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Employee ID') }}</p>
                        <p class="text-lg font-semibold text-gray-800">#{{ $payment->employee->emp_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Role') }}</p>
                        <p class="text-lg font-semibold text-gray-800">{{ ucfirst($payment->employee->role) }}</p>
                    </div>
                    @if($payment->employee->type)
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Type') }}</p>
                        <p class="text-lg font-semibold text-gray-800">{{ ucfirst($payment->employee->type) }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="payment-details p-6 rounded-lg mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-green-500 pb-2">
                    {{ __('Payment Details') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Payment Date') }}</p>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $payment->paid_at ? $payment->paid_at->format('M d, Y - h:i A') : $payment->created_at->format('M d, Y - h:i A') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Payment Method') }}</p>
                        <p class="text-lg font-semibold text-gray-800">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($payment->method == 'cash') bg-green-100 text-green-800
                                @elseif($payment->method == 'card') bg-blue-100 text-blue-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ ucfirst($payment->method) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Amount Paid') }}</p>
                        <p class="text-3xl font-bold text-green-600">${{ number_format($payment->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">{{ __('Transaction ID') }}</p>
                        <p class="text-lg font-semibold text-gray-800">TXN-{{ str_pad($payment->pay_id, 8, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                
                @if($payment->note)
                <div class="mt-6">
                    <p class="text-sm text-gray-600 mb-1">{{ __('Payment Note') }}</p>
                    <p class="text-lg text-gray-800 bg-white p-3 rounded border">{{ $payment->note }}</p>
                </div>
                @endif
            </div>

            <!-- Employee Financial Summary -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-purple-500 pb-2">
                    {{ __('Employee Financial Summary') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <p class="text-sm text-blue-600 mb-1">{{ __('Total Earnings') }}</p>
                        <p class="text-2xl font-bold text-blue-800">${{ number_format($financialSummary['total_earnings'], 2) }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg text-center">
                        <p class="text-sm text-green-600 mb-1">{{ __('Total Payments') }}</p>
                        <p class="text-2xl font-bold text-green-800">${{ number_format($financialSummary['total_payments'], 2) }}</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg text-center">
                        <p class="text-sm text-orange-600 mb-1">{{ __('Outstanding Balance') }}</p>
                        <p class="text-2xl font-bold text-orange-800">${{ number_format($financialSummary['outstanding_balance'], 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Assignment Summary -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-indigo-500 pb-2">
                    {{ __('Assignment Summary') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">{{ __('Total Assignments') }}</p>
                        <p class="text-xl font-bold text-gray-800">{{ $assignmentStats['total_assignments'] }}</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-600 mb-1">{{ __('Completed') }}</p>
                        <p class="text-xl font-bold text-green-800">{{ $assignmentStats['completed_assignments'] }}</p>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <p class="text-sm text-yellow-600 mb-1">{{ __('Pending') }}</p>
                        <p class="text-xl font-bold text-yellow-800">{{ $assignmentStats['pending_assignments'] }}</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-sm text-purple-600 mb-1">{{ __('Completion Rate') }}</p>
                        <p class="text-xl font-bold text-purple-800">{{ $assignmentStats['completion_rate'] }}%</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t-2 border-gray-200 pt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Authorized Signature') }}</h3>
                        <div class="signature-line"></div>
                        <p class="text-sm text-gray-600 mt-2">{{ __('Manager/Authorized Person') }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Employee Signature') }}</h3>
                        <div class="signature-line"></div>
                        <p class="text-sm text-gray-600 mt-2">{{ $payment->employee->emp_name }}</p>
                    </div>
                </div>
                
                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>{{ __('This is a computer-generated invoice. No signature required.') }}</p>
                    <p>{{ __('Generated on') }}: {{ now()->format('M d, Y - h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div class="no-print text-center mt-8">
        <button onclick="window.print()" 
                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors duration-200 mr-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            {{ __('Print Invoice') }}
        </button>
        <a href="{{ route('payments.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-xl hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            {{ __('Back to Payments') }}
        </a>
    </div>

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
