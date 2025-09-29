<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseDetail;


class Purchase_RetrunController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function fetchPurchaseDetails(Request $request)
{
    $search = $request->input('search');

    // Try searching by barcode or item_ID
    $purchaseDetail = PurchaseDetail::where('barcode', $search)
        ->orWhere('Pur_D_ID', $search)
        ->latest()
        ->first();

    if ($purchaseDetail) {
        return response()->json([
            'success' => true,
            'item_name' => $purchaseDetail->item->item_Name ?? '',
            'price' => $purchaseDetail->P_unit_price,
            'item_ID' => $purchaseDetail->item_ID,
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Item not found.']);
}


    public function index()
    {
        $purchaseReturns = PurchaseReturn::with(['item', 'supplier'])->get();
        return view('purchase-returns.index', compact('purchaseReturns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $suppliers = Supplier::all();
        return view('purchase-returns.create', compact('items', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_ID' => 'required|exists:items,item_ID',
            'Sup_ID' => 'nullable|exists:suppliers,Sup_ID',
            'Return_Date' => 'required|date',
            'Return_Qty' => 'required|integer|min:1',
            'Return_Rate' => 'required|numeric|min:0',
            'Return_amount' => 'required|numeric|min:0',
            'Return_Reason' => 'nullable|string|max:255',
        ]);

        PurchaseReturn::create([
            'item_ID' => $request->item_ID,
            'Sup_ID' => $request->Sup_ID,
            'Return_Date' => $request->Return_Date,
            'Return_Qty' => $request->Return_Qty,
            'Return_Rate' => $request->Return_Rate,
            'Return_amount' => $request->Return_amount,
            'Return_Reason' => $request->Return_Reason,
        ]);

        return redirect()->route('purchase-returns.index')
            ->with('success', 'Purchase return created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->load(['item', 'supplier']);
        return view('purchase-returns.show', compact('purchaseReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseReturn $purchaseReturn)
    {
        $items = Item::all();
        $suppliers = Supplier::all();
        return view('purchase-returns.edit', compact('purchaseReturn', 'items', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        $request->validate([
            'item_ID' => 'required|exists:items,item_ID',
            'Sup_ID' => 'nullable|exists:suppliers,Sup_ID',
            'Return_Date' => 'required|date',
            'Return_Qty' => 'required|integer|min:1',
            'Return_Rate' => 'required|numeric|min:0',
            'Return_amount' => 'required|numeric|min:0',
            'Return_Reason' => 'nullable|string|max:255',
        ]);

        $purchaseReturn->update([
            'item_ID' => $request->item_ID,
            'Sup_ID' => $request->Sup_ID,
            'Return_Date' => $request->Return_Date,
            'Return_Qty' => $request->Return_Qty,
            'Return_Rate' => $request->Return_Rate,
            'Return_amount' => $request->Return_amount,
            'Return_Reason' => $request->Return_Reason,
        ]);

        return redirect()->route('purchase-returns.index')
            ->with('success', 'Purchase return updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->delete();

        return redirect()->route('purchase-returns.index')
            ->with('success', 'Purchase return deleted successfully.');
    }
}
