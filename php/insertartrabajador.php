
<?php 
   include "conexion.php";
   if( isset($_POST['usuario'] ) && isset($_POST['email']) && isset($_POST['nombre'] ) && isset($_POST['email']) && isset($_POST['pass'] ) 
    && isset($_POST['pass2'] )&& isset($_POST['telefono'] )&& isset($_POST['rol'] )&& isset($_POST['id_seccion'] )&& isset($_POST['per_niveles'] )
    && isset($_POST['per_tickets'] )&& isset($_POST['per_categoria'] )&& isset($_POST['superior'] )&& isset($_POST['per_con'] )&& isset($_POST['per_seccion'] )&& isset($_POST['per_mistickets'] )&& isset($_POST['per_reserva'] )){

        $em= $conexion->query("SELECT email FROM usuarios WHERE email = '".$_POST['email']."'")or die($conexion->error);
        if(mysqli_num_rows($em)>0){
            header("Location: ../trabajadores.php?error=correo ya registrado");
        }

        else{
        if($_POST['pass'] == $_POST['pass2'] ){
            $documento=$_POST['usuario'];
            $name=$_POST['nombre'];
            $email=$_POST['email'];
            $pass=$_POST['pass'];
            $rol=$_POST['rol'];
            $telefono=$_POST['telefono'];
            $id_seccion=$_POST['id_seccion'];
            $superior=$_POST['superior'];
            $per_tickets=$_POST['per_tickets'];
            $per_categoria=$_POST['per_categoria'];
            $per_niveles=$_POST['per_niveles'];
            $per_seccion=$_POST['per_seccion'];
            $per_con=$_POST['per_con'];
            $per_reserva=$_POST['per_reserva'];
            $per_mistickets=$_POST['per_mistickets'];
                $conexion->query("insert into usuarios (usuario,nom_persona,id_estado,email,password,tipo_usuario,telefono,id_seccion,id_superior,per_tickets,per_categoria,per_niveles,per_seccion,per_con,per_mistickets,per_reserva) 
                    values('$documento','$name','5','$email','$pass','$rol','$telefono','$id_seccion',$superior,$per_tickets,$per_categoria,$per_niveles,$per_seccion,$per_con,$per_mistickets,$per_reserva)  ")or die($conexion->error);
                    header("Location: ../trabajadores.php");
        }else{
           
        header("Location: ../trabajadores.php?error=password  incorrectas");
        }
    }
}
?>