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
        echo json_encode(\simulador_compra\PlanCompraClass::ListarPlanCompra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }


    // Actualiza Plan de Compra
    public function ProcesaDataPlanCompra($f3)
    {

        $tempData = html_entity_decode($_REQUEST['models']);
        $json = json_decode($tempData, true);


        // var_dump($json['updated']);
        // die();


        // Recorrer el JSON
        foreach ($json['updated'] as $columna) {
            // echo $columna['ID_COLOR3'];

            $ID_COLOR3 = $columna["ID_COLOR3"];
            $GRUPO_COMPRA = $columna["GRUPO_COMPRA"];
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
            $NOM_VENTANA = $columna["NOM_VENTANA"];
            $COD_RANKVTA = $columna["COD_RANKVTA"];
            $LIFE_CYCLE = $columna["LIFE_CYCLE"];
            $NUM_EMB = $columna["NUM_EMB"];
            $COD_COLOR = $columna["COD_COLOR"];
            $TIPO_PRODUCTO = $columna["TIPO_PRODUCTO"];
            $TIPO_EXHIBICION = $columna["TIPO_EXHIBICION"];
            $DESTALLA = $columna["DESTALLA"];
            $TIPO_EMPAQUE = $columna["TIPO_EMPAQUE"];
            $PORTALLA_1_INI = $columna["PORTALLA_1_INI"];
            $PORTALLA_1 = $columna["PORTALLA_1"];
            $CURVATALLA = $columna["CURVATALLA"];
            $CURVAMIN = $columna["CURVAMIN"];
            $UNID_OPCION_INICIO = $columna["UNID_OPCION_INICIO"];
            $UNID_OPCION_AJUSTADA = $columna["UNID_OPCION_AJUSTADA"];
            $CAN = $columna["CAN"];
            $MTR_PACK = $columna["MTR_PACK"];
            $CANT_INNER = $columna["CANT_INNER"];
            $SEG_ASIG = $columna["SEG_ASIG"];
            $FORMATO = $columna["FORMATO"];
            $TDAS = $columna["TDAS"];
            $A = $columna["A"];
            $B = $columna["B"];
            $C = $columna["C"];
            $I = $columna["I"];
            $UND_ASIG_INI = $columna["UND_ASIG_INI"];
            $ROT = $columna["ROT"];
            $NOM_PRECEDENCIA = $columna["NOM_PRECEDENCIA"];
            $NOM_VIA = $columna["NOM_VIA"];
            $NOM_PAIS = $columna["NOM_PAIS"];
            $VIAJE = $columna["VIAJE"];
            $MKUP = $columna["MKUP"];
            $PRECIO_BLANCO = $columna["PRECIO_BLANCO"];
            $OFERTA = $columna["OFERTA"];
            $GM = $columna["GM"];
            $COD_TIP_MON = $columna["COD_TIP_MON"];
            $COSTO_TARGET = $columna["COSTO_TARGET"];
            $COSTO_FOB = $columna["COSTO_FOB"];
            $COSTO_INSP = $columna["COSTO_INSP"];
            $COSTO_RFID = $columna["COSTO_RFID"];
            $ROYALTY_POR = $columna["ROYALTY_POR"];
            $COSTO_UNIT = $columna["COSTO_UNIT"];
            $COSTO_UNITS = $columna["COSTO_UNITS"];
            $CST_TOTLTARGET = $columna["CST_TOTLTARGET"];
            $COSTO_TOT = $columna["COSTO_TOT"];
            $COSTO_TOTS = $columna["COSTO_TOTS"];
            $RETAIL = $columna["RETAIL"];
            $DEBUT_REODER = $columna["DEBUT_REODER"];
            $SEM_INI = $columna["SEM_INI"];
            $SEM_FIN = $columna["SEM_FIN"];
            $CICLO = $columna["CICLO"];
            $AGOT_OBJ = $columna["AGOT_OBJ"];
            $SEMLIQ = $columna["SEMLIQ"];
            $ALIAS_PROV = $columna["ALIAS_PROV"];
            $COD_PROVEEDOR = $columna["COD_PROVEEDOR"];
            $COD_TRADER = $columna["COD_TRADER"];
            $AFTER_MEETING_REMARKS = $columna["AFTER_MEETING_REMARKS"];
            $CODSKUPROVEEDOR = $columna["CODSKUPROVEEDOR"];
            $SKU = $columna["SKU"];
            $PROFORMA = $columna["PROFORMA"];
            $ARCHIVO = $columna["ARCHIVO"];
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
            $ESTADO_C1 = $columna["ESTADO_C1"];
            $VENTANA_LLEGADA = $columna["VENTANA_LLEGADA"];
            $PROFORMA_BASE = $columna["PROFORMA_BASE"];
            $TIPO_EMPAQUE_BASE = $columna["TIPO_EMPAQUE_BASE"];
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




            echo json_encode(\simulador_compra\PlanCompraClass::ActualizaPlanCompra(
                $f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),
                $ID_COLOR3,$GRUPO_COMPRA,$COD_TEMP,$LINEA,$SUBLINEA,$MARCA,$ESTILO,$SHORT_NAME,$ID_CORPORATIVO,$DESCMODELO,$DESCRIP_INTERNET,
                $NOMBRE_COMPRADOR,$NOMBRE_DISENADOR,$COMPOSICION,$TIPO_TELA,$FORRO,$COLECCION,$EVENTO,$COD_ESTILO_VIDA,$CALIDAD,$COD_OCASION_USO,
                $COD_PIRAMIX,$NOM_VENTANA,$COD_RANKVTA,$LIFE_CYCLE,$NUM_EMB,$COD_COLOR,$TIPO_PRODUCTO,$TIPO_EXHIBICION,$DESTALLA,$TIPO_EMPAQUE,
                $PORTALLA_1_INI,$PORTALLA_1,$CURVATALLA,$CURVAMIN,$UNID_OPCION_INICIO,$UNID_OPCION_AJUSTADA,$CAN,$MTR_PACK,$CANT_INNER,$SEG_ASIG,$FORMATO,$TDAS,$A,$B,$C,$I,$UND_ASIG_INI,$ROT,$NOM_PRECEDENCIA,$NOM_VIA,$NOM_PAIS,$VIAJE,$MKUP,$PRECIO_BLANCO,$OFERTA,$GM,$COD_TIP_MON,$COSTO_TARGET,$COSTO_FOB,$COSTO_INSP,$COSTO_RFID,$ROYALTY_POR,$COSTO_UNIT,$COSTO_UNITS,$CST_TOTLTARGET,$COSTO_TOT,$COSTO_TOTS,$RETAIL,$DEBUT_REODER,$SEM_INI,$SEM_FIN,$CICLO,$AGOT_OBJ,$SEMLIQ,$ALIAS_PROV,$COD_PROVEEDOR,$COD_TRADER,$AFTER_MEETING_REMARKS,$CODSKUPROVEEDOR,$SKU,$PROFORMA,$ARCHIVO,$ESTILO_PMM,$ESTADO_MATCH,$PO_NUMBER,$ESTADO_OC,$FECHA_ACORDADA,$FECHA_EMBARQUE,$FECHA_ETA,$FECHA_RECEPCION,$DIAS_ATRASO,$CODESTADO,$ESTADO_C1,$VENTANA_LLEGADA,$PROFORMA_BASE,$TIPO_EMPAQUE_BASE,$UNI_INICIALES_BASE,$PRECIO_BLANCO_BASE,$COSTO_TARGET_BASE,$COSTO_FOB_BASE,$COSTO_INSP_BASE,$COSTO_RFID_BASE,$COD_MARCA,$N_CURVASXCAJAS,$COD_JER2,$COD_SUBLIN));





        // Fin del each que recorre el JSON
        }





        // Fin del actualizar grilla
    }


    // Calcula el Curvado para los campos editados en el plan de compra
    public function CalculoCurvadoPlanCompra($f3){

        $dt = \simulador_compra\PlanCompraClass::CalculoCurvadoPlanCompra($_POST['_tipo_empaque']
            ,$_POST['_tallas']
            ,$_POST['_curvas']
            ,$_POST['_und_iniciales']
            ,$_POST['_cluster']
            ,$_POST['_formato']
            ,$_POST['_A']
            ,$_POST['_B']
            ,$_POST['_C']
            ,$_POST['_I']
            ,$_POST['_DEBUT_REODER']
            ,$_POST['_PORTALLA_1_INI']
            ,$f3->get('SESSION.COD_DEPTO')
            ,$f3->get('SESSION.COD_TEMPORADA')
            ,$_POST['_marcas']
            ,$_POST['_N_CURVASXCAJAS']
            ,$_POST['_cod_linea']
            ,$_POST['_cod_sublinea']
            ,$_POST['_id_color3']
            ,1);



        $varibles = /*0 unid ajust*/$dt[0]."|".
            /*1 porcenajust*/$dt[1]."|".
            /*2 N° CAJAS*/   $dt[2]."|".
            /*3 unidfinal*/$dt[3]."|".
            /*4 primera carga*/$dt[4]."|".
            /*5 $tdas*/$dt[5]."|".
            /*6 unidadesajustXtalla*/$dt[6];

        echo json_encode($varibles);
    }

    // Carga POPUP de Historial en Plan de Compra
    public function ListarHistorial($f3)
    {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarHistorial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.ID_COLOR3')));
    }

    // Busca Factor
    public function BuscaFactor($f3) { // $pais,$via,$moneda,$ventana
        echo json_encode(\simulador_compra\PlanCompraClass::BuscaFactor($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.PAIS'), $f3->get('GET.VIA'), $f3->get('GET.MONEDA'), $f3->get('GET.VENTANA')));
    }

    // Busca Factor
    public function BuscaTipoCambio($f3) { // ,$moneda,$ventana
        echo json_encode(\simulador_compra\PlanCompraClass::BuscaTipoCambio($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.MONEDA'), $f3->get('GET.VENTANA')));
    }


    // Actualizar grilla en plan_compra_color3
    public function actualiza_grilla_plan_compra_color3($f3) {

        $COSTO_UNITS = round($f3->get('GET.COSTO_UNITS'),0);

        /* ECHO ($f3->get('GET.und_ajust')."|".
            $f3->get('GET.porcent_ajust')."|".
            $f3->get('GET.n_cajas')."|".
            $f3->get('GET.primera_carga')."|".
            $f3->get('GET.tiendas')."|".
            $f3->get('GET.unida_ajust_xtallas')."|".
            $f3->get('GET.UNIDADES_FINALES')."|".
            $f3->get('GET.marca_')."|".
            $f3->get('GET.cluster_')."|".
            $f3->get('GET.debut_')."|".
            $f3->get('GET.tipo_emp_')."|".
            $f3->get('GET.formatos_')."|".
            $f3->get('GET.UNIDADES_INICIALES'));*/

        $cluster = str_replace(" ","+",$f3->get('GET.cluster_'));

        echo \simulador_compra\cbx_grilla_compra::actualiza_grilla_plan_compra_color3($f3->get('SESSION.COD_TEMPORADA')
            , $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3')
            , $f3->get('GET.COSTO_FOB'), $f3->get('GET.COSTO_INSP'), $f3->get('GET.COSTO_RFID')
            , $f3->get('GET.COSTO_UNIT'), $COSTO_UNITS, $f3->get('GET.CST_TOTLTARGET')
            , $f3->get('GET.COSTO_TOT'), $f3->get('GET.COSTO_TOTS'), $f3->get('GET.MKUP')
            , $f3->get('GET.GM'), $f3->get('GET.PROVEEDOR'), $f3->get('GET.VIA')
            , $f3->get('GET.PAIS'), $f3->get('GET.FACTOR_EST'), $f3->get('GET.NOM_VIA')
            , $f3->get('GET.NOM_PAIS'), $f3->get('GET.TARGET')
            ,  $f3->get('GET.tipo_emp_'),$f3->get('GET.UNIDADES_INICIALES'),$f3->get('GET.und_ajust'),$f3->get('GET.UNIDADES_FINALES'),
            $f3->get('GET.porcent_ajust'),$f3->get('GET.tiendas'),$f3->get('GET.formatos_'),$f3->get('GET.n_cajas'),
            $f3->get('GET.unida_ajust_xtallas'),$f3->get('GET.marca_'),$cluster,$f3->get('GET.debut_'),$f3->get('GET.precioRetail_'),$f3->get('GET.precio_blanco_')
            ,$f3->get('GET.COSTO'));
    }

    // Actualizar grilla en PLC_PLAN_COMPRA_COLOR_CIC
    public function actualiza_grilla_plan_compra_color_cic($f3) {
        echo \simulador_compra\cbx_grilla_compra::actualiza_grilla_plan_compra_color_cic($f3->get('SESSION.COD_TEMPORADA')
            , $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login')
            , $f3->get('GET.ID_COLOR3'), $f3->get('GET.COSTO')
            , $f3->get('GET.precioRetail_'));
    }

    // Listar País
    public function ListarPais($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarPais($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }

    // Listar Formatos Grilla Editar
    public function ListarFormato($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarFormato($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }

    // Listar Ventana Grilla Editar
    public function ListarVentana($f3) {
        echo json_encode(\simulador_compra\PlanCompraClass::ListarVentana($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
    }



// Termina Clase
}