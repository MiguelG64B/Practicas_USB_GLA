<?php
include "./conexion.php";

if (isset($_POST['id_libro']) && isset($_POST['fecha_reserva']) && isset($_POST['fecha_limite']) && isset($_POST['edicion']) && isset($_POST['id_usuario'])) {

    // Verificar si ya existe una reserva con el mismo id_usuario y entregado='no'
    $id_usuario = $_POST['id_usuario'];
    $edicion_actual = intval($_POST['edicion']);
    $consulta_reserva_existente = $conexion->prepare("SELECT * FROM reservas WHERE id_usuario = ? AND entregado = 'no'");
    $consulta_reserva_existente->bind_param("s", $id_usuario);
    $consulta_reserva_existente->execute();
    $resultado_reserva_existente = $consulta_reserva_existente->get_result();

    if ($resultado_reserva_existente->num_rows > 0) {
        // Ya existe una reserva para el usuario con entregado='no'
        header("Location: ../panellibros.php?error=Reserva ya existente, Favor de entregar tu libro actual");
        exit();
    }

    // Restar 1 al atributo edicion del inventario
    $edicion_nueva = $edicion_actual - 1;

    // Determinar el valor de $dispo según el resultado de la resta
    $dispo = ($edicion_nueva > 0) ? 'si' : 'no';

    // Insertar en la tabla reservas
    $consulta_insertar_reserva = $conexion->prepare("INSERT INTO reservas (id_usuario, id_libro, fecha_reserva, fecha_limite, comentarios, entregado) VALUES (?, ?, ?, ?, 'N/A', 'no')");
    $consulta_insertar_reserva->bind_param("ssss", $_POST['id_usuario'], $_POST['id_libro'], $_POST['fecha_reserva'], $_POST['fecha_limite']);
    $consulta_insertar_reserva->execute();

    // Actualizar el estado del libro en la tabla libros
    $consulta_actualizar_libro = $conexion->prepare("UPDATE libros SET existe=?, edicion=? WHERE id_libro=?");
    $consulta_actualizar_libro->bind_param("ssi", $dispo, $edicion_nueva, $_POST['id_libro']);
    $consulta_actualizar_libro->execute();

    header("Location: ../panellibros.php?success");
} else {
    header("Location: ../panellibros.php?error=Favor de llenar todos los campos");
}
?>
