<?php 
include "conexion.php";
if(isset($_POST['nombre'])){
    $conexion->query("update autor set 
    nom_persona='".$_POST['nombre']."'
                        where id=".$_POST['id']);
    echo "se actualizo";
    header("Location: ../panelautor.php");
}
