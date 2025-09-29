<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Phone;
use App\Models\InvoiceTb;
use App\Models\Customer;
use App\Models\ClothM;
use App\Models\VestM;
use App\Models\ClothAssignment;
use App\Models\Payment;

class TailoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@tailoring.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $employeeUser = User::create([
            'name' => 'John Cutter',
            'email' => 'john@tailoring.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create sample employees
        $employee1 = Employee::create([
            'emp_name' => 'Ahmad Khan',
            'role' => 'cutter_l',
            'base_rate' => 150.00,
            'user_id' => $employeeUser->id,
        ]);

        $employee2 = Employee::create([
            'emp_name' => 'Bilal Ahmed',
            'role' => 'salaye_s',
            'base_rate' => 120.00,
        ]);

        $employee3 = Employee::create([
            'emp_name' => 'Rashid Ali',
            'role' => 'cutter_s',
            'base_rate' => 130.00,
        ]);

        // Create sample phones
        $phone1 = Phone::create(['pho_no' => '+93701234567']);
        $phone2 = Phone::create(['pho_no' => '+93709876543']);
        $phone3 = Phone::create(['pho_no' => '+93705555555']);

        // Create sample invoices
        $invoice1 = InvoiceTb::create([
            'inc_date' => now()->subDays(5),
            'total_amt' => 2500.00,
            'status' => 'partial',
        ]);

        $invoice2 = InvoiceTb::create([
            'inc_date' => now()->subDays(2),
            'total_amt' => 1800.00,
            'status' => 'unpaid',
        ]);

        $invoice3 = InvoiceTb::create([
            'inc_date' => now()->subDays(10),
            'total_amt' => 3200.00,
            'status' => 'paid',
        ]);

        // Create sample customers
        $customer1 = Customer::create([
            'cus_name' => 'Mohammad Tariq',
            'F_pho_id' => $phone1->pho_id,
            'F_inv_id' => $invoice1->inc_id,
        ]);

        $customer2 = Customer::create([
            'cus_name' => 'Abdul Rahman',
            'F_pho_id' => $phone2->pho_id,
            'F_inv_id' => $invoice2->inc_id,
        ]);

        $customer3 = Customer::create([
            'cus_name' => 'Nasir Ahmad',
            'F_pho_id' => $phone3->pho_id,
            'F_inv_id' => $invoice3->inc_id,
        ]);

        // Create sample cloth measurements
        $cloth1 = ClothM::create([
            'F_cus_id' => $customer1->cus_id,
            'size' => 'L',
            'cloth_rate' => 1500.00,
            'order_status' => 'pending',
            'Height' => '5.8',
            'chati' => '42',
            'Sleeve' => 24,
            'Shoulder' => 18,
            'Collar' => '15.5',
            'Armpit' => '22',
            'Skirt' => '28',
            'Trousers' => '40',
            'Kaff' => '9',
            'Pacha' => '12',
            'sleeve_type' => 'Regular',
            'Kalar' => '16',
            'Shalwar' => '42',
            'Yakhan' => '8',
            'Daman' => '45',
            'Jeb' => 'Side pockets with button',
            'O_date' => now()->subDays(5),
            'R_date' => now()->addDays(7),
        ]);

        $cloth2 = ClothM::create([
            'F_cus_id' => $customer2->cus_id,
            'size' => 'S',
            'cloth_rate' => 1200.00,
            'order_status' => 'complete',
            'Height' => '5.6',
            'chati' => '38',
            'Sleeve' => 22,
            'Shoulder' => 16,
            'Collar' => '15',
            'Armpit' => '20',
            'Skirt' => '26',
            'Trousers' => '38',
            'O_date' => now()->subDays(15),
            'R_date' => now()->subDays(3),
        ]);

        // Create sample vest measurements
        $vest1 = VestM::create([
            'F_cus_id' => $customer1->cus_id,
            'size' => 'L',
            'vest_rate' => 800.00,
            'Height' => '5.8',
            'Shoulder' => '18',
            'Armpit' => '22',
            'Waist' => '36',
            'Shana' => '20',
            'Kalar' => '16',
            'Daman' => '28',
            'NawaWaskat' => '24',
            'Status' => 'In Progress',
            'O_date' => now()->subDays(3),
            'R_date' => now()->addDays(5),
        ]);

        $vest2 = VestM::create([
            'F_cus_id' => $customer3->cus_id,
            'size' => 'L',
            'vest_rate' => 900.00,
            'Height' => '6.0',
            'Shoulder' => '19',
            'Armpit' => '24',
            'Waist' => '38',
            'Status' => 'Completed',
            'O_date' => now()->subDays(20),
            'R_date' => now()->subDays(10),
        ]);

        // Create sample cloth assignments
        $assignment1 = ClothAssignment::create([
            'F_cm_id' => $cloth1->cm_id,
            'F_emp_id' => $employee1->emp_id,
            'work_type' => 'cutting',
            'qty' => 1,
            'rate_at_assign' => 150.00,
            'status' => 'pending',
            'assigned_at' => now()->subDays(4),
        ]);

        $assignment2 = ClothAssignment::create([
            'F_cm_id' => $cloth2->cm_id,
            'F_emp_id' => $employee2->emp_id,
            'work_type' => 'salaye',
            'qty' => 1,
            'rate_at_assign' => 120.00,
            'status' => 'complete',
            'assigned_at' => now()->subDays(10),
            'completed_at' => now()->subDays(5),
        ]);

        $assignment3 = ClothAssignment::create([
            'F_vm_id' => $vest1->V_M_ID,
            'F_emp_id' => $employee3->emp_id,
            'work_type' => 'cutting',
            'qty' => 1,
            'rate_at_assign' => 130.00,
            'status' => 'pending',
            'assigned_at' => now()->subDays(2),
        ]);

        // Create sample payments
        Payment::create([
            'F_inc_id' => $invoice1->inc_id,
            'amount' => 1000.00,
            'method' => 'cash',
            'note' => 'Partial payment received',
            'paid_at' => now()->subDays(3),
        ]);

        Payment::create([
            'F_inc_id' => $invoice3->inc_id,
            'amount' => 3200.00,
            'method' => 'bank',
            'note' => 'Full payment via bank transfer',
            'paid_at' => now()->subDays(8),
        ]);

        Payment::create([
            'F_emp_id' => $employee2->emp_id,
            'amount' => 120.00,
            'method' => 'cash',
            'note' => 'Payment for completed salaye work',
            'paid_at' => now()->subDays(4),
        ]);

        $this->command->info('Tailoring sample data seeded successfully!');
    }
}
