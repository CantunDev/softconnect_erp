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
            $table->foreignId('projection_id')->constrained('projections')->onDelete('cascade');
            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->enum('projection_type', ['revenue', 'customers', 'costs'])->default('revenue');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('deviation', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['draft', 'approved', 'adjusted'])->default('draft');
            $table->date('projection_date')->nullable();
            $table->timestamps();
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
