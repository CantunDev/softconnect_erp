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
        Schema::create('employee_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            $table->string('field_name');
            $table->text('old_value')->nullable();
            $table->text('new_value');
            $table->enum('change_type', ['position_change', 'salary_change', 'status_change', 'other'])->default('other');
            
            $table->date('effective_date');
            $table->string('changed_by')->nullable();
            $table->text('reason')->nullable();
            
            $table->timestamps();
            
            $table->index(['employee_id', 'effective_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_history');
    }
};
