<?php
// Asegúrate de que $email_usuario esté definido y tenga un valor válido
if (isset($email_usuario) && filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {

    // Dirección de correo electrónico del destinatario
    $para = $email_usuario;

    // Asunto del correo
    $título = 'Ticket tomado';

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

    // Contenido del mensaje
    $mensaje = '
    <html>
    <head>
        <title>Ticket Tomado</title>
    </head>
    <body>
        <div class="container">
            <h1>Gimnasio Los Almendros</h1>
            <p>Ticket Tomado</p>
            <p>Su ticket ha sido tomado. Para más detalles, por favor, ingrese a la plataforma.</p>
        </div>
    </body>
    </html>
    ';

    // Cabeceras del correo
    $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n"; // Usar UTF-8 para caracteres latinos
    $cabeceras .= 'From: proyecto@software.com' . "\r\n";

    // Agregar los estilos CSS en línea al mensaje
    $mensaje = $estilos . $mensaje;

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
