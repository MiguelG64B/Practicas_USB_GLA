<?php 
include "./conexion.php";

if(isset($_POST['nombre'])) {
    
    $conexion->query("INSERT INTO seccion 
        (descrip) VALUES
        (
            '".$_POST['nombre']."'
        )") or die($conexion->error);
    
    header("Location: ../panelseccion.php?success");
} else {
    header("Location: ../panelseccion.php?error=Favor de llenar todos los campos");
}
?>
