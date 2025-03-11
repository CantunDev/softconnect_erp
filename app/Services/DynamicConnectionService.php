<?php
namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DynamicConnectionService
{
    public function configureConnection($restaurant)
    {
        $connectionName = "restaurant_{$restaurant->id}";

        try {
            Config::set("database.connections.{$connectionName}", [
                'driver' => 'sqlsrv',
                'host' => $restaurant->ip ?? env('DEFAULT_SQLSRV_IP', '192.168.193.29\NATIONALSOFT'),
                'database' => $restaurant->database ?? env('DEFAULT_SQLSRV_DATABASE', 'softrestaurant10'),
                'username' => 'sa',
                'password' => 'National09',
                'prefix_indexes' => true,
                'encrypt' => env('DB_ENCRYPT', 'no'),
                'trust_server_certificate' => env('DB_TRUST_CERTIFICATE', 'no'),
                'strict' => false,
            ]);

            DB::purge($connectionName);
            DB::reconnect($connectionName);

            // Verificar si la conexión es válida
            DB::connection($connectionName)->getPdo();

            Log::info("Conexión configurada para el restaurante: {$restaurant->name}");
            return [
                'success' => true,
                'connection' => DB::connection($connectionName),
            ];
        } catch (Exception $e) {
            Log::error("Error al configurar la conexión para el restaurante {$restaurant->name}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => "No se pudo conectar al servidor del restaurante {$restaurant->name}.",
                'error' => $e->getMessage(),
            ];
        }
    }
}