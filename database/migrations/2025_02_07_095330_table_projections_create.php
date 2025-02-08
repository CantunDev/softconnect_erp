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
        Schema::create('projections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->integer('year');
            $table->integer('month');
            $table->decimal('projected_sales', 10, 2);
            $table->decimal('actual_sales', 10, 2)->default(0);
            $table->decimal('projected_costs', 10, 2)->default(0);
            $table->decimal('actual_costs', 10, 2)->default(0);
            $table->decimal('projected_profit', 10, 2)->default(0);
            $table->decimal('actual_profit', 10, 2)->default(0);
            $table->integer('projected_tax')->nullable();
            $table->integer('actual_tax')->nullable();
            $table->decimal('projected_check', 10, 2)->default(0);
            $table->decimal('actual_check', 10,2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
