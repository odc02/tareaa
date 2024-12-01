<?php
$host = 'localhost';
$usuario = 'root';
$clave = '';
$base_de_datos = 'escuela';

$conexion = new mysqli($host, $usuario, $clave, $base_de_datos);


if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM estudiantes WHERE id = $id";

    if ($conexion->query($sql) === TRUE) {
        echo "Estudiante eliminado correctamente.";
    } else {
        echo "Error al eliminar el estudiante: " . $conexion->error;
    }
}

header("Location: index.php");
exit();
?>
