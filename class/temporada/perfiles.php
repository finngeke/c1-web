<?php

/**
 * CLASS Temporada
 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
 * Fecha: 2018-02-07
 * @author RODRIGO RIOSECO
 */

namespace temporada;

class perfiles extends \parametros {

    protected static $_table = 'PLC_TIPO_USUARIO';
    protected static $_pk = 'COD_TIPUSR';
    protected static $_parametro = 'TIPO_USR';

    /**
     * Constructor de clase     
     */
    public function __construct() {
        call_user_func_array(array('parent', '__construct'), func_get_args());
    }

}
