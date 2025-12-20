<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\CustomerPayment;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentReportController extends Controller
{
    /**
     * Display the payment report with employee payments, customer payments, and balances
     */
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date', date('Y-m-01')); // First day of current month
        $toDate = $request->input('to_date', date('Y-m-d')); // Today
        
        // Get all employee payments (payments to employees)
        $employeePayments = Payment::with('employee')
            ->whereNotNull('F_emp_id')
            ->whereBetween('paid_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->orderBy('paid_at', 'desc')
            ->get();

        // Calculate total employee payments
        $totalEmployeePayments = $employeePayments->sum('amount');

        // Get employee payment summary by employee
        $employeePaymentSummary = Payment::select(
                'F_emp_id',
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as payment_count')
            )
            ->whereNotNull('F_emp_id')
            ->whereBetween('paid_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59'])
            ->groupBy('F_emp_id')
            ->with('employee')
            ->get();

        // Get all customer payments
        $customerPayments = CustomerPayment::with('customer')
            ->whereBetween('payment_date', [$fromDate, $toDate])
            ->orderBy('payment_date', 'desc')
            ->get();

        // Calculate total customer payments
        $totalCustomerPayments = $customerPayments->sum('amount');

        // Get customer payment summary by customer
        $customerPaymentSummary = CustomerPayment::select(
                'customer_id',
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as payment_count')
            )
            ->whereBetween('payment_date', [$fromDate, $toDate])
            ->groupBy('customer_id')
            ->with('customer')
            ->get();

        // Get all customers with their balances
        $customers = Customer::with(['clothMeasurements', 'vestMeasurements', 'customerPayments'])->get();
        
        $customerBalances = $customers->map(function ($customer) {
            $totalOrderValue = $customer->total_order_value;
            $totalPaid = $customer->total_paid;
            $remainingBalance = $customer->total_owed;
            
            return [
                'customer_id' => $customer->cus_id,
                'customer_name' => $customer->cus_name,
                'phone' => $customer->phone ? $customer->phone->pho_no : 'N/A',
                'total_order_value' => $totalOrderValue,
                'total_paid' => $totalPaid,
                'remaining_balance' => $remainingBalance,
                'payment_count' => $customer->customerPayments->count(),
            ];
        })->filter(function ($customer) {
            // Only show customers with orders or payments
            return $customer['total_order_value'] > 0 || $customer['total_paid'] > 0;
        })->sortByDesc('remaining_balance');

        // Calculate summary statistics
        $summary = [
            'total_employee_payments' => $totalEmployeePayments,
            'total_customer_payments' => $totalCustomerPayments,
            'total_customer_orders' => $customerBalances->sum('total_order_value'),
            'total_customer_paid' => $customerBalances->sum('total_paid'),
            'total_remaining_balance' => $customerBalances->sum('remaining_balance'),
            'employee_payment_count' => $employeePayments->count(),
            'customer_payment_count' => $customerPayments->count(),
            'customers_with_balance' => $customerBalances->where('remaining_balance', '>', 0)->count(),
        ];

        return view('payment-reports.index', compact(
            'employeePayments',
            'employeePaymentSummary',
            'customerPayments',
            'customerPaymentSummary',
            'customerBalances',
            'summary',
            'fromDate',
            'toDate'
        ));
    }
}

