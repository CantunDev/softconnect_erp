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
        Schema::dropIfExists('providers'); 
        Schema::dropIfExists('expenses'); 
        Schema::dropIfExists('expenses_categories'); 
        Schema::dropIfExists('payment_method'); 
        Schema::dropIfExists('payment_methods'); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
