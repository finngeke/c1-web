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

class tipo_ventana_llegada
{

    // Listar Registros
    public static function listarVentanaLlegada($temporada, $depto, $login)
    {

        $sql = " SELECT X.COD_VENTANA,
                       X.Ventana ,
                       SUM(X.Porcentaje) Porcentaje
                       FROM (
                        SELECT v.COD_VENTANA,
                               V.VENT_DESCRI Ventana,
                               NVL(e.PORCENTAJE,0) Porcentaje
                               FROM  PLC_VENTANA V,PLC_PPTO_EMB E
                               WHERE E.COD_TEMPORADA = '" . $temporada . "'
                               AND E.DEP_DEPTO = '" . $depto . "'
                               AND E.COD_VENTANA = V.COD_VENTANA
                         UNION
                         SELECT V.COD_VENTANA,
                                V.VENT_DESCRI Ventana,
                                0 Porcentaje
                                FROM PLC_VENTANA V
                                 ) X
                               GROUP BY X.COD_VENTANA,X.VENTANA
                               ORDER BY X.Ventana
                 ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Cargar Registros
    public static function almacenaVentanaLlegada($temporada, $depto, $ventana, $porcentaje,$user, $login)
    {

       $sql = "INSERT INTO PLC_PPTO_EMB ( COD_TEMPORADA,
                                  DEP_DEPTO,
                                  NIV_JERARQUIA,
                                  COD_JERARQUIA,
                                  COD_VENTANA,
                                  PORCENTAJE,
                                  USR_CRE,
                                  FEC_CRE )
               VALUES($temporada,
                    '".$depto."',
                    0,
                    0,
                    ".$ventana.",
                    '".$porcentaje."',
                    '".$user."',
                    SYSDATE)
                    ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/VENTANALLEGADA-AGREGA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }

    // Quitar registros previos (No se usa SP, conversado con eduardo... para evitar el update que necesita otro valor de entrada)
    public static function eliminarVentanaLlegada($temporada, $depto, $user, $login)
    {

        $sql = "DELETE FROM PLC_PPTO_EMB 
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
        $fp = fopen("../archivos/log_querys/".$login."/VENTANALLEGADA-QUITAR--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;
        //return 0;

    }


// Fin de la clase
}
