<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InfoController extends Controller
{
    public function index(Request $request)
    {
        $serverName = "192.168.193.29\\NATIONALSOFT"; // Usa doble barra invertida
        $connectionInfo = [
            "Database" => "softrestaurant10",
            "UID" => "sa",
            "PWD" => "National09",
            "CharacterSet" => "UTF-8",
            "TrustServerCertificate" => true // Desactiva la validación del certificado
        ];

        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if ($conn) {
            echo "Conexión exitosa";
        } else {
            echo "Error en la conexión: ";
            print_r(sqlsrv_errors());
        }
    }
}
