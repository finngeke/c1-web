<?php

namespace mantenedor_proveedor;

use log_transaccion\LogTransaccionClass;

class MantenedorProveedorClass extends \parametros
{

    // Listar Lead Time
    public static function ListarProveedor($login, $pais_filtro_ripley)
    {

        /*
         --VEND_TAXID,          -- 4
                       --VEND_NAME_DEALER,    -- 5
                       --VEND_BENEFICIARY,    -- 6
                       --VEND_ADD_BENEFICIARY, -- 7
                       --VEND_CITY,           -- 8
                       --VEND_COUNTRY,        -- 9
                       --VEND_PHONE,          -- 10
                       --VEND_FAX,            -- 11
                       --CONT_NAME,           -- 12
                       --CONT_ADDRESS,        -- 13
                       --CONT_PHONE,          -- 14
                       --CONT_EMAIL,          -- 15

                       --USU_CREA,            -- 19
                       --FECHA_CREA,          -- 20
                       --USU_MODIFICA,        -- 21
                       --FECHA_MODIFICA,      -- 22
                       --ESTADO,              -- 23
                       --TIPO,                -- 24
                       --NICKNAME,            -- 25
                       --COMMISSION           -- 26
        */


        $sql = "SELECT 
                       COD_PROVEEDOR, -- 0
                       COD_MOD_PAIS,  -- 1
                       RUT_PROVEEDOR, -- 2
                       NOM_PROVEEDOR,  -- 3
                       PI_AUTOMATICA, -- 4
                       COMPRA_CURVA,  -- 5
                       RFID  -- 6
                FROM plc_proveedores_pmm 
                WHERE COD_MOD_PAIS = $pais_filtro_ripley";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {

            // País
            if($va1[1]==1){
                $pais = "CL";
            }else{
                $pais = "PE";
            }

            array_push($array1, array(

                "COD_PROVEEDOR" => $va1[0]
                ,"COD_MOD_PAIS" => $pais
                , "RUT_PROVEEDOR" => $va1[2]
                , "NOM_PROVEEDOR" => utf8_encode($va1[3])
                , "PI_AUTOMATICA" => $va1[4]
                , "COMPRA_CURVA" => $va1[5]
                , "RFID" => $va1[6]

                /*, "VEND_TAXID" => $va1[3]
                , "VEND_NAME_DEALER" => $va1[4]
                , "VEND_BENEFICIARY" => $va1[5]
                , "VEND_ADD_BENEFICIARY" => $va1[6]
                , "VEND_CITY" => $va1[7]
                , "VEND_COUNTRY" => $va1[8]
                , "VEND_PHONE" => $va1[9]
                , "VEND_FAX" => $va1[10]
                , "CONT_NAME" => $va1[11]
                , "CONT_ADDRESS" => $va1[12]
                , "CONT_PHONE" => $va1[13]
                , "CONT_EMAIL" => $va1[14]
                , "PI_AUTOMATICA" => $va1[15]
                , "COMPRA_CURVA" => $va1[16]
                , "RFID" => $va1[17]
                , "USU_CREA" => $va1[19]
                , "FECHA_CREA" => $va1[20]
                , "USU_MODIFICA" => $va1[21]
                , "FECHA_MODIFICA" => $va1[22]*/
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

    // Listar Incoterm
    public static function ListarIncoterm($login, $pais_filtro_ripley)
    {

        $sql = "SELECT COD_INCOTERM, NOM_INCOTERM FROM PIA_INCOTERM ORDER BY NOM_INCOTERM";
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






// Fin de la Clase
}