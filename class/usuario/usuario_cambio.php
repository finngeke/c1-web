<?php

/**
 * Fecha: 2018-12-07
 */

namespace usuario;

class usuario_cambio  {

    //funciones para la asignacion de departamentos a usuarios//
    public static function trae_datos_cambio($login) {

        $sql = "SELECT CONTRASENIA,COD_USR FROM PLC_USUARIO
                  WHERE COD_USR = '".$login."' ";

        $data_tipo = \database::getInstancia()->getFilas($sql);
        return $data_tipo;
    }

    public static function actualizar_clave($login,$CLAVE) {


        $sql = "UPDATE PLC_USUARIO 
                SET CONTRASENIA = '".$CLAVE."'
                WHERE COD_USR = '".$login."' ";


        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/ACTUALIZAR-CLAVE-USUARIO--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);

        return $data;
    }

}


