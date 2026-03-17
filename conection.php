<?php
$host = "localhost";
$usuario = "usuario_alimentos";
$contrasena = "123456";
$base_datos = "alimentosdb";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

