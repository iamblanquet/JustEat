<!DOCTYPE html>
<html>
<head>
    <title>Gestor de Platillos</title>
</head>
<body>
    <h1>Gestor de Platillos</h1>

    <!-- Formulario para agregar un nuevo platillo -->
    <h2>Agregar Nuevo Platillo</h2>
    <form action="gestor.php" method="POST">
        <label>Nombre del Platillo:</label>
        <input type="text" name="nombreplatillo" required><br>
        <label>Descripción:</label>
        <input type="text" name="descripcion" required><br>
        <label>Precio:</label>
        <input type="number" name="precio" required><br>
        <label>URL de la Imagen:</label>
        <input type="text" name="url_imagen" required><br>
        <input type="submit" name="agregar" value="Agregar Platillo">
    </form>

    <?php
    // Establece la conexión a la base de datos
  

    $conn = mysqli_connect("localhost", "root", "", "prueba");

    if ($conn->connect_error) {
        die("Error en la conexión a la base de datos: " . $conn->connect_error);
    }

    // Función para mostrar la lista de platillos
    function mostrarPlatillos($conn) {
        $sql = "SELECT * FROM platillos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Lista de Platillos</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Imagen</th><th>Acciones</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["nombreplatillo"] . "</td>";
                echo "<td>" . $row["descripcion"] . "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td><img src='" . $row["url_imagen"] . "' alt='Imagen del platillo'></td>";
                echo "<td><a href='editar.php?id=" . $row["ID"] . "'>Editar</a> | <a href='eliminar.php?id=" . $row["ID"] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron platillos en la base de datos.";
        }
    }

    // Agregar nuevo platillo
    if (isset($_POST['agregar'])) {
        $nombreplatillo = $_POST['nombreplatillo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $url_imagen = $_POST['url_imagen'];

        $sql = "INSERT INTO platillos (nombreplatillo, descripcion, precio, url_imagen, RestauranteID) VALUES ('$nombreplatillo', '$descripcion', $precio, '$url_imagen', 1)";

        if ($conn->query($sql) === TRUE) {
            echo "Platillo agregado con éxito.";
        } else {
            echo "Error al agregar el platillo: " . $conn->error;
        }
    }

    // Mostrar la lista de platillos
    mostrarPlatillos($conn);

    // Cierra la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
