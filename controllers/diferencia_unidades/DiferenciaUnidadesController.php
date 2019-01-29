<?php

namespace diferencia_unidades;

class DiferenciaUnidadesController extends \Control
{

    // Listar Diferencia Unidades => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarDiferenciaUnidades($f3){
        echo json_encode(DiferenciaUnidadesClass::ListarDiferenciaUnidades($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }





// Termina Clase
}