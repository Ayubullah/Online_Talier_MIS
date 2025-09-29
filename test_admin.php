<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test admin user
$adminUser = App\Models\User::where('email', 'admin@tailoring.com')->first();
echo "Admin User Test:\n";
echo "Name: " . $adminUser->name . "\n";
echo "Email: " . $adminUser->email . "\n";
echo "Is Admin: " . ($adminUser->isAdmin() ? 'Yes' : 'No') . "\n";
echo "Has Employee Record: " . ($adminUser->hasEmployeeRecord() ? 'Yes' : 'No') . "\n";

// Test employee user
$empUser = App\Models\User::where('email', 'john@tailoring.com')->first();
echo "\nEmployee User Test:\n";
echo "Name: " . $empUser->name . "\n";
echo "Email: " . $empUser->email . "\n";
echo "Is Admin: " . ($empUser->isAdmin() ? 'Yes' : 'No') . "\n";
echo "Has Employee Record: " . ($empUser->hasEmployeeRecord() ? 'Yes' : 'No') . "\n";
if ($empUser->hasEmployeeRecord()) {
    echo "Employee Role: " . $empUser->getEmployeeRole() . "\n";
}

echo "\nAdmin Authentication System is working!\n";
