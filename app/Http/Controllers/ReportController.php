<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustPaid;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\SaleReturn;
use App\Models\SalesDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function customer(Request $request)
    {
        $searchId = $request->input('search');

        $customers = Customer::all();

        if ($searchId) {
            // Fetch filtered data
            $sales = SalesDetail::with(['item.category', 'stock', 'employee', 'invoice.customer'])
                ->whereHas('invoice.customer', fn($q) => $q->where('Cust_ID', $searchId))
                ->get();

            $salesReturns = SaleReturn::with('item', 'customer')
                ->where('Cust_ID', $searchId)
                ->get();

            $payments = Payment::with(['invoice.customer', 'invoice.salesDetails'])
                ->whereHas('invoice.customer', fn($q) => $q->where('Cust_ID', $searchId))
                ->get();

            $loans = DB::select("
                SELECT 
            cu.Cust_ID, 
            cu.Cust_Name, 
            i.Inv_ID, 
            
            COALESCE(SUM(sd.Sale_Qty * sd.S_unit_sale_Price), 0) AS sale_total, 
            COALESCE(MAX(py.Payment), 0) AS Payment, 
            COALESCE(SUM( (sd.Sale_Qty * sd.S_unit_sale_Price)), 0) - COALESCE(MAX(py.Payment), 0) AS remain
                FROM invoice i
                INNER JOIN customers cu ON i.Cust_ID = cu.Cust_ID
                inner JOIN salesdetails sd ON sd.Inv_ID = i.Inv_ID
                inner JOIN payments py ON py.F_Inv_ID = i.Inv_ID
                WHERE cu.Cust_ID = ?
                GROUP BY cu.Cust_ID, cu.Cust_Name, i.Inv_ID;

            ", [$searchId]);

            // Out-supplier data per item with per-invoice totals and payments
            $outSupplierdata = DB::select("
                SELECT 
                    cu.Cust_ID, 
                    cu.Cust_Name, 
                    i.Inv_ID AS Inv_ID,
                    COALESCE(MAX(os.p_price), 0) AS p_price, 
                    COALESCE(MAX(os.s_price), 0) AS s_price,
                    COALESCE(SUM(os.qty), 0) AS qty,
                    COALESCE(SUM(os.qty * os.s_price), 0) AS Stotal,
                    COALESCE(MAX(py.Payment), 0) AS SPayment,
                    COALESCE(SUM(os.qty * os.s_price), 0) AS Sremain
                FROM invoice i
                INNER JOIN customers cu ON i.Cust_ID = cu.Cust_ID
                INNER JOIN out_supplier_items os ON os.F_Inv_ID = i.Inv_ID
                LEFT JOIN payments py ON py.F_Inv_ID = i.Inv_ID
                WHERE cu.Cust_ID = ?
                GROUP BY cu.Cust_ID, cu.Cust_Name, i.Inv_ID
            ", [$searchId]);



            $custPaids = CustPaid::with('customer')
                ->where('cus_id', $searchId)
                ->orderByDesc('created_at')
                ->get();

            
        } else {
            // No searchId: return empty collections or default data if needed
            $sales = collect();
            $salesReturns = collect();
            $payments = collect();
            $loans = [];
            $custPaids = collect();
            $outSupplierdata = [];
        }

        return view('Reports.customer', compact('customers', 'sales', 'salesReturns', 'payments', 'loans', 'custPaids','outSupplierdata', 'searchId'));

    }

    /**
     * Display supplier report with details
     */
    public function supplier(Request $request)
    {
        $searchId = $request->input('search');

        $suppliers = \App\Models\Supplier::all();

        if ($searchId) {
            // Fetch filtered data
            $purchases = \App\Models\PurchaseDetail::with(['item.category', 'stock', 'employee', 'purchaseBill.supplier'])
                ->whereHas('purchaseBill.supplier', fn($q) => $q->where('Sup_ID', $searchId))
                ->get();

            $purchaseReturns = \App\Models\PurchaseReturn::with('item', 'supplier')
                ->where('Sup_ID', $searchId)
                ->get();

            $payments = Payment::with(['purchaseBill.supplier', 'purchaseBill.purchaseDetails'])
                ->whereHas('purchaseBill.supplier', fn($q) => $q->where('Sup_ID', $searchId))
                ->get();

            $loans = DB::select("
                SELECT 
                    s.Sup_ID, 
                    s.Sup_Name, 
                    pb.Pur_bill_ID, 
                    SUM(pd.Pur_D_Qty * pd.P_unit_price) AS total, 
                    MAX(py.Payment) AS Payment, 
                    SUM(pd.Pur_D_Qty * pd.P_unit_price) - MAX(py.Payment) AS remain
                FROM purchase_bill pb
                INNER JOIN suppliers s ON pb.Sup_ID = s.Sup_ID
                INNER JOIN purchasedetails pd ON pd.Pur_bill_ID = pb.Pur_bill_ID
                INNER JOIN payments py ON py.F_Pur_bill_ID = pb.Pur_bill_ID
                WHERE s.Sup_ID = ?
                GROUP BY pb.Pur_bill_ID, s.Sup_ID, s.Sup_Name
            ", [$searchId]);

            $supplierPaids = \App\Models\Debit::with('supplier')
                ->where('sup_id', $searchId)
                ->orderByDesc('created_at')
                ->get();

            // Out Supplier Items for this supplier
            $outSupplierItems = \App\Models\OutSupplierItem::with(['supplier','invoice'])
                ->where('sup_id', $searchId)
                ->orderByDesc('created_at')
                ->get();
        } else {
            // No searchId: return empty collections or default data if needed
            $purchases = collect();
            $purchaseReturns = collect();
            $payments = collect();
            $loans = [];
            $supplierPaids = collect();
            $outSupplierItems = collect();
        }

        return view('Reports.supplier', compact('suppliers', 'purchases', 'purchaseReturns', 'payments', 'loans', 'supplierPaids', 'outSupplierItems', 'searchId'));
    }

    /**
     * Display profit report with date filtering
     */
    public function profit(Request $request)
    {
        $from = $request->input('from', now()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));

        // Get profit data for the selected date range using invoice date
        $profitData = SalesDetail::with(['item', 'invoice'])
            ->whereHas('invoice', function($query) use ($from, $to) {
                $query->whereBetween('Inv_Date', [$from, $to]);
            })
            ->get()
            ->map(function ($sale) {
                $profit = ($sale->S_unit_sale_Price - $sale->S_unit_price) * $sale->Sale_Qty;
                return [
                    'sale_id' => $sale->Sale_ID,
                    'item_name' => $sale->item->item_Name ?? 'N/A',
                    'quantity' => $sale->Sale_Qty,
                    'unit_cost' => $sale->S_unit_price,
                    'unit_sale_price' => $sale->S_unit_sale_Price,
                    'total_cost' => $sale->S_unit_price * $sale->Sale_Qty,
                    'total_sale' => $sale->S_unit_sale_Price * $sale->Sale_Qty,
                    'profit' => $profit,
                    'invoice_id' => $sale->Inv_ID,
                    'created_at' => $sale->invoice->Inv_Date ? \Carbon\Carbon::parse($sale->invoice->Inv_Date)->format('Y-m-d H:i:s') : 'N/A'
                ];
            });

        // Get out supplier profit data for the selected date range
        $outSupplierProfitData = \App\Models\OutSupplierItem::with(['supplier', 'invoice'])
            ->whereHas('invoice', function($query) use ($from, $to) {
                $query->whereBetween('Inv_Date', [$from, $to]);
            })
            ->get()
            ->map(function ($outSupplier) {
                $profit = ($outSupplier->s_price - $outSupplier->p_price) * $outSupplier->qty;
                return [
                    'id' => $outSupplier->id,
                    'supplier_name' => $outSupplier->supplier->Sup_Name ?? 'N/A',
                    'item_name' => $outSupplier->item_name,
                    'quantity' => $outSupplier->qty,
                    'unit_cost' => $outSupplier->p_price,
                    'unit_sale_price' => $outSupplier->s_price,
                    'total_cost' => $outSupplier->p_price * $outSupplier->qty,
                    'total_sale' => $outSupplier->s_price * $outSupplier->qty,
                    'profit' => $profit,
                    'invoice_id' => $outSupplier->F_Inv_ID,
                    'created_at' => $outSupplier->invoice->Inv_Date ? \Carbon\Carbon::parse($outSupplier->invoice->Inv_Date)->format('Y-m-d H:i:s') : 'N/A'
                ];
            });

        // Calculate totals for regular sales
        $totalProfit = $profitData->sum('profit');
        $totalSales = $profitData->sum('total_sale');
        $totalCost = $profitData->sum('total_cost');
        $totalQuantity = $profitData->sum('quantity');

        // Calculate totals for out supplier sales
        $outSupplierTotalProfit = $outSupplierProfitData->sum('profit');
        $outSupplierTotalSales = $outSupplierProfitData->sum('total_sale');
        $outSupplierTotalCost = $outSupplierProfitData->sum('total_cost');
        $outSupplierTotalQuantity = $outSupplierProfitData->sum('quantity');

        // Combined totals
        $combinedTotalProfit = $totalProfit + $outSupplierTotalProfit;
        $combinedTotalSales = $totalSales + $outSupplierTotalSales;
        $combinedTotalCost = $totalCost + $outSupplierTotalCost;
        $combinedTotalQuantity = $totalQuantity + $outSupplierTotalQuantity;

        return view('Reports.profit', compact(
            'profitData', 
            'outSupplierProfitData',
            'totalProfit', 
            'totalSales', 
            'totalCost', 
            'totalQuantity',
            'outSupplierTotalProfit',
            'outSupplierTotalSales',
            'outSupplierTotalCost',
            'outSupplierTotalQuantity',
            'combinedTotalProfit',
            'combinedTotalSales',
            'combinedTotalCost',
            'combinedTotalQuantity',
            'from', 
            'to'
        ));
    }

    /**
     * Display sales and purchase report with date and item filtering
     */
    public function salesPurchase(Request $request)
    {
        $from = $request->input('from', now()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));
        $itemId = $request->input('item_id');
        
        // Get all items for filter dropdown
        $items = \App\Models\Item::orderBy('item_Name')->get();
        
        // Build sales query using invoice date
        $salesQuery = SalesDetail::with(['item', 'invoice.customer', 'employee'])
            ->whereHas('invoice', function($query) use ($from, $to) {
                $query->whereBetween('Inv_Date', [$from, $to]);
            });
        
        // Build purchase query using purchase bill date
        $purchaseQuery = \App\Models\PurchaseDetail::with(['item', 'purchaseBill.supplier'])
            ->whereHas('purchaseBill', function($query) use ($from, $to) {
                $query->whereBetween('Pur_bill_date', [$from, $to]);
            });
        
        // Apply item filter if selected
        if ($itemId) {
            $salesQuery->where('item_ID', $itemId);
            $purchaseQuery->where('item_ID', $itemId);
        }
        
        $sales = $salesQuery->get();
        $purchases = $purchaseQuery->get();
        
        // Process sales data
        $salesData = $sales->map(function ($sale) {
            return [
                'id' => $sale->Sale_ID,
                'type' => 'Sale',
                'item_name' => $sale->item->item_Name ?? 'N/A',
                'quantity' => $sale->Sale_Qty,
                'box_size' => $sale->item->box_size ?? null,
                'unit_price' => $sale->S_unit_sale_Price,
                'total_amount' => $sale->S_unit_sale_Price * $sale->Sale_Qty,
                'customer' => $sale->invoice->customer->Cust_Name ?? 'N/A',
                'employee' => $sale->employee->Emp_Name ?? 'N/A',
                'invoice_id' => $sale->Inv_ID,
                'time' => $sale->invoice->Inv_Date ? \Carbon\Carbon::parse($sale->invoice->Inv_Date)->format('H:i') : 'N/A',
                'created_at' => $sale->invoice->Inv_Date ? \Carbon\Carbon::parse($sale->invoice->Inv_Date) : null
            ];
        });
        
        // Process purchase data
        $purchaseData = $purchases->map(function ($purchase) {
            return [
                'id' => $purchase->Pur_D_ID,
                'type' => 'Purchase',
                'item_name' => $purchase->item->item_Name ?? 'N/A',
                'quantity' => $purchase->Pur_D_Qty,
                'box_size' => $purchase->item->box_size ?? null,
                'unit_price' => $purchase->P_unit_price,
                'total_amount' => $purchase->P_unit_price * $purchase->Pur_D_Qty,
                'supplier' => $purchase->purchaseBill->supplier->Sup_Name ?? 'N/A',
                'bill_id' => $purchase->Pur_bill_ID,
                'time' => $purchase->purchaseBill->Pur_bill_date ? \Carbon\Carbon::parse($purchase->purchaseBill->Pur_bill_date)->format('H:i') : 'N/A',
                'created_at' => $purchase->purchaseBill->Pur_bill_date ? \Carbon\Carbon::parse($purchase->purchaseBill->Pur_bill_date) : null
            ];
        });
        
        // Combine and sort by time
        $allTransactions = $salesData->concat($purchaseData)->sortBy('created_at');
        
        // Calculate totals
        $totalSales = $salesData->sum('total_amount');
        $totalPurchases = $purchaseData->sum('total_amount');
        $totalSalesQuantity = $salesData->sum('quantity');
        $totalPurchaseQuantity = $purchaseData->sum('quantity');
        $netAmount = $totalSales - $totalPurchases;
        
        // Get top selling items
        $topSellingItems = $salesData->groupBy('item_name')
            ->map(function ($group) {
                return [
                    'item_name' => $group->first()['item_name'],
                    'total_quantity' => $group->sum('quantity'),
                    'total_amount' => $group->sum('total_amount')
                ];
            })
            ->sortByDesc('total_amount')
            ->take(5);
        
        // Get top purchased items
        $topPurchasedItems = $purchaseData->groupBy('item_name')
            ->map(function ($group) {
                return [
                    'item_name' => $group->first()['item_name'],
                    'total_quantity' => $group->sum('quantity'),
                    'total_amount' => $group->sum('total_amount')
                ];
            })
            ->sortByDesc('total_amount')
            ->take(5);

        return view('Reports.salesPurchase', compact(
            'allTransactions', 
            'salesData', 
            'purchaseData', 
            'totalSales', 
            'totalPurchases', 
            'totalSalesQuantity', 
            'totalPurchaseQuantity', 
            'netAmount', 
            'items', 
            'itemId', 
            'topSellingItems', 
            'topPurchasedItems',
            'from',
            'to'
        ));
    }

    /**
     * Display stock alert report with net quantity calculations
     */
    public function stockAlert(Request $request)
    {
        $alertThreshold = $request->input('threshold', 10); // Default threshold of 10
        $selectedItem = $request->input('item_category');
        $stockStatus = $request->input('stock_status');
        
        // Get categories with their items for the combined dropdown
        $categories = \App\Models\Category::with('items')->orderBy('Cat_Name')->get();
        
        // Build the base query using the new SQL structure
        $query = "
            SELECT
                it.item_ID AS item_id,
                it.item_Name AS item_name,

                -- Total Purchase Qty
                COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS total_purchase_qty,

                -- Total Purchase Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS t_pd_Price,

                -- Total Purchase Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS total_returned_qty,

                -- Total Purchase Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS t_rt_Price,

                -- Total Outstock Qty
                COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0) AS total_outstock_qty,

                0 AS t_outs_Price,

                -- Total Sales Qty
                COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS total_sales_qty,

                -- Total Sales Amount
                COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS t_sd_Price,

                -- Total Sales Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0) AS total_sales_returned_qty,

                -- Total Sales Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0) AS t_sal_rt_Price,

                -- Net Purchase (Qty) = Purchase Qty - Purchase Returned Qty
                (
                    COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                ) AS net_purchase_qty,

                -- Net Purchase (Amount) = Purchase Amount - Returned Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS Net_Purchase,

                -- Net Sale Qty = Sales Qty - Sales Returned Qty (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS net_sale_qty,

                -- Net Sale Amount = Sales Amount - Sales Returned Amount (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS Net_Sales,

                -- Remain = Net Purchase Qty - Net Sale Qty - Outstock Qty
                (
                    (
                        COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                    )
                    - GREATEST(
                        COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                        0
                    )
                    - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)
                ) AS remain

            FROM items it
        ";
        
        // Add WHERE clauses for filtering
        $whereConditions = [];
        $params = [];
        
        if ($selectedItem) {
            $whereConditions[] = "it.item_ID = ?";
            $params[] = $selectedItem;
        }
        
        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }
        
        $query .= " ORDER BY it.item_ID";
        
        // Execute the query
        $stockData = DB::select($query, $params);
        
        // Process the data for stock alerts
        $stockAlerts = [];
        $lowStockItems = [];
        
        foreach ($stockData as $item) {
            // Get category name for the item
            $category = \App\Models\Category::whereHas('items', function($query) use ($item) {
                $query->where('item_ID', $item->item_id);
            })->first();
            
            $categoryName = $category ? $category->Cat_Name : 'N/A';
            
            // Calculate current stock (remaining quantity)
            $currentStock = $item->remain;
            
            // Check if stock is low
            $isLowStock = $currentStock <= $alertThreshold;
            
            // Get stock status
            $stockStatusValue = $this->getStockStatus($currentStock, $alertThreshold);
            
            // Apply stock status filter if specified
            if ($stockStatus && $stockStatus !== '') {
                if ($stockStatus === 'out_of_stock' && $stockStatusValue !== 'Out of Stock') {
                    continue;
                } elseif ($stockStatus === 'critical' && $stockStatusValue !== 'Critical') {
                    continue;
                } elseif ($stockStatus === 'low' && $stockStatusValue !== 'Low Stock') {
                    continue;
                }
            }
            
            $stockItem = [
                'item_id' => $item->item_id,
                'item_name' => $item->item_name,
                'category_name' => $categoryName,
                'current_stock' => $currentStock,
                'is_low_stock' => $isLowStock,
                'alert_threshold' => $alertThreshold,
                
                // Purchase data
                'total_purchases' => $item->total_purchase_qty,
                'purchase_returns' => $item->total_returned_qty,
                'net_purchases' => $item->net_purchase_qty,
                'total_purchase_amount' => $item->t_pd_Price,
                'purchase_return_amount' => $item->t_rt_Price,
                'net_purchase_amount' => $item->Net_Purchase,
                
                // Sale data
                'total_sales' => $item->total_sales_qty,
                'sale_returns' => $item->total_sales_returned_qty,
                'net_sales' => $item->net_sale_qty,
                'total_sale_amount' => $item->t_sd_Price,
                'sale_return_amount' => $item->t_sal_rt_Price,
                'net_sale_amount' => $item->Net_Sales,
                
                // Additional fields for the view
                'total_returns' => $item->total_returned_qty + $item->total_sales_returned_qty,
                'total_return_amount' => $item->t_rt_Price + $item->t_sal_rt_Price,
                'total_outstock' => $item->total_outstock_qty,
                'total_outstock_amount' => $item->t_outs_Price,
                
                // Net remaining
                'net_remaining' => $currentStock,
                'net_remaining_amount' => $item->Net_Purchase - $item->Net_Sales,
                
                // Stock status
                'stock_status' => $stockStatusValue
            ];
            
            $stockAlerts[] = $stockItem;
            
            // Add to low stock items if applicable
            if ($isLowStock) {
                $lowStockItems[] = $stockItem;
            }
        }
        
        // Calculate summary statistics
        $summary = [
            'total_items' => count($stockAlerts),
            'low_stock_items' => count($lowStockItems),
            'critical_stock_items' => collect($lowStockItems)->where('current_stock', '<=', 5)->count(),
            'out_of_stock_items' => collect($lowStockItems)->where('current_stock', '<=', 0)->count(),
            'total_stock_value' => collect($stockAlerts)->sum('net_remaining_amount'),
            'low_stock_value' => collect($lowStockItems)->sum('net_remaining_amount')
        ];

        return view('Reports.stockAlert', compact(
            'stockAlerts', 
            'lowStockItems', 
            'summary', 
            'alertThreshold', 
            'categories',
            'selectedItem',
            'stockStatus'
        ));
    }

    /**
     * Get stock status based on current stock and threshold
     */
    private function getStockStatus($currentStock, $threshold)
    {
        if ($currentStock <= 0) {
            return 'Out of Stock';
        } elseif ($currentStock <= 5) {
            return 'Critical';
        } elseif ($currentStock <= $threshold) {
            return 'Low Stock';
        } else {
            return 'In Stock';
        }
    }

    /**
     * Display complete stock analysis using raw SQL queries
     */
    public function stockAnalysis(Request $request)
    {
        $alertThreshold = $request->input('threshold', 10);
        $searchItem = $request->input('search_item');
        $itemId = $request->input('item_id');
        
        // Build the base query
        $query = "
            SELECT
                it.item_ID AS item_id,
                it.item_Name AS item_name,
                it.box_size AS box_size,

                -- Total Purchase Qty
                COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS total_purchase_qty,

                -- Total Purchase Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS t_pd_Price,

                -- Total Purchase Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS total_returned_qty,

                -- Total Purchase Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS t_rt_Price,

                -- Total Outstock Qty
                COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0) AS total_outstock_qty,

                0 AS t_outs_Price,

                -- Total Sales Qty
                COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS total_sales_qty,

                -- Total Sales Amount
                COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS t_sd_Price,

                -- Total Sales Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0) AS total_sales_returned_qty,

                -- Total Sales Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0) AS t_sal_rt_Price,

                -- Net Purchase (Qty) = Purchase Qty - Purchase Returned Qty
                (
                    COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                ) AS net_purchase_qty,

                -- Net Purchase (Amount) = Purchase Amount - Returned Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS Net_Purchase,

                -- Net Sale Qty = Sales Qty - Sales Returned Qty (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS net_sale_qty,

                -- Net Sale Amount = Sales Amount - Sales Returned Amount (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS Net_Sales,

                -- Remain = Net Purchase Qty - Net Sale Qty - Outstock Qty
                (
                    (
                        COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                    )
                    - GREATEST(
                        COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                        0
                    )
                    - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)
                ) AS remain

            FROM items it
        ";
        
        // Add WHERE clauses for filtering
        $whereConditions = [];
        $params = [];
        
        if ($searchItem) {
            $whereConditions[] = "it.item_Name LIKE ?";
            $params[] = "%{$searchItem}%";
        }
        
        if ($itemId) {
            $whereConditions[] = "it.item_ID = ?";
            $params[] = $itemId;
        }
        
        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }
        
        $query .= " ORDER BY it.item_ID";
        
        // Execute the query
        $stockData = DB::select($query, $params);
        
        // Calculate summary statistics
        $summary = [
            'total_items' => count($stockData),
            'total_purchase_value' => collect($stockData)->sum('Net_Purchase'),
            'total_sales_value' => collect($stockData)->sum('Net_Sales'),
            'total_remaining_value' => collect($stockData)->sum('remain'),
            'items_with_stock' => collect($stockData)->where('remain', '>', 0)->count(),
            'items_out_of_stock' => collect($stockData)->where('remain', '<=', 0)->count(),
        ];

        return view('Reports.stockAnalysis', compact(
            'stockData', 
            'summary', 
            'alertThreshold', 
            'searchItem',
            'itemId'
        ));
    }

    /**
     * Display remaining stock report with detailed calculations
     */
    public function stockReport(Request $request)
    {
        $searchItem = $request->input('search_item');
        $itemId = $request->input('item_id');
        
        // Build the base query
        $query = "
            SELECT
                it.item_ID AS item_id,
                it.item_Name AS item_name,
                it.box_size AS box_size,

                -- Total Purchase Qty
                COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS total_purchase_qty,

                -- Total Purchase Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS t_pd_Price,

                -- Total Purchase Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS total_returned_qty,

                -- Total Purchase Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS t_rt_Price,

                -- Total Outstock Qty
                COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0) AS total_outstock_qty,

                0 AS t_outs_Price,

                -- Total Sales Qty
                COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS total_sales_qty,

                -- Total Sales Amount
                COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS t_sd_Price,

                -- Total Sales Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0) AS total_sales_returned_qty,

                -- Total Sales Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0) AS t_sal_rt_Price,

                -- Net Purchase (Qty) = Purchase Qty - Purchase Returned Qty
                (
                    COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                ) AS net_purchase_qty,

                -- Net Purchase (Amount) = Purchase Amount - Returned Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS Net_Purchase,

                -- Net Sale Qty = Sales Qty - Sales Returned Qty (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS net_sale_qty,

                -- Net Sale Amount = Sales Amount - Sales Returned Amount (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS Net_Sales,

                -- Remain = Net Purchase Qty - Net Sale Qty - Outstock Qty
                (
                    (
                        COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                    )
                    - GREATEST(
                        COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                        0
                    )
                    - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)
                ) AS remain

            FROM items it
        ";
        
        // Add WHERE clauses for filtering
        $whereConditions = [];
        $params = [];
        
        if ($searchItem) {
            $whereConditions[] = "it.item_Name LIKE ?";
            $params[] = "%{$searchItem}%";
        }
        
        if ($itemId) {
            $whereConditions[] = "it.item_ID = ?";
            $params[] = $itemId;
        }
        
        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }
        
        $query .= " ORDER BY it.item_ID";
        
        // Execute the query
        $stockData = DB::select($query, $params);
        
        // Calculate summary statistics
        $summary = [
            'total_items' => count($stockData),
            'total_purchase_value' => collect($stockData)->sum('Net_Purchase'),
            'total_sales_value' => collect($stockData)->sum('Net_Sales'),
            'total_remaining_value' => collect($stockData)->sum('remain'),
            'items_with_stock' => collect($stockData)->where('remain', '>', 0)->count(),
            'items_out_of_stock' => collect($stockData)->where('remain', '<=', 0)->count(),
        ];
        
        return view('Reports.stockReport', compact('stockData', 'summary', 'searchItem', 'itemId'));
    }

    /**
     * Display expiry items report with search functionality
     */
    public function expiryItems(Request $request)
    {
        $search = $request->input('search');
        $categoryFilter = $request->input('category');
        $daysFilter = $request->input('days', 30); // Default to 30 days
        $tab = $request->input('tab', 'expiry'); // Default to expiry tab

        // Build the base query for items expiring within specified days using subqueries
        $query = "
            SELECT 
                it.item_ID AS item_id,
                it.item_Name AS item_name,
                c.cat_Name AS category_name,
                it.item_Desc AS description,
                it.box_size AS box_size,
                pd.Expire_date,
                DATEDIFF(pd.Expire_date, CURDATE()) AS days_until_expiry,
                COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS total_purchased_qty,
                COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS total_sold_qty,
                COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS total_returned_qty,
                COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0) AS total_outstock_qty,
                
                (COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                 - COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0) 
                 - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                 - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)
                 + COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0)) AS remaining_stock,
                
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS total_purchase_value,
                COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS total_sales_value,
                
                CASE 
                    WHEN DATEDIFF(pd.Expire_date, CURDATE()) < 0 THEN 'Expired'
                    WHEN DATEDIFF(pd.Expire_date, CURDATE()) <= 7 THEN 'Critical'
                    WHEN DATEDIFF(pd.Expire_date, CURDATE()) <= 15 THEN 'Warning'
                    WHEN DATEDIFF(pd.Expire_date, CURDATE()) <= 30 THEN 'Notice'
                    ELSE 'Safe'
                END AS expiry_status
                
            FROM items it
            LEFT JOIN categories c ON it.Cat_ID = c.cat_ID
            LEFT JOIN purchasedetails pd ON it.item_ID = pd.item_ID
            WHERE pd.Expire_date IS NOT NULL 
                AND pd.Expire_date != ''
                AND pd.Expire_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
                AND (COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                     - COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0) 
                     - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                     - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)
                     + COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0)) > 0
        ";

        $params = [$daysFilter];

        // Add search filter
        if ($search) {
            $query .= " AND (it.item_Name LIKE ? OR it.item_Desc LIKE ? OR c.cat_Name LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        // Add category filter
        if ($categoryFilter) {
            $query .= " AND c.cat_ID = ?";
            $params[] = $categoryFilter;
        }

        $query .= " ORDER BY pd.Expire_date ASC, days_until_expiry ASC";

        $expiryItems = DB::select($query, $params);

        // Stock Analysis Query (the detailed query you provided)
        $stockSearch = $request->input('stock_search');
        $stockCategoryFilter = $request->input('stock_category');
        
        $stockQuery = "
            SELECT
                it.item_ID AS item_id,
                it.item_Name AS item_name,

                -- Total Purchase Qty
                COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS total_purchase_qty,

                -- Total Purchase Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0) AS t_pd_Price,

                -- Total Purchase Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS total_returned_qty,

                -- Total Purchase Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS t_rt_Price,

                -- Total Outstock Qty
                COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0) AS total_outstock_qty,

                0 AS t_outs_Price,

                -- Total Sales Qty
                COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS total_sales_qty,

                -- Total Sales Amount
                COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0) AS t_sd_Price,

                -- Total Sales Returned Qty
                COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0) AS total_sales_returned_qty,

                -- Total Sales Returned Amount
                COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0) AS t_sal_rt_Price,

                -- Net Purchase (Qty) = Purchase Qty - Purchase Returned Qty
                (
                    COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                ) AS net_purchase_qty,

                -- Net Purchase (Amount) = Purchase Amount - Returned Amount
                COALESCE((SELECT SUM(Pur_D_Qty * P_unit_price) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM purchase_return WHERE item_ID = it.item_ID), 0) AS Net_Purchase,

                -- Net Sale Qty = Sales Qty - Sales Returned Qty (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS net_sale_qty,

                -- Net Sale Amount = Sales Amount - Sales Returned Amount (never negative)
                GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty * S_unit_sale_Price) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty * Return_Rate) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                ) AS Net_Sales,

                -- Remain = Net Purchase Qty - Net Sale Qty - Outstock Qty
                (
                    (
                        COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                    )
                    - GREATEST(
                        COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                        - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                        0
                    )
                    - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)
                ) AS remain

            FROM items it
        ";

        $stockParams = [];
        $stockWhereConditions = [];

        // Add search filter for stock analysis
        if ($stockSearch) {
            $stockWhereConditions[] = "it.item_Name LIKE ?";
            $stockParams[] = "%{$stockSearch}%";
        }

        // Add category filter for stock analysis
        if ($stockCategoryFilter) {
            $stockWhereConditions[] = "it.Cat_ID = ?";
            $stockParams[] = $stockCategoryFilter;
        }

        if (!empty($stockWhereConditions)) {
            $stockQuery .= " WHERE " . implode(" AND ", $stockWhereConditions);
        }

        $stockQuery .= " ORDER BY it.item_ID";

        $stockAnalysis = DB::select($stockQuery, $stockParams);

        // Get categories for filter dropdown
        $categories = DB::select("SELECT cat_ID, cat_Name FROM categories ORDER BY cat_Name");

        // Calculate summary statistics
        $summary = [
            'total_items' => count($expiryItems),
            'expired' => count(array_filter($expiryItems, fn($item) => $item->days_until_expiry < 0)),
            'critical' => count(array_filter($expiryItems, fn($item) => $item->days_until_expiry >= 0 && $item->days_until_expiry <= 7)),
            'warning' => count(array_filter($expiryItems, fn($item) => $item->days_until_expiry > 7 && $item->days_until_expiry <= 15)),
            'notice' => count(array_filter($expiryItems, fn($item) => $item->days_until_expiry > 15 && $item->days_until_expiry <= 30)),
        ];

        return view('Reports.expiryItems', compact(
            'expiryItems', 
            'categories', 
            'summary', 
            'search', 
            'categoryFilter', 
            'daysFilter',
            'stockAnalysis',
            'stockSearch',
            'stockCategoryFilter',
            'tab'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
