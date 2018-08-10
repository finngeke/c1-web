<?php

/**
 * CLASS Temporada
 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
 * Fecha: 2018-02-07
 * @author RODRIGO RIOSECO
 */

namespace simulador_compra;

class grilla_cabecera extends \parametros {

    public static function obtienePptoVentana($temporada, $depto, $ventana) {

        $sql = "SELECT A.COD_VENTANA,B.VENT_DESCRI,(A.PORCENTAJE * 100) AS PORCENTAJE FROM  PLC_PPTO_EMB A"
                . " INNER JOIN PLC_VENTANA B ON A.COD_VENTANA=B.COD_VENTANA"
                . " WHERE A.COD_TEMPORADA =" . $temporada . " AND A.DEP_DEPTO='" . $depto . "' and B.VENT_DESCRI='" . $ventana . "'";

        /*echo $sql;
        die();*/

        $data = (object) \database::getInstancia()->getFila($sql);

        return $data->PORCENTAJE;
    }

    public static function obtienePptoTotal($temporada, $depto) {
        $sql = "SELECT sum(A.PORCENTAJE * 100) as PPTO_TOTAL"
                . " FROM  PLC_PPTO_EMB A INNER JOIN PLC_VENTANA B "
                . " ON A.COD_VENTANA=B.COD_VENTANA WHERE A.COD_TEMPORADA =" . $temporada
                . " AND A.DEP_DEPTO='" . $depto . "'";

        $data = (object) \database::getInstancia()->getFila($sql);

        return $data->PPTO_TOTAL;
    }
    
    public static function obtienePptoCostoTotal($temporada, $depto) {
        $sql = " SELECT PRESUPUESTO FROM PLC_PPTO_COSTO PC "
              ." WHERE PC.COD_TEMPORADA=".$temporada." AND PC.DEP_DEPTO='".$depto."'";

        $data = (object) \database::getInstancia()->getFila($sql);

        return $data->PRESUPUESTO;
    }
   
    public static function obtienePptoRetailTotal($temporada, $depto) {
        $sql = "select MATI AS PRESUPUESTO FROM PLC_PPTO_RETAIL PP"
              ." WHERE PP.COD_TEMPORADA=".$temporada." AND PP.DEP_DEPTO='".$depto."'";

        $data = (object) \database::getInstancia()->getFila($sql);

        return $data->PRESUPUESTO;
    }

    public static function obtienePptos($temporada, $depto) {

        $sql = "SELECT B.VENT_DESCRI,sum(A.PORCENTAJE)* 100 AS PORCENTAJE FROM  PLC_PPTO_EMB A"
                . " INNER JOIN PLC_VENTANA B ON A.COD_VENTANA=B.COD_VENTANA"
                . " WHERE A.COD_TEMPORADA =" . $temporada . " AND A.DEP_DEPTO='" . $depto . "' "
                . " GROUP BY A.COD_VENTANA,B.VENT_DESCRI ORDER BY B.VENT_DESCRI ASC";

        /*echo  $sql;
        die();*/
        $data = \database::getInstancia()->getFilas($sql);
        $total = 0;
        $ventanas['tipo']="Ppto";
        foreach ($data as $val) {

            $ventanas[$val['VENT_DESCRI']] = $val['PORCENTAJE'].'%';
            $total = $total + $val['PORCENTAJE'];
        }

        array_push($ventanas, $total.'%');
        return $ventanas;
    }

    public static function obtienePptosemb($temporada, $depto) {

        $sql = "SELECT B.VENT_DESCRI,sum(A.PORCENTAJE) AS PORCENTAJE FROM  PLC_PPTO_EMB A"
            . " INNER JOIN PLC_VENTANA B ON A.COD_VENTANA=B.COD_VENTANA"
            . " WHERE A.COD_TEMPORADA =" . $temporada . " AND A.DEP_DEPTO='" . $depto . "' "
            . " GROUP BY A.COD_VENTANA,B.VENT_DESCRI ORDER BY B.VENT_DESCRI ASC";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    public static function obtienePptoRetailProrrateo($temporada, $depto) {

        $sql = "SELECT PP.MATI / (SELECT COUNT(1) FROM  PLC_PPTO_EMB A"
                . " INNER JOIN PLC_VENTANA B ON A.COD_VENTANA=B.COD_VENTANA WHERE A.COD_TEMPORADA =PP.COD_TEMPORADA"
                . " AND A.DEP_DEPTO=PP.DEP_DEPTO AND A.PORCENTAJE>0) AS VALOR_UNI"
                . " FROM PLC_PPTO_RETAIL PP WHERE PP.COD_TEMPORADA=" . $temporada
                . " AND PP.DEP_DEPTO='" . $depto . "'";

        /*echo $sql;
        die();*/
        $data = (object) \database::getInstancia()->getFila($sql);


        return $data->VALOR_UNI;
    }

    public static function obtienePptoRetail($temporada, $depto) {

        $sql =  " SELECT MATI as VALOR_UNI"
               ." FROM   PLC_PPTO_RETAIL C"
               ." WHERE  C.COD_TEMPORADA =" . $temporada
               ." AND    C.DEP_DEPTO     = '" . $depto . "'";

        $data = \database::getInstancia()->getFila($sql);
        $data2 = (object) \database::getInstancia()->getFila($sql);

        if (!$data){
            return 0;
        }else {
            return $data2->VALOR_UNI;
        }

    }

    public static function obtienePptoCosto($temporada, $depto) {

        $sql =  " SELECT PRESUPUESTO as VALOR_UNI"
            ." FROM   PLC_PPTO_COSTO C"
            ." WHERE  C.COD_TEMPORADA =" . $temporada
            ." AND    C.DEP_DEPTO     = '" . $depto . "'";

        $data = \database::getInstancia()->getFila($sql);
        $data2 = (object) \database::getInstancia()->getFila($sql);

        if (!$data){
            return 0;
        }else {
            return $data2->VALOR_UNI;
        }
    }

    public static function obtienePptoCostoProrrateo($temporada, $depto) {

        $sql = "SELECT PC.PRESUPUESTO / (SELECT COUNT(1) FROM  PLC_PPTO_EMB A"
              ." INNER JOIN PLC_VENTANA B ON A.COD_VENTANA=B.COD_VENTANA"
              ." WHERE A.COD_TEMPORADA =PC.COD_TEMPORADA"
              ." AND A.DEP_DEPTO=PC.DEP_DEPTO AND A.PORCENTAJE>0) AS VALOR_UNI"
              ." FROM PLC_PPTO_COSTO PC WHERE PC.COD_TEMPORADA=".$temporada." AND PC.DEP_DEPTO='".$depto."'";

        $data = (object) \database::getInstancia()->getFila($sql);
        return $data->VALOR_UNI;
    }

    public static function obtieneConsumo($temporada, $depto)
    {

        $sql = "SELECT PERIODO VENTANA
                      ,SUM(COSTO) COSTO
                      ,SUM(VTA_CDSCTO) RETAIL
                FROM plc_plan_compra_color_CIC A
                WHERE A.cod_temporada = " . $temporada . "
                AND A.dep_depto = '" . $depto . "'
                GROUP BY PERIODO
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }


}
