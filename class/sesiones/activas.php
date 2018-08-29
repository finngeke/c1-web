<?php

/**
 * CLASS Sesiones activas
 * Descripción: Obtiene sesiones activa de la tabla PLC_LOG_SESION
 * Fecha: 2018-02-15
 * @author RODRIGO RIOSECO
 */

namespace sesiones;

use database;

class activas {


    public static function getSesionesActivas() {
         
        /*$sql ="SELECT NUM_SESION,COD_USR,HOST,IP,FECHA_IN,MEM_OSNAME FROM PLC_LOG_SESION WHERE "
             ." FECHA_IN >= to_date('2018-02-14','yyyy-mm-dd') AND FECHA_OUT IS NULL";        
         $data = (object) database::getInstancia()->getFilas($sql);
        return $data;*/

     $sql ="SELECT
             A.COD_TEMPORADA,
             (
               SELECT T.NOM_TEMPORADA_CORTO FROM PLC_TEMPORADA T WHERE T.COD_TEMPORADA = A.COD_TEMPORADA
             ) AS DES_TEMPORADA,
             BOSACC_FUN_OBT_NOM_DPT( A.DEP_DEPTO ) AS DEPTO,
             A.DEP_DEPTO,
             A.COD_USR,
             A.USER_LOGIN,
             A.HOST,
             A.FECHA 
        FROM   PLC_CONCURRENCIA A
        ORDER BY fecha desc ";

        $data = (object) database::getInstancia()->getFilas($sql);
        return $data;

    }    
   
    
}
