<?php
// Conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$clave = '';
$base_de_datos = 'escuela';

$conexion = new mysqli($host, $usuario, $clave, $base_de_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consultar los estudiantes registrados
$sql = "SELECT * FROM estudiantes";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Registro de Estudiantes</h1>

    <!-- Formulario de Registro -->
    <form action="procesar.php" method="post">
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required min="5"><br><br>

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required><br><br>

        <label for="curso">Curso:</label>
        <select id="curso" name="curso" required>
            <option value="Gastronomia">Gastronomía</option>
            <option value="Fisica">Física</option>
            <option value="Programacion">Programación</option>
        </select><br><br>

        <label>Género:</label><br>
        <input type="radio" id="masculino" name="genero" value="Masculino" required>
        <label for="masculino">Masculino</label><br>
        <input type="radio" id="femenino" name="genero" value="Femenino">
        <label for="femenino">Femenino</label><br>
        <input type="radio" id="otro" name="genero" value="Otro">
        <label for="otro">Otro</label><br><br>

        <label>Áreas de interés:</label><br>
        <input type="checkbox" id="area1" name="intereses[]" value="Ingenieria de software">
        <label for="area1">Ingeniería de software</label><br>
        <input type="checkbox" id="area2" name="intereses[]" value="Video juegos">
        <label for="area2">Video juegos</label><br>
        <input type="checkbox" id="area3" name="intereses[]" value="Idiomas">
        <label for="area3">Idiomas</label><br><br>

        <input type="submit" value="Registrar">
    </form>

    <h2>Estudiantes Registrados</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Edad</th>
            <th>Correo</th>
            <th>Curso</th>
            <th>Género</th>
            <th>Áreas de interés</th>
            <th>Acciones</th>
        </tr>

        <?php
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['apellido'] . "</td>";
                echo "<td>" . $row['edad'] . "</td>";
                echo "<td>" . $row['correo'] . "</td>";
                echo "<td>" . $row['curso'] . "</td>";
                echo "<td>" . $row['genero'] . "</td>";
                echo "<td>" . $row['intereses'] . "</td>";
                echo "<td>
                        <a href='editar.php?id=" . $row['id'] . "'>Editar</a> | 
                        <a href='eliminar.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este registro?\");'>Eliminar</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No hay estudiantes registrados</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
$conexion->close();
?>
