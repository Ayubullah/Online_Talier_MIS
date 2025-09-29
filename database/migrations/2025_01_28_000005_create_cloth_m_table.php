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
        Schema::create('cloth_m', function (Blueprint $table) {
            $table->id('cm_id');
            $table->unsignedBigInteger('F_cus_id');
            $table->enum('size', ['S', 'L']);
            $table->decimal('cloth_rate', 10, 2);
            $table->enum('order_status', ['pending', 'complete'])->default('pending');
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            // Measurement fields
            $table->string('Height', 10)->nullable();
            $table->string('chati', 255)->nullable();
            $table->integer('Sleeve')->nullable();
            $table->integer('Shoulder')->nullable();
            $table->string('Collar', 15)->nullable();
            $table->string('Armpit', 15)->nullable();
            $table->string('Skirt', 15)->nullable();
            $table->string('Trousers', 15)->nullable();
            $table->string('Kaff', 40)->nullable();
            $table->string('Pacha', 15)->nullable();
            $table->string('sleeve_type', 40)->nullable();
            $table->string('Kalar', 15)->nullable();
            $table->string('Shalwar', 15)->nullable();
            $table->string('Yakhan', 15)->nullable();
            $table->string('Daman', 15)->nullable();
            $table->string('Jeb', 60)->nullable();
            $table->date('O_date')->nullable();
            $table->date('R_date')->nullable();
            
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
        Schema::dropIfExists('cloth_m');
    }
};
