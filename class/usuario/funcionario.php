<?php

/**
 * CLASS Funcionario
 * Descripción: Obtiene propiedades de los usuarios y validaciones de acceso
 * Fecha: 2018-02-13
 * @author RODRIGO RIOSECO
 */

namespace usuario;

use database;

class funcionario {

    private $usr_nom;
    /**
     * Constructor de clase
     * @param1 varchar $usr_nom Usuario de Windows
     * @param2 varchar $usr_pwd Clave (Crear metodo contra sql injection)
     */
    public function __construct($usr_nom, $usr_pwd) {
        $this->usr_nom = $usr_nom;
        $this->usr_pwd = $usr_pwd;
    }

    /**
     * Determina si el rut es de un funcionario
     * @return bool true si es funcionario
     */
    public function isFuncionario() {
        $data = database::getInstancia()->getFilas("SELECT 1 FROM PLC_USUARIO"
                . " where cod_usr=upper('" . $this->usr_nom . "') and contrasenia='" . $this->usr_pwd . "'");
        return count($data) == 1 ? true : false;
    }

    /**
     * Obtiene el nombre completo en el formato "Nombre Apellidos perfil" para el inicio del sistema
     * @return string
     */
    public function getDatosFuncionario() {

        $data = (object) database::getInstancia()->getFila("select COD_USR,NOM_USR,USR_CRE,FEC_MOD,CORREO,COD_PAIS,ESTADO,COD_TIPUSR from PLC_USUARIO"
                        . " where cod_usr=upper('" . $this->usr_nom . "') and contrasenia='" . $this->usr_pwd . "'");
        return $data;
    }

    /**
     * Obtiene todos los registros de los usuarios
     * @return array
     */
    public static function getListaFuncionarios() {

        $sql = "SELECT USR.cod_usr,USR.nom_usr, USR.CONTRASENIA CONTRASENIA,USR.cod_tipusr,NVL(TIPO.TIPO_USR,'Sin Perfil') AS TIPO_USR"
                . " ,USR.fec_cre,(CASE WHEN USR.estado = 1 THEN 'ACTIVO' ELSE 'INACTIVO' END) as estado,"
                . " (CASE WHEN USR.cod_pais = 2 THEN 'CHILE' ELSE 'OTRO' END) as pais,"
                . " USR.correo FROM PLC_USUARIO USR LEFT JOIN PLC_TIPO_USUARIO TIPO"
                . " ON USR.cod_tipusr=TIPO.cod_tipusr order by USR.nom_usr";
        return database::getInstancia()->getFilas($sql);
    }

    /**
     * Valida si existe usario antes de Crearlo
     * @return array
     */
    public static function existeFuncionario($COD_USR) {

        $sql = "SELECT 1 FROM PLC_USUARIO WHERE COD_USR=UPPER('" . $COD_USR . "')";
        return database::getInstancia()->getFila($sql);
    }

    /**
     * Crear Usuario
     * @return array
     */
    public static function crearFuncionario($LOGIN,$COD_USR, $NOM_USR, $CONTRASENIA, $COD_PAIS, $CORREO, $COD_TIPUSR, $ESTADO) {
        /*
         *      $COD_USR $NOM_USR $CONTRASENIA $COD_TIPUSR $USR_CRE $FEC_CRE $USR_MOD $FEC_MOD $ESTADO $COD_PAIS $CORREO
         */
        $sql = "insert into PLC_USUARIO values (upper('" . $COD_USR . "')"
                . ",UPPER('" . $NOM_USR . "')"
                . ",'" . $CONTRASENIA . "'"
                . "," . $COD_TIPUSR . ""
                . ",'".$LOGIN."'"
                . ",current_date"
                . ",'".$LOGIN."'"
                . ",current_date"
                . "," . $ESTADO . ""
                . ",2"
                . ",'" . $CORREO . "')";        
        return database::getInstancia()->getConsulta($sql);
    }
    
     /**
     * Modificar Usuario
     * @return array
     */
    public static function modificarFuncionario($LOGIN,$COD_USR, $NOM_USR, $CONTRASENIA, $COD_PAIS, $CORREO, $COD_TIPUSR, $ESTADO) {
        /*
         *      $COD_USR $NOM_USR $CONTRASENIA $COD_TIPUSR $USR_CRE $FEC_CRE $USR_MOD $FEC_MOD $ESTADO $COD_PAIS $CORREO
         */
        $sql = "update PLC_USUARIO set COD_USR=upper('" . $COD_USR . "')"
                . " , NOM_USR=UPPER('" . $NOM_USR . "')"
                . " , CONTRASENIA='" . $CONTRASENIA . "'"
                . " , COD_TIPUSR=" . $COD_TIPUSR . ""
                . " , USR_CRE='".$LOGIN."'"
                . " , FEC_CRE = current_date"
                . " , USR_MOD='".$LOGIN."'"
                . " , FEC_MOD=current_date"
                . " , ESTADO=" . $ESTADO . ""
                . " , COD_PAIS=2"
                . " , CORREO='" . $CORREO . "' where COD_USR=upper('" . $COD_USR . "')";       
        return database::getInstancia()->getConsulta($sql);
    }
    
      /**
     * Elimina Usuario
     * @return array
     */
    public static function eliminaFuncionario($LOGIN,$COD_USR) {
        /*
         *    COD_TIPUSR TIPO_USR USR_CRE FEC_CRE USR_MOD FEC_MOD
         */
        $sql = "delete from PLC_USUARIO where COD_USR='".$COD_USR."'";   
        return database::getInstancia()->getConsulta($sql);
    }

    public function __get($name) {
        return $this->_own[$name];
    }

}
