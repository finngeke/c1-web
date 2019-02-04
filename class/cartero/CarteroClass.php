<?php

namespace cartero;

use log_transaccion\LogTransaccionClass;

class CarteroClass extends \parametros
{

    public static function EnviarCorreo($destinatadio, $asunto,$mensaje)
    {

        require("../mailer/src/PHPMailer.php");
        $mail = new PHPMailer();

        //Luego tenemos que iniciar la validación por SMTP:
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.ripley.com"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
        $mail->Username = "lrobertop@ripley.com"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente.
        $mail->Password = "Ripley2019"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
        $mail->Port = 465; // Puerto de conexión al servidor de envio.
        $mail->From = "lrobertop@ripley.com"; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
        $mail->FromName = "Roberto Pérez"; //A RELLENAR Nombre a mostrar del remitente.
        $mail->AddAddress($destinatadio); // Esta es la dirección a donde enviamos
        $mail->IsHTML(true); // El correo se envía como HTML
        $mail->Subject = $asunto; // Este es el titulo del email.
        $body = $mensaje;

        $mail->Body = $body; // Mensaje a enviar.

        $exito = $mail->Send(); // Envía el correo.

        if($exito){
            echo 'Correo enviado correctamente';
        } else {
            echo 'Error al enviar correo';
        }


    // Fin EniarCorreo
    }


// Fin de la Clase
}