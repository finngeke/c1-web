<?php
/*
 * CONTROLADOR de AJAX
 * Descripción: Permite consultar y posteriormente listar, información asociada a tiendas disponibles y asignadas 
 * Fecha: 23-03-2018
 * @author ROBERTO PÉREZ
 */

namespace mantenedores;

class ControlTipoTienda extends \Control {

    // Llenar ListBox de Disponible
    public function obtiene_disponible($f3) {

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

        echo json_encode(\simulador_compra\tipo_de_tienda::getDisponibles($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.MARCA'),$f3->get('GET.TIENDA')));
        die();
        
        // Revisar que traen valor distinto de NULL
        /*if ($f3->get('GET.MARCA') !== 'NULL' && $f3->get('GET.TIENDA') !== 'NULL') {
           echo json_encode(\simulador_compra\tipo_de_tienda::getDisponibles($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.MARCA'),$f3->get('GET.TIENDA')));
        }*/
        
    }
    
    // Llenar ListBox de Asignado
    public function obtiene_asignado($f3) {

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

            echo json_encode(\simulador_compra\tipo_de_tienda::getAsignados($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.MARCA'),$f3->get('GET.TIENDA')));

    }

    // Buscar si el registro de internet se encuentra dentro de los registros
    public function busca_existe_internet($f3) {

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

        echo json_encode(\simulador_compra\tipo_de_tienda::busca_existe_internet($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.MARCA'),$f3->get('GET.TIENDA')));
    }
    
     // Quitar las tiendas asignadas previamente
    public function quitar_tienda($f3) {

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

       echo \simulador_compra\tipo_de_tienda::quitarTiendas($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.MARCA'),$f3->get('GET.TIENDA'),$f3->get('GET.ASIGNADO'),$f3->get('SESSION.login'));
    }

    // Quitar las tiendas asignadas previamente
    public function quitar_todas_tienda($f3) {

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

        echo \simulador_compra\tipo_de_tienda::quitar_todas_tienda($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.MARCA'),$f3->get('GET.TIENDA'),$f3->get('SESSION.login'),$f3->get('GET.STRING_ASIGNADOS'));
    }

    // Guardar las tiendas seleccionadas 
    public function agrega_tienda($f3) {

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

       echo \simulador_compra\tipo_de_tienda::almacenaTiendas($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.MARCA'),$f3->get('GET.TIENDA'),$f3->get('GET.ASIGNADO'),$f3->get('SESSION.login'));
    }

    // Botón replicar
    public function replicar_tienda($f3) {

        $depto = "";

        if($_GET['DEPTO']){
            $depto = $_GET['DEPTO'];
        }elseif($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            echo "No se puedo recuperar variable presupuesto.";
            die();
        }

        echo json_encode(\simulador_compra\tipo_de_tienda::replicarTiendas($f3->get('SESSION.COD_TEMPORADA'),$depto,$f3->get('GET.MARCA')));

    }

    // PRC_TEMP_CONFIGTIENDAS (Para llenar el CBX de temporadas)
    public function llenar_carga_temporada($f3) {

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

        echo json_encode(\simulador_compra\tipo_de_tienda::llenarCargaTemporadaTiendas($f3->get('GET.TEMP_REPLICADA'),$depto));
    }

    // Listar Carga Temporada
    public function listar_carga_temporada($f3) {

        $depto = "";

        if($_GET['DEPTO']){
            $depto = $_GET['DEPTO'];
        }elseif($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            echo "No se puedo recuperar variable presupuesto.";
            die();
        }

        echo json_encode(\simulador_compra\tipo_de_tienda::listarCargaTemporadaTiendas($f3->get('GET.TEMP_REPLICADA'),$depto,$f3->get('SESSION.login')));
    }

    // Quitar Carga Temporada
    public function quitar_carga_temporada($f3) {

        $depto = "";

        if($_GET['DEPTO']){
            $depto = $_GET['DEPTO'];
        }elseif($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            echo "No se puedo recuperar variable presupuesto.";
            die();
        }

        // TEMPORADA:    Temporada que selecciona en popup de replicar.
        // DEPARTAMENTO: Departamento en el que me encuentro.
        // DEPTO:        Depto desde el popup de departamento.
        // MARCA:        Marca del CBX de marca.

        echo \simulador_compra\tipo_de_tienda::quitarCargaTemporadaTiendas($f3->get('GET.TEMPORADA'),$depto,$f3->get('SESSION.login'),$f3->get('GET.MARCA'),$f3->get('SESSION.COD_TEMPORADA'));

    }

    // Agregar Carga Temporada (REVISAR)
    public function agrega_carga_temporada($f3) {

        $depto = "";

        if($_GET['DEPTO']){
            $depto = $_GET['DEPTO'];
        }elseif($f3->get('SESSION.COD_DEPTO')){
            $depto = $f3->get('SESSION.COD_DEPTO');
        }else{
            echo "No se puedo recuperar variable presupuesto.";
            die();
        }

        //echo \simulador_compra\tipo_de_tienda::agregaCargaTemporadaTiendas($f3->get('GET.V_COD_TEMPORADA'),$f3->get('GET.V_DEP_DEPTO'),$f3->get('GET.V_COD_GRUPCOMPRA'),$f3->get('GET.V_COD_LINEA'),$f3->get('GET.V_COD_SUBLINEA'),$f3->get('GET.V_COD_RNK'),$f3->get('GET.V_COD_CICLOVIDA'),$f3->get('GET.V_COD_TIPOPRODUCTO'),$f3->get('GET.V_TALLA'),$f3->get('GET.V_A'),$f3->get('GET.V_B'),$f3->get('GET.V_C'),$f3->get('GET.V_I'),$f3->get('GET.V_COD_MARCA'),$f3->get('GET.V_ID_OP'),$f3->get('GET.V_CURVA_REPARTO'),$f3->get('SESSION.login'));

        echo \simulador_compra\tipo_de_tienda::agregaCargaTemporadaTiendas($f3->get('GET.V_COD_TEMPORADA'),$f3->get('GET.V_DEP_DEPTO'),$f3->get('GET.V_COD_GRUPCOMPRA'),$f3->get('GET.V_COD_LINEA'),$f3->get('GET.V_COD_SUBLINEA'),$f3->get('GET.V_COD_RNK'),$f3->get('GET.V_COD_CICLOVIDA'),$f3->get('GET.V_COD_TIPOPRODUCTO'),$f3->get('GET.V_TALLA'),$f3->get('GET.V_A'),$f3->get('GET.V_B'),$f3->get('GET.V_C'),$f3->get('GET.V_I'),$f3->get('GET.V_COD_MARCA'),$f3->get('GET.V_ID_OP'),$f3->get('GET.V_CURVA_REPARTO'),$f3->get('SESSION.login'));


    }








// Fin de la clase
}
