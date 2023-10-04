<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;500&display=swap" rel="stylesheet">
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

  <title>JustEat</title>
</head>
<div class="collapse navbar-collapse" id="custom-collapse">
        <ul class="nav navbar-nav navbar-right" id="cerrar">
          <li><a href="logout_user.php">CERRAR SESION</a></li>
        </div>
<body>
<div class="main">
  <h1 class="title">JustEat</h1>
  <form action="busqueda_platillos.php" method="post">
    <div class="buscador">

    <input type="text" id="searchInput"  name="terminos_busqueda" placeholder="¡No seas tímido, busca tu comida favorita y dale rienda suelta a tu paladar!" class="buscar">

    <input type="submit" id="searchBtn" value="Buscar">
</div> 
</DIV>
</form>
  <section class="main-container">

    <div class="cards-container">


      
      <script>
        function abrirReseñas(platilloID) {
            // Abre la página de reseñas en una nueva ventana emergente
            window.open('reseñas.php?PlatilloID=' + platilloID, 'Reseñas', 'width=800,height=700');
        }
        </script>
        
</body>

</html>


<?php

function buscar_platillos($terminos_busqueda) {
  $conexion = mysqli_connect("localhost", "root", "", "prueba");

  $consulta = "SELECT `platillos`.`ID`, `platillos`.`url_imagen`, `platillos`.`precio`, `platillos`.`nombreplatillo`, `platillos`.`descripcion`, `restaurantes`.`Nombre`, `restaurantes`.`numero_telefono`, `restaurantes`.`direccion`, `platillos`.`calificacion_promedio`
  FROM `platillos`
  LEFT JOIN `restaurantes` ON `platillos`.`RestauranteID` = `restaurantes`.`RestauranteID`
  WHERE `platillos`.`nombreplatillo` LIKE '%$terminos_busqueda%';";

  $resultado = mysqli_query($conexion, $consulta);

  return $resultado;
}

if (isset($_POST["terminos_busqueda"])) {
  $resultados = buscar_platillos($_POST["terminos_busqueda"]);

  if (isset($resultados)) {
    while ($resultado = mysqli_fetch_assoc($resultados)) {
      echo "<div class='product-card'>";
      echo "<img src='" . $resultado["url_imagen"] . "' alt='" . $resultado["nombreplatillo"] . "'>";
      echo "<p class='precio'>Precio: $" . $resultado["precio"] . "</p>";
      echo "<p class='nombre'>" . $resultado["nombreplatillo"] . "</p>";
      echo "<p class='descripcion'>" . $resultado["descripcion"] . "</p>";
      echo "<p class='descripcion'>" . $resultado["Nombre"] . "</p>";
      echo "<p class='descripcion'>" . $resultado["numero_telefono"] . "</p>";
      echo "<p class='descripcion'>" . $resultado["direccion"] . "</p>";
      echo "<div class='nombre'>";
for ($i = 1; $i <= 5; $i++) {
    if ($i <= $resultado["calificacion_promedio"] ) {
        echo "<span class='star'>&#9733;</span>"; // Estrella llena (código de estrella Unicode)
    } else {
        echo "<span class='star'>&#9734;</span>"; // Estrella vacía (código de estrella Unicode)
    }
}

echo "</div>";
echo "<button onclick='abrirReseñas(" . $resultado["ID"] . ")' class='btn btn-reseñar'>Reseñar</button>";
      
      echo "</div>";

      
    }
  }
}
?>
