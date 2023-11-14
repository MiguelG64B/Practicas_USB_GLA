<?php
include "./conexion.php";

$conexion->query("DELETE FROM areas WHERE id=".$_POST['id']);

echo 'listo';
?>
