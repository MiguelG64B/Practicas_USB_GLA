<?php 
session_start();
include "./conexion.php";

if(  isset($_POST['email'])  && isset($_POST['password'])  ){
    
    $resultado = $conexion->query("select * from usuarios where 
        email='".$_POST['email']."' and 
        password='".$_POST['password']."' limit 1")or die($conexion->error);
        
    if(mysqli_num_rows($resultado)>0 ){
        $datos_usuario = mysqli_fetch_row($resultado); 
        $id_usuario= $datos_usuario[0];
        $nombre= $datos_usuario[2];
        $email= $datos_usuario[4];
        $nivel= $datos_usuario[6];
        $telefono = $datos_usuario[7];
     
        $_SESSION['datos_login']= array(
            'nombre'=>$nombre,
            'id_usuario'=>$id_usuario,
            'email'=>$email,
            'telefono'=>$telefono,
            'nivel'=>$nivel 
        );
        header("Location: ../index.php");
    }

    else{
        header("Location: ../login.php?error=Credenciales incorrectas");
    }



}else{
    header("../index.php");
}



?>