<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Reemplaza estas credenciales con las de tu base de datos
 

    // Recibe los datos del formulario
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Crea la conexión a la base de datos
    $conn =  mysqli_connect("localhost", "root", "", "prueba");


    // Verifica la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para verificar las credenciales del restaurante
    $sql = "SELECT RestauranteID, Nombre FROM restaurantes WHERE correo_electronico = '$correo' AND contraseña = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Inicio de sesión exitoso, guarda el ID del restaurante en la sesión
        $row = $result->fetch_assoc();
        $_SESSION["RestauranteID"] = $row["RestauranteID"];
        $_SESSION["NombreRestaurante"] = $row["Nombre"];
        header("Location: index_restaurante.php"); // Redirige a la página principal
    } else {
        $error = "Credenciales incorrectas. Por favor, intenta nuevamente.";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700'>
    <link rel="stylesheet" href="text.css">

    <title>Iniciar Sesión</title>
</head>
<body>
    
<div class="logo"></div>
<div class="login-block">
    <h1>Iniciar Sesión</h1>
    <form method="post" action="">
        <label for="correo">Correo Electrónico:</label>
        <input type="text" id="correo" name="correo" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required><br>

        <input type="submit" value="Iniciar Sesión">

    </form>
    
    </div>
    <?php
    if (isset($error)) {
        echo "<div class='login-block'>";
        echo "<p >$error</p>";
        echo "</div>";
    }
    ?>
</body>
</html>
