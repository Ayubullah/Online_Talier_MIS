<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('user')
            ->paginate(15);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $employees,
            ]);
        }

        // Return view for web requests
        return view('employees.index', compact('employees'));
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

        // Return view for web requests
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'emp_name' => 'required|string|max:100',
            'role' => 'required|in:cutter,salaye',
            'type' => 'nullable|in:cloth,vest',
            'cutter_s_rate' => 'nullable|numeric|min:0',
            'cutter_l_rate' => 'nullable|numeric|min:0',
            'salaye_s_rate' => 'nullable|numeric|min:0',
            'salaye_l_rate' => 'nullable|numeric|min:0',
            'F_user_id' => 'nullable|exists:users,id|unique:employee,F_user_id',
            // User fields for creating user account
            'emp_email' => 'required|email|unique:users,email',
            'emp_password' => 'required|string|min:8',
            'emp_role' => 'required|in:user,admin,agent',
        ]);

        // Use database transaction to ensure both user and employee are created together
        $result = DB::transaction(function () use ($request) {
            // Create user first
            $user = User::create([
                'name' => $request->emp_name,
                'email' => $request->emp_email,
                'password' => Hash::make($request->emp_password),
                'role' => $request->emp_role,
            ]);

            // Create employee with the F_user_id
            $employeeData = $request->only([
                'emp_name', 'role', 'type', 
                'cutter_s_rate', 'cutter_l_rate', 
                'salaye_s_rate', 'salaye_l_rate'
            ]);
            $employeeData['F_user_id'] = $user->id;
            
            $employee = Employee::create($employeeData);
            
            return ['user' => $user, 'employee' => $employee];
        });
        
        $user = $result['user'];
        $employee = $result['employee'];


        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee and user created successfully.',
                'data' => [
                    'employee' => $employee->load('user'),
                    'user' => $user
                ],
            ], 201);
        }

        // Redirect for web requests
        return redirect()->route('employees.index')
            ->with('success', 'Employee and user account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        // Load relationships for the view
        $employee->load(['user', 'clothAssignments', 'payments']);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $employee,
            ]);
        }

        // Return view for web requests
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $employee,
            ]);
        }

        // Return view for web requests
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'emp_name' => 'required|string|max:100',
            'role' => 'required|in:cutter,salaye',
            'type' => 'nullable|in:cloth,vest',
            'cutter_s_rate' => 'nullable|numeric|min:0',
            'cutter_l_rate' => 'nullable|numeric|min:0',
            'salaye_s_rate' => 'nullable|numeric|min:0',
            'salaye_l_rate' => 'nullable|numeric|min:0',
            'F_user_id' => 'nullable|exists:users,id|unique:employee,F_user_id,' . $employee->emp_id . ',emp_id',
            // User fields for updating user account (if employee has user account)
            'emp_email' => 'nullable|email|unique:users,email,' . ($employee->user ? $employee->user->id : 'NULL') . ',id',
            'emp_password' => 'nullable|string|min:8',
            'emp_role' => 'nullable|in:user,admin,agent',
        ]);

        // Use database transaction to ensure both user and employee are updated together
        $result = DB::transaction(function () use ($request, $employee) {
            // Update employee data
            $employeeData = $request->only([
                'emp_name', 'role', 'type', 
                'cutter_s_rate', 'cutter_l_rate', 
                'salaye_s_rate', 'salaye_l_rate'
            ]);
            
            $employee->update($employeeData);
            
            // Update user account if employee has one and user fields are provided
            if ($employee->user && ($request->has('emp_email') || $request->has('emp_role') || $request->has('emp_password'))) {
                $userData = [];
                
                if ($request->has('emp_email')) {
                    $userData['email'] = $request->emp_email;
                }
                
                if ($request->has('emp_role')) {
                    $userData['role'] = $request->emp_role;
                }
                
                if ($request->has('emp_password') && !empty($request->emp_password)) {
                    $userData['password'] = Hash::make($request->emp_password);
                }
                
                if (!empty($userData)) {
                    $employee->user->update($userData);
                }
            }
            
            return ['employee' => $employee->fresh(), 'user' => $employee->user ? $employee->user->fresh() : null];
        });
        
        $employee = $result['employee'];
        $user = $result['user'];

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $user ? 'Employee and user account updated successfully.' : 'Employee updated successfully.',
                'data' => [
                    'employee' => $employee->load('user'),
                    'user' => $user
                ],
            ]);
        }

        // Redirect for web requests
        return redirect()->route('employees.show', $employee)
            ->with('success', $user ? 'Employee and user account updated successfully.' : 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
