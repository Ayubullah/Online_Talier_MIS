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
        Schema::table('cloth_m', function (Blueprint $table) {
            $table->string('size_kaf', 10)->nullable()->after('Kaff');
            $table->string('size_sleve', 10)->nullable()->after('sleeve_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cloth_m', function (Blueprint $table) {
            $table->dropColumn(['size_kaf', 'size_sleve']);
        });
    }
};
