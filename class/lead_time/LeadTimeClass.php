<?php

namespace lead_time;

use log_transaccion\LogTransaccionClass;

class LeadTimeClass extends \parametros
{

    // Listar Lead Time
    public static function ListarLeadTime($temporada, $login, $pais_filtro_ripley)
    {

        $sql = "SELECT DISTINCT(T1.ID_TRANSITO),
                       T1.COD_TEMPORADA,                  -- 0
                       T2.NOM_VIA COD_VIA,                -- 1
                       T3.CNTRY_NAME CNTRY_LVL_CHILD,     -- 2
                       T4.NOM_PUERTO COD_PUERTO_EMB,      -- 3
                       T5.NOM_PUERTO COD_PUERTO_DESTINO,  -- 4
                       T7.LIN_DESCRIPCION LIN_LINEA,      -- 5
                       T6.DEP_DESCRIPCION DEP_DEPTO,      -- 6
                       T1.D_TRANSITO,                     -- 7
                       T1.D_PUERTO_CD,                    -- 8
                       T1.D_TIENDAS_CD,                   -- 9
                       T1.T_DIAS_SUCURS,                  -- 10
                       T1.COD_VENTANA_EMB,                -- 11
                       T1.FIRST_FORWARDER,                -- 12
                       T1.LASTEST_FORWARDER,              -- 13
                       
                       T2.COD_VIA COD_VIA,                -- 14
                       T3.CNTRY_LVL_CHILD ID_PAIS,        -- 16
                       T4.COD_PUERTO ID_EMBARQUE,         -- 17
                       T5.COD_PUERTO ID_DESTINO,          -- 18
                       T1.LIN_LINEA ID_LINEA,             -- 18
                       T1.DEP_DEPTO ID_DEPTO              -- 19
                FROM PIA_DIAS_TRANSITO T1
                INNER JOIN PLC_VIA T2 ON T2.COD_VIA=T1.COD_VIA
                INNER JOIN PLC_PAIS T3 ON T3.CNTRY_LVL_CHILD=T1.CNTRY_LVL_CHILD
                INNER JOIN PIA_PUERTOS T4 ON T4.COD_PUERTO=T1.COD_PUERTO_EMB
                LEFT JOIN PIA_PUERTOS T5 ON T5.COD_PUERTO=T1.COD_PUERTO_DESTINO
                INNER JOIN plc_jerarquia_comercial T6 ON T6.DEP_DEPTO=T1.DEP_DEPTO
                LEFT JOIN plc_jerarquia_comercial T7 ON T7.LIN_LINEA=T1.LIN_LINEA
                WHERE T1.COD_TEMPORADA = $temporada";

        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {


            if($va1[5]){
                $puerto_destino = $va1[18]." - ".$va1[5];
            }else{
                $puerto_destino = "ND";
            }

            array_push($array1, array(
                  "ID_TRANSITO" => $va1[0]
                , "COD_TEMPORADA" => $va1[1]
                , "COD_VIA" => $va1[14]." - ".$va1[2]
                , "CNTRY_LVL_CHILD" => $va1[16]." - ".$va1[3]
                , "COD_PUERTO_EMB" => $va1[17]." - ".$va1[4]
                , "COD_PUERTO_DESTINO" => $puerto_destino
                , "LIN_LINEA" => $va1[19]." - ".$va1[6]
                , "DEP_DEPTO" => $va1[20]." - ".$va1[7]
                , "D_TRANSITO" => $va1[8]
                , "D_PUERTO_CD" => $va1[9]
                , "D_TIENDAS_CD" => $va1[10]
                , "T_DIAS_SUCURS" => $va1[11]
                , "COD_VENTANA_EMB" => $va1[12]
                , "FIRST_FORWARDER" => $va1[13]
                , "LASTEST_FORWARDER" => $va1[14]
                )
            );
        }

        return $array1;

    }

