<?php

/**
 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
 * Descripción: 
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 */

namespace tipo_cambio;

class ControlCrea extends \Control {

    public function tipo_cambio($f3) {

        $cod_moneda = $f3->get('POST.moneda');
        $a = $f3->get('POST.a');
        $b = $f3->get('POST.b');
        $c = $f3->get('POST.c');
        $d = $f3->get('POST.d');
        $e = $f3->get('POST.e');
        $f = $f3->get('POST.f');
        $g = $f3->get('POST.g');
        $h = $f3->get('POST.h');
        $i = $f3->get('POST.i');

        $key = 0;

        foreach ($f3->get('POST.a') as $val) {

            $valida = (int) \temporada\factor_estimado::existeTipoCambio($f3->get('SESSION.COD_TEMPORADA'), $cod_moneda[$key]);
            try {
                \temporada\factor_estimado::guardaTipoCambio($f3->get('SESSION.login'), $f3->get('SESSION.COD_TEMPORADA'), $cod_moneda[$key], $a[$key], $b[$key], $c[$key], $d[$key], $e[$key], $f[$key], $g[$key], $h[$key], $i[$key], $valida);
            } catch (Exception $ex) {
                $f3->set('SESSION.error', 'error');
                $f3->reroute('/factor_estimado');
            }
            $key++;
        }
        
         \temporada\calculos::RecarcularFactorEst($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'));
        $f3->set('SESSION.modifica', 'exito_modificacion');
        $f3->reroute('/factor_estimado');
    }


    public function beforeRoute($f3) {
        if ($f3->exists('SESSION.login') == false) {
            $f3->reroute('/fin-sesion');
        }
    }

}
