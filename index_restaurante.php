<?php
session_start();

if (!isset($_SESSION['RestauranteID'])) {
    header('Location: login_restaurante.php');
    exit();
}

$restauranteID = $_SESSION['RestauranteID'];



$conn = mysqli_connect("localhost", "root", "", "prueba");


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_platillo"])) {
    $platilloID = $_POST["platillo_id"];
    $sql = "DELETE FROM platillos WHERE ID = $platilloID AND RestauranteID = $restauranteID";
    if ($conn->query($sql) === TRUE) {
        header("Location: index_restaurante.php");
        exit();
    } else {
        echo "Error al eliminar el platillo: " . $conn->error;
    }
}

$sql = "SELECT * FROM platillos WHERE RestauranteID = $restauranteID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <title>Platillos del Restaurante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
</head>
<body>
    <style>body {
    background: url('https://i.imgur.com/yTeO9xA.png') no-repeat fixed center center;
    background-size: cover;
    font-family:Quicksand;}

    h1{
        color: #acd9b2;
        text-align:center;
        size: 70px;
    }
        label, input, select, 
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate{
            color:#acd9b2;

 
        }
</style>
    <div class="container mt-5">
        <h1>Platillos del Restaurante</h1>
        <dir>
                    <form method="get" action="agregar_platillo.php">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Agregar Platillo</button>
        <table id="tabla-platillos" class="table table-hover table-dark">
        </form>
        </div>
            <thead>
            
                    <th>Nombre del Platillo</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombreplatillo"] . "</td>";
                        echo "<td>" . $row["descripcion"] . "</td>";
                        echo "<td>" . $row["precio"] . "</td>";
                        echo '<td><img src="' . $row["url_imagen"] . '" alt="' . $row["nombreplatillo"] . '" width="100"></td>';
                        echo '<td>';
                        echo '<form method="post" action="">';
                        echo '<input type="hidden" name="platillo_id" value="' . $row["ID"] . '">';
                        echo '<button type="submit" class="btn btn-danger btn-md" name="eliminar_platillo">Borrar</button>';
                        echo '</form>';
                        echo '<form method="get" action="editar_platillo.php">';
                        echo '<input type="hidden" name="id" value="' . $row["ID"] . '">';
                        echo '<button type="submit" class="btn btn-primary btn-md ">Editar</button>';
                        echo '</form>';
                        echo '</td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron platillos.</td></tr>";
                }
                ?>

                
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>
    </div>
    
    <!-- Agrega el script de Bootstrap (jQuery y Popper.js) al final del documento -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
<script>
$(document).ready(function() {
    $('#tabla-platillos').DataTable({
        "paging": true,  // Habilita la paginación
        "lengthMenu": [5, 10, 25, 50],  // Define la cantidad de registros por página
        "pageLength": 5,  // Cantidad de registros mostrados por página por defecto
        "searching": true,  // Habilita la búsqueda
        "ordering": true,  // Habilita el ordenamiento de columnas
        "info": true,  // Muestra la información de la tabla (por ejemplo, "Mostrando 1-10 de 25 registros")
        "autoWidth": false,  // Desactiva el ajuste automático del ancho de las columnas
    });
});
</script>
