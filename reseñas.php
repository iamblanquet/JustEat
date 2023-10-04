<?php
$conexion = mysqli_connect("localhost", "root", "", "prueba");

if (isset($_GET["PlatilloID"])) {
  $platilloID = $_GET["PlatilloID"];

  // Consulta SQL para obtener las valoraciones del platillo
  $consulta_valoraciones = "SELECT `usuarios`.`nombre`, `valoraciones`.`Calificacion`, `valoraciones`.`Comentario` FROM `valoraciones`
  LEFT JOIN `usuarios` ON `valoraciones`.`UsuarioID` = `usuarios`.`id`
  WHERE `valoraciones`.`PlatilloID` = $platilloID";

  $resultado_valoraciones = mysqli_query($conexion, $consulta_valoraciones);


  echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>";
  echo "<link rel='stylesheet' href='style_review.css'>";


  echo "<h1 class='title'>Reseñas del Platillo</h1>";

  while ($row = mysqli_fetch_assoc($resultado_valoraciones)) {

echo "<div class='card text-bg-dark mb-3 style='max-width: 700px;'>";
// echo "<h5 class='card-title'>Usuario: " . $row["nombre"] . "</h5>";

echo '<div class="row g-0">
    <div class="col-md-1">
      <img src="https://i.imgur.com/hP3Uf1b.png" class="img-fluid rounded-start" id="avatar">
    </div>';



echo "<div class='col-md-8'>";
echo "<div class='card-body'>";

// Obtén la calificación del platillo
$calificacion = $row["Calificacion"];

echo "<p class='card-text text-bg-dark mb-3'>Calificación: ";
// Agrega estrellas en función de la calificación
for ($i = 1; $i <= 5; $i++) {
    if ($i <= $calificacion) {
        echo "<span class='star' id='star'>&#9733;</span>"; // Estrella llena (código de estrella Unicode)
    } else {
        echo "<span class='star'>&#9734;</span>"; // Estrella vacía (código de estrella Unicode)
    }
}
echo "</p>";

echo "<p class='card-text text-bg-dark mb-3'>Reseña: " . $row["Comentario"] . "</p>";
echo "</div>";
echo "</div>";
echo "</div";
echo "</div";

  }
  echo "<div class='text-bg-dark mb-3'>";
 
  echo "<h2>Deja tu reseña</h2>";
  echo "<form action='procesar_valoracion.php' method='post'>";
  echo "<input type='hidden' name='platilloID' value='$platilloID'>";
  echo "<label for='calificacion' class='form-label-text-bg-dark mb-3'>Calificación:</label>";
echo "<select name='calificacion' id='calificacion' class='form-control' required>";
$calificacion = isset($_POST['calificacion']) ? $_POST['calificacion'] : 0;

for ($i = 5; $i >= 1; $i--) {
    echo "<option value='$i'";
    if ($calificacion == $i) {
        echo " selected";
    }
    echo ">";
    for ($j = 1; $j <= $i; $j++) {
        echo '&#9733';; // Estrella llena (código de estrella Unicode)
    }
    echo "</option>";
}

echo "</select>";



  echo "</div>";
  echo "<div class='text-bg-dark mb-3'>";
  echo "<label for='comentario' class='form-label'>Comentario:</label>";
  echo "<textarea name='comentario' id='comentario' class='buscar' rows='4' required></textarea>";
  echo "<div class='reviewbox'>";
  echo "<button type='submit' class='buscar-btn'>Enviar reseña</button>";
  echo "</div>";

  echo "</form>";
} else {
  echo "Error: No se proporcionó un ID de platillo válido en la URL.";
}

?>
