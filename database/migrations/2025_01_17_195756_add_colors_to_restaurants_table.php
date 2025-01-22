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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('color_primary', 7)->nullable()->after('name'); // Código hexadecimal del color
            $table->string('color_secondary', 7)->nullable()->after('color_primary');
            $table->string('color_accent', 7)->nullable()->after('color_secondary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['color_primary', 'color_secondary', 'color_accent']);
        });
    }
};
