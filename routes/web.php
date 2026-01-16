<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VestController;
use App\Http\Controllers\ClothMController;
use App\Http\Controllers\VestMController;
use App\Http\Controllers\ClothAssignmentController;
use App\Http\Controllers\VestAssignmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\EmployeeDetailsController;
use App\Http\Controllers\OnlineEmployeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Locale switcher (available to all users)
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fa', 'ps'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang');

// Dashboard route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Profile routes for all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ---------------------------------------- Admin Routes ---------------------------------------- 
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Employee management (admin only)
    Route::resource('employees', EmployeeController::class);
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Employee details and search (admin only)
    Route::get('admin-employee-details', [EmployeeDetailsController::class, 'index'])->name('employee-details.index');
    Route::get('admin-employee-details/search', [EmployeeDetailsController::class, 'search'])->name('employee-details.search');
    Route::get('admin-employee-details/{id}', [EmployeeDetailsController::class, 'show'])->name('employee-details.show');
    Route::get('admin-employee-details/{id}/assignments', [EmployeeDetailsController::class, 'assignments'])->name('employee-details.assignments');
    Route::get('admin-employee-details/{id}/payments', [EmployeeDetailsController::class, 'payments'])->name('employee-details.payments');
    
    // Customer management
    Route::resource('customers', CustomerController::class);
    Route::get('customers/print/{invoiceId}', [CustomerController::class, 'printInvoice'])->name('customers.print');
    Route::get('customers/print-size/{cmId}', [CustomerController::class, 'printSize'])->name('customers.print-size');
    Route::get('customers/search-by-phone', [CustomerController::class, 'searchByPhone'])->name('customers.search-by-phone');
    
    // Customer Payment management
    Route::get('/customer-payments', [App\Http\Controllers\CustomerPaymentController::class, 'index'])->name('customer-payments.index');
    Route::get('/customer-payments/create', [App\Http\Controllers\CustomerPaymentController::class, 'create'])->name('customer-payments.create');
    Route::post('/customer-payments', [App\Http\Controllers\CustomerPaymentController::class, 'store'])->name('customer-payments.store');
    Route::get('/customer-payments/{customerPayment}', [App\Http\Controllers\CustomerPaymentController::class, 'show'])->name('customer-payments.show');
    Route::get('/customer-payments/{customerPayment}/edit', [App\Http\Controllers\CustomerPaymentController::class, 'edit'])->name('customer-payments.edit');
    Route::put('/customer-payments/{customerPayment}', [App\Http\Controllers\CustomerPaymentController::class, 'update'])->name('customer-payments.update');
    Route::delete('/customer-payments/{customerPayment}', [App\Http\Controllers\CustomerPaymentController::class, 'destroy'])->name('customer-payments.destroy');
    Route::get('/customer-payments/search-by-phone', [App\Http\Controllers\CustomerPaymentController::class, 'searchByPhone'])->name('customer-payments.search-by-phone');
    
    // Search functionality
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
    Route::get('/search/by-phone', [App\Http\Controllers\SearchController::class, 'searchByPhone'])->name('search.by-phone');
    Route::get('/search/phone/{phoneNumber}', [App\Http\Controllers\SearchController::class, 'show'])->name('search.show');
    Route::post('/search/insert-orders', [App\Http\Controllers\SearchController::class, 'insertOrders'])->name('search.insert-orders');
    Route::post('/search/send-cloth-details', [App\Http\Controllers\SearchController::class, 'sendClothDetails'])->name('search.send-cloth-details');
    Route::post('/search/send-vest-details', [App\Http\Controllers\SearchController::class, 'sendVestDetails'])->name('search.send-vest-details');
    Route::get('/cloth/create', function() {
        return view('search.Cloth_create');
    })->name('cloth.create');

    Route::get('/vest/create', function() {
        return view('search.Vest_create');
    })->name('vests.create');
    
    // Vest management
    Route::get('vests/print/{invoiceId}', [VestController::class, 'printInvoice'])->name('vests.print');
    Route::get('vests/print-size/{vestId}', [VestController::class, 'printSize'])->name('vests.print-size');
    Route::resource('vests', VestController::class);
    
    // Cloth management (similar to vests)
    Route::get('cloth/print/{invoiceId}', [ClothMController::class, 'printInvoice'])->name('cloth.print');
    Route::get('cloth/print-size/{clothId}', [ClothMController::class, 'printSize'])->name('cloth.print-size');
    Route::resource('cloth', ClothMController::class);
    
    // Cloth measurements (keep for backward compatibility)
    Route::resource('cloth-measurements', ClothMController::class);
    
    // Cloth assignments
    Route::get('cloth-assignments/pending', [ClothAssignmentController::class, 'pending'])->name('cloth-assignments.pending');
    Route::get('cloth-assignments/complete', [ClothAssignmentController::class, 'complete'])->name('cloth-assignments.complete-view');
    Route::resource('cloth-assignments', ClothAssignmentController::class);
    Route::patch('cloth-assignments/{clothAssignment}/complete', [ClothAssignmentController::class, 'markComplete'])
        ->name('cloth-assignments.complete');
    
    // Vest assignments
    Route::get('vest-assignments/pending', [VestAssignmentController::class, 'pending'])->name('vest-assignments.pending');
    Route::get('vest-assignments/complete', [VestAssignmentController::class, 'complete'])->name('vest-assignments.complete-view');
    Route::resource('vest-assignments', VestAssignmentController::class);
    Route::patch('vest-assignments/{vestAssignment}/complete', [VestAssignmentController::class, 'markComplete'])
        ->name('vest-assignments.complete');
    
    // Admin Status Management
    Route::get('admin/status', [App\Http\Controllers\AdminStatusController::class, 'index'])->name('admin.status.index');
    Route::post('admin/status/search', [App\Http\Controllers\AdminStatusController::class, 'search'])->name('admin.status.search');
    Route::patch('admin/status/update-cloth/{id}', [App\Http\Controllers\AdminStatusController::class, 'updateClothStatus'])->name('admin.status.update.cloth');
    Route::patch('admin/status/update-vest/{id}', [App\Http\Controllers\AdminStatusController::class, 'updateVestStatus'])->name('admin.status.update.vest');

    // Invoice management (admin only)
    Route::resource('invoices', InvoiceController::class);
    
    // Payment management (admin only)
    Route::resource('payments', PaymentController::class);
    Route::get('payments/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');
    
    // Payment Report (admin only)
    Route::get('payment-reports', [App\Http\Controllers\PaymentReportController::class, 'index'])->name('payment-reports.index');
    
    // Settings management (admin only)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/backup-database', [SettingsController::class, 'backupDatabase'])->name('settings.backup-database');
    Route::get('/settings/backup-history', [SettingsController::class, 'backupHistory'])->name('settings.backup-history');
    Route::get('/settings/download-backup/{filename}', [SettingsController::class, 'downloadBackup'])->name('settings.download-backup');
    Route::delete('/settings/delete-backup/{filename}', [SettingsController::class, 'deleteBackup'])->name('settings.delete-backup');
    Route::post('/settings/upload-backup', [SettingsController::class, 'uploadBackup'])->name('settings.upload-backup');
    Route::post('/settings/restore-backup', [SettingsController::class, 'restoreBackup'])->name('settings.restore-backup');
    Route::post('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('/settings/optimize-app', [SettingsController::class, 'optimizeApp'])->name('settings.optimize-app');
});
// ---------------------------------------- Admin Routes end ---------------------------------------- 


