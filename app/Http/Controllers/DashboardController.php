<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\ClothM;
use App\Models\VestM;
use App\Models\ClothAssignment;
use App\Models\Employee;
use App\Models\InvoiceTb;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Redirect based on user role
        if ($user->role === 'user') {
            return redirect()->route('user.dashboard');
        }
        
        // Get current month and previous month for comparison
        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();
        
        // Customer statistics
        $usersCount = Customer::count();
        $usersChange = $this->calculatePercentageChange(
            Customer::whereMonth('created_at', $previousMonth->month)->count(),
            Customer::whereMonth('created_at', $currentMonth->month)->count()
        );
        
        // Order statistics
        $clothOrders = ClothM::count();
        $vestOrders = VestM::count();
        $ordersCount = $clothOrders + $vestOrders;
        $ordersChange = $this->calculatePercentageChange(
            ClothM::whereMonth('created_at', $previousMonth->month)->count() + 
            VestM::whereMonth('created_at', $previousMonth->month)->count(),
            ClothM::whereMonth('created_at', $currentMonth->month)->count() + 
            VestM::whereMonth('created_at', $currentMonth->month)->count()
        );
        
        // Revenue statistics
        $clothRevenue = ClothM::sum('cloth_rate');
        $vestRevenue = VestM::sum('vest_rate');
        $revenue = $clothRevenue + $vestRevenue;
        $revenueChange = $this->calculatePercentageChange(
            ClothM::whereMonth('created_at', $previousMonth->month)->sum('cloth_rate') + 
            VestM::whereMonth('created_at', $previousMonth->month)->sum('vest_rate'),
            ClothM::whereMonth('created_at', $currentMonth->month)->sum('cloth_rate') + 
            VestM::whereMonth('created_at', $currentMonth->month)->sum('vest_rate')
        );
        
        // Profit calculation (simplified - you can adjust based on your business logic)
        $profit = $revenue * 0.3; // Assuming 30% profit margin
        $profitChange = $revenueChange; // Simplified for now
        
        // Employee statistics
        $totalEmployees = Employee::count();
        $cutterEmployees = Employee::where('role', 'cutter')->count();
        $salayeEmployees = Employee::where('role', 'salaye')->count();
        
        // Assignment statistics
        $pendingAssignments = ClothAssignment::where('status', 'pending')->count();
        $completedAssignments = ClothAssignment::where('status', 'completed')->count();
        
        // Recent activities
        $recentCustomers = Customer::latest()->take(5)->get();
        $recentClothOrders = ClothM::with('customer')->latest()->take(5)->get();
        $recentVestOrders = VestM::with('customer')->latest()->take(5)->get();
        
        // Monthly trends for charts
        $monthlyData = $this->getMonthlyTrends();
        
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'user_is_admin' => $user ? $user->isAdmin() : false,
            'user_has_employee' => $user ? $user->hasEmployeeRecord() : false,
            'user_employee_role' => $user ? $user->getEmployeeRole() : null,
        ];

        return view('dashboard.index', compact(
            'stats',
            'usersCount',
            'usersChange',
            'ordersCount',
            'ordersChange',
            'revenue',
            'revenueChange',
            'profit',
            'profitChange',
            'totalEmployees',
            'cutterEmployees',
            'salayeEmployees',
            'pendingAssignments',
            'completedAssignments',
            'recentCustomers',
            'recentClothOrders',
            'recentVestOrders',
            'monthlyData'
        ));
    }
    
    /**
     * Calculate percentage change between two values
     */
    private function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }
        
        return round((($newValue - $oldValue) / $oldValue) * 100, 1);
    }
    
    /**
     * Get monthly trends for charts
     */
    private function getMonthlyTrends()
    {
        $months = [];
        $clothData = [];
        $vestData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');
            
            $clothData[] = ClothM::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('cloth_rate');
                
            $vestData[] = VestM::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('vest_rate');
        }
        
        return [
            'months' => $months,
            'clothData' => $clothData,
            'vestData' => $vestData
        ];
    }
}
