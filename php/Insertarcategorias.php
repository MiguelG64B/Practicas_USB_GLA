<?php 
include "./conexion.php";

if(isset($_POST['nombre']) && isset($_POST['descripcion'])) {
    
    $conexion->query("INSERT INTO categorias 
        (nombre, descripcion) VALUES
        (
            '".$_POST['nombre']."',
            '".$_POST['descripcion']."'
        )") or die($conexion->error);
    
    header("Location: ../panelcategorias.php?success");
} else {
    header("Location: ../panelcategorias.php?error=Favor de llenar todos los campos");
}
?>
