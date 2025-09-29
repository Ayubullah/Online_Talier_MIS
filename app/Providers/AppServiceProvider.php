<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share stock alert count with all views
        View::composer('*', function ($view) {
            try {
                // Get stock alert count using the same logic as ReportController
                $alertThreshold = 10; // Default threshold
                
                $query = "
                    SELECT COUNT(*) as low_stock_count
                    FROM (
                        SELECT 
                            it.item_ID,
                            (COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                             - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0) 
                             - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0)
                             - COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                             + COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0)) as remain
                        FROM items it
                    ) as low_stock_items
                    WHERE remain <= ?";
                
                $result = DB::select($query, [$alertThreshold]);
                $stockAlertCount = $result[0]->low_stock_count ?? 0;
                
                // Get expiry items count (items expiring within 30 days or already expired with remaining stock)
                $expiryQuery = "
                    SELECT COUNT(DISTINCT it.item_ID) as expiry_count
                    FROM items it
                    INNER JOIN (
                        SELECT DISTINCT item_ID, Expire_date 
                        FROM purchasedetails 
                        WHERE Expire_date IS NOT NULL 
                        AND Expire_date != ''
                        AND Expire_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                    ) pd ON it.item_ID = pd.item_ID
                    WHERE ((COALESCE((SELECT SUM(Pur_D_Qty) FROM purchasedetails WHERE item_ID = it.item_ID), 0)
                         - COALESCE((SELECT SUM(Return_Qty) FROM purchase_return WHERE item_ID = it.item_ID), 0))
                         - (COALESCE((SELECT SUM(Sale_Qty) FROM salesdetails WHERE item_ID = it.item_ID), 0)
                         - COALESCE((SELECT SUM(Return_Qty) FROM sale_return WHERE item_ID = it.item_ID), 0))
                         - COALESCE((SELECT SUM(outstock_qty) FROM outstocks WHERE item_ID = it.item_ID), 0)) > 0";
                
                $expiryResult = DB::select($expiryQuery);
                $expiryItemsCount = count($expiryResult);
                
                $view->with([
                    'stockAlertCount' => $stockAlertCount,
                    'expiryItemsCount' => $expiryItemsCount
                ]);
            } catch (\Exception $e) {
                // If there's an error, set counts to 0
                $view->with([
                    'stockAlertCount' => 0,
                    'expiryItemsCount' => 0
                ]);
            }
        });
    }
}
