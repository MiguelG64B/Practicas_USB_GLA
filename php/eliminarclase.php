<?php
include "./conexion.php";

$conexion->query("DELETE FROM clase WHERE id=".$_POST['id']);

echo 'listo';
?>
