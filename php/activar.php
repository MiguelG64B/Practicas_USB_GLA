<?php
include "./conexion.php";

$conexion->query("UPDATE usuarios SET id_estado = 5 WHERE id=".$_POST['id']);

echo 'listo';
?>
