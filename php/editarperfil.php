<?php
include "conexion.php";

if (isset($_POST['id_usuario']) && isset($_POST['nombre']) && isset($_POST['telefono'])) {
    $conexion->query("update usuarios set 
    nom_persona='".$_POST['nombre']."',
    telefono='".$_POST['telefono']."'
    where id=".$_POST['id_usuario']);

    echo "se actualizo";
    header("Location: ../perfil.php?success=En la proxima sesion se vera reflejado el cambio");
} else {
    header("Location: ../perfil.php?error=Favor de completar los campos");
}
?>
