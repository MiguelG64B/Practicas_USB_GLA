<?php 
session_start();
include "./conexion.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    $resultado = $conexion->query("SELECT * FROM usuarios WHERE email = '" . $_POST['email'] . "' AND password = '" . $_POST['password'] . "' LIMIT 1") or die($conexion->error);

    if (mysqli_num_rows($resultado) > 0) {
        $datos_usuario = mysqli_fetch_assoc($resultado); // Usamos mysqli_fetch_assoc para obtener un array asociativo
        $id_usuario = $datos_usuario['id'];
        $nombre = $datos_usuario['nom_persona'];
        $usuario = $datos_usuario['usuario'];
        $email = $datos_usuario['email'];
        $nivel = $datos_usuario['tipo_usuario'];
        $id_estado = $datos_usuario['id_estado'];
        $telefono = $datos_usuario['telefono'];
        $id_seccion = $datos_usuario['id_seccion'];

        // Crear un array con los valores de permisos
        $permisos_array = array(
            'id_superior' => $datos_usuario['id_superior'],
            'per_niveles' => $datos_usuario['per_niveles'],
            'per_categoria' => $datos_usuario['per_categoria'],
            'per_tickets' => $datos_usuario['per_tickets'],
            'per_seccion' => $datos_usuario['per_seccion'],
            'per_con' => $datos_usuario['per_con'],
            'per_mistickets' => $datos_usuario['per_mistickets'],
            'per_crear' => $datos_usuario['per_crear'],
            'per_reserva' => $datos_usuario['per_reserva']
        );

        $_SESSION['datos_login'] = array(
            'usuario' => $usuario,
            'nombre' => $nombre,
            'id_usuario' => $id_usuario,
            'email' => $email,
            'telefono' => $telefono,
            'nivel' => $nivel,
            'permisos' => $permisos_array,
            'id_seccion' => $id_seccion,
            'id_estado' => $id_estado
            
        );

        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=Credenciales incorrectas");
    }
} else {
    header("../index.php");
}

?>