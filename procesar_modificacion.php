        <?php
        // Incluir el archivo de conexión a la base de datos
        include('conexion.php');

        // Realizar una consulta SQL para obtener los platillos
        $sql = "SELECT * FROM platillos";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['nombreplatillo'] . "</td>";
                echo "<td>" . $row['descripcion'] . "</td>";
                echo "<td>" . $row['precio'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron platillos.</td></tr>";
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
        ?>