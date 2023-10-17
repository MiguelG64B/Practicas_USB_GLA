<?php 
include "conexion.php";
if(isset($_POST['nombre']) &&  isset($_POST['descripcion'])&&  isset($_POST['id_area'])){
    $conexion->query("update categorias set 
                        nombre='".$_POST['nombre']."',
                        descripcion='".$_POST['descripcion']."',
                        id_area='".$_POST['id_area']."'
                        where id=".$_POST['id']);
    echo "se actualizo";
    header("Location: ../panelcategorias.php");
}   
?>