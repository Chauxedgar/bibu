<?php
include("conection.php");

$code = $_POST['code'];
$name = $_POST['name'];
$type = $_POST['type'];
$value = $_POST['value'];

$sql = "UPDATE alimentos 
        SET name='$name', type='$type', value='$value'
        WHERE code='$code'";

if($conexion->query($sql)){
    echo "ok";
} else {
    echo "error";
}

$conexion->close();
?>