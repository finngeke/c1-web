<?php

namespace diferencia_fechas;

class DiferenciaFechasController extends \Control
{

    // Listar Diferencia Fechas => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarDiferenciaFechas($f3){
        echo json_encode(DiferenciaFechasClass::ListarDiferenciaFechas($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }





// Termina Clase
}