<?php
    // Conexión a la base de datos
    class Conexion {
        public static function conectar(){
            return new mysqli("localhost","root","","neww");
        }
    }
?>