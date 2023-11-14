<?php 
include "./conexion.php";

if(isset($_POST['nombre'])) {
    
    $conexion->query("INSERT INTO editorial 
        (descrip) VALUES
        (
            '".$_POST['nombre']."'
        )") or die($conexion->error);
    
    header("Location: ../paneleditorial.php?success");
} else {
    header("Location: ../paneleditorial.php?error=Favor de llenar todos los campos");
}
?>
