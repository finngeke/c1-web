<?php

namespace mantenedor_proveedor;

use log_transaccion\LogTransaccionClass;

class MantenedorProveedorClass extends \parametros
{

    // Listar Proveedor
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

    // Crear Proveedor
    public static function CrearProveedor($login, $pais_filtro_ripley, $COD_PROVEEDOR,$RUT_PROVEEDOR,$NOM_PROVEEDOR,$VEND_TAXID,$VEND_NAME_DEALER,$VEND_BENEFICIARY,$VEND_ADD_BENEFICIARY,$VEND_CITY,$VEND_COUNTRY,$VEND_PHONE,$VEND_FAX,$CONT_NAME,$CONT_ADDRESS,$CONT_PHONE,$CONT_EMAIL,$PI_AUTOMATICA,$COMPRA_CURVA,$RFID,$COD_MOD_PAIS,$ESTADO,$PAY_BANK_NAME_BENEFICIARY,$PAY_ADD_BANK_BENEFICIARY,$PAY_CITY_BENEFICIARY_BANK,$PAY_COUNTRY_BENEFICIARY,$PAY_SWIFT_CODE,$PAY_ABA,$PAY_IBAN,$PAY_ACC_NUMBER_BENEFICIARY,$PAY_CURRENCY_ACCOUNT,$PAY_SECOND_BENEFICIARY,$INTER_BANK_NAME,$INTER_SWIFT,$INTER_COUNTRY,$INTER_CITY,$PUR_CURRENCY,$PUR_INCOTEM,$PUR_PAYMENTO)
    {

        // Verificar que el COD_PROVEEDOR no exista
        $sql_cod_proveedor = "SELECT 1 FROM PLC_PROVEEDORES_PMM
                              WHERE COD_PROVEEDOR = $COD_PROVEEDOR";
        $existe_archivo = (int)\database::getInstancia()->getFila($sql_cod_proveedor);

        // Si existe archivo
        if ($existe_archivo == 1) {
            return json_encode(" COD_PROVEEDOR EXISTE");
            die();
        }else{

            $sql_insert = "INSERT INTO PLC_PROVEEDORES_PMM (COD_PROVEEDOR,RUT_PROVEEDOR,NOM_PROVEEDOR,VEND_TAXID,VEND_NAME_DEALER,VEND_BENEFICIARY,VEND_ADD_BENEFICIARY,VEND_CITY,VEND_COUNTRY,VEND_PHONE,VEND_FAX,CONT_NAME,CONT_ADDRESS,CONT_PHONE,CONT_EMAIL,PI_AUTOMATICA,COMPRA_CURVA,RFID,COD_MOD_PAIS,USU_CREA,FECHA_CREA,USU_MODIFICA,FECHA_MODIFICA,ESTADO)
                       VALUES($COD_PROVEEDOR,$RUT_PROVEEDOR,$NOM_PROVEEDOR,$VEND_TAXID,$VEND_NAME_DEALER,$VEND_BENEFICIARY,$VEND_ADD_BENEFICIARY,$VEND_CITY,$VEND_COUNTRY,$VEND_PHONE,$VEND_FAX,$CONT_NAME,$CONT_ADDRESS,$CONT_PHONE,$CONT_EMAIL,$PI_AUTOMATICA,$COMPRA_CURVA,$RFID,$COD_MOD_PAIS,'".$login."',SYSDATE,'".$login."',SYSDATE,$ESTADO)";
            //echo $sql_insert;
            //die();
            $data_insert = \database::getInstancia()->getConsulta($sql_insert);

            if($data_insert){

                $sql_insert_detalle = "INSERT INTO PIA_VENDOR_BANK (COD_PROVEEDOR,PAY_BANK_NAME_BENEFICIARY,PAY_ADD_BANK_BENEFICIARY,PAY_CITY_BENEFICIARY_BANK,PAY_COUNTRY_BENEFICIARY,PAY_SWIFT_CODE,PAY_ABA,PAY_IBAN,PAY_ACC_NUMBER_BENEFICIARY,PAY_CURRENCY_ACCOUNT,PAY_SECOND_BENEFICIARY,INTER_BANK_NAME,INTER_SWIFT,INTER_COUNTRY,INTER_CITY,PUR_CURRENCY,PUR_INCOTEM,PUR_PAYMENTO)
                                   VALUES($COD_PROVEEDOR,$PAY_BANK_NAME_BENEFICIARY,$PAY_ADD_BANK_BENEFICIARY,$PAY_CITY_BENEFICIARY_BANK,$PAY_COUNTRY_BENEFICIARY,$PAY_SWIFT_CODE,$PAY_ABA,$PAY_IBAN,$PAY_ACC_NUMBER_BENEFICIARY,$PAY_CURRENCY_ACCOUNT,$PAY_SECOND_BENEFICIARY,$INTER_BANK_NAME,$INTER_SWIFT,$INTER_COUNTRY,$INTER_CITY,$PUR_CURRENCY,$PUR_INCOTEM,$PUR_PAYMENTO)";
                //echo $sql_insert;
                //die();
                $data_insert_detalle = \database::getInstancia()->getConsulta($sql_insert_detalle);

                // Si se ejecuta la consulta
                if ($data_insert_detalle) {
                    // Acción: Crear / Eliminar / Actualizar
                    LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'Mantenedor Proveedor','Crear', $sql_insert, 'OK' );
                    LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'Mantenedor Proveedor','Crear', $sql_insert_detalle, 'OK' );
                    return json_encode("OK");
                    die();
                    // Si la consulta no se puede realizar
                } else {
                    // Acción: Crear / Eliminar / Actualizar
                    LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'Mantenedor Proveedor','Crear', $sql_insert, 'ERROR' );
                    LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'Mantenedor Proveedor','Crear', $sql_insert_detalle, 'ERROR' );
                    return json_encode("ERROR");
                    die();
                }

            }else{
                LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'Mantenedor Proveedor','Crear', $sql_insert, 'ERROR' );
                return json_encode("ERROR");
                die();
            }

        }





    // Fin de la clase
    }

    // Actualiza Proveedor
    public static function ActualizaProveedor($login, $pais_filtro_ripley,$COD_PROVEEDOR,$PI_AUTOMATICA,$COMPRA_CURVA,$RFID,$VEND_TAXID,$VEND_BENEFICIARY,$VEND_ADD_BENEFICIARY,$VEND_CITY,$VEND_COUNTRY,$VEND_PHONE,$VEND_FAX,$VEND_NAME_DEALER,$CONT_NAME,$CONT_ADDRESS,$CONT_PHONE,$CONT_EMAIL,$PAY_BANK_NAME_BENEFICIARY,$PAY_ADD_BANK_BENEFICIARY,$PAY_CITY_BENEFICIARY_BANK,$PAY_COUNTRY_BENEFICIARY,$PAY_SWIFT_CODE,$PAY_ABA,$PAY_IBAN,$PAY_ACC_NUMBER_BENEFICIARY,$PAY_CURRENCY_ACCOUNT,$PAY_SECOND_BENEFICIARY,$INTER_BANK_NAME,$INTER_SWIFT,$INTER_COUNTRY,$INTER_CITY,$PUR_CURRENCY,$incoterm,$PUR_PAYMENTO)
    {

        if( ($COD_PROVEEDOR==null) || ($COD_PROVEEDOR=="null") || ($COD_PROVEEDOR=="") || (!$COD_PROVEEDOR) ){
            return json_encode("Ingrese Código Proveedor");
            die();
        }

        if( ($PI_AUTOMATICA==null) || ($PI_AUTOMATICA=="null") || ($PI_AUTOMATICA=="") || (!$PI_AUTOMATICA) ){
            return json_encode("Ingrese PI Automática");
            die();
        }

        if( ($COMPRA_CURVA==null) || ($COMPRA_CURVA=="null") || ($COMPRA_CURVA=="") || (!$COMPRA_CURVA) ){
            return json_encode("Ingrese Compra en Curva");
            die();
        }

        if( ($RFID==null) || ($RFID=="null") || ($RFID=="") || (!$RFID) ){
            return json_encode("Ingrese RFID");
            die();
        }


        $sql = "UPDATE plc_proveedores_pmm 
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
                    WHERE COD_PROVEEDOR = $COD_PROVEEDOR";
        $data_update = \database::getInstancia()->getConsulta($sql);

        // Si se ejecuta la consulta
        if ($data_update) {
            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, $temporada, 'ND', 'Lead Time','Actualizar', $sql, 'OK' );
            return json_encode("OK");
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

    // Actualiza Portada
    public static function ActualizaPortada($login, $pais_filtro_ripley,$COD_PROVEEDOR,$PI_AUTOMATICA,$COMPRA_CURVA,$RFID)
    {

        if( ($COD_PROVEEDOR==null) || ($COD_PROVEEDOR=="null") || ($COD_PROVEEDOR=="") || (!$COD_PROVEEDOR) ){
            return json_encode("Ingrese Código Proveedor");
            die();
        }

        if( ($PI_AUTOMATICA==null) || ($PI_AUTOMATICA=="null") || ($PI_AUTOMATICA=="") || (!$PI_AUTOMATICA) ){
            return json_encode("Ingrese PI Automática");
            die();
        }

        if( ($COMPRA_CURVA==null) || ($COMPRA_CURVA=="null") || ($COMPRA_CURVA=="") || (!$COMPRA_CURVA) ){
            return json_encode("Ingrese Compra en Curva");
            die();
        }

        if( ($RFID==null) || ($RFID=="null") || ($RFID=="") || (!$RFID) ){
            return json_encode("Ingrese RFID");
            die();
        }


        $sql = "UPDATE plc_proveedores_pmm 
                SET PI_AUTOMATICA = $PI_AUTOMATICA,
                COMPRA_CURVA = $COMPRA_CURVA,
                RFID = $RFID,
                USU_MODIFICA = '".$login."',
                FECHA_MODIFICA = SYSDATE
                WHERE COD_PROVEEDOR = $COD_PROVEEDOR";
        $data_update = \database::getInstancia()->getConsulta($sql);

        // Si se ejecuta la consulta
        if ($data_update) {
            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'Mantenedor Proveedor','Actualizar', $sql, 'OK' );
            return json_encode("OK");
            die();
            // Si la consulta no se puede realizar
        } else {
            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'Mantenedor Proveedor','Actualizar', $sql, 'ERROR' );
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
                    "COD_INCOTERM" => utf8_encode($va1[0]),
                    "NOM_INCOTERM" => utf8_encode($va1[1])
                )
            );
        }

        return $array1;

    }

    // Busca Proveedor
    public static function BuscaProveedor($login, $pais_filtro_ripley, $cod_proveedor)
    {

        $sql = "SELECT 
                    T1.COD_PROVEEDOR,
                    T1.RUT_PROVEEDOR,
                    T1.NOM_PROVEEDOR,
                    T1.VEND_TAXID,
                    T1.VEND_NAME_DEALER,
                    T1.VEND_BENEFICIARY,
                    T1.VEND_ADD_BENEFICIARY,
                    T1.VEND_CITY,
                    T1.VEND_COUNTRY,
                    T1.VEND_PHONE,
                    T1.VEND_FAX,
                    T1.CONT_NAME,
                    T1.CONT_ADDRESS,
                    T1.CONT_PHONE,
                    T1.CONT_EMAIL,
                    T1.PI_AUTOMATICA,
                    T1.COMPRA_CURVA,
                    T1.RFID,
                    T1.COD_MOD_PAIS,
                    T1.USU_CREA,
                    T1.FECHA_CREA,
                    T1.USU_MODIFICA,
                    T1.FECHA_MODIFICA,
                    T1.ESTADO,
                    T1.TIPO,
                    T1.NICKNAME,
                    T1.COMMISSION,
                    T2.PAY_BANK_NAME_BENEFICIARY,
                    T2.PAY_ADD_BANK_BENEFICIARY,
                    T2.PAY_CITY_BENEFICIARY_BANK,
                    T2.PAY_COUNTRY_BENEFICIARY,
                    T2.PAY_SWIFT_CODE,
                    T2.PAY_ABA,
                    T2.PAY_IBAN,
                    T2.PAY_ACC_NUMBER_BENEFICIARY,
                    T2.PAY_CURRENCY_ACCOUNT,
                    T2.PAY_SECOND_BENEFICIARY,
                    T2.INTER_BANK_NAME,
                    T2.INTER_SWIFT,
                    T2.INTER_COUNTRY,
                    T2.INTER_CITY,
                    T2.PUR_CURRENCY,
                    T2.PUR_INCOTEM,
                    T2.PUR_PAYMENTO
                FROM PLC_PROVEEDORES_PMM T1
                INNER JOIN PIA_VENDOR_BANK T2 ON T2.COD_PROVEEDOR = T1.COD_PROVEEDOR
                WHERE T1.COD_PROVEEDOR = $cod_proveedor";

        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {

            array_push($array1, array(
                 "COD_PROVEEDOR" => $va1[0]
                ,"RUT_PROVEEDOR" => $va1[1]
                ,"NOM_PROVEEDOR" => $va1[2]
                ,"VEND_TAXID" => utf8_encode($va1[3])
                ,"VEND_NAME_DEALER" => $va1[4]
                ,"VEND_BENEFICIARY" => $va1[5]
                ,"VEND_ADD_BENEFICIARY" => $va1[6]
                ,"VEND_CITY" => $va1[7]
                ,"VEND_COUNTRY" => $va1[8]
                ,"VEND_PHONE" => $va1[9]
                ,"VEND_FAX" => $va1[10]
                ,"CONT_NAME" => $va1[11]
                ,"CONT_ADDRESS" => $va1[12]
                ,"CONT_PHONE" => $va1[13]
                ,"CONT_EMAIL" => $va1[14]
                ,"PI_AUTOMATICA" => $va1[15]
                ,"COMPRA_CURVA" => $va1[16]
                ,"RFID" => $va1[17]
                ,"COD_MOD_PAIS" => $va1[18]
                ,"USU_CREA" => $va1[19]
                ,"FECHA_CREA" => $va1[20]
                ,"USU_MODIFICA" => $va1[21]
                ,"FECHA_MODIFICA" => $va1[22]
                ,"ESTADO" => $va1[23]
                ,"TIPO" => $va1[24]
                ,"NICKNAME" => $va1[25]
                ,"COMMISSION" => $va1[26]
                ,"PAY_BANK_NAME_BENEFICIARY" => $va1[27]
                ,"PAY_ADD_BANK_BENEFICIARY" => $va1[28]
                ,"PAY_CITY_BENEFICIARY_BANK" => $va1[29]
                ,"PAY_COUNTRY_BENEFICIARY" => $va1[30]
                ,"PAY_SWIFT_CODE" => $va1[31]
                ,"PAY_ABA" => $va1[32]
                ,"PAY_IBAN" => $va1[33]
                ,"PAY_ACC_NUMBER_BENEFICIARY" => $va1[34]
                ,"PAY_CURRENCY_ACCOUNT" => $va1[35]
                ,"PAY_SECOND_BENEFICIARY" => $va1[36]
                ,"INTER_BANK_NAME" => $va1[37]
                ,"INTER_SWIFT" => $va1[38]
                ,"INTER_COUNTRY" => $va1[39]
                ,"INTER_CITY" => $va1[40]
                ,"PUR_CURRENCY" => $va1[41]
                ,"PUR_INCOTEM" => $va1[42]
                ,"PUR_PAYMENTO" => $va1[43]
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