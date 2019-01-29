<?php

namespace diferencia_unidades;

use log_transaccion\LogTransaccionClass;

class MantenedorProveedorClass extends \parametros
{

    // // Listar Diferencia Unidades => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarDiferenciaUnidades($temporada, $depto,$login,$pais)
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







// Fin de la Clase
}