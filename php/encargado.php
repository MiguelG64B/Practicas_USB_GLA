<?php
include "./conexion.php";

if (isset($_POST['id']) && isset($_POST['encargado']) && isset($_POST['id_usuario'])) {
    $id = $_POST['id'];
    $id_usuario = $_POST['id_usuario'];
    $encargado = $_POST['encargado'];

    // Realiza una consulta para obtener el email del usuario
    $consulta = $conexion->prepare("SELECT email FROM usuarios WHERE id = ?");
    $consulta->bind_param("i", $id_usuario);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $email_usuario = $fila['email'];

        // Ahora puedes incluir mailtomaticket.php y utilizar $email_usuario según sea necesario
        include "./mailtomaticket.php"; // Correo notificando

        // Luego, actualiza la tabla de tickets
        $conexion->query("UPDATE tickets SET
            id_encargado='$encargado',
            id_estado='2'
            WHERE id_ticket='$id'") or die($conexion->error);

        header("Location: ../index.php?success");
    } else {
        header("Location: ../index.php?error=No se encontró el usuario");
    }
} else {
    header("Location: ../index.php?error=Favor de llenar todos los campos");
}

?>
