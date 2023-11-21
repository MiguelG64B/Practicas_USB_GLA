<?php 
include "conexion.php";
if(isset($_POST['nombre'])&& isset($_POST['tipo'])){
    $conexion->query("update seccion set 
    descrip='".$_POST['nombre']."',
    tipo='".$_POST['tipo']."'
                        where id=".$_POST['id']);
    header("Location: ../panelseccion.php?success");
}
