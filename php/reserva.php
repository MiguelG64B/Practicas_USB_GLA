<?php
include "./conexion.php";

if (isset($_POST['id_libro']) && isset($_POST['fecha_reserva']) && isset($_POST['fecha_limite'])) {

    // Verificar si ya existe una reserva con el mismo id_usuario y entregado='no'
    $id_usuario = $_POST['id_usuario'];
    $consulta_reserva_existente = $conexion->query("SELECT * FROM reservas WHERE id_usuario = '$id_usuario' AND entregado = 'no'");
    
    if ($consulta_reserva_existente->num_rows > 0) {
        // Ya existe una reserva para el usuario con entregado='no'
        header("Location: ../panellibros.php?error=Reserva ya existente, Favor de entregar tu libro actual");
        exit();
    }

    // Insertar en la tabla reservas
    $conexion->query("INSERT INTO reservas
        (id_usuario, id_libro, fecha_reserva, fecha_limite, comentarios, entregado) VALUES
        (
            '".$_POST['id_usuario']."',
            '".$_POST['id_libro']."',
            '".$_POST['fecha_reserva']."',
            '".$_POST['fecha_limite']."',
            'N/A',
            'no'
        )") or die($conexion->error);

    // Actualizar el estado del libro en la tabla libros
    $conexion->query("UPDATE libros SET existe='no' WHERE id_libro=".$_POST['id_libro']);

    header("Location: ../panellibros.php?success");
} else {
    header("Location: ../panellibros.php?error=Favor de llenar todos los campos");
}
?>
