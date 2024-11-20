<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatabaseService
{
    public function ejecutarConsultaDinamica($ip, $database, $tabla, $columnas = ['*'])
    {
    //     $serverName = "{$ip}\\NATIONALSOFT";

    //     $connectionInfo = [
    //         'driver' => 'sqlsrv',
    //         'host' => $serverName,
    //         'port' => '1433',
    //         'database' => $database,
    //         'username' => 'sa',
    //         'password' => 'National09',
    //         'charset' => 'utf8',
    //         'prefix' => '',
    //         'options' => [
    //             'CharacterSet' => 'UTF-8',
    //         ],
    //     ];

    //     // Configurar la conexión en tiempo de ejecución
    //     config(['database.connections.sqlsrv' => $connectionInfo]);

    //     try {
    //         // Realizar la consulta en la conexión dinámica
    //         $results = DB::connection('sqlsrv')->table($tabla)->select($columnas)->get();

    //         // Devolver los resultados en formato JSON
    //         return $results;

    //     } catch (\Exception $e) {
    //         return [
    //             'error' => 'Error en la conexión o consulta',
    //             'message' => $e->getMessage()
    //         ];
    //     } finally {
    //         DB::disconnect('sqlsrv');
    //     }
    // }
    $serverName = "{$ip}\\NATIONALSOFT"; // Usar "server\\instancia" para instancias nombradas
         $connectionInfo = [
             "Database" => $database,
             "UID" => "sa",
             "PWD" => "National09",
             "CharacterSet" => "UTF-8",
             "TrustServerCertificate" => true
         ];
        $conn = sqlsrv_connect($serverName, $connectionInfo); 
        if ($conn === false) {
            echo "Connection could not be established.<br />";
            die(print_r(sqlsrv_errors(), true));
        }
    
        try {
            $columnasSeleccionadas = $columnas === ['*'] ? '*' : implode(', ', $columnas);
            $sql = "SELECT $columnasSeleccionadas FROM $tabla";
            $stmt = sqlsrv_query($conn, $sql);

             if ($stmt === false) {
                echo "Error in query execution.<br />";
                die(print_r(sqlsrv_errors(), true));
            }
            $results = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[] = $row; // Agregar to¡da la fila al array de resultados
            }
              // Liberar el recurso y cerrar la conexión
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conn);
            // Devolver los resultados en formato JSON
            return $results;

        } catch (\Exception $e) {
           // Manejo de errores
            return response()->json([
                'error' => 'Error en la conexión o consulta',
                'message' => $e->getMessage()
            ], 500);
        }

        //if ($conn) {
        //     // echo "Connection established.<br />"; 
        //     // Consulta SELECT a la tabla cheques
        //     $sql = "SELECT * FROM $tabla";
        //     $stmt = sqlsrv_query($conn, $sql);
    
        //     if ($stmt === false) {
        //         echo "Error in query execution.<br />";
        //         die(print_r(sqlsrv_errors(), true));
        //     }
        // // Mostrar resultados de la consulta
        // $results = [];
        //     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        //         $results[] = $row; // Agregar to¡da la fila al array de resultados
        //     }
    
        // // Liberar el recurso y cerrar la conexión
        //     sqlsrv_free_stmt($stmt);
        //     sqlsrv_close($conn);
    
        //     return response()->json($results);

        // } else {
        //     echo "Connection could not be established.<br />";
        //         die(print_r(sqlsrv_errors(), true));
        // }
    }
}
