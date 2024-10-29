<?php

use Illuminate\Database\Eloquent\SoftDeletingScope;
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('folio');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreignId('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->tinyInteger('invoiced');
            $table->string('folio_invoiced');
            $table->foreignId('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->float('subtotal');
            $table->float('tax')->default(0);
            $table->float('discount')->default(0);
            $table->float('amount');
            $table->foreignId('type')->references('id')->on('expenses_categories')->onDelete('cascade');
            $table->foreignId('subtype')->references('id')->on('expenses_categories')->onDelete('cascade');
            $table->foreignId('sub_subtype')->references('id')->on('expenses_categories')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();    
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_expenses');
    }
};