    // Listar Vía
    public static function ListarVia($temporada, $login, $pais_filtro_ripley)
    {

        $sql = "SELECT COD_VIA, NOM_VIA FROM PLC_VIA ORDER BY NOM_VIA";
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
    public static function ListarPais($temporada, $login, $pais_filtro_ripley)
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

    // Listar Embarque
    public static function ListarEmbarque($temporada, $login, $pais_filtro_ripley, $pais)
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

    // Listar Destino
    public static function ListarDestino($temporada, $login, $pais_filtro_ripley)
    {

        $sql = "SELECT COD_PUERTO,NOM_PUERTO 
                FROM PIA_PUERTOS 
                WHERE CNTRY_LVL_CHILD = 2 
                AND COD_PUERTO <> 'SNT'
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

    // Listar Depto
    public static function ListarDepto($temporada, $login, $pais_filtro_ripley)
    {

        $sql = "SELECT DISTINCT(DEP_DEPTO),DEP_DESCRIPCION 
                FROM plc_jerarquia_comercial
                ORDER BY 2";
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

    // Listar Línea
    public static function ListarLinea($temporada, $login, $pais_filtro_ripley, $deptocbx)
    {

        $sql = "SELECT DISTINCT(LIN_LINEA),LIN_DESCRIPCION 
                FROM plc_jerarquia_comercial
                WHERE DEP_DEPTO = '" . $deptocbx . "'
                ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "LIN_LINEA" => $va1[0]." - ".$va1[1],
                    "LIN_DESCRIPCION" => $va1[0]." - ".$va1[1]
                )
            );
        }

        return $array1;

    }

    // Crear Lead Time
    public static function CrearLeadTime($temporada, $login, $pais_filtro_ripley, $VIA, $PAIS, $EMBARQUE, $DESTINO, $DEPARTAMENTO, $LINEA, $TRANSITO, $PUERTOCD, $CDTIENDA, $TOTAL_DIAS_SUCURSAL, $VENTANA_EMBARQUE, $FIRST_FORWARDER, $LASTEST_FORWARDER)
    {

        if( ($VIA==null) || ($VIA=="null") || ($VIA=="") || (!$VIA) ){
            return json_encode("Ingrese Vía");
            die();
        }
        if( ($PAIS==null) || ($PAIS=="null") || ($PAIS=="") || (!$PAIS) ){
            return json_encode("Ingrese País");
            die();
        }
        if( ($EMBARQUE==null) || ($EMBARQUE=="null") || ($EMBARQUE=="") || (!$EMBARQUE) ){
            return json_encode("Ingrese Puerto Embarque");
            die();
        }
        if( ($DEPARTAMENTO==null) || ($DEPARTAMENTO=="null") || ($DEPARTAMENTO=="") || (!$DEPARTAMENTO) ){
            return json_encode("Ingrese Departamento");
            die();
        }


        $sql_id = "SELECT   
                       CASE   
                          WHEN MAX(ID_TRANSITO) IS NULL THEN 1   
                          WHEN MAX(ID_TRANSITO) >=0 THEN MAX(ID_TRANSITO) + 1   
                       END  ID 
                    FROM PIA_DIAS_TRANSITO";
        $data_id = \database::getInstancia()->getFilas($sql_id);

        foreach ($data_id as $va1) {

            $maxId = $va1[0];

            $sql = "INSERT INTO PIA_DIAS_TRANSITO (ID_TRANSITO, COD_TEMPORADA,COD_VIA,COD_PUERTO_EMB,CNTRY_LVL_CHILD,COD_PUERTO_DESTINO,LIN_LINEA,DEP_DEPTO,D_TRANSITO,D_PUERTO_CD,D_TIENDAS_CD,T_DIAS_SUCURS,COD_VENTANA_EMB,FIRST_FORWARDER,LASTEST_FORWARDER,COD_MOD_PAIS)
                    VALUES($maxId,$temporada,$VIA,'".$EMBARQUE."',$PAIS,'".$DESTINO."','".$LINEA."','".$DEPARTAMENTO."',$TRANSITO,$PUERTOCD,$CDTIENDA,$TOTAL_DIAS_SUCURSAL,$VENTANA_EMBARQUE,$FIRST_FORWARDER,$LASTEST_FORWARDER,$pais_filtro_ripley)";
                /*echo $sql;
                die();*/
            $data_insert = \database::getInstancia()->getConsulta($sql);

            // Si se ejecuta la consulta
            if ($data_insert) {
                // Acción: Crear / Eliminar / Actualizar
                LogTransaccionClass::GuardaLogTransaccion($login, $temporada, 'ND', 'Lead Time','Crear', $sql, 'OK' );
                return json_encode("OK");
                die();
                // Si la consulta no se puede realizar
            } else {
                // Acción: Crear / Eliminar / Actualizar
                LogTransaccionClass::GuardaLogTransaccion($login, $temporada, 'ND', 'Lead Time','Crear', $sql, 'ERROR' );
                return json_encode("ERROR");
                die();
            }

        }










        // Fin de la clase
    }

