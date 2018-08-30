<?php

/**
 * Descripción: 
 * Fecha: 2018-05-09
 */

namespace usuario;

class Control_usuario_cambios  {

    // funciones el modulo de asignar departamentos//
    public function trae_datos_cambio($f3) {
        echo json_encode(\usuario\usuario_cambio::trae_datos_cambio($f3->get('SESSION.login')) );
    }

    public function actualizar_clave($f3) {
        echo \usuario\usuario_cambio::actualizar_clave($f3->get('SESSION.login'),$f3->get('GET.CLAVE'));
    }

}
