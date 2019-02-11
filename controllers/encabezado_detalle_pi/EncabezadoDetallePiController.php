<?php

namespace encabezado_detalle_pi;

class EncabezadoDetallePiController extends \Control
{

    // Listar Encabezado Oantalla 5 => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarP5Encabezado($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarP5Encabezado($f3->get('SESSION.login'),1));
    }

    // Listar Cuerpo
    public function ListarP5Cuerpo($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarP5Cuerpo($f3->get('SESSION.login'),$f3->get('GET.COD_MOD_PAIS'),$f3->get('GET.PROFORMA')));
    }

    // Listar Opción => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarOpcion($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarOpcion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }

    // Listar Variación => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarVariacion($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarVariacion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }

    // Listar Temporada
    public function ListarTemporada($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarTemporada($f3->get('SESSION.login'),1));
    }

    // Listar Ventana
    public function ListarVentana($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarVentana($f3->get('SESSION.login'),1));
    }

    // Listar Depto
    public function ListarDepto($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarDepto($f3->get('SESSION.login'),1));
    }

    // Listar Incoterm COD_PROVEEDOR
    public function ListarIncoterm($f3){
        echo json_encode(EncabezadoDetallePiClass::ListarIncoterm($f3->get('SESSION.login'),1));
    }

// Termina Clase
}