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
        Schema::create('vest_m', function (Blueprint $table) {
            $table->id('V_M_ID');
            $table->unsignedBigInteger('F_cus_id');
            $table->enum('size', ['S', 'L']);
            $table->decimal('vest_rate', 10, 2);

            // Measurement fields
            $table->string('Height', 50)->nullable();
            $table->string('Shoulder', 50)->nullable();
            $table->string('Armpit', 50)->nullable();
            $table->string('Waist', 20)->nullable();
            $table->string('Shana', 50)->nullable();
            $table->string('Kalar', 50)->nullable();
            $table->string('Daman', 50)->nullable();
            $table->string('NawaWaskat', 50)->nullable();

            $table->string('Status', 50)->nullable();
            $table->date('O_date')->nullable();
            $table->date('R_date')->nullable();
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();

            // Foreign key
            $table->foreign('F_cus_id')
                  ->references('cus_id')
                  ->on('customer')
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
        Schema::dropIfExists('vest_m');
    }
};
