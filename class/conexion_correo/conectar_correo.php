<?php

namespace conexion_correo;

class conectar_correo {

    private $inbox;
    private $host;

    public function __construct($hostname, $username, $password) {

        set_time_limit(3000);

        /* try to connect */
        $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Zimbra: ' . imap_last_error());

        $this->inbox = $inbox;
        $this->host = $hostname;
    }

    public function obtenerCorreos($filtro, $cont) {
        //SUBJECT "soporte"
    
        $emails = imap_search($this->inbox, 'SUBJECT "soporte"');
        //$emails = imap_search($this->inbox, '');


        /* useful only if the above search is set to 'ALL' */
        $max_emails = $cont;
       
        /* if any emails found, iterate through each email */
        if (count($emails)>1) {
            $count = 1;
            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */

            foreach ($emails as $email_number) {

                /* get information specific to this email */
                $overview = imap_fetch_overview($this->inbox, $email_number, 0);
                $codigo = explode("<", $overview[0]->from);


                $struct = imap_fetchstructure($this->inbox, $email_number);

                // $status = imap_setflag_full($this->inbox, $email_number, "\\Unseen"); //,"\\Seen"); Funcion que los deja leidos por defecto


                if ($struct->subtype !== 'PLAIN') {

                    $message = quoted_printable_decode(imap_fetchbody($this->inbox, $email_number, 1));
                } else {
                    $message = imap_fetchbody($this->inbox, $email_number, 1);

                    switch ($struct->encoding) {
                        case 0:
                            $message = utf8_decode($message);
                            break;
                        case 1:
                            $message = imap_8bit($message);
                            break;
                        case 2:
                            $message = imap_binary($message);
                            break;
                        case 3:
                            $message = imap_base64($message);
                            break;
                        case 4:
                            $message = imap_qprint($message);
                            break;
                    }
                }

                if (\soporte\solicitud::existeCorreoSolicitud((int) $email_number) == 0) {

                    $correo[] = array('nombre' => $codigo[0],
                        'correo' => str_replace('>', '', $codigo[1]),
                        'fecha' => date("Y-m-d H:i:s", strtotime($overview[0]->date)),
                        'cuerpo' => substr($message, 0, 800),
                        'id_mail' => $email_number
                    );
                }/* else{
                  $correo=0;
                  } */


                if ($count++ >= $max_emails)
                    break;
            }
            return $correo;
        }else {
            return 0;
        }
    }

    public function cuentaCorreos() {
        //SUBJECT "soporte"
        $emails = imap_search($this->inbox, 'SUBJECT "soporte"');

        return count($emails);
    }

    public function marcarCorreoComoLeido($id_mail) {
        imap_setflag_full($this->inbox, trim($id_mail), '\\Seen');
    }

    public function cerrar_conexion() {
        imap_close($this->inbox);
    }

    public static function enviaRespuestaUsuario($mail, $asunto, $msg, $correo_usuario) {


        $body = $msg;

        $mail->IsSMTP();

        $mail->Host = "smtp.gmail.com";

        $mail->From = "crs.helpdesk.utem@gmail.com";

        $mail->FromName = "CRS HELPDESK";

        $mail->Subject = $asunto;
        $mail->AltBody = $msg;

        $mail->MsgHTML($body);

        $mail->AddAddress($correo_usuario);

        $mail->SMTPAuth = true;

        $mail->Username = "crs.helpdesk.utem@gmail.com";
        $mail->Password = "crs123456";
        $mail->Send();
        /* if (!$mail->Send()) {
          echo "Error enviando: " . $mail->ErrorInfo;
          } else {
          echo "ok";
          } */
    }

}
