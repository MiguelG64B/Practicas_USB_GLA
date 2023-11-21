<?php 
include "./conexion.php";

if(isset($_POST['nombre'])&& isset($_POST['tipo'])) {
    
    $conexion->query("INSERT INTO seccion 
        (descrip,tipo) VALUES
        (
            '".$_POST['nombre']."',
            '".$_POST['tipo']."'
        )") or die($conexion->error);
    
    header("Location: ../panelseccion.php?success");
} else {
    header("Location: ../panelseccion.php?error=Favor de llenar todos los campos");
}
?>
