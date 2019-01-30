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

        echo json_encode(\simulador_compra\PlanCompraClass::ListarPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL'),$f3->get('SESSION.NOM_TEMPORADA_CORTO')));

       // $json = \simulador_compra\PlanCompraClass::ListarPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL'),$f3->get('SESSION.NOM_TEMPORADA_CORTO'));

    /*    $key = 0;
        foreach ($json as $w3r_string) {
            json_encode($w3r_string);
            $key ++;
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    echo ' - No errors';
                    break;
                case JSON_ERROR_DEPTH:
                    echo ' - Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    echo ' - Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    echo ' - Malformed UTF-8 characters, possibly incorrectly encoded '.$key."<br>";
                    break;
                default:
                    echo ' - Unknown error';
                    break;
            }
            echo PHP_EOL;
        }

        die();*/

    }

    // Devuelve la Cantidad de Registros
    public function CantidadRegistrosPlanCompra($f3)
    {

        echo json_encode(\simulador_compra\PlanCompraClass::ListarPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL')));

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
            $TIPO_EMPAQUE = trim(strtoupper($columna["TIPO_EMPAQUE"]));
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
            $COSTO_TARGET = str_replace(",",".",$columna["COSTO_TARGET"]);
            $COSTO_FOB = str_replace(",",".",$columna["COSTO_FOB"]);
            $COSTO_INSP = str_replace(",",".",$columna["COSTO_INSP"]);
            $COSTO_RFID = str_replace(",",".",$columna["COSTO_RFID"]);
            $DEBUT_REODER = trim(strtoupper($columna["DEBUT_REODER"]));
            $COD_MARCA = $columna["COD_MARCA"];
            $N_CURVASXCAJAS = $columna["N_CURVASXCAJAS"];
            $COD_JER2 = $columna["COD_JER2"];
            $COD_SUBLIN = $columna["COD_SUBLIN"];

            if( ($columna["FECHA_ACORDADA"]!=null) && ($columna["FECHA_ACORDADA"]!="null") ){

                $fecha = date_create('1900-01-01');
                $total_dias = $columna["FECHA_ACORDADA"] -2;
                date_add($fecha, date_interval_create_from_date_string($total_dias.' days'));
                $FECHA_ACORDADA = date_format($fecha, 'd/m/Y');
                //$FECHA_ACORDADA = str_replace("-","/",trim($FECHA_ACORDADA));

            }else{
                $FECHA_ACORDADA = '';
            }

            $EVENTO = trim(strtoupper($columna["EVENTO"]));


            /*$TIPO_EMPAQUE_BASE = trim(strtoupper($columna["TIPO_EMPAQUE_BASE"]));
            $UNI_INICIALES_BASE = $columna["UNI_INICIALES_BASE"];
            $PRECIO_BLANCO_BASE = $columna["PRECIO_BLANCO_BASE"];
            $COSTO_TARGET_BASE = $columna["COSTO_TARGET_BASE"];
            $COSTO_FOB_BASE = $columna["COSTO_FOB_BASE"];
            $COSTO_INSP_BASE = $columna["COSTO_INSP_BASE"];
            $COSTO_RFID_BASE = $columna["COSTO_RFID_BASE"];
            $FORMATO_BASE = $columna["FORMATO_BASE"];*/

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
                $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $DEBUT_REODER,  $COD_MARCA,
                $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN,$FECHA_ACORDADA,$EVENTO));
}

