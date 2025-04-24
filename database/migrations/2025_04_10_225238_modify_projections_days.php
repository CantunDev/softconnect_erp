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
        Schema::create('projections_days', function (Blueprint $table) {
            $table->id();
            // 1. Fechas (año, mes, día)
            $table->date('date')->nullable(); // Columna única para fecha completa
            // 2. Relations
            $table->foreignId('projection_id')->constrained('projections')->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // 3. Datos proyectados
            $table->decimal('projected_day_sales', 12, 2)->nullable();
            $table->decimal('actual_day_sales', 12, 2)->nullable();
            $table->decimal('projected_day_costs', 12, 2)->nullable();
            $table->decimal('actual_day_costs', 12, 2)->nullable();
            $table->decimal('projected_day_profit', 12, 2)->nullable();
            $table->decimal('actual_day_profit', 12, 2)->nullable();
            $table->decimal('projected_day_tax', 12, 2)->nullable();
            $table->decimal('actual_day_tax', 12, 2)->nullable();
            $table->decimal('projected_day_check', 12, 2)->nullable();
            $table->decimal('actual_day_check', 12, 2)->nullable();
            // 4. Estado y timestamps
            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');            
            // Índice compuesto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projections_days');
    }
};