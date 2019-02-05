<?php

namespace cartero;

require_once '../../class/mailer/src/PHPMailer.php';

use log_transaccion\LogTransaccionClass;

class CarteroClass extends \parametros
{

    public static function EnviarCorreo($destinatadio, $asunto,$mensaje)
    {


        $mail = new PHPMailer();

        //Luego tenemos que iniciar la validación por SMTP:
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "mail.ripley.com";
        $mail->Username = "lrobertop@ripley.com";
        $mail->Password = "Ripley0119";
        $mail->Port = 465;
        $mail->From = "lrobertop@ripley.com";
        $mail->FromName = "Roberto Pérez";
        $mail->AddAddress($destinatadio);
        $mail->IsHTML(true);
        $mail->Subject = $asunto;
        $body = $mensaje;

        $mail->Body = $body;

        $exito = $mail->Send();

        if($exito){
            echo 'Correo enviado correctamente';
        } else {
            echo 'Error al enviar correo';
        }


    // Fin EniarCorreo
    }


// Fin de la Clase
}