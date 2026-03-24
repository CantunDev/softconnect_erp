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
              $table->enum('occupancy_status', [
                'low', 
                'moderate', 
                'high', 
                'full', 
                'closed'
            ])->default('moderate')->after('slug')->comment('Nivel de ocupación actual del restaurante');
            
            $table->integer('total_capacity')->nullable()->after('occupancy_status')->comment('Capacidad total de personas');
            $table->integer('current_occupancy')->default(0)->after('total_capacity')->comment('Ocupación actual');
            
            $table->integer('tables_count')->nullable()->after('current_occupancy')->comment('Número total de mesas');
          // Campos de geolocalización
            $table->string('address')->nullable()->after('tables_count');
            $table->string('city')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
            $table->string('postal_code')->nullable()->after('country');
            $table->decimal('latitude', 10, 8)->nullable()->after('postal_code');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        
            // Campos para reloj checador
            $table->string('timeclock_host')->nullable()->after('longitude')->comment('Host del reloj checador');
            $table->string('timeclock_port')->nullable()->after('timeclock_host')->comment('Puerto del reloj checador');
            $table->string('timeclock_database')->nullable()->after('timeclock_port')->comment('Base de datos del reloj checador');
            $table->string('timeclock_username')->nullable()->after('timeclock_database')->comment('Usuario del reloj checador');
            $table->string('timeclock_password')->nullable()->after('timeclock_username')->comment('Contraseña del reloj checador');
            $table->string('timeclock_type')->nullable()->after('timeclock_password')->comment('Tipo/marca del reloj checador');
            $table->boolean('timeclock_active')->default(false)->after('timeclock_type')->comment('Si el reloj checador está activo');
        
            $table->string('db_port')->nullable()->after('database')->comment('Puerto de base de datos externa');
            $table->string('db_username')->nullable()->after('db_port')->comment('Usuario de base de datos externa');
            $table->string('db_password')->nullable()->after('db_username')->comment('Contraseña de base de datos externa');
            $table->string('db_connection_type')->nullable()->after('db_password')->comment('Tipo de conexión: mysql, pgsql, etc');
        });


        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // Eliminar campos de ocupación
            $table->dropColumn([
                'occupancy_status',
                'total_capacity',
                'current_occupancy',
                'tables_count'
            ]);
            
            // Eliminar campos de geolocalización
            $table->dropColumn([
                'address',
                'city',
                'state',
                'country',
                'postal_code',
                'latitude',
                'longitude'
            ]);
            
            // Eliminar campos de reloj checador
            $table->dropColumn([
                'timeclock_host',
                'timeclock_port',
                'timeclock_database',
                'timeclock_username',
                'timeclock_password',
                'timeclock_type',
                'timeclock_active'
            ]);
            
            // Eliminar campos de base de datos adicional
            $table->dropColumn([
                'db_port',
                'db_username',
                'db_password',
                'db_connection_type'
            ]);
        });
    }
};
