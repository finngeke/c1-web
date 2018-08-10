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
 * @author Roberto Pérez 21-05-2018
 */

class deptomarca
{

    // Obtiene Division
    public static function obtiene_division($temporada, $depto)
    {

        $sql = "SELECT T.DIV_DIVISION,
                       T.DIV_DESCRIPCION,
                       ROWNUM  AS INDICE
                FROM   (  SELECT DIV_DIVISION,
                                 DIV_DESCRIPCION
                          FROM   GST_MAEDIVISI
                          where DIV_DIVISION not in('G05','G08','G07','G10')
                          ORDER BY DIV_DESCRIPCION
                        ) T
                ORDER BY INDICE";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

        /*$sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_DIVISION('" . $tempo . "','" . $depto . "', :data); end";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;*/

    }

    // Obtiene Depto
    public static function obtiene_depto($temporada, $depto, $division)
    {
        $sql = "SELECT DISTINCT COD_DEPTO,DEPTO FROM (SELECT RANK() OVER (PARTITION BY P1.PRD_LVL_NUMBER ORDER BY P1.PRD_LVL_NUMBER) NUMERO,
                       P5.PRD_LVL_NUMBER          AS COD_DIV,
                       P5.PRD_NAME_FULL           AS DIVISION,
                       P3.PRD_LVL_NUMBER          AS COD_DEPTO,
                       P3.PRD_NAME_FULL           AS DEPTO,
                       P2.PRD_LVL_NUMBER          AS COD_LINEA,
                       P2.PRD_NAME_FULL           AS LINEA,
                       P1.PRD_LVL_NUMBER          AS COD_SUBLINEA,
                       P1.PRD_NAME_FULL           AS SUBLINEA,
                        NVL((SELECT X.MSTPACK
                             FROM PLC_MSTPACK X
                             WHERE  TRIM(P3.PRD_LVL_NUMBER)   =X.COD_DEPTO      
                             AND    TRIM(P2.PRD_LVL_NUMBER)   =X.COD_LIN        
                             AND    TRIM(P1.PRD_LVL_NUMBER)   =X.COD_SUBLIN),0) AS MSTPACK
                      ,''ACTION                                 
                FROM PRDMSTEE P1,
                     PRDMSTEE P2,
                     PRDMSTEE P3,
                     PRDMSTEE P4,
                     PRDMSTEE P5
                WHERE P1.PRD_LVL_ID       =2
                AND   P1.PRD_STATUS       =0
                AND   P1.PRD_LVL_PARENT   =P2.PRD_LVL_CHILD
                AND   P2.PRD_STATUS       =0   
                AND   P2.PRD_LVL_PARENT   =P3.PRD_LVL_CHILD
                AND   P3.PRD_STATUS       =0
                AND   P3.PRD_LVL_PARENT   =P4.PRD_LVL_CHILD
                AND   P4.PRD_STATUS       =0
                AND   P4.PRD_LVL_PARENT   =P5.PRD_LVL_CHILD
                AND   P5.PRD_STATUS       =0
                AND   P5.PRD_LVL_NUMBER  = '" . $division . "' 
                ORDER BY MSTPACK DESC)
                    ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    // Obtiene Marca
    public static function obtiene_marca($temporada, $depto,$division, $departamento,$tipo)
    {

        if($tipo == 1) {
            // C1
            $sql = "SELECT 
                    trim(COD_MARCA), 
                    trim(NOM_MARCA) 
                    FROM PLC_DEPTO_MARCA
                    WHERE  LTRIM(RTRIM(COD_DEPT)) = LTRIM(RTRIM('".$departamento."'))
                    ORDER BY COD_DEPT DESC
                ";
        }else {
            // PMM
            $sql = "SELECT REPLACE(REPLACE(REPLACE(ATR_CODE,CHR(9),''),CHR(10),''),CHR(13),'')ATR_CODE, 
                    convert(REPLACE(REPLACE(REPLACE(ATR_CODE_DESC,CHR(9),''),CHR(10),''),CHR(13),''),'utf8','us7ascii') ATR_CODE_DESC
                    FROM BASACDEE
                    WHERE ATR_HDR_TECH_KEY IN (204,205)
                    ORDER BY ATR_CODE ASC
                    ";
        }

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Agregar Marca
    public static function agrega_marca($temporada, $sdepto, $division, $nom_div, $depto, $nom_depto, $marca, $nom_marca, $login)
    {

                $sql = "begin PLC_PKG_PRUEBA.PRC_INSERT_PLC_DEPTO_MARCA('".$division."','".$nom_div."','".$depto."','".$nom_depto."','".$marca."','".$nom_marca."', :error, :data); end;";

                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                if (!file_exists('../archivos/log_querys/'.$login)) {
                    mkdir('../archivos/log_querys/'.$login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql;
                $fp = fopen("../archivos/log_querys/".$login."/DEPTOMARCA-AGREGAR--".$login."-".$stamp." R".$rand.".txt","wb");
                fwrite($fp,$content);
                fclose($fp);

                // Funciona pero no retorna nada para el alert de ok
                /*$data = \database::getInstancia()->getConsultaSP($sql, 2);
                return $data;*/

                if(\database::getInstancia()->getConsultaSP($sql, 2)){
                    return 1;
                }



    }

    // Quitar Marca
    public static function quitar_marca($temporada, $sdepto, $division, $depto, $marca,$login)
    {


            $sql = "begin PLC_PKG_PRUEBA.PRC_ELIMINA_MARCA('".$division."','".$depto."','".$marca."', :error, :data); end;";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/'.$login)) {
                mkdir('../archivos/log_querys/'.$login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql;
            $fp = fopen("../archivos/log_querys/".$login."/DEPTOMARCA-QUITAR--".$login."-".$stamp." R".$rand.".txt","wb");
            fwrite($fp,$content);
            fclose($fp);

            // Funciona pero no retorna nada para el alert de ok
            /*$data = \database::getInstancia()->getConsultaSP($sql, 2);
            return $data;*/

            if(\database::getInstancia()->getConsultaSP($sql, 2)){
                return 1;
            }


    }





// Fin de la clase
}
