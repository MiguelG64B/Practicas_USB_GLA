<?php
// Varios destinatarios
$para = $email_usuario; // Usar la variable $email_usuario como destinatario

// Título
$título = 'Ticket tomado';

// Estilos CSS en línea
$estilos = '
<style>
    body {
        background-color: #609966; /* Fondo verde */
        font-family: Arial, sans-serif; /* Fuente moderna */
    }
    .container {
        text-align: center;
        background-color: #fff; /* Fondo blanco */
        padding: 20px;
        border-radius: 10px; /* Bordes redondeados */
        margin: 0 auto; /* Centrar el contenido horizontalmente */
        max-width: 600px; /* Ancho máximo del contenedor */
    }
</style>
';

// Mensaje
$mensaje = '
<html>
<head>
  <title>Ticket Tomado</title>
</head>
<body>
    <div class="container">
        <h1>Gimnasio Los Almendros</h1>
        <p>Ticket Tomado</p>
        <p>Su ticket ha sido tomado para más detalles, por favor ingrese a la plataforma para mas detalles.</p>
    </div>
</body>
</html>
';

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n"; // Usar UTF-8 para caracteres latinos

// Agregar los estilos CSS en línea al mensaje
$mensaje = $estilos . $mensaje;

$cabeceras .= 'From: proyecto@software.com' . "\r\n";

// Enviar correo electrónico
$enviado = false;
if (mail($para, $título, $mensaje, $cabeceras)) {
    $enviado = true;
}

// Puedes agregar una lógica adicional aquí para manejar la respuesta de envío de correo
?>