// ---------------------------------------- User Routes ----------------------------------------
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('employee-details', [OnlineEmployeController::class, 'index'])->name('online-employee-details.index');
    
    // Size information pages
    Route::get('employee-details/cloth-size/{id}', [OnlineEmployeController::class, 'showClothSize'])->name('online-employee-details.cloth-size');
    Route::get('employee-details/vest-size/{id}', [OnlineEmployeController::class, 'showVestSize'])->name('online-employee-details.vest-size');
    
    // Assignment completion routes
    Route::patch('employee-details/complete-assignment/{measure_id}', [OnlineEmployeController::class, 'completeAssignment'])->name('online-employee-details.complete-assignment');
    Route::patch('employee-details/complete-vest-assignment/{measure_id}', [OnlineEmployeController::class, 'completeVestAssignment'])->name('online-employee-details.complete-vest-assignment');
    
    // Transactions route for user
    Route::get('/transactions', [App\Http\Controllers\OnlineEmployeController::class, 'transactions'])->name('transactions.index');

});
// ---------------------------------------- User Routes end ---------------------------------------- 
// Business resource routes (authenticated users)


// API routes for measurement details
Route::get('/api/cloth-measurement/{id}', [App\Http\Controllers\SearchController::class, 'getClothMeasurementDetails']);
Route::get('/api/vest-measurement/{id}', [App\Http\Controllers\SearchController::class, 'getVestMeasurementDetails']);


require __DIR__.'/auth.php';
