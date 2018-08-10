<?php

namespace simulador_compra;

/**
 * Description of tipo_de_tienda
 * @author epacheco
 * @edida Roberto Pérez 23-03-2018
 */
class tipo_de_tienda
{

    // Carga Select de Marcas
    public static function getMarcas($depto)
    {
        $sql = "begin PLC_PKG_PRUEBA.PRC_LISTAR_DEPTO_MARCA('".$depto."', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;
    }

    // Listar Ventanas
    public static function getVentanas($depto,$temporada)
    {

        // pregunto si tiene cluster, si no tiene los agrego y luego listo
        $sql = "SELECT 1
                 FROM   PLC_SEGMENTOS
                 WHERE  COD_TEMPORADA = '".$temporada."'
                 AND    DEP_DEPTO     = '".$depto."'
                 ";

        $existe = (int) \database::getInstancia()->getFila($sql);


        if ($existe == 1) {

            // Listar Clusters
            $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_SEGMENTOS('".$temporada."','".$depto."',0,0, :data); end;";
            $data = \database::getInstancia()->getConsultaSP($sql, 1);
            return $data;

        }else{
            // Inserto los Clusters
            $sql_inserta =  "INSERT INTO PLC_SEGMENTOS (cod_temporada,dep_depto,niv_jer1,cod_jer1,cod_seg,des_seg)
                        select ".$temporada.",'".$depto."',0,'0',1,'A' from dual union
                        select ".$temporada.",'".$depto."',0,'0',2,'B' from dual union
                        select ".$temporada.",'".$depto."',0,'0',3,'C' from dual union
                        select ".$temporada.",'".$depto."',0,'0',4,'I' from dual";

            $data_inserta = \database::getInstancia()->getConsulta($sql_inserta);

            // Listar clusters insertados previamente
            $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_SEGMENTOS('".$temporada."','".$depto."',0,0, :data); end;";
            $data = \database::getInstancia()->getConsultaSP($sql, 1);
            return $data;

        }




    }

    // Revisar si despliega tipo de tienda
    public static function getCluster($tempo, $depto)
    {
        $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_SEGMENTOS('" . $tempo . "','" . $depto . "', :data); end";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;
    }

    // Carga ListBox de Disponible
    public static function getDisponibles($temporada, $depto, $marca, $tienda)
    {

        $sql = "begin PLC_PKG_PRUEBA.PRC_LISTAR_TDA($temporada,'".$depto."',$marca, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $disponibles = array();
        foreach ($data as $val) {
            $disponibles[] = $val[0] . '#' . utf8_decode($val[1]);
        }
        return $disponibles;

    }

    // Carga ListBox de Asignados
    public static function getAsignados($temporada, $depto, $marca, $tienda)
    {

        $sql = "SELECT DISTINCT
                P.COD_TDA AS COD_SUC,
                INITCAP( TRIM( BOSACC_FUN_OBT_NOM_SUC( P.COD_TDA ) ) ) AS DES_SUC
                 FROM   PLC_SEGMENTOS_TDA P
                 WHERE  P.COD_TEMPORADA = $temporada
                 AND    P.DEP_DEPTO     = '" . $depto . "'
                 AND    P.COD_MARCA = $marca
                 AND    DECODE( $tienda, 0, 0,P.COD_SEG ) = $tienda
                 ORDER BY 2
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;


    }

