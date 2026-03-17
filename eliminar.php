<?php
include("conection.php");

$code = $_POST['code'];

$sql = "DELETE FROM alimentos WHERE code='$code'";

if($conexion->query($sql)){
    echo "ok";
} else {
    echo "error";
}

$conexion->close();
?>