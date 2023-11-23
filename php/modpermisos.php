<?php
include "conexion.php";

if (isset($_POST['id']) && isset($_POST['id_superior'])&& isset($_POST['id_seccion']) && isset($_POST['per_niveles'])&& isset($_POST['per_categoria'])&& isset($_POST['per_tickets'])&& isset($_POST['per_con'] )&& isset($_POST['per_seccion'] )&& isset($_POST['per_mistickets'] )&& isset($_POST['per_reserva'] )) {
    $conexion->query("update usuarios set 
    id_seccion='".$_POST['id_seccion']."',
    id_superior='".$_POST['id_superior']."',
    per_tickets='".$_POST['per_tickets']."',
    per_categoria='".$_POST['per_categoria']."',
    per_niveles='".$_POST['per_niveles']."',
    per_seccion='".$_POST['per_seccion']."',
    per_con='".$_POST['per_con']."',
    per_mistickets='".$_POST['per_mistickets']."',
    per_reserva='".$_POST['per_reserva']."'
    where id=".$_POST['id']);

    echo "se actualizo";
    header("Location: ../trabajadores.php?success=En la proxima sesion se vera reflejado el cambio");
} else {
    header("Location: ../trabajadores.php?error=Favor de completar los campos");
}
?>
