<?php

namespace resumen_estilos;

use log_transaccion\LogTransaccionClass;

class ResumenEstilosClass extends \parametros
{

    // Listar Resumen Estilos => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarResumenEstilos($temporada, $depto,$login,$pais)
    {

        $sql = "SELECT CAMPO1,CAMPO3,CAMPO3 FROM TABLA";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                 "CAMPO1" => $val[0]
                ,"CAMPO2" => $val[1]
                ,"CAMPO3" => utf8_encode($val[2]) // UTF-8 Si me Trae String
                )
            );
        }

        return $array;

    }


    // Listar Temporada
    public static function ListarTemporada($login,$pais)
    {

        $sql = "SELECT COD_TEMPORADA, NOM_TEMPORADA_CORTO FROM PLC_TEMPORADA ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                    "COD_TEMPORADA" => $val[0]
                ,"NOM_TEMPORADA_CORTO" => utf8_encode($val[1]) // UTF-8 Si me Trae String
                )
            );
        }

        return $array;

    }

    // Listar Ventana
    public static function ListarVentana($login,$pais)
    {

        $sql = "SELECT COD_VENTANA, VENT_DESCRI FROM plc_ventana ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                    "COD_VENTANA" => $val[0]
                ,"VENT_DESCRI" => utf8_encode($val[1]) // UTF-8 Si me Trae String
                )
            );
        }

        return $array;

    }




// Fin de la Clase
}