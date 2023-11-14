<?php 
include "./conexion.php";

if(isset($_POST['nombre']) && isset($_POST['descripcion'])&& isset($_POST['id_seccion'])) {
    
    $conexion->query("INSERT INTO categorias 
        (nombre, descripcion,id_seccion) VALUES
        (
            '".$_POST['nombre']."',
            '".$_POST['descripcion']."',
            '".$_POST['id_seccion']."'
        )") or die($conexion->error);
    
    header("Location: ../panelcategorias.php?success");
} else {
    header("Location: ../panelcategorias.php?error=Favor de llenar todos los campos");
}
?>
