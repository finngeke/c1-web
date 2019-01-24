<?php

namespace factor_importacion;

use log_transaccion\LogTransaccionClass;

class FactorImportacionClass extends \parametros
{
    //Listar factor
    public static function List_factor_Importacion($cod_temporada){
        $array1 = [];
        // Listar las tempradas par desplegarlas en elinici de bienvenida de las temporadas en el select
        $sql = "SELECT  T1.ID_FACTOR_IMPORT ID_FACTOR
                       ,T1.COD_VIA             ||' - '|| T2.NOM_VIA                  COD_VIA              
                       ,T1.COD_PUERTO_EMB      ||' - '|| T4.NOM_PUERTO               COD_PUERTO_EMB
                       ,CASE WHEN T1.COD_PUERTO_DESTINO IS NULL THEN 'ND' 
                             ELSE T1.COD_PUERTO_DESTINO  ||' - '|| T5.NOM_PUERTO END COD_PUERTO_DESTINO
                       ,T1.COD_INCOTERM        ||' - '|| T3.NOM_INCOTERM             COD_INCOTERM            
                       ,T1.COD_DIV             ||' - '|| T6.DEP_DES_DVS              COD_DIV  
                       ,T1.DEP_DEPTO           ||' - '|| T7.DEP_DESCRIPCION          DEP_DEPTO  
                       ,CASE WHEN T1.COD_MARCA = 0 THEN 'ND'
                             ELSE T1.COD_MARCA ||' - '|| T8.NOM_MARCA END            COD_MARCA
                       ,T1.FACTOR_ESTIMADO
                       ,T1.FACTOR_REAL
                       ,T1.COD_PAIS_EMB        ||' - '|| T9.CNTRY_NAME               COD_PAIS_EMB 
                       ,T1.COD_PAIS_DESTINO    ||' - '|| T10.CNTRY_NAME              COD_PAIS_DESTINO 
                       ,T1.COD_TIP_MON         ||' - '|| T11.NOM_TIP_MON             COD_TIP_MON
                FROM PIA_FACTOR_IMPORT T1
                LEFT JOIN PLC_VIA T2 ON T2.COD_VIA=T1.COD_VIA
                LEFT JOIN PIA_PUERTOS T4 ON T4.COD_PUERTO=T1.COD_PUERTO_EMB
                LEFT JOIN PIA_PUERTOS T5 ON T5.COD_PUERTO=T1.COD_PUERTO_DESTINO
                LEFT JOIN PIA_INCOTERM T3 ON T3.COD_INCOTERM = T1.COD_INCOTERM
                LEFT JOIN (SELECT DISTINCT DEP_COC_DVS,DEP_DES_DVS FROM GST_MAEDEPTOS) T6 ON T6.DEP_COC_DVS = T1.COD_DIV
                LEFT JOIN (SELECT DISTINCT DEP_DEPTO,DEP_DESCRIPCION FROM GST_MAEDEPTOS)T7 ON T7.DEP_DEPTO = T1.DEP_DEPTO
                LEFT JOIN (SELECT DISTINCT COD_MARCA,NOM_MARCA,COD_DEPT FROM PLC_DEPTO_MARCA)T8 ON T8.COD_MARCA = T1.COD_MARCA AND T8.COD_DEPT = T1.DEP_DEPTO
                LEFT JOIN PLC_PAIS T9 ON T9.CNTRY_LVL_CHILD = T1.COD_PAIS_EMB 
                LEFT JOIN PLC_PAIS T10 ON T10.CNTRY_LVL_CHILD = T1.COD_PAIS_DESTINO  
                LEFT JOIN PLC_TIPO_MONEDA T11 ON T11.COD_TIP_MON = T1.COD_TIP_MON               
                WHERE COD_TEMPORADA = $cod_temporada
                ORDER BY 2,3,4,5,7,8,9,10,11";

        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        foreach ($data as $va1) {
            array_push($array1
                , array("ID_FACTOR" => $va1[0]
                , "COD_VIA" => $va1[1]
                , "COD_PUERTO_EMB" => $va1[2]
                , "COD_PUERTO_DESTINO" => $va1[3]
                , "COD_INCOTERM" => $va1[4]
                , "COD_DIV" => $va1[5]
                , "DEP_DEPTO" => $va1[6]
                , "COD_MARCA" => $va1[7]
                , "FACTOR_ESTIMADO" => $va1[8]
                , "FACTOR_REAL" => $va1[9]
                , "COD_PAIS_EMB" => $va1[10]
                , "COD_PAIS_DESTINO" => $va1[11]
                , "COD_TIP_MON" => $va1[12]
                )
            );
        }
        return $array1;
    }

