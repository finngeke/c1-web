<?php

namespace diferencia_unidades;

class DiferenciaUnidadesController extends \Control
{

    // Listar Diferencia Unidades => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarDiferenciaUnidades($f3){


        echo json_encode(DiferenciaUnidadesClass::ListarDiferenciaUnidades($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPARTAMENTO'),$f3->get('GET.VENTANA')));
    }

    // Listar Temporada
    public function ListarTemporada($f3){
        echo json_encode(DiferenciaUnidadesClass::ListarTemporada($f3->get('SESSION.login'),1));
    }

    // Listar Ventana
    public function ListarVentana($f3){
        echo json_encode(DiferenciaUnidadesClass::ListarVentana($f3->get('SESSION.login'),1));
    }

    // Listar Depto
    public function ListarDepto($f3){
        echo json_encode(DiferenciaUnidadesClass::ListarDepto($f3->get('SESSION.login'),1));
    }





// Termina Clase
}