    // Actualiza Lead Time
    public static function ActualizaLeadTime($temporada, $login, $pais_filtro_ripley,$ID_TRANSITO, $VIA, $PAIS, $EMBARQUE, $DESTINO, $DEPARTAMENTO, $LINEA, $TRANSITO, $PUERTOCD, $CDTIENDA, $TOTAL_DIAS_SUCURSAL, $VENTANA_EMBARQUE, $FIRST_FORWARDER, $LASTEST_FORWARDER)
    {

        if( ($VIA==null) || ($VIA=="null") || ($VIA=="") || (!$VIA) ){
            return json_encode("Ingrese Vía");
            die();
        }
        if( ($PAIS==null) || ($PAIS=="null") || ($PAIS=="") || (!$PAIS) ){
            return json_encode("Ingrese País");
            die();
        }
        if( ($EMBARQUE==null) || ($EMBARQUE=="null") || ($EMBARQUE=="") || (!$EMBARQUE) ){
            return json_encode("Ingrese Puerto Embarque");
            die();
        }
        if( ($DEPARTAMENTO==null) || ($DEPARTAMENTO=="null") || ($DEPARTAMENTO=="") || (!$DEPARTAMENTO) ){
            return json_encode("Ingrese Departamento");
            die();
        }


            $sql = "UPDATE PIA_DIAS_TRANSITO 
                    SET COD_VIA = $VIA,
                        COD_PUERTO_EMB = '".$EMBARQUE."',
                        CNTRY_LVL_CHILD = $PAIS,
                        COD_PUERTO_DESTINO = '".$DESTINO."',
                        LIN_LINEA = '".$LINEA."',
                        DEP_DEPTO = '".$DEPARTAMENTO."',
                        D_TRANSITO = $TRANSITO,
                        D_PUERTO_CD = $PUERTOCD,
                        D_TIENDAS_CD = $CDTIENDA,
                        T_DIAS_SUCURS = $TOTAL_DIAS_SUCURSAL,
                        COD_VENTANA_EMB = $VENTANA_EMBARQUE,
                        FIRST_FORWARDER = $FIRST_FORWARDER,
                        LASTEST_FORWARDER= $LASTEST_FORWARDER
                    WHERE ID_TRANSITO = $ID_TRANSITO";
            $data_update = \database::getInstancia()->getConsulta($sql);

            // Si se ejecuta la consulta
            if ($data_update) {
                // Acción: Crear / Eliminar / Actualizar
                LogTransaccionClass::GuardaLogTransaccion($login, $temporada, 'ND', 'Lead Time','Actualizar', $sql, 'OK' );
                return json_encode("ERROR");
                die();
                // Si la consulta no se puede realizar
            } else {
                // Acción: Crear / Eliminar / Actualizar
                LogTransaccionClass::GuardaLogTransaccion($login, $temporada, 'ND', 'Lead Time','Actualizar', $sql, 'ERROR' );
                return json_encode("ERROR");
                die();
            }






        // Fin de la clase
    }





// Fin de la Clase
}