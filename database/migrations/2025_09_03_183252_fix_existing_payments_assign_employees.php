<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the first available employee ID
        $firstEmployee = DB::table('employee')->first();
        
        if ($firstEmployee) {
            // Update all existing payments that have NULL F_emp_id
            DB::table('payment')
                ->whereNull('F_emp_id')
                ->update(['F_emp_id' => $firstEmployee->emp_id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set F_emp_id back to NULL for payments that were updated
        // Note: This will affect all payments, so use with caution
        DB::table('payment')
            ->where('F_emp_id', '>', 0)
            ->update(['F_emp_id' => null]);
    }
};
