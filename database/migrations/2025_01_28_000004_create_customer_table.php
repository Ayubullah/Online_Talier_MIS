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
        Schema::create('customer', function (Blueprint $table) {
            $table->id('cus_id');
            $table->string('cus_name', 50);
            $table->unsignedBigInteger('F_pho_id')->nullable();
            $table->unsignedBigInteger('F_inv_id')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('F_pho_id')
                  ->references('pho_id')
                  ->on('phone')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('F_inv_id')
                  ->references('inc_id')
                  ->on('invoice_tb')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
