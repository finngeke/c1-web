<?php

namespace resumen_estilos;

use log_transaccion\LogTransaccionClass;
use cartero\CarteroClass;

class ResumenEstilosClass extends \parametros
{

    // Listar Resumen Estilos => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarResumenEstilos($temporada, $depto,$login,$pais)
    {

        //CarteroClass::EnviarCorreo('lperezs@ripley.com','Asunto hola','mensaje de ejemplo');


        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_LISTAR_RESUMEN_ESTILO('$login',$pais, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(

                //DEPTO+PAIS+MARCA+LINEA+FECHA+    ESTILO
                 "ID" => $val[11]
                ,"PROFORMA" => ""
                ,"DES_ESTILO" => trim($val[0])
                ,"COD_MOD_PAIS" => utf8_encode(trim($val[1]))
                ,"NOM_MARCA" => utf8_encode(trim($val[2])) // UTF-8 Si me Trae String
                ,"NOM_LINEA" => utf8_encode(trim($val[3])) // UTF-8 Si me Trae String
                ,"COSTO_INSP" => $val[4]
                ,"UNIDADES" => number_format($val[5],0,",",".") //$val[5]
                ,"COSTO_FOB" => $val[6]
                ,"COSTO_TOT" => number_format($val[7],0,",",".") //$val[7]
                ,"MTR_PACK" => $val[8]
                ,"CANT_INNER" => $val[9]
                ,"FECHA_EMBARQUE_ACORDADA" => trim($val[10])
                ,"COD_PUERTO" => ""
                ,"DEP_DEPTO" => trim($val[11])
                )
            );
        }

