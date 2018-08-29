<?php

namespace simulador_compra;

class formato
{

    // Carga Select de Marcas
    public static function getFormatos($temporada, $depto)
    {
        $sql = "SELECT COD_SEG, DES_SEG 
                FROM PLC_FORMATO 
                WHERE COD_TEMPORADA = $temporada 
                AND DEP_DEPTO = '" . $depto . "' 
                ORDER BY COD_SEG
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    // Carga ListBox de Disponible
    public static function getDisponibles($temporada, $depto, $formato)
    {

        $sql = "SELECT  S.SUC_SUCURSAL AS COD_SUC,
                        INITCAP(TRIM(S.SUC_NOMBRE)) AS DES_SUC
                 FROM GST_MAESUCURS S
                 WHERE SUC_SUCURSAL NOT IN (SELECT DISTINCT P.COD_TDA AS COD_SUC
                                              FROM   PLC_FORMATOS_TDA P
                                              WHERE  P.COD_TEMPORADA = $temporada
                                              AND    P.DEP_DEPTO     = '" . $depto . "'
                                              AND    DECODE( " . $formato . ", 0, 0,P.COD_SEG ) = " . $formato . "
                                              )
                 ORDER BY  INITCAP(TRIM(S.SUC_NOMBRE)) ASC
                 ";

        $data = \database::getInstancia()->getFilas($sql);
        $disponibles = array();
        foreach ($data as $val) {
            $disponibles[] = $val[0] . '#' . utf8_decode($val[1]);
        }
        return $disponibles;


    }

    // Carga ListBox de Asignados
    public static function getAsignados($temporada, $depto, $formato)
    {

        $sql = " SELECT DISTINCT
                P.COD_TDA                                              AS COD_SUC,
                INITCAP( TRIM( BOSACC_FUN_OBT_NOM_SUC( P.COD_TDA ) ) ) AS DES_SUC
         FROM   PLC_FORMATOS_TDA P
         WHERE  P.COD_TEMPORADA = $temporada
         AND    P.DEP_DEPTO     = '" . $depto . "'
         AND    DECODE( " . $formato . ", 0, 0,P.COD_SEG ) = " . $formato . "
         ORDER BY 2
         ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Revisar si despliega tipo de tienda
    public static function getCluster($tempo, $depto)
    {
        $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_SEGMENTOS($tempo,'" . $depto . "', :data); end";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;
    }

    // Quitar 
    public static function quitarFormato($temporada, $depto, $formato, $asignado,$login)
    {

        $sql = "DELETE FROM plc_formatos_tda
                WHERE  COD_TEMPORADA  = $temporada
                AND    DEP_DEPTO      = '" . $depto . "'
                AND    COD_SEG        = " . $formato . "
                AND    COD_TDA        = " . $asignado . "
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORFORMATO-QUITARFORMATO--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        // $data = \database::getInstancia()->getConsulta($sql);

        if(\database::getInstancia()->getConsulta($sql)){
            return 1;
        }else{
            return 0;
        }


    }

    // Quitar cuando no hay registros
    public static function quitar_formato_noasignados($temporada, $depto, $formato, $asignado,$login)
    {

        $sql = "DELETE FROM plc_formatos_tda
                WHERE  COD_TEMPORADA  = $temporada
                AND    DEP_DEPTO      = '" . $depto . "'
                AND    COD_SEG        = " . $formato . "
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORFORMATO-QUITARFORMATONOASIGNADO--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        // $data = \database::getInstancia()->getConsulta($sql);

        if(\database::getInstancia()->getConsulta($sql)){
            return 1;
        }else{
            return 0;
        }


    }


    // Quitar Todos
    public static function quitarTodoFormato($temporada, $depto, $formato, $asignado,$login)
    {

        $sql = "DELETE FROM plc_formatos_tda
                WHERE  COD_TEMPORADA  = " . $temporada . "
                AND    DEP_DEPTO      = '" . $depto . "'
                AND    COD_SEG        = " . $formato . "
        ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORFORMATO-QUITARTODOFORMATO--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);


        // $data = \database::getInstancia()->getConsulta($sql);

        if(\database::getInstancia()->getConsulta($sql)){
            return 1;
        }else{
            return 0;
        }

    }

    // Almacenar
    public static function almacenaFormato($temporada, $depto, $formato, $asignado, $login)
    {

        $sql = "INSERT INTO PLC_FORMATOS_TDA( 
                      COD_TEMPORADA ,
                      DEP_DEPTO     ,
                      NIV_JER1 ,
                      COD_JER1,
                      COD_SEG,
                      COD_TDA)
                    VALUES(" . $temporada . ",'" . $depto . "',0,0," . $formato . "," . $asignado . ")
        ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORFORMATO-ALMACENAFORMATO--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        // $data = \database::getInstancia()->getConsulta($sql);

        if(\database::getInstancia()->getConsulta($sql)){
            return 1;
        }else{
            return 0;
        }


    }

    // Almacena Nuevo Formato (Enviado desde el modal)
    public static function almacenaNuevoFormato($temporada, $depto, $formato, $login)
    {

        $sql = "INSERT INTO PLC_Formato  VALUES( "
            . $temporada . ","
            . "'" . $depto . "',0,0,"
            . " (SELECT (NVL( MAX( TO_NUMBER( COD_SEG ) ), 0 ) + 1 ) AS INCREMENTAL FROM"
            . " PLC_Formato WHERE  COD_TEMPORADA = "
            . $temporada . " AND DEP_DEPTO = '" . $depto . "')," .
            "'" . $formato . "')";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORFORMATO-ALMACENANUEVOFORMATO--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        //$data = \database::getInstancia()->getConsulta($sql);

        if(\database::getInstancia()->getConsulta($sql)){
            return 1;
        }else{
            return 0;
        }


    }


}
