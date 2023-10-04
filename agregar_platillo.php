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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_platillo"])) {
    $nombreplatillo = $_POST["nombreplatillo"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $url_imagen = $_POST["url_imagen"];

    $sql = "INSERT INTO platillos (nombreplatillo, descripcion, precio, url_imagen, RestauranteID)
            VALUES ('$nombreplatillo', '$descripcion', $precio, '$url_imagen', $restauranteID)";

    if ($conn->query($sql) === TRUE) {
        header("Location: index_restaurante.php");
        exit();
    } else {
        echo "Error al agregar el platillo: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Agregar Platillo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles_agregar.css">

</head>
<body>
    <div class="container mt-5">
        <h1>Agregar Platillo</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="nombreplatillo" class="form-label">Nombre del Platillo:</label>
                <input type="text" class="form-control" id="nombreplatillo" name="nombreplatillo" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
            </div>

            <div class="mb-3">
                <label for="url_imagen" class="form-label">URL de la Imagen:</label>
                <input type="text" class="form-control" id="url_imagen" name="url_imagen" required>
            </div>

            <button type="submit" class="btn btn-primary" name="agregar_platillo">Agregar Platillo</button>
        </form>
        <a href="index_restaurante.php" class="btn btn-secondary mt-3">Volver</a>
    </div>


</body>
</html>

<?php
$conn->close();
?>
