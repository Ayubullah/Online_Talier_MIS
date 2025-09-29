<?php

namespace App\Http\Controllers;

use App\Models\ClothM;
use App\Models\Customer;
use Illuminate\Http\Request;

class ClothMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clothMeasurements = ClothM::with(['customer', 'clothAssignments'])
            ->paginate(15);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $clothMeasurements,
            ]);
        }

        // Return view for web requests
        return view('cloth.customers.index', compact('clothMeasurements'));
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
        return view('cloth-measurements.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'F_cus_id' => 'required|exists:customer,cus_id',
            'size' => 'required|in:S,L',
            'cloth_rate' => 'required|numeric|min:0',
            'order_status' => 'nullable|in:pending,complete',
            'Height' => 'nullable|string|max:10',
            'chati' => 'nullable|string|max:255',
            'Sleeve' => 'nullable|integer',
            'Shoulder' => 'nullable|integer',
            'Collar' => 'nullable|string|max:15',
            'Armpit' => 'nullable|string|max:15',
            'Skirt' => 'nullable|string|max:15',
            'Trousers' => 'nullable|string|max:15',
            'Kaff' => 'nullable|string|max:40',
            'Pacha' => 'nullable|string|max:15',
            'sleeve_type' => 'nullable|string|max:40',
            'Kalar' => 'nullable|string|max:15',
            'Shalwar' => 'nullable|string|max:15',
            'Yakhan' => 'nullable|string|max:15',
            'Daman' => 'nullable|string|max:15',
            'Jeb' => 'nullable|string|max:60',
            'O_date' => 'nullable|date',
            'R_date' => 'nullable|date',
        ]);

        $clothM = ClothM::create($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cloth measurement created successfully.',
                'data' => $clothM->load('customer'),
            ], 201);
        }

        // Redirect for web requests
        return redirect()->route('cloth-measurements.index')
            ->with('success', 'Cloth measurement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClothM $clothM)
    {
        // Load relationships for the view
        $clothM->load(['customer', 'clothAssignments.employee']);

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $clothM,
            ]);
        }

        // Return view for web requests
        return view('cloth-measurements.show', compact('clothM'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClothM $clothM)
    {
        $customers = Customer::all();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => ['clothM' => $clothM, 'customers' => $customers],
            ]);
        }

        // Return view for web requests
        return view('cloth-measurements.edit', compact('clothM', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClothM $clothM)
    {
        $request->validate([
            'F_cus_id' => 'required|exists:customer,cus_id',
            'size' => 'required|in:S,L',
            'cloth_rate' => 'required|numeric|min:0',
            'order_status' => 'nullable|in:pending,complete',
            'Height' => 'nullable|string|max:10',
            'chati' => 'nullable|string|max:255',
            'Sleeve' => 'nullable|integer',
            'Shoulder' => 'nullable|integer',
            'Collar' => 'nullable|string|max:15',
            'Armpit' => 'nullable|string|max:15',
            'Skirt' => 'nullable|string|max:15',
            'Trousers' => 'nullable|string|max:15',
            'Kaff' => 'nullable|string|max:40',
            'Pacha' => 'nullable|string|max:15',
            'sleeve_type' => 'nullable|string|max:40',
            'Kalar' => 'nullable|string|max:15',
            'Shalwar' => 'nullable|string|max:15',
            'Yakhan' => 'nullable|string|max:15',
            'Daman' => 'nullable|string|max:15',
            'Jeb' => 'nullable|string|max:60',
            'O_date' => 'nullable|date',
            'R_date' => 'nullable|date',
        ]);

        $clothM->update($request->all());

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cloth measurement updated successfully.',
                'data' => $clothM->load('customer'),
            ]);
        }

        // Redirect for web requests
        return redirect()->route('cloth-measurements.show', $clothM)
            ->with('success', 'Cloth measurement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClothM $clothM)
    {
        $clothM->delete();

        // Check if the request wants JSON (API call)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cloth measurement deleted successfully.',
            ]);
        }

        // Redirect for web requests
        return redirect()->route('cloth-measurements.index')
            ->with('success', 'Cloth measurement deleted successfully.');
    }
}
