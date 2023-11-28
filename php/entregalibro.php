<?php
include "conexion.php";

if (isset($_POST['id_libro']) && isset($_POST['id_reserva']) && isset($_POST['edicion']) && isset($_POST['id_estado'])) {

    $edicion_actual = intval($_POST['edicion']);
    $edicion_nueva = $edicion_actual + 1;

    // Actualizar la reserva utilizando una consulta preparada
    $consulta_actualizar_reserva = $conexion->prepare("UPDATE reservas SET entregado='si', id_estado=? WHERE id_reserva=?");
    $consulta_actualizar_reserva->bind_param("ii", $_POST['id_estado'], $_POST['id_reserva']);
    $consulta_actualizar_reserva->execute();
    $consulta_actualizar_reserva->close();

    // Actualizar el estado del libro y la edición utilizando consultas preparadas
    $consulta_actualizar_libro = $conexion->prepare("UPDATE libros SET edicion=?, existe='si' WHERE id_libro=?");
    $consulta_actualizar_libro->bind_param("ii", $edicion_nueva, $_POST['id_libro']);
    $consulta_actualizar_libro->execute();
    $consulta_actualizar_libro->close();

    header("Location: ../reservas.php?success");
}
?>
