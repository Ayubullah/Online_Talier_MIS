<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class LinkUsersToEmployees extends Command
{
    protected $signature = 'users:link-to-employees';
    protected $description = 'Link existing users to employees and assign default images';

    public function handle()
    {
        $this->info('Linking users to employees...');

        // Get all users that don't have associated employees
        $users = User::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('employees')
                  ->whereRaw('employees.user_id = users.id');
        })->get();

        $this->info("Found {$users->count()} users without employee records");

        foreach ($users as $user) {
            // Check if an employee record already exists for this user
            $existingEmployee = Employee::where('user_id', $user->id)->first();
            
            if (!$existingEmployee) {
                // Create employee record
                $employee = Employee::create([
                    'user_id' => $user->id,
                    'emp_image' => null, // No image for now
                ]);
                
                $this->info("Created employee record for user: {$user->name} (ID: {$user->id})");
            } else {
                $this->info("Employee record already exists for user: {$user->name} (ID: {$user->id})");
            }
        }

        // Fix image paths for existing employees
        $employees = Employee::whereNotNull('emp_image')->get();
        $fixedCount = 0;

        foreach ($employees as $employee) {
            $imagePath = $employee->emp_image;
            
            // If the path contains 'uploads/employees/', extract just the filename
            if (strpos($imagePath, 'uploads/employees/') === 0) {
                $filename = str_replace('uploads/employees/', '', $imagePath);
                $employee->update(['emp_image' => $filename]);
                $fixedCount++;
                $this->info("Fixed image path for employee ID {$employee->Emp_ID}: {$filename}");
            }
        }

        $this->info("Fixed {$fixedCount} image paths");
        $this->info('Linking completed successfully!');
    }
}
