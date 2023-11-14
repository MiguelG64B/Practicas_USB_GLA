<?php 
include "./conexion.php";

if(isset($_POST['nombre'])) {
    
    $conexion->query("INSERT INTO autor
        (nom_persona) VALUES
        (
            '".$_POST['nombre']."'
        )") or die($conexion->error);
    
    header("Location: ../panelautor.php?success");
} else {
    header("Location: ../panelautor.php?error=Favor de llenar todos los campos");
}
?>
