<?php

namespace simulador_compra;

class LogTransaccionController extends \Control
{

    // Almacena Log Transacción
    public function GuardaLogTransaccion($f3) {

        $array_data = $_GET;
        echo \log_transaccion\LogTransaccionClass::GuardaLogTransaccion($f3->get('SESSION.login'),$f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.MODULO'), $f3->get('GET.ACCION'), $f3->get('GET.QUERY'), $f3->get('GET.MENSAJE'));

    }



// Termina Clase
}