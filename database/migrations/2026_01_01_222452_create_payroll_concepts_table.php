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
        Schema::create('payroll_concepts', function (Blueprint $table) {
            $table->id();
           $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->text('description')->nullable();
            
            // Tipo de concepto: ingreso o descuento
            $table->enum('type', ['income', 'deduction', 'adjustment'])->default('income');
            
            // Impuestos
            $table->boolean('affects_isr')->default(false);
            $table->boolean('affects_imss')->default(false);
            $table->boolean('is_taxable')->default(false);
            
            $table->boolean('is_mandatory')->default(false);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_concepts');
    }
};
