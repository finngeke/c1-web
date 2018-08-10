<?php
/*
 * CONTROLADOR de AJAX
 * Descripción: Permite consultar y posteriormente listar, información asociada a tiendas disponibles y asignadas 
 * Fecha: 23-03-2018
 * @author ROBERTO PÉREZ
 */

namespace mantenedores;

class ControlDeptoMarca extends \Control {

    // Llenar Division
    public function obtiene_division($f3) {
           echo json_encode(\simulador_compra\deptomarca::obtiene_division($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO')));
    }

    // Llenar Depto
    public function obtiene_depto($f3) {
        echo json_encode(\simulador_compra\deptomarca::obtiene_depto($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.DIVISION')));
    }

    // Llenar Marca
    public function obtiene_marca($f3) {
        echo json_encode(\simulador_compra\deptomarca::obtiene_marca($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.DIVISION'),$f3->get('GET.DEPTO'),$f3->get('GET.TIPO')));
    }

     // Agregar Marca
    public function agrega_marca($f3) {
       echo \simulador_compra\deptomarca::agrega_marca($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.DIVISION'),$f3->get('GET.NOM_DIVISION'),$f3->get('GET.DEPTO'),$f3->get('GET.NOM_DEPTO'),$f3->get('GET.MARCA'),$f3->get('GET.NOM_MARCA'),$f3->get('SESSION.login'));
    }

    // Quitar Marca
    public function quitar_marca($f3) {
        echo \simulador_compra\deptomarca::quitar_marca($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.DIVISION'),$f3->get('GET.DEPTO'),$f3->get('GET.MARCA'),$f3->get('SESSION.login'));
    }



}
