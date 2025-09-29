<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;

class StockAdviceController extends Controller
{
    public function index(Request $request)
    {
        $threshold = (int) $request->input('threshold', 10);
        $days = (int) $request->input('days', 30);

        $sql = "
            SELECT
    it.item_ID AS item_id,
    it.item_Name AS item_name,
    pd.Pur_D_Qty - COALESCE(pr.Return_Qty, 0)
      - GREATEST(
          COALESCE(sd.Sale_Qty,0) - COALESCE(sr.Return_Qty,0), 0
        )
      - COALESCE(os.outstock_qty,0) AS remain,
    pd.Expire_date,
    DATEDIFF(pd.Expire_date, CURDATE()) AS days_until_expiry
FROM
    items it
JOIN purchasedetails pd ON pd.item_ID = it.item_ID
LEFT JOIN (
    SELECT item_ID, SUM(Return_Qty) AS Return_Qty FROM purchase_return GROUP BY item_ID
) pr ON pr.item_ID = it.item_ID
LEFT JOIN (
    SELECT item_ID, SUM(Sale_Qty) AS Sale_Qty FROM salesdetails GROUP BY item_ID
) sd ON sd.item_ID = it.item_ID
LEFT JOIN (
    SELECT item_ID, SUM(Return_Qty) AS Return_Qty FROM sale_return GROUP BY item_ID
) sr ON sr.item_ID = it.item_ID
LEFT JOIN (
    SELECT item_ID, SUM(outstock_qty) AS outstock_qty FROM outstocks GROUP BY item_ID
) os ON os.item_ID = it.item_ID
WHERE
    DATEDIFF(pd.Expire_date, CURDATE()) <= 7  -- near expiry within 7 days
ORDER BY
    days_until_expiry ASC;

        ";

        $rows = collect(DB::select($sql));

        $lowStock = $rows
            ->filter(function ($r) use ($threshold) {
                return (int) ($r->remain ?? 0) <= $threshold;
            })
            ->sortBy('remain')
            ->values();

        $nearExpiry = $rows
            ->filter(function ($r) use ($days) {
                if ($r->days_until_expiry === null) {
                    return false;
                }
                $d = (int) $r->days_until_expiry;
                return $d >= 0 && $d <= $days;
            })
            ->sortBy('days_until_expiry')
            ->values();

        $reorder = $rows
            ->filter(function ($r) use ($threshold, $days) {
                $remain = (int) ($r->remain ?? 0);
                $dueSoon = $r->days_until_expiry !== null && (int) $r->days_until_expiry <= $days && (int) $r->days_until_expiry >= 0;
                return $remain <= $threshold || $dueSoon;
            })
            ->sortBy([
                ['remain', 'asc'],
                ['days_until_expiry', 'asc'],
            ])
            ->values();

        // Summary stats
        $totalItems = $rows->count();
        $totalRemain = (int) $rows->sum(function ($r) {
            return (int) ($r->remain ?? 0);
        });
        $lowStockCount = $lowStock->count();
        $nearExpiryCount = $nearExpiry->count();
        $outOfStockCount = $rows->filter(function ($r) {
            return (int) ($r->remain ?? 0) <= 0;
        })->count();
        $reorderCount = $reorder->count();

        // Chart data
        $lowChartSample = $lowStock->take(10);
        $lowChart = [
            'labels' => $lowChartSample->pluck('item_name')->values(),
            'values' => $lowChartSample->pluck('remain')->map(function ($v) { return (int) ($v ?? 0); })->values(),
        ];

        $expiryChartSample = $nearExpiry->take(10);
        $expiryChart = [
            'labels' => $expiryChartSample->pluck('item_name')->values(),
            'values' => $expiryChartSample->pluck('days_until_expiry')->map(function ($v) { return (int) ($v ?? 0); })->values(),
        ];

        $inStockCount = $rows->filter(function ($r) { return (int) ($r->remain ?? 0) > 0; })->count();
        $stockSplitChart = [
            'labels' => ['In Stock', 'Out of Stock'],
            'values' => [$inStockCount, $outOfStockCount],
        ];

        return view('stock.advice', [
            'threshold' => $threshold,
            'days' => $days,
            'lowStock' => $lowStock,
            'nearExpiry' => $nearExpiry,
            'reorder' => $reorder,
            'totalItems' => $totalItems,
            'totalRemain' => $totalRemain,
            'lowStockCount' => $lowStockCount,
            'nearExpiryCount' => $nearExpiryCount,
            'outOfStockCount' => $outOfStockCount,
            'reorderCount' => $reorderCount,
            'chartLow' => $lowChart,
            'chartExpiry' => $expiryChart,
            'chartStockSplit' => $stockSplitChart,
        ]);
    }
    public function chat(Request $request)
    {
    $threshold = 10;
    $days = 30;

    $sql = "
        SELECT
            it.item_ID AS item_id,
            it.item_Name AS item_name,
            (
                COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                - GREATEST(
                    COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                    - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0),
                    0
                )
                - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)
            ) AS remain,
            (SELECT MIN(Expire_date) FROM purchasedetails WHERE item_ID = it.item_ID) AS earliest_expiry,
            DATEDIFF((SELECT MIN(Expire_date) FROM purchasedetails WHERE item_ID = it.item_ID), CURDATE()) AS days_until_expiry
        FROM items it
        ORDER BY it.item_ID
    ";

    $rows = collect(DB::select($sql));

    $lowStock = $rows->filter(fn($r) => (int)($r->remain ?? 0) <= $threshold)->sortBy('remain')->values();
    $nearExpiry = $rows->filter(fn($r) => $r->days_until_expiry !== null && $r->days_until_expiry >= 0 && $r->days_until_expiry <= $days)->sortBy('days_until_expiry')->values();
    $reorder = $rows->filter(fn($r) => ((int)($r->remain ?? 0) <= $threshold) || ($r->days_until_expiry !== null && $r->days_until_expiry <= $days && $r->days_until_expiry >= 0))->sortBy(['remain','days_until_expiry'])->values();

    $totalItems = $rows->count();
    $totalRemain = (int)$rows->sum(fn($r)=> (int)($r->remain ?? 0));

    $stock_data = [
        'low_stock' => $lowStock,
        'near_expiry' => $nearExpiry,
        'reorder' => $reorder,
        'total_items' => $totalItems,
        'total_remain' => $totalRemain,
    ];

    $chat_history = session('chat_history', []);

    // Add user message
    $chat_history[] = ['role'=>'user','content'=>$request->message];

    $system_prompt = "You are a pharmacy stock advisor AI. Use the following stock data to answer user questions accurately: ".json_encode($stock_data);

    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => array_merge([['role'=>'system','content'=>$system_prompt]], $chat_history)
        ]);
        $ai_message = $response['choices'][0]['message']['content'] ?? 'No response';
    } catch (\Exception $e) {
        $ai_message = 'AI service unavailable: '.$e->getMessage();
    }

    $chat_history[] = ['role'=>'assistant','content'=>$ai_message];
    session(['chat_history'=>$chat_history]);

        return redirect()->back();
    }

    public function clear(Request $request)
    {
        session()->forget('chat_history');
        return redirect()->back();
    }

}
