<?php
    $servidor="localhost";
    $nombreBd="almendros";
    $usuario="root";
    $pass="";
    $conexion = new mysqli($servidor,$usuario,$pass,$nombreBd);
    $conexion->set_charset("utf8mb4")
?>