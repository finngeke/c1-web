<?php

/**
 * CLASS Division
 * Descripción: Obtiene temporadas de la tabla GST_MAEDIVISI
 * Fecha: 2018-02-19
 * @author EDUARDO PACHECO
 */

namespace jerarquia;

class division extends \parametros {

    protected static $_table = 'GST_MAEDIVISI';
    protected static $_pk = 'DIV_DIVISION';
    protected static $_parametro = 'DIV_DESCRIPCION';

    /**
     * Constructor de clase     
     */
    public function __construct() {
        call_user_func_array(array('parent', '__construct'), func_get_args());
    }

    public static function getListaDivisiones() {

        $data = \database::getInstancia()->getFilas("SELECT DIV_DIVISION, DIV_DESCRIPCION"
                  ." FROM   GST_MAEDIVISI where DIV_DIVISION not in('G05','G08','G07','G10')"
                  ." ORDER BY DIV_DESCRIPCION");
       
        return $data;
    }
    
    
}
