<?php

namespace App\Http\Controllers;

use App\Models\Outstock;
use App\Models\Item;
use Illuminate\Http\Request;

class OutstockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outstocks = Outstock::with(['item.purchaseDetails' => function($query) {
            $query->latest();
        }])->get();
        return view('outstocks.index', compact('outstocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = \App\Models\Item::all();
        return view('outstocks.create', compact('items'));
    }

    /**
     * Fetch item by barcode or ID (from purchasedetails)
     */
    public function fetch(Request $request)
    {
        $search = $request->get('search');
        
        $purchaseDetail = \App\Models\PurchaseDetail::where('barcode', $search)
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

        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_ID' => 'required|exists:items,item_ID',
            'outstock_type' => 'required|in:lost,expired',
            'outstock_date' => 'required|date',
            'outstock_qty' => 'required|integer|min:1',
            'outstock_reason' => 'nullable|string|max:255',
        ]);

        Outstock::create($request->only([
            'item_ID',
            'outstock_type',
            'outstock_date',
            'outstock_qty',
            'outstock_reason',
        ]));

        return redirect()->route('outstocks.index')
            ->with('success', 'Outstock record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Outstock $outstock)
    {
        $outstock->load(['item.purchaseDetails' => function($query) {
            $query->latest();
        }]);
        return view('outstocks.show', compact('outstock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outstock $outstock)
    {
        $items = \App\Models\Item::all();
        $outstock->load(['item.purchaseDetails' => function($query) {
            $query->latest();
        }]);
        return view('outstocks.edit', compact('outstock', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outstock $outstock)
    {
        $request->validate([
            'item_ID' => 'required|exists:items,item_ID',
            'outstock_type' => 'required|in:lost,expired',
            'outstock_date' => 'required|date',
            'outstock_qty' => 'required|integer|min:1',
            'outstock_reason' => 'nullable|string|max:255',
        ]);

        $outstock->update($request->only([
            'item_ID',
            'outstock_type',
            'outstock_date',
            'outstock_qty',
            'outstock_reason',
        ]));

        return redirect()->route('outstocks.index')
            ->with('success', 'Outstock record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outstock $outstock)
    {
        $outstock->delete();
        return redirect()->route('outstocks.index')
            ->with('success', 'Outstock record deleted successfully.');
    }
}
