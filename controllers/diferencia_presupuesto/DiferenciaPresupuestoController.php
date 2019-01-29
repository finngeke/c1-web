<?php

namespace diferencia_presupuesto;

class DiferenciaPresupuestoController extends \Control
{

    // Listar Diferencia Presupuesto => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarDiferenciaPresupuesto($f3){
        echo json_encode(DiferenciaPresupuestoClass::ListarDiferenciaPresupuesto($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }





// Termina Clase
}