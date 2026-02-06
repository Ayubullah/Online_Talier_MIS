<?php

namespace App\Http\Controllers;

use App\Models\ClothAssignment;
use App\Models\Employee;
use App\Models\VestM;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class VestAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get customers with complete assignments (both cutter and salaye assigned)
        $completeCustomers = Customer::with(['vestMeasurements.clothAssignments','phone'])
            ->whereHas('vestMeasurements')
            ->whereHas('vestMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'cutting');
            })
            ->whereHas('vestMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'salaye');
            })
            ->get();

        // Get customers with incomplete assignments (missing cutter or salaye)
        $pendingCustomers = Customer::with(['vestMeasurements.clothAssignments','phone'])
            ->whereHas('vestMeasurements')
            ->where(function($query) {
                $query->whereDoesntHave('vestMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'cutting');
                })
                ->orWhereDoesntHave('vestMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'salaye');
                });
            })
            ->get();

        $customers = $pendingCustomers; // Keep for backward compatibility

        // Return view for web requests
        return view('vest-assignments.index', compact('customers', 'pendingCustomers', 'completeCustomers'));
    }

    /**
     * Display pending assignments.
     */
    public function pending()
    {
        // Get customers with incomplete assignments (missing cutter or salaye)
        $pendingCustomers = Customer::with(['vestMeasurements.clothAssignments','phone'])
            ->whereHas('vestMeasurements')
            ->where(function($query) {
                $query->whereDoesntHave('vestMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'cutting');
                })
                ->orWhereDoesntHave('vestMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'salaye');
                });
            })
            ->get();

        // Check if each customer has cutter and salaye assignments
        foreach ($pendingCustomers as $cust) {
            $hasCutter = $cust->vestMeasurements->flatMap->clothAssignments->where('work_type', 'cutting')->count() > 0;
            $hasSalaye = $cust->vestMeasurements->flatMap->clothAssignments->where('work_type', 'salaye')->count() > 0;
            
            $cust->hasCutter = $hasCutter;
            $cust->hasSalaye = $hasSalaye;
        }

        return view('vest-assignments.pending', compact('pendingCustomers'));
    }

    /**
     * Display complete assignments.
     */
    public function complete()
    {
        // Get customers with complete assignments (both cutter and salaye assigned)
        $completeCustomers = Customer::with(['vestMeasurements.clothAssignments','phone'])
            ->whereHas('vestMeasurements')
            ->whereHas('vestMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'cutting');
            })
            ->whereHas('vestMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'salaye');
            })
            ->get();

        return view('vest-assignments.complete', compact('completeCustomers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        $vestMeasurements = VestM::with('customer')->get();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'employees' => $employees,
                    'vestMeasurements' => $vestMeasurements,
                ],
            ]);
        }

        // Return view for web requests
        return view('vest-assignments.create', compact('employees', 'vestMeasurements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Vest Assignment Store Request:', $request->all());

        try {
            // Validate the request
            $request->validate([
                'F_vm_id' => 'required|exists:vest_m,V_M_ID',
                'emp_id_C' => 'required|exists:employee,emp_id',
                'emp_id_S' => 'required|exists:employee,emp_id',
                'rateC' => 'required',
                'rateS' => 'required',
            ]);

            // Create assignment for Cutter employee
            if ($request->emp_id_C && $request->rateC) {
                $cleanRate = (float) str_replace(['$', ','], '', $request->rateC);
                $vestAssignment = new ClothAssignment();
                $vestAssignment->F_vm_id = $request->F_vm_id;
                $vestAssignment->F_emp_id = $request->emp_id_C;
                $vestAssignment->rate_at_assign = $cleanRate;
                $vestAssignment->work_type = 'cutting';
                $vestAssignment->status = 'pending';
                $vestAssignment->assigned_at = now();
                $vestAssignment->save();
                
                \Log::info('Cutter assignment created:', [
                    'F_vm_id' => $request->F_vm_id,
                    'emp_id' => $request->emp_id_C,
                    'rate' => $cleanRate
                ]);
            }

            // Create assignment for Salaye employee
            if ($request->emp_id_S && $request->rateS) {
                $cleanRate = (float) str_replace(['$', ','], '', $request->rateS);
                $vestAssignment = new ClothAssignment();
                $vestAssignment->F_vm_id = $request->F_vm_id;
                $vestAssignment->F_emp_id = $request->emp_id_S;
                $vestAssignment->rate_at_assign = $cleanRate;
                $vestAssignment->work_type = 'salaye';
                $vestAssignment->status = 'pending';
                $vestAssignment->assigned_at = now();
                $vestAssignment->save();
                
                \Log::info('Salaye assignment created:', [
                    'F_vm_id' => $request->F_vm_id,
                    'emp_id' => $request->emp_id_S,
                    'rate' => $cleanRate
                ]);
            }

            return redirect()->route('vest-assignments.index')
                ->with('success', 'Vest assignments created successfully.');

        } catch (\Exception $e) {
            \Log::error('Error creating vest assignments:', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create vest assignments. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClothAssignment $vestAssignment)
    {
        // Load relationships for the view
        $vestAssignment->load([
            'vestMeasurement.customer', 
            'employee'
        ]);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $vestAssignment,
            ]);
        }

        // Return view for web requests
        return view('vest-assignments.show', compact('vestAssignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClothAssignment $vestAssignment)
    {
        $employees = Employee::all();
        $vestMeasurements = VestM::with('customer')->get();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'vestAssignment' => $vestAssignment,
                    'employees' => $employees,
                    'vestMeasurements' => $vestMeasurements,
                ],
            ]);
        }

        // Return view for web requests
        return view('vest-assignments.edit', compact('vestAssignment', 'employees', 'vestMeasurements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClothAssignment $vestAssignment)
    {
        $request->validate([
            'F_vm_id' => [
                'nullable',
                'exists:vest_m,V_M_ID',
                Rule::requiredIf(function () use ($request) {
                    return !$request->F_cm_id;
                }),
            ],
            'F_emp_id' => 'required|exists:employee,emp_id',
            'work_type' => 'required|in:cutting,salaye',
            'rate_at_assign' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed',
        ]);

        $vestAssignment->update($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest assignment updated successfully.',
                'data' => $vestAssignment->load('vestMeasurement.customer', 'employee'),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('vest-assignments.show', $vestAssignment)
            ->with('success', 'Vest assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClothAssignment $vestAssignment)
    {
        $vestAssignment->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest assignment deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('vest-assignments.index')
            ->with('success', 'Vest assignment deleted successfully.');
    }

    /**
     * Mark assignment as complete
     */
    public function markComplete(ClothAssignment $vestAssignment)
    {
        $vestAssignment->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest assignment marked as complete.',
                'data' => $vestAssignment->load('vestMeasurement.customer', 'employee'),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('vest-assignments.show', $vestAssignment)
            ->with('success', 'Vest assignment marked as complete.');
    }

    /**
     * Show form for editing customer assignments.
     */
    public function editCustomerAssignments(Customer $customer)
    {
        // Get all vest measurements for this customer that have assignments
        $vestMeasurements = $customer->vestMeasurements()
            ->with(['clothAssignments.employee'])
            ->whereHas('clothAssignments')
            ->get();

        $employees = Employee::all();

        return view('vest-assignments.edit-customer', compact('customer', 'vestMeasurements', 'employees'));
    }

    /**
     * Update customer assignments.
     */
    public function updateCustomerAssignments(Request $request, Customer $customer)
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.status' => 'required|in:pending,completed',
            'assignments.*.F_emp_id' => 'nullable|exists:employee,emp_id',
        ]);

        try {
            foreach ($request->assignments as $assignmentId => $assignmentData) {
                $assignment = ClothAssignment::find($assignmentId);

                if ($assignment) {
                    $updateData = [
                        'status' => $assignmentData['status'],
                    ];

                    // Only update employee if provided and not empty
                    if (!empty($assignmentData['F_emp_id'])) {
                        $updateData['F_emp_id'] = $assignmentData['F_emp_id'];
                    }

                    $assignment->update($updateData);
                }
            }

            return redirect()->route('vest-assignments.complete-view')
                ->with('success', 'Vest assignments updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update assignments: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete a specific assignment.
     */
    public function deleteAssignment(ClothAssignment $vestAssignment)
    {
        try {
            // Get customer ID before deleting for redirect
            $customerId = $vestAssignment->vestMeasurement->customer_id;

            $vestAssignment->delete();

            return redirect()->route('vest-assignments.edit-customer', $customerId)
                ->with('success', ucfirst($vestAssignment->work_type) . ' assignment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete assignment: ' . $e->getMessage());
        }
    }
}
