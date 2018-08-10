<?php

/**
 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
 * Descripción: 
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 */

namespace temporada;

class ControlFechaRecepcion extends \Control {

    // Guardar
    public function guarda_fecha_recepcion($f3) {
        echo \temporada\fecha_recepcion::guardarFechaRecepcion($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.VENTANA'),$f3->get('GET.RECEPCION'),$f3->get('GET.VENTA'),$f3->get('GET.USER'),$f3->get('SESSION.login'));
    }

    // Quitar todos
    public function quitar_fecha_recepcion($f3) {
        echo \temporada\fecha_recepcion::quitarFechaRecepcion($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.USER'),$f3->get('SESSION.login'));
    }

    // Quitar ventana
    public function quitar_ventana_recepcion($f3) {
        echo \temporada\fecha_recepcion::quitarVentanaRecepcion($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.VENTANA'),$f3->get('GET.USER'),$f3->get('SESSION.login'));
    }

    // Listar las fechas de recepcion
    public function listar_ventana_recepcion($f3) {
        echo json_encode(\temporada\fecha_recepcion::getListafecharecepcion($f3->get('SESSION.COD_TEMPORADA')));
    }

    // COntar Regsitro
    public function contarRegistros($f3) {
        echo json_encode(\temporada\fecha_recepcion::contarRegistros($f3->get('SESSION.COD_TEMPORADA')));
    }

}
