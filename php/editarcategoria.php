<?php 
include "conexion.php";
if(isset($_POST['nombre']) &&  isset($_POST['descripcion'])&&  isset($_POST['id_seccion'])){
    $conexion->query("update categorias set 
                        nombre='".$_POST['nombre']."',
                        descripcion='".$_POST['descripcion']."',
                        id_seccion='".$_POST['id_seccion']."'
                        where id=".$_POST['id']);
    echo "se actualizo";
    header("Location: ../panelcategorias.php");
}   
?>