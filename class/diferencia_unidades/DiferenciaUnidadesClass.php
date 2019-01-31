<?php

namespace diferencia_unidades;

use log_transaccion\LogTransaccionClass;

class DiferenciaUnidadesClass extends \parametros
{

    // Listar Diferencia Unidades => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarDiferenciaUnidades($temporada, $depto,$ventanas)
    {
//convertir array para seleccionar mmultiples ventanas
        $sql = "SELECT  T.NOM_TEMPORADA_CORTO NOM_TEMPORADA
                        ,PLN.GRUPO_COMPRA G_PLAN
                        ,PLN.NOM_VENTANA V_PLAN
                        ,PLN.DES_ESTILO
                        ,PLN.NOM_COLOR
                        ,PLN.UNIDADES_PLAN
                        ,RLA.UNIDADES_ACORDADA  
                        ,RLA.UNIDADES_ACORDADA - PLN.UNIDADES_PLAN DIFER_UNID
                        ,CASE WHEN UNIDADES_PLAN = 0 THEN 0 
                              ELSE((RLA.UNIDADES_ACORDADA - PLN.UNIDADES_PLAN)*100)/UNIDADES_PLAN END DIFEREN_UNID   
                FROM (
                     select COD_TEMPORADA,GRUPO_COMPRA ,NOM_VENTANA ,DES_ESTILO,NOM_COLOR,SUM(UNIDADES) UNIDADES_PLAN
                     from PIA_plan_compra_color
                     where cod_temporada = $temporada
                     and dep_depto = '".$depto."'
                     and vent_emb in ($ventanas)
                     GROUP BY COD_TEMPORADA,GRUPO_COMPRA,NOM_VENTANA,DES_ESTILO,NOM_COLOR) PLN
                LEFT JOIN(select COD_TEMPORADA,GRUPO_COMPRA,NOM_VENTANA ,DES_ESTILO,NOM_COLOR,SUM(UNIDADES) UNIDADES_ACORDADA
                            from plc_plan_compra_color_3
                            where cod_temporada = $temporada
                            and dep_depto = '".$depto."'
                            and vent_emb in ($ventanas)
                            GROUP BY COD_TEMPORADA ,GRUPO_COMPRA,NOM_VENTANA,DES_ESTILO,NOM_COLOR ) RLA ON PLN.COD_TEMPORADA = RLA.COD_TEMPORADA
                                                                                                       AND PLN.NOM_VENTANA =RLA.NOM_VENTANA
                                                                                                       AND PLN.DES_ESTILO =RLA.DES_ESTILO
                                                                                                       AND PLN.NOM_COLOR = RLA.NOM_COLOR
                LEFT JOIN PLC_TEMPORADA T ON PLN.COD_TEMPORADA = T.COD_TEMPORADA
                ORDER BY 1,2,3,4,5";
        $data = \database::getInstancia()->getFilas($sql);

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
                ,"PORCENT_DIFER" => $val[8] )
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




// Fin de la Clase
}