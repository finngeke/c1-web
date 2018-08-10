<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace temporada;

/**
 * Description of parametros
 *
 * @author epacheco
 */
class parametros {
    //put your code here
    
     Public static function getPaises(){
        
         $data = \database::getInstancia()->getFilas("SELECT P.CNTRY_LVL_CHILD AS COD_PAIS,
                                                      UPPER( TRIM( P.CNTRY_NAME ) ) AS NOM_PAIS
                                                    FROM   PLC_PAIS P
                                                    ORDER BY P.CNTRY_NAME");
        return $data;   
    }
    
     Public static function getVia(){
        
         $data = \database::getInstancia()->getFilas("select COD_VIA,NOM_VIA from plc_via");
        return $data;   
    }
    
    Public static function getTipoMoneda(){
        
         $data = \database::getInstancia()->getFilas("SELECT COD_TIP_MON,NOM_TIP_MON FROM PLC_TIPO_MONEDA");
        return $data;   
    }
    
}
