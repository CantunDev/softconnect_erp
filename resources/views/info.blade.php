<?php 
//phpinfo();
$serverName = "192.168.193.29\NATIONALSOFT";
$connectionInfo = array("Database" => "softrestaurant10", "UID"=>"sa", "PWD"=>"National09");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}else {
    echo "Conexion lista";
}
?>