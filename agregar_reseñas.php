<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos del formulario
    $platilloID = $_POST["platilloID"];
    $calificacion = $_POST["calificacion"];
    $comentario = $_POST["comentario"];

    // Conéctate a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "prueba");

    // Inserta la reseña en la base de datos
    $consulta_insertar = "INSERT INTO `reviews` (`UsuarioID`, `PlatilloID`, `Calificacion`, `Comentario`) VALUES (1, $platilloID, $calificacion, '$comentario')";

    // Ejecuta la consulta
    $resultado_insertar = mysqli_query($conexion, $consulta_insertar);

    if ($resultado_insertar) {
        // La reseña se ha agregado correctamente
        header("Location: reseñas.php?PlatilloID=$platilloID");
        exit();
    } else {
        // Error al agregar la reseña
        echo "Error al agregar la reseña.";
    }
} else {
    // La página no se accedió a través de POST
    echo "Acceso no válido.";
}
?>
