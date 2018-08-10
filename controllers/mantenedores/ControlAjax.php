<?php

/**
 * CONTROLADOR de AJAX Formulario de USURAIO
 * Descripción: 
 * Fecha: 2018-02-14
 * @author RODRIGO RIOSECO
 */

namespace mantenedores;

class ControlAjax extends \Control {

    public function agrega($f3) {
        $columns = array('name' => 'first_name');
        echo json_encode($columns);
        die();

        try {
            return (\jerarquia\departamento::getDepartamentoDivision(7, $f3->get('GET.division')));
        } catch (Exception $ex) {
            echo 'ERROR-En el cursor PRC_LIST_MSTPACK.';
        }
    }

    public function obtiene_departamentos($f3) {

        if ($f3->get('GET.division') !== '0') {
            echo json_encode(\jerarquia\departamento::getDepartamentosPorDivision($f3->get('GET.division')));
        }
    }

    public function obtiene_lineas($f3) {
        if ($f3->get('GET.depto') !== '0') {
            echo json_encode(\jerarquia\departamento::getLineas($f3->get('GET.depto')));
        }
    }

    public function obtiene_Sublineas($f3) {
        if ($f3->get('GET.linea') !== '0') {
            echo json_encode(\jerarquia\departamento::getSubLineas($f3->get('GET.linea')));
        }
    }
    
    public function agrega_depto_master_pack($f3) {
        
        $cadena = explode("$", $f3->get('GET.codigos'));
        
        
        echo \jerarquia\departamento::almacenaDeptoMaster($cadena[0], $cadena[1], $cadena[2]);
        
    }

}
