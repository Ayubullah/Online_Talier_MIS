<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\ClothM;
use App\Models\VestM;
use App\Models\ClothAssignment;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Display the search page
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * Search customers by phone number with comprehensive data
     */
    public function searchByPhone(Request $request)
    {
        $phoneNumber = $request->input('phone_number');
        
        if (empty($phoneNumber)) {
            return redirect()->route('search.index')->with('error', 'Please enter a phone number to search');
        }

        try {
            // Check if any customers exist with this phone number
            $customers = Customer::whereHas('phone', function ($query) use ($phoneNumber) {
                $query->where('pho_no', $phoneNumber);
            })->get();

            if ($customers->isEmpty()) {
                return redirect()->route('search.index')->with('error', 'No customers found with phone number: ' . $phoneNumber);
            }

            // Redirect directly to the show page with the phone number
            return redirect()->route('search.show', $phoneNumber);

        } catch (\Exception $e) {
            return redirect()->route('search.index')->with('error', 'Error searching customers: ' . $e->getMessage());
        }
    }

    /**
     * Show all customers with the same phone number and their combined data
     */
    public function show($phoneNumber)
    {
        $customers = Customer::with([
            'phone', 
            'clothMeasurements', 
            'vestMeasurements', 
            'customerPayments',
            'invoice'
        ])
        ->whereHas('phone', function ($query) use ($phoneNumber) {
            $query->where('pho_no', $phoneNumber);
        })
        ->get();

        if ($customers->isEmpty()) {
            return redirect()->route('search.index')->with('error', 'No customers found with phone number: ' . $phoneNumber);
        }

        // Calculate combined financial summary for all customers
        $financialSummary = $this->calculateCombinedFinancialSummary($customers);
        
        // Get combined order statistics for all customers
        $orderStats = $this->getCombinedOrderStats($customers);
        
        // Get combined recent activity for all customers
        $recentActivity = $this->getCombinedRecentActivity($customers);

        // Get the primary customer (first one) for display purposes
        $primaryCustomer = $customers->first();

        return view('search.show', compact('customers', 'primaryCustomer', 'financialSummary', 'orderStats', 'recentActivity', 'phoneNumber'));
    }

    /**
     * Calculate financial summary for customer
     */
    private function calculateFinancialSummary($customer)
    {
        $totalClothRate = $customer->clothMeasurements->sum('cloth_rate');
        $totalVestRate = $customer->vestMeasurements->sum('vest_rate');
        $totalPaid = $customer->customerPayments->sum('amount');
        $totalOrderValue = $totalClothRate + $totalVestRate;
        $remainingBalance = $totalOrderValue - $totalPaid;

        return [
            'total_order_value' => $totalOrderValue,
            'total_paid' => $totalPaid,
            'remaining_balance' => $remainingBalance,
            'cloth_total' => $totalClothRate,
            'vest_total' => $totalVestRate,
        ];
    }

    /**
     * Get order statistics for customer
     */
    private function getOrderStats($customer)
    {
        $clothOrders = $customer->clothMeasurements;
        $vestOrders = $customer->vestMeasurements;
        
        // Count pending orders (cloth uses 'order_status', vest uses 'Status')
        $pendingCloth = $clothOrders->whereIn('order_status', ['pending', 'in_progress'])->count();
        $pendingVest = $vestOrders->whereIn('Status', ['pending', 'in_progress'])->count();
        
        // Count completed orders
        $completedCloth = $clothOrders->where('order_status', 'complete')->count();
        $completedVest = $vestOrders->where('Status', 'complete')->count();

        return [
            'total_orders' => $clothOrders->count() + $vestOrders->count(),
            'cloth_orders' => $clothOrders->count(),
            'vest_orders' => $vestOrders->count(),
            'pending_orders' => $pendingCloth + $pendingVest,
            'completed_orders' => $completedCloth + $completedVest,
        ];
    }

    /**
     * Get recent activity for customer
     */
    private function getRecentActivity($customer)
    {
        // Get cloth orders with created_at
        $clothOrders = $customer->clothMeasurements->map(function ($order) {
            $order->order_type = 'cloth';
            $order->sort_date = $order->created_at;
            return $order;
        });

        // Get vest orders with O_date (since VestM doesn't have created_at)
        $vestOrders = $customer->vestMeasurements->map(function ($order) {
            $order->order_type = 'vest';
            $order->sort_date = $order->O_date ? \Carbon\Carbon::parse($order->O_date) : now();
            return $order;
        });

        $recentOrders = $clothOrders->concat($vestOrders)
            ->sortByDesc('sort_date')
            ->take(5);

        $recentPayments = $customer->customerPayments
            ->sortByDesc('payment_date')
            ->take(5);

        return [
            'recent_orders' => $recentOrders,
            'recent_payments' => $recentPayments,
        ];
    }

    /**
     * Calculate combined financial summary for multiple customers
     */
    private function calculateCombinedFinancialSummary($customers)
    {
        $totalClothRate = 0;
        $totalVestRate = 0;
        $totalPaid = 0;

        foreach ($customers as $customer) {
            $totalClothRate += $customer->clothMeasurements->sum('cloth_rate');
            $totalVestRate += $customer->vestMeasurements->sum('vest_rate');
            $totalPaid += $customer->customerPayments->sum('amount');
        }

        $totalOrderValue = $totalClothRate + $totalVestRate;
        $remainingBalance = $totalOrderValue - $totalPaid;

        return [
            'total_order_value' => $totalOrderValue,
            'total_paid' => $totalPaid,
            'remaining_balance' => $remainingBalance,
            'cloth_total' => $totalClothRate,
            'vest_total' => $totalVestRate,
        ];
    }

    /**
     * Get combined order statistics for multiple customers
     */
    private function getCombinedOrderStats($customers)
    {
        $totalClothOrders = 0;
        $totalVestOrders = 0;
        $totalPendingOrders = 0;
        $totalCompletedOrders = 0;

        foreach ($customers as $customer) {
            $clothOrders = $customer->clothMeasurements;
            $vestOrders = $customer->vestMeasurements;
            
            $totalClothOrders += $clothOrders->count();
            $totalVestOrders += $vestOrders->count();
            
            // Count pending orders (cloth uses 'order_status', vest uses 'Status')
            $totalPendingOrders += $clothOrders->whereIn('order_status', ['pending', 'in_progress'])->count();
            $totalPendingOrders += $vestOrders->whereIn('Status', ['pending', 'in_progress'])->count();
            
            // Count completed orders
            $totalCompletedOrders += $clothOrders->where('order_status', 'complete')->count();
            $totalCompletedOrders += $vestOrders->where('Status', 'complete')->count();
        }

        return [
            'total_orders' => $totalClothOrders + $totalVestOrders,
            'cloth_orders' => $totalClothOrders,
            'vest_orders' => $totalVestOrders,
            'pending_orders' => $totalPendingOrders,
            'completed_orders' => $totalCompletedOrders,
        ];
    }

    /**
     * Get combined recent activity for multiple customers
     */
    private function getCombinedRecentActivity($customers)
    {
        $allClothOrders = collect();
        $allVestOrders = collect();
        $allPayments = collect();

        foreach ($customers as $customer) {
            // Get cloth orders with created_at
            $clothOrders = $customer->clothMeasurements->map(function ($order) use ($customer) {
                $order->order_type = 'cloth';
                $order->sort_date = $order->created_at;
                $order->customer_name = $customer->cus_name;
                $order->customer_id = $customer->cus_id;
                return $order;
            });

            // Get vest orders with O_date (since VestM doesn't have created_at)
            $vestOrders = $customer->vestMeasurements->map(function ($order) use ($customer) {
                $order->order_type = 'vest';
                $order->sort_date = $order->O_date ? \Carbon\Carbon::parse($order->O_date) : now();
                $order->customer_name = $customer->cus_name;
                $order->customer_id = $customer->cus_id;
                return $order;
            });

            // Get payments with customer info
            $payments = $customer->customerPayments->map(function ($payment) use ($customer) {
                $payment->customer_name = $customer->cus_name;
                $payment->customer_id = $customer->cus_id;
                return $payment;
            });

            $allClothOrders = $allClothOrders->concat($clothOrders);
            $allVestOrders = $allVestOrders->concat($vestOrders);
            $allPayments = $allPayments->concat($payments);
        }

        $recentOrders = $allClothOrders->concat($allVestOrders)
            ->sortByDesc('sort_date')
            ->take(10);

        $recentPayments = $allPayments
            ->sortByDesc('payment_date')
            ->take(10);

        return [
            'recent_orders' => $recentOrders,
            'recent_payments' => $recentPayments,
        ];
    }

    /**
     * Get cloth measurement details by ID
     */
    public function getClothMeasurementDetails($id)
    {
        try {
            $measurement = \App\Models\ClothM::with(['customer'])->find($id);
            
            if (!$measurement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cloth measurement not found'
                ], 404);
            }

            // Add customer name to the measurement data
            $measurement->customer_name = $measurement->customer ? $measurement->customer->cus_name : 'Unknown Customer';

            return response()->json([
                'success' => true,
                'measurement' => $measurement
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cloth measurement details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get vest measurement details by ID
     */
    public function getVestMeasurementDetails($id)
    {
        try {
            $measurement = \App\Models\VestM::with(['customer'])->find($id);
            
            if (!$measurement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vest measurement not found'
                ], 404);
            }

            // Add customer name to the measurement data
            $measurement->customer_name = $measurement->customer ? $measurement->customer->cus_name : 'Unknown Customer';

            return response()->json([
                'success' => true,
                'measurement' => $measurement
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching vest measurement details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getClothMeasurementInfo($id)
    {
        dd($id);
    }

    /**
     * Handle sending cloth details
     */
    public function sendClothDetails(Request $request)
    {
        // dd($request);
        $selected_ids = $request->input('cloth_ids', []);

        if (empty($selected_ids)) {
            return redirect()->back()->with('error', 'No cloth orders selected.');
        }

        // Use Eloquent models to get the selected cloth data with relationships
        $selectedData = ClothM::with(['customer', 'customer.phone'])
            ->whereIn('cm_id', $selected_ids)
            ->get();

        // Pass the selected data to the view
        return view('search.Cloth_create', [
            'selectedData' => $selectedData,
            'success' => count($selectedData) . ' cloth orders selected successfully.'
        ]);
    }
    

    /**
     * Handle sending vest details
     */
    public function sendVestDetails(Request $request)
    {
        // dd($request);
        $selected_ids = $request->input('vest_ids', []);

        if (empty($selected_ids)) {
            return redirect()->back()->with('error', 'No vest orders selected.');
        }

        // Use Eloquent models to get the selected vest data with relationships
        $selectedData = VestM::with(['customer', 'customer.phone'])
            ->whereIn('V_M_ID', $selected_ids)
            ->get();

        // Pass the selected data to the view (same as cloth method)
        return view('search.Vest_create', [
            'selectedData' => $selectedData,
            'success' => count($selectedData) . ' vest orders selected successfully.'
        ]);
    }
    

}
