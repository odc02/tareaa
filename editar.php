<?php

$host = 'localhost';
$usuario = 'root';
$clave = '';
$base_de_datos = 'escuela';

$conexion = new mysqli($host, $usuario, $clave, $base_de_datos);


if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}


$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $edad = $_POST['edad'];
    $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $curso = $_POST['curso'];
    $genero = $_POST['genero'];
    $intereses = isset($_POST['intereses']) ? implode(', ', $_POST['intereses']) : '';

    
    if (isset($_POST['id']) && $_POST['id'] != '') {
        
        $id = $_POST['id'];
        $sql = "UPDATE estudiantes 
                SET nombre = '$nombre', apellido = '$apellido', edad = '$edad', correo = '$correo', 
                    curso = '$curso', genero = '$genero', intereses = '$intereses' 
                WHERE id = $id";
        $mensaje = 'Estudiante actualizado correctamente.';
    } else {
        
        $sql = "INSERT INTO estudiantes (nombre, apellido, edad, correo, curso, genero, intereses)
                VALUES ('$nombre', '$apellido', '$edad', '$correo', '$curso', '$genero', '$intereses')";
        $mensaje = 'Estudiante registrado correctamente.';
    }

    
    if ($conexion->query($sql) === TRUE) {
        
    } else {
        echo "Error: " . $conexion->error;
    }
}


$sql = "SELECT * FROM estudiantes";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar o Editar Estudiante</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Registrar o Editar Estudiante</h1>


<?php if ($mensaje != ''): ?>
    <p><?php echo $mensaje; ?></p>
<?php endif; ?>

<form action="editar.php" method="post">
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

    <input type="hidden" id="id" name="id" value="">
    <input type="submit" value="Registrar / Actualizar">
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
        <th>Intereses</th>
        <th>Acciones</th>
    </tr>
    <?php while ($estudiante = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo $estudiante['nombre']; ?></td>
            <td><?php echo $estudiante['apellido']; ?></td>
            <td><?php echo $estudiante['edad']; ?></td>
            <td><?php echo $estudiante['correo']; ?></td>
            <td><?php echo $estudiante['curso']; ?></td>
            <td><?php echo $estudiante['genero']; ?></td>
            <td><?php echo $estudiante['intereses']; ?></td>
            <td>
                <a href="editar.php?id=<?php echo $estudiante['id']; ?>">Editar</a>
                <a href="eliminar.php?id=<?php echo $estudiante['id']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>
