<?php 
include "conexion.php";
if(isset($_POST['nombre'])){
    $conexion->query("update areas set 
    descrip='".$_POST['nombre']."'
                        where id=".$_POST['id']);
    echo "se actualizo";
    header("Location: ../panelarea.php");
}
