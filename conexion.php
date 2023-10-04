<?php

// Crear una conexión
$conexion = mysqli_connect("localhost", "root", "", "prueba");
// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
