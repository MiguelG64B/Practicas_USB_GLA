<?php
// Asegúrate de que $email_usuario esté definido y sea una dirección de correo electrónico válida
if (isset($email_usuario) && filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
    // Varios destinatarios
    $para = $email_usuario;

    // Contenido dinámico
    $comentarios = $editor;
    $estado;
    $ticket = $id;

    // Corregir después
    if ($estado == 3) {
        $nombre_estado = 'Denegado';
    } else {
        $nombre_estado = 'Finalizado';
    }

    $título = 'Ticket ' . $nombre_estado;

    // Estilos CSS en línea
    $estilos = '
    <style>
        body {
            background-color: #609966;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 0 auto;
            max-width: 600px;
        }
    </style>
    ';

    // Mensaje
    $mensaje = '
    <html>
    <head>
    <title>Ticket ' . $nombre_estado . '</title>
    </head>
    <body>
    <div class="container">
        <h1>Gimnasio Los Almendros</h1>
        <p>Ticket ' . $nombre_estado . '</p>
        <p>Su ticket ha sido ' . $nombre_estado . ' para más detalles. Por favor, ingrese al siguiente link para indicar sus opiniones:</p>
        <p><a href="https://localhost/py3/Practicas_USB_GLA/satisfaccion.php?id=' . $ticket . '&comentarios=' . $comentarios . '">Detalles</a></p>
    </div>
    </body>
    </html>
    ';

    // Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n"; // Usar UTF-8 para caracteres latinos

    // Agregar los estilos CSS en línea al mensaje
    $mensaje = $estilos . $mensaje;

    $cabeceras .= 'From: proyecto@software.com' . "\r\n";

    // Enviar correo electrónico
    $enviado = mail($para, $título, $mensaje, $cabeceras);

    // Verificar si el correo se envió correctamente
    if ($enviado) {
        echo "¡Correo electrónico enviado correctamente!";
    } else {
        echo "Error al enviar el correo.";
    }
} else {
    echo "Dirección de correo electrónico no válida.";
}
?>
