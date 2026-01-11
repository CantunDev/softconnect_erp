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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('birth_place', 255)->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('birth_date');
            $table->string('address', 255)->nullable()->after('gender');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('postal_code', 10)->nullable()->after('state');
            $table->string('country', 100)->default('Mexico')->after('postal_code');
            $table->string('curp', 18)->nullable()->unique()->after('rfc');
            $table->index('birth_date');
            $table->index('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['birth_date']);
            $table->dropIndex(['city']);
            $table->dropColumn([
                'birth_place',
                'birth_date',
                'gender',
                'address',
                'city',
                'state',
                'postal_code',
                'country',
                'curp'
            ]);
        });
    }
};
