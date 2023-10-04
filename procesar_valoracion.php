<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $platilloID = $_POST["platilloID"];
    $calificacion = $_POST["calificacion"];
    $comentario = $_POST["comentario"];

    $conexion = mysqli_connect("localhost", "root", "", "prueba");

    $consulta_insertar_valoracion = "INSERT INTO `valoraciones` (`UsuarioID`, `PlatilloID`, `Calificacion`, `Comentario`)
                                     VALUES (1, $platilloID, $calificacion, '$comentario')";

    if (mysqli_query($conexion, $consulta_insertar_valoracion)) {
        // Calcula la nueva calificación promedio
        $consulta_calificacion_promedio = "SELECT AVG(`Calificacion`) AS CalificacionPromedio
                                           FROM `valoraciones`
                                           WHERE `PlatilloID` = $platilloID";

        $resultado_calificacion_promedio = mysqli_query($conexion, $consulta_calificacion_promedio);

        if ($resultado_calificacion_promedio) {
            $fila_calificacion_promedio = mysqli_fetch_assoc($resultado_calificacion_promedio);
            $calificacion_promedio = $fila_calificacion_promedio["CalificacionPromedio"];

            // Actualiza la calificación promedio en la tabla 'platillos'
            $consulta_actualizar_calificacion = "UPDATE `platillos`
                                               SET `calificacion_promedio` = $calificacion_promedio
                                               WHERE `ID` = $platilloID";

            if (mysqli_query($conexion, $consulta_actualizar_calificacion)) {
                // La actualización se realizó con éxito
                header("Location:  reseñas.php?PlatilloID=$platilloID");    
                            
            } 
        }
    // Cierra la conexión
    mysqli_close($conexion);
}
}
?>
