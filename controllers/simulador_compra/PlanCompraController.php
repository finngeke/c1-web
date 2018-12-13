<?php

/**
 * CONTROLADOR PLAN DE COMPRA
 * Fecha: 22-11-2018
 * @author ROBERTO PÈREZ
 */

namespace simulador_compra;

class PlanCompraController extends \Control
{

    // Lista el Plan de Compra, según temporada seleccionada
    public function ListarPlanCompra($f3)
    {

        echo json_encode(\simulador_compra\PlanCompraClass::ListarPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL')));

        // Original
        // echo json_encode(\simulador_compra\PlanCompraClass::ListarPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));

    }


    // Actualiza Plan de Compra
    public function ProcesaDataPlanCompra($f3)
    {

        /*echo "<pre>";
        var_dump($_REQUEST);
        echo "</pre>";
        die();*/

        $tempData = html_entity_decode($_REQUEST['models']);
        $json = json_decode($tempData, true);



        // Recorrer el JSON
        // foreach ($json['updated'] as $columna) {
        foreach ($json as $columna) {

            $ID_COLOR3 = $columna["ID_COLOR3"];
            $ESTADO_C1 = $columna["ESTADO_C1"];
            $PROFORMA = trim($columna["PROFORMA"]);
            $ARCHIVO = trim($columna["ARCHIVO"]);
            $PROFORMA_BASE = trim($columna["PROFORMA_BASE"]);
            $ARCHIVO_BASE = trim($columna["ARCHIVO_BASE"]);
            $ALIAS_PROV = trim($columna["ALIAS_PROV"]);
            $NOM_VENTANA = trim(strtoupper($columna["NOM_VENTANA"])); // Pasamos a mayúscula la ventana que llega
            $DESTALLA = trim($columna["DESTALLA"]);
            $TIPO_EMPAQUE = $columna["TIPO_EMPAQUE"];
            $PORTALLA_1_INI = trim($columna["PORTALLA_1_INI"]);
            $CURVATALLA = trim($columna["CURVATALLA"]);
            $UNID_OPCION_INICIO = $columna["UNID_OPCION_INICIO"];
            $CAN = $columna["CAN"];
            $SEG_ASIG = str_replace(" ", "+", trim($columna["SEG_ASIG"]));
            $FORMATO = $columna["FORMATO"];
            $A = $columna["A"];
            $B = $columna["B"];
            $C = $columna["C"];
            $I = $columna["I"];
            $NOM_VIA = trim($columna["NOM_VIA"]);
            $NOM_PAIS = trim($columna["NOM_PAIS"]);
            $PRECIO_BLANCO = $columna["PRECIO_BLANCO"];
            $COSTO_TARGET = $columna["COSTO_TARGET"];
            $COSTO_FOB = $columna["COSTO_FOB"];
            $COSTO_INSP = $columna["COSTO_INSP"];
            $COSTO_RFID = $columna["COSTO_RFID"];
            $DEBUT_REODER = trim(strtoupper($columna["DEBUT_REODER"]));
            $TIPO_EMPAQUE_BASE = trim(strtoupper($columna["TIPO_EMPAQUE_BASE"]));
            $UNI_INICIALES_BASE = $columna["UNI_INICIALES_BASE"];
            $PRECIO_BLANCO_BASE = $columna["PRECIO_BLANCO_BASE"];
            $COSTO_TARGET_BASE = $columna["COSTO_TARGET_BASE"];
            $COSTO_FOB_BASE = $columna["COSTO_FOB_BASE"];
            $COSTO_INSP_BASE = $columna["COSTO_INSP_BASE"];
            $COSTO_RFID_BASE = $columna["COSTO_RFID_BASE"];
            $COD_MARCA = $columna["COD_MARCA"];
            $N_CURVASXCAJAS = $columna["N_CURVASXCAJAS"];
            $COD_JER2 = $columna["COD_JER2"];
            $COD_SUBLIN = $columna["COD_SUBLIN"];
            $FORMATO_BASE = $columna["FORMATO_BASE"];


            // OTRAS VARIABLES
            /*$GRUPO_COMPRA = $columna["GRUPO_COMPRA"];
            $COD_TEMP = $columna["COD_TEMP"];
            $LINEA = $columna["LINEA"];
            $SUBLINEA = $columna["SUBLINEA"];
            $MARCA = $columna["MARCA"];
            $ESTILO = $columna["ESTILO"];
            $SHORT_NAME = $columna["SHORT_NAME"];
            $ID_CORPORATIVO = $columna["ID_CORPORATIVO"];
            $DESCMODELO = $columna["DESCMODELO"];
            $DESCRIP_INTERNET = $columna["DESCRIP_INTERNET"];
            $NOMBRE_COMPRADOR = $columna["NOMBRE_COMPRADOR"];
            $NOMBRE_DISENADOR = $columna["NOMBRE_DISENADOR"];
            $COMPOSICION = $columna["COMPOSICION"];
            $TIPO_TELA = $columna["TIPO_TELA"];
            $FORRO = $columna["FORRO"];
            $COLECCION = $columna["COLECCION"];
            $EVENTO = $columna["EVENTO"];
            $COD_ESTILO_VIDA = $columna["COD_ESTILO_VIDA"];
            $CALIDAD = $columna["CALIDAD"];
            $COD_OCASION_USO = $columna["COD_OCASION_USO"];
            $COD_PIRAMIX = $columna["COD_PIRAMIX"];
            $COD_RANKVTA = $columna["COD_RANKVTA"];
            $LIFE_CYCLE = $columna["LIFE_CYCLE"];
            $NUM_EMB = $columna["NUM_EMB"];
            $COD_COLOR = $columna["COD_COLOR"];
            $TIPO_PRODUCTO = $columna["TIPO_PRODUCTO"];
            $TIPO_EXHIBICION = $columna["TIPO_EXHIBICION"];
            $PORTALLA_1 = $columna["PORTALLA_1"];
            $CURVAMIN = $columna["CURVAMIN"];
            $UNID_OPCION_AJUSTADA = $columna["UNID_OPCION_AJUSTADA"];
            $MTR_PACK = $columna["MTR_PACK"];
            $CANT_INNER = $columna["CANT_INNER"];
            $TDAS = $columna["TDAS"];
            $UND_ASIG_INI = $columna["UND_ASIG_INI"];
            $ROT = $columna["ROT"];
            $NOM_PRECEDENCIA = $columna["NOM_PRECEDENCIA"];
            $VIAJE = $columna["VIAJE"];
            $MKUP = $columna["MKUP"];
            $OFERTA = $columna["OFERTA"];
            $GM = $columna["GM"];
            $COD_TIP_MON = $columna["COD_TIP_MON"];
            $ROYALTY_POR = $columna["ROYALTY_POR"];
            $COSTO_UNIT = $columna["COSTO_UNIT"];
            $COSTO_UNITS = round($columna["COSTO_UNITS"], 0); //$columna["COSTO_UNITS"]
            $CST_TOTLTARGET = $columna["CST_TOTLTARGET"];
            $COSTO_TOT = $columna["COSTO_TOT"];
            $COSTO_TOTS = $columna["COSTO_TOTS"];
            $RETAIL = $columna["RETAIL"];
            $SEM_INI = $columna["SEM_INI"];
            $SEM_FIN = $columna["SEM_FIN"];
            $CICLO = $columna["CICLO"];
            $AGOT_OBJ = $columna["AGOT_OBJ"];
            $SEMLIQ = $columna["SEMLIQ"];
            $COD_PROVEEDOR = $columna["COD_PROVEEDOR"];
            $COD_TRADER = $columna["COD_TRADER"];
            $AFTER_MEETING_REMARKS = $columna["AFTER_MEETING_REMARKS"];
            $CODSKUPROVEEDOR = $columna["CODSKUPROVEEDOR"];
            $SKU = $columna["SKU"];
            $ESTILO_PMM = $columna["ESTILO_PMM"];
            $ESTADO_MATCH = $columna["ESTADO_MATCH"];
            $PO_NUMBER = $columna["PO_NUMBER"];
            $ESTADO_OC = $columna["ESTADO_OC"];
            $FECHA_ACORDADA = $columna["FECHA_ACORDADA"];
            $FECHA_EMBARQUE = $columna["FECHA_EMBARQUE"];
            $FECHA_ETA = $columna["FECHA_ETA"];
            $FECHA_RECEPCION = $columna["FECHA_RECEPCION"];
            $DIAS_ATRASO = $columna["DIAS_ATRASO"];
            $CODESTADO = $columna["CODESTADO"];
            $VENTANA_LLEGADA = $columna["VENTANA_LLEGADA"];

            */

if($ESTADO_C1!=24){
            echo json_encode(\simulador_compra\PlanCompraClass::ProcesaDataPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),
                $ID_COLOR3,$ESTADO_C1, $PROFORMA, $ARCHIVO,$PROFORMA_BASE,$ARCHIVO_BASE,$ALIAS_PROV,
                $NOM_VENTANA,$DESTALLA, $TIPO_EMPAQUE, $PORTALLA_1_INI, $CURVATALLA, $UNID_OPCION_INICIO,
                $CAN, $SEG_ASIG, $FORMATO, $A, $B, $C, $I, $NOM_VIA, $NOM_PAIS, $PRECIO_BLANCO, $COSTO_TARGET,
                $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $DEBUT_REODER, $TIPO_EMPAQUE_BASE, $UNI_INICIALES_BASE,
                $PRECIO_BLANCO_BASE, $COSTO_TARGET_BASE, $COSTO_FOB_BASE, $COSTO_INSP_BASE, $COSTO_RFID_BASE, $COD_MARCA,
                $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN, $FORMATO_BASE
            ));
}

            /*
            echo json_encode(\simulador_compra\PlanCompraClass::ProcesaDataPlanCompra(
                $f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),
                $ID_COLOR3, $GRUPO_COMPRA, $COD_TEMP, $LINEA, $SUBLINEA, $MARCA, $ESTILO, $SHORT_NAME, $ID_CORPORATIVO, $DESCMODELO, $DESCRIP_INTERNET,
                $NOMBRE_COMPRADOR, $NOMBRE_DISENADOR, $COMPOSICION, $TIPO_TELA, $FORRO, $COLECCION, $EVENTO, $COD_ESTILO_VIDA, $CALIDAD, $COD_OCASION_USO,
                $COD_PIRAMIX, $NOM_VENTANA, $COD_RANKVTA, $LIFE_CYCLE, $NUM_EMB, $COD_COLOR, $TIPO_PRODUCTO, $TIPO_EXHIBICION, $DESTALLA, $TIPO_EMPAQUE,
                $PORTALLA_1_INI, $PORTALLA_1, $CURVATALLA, $CURVAMIN, $UNID_OPCION_INICIO, $UNID_OPCION_AJUSTADA, $CAN, $MTR_PACK, $CANT_INNER, $SEG_ASIG,
                $FORMATO, $TDAS, $A, $B, $C, $I, $UND_ASIG_INI, $ROT, $NOM_PRECEDENCIA, $NOM_VIA, $NOM_PAIS, $VIAJE, $MKUP, $PRECIO_BLANCO, $OFERTA, $GM,
                $COD_TIP_MON, $COSTO_TARGET, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $ROYALTY_POR, $COSTO_UNIT, $COSTO_UNITS, $CST_TOTLTARGET, $COSTO_TOT, $COSTO_TOTS,
                $RETAIL, $DEBUT_REODER, $SEM_INI, $SEM_FIN, $CICLO, $AGOT_OBJ, $SEMLIQ, $ALIAS_PROV, $COD_PROVEEDOR, $COD_TRADER, $AFTER_MEETING_REMARKS, $CODSKUPROVEEDOR,
                $SKU, $PROFORMA, $ARCHIVO, $ESTILO_PMM, $ESTADO_MATCH, $PO_NUMBER, $ESTADO_OC, $FECHA_ACORDADA, $FECHA_EMBARQUE, $FECHA_ETA, $FECHA_RECEPCION, $DIAS_ATRASO,
                $CODESTADO, $ESTADO_C1, $VENTANA_LLEGADA, $TIPO_EMPAQUE_BASE, $UNI_INICIALES_BASE, $PRECIO_BLANCO_BASE, $COSTO_TARGET_BASE, $COSTO_FOB_BASE,
                $COSTO_INSP_BASE, $COSTO_RFID_BASE, $COD_MARCA, $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN));

            */


        // Fin del each que recorre el JSON
        }


