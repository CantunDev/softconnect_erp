<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InfoController extends Controller
{
    public function index(Request $request)
    {
        
        $serverName = "192.168.193.194\\NATIONALSOFT";
        $connectionInfo = [
            "Database" => "softrestaurant10",
            "UID" => "sa",
            "PWD" => "National09",
            "CharacterSet" => "UTF-8",
            "Encrypt" => false,
            "TrustServerCertificate" => true
        ];
        
        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if (!$conn) {
            echo "Conexión fallida: <br>";
            foreach (sqlsrv_errors() as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                echo "Code: " . $error['code'] . "<br>";
                echo "Message: " . $error['message'] . "<br>";
            }

        } else {
            echo "Conexión exitosa";

        }
        
        
    }
}
