<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            // Drop the old enum column
            $table->dropColumn('role');
        });

        Schema::table('employee', function (Blueprint $table) {
            // Add the new role column with correct enum values
            $table->enum('role', ['cutter', 'salaye'])->after('emp_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            // Drop the new role column
            $table->dropColumn('role');
        });

        Schema::table('employee', function (Blueprint $table) {
            // Restore the old role column
            $table->enum('role', ['cutter_s', 'cutter_l', 'salaye_s', 'salaye_l'])->after('emp_name');
        });
    }
};
