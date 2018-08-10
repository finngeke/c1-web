<?php

/**
 * CLASS Parametros 
 * Descripción: Validacion combobox
 * Fecha: 2018-03-14
 * @author RODRIGO RIOSECO
 */

namespace simulador_compra;

class parametros extends \parametros {

    public function obtieneColores() {
        $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_COLOR(:data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $colores = array();
        foreach ($data as $val) {
            $colores[$val[0]] = strtoupper(utf8_encode($val[1]));
        }
        return $colores;
    }

    public function obtieneLineas($depto) {
        $sql = "begin PLC_PKG_GENERAL.PRC_GET_LINEAS('" . $depto . "', 1, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $lineas = array();
        foreach ($data as $val) {
            $lineas[$val[0]] = strtoupper(utf8_encode($val[1]));
        }
        return $lineas;
    }

    public function obtieneSubLineas($depto, $linea) {
        $sql = "begin PLC_PKG_GENERAL.PRC_GET_SUBLINEAS('" . $depto . "', 1,'" . $linea . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $sublineas = array();
        foreach ($data as $val) {
            $sublineas[$val[1]] = strtoupper(utf8_encode($val[0]));
        }
        return $sublineas;
    }

    public function obtieneMarcas($depto) {
        $sql = "begin PLC_PKG_PRUEBA.PRC_LISTAR_DEPTO_MARCA('" . $depto . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $marcas = array();
        foreach ($data as $val) {
            $marcas[$val[1]] = strtoupper(utf8_encode($val[0]));
        }
        return $marcas;
    }

    public function obtieneTipoCambio($temporada, $moneda) {

        $sql = "begin PLC_PKG_MIGRACION.PRC_GET_TIPOCAMBIO2(" . $temporada . ",2, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $tipo_cambios = array();
        foreach ($data as $val) {
            $tipo_cambios[$val[0]] = strtoupper(utf8_encode($val[1]));
        }
        return $tipo_cambios;
    }

    public function obtieneVentanasEmbarque($temporada) {
        
        $sql = "begin PLC_PKG_PRUEBA.PRC_VENTA_EMBAR_COMPRA(" . $temporada . ",:data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $ventanas = array();
        foreach ($data as $val) {
            $ventanas[$val[0]] = strtoupper(utf8_encode($val[1]));
        }
        return $ventanas;       
    }

}
