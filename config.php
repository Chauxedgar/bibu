<?php
$host = 'localhost';
$user = 'nuevo'; 
$password = 'nuevo123'; 
$database = 'crud_clientes';  

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die(json_encode(['error' => 'Error de conexión: ' . mysqli_connect_error()]));
}

mysqli_set_charset($conn, "utf8");
?>