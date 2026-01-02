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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('restrict');
            $table->foreignId('position_id')->constrained('positions')->onDelete('restrict');
            
            // Información personal
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('sur_name', 100);
            $table->string('full_name')->storedAs("CONCAT(first_name, ' ', last_name, ' ', sur_name)");
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
             // Información laboral
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->enum('employment_type', ['fixed', 'temporal', 'part-time', 'contractor'])->default('fixed');
            $table->enum('status', ['active', 'inactive', 'suspended', 'terminated', 'on_leave'])->default('active');
            // Datos fiscales y bancarios
            $table->string('imss_number')->nullable()->unique();
            $table->string('rfc')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_clabe')->nullable();
            // Información adicional
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['restaurant_id', 'status']);
            $table->index('hire_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
