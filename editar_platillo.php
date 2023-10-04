<?php
session_start();

if (!isset($_SESSION['RestauranteID'])) {
    header('Location: login.php');
    exit();
}

$restauranteID = $_SESSION['RestauranteID'];



$conn = mysqli_connect("localhost", "root", "", "prueba");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_platillo"])) {
    $platilloID = $_POST["platillo_id"];
    $nombreplatillo = $_POST["nombreplatillo"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $url_imagen = $_POST["url_imagen"];

    $sql = "UPDATE platillos SET nombreplatillo = '$nombreplatillo', descripcion = '$descripcion', precio = $precio, url_imagen = '$url_imagen' WHERE ID = $platilloID AND RestauranteID = $restauranteID";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_restaurante.php");
        exit();
    } else {
        echo "Error al editar el platillo: " . $conn->error;
    }
}

if (isset($_GET["id"])) {
    $platilloID = $_GET["id"];
    $sql = "SELECT * FROM platillos WHERE ID = $platilloID AND RestauranteID = $restauranteID";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombreplatillo = $row["nombreplatillo"];
        $descripcion = $row["descripcion"];
        $precio = $row["precio"];
        $url_imagen = $row["url_imagen"];
    } else {
        echo "Platillo no encontrado.";
        exit();
    }
} else {
    echo "ID de platillo no proporcionado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Platillo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <!-- Agrega tu hoja de estilo personalizada para el modo oscuro -->
    <link rel="stylesheet" href="styles_editar.css">

</head>
<body>
    <div class="container mt-5">
        <h1>Editar Platillo</h1>
        <form method="post" action="">
            <input type="hidden" name="platillo_id" value="<?php echo $platilloID; ?>">
            
            <div class="mb-3">
                <label for="nombreplatillo" class="form-label">Nombre del Platillo:</label>
                <input type="text" class="form-control" id="nombreplatillo" name="nombreplatillo" value="<?php echo $nombreplatillo; ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?php echo $precio; ?>" required>
            </div>

            <div class="mb-3">
                <label for="url_imagen" class="form-label">URL de la Imagen:</label>
                <input type="text" class="form-control" id="url_imagen" name="url_imagen" value="<?php echo $url_imagen; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="editar_platillo">Guardar Cambios</button>
        </form>
        <a href="index_restaurante.php" class="btn btn-secondary mt-3">Volver</a>
    </div>

    <!-- Agrega el script de Bootstrap (jQuery y Popper.js) al final del documento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
</body>
</html>


<?php
$conn->close();
?>
