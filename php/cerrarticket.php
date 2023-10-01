<?php
include "./conexion.php";

if (
    isset($_POST['id']) &&
    isset($_POST['editor']) &&
    isset($_POST['estado']) &&
    isset($_POST['id_usuario'])
) {
    $id = $_POST['id'];
    $id_usuario = $_POST['id_usuario'];
    $editor = $_POST['editor'];
    $estado = $_POST['estado'];
    $fecha = date('Y-m-d');

    // Realiza toma de la prueba
    $carpeta = "../images/";
    $nombre = $_FILES['imagen']['name'];
    $temp = explode('.', $nombre);
    $extension = end($temp);
    $nombreFinal = time() . '.' . $extension;

    // Realiza una consulta para obtener el email del usuario
    $consulta = $conexion->prepare("SELECT email FROM usuarios WHERE id = ?");
    $consulta->bind_param("i", $id_usuario);
    $consulta->execute();
    $resultado = $consulta->get_result();
    move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta . $nombreFinal);
    if ($extension == 'jpg' || $extension == 'png') {
            if ($fila = $resultado->fetch_assoc()) {
                $email_usuario = $fila['email'];

                // Ahora puedes incluir mailtomaticket.php y utilizar $email_usuario según sea necesario
                include "./mailcerrarticket.php"; // Correo notificando

                // Luego, actualiza la tabla de tickets
                $conexion->query("UPDATE tickets SET
                coment_encargado='$editor',
                coment_usuario='N/A',
                imagen='$nombreFinal',
                id_estado='$estado'
                WHERE id_ticket='$id'") or die($conexion->error);

                header("Location: ../index.php?success");
            } else {
                header("Location: ../index.php?error=No se encontró el usuario");
            }
    } else {
        header("Location: ../index.php?error=El formato de imagen no es válido (solo se permiten JPG y PNG)");
    }
} else {
    header("Location: ../index.php?error=Favor de llenar todos los campos");
}
?>
