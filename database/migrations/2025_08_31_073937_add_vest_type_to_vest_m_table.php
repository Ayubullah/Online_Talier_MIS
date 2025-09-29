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
        Schema::table('vest_m', function (Blueprint $table) {
            $table->string('Vest_Type', 50)->nullable()->after('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vest_m', function (Blueprint $table) {
            $table->dropColumn('Vest_Type');
        });
    }
};
