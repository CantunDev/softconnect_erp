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
        Schema::create('payroll_summaries', function (Blueprint $table) {
            $table->id();
         $table->foreignId('payroll_period_id')->constrained('payroll_periods')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            // Días trabajados y conceptos
            $table->integer('working_days')->default(0);
            $table->integer('absences')->default(0);
            $table->integer('permissions')->default(0);
            $table->integer('disabilities')->default(0);
            $table->integer('delays')->default(0);
            $table->integer('holidays')->default(0);
            $table->integer('extra_hours')->default(0);
            $table->integer('double_shifts')->default(0);
            
            // Sumas de ingresos
            $table->decimal('base_salary', 12, 2)->default(0);
            $table->decimal('extra_hours_amount', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('vacation_days_amount', 12, 2)->default(0);
            $table->decimal('other_income', 12, 2)->default(0);
            $table->decimal('total_income', 12, 2)->default(0);
            
            // Descuentos
            $table->decimal('isr_discount', 12, 2)->default(0);
            $table->decimal('imss_discount', 12, 2)->default(0);
            $table->decimal('other_deductions', 12, 2)->default(0);
            $table->decimal('total_deductions', 12, 2)->default(0);
            
            // Total a pagar
            $table->decimal('net_payment', 12, 2)->default(0);
            
            // Método de pago
            $table->enum('payment_method', ['cash', 'transfer', 'check'])->default('transfer');
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['payroll_period_id', 'employee_id']);
            $table->index(['payroll_period_id']);
$table->foreignId('payroll_period_id')->constrained('payroll_periods')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            // Días trabajados y conceptos
            $table->integer('working_days')->default(0);
            $table->integer('absences')->default(0);
            $table->integer('permissions')->default(0);
            $table->integer('disabilities')->default(0);
            $table->integer('delays')->default(0);
            $table->integer('holidays')->default(0);
            $table->integer('extra_hours')->default(0);
            $table->integer('double_shifts')->default(0);
            
            // Sumas de ingresos
            $table->decimal('base_salary', 12, 2)->default(0);
            $table->decimal('extra_hours_amount', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('vacation_days_amount', 12, 2)->default(0);
            $table->decimal('other_income', 12, 2)->default(0);
            $table->decimal('total_income', 12, 2)->default(0);
            
            // Descuentos
            $table->decimal('isr_discount', 12, 2)->default(0);
            $table->decimal('imss_discount', 12, 2)->default(0);
            $table->decimal('other_deductions', 12, 2)->default(0);
            $table->decimal('total_deductions', 12, 2)->default(0);
            
            // Total a pagar
            $table->decimal('net_payment', 12, 2)->default(0);
            
            // Método de pago
            $table->enum('payment_method', ['cash', 'transfer', 'check'])->default('transfer');
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['payroll_period_id', 'employee_id']);
            $table->index(['payroll_period_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_summaries');
    }
};
