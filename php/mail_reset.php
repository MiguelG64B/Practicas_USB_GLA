<?php

// Varios destinatarios
$para  = $_POST['email']; // atención a la coma
//$para .= 'wez@example.com';

// título
$título = 'Recuperar contraseña';
$codigo = rand(1000, 9999);
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

// mensaje
$mensaje = '
<html>
<head>
  <title>Restablecer contraseña</title>
</head>
<body>
<div class="container">
<img src="https://gimnasiolosalmendros.edu.co/wp-content/uploads/2023/06/escudo.png" width="100" height="80" alt="Gimnasio Los Almendros" id="logo" data-height-percentage="100">
    <h1>Gimnasio Los Almendros</h1>
        <p>Recuperar contraseña</p>
        <h3>' . $codigo . '</h3>
        <p>Ingresa al link con para restablecer contraseña</p>
        <p> <a 
        href="https://localhost/py3/Practicas_USB_GLA/reset.php?email=' . $_POST['email'] . '&token=' . $token . '"> 
            Detalles </a> </p>
    </div>
</body>
</html>
';
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
