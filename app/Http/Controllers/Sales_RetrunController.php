<?php

namespace App\Http\Controllers;

use App\Models\SaleReturn;
use App\Models\Item;
use App\Models\Customer;
use App\Models\PurchaseDetail;
use App\Models\SalesDetail;
use Illuminate\Http\Request;

class Sales_RetrunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesReturns = SaleReturn::with(['item', 'customer'])->get();
        return view('sales-returns.index', compact('salesReturns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $customers = Customer::all();
        return view('sales-returns.create', compact('items', 'customers'));
    }

    /**
     * Fetch sales details by barcode or ID
     */
    public function fetchSalesDetails(Request $request)
    {
        $search = $request->input('search');

        // Try searching by barcode or Sale_ID
        // $salesDetail = PurchaseDetail::where('Pur_ID', $search)
        $salesDetail = PurchaseDetail::where('barcode', $search)
        ->orWhere('Pur_D_ID', $search)
        ->latest()
        ->first();

    if ($salesDetail) {
        return response()->json([
            'success' => true,
            'item_name' => $salesDetail->item->item_Name ?? '',
            'price' => $salesDetail->P_unit_sale_Price,
            'item_ID' => $salesDetail->item_ID,
        ]);
    
        }

        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Cust_ID' => 'required|exists:customers,Cust_ID',
            'item_ID' => 'required|exists:items,item_ID',
            'Return_Date' => 'required|date',
            'Return_Qty' => 'required|integer|min:1',
            'Return_Rate' => 'required|numeric|min:0',
            'Return_amount' => 'required|numeric|min:0',
            'Return_Reason' => 'nullable|string|max:255',
        ]);

        SaleReturn::create([
            'Cust_ID' => $request->Cust_ID,
            'item_ID' => $request->item_ID,
            'Return_Date' => $request->Return_Date,
            'Return_Qty' => $request->Return_Qty,
            'Return_Rate' => $request->Return_Rate,
            'Return_amount' => $request->Return_amount,
            'Return_Reason' => $request->Return_Reason,
        ]);

        return redirect()->route('sales-returns.index')
            ->with('success', 'Sales return created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleReturn $salesReturn)
    {
        $salesReturn->load(['item', 'customer']);
        return view('sales-returns.show', compact('salesReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleReturn $salesReturn)
    {
        $items = Item::all();
        $customers = Customer::all();
        return view('sales-returns.edit', compact('salesReturn', 'items', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleReturn $salesReturn)
    {
        $request->validate([
            'Cust_ID' => 'required|exists:customers,Cust_ID',
            'item_ID' => 'required|exists:items,item_ID',
            'Return_Date' => 'required|date',
            'Return_Qty' => 'required|integer|min:1',
            'Return_Rate' => 'required|numeric|min:0',
            'Return_amount' => 'required|numeric|min:0',
            'Return_Reason' => 'nullable|string|max:255',
        ]);

        $salesReturn->update([
            'Cust_ID' => $request->Cust_ID,
            'item_ID' => $request->item_ID,
            'Return_Date' => $request->Return_Date,
            'Return_Qty' => $request->Return_Qty,
            'Return_Rate' => $request->Return_Rate,
            'Return_amount' => $request->Return_amount,
            'Return_Reason' => $request->Return_Reason,
        ]);

        return redirect()->route('sales-returns.index')
            ->with('success', 'Sales return updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleReturn $salesReturn)
    {
        $salesReturn->delete();

        return redirect()->route('sales-returns.index')
            ->with('success', 'Sales return deleted successfully.');
    }
}
