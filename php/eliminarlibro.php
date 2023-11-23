<?php
include "./conexion.php";

$conexion->query("DELETE FROM libros WHERE id_libro=".$_POST['id_libro']);

echo 'listo';
?>
