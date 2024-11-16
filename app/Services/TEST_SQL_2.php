<?php 
public function connection($ip,$database,$tabla)
{       // Configuración de conexión dinámica
   $serverName = "{$ip}\\NATIONALSOFT";
   $connectionInfo = [
        "Database" => $database,
        "UID" => "sa",
        "PWD" => "National09",
        "CharacterSet" => "UTF-8" // Define el conjunto de caracteres a UTF-8
    ];
   $conn = sqlsrv_connect($serverName, $connectionInfo);    
   if ($conn) {
            // echo "Connection established.<br />"; 
            // Consulta SELECT a la tabla cheques
            $sql = "SELECT * FROM $tabla";
            $stmt = sqlsrv_query($conn, $sql);
    
            if ($stmt === false) {
                echo "Error in query execution.<br />";
                die(print_r(sqlsrv_errors(), true));
            }
        // Mostrar resultados de la consulta
        $results = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $results[] = $row; // Agregar to¡da la fila al array de resultados
            }
    
        // Liberar el recurso y cerrar la conexión
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conn);
    
            return response()->json($results);

        } else {
            echo "Connection could not be established.<br />";
            die(print_r(sqlsrv_errors(), true));
    }

}


}

