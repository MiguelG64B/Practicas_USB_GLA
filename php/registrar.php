
<?php 
   include "conexion.php";
   if( isset($_POST['nombre'] ) && isset($_POST['email']) && isset($_POST['pass'] ) 
    && isset($_POST['pass2'] )&& isset($_POST['documento'] )){
       
        $em= $conexion->query("SELECT email FROM usuarios WHERE email = '".$_POST['email']."'")or die($conexion->error);
        if(mysqli_num_rows($em)>0){
            header("Location: ../registro.php?error=correo ya registrado");
        }

        else{
        if($_POST['pass'] == $_POST['pass2'] ){
            $name=$_POST['nombre'];
            $email=$_POST['email'];
            $documento=$_POST['documento'];
            $pass=$_POST['pass'];
                $conexion->query("insert into usuarios (usuario,nom_persona,id_estado,email,password,tipo_usuario) 
                    values('$documento','$name','1234','$email','$pass','1')  ")or die($conexion->error);
                    header("Location: ../login.php");
        }else{
           
        header("Location: ../registro.php?error=password  incorrectas");
        }
    }
}
?>
