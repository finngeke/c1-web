<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace simulador_compra;

/**
 * Descripción de formato
 *
 * @author Roberto Pérez 18-04-2018
 */

class tipo_ppto_retail
{

    // Listar Registros
    public static function buscarPptoRetail($temporada, $depto, $login)
    {
        $sql =  "SELECT MATI as VALOR_UNI
                 FROM   PLC_PPTO_RETAIL C
                 WHERE  C.COD_TEMPORADA = $temporada
                 AND    C.DEP_DEPTO     = '".$depto."'
        ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Cargar Registros
    public static function almacenaPptoRetail($temporada,$depto,$presupuesto,$user, $login)
    {

        $sql = "INSERT INTO PLC_PPTO_RETAIL( COD_TEMPORADA,
                                   DEP_DEPTO,
                                   NIV_JER1,
                                   COD_JER1,
                                   NIV_JER2,
                                   COD_JER2,
                                   MATI,
                                   USR_CRE,
                                   FEC_CRE )
                           VALUES( $temporada,
                                   '" . $depto . "',
                                   0,
                                   0,
                                   0,
                                   0,
                                   $presupuesto,
                                   '" . $user . "',
                                   SYSDATE )";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTORETAIL-AGREGA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;


    }

    // Quitar
    public static function eliminarPptoRetail($temporada, $depto, $user, $login)
    {

        $sql = "DELETE FROM PLC_PPTO_RETAIL P
                WHERE P.COD_TEMPORADA = $temporada          
                AND P.DEP_DEPTO = '".$depto."'
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTORETAIL-QUITAR--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }


}
