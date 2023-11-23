<?php
include "conexion.php";
if (isset($_POST['id_libro']) && isset($_POST['id_reserva']) && isset($_POST['comentarios'])) {
    $conexion->query("update reservas set comentarios='" . $_POST['comentarios'] . "', entregado='si' where id_reserva=" . $_POST['id_reserva']);

    $conexion->query("UPDATE libros SET existe='si' WHERE id_libro=" . $_POST['id_libro']);
    header("Location: ../reservas.php?success");
}
