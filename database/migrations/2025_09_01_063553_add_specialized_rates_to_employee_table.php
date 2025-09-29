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
            // Add specialized rates for cutter roles
            $table->decimal('cutter_s_rate', 10, 2)->nullable()->after('base_rate');
            $table->decimal('cutter_l_rate', 10, 2)->nullable()->after('cutter_s_rate');
            
            // Add salary rate for salary employees
            $table->decimal('salary_rate', 10, 2)->nullable()->after('cutter_l_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropColumn(['cutter_s_rate', 'cutter_l_rate', 'salary_rate']);
        });
    }
};
