<?php
/*
 * CONTROLADOR de AJAX
 * Descripción: Permite consultar y posteriormente listar, información asociada a tiendas disponibles y asignadas 
 * Fecha: 23-03-2018
 * @author ROBERTO PÉREZ
 */

namespace mantenedores;

class ControlPptoRetail extends \Control {

    // Llenar
    public function busca_ppto($f3) {

        $depto = "";

        /*if($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            $depto = $_GET['DEPTO'];
        }*/

        if($_GET['DEPTO']){
            $depto = $_GET['DEPTO'];
        }elseif($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            echo "No se puedo recuperar variable presupuesto.";
            die();
        }

        echo json_encode(\simulador_compra\tipo_ppto_retail::buscarPptoRetail($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('SESSION.login')));
    }


    // Guardar
    public function agrega_ppto_retail($f3) {

        $depto = "";

        /*if($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            $depto = $_GET['DEPTO'];
        }*/

        if($_GET['DEPTO']){
            $depto = $_GET['DEPTO'];
        }elseif($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            echo "No se puedo recuperar variable presupuesto.";
            die();
        }

        echo \simulador_compra\tipo_ppto_retail::almacenaPptoRetail($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.PRESUPUESTO'),$f3->get('GET.USER'),$f3->get('SESSION.login'));
    }


    // Eliminar Registros existentea
    public function eliminar_ppto_retail($f3) {

        $depto = "";

        /*if($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            $depto = $_GET['DEPTO'];
        }*/


        if($_GET['DEPTO']){
            $depto = $_GET['DEPTO'];
        }elseif($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            echo "No se puedo recuperar variable presupuesto.";
            die();
        }

        echo \simulador_compra\tipo_ppto_retail::eliminarPptoRetail($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.USER'),$f3->get('SESSION.login'));
    }



}
