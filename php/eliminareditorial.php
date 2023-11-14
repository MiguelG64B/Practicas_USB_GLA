<?php
include "./conexion.php";

$conexion->query("DELETE FROM editorial WHERE id=".$_POST['id']);

echo 'listo';
?>
