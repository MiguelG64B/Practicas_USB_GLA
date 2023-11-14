<?php
include "./conexion.php";

$conexion->query("DELETE FROM autor WHERE id=".$_POST['id']);

echo 'listo';
?>
