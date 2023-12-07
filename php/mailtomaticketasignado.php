<?php
// Asegúrate de que $email_encargado esté definido y tenga un valor válido
if (isset($email_encargado) && filter_var($email_encargado, FILTER_VALIDATE_EMAIL)) {

    // Dirección de correo electrónico del destinatario
    $para = $email_encargado;

    // Asunto del correo
    $título = 'Ticket Asignado';

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
        <title>Ticket Asignado</title>
    </head>
    <body>
        <div class="container">
        <img src="https://gimnasiolosalmendros.edu.co/wp-content/uploads/2023/06/escudo.png" width="100" height="80" alt="Gimnasio Los Almendros" id="logo" data-height-percentage="100">
            <h1>Gimnasio Los Almendros</h1>
            <p>Ticket Asignado</p>
            <p>Se te ha asignado un ticket. Para más detalles, por favor, ingrese a la plataforma a Mis solicitudes.</p>
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
