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
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_period_id')->constrained('payroll_periods')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('payroll_concept_id')->constrained('payroll_concepts')->onDelete('restrict');
            // Valores
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_value', 12, 2);
            $table->decimal('amount', 12, 2)->storedAs('quantity * unit_value');
            
            // Información adicional
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['payroll_period_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_details');
    }
};
