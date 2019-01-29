<?php

namespace resumen_estilos;

class ResumenEstilosController extends \Control
{

    // Listar Resumen Estilos => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarResumenEstilos($f3){
        echo json_encode(ResumenEstilosClass::ListarResumenEstilos($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }





// Termina Clase
}