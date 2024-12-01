<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Recibidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Establecer la conexión con la base de datos
$host = 'localhost';
$usuario = 'root';
$clave = '';
$base_de_datos = 'escuela';

$conexion = new mysqli($host, $usuario, $clave, $base_de_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Comprobar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtener los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $edad = isset($_POST['edad']) && is_numeric($_POST['edad']) ? $_POST['edad'] : '';
    $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $curso = $_POST['curso'];
    $genero = $_POST['genero'];
    $intereses = isset($_POST['intereses']) ? implode(', ', $_POST['intereses']) : '';

    // Validar que todos los campos necesarios estén completos
    if ($nombre && $apellido && $edad && $correo && $curso && $genero) {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO estudiantes (nombre, apellido, edad, correo, curso, genero, intereses) 
                VALUES ('$nombre', '$apellido', '$edad', '$correo', '$curso', '$genero', '$intereses')";

        if ($conexion->query($sql) === TRUE) {
            echo "Estudiante registrado correctamente.";
        } else {
            echo "Error al registrar el estudiante: " . $conexion->error;
        }
    } else {
        echo "Error: Todos los campos son obligatorios.";
    }
}

$conexion->close();
?>

</body>
</html>