    public static function busca_existe_internet($temporada, $depto, $marca, $tienda)
    {

        $sql = "SELECT * FROM PLC_SEGMENTOS_TDA
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND cod_seg = $tienda
                AND cod_tda = 10039
                AND cod_marca = $marca
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Quitar tiendas (SEGMENTOS)
    public static function quitarTiendas($temporada, $depto, $marca, $tienda, $asignado,$login)
    {
        $sql = "begin PLC_PKG_GENERAL.PRC_DEL_SEGMENTOS_TDA('" . $temporada . "','" . $depto . "',0,0," . $tienda . "," . $asignado . "," . $marca . ", :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORTIENDA-QUITARTIENDAS--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;
    }

    // Quitar todas tiendas (SEGMENTOS)
    public static function quitar_todas_tienda($temporada, $depto, $marca, $tienda, $login, $string_asignados)
    {

        // Quitamos los registros
        $sql_quitar = "DELETE FROM PLC_SEGMENTOS_TDA
                        WHERE cod_temporada = $temporada
                        AND dep_depto = '" . $depto . "'
                        AND cod_seg = $tienda
                        AND cod_marca = $marca
                        ";

        // Quitamos los registros, luego de eso agregamos las tiendas asignadas
        if(\database::getInstancia()->getConsulta($sql_quitar)){

if(strlen($string_asignados)>0){

            $tiendas = explode(",", $string_asignados);
            foreach ($tiendas as $vals) {

                $sql_agregar = "INSERT INTO PLC_SEGMENTOS_TDA(COD_TEMPORADA,DEP_DEPTO,NIV_JER1,COD_JER1,COD_SEG,COD_TDA,COD_MARCA)
                                VALUES($temporada,'".$depto."',0,0,$tienda,$vals,$marca)
                                ";
                \database::getInstancia()->getConsulta($sql_agregar);

                // Guardamos registros del agregar
                if (!file_exists('../archivos/log_querys/'.$login)) {
                    mkdir('../archivos/log_querys/'.$login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql_agregar;
                $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORTIENDA-ALMACENATIENDAS--".$login."-".$stamp." R".$rand.".txt","wb");
                fwrite($fp,$content);
                fclose($fp);

            }



}

            // Guardamos registros del eliminar
            if (!file_exists('../archivos/log_querys/'.$login)) {
                mkdir('../archivos/log_querys/'.$login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_quitar;
            $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORTIENDA-QUITARTODASTIENDAS--".$login."-".$stamp." R".$rand.".txt","wb");
            fwrite($fp,$content);
            fclose($fp);

        }else{
            return 0;
        }


    }

    // Almacenar tiendas (SEGMENTOS)
    public static function almacenaTiendas($temporada, $depto, $marca, $tienda, $asignado,$login)
    {

        $sql = "INSERT INTO PLC_SEGMENTOS_TDA(COD_TEMPORADA,DEP_DEPTO,NIV_JER1,COD_JER1,COD_SEG,COD_TDA,COD_MARCA)
                VALUES($temporada,'".$depto."',0,0,$tienda,$asignado,$marca)
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORTIENDA-ALMACENATIENDAS--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;



    }

    // Botón replicar otras temporadas - Llena el CBX de temporada del popup
    public static function replicarTiendas($temporada, $depto, $marca)
    {
        /*$sql = "begin PLC_PKG_MIGRACION.PRC_TEMP_CONFIGTIENDAS($temporada, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;*/

        // --convert(REPLACE(REPLACE(REPLACE(r.NOM_TEMPORADA_CORTO,CHR(9),''),CHR(10),''),CHR(13),''),'utf8','us7ascii') NOM_TEMPORADA

        $sql = "SELECT DISTINCT a.cod_temporada,
                       r.NOM_TEMPORADA_CORTO
                FROM plc_segmentos_tda a 
                LEFT JOIN plc_temporada R ON a.COD_TEMPORADA = R.COD_TEMPORADA   
                WHERE a.cod_temporada <> $temporada
                AND a.dep_depto = '".$depto."'
                AND  a.cod_marca = $marca
                ";

        $data = \database::getInstancia()->getFilas($sql);


        return $data;

    }

    // Llenar al CBX de las Tempuradas del popup duplicar
    public static function llenarCargaTemporadaTiendas($temporada, $depto)
    {
        //  PLC_PKG_MIGRACION.PRC_TEMP_CONFIGTIENDAS
        $sql = "begin PLC_PKG_MIGRACION.PRC_TEMP_CONFIGTIENDAS($temporada, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;
    }

    // Listar Carga Temporada
    public static function listarCargaTemporadaTiendas($temporada, $depto, $login)
    {
        $sql = "begin PLC_PKG_MIGRACION.PRC_LISTAR_CONFIGTIENDAS($temporada,'".$depto."', :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORTIENDA-LISTACARGATEMPTIENDA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        /*$data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;*/

        if(\database::getInstancia()->getConsultaSP($sql, 1)){
            return 1;
        }else{
            return 0;
        }


    }

    // Agrega Carga Temporada
    public static function agregaCargaTemporadaTiendas($V_COD_TEMPORADA, $V_DEP_DEPTO, $V_NIV_JER1, $_COD_JER1, $V_COD_SEG, $V_COD_TDA, $V_COD_MARCA,$login)
    {
        $sql = "begin PLC_PKG_MIGRACION.PRC_ADD_CONFIGTIENDAS('".$V_COD_TEMPORADA."','".$V_DEP_DEPTO."','".$V_NIV_JER1."','".$_COD_JER1."','".$V_COD_SEG."','".$V_COD_TDA."','".$V_COD_MARCA."', :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORTIENDA-AGREGACARGATEMPTIENDA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;
    }

    // Quitar Carga Temporada
    public static function quitarCargaTemporadaTiendas($temporada, $depto, $login,$marca,$temp_login)
    {

        // Elimina: PLC_PKG_MIGRACION.PRC_DELFULL_CONFIGTIENDAS_WEB
        // Lista:   PLC_PKG_MIGRACION.PRC_LISTAR_CONFIGTIENDAS
        // Agrega:  PLC_PKG_MIGRACION.PRC_ADD_CONFIGTIENDAS

        $sql = "begin PLC_PKG_MIGRACION.PRC_DELFULL_CONFIGTIENDAS_WEB($temp_login,$temporada,'" . $depto . "',$marca, :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORTIENDA-QUITARCARGATEMPTIENDA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        // $data = \database::getInstancia()->getConsultaSP($sql, 2);
        // var_dump($data);
        // return 0;

        if(\database::getInstancia()->getConsultaSP($sql, 2)){
            return 1;
        }else{
            return 0;
        }

    // Fin quitarCargaTemporadaTiendas
    }




// Fin de la clase
}
