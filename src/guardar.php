<?php
include("conection.php");

$code = $_POST['code'];
$name = $_POST['name'];
$type = $_POST['type'];
$value = $_POST['value'];

$sql = "INSERT INTO alimentos (code, name, type, value)
        VALUES ('$code', '$name', '$type', '$value')";

if($conexion->query($sql)){
    echo "ok";
} else {
    echo "error";
}

$conexion->close();
?>