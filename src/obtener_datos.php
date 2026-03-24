<?php
include("conection.php");

$sql = "SELECT * FROM alimentos";
$resultado = $conexion->query($sql);

$datos = [];

while($fila = $resultado->fetch_assoc()){
    $datos[] = $fila;
}

echo json_encode($datos);

$conexion->close();
?>