    //Listar Vía
    public static function ListarVia($login, $pais_filtro_ripley)
    {
        $sql = "SELECT COD_VIA, NOM_VIA FROM PLC_VIA ORDER BY COD_VIA";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "COD_VIA" => $va1[0]." - ".$va1[1],
                    "NOM_VIA" => $va1[0]." - ".$va1[1]
                )
            );
        }
        return $array1;
    }

    // Listar País
    public static function ListarPais($login, $pais_filtro_ripley)
    {

        $sql = "SELECT CNTRY_LVL_CHILD,CNTRY_NAME FROM plc_pais ORDER BY CNTRY_NAME";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "CNTRY_LVL_CHILD" => $va1[0]." - ".$va1[1],
                    "CNTRY_NAME" => $va1[0]." - ".$va1[1]
                )
            );
        }

        return $array1;

    }

    // Listar Puertos
    public static function ListarPuertos($login, $pais_filtro_ripley, $pais)
    {

        $sql = "SELECT COD_PUERTO,NOM_PUERTO 
                FROM PIA_PUERTOS 
                WHERE CNTRY_LVL_CHILD = $pais
                ORDER BY NOM_PUERTO";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "COD_PUERTO" => $va1[0]." - ".$va1[1],
                    "NOM_PUERTO" => $va1[0]." - ".$va1[1]
                )
            );
        }

        return $array1;

    }

    // Listar Pais Dest
    public static function ListarPaisDest($login, $pais_filtro_ripley, $pais){
        $sql = "SELECT CNTRY_LVL_CHILD,CNTRY_NAME FROM plc_pais where CNTRY_LVL_CHILD <> $pais ORDER BY CNTRY_NAME";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "CNTRY_LVL_CHILD" => $va1[0]." - ".$va1[1],
                    "CNTRY_NAME" => $va1[0]." - ".$va1[1]
                )
            );
        }

        return $array1;
    }

    // Listar Incoterm
    public static function ListarIncoterm($login, $pais_filtro_ripley)
    {

        $sql = "SELECT COD_INCOTERM,NOM_INCOTERM FROM PIA_INCOTERM ORDER BY 1 ASC";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "COD_INCOTERM" => $va1[0]." - ".$va1[1],
                    "NOM_INCOTERM" => $va1[0]." - ".$va1[1]
                )
            );
        }

        return $array1;

    }

    // Listar Division
    public static function ListarDivisiones ($login, $pais_filtro_ripley){

        $sql = "SELECT DISTINCT DEP_COC_DVS COD_DIVISION
                       ,DEP_DES_DVS NOM_DIVISION 
                FROM GST_MAEDEPTOS
                ORDER BY 1 ASC";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "COD_DIVISION" => $va1[0]." - ".$va1[1],
                    "NOM_DIVISION" => $va1[0]." - ".$va1[1]
                )
            );
        }
        return $array1;

    }

    // Listar Depto
    public static function ListarDeptoxDivision ($login, $pais_filtro_ripley,$cod_division){

        $sql = "SELECT DISTINCT DEP_DEPTO, DEP_DESCRIPCION 
                FROM GST_MAEDEPTOS
                WHERE DEP_COC_DVS = '".$cod_division."'
                ORDER BY 1 ASC";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "DEP_DEPTO" => $va1[0]." - ".$va1[1],
                    "DEP_DESCRIPCION" => $va1[0]." - ".$va1[1]
                )
            );
        }
        return $array1;
    }

    // Listar MARCA
    public static function ListarMarcaxDepto ($login, $pais_filtro_ripley,$dep_depto){

        $sql = "SELECT COD_MARCA,NOM_MARCA
                FROM PLC_DEPTO_MARCA
                WHERE COD_DEPT = '".$dep_depto."'
                ORDER BY 1 ASC";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "COD_MARCA" => $va1[0]." - ".$va1[1],
                    "NOM_MARCA" => $va1[0]." - ".$va1[1]
                )
            );
        }
        return $array1;
    }

    // Listar tipo de moneda
    public static function ListartipoMoneda($login, $pais_filtro_ripley){
        $sql = "select COD_TIP_MON,NOM_TIP_MON 
                from plc_tipo_moneda
                ORDER BY 1 ASC";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "COD_TIP_MON" => $va1[0]." - ".$va1[1],
                    "NOM_TIP_MON" => $va1[0]." - ".$va1[1]
                )
            );
        }
        return $array1;


    }

    // Insert Factor Import
    public static function InsertFactorImport($temporada, $login, $pais_filtro_ripley,$dt)
    {


        $sql_id = "SELECT CASE WHEN MAX(ID_FACTOR_IMPORT) IS NULL THEN 1   
                               WHEN MAX(ID_FACTOR_IMPORT) >=0 THEN MAX(ID_FACTOR_IMPORT) + 1 END ID
                   FROM PIA_FACTOR_IMPORT";
        $data_id = \database::getInstancia()->getFila($sql_id);

        $sql = "INSERT INTO PIA_FACTOR_IMPORT(ID_FACTOR_IMPORT,COD_VIA,COD_PUERTO_EMB,COD_PUERTO_DESTINO,COD_INCOTERM,COD_DIV,DEP_DEPTO,COD_MARCA,FACTOR_ESTIMADO
                                            ,FACTOR_REAL,COD_TEMPORADA,COD_MOD_PAIS,COD_PAIS_EMB,COD_PAIS_DESTINO,COD_TIP_MON)
               VALUES( ".$data_id['ID'].",
                       ".$dt['via'].",
                       '".$dt['pto_embarque']."',
                       '".$dt['pto_destino']."',
                       ".$dt['incoterm'].",
                       '".$dt['division']."',
                       '".$dt['departamento']."',
                       '".$dt['marca']."',
                       ".$dt['factor_est'].",
                       0,
                       ".$temporada.",
                       ".$pais_filtro_ripley.",
                       ".$dt['pais_emb'].",
                       ".$dt['pais_dest'].",
                       ".$dt['moneda'].")";

            $data_insert = \database::getInstancia()->getConsulta($sql);

            // Si se ejecuta la consulta
            if ($data_insert) {
                // Acción: Crear / Eliminar / Actualizar
                LogTransaccionClass::GuardaLogTransaccion($login, $temporada, 'ND', 'Factor Importacion','Crear', $sql, 'OK' );
                return json_encode("OK");
                die();
                // Si la consulta no se puede realizar
            } else {
                // Acción: Crear / Eliminar / Actualizar
                LogTransaccionClass::GuardaLogTransaccion($login, $temporada, 'ND', 'Factor Importacion','Crear', $sql, 'ERROR' );
                return json_encode("ERROR");
                die();
            }

        }

    // valor del cambio por ventana
    public static function getTipoCambioxVentana($temporada,$cod_moneda,$nom_ventana){
        $valor = 0;
        $sql = "SELECT ".$nom_ventana." 
                FROM PLC_TIPO_CAMBIO
                WHERE COD_TEMPORADA = ".$temporada."
                AND COD_TIP_MON = ".$cod_moneda;
        $data = \database::getInstancia()->getFila($sql);
        if (count($data) <>0){
            $valor = $data[0];
        }
        return $valor;
    }

    public static function _existeFactor($temporada, $login, $pais_filtro_ripley,$dt){
        $pto_Destino ="";
        if ($dt['pto_destino'] == ""){
            $pto_Destino = " and  COD_PUERTO_DESTINO is null ";
        }else {
            $pto_Destino = " and  COD_PUERTO_DESTINO = "."'" . $dt['pto_destino'] . "' " ;
        }

        $sql = "select count(1) n from PIA_FACTOR_IMPORT
                where COD_VIA = " . $dt['via'] . "
                and  COD_PUERTO_EMB = '" . $dt['pto_embarque'] . "'
                ".$pto_Destino."
                and  COD_INCOTERM = " . $dt['incoterm'] . "
                and  COD_DIV =  '" . $dt['division'] . "'
                and  DEP_DEPTO = '" . $dt['departamento'] . "'
                and  COD_MARCA = " . $dt['marca'] . "
                and  COD_TEMPORADA =  " . $temporada . "
                and  COD_PAIS_EMB = " . $dt['pais_emb'] . "
                and  COD_PAIS_DESTINO = " . $dt['pais_dest'] . "
                and  COD_TIP_MON  = " . $dt['moneda'];

        $data = \database::getInstancia()->getFila($sql);

        return $data[0];

    }

}