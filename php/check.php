<?php 
session_start();
include "./conexion.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    $resultado = $conexion->query("SELECT * FROM usuarios WHERE 
        email='" . $_POST['email'] . "' AND 
        password='" . $_POST['password'] . "' LIMIT 1") or die($conexion->error);

    if (mysqli_num_rows($resultado) > 0) {
        $datos_usuario = mysqli_fetch_row($resultado);
        $id_usuario = $datos_usuario[0];
        $nombre = $datos_usuario[2];
        $email = $datos_usuario[4];
        $nivel = $datos_usuario[6];
        $telefono = $datos_usuario[7];
        $id_permiso = $datos_usuario[8];

        // Consulta para obtener los datos de permisos
        $permisos_resultado = $conexion->query("SELECT * FROM permisos WHERE id_usuario = $id_usuario") or die($conexion->error);
        $datos_permisos = mysqli_fetch_assoc($permisos_resultado);

        // Crear un array con los valores de permisos
        $permisos_array = array(
            'id_superior' => $datos_permisos['id_superior'],
            'per_niveles' => $datos_permisos['per_niveles'],
            'per_categoria' => $datos_permisos['per_categoria'],
            'per_tickets' => $datos_permisos['per_tickets'],
            'per_libros' => $datos_permisos['per_libros'],
            'per_conlibro' => $datos_permisos['per_conlibro'],
            'per_mistickets' => $datos_permisos['per_mistickets']
        );

        $_SESSION['datos_login'] = array(
            'nombre' => $nombre,
            'id_usuario' => $id_usuario,
            'email' => $email,
            'telefono' => $telefono,
            'nivel' => $nivel,
            'permisos' => $permisos_array  // Agregar el array de permisos al array de sesión
        );

        header("Location: ../index.php");
    } else {
        header("Location: ../login.php?error=Credenciales incorrectas");
    }
} else {
    header("../index.php");
}


?>