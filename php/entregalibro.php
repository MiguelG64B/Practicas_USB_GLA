<?php
include "conexion.php";

if (isset($_POST['id_libro']) && isset($_POST['id_reserva']) && isset($_POST['comentarios']) && isset($_POST['edicion'])) {

    $edicion_actual = intval($_POST['edicion']);
    $edicion_nueva = $edicion_actual + 1;

    // Actualizar la reserva utilizando una consulta preparada
    $consulta_actualizar_reserva = $conexion->prepare("UPDATE reservas SET comentarios=?, entregado='si' WHERE id_reserva=?");
    $consulta_actualizar_reserva->bind_param("si", $_POST['comentarios'], $_POST['id_reserva']);
    $consulta_actualizar_reserva->execute();

    // Actualizar el estado del libro y la edición utilizando consultas preparadas
    $consulta_actualizar_libro = $conexion->prepare("UPDATE libros SET existe='si', edicion=? WHERE id_libro=?");
    $consulta_actualizar_libro->bind_param("ii", $edicion_nueva, $_POST['id_libro']);
    $consulta_actualizar_libro->execute();

    header("Location: ../reservas.php?success");
}
?>
