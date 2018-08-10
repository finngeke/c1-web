<?php

$email_from="rriosec@utem.cl";
$email_to = "rriosec@utem.cl";
$email_subject = "Contacto desde el sitio web";

$email_message = "Detalles del formulario de contacto:\n\n";
$email_message .= "Nombre: 12312312\n";
$email_message .= "Apellido: 123123\n";
$email_message .= "E-mail: rriosec@utem.cl\n";
$email_message .= "Teléfono: 12312312\n";
$email_message .= "Comentarios: 213\n\n";


// Ahora se envía el e-mail usando la función mail() de PHP
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);

echo "¡El formulario se ha enviado con éxito!";
?>