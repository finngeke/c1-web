<?php

/**
 * CLASS Perfil
 * Descripción: Obtiene perfil de la tabla PLC_TIPO_USUARIO
 * Fecha: 2018-02-07
 * @author RODRIGO RIOSECO
 */

namespace usuario;

use database;

class perfil {



    private $TIPO_USR;    
     /**
     * Constructor de clase
     * @param1 varchar $TIPO_USR codigo perfil
     */
    public function __construct($tipo_usr) {
        $this->TIPO_USR = $tipo_usr;
    }
    
   
    public function getDescripcion() {
        
         $data = (object) database::getInstancia()->getFila("select TIPO_USR from PLC_TIPO_USUARIO"
                        . " where COD_TIPUSR = " . $this->TIPO_USR);
         return $data;
     
    }
    
     /**
     * Crear Perfil
     * @return array
     */
    public static function crearPerfil($LOGIN,$PERFIL) {
        /*
         *    COD_TIPUSR TIPO_USR USR_CRE FEC_CRE USR_MOD FEC_MOD
         */
        $sql = "insert into PLC_TIPO_USUARIO values ( (select (max(A.COD_TIPUSR) + 1) AS ID from PLC_TIPO_USUARIO A)"
                . ",UPPER('" . $PERFIL . "')"
                . ",'".$LOGIN."'"
                . ",current_date"
                . ",NULL"
                . ",NULL)";   
        return database::getInstancia()->getConsulta($sql);
    }
    
    /**
     * Elimina Perfil
     * @return array
     */
    public static function eliminaPerfil($LOGIN,$PERFIL) {
        /*
         *    COD_TIPUSR TIPO_USR USR_CRE FEC_CRE USR_MOD FEC_MOD
         */
        $sql = "delete from PLC_TIPO_USUARIO where COD_TIPUSR=".$PERFIL;
        return database::getInstancia()->getConsulta($sql);
    }
    
}
