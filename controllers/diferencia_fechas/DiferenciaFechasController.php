<?php

namespace diferencia_fechas;

class DiferenciaFechasController extends \Control
{

    // Listar Diferencia Fechas => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarDiferenciaFechas($f3){
        echo json_encode(DiferenciaFechasClass::ListarDiferenciaFechas($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.login'),1));
    }

    // Listar Temporada
    public function ListarTemporada($f3){
        echo json_encode(DiferenciaFechasClass::ListarTemporada($f3->get('SESSION.login'),1));
    }

    // Listar Ventana
    public function ListarVentana($f3){
        echo json_encode(DiferenciaFechasClass::ListarVentana($f3->get('SESSION.login'),1));
    }

    // Listar Depto
    public function ListarDepto($f3){
        echo json_encode(DiferenciaFechasClass::ListarDepto($f3->get('SESSION.login'),1));
    }

    //Aprobar los registros seleccionados
    public function aprobar($f3){
        echo json_encode(DiferenciaFechasClass::aprobar_fechas($_GET['SELECCION'],$f3->get('SESSION.login'),1));
    }

    //Aprobar los registros seleccionados
    public function rechazar($f3){
        echo json_encode(DiferenciaFechasClass::rechazar_fechas($_GET['SELECCION'],$f3->get('SESSION.login'),1));
    }


// Termina Clase
}