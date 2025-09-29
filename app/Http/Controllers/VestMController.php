<?php

namespace App\Http\Controllers;

use App\Models\VestM;
use App\Models\Customer;
use Illuminate\Http\Request;

class VestMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vestMeasurements = VestM::with(['customer', 'clothAssignments'])
            ->paginate(15);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $vestMeasurements,
            ]);
        }

        // Return view for web requests
        return view('vest-measurements.index', compact('vestMeasurements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => ['customers' => $customers],
            ]);
        }

        // Return view for web requests
        return view('vests.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'F_cus_id' => 'required|exists:customer,cus_id',
            'size' => 'required|in:S,L',
            'vest_rate' => 'required|numeric|min:0',
            'Height' => 'nullable|string|max:50',
            'Shoulder' => 'nullable|string|max:50',
            'Armpit' => 'nullable|string|max:50',
            'Waist' => 'nullable|string|max:20',
            'Shana' => 'nullable|string|max:50',
            'Kalar' => 'nullable|string|max:50',
            'Daman' => 'nullable|string|max:50',
            'NawaWaskat' => 'nullable|string|max:50',
            'Status' => 'nullable|string|max:50',
            'O_date' => 'nullable|date',
            'R_date' => 'nullable|date',
        ]);

        $vestM = VestM::create($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest measurement created successfully.',
                'data' => $vestM->load('customer'),
            ], 201);
        }

        // Redirect for web requests
        return redirect()->route('vests.index')
            ->with('success', 'Vest measurement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VestM $vestM)
    {
        // Load relationships for the view
        $vestM->load(['customer', 'clothAssignments.employee']);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $vestM,
            ]);
        }

        // Return view for web requests
        return view('vests.show', compact('vestM'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VestM $vestM)
    {
        $customers = Customer::all();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => ['vestM' => $vestM, 'customers' => $customers],
            ]);
        }

        // Return view for web requests
        return view('vests.edit', compact('vestM', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VestM $vestM)
    {
        $request->validate([
            'F_cus_id' => 'required|exists:customer,cus_id',
            'size' => 'required|in:S,L',
            'vest_rate' => 'required|numeric|min:0',
            'Height' => 'nullable|string|max:50',
            'Shoulder' => 'nullable|string|max:50',
            'Armpit' => 'nullable|string|max:50',
            'Waist' => 'nullable|string|max:20',
            'Shana' => 'nullable|string|max:50',
            'Kalar' => 'nullable|string|max:50',
            'Daman' => 'nullable|string|max:50',
            'NawaWaskat' => 'nullable|string|max:50',
            'Status' => 'nullable|string|max:50',
            'O_date' => 'nullable|date',
            'R_date' => 'nullable|date',
        ]);

        $vestM->update($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest measurement updated successfully.',
                'data' => $vestM->load('customer'),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('vests.show', $vestM)
            ->with('success', 'Vest measurement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VestM $vestM)
    {
        $vestM->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vest measurement deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('vests.index')
            ->with('success', 'Vest measurement deleted successfully.');
    }
}
