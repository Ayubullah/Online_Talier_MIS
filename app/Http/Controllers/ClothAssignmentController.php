<?php

namespace App\Http\Controllers;

use App\Models\ClothAssignment;
use App\Models\Employee;
use App\Models\ClothM;
use App\Models\Customer;
use App\Models\VestM;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function Pest\Laravel\get;

class ClothAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $assignments = ClothAssignment::with(['clothMeasurement', 'vestMeasurement', 'employee'])
        //     ->paginate(15);

        // // Check if the request wants JSON (API call)
        // if (request()->wantsJson()) {
        //     return response()->json([
        //         'success' => true,
        //         'data' => $assignments,
        //     ]);
        // }

        // Get customers with complete assignments (both cutter and salaye assigned)
        $completeCustomers = Customer::with(['clothMeasurements.clothAssignments','phone'])
            ->whereHas('clothMeasurements')
            ->whereHas('clothMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'cutting');
            })
            ->whereHas('clothMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'salaye');
            })
            ->get();

        // Get customers with incomplete assignments (missing cutter or salaye)
        $pendingCustomers = Customer::with(['clothMeasurements.clothAssignments','phone'])
            ->whereHas('clothMeasurements')
            ->where(function($query) {
                $query->whereDoesntHave('clothMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'cutting');
                })
                ->orWhereDoesntHave('clothMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'salaye');
                });
            })
            ->get();

        $customer = $pendingCustomers; // Keep for backward compatibility
        

        // Return view for web requests
        return view('cloth-assignments.index', compact('customer', 'pendingCustomers', 'completeCustomers'));
    }

    /**
     * Display pending assignments.
     */
    public function pending()
    {
        // Get customers with incomplete assignments (missing cutter or salaye)
        $pendingCustomers = Customer::with(['clothMeasurements.clothAssignments','phone'])
            ->whereHas('clothMeasurements')
            ->where(function($query) {
                $query->whereDoesntHave('clothMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'cutting');
                })
                ->orWhereDoesntHave('clothMeasurements.clothAssignments', function($subQuery) {
                    $subQuery->where('work_type', 'salaye');
                });
            })
            ->get();

        // Check if each customer has cutter and salaye assignments
        foreach ($pendingCustomers as $cust) {
            $hasCutter = $cust->clothMeasurements->flatMap->clothAssignments->where('work_type', 'cutting')->count() > 0;
            $hasSalaye = $cust->clothMeasurements->flatMap->clothAssignments->where('work_type', 'salaye')->count() > 0;
            
            $cust->hasCutter = $hasCutter;
            $cust->hasSalaye = $hasSalaye;
        }

        return view('cloth-assignments.pending', compact('pendingCustomers'));
    }

    /**
     * Display complete assignments.
     */
    public function complete()
    {
        // Get customers with complete assignments (both cutter and salaye assigned)
        $completeCustomers = Customer::with(['clothMeasurements.clothAssignments','phone'])
            ->whereHas('clothMeasurements')
            ->whereHas('clothMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'cutting');
            })
            ->whereHas('clothMeasurements.clothAssignments', function($query) {
                $query->where('work_type', 'salaye');
            })
            ->get();

        return view('cloth-assignments.complete', compact('completeCustomers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        $clothMeasurements = ClothM::with('customer')->get();
        $vestMeasurements = VestM::with('customer')->get();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'employees' => $employees,
                    'clothMeasurements' => $clothMeasurements,
                    'vestMeasurements' => $vestMeasurements,
                ],
            ]);
        }

        // Return view for web requests
        return view('cloth-assignments.create', compact('employees', 'clothMeasurements', 'vestMeasurements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Create assignment for Cutter employee
        if ($request->emp_id_C && $request->rateC) {
            $cleanRate = (float) str_replace(['$', ','], '', $request->rateC);
            $clothAssignment = new ClothAssignment();
            $clothAssignment->F_cm_id = $request->F_cm_id;
            $clothAssignment->F_emp_id = $request->emp_id_C;
            $clothAssignment->rate_at_assign = $cleanRate;
            $clothAssignment->work_type = 'cutting';
            $clothAssignment->status = 'pending';
            $clothAssignment->assigned_at = now();
            $clothAssignment->save();
        }

        // Create assignment for Salaye employee
        if ($request->emp_id_S && $request->rateS) {
            $cleanRate = (float) str_replace(['$', ','], '', $request->rateS);
            $clothAssignment = new ClothAssignment();
            $clothAssignment->F_cm_id = $request->F_cm_id;
            $clothAssignment->F_emp_id = $request->emp_id_S;
            $clothAssignment->rate_at_assign = $cleanRate;
            $clothAssignment->work_type = 'salaye';
            $clothAssignment->status = 'pending';
            $clothAssignment->assigned_at = now();
            $clothAssignment->save();
        }

        return redirect()->route('cloth-assignments.index')
            ->with('success', 'Assignments created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClothAssignment $clothAssignment)
    {
        // Load relationships for the view
        $clothAssignment->load([
            'clothMeasurement.customer', 
            'vestMeasurement.customer', 
            'employee'
        ]);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $clothAssignment,
            ]);
        }

        // Return view for web requests
        return view('cloth-assignments.show', compact('clothAssignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClothAssignment $clothAssignment)
    {
        $employees = Employee::all();
        $clothMeasurements = ClothM::with('customer')->get();
        $vestMeasurements = VestM::with('customer')->get();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'clothAssignment' => $clothAssignment,
                    'employees' => $employees,
                    'clothMeasurements' => $clothMeasurements,
                    'vestMeasurements' => $vestMeasurements,
                ],
            ]);
        }

        // Return view for web requests
        return view('cloth-assignments.edit', compact('clothAssignment', 'employees', 'clothMeasurements', 'vestMeasurements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClothAssignment $clothAssignment)
    {
        $request->validate([
            'F_cm_id' => [
                'nullable',
                'exists:cloth_m,cm_id',
                Rule::requiredIf(function () use ($request) {
                    return empty($request->F_vm_id);
                }),
            ],
            'F_vm_id' => [
                'nullable',
                'exists:vest_m,V_M_ID',
                Rule::requiredIf(function () use ($request) {
                    return empty($request->F_cm_id);
                }),
            ],
            'F_emp_id' => 'required|exists:employee,emp_id',
            'work_type' => 'required|in:cutting,salaye',
            'qty' => 'required|integer|min:1',
            'rate_at_assign' => 'required|numeric|min:0',
            'status' => 'nullable|in:pending,complete',
            'assigned_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
        ]);

        // Ensure exactly one of F_cm_id or F_vm_id is present
        if (($request->F_cm_id && $request->F_vm_id) || (!$request->F_cm_id && !$request->F_vm_id)) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Exactly one of cloth measurement ID or vest measurement ID must be provided.',
                ], 422);
            }
            
            return back()->withErrors(['assignment' => 'Exactly one of cloth measurement ID or vest measurement ID must be provided.'])->withInput();
        }

        $clothAssignment->update($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Assignment updated successfully.',
                'data' => $clothAssignment->load(['clothMeasurement', 'vestMeasurement', 'employee']),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('cloth-assignments.show', $clothAssignment)
            ->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClothAssignment $clothAssignment)
    {
        $clothAssignment->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Assignment deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('cloth-assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }

    /**
     * Mark assignment as complete.
     */
    public function markComplete(ClothAssignment $clothAssignment)
    {
        $clothAssignment->markAsComplete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Assignment marked as complete.',
                'data' => $clothAssignment->load(['clothMeasurement', 'vestMeasurement', 'employee']),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('cloth-assignments.show', $clothAssignment)
            ->with('success', 'Assignment marked as complete.');
    }
}
