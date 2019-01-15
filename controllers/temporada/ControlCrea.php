<?php

/**
 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
 * Descripción:
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 */

namespace temporada;

class ControlCrea extends \Control
{

    public function temporada($f3)
    {

        /* echo $f3->get('POST.cod_temp') . '<br>';
          echo $f3->get('POST.nombre_corto') . '<br>';
          echo $f3->get('POST.descripcion') . '<br>';

          echo (int) temporada::existeTemporada($f3->get('POST.cod_temp'));
          die(); */


        $accion = $f3->get('POST.cod_temp') == '' ? 0 : 1;

        if ($accion == 1 && (int)temporada::existeTemporada($f3->get('POST.cod_temp')) >= 1) {
            if (temporada::modificarTemporada($f3->get('SESSION.login'), $f3->get('POST.cod_temp'), $f3->get('POST.nombre_corto'), $f3->get('POST.anno'), $f3->get('POST.descripcion'))) {
                $f3->set('SESSION.modifica', 'exito_modificacion');
            } else {
                $f3->set('SESSION.error', 'error');
            }
        } else {
            if (temporada::crearTemporada($f3->get('SESSION.login'), $f3->get('POST.nombre_corto'), $f3->get('POST.anno'), $f3->get('POST.descripcion'))) {
                $f3->set('SESSION.exito', 'exito');
            } else {
                $f3->set('SESSION.error', 'error');
            }
        }

        $f3->reroute('/temporada_compra');
    }


    public function List_factor_Importacion($f3){
        echo json_encode(temporada::List_factor_Importacion($f3->get('SESSION.COD_TEMPORADA')));

    }

    public function beforeRoute($f3)
    {
        if ($f3->exists('SESSION.login') == false) {
            $f3->reroute('/fin-sesion');
        }
    }


// Fin de la clase
}
