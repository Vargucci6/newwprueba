<?php

// Obtener la conexión

include_once("conection.php");
$conexion = Conexion::conectar();

//Empezar sesión

session_start();

// Igualar variables a datos recibidos

$contrasenia = "";
if (isset($_POST['contrasenia']) == null || $_POST['contrasenia'] == "") {
    $contrasenia = $_SESSION['contrasenia'];
} else {
    $contrasenia = htmlspecialchars($_POST['contrasenia'], ENT_QUOTES);
    $_SESSION['contrasenia'] = $contrasenia;
}

$correo = $_SESSION['correo'];
$nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES);

// Crear sentencia SQL

$sql = "UPDATE usuarios SET correo = '$correo', nombre = '$nombre', contrasenia = '$contrasenia' WHERE correo = '$correo'";

// Insertar secuencia a la base de datos

if ($conexion->query($sql)) {
?>
    <script>
        alert("Se han actualizado los datos correctamente!");
        location.href = "index.php";
    </script>
<?php
} else {
?>
    <script>
        alert("Error");
        location.href = "index.php";
    </script>
<?php
}
?>