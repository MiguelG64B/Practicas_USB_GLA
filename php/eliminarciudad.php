<?php
include "./conexion.php";

$conexion->query("DELETE FROM ciudad WHERE id=".$_POST['id']);

echo 'listo';
?>
