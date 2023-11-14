<?php
include "./conexion.php";

$conexion->query("DELETE FROM seccion WHERE id=".$_POST['id']);

echo 'listo';
?>
