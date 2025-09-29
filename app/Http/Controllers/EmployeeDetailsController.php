<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use App\Models\ClothAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeDetailsController extends Controller
{
    /**
     * Show the employee search page
     */
    public function index()
    {
        return view('employee-details.index');
    }

    /**
     * Search for employees by name or ID
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query)) {
            return redirect()->route('employee-details.index')
                ->with('error', 'Please enter a search term.');
        }

        $employees = Employee::where('emp_name', 'LIKE', "%{$query}%")
            ->orWhere('emp_id', 'LIKE', "%{$query}%")
            ->with(['user', 'clothAssignments.clothMeasurement.customer', 'clothAssignments.vestMeasurement.customer'])
            ->get();

        return view('employee-details.search-results', compact('employees', 'query'));
    }

    /**
     * Show detailed information for a specific employee
     */
    public function show($id)
    {
        $employee = Employee::with([
            'user',
            'clothAssignments' => function($query) {
                $query->with(['clothMeasurement.customer', 'vestMeasurement.customer'])
                      ->orderBy('created_at', 'desc');
            },
            'payments' => function($query) {
                $query->orderBy('paid_at', 'desc');
            }
        ])->findOrFail($id);

        // Calculate financial summaries
        $financialSummary = $this->calculateFinancialSummary($employee);
        
        // Get assignment statistics
        $assignmentStats = $this->getAssignmentStats($employee);
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity($employee);

        return view('employee-details.show', compact(
            'employee', 
            'financialSummary', 
            'assignmentStats', 
            'recentActivity'
        ));
    }

    /**
     * Calculate financial summary for the employee
     */
    private function calculateFinancialSummary($employee)
    {
        // Total earnings from assignments
        $totalEarnings = $employee->clothAssignments()
            ->where('status', 'complete')
            ->sum(DB::raw('qty * rate_at_assign'));

        // Total payments received
        $totalPayments = $employee->payments()->sum('amount');

        // Outstanding balance
        $outstandingBalance = $totalEarnings - $totalPayments;

        // Pending assignments value
        $pendingValue = $employee->clothAssignments()
            ->where('status', 'pending')
            ->sum(DB::raw('qty * rate_at_assign'));

        return [
            'total_earnings' => $totalEarnings,
            'total_payments' => $totalPayments,
            'outstanding_balance' => $outstandingBalance,
            'pending_value' => $pendingValue,
        ];
    }

    /**
     * Get assignment statistics for the employee
     */
    private function getAssignmentStats($employee)
    {
        $totalAssignments = $employee->clothAssignments()->count();
        $completedAssignments = $employee->clothAssignments()->where('status', 'complete')->count();
        $pendingAssignments = $employee->clothAssignments()->where('status', 'pending')->count();
        
        $clothAssignments = $employee->clothAssignments()->whereNotNull('F_cm_id')->count();
        $vestAssignments = $employee->clothAssignments()->whereNotNull('F_vm_id')->count();

        $completionRate = $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100, 1) : 0;

        return [
            'total_assignments' => $totalAssignments,
            'completed_assignments' => $completedAssignments,
            'pending_assignments' => $pendingAssignments,
            'cloth_assignments' => $clothAssignments,
            'vest_assignments' => $vestAssignments,
            'completion_rate' => $completionRate,
        ];
    }

    /**
     * Get recent activity for the employee
     */
    private function getRecentActivity($employee)
    {
        $recentAssignments = $employee->clothAssignments()
            ->with(['clothMeasurement.customer', 'vestMeasurement.customer'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentPayments = $employee->payments()
            ->orderBy('paid_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'recent_assignments' => $recentAssignments,
            'recent_payments' => $recentPayments,
        ];
    }

    /**
     * Get employee assignments with filters
     */
    public function assignments($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        
        $query = $employee->clothAssignments()
            ->with(['clothMeasurement.customer', 'vestMeasurement.customer']);

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('type') && $request->type !== '') {
            if ($request->type === 'cloth') {
                $query->whereNotNull('F_cm_id');
            } elseif ($request->type === 'vest') {
                $query->whereNotNull('F_vm_id');
            }
        }

        if ($request->has('work_type') && $request->work_type !== '') {
            $query->where('work_type', $request->work_type);
        }

        $assignments = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('employee-details.assignments', compact('employee', 'assignments'));
    }

    /**
     * Get employee payments with filters
     */
    public function payments($id, Request $request)
    {
        $employee = Employee::findOrFail($id);
        
        $query = $employee->payments();

        // Apply date filters
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('paid_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('paid_at', '<=', $request->to_date);
        }

        if ($request->has('method') && $request->method !== '') {
            $query->where('method', $request->method);
        }

        $payments = $query->orderBy('paid_at', 'desc')->paginate(20);

        return view('employee-details.payments', compact('employee', 'payments'));
    }
}
