<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use PDO;

class DynamicConnectionService
{
    public function configureConnection($restaurant)
    {
        $connectionName = "restaurant_{$restaurant->id}";
        $ip = $restaurant->ip ?? env('DEFAULT_SQLSRV_IP', '192.168.193.29');
        $port = 1433; // Puerto predeterminado de SQL Server
        $timeout = 1; // Timeout de 1 segundo para la verificación de puerto

        // Verificar si el puerto está abierto
        if (!$this->isPortOpen($ip, $port, $timeout)) {
            Log::error("El puerto {$port} en el servidor {$ip} no está disponible.");
            return [
                'success' => false,
                // 'message' => "El servidor {$ip} no está disponible en el puerto {$port}.",
                'message' => "El servidor es inaccesible ó se encuentra apagado.",
            ];
        }

        // Si el puerto está abierto, intentar la conexión SQL
        try {
            Config::set("database.connections.{$connectionName}", [
                'driver' => 'sqlsrv',
                'host' => $restaurant->ip ?? env('DEFAULT_SQLSRV_IP', '192.168.193.29\NATIONALSOFT'),
                'database' => $restaurant->database ?? env('DEFAULT_SQLSRV_DATABASE', 'softrestaurant10'),
                'username' => 'sa',
                'password' => 'National09',
                'prefix_indexes' => true,
                'encrypt' => env('DB_ENCRYPT', 'yes'),
                'trust_server_certificate' => env('DB_TRUST_CERTIFICATE', 'true'),
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

    /**
     * Verifica si un puerto está abierto en un servidor.
     *
     * @param string $ip La dirección IP del servidor.
     * @param int $port El puerto a verificar.
     * @param int $timeout El tiempo máximo de espera en segundos.
     * @return bool True si el puerto está abierto, False en caso contrario.
     */
    private function isPortOpen($ip, $port, $timeout)
    {
        $connection = @fsockopen($ip, $port, $errno, $errstr, $timeout);

        if ($connection) {
            fclose($connection);
            return true;
        }

        return false;
    }
}