<?php

/**
 * CLASS MasterPack
 * Descripción: Obtiene temporadas de la tabla PLC_MSTPACK
 * Fecha: 2018-03-14
 * @author RODRIGO RIOSECO
 */

namespace simulador_compra;

class master_pack extends \parametros {

    
    public static function obtieneListMasterPack($temporada, $depto, $linea, $sublinea) {

        $sql = "begin PLC_PKG_PRUEBA.PRC_LIST_MASTER_PACK(" . $temporada . ",'" . $depto . "','" . $linea . "','" . $sublinea . "', :error, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        
    }

   

}
