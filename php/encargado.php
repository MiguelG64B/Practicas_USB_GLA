<?php
include "./conexion.php";

if (isset($_POST['id']) && isset($_POST['encargado']) && isset($_POST['id_usuario'])) {
    $id = $_POST['id'];
    $id_usuario = $_POST['id_usuario'];
    $encargado = $_POST['encargado'];

    // Consulta para obtener el email del usuario asociado a $id_usuario
    $consulta_usuario = $conexion->prepare("SELECT email FROM usuarios WHERE id = ?");
    $consulta_usuario->bind_param("i", $id_usuario);
    $consulta_usuario->execute();
    $resultado_usuario = $consulta_usuario->get_result();

    if ($fila_usuario = $resultado_usuario->fetch_assoc()) {
        $email_usuario = $fila_usuario['email'];

        // Consulta para obtener el email del encargado
        $consulta_encargado = $conexion->prepare("SELECT email FROM usuarios WHERE id = ?");
        $consulta_encargado->bind_param("i", $encargado);
        $consulta_encargado->execute();
        $resultado_encargado = $consulta_encargado->get_result();

        if ($fila_encargado = $resultado_encargado->fetch_assoc()) {
            $email_encargado = $fila_encargado['email'];

            // Ahora puedes incluir mailtomaticket.php y utilizar $email_usuario y $email_encargado según sea necesario
            include "./mailtomaticket.php"; // Correo notificando
            include "./mailtomaticketasignado.php"; // Correo notificando


            // Luego, actualiza la tabla de tickets
            $conexion->query("UPDATE tickets SET
                id_encargado='$encargado',
                id_estado='2'
                WHERE id_ticket='$id'") or die($conexion->error);

            header("Location: ../index.php?success");
        } else {
            header("Location: ../index.php?error=No se encontró el encargado");
        }
    } else {
        header("Location: ../index.php?error=No se encontró el usuario");
    }
} else {
    header("Location: ../index.php?error=Favor de llenar todos los campos");
}
?>
