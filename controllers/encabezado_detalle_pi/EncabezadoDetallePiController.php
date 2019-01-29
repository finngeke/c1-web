<?php

namespace encabezado_detalle_pi;

class EncabezadoDetallePiController extends \Control
{

    // Listar PI => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarPi($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarPi($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }

    // Listar Opción => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarOpcion($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarOpcion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }

    // Listar Variación => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarVariacion($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarVariacion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }




// Termina Clase
}