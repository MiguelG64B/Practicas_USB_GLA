<?php
include "conexion.php";

if (isset($_POST['id_usuario']) && isset($_POST['id_reserva']) && isset($_POST['titulo']) && isset($_POST['id_libro'])) {
    // Obtén el correo electrónico desde la base de datos según el ID de usuario
    $idUsuario = $_POST['id_usuario'];
    $query = "SELECT email FROM usuarios WHERE id = $idUsuario";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $usuario = mysqli_fetch_assoc($resultado);
        $email = $usuario['email'];

        // Contenido del correo electrónico
        $titulo = $_POST['titulo'];
        $mensaje = "
        <html>
        <head>
        <title>Entrega de libro</title>
        </head>
        <body>
        <div class='container'>
            <h1>Gimnasio Los Almendros</h1>
            <p>Reserva del libro $titulo</p>
            <p>Su reserva ha sido solicitada para una pronta entrega. Para más detalles, por favor, ingrese a sus reservas en la plataforma.</p>
        </div>
        </body>
        </html>
        ";

        // Envía el correo electrónico
        $asunto = "Entrega de libro - Gimnasio Los Almendros";
        $headers = "From: tu_correo@example.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($email, $asunto, $mensaje, $headers);

      

        echo "¡Correo electrónico enviado correctamente!";
        header("Location: ../reservas.php?success");
    } else {
        echo "Error en la consulta a la base de datos: " . mysqli_error($conexion);
    }
} else {
    echo "Datos incompletos recibidos.";
}
?>
