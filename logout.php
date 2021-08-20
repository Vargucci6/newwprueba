<?php

//Destruir sesión y así cerrarla

session_start();
if (isset($_SESSION['nombre']) != null) {
    session_destroy();
    header("Location: index.php");   
} else {
    header("Location: index.php");
}
