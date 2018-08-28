<?php
/**
 * Created by PhpStorm.
 * Date: 17/08/2018
 * Time: 12:40
 */
namespace simulador_compra;

class actualizar_calculos {


    public static function llenar_departamento_actualizar_calculos($COD_TEMPORADA) {

        $sql = "select distinct dep_depto 
                from plc_plan_compra_color_3
                where cod_temporada = $COD_TEMPORADA";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }

    public static function traer_datos_para_calcular_query($COD_TEMPORADA,$DEPTO) {

        $sql = "SELECT 
                C.ID_COLOR3,      
                       
                C.NOM_VENTANA DESCRIPCION,
                
                --C.UNID_OPCION_INICIO,     
                 C.UNIDADES CAN, --  Uni Ini
            
                VIA,
                PAIS,
            
                C.MKUP,  
                C.PRECIO_BLANCO,   
                                                             
                COD_TIP_MON,
                C.COSTO_TARGET,  
                C.COSTO_FOB,  
                C.COSTO_INSP, 
                C.COSTO_RFID,
                
                C.COSTO_UNIT,  
                C.COSTO_UNITS,  
                C.CST_TOTLTARGET,                                               --(Registro 60)
                C.COSTO_TOT, 
                C.COSTO_TOTS,
                C.RETAIL,
                C.GMB
                                                   
                  FROM PLC_PLAN_COMPRA_COLOR_3 C
                  LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                  AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                  WHERE C.COD_TEMPORADA =  " . $COD_TEMPORADA . " AND C.DEP_DEPTO =  '" . $DEPTO . "'   
                  ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER
              ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    public static function traer_factor($VENTANA,$COD_TEMPORADA,$DEPTO,$PAIS,$VIA,$COD_TIP_MON) {

        $sql = "select $VENTANA as VENTANA_FACTOR from PLC_FACTOR_EST 
                    where COD_TEMPORADA = $COD_TEMPORADA
                    and DEP_DEPTO = '".$DEPTO."'
                    and CNTRY_LVL_CHILD = $PAIS
                    and COD_VIA = $VIA
                    and COD_TIP_MON = $COD_TIP_MON";


        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    public static function traer_tipo_cambio($VENTANA,$COD_TEMPORADA,$COD_TIP_MON) {

        $sql = "select $VENTANA as VENTANA_TIPO_CAMBIO from PLC_TIPO_CAMBIO
                    where cod_temporada = $COD_TEMPORADA 
                    and cod_tip_mon = $COD_TIP_MON 
                    ";


        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    public static function actualizar_calculos_departamento($login,$COD_TEMPORADA,$DEPTO,$ID_COLOR3,$MKUP,$GMB,$COSTO_UNITARIO_US,$COSTO_UNITARIO_PESO,$TOTAL_TARGET,$TOTAL_FOB,$COSTO_TOTAL_PESO,$RETAIL) {

        $sql = "update plc_plan_compra_color_3 
                       set mkup = $MKUP,
                           GMB = $GMB,
                           COSTO_UNIT = $COSTO_UNITARIO_US,
                           COSTO_UNITS = $COSTO_UNITARIO_PESO,
                           CST_TOTLTARGET = $TOTAL_TARGET,
                           COSTO_TOT = $TOTAL_FOB,
                           COSTO_TOTS = $COSTO_TOTAL_PESO,
                           RETAIL = $RETAIL
                       where cod_temporada = $COD_TEMPORADA
                       and dep_depto = '".$DEPTO."'
                       and id_color3 = $ID_COLOR3";

        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/ACTUALIZAR-CALCULOS-ACTUALIZAR-DEPTO--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);

        return $data;
    }

    public static function actualizar_calculos_departament_CIC($login,$COD_TEMPORADA,$DEPTO,$ID_COLOR3,$MKUP,$GMB,$COSTO_UNITARIO_US,$COSTO_UNITARIO_PESO,$TOTAL_TARGET,$TOTAL_FOB,$COSTO_TOTAL_PESO,$RETAIL) {

        $sql = "update PLC_PLAN_COMPRA_COLOR_CIC 
                       set 
                           COSTO = $COSTO_TOTAL_PESO,
                           VTA_CDSCTO = $RETAIL
                       where cod_temporada = $COD_TEMPORADA
                       and dep_depto = '".$DEPTO."'
                       and id_color3 = $ID_COLOR3";

        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/ACTUALIZAR-CALCULOS-ACTUALIZAR-DEPTO--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);

        return $data;
    }


}