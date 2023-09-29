<?php
include "./conexion.php";

$conexion->query("DELETE FROM categorias WHERE id=".$_POST['id']);

echo 'listo';
?>
