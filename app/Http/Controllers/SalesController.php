<?php

namespace App\Http\Controllers;

use App\Models\SalesDetail;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\OutSupplierItem;
use App\Models\Payment;
use App\Models\PurchaseDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Calculate remaining quantity for a specific item
     */
    private function calculateRemainingQuantity($itemId)
    {
        $query = "
            SELECT 
                (
                    (
                        COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = ?), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = ?), 0)
                    )
                    - GREATEST(
                        COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = ?), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = ?), 0),
                        0
                    )
                    - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = ?), 0)
                ) AS remain
        ";
        
        $result = DB::select($query, [$itemId, $itemId, $itemId, $itemId, $itemId]);
        return $result[0]->remain ?? 0;
    }

    public function fetchPurchaseDetails(Request $request)
    {
        $search = $request->input('search');

        // Optimized query - search by barcode or item_ID with proper ordering
        $purchaseDetail = PurchaseDetail::where('barcode', $search)
            ->orWhere('Pur_D_ID', $search)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($purchaseDetail) {
            // Check remaining quantity before proceeding
            $remainingQty = $this->calculateRemainingQuantity($purchaseDetail->item_ID);
            
            if ($remainingQty <= 0) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Item is out of stock. Remaining quantity: ' . $remainingQty
                ]);
            }

            return response()->json([
                'success' => true,
                'item_name' => $purchaseDetail->item->item_Name ?? '',
                'price' => $purchaseDetail->P_unit_price,
                'price2' => $purchaseDetail->P_unit_sale_Price,
                'item_ID' => $purchaseDetail->item_ID,
                'Expire_date' => $purchaseDetail->Expire_date,
                'remaining_qty' => $remainingQty
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

    public function fetchItemDetails(Request $request)
    {
        $itemId = $request->input('item_id');
        
        // Check remaining quantity first
        $remainingQty = $this->calculateRemainingQuantity($itemId);
        
        if ($remainingQty <= 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Item is out of stock. Remaining quantity: ' . $remainingQty
            ]);
        }
        
        // Optimized query - get the most recent purchase detail for this item
        $purchaseDetail = PurchaseDetail::where('item_ID', $itemId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($purchaseDetail) {
            return response()->json([
                'success' => true,
                'item_name' => $purchaseDetail->item->item_Name ?? '',
                'price' => $purchaseDetail->P_unit_price,
                'price2' => $purchaseDetail->P_unit_sale_Price,
                'item_ID' => $purchaseDetail->item_ID,
                'Expire_date' => $purchaseDetail->Expire_date,
                'remaining_qty' => $remainingQty
            ]);
        }

        // If no purchase detail found, try to get basic item info
        $item = Item::find($itemId);
        if ($item) {
            return response()->json([
                'success' => true,
                'item_name' => $item->item_Name,
                'price' => 0, // Default price
                'price2' => 0, // Default sale price
                'item_ID' => $item->item_ID,
                'Expire_date' => null,
                'remaining_qty' => $remainingQty
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found.']);
    }

        
    public function printInvoice($id)
    {
        $sales = SalesDetail::with([
            'item.category',
            'stock',
            'employee',
            'invoice.customer',
            'invoice.payments' // Include payments relation
        ])
        ->where('Inv_ID', $id)
        ->get();

        // Out Supplier items linked to this invoice
        $outSupplierItems = \App\Models\OutSupplierItem::with('supplier')
            ->where('F_Inv_ID', $id)
            ->get();

        // 4. Pass everything to a view
        return view('invoice.print', compact('sales', 'outSupplierItems'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = SalesDetail::with([
            'item.category',
            'stock',
            'employee',
            'invoice.customer'
        ])->get();

        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get only items with remaining quantity > 0
        $items = Item::with('category')->get()->filter(function($item) {
            $remainingQty = $this->calculateRemainingQuantity($item->item_ID);
            return $remainingQty > 0;
        })->map(function($item) {
            $remainingQty = $this->calculateRemainingQuantity($item->item_ID);
            $item->remaining_qty = $remainingQty;
            return $item;
        });

        $customers = Customer::all();
        $suppliers = Supplier::orderBy('Sup_Name')->get();
        return view('sales.create', compact('items', 'customers', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // Validate required invoice & payment fields
            $request->validate([
                'customer_id.0' => 'required|exists:customers,Cust_ID',
                'paid_amount'   => 'required|numeric|min:0',
            ]);

            // Section presence
            $hasOutSupplier = is_array($request->input('item_names_S')) && count(array_filter($request->input('item_names_S'))) > 0;
            $hasSalesDetails = is_array($request->input('item_IDs')) && count($request->input('item_IDs')) > 0;

            if (!$hasOutSupplier && !$hasSalesDetails) {
                return back()->withErrors(['items' => 'Please add at least one sale item or out supplier item.'])->withInput();
            }

            DB::beginTransaction();
            try {
                // 1) Invoice
                $invoice = new Invoice();
                $invoice->Cust_ID = $request->customer_id[0];
                $invoice->Inv_Date = Carbon::today();
                $invoice->save();
                $invId = $invoice->Inv_ID;

                // 2) Out Supplier Items (if any)
                if ($hasOutSupplier) {
                    $supplierIds = $request->input('supplier_ids', []);
                    $itemNames   = $request->input('item_names_S', []);
                    $qtysS       = $request->input('qtys_S', []);
                    $pPricesS    = $request->input('S_unit_price_S', []);
                    $sPricesS    = $request->input('S_unit_sale_Price_S', []);
                    $amountsS    = $request->input('amounts_S', []);

                    for ($i = 0; $i < count($itemNames); $i++) {
                        $supId   = $supplierIds[$i] ?? null;
                        $name    = $itemNames[$i] ?? null;
                        $qty     = $qtysS[$i] ?? null;
                        $pPrice  = $pPricesS[$i] ?? null;
                        $sPrice  = $sPricesS[$i] ?? null;
                        $amount  = $amountsS[$i] ?? null;

                        if ($supId && $name && $qty && $pPrice !== null && $amount !== null) {
                            OutSupplierItem::create([
                                'F_Inv_ID' => $invId,
                                'F_cus_ID' => $request->customer_id[0] ?? null,
                                'sup_id'   => $supId,
                                'item_name'=> $name,
                                'qty'      => $qty,
                                'p_price'  => $pPrice,
                                's_price'  => $sPrice,
                                'amount'   => $amount,
                            ]);
                        }
                    }
                }

                // 3) Sales Details (if any)
                if ($hasSalesDetails) {
                    $items       = $request->input('item_IDs', []);
                    $expireDates = $request->input('exp_date', []);
                    $quantities  = $request->input('qtys', []);
                    $unitPrices  = $request->input('S_unit_price', []);
                    $salePrices  = $request->input('S_unit_sale_Price', []);

                    for ($index = 0; $index < count($items); $index++) {
                        $itemId = $items[$index] ?? null;
                        if (!$itemId) { continue; }
                        $detail = new SalesDetail();
                        $detail->Inv_ID = $invId;
                        $detail->F_cus_ID = $request->customer_id[0];
                        $detail->Emp_ID = 1;
                        $detail->Stock_ID = 1;
                        $detail->item_ID = $itemId;
                        $detail->Sale_Qty = $quantities[$index] ?? 0;
                        $detail->Expire_date = $expireDates[$index] ?? null;
                        $detail->S_unit_price = $unitPrices[$index] ?? 0;
                        $detail->S_unit_sale_Price = $salePrices[$index] ?? 0;
                        $detail->save();
                    }
                }

                // 4) Payment (always)
                $payment = new Payment();
                $payment->F_Inv_ID = $invId;
                $payment->Payment = $request->paid_amount;
                $payment->save();

                DB::commit();
                return redirect()->route('invoice.print', ['id' => $invoice->Inv_ID]);
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('Sales store failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
                return back()->with('error', 'Failed to save sale. Please try again.')->withInput();
            }
    }
        


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = SalesDetail::with([
            'item.category',
            'stock',
            'employee',
            'invoice.customer',
            'invoice.payments'
        ])->findOrFail($id);

        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = SalesDetail::with([
            'item.category',
            'stock',
            'employee',
            'invoice.customer'
        ])->findOrFail($id);

        $customers = Customer::all();
        $items = Item::all();

        return view('sales.edit', compact('sale', 'customers', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,Cust_ID',
            'item_ID' => 'required|exists:items,item_ID',
        ]);

        $sale = SalesDetail::findOrFail($id);
        
        // Update the customer in the invoice
        $sale->invoice->update([
            'Cust_ID' => $request->customer_id
        ]);
        
        // Update the item in the sales detail
        $sale->update([
            'item_ID' => $request->item_ID
        ]);

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Check if an item is available for sale (has remaining quantity > 0)
     * This method can be called from other parts of the application
     */
    public function checkItemAvailability(Request $request)
    {
        $itemId = $request->input('item_id');
        
        if (!$itemId) {
            return response()->json([
                'success' => false,
                'message' => 'Item ID is required'
            ]);
        }

        $remainingQty = $this->calculateRemainingQuantity($itemId);
        
        if ($remainingQty <= 0) {
            return response()->json([
                'success' => false,
                'available' => false,
                'remaining_qty' => $remainingQty,
                'message' => 'Item is out of stock. Remaining quantity: ' . $remainingQty
            ]);
        }

        return response()->json([
            'success' => true,
            'available' => true,
            'remaining_qty' => $remainingQty,
            'message' => 'Item is available with ' . $remainingQty . ' units in stock'
        ]);
    }
}
