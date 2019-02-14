<?php

namespace diferencia_presupuesto;

use log_transaccion\LogTransaccionClass;

class DiferenciaPresupuestoClass extends \parametros
{

    // // Listar Diferencia Presupuesto => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarDiferenciaPresupuesto($temporada,$login,$pais)
    {
        $depto = $_GET['DEPARTAMENTO'];
        $ventana =  implode(',',$_GET['VENTANA']);

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_DIFERENCIA_PRESUPUESTO('$depto','$temporada','".$ventana."', :data); END;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                 "NOM_TEMPO" => utf8_encode($val[0])
                ,"GRUPO_COMPRA" => utf8_encode($val[1])
                ,"NOM_VENTANA" => utf8_encode($val[2])
                ,"COSTO_PLAN" => strval(number_format($val[3],2,',','.')). ' $'
                ,"RETAIL_PLAN" => strval(number_format($val[4],2,',','.')). ' $'
                ,"UNIDADES_PLAN" => number_format($val[5],0,',','.')
                ,"COSTO_REAL" => strval(number_format($val[6],2,',','.')). ' $'
                ,"RETAIL_REAL" => strval(number_format($val[7],2,',','.')). ' $'
                ,"UNIDADES_REAL" => number_format($val[8],0,',','.')
                ,"VARIACION_COSTO" => strval(number_format($val[9],2,',','.')). '%'
                ,"VARIACION_RETAIL" => strval(number_format($val[10],2,',','.')). '%'
                ,"VARIACION_UNIDADES" => strval(number_format($val[11],2,',','.')). '%'
                ,"ID" => utf8_encode($val[14])
                ,"NOM_LINEA" => utf8_encode($val[16])
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
    public static function aprobar_presupuestos($registros,$login,$pais)
    {
        $registros = explode('*',$registros);

        foreach ($registros as $reg) {
            $aux = explode(';',$reg);
            $temporada = intval($aux[0]);
            $departamento = $aux[1];
            $ventana = $aux[2];
            $codLinea = $aux[3];

            $sql  = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_APROBAR_PRESUPUESTOS('$departamento',$temporada,'$ventana','$codLinea'); END;";
            \database::getInstancia()->getConsulta($sql);

        }

    }

    // rechazar
    public static function rechazar_presupuestos($registros,$login,$pais)
    {
        $registros = explode('*',$registros);

        foreach ($registros as $reg) {
            $aux = explode(';',$reg);
            $temporada = intval($aux[0]);
            $departamento = $aux[1];
            $ventana = $aux[2];
            $codLinea = $aux[3];

            $sql  = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_RECHAZAR_PRESUPUESTOS('$departamento',$temporada,'$ventana','$codLinea'); END;";
            \database::getInstancia()->getConsulta($sql);

        }

    }


// Fin de la Clase
}