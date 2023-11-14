<?php 
include "conexion.php";
if(isset($_POST['nombre'])){
    $conexion->query("update ciudad set 
    descrip='".$_POST['nombre']."'
                        where id=".$_POST['id']);
    echo "se actualizo";
    header("Location: ../panelciudad.php");
}
