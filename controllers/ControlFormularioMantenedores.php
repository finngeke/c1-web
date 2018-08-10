<?php

/**
 * CONTROLADOR de FORMULARIOS
 * Descripción: 
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 * @Edición Roberto Pérez (22-03-2018)
 */
class ControlFormularioMantenedores extends Control {

    public static function tipo_tienda($f3) {
        
       // CBX Listar Marcas por departamento
        $marcas = \simulador_compra\tipo_de_tienda::getMarcas($f3->get('SESSION.COD_DEPTO'));
        foreach($marcas as $val)
        {
           $marca[]= array($val[0] => 'CODIGO', $val[1] => 'DESCRIPCION');
        }
        $select = new html\select($marcas, 0, 1);
        $f3->set('lis_marca', $select);


        // CBX Listar Tipo Tiendas (Ventanas)
        $ventanas = \simulador_compra\tipo_de_tienda::getVentanas($f3->get('SESSION.COD_DEPTO'),$f3->get('SESSION.COD_TEMPORADA'));
        foreach($ventanas as $val)
        {
            $ventanas[]= array($val[0] => 'CODIGO', $val[1] => 'DESCRIPCION');
        }
        $select = new html\select($ventanas, 0, 1);
        $f3->set('lis_ventanas', $select);


        $f3->set('depto', $f3->get('SESSION.COD_DEPTO'));
        $f3->set('temporada', $f3->get('SESSION.COD_TEMPORADA'));
        
        $f3->set('tipo_tienda', 'formulario/plan_compra/mantenedor/popup_tipo_tienda.html');
        
    }



    // CBX Listar Marcas por departamento
    public function cbxMarca($f3) {

        $depto = "";

        if($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            $depto = $_GET['DEPTO'];
        }

        echo json_encode(\simulador_compra\tipo_de_tienda::getMarcas($depto));
    }

    // CBX Listar Tipo Tiendas (Ventanas)
    public function cbxVentana($f3) {

        $depto = "";

        if($f3->get('SESSION.COD_DEPTO')){
           $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            $depto = $_GET['DEPTO'];
        }

        echo json_encode(\simulador_compra\tipo_de_tienda::getVentanas($depto,$f3->get('SESSION.COD_TEMPORADA')));
    }

    // CBX Listar Temporada, en Modal de Replicar
    /*public function cbxReplicaTienda($f3) {

        $depto = "";

        if($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            $depto = $_GET['DEPTO'];
        }

        echo json_encode(\simulador_compra\tipo_de_tienda::replicarTiendas($f3->get('SESSION.COD_TEMPORADA'),$depto));
    }*/




    public static function formatos($f3) {
    
        $formatos = \simulador_compra\formato::getFormatos($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'));
        
        foreach($formatos as $val)
        {
           $formato[]= array($val[0] => 'CODIGO', $val[1] => 'DESCRIPCION');
        }
        
        $select = new html\select($formatos, 0, 1);
        $f3->set('lis_formato', $select);

        $f3->set('depto', $f3->get('SESSION.COD_DEPTO'));
        $f3->set('temporada', $f3->get('SESSION.COD_TEMPORADA'));
       
        $f3->set('tipo_formato', 'formulario/plan_compra/mantenedor/popup_formato.html');
        
}

    public static function tipo_curva($f3) {

        $f3->set('depto', $f3->get('SESSION.COD_DEPTO'));
        $f3->set('temporada', $f3->get('SESSION.COD_TEMPORADA'));

        $f3->set('tipo_curva', 'formulario/plan_compra/mantenedor/popup_curva.html');

    }

    public static function tipo_ventana_llegada($f3) {

        $f3->set('depto', $f3->get('SESSION.COD_DEPTO'));
        $f3->set('temporada', $f3->get('SESSION.COD_TEMPORADA'));

        $f3->set('tipo_ventana_llegada', 'formulario/plan_compra/mantenedor/popup_ventana_llegada.html');

    }

    public static function tipo_ppto_costo($f3) {

        $f3->set('depto', $f3->get('SESSION.COD_DEPTO'));
        $f3->set('temporada', $f3->get('SESSION.COD_TEMPORADA'));

        $f3->set('tipo_ppto_costo', 'formulario/plan_compra/mantenedor/popup_ppto_costo.html');

    }

    public static function tipo_ppto_retail($f3) {

        $f3->set('depto', $f3->get('SESSION.COD_DEPTO'));
        $f3->set('temporada', $f3->get('SESSION.COD_TEMPORADA'));

        $f3->set('tipo_ppto_retail', 'formulario/plan_compra/mantenedor/popup_ppto_retail.html');

    }

    public function beforeRoute($f3) {
        if ($f3->exists('SESSION.login') == false) {
            $f3->reroute('/fin-sesion');
        }
    }


}
