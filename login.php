<?php
  include("login.html");

  $conexion = mysqli_connect("localhost", "root", "", "prueba");
// Conectarse a la base de datos

// Validar los datos del formulario


// Verificar que los datos sean válidos
$sql = "SELECT * FROM usuarios WHERE correo_electronico = '" . $_POST["correo_electronico"] . "' AND contraseña = '" . $_POST["contraseña"] . "'";
$resultado = mysqli_query($conexion, $sql);

if (empty($_POST["correo_electronico"])) {
  echo "<h1> El correo electrónico es obligatorio.</h1>";
  echo "</div>";
  exit();
}

if (empty($_POST["contraseña"])) {
  echo "La contraseña es obligatoria.";
  exit();
}

if (mysqli_num_rows($resultado) == 0) {
  echo "El correo electrónico o la contraseña no son válidos.";
  exit();
}

// Iniciar sesión al usuario
$usuario = mysqli_fetch_assoc($resultado);
session_start();
$_SESSION["id_usuario"] = $usuario["id"];
$_SESSION["tipo_usuario"] = $usuario["tipo_usuario"];

// Redireccionar al usuario a la página principal
header("Location: busqueda_platillos.html");
