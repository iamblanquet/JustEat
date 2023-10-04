<?php
  include("create_usuario.html");

$conexion = mysqli_connect("localhost", "root", "", "prueba");


if (empty($_POST["nombre"])) {
  echo "El nombre es obligatorio.";
  exit();
}

if (empty($_POST["correo_electronico"])) {
  echo "El correo electrónico es obligatorio.";
  exit();
}

if (empty($_POST["contraseña"])) {
  echo "La contraseña es obligatoria.";
  exit();
}



// Verificar que el correo electrónico no esté ya registrado
$sql = "SELECT * FROM usuarios WHERE correo_electronico = '" . $_POST["correo_electronico"] . "'";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
  echo "El correo electrónico ya está registrado.";
  exit();
}

// Crear una nueva cuenta de usuario
$sql = "INSERT INTO usuarios (nombre, correo_electronico, contraseña, tipo_usuario) VALUES ('" . $_POST["nombre"] . "', '" . $_POST["correo_electronico"] . "', '" . $_POST["contraseña"] .  "', 'usuario')";
mysqli_query($conexion, $sql);

// Enviar un correo electrónico de confirmación
$asunto = "Registro de usuario";
$mensaje = "Gracias por registrarte en nuestro sitio web. Tu cuenta ha sido creada con éxito.";
mail($_POST["correo_electronico"], $asunto, $mensaje);

// Redireccionar al usuario a la página de inicio
header("Location: busqueda_platillos.html");

?>