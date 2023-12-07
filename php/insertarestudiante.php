
<?php 
   include "conexion.php";
   if( isset($_POST['usuario'] ) && isset($_POST['email']) && isset($_POST['nombre'] ) && isset($_POST['email']) && isset($_POST['pass'] ) 
    && isset($_POST['pass2'] )&& isset($_POST['telefono'] )){

        $em= $conexion->query("SELECT email FROM usuarios WHERE email = '".$_POST['email']."'")or die($conexion->error);
        if(mysqli_num_rows($em)>0){
            header("Location: ../estudiantes.php?error=correo ya registrado");
        }

        else{
        if($_POST['pass'] == $_POST['pass2'] ){
            $documento=$_POST['usuario'];
            $name=$_POST['nombre'];
            $email=$_POST['email'];
            $pass=$_POST['pass'];
            $p1=sha1($pass);
            $telefono=$_POST['telefono'];
                $conexion->query("insert into usuarios (usuario,nom_persona,id_estado,email,password,tipo_usuario,telefono,id_seccion,id_superior,per_tickets,per_categoria,per_niveles,per_seccion,per_con,per_mistickets,per_reserva) 
                    values('$documento','$name','5','$email','$p1','7','$telefono','0','0','0','0','0','0','0','0','1')  ")or die($conexion->error);
                    header("Location: ../estudiantes.php");
        }else{
           
        header("Location: ../estudiantes.php?error=password  incorrectas");
        }
    }
}
?>