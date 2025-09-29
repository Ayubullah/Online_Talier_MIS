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
            // Add specialized rates for salaye roles
            $table->decimal('salaye_s_rate', 10, 2)->nullable()->after('salary_rate');
            $table->decimal('salaye_l_rate', 10, 2)->nullable()->after('salaye_s_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropColumn(['salaye_s_rate', 'salaye_l_rate']);
        });
    }
};
