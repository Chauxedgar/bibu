<?php
$host = "db";
$usuario = "nuevo";
$contrasena = "nuevo123";
$base_datos = "crud_clientes";

$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

