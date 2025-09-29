<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Filter only employee payments
        $payments = Payment::with(['employee'])
            ->whereNotNull('F_emp_id')
            ->paginate(15);

        // Get statistics for employee payments only
        $totalAmount = Payment::whereNotNull('F_emp_id')->sum('amount');
        $thisMonthCount = Payment::whereNotNull('F_emp_id')->whereMonth('created_at', now()->month)->count();
        $employeePaymentsCount = Payment::whereNotNull('F_emp_id')->count();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $payments,
            ]);
        }

        // Return view for web requests
        return view('payments.index', compact('payments', 'totalAmount', 'thisMonthCount', 'employeePaymentsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Create form data',
            ]);
        }

        // Get pre-selected employee if provided
        $selectedEmployeeId = request('employee_id');
        $selectedEmployee = null;
        
        if ($selectedEmployeeId) {
            $selectedEmployee = \App\Models\Employee::find($selectedEmployeeId);
        }

        // Return view for web requests
        return view('payments.create', compact('selectedEmployee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'F_emp_id' => 'required|exists:employee,emp_id',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|in:cash,card,bank',
            'note' => 'nullable|string|max:255',
            'paid_at' => 'nullable|date',
        ]);

        // Set F_inc_id to null since we only handle employee payments
        $request->merge([
            'F_inc_id' => null
        ]);

        $payment = Payment::create($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment created successfully.',
                'data' => $payment->load(['employee']),
            ], 201);
        }

        // Check if user wants to print invoice immediately
        if (request()->has('print_invoice')) {
            return redirect()->route('payments.invoice', $payment)
                ->with('success', 'Payment created successfully. Invoice ready for printing.');
        }

        // Redirect for web requests
        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        // Load relationships for the view
        $payment->load(['employee']);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $payment,
            ]);
        }

        // Return view for web requests
        return view('payments.show', compact('payment'));
    }

    /**
     * Display payment invoice/slip for printing.
     */
    public function invoice(Payment $payment)
    {
        // Load relationships
        $payment->load(['employee']);
        
        // Get employee's financial summary
        $employee = $payment->employee;
        $totalEarnings = $employee->clothAssignments()
            ->where('status', 'complete')
            ->sum(\DB::raw('qty * rate_at_assign'));
        
        $totalPayments = $employee->payments()->sum('amount');
        $outstandingBalance = $totalEarnings - $totalPayments;
        $pendingValue = $employee->clothAssignments()
            ->where('status', 'pending')
            ->sum(\DB::raw('qty * rate_at_assign'));

        $financialSummary = [
            'total_earnings' => $totalEarnings,
            'total_payments' => $totalPayments,
            'outstanding_balance' => $outstandingBalance,
            'pending_value' => $pendingValue,
        ];

        // Get assignment statistics
        $totalAssignments = $employee->clothAssignments()->count();
        $completedAssignments = $employee->clothAssignments()->where('status', 'complete')->count();
        $pendingAssignments = $employee->clothAssignments()->where('status', 'pending')->count();
        $completionRate = $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100, 1) : 0;
        $clothAssignments = $employee->clothAssignments()->whereNotNull('F_cm_id')->count();
        $vestAssignments = $employee->clothAssignments()->whereNotNull('F_vm_id')->count();

        $assignmentStats = [
            'total_assignments' => $totalAssignments,
            'completed_assignments' => $completedAssignments,
            'pending_assignments' => $pendingAssignments,
            'completion_rate' => $completionRate,
            'cloth_assignments' => $clothAssignments,
            'vest_assignments' => $vestAssignments,
        ];

        return view('payments.invoice', compact('payment', 'financialSummary', 'assignmentStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $payment,
            ]);
        }

        // Return view for web requests
        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|in:cash,card,bank',
            'note' => 'nullable|string|max:255',
            'paid_at' => 'nullable|date',
        ]);

        // For updates, we don't allow changing the payment type or recipient
        // Only allow updating amount, method, note, and paid_at

        $payment->update($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment updated successfully.',
                'data' => $payment->load(['employee']),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
