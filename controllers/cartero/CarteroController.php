<?php

namespace cartero;

class CarteroController extends \Control
{

    public function EnviarCorreo($f3){
        echo json_encode(CarteroClass::EnviarCorreo($f3->get('GET.DESTINATARIO'), $f3->get('GET.ASUNTO'),$f3->get('GET.MENSAJE')));
    }






// Termina Clase
}