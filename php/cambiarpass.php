<?php
include "conexion.php";
$id_usuario = $_POST['id_usuario']; // Cambiamos $email por $id_usuario
$p1 = $_POST['p1'];
$p2 = $_POST['p2'];
if ($p1 == $p2) {
    $p1 = sha1($p1);
    $conexion->query("update usuarios set password='$p1' where id='$id_usuario' ") or die($conexion->error);
    header("Location: ../perfil.php?todobien=Contraseña cambiada, ya puedes iniciar sesión.");
} else {
    header("Location: ../perfil.php?error=Contraseñas no coinciden"); 
}
?>
