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
 * @author Roberto Pérez 13-04-2018
 */

class tipo_ppto_costo
{

    // Listar Registros
    public static function buscarPptoCosto($temporada, $depto, $login)
    {
        $sql =  " SELECT PRESUPUESTO as VALOR_UNI"
            ." FROM   PLC_PPTO_COSTO C"
            ." WHERE  C.COD_TEMPORADA =" . $temporada
            ." AND    C.DEP_DEPTO     = '" . $depto . "'
            ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Cargar Registros
    public static function almacenaPptoCosto($temporada,$depto,$presupuesto,$user, $login)
    {

        $sql = "INSERT INTO PLC_PPTO_COSTO( COD_TEMPORADA,
                                   DEP_DEPTO,
                                   NIV_JER1,
                                   COD_JER1,
                                   NIV_JER2,
                                   COD_JER2,
                                   PRESUPUESTO,
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
                                   SYSDATE )
                                   ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTOCOSTO-AGREGA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;


    }

    // Quitar
    public static function eliminarPptoCosto($temporada, $depto, $user, $login)
    {

        $sql = "DELETE FROM PLC_PPTO_COSTO 
                WHERE cod_temporada = $temporada 
                AND dep_depto = '" . $depto . "'
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTOCOSTO-QUITAR--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }

}