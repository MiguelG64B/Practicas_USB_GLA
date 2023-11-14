<?php 
include "./conexion.php";

if(isset($_POST['nombre'])) {
    
    $conexion->query("INSERT INTO clase
        (descrip) VALUES
        (
            '".$_POST['nombre']."'
        )") or die($conexion->error);
    
    header("Location: ../panelclase.php?success");
} else {
    header("Location: ../panelclase.php?error=Favor de llenar todos los campos");
}
?>
