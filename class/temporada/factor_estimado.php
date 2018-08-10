<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace temporada;

/**
 * Description of factor_estimado
 *
 * @author epacheco
 */
class factor_estimado {

    //put your code here
    //Factor Estiamdo
    public static function getFactor_Estimado($cod_temp) {

        $sql="SELECT  F.DEP_DEPTO
                                                             ,G.DEP_DESCRIPCION
                                                             ,F.CNTRY_LVL_CHILD AS COD_PAIS
                                                             ,P.CNTRY_NAME      AS NOM_PAIS
                                                             ,F.COD_VIA
                                                             ,V.NOM_VIA
                                                             ,F.COD_TIP_MON     AS COD_MONEDA
                                                             ,M.NOM_TIP_MON     AS NOM_MONEDA
                                                             ,ROUND( F.FACTOR_DOL, 2 ) AS FACTOR_DOL 
                                                             ,F.A,F.B,F.C,F.D
                                                             ,F.E,F.F,F.G,F.H,F.I           
                                                      FROM PLC_FACTOR_EST       F 
                                                      LEFT JOIN GST_MAEDEPTOS   G ON F.DEP_DEPTO = G.DEP_DEPTO
                                                      LEFT JOIN PLC_PAIS        P ON F.CNTRY_LVL_CHILD = P.CNTRY_LVL_CHILD
                                                      LEFT JOIN PLC_VIA         V ON F.COD_VIA = V.COD_VIA
                                                      LEFT JOIN PLC_TIPO_MONEDA M ON F.COD_TIP_MON = M.COD_TIP_MON
                                                      WHERE  F.COD_TEMPORADA = " . $cod_temp
                . " ORDER BY G.DEP_DESCRIPCION
                                                               ,P.CNTRY_NAME
                                                               ,V.NOM_VIA
                                                               ,M.NOM_TIP_MON
                                                               ,F.FACTOR_DOL ASC";
      
        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }
    public static function updateFactorEstimadoV($cod_mon, $factor, $cod_via, $cod_pais, $depto, $login, $temporada, $a, $b, $c, $d, $e, $f, $g, $h, $i) {


        $sql = " UPDATE PLC_FACTOR_EST 
                         SET   USR_MOD = '" . $login . "',
                           FEC_MOD     = current_date,
                            A          = " . $a . ",
                            B          = " . $b . ",
                            C          = " . $c . ",
                            D          = " . $d . ",
                            E          = " . $e . ",
                            F          = " . $f . ",
                            G          = " . $g . ",
                            H          = " . $h . ",
                            I          = " . $i . "
                        WHERE  COD_TEMPORADA = " . $temporada
                . " AND  DEP_DEPTO   = '" . $depto . "'"
                . " AND  CNTRY_LVL_CHILD = " . $cod_pais
                . " AND  COD_VIA = " . $cod_via
                . " AND  FACTOR_DOL = " . $factor;

        \database::getInstancia()->getConsulta($sql);
    }
    public static function existe_Factor($temporada, $depto, $pais, $via, $tipo_moneda) {

        $sql = "SELECT COUNT(1)FROM PLC_FACTOR_EST  
             WHERE COD_TEMPORADA = " . $temporada
                . " AND   DEP_DEPTO = '" . $depto . "'"
                . " AND   CNTRY_LVL_CHILD = " . $pais
                . " AND   COD_VIA = " . $via
                . " AND   COD_TIP_MON = " . $tipo_moneda;


        $data = \database::getInstancia()->getFila($sql);
        $_val = 0;

        if ($data[0] > 0) {
            $_val = 1;
        }
        return $_val;
    }
    public static function guardaFactorEstimado($tipo, $cod_mon, $factor, $cod_via, $cod_pais, $depto, $login, $temporada, $a, $b, $c, $d, $e, $f, $g, $h, $i, $rowsmodi) {
        
        
        if ($tipo == 1) {

            $sql = "    INSERT INTO PLC_FACTOR_EST( COD_TEMPORADA	
                                                    ,DEP_DEPTO	
                                                    ,CNTRY_LVL_CHILD	
                                                    ,COD_VIA	
                                                    ,FACTOR_DOL	
                                                    ,USR_CRE	
                                                    ,FEC_CRE	
                                                    ,USR_MOD	
                                                    ,FEC_MOD	
                                                    ,COD_TIP_MON	
                                                    ,A,B,C,D,E	
                                                    ,F,G,H,I)
                                            VALUES( " . $temporada . ",
                                                    '" . $depto . "',
                                                    " . $cod_pais . ",
                                                    " . $cod_via . ",
                                                    " . $factor . ",
                                                    '" . $login . "',   
                                                    current_date,
                                                    '" . $login . "',
                                                    current_date,
                                                    " . $cod_mon . ",
                                                    " . $a . ",
                                                    " . $b . ",
                                                    " . $c . ",
                                                    " . $d . ",
                                                    " . $e . ",
                                                    " . $f . ",
                                                    " . $g . ",
                                                    " . $h . ",
                                                    " . $i . ")";

            \database::getInstancia()->getConsulta($sql);
        } else {


            $rowupdate = explode("$", $rowsmodi);
            $sql = "update plc_factor_est
                     set dep_depto =  '" . $depto . "'
                         ,CNTRY_LVL_CHILD = " . $cod_pais . "
                         ,COD_VIA =  " . $cod_via . "
                         ,FACTOR_DOL = " . $factor . "
                         ,COD_TIP_MON  = " . $cod_mon . "
                         ,A = " . $a . "
                         ,B = " . $b . "
                         ,C = " . $c . "
                         ,D = " . $d . "
                         ,E = " . $e . "
                         ,F = " . $f . "
                         ,G = " . $g . "
                         ,H = " . $h . "
                         ,I = " . $i . "
                   WHERE  COD_TEMPORADA = " . $temporada . "
                      AND DEP_DEPTO = '" . $rowupdate[0] . "'
                      AND CNTRY_LVL_CHILD = " . $rowupdate[1] . "
                      AND COD_VIA = " . $rowupdate[2] . "
                      AND COD_TIP_MON =" . $rowupdate[3] . "";


            \database::getInstancia()->getConsulta($sql);
            // D103$16$1$2$1.2
        }
    }
    public static function delete_Factor($temporada, $depto, $pais, $via, $tipo_moneda) {

        $sql = "DELETE plc_factor_est
                WHERE COD_TEMPORADA = " . $temporada
            . " AND   DEP_DEPTO = '" . $depto . "'"
            . " AND   CNTRY_LVL_CHILD = " . $pais
            . " AND   COD_VIA = " . $via
            . " AND   COD_TIP_MON = " . $tipo_moneda;
        
         \database::getInstancia()->getConsulta($sql);
    }
    public static function delete_Factor_all($temporada){
        
       $sql = "DELETE plc_factor_est
                WHERE COD_TEMPORADA = " . $temporada;
        
         \database::getInstancia()->getConsulta($sql);  
    }

   //Tipo de Cambio 
    public static function getTipo_Cambio($cod_temp) {

        $data = \database::getInstancia()->getFilas("SELECT A.COD_TIP_MON
                                                            ,A.NOM_TIP_MON
                                                            ,NVL((B.A),0)A
                                                            ,NVL((B.B),0)B
                                                            ,NVL((B.C),0)C
                                                            ,NVL((B.D),0)D
                                                            ,NVL((B.E),0)E
                                                            ,NVL((B.F),0)F
                                                            ,NVL((B.G),0)G
                                                            ,NVL((B.H),0)H
                                                            ,NVL((B.I),0)I
                                                     FROM PLC_TIPO_MONEDA A
                                                     LEFT JOIN(SELECT B.TIPO_CAMBIO
                                                                      ,B.A,B.B,B.C,B.D,B.E,B.F,B.G,B.H,B.I
                                                                      ,COD_TIP_MON
                                                                 FROM PLC_TIPO_CAMBIO B
                                                                 WHERE COD_TEMPORADA=" . $cod_temp . ")B
                                                       ON B.COD_TIP_MON=A.COD_TIP_MON
                                                       WHERE a.cod_tip_mon>1");
        return $data;
    }
    public static function existeTipoCambio($temporada, $tipo_moneda) {

        $sql = "select * from PLC_TIPO_CAMBIO where cod_temporada = " . $temporada
                . " and cod_tip_mon = " . $tipo_moneda;

        return \database::getInstancia()->getFila($sql);
    }
    public static function guardaTipoCambio($login, $temporada, $tipo_moneda, $a, $b, $c, $d, $e, $f, $g, $h, $i, $valida) {

        if ($valida > 0) { // update
            $sql = " UPDATE PLC_TIPO_CAMBIO 
                    SET   USR_MOD       =  '" . $login . "',
                 FEC_MOD       = current_date,
                    A          = " . $a . ",
                    B          = " . $b . ",
                    C          = " . $c . ",
                    D          = " . $d . ",
                    E          = " . $e . ",
                    F          = " . $f . ",
                    G          = " . $g . ",
                    H          = " . $h . ",
                    I          = " . $i . "
          WHERE  COD_TEMPORADA = " . $temporada
                    . " AND    COD_TIP_MON   = " . $tipo_moneda;


            \database::getInstancia()->getConsulta($sql);

        } else { // INSERT
            $sql = "    INSERT INTO PLC_TIPO_CAMBIO( COD_TEMPORADA,
                                   TIPO_CAMBIO,
                                   USR_CRE,
                                   FEC_CRE ,
                                   COD_TIP_MON,
                                   A,B,C,D,E,F,G,H,I)
                           VALUES( " . $temporada . ",
                                   0,
                                   '" . $login . "',
                                   current_date,
                                   " . $tipo_moneda . ",
                                   " . $a . ",
                                   " . $b . ",
                                   " . $c . ",
                                   " . $d . ",
                                   " . $e . ",
                                   " . $f . ",
                                   " . $g . ",
                                   " . $h . ",
                                   " . $i . ")";
            \database::getInstancia()->getConsulta($sql);
        }
    }


    // Conteo Tipo Cambio
    public static function conteo_factor_estimado($temporada,$depto, $login){

        $sql = "SELECT COUNT(*)TOTAL 
                FROM PLC_FACTOR_EST
                WHERE cod_temporada = $temporada
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Conteo Tipo Cambio
    public static function conteo_tipo_cambio($temporada,$depto, $login){

        $sql = "SELECT COUNT(*)TOTAL 
                FROM PLC_TIPO_CAMBIO
                WHERE COD_TEMPORADA = $temporada
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }




// Fin de la Clase
}
