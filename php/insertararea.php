<?php 
include "./conexion.php";

if(isset($_POST['nombre'])) {
    
    $conexion->query("INSERT INTO areas 
        (descrip) VALUES
        (
            '".$_POST['nombre']."'
        )") or die($conexion->error);
    
    header("Location: ../panelarea.php?success");
} else {
    header("Location: ../panelarea.php?error=Favor de llenar todos los campos");
}
?>
