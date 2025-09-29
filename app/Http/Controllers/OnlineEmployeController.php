<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use App\Models\ClothAssignment;
use App\Models\ClothM;
use App\Models\VestM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineEmployeController extends Controller
{
    /**
     * Show comprehensive employee dashboard for the logged-in user
     */
    public function index()
    {
        $user = request()->user();

        // Check if user has an associated employee record
        if (!$user->employee) {
            return view('Online_employee-details.index', [
                'hasEmployeeRecord' => false,
                'error' => 'No employee record found for your account. Please contact administrator.'
            ]);
        }

        $employee = Employee::with([
            'user',
            'clothAssignments' => function($query) {
                $query->with(['clothMeasurement.customer', 'vestMeasurement.customer'])
                      ->orderBy('created_at', 'desc');
            },
            'payments' => function($query) {
                $query->orderBy('paid_at', 'desc');
            }
        ])->findOrFail($user->employee->emp_id);

        // Calculate financial summaries
        $financialSummary = $this->calculateFinancialSummary($employee);

        // Get assignment statistics
        $assignmentStats = $this->getAssignmentStats($employee);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($employee);

        // Get cloth and vest assignments separately
        $clothAssignments = $employee->clothAssignments()->whereNotNull('F_cm_id')->with(['clothMeasurement.customer'])->get();
        $vestAssignments = $employee->clothAssignments()->whereNotNull('F_vm_id')->with(['vestMeasurement.customer'])->get();

        // Get monthly earnings for the last 6 months
        $monthlyEarnings = $this->getMonthlyEarnings($employee);

        // Get performance metrics
        $performanceMetrics = $this->getPerformanceMetrics($employee);

        $data = [
            'employee' => $employee,
            'financialSummary' => $financialSummary,
            'assignmentStats' => $assignmentStats,
            'recentActivity' => $recentActivity,
            'clothAssignments' => $clothAssignments,
            'vestAssignments' => $vestAssignments,
            'monthlyEarnings' => $monthlyEarnings,
            'performanceMetrics' => $performanceMetrics,
            'hasEmployeeRecord' => true
        ];

        return view('Online_employee-details.index', $data);
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
     * Get monthly earnings for the last 6 months
     */
    private function getMonthlyEarnings($employee)
    {
        $earnings = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');

            $monthlyTotal = $employee->clothAssignments()
                ->where('status', 'complete')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum(DB::raw('qty * rate_at_assign'));

            $earnings[] = [
                'month' => $monthYear,
                'amount' => $monthlyTotal,
            ];
        }

        return $earnings;
    }

    /**
     * Get performance metrics for the employee
     */
    private function getPerformanceMetrics($employee)
    {
        $totalAssignments = $employee->clothAssignments()->count();
        $completedAssignments = $employee->clothAssignments()->where('status', 'complete')->count();
        $pendingAssignments = $employee->clothAssignments()->where('status', 'pending')->count();

        $avgCompletionTime = 0;
        if ($completedAssignments > 0) {
            $completedAssignmentsData = $employee->clothAssignments()
                ->where('status', 'complete')
                ->whereNotNull('updated_at')
                ->get();

            if ($completedAssignmentsData->count() > 0) {
                $totalDays = 0;
                foreach ($completedAssignmentsData as $assignment) {
                    $created = $assignment->created_at;
                    $updated = $assignment->updated_at;
                    $totalDays += $created->diffInDays($updated);
                }
                $avgCompletionTime = round($totalDays / $completedAssignmentsData->count(), 1);
            }
        }

        $totalRevenue = $employee->clothAssignments()
            ->where('status', 'complete')
            ->sum(DB::raw('qty * rate_at_assign'));

        $monthlyTarget = $employee->isCutter() ? 2000 : 1500; // Example targets
        $currentMonthEarnings = $employee->clothAssignments()
            ->where('status', 'complete')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum(DB::raw('qty * rate_at_assign'));

        $targetProgress = $monthlyTarget > 0 ? min(100, ($currentMonthEarnings / $monthlyTarget) * 100) : 0;

        return [
            'total_assignments' => $totalAssignments,
            'completed_assignments' => $completedAssignments,
            'pending_assignments' => $pendingAssignments,
            'avg_completion_time' => $avgCompletionTime,
            'total_revenue' => $totalRevenue,
            'monthly_target' => $monthlyTarget,
            'current_month_earnings' => $currentMonthEarnings,
            'target_progress' => $targetProgress,
            'completion_rate' => $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100, 1) : 0,
        ];
    }

    /**
     * Show all transactions and financial activities for the logged-in employee
     */
    public function transactions()
    {
        $user = request()->user();

        if (!$user->employee) {
            return view('transactions.index', [
                'hasEmployeeRecord' => false,
                'error' => 'No employee record found for your account. Please contact administrator.'
            ]);
        }

        $employee = Employee::with([
            'user',
            'clothAssignments' => function($query) {
                $query->with(['clothMeasurement.customer', 'vestMeasurement.customer'])
                      ->orderBy('created_at', 'desc');
            },
            'payments' => function($query) {
                $query->orderBy('paid_at', 'desc');
            }
        ])->findOrFail($user->employee->emp_id);

        // Get all transactions (payments and assignments)
        $payments = $employee->payments()->with(['employee.user'])->orderBy('paid_at', 'desc')->get();
        $assignments = $employee->clothAssignments()->with(['clothMeasurement.customer', 'vestMeasurement.customer'])->orderBy('created_at', 'desc')->get();

        // Combine and sort all transactions by date
        $allTransactions = collect();

        // Add payments to transactions
        foreach ($payments as $payment) {
            $allTransactions->push([
                'id' => 'payment_' . $payment->id,
                'type' => 'payment',
                'title' => 'Payment Received',
                'description' => ucfirst($payment->method) . ' payment',
                'amount' => $payment->amount,
                'date' => $payment->paid_at,
                'status' => 'completed',
                'icon' => 'payment',
                'color' => 'green',
                'details' => $payment->note ?? 'No additional notes',
                'customer' => null,
                'work_type' => null
            ]);
        }

        // Add assignments to transactions
        foreach ($assignments as $assignment) {
            $customer = null;
            if ($assignment->clothMeasurement && $assignment->clothMeasurement->customer) {
                $customer = $assignment->clothMeasurement->customer;
            } elseif ($assignment->vestMeasurement && $assignment->vestMeasurement->customer) {
                $customer = $assignment->vestMeasurement->customer;
            }

            $allTransactions->push([
                'id' => 'assignment_' . $assignment->id,
                'type' => 'assignment',
                'title' => ucfirst($assignment->assignment_type) . ' Assignment',
                'description' => ucfirst($assignment->work_type) . ' work assigned',
                'amount' => $assignment->total_amount,
                'date' => $assignment->created_at,
                'status' => $assignment->status,
                'icon' => $assignment->assignment_type,
                'color' => $assignment->status === 'complete' ? 'green' : 'yellow',
                'details' => 'Quantity: ' . $assignment->qty . ' | Rate: $' . number_format($assignment->rate_at_assign, 2),
                'customer' => $customer,
                'work_type' => $assignment->work_type
            ]);
        }

        // Sort transactions by date (newest first)
        $sortedTransactions = $allTransactions->sortByDesc('date')->values();

        // Calculate transaction statistics
        $transactionStats = [
            'total_transactions' => $sortedTransactions->count(),
            'total_payments' => $payments->count(),
            'total_assignments' => $assignments->count(),
            'completed_assignments' => $assignments->where('status', 'complete')->count(),
            'pending_assignments' => $assignments->where('status', 'pending')->count(),
            'total_amount_received' => $payments->sum('amount'),
            'total_work_value' => $assignments->sum('total_amount'),
            'average_transaction_amount' => $sortedTransactions->count() > 0 ? $sortedTransactions->avg('amount') : 0,
        ];

        // Monthly transaction data for charts
        $monthlyTransactionData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');

            $monthlyPayments = $payments->where('paid_at', '>=', $date->startOfMonth())
                                       ->where('paid_at', '<=', $date->endOfMonth())
                                       ->sum('amount');

            $monthlyAssignments = $assignments->where('created_at', '>=', $date->startOfMonth())
                                           ->where('created_at', '<=', $date->endOfMonth())
                                           ->sum('total_amount');

            $monthlyTransactionData[] = [
                'month' => $monthYear,
                'payments' => $monthlyPayments,
                'assignments' => $monthlyAssignments,
                'total' => $monthlyPayments + $monthlyAssignments,
                'count' => $payments->where('paid_at', '>=', $date->startOfMonth())
                                   ->where('paid_at', '<=', $date->endOfMonth())->count() +
                          $assignments->where('created_at', '>=', $date->startOfMonth())
                                     ->where('created_at', '<=', $date->endOfMonth())->count()
            ];
        }

        return view('transactions.index', [
            'employee' => $employee,
            'transactions' => $sortedTransactions,
            'transactionStats' => $transactionStats,
            'monthlyTransactionData' => $monthlyTransactionData,
            'hasEmployeeRecord' => true
        ]);
    }

    /**
     * Show cloth size information for a specific assignment
     */
    public function showClothSize($id)
    {
        try {
            $user = request()->user();
            
            if (!$user->employee) {
                return redirect()->route('online-employee-details.index')
                    ->with('error', 'No employee record found for your account.');
            }

            $assignment = ClothAssignment::where('ca_id', $id)
                ->where('F_emp_id', $user->employee->emp_id)
                ->with(['clothMeasurement.customer.phone'])
                ->first();

            if (!$assignment || !$assignment->clothMeasurement) {
                return redirect()->route('online-employee-details.index')
                    ->with('error', 'Cloth assignment not found or not accessible.');
            }

            return view('Online_employee-details.cloth-size', [
                'clothMeasurement' => $assignment->clothMeasurement,
                'assignment' => $assignment
            ]);

        } catch (\Exception $e) {
            return redirect()->route('online-employee-details.index')
                ->with('error', 'Error loading cloth size information: ' . $e->getMessage());
        }
    }

    /**
     * Show vest size information for a specific assignment
     */
    public function showVestSize($id)
    {
        try {
            $user = request()->user();
            
            if (!$user->employee) {
                return redirect()->route('online-employee-details.index')
                    ->with('error', 'No employee record found for your account.');
            }

            $assignment = ClothAssignment::where('ca_id', $id)
                ->where('F_emp_id', $user->employee->emp_id)
                ->with(['vestMeasurement.customer.phone'])
                ->first();

            if (!$assignment || !$assignment->vestMeasurement) {
                return redirect()->route('online-employee-details.index')
                    ->with('error', 'Vest assignment not found or not accessible.');
            }

            return view('Online_employee-details.vest-size', [
                'vestMeasurement' => $assignment->vestMeasurement,
                'assignment' => $assignment
            ]);

        } catch (\Exception $e) {
            return redirect()->route('online-employee-details.index')
                ->with('error', 'Error loading vest size information: ' . $e->getMessage());
        }
    }

    /**
     * Complete an assignment by marking it as completed
     */
    public function completeAssignment($measure_id)
    {
        $user = request()->user();
        
        if (!$user->employee) {
            return redirect()->route('online-employee-details.index')
                ->with('error', 'No employee record found for your account.');
        }

        $assignment = ClothAssignment::where('F_cm_id', $measure_id)
            ->where('F_emp_id', $user->employee->emp_id)
            ->first();

        if (!$assignment) {
            return redirect()->route('online-employee-details.index')
                ->with('error', 'Assignment not found or not accessible.');
        }

        // Mark assignment as complete
        $assignment->markAsComplete();

        // Update the cloth measurement order status using measure_id directly
        ClothM::where('cm_id', $measure_id)->update([
            'order_status' => 'complete'
        ]);

        return redirect()->route('online-employee-details.index')
            ->with('success', 'Assignment completed successfully. Measure ID: ' . $measure_id . ' has been stored and order status updated.');
    }

    /**
     * Complete a vest assignment by marking it as completed
     */
    public function completeVestAssignment($measure_id)
    {
        $user = request()->user();
        
        if (!$user->employee) {
            return redirect()->route('online-employee-details.index')
                ->with('error', 'No employee record found for your account.');
        }

        $assignment = ClothAssignment::where('F_vm_id', $measure_id)
            ->where('F_emp_id', $user->employee->emp_id)
            ->first();

        if (!$assignment) {
            return redirect()->route('online-employee-details.index')
                ->with('error', 'Vest assignment not found or not accessible.');
        }

        // Mark assignment as complete
        $assignment->markAsComplete();

        // Update the vest measurement order status using measure_id directly
        VestM::where('V_M_ID', $measure_id)->update([
            'Status' => 'complete'
        ]);

        return redirect()->route('online-employee-details.index')
            ->with('success', 'Vest assignment completed successfully. Measure ID: ' . $measure_id . ' has been stored and order status updated.');
    }
}
