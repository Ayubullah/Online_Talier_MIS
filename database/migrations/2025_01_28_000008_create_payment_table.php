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
        Schema::create('payment', function (Blueprint $table) {
            $table->id('pay_id');
            $table->unsignedBigInteger('F_inc_id')->nullable();
            $table->unsignedBigInteger('F_phone_id')->nullable();
            $table->unsignedBigInteger('F_emp_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'card', 'bank'])->default('cash');
            $table->string('note', 255)->nullable();
            $table->datetime('paid_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            // Foreign keys
            $table->foreign('F_inc_id')
                  ->references('inc_id')
                  ->on('invoice_tb')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('F_emp_id')
                  ->references('emp_id')
                  ->on('employee')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('F_phone_id')
                  ->references('pho_id')
                  ->on('phone')
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
        Schema::dropIfExists('payment');
    }
};
