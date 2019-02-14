<?php

namespace encabezado_detalle_pi;

use log_transaccion\LogTransaccionClass;

class EncabezadoDetallePiClass extends \parametros
{

    // Listar PI => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarP5Encabezado($login,$pais)
    {

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_LISTAR_P5_ENCABEZADO('".$login."',$pais, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                "ID" => utf8_encode($val[2])
                ,"NOM_EST_C1" => utf8_encode($val[0])
                ,"PI_VENDOR" => utf8_encode($val[1])
                ,"PROFORMA" => utf8_encode($val[2]) // UTF-8 Si me Trae String
                ,"NOM_PAIS" => utf8_encode($val[3]) // UTF-8 Si me Trae String
                ,"INCOTERM" => $val[4]
                ,"COD_PUERTO" => utf8_encode($val[5]) // UTF-8 Si me Trae String
                ,"TOTAL_WEIGHT" => $val[6]
                ,"CBM" => $val[7]
                ,"ESTADO" => $val[8]
                ,"COD_PUERTO_COD" => $val[9]
                ,"DEP_DEPTO" => $val[10]
                ,"COD_MOD_PAIS" => $val[11]
                )
            );
        }

        return $array;

    }

    // Listar Cuerpo
    public static function ListarP5Cuerpo($login,$pais,$proforma)
    {

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_LISTAR_P5_CUERPO('".$login."',$pais,'".$proforma."', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                 "ID" => utf8_encode($val[2])
                ,"NOM_EST_C1" => utf8_encode($val[0])
                ,"PI_VENDOR" => utf8_encode($val[1])
                ,"PROFORMA" => utf8_encode($val[2])
                ,"DES_ESTILO" => utf8_encode($val[3])
                ,"NOM_PAIS" => utf8_encode($val[4])
                ,"NOM_MARCA" => utf8_encode($val[5])
                ,"NOM_LINEA" => utf8_encode($val[6])
                ,"COSTO_INSP" => $val[7]
                ,"UNIDADES" => $val[8]
                ,"COSTO_FOB" => $val[9]
                ,"COSTO_TOT" => $val[10]
                ,"MTR_PACK" => $val[11]
                ,"CANT_INNER" => $val[12]
                ,"FECHA_EMBARQUE_ACORDADA" => utf8_encode($val[13])
                ,"NOM_PUERTO" => utf8_encode($val[14])
                ,"DESTALLA" => utf8_encode($val[15])
                ,"COLOR" => utf8_encode($val[16])
                ,"ESTADO" => $val[17]
                ,"COD_PUERTO" => $val[18]
                )
            );
        }

        return $array;

    }

    // Listar Opción => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarOpcion($temporada, $depto,$login,$pais)
    {

        $sql = "SELECT CAMPO1,CAMPO3,CAMPO3 FROM TABLA";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                    "CAMPO1" => $val[0]
                ,"CAMPO2" => $val[1]
                ,"CAMPO3" => utf8_encode($val[2]) // UTF-8 Si me Trae String
                )
            );
        }

        return $array;

    }

    // Listar Variación => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public static function ListarVariacion($temporada, $depto,$login,$pais)
    {

        $sql = "SELECT CAMPO1,CAMPO3,CAMPO3 FROM TABLA";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array = [];
        foreach ($data as $val) {
            array_push($array, array(
                    "CAMPO1" => $val[0]
                ,"CAMPO2" => $val[1]
                ,"CAMPO3" => utf8_encode($val[2]) // UTF-8 Si me Trae String
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

    // Listar Incoterm
    public static function ListarIncoterm($login, $pais_filtro_ripley)
    {

        $sql = "SELECT COD_INCOTERM, NOM_INCOTERM FROM PIA_INCOTERM ORDER BY NOM_INCOTERM";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1, array(
                    "COD_INCOTERM" => $va1[0]." - ".utf8_encode($va1[1]),
                    "NOM_INCOTERM" => $va1[0]." - ".utf8_encode($va1[1])
                )
            );
        }

        return $array1;

    }




    // ActualizaIncoterm
    public static function ActualizaIncoterm($login,$PROFORMA,$COD_MOD_PAIS)
    {

        $sql = "BEGIN PIA_PKG_PIAUTOMATICA.PRC_ACT_INCOTERM('".$login."','".$PROFORMA."',$COD_MOD_PAIS, :error, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,2);

        if($data == 0){

            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'PIA Pantalla 5 - UPDATE INCOTERM','Actualizar', $sql, 'OK' );

            return "OK";
            die();

        }else{

            // Acción: Crear / Eliminar / Actualizar
            LogTransaccionClass::GuardaLogTransaccion($login, 0, 'ND', 'PIA Pantalla 5 - UPDATE INCOTERM','Actualizar', $sql, 'ERROR' );

            return "ERROR";
            die();

        }

    }




// Fin de la Clase
}