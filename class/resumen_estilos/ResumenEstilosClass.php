<?php

namespace resumen_estilos;

use log_transaccion\LogTransaccionClass;

class ResumenEstilosClass extends \parametros
{

    // Listar Resumen Estilos => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarResumenEstilos($temporada, $depto,$login,$pais)
    {

        // 1.- Borrar Tabla


        $sql = "SELECT 
                   DES_ESTILO STYLE_NAME,
                   CASE WHEN COD_MOD_PAIS = 1 THEN 'CHILE' 
                   ELSE 'PERÚ' END COD_MOD_PAIS, 
                   NOM_MARCA BRAND,
                   NOM_LINEA LINE, 
                   SUM(COSTO_INSP) INSPECTION, 
                   SUM(UNIDADES) QTTY,
                   COSTO_FOB FINAL_PRICE,
                   SUM(UNIDADES*COSTO_FOB) TOTAL_AMOUNT,
                   MTR_PACK MASTER_PACK,
                   SUM(CANT_INNER) CARTONS,
                   FECHA_EMBARQUE_ACORDADA DELIVERY_DATE 
                FROM PIA_RESUMEN_ESTILO_PASO 
                WHERE COD_PROVEEDOR = $login
                GROUP BY
                       DES_ESTILO,
                       COD_MOD_PAIS,
                       NOM_MARCA,
                       NOM_LINEA,
                       COSTO_FOB,
                       MTR_PACK,
                       FECHA_EMBARQUE_ACORDADA
                ORDER BY DES_ESTILO ASC";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                "ID" => trim($val[0])."*".utf8_encode(trim($val[1]))."*".utf8_encode(trim($val[2]))."*".utf8_encode(trim($val[3]))."*".trim($val[10])
                ,"PROFORMA" => ""
                ,"DES_ESTILO" => trim($val[0])
                ,"COD_MOD_PAIS" => utf8_encode(trim($val[1]))
                ,"NOM_MARCA" => utf8_encode(trim($val[2])) // UTF-8 Si me Trae String
                ,"NOM_LINEA" => utf8_encode(trim($val[3])) // UTF-8 Si me Trae String
                ,"COSTO_INSP" => $val[4]
                ,"UNIDADES" => $val[5]
                ,"COSTO_FOB" => $val[6]
                ,"COSTO_TOT" => $val[7]
                ,"MTR_PACK" => $val[8]
                ,"CANT_INNER" => $val[9]
                ,"FECHA_EMBARQUE_ACORDADA" => trim($val[10])
                ,"COD_PUERTO" => ""
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

    // Listar Port of Delivery
    public static function ListarPortDelivery($login,$pais)
    {

        $sql = "SELECT 
                   T1.COD_PUERTO,
                   T1.NOM_PUERTO 
                FROM PIA_PUERTOS T1
                LEFT JOIN plc_proveedores_pmm T2 ON T2.VEND_COUNTRY = T1.CNTRY_LVL_CHILD 
                WHERE T2.COD_PROVEEDOR = $login";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                    "COD_PUERTO" => $val[0]
                ,"NOM_PUERTO" => utf8_encode($val[1]) // UTF-8 Si me Trae String
                )
            );
        }

        return $array;

    }



// Fin de la Clase
}