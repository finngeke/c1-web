<?php

namespace html;

use html\select;

class meses {

    /**
     * Arreglo con los nombres de los meses
     * @var array
     */
    static $meses = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio'
        , 7 => 'Julio', 8 => 'Agosto', 9 => "Septiembre", 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');

    /**
     * Obtiene un combo con los meses
     * @return \html\select
     */
    public static function getComboFull() {
        return new select(self::getArray(), 'numero', 'texto');
    }

    /**
     * Obtiene un arreglo compatible para los combos
     * @return array
     */
    public static function getArray() {
        return array_map(function($i, $v) {
            return array('numero' => $i, 'texto' => $v);
        }, array_keys(self::$meses), array_values(self::$meses));
    }

    /**
     * Obtiene el nombre de un mes
     * @param int $mes
     * @return string
     */
    public static function getMes($mes) {
        return self::$meses[$mes];
    }

}
