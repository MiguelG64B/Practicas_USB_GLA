<?php 
include "./conexion.php";

if(isset($_POST['nombre'])) {
    
    $conexion->query("INSERT INTO ciudad
        (descrip) VALUES
        (
            '".$_POST['nombre']."'
        )") or die($conexion->error);
    
    header("Location: ../panelciudad.php?success");
} else {
    header("Location: ../panelciudad.php?error=Favor de llenar todos los campos");
}
?>
