<?php
include "./conexion.php";

if (isset($_POST['id']) && isset($_POST['coment_usuario']) && isset($_POST['coment_encargado']) && isset($_POST['satisfaccion'])) {
    $id = $_POST['id'];
    $coment_usuario = $_POST['coment_usuario'];
    $coment_encargado = $_POST['coment_encargado'];
    $satisfaccion = $_POST['satisfaccion'];


    $conexion->query("UPDATE tickets SET
        coment_usuario='$coment_usuario',
        id_satisfaccion='$satisfaccion'
        WHERE id_ticket='$id'") or die($conexion->error);

    header("Location: ../index.php?success");
} else {
    header("Location: ../satisfaccion.php?error=Favor completar los campos&id=".$id."&comentarios=".$coment_encargado);
}
?>
