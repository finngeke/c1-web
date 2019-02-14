<?php

namespace diferencia_unidades;

use log_transaccion\LogTransaccionClass;

class DiferenciaUnidadesClass extends \parametros
{

    // Listar Diferencia Unidades => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarDiferenciaUnidades($temporada, $depto)
    {
        $ventanas = implode(',',$_GET['VENTANA']);

        //convertir array para seleccionar mmultiples ventanas

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_DIFERENCIA_UNIDADES('$depto','$temporada','".$ventanas."', :data); END;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                 "TEMPORADA" => $val[0]
                ,"GRUPO_COMPRA" => $val[1]
                ,"VENTANA" => $val[2]
                ,"ESTILO" => utf8_encode($val[3])
                ,"COLOR" => $val[4]
                ,"UNID_PLAN" => $val[5]
                ,"UNID_ACORD" => $val[6]
                ,"DIFER_UND" => $val[7]
                ,"PORCENT_DIFER" => $val[8]
                ,"ESTADO" => $val[9]
                ,"ID" => $val[10])
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


    // Listar Depto
    public static function ListarDepto($login,$pais)
    {

        $sql = "SELECT DEP_DEPTO,DEP_DESCRIPCION FROM gst_maedeptos ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                    "DEP_DEPTO" => $val[0]
                ,"DEP_DESCRIPCION" => utf8_encode($val[1]) // UTF-8 Si me Trae String
                )
            );
        }

        return $array;

    }

    // aprobar
    public static function aprobar_unidades($registros,$login,$pais)
    {
        $registros = explode('*',$registros);

        foreach ($registros as $reg) {
            $aux = explode(';',$reg);
            $temporada = intval($aux[0]);
            $departamento = $aux[1];
            $ventana = $aux[2];
            $desEstilo = $aux[3];
            $nomColor = $aux[4];

            $sql  = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_APROBAR_UNIDADES('$departamento',$temporada,'$ventana','$desEstilo','$nomColor'); END;";
            \database::getInstancia()->getConsulta($sql);

        }

    }

    // rechazar
    public static function rechazar_unidades($registros,$login,$pais)
    {
        $registros = explode('*',$registros);

        foreach ($registros as $reg) {
            $aux = explode(';',$reg);
            $temporada = intval($aux[0]);
            $departamento = $aux[1];
            $ventana = $aux[2];
            $desEstilo = $aux[3];
            $nomColor = $aux[4];

            $sql  = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_RECHAZAR_UNIDADES('$departamento',$temporada,'$ventana','$desEstilo','$nomColor'); END;";
            \database::getInstancia()->getConsulta($sql);

        }

    }


// Fin de la Clase
}