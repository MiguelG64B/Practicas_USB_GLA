<?php
include "conexion.php";

if (isset($_POST['id_libro']) && isset($_POST['id_reserva']) && isset($_POST['edicion'])) {

    $conexion->query("update reservas set 
    entregado='pendi'
                        where id_reserva=".$_POST['id_reserva']);
    echo "se actualizo";
    header("Location: ../reservas.php");

}


?>
