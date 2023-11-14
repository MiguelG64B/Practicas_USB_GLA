<?php
include "./conexion.php";

if (isset($_POST['titulo'])&& isset($_POST['id_usuario']) && isset($_POST['editor']) && isset($_POST['prioridad']) && isset($_POST['categoria'])) {

    $fecha = date('Y-m-d'); // Obtiene la fecha actual en formato YYYY-MM-DD

    $contenido = $_POST['editor']; // Contenido del editor

    // Se asegura de escapar las comillas simples en el contenido para evitar problemas de inserción
    $contenido = $conexion->real_escape_string($contenido);

    $encargado = "0"; // encargado 0 porque no se ha encargado a un usuario
    $estado = "1"; // estado 1 significando un estado activo

    $conexion->query("INSERT INTO tickets (id_usuario,id_categoria, titulo, resumen,id_prioridad,id_encargado,fecha,id_estado) VALUES
        (
            '" . $_POST['id_usuario'] . "',
            '" . $_POST['categoria'] . "',
            '" . $_POST['titulo'] . "',
            '$contenido',
            '" . $_POST['prioridad'] . "',
            '$encargado',
            '$fecha',
            '$estado'
        )") or die($conexion->error);
    header("Location: ../mistickets.php?success");
} else {
    header("Location: ../mistickets.php?error=Favor de llenar todos los campos");
}
?>
