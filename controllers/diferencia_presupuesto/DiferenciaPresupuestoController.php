<?php

namespace diferencia_presupuesto;

class DiferenciaPresupuestoController extends \Control
{

    // Listar Diferencia Presupuesto => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarDiferenciaPresupuesto($f3){
        echo json_encode(DiferenciaPresupuestoClass::ListarDiferenciaPresupuesto($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }


    // Listar Temporada
    public function ListarTemporada($f3){
        echo json_encode(DiferenciaPresupuestoClass::ListarTemporada($f3->get('SESSION.login'),1));
    }

    // Listar Ventana
    public function ListarVentana($f3){
        echo json_encode(DiferenciaPresupuestoClass::ListarVentana($f3->get('SESSION.login'),1));
    }

    // Listar Depto
    public function ListarDepto($f3){
        echo json_encode(DiferenciaPresupuestoClass::ListarDepto($f3->get('SESSION.login'),1));
    }





// Termina Clase
}