<?php
include "./conexion.php";

if (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['editor']) && isset($_POST['categoria'])&& isset($_POST['prioridad'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['editor'];
    $categoria = $_POST['categoria'];
    $prioridad = $_POST['prioridad'];

    // Se asegura de escapar las comillas simples en el contenido para evitar problemas de inserción
    $contenido = $conexion->real_escape_string($contenido);

    $conexion->query("UPDATE tickets SET
        id_categoria='$categoria',
        titulo='$titulo',
        resumen='$contenido',
        id_prioridad='$prioridad'
        WHERE id_ticket='$id'") or die($conexion->error);

    header("Location: ../index.php?success");
} else {
    header("Location: ../index.php?error=Favor de llenar todos los campos");
}
?>
