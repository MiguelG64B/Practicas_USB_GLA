<?php
include "./conexion.php";

if (isset($_POST['id']) && isset($_POST['encargado'])) {
    $id = $_POST['id'];
    $encargado = $_POST['encargado'];

    $conexion->query("UPDATE tickets SET
        id_encargado='$encargado',
        id_estado='2'
        WHERE id_ticket='$id'") or die($conexion->error);

    header("Location: ../index.php?success");
} else {
    header("Location: ../index.php?error=Favor de llenar todos los campos");
}

?>
