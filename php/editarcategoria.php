<?php 
include "conexion.php";
if(isset($_POST['nombre']) &&  isset($_POST['descripcion'])){
    $conexion->query("update categorias set 
                        nombre='".$_POST['nombre']."',
                        descripcion='".$_POST['descripcion']."'
                        where id=".$_POST['id']);
    echo "se actualizo";
    header("Location: ../panelcategorias.php");
}   
?>