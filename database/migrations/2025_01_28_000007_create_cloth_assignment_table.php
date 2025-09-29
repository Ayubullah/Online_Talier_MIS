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
        Schema::create('cloth_assignment', function (Blueprint $table) {
            $table->id('ca_id');
            $table->unsignedBigInteger('F_cm_id')->nullable();
            $table->unsignedBigInteger('F_vm_id')->nullable();
            $table->unsignedBigInteger('F_emp_id');
            $table->enum('work_type', ['cutting', 'salaye']);
            $table->integer('qty')->default(1);
            $table->decimal('rate_at_assign', 10, 2);
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->datetime('assigned_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('completed_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('F_cm_id')
                  ->references('cm_id')
                  ->on('cloth_m')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('F_vm_id')
                  ->references('V_M_ID')
                  ->on('vest_m')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('F_emp_id')
                  ->references('emp_id')
                  ->on('employee')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
        });

        // Add CHECK constraint after table creation (MySQL 8.0.16+ supports CHECK constraints)
        try {
            DB::statement('ALTER TABLE cloth_assignment ADD CONSTRAINT chk_assignment_type CHECK ((F_cm_id IS NOT NULL AND F_vm_id IS NULL) OR (F_cm_id IS NULL AND F_vm_id IS NOT NULL))');
        } catch (\Exception $e) {
            // Ignore if CHECK constraints are not supported in this MySQL version
            \Log::info('CHECK constraint not supported or failed to create: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloth_assignment');
    }
};