        // Fin del actualizar grilla
    }


    // Calcula el Curvado para los campos editados en el plan de compra
    public function CalculoCurvadoPlanCompra($f3)
    {

        $dt = \simulador_compra\PlanCompraClass::CalculoCurvadoPlanCompra($_POST['_tipo_empaque']
            , $_POST['_tallas']
            , $_POST['_curvas']
            , $_POST['_und_iniciales']
            , $_POST['_cluster']
            , $_POST['_formato']
            , $_POST['_A']
            , $_POST['_B']
            , $_POST['_C']
            , $_POST['_I']
            , $_POST['_DEBUT_REODER']
            , $_POST['_PORTALLA_1_INI']
            , $f3->get('SESSION.COD_DEPTO')
            , $f3->get('SESSION.COD_TEMPORADA')
            , $_POST['_marcas']
            , $_POST['_N_CURVASXCAJAS']
            , $_POST['_cod_linea']
            , $_POST['_cod_sublinea']
            , $_POST['_id_color3']
            , 1);


        $varibles = /*0 unid ajust*/
            $dt[0] . "|" .
            /*1 porcenajust*/
            $dt[1] . "|" .
            /*2 N° CAJAS*/
            $dt[2] . "|" .
            /*3 unidfinal*/
            $dt[3] . "|" .
            /*4 primera carga*/
            $dt[4] . "|" .
            /*5 $tdas*/
            $dt[5] . "|" .
            /*6 unidadesajustXtalla*/
            $dt[6];

        echo json_encode($varibles);
    }


    // Carga POPUP de Historial en Plan de Compra
    public function ListarHistorial($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarHistorial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.ID_COLOR3')));
    }

    // Busca Factor
    public function BuscaFactor($f3)
    { // $pais,$via,$moneda,$ventana
        echo json_encode(\simulador_compra\PlanCompraClass::BuscaFactor($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.PAIS'), $f3->get('GET.VIA'), $f3->get('GET.MONEDA'), $f3->get('GET.VENTANA')));
    }

    // Busca Factor
    public function BuscaTipoCambio($f3)
    { // ,$moneda,$ventana
        echo json_encode(\simulador_compra\PlanCompraClass::BuscaTipoCambio($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.MONEDA'), $f3->get('GET.VENTANA')));
    }


    public function GuardaArhcivoPI($f3)
    {

        // Obtener el nombre del temporal del archivo
        $file = $_FILES;

        // Llega el nombre de la PI por POST
        $json = $_POST;
        $archivo_proforma = $json["NombreArchivoProforma"];
        $nombre_archivo = "PI_" . $f3->get('SESSION.COD_TEMPORADA') . "_" . $f3->get('SESSION.COD_DEPTO') . "_" . $archivo_proforma . ".xlsx";

        // Ruta
        $dir_subida = $f3->get('UPLOADS_PI');
        $fichero_subido = $dir_subida . basename($nombre_archivo);

        // Si el archivo se subió correctamente, realizo las actualizaciones de los estados
        if (move_uploaded_file($file['JSONGuardaArhcivoPI']["tmp_name"], $fichero_subido)) {
            echo "";
        } else {
            echo "ERROR";
        }


    }

    // ######################## TRABAJO CON CONCURRENCIA ############################
    // ############ Actualiza la fecha del registro de concurrencia #################
    public function actualiza_fecha_concurrencia($f3){
        echo \simulador_compra\PlanCompraClass::actualiza_fecha_concurrencia($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'));
    }
    // ######################## FIN TRABAJO CON CONCURRENCIA ########################


    // Listar País
    public function ListarPais($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarPais($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }


    // Listar Formatos Grilla Editar
    public function ListarFormato($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarFormato($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }


    // Listar Ventana Grilla Editar
    public function ListarVentana($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarVentana($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }

    // Match - Consulta OC Linekada
    public function ConsultaOCLinkeada($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::ConsultaOCLinkeada($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC')));
    }

    // Match - Listar PMM
    public function MatchLlenarGridPMM($f3) {

        $array_data = $_GET;

        /*echo $array_data["OC"];
        echo "<br>";
        echo $array_data["PROFORMA"];*/

        echo json_encode(\simulador_compra\PlanCompraClass::MatchLlenarGridPMM($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["OC"], $array_data["PROFORMA"], $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL')));

    }

    // Match - Listar PLAN
    public function MatchLlenarGridPlan($f3) {

        $array_data = $_GET;

        echo json_encode(\simulador_compra\PlanCompraClass::MatchLlenarGridPlan($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["OC"], $array_data["PROFORMA"], $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL') ));
    }

    // Match - Listar CBX Línea en Match
    public function ListarLineaCBXMatch($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarLineaCBXMatch($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }

    // Match - Listar CBX SubLínea en Match
    public function ListarSubLineaCBXMatch($f3) {

        $array_data = $_GET;
        echo json_encode(\simulador_compra\PlanCompraClass::ListarSubLineaCBXMatch($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $array_data["LINEA"]));

    }

    // Match - Listar CBX Color enMatch
    public function ListarColorCBXMatch($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarColorCBXMatch($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    // Match - Actualiza Plan de Compra
    public function ActualizaPlanMATCH($f3)
    {

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::ActualizaPlanMATCH($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["ID"], $array_data["LINEA"], $array_data["SUB_LINEA"], $array_data["ESTILO"], $array_data["COLOR"]);

    // Fin del ActualizaPlanMATCH
    }

    // Match - Generar Match
    public function GenerarMatch($f3) {

        $array_data = $_GET;
        echo \simulador_compra\PlanCompraClass::GenerarMatch($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["OC"], $array_data["PROFORMA"]);

    }

    // Match - Agrega Variaciones
    public function GenerarMatchVariaciones($f3) {

        $array_data = $_GET;
        echo \simulador_compra\PlanCompraClass::GenerarMatchVariaciones($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["OC"], $array_data["PROFORMA"]);

    }



    // ######################## INICIO Trabajo con flujo de aprobación ########################

    public function ModificaEstadoDinamico($f3) {

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::ModificaEstadoDinamico($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["ID_COLOR3"], $array_data["ESTADO_INSERT"], $array_data["PROFORMA"], $array_data["ESTADO_UPDATE"]);

    }

    public function ModificaEstadoDinamicoCorreccion($f3) {

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::ModificaEstadoDinamicoCorreccion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["ID_COLOR3"], $array_data["ESTADO_INSERT"], $array_data["PROFORMA"], $array_data["ESTADO_UPDATE"], $array_data["COMENTARIO"]);

    }

    // ######################## FIN Trabajo con flujo de aprobación ########################




    // ######################## INICIO Permisos de Usuario ########################

    // Listar Permisos de Usuario
    public function ListarPermisosUsuario($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarPermisosUsuario($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('SESSION.cod_tipusr')));
    }

    // Revisar Concurrencia
    public function RevisaConcurrencia($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::RevisaConcurrencia($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('SESSION.cod_tipusr')));
    }

    // ######################## FIN Permisos de Usuario ########################


// Termina Clase
}