        return $array;


    }

    // Listar Temporada
    public static function ListarTemporada($login,$pais)
    {

        /*$sql = "SELECT COD_TEMPORADA, NOM_TEMPORADA_CORTO FROM PLC_TEMPORADA ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);*/

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_LISTAR_TEMPORADA(".$login.",$pais, :data); end;";
        echo $sql;
        die();
        $data = \database::getInstancia()->getConsultaSP($sql,1);

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

        /*$sql = "SELECT COD_VENTANA, VENT_DESCRI FROM plc_ventana ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);*/

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_LISTAR_VENTANA(".$login.",$pais, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);

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

        /*$sql = "SELECT DEP_DEPTO,DEP_DESCRIPCION FROM gst_maedeptos ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);*/

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_LISTAR_DEPTO(".$login.",$pais, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);

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

        /*$sql = "SELECT
                   T1.COD_PUERTO,
                   T1.NOM_PUERTO 
                FROM PIA_PUERTOS T1
                LEFT JOIN plc_proveedores_pmm T2 ON T2.VEND_COUNTRY = T1.CNTRY_LVL_CHILD 
                WHERE T2.COD_PROVEEDOR = $login";
        $data = \database::getInstancia()->getFilas($sql);*/

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_LISTAR_DELIVERY_PORT(".$login.",$pais, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                    "COD_PUERTO" => trim($val[0])." - ".utf8_encode($val[1])
                ,"NOM_PUERTO" => trim($val[0])." - ".utf8_encode($val[1]) // UTF-8 Si me Trae String
                )
            );
        }

        return $array;

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

    // Actualizar Registros en PIA_RESUMEN_ESTILO_PASO
    public static function ActualizaResumenEstilos($login,$ID,$PROFORMA,$DES_ESTILO,$COD_MOD_PAIS,$NOM_MARCA,$NOM_LINEA,$FECHA_EMBARQUE_ACORDADA,$COD_PUERTO,$DEP_DEPTO)
    {
        // Agregar el cambio de estado
        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_ACTUALIZA_RESUMEN_ESTILO('".$login."','".$PROFORMA."','".$DES_ESTILO."','".$COD_MOD_PAIS."','".$NOM_MARCA."','".$NOM_LINEA."','".$FECHA_EMBARQUE_ACORDADA."','".$COD_PUERTO."','".$DEP_DEPTO."', :error, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,2);

        // Se pudo actualizar el registro en PIA_RESUMEN_ESTILO_PASO, actualizo plan compra color 3
        if($data==0){

            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, 0, $DEP_DEPTO, 'PIA Pantalla 4 - UPDATE','Actualizar', $sql, 'OK' );

            $sql_color3 = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_ACT_COLOR3_RESUMEN_ESTILO('".$login."','".$PROFORMA."','".$DES_ESTILO."','".$COD_MOD_PAIS."','".$NOM_MARCA."','".$NOM_LINEA."','".$FECHA_EMBARQUE_ACORDADA."','".$COD_PUERTO."','".$DEP_DEPTO."', :error, :data); end;";
            $data_color3 = \database::getInstancia()->getConsultaSP($sql_color3,2);

            if($data_color3==0){

                // Acción: Crear / Eliminar / Actualizar
                LogTransaccionClass::GuardaLogTransaccion($login, 0, $DEP_DEPTO, 'PIA Pantalla 4 - UPDATE C3','Actualizar', $sql_color3, 'OK' );


                return json_encode("OK");
                die();

            }else{
                return json_encode("NO ENCONTRADO ".$data_color3);
                die();
            }


        }else{
            return json_encode(" Error saving: Delivery Date: ".$FECHA_EMBARQUE_ACORDADA." Port of Delivery: ".$COD_PUERTO." VendorPI: ".$COD_PUERTO." Style Name: ".$DES_ESTILO);
            die();
        }

    }

    // Actualizar Registros en PIA_RESUMEN_ESTILO_PASO
    public static function ActualizaResumenEstiloPaso($login,$ID,$PROFORMA,$DES_ESTILO,$COD_MOD_PAIS,$NOM_MARCA,$NOM_LINEA,$FECHA_EMBARQUE_ACORDADA,$COD_PUERTO,$DEP_DEPTO)
    {
        // Agregar el cambio de estado
        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_ACT_RESUMEN_ESTILO('".$login."','".$PROFORMA."','".$DES_ESTILO."','".$COD_MOD_PAIS."','".$NOM_MARCA."','".$NOM_LINEA."','".$FECHA_EMBARQUE_ACORDADA."','".$COD_PUERTO."','".$DEP_DEPTO."', :error, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,2);

        // return "<br>".$data;

        // Se pudo actualizar el registro en PIA_RESUMEN_ESTILO_PASO, actualizo plan compra color 3
        if($data==0){

            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, 0, $DEP_DEPTO, 'PIA Pantalla 4 - UPDATE','Actualizar', $sql, 'OK' );

            //return json_encode("OK");
            return "OK";
            die();


        }else{
            //return json_encode("ERROR");
            return "ERROR";
            die();
        }

    }

    // Actualizar Registros en COLOR 3
    public static function ActualizaColor3($login,$ID,$PROFORMA,$DES_ESTILO,$COD_MOD_PAIS,$NOM_MARCA,$NOM_LINEA,$FECHA_EMBARQUE_ACORDADA,$COD_PUERTO,$DEP_DEPTO)
    {

        $sql_color3 = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_ACT_COLOR3('".$login."','".$PROFORMA."','".$DES_ESTILO."','".$COD_MOD_PAIS."','".$NOM_MARCA."','".$NOM_LINEA."','".$FECHA_EMBARQUE_ACORDADA."','".$COD_PUERTO."','".$DEP_DEPTO."', :error, :data); end;";
        $data_color3 = \database::getInstancia()->getConsultaSP($sql_color3,2);

        return $data_color3;

        /*if($data_color3 == 0){

            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, 0, $DEP_DEPTO, 'PIA Pantalla 4 - UPDATE C3','Actualizar', $sql_color3, 'OK' );

            return "OK";
            die();

        }else{
            return "ERROR";
            die();
        }*/

    }


// Fin de la Clase
}