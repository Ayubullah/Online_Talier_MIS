<?php

namespace App\Http\Controllers;

use App\Models\InvoiceTb;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = InvoiceTb::with(['customers', 'payments'])
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $invoices,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inc_date' => 'nullable|date',
            'total_amt' => 'required|numeric|min:0',
            'status' => 'nullable|in:unpaid,partial,paid',
        ]);

        $invoice = InvoiceTb::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Invoice created successfully.',
            'data' => $invoice,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceTb $invoiceTb)
    {
        return response()->json([
            'success' => true,
            'data' => $invoiceTb->load(['customers.phone', 'payments']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceTb $invoiceTb)
    {
        $request->validate([
            'inc_date' => 'nullable|date',
            'total_amt' => 'required|numeric|min:0',
            'status' => 'nullable|in:unpaid,partial,paid',
        ]);

        $invoiceTb->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Invoice updated successfully.',
            'data' => $invoiceTb,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceTb $invoiceTb)
    {
        $invoiceTb->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully.',
        ]);
    }
}