// $TIPO_EMPAQUE_BASE, $UNI_INICIALES_BASE,$PRECIO_BLANCO_BASE, $COSTO_TARGET_BASE, $COSTO_FOB_BASE, $COSTO_INSP_BASE, $COSTO_RFID_BASE, $FORMATO_BASE


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

        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","Ñ");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","N");
        $archivo_proforma = str_replace($no_permitidas, $permitidas ,$archivo_proforma);

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
    public function ActualizaFechaConcurrencia($f3){
        echo \simulador_compra\PlanCompraClass::ActualizaFechaConcurrencia($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'));
    }
    // ######################## FIN TRABAJO CON CONCURRENCIA ########################


    // ######################## TRABAJO CON MATCH ############################
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
    // Listar Proveedores Grilla Editar
    public function ListarProveedor($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarProveedor($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }
    // Listar Eventos Grilla Editar
    public function ListarEventos($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarEventos($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
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
    // Match - Revertir Match
    public function RevertirMatch($f3) {
        $array_data = $_GET;
        echo \simulador_compra\PlanCompraClass::GenerarMatchVariaciones($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["PROFORMA"]);

    }
    // Match - Agregar OC a Tabla plc_ordenes_compra_pmm
    public function AgregaOcTablaOCPMM($f3) {
        $array_data = $_GET;
        echo json_encode(\simulador_compra\PlanCompraClass::AgregaOcTablaOCPMM( $f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["OC"], $array_data["PROFORMA"] ));
    }
    // ######################## FIN TRABAJO CON MATCH ############################


    // ######################## INICIO Trabajo con flujo de aprobación ########################
    public function ModificaEstadoDinamico($f3) {

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::ModificaEstadoDinamico($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["ID_COLOR3"], $array_data["ESTADO_INSERT"], $array_data["PROFORMA"], $array_data["ESTADO_UPDATE"]);

    }
    public function ModificaEstadoDinamicoCorreccion($f3) {

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::ModificaEstadoDinamicoCorreccion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["ID_COLOR3"], $array_data["ESTADO_INSERT"], $array_data["PROFORMA"], $array_data["ESTADO_UPDATE"], $array_data["COMENTARIO"]);

    }
    public function EliminaVariaciones($f3) {
        echo \simulador_compra\PlanCompraClass::EliminaVariaciones($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'));
    }
    // ######################## FIN Trabajo con flujo de aprobación ########################


    // ######################## INICIO Permisos de Usuario ########################
    // Listar Permisos, Presupuestos, Tiendas Registradas
    public function ListarPermisosValidaPresupuestos($f3)
    {

        if($f3->get('GET.DEPTO')){
            $depto = $f3->get('GET.DEPTO');
        }else{
            $depto = $f3->get('SESSION.COD_DEPTO');
        }

        echo json_encode(\simulador_compra\PlanCompraClass::ListarPermisosValidaPresupuestos($f3->get('SESSION.COD_TEMPORADA'), $depto, $f3->get('SESSION.login')));
    }
    // Validar Tiendas Registradas
    public function ValidarTiendasPresupuestos($f3)
    {

        if($f3->get('GET.DEPTO')){
            $depto = $f3->get('GET.DEPTO');
        }else{
            $depto = $f3->get('SESSION.COD_DEPTO');
        }

        echo json_encode(\simulador_compra\PlanCompraClass::ValidarTiendasPresupuestos($f3->get('SESSION.COD_TEMPORADA'), $depto, $f3->get('SESSION.login')));
    }
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
    // Busca Usuario Desconectado
    public function BuscaUsuarioDesconectado($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::BuscaUsuarioDesconectado($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('SESSION.cod_tipusr')));
    }
    // ######################## FIN Permisos de Usuario ########################


    // ######################## INICIO Trabajo POPUP Tiendas ########################
    // Listar Marca
    public function ListarMarca($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarMarca($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }
    // Listar Tipo Tienda
    public function ListarTipoTienda($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarTipoTienda($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }
    // Llenar ListBox de Disponible
    public function TiendaObtieneDisponible($f3) {

        $array_data = $_GET;
        echo json_encode(\simulador_compra\PlanCompraClass::TiendaObtieneDisponible($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$array_data["MARCA"],$array_data["TIENDA"]));
    }
    // Llenar ListBox de Asignado
    public function TiendaObtieneAsignado($f3) {

        $array_data = $_GET;
        echo json_encode(\simulador_compra\PlanCompraClass::TiendaObtieneAsignado($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$array_data["MARCA"],$array_data["TIENDA"]));
    }
    // Llenar ListBox de TiendaObtieneDisponibleAsignado
    public function TiendaObtieneDisponibleAsignado($f3) {
        $array_data = $_GET;
        echo json_encode(\simulador_compra\PlanCompraClass::TiendaObtieneDisponibleAsignado($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$array_data["MARCA"],$array_data["TIENDA"]));
    }
    // Actualiza Asignados
    public function TiendaActualizaAsignado($f3) {

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::TiendaActualizaAsignado($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["CODIGO"], $array_data["DESCRIPCION"], $array_data["ESTADO"], $array_data["MARCA"], $array_data["TIPO_TIENDA"]);

    }
    // Actualiza Otras Marcas
    public function TiendaActualizaAsignadoOtrasMarcas($f3) {

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::TiendaActualizaAsignadoOtrasMarcas($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["MARCA"], $array_data["TIPO_TIENDA"]);

    }
    // Llenar el CBX de las Temporadas a duplicar del popup
    public function ListarTemporadasDuplicar($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarTemporadasDuplicar($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login')));
    }
    // Duplicar Temporada
    public function TiendaDuplicarTemporada($f3) {

        // TEMPORADA:    Temporada que selecciona en popup de replicar.
        // DEPARTAMENTO: Departamento en el que me encuentro.
        // DEPTO:        Depto desde el popup de departamento.
        // MARCA:        Marca del CBX de marca.

        $array_data = $_GET;

        echo \simulador_compra\PlanCompraClass::TiendaDuplicarTemporada($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('SESSION.login'),$array_data["TEMP_SELECCIONADA"],$array_data["MARCA"]);

    }
    // ######################## FIN Trabajo POPUP Tiendas ########################



    // ######################## INICIO Trabajo POPUP Formatos ########################
    // Listar Formato
    public function MantenedorListarFormato($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::MantenedorListarFormato($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }
    // Llenar ListBox de FormatoObtieneDisponibleAsignado
    public function FormatoObtieneDisponibleAsignado($f3) {
        $array_data = $_GET;
        echo json_encode(\simulador_compra\PlanCompraClass::FormatoObtieneDisponibleAsignado($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$array_data["FORMATO"]));
    }
    // Actualiza Asignados
    public function FormatoActualizaAsignado($f3) {

        $array_data = $_GET;
        echo \simulador_compra\PlanCompraClass::FormatoActualizaAsignado($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["FORMATO"], $array_data["CODIGO"], $array_data["DESCRIPCION"], $array_data["ESTADO"]);

    }
    // Crear Nuevo Formato
    public function FormatoCrearNuevo($f3) {

        $array_data = $_GET;
        echo \simulador_compra\PlanCompraClass::FormatoCrearNuevo($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), trim($array_data["FORMATO"]));

    }
    // ######################## FIN Trabajo POPUP Formatos ########################



    // ######################## DETALLE ERROR PI ########################
    public function BuscaComentarioPI($f3) {

        $array_data = $_GET;
        echo json_encode(\simulador_compra\PlanCompraClass::BuscaComentarioPI($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $array_data["PI"], $array_data["ID_COLOR3"]));
    }
    // ######################## FIN Trabajo POPUP Formatos ########################


    // ######################## VERIFICA TIENDAS EN PLAN DE COMPRA ########################
    public function VerificaTiendaPlanCompra($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::VerificaTiendaPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPTO'),$f3->get('SESSION.login')));
    }
    public function VerificaTiendaInternet($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::VerificaTiendaInternet($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPTO'),$f3->get('SESSION.login')));
    }
    // ######################## FIN VERIFICA TIENDAS EN PLAN DE COMPRA ########################


    // Carga POPUP Ajuste de Compra en Plan de Compra
    public function Listar_Pop_Ajuste_Compra($f3)
    {

        echo json_encode(\simulador_compra\PlanCompraClass::Listar_Pop_Ajuste_Compra($f3->get('SESSION.COD_TEMPORADA')
                         , $f3->get('SESSION.COD_DEPTO')
                         , $f3->get('GET.ID_COLOR3')
                         , $f3->get('GET._Tallas')));
    }

    // Carga POPUP Ajuste por Cajas en Plan de Compra
    public function Listar_Pop_Ajuste_Cajas($f3) {

    echo json_encode(\simulador_compra\PlanCompraClass::Listar_Pop_Ajuste_Cajas($f3->get('SESSION.COD_TEMPORADA')
        , $f3->get('SESSION.COD_DEPTO')
        , $f3->get('GET.ID_COLOR3')
        , $f3->get('GET._Tallas')
        , $f3->get('GET._TipoEmpaque')
        , $f3->get('GET._DebutReorder')));

}

    public function Listar_Pop_Ajuste_Cajas_curvado_solido($f3) {

        echo json_encode(\simulador_compra\PlanCompraClass::Listar_Pop_Ajuste_Cajas_curvado_solido($f3->get('SESSION.COD_TEMPORADA')
            , $f3->get('SESSION.COD_DEPTO')
            , $f3->get('GET.ID_COLOR3')
            , $f3->get('GET._Tallas')
            , $f3->get('GET._TipoEmpaque')
            , $f3->get('GET._DebutReorder')));

    }

// ######################## POP PRESUPUESTOS Total PLAN########################
    public function Listar_Pop_Presupuestos($f3){

        //Presupuestos Costo-Retail-Embarque
        $presupuestos = \simulador_compra\PlanCompraClass::obtienePptosemb($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'));
        $prorrateo_ppto_retail = \simulador_compra\PlanCompraClass::obtienePptoRetail($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'));
        $prorrateo_ppto_costo = \simulador_compra\PlanCompraClass::obtienePptoCosto($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'));

        //Consumos de costos del plan por Ventana
        $tabla1_consumo = \simulador_compra\PlanCompraClass::obtieneConsumo($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'));

        //Contruccion de filas
        #region "PPTO"
                // 0.- Línea de Presupuesto
                $presu = array("Tipo" => "Ppto",
                    "Ac" => "0", "Bc" => "0", "Cc" => "0", "Dc" => "0", "Ec" => "0", "Fc" => "0", "Gc" => "0", "Hc" => "0", "Ic" => "0", "Totalc" => $prorrateo_ppto_costo,
                    "Ar" => "0", "Br" => "0", "Cr" => "0", "Dr" => "0", "Er" => "0", "Fr" => "0", "Gr" => "0", "Hr" => "0", "Ir" => "0", "Totalr" => $prorrateo_ppto_retail,
                    "Ae" => "0", "Be" => "0", "Ce" => "0", "De" => "0", "Ee" => "0", "Fe" => "0", "Ge" => "0", "He" => "0", "Ie" => "0", "Totale" => "100%");


                // 0.- Llenar Línea de Ppto
                for ($i=0;$i<= (count($presupuestos)-1);$i++){
                    if ($presupuestos[$i]['VENT_DESCRI'] == "A") {
                        $presu['Ae'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Ar'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Ac'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "B") {
                        $presu['Be'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Br'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Bc'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "C") {
                        $presu['Ce'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Cr'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Cc'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "D") {
                        $presu['De'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Dr'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Dc'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "E") {
                        $presu['Ee'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Er'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Ec'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "F") {
                        $presu['Fe'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Fr'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Fc'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "G") {
                        $presu['Ge'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Gr'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Gc'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "H") {
                        $presu['He'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Hr'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Hc'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    } elseif ($presupuestos[$i]['VENT_DESCRI'] == "I") {
                        $presu['Ie'] = ($presupuestos[$i]['PORCENTAJE'] * 100) . '%';
                        $presu['Ir'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_retail;
                        $presu['Ic'] = $presupuestos[$i]['PORCENTAJE'] * $prorrateo_ppto_costo;
                    }
                }
                $presu['Totale'] = "100%";
        #endregion//
        #region "Consumo"
                // 2.- Líneas de Consumo
                $tab1_arr_consumo = array("Tipo" => "Consumo",
                    "Ac" => "0", "Bc" => "0", "Cc" => "0", "Dc" => "0", "Ec" => "0", "Fc" => "0", "Gc" => "0", "Hc" => "0", "Ic" => "0", "Totalc" => "0",
                    "Ar" => "0", "Br" => "0", "Cr" => "0", "Dr" => "0", "Er" => "0", "Fr" => "0", "Gr" => "0", "Hr" => "0", "Ir" => "0", "Totalr" => "0",
                    "Ae" => "0", "Be" => "0", "Ce" => "0", "De" => "0", "Ee" => "0", "Fe" => "0", "Ge" => "0", "He" => "0", "Ie" => "0", "Totale" => "0");

                // 3.- Llenar la línea de Consumo -> Costo y Retail (Orden: Ac - Ar - Ae)
                for ($i=0;$i<= (count($tabla1_consumo)-1);$i++){
                    if ($tabla1_consumo[$i]['VENTANA'] == "A") {
                        $tab1_arr_consumo['Ac'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Ar'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "B") {
                        $tab1_arr_consumo['Bc'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Br'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "C") {
                        $tab1_arr_consumo['Cc'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Cr'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "D") {
                        $tab1_arr_consumo['Dc'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Dr'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "E") {
                        $tab1_arr_consumo['Ec'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Er'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "F") {
                        $tab1_arr_consumo['Fc'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Fr'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "G") {
                        $tab1_arr_consumo['Gc'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Gr'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "H") {
                        $tab1_arr_consumo['Hc'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Hr'] = $tabla1_consumo[$i]['RETAIL'];
                    } elseif ($tabla1_consumo[$i]['VENTANA'] == "I") {
                        $tab1_arr_consumo['Ic'] = $tabla1_consumo[$i]['COSTO'];
                        $tab1_arr_consumo['Ir'] = $tabla1_consumo[$i]['RETAIL'];
                    }
                }

                // 4.- Línea de Consumo -> Total Costo y Total Retail
                $tab1_arr_consumo['Totalc'] = $tab1_arr_consumo['Ac'] + $tab1_arr_consumo['Bc'] + $tab1_arr_consumo['Cc'] + $tab1_arr_consumo['Dc'] + $tab1_arr_consumo['Ec'] + $tab1_arr_consumo['Fc'] + $tab1_arr_consumo['Gc'] + $tab1_arr_consumo['Hc'] + $tab1_arr_consumo['Ic'];
                $tab1_arr_consumo['Totalr'] = $tab1_arr_consumo['Ar'] + $tab1_arr_consumo['Br'] + $tab1_arr_consumo['Cr'] + $tab1_arr_consumo['Dr'] + $tab1_arr_consumo['Er'] + $tab1_arr_consumo['Fr'] + $tab1_arr_consumo['Gr'] + $tab1_arr_consumo['Hr'] + $tab1_arr_consumo['Ir'];


                // 5.- Llenar la línea de Consumo -> Embarque
                $arrayLetra = array("A","B","C","D","E","F","G","H","I");
                foreach ($arrayLetra as $v){
                   if ($tab1_arr_consumo['Totalc']<> 0){
                       $tab1_arr_consumo[$v.'e'] = round((($tab1_arr_consumo[$v.'c'] / $tab1_arr_consumo['Totalc']) * 100), 2);
                   }else{
                       $tab1_arr_consumo[$v.'e'] = 0;
                   }
                }
        #endregion
        #region "Saldo"

        if ($prorrateo_ppto_costo == 0) {
            $tab1_arr_consumo['Totale'] = 0;
        } else {
            $tab1_arr_consumo['Totale'] = round((($tab1_arr_consumo['Totalc'] / $prorrateo_ppto_costo)), 2);
        }

        $tab1_arr_total = array(
            "Tipo" => "Total",
            "Ac" => number_format(($presu['Ac'] - $tab1_arr_consumo['Ac']), 0, ',', '.'),
            "Bc" => number_format(($presu['Bc'] - $tab1_arr_consumo['Bc']), 0, ',', '.'),
            "Cc" => number_format(($presu['Cc'] - $tab1_arr_consumo['Cc']), 0, ',', '.'),
            "Dc" => number_format(($presu['Dc'] - $tab1_arr_consumo['Dc']), 0, ',', '.'),
            "Ec" => number_format(($presu['Ec'] - $tab1_arr_consumo['Ec']), 0, ',', '.'),
            "Fc" => number_format(($presu['Fc'] - $tab1_arr_consumo['Fc']), 0, ',', '.'),
            "Gc" => number_format(($presu['Gc'] - $tab1_arr_consumo['Gc']), 0, ',', '.'),
            "Hc" => number_format(($presu['Hc'] - $tab1_arr_consumo['Hc']), 0, ',', '.'),
            "Ic" => number_format(($presu['Ic'] - $tab1_arr_consumo['Ic']), 0, ',', '.'),
            "Totalc" => number_format(($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc']), 0, ',', '.'),
            "Ar" => number_format(($presu['Ar'] - $tab1_arr_consumo['Ar']), 0, ',', '.'),
            "Br" => number_format(($presu['Br'] - $tab1_arr_consumo['Br']), 0, ',', '.'),
            "Cr" => number_format(($presu['Cr'] - $tab1_arr_consumo['Cr']), 0, ',', '.'),
            "Dr" => number_format(($presu['Dr'] - $tab1_arr_consumo['Dr']), 0, ',', '.'),
            "Er" => number_format(($presu['Er'] - $tab1_arr_consumo['Er']), 0, ',', '.'),
            "Fr" => number_format(($presu['Fr'] - $tab1_arr_consumo['Fr']), 0, ',', '.'),
            "Gr" => number_format(($presu['Gr'] - $tab1_arr_consumo['Gr']), 0, ',', '.'),
            "Hr" => number_format(($presu['Hr'] - $tab1_arr_consumo['Hr']), 0, ',', '.'),
            "Ir" => number_format(($presu['Ir'] - $tab1_arr_consumo['Ir']), 0, ',', '.'),
            "Totalr" => number_format(($prorrateo_ppto_retail - $tab1_arr_consumo['Totalr']), 0, ',', '.'),
            "Ae" => round(($presu['Ac'] > 0 ? (($presu['Ac'] - $tab1_arr_consumo['Ac']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "Be" => round(($presu['Bc'] > 0 ? (($presu['Bc'] - $tab1_arr_consumo['Bc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "Ce" => round(($presu['Cc'] > 0 ? (($presu['Cc'] - $tab1_arr_consumo['Cc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "De" => round(($presu['Dc'] > 0 ? (($presu['Dc'] - $tab1_arr_consumo['Dc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "Ee" => round(($presu['Ec'] > 0 ? (($presu['Ec'] - $tab1_arr_consumo['Ec']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "Fe" => round(($presu['Fc'] > 0 ? (($presu['Fc'] - $tab1_arr_consumo['Fc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "Ge" => round(($presu['Gc'] > 0 ? (($presu['Gc'] - $tab1_arr_consumo['Gc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "He" => round(($presu['Hc'] > 0 ? (($presu['Hc'] - $tab1_arr_consumo['Hc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",
            "Ie" => round(($presu['Ic'] > 0 ? (($presu['Ic'] - $tab1_arr_consumo['Ic']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0), 2) . "%",

            "Totale" => round((($presu['Ac'] > 0 ? (($presu['Ac'] - $tab1_arr_consumo['Ac']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Bc'] > 0 ? (($presu['Bc'] - $tab1_arr_consumo['Bc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Cc'] > 0 ? (($presu['Cc'] - $tab1_arr_consumo['Cc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Dc'] > 0 ? (($presu['Dc'] - $tab1_arr_consumo['Dc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Ec'] > 0 ? (($presu['Ec'] - $tab1_arr_consumo['Ec']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Fc'] > 0 ? (($presu['Fc'] - $tab1_arr_consumo['Fc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Gc'] > 0 ? (($presu['Gc'] - $tab1_arr_consumo['Gc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Hc'] > 0 ? (($presu['Hc'] - $tab1_arr_consumo['Hc']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0) +
                    ($presu['Ic'] > 0 ? (($presu['Ic'] - $tab1_arr_consumo['Ic']) / ($prorrateo_ppto_costo - $tab1_arr_consumo['Totalc'])) * 100 : 0)), 2) . "%"
        );



#endregion

        //Unir filas
        $dtpresupuestos= []; array_push($dtpresupuestos,$presu,$tab1_arr_consumo,$tab1_arr_total);
        echo json_encode($dtpresupuestos);
    }

// ######################## POP PRESUPUESTOS Edit########################
    public function ListarPopEditPresupuestos($f3){
        $tipo= $f3->get('GET.tipo');

        if($tipo== 1){
         echo json_encode(\simulador_compra\PlanCompraClass::obtienePptoCosto($f3->get('SESSION.COD_TEMPORADA')
                                                                            , $f3->get('SESSION.COD_DEPTO')));
        }elseif ($tipo== 2){
         echo json_encode(\simulador_compra\PlanCompraClass::obtienePptoRetail($f3->get('SESSION.COD_TEMPORADA')
                                                                             , $f3->get('SESSION.COD_DEPTO')));
        }else{
          echo json_encode(\simulador_compra\PlanCompraClass::obtienePptosemb($f3->get('SESSION.COD_TEMPORADA')
                                                                            , $f3->get('SESSION.COD_DEPTO')));
        }

    }

    public function InsertPptoCosto($f3) {

        \simulador_compra\PlanCompraClass::EliminarPptoCosto($f3->get('SESSION.COD_TEMPORADA')
                                                            ,$f3->get('SESSION.COD_DEPTO')
                                                            ,$f3->get('SESSION.login'));

        echo \simulador_compra\PlanCompraClass::InsertPptoCosto( $f3->get('SESSION.COD_TEMPORADA')
                                                                ,$f3->get('SESSION.COD_DEPTO')
                                                                ,$f3->get('GET.PRESUPUESTO')
                                                                ,$f3->get('SESSION.login'));
    }

    public function InsertPptoRetail($f3) {
        \simulador_compra\PlanCompraClass::EliminarPptoRetail($f3->get('SESSION.COD_TEMPORADA')
            ,$f3->get('SESSION.COD_DEPTO')
            ,$f3->get('SESSION.login'));

        echo \simulador_compra\PlanCompraClass::InsertPptoRetail( $f3->get('SESSION.COD_TEMPORADA')
                                                                    ,$f3->get('SESSION.COD_DEPTO')
                                                                    ,$f3->get('GET.PRESUPUESTO')
                                                                    ,$f3->get('SESSION.login'));
    }

    public function InsertVentEmb($f3) {

        echo \simulador_compra\PlanCompraClass::InsertVentEmb($f3->get('SESSION.COD_TEMPORADA')
            ,$f3->get('SESSION.COD_DEPTO')
            ,$f3->get('GET.VENTANA')
            ,$f3->get('GET.PORCENTAJE')
            ,$f3->get('SESSION.login'));
    }

    public function DeleteVentEm($f3){
       echo \simulador_compra\PlanCompraClass::EliminarVentEmb($f3->get('SESSION.COD_TEMPORADA')
                ,$f3->get('SESSION.COD_DEPTO')
                ,$f3->get('SESSION.login'));
    }

    public function Sumaporcent($f3){
        $dt = explode("-", (substr ($f3->get('GET._Porcent'), 0, -1)));
        $total = 0;
        foreach ($dt as $val){
            $total = $total + ($val*100);
        }
        if ($total == 100){
            echo 1;
        }else{
            echo 0;
        }

    }

// ######################## POP EXPORTAR ########################
    public function ListarDeptosTemp($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarDeptosTemp($f3->get('SESSION.COD_TEMPORADA')));
    }

    public function ListarDeptosTempAssortment($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarDeptosTempAssortment($f3->get('SESSION.COD_TEMPORADA')));
    }

    public function ListarEstadosPlan($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarEstadosPlan($f3->get('SESSION.COD_TEMPORADA')));
    }


    public function ExportarArchivos($f3){

        require_once '../PHPExcel/PHPExcel.php';
        $typeExport = $_POST['CBXtipoExport'];
        $deptos = trim($_POST['SeleccionDepto']);
        $estados = trim($_POST['Seleccionestados']);

        /* 1:Assortment
           2:C1
           3:Opcion por estado
           4:Formato Assortment
         */

        if ($typeExport == 1){

            $dt = explode(',',$deptos);
            $deptosQuery = "";
            foreach ($dt as $val){
                $deptosQuery = $deptosQuery."'".trim($val)."',";
            }
            $deptosQuery = substr($deptosQuery, 0, -1);
            include '../ui/reporte/excel_asorment.php';

        }
        elseif($typeExport == 2){
            $deptos = str_replace(" ","", $deptos);
            include '../ui/reporte/cabeceraexcel.php';

          /*
            $file ="C1_Consolidada_".$f3->get('SESSION.COD_TEMPORADA').".xls"; // Decode URL-encoded string
            $filepath = "../archivos/c1_consolidada/" . $file;

            // Process download
            if(file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$file.'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));

                flush(); // Flush system output buffer
                readfile($filepath);
                exit;
            }*/

        }
        elseif($typeExport == 3){
            $dt = explode(',',$deptos);
            $deptosQuery = "";
            foreach ($dt as $val){
                $deptosQuery = $deptosQuery.trim($val).",";
            }
            $estados = str_replace(" ","", $estados);
            include '../ui/reporte/excel_opcion.php';

        }
        elseif($typeExport == 4){
            $file ="Formato_Assortment.xls"; // Decode URL-encoded string
            $filepath = "../archivos/formatos/Formato Assorment.xlsx";

            // Process download
            if(file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $file . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));

                flush(); // Flush system output buffer
                readfile($filepath);
                exit;
            }
        }
    }



// Termina Clase
}