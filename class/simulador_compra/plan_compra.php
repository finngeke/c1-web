<?php

/**
 * CLASS Temporada
 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
 * Fecha: 2018-02-07
 * @author RODRIGO RIOSECO
 */

namespace simulador_compra;

class plan_compra extends \parametros {

    private $campos_validos_hist;

    /**
     * Constructor de clase
     * @param1 varchar $usr_nom Usuario de Windows
     */
    public function __construct($campos_validos_hist) {

        $this->campos_insert_hist = $campos_validos_hist;
    }
#region {*************Metodos Importar Assortment*************}
    public static function existeGrillaBmt($temporada, $depto) {

        $sql = "select count(1) as reg from PLC_PLAN_COMPRA_COLOR_3 "
            . " where cod_temporada=" . $temporada . " and dep_depto='" . $depto . "'";

        return (object) \database::getInstancia()->getFila($sql);
    }
    public static function existeGrupoCompraImport($temporada, $depto, $grupo) {

        $sql = "select count(1) as reg from PLC_PLAN_COMPRA_COLOR_3 "
            . " where cod_temporada=" . $temporada . " and dep_depto='" . $depto . "' and grupo_compra='" . $grupo . "'"
            . " and estado not in (31,13,0)";

        return (object) \database::getInstancia()->getFila($sql);
    }
    public static function eliminaHistoricoBmt($temporada, $depto) {

        $sql = "begin PLC_PKG_DESARROLLO.PRC_DEL_HIS_IMPORT_BMT(" . $temporada . ",'" . $depto . "', :error, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 2);
    }
    public static function generaFilaBmt($columnas, $datos, $correlativo, $temporada) {

        $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_HIS_IMPORT_BMT('" . $datos[$columnas['PURCHASE GROUP']] . "'"
            . ",'" . utf8_decode($datos[$columnas['CORPORATE BUYER NAME']]) . "'"
            . ",'" . utf8_decode($datos[$columnas['DESIGNER NAME']]) . "'"
            . ",'" . $datos[$columnas['PI SEASON']] . "'"
            . ",'" . $datos[$columnas['STYLE NUMBER']] . "'"
            . ",'" . $datos[$columnas['STYLE NAME']] . "'"
            . ",'" . $datos[$columnas['SHORT_NAME']] . "'"
            . ",'" . $datos[$columnas['PHOTOGRAF']] . "'"
            . ",'" . $datos[$columnas['COLOR CODE']] . "'"
            . ",'" . $datos[$columnas['COLOR NAME']] . "'"
            . ",'" . $datos[$columnas['COLECTION']] . "'"
            . ",'" . $datos[$columnas['COMPOSITION']] . "'"
            . ",'" . $datos[$columnas['LINING']] . "'"
            . ",'" . $datos[$columnas['TYPE OF FABRIC']] . "'"
            . ",'" . $datos[$columnas['DETAILS']] . "'"
            . ",'" . $datos[$columnas['BEFORE MEETING REMARKS']] . "'"
            . ",'" . $datos[$columnas['AFTER MEETING REMARKS']] . "'"
            . ",'" . $datos[$columnas['PRODUCT DESCRIPTION']] . "'"
            . ",'" . $datos[$columnas['STYLE GENDER']] . "'"
            . ",'" . $datos[$columnas['SEASON']] . "'"
            . ",'" . $datos[$columnas['TARGET VENDOR']] . "'"
            . ",'" . $datos[$columnas['VENDOR NICK NAME']] . "'"
            . ",'" . $datos[$columnas['VENDOR CODE']] . "'"
            . ",'" . $datos[$columnas['COUNTRY OF ORIGIN']] . "'"
            . ",'" . $datos[$columnas['HKO/NO HKO']] . "'"
            . ",'" . $datos[$columnas['TARGET COST']] . "'"
            . ",'" . $datos[$columnas['TARGET BUDGET']] . "'"
            . ",'" . $datos[$columnas['TOTAL QUANTITY']] . "'"
            . ",'" . $datos[$columnas['FINAL COST']] . "'"
            . ",'" . $datos[$columnas['FINAL BUDGET']] . "'"
            . ",'" . $datos[$columnas['LEAD TIME TYPE']] . "'"
            . ",'" . $datos[$columnas['LOCAL BUYER']] . "'"
            . ",'" . $datos[$columnas['LOCAL BRAND']] . "'"
            . ",'" . $datos[$columnas['DEPARTMENT']] . "'"
            . ",'" . $datos[$columnas['DEPARTMENT CODE']] . "'"
            . ",'" . $temporada . "'"
            . ",'" . $datos[$columnas['LINE (*)']] . "'"
            . ",'" . $datos[$columnas['SUBLINE']] . "'"
            . ",'" . $datos[$columnas['SUBLNE CODE']] . "'"
            . ",' '"
            . ",'" . $datos[$columnas['LIFE CICLE']] . "'"
            . ",'" . $datos[$columnas['PRODUCT SEASON']] . "'"
            . ",'" . $datos[$columnas['PYRAMID MIX']] . "'"
            . ",'" . $datos[$columnas['TYPE OF PRODUCT']] . "'"
            . ",'" . $datos[$columnas['CHANCE OF USER']] . "'"
            . ",'" . $datos[$columnas['RANKING OF SALE']] . "'"
            . ",'" . $datos[$columnas['LIFE STYLE']] . "'"
            . ",'" . $datos[$columnas['RETAIL PRICE']] . "'"
            . ",'" . $datos[$columnas['PRICE RANGE']] . "'"
            . ",'" . $datos[$columnas['2 X RETAIL PRICE']] . "'"
            . ",'" . $datos[$columnas['ANTES/AHORA']] . "'"
            . ",'" . $datos[$columnas['EVENTO']] . "'"
            . ",'" . $datos[$columnas['SHIPMENT MODE']] . "'"
            . ",'" . $datos[$columnas['VENTANA']] . "'"
            . ",'" . $datos[$columnas['mm/dd1']] . "'"
            . ",'" . $datos[$columnas['mm/dd2']] . "'"
            . ",'" . $datos[$columnas['mm/dd3']] . "'"
            . ",'" . $datos[$columnas['mm/dd4']] . "'"
            . ",'" . $datos[$columnas['mm/dd5']] . "'"
            . ",'" . $datos[$columnas['mm/dd6']] . "'"
            . ",'" . $datos[$columnas['mm/dd7']] . "'"
            . ",'" . $datos[$columnas['TOTAL QUANTITY CL']] . "'"
            . ",''"
            . ",'" . $datos[$columnas['SIZE']] . "'"
            . ",'" . $datos[$columnas['Size %1']] . "'"
            . ",'" . $datos[$columnas['Size %2']] . "'"
            . ",'" . $datos[$columnas['Size %3']] . "'"
            . ",'" . $datos[$columnas['Size %4']] . "'"
            . ",'" . $datos[$columnas['Size %5']] . "'"
            . ",'" . $datos[$columnas['Size %6']] . "'"
            . ",'" . $datos[$columnas['Size %7']] . "'"
            . ",'" . $datos[$columnas['Size %8']] . "'"
            . ",'" . $datos[$columnas['Size %9']] . "'"
            . ",'" . $datos[$columnas['Size %10']] . "'"
            . ",'" . $datos[$columnas['Size %11']] . "'"
            . ",'" . $datos[$columnas['Size %12']] . "'"
            . ",'" . $datos[$columnas['Size %13']] . "'"
            . ",'" . $datos[$columnas['Size %14']] . "'"
            . ",'" . $datos[$columnas['Size %15']] . "'"
            . ",'" . $datos[$columnas['Qty #1']] . "'"
            . ",'" . $datos[$columnas['Qty #2']] . "'"
            . ",'" . $datos[$columnas['Qty #3']] . "'"
            . ",'" . $datos[$columnas['Qty #4']] . "'"
            . ",'" . $datos[$columnas['Qty #5']] . "'"
            . ",'" . $datos[$columnas['Qty #6']] . "'"
            . ",'" . $datos[$columnas['Qty #7']] . "'"
            . ",'" . $datos[$columnas['Qty #8']] . "'"
            . ",'" . $datos[$columnas['Qty #9']] . "'"
            . ",'" . $datos[$columnas['Qty #10']] . "'"
            . ",'" . $datos[$columnas['Qty #11']] . "'"
            . ",'" . $datos[$columnas['Qty #12']] . "'"
            . ",'" . $datos[$columnas['Qty #13']] . "'"
            . ",'" . $datos[$columnas['Qty #14']] . "'"
            . ",'" . $datos[$columnas['Qty #15']] . "'"
            . ",'" . $datos[$columnas['PREPACK']] . "'"
            . ",'" . $datos[$columnas['HANDLING TYPE']] . "'"
            . ",'" . $datos[$columnas['HANDLING TYPE CD']] . "'"
            . ",'" . $datos[$columnas['SIZE STICKER']] . "'"
            . ",'" . $datos[$columnas['UNITS PER BOX']] . "'"
            . ",'" . $datos[$columnas['REORDER']] . "'"
            . ",'" . $datos[$columnas['COST LAST PURCHASE']] . "'"
            . ",'" . $datos[$columnas['VENDOR LAST PURCHASE']] . "'"
            . ",'" . $datos[$columnas['EXTENDED WARRANTY']] . "'"
            . ",''"
            . ",'" . $datos[$columnas['INSPECTION COST']] . "'"
            . ",'" . $datos[$columnas['ROYALTY']] . "'"
            . ",'" . $datos[$columnas['SIZE SAMPLE']] . "'"
            . ",'" . $datos[$columnas['COD CORP']] . "'"
            . ",'" . $datos[$columnas['DESCRIPCION INTERNET']] . "'"
            . ",'" . $datos[$columnas['CLUSTER']] . "'"
            . ",'" . $datos[$columnas['RFID COST']] . "'"
            . ",'" . $datos[$columnas['TYPE OF EXHIBITION']] . "'"
            . ",'" . $datos[$columnas['LOCAL BUYER P']] . "'"
            . ",'" . $datos[$columnas['LOCAL BRAND P']] . "'"
            . ",'" . $datos[$columnas['DEPARTMENT P']] . "'"
            . ",'" . $datos[$columnas['DEPARTMENT CODE P']] . "'"
            . ",'" . $datos[$columnas['LINE (*) P']] . "'"
            . ",'" . $datos[$columnas['SUBLINE P']] . "'"
            . ",'" . $datos[$columnas['SUBLNE CODE P']] . "'"
            . ",'" . $datos[$columnas['HIERARCHI P']] . "'"
            . ",'" . $datos[$columnas['LIFE CICLE P']] . "'"
            . ",'" . $datos[$columnas['PRODUCT SEASON P']] . "'"
            . ",'" . $datos[$columnas['PYRAMID MIX P']] . "'"
            . ",'" . $datos[$columnas['CHANCE OF USER P']] . "'"
            . ",'" . $datos[$columnas['RANKING OF SALE P']] . "'"
            . ",'" . $datos[$columnas['LIFE STYLE P']] . "'"
            . ",'" . $datos[$columnas['RETAIL PRICE P']] . "'"
            . ",'" . $datos[$columnas['PRICE RANGE P']] . "'"
            . ",'" . $datos[$columnas['2 X RETAIL PRICE P']] . "'"
            . ",'" . $datos[$columnas['ANTES/AHORA P']] . "'"
            . ",'" . $datos[$columnas['EVENTO P']] . "'"
            . ",'" . $datos[$columnas['SHIPMENT MODE P']] . "'"
            . ",'" . $datos[$columnas['VENTANA P']] . "'"
            . ",'" . $datos[$columnas['mm/dd1 P']] . "'"
            . ",'" . $datos[$columnas['mm/dd2 P']] . "'"
            . ",'" . $datos[$columnas['mm/dd3 P']] . "'"
            . ",'" . $datos[$columnas['mm/dd4 P']] . "'"
            . ",'" . $datos[$columnas['mm/dd5 P']] . "'"
            . ",'" . $datos[$columnas['mm/dd6 P']] . "'"
            . ",'" . $datos[$columnas['mm/dd7 P']] . "'"
            . ",'" . $datos[$columnas['TOTAL QUANTITY P']] . "'"
            . ",'" . $datos[$columnas['SIZE TYPE P']] . "'"
            . ",'" . $datos[$columnas['SIZE P']] . "'"
            . ",'" . $datos[$columnas['Size %1 P']] . "'"
            . ",'" . $datos[$columnas['Size %2 P']] . "'"
            . ",'" . $datos[$columnas['Size %3 P']] . "'"
            . ",'" . $datos[$columnas['Size %4 P']] . "'"
            . ",'" . $datos[$columnas['Size %5 P']] . "'"
            . ",'" . $datos[$columnas['Size %6 P']] . "'"
            . ",'" . $datos[$columnas['Size %7 P']] . "'"
            . ",'" . $datos[$columnas['Size %8 P']] . "'"
            . ",'" . $datos[$columnas['Size %9 P']] . "'"
            . ",'" . $datos[$columnas['Size %10 P']] . "'"
            . ",'" . $datos[$columnas['Size %11 P']] . "'"
            . ",'" . $datos[$columnas['Size %12 P']] . "'"
            . ",'" . $datos[$columnas['Size %13 P']] . "'"
            . ",'" . $datos[$columnas['Size %14 P']] . "'"
            . ",'" . $datos[$columnas['Size %15 P']] . "'"
            . ",'" . $datos[$columnas['Qty #1 P']] . "'"
            . ",'" . $datos[$columnas['Qty #2 P']] . "'"
            . ",'" . $datos[$columnas['Qty #3 P']] . "'"
            . ",'" . $datos[$columnas['Qty #4 P']] . "'"
            . ",'" . $datos[$columnas['Qty #5 P']] . "'"
            . ",'" . $datos[$columnas['Qty #6 P']] . "'"
            . ",'" . $datos[$columnas['Qty #7 P']] . "'"
            . ",'" . $datos[$columnas['Qty #8 P']] . "'"
            . ",'" . $datos[$columnas['Qty #9 P']] . "'"
            . ",'" . $datos[$columnas['Qty #10 P']] . "'"
            . ",'" . $datos[$columnas['Qty #11 P']] . "'"
            . ",'" . $datos[$columnas['Qty #12 P']] . "'"
            . ",'" . $datos[$columnas['Qty #13 P']] . "'"
            . ",'" . $datos[$columnas['Qty #14 P']] . "'"
            . ",'" . $datos[$columnas['Qty #15 P']] . "'"
            . ",'" . $datos[$columnas['PREPACK P']] . "'"
            . ",'" . $datos[$columnas['HANDLING TYPE P']] . "'"
            . ",'" . $datos[$columnas['SIZE STICKER P']] . "'"
            . ",'" . $datos[$columnas['UNITS PER BOX P']] . "'"
            . ",'" . $datos[$columnas['REORDER P']] . "'"
            . ",'" . $datos[$columnas['COST LAST PURCHASE P']] . "'"
            . ",'" . $datos[$columnas['VENDOR LAST PURCHASE P']] . "'"
            . ",'" . $datos[$columnas['EXTENDED WARRANTY P']] . "'"
            . ",'" . $datos[$columnas['INSPECTION NEEDED P']] . "'"
            . ",'" . $datos[$columnas['INSPECTION COST P']] . "'"
            . ",'" . $datos[$columnas['ROYALTY P']] . "'"
            . ",'" . $datos[$columnas['PERU DUMPING P']] . "'"
            . ",'" . $datos[$columnas['SIZE SAMPLE P']] . "'"
            . "," . $correlativo . ", :error, :data); end;";
        return $sql;
    }
    public static function obtieneMasterPack($temporada, $depto, $linea, $sublinea) {

        $parametros = new parametros();
        $lineas = $parametros->obtieneLineas($depto);
        $cod_linea = array_search($linea, $lineas);

        $sql = "begin PLC_PKG_PRUEBA.PRC_LIST_MASTER_PACK(7, '" . $depto . "','" . $cod_linea . "', '" . $sublinea . "' , :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        $master = array();
        foreach ($data as $val) {
            $master[] = $val[0];
        }
        return $master[0];
    }
    public static function obtieneSegmentosTienda($fila, $depto, $cluster, $marca, $temporada) {

        $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_TDA_SEG(" . $temporada . ", '" . $depto . "','',''," . $cluster . ", " . $marca . " , :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $ventanas = array();
        foreach ($data as $val) {
            $ventanas[] = $val[0];
        }
        return count($ventanas);
    }
    public static function obtieneVentanasEmbarque($temporada) {
        $parametros = new parametros();
        var_dump($parametros->obtieneVentanasEmbarque($temporada));
    }
    public static function InsertHistoricaAssortment($rows,$limite,$nom_columnas,$cod_tempo,$depto,$codMarca,$grupo_compra){
        $_insert = true;
        $sql = "delete PLC_HISTORIAL_ASSORTMENT
                 where cod_temporada = " . $cod_tempo . "
                 and dep_depto =  '" . $depto . "'
                 AND GRUPO_DE_COMPRA = '" . $grupo_compra . "'
                 AND CODIGO_MARCA =  " . $codMarca . "";
        \database::getInstancia()->getConsulta($sql);


        for($i = 3;$i <= $limite; $i++){

            if ($rows[$i][$nom_columnas['Cod Dpto']] == $depto and
                $rows[$i][$nom_columnas['Codigo Marca']] == $codMarca and
                $rows[$i][$nom_columnas['Linea']] <> null  and
                $rows[$i][$nom_columnas['Cod Sublinea']] <> null and
                $rows[$i][$nom_columnas['Cod Color']]<> null){


                $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_HIST_ASSORTMENT" .
                    /*V_COD_TEMPORADA*/          ("(" . $cod_tempo . "" .
                        /*V_DEP_DEPTO*/                 ",'" . $depto . "'" .
                        /*V_DPTO*/                      ",'" . $rows[$i][$nom_columnas['Dpto']] . "'" .
                        /*V_MARCA*/                     ",'" . $rows[$i][$nom_columnas['Marca']] . "'" .
                        /*V_CODIGO_MARCA*/              ","  . $codMarca ."".
                        /*V_SEASON*/                    ",'" . $rows[$i][$nom_columnas['Season']] . "'" .
                        /*V_LINEA*/                     ",'" . $rows[$i][$nom_columnas['Linea']] . "'" .
                        /*V_COD_LINEA*/                 ",'" . $rows[$i][$nom_columnas['Cod Linea']] . "'" .
                        /*V_SUBLINEA*/                  ",'" . $rows[$i][$nom_columnas['Sublinea']] . "'" .
                        /*V_COD_SUBLINEA*/              ",'" . $rows[$i][$nom_columnas['Cod Sublinea']] . "'" .
                        /*V_CODIGO_CORPORATIVO*/        ",'" . $rows[$i][$nom_columnas['Codigo corporativo']] . "'" .
                        /*V_NOMBRE_ESTILO*/             ",'" . $rows[$i][$nom_columnas['Nombre Estilo']] . "'" .
                        /*V_ESTILO_CORTO*/              ",'" . $rows[$i][$nom_columnas['Estilo Corto']] . "'" .
                        /*V_DESCRIPCION_ESTILO*/        ",'" . $rows[$i][$nom_columnas['Descripcion Estilo']] . "'" .
                        /*V_COLOR*/                     ",'" . $rows[$i][$nom_columnas['Color']] . "'" .
                        /*V_COD_COLOR*/                 ","  . $rows[$i][$nom_columnas['Cod Color']] . "" .
                        /*V_EVENTO*/                    ",'" . $rows[$i][$nom_columnas['Evento']] . "'" .
                        /*V_GRUPO_DE_COMPRA*/           ",'" . $rows[$i][$nom_columnas['Grupo de compra']] . "'" .
                        /*V_VENTANA_DEBUT*/             ",'" . $rows[$i][$nom_columnas['Ventana Debut']] . "'" .
                        /*V_TIPO_EXHIBICION*/           ",'" . $rows[$i][$nom_columnas['Tipo exhibicion']] . "'" .
                        /*V_TIPO_PRODUCTO*/             ",'" . $rows[$i][$nom_columnas['Tipo Producto']] . "'" .
                        /*V_DEBUT_O_REORDER*/           ",'" . $rows[$i][$nom_columnas['Debut o Reorder']] . "'" .
                        /*V_TEMPORADA*/                 ",'" . $rows[$i][$nom_columnas['Temporada']] . "'" .
                        /*V_PRECIO*/                    ","  . ($rows[$i][$nom_columnas['Precio']]<> null ? ($rows[$i][$nom_columnas['Precio']]) : 0)  . "" .
                        /*V_RANKING_DE_VENTA*/          ",'" . $rows[$i][$nom_columnas['Ranking de venta']] . "'" .
                        /*V_CICLO_DE_VIDA*/             ",'" . $rows[$i][$nom_columnas['Ciclo de Vida']] . "'" .
                        /*V_PIRAMIDE_MIX*/              ",'" . $rows[$i][$nom_columnas['Piramide Mix']] . "'" .
                        /*V_RATIO_COMPRA*/              ",'" . $rows[$i][$nom_columnas['Ratio compra']] . "'" .
                        /*V_FACTOR_AMPLIFICACION*/      ",'" . $rows[$i][$nom_columnas['Factor amplificacion']] . "'" .
                        /*V_RATIO_COMPRA_FINAL*/        ",'" . $rows[$i][$nom_columnas['Ratio compra final']] . "'" .
                        /*V_CLUSTER_*/                  ",'" . $rows[$i][$nom_columnas['Cluster']] . "'" .
                        /*V_FORMATO*/                   ",'" . $rows[$i][$nom_columnas['Formato']] . "'" .
                        /*V_COMPRA_UNIDADES_ASSORTMENT*/","  . ($rows[$i][$nom_columnas['Compra Unidades Assortment']] <> null ? ($rows[$i][$nom_columnas['Compra Unidades Assortment']]) : 0)  . "" .
                        /*V_COMPRA_UNIDADES_FINAL*/     ","  . ($rows[$i][$nom_columnas['Compra Unidades final']] <> null ? ($rows[$i][$nom_columnas['Compra Unidades final']]) : 0)  . "" .
                        /*V_VAR_PORCE*/                 ",'" . $rows[$i][$nom_columnas['Var%']] . "'" .
                        /*V_TARGET_USD*/                ","  . ($rows[$i][$nom_columnas['Target USD'] ]<> null ? ($rows[$i][$nom_columnas['Target USD']]) : 0)  . "" .
                        /*V_RFID_USD*/                  ","  . ($rows[$i][$nom_columnas['RFID USD'] ]<> null ? ($rows[$i][$nom_columnas['RFID USD']]) : 0)  . "" .
                        /*V_VIA*/                       ",'" . $rows[$i][$nom_columnas['Via']] . "'" .
                        /*V_PAIS*/                      ",'" . $rows[$i][$nom_columnas['Pais']] . "'" .
                        /*V_FACTOR*/                    ","  . ($rows[$i][$nom_columnas['Factor'] ]<> null ? ($rows[$i][$nom_columnas['Factor']]) : 0)  . "" .
                        /*V_COSTO_TOTAL*/               ","  . ($rows[$i][$nom_columnas['Costo Total'] ]<> null ? ($rows[$i][$nom_columnas['Costo Total']]) : 0)  . "" .
                        /*V_RETAIL_TOTAL_SIN_IVA*/      ","  . ($rows[$i][$nom_columnas['Retail Total sin iva'] ]<> null ? ($rows[$i][$nom_columnas['Retail Total sin iva']]) : 0)  . "" .
                        /*V_MUP_COMPRA*/                ",'" . $rows[$i][$nom_columnas['MUP Compra']] . "'" .
                        /*V_EXHIBICION*/                ",'" . $rows[$i][$nom_columnas['Exhibicion']] . "'" .
                        /*V_TALLA1*/                    ",'" . $rows[$i][$nom_columnas['Talla1']] . "'" .
                        /*V_TALLA2*/                    ",'" . $rows[$i][$nom_columnas['Talla2']] . "'" .
                        /*V_TALLA3*/                    ",'" . $rows[$i][$nom_columnas['Talla3']] . "'" .
                        /*V_TALLA4*/                    ",'" . $rows[$i][$nom_columnas['Talla4']] . "'" .
                        /*V_TALLA5*/                    ",'" . $rows[$i][$nom_columnas['Talla5']] . "'" .
                        /*V_TALLA6*/                    ",'" . $rows[$i][$nom_columnas['Talla6']] . "'" .
                        /*V_TALLA7*/                    ",'" . $rows[$i][$nom_columnas['Talla7']] . "'" .
                        /*V_TALLA8*/                    ",'" . $rows[$i][$nom_columnas['Talla8']] . "'" .
                        /*V_TALLA9*/                    ",'" . $rows[$i][$nom_columnas['Talla9']] . "'" .
                        /*V_INNER*/                     ",'" . ($rows[$i][$nom_columnas['Inner'] ]<> null ? ($rows[$i][$nom_columnas['Inner']]) : 0)  . "'" .
                        /*V_CURVA1*/                    ","  . ($rows[$i][$nom_columnas['Curva1'] ]<> null ? ($rows[$i][$nom_columnas['Curva1']]) : 0)  . "" .
                        /*V_CURVA2*/                    ","  . ($rows[$i][$nom_columnas['Curva2'] ]<> null ? ($rows[$i][$nom_columnas['Curva2']]) : 0)  . "" .
                        /*V_CURVA3*/                    ","  . ($rows[$i][$nom_columnas['Curva3'] ]<> null ? ($rows[$i][$nom_columnas['Curva3']]) : 0)  . "" .
                        /*V_CURVA4*/                    ","  . ($rows[$i][$nom_columnas['Curva4'] ]<> null ? ($rows[$i][$nom_columnas['Curva4']]) : 0)  . "" .
                        /*V_CURVA5*/                    ","  . ($rows[$i][$nom_columnas['Curva5'] ]<> null ? ($rows[$i][$nom_columnas['Curva5']]) : 0)  . "" .
                        /*V_CURVA6*/                    ","  . ($rows[$i][$nom_columnas['Curva6'] ]<> null ? ($rows[$i][$nom_columnas['Curva6']]) : 0)  . "" .
                        /*V_CURVA7*/                    ","  . ($rows[$i][$nom_columnas['Curva7'] ]<> null ? ($rows[$i][$nom_columnas['Curva7']]) : 0)  . "" .
                        /*V_CURVA8*/                    ","  . ($rows[$i][$nom_columnas['Curva8'] ]<> null ? ($rows[$i][$nom_columnas['Curva8']]) : 0)  . "" .
                        /*V_CURVA9*/                    ","  . ($rows[$i][$nom_columnas['Curva9'] ]<> null ? ($rows[$i][$nom_columnas['Curva9']]) : 0)  . "" .
                        /*V_Validador_Masterpack_Inner*/",'"  . $rows[$i][$nom_columnas['Validador Masterpack/Inner']]  . "'" .
                        /*V_TIPO_DE_EMPAQUE*/           ",'" . $rows[$i][$nom_columnas['Tipo de empaque']] . "'" .
                        /*V_N_CURVAS_POR_CAJA_CURVADAS*/","  . ($rows[$i][$nom_columnas['N curvas por caja curvadas']]<> null ? ($rows[$i][$nom_columnas['N curvas por caja curvadas']]) : 0)  . "" .
                        /*V_UNO_POR*/                   ",'" . $rows[$i][$nom_columnas['1_%']] . "'" .
                        /*V_DOS_POR*/                   ",'" . $rows[$i][$nom_columnas['2_%']] . "'" .
                        /*V_TRES_POR*/                  ",'" . $rows[$i][$nom_columnas['3_%']] . "'" .
                        /*V_CUATRO_POR*/                ",'" . $rows[$i][$nom_columnas['4_%']] . "'" .
                        /*V_CINCO_POR*/                 ",'" . $rows[$i][$nom_columnas['5_%']] . "'" .
                        /*V_SEIS_POR*/                  ",'" . $rows[$i][$nom_columnas['6_%']] . "'" .
                        /*V_SIETE_POR*/                 ",'" . $rows[$i][$nom_columnas['7_%']] . "'" .
                        /*V_OCHO_POR*/                  ",'" . $rows[$i][$nom_columnas['8_%']] . "'" .
                        /*V_NUEVE_POR*/                 ",'" . $rows[$i][$nom_columnas['9_%']] . "'" .
                        /*V_TIENDASA*/                  ","  . ($rows[$i][$nom_columnas['TiendasA'] ]<> null ? ($rows[$i][$nom_columnas['TiendasA']]) : 0)  . "" .
                        /*V_TIENDASB*/                  ","  . ($rows[$i][$nom_columnas['TiendasB'] ]<> null ? ($rows[$i][$nom_columnas['TiendasB']]) : 0)  . "" .
                        /*V_TIENDASC*/                  ","  . ($rows[$i][$nom_columnas['TiendasC'] ]<> null ? ($rows[$i][$nom_columnas['TiendasC']]) : 0)  . "" .
                        /*V_TIENDASI*/                  ","  . ($rows[$i][$nom_columnas['TiendasI'] ]<> null ? ($rows[$i][$nom_columnas['TiendasI']]) : 0)  . "" .
                        /*V_CLUSTERA*/                  ","  . ($rows[$i][$nom_columnas['ClusterA'] ]<> null ? ($rows[$i][$nom_columnas['ClusterA']]) : 0)  . "" .
                        /*V_CLUSTERB*/                  ","  . ($rows[$i][$nom_columnas['ClusterB'] ]<> null ? ($rows[$i][$nom_columnas['ClusterB']]) : 0)  . "" .
                        /*V_CLUSTERC*/                  ","  . ($rows[$i][$nom_columnas['ClusterC'] ]<> null ? ($rows[$i][$nom_columnas['ClusterC']]) : 0)  . "" .
                        /*V_CLUSTERI*/                  ","  . ($rows[$i][$nom_columnas['ClusterI'] ]<> null ? ($rows[$i][$nom_columnas['ClusterI']]) : 0)  . "" .
                        /*V_Size_1*/                    ",'" . $rows[$i][$nom_columnas['Size%1']] . "'" .
                        /*V_Size_2*/                    ",'" . $rows[$i][$nom_columnas['Size%2']] . "'" .
                        /*V_Size_3*/                    ",'" . $rows[$i][$nom_columnas['Size%3']] . "'" .
                        /*V_Size_4*/                    ",'" . $rows[$i][$nom_columnas['Size%4']] . "'" .
                        /*V_Size_5*/                    ",'" . $rows[$i][$nom_columnas['Size%5']] . "'" .
                        /*V_Size_6*/                    ",'" . $rows[$i][$nom_columnas['Size%6']] . "'" .
                        /*V_Size_7*/                    ",'" . $rows[$i][$nom_columnas['Size%7']] . "'" .
                        /*V_Size_8*/                    ",'" . $rows[$i][$nom_columnas['Size%8']] . "'" .
                        /*V_Size_9*/                    ",'" . $rows[$i][$nom_columnas['Size%9']] . "'" .
                        /*V_VENTA*/                     ","  . ($rows[$i][$nom_columnas['VentA'] ]<> null ? ($rows[$i][$nom_columnas['VentA']]) : 0)  . "" .
                        /*V_VENTB*/                     ","  . ($rows[$i][$nom_columnas['VentB'] ]<> null ? ($rows[$i][$nom_columnas['VentB']]) : 0)  . "" .
                        /*V_VENTC*/                     ","  . ($rows[$i][$nom_columnas['VentC'] ]<> null ? ($rows[$i][$nom_columnas['VentC']]) : 0)  . "" .
                        /*V_VENTD*/                     ","  . ($rows[$i][$nom_columnas['VentD'] ]<> null ? ($rows[$i][$nom_columnas['VentD']]) : 0)  . "" .
                        /*V_VENTE*/                     ","  . ($rows[$i][$nom_columnas['VentE'] ]<> null ? ($rows[$i][$nom_columnas['VentE']]) : 0)  . "" .
                        /*V_VENTF*/                     ","  . ($rows[$i][$nom_columnas['VentF'] ]<> null ? ($rows[$i][$nom_columnas['VentF']]) : 0)  . "" .
                        /*V_VENTG*/                     ","  . ($rows[$i][$nom_columnas['VentG'] ]<> null ? ($rows[$i][$nom_columnas['VentG']]) : 0)  . "" .
                        /*V_VENTH*/                     ","  . ($rows[$i][$nom_columnas['VentH'] ]<> null ? ($rows[$i][$nom_columnas['VentH']]) : 0)  . "" .
                        /*V_VENTI*/                     ","  . ($rows[$i][$nom_columnas['VentI'] ]<> null ? ($rows[$i][$nom_columnas['VentI']]) : 0)  . "" . ", :error, :data); end;");

                $data = \database::getInstancia()->getConsultaSP($sql, 2);

                $_error = explode("#", $data);
                if ($_error[0] == 1 ){
                    $_insert = false;
                    $array = array('Tipo' => FALSE,
                        'Error'=> "Guardado Historico =|".$_error[1]."|");
                    break;
                }
            }
        }

        if ($_insert == false ){
            return $array;
        }else{
            $array = array('Tipo' => TRUE,
                'Error'=> "(".''.") -> ".''."");
        };
        return $array;
    }
    public static function InsertHistoricadelAssorment($cod_tempo,$depto,$codMarca,$grupo_compra){

        $sql = "delete PLC_HISTORIAL_ASSORTMENT
                 where cod_temporada = " . $cod_tempo . "
                 and dep_depto =  '" . $depto . "'
                 AND GRUPO_DE_COMPRA = '" . $grupo_compra . "'
                 AND CODIGO_MARCA =  " . $codMarca . "";
        \database::getInstancia()->getConsulta($sql);


    }
    public static function InsertPlanCompraAssorment($rows,$limite,$nom_columnas,$cod_tempo,$depto,$login,$f3){

        $_insert = true;
        $dtjerarquia = plan_compra::list_jerarquia($depto);
        $dtmarcas = plan_compra::list_Marcas($depto);
        $array=[];
        $maxid = plan_compra::get_maxidplan($cod_tempo,$depto);
        for($i =1 ;$i <= $limite; $i++) {
            $rfid = number_format( $rows[$i][$nom_columnas['RFID USD']], 2, '.', ',');
            $cod_vent =  plan_compra::get_codName($rows[$i][$nom_columnas['Ventana Debut']], plan_compra::list_ventanas($cod_tempo));
            $cod_pais = plan_compra::get_codName($rows[$i][$nom_columnas['Pais']], plan_compra::list_pais());
            $cod_via =plan_compra::get_codName($rows[$i][$nom_columnas['Via']], plan_compra::list_via());
            $tdas = plan_compra::get_N_tdas($depto,$rows[$i][$nom_columnas['Codigo Marca']],$cod_tempo,$rows[$i][$nom_columnas['Cluster']], $rows[$i][$nom_columnas['Formato']]);
            $por_Inicial = plan_compra::get_ComposicionCampos($rows, $nom_columnas, $i, "Size%");
            $curva_reparto = plan_compra::get_ComposicionCampos($rows, $nom_columnas, $i, "Curva");
            $tallas = plan_compra::get_ComposicionCampos($rows, $nom_columnas, $i, "Talla");
            $mstpack = plan_compra::list_mstpack($rows[$i][$nom_columnas['Cod Linea']],$rows[$i][$nom_columnas['Cod Sublinea']],$depto);
            $dtAjustada = plan_compra::AjustesPrimerReparto($por_Inicial
                ,$rows[$i][$nom_columnas['Unidades']]
                ,$curva_reparto
                ,$tallas
                ,$rows[$i]
                ,$nom_columnas
                ,$cod_tempo
                ,$depto
                ,$rows[$i][$nom_columnas['Codigo Marca']]
                ,$rows[$i][$nom_columnas['Debut o Reorder']]
                ,$rows[$i][$nom_columnas['Tipo de empaque']]
                ,$rows[$i][$nom_columnas['N curvas por caja curvadas']]
                ,$rows[$i][$nom_columnas['Formato']]
                ,""
                ,$mstpack
                ,$i);

            $dtdiviporcent = plan_compra::Division_porcent ($dtAjustada[1]);
            $dtdivicantidad = plan_compra::Division_cantidades($dtAjustada[6]);
            $dtclustercurva= plan_compra::curvaportiendas($dtAjustada[7],$rows[$i][$nom_columnas['ClusterA']],$rows[$i][$nom_columnas['ClusterB']],$rows[$i][$nom_columnas['ClusterC']],$rows[$i][$nom_columnas['ClusterI']]);

            $Cos_Total_Target_us = ($rows[$i][$nom_columnas['Target USD']] + $rows[$i][$nom_columnas['RFID USD']]) *  $dtAjustada[3];
            $Cos_Uni_Finl_Pesos = plan_compra::getC_uni_finalbmt($Cos_Total_Target_us,$rows[$i][$nom_columnas['Ventana Debut']],$cod_tempo,$depto,$cod_pais,$cod_via);


            $key = $maxid +$i;
            $sql = "begin PLC_PKG_GENERAL.PRC_ADD_PLAN_COMPRA_COLOR_3" .
                /*V_COD_TEMPORADA*/      ("('" . $cod_tempo . "'" .
                    /*V_DEP_DEPTO*/             ",'" . $depto . "'" .
                    /*V_NIV_JER1*/              ",0" .
                    /*V_COD_JER1*/              ",0" .
                    /*V_NIV_JER2*/              ",0" .
                    /*V_COD_JER2*/              ",'" . $rows[$i][$nom_columnas['Cod Linea']] . "'" .
                    /*V_ITEM*/                  ",0" .
                    /*V_COD_SUBLIN*/            ",'" . $rows[$i][$nom_columnas['Cod Sublinea']] . "'" .
                    /*V_COD_ESTILO*/            ",0" .
                    /*V_EstiloReal*/            ",'" . $rows[$i][$nom_columnas['Nombre Estilo']] . "'" .
                    /*V_COD_COLOR*/             ","  . $rows[$i][$nom_columnas['Cod Color']] . "" .
                    /*V_COD_PIRAMIX*/           ","  . plan_compra::get_codName($rows[$i][$nom_columnas['Piramide Mix']], plan_compra::list_piramidemix($f3)) . "" .
                    /*V_PORCENTAJE*/            ",0" .
                    /*V_UNIDADES*/              ","  . $dtAjustada[3] . "" . /*-Unidades finales-*/
                    /*V_USR_CRE*/               ",'" . $login . "'" .
                    /*V_USR_MOD*/               ",'" . $login . "'" .
                    /*V_SEM_INI*/               ",'" . plan_compra::SemanasIni_Fin('SemIni',$cod_vent,$cod_tempo,'','')  . "'" .
                    /*V_SEM_FIN*/               ",'" . plan_compra::SemanasIni_Fin('SemFin',$cod_vent,$cod_tempo,plan_compra::get_codName($rows[$i][$nom_columnas['Ciclo de Vida']], plan_compra::list_ciclo_vida()),$rows[$i][$nom_columnas['Debut o Reorder']])  . "'" .
                    /*V_CICLO*/                 ",'" . plan_compra::getsemliq_cicloA('CicloA',$rows[$i][$nom_columnas['Ciclo de Vida']],$rows[$i][$nom_columnas['Debut o Reorder']]) . "'" .
                    /*V_TIPO_CURVA*/            ",0" .
                    /*V_NUM_EMB*/               ",'" . $rows[$nom_columnas['Cod Opcion']] . "'" .
                    /*V_EMB_MIN*/               ",0" .
                    /*V_EMB_MAX*/               ",0" .
                    /*V_COB_CALC*/              ",0" .
                    /*V_FLAG_EMB_MANUAL*/       ",0" .
                    /*V_VENT_HAB_INI*/          ",'" . "" . "'" .
                    /*V_VENT_HAB_FIN*/          ",'" . "" . "'" .
                    /*V_COD_RANKVTA*/           ","  . plan_compra::get_codName($rows[$i][$nom_columnas['Ranking de venta']], plan_compra::list_rnk($f3)) . "" .
                    /*V_DSCTO_OBJ*/             ",0" .
                    /*V_DSCTO_PROM*/            ",0" .
                    /*V_STK_MIN*/               ",0" .
                    /*V_SEG_ASIG*/              ",'" . $rows[$i][$nom_columnas['Cluster']] . "'" .
                    /*V_TDAS*/                  ","  . $tdas . "" .
                    /*V_UND_ASIG*/              ",0" .
                    /*V_ROT*/                   ","  . $dtAjustada[5] .""./*%tienda*/
                    /*V_TIPO_CICLO*/            ",0" .
                    /*V_INDICE*/                ",0" .
                    /*V_GM*/                    ","  . round((((($rows[$i][$nom_columnas['Precio']]/1.19)-(plan_compra::getC_uni_final($rows[$i][$nom_columnas['Target USD']],$rfid,$rows[$i][$nom_columnas['Ventana Debut']],$cod_tempo,$depto,$cod_pais,$cod_via)))/($rows[$i][$nom_columnas['Precio']]/1.19))*100),2) ."".
                    /*V_ID*/                    ",0" .
                    /*V_TIPO_DSCTO*/            ",0" .
                    /*V_RATIO*/                 ",0" .
                    /*V_UNDWHITAKER*/           ",0" .
                    /*V_EVENTO*/                ",'" . $rows[$i][$nom_columnas['Evento']] ."'".
                    /*V_GMB*/                   ",0" .
                    /*V_VENT_EMB*/              ","  . $cod_vent . "" .
                    /*V_AGOT_OBJ*/              ",0.7".
                    /*V_SEMLIQ*/                ","  . plan_compra::getsemliq_cicloA('semLiq',$rows[$i][$nom_columnas['Ciclo de Vida']],$rows[$i][$nom_columnas['Debut o Reorder']]) . "" .
                    /*V_COSTO_UNIT*/            ","  .($rows[$i][$nom_columnas['Target USD']] + $rfid).""./*-COSTO UNITARIO FINAL US$-*/
                    /*V_COSTO_UNITH*/           ",0" .
                    /*V_COSTO_TOT*/             ",0" . /*-TOTAL FOB US$-*/
                    /*V_COSTO_TOTH*/            ",0" .
                    /*V_PRECIO_BLANCO*/         ","  . $rows[$i][$nom_columnas['Precio']] . "" .
                    /*V_PRECIO_BLANCOH*/        ",0" .
                    /*V_COSTO_FOB*/             ",0" .
                    /*V_COSTO_INSP*/            ",0" .
                    /*V_COSTO_HANGER*/          ",0" .
                    /*V_COSTO_STICKER*/         ",0" .
                    /*V_DUMPING_POR*/           ",0" .
                    /*V_DUMPING_DOL*/           ",0" .
                    /*V_TRADER_POR*/            ",0" .
                    /*V_TRADER_DOL*/            ",0" .
                    /*V_ROYALTY_POR*/           ",0" .
                    /*V_ROYALTY_DOL*/           ",0" .
                    /*V_COSTO_TARGET*/          ","  . $rows[$i][$nom_columnas['Target USD']] . "" .
                    /*V_ESTADO*/                ",0" .
                    /*V_EQUIV*/                 ",''".
                    /*V_ESTADOCICLO*/           ",0" .
                    /*V_ESTADODIST*/            ",0" .
                    /*V_COSTO_UNITS*/           "," . plan_compra::getC_uni_final($rows[$i][$nom_columnas['Target USD']],$rfid,$rows[$i][$nom_columnas['Ventana Debut']]
                        ,$cod_tempo,$depto,$cod_pais,$cod_via). "" ./*-COSTO UNITARIO FINAL PESOS-*/
                    /*V_COSTO_TOTS*/            ","  . $Cos_Uni_Finl_Pesos."". /*-CALCULO COSTO TOTAL PESOS$-*/
                    /*V_BOLSA*/                 ",0" .
                    /*V_ITEM_REF*/              ",0" .
                    /*V_LIFE_CYCLE*/            ","  . plan_compra::get_codName($rows[$i][$nom_columnas['Ciclo de Vida']], plan_compra::list_ciclo_vida()) . "" .
                    /*V_VENT_REAL*/             ",'" . $rows[$i][$nom_columnas['Ventana Debut']] . "'" .
                    /*V_RETAIL*/                ","  . ROUND((($dtAjustada[3] * $rows[$i][$nom_columnas['Precio']])/1.19)) . "" .  /*-RETAIL-*/
                    /*V_FORMATO*/               ",'" . $rows[$i][$nom_columnas['Formato']] . "'" .
                    /*V_DEBUT_REODER*/          ",'" . $rows[$i][$nom_columnas['Debut o Reorder']] . "'" .
                    /*V_ID_COMPRA*/             ",0" .
                    /*V_TIPO_PRODUCTO*/         ",'" . $rows[$i][$nom_columnas['Tipo Producto']] . "'" .
                    /*V_TIPO_EXHIBICION*/       ",'" . $rows[$i][$nom_columnas['Tipo exhibicion']] . "'" .
                    /*V_ID_CORPORATIVO*/        ",'" . $rows[$i][$nom_columnas['Codigo corporativo']] . "'" .
                    /*V_MTR_PACK*/              ","  . $dtmstpack = plan_compra::get_mst_pack($depto,$rows[$i][$nom_columnas['Cod Linea']],$rows[$i][$nom_columnas['Cod Sublinea']]). "" .
                        /*V_MKUP*/                  ","  . round(($rows[$i][$nom_columnas['Precio']]/1.19)/ (plan_compra::getC_uni_final($rows[$i][$nom_columnas['Target USD']],$rfid,$rows[$i][$nom_columnas['Ventana Debut']],$cod_tempo,$depto,$cod_pais,$cod_via)),2)  . "" .
                        /*V_CODSKUPROVEEDOR*/       ",0" .
                        /*V_GRUPO_COMPRA*/          ",'" . $rows[$i][$nom_columnas['Grupo de compra']] . "'" .
                        /*V_PROFORMA*/              ",0" .
                        /*V_PORTALLAS*/             ",0" .
                        /*V_PROCEDENCIA*/           ",1" .
                        /*V_VIA*/                   ","  . $cod_via . "" .
                        /*V_PAIS*/                  ","  . $cod_pais . "" .
                        /*V_VIAJE*/                 ",0" .
                        /*V_CST_TOTLTARGET*/        ","  . $Cos_Total_Target_us .""./*-COSTO TOTAL TARGET.-*/
                        /*V_CANT_INNER*/            ","  . $dtAjustada[2]. "" ./*-N_CAJAS.-*/
                        /*V_UNID_OPCION_INICIO*/    ","  . $rows[$i][$nom_columnas['Unidades']] . "" .
                        /*V_UND_ASIG_INI*/          ","  . $dtAjustada[4] . "" . /*-Primera_Reparto.-*/
                        /*V_DESTALLA*/              ",'" . $tallas . "'" .
                        /*V_CURVATALLA*/            ",'" . $curva_reparto . "'" .
                        /*V_PORTALLA*/              ",0" .
                        /*V_PORTALLA_1*/            ",'" . $dtAjustada[1]. "'" ./*-Porcentaje Ajustada-*/
                        /*V_CURVAMIN*/              ","  . $rows[$i][$nom_columnas['Inner']] . "" .
                        /*V_DIST*/                  ",0" .
                        /*V_COMPOSICION*/           ",0" .
                        /*V_TEMP*/                  ","  . plan_compra::get_codtemporadaseason($rows, $nom_columnas, $i) . "" .
                        /*V_COLECCION*/             ",0" .
                        /*V_COD_ESTILO_VIDA*/       ",0" .
                        /*V_DESCMODELO*/            ",'" . $rows[$i][$nom_columnas['Descripcion Estilo']] . "'" .
                        /*V_CALIDAD*/               ",0" .
                        /*V_COD_OCASION_USO*/       ",0" .
                        /*V_ALIAS_PROV*/            ",0" .
                        /*V_COD_PROVEEDOR*/         ",0" .
                        /*V_COD_TRADER*/            ",0" .
                        /*V_A*/                     ","  . $dtclustercurva[0]. "" .
                        /*V_B*/                     ","  . $dtclustercurva[1] . "" .
                        /*V_C*/                     ","  . $dtclustercurva[2] . "" .
                        /*V_DIFER_REPARTO*/         ","  . $dtAjustada[5]  . "" ./*-DIFERENCIA-*/
                        /*V_ID_COLOR3*/             ","  . $key . "" .
                        /*V_COD_TIP_MON*/           ","  . 2 . "" .
                        /*V_COD_MARCA*/             ","  . $rows[$i][$nom_columnas['Codigo Marca']] . "" .
                        /*V_FACTOR_EST*/            ",0" .
                        /*V_NOM_GRUPOCOMPRA*/       ",'" . $rows[$i][$nom_columnas['Grupo de compra']] . "'" .
                        /*V_NOM_TEMP*/              ",'" . $rows[$i][$nom_columnas['Temporada']] . "'" .
                        /*V_NOM_LINEA*/             ",'" . plan_compra::get_NomJerarquia($dtjerarquia, $rows, $nom_columnas, $i, 1) . "'" .
                        /*V_NOM_SUBLINEA*/          ",'" . plan_compra::get_NomJerarquia($dtjerarquia, $rows, $nom_columnas, $i, 2) . "'" .
                        /*V_NOM_MARCA*/             ",'" . plan_compra::get_NomMarcas($dtmarcas, $rows, $nom_columnas, $i) . "'" .
                        /*V_NOM_ESTILOVIDA*/        ",''".
                        /*V_NOM_CALIDAD*/           ",''".
                        /*V_NOM_OCACIONUSO*/        ",''".
                        /*V_NOM_PIRAMIDEMIX*/       ",'" . $rows[$i][$nom_columnas['Piramide Mix']] . "'" .
                        /*V_NOM_VENTANA*/           ",'" . $rows[$i][$nom_columnas['Ventana Debut']] . "'" .
                        /*V_NOM_LIFECYCLE*/         ",'" . $rows[$i][$nom_columnas['Ciclo de Vida']] . "'" .
                        /*V_NOM_COLOR*/             ",'" . $rows[$i][$nom_columnas['Color']] . "'" .
                        /*V_NOM_PROCEDENCIA*/       ",'IMP'".
                        /*V_NOM_VIA*/               ",'" . $rows[$i][$nom_columnas['Via']] . "'" .
                        /*V_NOM_PAIS*/              ",'" . $rows[$i][$nom_columnas['Pais']] . "'" .
                        /*V_NOM_MONEDA*/            ",'USD'".
                        /*V_NOM_RAZONSOCIAL*/       ",''".
                        /*V_NOM_TRADER*/            ",''".
                        /*V_NOM_RNK*/               ",'" . $rows[$i][$nom_columnas['Ranking de venta']] . "'" .
                        /*V_TALLA1*/                ",'" . $rows[$i][$nom_columnas['Talla1']] . "'" .
                        /*V_TALLA2*/                ",'" . $rows[$i][$nom_columnas['Talla2']] . "'" .
                        /*V_TALLA3*/                ",'" . $rows[$i][$nom_columnas['Talla3']] . "'" .
                        /*V_TALLA4*/                ",'" . $rows[$i][$nom_columnas['Talla4']] . "'" .
                        /*V_TALLA5*/                ",'" . $rows[$i][$nom_columnas['Talla5']] . "'" .
                        /*V_TALLA6*/                ",'" . $rows[$i][$nom_columnas['Talla6']] . "'" .
                        /*V_TALLA7*/                ",'" . $rows[$i][$nom_columnas['Talla7']] . "'" .
                        /*V_TALLA8*/                ",'" . $rows[$i][$nom_columnas['Talla8']] . "'" .
                        /*V_TALLA9*/                ",'" . $rows[$i][$nom_columnas['Talla9']] . "'" .
                        /*V_TALLA10*/               ",0" .
                        /*V_TALLA11*/               ",0" .
                        /*V_TALLA12*/               ",0" .
                        /*V_TALLA13*/               ",0" .
                        /*V_TALLA14*/               ",0" .
                        /*V_TALLA15*/               ",0" .
                        /*V_CURV1*/                 ","  . ($rows[$i][$nom_columnas['Curva1'] ]<> null ? ($rows[$i][$nom_columnas['Curva1']]) : 0) . "" .
                        /*V_CURV2*/                 ","  . ($rows[$i][$nom_columnas['Curva2']] <> null ? ($rows[$i][$nom_columnas['Curva2']]) : 0) . "" .
                        /*V_CURV3*/                 ","  . ($rows[$i][$nom_columnas['Curva3']] <> null ? ($rows[$i][$nom_columnas['Curva3']]) : 0) . "" .
                        /*V_CURV4*/                 ","  . ($rows[$i][$nom_columnas['Curva4']] <> null ? ($rows[$i][$nom_columnas['Curva4']]) : 0) . "" .
                        /*V_CURV5*/                 ","  . ($rows[$i][$nom_columnas['Curva5']] <> null ? ($rows[$i][$nom_columnas['Curva5']]) : 0) . "" .
                        /*V_CURV6*/                 ","  . ($rows[$i][$nom_columnas['Curva6']] <> null ? ($rows[$i][$nom_columnas['Curva6']]) : 0) . "" .
                        /*V_CURV7*/                 ","  . ($rows[$i][$nom_columnas['Curva7']] <> null ? ($rows[$i][$nom_columnas['Curva7']]) : 0) . "" .
                        /*V_CURV8*/                 ","  . ($rows[$i][$nom_columnas['Curva8']] <> null ? ($rows[$i][$nom_columnas['Curva8']]) : 0) . "" .
                        /*V_CURV9*/                 ","  . ($rows[$i][$nom_columnas['Curva9']] <> null ? ($rows[$i][$nom_columnas['Curva9']]) : 0). "" .
                        /*V_CURV10*/                ",0" .
                        /*V_CURV11*/                ",0" .
                        /*V_CURV12*/                ",0" .
                        /*V_CURV13*/                ",0" .
                        /*V_CURV14*/                ",0" .
                        /*V_CURV15*/                ",0" .
                        /*V_PORCEN_T1*/             ",'"  . $dtdiviporcent[0] . "'" .
                        /*V_PORCEN_T2*/             ",'"  . $dtdiviporcent[1]  . "'" .
                        /*V_PORCEN_T3*/             ",'"  . $dtdiviporcent[2]  . "'" .
                        /*V_PORCEN_T4*/             ",'"  . $dtdiviporcent[3]  . "'" .
                        /*V_PORCEN_T5*/             ",'"  . $dtdiviporcent[4]  . "'" .
                        /*V_PORCEN_T6*/             ",'"  . $dtdiviporcent[5]  . "'" .
                        /*V_PORCEN_T7*/             ",'"  . $dtdiviporcent[6]  . "'" .
                        /*V_PORCEN_T8*/             ",'"  . $dtdiviporcent[7]  . "'" .
                        /*V_PORCEN_T9*/             ",'"  . $dtdiviporcent[8]  . "'" .
                        /*V_PORCEN_T10*/            ",0" .
                        /*V_PORCEN_T11*/            ",0" .
                        /*V_PORCEN_T12*/            ",0" .
                        /*V_PORCEN_T13*/            ",0" .
                        /*V_PORCEN_T14*/            ",0" .
                        /*V_PORCEN_T15*/            ",0" .
                        /*V_CANT_T1*/               ","  . $dtdivicantidad[0]  . "" .
                        /*V_CANT_T2*/               ","  . $dtdivicantidad[1]  . "" .
                        /*V_CANT_T3*/               ","  . $dtdivicantidad[2]  . "" .
                        /*V_CANT_T4*/               ","  . $dtdivicantidad[3]  . "" .
                        /*V_CANT_T5*/               ","  . $dtdivicantidad[4]  . "" .
                        /*V_CANT_T6*/               ","  . $dtdivicantidad[5]  . "" .
                        /*V_CANT_T7*/               ","  . $dtdivicantidad[6]  . "" .
                        /*V_CANT_T8*/               ","  . $dtdivicantidad[7]  . "" .
                        /*V_CANT_T9*/               ","  . $dtdivicantidad[8]  . "" .
                        /*V_CANT_T10*/              ",0" .
                        /*V_CANT_T11*/              ",0" .
                        /*V_CANT_T12*/              ",0" .
                        /*V_CANT_T13*/              ",0" .
                        /*V_CANT_T14*/              ",0" .
                        /*V_CANT_T15*/              ",0" .
                        /*V_PORTALLA_1_INI*/        ",'" . $por_Inicial . "'" .
                        /*V_OPCION_AJUSTADO*/       ","  . $dtAjustada[0] ."".
                        /*V_TIPO_EMPAQUE*/          ",'" . trim(strtoupper($rows[$i][$nom_columnas['Tipo de empaque']])) . "'" .
                        /*V_CURVA_COMPRA*/          ",0" .
                        /*V_I*/                     ","  . $dtclustercurva[3] . "" .
                        /*V_INTERNET_DESCRIPTION*/  ",''".
                        /*V_COSTO_RFID*/            ","  . $rows[$i][$nom_columnas['RFID USD']] . "" .
                        /*V_ERROR_PI*/              ",''".
                        /*V_SHORT_NAME*/            ",'" . $rows[$i][$nom_columnas['Estilo Corto']] . "'".
                        /*V_N_CURVASXCAJAS*/        ","  . $rows[$i][$nom_columnas['N curvas por caja curvadas']] . ", :error, :data); end;");



            $data = \database::getInstancia()->getConsultaSP($sql, 2);

            $_error = explode("#", $data);
            if ($_error[0] == 1 ){
                $_insert = false;
                $array = array('Tipo' => FALSE,
                    'Error'=> "Guardado Plan de Compra =|".$_error[1]."|");
                break;
            }

            $sql = "begin PLC_PKG_UTILS.PRC_ADD_PLAN_COMPRA_COLOR_CIC" .
                /*V_COD_TEMPORADA*/     ("('" . $cod_tempo . "'" .
                    /*V_DEP_DEPTO*/             ",'" . $depto . "'" .
                    /*V_NIV_JER1*/              ",0" .
                    /*V_COD_JER1*/              ",0" .
                    /*V_NIV_JER2*/              ",0" .
                    /*V_COD_JER2*/              ",'" . $rows[$i][$nom_columnas['Cod Linea']] . "'" .
                    /*V_ITEM*/                  ",0" .
                    /*V_COD_SUBLIN*/            ",'" . $rows[$i][$nom_columnas['Cod Sublinea']] . "'" .
                    /*V_COD_ESTILO*/            ",0" .
                    /*V_EstiloReal*/            ",'" . $rows[$i][$nom_columnas['Nombre Estilo']] . "'" .
                    /*V_COD_COLOR*/             ","  . $rows[$i][$nom_columnas['Cod Color']] . "" .
                    /*V_SEMANA*/                ",0" .
                    /*V_POR_AGOT*/              ",0" .
                    /*V_UNID_AGOT*/             ",0" .
                    /*V_USR_CRE*/               ",'" . $login . "'" .
                    /*V_USR_MOD*/               ",'" . $login . "'" .
                    /*V_POR_ROT*/               ",0" .
                    /*V_POR_DSCTO*/             ",0" .
                    /*V_UNID_ROT*/              ",0" .
                    /*V_VTA_SIGV*/              ",0" .
                    /*V_COSTO*/                 ","  . $Cos_Uni_Finl_Pesos."".
                    /*V_VTA_CDSCTO*/            ","  . round((($dtAjustada[3] * $rows[$i][$nom_columnas['Precio']])/1.19),0) . "" .
                    /*V_GM*/                    ","  . round((((($rows[$i][$nom_columnas['Precio']]/1.19)-(plan_compra::getC_uni_final($rows[$i][$nom_columnas['Target USD']],$rfid,$rows[$i][$nom_columnas['Ventana Debut']],$cod_tempo,$depto,$cod_pais,$cod_via)))/($rows[$i][$nom_columnas['Precio']]/1.19))*100),2) ."".
                    /*V_PERIODO*/               ","  . plan_compra::get_codName($rows[$i][$nom_columnas['Ventana Debut']], plan_compra::list_ventanas($cod_tempo)) . "" .
                    /*V_SEM_CORTA*/             ",0" .
                    /*V_ID*/                    ",0" .
                    /*V_ID_COLOR3*/             ","  . $key . ", :error, :data); end;");

            $data = \database::getInstancia()->getConsultaSP($sql, 2);
            $_error = explode("#", $data);
            if ($_error[0] == 1 ){
                $_insert = false;
                $array = array('Tipo' => FALSE,
                    'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                break;
            }

            $sql = "begin PLC_PKG_PRUEBA.PRC_ADD_PLAN_HISTORICO" .
                /*V_TEMP*/         ("('" . $cod_tempo . "'" .
                    /*V_DPTO*/          ",'" . $depto . "'" .
                    /*V_LINEA*/         ",'" . $rows[$i][$nom_columnas['Cod Linea']] . "'" .
                    /*V_SUBLINEA*/      ",'" . $rows[$i][$nom_columnas['Cod Sublinea']] . "'" .
                    /*V_MARCA*/         ","  . $rows[$i][$nom_columnas['Codigo Marca']] . "" .
                    /*V_ESTILO*/        ",'" . $rows[$i][$nom_columnas['Nombre Estilo']] . "'" .
                    /*V_VENTANA*/       ","  . plan_compra::get_codName($rows[$i][$nom_columnas['Ventana Debut']], plan_compra::list_ventanas($cod_tempo)) . "" .
                    /*V_COLOR*/         ","  . $rows[$i][$nom_columnas['Cod Color']] . "" .
                    /*V_USER_LOGIN*/    ",'" . $login . "'" .
                    /*V_PI*/            ",0" .
                    /*V_OC*/            ",0" .
                    /*V_ESTADO*/        ",0" .
                    /*V_ID_COLOR3*/     ","  . $key . "" .
                    /*V_TIPOINSERT*/    ",1" .
                    /*V_NOM_LINEA*/     ",'" . plan_compra::get_NomJerarquia($dtjerarquia, $rows, $nom_columnas, $i, 1) . "'" .
                    /*V_NOM_SUBLINEA*/  ",'" . plan_compra::get_NomJerarquia($dtjerarquia, $rows, $nom_columnas, $i, 2) . "'" .
                    /*V_NOM_MARCA*/     ",'" . plan_compra::get_NomMarcas($dtmarcas, $rows, $nom_columnas, $i) . "'" .
                    /*V_NOM_VENTANA*/   ",'" . $rows[$i][$nom_columnas['Ventana Debut']] . "'" .
                    /*V_NOM_COLOR*/     ",'" . $rows[$i][$nom_columnas['Color']] . "', :error, :data); end;");
            $data = \database::getInstancia()->getConsultaSP($sql, 2);
            $_error = explode("#", $data);
            if ($_error[0] == 1 ){
                $_insert = false;
                $array = array('Tipo' => FALSE,
                    'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                break;
            }

            //Guardado PLC_AJUSTES_COMPRA $dtAjustada
            $_error = plan_compra::SaveAjuste_Compra(/*AJUSTE DE COMPRA*/  $dtAjustada[8]
                /*AJUSTE CURVADO*/   ,$dtAjustada[9]
                /*AJUSTE CUR SOLIDO*/,$dtAjustada[10]
                /*AJUSTE SOLIDO FUL*/,$dtAjustada[11]
                /*AJUSTE REORDER*/   ,$dtAjustada[12]
                /*DEBUT/REORDER*/    ,$rows[$i][$nom_columnas['Debut o Reorder']]
                /*TIPO EMPAQUE*/     ,trim(strtoupper($rows[$i][$nom_columnas['Tipo de empaque']]))
                /*ID_COLOR3*/        ,$key
                /*Tallas*/           ,$tallas
                /*TEMPO*/            ,$cod_tempo
                /*DEPTO*/            ,$depto);
            if (count($_error) == 1 ){
                $_insert = false;
                $array = array('Tipo' =>$_error["Tipo"],
                    'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error["Error"]."|");
                break;
            }


        }//exit for
        if ($_insert == false ){
            return $array;

        }else{
            $array = array('Tipo' => TRUE,
                'Error'=> "(".''.") -> ".''."");
        };
        return $array;
    }
    public static function insertaBmpHistorica($datos) {

        foreach ($datos as $val) {

            $data = \database::getInstancia()->getConsultaSP($val, 2);
        }
    }
    public static function DeleteRowsPlan($cod_tempo,$depto,$marca,$gcompra){
        $array=[];


        try {
            $sql = "select id_color3"
                . " from plc_plan_compra_color_3"
                . " where cod_temporada = " . $cod_tempo . ""
                . " and dep_depto = '" . $depto . "' and cod_marca = " . $marca . ""
                . " and estado = 0 and grupo_compra = '" . $gcompra . "'";

            $data = \database::getInstancia()->getFilas($sql);

            $id_color3 = "";
            if (count($data) > 0) {
                foreach ($data as $var2) {
                    $id_color3 = $id_color3 . $var2["ID_COLOR3"] . ",";
                }
                $id_color3 = substr($id_color3, 0, -1);
                $sql = "delete plc_plan_compra_color_3"
                    . " where cod_temporada = " . $cod_tempo . ""
                    . " and dep_depto = '" . $depto . "'"
                    . " and id_color3 in (" . $id_color3 . ")";

                \database::getInstancia()->getConsulta($sql);

                $sql = "delete plc_plan_compra_color_cic"
                    . " where cod_temporada = " . $cod_tempo . ""
                    . " and dep_depto = '" . $depto . "'"
                    . " and id_color3 in (" . $id_color3 . ")";
                \database::getInstancia()->getConsulta($sql);

                $sql = "delete plc_plan_compra_historica"
                    . " where temp = " . $cod_tempo . ""
                    . " and dpto = '" . $depto . "'"
                    . " and estado = 0 "
                    . " and id_color3 in (" . $id_color3 . ")";
                \database::getInstancia()->getConsulta($sql);

                $sql = "delete plc_plan_compra_oc"
                    . " where cod_temporada = " . $cod_tempo . ""
                    . " and dep_depto = '" . $depto . "'"
                    . " and id_color3 in (" . $id_color3 . ")";
                \database::getInstancia()->getConsulta($sql);

                $sql = "delete PLC_AJUSTES_COMPRA"
                    . " where cod_temporada = " . $cod_tempo . ""
                    . " and dep_depto = '" . $depto . "'"
                    . " and id_color3 in (" . $id_color3 . ")";
                \database::getInstancia()->getConsulta($sql);
            }
            $array = array('Tipo' => true,
                'Error'=> '');
        }catch (Exception $e) {
            $array = array('Tipo' => false,
                'Error'=> $e->getMessage());
        }
        return $array;

    }
    public static function list_codMarca($depto){

        $sql = "begin PLC_PKG_PRUEBA.PRC_LISTAR_DEPTO_MARCA('" . $depto . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        $master = array();
        foreach ($data as $val) {
            $master[] = $val[0];
        }
        return $master;
    }
    public static function list_Marcas($depto){

        $sql = "SELECT DISTINCT COD_MARCA CODIGO, NOM_MARCA DESCRIPCION"
            . " FROM PLC_DEPTO_MARCA"
            . " WHERE COD_DEPT = '" . $depto . "'";
        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }
    public static function list_jerarquia($depto){

        /*$sql= "SELECT TRIM(P.PRD_LVL_NUMBER) LIN_LINEA ,P.PRD_NAME_FULL LIN_DESCRIPCION,TRIM( L.PRD_LVL_NUMBER ) AS SLI_SUBLINEA,TRIM( L.PRD_NAME_FULL ) AS SLI_DESCRIPCION"
            . " FROM   PRDMSTEE P,PRDMSTEE  L"
            . " WHERE  P.PRD_LVL_NUMBER IN (SELECT RPAD( TRIM( L.PRD_LVL_NUMBER ), 15, ' ' ) AS LIN_LINEA"
            . "                             FROM   PRDMSTEE P,PRDMSTEE L"
            . "                             WHERE  P.PRD_LVL_NUMBER = RPAD( '" . $depto . "', 15, ' ' )"
            . " AND    P.PRD_LVL_CHILD  = L.PRD_LVL_PARENT"
            . " AND    L.PRD_STATUS = 0)"
            . " AND    P.PRD_LVL_CHILD  = L.PRD_LVL_PARENT"
            . " AND    L.PRD_STATUS = 0"
            . " ORDER BY 1 ASC";*/

        /* $sql="select LIN_LINEA,LIN_DESCRIPCION,SLI_SUBLINEA,SLI_DESCRIPCION
               from PLC_VIEW_JERARQUIA
               where DEP_DEPTO = '" . $depto . "'";

         $dtLinea = \database::getInstancia()->getFilas($sql);
         return $dtLinea;*/


        $sql="select LIN_LINEA,LIN_DESCRIPCION,SLI_SUBLINEA,SLI_DESCRIPCION 
              from PLC_JERARQUIA_COMERCIAL
              where DEP_DEPTO = '" . $depto . "'";

        $dtLinea = \database::getInstancia()->getFilas($sql);
        return $dtLinea;

    }
    public static function list_colores(){
        $sql = "SELECT trim(t.codigo) AS COD_COLOR,INITCAP( t.descripcion)  AS NOM_COLOR"
            . " FROM PLC_MAEDIM T"
            . " WHERE T.TIPO='C'";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_tipoProducto(){

        $sql= "select ID_TIPOPRODUC,NOM_TIPOPRODUC"
            ." from plc_tipoproducto";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }
    public static function list_tipoexhibicion(){

        $sql= "select ID_EXHIBICION,NOM_EXHIBICION"
            ." from plc_tipoexhibicion";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }
    public static function list_ciclo_vida(){
        $sql = "SELECT C.ATR_COD_TECH_KEY AS CODIGO,UPPER(C.ATR_CODE_DESC)  DESCRIPCION"
            ." FROM   BASACDEE C"
            ." WHERE  C.ATR_HDR_TECH_KEY = 47"
            ." AND  atr_code not in ('12 MESES','1 MES','6 MESES','3 MESES')"
            ." ORDER BY C.ATR_CODE_DESC";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_rnk($f3)
    {

        //275 proc
        //307 qa
        $coneccion = $f3->get('SESSION.BD_control_conexion');
        $cod = 0;
        if ($coneccion == "QA" or $coneccion == "QACLOUD" ){
            $cod = 307;
        }else{
            $cod = 275;
        }
        $sql = "SELECT C.ATR_COD_TECH_KEY AS CODIGO,UPPER(C.ATR_CODE_DESC)  DESCRIPCION"
            ." FROM   BASACDEE C"
            ." WHERE  C.ATR_HDR_TECH_KEY = ".$cod
            ." AND  atr_code not in ('12 MESES','1 MES','6 MESES','3 MESES')"
            ." ORDER BY C.ATR_CODE_DESC";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_piramidemix($f3){
        //274 proc
        //306 qa
        $coneccion = $f3->get('SESSION.BD_control_conexion');
        $cod = 0;
        if ($coneccion == "QA" or $coneccion == "QACLOUD" ){
            $cod = 306;
        }else{
            $cod = 274;
        }
        $sql = "SELECT C.ATR_COD_TECH_KEY AS CODIGO,UPPER(C.ATR_CODE_DESC)  DESCRIPCION"
            ." FROM   BASACDEE C"
            ." WHERE  C.ATR_HDR_TECH_KEY = ".$cod
            ." AND atr_code not in ('12 MESES','1 MES','6 MESES','3 MESES')"
            ." AND C.ATR_COD_TECH_KEY not in (85182,85183,85741,85184)"
            ." ORDER BY C.ATR_CODE_DESC";
        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }
    public static function list_cluster($temporada,$depto){
        $sql = "SELECT DISTINCT COD_SEG as CODIGO,case when DES_SEG = 'A' then 'A'"
            ."                     when DES_SEG = 'B' then 'A+B'"
            ."                     when DES_SEG = 'C' then 'A+B+C'"
            ."                     when DES_SEG = 'I' then 'A+I' END  DESCRIPCION"
            ." FROM   PLC_SEGMENTOS"
            ." WHERE  COD_TEMPORADA = ".$temporada.""
            ." AND    DEP_DEPTO     = '".$depto."'"
            ." UNION SELECT 5 COD_SEG,'A+B+I' FROM DUAL"
            ." UNION SELECT 6 COD_SEG,'A+B+C+I' FROM DUAL";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_Formato($temporada,$depto){
        $sql = "SELECT COD_SEG CODIGO, DES_SEG DESCRIPCION"
            ." FROM PLC_FORMATO"
            ." WHERE COD_TEMPORADA =".$temporada.""
            ." AND DEP_DEPTO ='".$depto."'"
            ." ORDER BY COD_SEG";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_via(){
        $sql = "SELECT COD_VIA CODIGO, NOM_VIA DESCRIPCION"
            ." FROM PLC_VIA";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }
    public static function list_pais(){
        $sql = "SELECT P.CNTRY_LVL_CHILD CODIGO"
            ." ,CASE WHEN P.CNTRY_NAME = 'Espa?a' THEN"
            ."  'España' else P.CNTRY_NAME end DESCRIPCION"
            ."  FROM PLC_PAIS P"
            ."  WHERE P.CNTRY_LVL_CHILD <> 2"
            ."  ORDER BY 1";
        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }
    public static function list_ventanas($cod_temporada){

        $sql = "SELECT  B.COD_VENTANA CODIGO"
            ." ,B.VENT_DESCRI DESCRIPCION"
            ." FROM PLC_VENTANA_EMB A,PLC_VENTANA B WHERE A.COD_VENTANA = B.COD_VENTANA"
            ." AND COD_TEMPORADA = ".$cod_temporada.""
            ." order by B.VENT_DESCRI";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function lis_factor($cod_temporada,$depto,$pais,$via,$moneda,$ventana){

        $sql=  "SELECT ".$ventana." FROM   PLC_FACTOR_EST    F
                WHERE  F.COD_TEMPORADA   = ".$cod_temporada."
                AND    F.DEP_DEPTO       = '".$depto."'
                AND    F.CNTRY_LVL_CHILD = ".$pais."
                AND    F.COD_VIA         = ".$via."
                AND    F.COD_TIP_MON     = ".$moneda."";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function lis_moneda($cod_temporada,$moneda,$ventana){

        $sql=  "SELECT  ".$ventana."
                FROM   PLC_TIPO_CAMBIO P
                WHERE  P.COD_TEMPORADA = ".$cod_temporada."
                AND    P.COD_TIP_MON=".$moneda."";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    Public static function lis_tipo_cambio($cod_temporada,$depto,$moneda,$ventana){

        $sql=  "SELECT ".$ventana." FROM   PLC_TIPO_CAMBIO    F
                WHERE  F.COD_TEMPORADA   = ".$cod_temporada."
                AND    F.COD_TIP_MON     = ".$moneda."";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_semanaInicio($codventana, $temporada){
        $sql=  "SELECT SEMANA  SEMANA_TDA ".
            " FROM   PLC_VENTANA_EMB E
                INNER JOIN PLC_VENTANA V ON E.COD_VENTANA = V.COD_VENTANA
                INNER JOIN GST_CALENDARIO C ON E.FECHA_TDA = C.FECHA
                WHERE E.COD_TEMPORADA = ".$temporada." 
                AND V.COD_VENTANA  = ".$codventana."";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_semanaFin($semana_ini,$codciclo_vida){

        $sql=  "SELECT A.SEMANA SEMANA_TDA
                FROM GST_CALENDARIO A,
                (SELECT DIAS FROM PLC_CICLO_VIDA WHERE CODIGO = ".$codciclo_vida.") B
                WHERE FECHA = TO_DATE((SELECT TO_CHAR((MAX(FECHA))+B.DIAS, 'DD-mm-YYYY') FECHA
                                        FROM GST_CALENDARIO WHERE TO_CHAR(SEMANA)= '".$semana_ini."'),'DD/MM/YYYY')";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    Public static function list_tdas_sin_formato($depto,$marca,$temporada,$cluster){

        $array_cluster = explode("+",$cluster);
        $cluster2= "";
        if($cluster <> ""){
            foreach ($array_cluster as $var)  {
                $cluster2 = $cluster2 ."'".$var."'".",";
            }
            $cluster2 = substr($cluster2, 0, -1);
        }

        $sql= "SELECT  COUNT(1) TIENDAS
               FROM PLC_SEGMENTOS          A
               INNER JOIN PLC_SEGMENTOS_TDA B  ON  A.COD_TEMPORADA = B.COD_TEMPORADA
                                               AND A.DEP_DEPTO     = B.DEP_DEPTO
                                               AND A.COD_SEG       = B.COD_SEG
               INNER JOIN  GST_MAESUCURS     C  ON  B.COD_TDA        = C.SUC_SUCURSAL
               WHERE A.COD_TEMPORADA = ".$temporada." 
               AND A.DEP_DEPTO = '".$depto."'
               AND B.COD_MARCA = '".$marca."'
               AND A.DES_SEG IN(".$cluster2.")";

        $data = \database::getInstancia()->getFila($sql);

        return $data;
    }
    Public static function list_tdas_con_formato($depto,$marca,$temporada,$cluster,$formato){
        $array_cluster = explode("+",$cluster);
        $cluster2= "";
        if($cluster <> ""){
            foreach ($array_cluster as $var)  {
                $cluster2 = $cluster2 ."'".$var."'".",";
            }
            $cluster2 = substr($cluster2, 0, -1);
        }

        $sql ="SELECT COUNT(1) TIENDAS
                FROM PLC_SEGMENTOS A
                INNER JOIN PLC_SEGMENTOS_TDA B  ON  A.COD_TEMPORADA = B.COD_TEMPORADA AND A.DEP_DEPTO = B.DEP_DEPTO AND A.COD_SEG = B.COD_SEG
                INNER JOIN  GST_MAESUCURS    C  ON  B.COD_TDA = C.SUC_SUCURSAL
                LEFT  JOIN  PLC_FORMATOS_TDA D  ON  A.COD_TEMPORADA = D.COD_TEMPORADA AND A.DEP_DEPTO = D.DEP_DEPTO AND B.COD_TDA = D.COD_TDA
                LEFT JOIN  PLC_FORMATO       E  ON  A.COD_TEMPORADA = E.COD_TEMPORADA AND A.DEP_DEPTO = E.DEP_DEPTO AND D.COD_SEG = E.COD_SEG
                WHERE A.COD_TEMPORADA = ".$temporada." AND A.DEP_DEPTO ='".$depto."' AND E.DES_SEG= '".$formato."' AND B.COD_MARCA = '".$marca."' 
                AND A.DES_SEG IN(".$cluster2.")";
        $data = \database::getInstancia()->getFila($sql);

        return $data;
    }



    Public static function list_inter_tds_cluster($depto,$marca,$temporada,$cluster,$formato){

        $array_cluster = explode("+",$cluster);
        $cluster2= "";
        if($cluster <> ""){
            foreach ($array_cluster as $var)  {
                $cluster2 = $cluster2 ."'".$var."'".",";
            }
            $cluster2 = substr($cluster2, 0, -1);
        }

        if ($cluster <> "" and $cluster <> "0" and  ($formato <> "SIN FORMATO" AND $formato <> "" ) ){
            $sql ="SELECT DISTINCT A.DES_SEG
                FROM PLC_SEGMENTOS A
                INNER JOIN PLC_SEGMENTOS_TDA B  ON  A.COD_TEMPORADA = B.COD_TEMPORADA AND A.DEP_DEPTO = B.DEP_DEPTO AND A.COD_SEG = B.COD_SEG
                INNER JOIN  GST_MAESUCURS    C  ON  B.COD_TDA = C.SUC_SUCURSAL
                LEFT  JOIN  PLC_FORMATOS_TDA D  ON  A.COD_TEMPORADA = D.COD_TEMPORADA AND A.DEP_DEPTO = D.DEP_DEPTO AND B.COD_TDA = D.COD_TDA
                LEFT JOIN  PLC_FORMATO       E  ON  A.COD_TEMPORADA = E.COD_TEMPORADA AND A.DEP_DEPTO = E.DEP_DEPTO AND D.COD_SEG = E.COD_SEG
                WHERE A.COD_TEMPORADA = ".$temporada." AND A.DEP_DEPTO ='".$depto."' AND E.DES_SEG= '".$formato."' AND B.COD_MARCA = '".$marca."' 
                AND A.DES_SEG IN(".$cluster2.")";
        }ELSE {
            $sql= "SELECT  DISTINCT DES_SEG
               FROM PLC_SEGMENTOS          A
               INNER JOIN PLC_SEGMENTOS_TDA B  ON  A.COD_TEMPORADA = B.COD_TEMPORADA
                                               AND A.DEP_DEPTO     = B.DEP_DEPTO
                                               AND A.COD_SEG       = B.COD_SEG
               INNER JOIN  GST_MAESUCURS     C  ON  B.COD_TDA        = C.SUC_SUCURSAL
               WHERE A.COD_TEMPORADA = ".$temporada." 
               AND A.DEP_DEPTO = '".$depto."'
               AND B.COD_MARCA = '".$marca."'
               AND A.DES_SEG IN(".$cluster2.")";
        }
        $data = \database::getInstancia()->getFilas($sql);


        $cluster2 = "";
        if(count($data) <> 0 ){
            foreach ($data as $var){
                $cluster2 = $cluster2 .$var["DES_SEG"]."+" ;
            }
            $cluster2 = substr($cluster2, 0, -1);
        }


        return $cluster2;


    }
    Public static function list_mstpack ($linea,$sublinea,$depto){

        $sql = "SELECT MSTPACK FROM PLC_MSTPACK
                WHERE COD_DEPTO = '".$depto."'
                AND COD_LIN =  '".$linea."'
                AND COD_SUBLIN = '".$sublinea."'";
        $data = \database::getInstancia()->getFila($sql);
        return $data;
    }
    public static function get_mst_pack($depto,$linea,$sublinea){

        $sql = "select MSTPACK from plc_mstpack"
            ." where cod_lin = '".$linea."'"
            ." and cod_sublin = '".$sublinea."'"
            ." and cod_depto = '".$depto."'";


        $data = \database::getInstancia()->getFila($sql);

        if (count($data)> 0){
            $data = $data[0];
        }

        return $data;
    }
    public static function get_codName($Nombre,$data){
        $codigo = 0;
        $key = 0;
        foreach ($data as $var)  {
            if (strtoupper($data[$key]['DESCRIPCION']) == strtoupper($Nombre)) {
                $codigo = $data[$key]['CODIGO'];
                break;
            }
            $key++;
        }

        return $codigo;
    }
    public static function get_ComposicionCampos($rows,$nom_columnas,$i,$tipo){

        $composion = "";
        for($x = 1;$x <= 9; $x++){
            $column = $tipo.$x;
            if ($rows[$i][$nom_columnas[$column]] <> "" and
                $rows[$i][$nom_columnas[$column]] <> "0" and
                $rows[$i][$nom_columnas[$column]] <> " " and
                $rows[$i][$nom_columnas[$column]] <> null and
                $rows[$i][$nom_columnas[$column]] <> "0%" ){
                if ($tipo == "Size%"){
                    $composion = $composion. (round($rows[$i][$nom_columnas[$column]],5) * 100) ."-";

                }elseif ($tipo == "Size %"){
                    $composion = $composion. (round($rows[$i][$nom_columnas[$column]],5)) ."-";
                }else {
                    $composion = $composion . $rows[$i][$nom_columnas[$column]] . ",";
                }
            }
        }

        if ((strlen($composion)) > 0){
            $composion = substr($composion, 0, - 1);
        }

        return $composion;
    }
    public static function get_codtemporadaseason($rows,$nom_columnas,$i){
        $cod = 0;
        if($rows[$i][$nom_columnas["Temporada"]] == "CL - INVIERNO" or
            $rows[$i][$nom_columnas["Temporada"]] == "CL - OTOÑO" ){
            $cod = 1;
        }elseif ($rows[$i][$nom_columnas["Temporada"]] == "CL - PRIMAVERA" or
            $rows[$i][$nom_columnas["Temporada"]] == "CL - VERANO"){
            $cod = 2;
        }elseif ($rows[$i][$nom_columnas["Temporada"]] == "CL - TODA TEMPORADA") {
            $cod = 3;
        }
        return $cod;
    }
    public static function get_NomJerarquia($dtjerarquia,$rows,$nom_columnas,$i,$tipo){

        if($tipo==1){
            $camposPMM = "LIN_LINEA";
            $camposAsort = "Cod Linea";
            $camposdescrip = "LIN_DESCRIPCION";
        }else{
            $camposPMM = "SLI_SUBLINEA";
            $camposAsort = "Cod Sublinea";
            $camposdescrip = "SLI_DESCRIPCION";
        }

        $nombre = "";
        $key3 = 0;
        foreach ($dtjerarquia as $var  ){
            if ($dtjerarquia[$key3][$camposPMM] == $rows[$i][$nom_columnas[$camposAsort]]) {
                $nombre = $dtjerarquia[$key3][$camposdescrip];
                break;
            }
            $key3++;
        }

        return $nombre;

    }
    public static function get_NomMarcas($dtmarcas,$rows,$nom_columnas,$i){
        $nombre = "";
        $key3 = 0;
        foreach ($dtmarcas as $var  ){
            if ($dtmarcas[$key3]["CODIGO"] == $rows[$i][$nom_columnas["Codigo Marca"]]) {
                $nombre = $dtmarcas[$key3]["DESCRIPCION"];
                break;
            }
            $key3++;
        }

        return $nombre;
    }
    public static function get_maxidplan($temporada,$depto){
        $count = 0;
        $sql = "select max(id_color3)Codigo"
            ." from plc_plan_compra_color_3"
            ." where cod_temporada = ".$temporada.""
            ." and dep_Depto = '".$depto."'";

        $data = \database::getInstancia()->getFila($sql);

        if ($data{0}>0){
            $count = $data{0};
        }
        return $count;

    }
    public static function getC_uni_final($target,$rfid,$ventana,$cod_temporada,$depto,$pais,$via){
        $costo = 0;
        $factor =  plan_compra::lis_factor($cod_temporada,$depto,$pais,$via,2,$ventana);
        if (count($factor) <> 0 ){
            $costo = round(($target+$rfid) * $factor[0][0]);
        }else{
            $tc = plan_compra::lis_tipo_cambio($cod_temporada,$depto,2,$ventana);
            if(count($tc)<> 0){
                $costo = round(($target+$rfid) * $tc[0][0]);
            }
        }

        return $costo;
    }
    public static function getsemliq_cicloA($tipo,$ciclo_vida,$debut){
        $semLiq = "0";
        $CicloA = "0";
        IF(strtoupper($ciclo_vida) == 'LONG TERM' and $debut == 'DEBUT' ){
            $semLiq = 6;
            $CicloA = 19;
        }ELSEIF(strtoupper($ciclo_vida) == 'MID TERM'and $debut == 'DEBUT') {
            $semLiq = 4;
            $CicloA = 13;
        }ELSEIF(strtoupper($ciclo_vida) == 'SHORT TERM' and $debut == 'DEBUT') {
            $semLiq = 3;
            $CicloA = 9;
        }
        if ($tipo== 'semLiq'){
            return $semLiq;
        }else {
            return $CicloA;
        }

    }
    public static function SemanasIni_Fin($tipo,$codventana,$temporada,$codciclovida,$debut){
        $val = "";

        if ($tipo =="SemIni"){
            $val = plan_compra::list_semanaInicio($codventana,$temporada);
            if (count($val)<> 0){
                $val = $val[0]["SEMANA_TDA"];
            }else {$val = "";};
        }elseif($debut == 'DEBUT'){
            $val = plan_compra::list_semanaInicio($codventana,$temporada);
            if (count($val)<> 0){
                $val = $val[0]["SEMANA_TDA"];
            }else {$val = "";};
            $val = plan_compra::list_semanaFin($val,$codciclovida);
            if (count($val)<> 0){
                $val = $val[0]["SEMANA_TDA"];
            }else {$val = "";};
        }

        return $val;

    }
    public static function get_N_tdas($depto,$marca,$cod_Tempo,$cluster,$formato){
        $tdas = 0;
        if ($formato == ""){
            $formato = 'SIN FORMATO';
        }

        IF (($formato == 'SIN FORMATO')and $cluster <> "" and $cluster <> null ) {
            $tdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_Tempo, $cluster);
            if(count($tdas) <> 0){
                $tdas = $tdas["TIENDAS"];
            }
        }elseif(($formato <> "" or $formato <> null or $formato <> 'SIN FORMATO')and $cluster <> "" and $cluster <> null) {
            $tdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_Tempo, $cluster,$formato);
            if(count($tdas) <> 0){
                $tdas = $tdas["TIENDAS"];
            }
        }
        return $tdas;
    }
    public static function Division_porcent($Porcent){

        $dtcolumnas = [];
        $dtporcent = explode("-",$Porcent);
        foreach ($dtporcent as $val){
            // array_push($dtcolumnas,($val."%"));
            array_push($dtcolumnas,(str_replace(".", ",",($val."%"))));
            // array_push($dtcolumnas,($val/100));
        }
        $count = 9 - count($dtporcent) ;
        if ($count <> 0 ) {
            for ($i = 1; $i <= $count; $i++) {
                array_push($dtcolumnas, ("0%"));
            }
        }
        return $dtcolumnas;

    }
    public static function AjustesPrimerReparto($por_Inicial,$unid_ini,$curva_reparto,$tallas,$rows,$nom_columnas,$cod_tempo,$depto,$marca,$DEBUT,$tipo_empaque,$N_CURVAS_CAJAS,$formato,$dtplanCompra,$mstpack,$id_for){

        /*******************AJUSTE CUERVA DE COMPRA*********************/
        $mstpack = $mstpack["MSTPACK"];
        $dtTabla = []; $dtTablaCurvado = [];$dtTablasSolidoCurvado = [];$dtTablasolidoFULL = [];$dtTablaReorder =[];
        $unid_ajustas = 0;$unid_final = 0;$porcentajeAjust = "";$n_cajasfinales = 0;$totalprimerRepato = 0;$unid_ajustasxtallas = "";
        $N_Columna = count(explode(",", trim($tallas)));
        //*-----------------tallas columnas
        $tallas2 = explode(",", trim($tallas));
        $insert = [];
        foreach ($tallas2 as $var) {
            array_push($insert, $var);
        }
        array_push($insert, "Total");
        array_push($dtTabla, $insert);

        $clusters3 = "";
        /*DEBUT*/IF ($DEBUT == "DEBUT") {
            //*-----------------curva de compra
            $insert = [];$por_Inicial = explode("-", trim($por_Inicial));$total = 0;
            foreach ($por_Inicial as $var) {
                $total += round((($var * $unid_ini) / 100));
                array_push($insert, round((($var * $unid_ini) / 100)));
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------Curva del Primer Reparto
            $insert = [];$curvas = explode(",", trim($curva_reparto));$total = 0;
            $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $rows[$nom_columnas['Cluster']], $formato));
            foreach ($curvas as $var) {
                $primer = 0;
                foreach ($clusters as $varc) {
                    $ntdas = 0;
                    if ($formato == "" OR $formato == "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                    } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                    }
                    $primer += $var * $rows[$nom_columnas['Cluster' . $varc]] * $ntdas["TIENDAS"];
                }
                $total += $primer;
                array_push($insert, $primer);
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------diferencial
            $key = 0;$insert = [];$total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                if ($dtTabla[1][$key] < $dtTabla[2][$key]) {
                    $val = $dtTabla[1][$key] - $dtTabla[2][$key];
                }
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------Total
            $key = 0;$insert = [];$total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                if ($dtTabla[3][$key] <> 0) {
                    $val = $dtTabla[2][$key];
                } else {
                    $val = $dtTabla[1][$key];
                }
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------CURVA DE COMPRA Ajustada
            $key = 0;$insert = [];$total = "";
            $TotalAjust = $dtTabla[4][$N_Columna];
            foreach ($tallas2 as $var) {
                $val = 0;
                $val = (round((($dtTabla[4][$key] / $TotalAjust) * 100), 5));
                if (strlen($val) > 6) {
                    $val = round($val, 3);
                }
                $total = $total . $val . "-";
                array_push($insert, $val);
                $key += 1;

            }
            $total = substr($total, 0, -1);
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            /*%*/$unid_ajustas = $dtTabla[4][$N_Columna];

            /*CURVADO*/ if ($tipo_empaque == "Curvado" or $tipo_empaque == "CURVADO") {
                //*****************1.-AJUSTE DE CAJAS CURVADOS
                array_push($dtTablaCurvado, $dtTabla[0]);//CABECERA
                array_push($dtTablaCurvado, $dtTabla[4]);//TOTAL AJUSTE COMPRA
                //*-----------------Curva del Primer Reparto
                $insert = [];$total = 0;
                $curvas = explode(",", trim($curva_reparto));
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $rows[$nom_columnas['Cluster']], $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $ntdas = 0;
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($rows[$nom_columnas[0]["Formato"]] <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }
                        $primer += $var * $rows[$nom_columnas["Cluster" . $varc]] * $ntdas["TIENDAS"];
                    }
                    $total += $primer;
                    array_push($insert, $primer);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);

                //*-----------------Curvas de repartos EJ: 1,2,3,4
                $insert = [];$total = 0;
                foreach ($curvas as $var) {
                    $total += $var;
                    array_push($insert, $var);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);

                //Curva minima * n° de curva/caja
                //$masterCurvado = $dtTablaCurvado [3][$N_Columna] * $N_CURVAS_CAJAS;
                $insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $dtTablaCurvado [3][$N_Columna] * $N_CURVAS_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //total 1er repato / inner(curva min)
                $Curva_repartir = $dtTablaCurvado [2][$N_Columna] / $dtTablaCurvado[3][$N_Columna];$insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $Curva_repartir);
                array_push($dtTablaCurvado, $insert);

                //Curva a repartir / n de curva cajas
                $n_CAJAS = $Curva_repartir / $N_CURVAS_CAJAS;$insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $n_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //N° de curvas caja
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $rows[$nom_columnas['N curvas por caja curvadas']]);
                array_push($dtTablaCurvado, $insert);

                //*-------------porcenjas compra curvada
                $key2 = 0;
                foreach ($tallas2 as $vart) {
                    if ($dtTablaCurvado [2][$key2] <> 0) {
                        $porcentajeAjust = $porcentajeAjust . (round(($dtTablaCurvado[2][$key2] / $dtTablaCurvado [2][$N_Columna]) * 100, 3)) . "-";
                    } else {
                        $porcentajeAjust = $porcentajeAjust . "0-";
                    }
                    $key2 += 1;
                }

                //*****************2.-AJUSTE DE CAJAS SOLIDAS
                array_push($dtTablasSolidoCurvado, $dtTabla[0]);//CABECERA
                //total solido
                $insert = [];$total = 0; $keytallas = 0;
                foreach ($tallas2 as $vart) {
                    array_push($insert, $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas]);
                    $total += $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas];
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //n°cajas
                $insert = [];$total = 0;$keytallas = 0;
                foreach ($tallas2 as $vart) {
                    $parametro95 = round($dtTablaCurvado[2][$keytallas] / $dtTablaCurvado[1][$keytallas] * 100, 3);
                    if ($parametro95 >= 95 and $dtTablasSolidoCurvado[1][$keytallas] < $mstpack) {
                        array_push($insert, 0);
                    } elseif ($parametro95 < 95 and $dtTablasSolidoCurvado[1][$keytallas] >= (0.3 * $mstpack)) {//Redondeo hacia arriba
                        array_push($insert, ceil($dtTablasSolidoCurvado[1][$keytallas] / $mstpack));
                        $total += ceil($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                    } else {
                        array_push($insert, floor($dtTablasSolidoCurvado[1][$keytallas] / $mstpack));
                        $total += floor($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                    }
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //total de solido ajustado
                $insert = [];$total = 0;$keytallas = 0;
                foreach ($tallas2 as $vart) {
                    array_push($insert, $dtTablasSolidoCurvado[2][$keytallas] * $mstpack);
                    $total += $dtTablasSolidoCurvado[2][$keytallas] * $mstpack;
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);
                foreach ($clusters as $Var2) {
                    $clusters3 = $clusters3 . $Var2 . "+";
                }

                //MSTPACK
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $mstpack);
                array_push($dtTablasSolidoCurvado, $insert);

                //*-----------------% unid ajustada x tallas TOTALES
                $key = 0; $unid_ajustasxtallas = "";$insert = [];$total= 0;
                foreach ($tallas2 as $var) {
                    $unid_ajustasxtallas = $unid_ajustasxtallas . strval($dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key]) . "-";
                    array_push($insert, $dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key]);
                    $total += $dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key];
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //Total numero cajas finales
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS);
                array_push($dtTablasSolidoCurvado, $insert);

                //Total PORCENTAJE TOTAL AJUSTADO
                $insert = [];$key2= 0;
                foreach ($tallas2 as $vart) {
                    if ($dtTablaCurvado [2][$key2] <> 0) {
                        array_push($insert, round(($dtTablaCurvado[2][$key2] / $dtTablaCurvado [2][$N_Columna]) * 100, 3));
                    } else {
                        array_push($insert, 0);
                    }
                    $key2 += 1;
                }
                array_push($insert, 0);
                array_push($dtTablasSolidoCurvado, $insert);


                /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, strlen($porcentajeAjust) - 1);
                /*%*/$n_cajasfinales = $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS; //curvado + solido
                /*%*/$unid_final = $dtTablasSolidoCurvado[3][$N_Columna] + $dtTablaCurvado[2][$N_Columna]; //curvado + solido
                /*%*/$totalprimerRepato = $dtTablaCurvado[2][$N_Columna];
                /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/$clusters3 = substr($clusters3, 0, -1);
            }
            /*SOLIDO*/ else {
                /*******************AJUSTE MST-PACK SOLIDO*********************/
                /*%*/$porcentajeAjust = $dtTabla[5][$N_Columna];
                array_push($dtTablasolidoFULL, $dtTabla[0]);//CABECERA
                //--------------unid iniciales
                $insert = [];$por_ajust = explode("-", trim($porcentajeAjust));$total = 0;
                foreach ($por_ajust as $var) {
                    $total += round((($var * $unid_ajustas) / 100));
                    array_push($insert, round((($var * $unid_ajustas) / 100)));
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------Curva del Primer Reparto
                $insert = []; $curvas = explode(",", trim($curva_reparto));$total = 0;
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $rows[$nom_columnas['Cluster']], $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $ntdas = 0;
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }
                        $primer += $var * $rows[$nom_columnas['Cluster' . $varc]] * $ntdas["TIENDAS"];
                    }
                    $total += $primer;
                    array_push($insert, $primer);
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //mst pack
                $insert = [];
                foreach ($tallas2 as $var) {
                    array_push($insert, $mstpack);
                }
                array_push($insert, $mstpack);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------N° Cajas
                $key = 0;$insert = [];$total = 0;
                foreach ($tallas2 as $var) {
                    $val = 0;
                    $val = $dtTablasolidoFULL[1][$key] / $dtTablasolidoFULL[3][$key];
                    if (is_float($val) == true) {
                        $val = round($val, 0);
                        if (($val * $dtTablasolidoFULL[3][$key]) < $dtTablasolidoFULL[2][$key]) {
                            $val += 1;
                        }
                    }
                    $total += $val;
                    array_push($insert, $val);
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------UND FINAL
                $key = 0;$insert = [];$total = 0;
                foreach ($tallas2 as $var) {
                    $val = 0;
                    $val = $dtTablasolidoFULL[4][$key] * $dtTablasolidoFULL[3][$key];
                    $total += $val;
                    array_push($insert, $val);
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------% pocentaje ajustada por mstpack
                $key = 0;$porcentajeAjust = "";$unid_final = $dtTablasolidoFULL[5][$N_Columna];
                foreach ($tallas2 as $var) {
                    $porcentajeAjust = $porcentajeAjust . round((($dtTablasolidoFULL[5][$key] / $unid_final) * 100), 3) . "-";
                    $key += 1;
                }

                //*-----------------% unid ajustada por mstpack
                $key = 0;
                foreach ($tallas2 as $var) {
                    $unid_ajustasxtallas = $unid_ajustasxtallas . strval(round($dtTablasolidoFULL[5][$key], 0)) . "-";
                    $key += 1;
                }
                foreach ($clusters as $Var2) {
                    $clusters3 = $clusters3 . $Var2 . "+";
                }

                /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, -1);
                /*%*/$n_cajasfinales = $dtTablasolidoFULL[4][$N_Columna];
                /*%*/$unid_final = $dtTablasolidoFULL[5][$N_Columna];
                /*%*/$totalprimerRepato = $dtTablasolidoFULL[2][$N_Columna];
                /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/$clusters3 = substr($clusters3, 0, -1);
            }
        }
        /*REORDER*/ELSE {
            $unid_ajust = $unid_ini;$porcentAjut = $por_Inicial;
            //*-----------------tallas columnas
            array_push($dtTablaReorder,$dtTabla[0]);
            //--------------unid iniciales
            $insert =[]; $por_ajust = explode("-",  trim($porcentAjut)); $total = 0;
            foreach ($por_ajust as $var ){
                $val = round(($var * $unid_ajust)/100,0);
                $total += $val;
                array_push($insert,$val);
            }
            array_push($insert,$total);
            array_push($dtTablaReorder, $insert);

            //-------------los  REORDER NO TIENE PRIMERA CARGA
            //*-----------------N° Cajas
            $key = 0; $insert =[]; $total = 0;
            foreach ($tallas2 as $var ){$val = 0;
                $val = $dtTablaReorder[1][$key] / $mstpack;
                if (is_float($val) == true){
                    $val =round($val ,0);
                }
                $total+= $val;
                array_push($insert,$val);
                $key += 1;
            }
            array_push($insert,$total);
            array_push($dtTablaReorder,$insert);

            //*-----------------UND FINAL
            $key = 0; $insert =[]; $total = 0;
            foreach ($tallas2 as $var ){$val = 0;
                $val = $dtTablaReorder[2][$key] * $mstpack;
                $total+= $val;
                array_push($insert,$val);
                $key += 1;
            }
            array_push($insert,$total);
            array_push($dtTablaReorder,$insert);

            //mstpack
            $insert =[];
            foreach ($tallas2 as $var ){array_push($insert,$mstpack);}
            array_push($insert,$mstpack);
            array_push($dtTablaReorder,$insert);

            //*-----------------% pocentaje ajustada por mstpack
            $key = 0; $porcentAjut = ""; $unid_final  = $dtTablaReorder[3][$N_Columna];
            foreach ($tallas2 as $var ){
                $porcentajeAjust = $porcentajeAjust.round((($dtTablaReorder[3][$key]/$unid_final)*100),3)."-";
                $key += 1;
            }
            //*-----------------% unid ajustada por tallas mstpack
            $key = 0;
            foreach ($tallas2 as $var ){
                $unid_ajustasxtallas = $unid_ajustasxtallas.strval(round($dtTablaReorder[3][$key]))."-";
                $key += 1;
            }

            /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, -1);
            /*%*/$n_cajasfinales = $dtTablaReorder[2][$N_Columna];
            /*%*/$unid_final = $dtTablaReorder[3][$N_Columna];
            /*%*/$totalprimerRepato = 0;
            /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
            /*%*/$clusters3 = "";
            /*%*/$unid_ajustas = $unid_ini;
        }

        // AJUSTE DE COMPRA   = $dtTabla
        // AJUSTE CURVADO     = $dtTablaCurvado + $dtTablasSolidoCurvado
        // AJUSTE SOLIDO FULL = $dtTablasolidoFULL
        // AJUSTE REORDER     = $dtTablaReorder

        $array2 = array(
            /*unid_ajustada*/$unid_ajustas
            /*porcenajust=mstpack*/, $porcentajeAjust
            /*n°cajas*/, $n_cajasfinales
            /*unidfinal*/, $unid_final
            /*primera carga*/, $totalprimerRepato
            /*$tdas*/, round(($totalprimerRepato / $unid_final) * 100, 2)
            /*unidadesajustXtalla*/, $unid_ajustasxtallas
            /*clustes intersecion*/, $clusters3
        ,$dtTabla,$dtTablaCurvado,$dtTablasSolidoCurvado,$dtTablasolidoFULL,$dtTablaReorder);

        return $array2;
    }
    public static function Division_cantidades($cantidad){

        $dtcolumnas = [];
        $dtcantidad = explode("-",$cantidad);

        foreach ($dtcantidad as $val){
            array_push($dtcolumnas,$val);
        }

        $count = 9 - count($dtcantidad) ;
        if ($count <> 0 ) {
            for ($i = 1; $i <= $count; $i++) {
                array_push($dtcolumnas, (0));
            }
        }

        return $dtcolumnas;
    }
    public static function curvaportiendas($cluster,$A,$B,$C,$I){

        $dtcolumnas = array("A","B","C","I");
        $dtcluster = explode("+",$cluster);

        $insert = [];
        foreach ($dtcolumnas as $var){
            $_val = false;
            foreach ($dtcluster as $var2){
                if ($var2 == $var){
                    $_val = true;
                    break;
                }
            }

            if($_val == true){
                switch ($var){
                    case "A" : array_push($insert,$A);Break;
                    case "B" : array_push($insert,$B);Break;
                    case "C" : array_push($insert,$C);Break;
                    case "I" : array_push($insert,$I);Break;
                }

            }ELSE{
                array_push($insert,0);
            }
        }



        return $insert;
    }
    public static function Division_tallas($explodetallas,$dttallas){

        $dtcolumnas = [];
        $key = 0 ;
        foreach ($explodetallas as $val){
            array_push($dtcolumnas,$dttallas[$key]);
            $key +=1;
        }

        $count = 9 - count($explodetallas) ;
        if ($count <> 0 ) {
            for ($i = 1; $i <= $count; $i++) {
                array_push($dtcolumnas, (0));
            }
        }
        return $dtcolumnas;

    }
    public static function list_plan_compraxgrupo ($tempo,$depto,$grupo,$marca){
        $sql=  "SELECT * FROM PLC_PLAN_COMPRA_COLOR_3
                WHERE COD_TEMPORADA = ".$tempo."
                AND DEP_DEPTO = '".$depto."'
                AND GRUPO_COMPRA = '".$grupo."'
                AND COD_MARCA = ".$marca."
                AND ESTADO <> 0  ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function SaveAjuste_Compra($dtTabla, $dtTablaCurvado,$dtTablasSolidoCurvado,$dtTablasolidoFULL,$dtTablaReorder,$DEBUT,$Tipo_empaque,$id_color3,$Tallas,$cod_tempo,$depto){
        $array = [];
        $_insert= true ;
        $N_Columna = count(explode(",", trim($Tallas)));
        $tallas2 = explode(",", trim($Tallas));
        $key = 0;$columnas = "";

        if(strtoupper($DEBUT) == "DEBUT" AND strtoupper($Tipo_empaque) == "CURVADO"){
            //Guardado Ajuste de compra.
            foreach ($dtTabla as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Curva de Compra";}elseif($key ==2){$columnas = "Curva Primer Reparto";}elseif($key ==3){$columnas = "Diferencial";}elseif($key ==4){$columnas = "Total";}elseif($key ==5){$columnas = "Curva de compra Ajustada";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_AJUSTES_COMPRA" .
                        /*V_COD_TEMPORADA*/ ("('" . $cod_tempo . "'" .
                            /*V_DEP_DEPTO*/      ",'" . $depto . "'" .
                            /*V_ID_COLOR3*/      ",'" . $id_color3 . "'" .
                            /*V_TIPO_EMPAQUE*/   ",'" . $Tipo_empaque . "'" .
                            /*V_DEBUT_REORDER*/  ",'" . $DEBUT . "'" .
                            /*V_COLUMNAS*/       ",'" . $columnas . "'" .
                            /*V_TALLAS*/         ",'" . $Tallas . "'" .
                            /*V_TALLA_1*/        ","  . $tallas3[0] . "" .
                            /*V_TALLA_2*/        ","  . $tallas3[1] . "" .
                            /*V_TALLA_3*/        ","  . $tallas3[2] . "" .
                            /*V_TALLA_4*/        ","  . $tallas3[3] . "" .
                            /*V_TALLA_5*/        ","  . $tallas3[4] . "" .
                            /*V_TALLA_6*/        ","  . $tallas3[5] . "" .
                            /*V_TALLA_7*/        ","  . $tallas3[6] . "" .
                            /*V_TALLA_8*/        ","  . $tallas3[7] . "" .
                            /*V_TALLA_9*/        ","  . $tallas3[8] . "" .
                            /*V_TOTAL*/          ","  . ($key <> 5 ? ($val[$N_Columna]) : 0)  . "" .
                            /*V_TIPO_AJUSTE*/    ",'Ajuste de Compra', :error, :data); end;");
                    $data = \database::getInstancia()->getConsultaSP($sql, 2);
                    $_error = explode("#", $data);
                    if ($_error[0] == 1 ){
                        $_insert = false;
                        $array = array('Tipo' => FALSE,
                            'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                        break;
                    }
                }
                $key +=1;
            }$key = 0;
            //Guardado Ajuste de Curvado.
            foreach ($dtTablaCurvado as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Compra Total";}elseif($key ==2){$columnas = "1er Reparto";}elseif($key ==3){$columnas = "Curva 1er Reparto";}elseif($key ==4){$columnas = "Master Curvado";}elseif($key ==5){$columnas = "Curvas a repartir";}elseif($key ==6){$columnas = "N de Cajas";}elseif($key ==7){$columnas = "N de curvas x cajas";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_AJUSTES_COMPRA" .
                        /*V_COD_TEMPORADA*/ ("('" . $cod_tempo . "'" .
                            /*V_DEP_DEPTO*/      ",'" . $depto . "'" .
                            /*V_ID_COLOR3*/      ",'" . $id_color3 . "'" .
                            /*V_TIPO_EMPAQUE*/   ",'" . $Tipo_empaque . "'" .
                            /*V_DEBUT_REORDER*/  ",'" . $DEBUT . "'" .
                            /*V_COLUMNAS*/       ",'" . $columnas . "'" .
                            /*V_TALLAS*/         ",'" . $Tallas . "'" .
                            /*V_TALLA_1*/        ","  . $tallas3[0] . "" .
                            /*V_TALLA_2*/        ","  . $tallas3[1] . "" .
                            /*V_TALLA_3*/        ","  . $tallas3[2] . "" .
                            /*V_TALLA_4*/        ","  . $tallas3[3] . "" .
                            /*V_TALLA_5*/        ","  . $tallas3[4] . "" .
                            /*V_TALLA_6*/        ","  . $tallas3[5] . "" .
                            /*V_TALLA_7*/        ","  . $tallas3[6] . "" .
                            /*V_TALLA_8*/        ","  . $tallas3[7] . "" .
                            /*V_TALLA_9*/        ","  . $tallas3[8] . "" .
                            /*V_TOTAL*/          ","  . $val[$N_Columna] . "" .
                            /*V_TIPO_AJUSTE*/    ",'Ajuste Curvado', :error, :data); end;");
                    $data = \database::getInstancia()->getConsultaSP($sql, 2);
                    $_error = explode("#", $data);
                    if ($_error[0] == 1 ){
                        $_insert = false;
                        $array = array('Tipo' => FALSE,
                            'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                        break;
                    }
                }
                $key +=1;
            }$key = 0;
            //Guardado Ajuste de Solido Curvado.
            foreach ($dtTablasSolidoCurvado as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Total Solido";}elseif($key ==2){$columnas = "N Cajas";}elseif($key ==3){$columnas = "Total Solido Ajustado";}elseif($key ==4){$columnas = "Master Pack";}elseif($key ==5){$columnas = "Total Unidades Final";}elseif($key ==6){$columnas = "Total N Cajas Final";}elseif($key ==7){$columnas = "Total Porcentajes Ajust Final";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_AJUSTES_COMPRA" .
                        /*V_COD_TEMPORADA*/ ("('" . $cod_tempo . "'" .
                            /*V_DEP_DEPTO*/      ",'" . $depto . "'" .
                            /*V_ID_COLOR3*/      ",'" . $id_color3 . "'" .
                            /*V_TIPO_EMPAQUE*/   ",'" . $Tipo_empaque . "'" .
                            /*V_DEBUT_REORDER*/  ",'" . $DEBUT . "'" .
                            /*V_COLUMNAS*/       ",'" . $columnas . "'" .
                            /*V_TALLAS*/         ",'" . $Tallas . "'" .
                            /*V_TALLA_1*/        ","  . $tallas3[0] . "" .
                            /*V_TALLA_2*/        ","  . $tallas3[1] . "" .
                            /*V_TALLA_3*/        ","  . $tallas3[2] . "" .
                            /*V_TALLA_4*/        ","  . $tallas3[3] . "" .
                            /*V_TALLA_5*/        ","  . $tallas3[4] . "" .
                            /*V_TALLA_6*/        ","  . $tallas3[5] . "" .
                            /*V_TALLA_7*/        ","  . $tallas3[6] . "" .
                            /*V_TALLA_8*/        ","  . $tallas3[7] . "" .
                            /*V_TALLA_9*/        ","  . $tallas3[8] . "" .
                            /*V_TOTAL*/          ","  . $val[$N_Columna] . "" .
                            /*V_TIPO_AJUSTE*/    ",'Solido Curvado', :error, :data); end;");
                    $data = \database::getInstancia()->getConsultaSP($sql, 2);
                    $_error = explode("#", $data);
                    if ($_error[0] == 1 ){
                        $_insert = false;
                        $array = array('Tipo' => FALSE,
                            'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                        break;
                    }
                }
                $key +=1;
            }

            // $dtTabla,$dtTablaCurvado,$dtTablasSolidoCurvado
        }
        elseif(strtoupper($DEBUT) == "DEBUT" and strtoupper($Tipo_empaque) == "SOLIDO" ){
            //Guardado Ajuste de compra.
            foreach ($dtTabla as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Curva de Compra";}elseif($key ==2){$columnas = "Curva Primer Reparto";}elseif($key ==3){$columnas = "Diferencial";}elseif($key ==4){$columnas = "Total";}elseif($key ==5){$columnas = "Curva de compra Ajustada";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_AJUSTES_COMPRA" .
                        /*V_COD_TEMPORADA*/ ("('" . $cod_tempo . "'" .
                            /*V_DEP_DEPTO*/      ",'" . $depto . "'" .
                            /*V_ID_COLOR3*/      ",'" . $id_color3 . "'" .
                            /*V_TIPO_EMPAQUE*/   ",'" . $Tipo_empaque . "'" .
                            /*V_DEBUT_REORDER*/  ",'" . $DEBUT . "'" .
                            /*V_COLUMNAS*/       ",'" . $columnas . "'" .
                            /*V_TALLAS*/         ",'" . $Tallas . "'" .
                            /*V_TALLA_1*/        ","  . $tallas3[0] . "" .
                            /*V_TALLA_2*/        ","  . $tallas3[1] . "" .
                            /*V_TALLA_3*/        ","  . $tallas3[2] . "" .
                            /*V_TALLA_4*/        ","  . $tallas3[3] . "" .
                            /*V_TALLA_5*/        ","  . $tallas3[4] . "" .
                            /*V_TALLA_6*/        ","  . $tallas3[5] . "" .
                            /*V_TALLA_7*/        ","  . $tallas3[6] . "" .
                            /*V_TALLA_8*/        ","  . $tallas3[7] . "" .
                            /*V_TALLA_9*/        ","  . $tallas3[8] . "" .
                            /*V_TOTAL*/          ","  . ($key <> 5 ? ($val[$N_Columna]) : 0)  . "" .
                            /*V_TIPO_AJUSTE*/    ",'Ajuste de Compra', :error, :data); end;");
                    $data = \database::getInstancia()->getConsultaSP($sql, 2);
                    $_error = explode("#", $data);
                    if ($_error[0] == 1 ){
                        $_insert = false;
                        $array = array('Tipo' => FALSE,
                            'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                        break;
                    }
                }
                $key +=1;
            }$key = 0;
            //Guardado Ajuste mst pack.
            foreach ($dtTablasolidoFULL as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Unid Ini";}elseif($key ==2){$columnas = "Primer Reparto";}elseif($key ==3){$columnas = "Master Pack";}elseif($key ==4){$columnas = "N Cajas";}elseif($key ==5){$columnas = "Unid Final";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_AJUSTES_COMPRA" .
                        /*V_COD_TEMPORADA*/ ("('" . $cod_tempo . "'" .
                            /*V_DEP_DEPTO*/      ",'" . $depto . "'" .
                            /*V_ID_COLOR3*/      ",'" . $id_color3 . "'" .
                            /*V_TIPO_EMPAQUE*/   ",'" . $Tipo_empaque . "'" .
                            /*V_DEBUT_REORDER*/  ",'" . $DEBUT . "'" .
                            /*V_COLUMNAS*/       ",'" . $columnas . "'" .
                            /*V_TALLAS*/         ",'" . $Tallas . "'" .
                            /*V_TALLA_1*/        ","  . $tallas3[0] . "" .
                            /*V_TALLA_2*/        ","  . $tallas3[1] . "" .
                            /*V_TALLA_3*/        ","  . $tallas3[2] . "" .
                            /*V_TALLA_4*/        ","  . $tallas3[3] . "" .
                            /*V_TALLA_5*/        ","  . $tallas3[4] . "" .
                            /*V_TALLA_6*/        ","  . $tallas3[5] . "" .
                            /*V_TALLA_7*/        ","  . $tallas3[6] . "" .
                            /*V_TALLA_8*/        ","  . $tallas3[7] . "" .
                            /*V_TALLA_9*/        ","  . $tallas3[8] . "" .
                            /*V_TOTAL*/          ","  . $val[$N_Columna]  . "" .
                            /*V_TIPO_AJUSTE*/    ",'Ajuste Master Pack', :error, :data); end;");
                    $data = \database::getInstancia()->getConsultaSP($sql, 2);
                    $_error = explode("#", $data);
                    if ($_error[0] == 1 ){
                        $_insert = false;
                        $array = array('Tipo' => FALSE,
                            'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                        break;
                    }
                }
                $key +=1;
            }

        }elseif (strtoupper($DEBUT) == "REORDER"){
            //Guardado Ajuste mst pack.
            foreach ($dtTablaReorder as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Unid Ini";}elseif($key ==2){$columnas = "N Cajas";}elseif($key ==3){$columnas = "Und Final";}elseif($key ==4){$columnas = "Mst Pack";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_AJUSTES_COMPRA" .
                        /*V_COD_TEMPORADA*/ ("('" . $cod_tempo . "'" .
                            /*V_DEP_DEPTO*/      ",'" . $depto . "'" .
                            /*V_ID_COLOR3*/      ",'" . $id_color3 . "'" .
                            /*V_TIPO_EMPAQUE*/   ",'" . $Tipo_empaque . "'" .
                            /*V_DEBUT_REORDER*/  ",'" . $DEBUT . "'" .
                            /*V_COLUMNAS*/       ",'" . $columnas . "'" .
                            /*V_TALLAS*/         ",'" . $Tallas . "'" .
                            /*V_TALLA_1*/        ","  . $tallas3[0] . "" .
                            /*V_TALLA_2*/        ","  . $tallas3[1] . "" .
                            /*V_TALLA_3*/        ","  . $tallas3[2] . "" .
                            /*V_TALLA_4*/        ","  . $tallas3[3] . "" .
                            /*V_TALLA_5*/        ","  . $tallas3[4] . "" .
                            /*V_TALLA_6*/        ","  . $tallas3[5] . "" .
                            /*V_TALLA_7*/        ","  . $tallas3[6] . "" .
                            /*V_TALLA_8*/        ","  . $tallas3[7] . "" .
                            /*V_TALLA_9*/        ","  . $tallas3[8] . "" .
                            /*V_TOTAL*/          ","  . $val[$N_Columna]  . "" .
                            /*V_TIPO_AJUSTE*/    ",'Ajuste Master Pack', :error, :data); end;");
                    $data = \database::getInstancia()->getConsultaSP($sql, 2);
                    $_error = explode("#", $data);
                    if ($_error[0] == 1 ){
                        $_insert = false;
                        $array = array('Tipo' => FALSE,
                            'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
                        break;
                    }
                }
                $key +=1;
            }
        }

        return $array;

    }
    public static function get_nomcolor2($dtcolor,$cod_color){

        $val = "";
        foreach($dtcolor as $val2){
            if ($val2['COD_COLOR'] == $cod_color){
                $val = $val2['NOM_COLOR'];
                break;
            }
        }
        return $val;
    }


    #endregion

#region {*************Metodos Importar Assortment v2*************}
    public static function list_plan_compra_debut($cod_temporada,$depto,$grupo_compra){
        $sql ="select cod_jer2 linea,cod_sublin,Des_Estilo,cod_color,debut_reoder
              from plc_plan_compra_color_3
              where cod_temporada = ".$cod_temporada."
              and dep_depto = '".$depto."'
              and grupo_compra <> '".$grupo_compra."'
              and debut_reoder = 'DEBUT'
              and estado <> 24";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }
    Public static function Validacion_tdas_count_formato2($depto,$temporada,$cod_formato){
        $n = 0;
        $sql ="select count(cod_tda) n_tdas 
                from plc_formatos_tda
                where cod_seg = ".$cod_formato."
                and cod_temporada = ".$temporada."
                and dep_depto = '".$depto."'" ;
        $data = \database::getInstancia()->getFila($sql);
        if (count($data) <> 0) {
            $n = $data['n_tdas'];
        }
        return $n;
    }
    public static function get_codformato($depto,$temporada,$nom_formato){
        $cod = 0;
        $sql = "select distinct cod_seg  as cod_formato
                from plc_formato
                where cod_Temporada  = ".$temporada."
                 and dep_depto = '".$depto."'
                 and des_seg = '".$nom_formato."'";
        $data = \database::getInstancia()->getFila($sql);
        if (count($data) <> 0){
            $cod = $data['cod_formato'];
        }
        return $cod;
    }
    public static function get_NomJerarquia2($dtjerarquia,$rows,$nom_columnas,$tipo){


        if($tipo==1){
            $camposPMM = "LIN_LINEA";
            $camposAsort = "Cod Linea";
            $camposdescrip = "LIN_DESCRIPCION";
        }else{
            $camposPMM = "SLI_SUBLINEA";
            $camposAsort = "Cod Sublinea";
            $camposdescrip = "SLI_DESCRIPCION";
        }

        $nombre = "";
        $key3 = 0;
        foreach ($dtjerarquia as $var  ){
            if ($dtjerarquia[$key3][$camposPMM] == $rows[$nom_columnas[$camposAsort]]) {
                $nombre = $dtjerarquia[$key3][$camposdescrip];
                break;
            }
            $key3++;
        }

        return $nombre;

    }
    public static function get_NomMarcas2($dtmarcas,$rows,$nom_columnas){
        $nombre = "";
        $key3 = 0;
        foreach ($dtmarcas as $var  ){
            if ($dtmarcas[$key3]["CODIGO"] == $rows[$nom_columnas["Codigo Marca"]]) {
                $nombre = $dtmarcas[$key3]["DESCRIPCION"];
                break;
            }
            $key3++;
        }

        return $nombre;
    }
    public static function get_ComposicionCampos2($rows,$nom_columnas,$tipo){

        $composion = "";
        for($x = 1;$x <= 9; $x++){
            $column = $tipo.$x;
            if ($rows[$nom_columnas[$column]] <> "" and
                $rows[$nom_columnas[$column]] <> "0" and
                $rows[$nom_columnas[$column]] <> " " and
                $rows[$nom_columnas[$column]] <> null ){
                if ($tipo == "Size%"){
                    $composion = $composion. (round($rows[$nom_columnas[$column]],5) * 100) ."-";
                }elseif ($tipo == "Size %"){
                    $composion = $composion. (round($rows[$nom_columnas[$column]],5)) ."-";
                }else {
                    $composion = $composion . $rows[$nom_columnas[$column]] . ",";
                }
            }
        }

        if ((strlen($composion)) > 0){
            $composion = substr($composion, 0, - 1);
        }
        return $composion;
    }
    public static function get_codtemporadaseason2($rows,$nom_columnas){
        $cod = 0;
        if($rows[$nom_columnas["Temporada"]] == "CL - INVIERNO" or
            $rows[$nom_columnas["Temporada"]] == "CL - OTOÑO" ){
            $cod = 1;
        }elseif ($rows[$nom_columnas["Temporada"]] == "CL - PRIMAVERA" or
            $rows[$nom_columnas["Temporada"]] == "CL - VERANO"){
            $cod = 2;
        }elseif ($rows[$nom_columnas["Temporada"]] == "CL - TODA TEMPORADA") {
            $cod = 3;
        }
        return $cod;
    }
    public static function AjustesPrimerReparto2($por_Inicial,$unid_ini,$curva_reparto,$tallas,$rows,$nom_columnas,$cod_tempo,$depto,$marca,$DEBUT,$tipo_empaque,$N_CURVAS_CAJAS,$formato,$dtplanCompra,$mstpack){

        /*******************AJUSTE CUERVA DE COMPRA*********************/
        $mstpack = $mstpack["MSTPACK"];
        $dtTabla = []; $dtTablaCurvado = [];$dtTablasSolidoCurvado = [];$dtTablasolidoFULL = [];$dtTablaReorder =[];
        $unid_ajustas = 0;$unid_final = 0;$porcentajeAjust = "";$n_cajasfinales = 0;$totalprimerRepato = 0;$unid_ajustasxtallas = "";
        $N_Columna = count(explode(",", trim($tallas)));
        //*-----------------tallas columnas
        $tallas2 = explode(",", trim($tallas));
        $insert = [];
        foreach ($tallas2 as $var) {
            array_push($insert, $var);
        }
        array_push($insert, "Total");
        array_push($dtTabla, $insert);

        $clusters3 = "";
        /*DEBUT*/IF ($DEBUT == "DEBUT") {
            //*-----------------curva de compra
            $insert = [];$por_Inicial = explode("-", trim($por_Inicial));$total = 0;
            foreach ($por_Inicial as $var) {
                $total += round((($var * $unid_ini) / 100));
                array_push($insert, round((($var * $unid_ini) / 100)));
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------Curva del Primer Reparto
            $insert = [];$curvas = explode(",", trim($curva_reparto));$total = 0;
            $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $rows[$nom_columnas['Cluster']], $formato));
            foreach ($curvas as $var) {
                $primer = 0;
                foreach ($clusters as $varc) {
                    $ntdas = 0;
                    if ($formato == "" OR $formato == "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                    } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                    }
                    $primer += $var * $rows[$nom_columnas['Cluster' . $varc]] * $ntdas["TIENDAS"];
                }
                $total += $primer;
                array_push($insert, $primer);
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------diferencial
            $key = 0;$insert = [];$total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                if ($dtTabla[1][$key] < $dtTabla[2][$key]) {
                    $val = $dtTabla[1][$key] - $dtTabla[2][$key];
                }
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------Total
            $key = 0;$insert = [];$total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                if ($dtTabla[3][$key] <> 0) {
                    $val = $dtTabla[2][$key];
                } else {
                    $val = $dtTabla[1][$key];
                }
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------CURVA DE COMPRA Ajustada
            $key = 0;$insert = [];$total = "";
            $TotalAjust = $dtTabla[4][$N_Columna];
            foreach ($tallas2 as $var) {
                $val = 0;
                $val = (round((($dtTabla[4][$key] / $TotalAjust) * 100), 5));
                if (strlen($val) > 6) {
                    $val = round($val, 3);
                }
                $total = $total . $val . "-";
                array_push($insert, $val);
                $key += 1;

            }
            $total = substr($total, 0, -1);
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            /*%*/$unid_ajustas = $dtTabla[4][$N_Columna];

            /*CURVADO*/ if ($tipo_empaque == "Curvado" or $tipo_empaque == "CURVADO") {
                //*****************1.-AJUSTE DE CAJAS CURVADOS
                array_push($dtTablaCurvado, $dtTabla[0]);//CABECERA
                array_push($dtTablaCurvado, $dtTabla[4]);//TOTAL AJUSTE COMPRA
                //*-----------------Curva del Primer Reparto
                $insert = [];$total = 0;
                $curvas = explode(",", trim($curva_reparto));
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $rows[$nom_columnas['Cluster']], $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $ntdas = 0;
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($rows[$nom_columnas["Formato"]] <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }
                        $primer += $var * $rows[$nom_columnas["Cluster" . $varc]] * $ntdas["TIENDAS"];
                    }
                    $total += $primer;
                    array_push($insert, $primer);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);


                //*-----------------Curvas de repartos EJ: 1,2,3,4
                $insert = [];$total = 0;
                foreach ($curvas as $var) {
                    $total += $var;
                    array_push($insert, $var);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);

                //Curva minima * n° de curva/caja
                //$masterCurvado = $dtTablaCurvado [3][$N_Columna] * $N_CURVAS_CAJAS;
                $insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $dtTablaCurvado [3][$N_Columna] * $N_CURVAS_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //total 1er repato / inner(curva min)
                $Curva_repartir = $dtTablaCurvado [2][$N_Columna] / $dtTablaCurvado[3][$N_Columna];$insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $Curva_repartir);
                array_push($dtTablaCurvado, $insert);

                //Curva a repartir / n de curva cajas
                $n_CAJAS = $Curva_repartir / $N_CURVAS_CAJAS;$insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $n_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //N° de curvas caja
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $rows[$nom_columnas['N curvas por caja curvadas']]);
                array_push($dtTablaCurvado, $insert);

                //*-------------porcenjas compra curvada
                $key2 = 0;
                foreach ($tallas2 as $vart) {
                    if ($dtTablaCurvado [2][$key2] <> 0) {
                        $porcentajeAjust = $porcentajeAjust . (round(($dtTablaCurvado[2][$key2] / $dtTablaCurvado [2][$N_Columna]) * 100, 3)) . "-";
                    } else {
                        $porcentajeAjust = $porcentajeAjust . "0-";
                    }
                    $key2 += 1;
                }

                //*****************2.-AJUSTE DE CAJAS SOLIDAS
                array_push($dtTablasSolidoCurvado, $dtTabla[0]);//CABECERA
                //total solido
                $insert = [];$total = 0; $keytallas = 0;
                foreach ($tallas2 as $vart) {
                    array_push($insert, $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas]);
                    $total += $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas];
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //n°cajas
                $insert = [];$total = 0;$keytallas = 0;
                foreach ($tallas2 as $vart) {
                    $parametro95 = round($dtTablaCurvado[2][$keytallas] / $dtTablaCurvado[1][$keytallas] * 100, 3);
                    $decimal = 0;
                    if (is_float($parametro95 ) == true){$division = 0;
                        if ($dtTablasSolidoCurvado[1][$keytallas] <> 0){
                            $division = ($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                            $decimal  = (substr($division, strpos($division, "." )));
                        }
                    }
                    if ($parametro95 >= 95 and $dtTablasSolidoCurvado[1][$keytallas] < $mstpack) {
                        array_push($insert, 0);
                    } elseif ($parametro95 < 95 and $decimal < 0.3) {//Redondeo hacia abajo
                        array_push($insert, floor($dtTablasSolidoCurvado[1][$keytallas] / $mstpack));
                        $total += floor($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                    } else {
                        array_push($insert, ceil($dtTablasSolidoCurvado[1][$keytallas] / $mstpack));
                        $total += ceil($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                    }
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //total de solido ajustado
                $insert = [];$total = 0;$keytallas = 0;
                foreach ($tallas2 as $vart) {
                    array_push($insert, $dtTablasSolidoCurvado[2][$keytallas] * $mstpack);
                    $total += $dtTablasSolidoCurvado[2][$keytallas] * $mstpack;
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);
                foreach ($clusters as $Var2) {
                    $clusters3 = $clusters3 . $Var2 . "+";
                }

                //MSTPACK
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $mstpack);
                array_push($dtTablasSolidoCurvado, $insert);

                //*-----------------% unid ajustada x tallas TOTALES
                $key = 0; $unid_ajustasxtallas = "";$insert = [];$total= 0;
                foreach ($tallas2 as $var) {
                    $unid_ajustasxtallas = $unid_ajustasxtallas . strval($dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key]) . "-";
                    array_push($insert, $dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key]);
                    $total += $dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key];
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //Total numero cajas finales
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS);
                array_push($dtTablasSolidoCurvado, $insert);

                //Total PORCENTAJE TOTAL AJUSTADO
                $insert = [];$key2= 0;
                foreach ($tallas2 as $vart) {
                    if ($dtTablaCurvado [2][$key2] <> 0) {
                        array_push($insert, round(($dtTablaCurvado[2][$key2] / $dtTablaCurvado [2][$N_Columna]) * 100, 3));
                    } else {
                        array_push($insert, 0);
                    }
                    $key2 += 1;
                }
                array_push($insert, 0);
                array_push($dtTablasSolidoCurvado, $insert);


                /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, strlen($porcentajeAjust) - 1);
                /*%*/$n_cajasfinales = $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS; //curvado + solido
                /*%*/$unid_final = $dtTablasSolidoCurvado[3][$N_Columna] + $dtTablaCurvado[2][$N_Columna]; //curvado + solido
                /*%*/$totalprimerRepato = $dtTablaCurvado[2][$N_Columna];
                /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/$clusters3 = substr($clusters3, 0, -1);
            }
            /*SOLIDO*/ else {
                /*******************AJUSTE MST-PACK SOLIDO*********************/
                /*%*/$porcentajeAjust = $dtTabla[5][$N_Columna];
                array_push($dtTablasolidoFULL, $dtTabla[0]);//CABECERA
                //--------------unid iniciales
                $insert = [];$por_ajust = explode("-", trim($porcentajeAjust));$total = 0;
                foreach ($por_ajust as $var) {
                    $total += round((($var * $unid_ajustas) / 100));
                    array_push($insert, round((($var * $unid_ajustas) / 100)));
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------Curva del Primer Reparto
                $insert = []; $curvas = explode(",", trim($curva_reparto));$total = 0;
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $rows[$nom_columnas['Cluster']], $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $ntdas = 0;
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }
                        $primer += $var * $rows[$nom_columnas['Cluster' . $varc]] * $ntdas["TIENDAS"];
                    }
                    $total += $primer;
                    array_push($insert, $primer);
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //mst pack
                $insert = [];
                foreach ($tallas2 as $var) {
                    array_push($insert, $mstpack);
                }
                array_push($insert, $mstpack);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------N° Cajas
                $key = 0;$insert = [];$total = 0;
                foreach ($tallas2 as $var) {
                    $val = 0;
                    $val = $dtTablasolidoFULL[1][$key] / $dtTablasolidoFULL[3][$key];
                    if (is_float($val) == true) {
                        $val = round($val, 0);
                        if (($val * $dtTablasolidoFULL[3][$key]) < $dtTablasolidoFULL[2][$key]) {
                            $val += 1;
                        }
                    }
                    $total += $val;
                    array_push($insert, $val);
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------UND FINAL
                $key = 0;$insert = [];$total = 0;
                foreach ($tallas2 as $var) {
                    $val = 0;
                    $val = $dtTablasolidoFULL[4][$key] * $dtTablasolidoFULL[3][$key];
                    $total += $val;
                    array_push($insert, $val);
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------% pocentaje ajustada por mstpack
                $key = 0;$porcentajeAjust = "";$unid_final = $dtTablasolidoFULL[5][$N_Columna];
                foreach ($tallas2 as $var) {
                    $porcentajeAjust = $porcentajeAjust . round((($dtTablasolidoFULL[5][$key] / $unid_final) * 100), 3) . "-";
                    $key += 1;
                }

                //*-----------------% unid ajustada por mstpack
                $key = 0;
                foreach ($tallas2 as $var) {
                    $unid_ajustasxtallas = $unid_ajustasxtallas . strval(round($dtTablasolidoFULL[5][$key], 0)) . "-";
                    $key += 1;
                }
                foreach ($clusters as $Var2) {
                    $clusters3 = $clusters3 . $Var2 . "+";
                }

                /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, -1);
                /*%*/$n_cajasfinales = $dtTablasolidoFULL[4][$N_Columna];
                /*%*/$unid_final = $dtTablasolidoFULL[5][$N_Columna];
                /*%*/$totalprimerRepato = $dtTablasolidoFULL[2][$N_Columna];
                /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/$clusters3 = substr($clusters3, 0, -1);
            }
        }
        /*REORDER*/ELSE {
            $unid_ajust = $unid_ini;$porcentAjut = $por_Inicial;
            //*-----------------tallas columnas
            array_push($dtTablaReorder,$dtTabla[0]);
            //--------------unid iniciales
            $insert =[]; $por_ajust = explode("-",  trim($porcentAjut)); $total = 0;
            foreach ($por_ajust as $var ){
                $val = round(($var * $unid_ajust)/100,0);
                $total += $val;
                array_push($insert,$val);
            }
            array_push($insert,$total);
            array_push($dtTablaReorder, $insert);

            //-------------los  REORDER NO TIENE PRIMERA CARGA
            //*-----------------N° Cajas
            $key = 0; $insert =[]; $total = 0;
            foreach ($tallas2 as $var ){$val = 0;
                $val = $dtTablaReorder[1][$key] / $mstpack;
                if (is_float($val) == true){
                    $val =round($val ,0);
                }
                $total+= $val;
                array_push($insert,$val);
                $key += 1;
            }
            array_push($insert,$total);
            array_push($dtTablaReorder,$insert);

            //*-----------------UND FINAL
            $key = 0; $insert =[]; $total = 0;
            foreach ($tallas2 as $var ){$val = 0;
                $val = $dtTablaReorder[2][$key] * $mstpack;
                $total+= $val;
                array_push($insert,$val);
                $key += 1;
            }
            array_push($insert,$total);
            array_push($dtTablaReorder,$insert);

            //mstpack
            $insert =[];
            foreach ($tallas2 as $var ){array_push($insert,$mstpack);}
            array_push($insert,$mstpack);
            array_push($dtTablaReorder,$insert);

            //*-----------------% pocentaje ajustada por mstpack
            $key = 0; $porcentAjut = ""; $unid_final  = $dtTablaReorder[3][$N_Columna];
            foreach ($tallas2 as $var ){
                $porcentajeAjust = $porcentajeAjust.round((($dtTablaReorder[3][$key]/$unid_final)*100),3)."-";
                $key += 1;
            }
            //*-----------------% unid ajustada por tallas mstpack
            $key = 0;
            foreach ($tallas2 as $var ){
                $unid_ajustasxtallas = $unid_ajustasxtallas.strval(round($dtTablaReorder[3][$key]))."-";
                $key += 1;
            }

            /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, -1);
            /*%*/$n_cajasfinales = $dtTablaReorder[2][$N_Columna];
            /*%*/$unid_final = $dtTablaReorder[3][$N_Columna];
            /*%*/$totalprimerRepato = 0;
            /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
            /*%*/$clusters3 = "";
            /*%*/$unid_ajustas = $unid_ini;
        }

        // AJUSTE DE COMPRA   = $dtTabla
        // AJUSTE CURVADO     = $dtTablaCurvado + $dtTablasSolidoCurvado
        // AJUSTE SOLIDO FULL = $dtTablasolidoFULL
        // AJUSTE REORDER     = $dtTablaReorder

        $array2 = array(
            /*unid_ajustada*/$unid_ajustas
            /*porcenajust=mstpack*/, $porcentajeAjust
            /*n°cajas*/, $n_cajasfinales
            /*unidfinal*/, $unid_final
            /*primera carga*/, $totalprimerRepato
            /*$tdas*/, round(($totalprimerRepato / $unid_final) * 100, 2)
            /*unidadesajustXtalla*/, $unid_ajustasxtallas
            /*clustes intersecion*/, $clusters3
        ,$dtTabla,$dtTablaCurvado,$dtTablasSolidoCurvado,$dtTablasolidoFULL,$dtTablaReorder);

        return $array2;
    }
    public static function InsertHistoricaAssortment2($rows,$nom_columnas,$cod_tempo,$depto,$codMarca){

        $array= [];
        $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_PLC_HIST_ASSORTMENT" .
            /*V_COD_TEMPORADA*/          ("(" . $cod_tempo . "" .
                /*V_DEP_DEPTO*/                 ",'" . $depto . "'" .
                /*V_DPTO*/                      ",'" . $rows[$nom_columnas['Dpto']] . "'" .
                /*V_MARCA*/                     ",'" . $rows[$nom_columnas['Marca']] . "'" .
                /*V_CODIGO_MARCA*/              ","  . $codMarca ."".
                /*V_SEASON*/                    ",'" . $rows[$nom_columnas['Season']] . "'" .
                /*V_LINEA*/                     ",'" . $rows[$nom_columnas['Linea']] . "'" .
                /*V_COD_LINEA*/                 ",'" . $rows[$nom_columnas['Cod Linea']] . "'" .
                /*V_SUBLINEA*/                  ",'" . $rows[$nom_columnas['Sublinea']] . "'" .
                /*V_COD_SUBLINEA*/              ",'" . $rows[$nom_columnas['Cod Sublinea']] . "'" .
                /*V_CODIGO_CORPORATIVO*/        ",'" . $rows[$nom_columnas['Codigo corporativo']] . "'" .
                /*V_NOMBRE_ESTILO*/             ",'" . utf8_encode($rows[$nom_columnas['Nombre Estilo']]) . "'" .
                /*V_ESTILO_CORTO*/              ",'" . utf8_encode($rows[$nom_columnas['Estilo Corto']]) . "'" .
                /*V_DESCRIPCION_ESTILO*/        ",'" . utf8_encode($rows[$nom_columnas['Descripcion Estilo']]) . "'" .
                /*V_COLOR*/                     ",'" . $rows[$nom_columnas['Color']] . "'" .
                /*V_COD_COLOR*/                 ","  . $rows[$nom_columnas['Cod Color']] . "" .
                /*V_EVENTO*/                    ",'" . $rows[$nom_columnas['Evento']] . "'" .
                /*V_GRUPO_DE_COMPRA*/           ",'" . $rows[$nom_columnas['Grupo de compra']] . "'" .
                /*V_VENTANA_DEBUT*/             ",'" . $rows[$nom_columnas['Ventana Debut']] . "'" .
                /*V_TIPO_EXHIBICION*/           ",'" . $rows[$nom_columnas['Tipo exhibicion']] . "'" .
                /*V_TIPO_PRODUCTO*/             ",'" . $rows[$nom_columnas['Tipo Producto']] . "'" .
                /*V_DEBUT_O_REORDER*/           ",'" . $rows[$nom_columnas['Debut o Reorder']] . "'" .
                /*V_TEMPORADA*/                 ",'" . $rows[$nom_columnas['Temporada']] . "'" .
                /*V_PRECIO*/                    ","  . ($rows[$nom_columnas['Precio']]<> null ? ($rows[$nom_columnas['Precio']]) : 0)  . "" .
                /*V_RANKING_DE_VENTA*/          ",'" . $rows[$nom_columnas['Ranking de venta']] . "'" .
                /*V_CICLO_DE_VIDA*/             ",'" . $rows[$nom_columnas['Ciclo de Vida']] . "'" .
                /*V_PIRAMIDE_MIX*/              ",'" . $rows[$nom_columnas['Piramide Mix']] . "'" .
                /*V_RATIO_COMPRA*/              ",'" . $rows[$nom_columnas['Ratio compra']] . "'" .
                /*V_FACTOR_AMPLIFICACION*/      ",'" . $rows[$nom_columnas['Factor amplificacion']] . "'" .
                /*V_RATIO_COMPRA_FINAL*/        ",'" . $rows[$nom_columnas['Ratio compra final']] . "'" .
                /*V_CLUSTER_*/                  ",'" . $rows[$nom_columnas['Cluster']] . "'" .
                /*V_FORMATO*/                   ",'" . $rows[$nom_columnas['Formato']] . "'" .
                /*V_COMPRA_UNIDADES_ASSORTMENT*/","  . ($rows[$nom_columnas['Compra Unidades Assortment']] <> null ? ($rows[$nom_columnas['Compra Unidades Assortment']]) : 0)  . "" .
                /*V_COMPRA_UNIDADES_FINAL*/     ","  . ($rows[$nom_columnas['Compra Unidades final']] <> null ? ($rows[$nom_columnas['Compra Unidades final']]) : 0)  . "" .
                /*V_VAR_PORCE*/                 ",'" . $rows[$nom_columnas['Var%']] . "'" .
                /*V_TARGET_USD*/                ","  . ($rows[$nom_columnas['Target USD'] ]<> null ? ($rows[$nom_columnas['Target USD']]) : 0)  . "" .
                /*V_RFID_USD*/                  ","  . ($rows[$nom_columnas['RFID USD'] ]<> null ? ($rows[$nom_columnas['RFID USD']]) : 0)  . "" .
                /*V_VIA*/                       ",'" . $rows[$nom_columnas['Via']] . "'" .
                /*V_PAIS*/                      ",'" . utf8_encode($rows[$nom_columnas['Pais']]) . "'" .
                /*V_FACTOR*/                    ","  . ($rows[$nom_columnas['Factor'] ]<> null ? ($rows[$nom_columnas['Factor']]) : 0)  . "" .
                /*V_COSTO_TOTAL*/               ","  . ($rows[$nom_columnas['Costo Total'] ]<> null ? ($rows[$nom_columnas['Costo Total']]) : 0)  . "" .
                /*V_RETAIL_TOTAL_SIN_IVA*/      ","  . ($rows[$nom_columnas['Retail Total sin iva'] ]<> null ? ($rows[$nom_columnas['Retail Total sin iva']]) : 0)  . "" .
                /*V_MUP_COMPRA*/                ",'" . $rows[$nom_columnas['MUP Compra']] . "'" .
                /*V_EXHIBICION*/                ",'" . $rows[$nom_columnas['Exhibicion']] . "'" .
                /*V_TALLA1*/                    ",'" . $rows[$nom_columnas['Talla1']] . "'" .
                /*V_TALLA2*/                    ",'" . $rows[$nom_columnas['Talla2']] . "'" .
                /*V_TALLA3*/                    ",'" . $rows[$nom_columnas['Talla3']] . "'" .
                /*V_TALLA4*/                    ",'" . $rows[$nom_columnas['Talla4']] . "'" .
                /*V_TALLA5*/                    ",'" . $rows[$nom_columnas['Talla5']] . "'" .
                /*V_TALLA6*/                    ",'" . $rows[$nom_columnas['Talla6']] . "'" .
                /*V_TALLA7*/                    ",'" . $rows[$nom_columnas['Talla7']] . "'" .
                /*V_TALLA8*/                    ",'" . $rows[$nom_columnas['Talla8']] . "'" .
                /*V_TALLA9*/                    ",'" . $rows[$nom_columnas['Talla9']] . "'" .
                /*V_INNER*/                     ",'" . ($rows[$nom_columnas['Inner'] ]<> null ? ($rows[$nom_columnas['Inner']]) : 0)  . "'" .
                /*V_CURVA1*/                    ","  . ($rows[$nom_columnas['Curva1'] ]<> null ? ($rows[$nom_columnas['Curva1']]) : 0)  . "" .
                /*V_CURVA2*/                    ","  . ($rows[$nom_columnas['Curva2'] ]<> null ? ($rows[$nom_columnas['Curva2']]) : 0)  . "" .
                /*V_CURVA3*/                    ","  . ($rows[$nom_columnas['Curva3'] ]<> null ? ($rows[$nom_columnas['Curva3']]) : 0)  . "" .
                /*V_CURVA4*/                    ","  . ($rows[$nom_columnas['Curva4'] ]<> null ? ($rows[$nom_columnas['Curva4']]) : 0)  . "" .
                /*V_CURVA5*/                    ","  . ($rows[$nom_columnas['Curva5'] ]<> null ? ($rows[$nom_columnas['Curva5']]) : 0)  . "" .
                /*V_CURVA6*/                    ","  . ($rows[$nom_columnas['Curva6'] ]<> null ? ($rows[$nom_columnas['Curva6']]) : 0)  . "" .
                /*V_CURVA7*/                    ","  . ($rows[$nom_columnas['Curva7'] ]<> null ? ($rows[$nom_columnas['Curva7']]) : 0)  . "" .
                /*V_CURVA8*/                    ","  . ($rows[$nom_columnas['Curva8'] ]<> null ? ($rows[$nom_columnas['Curva8']]) : 0)  . "" .
                /*V_CURVA9*/                    ","  . ($rows[$nom_columnas['Curva9'] ]<> null ? ($rows[$nom_columnas['Curva9']]) : 0)  . "" .
                /*V_Validador_Masterpack_Inner*/",'"  . $rows[$nom_columnas['Validador Masterpack/Inner']]  . "'" .
                /*V_TIPO_DE_EMPAQUE*/           ",'" . $rows[$nom_columnas['Tipo de empaque']] . "'" .
                /*V_N_CURVAS_POR_CAJA_CURVADAS*/","  . ($rows[$nom_columnas['N curvas por caja curvadas']]<> null ? ($rows[$nom_columnas['N curvas por caja curvadas']]) : 0)  . "" .
                /*V_UNO_POR*/                   ",'" . $rows[$nom_columnas['1_%']] . "'" .
                /*V_DOS_POR*/                   ",'" . $rows[$nom_columnas['2_%']] . "'" .
                /*V_TRES_POR*/                  ",'" . $rows[$nom_columnas['3_%']] . "'" .
                /*V_CUATRO_POR*/                ",'" . $rows[$nom_columnas['4_%']] . "'" .
                /*V_CINCO_POR*/                 ",'" . $rows[$nom_columnas['5_%']] . "'" .
                /*V_SEIS_POR*/                  ",'" . $rows[$nom_columnas['6_%']] . "'" .
                /*V_SIETE_POR*/                 ",'" . $rows[$nom_columnas['7_%']] . "'" .
                /*V_OCHO_POR*/                  ",'" . $rows[$nom_columnas['8_%']] . "'" .
                /*V_NUEVE_POR*/                 ",'" . $rows[$nom_columnas['9_%']] . "'" .
                /*V_TIENDASA*/                  ","  . ($rows[$nom_columnas['TiendasA'] ]<> null ? ($rows[$nom_columnas['TiendasA']]) : 0)  . "" .
                /*V_TIENDASB*/                  ","  . ($rows[$nom_columnas['TiendasB'] ]<> null ? ($rows[$nom_columnas['TiendasB']]) : 0)  . "" .
                /*V_TIENDASC*/                  ","  . ($rows[$nom_columnas['TiendasC'] ]<> null ? ($rows[$nom_columnas['TiendasC']]) : 0)  . "" .
                /*V_TIENDASI*/                  ","  . ($rows[$nom_columnas['TiendasI'] ]<> null ? ($rows[$nom_columnas['TiendasI']]) : 0)  . "" .
                /*V_CLUSTERA*/                  ","  . ($rows[$nom_columnas['ClusterA'] ]<> null ? ($rows[$nom_columnas['ClusterA']]) : 0)  . "" .
                /*V_CLUSTERB*/                  ","  . ($rows[$nom_columnas['ClusterB'] ]<> null ? ($rows[$nom_columnas['ClusterB']]) : 0)  . "" .
                /*V_CLUSTERC*/                  ","  . ($rows[$nom_columnas['ClusterC'] ]<> null ? ($rows[$nom_columnas['ClusterC']]) : 0)  . "" .
                /*V_CLUSTERI*/                  ","  . ($rows[$nom_columnas['ClusterI'] ]<> null ? ($rows[$nom_columnas['ClusterI']]) : 0)  . "" .
                /*V_Size_1*/                    ",'" . $rows[$nom_columnas['Size%1']] . "'" .
                /*V_Size_2*/                    ",'" . $rows[$nom_columnas['Size%2']] . "'" .
                /*V_Size_3*/                    ",'" . $rows[$nom_columnas['Size%3']] . "'" .
                /*V_Size_4*/                    ",'" . $rows[$nom_columnas['Size%4']] . "'" .
                /*V_Size_5*/                    ",'" . $rows[$nom_columnas['Size%5']] . "'" .
                /*V_Size_6*/                    ",'" . $rows[$nom_columnas['Size%6']] . "'" .
                /*V_Size_7*/                    ",'" . $rows[$nom_columnas['Size%7']] . "'" .
                /*V_Size_8*/                    ",'" . $rows[$nom_columnas['Size%8']] . "'" .
                /*V_Size_9*/                    ",'" . $rows[$nom_columnas['Size%9']] . "'" .
                /*V_VENTA*/                     ","  . ($rows[$nom_columnas['VentA'] ]<> null ? ($rows[$nom_columnas['VentA']]) : 0)  . "" .
                /*V_VENTB*/                     ","  . ($rows[$nom_columnas['VentB'] ]<> null ? ($rows[$nom_columnas['VentB']]) : 0)  . "" .
                /*V_VENTC*/                     ","  . ($rows[$nom_columnas['VentC'] ]<> null ? ($rows[$nom_columnas['VentC']]) : 0)  . "" .
                /*V_VENTD*/                     ","  . ($rows[$nom_columnas['VentD'] ]<> null ? ($rows[$nom_columnas['VentD']]) : 0)  . "" .
                /*V_VENTE*/                     ","  . ($rows[$nom_columnas['VentE'] ]<> null ? ($rows[$nom_columnas['VentE']]) : 0)  . "" .
                /*V_VENTF*/                     ","  . ($rows[$nom_columnas['VentF'] ]<> null ? ($rows[$nom_columnas['VentF']]) : 0)  . "" .
                /*V_VENTG*/                     ","  . ($rows[$nom_columnas['VentG'] ]<> null ? ($rows[$nom_columnas['VentG']]) : 0)  . "" .
                /*V_VENTH*/                     ","  . ($rows[$nom_columnas['VentH'] ]<> null ? ($rows[$nom_columnas['VentH']]) : 0)  . "" .
                /*V_VENTI*/                     ","  . ($rows[$nom_columnas['VentI'] ]<> null ? ($rows[$nom_columnas['VentI']]) : 0)  . "" .
                /*V_COD_OPCION*/                ",'" . $rows[$nom_columnas['Cod Opcion']] . "'" .", :error, :data); end;");


        $data = \database::getInstancia()->getConsultaSP($sql, 2);



        $_error = explode("#", $data);
        if ($_error[0] == 1 ){
            $array = array('Tipo' => FALSE,
                'Error'=> "Error en el Insertado Historico =|".$_error[1]."|");
            return $array;
        }else{
            $array = array('Tipo' => TRUE,
                'Error'=> "(".''.") -> ".''."");
            return $array;
        }

    }
    public static function InsertPlanCompraAssorment2($rows,$nom_columnas,$cod_tempo,$depto,$login){
        $_insert = true;
        $sql = "begin PLC_PKG_GENERAL.PRC_ADD_PLAN_COMPRA_COLOR_3" .
            /*V_COD_TEMPORADA*/      ("('" . $cod_tempo . "'" .
                /*V_DEP_DEPTO*/             ",'" . $depto . "'" .
                /*V_NIV_JER1*/              ",0" .
                /*V_COD_JER1*/              ",0" .
                /*V_NIV_JER2*/              ",0" .
                /*V_COD_JER2*/              ",'" . $rows[$nom_columnas['Cod Linea']] . "'" .
                /*V_ITEM*/                  ",0" .
                /*V_COD_SUBLIN*/            ",'" . $rows[$nom_columnas['Cod Sublinea']] . "'" .
                /*V_COD_ESTILO*/            ",0" .
                /*V_EstiloReal*/            ",'" . utf8_encode($rows[$nom_columnas['Nombre Estilo']]) . "'" .
                /*V_COD_COLOR*/             ","  . $rows[$nom_columnas['Cod Color']] . "" .
                /*V_COD_PIRAMIX*/           ","  . $rows[$nom_columnas['cod_piramidemix']] . "" .
                /*V_PORCENTAJE*/            ",0" .
                /*V_UNIDADES*/              ","  . $rows[$nom_columnas['und_finales']] . "" . /*-Unidades finales-*/
                /*V_USR_CRE*/               ",'" . $login . "'" .
                /*V_USR_MOD*/               ",'" . $login . "'" .
                /*V_SEM_INI*/               ",'" . $rows[$nom_columnas['Sem_ini']] . "'" .
                /*V_SEM_FIN*/               ",'" . $rows[$nom_columnas['sem_fin']]  . "'" .
                /*V_CICLO*/                 ",'" . $rows[$nom_columnas['ciclo']] . "'" .
                /*V_TIPO_CURVA*/            ",0" .
                /*V_NUM_EMB*/               ",'" . $rows[$nom_columnas['Cod Opcion']] . "'" .
                /*V_EMB_MIN*/               ",0" .
                /*V_EMB_MAX*/               ",0" .
                /*V_COB_CALC*/              ",0" .
                /*V_FLAG_EMB_MANUAL*/       ",0" .
                /*V_VENT_HAB_INI*/          ",'" . "" . "'" .
                /*V_VENT_HAB_FIN*/          ",'" . "" . "'" .
                /*V_COD_RANKVTA*/           ","  . $rows[$nom_columnas['cod_rnk']]  . "" .
                /*V_DSCTO_OBJ*/             ",0" .
                /*V_DSCTO_PROM*/            ",0" .
                /*V_STK_MIN*/               ",0" .
                /*V_SEG_ASIG*/              ",'" . $rows[$nom_columnas['Cluster']] . "'" .
                /*V_TDAS*/                  ","  . $rows[$nom_columnas['n_tdas']] . "" .//falto el array numero de tiendas
                /*V_UND_ASIG*/              ",0" .
                /*V_ROT*/                   ","  . $rows[$nom_columnas['tdas']] .""./*%tienda*/
                /*V_TIPO_CICLO*/            ",0" .
                /*V_INDICE*/                ",0" .
                /*V_GM*/                    ","  . $rows[$nom_columnas['GM']] ."".
                /*V_ID*/                    ",0" .
                /*V_TIPO_DSCTO*/            ",0" .
                /*V_RATIO*/                 ",0" .
                /*V_UNDWHITAKER*/           ",0" .
                /*V_EVENTO*/                ",'" . $rows[$nom_columnas['Evento']] ."'".
                /*V_GMB*/                   ",0" .
                /*V_VENT_EMB*/              ","  . $rows[$nom_columnas['cod_vent']]. "" .
                /*V_AGOT_OBJ*/              ",0.7".
                /*V_SEMLIQ*/                ","  . $rows[$nom_columnas['semliq']] . "" .
                /*V_COSTO_UNIT*/            ","  . $rows[$nom_columnas['cos_uni_finalUS']].""./*-COSTO UNITARIO FINAL US$-*/
                /*V_COSTO_UNITH*/           ",0" .
                /*V_COSTO_TOT*/             ",0" . /*-TOTAL FOB US$-*/
                /*V_COSTO_TOTH*/            ",0" .
                /*V_PRECIO_BLANCO*/         ","  . $rows[$nom_columnas['Precio']] . "" .
                /*V_PRECIO_BLANCOH*/        ",0" .
                /*V_COSTO_FOB*/             ",0" .
                /*V_COSTO_INSP*/            ",0" .
                /*V_COSTO_HANGER*/          ",0" .
                /*V_COSTO_STICKER*/         ",0" .
                /*V_DUMPING_POR*/           ",0" .
                /*V_DUMPING_DOL*/           ",0" .
                /*V_TRADER_POR*/            ",0" .
                /*V_TRADER_DOL*/            ",0" .
                /*V_ROYALTY_POR*/           ",0" .
                /*V_ROYALTY_DOL*/           ",0" .
                /*V_COSTO_TARGET*/          ","  . $rows[$nom_columnas['Target USD']] . "" .
                /*V_ESTADO*/                ",0" .
                /*V_EQUIV*/                 ",''".
                /*V_ESTADOCICLO*/           ",0" .
                /*V_ESTADODIST*/            ",0" .
                /*V_COSTO_UNITS*/           ","  . $rows[$nom_columnas['cos_uni_final$']]. "" ./*-COSTO UNITARIO FINAL PESOS-*/
                /*V_COSTO_TOTS*/            ","  . $rows[$nom_columnas['cos_total_$']]."". /*-CALCULO COSTO TOTAL PESOS$-*/
                /*V_BOLSA*/                 ",0" .
                /*V_ITEM_REF*/              ",0" .
                /*V_LIFE_CYCLE*/            ","  . $rows[$nom_columnas['cod_ciclo_vida']] . "" .
                /*V_VENT_REAL*/             ",'" . $rows[$nom_columnas['Ventana Debut']] . "'" .
                /*V_RETAIL*/                ","  . $rows[$nom_columnas['cos_retail']] . "" .  /*-RETAIL-*/
                /*V_FORMATO*/               ",'" . $rows[$nom_columnas['Formato']] . "'" .
                /*V_DEBUT_REODER*/          ",'" . $rows[$nom_columnas['Debut o Reorder']] . "'" .
                /*V_ID_COMPRA*/             ",0" .
                /*V_TIPO_PRODUCTO*/         ",'" . $rows[$nom_columnas['Tipo Producto']] . "'" .
                /*V_TIPO_EXHIBICION*/       ",'" . $rows[$nom_columnas['Tipo exhibicion']] . "'" .
                /*V_ID_CORPORATIVO*/        ",'" . $rows[$nom_columnas['Codigo corporativo']] . "'" .
                /*V_MTR_PACK*/              ","  . $rows[$nom_columnas['mst_pack']] . "" .
                /*V_MKUP*/                  ","  . $rows[$nom_columnas['mkup']]   . "" .
                /*V_CODSKUPROVEEDOR*/       ",0" .
                /*V_GRUPO_COMPRA*/          ",'" . $rows[$nom_columnas['Grupo de compra']] . "'" .
                /*V_PROFORMA*/              ",0" .
                /*V_PORTALLAS*/             ",0" .
                /*V_PROCEDENCIA*/           ",1" .
                /*V_VIA*/                   ","  . $rows[$nom_columnas['cod_via']] . "" .
                /*V_PAIS*/                  ","  . $rows[$nom_columnas['cod_pais']] . "" .
                /*V_VIAJE*/                 ",0" .
                /*V_CST_TOTLTARGET*/        ","  . $rows[$nom_columnas['cos_total_target']] .""./*-COSTO TOTAL TARGET.-*/
                /*V_CANT_INNER*/            ","  . $rows[$nom_columnas['n_cajas']]. "" ./*-N_CAJAS.-*/
                /*V_UNID_OPCION_INICIO*/    ","  . $rows[$nom_columnas['Unidades']] . "" .
                /*V_UND_ASIG_INI*/          ","  . $rows[$nom_columnas['primer_reparto']] . "" . /*-Primera_Reparto.-*/
                /*V_DESTALLA*/              ",'" . $rows[$nom_columnas['tallas']] . "'" .
                /*V_CURVATALLA*/            ",'" . $rows[$nom_columnas['curva_reparto']] . "'" .
                /*V_PORTALLA*/              ",0" .
                /*V_PORTALLA_1*/            ",'" . $rows[$nom_columnas['porcent_ajust']]. "'" ./*-Porcentaje Ajustada-*/
                /*V_CURVAMIN*/              ","  . $rows[$nom_columnas['Inner']] . "" .
                /*V_DIST*/                  ",0" .
                /*V_COMPOSICION*/           ",0" .
                /*V_TEMP*/                  ","  . $rows[$nom_columnas['cod_temp']] . "" .
                /*V_COLECCION*/             ",0" .
                /*V_COD_ESTILO_VIDA*/       ",0" .
                /*V_DESCMODELO*/            ",'" . utf8_encode($rows[$nom_columnas['Descripcion Estilo']]) . "'" .
                /*V_CALIDAD*/               ",0" .
                /*V_COD_OCASION_USO*/       ",0" .
                /*V_ALIAS_PROV*/            ",0" .
                /*V_COD_PROVEEDOR*/         ",0" .
                /*V_COD_TRADER*/            ",0" .
                /*V_A*/                     ","  . ($rows[$nom_columnas['ClusterA']] <> null ? ($rows[$nom_columnas['ClusterA']]) : 0). "" .
                /*V_B*/                     ","  . ($rows[$nom_columnas['ClusterB']] <> null ? ($rows[$nom_columnas['ClusterB']]) : 0) . "" .
                /*V_C*/                     ","  . ($rows[$nom_columnas['ClusterC']] <> null ? ($rows[$nom_columnas['ClusterC']]) : 0) . "" .
                /*V_DIFER_REPARTO*/         ","  . $rows[$nom_columnas['diferencia']]  . "" ./*-DIFERENCIA-*/
                /*V_ID_COLOR3*/             ","  . $rows[$nom_columnas['id_color3']] . "" .
                /*V_COD_TIP_MON*/           ","  . 2 . "" .
                /*V_COD_MARCA*/             ","  . $rows[$nom_columnas['Codigo Marca']] . "" .
                /*V_FACTOR_EST*/            ",0" .
                /*V_NOM_GRUPOCOMPRA*/       ",'" . $rows[$nom_columnas['Grupo de compra']] . "'" .
                /*V_NOM_TEMP*/              ",'" . $rows[$nom_columnas['Temporada']] . "'" .
                /*V_NOM_LINEA*/             ",'" . utf8_encode($rows[$nom_columnas['nom_linea']]) . "'" .
                /*V_NOM_SUBLINEA*/          ",'" . utf8_encode($rows[$nom_columnas['nom_sublinea']]) . "'" .
                /*V_NOM_MARCA*/             ",'" . utf8_encode($rows[$nom_columnas['nom_marca']]) . "'" .
                /*V_NOM_ESTILOVIDA*/        ",''".
                /*V_NOM_CALIDAD*/           ",''".
                /*V_NOM_OCACIONUSO*/        ",''".
                /*V_NOM_PIRAMIDEMIX*/       ",'" . $rows[$nom_columnas['Piramide Mix']] . "'" .
                /*V_NOM_VENTANA*/           ",'" . $rows[$nom_columnas['Ventana Debut']] . "'" .
                /*V_NOM_LIFECYCLE*/         ",'" . $rows[$nom_columnas['Ciclo de Vida']] . "'" .
                /*V_NOM_COLOR*/             ",'" . $rows[$nom_columnas['Color']] . "'" .
                /*V_NOM_PROCEDENCIA*/       ",'IMP'".
                /*V_NOM_VIA*/               ",'" . utf8_encode($rows[$nom_columnas['Via']]) . "'" .
                /*V_NOM_PAIS*/              ",'" . utf8_encode($rows[$nom_columnas['Pais']]) . "'" .
                /*V_NOM_MONEDA*/            ",'USD'".
                /*V_NOM_RAZONSOCIAL*/       ",''".
                /*V_NOM_TRADER*/            ",''".
                /*V_NOM_RNK*/               ",'" . $rows[$nom_columnas['Ranking de venta']] . "'" .
                /*V_TALLA1*/                ",'" . $rows[$nom_columnas['Talla1']] . "'" .
                /*V_TALLA2*/                ",'" . $rows[$nom_columnas['Talla2']] . "'" .
                /*V_TALLA3*/                ",'" . $rows[$nom_columnas['Talla3']] . "'" .
                /*V_TALLA4*/                ",'" . $rows[$nom_columnas['Talla4']] . "'" .
                /*V_TALLA5*/                ",'" . $rows[$nom_columnas['Talla5']] . "'" .
                /*V_TALLA6*/                ",'" . $rows[$nom_columnas['Talla6']] . "'" .
                /*V_TALLA7*/                ",'" . $rows[$nom_columnas['Talla7']] . "'" .
                /*V_TALLA8*/                ",'" . $rows[$nom_columnas['Talla8']] . "'" .
                /*V_TALLA9*/                ",'" . $rows[$nom_columnas['Talla9']] . "'" .
                /*V_TALLA10*/               ",0" .
                /*V_TALLA11*/               ",0" .
                /*V_TALLA12*/               ",0" .
                /*V_TALLA13*/               ",0" .
                /*V_TALLA14*/               ",0" .
                /*V_TALLA15*/               ",0" .
                /*V_CURV1*/                 ","  . ($rows[$nom_columnas['Curva1'] ]<> null ? ($rows[$nom_columnas['Curva1']]) : 0) . "" .
                /*V_CURV2*/                 ","  . ($rows[$nom_columnas['Curva2']] <> null ? ($rows[$nom_columnas['Curva2']]) : 0) . "" .
                /*V_CURV3*/                 ","  . ($rows[$nom_columnas['Curva3']] <> null ? ($rows[$nom_columnas['Curva3']]) : 0) . "" .
                /*V_CURV4*/                 ","  . ($rows[$nom_columnas['Curva4']] <> null ? ($rows[$nom_columnas['Curva4']]) : 0) . "" .
                /*V_CURV5*/                 ","  . ($rows[$nom_columnas['Curva5']] <> null ? ($rows[$nom_columnas['Curva5']]) : 0) . "" .
                /*V_CURV6*/                 ","  . ($rows[$nom_columnas['Curva6']] <> null ? ($rows[$nom_columnas['Curva6']]) : 0) . "" .
                /*V_CURV7*/                 ","  . ($rows[$nom_columnas['Curva7']] <> null ? ($rows[$nom_columnas['Curva7']]) : 0) . "" .
                /*V_CURV8*/                 ","  . ($rows[$nom_columnas['Curva8']] <> null ? ($rows[$nom_columnas['Curva8']]) : 0) . "" .
                /*V_CURV9*/                 ","  . ($rows[$nom_columnas['Curva9']] <> null ? ($rows[$nom_columnas['Curva9']]) : 0). "" .
                /*V_CURV10*/                ",0" .
                /*V_CURV11*/                ",0" .
                /*V_CURV12*/                ",0" .
                /*V_CURV13*/                ",0" .
                /*V_CURV14*/                ",0" .
                /*V_CURV15*/                ",0" .
                /*V_PORCEN_T1*/             ",'"  . $rows[$nom_columnas['porcent_1']] . "'" .
                /*V_PORCEN_T2*/             ",'"  . $rows[$nom_columnas['porcent_2']]  . "'" .
                /*V_PORCEN_T3*/             ",'"  . $rows[$nom_columnas['porcent_3']]  . "'" .
                /*V_PORCEN_T4*/             ",'"  . $rows[$nom_columnas['porcent_4']]  . "'" .
                /*V_PORCEN_T5*/             ",'"  . $rows[$nom_columnas['porcent_5']]  . "'" .
                /*V_PORCEN_T6*/             ",'"  . $rows[$nom_columnas['porcent_6']]  . "'" .
                /*V_PORCEN_T7*/             ",'"  . $rows[$nom_columnas['porcent_7']]  . "'" .
                /*V_PORCEN_T8*/             ",'"  . $rows[$nom_columnas['porcent_8']] . "'" .
                /*V_PORCEN_T9*/             ",'"  . $rows[$nom_columnas['porcent_9']] . "'" .
                /*V_PORCEN_T10*/            ",0" .
                /*V_PORCEN_T11*/            ",0" .
                /*V_PORCEN_T12*/            ",0" .
                /*V_PORCEN_T13*/            ",0" .
                /*V_PORCEN_T14*/            ",0" .
                /*V_PORCEN_T15*/            ",0" .
                /*V_CANT_T1*/               ","  . $rows[$nom_columnas['cant_1']]   . "" .
                /*V_CANT_T2*/               ","  . $rows[$nom_columnas['cant_2']]   . "" .
                /*V_CANT_T3*/               ","  . $rows[$nom_columnas['cant_3']]   . "" .
                /*V_CANT_T4*/               ","  . $rows[$nom_columnas['cant_4']]   . "" .
                /*V_CANT_T5*/               ","  . $rows[$nom_columnas['cant_5']]   . "" .
                /*V_CANT_T6*/               ","  . $rows[$nom_columnas['cant_6']]   . "" .
                /*V_CANT_T7*/               ","  . $rows[$nom_columnas['cant_7']]  . "" .
                /*V_CANT_T8*/               ","  . $rows[$nom_columnas['cant_8']]   . "" .
                /*V_CANT_T9*/               ","  . $rows[$nom_columnas['cant_9']]   . "" .
                /*V_CANT_T10*/              ",0" .
                /*V_CANT_T11*/              ",0" .
                /*V_CANT_T12*/              ",0" .
                /*V_CANT_T13*/              ",0" .
                /*V_CANT_T14*/              ",0" .
                /*V_CANT_T15*/              ",0" .
                /*V_PORTALLA_1_INI*/        ",'" . $rows[$nom_columnas['porcent_ini']] . "'" .
                /*V_OPCION_AJUSTADO*/       ","  . $rows[$nom_columnas['opcion_ajus']] ."".
                /*V_TIPO_EMPAQUE*/          ",'" . trim(strtoupper($rows[$nom_columnas['Tipo de empaque']])) . "'" .
                /*V_CURVA_COMPRA*/          ",0" .
                /*V_I*/                     ","  . $rows[$nom_columnas['ClusterI']]. "" .
                /*V_INTERNET_DESCRIPTION*/  ",''".
                /*V_COSTO_RFID*/            ","  . ($rows[$nom_columnas['RFID USD']]<> null ? ($rows[$nom_columnas['RFID USD']]) : 0). "" .
                /*V_ERROR_PI*/              ",''".
                /*V_SHORT_NAME*/            ",'" . $rows[$nom_columnas['Estilo Corto']] . "'".
                /*V_N_CURVASXCAJAS*/        ","  . ($rows[$nom_columnas['N curvas por caja curvadas'] ]<> null ? ($rows[$nom_columnas['N curvas por caja curvadas']]) : 0). ", :error, :data); end;");

        $data = \database::getInstancia()->getConsultaSP($sql, 2);


        $_error = explode("#", $data);
        if ($_error[0] == 1 ){
            $_insert = false;
            $array = array('Tipo' => FALSE,
                'Error'=> "Guardado Plan de Compra =|".$_error[1]."|");
        }

        if ($_insert <> false){
            $sql = "begin PLC_PKG_UTILS.PRC_ADD_PLAN_COMPRA_COLOR_CIC" .
                /*V_COD_TEMPORADA*/     ("('" . $cod_tempo . "'" .
                    /*V_DEP_DEPTO*/             ",'" . $depto . "'" .
                    /*V_NIV_JER1*/              ",0" .
                    /*V_COD_JER1*/              ",0" .
                    /*V_NIV_JER2*/              ",0" .
                    /*V_COD_JER2*/              ",'" . $rows[$nom_columnas['Cod Linea']] . "'" .
                    /*V_ITEM*/                  ",0" .
                    /*V_COD_SUBLIN*/            ",'" . $rows[$nom_columnas['Cod Sublinea']] . "'" .
                    /*V_COD_ESTILO*/            ",0" .
                    /*V_EstiloReal*/            ",'" . utf8_encode($rows[$nom_columnas['Nombre Estilo']]) . "'" .
                    /*V_COD_COLOR*/             ","  . $rows[$nom_columnas['Cod Color']] . "" .
                    /*V_SEMANA*/                ",0" .
                    /*V_POR_AGOT*/              ",0" .
                    /*V_UNID_AGOT*/             ",0" .
                    /*V_USR_CRE*/               ",'" . $login . "'" .
                    /*V_USR_MOD*/               ",'" . $login . "'" .
                    /*V_POR_ROT*/               ",0" .
                    /*V_POR_DSCTO*/             ",0" .
                    /*V_UNID_ROT*/              ",0" .
                    /*V_VTA_SIGV*/              ",0" .
                    /*V_COSTO*/                 ","  . $rows[$nom_columnas['cos_total_$']]."".
                    /*V_VTA_CDSCTO*/            ","  . $rows[$nom_columnas['cos_retail']] . "" .
                    /*V_GM*/                    ","  . $rows[$nom_columnas['GM']] ."".
                    /*V_PERIODO*/               ","  . $rows[$nom_columnas['cod_vent']]  . "" .
                    /*V_SEM_CORTA*/             ",0" .
                    /*V_ID*/                    ",0" .
                    /*V_ID_COLOR3*/             ","  . $rows[$nom_columnas['id_color3']] . ", :error, :data); end;");

            $data = \database::getInstancia()->getConsultaSP($sql, 2);
            $_error = explode("#", $data);
            if ($_error[0] == 1 ){
                $_insert = false;
                $array = array('Tipo' => FALSE,
                    'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error[1]."|");
            }
        }


        if ($_insert <> false){
            $sql = "begin PLC_PKG_PRUEBA.PRC_ADD_PLAN_HISTORICO" .
                /*V_TEMP*/         ("('" . $cod_tempo . "'" .
                    /*V_DPTO*/          ",'" . $depto . "'" .
                    /*V_LINEA*/         ",'" . $rows[$nom_columnas['Cod Linea']] . "'" .
                    /*V_SUBLINEA*/      ",'" . $rows[$nom_columnas['Cod Sublinea']] . "'" .
                    /*V_MARCA*/         ","  . $rows[$nom_columnas['Codigo Marca']] . "" .
                    /*V_ESTILO*/        ",'" . utf8_encode($rows[$nom_columnas['Nombre Estilo']]) . "'" .
                    /*V_VENTANA*/       ","  . $rows[$nom_columnas['cod_vent']] . "" .
                    /*V_COLOR*/         ","  . $rows[$nom_columnas['Cod Color']] . "" .
                    /*V_USER_LOGIN*/    ",'" . $login . "'" .
                    /*V_PI*/            ",0" .
                    /*V_OC*/            ",0" .
                    /*V_ESTADO*/        ",0" .
                    /*V_ID_COLOR3*/     ","  . $rows[$nom_columnas['id_color3']] . "" .
                    /*V_TIPOINSERT*/    ",1" .
                    /*V_NOM_LINEA*/     ",'" . $rows[$nom_columnas['nom_linea']]  . "'" .
                    /*V_NOM_SUBLINEA*/  ",'" . $rows[$nom_columnas['nom_sublinea']] . "'" .
                    /*V_NOM_MARCA*/     ",'" . $rows[$nom_columnas['nom_marca']]. "'" .
                    /*V_NOM_VENTANA*/   ",'" . $rows[$nom_columnas['Ventana Debut']] . "'" .
                    /*V_NOM_COLOR*/     ",'" . $rows[$nom_columnas['Color']] . "', :error, :data); end;");
            $data = \database::getInstancia()->getConsultaSP($sql, 2);
            $_error = explode("#", $data);
            if ($_error[0] == 1 ){
                $_insert = false;
                $array = array('Tipo' => FALSE,
                    'Error'=> "Guardado historial C1 =|".$_error[1]."|");
            }
        }

        if ($_insert == false ){
            return $array;

        }else{
            $array = array('Tipo' => TRUE,
                'Error'=> "(".''.") -> ".''."");
            return $array;
        };

    }
    public static function SaveAjuste_Compra2($dtTabla, $dtTablaCurvado,$dtTablasSolidoCurvado,$dtTablasolidoFULL,$dtTablaReorder,$DEBUT,$Tipo_empaque,$id_color3,$Tallas,$cod_tempo,$depto){
        $N_Columna = count(explode(",", trim($Tallas)));
        $tallas2 = explode(",", trim($Tallas));
        $key = 0;$columnas = "";

        $_logquery = [];

        if(strtoupper($DEBUT) == "DEBUT" AND strtoupper($Tipo_empaque) == "CURVADO"){
            //Guardado Ajuste de compra.
            foreach ($dtTabla as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Curva de Compra";}elseif($key ==2){$columnas = "Curva Primer Reparto";}elseif($key ==3){$columnas = "Diferencial";}elseif($key ==4){$columnas = "Total";}elseif($key ==5){$columnas = "Curva de compra Ajustada";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "select   " . $cod_tempo . ",'" . $depto . "','" . $id_color3 . "','" . $Tipo_empaque . "','" . $DEBUT . "','" . $columnas . "','" . $Tallas . "'," . $tallas3[0] . "," . $tallas3[1] . "," . $tallas3[2] . "," . $tallas3[3] . "," . $tallas3[4] . "," . $tallas3[5] . "," . $tallas3[6] . "," . $tallas3[7] . "," . $tallas3[8] . "," . $val[$N_Columna] .",'Ajuste de Compra',SYSDATE  from dual union ";
                    array_push($_logquery,$sql);
                }
                $key +=1;
            }$key = 0;
            //Guardado Ajuste de Curvado.
            foreach ($dtTablaCurvado as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Compra Total";}elseif($key ==2){$columnas = "1er Reparto";}elseif($key ==3){$columnas = "Curva 1er Reparto";}elseif($key ==4){$columnas = "Master Curvado";}elseif($key ==5){$columnas = "Curvas a repartir";}elseif($key ==6){$columnas = "N de Cajas";}elseif($key ==7){$columnas = "N de curvas x cajas";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "select   " . $cod_tempo . ",'" . $depto . "','" . $id_color3 . "','" . $Tipo_empaque . "','" . $DEBUT . "','" . $columnas . "','" . $Tallas . "'," . $tallas3[0] . "," . $tallas3[1] . "," . $tallas3[2] . "," . $tallas3[3] . "," . $tallas3[4] . "," . $tallas3[5] . "," . $tallas3[6] . "," . $tallas3[7] . "," . $tallas3[8] . "," . $val[$N_Columna] . ",'Ajuste Curvado',SYSDATE  from dual union ";
                    array_push($_logquery,$sql);
                }
                $key +=1;
            }$key = 0;
            //Guardado Ajuste de Solido Curvado.
            foreach ($dtTablasSolidoCurvado as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Total Solido";}elseif($key ==2){$columnas = "N Cajas";}elseif($key ==3){$columnas = "Total Solido Ajustado";}elseif($key ==4){$columnas = "Master Pack";}elseif($key ==5){$columnas = "Total Unidades Final";}elseif($key ==6){$columnas = "Total N Cajas Final";}elseif($key ==7){$columnas = "Total Porcentajes Ajust Final";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "select   " . $cod_tempo . ",'" . $depto . "','" . $id_color3 . "','" . $Tipo_empaque . "','" . $DEBUT . "','" . $columnas . "','" . $Tallas . "'," . $tallas3[0] . "," . $tallas3[1] . "," . $tallas3[2] . "," . $tallas3[3] . "," . $tallas3[4] . "," . $tallas3[5] . "," . $tallas3[6] . "," . $tallas3[7] . "," . $tallas3[8] . "," . $val[$N_Columna] .",'Solido Curvado',SYSDATE  from dual union ";
                    array_push($_logquery,$sql);
                }
                $key +=1;
            }

            // $dtTabla,$dtTablaCurvado,$dtTablasSolidoCurvado
        }
        elseif(strtoupper($DEBUT) == "DEBUT" and strtoupper($Tipo_empaque) == "SOLIDO" ){
            //Guardado Ajuste de compra.
            foreach ($dtTabla as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Curva de Compra";}elseif($key ==2){$columnas = "Curva Primer Reparto";}elseif($key ==3){$columnas = "Diferencial";}elseif($key ==4){$columnas = "Total";}elseif($key ==5){$columnas = "Curva de compra Ajustada";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "select   " . $cod_tempo . ",'" . $depto . "','" . $id_color3 . "','" . $Tipo_empaque . "','" . $DEBUT . "','" . $columnas . "','" . $Tallas . "'," . $tallas3[0] . "," . $tallas3[1] . "," . $tallas3[2] . "," . $tallas3[3] . "," . $tallas3[4] . "," . $tallas3[5] . "," . $tallas3[6] . "," . $tallas3[7] . "," . $tallas3[8] . "," . $val[$N_Columna] .",'Ajuste de Compra',SYSDATE  from dual union ";
                    array_push($_logquery,$sql);
                }
                $key +=1;
            }$key = 0;
            //Guardado Ajuste mst pack.
            foreach ($dtTablasolidoFULL as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Unid Ini";}elseif($key ==2){$columnas = "Primer Reparto";}elseif($key ==3){$columnas = "Master Pack";}elseif($key ==4){$columnas = "N Cajas";}elseif($key ==5){$columnas = "Unid Final";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "select   " . $cod_tempo . ",'" . $depto . "','" . $id_color3 . "','" . $Tipo_empaque . "','" . $DEBUT . "','" . $columnas . "','" . $Tallas . "'," . $tallas3[0] . "," . $tallas3[1] . "," . $tallas3[2] . "," . $tallas3[3] . "," . $tallas3[4] . "," . $tallas3[5] . "," . $tallas3[6] . "," . $tallas3[7] . "," . $tallas3[8] . "," . $val[$N_Columna] .",'Ajuste Master Pack',SYSDATE  from dual union ";
                    array_push($_logquery,$sql);
                }
                $key +=1;
            }

        }elseif (strtoupper($DEBUT) == "REORDER"){
            //Guardado Ajuste mst pack.
            foreach ($dtTablaReorder as $val){
                if ($key <> 0){
                    //columnas
                    if ($key ==1){$columnas = "Unid Ini";}elseif($key ==2){$columnas = "N Cajas";}elseif($key ==3){$columnas = "Und Final";}elseif($key ==4){$columnas = "Mst Pack";}
                    $tallas3 = plan_compra::Division_tallas($tallas2,$val);
                    $sql = "select   " . $cod_tempo . ",'" . $depto . "','" . $id_color3 . "','" . $Tipo_empaque . "','" . $DEBUT . "','" . $columnas . "','" . $Tallas . "'," . $tallas3[0] . "," . $tallas3[1] . "," . $tallas3[2] . "," . $tallas3[3] . "," . $tallas3[4] . "," . $tallas3[5] . "," . $tallas3[6] . "," . $tallas3[7] . "," . $tallas3[8] . "," . $val[$N_Columna] .",'Ajuste Master Pack',SYSDATE  from dual union ";
                    array_push($_logquery,$sql);
                }
                $key +=1;
            }
        }
        return $_logquery;
    }
    public static function InsertAjustes ($log){
        $sql = "insert into plc_ajustes_compra ".$log;

        $data = \database::getInstancia()->getConsulta($sql);

        return $data;
    }
    public static function ImpAssorCalculos($rows,$nom_columnas,$cod_tempo,$depto,$login,$dtjerarquia,$f3){
        $_error ="";
        $_v = 0;
        $_Array = []; array_push($_Array,$nom_columnas);
        $_i = 0;
        $logAjustes= [];
        $key = 0;
        $dtcolores = plan_compra::list_colores();

        foreach($rows as $val2){ $_i ++;
            if ($_i > 1){ //fila 1 es la cabesera
                if ($_i == 2){//Borrar filas, maximo id_color3
                    plan_compra::DeleteRowsPlan($cod_tempo,$depto,$val2[$nom_columnas['Codigo Marca']],$val2[$nom_columnas['Grupo de compra']]);
                    $key = plan_compra::get_maxidplan($cod_tempo,$depto)+1;
                }
                $dtmarcas = plan_compra::list_Marcas($depto);
                $rfid = number_format( $val2[$nom_columnas['RFID USD']], 2, '.', ',');
                $cod_vent =  plan_compra::get_codName($val2[$nom_columnas['Ventana Debut']], plan_compra::list_ventanas($cod_tempo));
                $cod_pais = plan_compra::get_codName($val2[$nom_columnas['Pais']], plan_compra::list_pais());
                $cod_via =plan_compra::get_codName($val2[$nom_columnas['Via']], plan_compra::list_via());
                $tdas = plan_compra::get_N_tdas($depto,$val2[$nom_columnas['Codigo Marca']],$cod_tempo,$val2[$nom_columnas['Cluster']], $val2[$nom_columnas['Formato']]);
                $por_Inicial = plan_compra::get_ComposicionCampos2($val2, $nom_columnas, "Size%");
                $curva_reparto = plan_compra::get_ComposicionCampos2($val2, $nom_columnas, "Curva");
                $tallas = plan_compra::get_ComposicionCampos2($val2, $nom_columnas, "Talla");
                $mstpack = plan_compra::list_mstpack($val2[$nom_columnas['Cod Linea']],$val2[$nom_columnas['Cod Sublinea']],$depto);
                $dtAjustada = plan_compra::AjustesPrimerReparto2($por_Inicial,$val2[$nom_columnas['Unidades']],$curva_reparto,$tallas,$val2,$nom_columnas,$cod_tempo,$depto,$val2[$nom_columnas['Codigo Marca']],$val2[$nom_columnas['Debut o Reorder']],$val2[$nom_columnas['Tipo de empaque']],$val2[$nom_columnas['N curvas por caja curvadas']],$val2[$nom_columnas['Formato']],"",$mstpack);
                $dtdiviporcent = plan_compra::Division_porcent ($dtAjustada[1]);
                $dtdivicantidad = plan_compra::Division_cantidades($dtAjustada[6]);
                $dtclustercurva= plan_compra::curvaportiendas($dtAjustada[7],$val2[$nom_columnas['ClusterA']],$val2[$nom_columnas['ClusterB']],$val2[$nom_columnas['ClusterC']],$val2[$nom_columnas['ClusterI']]);
                $Cos_Total_Target_us = ($val2[$nom_columnas['Target USD']] + $val2[$nom_columnas['RFID USD']]) *  $dtAjustada[3];
                $Cos_Uni_Finl_Pesos = plan_compra::getC_uni_finalbmt($Cos_Total_Target_us,$val2[$nom_columnas['Ventana Debut']],$cod_tempo,$depto,$cod_pais,$cod_via);

                //data calculable
                array_push($_Array
                    , array($val2[$nom_columnas["s"]]
                    , $val2[$nom_columnas["Cod Dpto"]]
                    , $val2[$nom_columnas["Dpto"]]
                    , $val2[$nom_columnas["Marca"]]
                    , $val2[$nom_columnas["Codigo Marca"]]
                    , $val2[$nom_columnas["Season"]]
                    , $val2[$nom_columnas["Linea"]]
                    , $val2[$nom_columnas["Cod Linea"]]
                    , $val2[$nom_columnas["Sublinea"]]
                    , $val2[$nom_columnas["Cod Sublinea"]]
                    , $val2[$nom_columnas["Codigo corporativo"]]
                    , $val2[$nom_columnas["Nombre Estilo"]]
                    , $val2[$nom_columnas["Estilo Corto"]]
                    , $val2[$nom_columnas["Descripcion Estilo"]]
                    , $val2[$nom_columnas["Cod Opcion"]]
                        //, $val2[$nom_columnas["Color"]]
                    , plan_compra::get_nomcolor2($dtcolores,$val2[$nom_columnas["Cod Color"]])
                    , $val2[$nom_columnas["Cod Color"]]
                    , $val2[$nom_columnas["Evento"]]
                    , $val2[$nom_columnas["Grupo de compra"]]
                    , $val2[$nom_columnas["Ventana Debut"]]
                    , $val2[$nom_columnas["Tipo exhibicion"]]
                    , $val2[$nom_columnas["Tipo Producto"]]
                    , $val2[$nom_columnas["Debut o Reorder"]]
                    , $val2[$nom_columnas["Temporada"]]
                    , $val2[$nom_columnas["Precio"]]
                    , $val2[$nom_columnas["Ranking de venta"]]
                    , $val2[$nom_columnas["Ciclo de Vida"]]
                    , $val2[$nom_columnas["Piramide Mix"]]
                    , $val2[$nom_columnas["Ratio compra"]]
                    , $val2[$nom_columnas["Factor amplificacion"]]
                    , $val2[$nom_columnas["Ratio compra final"]]
                    , $val2[$nom_columnas["Cluster"]]
                    , $val2[$nom_columnas["Formato"]]
                    , $val2[$nom_columnas["Compra Unidades Assortment"]]
                    , $val2[$nom_columnas["Compra Unidades final"]]
                    , $val2[$nom_columnas["Var%"]]
                    , $val2[$nom_columnas["Target USD"]]
                    , $val2[$nom_columnas["RFID USD"]]
                    , $val2[$nom_columnas["Via"]]
                    , $val2[$nom_columnas["Pais"]]
                    , $val2[$nom_columnas["Factor"]]
                    , $val2[$nom_columnas["Costo Total"]]
                    , $val2[$nom_columnas["Retail Total sin iva"]]
                    , $val2[$nom_columnas["MUP Compra"]]
                    , $val2[$nom_columnas["Exhibicion"]]
                    , $val2[$nom_columnas["Talla1"]], $val2[$nom_columnas["Talla2"]], $val2[$nom_columnas["Talla3"]]
                    , $val2[$nom_columnas["Talla4"]], $val2[$nom_columnas["Talla5"]], $val2[$nom_columnas["Talla6"]]
                    , $val2[$nom_columnas["Talla7"]], $val2[$nom_columnas["Talla8"]], $val2[$nom_columnas["Talla9"]]
                    , $val2[$nom_columnas["Inner"]]
                    , $val2[$nom_columnas["Curva1"]], $val2[$nom_columnas["Curva2"]], $val2[$nom_columnas["Curva3"]]
                    , $val2[$nom_columnas["Curva4"]], $val2[$nom_columnas["Curva5"]], $val2[$nom_columnas["Curva6"]]
                    , $val2[$nom_columnas["Curva7"]], $val2[$nom_columnas["Curva8"]], $val2[$nom_columnas["Curva9"]]
                    , $val2[$nom_columnas["Validador Masterpack/Inner"]]
                    , $val2[$nom_columnas["Tipo de empaque"]]
                    , $val2[$nom_columnas["N curvas por caja curvadas"]]
                    , $val2[$nom_columnas["1_%"]], $val2[$nom_columnas["2_%"]], $val2[$nom_columnas["3_%"]]
                    , $val2[$nom_columnas["4_%"]], $val2[$nom_columnas["5_%"]], $val2[$nom_columnas["6_%"]]
                    , $val2[$nom_columnas["7_%"]], $val2[$nom_columnas["8_%"]], $val2[$nom_columnas["9_%"]]
                    , $val2[$nom_columnas["TiendasA"]]
                    , $val2[$nom_columnas["TiendasB"]]
                    , $val2[$nom_columnas["TiendasC"]]
                    , $val2[$nom_columnas["TiendasI"]]
                        /*cluster a*/               , $dtclustercurva[0]
                        /*cluster b*/               , $dtclustercurva[1]
                        /*cluster c*/               , $dtclustercurva[2]
                        /*cluster I*/               , $dtclustercurva[3]
                    , $val2[$nom_columnas["Size%1"]], $val2[$nom_columnas["Size%2"]], $val2[$nom_columnas["Size%3"]]
                    , $val2[$nom_columnas["Size%4"]], $val2[$nom_columnas["Size%5"]], $val2[$nom_columnas["Size%6"]]
                    , $val2[$nom_columnas["Size%7"]], $val2[$nom_columnas["Size%8"]], $val2[$nom_columnas["Size%9"]]
                    , $val2[$nom_columnas["VentA"]], $val2[$nom_columnas["VentB"]], $val2[$nom_columnas["VentC"]]
                    , $val2[$nom_columnas["VentD"]], $val2[$nom_columnas["VentE"]], $val2[$nom_columnas["VentF"]]
                    , $val2[$nom_columnas["VentG"]], $val2[$nom_columnas["VentH"]], $val2[$nom_columnas["VentI"]]
                    , $val2[$nom_columnas["Unidades"]]
                        /*piramide mix*/            , plan_compra::get_codName($val2[$nom_columnas['Piramide Mix']], plan_compra::list_piramidemix($f3))
                        /*unidades finales*/        , $dtAjustada[3]
                        /*semana inicio*/           , plan_compra::SemanasIni_Fin('SemIni',$cod_vent,$cod_tempo,'','')
                        /*semana fin*/              , plan_compra::SemanasIni_Fin('SemFin',$cod_vent,$cod_tempo,plan_compra::get_codName($val2[$nom_columnas['Ciclo de Vida']], plan_compra::list_ciclo_vida()),$val2[$nom_columnas['Debut o Reorder']])
                        /*ciclo*/                   , plan_compra::getsemliq_cicloA('CicloA',$val2[$nom_columnas['Ciclo de Vida']],$val2[$nom_columnas['Debut o Reorder']])
                        /*COD_RANKVTA*/             , plan_compra::get_codName($val2[$nom_columnas['Ranking de venta']], plan_compra::list_rnk($f3))
                        /*tdas*/                    , $dtAjustada[5]
                        /*gm*/                      , round((((($val2[$nom_columnas['Precio']]/1.19)-(plan_compra::getC_uni_final($val2[$nom_columnas['Target USD']],$rfid,$val2[$nom_columnas['Ventana Debut']],$cod_tempo,$depto,$cod_pais,$cod_via)))/($val2[$nom_columnas['Precio']]/1.19))*100),2)
                        /*cod ventana*/             , $cod_vent
                        /*semanaliq*/               , plan_compra::getsemliq_cicloA('semLiq',$val2[$nom_columnas['Ciclo de Vida']],$val2[$nom_columnas['Debut o Reorder']])
                        /*cos_uni_final us*/        , $val2[$nom_columnas['Target USD']] + $rfid
                        /*cos_uni_final $*/         , plan_compra::getC_uni_final($val2[$nom_columnas['Target USD']],$rfid,$val2[$nom_columnas['Ventana Debut']] ,$cod_tempo,$depto,$cod_pais,$cod_via)
                        /*cos_total*/               , $Cos_Uni_Finl_Pesos
                        /*cod_ciclo_vid*/           , plan_compra::get_codName($val2[$nom_columnas['Ciclo de Vida']], plan_compra::list_ciclo_vida())
                        /*cost_retail*/             , ROUND((($dtAjustada[3] * $val2[$nom_columnas['Precio']])/1.19))
                        /*mstpack*/                 , plan_compra::get_mst_pack($depto,$val2[$nom_columnas['Cod Linea']],$val2[$nom_columnas['Cod Sublinea']])
                        /*mkup*/                    , round(($val2[$nom_columnas['Precio']]/1.19)/ (plan_compra::getC_uni_final($val2[$nom_columnas['Target USD']],$rfid,$val2[$nom_columnas['Ventana Debut']],$cod_tempo,$depto,$cod_pais,$cod_via)),2)
                        /*cod_via*/                 , $cod_via
                        /*cod_pais*/                , $cod_pais
                        /*costo total target*/      , $Cos_Total_Target_us
                        /*n_cajas*/                 , $dtAjustada[2]
                        /*primer reparto*/          , $dtAjustada[4]
                        /*tallas*/                  , $tallas
                        /*CURVATALLA*/              , $curva_reparto
                        /*Porcentaje Ajustada-*/    , $dtAjustada[1]
                        /*temp*/                    , plan_compra::get_codtemporadaseason2($val2, $nom_columnas)
                        /*diferancia*/              , $dtAjustada[5]
                        /*nom_linea*/               , plan_compra::get_NomJerarquia2($dtjerarquia, $val2, $nom_columnas, 1)
                        /*nom_sublinea*/            , plan_compra::get_NomJerarquia2($dtjerarquia, $val2, $nom_columnas, 2)
                        /*nom_marca*/               , plan_compra::get_NomMarcas2($dtmarcas, $val2, $nom_columnas)
                        /*porcent_1*/               , $dtdiviporcent[0]
                        /*porcent_2*/               , $dtdiviporcent[1]
                        /*porcent_3*/               , $dtdiviporcent[2]
                        /*porcent_4*/               , $dtdiviporcent[3]
                        /*porcent_5*/               , $dtdiviporcent[4]
                        /*porcent_6*/               , $dtdiviporcent[5]
                        /*porcent_7*/               , $dtdiviporcent[6]
                        /*porcent_8*/               , $dtdiviporcent[7]
                        /*porcent_9*/               , $dtdiviporcent[8]
                        /*cant_1*/                  , $dtdivicantidad[0]
                        /*cant_2*/                  , $dtdivicantidad[1]
                        /*cant_3*/                  , $dtdivicantidad[2]
                        /*cant_4*/                  , $dtdivicantidad[3]
                        /*cant_5*/                  , $dtdivicantidad[4]
                        /*cant_6*/                  , $dtdivicantidad[5]
                        /*cant_7*/                  , $dtdivicantidad[6]
                        /*cant_8*/                  , $dtdivicantidad[7]
                        /*cant_9*/                  , $dtdivicantidad[8]
                        /*porcent ini*/             , $por_Inicial
                        /*opcion ajust*/            , $dtAjustada[0]
                        /*id_color3*/               , $key
                        /*n_tdast*/                 , $tdas
                    ));

                //Guardado PLC_AJUSTES_COMPRA $dtAjustada
                $_query = plan_compra::SaveAjuste_Compra2(/*AJUSTE DE COMPRA*/$dtAjustada[8]
                    /*AJUSTE CURVADO*/, $dtAjustada[9]
                    /*AJUSTE CUR SOLIDO*/, $dtAjustada[10]
                    /*AJUSTE SOLIDO FUL*/, $dtAjustada[11]
                    /*AJUSTE REORDER*/, $dtAjustada[12]
                    /*DEBUT/REORDER*/, $val2[$nom_columnas['Debut o Reorder']]
                    /*TIPO EMPAQUE*/, trim(strtoupper($val2[$nom_columnas['Tipo de empaque']]))
                    /*ID_COLOR3*/, $key
                    /*Tallas*/, $tallas
                    /*TEMPO*/, $cod_tempo
                    /*DEPTO*/, $depto);


                foreach ($_query as $val3){
                    array_push($logAjustes,$val3);
                }
                $key++;
            }
        }

        $key4 = 0;$logInsert = "";$count = count($logAjustes);
        foreach ($logAjustes as $val4){$key4++;
            if($count == $key4){
                $val4 = str_replace("union", "", $val4);
            }
            $logInsert = $logInsert." ".$val4;
        }
        plan_compra::InsertAjustes($logInsert);

        return $_Array;
    }
#endregion


#region {*************Metodos Importar BMT*************}
    public static function list_estiloVida(){
        $sql = "select CODIGO,DESCRIPCION from PLC_ESTILOCICLOVIDA";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function list_ocacionuso(){
        $sql = "SELECT CODIGO,DESCRIPCION FROM PLC_OCASIONDEUSO";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function get_codLinea($nom_linea,$dt){
        $cod = "";
        foreach ($dt as $val){
            if($val['LIN_DESCRIPCION'] == $nom_linea){
                $cod = $val['LIN_LINEA'];
                break;
            }
        }
        return $cod;
    }
    public static function get_codColor($nom_color,$dt){
        $cod = 0;
        foreach ($dt as $val){
            if(strtoupper($val['NOM_COLOR']) == strtoupper($nom_color)){
                $cod = $val['COD_COLOR'];
                break;
            }
        }
        return $cod;
    }
    public static function get_columnas_archivos($tipo){
        //1.- Assortment
        //2.- BMT
        //3.- columnas nuevas assortment
        //4.- columnas nuevas bmt

        $sql = "select COLUMNAS".
            " from plc_columnas_archivos".
            " WHERE COD_TIPOARCHIVO =".$tipo."";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;


    }
    public static function listar_plan_compraPorID($cod_tempo,$depto,$rows,$nom_columnas,$_Jerarquia){

        $grupo_compra = $rows[$nom_columnas['PURCHASE GROUP']];
        $cod_marca = plan_compra::get_codMarca(strtoupper($rows[$nom_columnas['LOCAL BRAND']]),$depto);//get
        $cod_linea =  plan_compra::get_codLinea(strtoupper($rows[$nom_columnas['LINE (*)']]),$_Jerarquia); //get
        $cod_sublinea = $rows[$nom_columnas['SUBLNE CODE']];
        $estilo = $rows[$nom_columnas['STYLE NAME']];
        $ventana = strtoupper($rows[$nom_columnas['VENTANA']]);
        $num_opcion = $rows[$nom_columnas['OPTION NUMBER']];
        $cod_color = $rows[$nom_columnas['COLOR CODE']];

        $sql = "select ID_COLOR3,VENT_EMB,NOM_VENTANA,VENTANA_LLEGADA,TIPO_EMPAQUE,PORTALLA_1_INI,PORTALLA_1           
              ,UNID_OPCION_INICIO,UNID_OPCION_AJUSTADA,UNIDADES,CANT_INNER,UND_ASIG_INI,DIFER_REPARTO       
              ,ROT,VIA,NOM_VIA,PAIS,NOM_PAIS,MKUP,PRECIO_BLANCO,GM,COSTO_FOB,COSTO_INSP,COSTO_RFID          
              ,COSTO_UNIT,COSTO_UNITS,COSTO_TOT,COSTO_TOTS,RETAIL,DEBUT_REODER,SEM_INI,SEM_FIN          
              ,CICLO,SEMLIQ,ALIAS_PROV,A.DESTALLA,CURVATALLA,SEG_ASIG CLUSTER1,FORMATO,A ClusterA,B ClusterB,A.COD_MARCA
              ,C ClusterC,I ClusterI,N_CURVASXCAJAS,B.MSTPACK   
               FROM PLC_PLAN_COMPRA_COLOR_3 A
               LEFT JOIN PLC_MSTPACK B ON A.COD_JER2 = B.COD_LIN AND A.COD_SUBLIN = B.COD_SUBLIN
                                          AND A.DEP_DEPTO = B.COD_DEPTO          
               WHERE  A.COD_TEMPORADA  = ".$cod_tempo."
               AND    A.DEP_DEPTO      = '".$depto."'
               AND    A.GRUPO_COMPRA   = '".$grupo_compra."'
               AND    A.COD_MARCA      = ".$cod_marca."
               AND    A.COD_JER2       = '".$cod_linea."'
               AND    A.COD_SUBLIN     = '".$cod_sublinea."'
               AND    A.DES_ESTILO     = '".$estilo."'
               AND    A.NOM_VENTANA    = '".$ventana."'
               AND    A.NUM_EMB        = '".$num_opcion."'
               AND    A.COD_COLOR      = ".$cod_color;

        $data = \database::getInstancia()->getFilas($sql);

        return $data;

    }
    public static function Calculo_DebutReorder ($rows,$limite,$nom_columnas){

        $dtrowsvalidado = [];
        //data1
        for ($i = 1; $i <= $limite; $i++) {
            //************ rows validados
            $_exite = false;
            if(count($dtrowsvalidado) <> 0){
                $count = count($dtrowsvalidado)-1;
                for ($o = 0; $o <= $count; $o++){
                    if ($dtrowsvalidado[$o][0] == $rows[$i][$nom_columnas['LINE (*)']] and
                        $dtrowsvalidado[$o][1] == $rows[$i][$nom_columnas['SUBLNE CODE']] and
                        $dtrowsvalidado[$o][2] == $rows[$i][$nom_columnas['STYLE NAME']] and
                        $dtrowsvalidado[$o][3] == $rows[$i][$nom_columnas['COLOR NAME']] and
                        $dtrowsvalidado[$o][4] == $rows[$i][$nom_columnas['PRODUCT SEASON']] ){
                        $_exite = true;
                        break;
                    }
                }
            }

            if ($_exite <> true){
                //************ llenar grupo
                $dtGrupo =[];
                for ($g = 1; $g <= $limite; $g++) {
                    if ($rows[$g][$nom_columnas['LINE (*)']] == $rows[$i][$nom_columnas['LINE (*)']] and
                        $rows[$g][$nom_columnas['SUBLNE CODE']] == $rows[$i][$nom_columnas['SUBLNE CODE']] and
                        $rows[$g][$nom_columnas['STYLE NAME']] == $rows[$i][$nom_columnas['STYLE NAME']] and
                        $rows[$g][$nom_columnas['COLOR NAME']] == $rows[$i][$nom_columnas['COLOR NAME']] and
                        $rows[$g][$nom_columnas['PRODUCT SEASON']] == $rows[$i][$nom_columnas['PRODUCT SEASON']] ){

                        array_push($dtGrupo
                            , array($rows[$g][$nom_columnas['LINE (*)']]
                            , $rows[$g][$nom_columnas['SUBLNE CODE']]
                            , $rows[$g][$nom_columnas['STYLE NAME']]
                            , $rows[$g][$nom_columnas['COLOR NAME']]
                            , $rows[$g][$nom_columnas['PRODUCT SEASON']]
                            , $rows[$g][$nom_columnas['VENTANA']]));
                    }
                }

                //************ ordernar por ventana
                $dtorderby=[];$count = count($dtGrupo)-1;//ordernar grupo
                $dtventana = array("A","B","C","D","E","F","G","H","I");
                foreach ($dtventana as $val){
                    for ($h = 0; $h <= $count; $h++) {
                        if ($dtGrupo[$h][5]== $val){
                            array_push($dtorderby
                                , array($dtGrupo[$h][0]
                                , $dtGrupo[$h][1]
                                , $dtGrupo[$h][2]
                                , $dtGrupo[$h][3]
                                , $dtGrupo[$h][4]
                                , $dtGrupo[$h][5] ));
                        }
                    }
                }

                //************ Asignarle debut o reorder
                $count = count($dtorderby)-1;
                $key = 0;
                for ($o = 0; $o <= $count; $o++){//dtorder
                    $key +=1;
                    for ($b = 1; $b <= $limite; $b++){//dtbmt
                        if ($rows[$b][$nom_columnas['LINE (*)']] == $dtorderby[$o][0] and
                            $rows[$b][$nom_columnas['SUBLNE CODE']] == $dtorderby[$o][1] and
                            $rows[$b][$nom_columnas['STYLE NAME']] == $dtorderby[$o][2] and
                            $rows[$b][$nom_columnas['COLOR NAME']] == $dtorderby[$o][3]and
                            $rows[$b][$nom_columnas['PRODUCT SEASON']] == $dtorderby[$o][4] and
                            $rows[$b][$nom_columnas['VENTANA']] == $dtorderby[$o][5]){
                            if ($key == 1){
                                $rows[$b][$nom_columnas['REORDER']] = "DEBUT";
                            }else{
                                $rows[$b][$nom_columnas['REORDER']] = "REORDER";
                            }
                            break;
                        }
                    }
                    //Agregarle las opciones ya calculadas
                    array_push($dtrowsvalidado
                        , array($dtorderby[$o][0]
                        , $dtorderby[$o][1]
                        , $dtorderby[$o][2]
                        , $dtorderby[$o][3]
                        , $dtorderby[$o][4]
                        , $dtorderby[$o][5] ));
                }
            }
        }

        return $rows;
    }
    public static function Calculo_DebutReorderBMT ($rows,$limite,$nom_columnas,$cod_tempo,$depto){

        $dtrowsvalidado = [];
        $dtplan_compra =  plan_compra::list_plan_compra_debut($cod_tempo,$depto,$rows[1][$nom_columnas["PURCHASE GROUP"]]);
        $dtjerarquia = $_SESSION['dtjerarquia'];
        //data1
        for ($i = 1; $i <= $limite; $i++) {
            //************ rows validados
            $_exite = false;
            if(count($dtrowsvalidado) <> 0){
                $count = count($dtrowsvalidado)-1;
                for ($o = 0; $o <= $count; $o++){
                    if ($dtrowsvalidado[$o][0] == $rows[$i][$nom_columnas['LINE (*)']] and
                        $dtrowsvalidado[$o][1] == $rows[$i][$nom_columnas['SUBLNE CODE']] and
                        $dtrowsvalidado[$o][2] == $rows[$i][$nom_columnas['STYLE NAME']] and
                        $dtrowsvalidado[$o][3] == $rows[$i][$nom_columnas['COLOR CODE']] and
                        $dtrowsvalidado[$o][4] == $rows[$i][$nom_columnas['PRODUCT SEASON']] ){
                        $_exite = true;
                        break;
                    }
                }
            }

            if ($_exite <> true){
                //************ llenar grupo
                $dtGrupo =[];
                for ($g = 1; $g <= $limite; $g++) {
                    if ($rows[$g][$nom_columnas['LINE (*)']] == $rows[$i][$nom_columnas['LINE (*)']] and
                        $rows[$g][$nom_columnas['SUBLNE CODE']] == $rows[$i][$nom_columnas['SUBLNE CODE']] and
                        $rows[$g][$nom_columnas['STYLE NAME']] == $rows[$i][$nom_columnas['STYLE NAME']] and
                        $rows[$g][$nom_columnas['COLOR CODE']] == $rows[$i][$nom_columnas['COLOR CODE']] and
                        $rows[$g][$nom_columnas['PRODUCT SEASON']] == $rows[$i][$nom_columnas['PRODUCT SEASON']] ){

                        array_push($dtGrupo
                            , array($rows[$g][$nom_columnas['LINE (*)']]
                            , $rows[$g][$nom_columnas['SUBLNE CODE']]
                            , $rows[$g][$nom_columnas['STYLE NAME']]
                            , $rows[$g][$nom_columnas['COLOR CODE']]
                            , $rows[$g][$nom_columnas['PRODUCT SEASON']]
                            , $rows[$g][$nom_columnas['VENTANA']]));
                    }
                }

                //************ ordernar por ventana
                $dtorderby=[];$count = count($dtGrupo)-1;//ordernar grupo
                $dtventana = array("A","B","C","D","E","F","G","H","I");
                foreach ($dtventana as $val) {
                    for ($h = 0; $h <= $count; $h++) {
                        if ($dtGrupo[$h][5] == $val) {
                            array_push($dtorderby
                                , array($dtGrupo[$h][0]
                                , $dtGrupo[$h][1]
                                , $dtGrupo[$h][2]
                                , $dtGrupo[$h][3]
                                , $dtGrupo[$h][4]
                                , $dtGrupo[$h][5]));
                        }
                    }
                }
                //************ Asignarle debut o reorder
                $count = count($dtorderby)-1;
                $key = 0;
                for ($o = 0; $o <= $count; $o++){//dtorder
                    $key +=1;
                    for ($b = 1; $b <= $limite; $b++){//dtbmt
                        if ($rows[$b][$nom_columnas['LINE (*)']] == $dtorderby[$o][0] and
                            $rows[$b][$nom_columnas['SUBLNE CODE']] == $dtorderby[$o][1] and
                            $rows[$b][$nom_columnas['STYLE NAME']] == $dtorderby[$o][2] and
                            $rows[$b][$nom_columnas['COLOR CODE']] == $dtorderby[$o][3]and
                            $rows[$b][$nom_columnas['PRODUCT SEASON']] == $dtorderby[$o][4] and
                            $rows[$b][$nom_columnas['VENTANA']] == $dtorderby[$o][5]){

                            $_existedebut = valida_archivo_bmt::Valida_existe_debutDepto($dtplan_compra
                                ,plan_compra::get_codLinea($rows[$b][$nom_columnas["LINE (*)"]],$dtjerarquia)
                                ,$rows[$b][$nom_columnas["SUBLNE CODE"]]
                                ,$rows[$b][$nom_columnas["STYLE NAME"]]
                                ,$rows[$b][$nom_columnas["COLOR CODE"]]);

                            if ($key == 1){
                                if ($_existedebut == true){
                                    $rows[$b][$nom_columnas['REORDER']] = "REORDER";
                                }else{
                                    $rows[$b][$nom_columnas['REORDER']] = "DEBUT";
                                }
                            }else{
                                $rows[$b][$nom_columnas['REORDER']] = "REORDER";
                            }

                            break;
                        }
                    }
                    //Agregarle las opciones ya calculadas
                    array_push($dtrowsvalidado
                        , array($dtorderby[$o][0]
                        , $dtorderby[$o][1]
                        , $dtorderby[$o][2]
                        , $dtorderby[$o][3]
                        , $dtorderby[$o][4]
                        , $dtorderby[$o][5] ));
                }
            }
        }

        return $rows;
    }
    public static function get_ComposicionCamposBmt($rows,$nom_columnas,$i,$tipo){

        $composion = "";
        for($x = 1;$x <= 9; $x++){
            $column = $tipo.$x;
            if ($rows[$i][$nom_columnas[$column]] <> "" and
                $rows[$i][$nom_columnas[$column]] <> "0" and
                $rows[$i][$nom_columnas[$column]] <> " " and
                $rows[$i][$nom_columnas[$column]] <> null ){
                if ($tipo == "Size %"){
                    $composion = $composion. (round($rows[$i][$nom_columnas[$column]],5) * 100) ."-";
                }else {
                    $composion = $composion . $rows[$i][$nom_columnas[$column]] . ",";
                }
            }
        }

        if ((strlen($composion)) > 0){
            $composion = substr($composion, 0, - 1);
        }


        return $composion;
    }
    public static function get_codMarca($nom_Marca,$depto){
        $val = 0;$key3 = 0;
        $data = plan_compra::list_Marcas($depto);
        foreach ($data as $var){
            if ($data[$key3]["DESCRIPCION"] == $nom_Marca) {
                $val = $data[$key3]["CODIGO"];
                break;
            }
            $key3++;
        }
        return $val;
    }
    public static function get_codMarca2($nom_Marca,$dt){
        $cod_marca=0;
        foreach ($dt as $val){
            if (strtoupper($val["DESCRIPCION"]) == strtoupper($nom_Marca)) {
                $cod_marca = $val["CODIGO"];
                break;
            }

        }
        return $cod_marca;
    }
    public static function get_nomColor($Cod_Color){

        $dt = plan_compra::list_colores();
        $NomColor = "";
        foreach ($dt as $val){
            if($val['COD_COLOR'] == $Cod_Color ){
                $NomColor = $val['NOM_COLOR'];break;
            }
        }
        return $NomColor;
    }
    public static function get_nomMarca($cod_marca,$dt){
        $nom_marca = "";
        foreach ($dt as $val){
            if ($val['CODIGO'] == $cod_marca){
                $nom_marca = $val['DESCRIPCION'];
                break;
            }
        }
        return $nom_marca;
    }

    public static function get_codEstilovida($nom,$dt){
        $cod =0;
        foreach ($dt as $val){
            if (strtoupper($nom) == strtoupper($val['DESCRIPCION'])){
                $cod = $val['CODIGO'];
                break;
            }
        }
        return $cod;
    }
    public static function get_codocacionuso($nom,$dt){
        $cod =0;
        foreach ($dt as $val){
            if (strtoupper($nom) == strtoupper($val['DESCRIPCION'])){
                $cod = $val['CODIGO'];
                break;
            }
        }
        return $cod;
    }
    public static function get_codrnk($nom,$dt){
        $cod =0;
        foreach ($dt as $val){
            if (strtoupper($nom) == strtoupper($val['DESCRIPCION'])){
                $cod = $val['CODIGO'];
                break;
            }
        }
        return $cod;
    }
    public static function get_codlife_cycle($nom,$dt){
        $cod =0;
        foreach ($dt as $val){
            if (strtoupper($nom) == strtoupper($val['DESCRIPCION'])){
                $cod = $val['CODIGO'];
                break;
            }
        }
        return $cod;
    }

    public static function InsertHistoricadelBMT($cod_tempo,$depto,$nom_marca,$grupo_compra){

        foreach ($nom_marca as $m){
            $sql = "DELETE PLC_HIS_IMPOR_BMT"
                . " WHERE TEMPORADA = " . $cod_tempo . ""
                . " AND DEPARTMENT_CODE = '" . $depto . "'"
                . " AND PURCHASE_GROUP  = '" . $grupo_compra . "'"
                . " AND LOCAL_BRAND  = '" . $m . "'";
            \database::getInstancia()->getConsulta($sql);
        }
    }
    public static function ImpBMTCalculos($rows,$limite,$nom_columnas,$cod_tempo,$depto,$f3){


        $_Array=[];
        $_Jerarquia = $_SESSION['dtjerarquia'];
        $columnasnuevas = plan_compra::get_columnas_archivos(4);$dt_columnas = [];
        foreach ($columnasnuevas as $var5){
            array_push($dt_columnas,$var5['COLUMNAS']);
        }
        array_push($_Array,array_flip($dt_columnas));
        $logAjustes= [];
        $dtestilovida = plan_compra::list_estiloVida();
        $dtocacionuso = plan_compra::list_ocacionuso();
        $dtrnkvta = plan_compra::list_rnk($f3);
        $dtciclovida = plan_compra::list_ciclo_vida();

        for ($i = 1; $i <= $limite; $i++) {
            $dtplanCompra = plan_compra::listar_plan_compraPorID($cod_tempo,$depto,$rows[$i],$nom_columnas,$_Jerarquia);
            $cod_vent = plan_compra::get_codName($rows[$i][$nom_columnas['VENTANA']], plan_compra::list_ventanas($cod_tempo));
            $cod_pais = plan_compra::get_codName($rows[$i][$nom_columnas['COUNTRY OF ORIGIN']], plan_compra::list_pais());
            $cod_via = plan_compra::get_codName($rows[$i][$nom_columnas['SHIPMENT MODE']], plan_compra::list_via());
            $por_Inicial = plan_compra::get_ComposicionCampos($rows, $nom_columnas, $i, "Size %");
            $dtAjustada = plan_compra::AjustesPrimerRepartobmt($por_Inicial //porcentajes iniciales
                , $rows[$i][$nom_columnas['TOTAL QUANTITY CL']] //unidades iniciales
                , $dtplanCompra[0]["CURVATALLA"]// Curvas
                , $dtplanCompra[0]["DESTALLA"]//Tallas
                , $rows[$i]
                , $nom_columnas
                , $cod_tempo//Temporada
                , $depto //depto
                , $dtplanCompra[0]['COD_MARCA'] //marca
                , $dtplanCompra[0]['DEBUT_REODER']
                , $dtplanCompra[0]['TIPO_EMPAQUE']
                , $dtplanCompra[0]["N_CURVASXCAJAS"]
                , $dtplanCompra[0]["FORMATO"]
                , $dtplanCompra
                , $dtplanCompra[0]['MSTPACK']);
            $dtdiviporcent = plan_compra::Division_porcent($dtAjustada[1]);
            $dtdivicantidad = plan_compra::Division_cantidades($dtAjustada[6]);
            $Cos_Uni_Finl_US = plan_compra::Cost_Uni_final_us($rows[$i][$nom_columnas['TARGET COST']], $rows[$i][$nom_columnas['FINAL COST']], $rows[$i][$nom_columnas['INSPECTION COST']], $rows[$i][$nom_columnas['RFID COST']]);
            $Cos_Uni_Finl_Pesos = plan_compra::getC_uni_finalbmt($Cos_Uni_Finl_US, $rows[$i][$nom_columnas['VENTANA']], $cod_tempo, $depto, $cod_pais, $cod_via);
            $nomcolor = plan_compra::get_nomColor($rows[$i][$nom_columnas['COLOR CODE']]);
            $estilovida=0; $ocacion= 0; $rnk=0; $ciclo= 0;
            if ($rows[$i][$nom_columnas['LIFE STYLE']] <> null){
                $estilovida = plan_compra::get_codEstilovida($rows[$i][$nom_columnas['LIFE STYLE']],$dtestilovida);
            }
            if ($rows[$i][$nom_columnas['CHANCE OF USER']] <> null){
                $ocacion = plan_compra::get_codocacionuso($rows[$i][$nom_columnas['CHANCE OF USER']],$dtocacionuso);
            }
            if ($rows[$i][$nom_columnas['RANKING OF SALE']] <> null){
                $rnk = plan_compra::get_codrnk($rows[$i][$nom_columnas['RANKING OF SALE']],$dtrnkvta);
            }
            if ($rows[$i][$nom_columnas['LIFE CICLE']] <> null){
                $ciclo = plan_compra::get_codlife_cycle($rows[$i][$nom_columnas['LIFE CICLE']],$dtciclovida);
            }

            array_push($_Array,
                array(/*0V_COD_TEMPORADA*/          $cod_tempo
                    /*1V_DEP_DEPTO*/              , $depto
                    /*2V_DES_ESTILO*/             , $rows[$i][$nom_columnas['STYLE NAME']]
                    /*3V_NUM_EMB*/                , $rows[$i][$nom_columnas['OPTION NUMBER']]
                    /*4V_VENT_EMB*/               , $cod_vent
                    /*5V_NOM_VENTANA*/            , $rows[$i][$nom_columnas['VENTANA']]
                    /*6V_VENTANA_LLEGADA*/        , $cod_vent
                    /*7V_COD_COLOR*/              , $rows[$i][$nom_columnas['COLOR CODE']]
                    /*8V_NOM_COLOR*/              , $nomcolor
                    /*9V_TIPO_EMPAQUE*/           , $rows[$i][$nom_columnas['PREPACK']]
                    /*10V_PORTALLA_1_INI*/        , $por_Inicial
                    /*11V_PORTALLA_1*/            , $dtAjustada[1]/*-Porcentaje Ajustada-*/
                    /*12V_UNID_OPCION_INICIO*/    , $rows[$i][$nom_columnas['TOTAL QUANTITY CL']]
                    /*13V_UNID_OPCION_AJUSTADA*/  , $dtAjustada[0]
                    /*14V_UNIDADES*/              , $dtAjustada[3]//unidades
                    /*15V_CANT_INNER*/            , $dtAjustada[2]/*-N_CAJAS.-*/
                    /*16V_UND_ASIG_INI*/          , $dtAjustada[4]/*-Primera_Reparto.-*/
                    /*17V_DIFER_REPARTO*/         , $dtAjustada[5]/*-DIFERENCIA-*/
                    /*18V_ROT*/                   , $dtAjustada[5]/*%tienda*/
                    /*19V_VIA*/                   , $cod_via
                    /*20V_NOM_VIA*/               , $rows[$i][$nom_columnas['SHIPMENT MODE']]
                    /*21V_PAIS*/                  , $cod_pais
                    /*22V_NOM_PAIS*/              , $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']]
                    /*23V_MKUP*/                  , round(($rows[$i][$nom_columnas['RETAIL PRICE']] / 1.19) / $Cos_Uni_Finl_Pesos, 2)
                    /*24V_PRECIO_BLANCO*/         , $rows[$i][$nom_columnas['RETAIL PRICE']]
                    /*25V_GM*/                    , round((($rows[$i][$nom_columnas['RETAIL PRICE']] / 1.19) - $Cos_Uni_Finl_Pesos) / ($rows[$i][$nom_columnas['RETAIL PRICE']] / 1.19) * 100, 2)
                    /*26V_COSTO_FOB*/             , $rows[$i][$nom_columnas['FINAL COST']]
                    /*27V_COSTO_INSP*/            , $rows[$i][$nom_columnas['INSPECTION COST']]
                    /*28V_COSTO_RFID*/            , $rows[$i][$nom_columnas['RFID COST']]
                    /*29V_COSTO_UNIT*/            , $Cos_Uni_Finl_US
                    /*30V_COSTO_UNITS*/           , $Cos_Uni_Finl_Pesos
                    /*31V_COSTO_TOT*/             , $Cos_Uni_Finl_US * $dtAjustada[3]
                    /*32V_COSTO_TOTS*/            , $Cos_Uni_Finl_Pesos * $dtAjustada[3]
                    /*33V_RETAIL*/                , round(($rows[$i][$nom_columnas['RETAIL PRICE']] * $dtAjustada[3]) / 1.19)
                    /*34V_DEBUT_REODER*/          , $rows[$i][$nom_columnas['REORDER']]
                    /*35V_SEM_INI*/               , plan_compra::SemanasIni_Fin('SemIni', $cod_vent, $cod_tempo, '', '')
                    /*36V_SEM_FIN*/               , plan_compra::SemanasIni_Fin('SemFin', $cod_vent, $cod_tempo, plan_compra::get_codName($rows[$i][$nom_columnas['LIFE CICLE']], plan_compra::list_ciclo_vida()), $rows[$i][$nom_columnas['REORDER']])
                    /*37V_CICLO*/                 , plan_compra::getsemliq_cicloA('CicloA', $rows[$i][$nom_columnas['LIFE CICLE']], $rows[$i][$nom_columnas['REORDER']])
                    /*38V_SEMLIQ*/                , plan_compra::getsemliq_cicloA('semLiq', $rows[$i][$nom_columnas['LIFE CICLE']], $rows[$i][$nom_columnas['REORDER']])
                    /*39V_ALIAS_PROV*/            , $rows[$i][$nom_columnas['VENDOR NICK NAME']]
                    /*40V_PORCEN_T1*/             , $dtdiviporcent[0]
                    /*41V_PORCEN_T2*/             , $dtdiviporcent[1]
                    /*42V_PORCEN_T3*/             , $dtdiviporcent[2]
                    /*43V_PORCEN_T4*/             , $dtdiviporcent[3]
                    /*44V_PORCEN_T5*/             , $dtdiviporcent[4]
                    /*45V_PORCEN_T6*/             , $dtdiviporcent[5]
                    /*46V_PORCEN_T7*/             , $dtdiviporcent[6]
                    /*47V_PORCEN_T8*/             , $dtdiviporcent[7]
                    /*48V_PORCEN_T9*/             , $dtdiviporcent[8]
                    /*49V_CANT_T1*/               , $dtdivicantidad[0]
                    /*50V_CANT_T2*/               , $dtdivicantidad[1]
                    /*51V_CANT_T3*/               , $dtdivicantidad[2]
                    /*52V_CANT_T4*/               , $dtdivicantidad[3]
                    /*53V_CANT_T5*/               , $dtdivicantidad[4]
                    /*54V_CANT_T6*/               , $dtdivicantidad[5]
                    /*55V_CANT_T7*/               , $dtdivicantidad[6]
                    /*56V_CANT_T8*/               , $dtdivicantidad[7]
                    /*57V_CANT_T9*/               , $dtdivicantidad[8]
                    /*58V_COD_LINEA*/             , plan_compra::get_codLinea($rows[$i][$nom_columnas['LINE (*)']],$_Jerarquia)
                    /*59V_COD_SUBLINEA*/          , $rows[$i][$nom_columnas['SUBLNE CODE']]
                    /*60V_COD_MARCA*/             , $dtplanCompra[0]['COD_MARCA']
                    /*61V_ID_COLOR3*/             , $dtplanCompra[0]['ID_COLOR3']
                    /*62V_ID_CORPORATIVO*/        ,$rows[$i][$nom_columnas['COD CORP']]
                    /*63V_COMPOSICION */          ,$rows[$i][$nom_columnas['COMPOSITION']]
                    /*64V_DESCRIP_INTERNET*/      ,$rows[$i][$nom_columnas['DESCRIPCION INTERNET']]
                    /*65V_COLECCION*/             ,$rows[$i][$nom_columnas['COLECTION']]
                    /*66V_EVENTO*/                ,$rows[$i][$nom_columnas['EVENTO']]
                    /*67V_COD_ESTILO_VIDA*/       ,$estilovida
                    /*68V_NOM_ESTILOVIDA*/        ,$rows[$i][$nom_columnas['LIFE STYLE']]
                    /*69V_COD_OCASION_USO*/       ,$ocacion
                    /*70V_NOM_OCACIONUSO*/        ,$rows[$i][$nom_columnas['CHANCE OF USER']]
                    /*71V_COD_RANKVTA*/           ,$rnk
                    /*72V_NOM_RNK*/               ,$rows[$i][$nom_columnas['RANKING OF SALE']]
                    /*73V_LIFE_CYCLE*/            ,$ciclo
                    /*74V_NOM_LIFECYCLE*/         ,$rows[$i][$nom_columnas['LIFE CICLE']]
                    /*75V_TIPO_PRODUCTO*/         ,$rows[$i][$nom_columnas['TYPE OF PRODUCT']]
                    /*76V_TIPO_EXHIBICION*/       ,$rows[$i][$nom_columnas['TYPE OF EXHIBITION']]));

            $sql = "delete PLC_AJUSTES_COMPRA"
                . " where cod_temporada = " . $cod_tempo . ""
                . " and dep_depto = '" . $depto . "'"
                . " and id_color3 in (" . $dtplanCompra[0]['ID_COLOR3'] . ")";
            \database::getInstancia()->getConsulta($sql);

            //Guardado PLC_AJUSTES_COMPRA $dtAjustada
            $_query = plan_compra::SaveAjuste_Compra2(/*AJUSTE DE COMPRA*/$dtAjustada[8]
                /*AJUSTE CURVADO*/, $dtAjustada[9]
                /*AJUSTE CUR SOLIDO*/, $dtAjustada[10]
                /*AJUSTE SOLIDO FUL*/, $dtAjustada[11]
                /*AJUSTE REORDER*/, $dtAjustada[12]
                /*DEBUT/REORDER*/, $dtplanCompra[0]['DEBUT_REODER']
                /*TIPO EMPAQUE*/, trim(strtoupper($dtplanCompra[0]['TIPO_EMPAQUE']))
                /*ID_COLOR3*/, $dtplanCompra[0]['ID_COLOR3']
                /*Tallas*/, $dtplanCompra[0]["DESTALLA"]
                /*TEMPO*/, $cod_tempo
                /*DEPTO*/, $depto);


            foreach ($_query as $val3) {
                array_push($logAjustes, $val3);

            }

        }

        $key4 = 0;$logInsert = "";$count = count($logAjustes);
        foreach ($logAjustes as $val4){$key4++;
            if($count == $key4){
                $val4 = str_replace("union", "", $val4);
            }
            $logInsert = $logInsert." ".$val4;
        }
        plan_compra::InsertAjustes($logInsert);

        return $_Array;
    }
    public static function ActualizaPlanCompraBMT($rows,$nom_columnas,$cod_tempo,$depto){
        $_insert = true;
        $sql = "begin PLC_PKG_DESARROLLO.PRC_UPDATE_PLAN_COMPRA_COLOR_3" .
            /*V_COD_TEMPORADA*/             ("('" .$cod_tempo . "'" .
                /*V_DEP_DEPTO*/             ",'"  .$depto . "'" .
                /*V_DES_ESTILO*/            ",'"  .utf8_encode($rows[$nom_columnas['DES_ESTILO']]) . "'" .
                /*V_ID_COLOR3*/             ","   .$rows[$nom_columnas['ID_COLOR3']] . "" .
                /*V_NUM_EMB*/               ",'"  .$rows[$nom_columnas['NUM_EMB']] . "'" .
                /*V_VENT_EMB*/              ","   .$rows[$nom_columnas['VENT_EMB']]."".
                /*V_NOM_VENTANA*/           ",'"  .$rows[$nom_columnas['NOM_VENTANA']] . "'" .
                /*V_VENTANA_LLEGADA*/       ","   .$rows[$nom_columnas['VENTANA_LLEGADA']]."".
                /*V_COD_COLOR*/             ","   .$rows[$nom_columnas['COD_COLOR']] . "" .
                /*V_NOM_COLOR*/             ",'"  .$rows[$nom_columnas['NOM_COLOR']] . "'" .
                /*V_TIPO_EMPAQUE*/          ",'"  .$rows[$nom_columnas['TIPO_EMPAQUE']] . "'" .
                /*V_PORTALLA_1_INI*/        ",'"  .$rows[$nom_columnas['PORTALLA_1_INI']]."'".
                /*V_PORTALLA_1*/            ",'"  .$rows[$nom_columnas['PORTALLA_1']]. "'" ./*-Porcentaje Ajustada-*/
                /*V_UNID_OPCION_INICIO*/    ","   .$rows[$nom_columnas['UNID_OPCION_INICIO']]. "" .
                /*V_UNID_OPCION_AJUSTADA*/  ","   .$rows[$nom_columnas['UNID_OPCION_AJUSTADA']]."".
                /*V_UNIDADES*/              ","   .$rows[$nom_columnas['UNIDADES']]."".//unidades
                /*V_CANT_INNER*/            ","   .$rows[$nom_columnas['CANT_INNER']].""./*-N_CAJAS.-*/
                /*V_UND_ASIG_INI*/          ","   .$rows[$nom_columnas['UND_ASIG_INI']].""./*-Primera_Reparto.-*/
                /*V_DIFER_REPARTO*/         ","   .$rows[$nom_columnas['DIFER_REPARTO']].""./*-DIFERENCIA-*/
                /*V_ROT*/                   ","   .$rows[$nom_columnas['ROT']].""./*%tienda*/
                /*V_VIA*/                   ","   .$rows[$nom_columnas['VIA']]. "" .
                /*V_NOM_VIA*/               ",'"  .$rows[$nom_columnas['NOM_VIA']]. "'" .
                /*V_PAIS*/                  ","   .$rows[$nom_columnas['PAIS']]. "" .
                /*V_NOM_PAIS*/              ",'"  .$rows[$nom_columnas['NOM_PAIS']] . "'" .
                /*V_MKUP*/                  ","   .$rows[$nom_columnas['MKUP']]. "" .
                /*V_PRECIO_BLANCO*/         ","   .$rows[$nom_columnas['PRECIO_BLANCO']] . "" .
                /*V_GM*/                    ","   .$rows[$nom_columnas['GM']] ."" .
                /*V_COSTO_FOB*/             ","   .$rows[$nom_columnas['COSTO_FOB']]. "" .
                /*V_COSTO_INSP*/            ","   .$rows[$nom_columnas['COSTO_INSP']]. "" .
                /*V_COSTO_RFID*/            ","   .$rows[$nom_columnas['COSTO_RFID']]. "" .
                /*V_COSTO_UNIT*/            ","   .$rows[$nom_columnas['COSTO_UNIT']]. "" .
                /*V_COSTO_UNITS*/           ","   .$rows[$nom_columnas['COSTO_UNITS']]. "" .
                /*V_COSTO_TOT*/             ","   .$rows[$nom_columnas['COSTO_TOT']]. "" .
                /*V_COSTO_TOTS*/            ","   .$rows[$nom_columnas['COSTO_TOTS']]. "" .
                /*V_RETAIL*/                ","   .$rows[$nom_columnas['RETAIL']]. "" .
                /*V_DEBUT_REODER*/          ",'"  .$rows[$nom_columnas['DEBUT_REODER']]."'".
                /*V_SEM_INI*/               ",'"  .$rows[$nom_columnas['SEM_INI']]."'".
                /*V_SEM_FIN*/               ",'"  .$rows[$nom_columnas['SEM_FIN']]. "'" .
                /*V_CICLO*/                 ",'"  .$rows[$nom_columnas['CICLO']]. "'" .
                /*V_SEMLIQ*/                ","   .$rows[$nom_columnas['SEMLIQ']]. "" .
                /*V_ALIAS_PROV*/            ",'"  .$rows[$nom_columnas['ALIAS_PROV']]. "'" .
                /*V_PORCEN_T1*/             ",'"  .$rows[$nom_columnas['PORCEN_T1']]. "'" .
                /*V_PORCEN_T2*/             ",'"  .$rows[$nom_columnas['PORCEN_T2']]. "'" .
                /*V_PORCEN_T3*/             ",'"  .$rows[$nom_columnas['PORCEN_T3']]. "'" .
                /*V_PORCEN_T4*/             ",'"  .$rows[$nom_columnas['PORCEN_T4']] . "'" .
                /*V_PORCEN_T5*/             ",'"  .$rows[$nom_columnas['PORCEN_T5']]. "'" .
                /*V_PORCEN_T6*/             ",'"  .$rows[$nom_columnas['PORCEN_T6']]. "'" .
                /*V_PORCEN_T7*/             ",'"  .$rows[$nom_columnas['PORCEN_T7']]. "'" .
                /*V_PORCEN_T8*/             ",'"  .$rows[$nom_columnas['PORCEN_T8']]. "'" .
                /*V_PORCEN_T9*/             ",'"  .$rows[$nom_columnas['PORCEN_T9']]. "'" .
                /*V_CANT_T1*/               ","   .$rows[$nom_columnas['CANT_T1']]. "" .
                /*V_CANT_T2*/               ","   .$rows[$nom_columnas['CANT_T2']]. "" .
                /*V_CANT_T3*/               ","   .$rows[$nom_columnas['CANT_T3']]. "" .
                /*V_CANT_T4*/               ","   .$rows[$nom_columnas['CANT_T4']]. "" .
                /*V_CANT_T5*/               ","   .$rows[$nom_columnas['CANT_T5']]. "" .
                /*V_CANT_T6*/               ","   .$rows[$nom_columnas['CANT_T6']]. "" .
                /*V_CANT_T7*/               ","   .$rows[$nom_columnas['CANT_T7']]. "" .
                /*V_CANT_T8*/               ","   .$rows[$nom_columnas['CANT_T8']]. "" .
                /*V_CANT_T9*/               ","   .$rows[$nom_columnas['CANT_T9']]. "" .
                /*V_ID_CORPORATIVO*/        ",'"  .utf8_encode($rows[$nom_columnas['ID_CORPORATIVO']]). "'" .
                /*V_COMPOSICION*/           ",'"  .utf8_encode($rows[$nom_columnas['COMPOSICION']]). "'" .
                /*V_DESCRIP_INTERNET*/      ",'"  .utf8_encode($rows[$nom_columnas['DESCRIP_INTERNET']]). "'" .
                /*V_COLECCION*/             ",'"  .utf8_encode($rows[$nom_columnas['COLECCION']]). "'" .
                /*V_EVENTO*/                ",'"  .utf8_encode($rows[$nom_columnas['EVENTO']]). "'" .
                /*V_COD_ESTILO_VIDA*/       ","   .$rows[$nom_columnas['COD_ESTILO_VIDA']]. "" .
                /*V_NOM_ESTILOVIDA*/        ",'"  .utf8_encode($rows[$nom_columnas['NOM_ESTILOVIDA']]). "'" .
                /*V_COD_OCASION_USO*/       ","   .$rows[$nom_columnas['COD_OCASION_USO']]. "" .
                /*V_NOM_OCACIONUSO*/        ",'"  .utf8_encode($rows[$nom_columnas['NOM_OCACIONUSO']]). "'" .
                /*V_COD_RANKVTA*/           ","   .$rows[$nom_columnas['COD_RANKVTA']]. "" .
                /*V_NOM_RNK*/               ",'"  .utf8_encode($rows[$nom_columnas['NOM_RNK']]). "'" .
                /*V_LIFE_CYCLE*/            ","   .$rows[$nom_columnas['LIFE_CYCLE']]. "" .
                /*V_NOM_LIFECYCLE*/         ",'"  .utf8_encode($rows[$nom_columnas['NOM_LIFECYCLE']]). "'" .
                /*V_TIPO_PRODUCTO*/         ",'"  .utf8_encode($rows[$nom_columnas['TIPO_PRODUCTO']]). "'" .
                /*V_TIPO_EXHIBICION*/       ",'"  .utf8_encode($rows[$nom_columnas['TIPO_EXHIBICION']]). "'" . ", :error, :data); end;");

        $data = \database::getInstancia()->getConsultaSP($sql, 2);

        $_error = explode("#", $data);
        if ($_error[0] == 1 ){
            $_insert = false;
            $array = array('Tipo' => FALSE,
                'Error'=> "Actualización Registro Compra =|".$_error[1]."|");
        }

        if ($_insert == false ){
            return $array;

        }else{
            $array = array('Tipo' => TRUE,
                'Error'=> "(".''.") -> ".''."");
            return $array;
        };

    }
    public static function InsertHistorialBmt($rows,$nom_columnas,$cod_tempo){
        $_insert = true;
        //for($i =1 ;$i <= $limite; $i++) {

        $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_HIS_IMPORT_BMT" .
            /*v_purchase_group*/            ("('".$rows[$nom_columnas['PURCHASE GROUP']] . "'" .
                /*v_corporate_buyer_name*/      ",'" .$rows[$nom_columnas['CORPORATE BUYER NAME']]. "'" .
                /*v_disigner_name*/             ",'" .$rows[$nom_columnas['DISIGNER NAME']]. "'" .
                /*v_pi_season*/                 ",'" .$rows[$nom_columnas['PI SEASON']]. "'" .
                /*v_style_number*/              ",''" .
                /*V_OPTION_NUMBER*/             ",'" .$rows[$nom_columnas['OPTION NUMBER']]. "'" .
                /*v_stye_name*/                 ",'" .$rows[$nom_columnas['STYLE NAME']]. "'" .
                /*v_short_name*/                ",'" .$rows[$nom_columnas['SHORT_NAME']]. "'" .
                /*v_photograf*/                 ",'" .$rows[$nom_columnas['PHOTOGRAF']]. "'" .
                /*v_color_code*/                ",'" .$rows[$nom_columnas['COLOR CODE']]. "'" .
                /*v_color_name*/                ",'" .$rows[$nom_columnas['COLOR NAME']]. "'" .
                /*v_colection*/                 ",'" .$rows[$nom_columnas['COLECTION']]. "'" .
                /*v_composition*/               ",'" .$rows[$nom_columnas['COMPOSITION']]. "'" .
                /*v_lining*/                    ",'" .$rows[$nom_columnas['LINING']]. "'" .
                /*v_type_of_fabric*/            ",'" .$rows[$nom_columnas['TYPE OF FABRIC']]. "'" .
                /*v_details*/                   ",'" .$rows[$nom_columnas['DETAILS']]. "'" .
                /*v_before_meeting_remarks*/    ",'" .$rows[$nom_columnas['BEFORE MEETING REMARKS']]. "'" .
                /*v_after_meeting_remarks*/     ",'" .$rows[$nom_columnas['AFTER MEETING REMARKS']]. "'" .
                /*v_product_description*/       ",'" .$rows[$nom_columnas['PRODUCT DESCRIPTION']]. "'" .
                /*v_style_gender*/              ",'" .$rows[$nom_columnas['STYLE GENDER']]. "'" .
                /*v_season*/                    ",'" .$rows[$nom_columnas['SEASON']]. "'" .
                /*v_target_vendedor*/           ",'" .$rows[$nom_columnas['TARGET VENDOR']]. "'" .
                /*v_vendor_nick_name*/          ",'" .$rows[$nom_columnas['VENDOR NICK NAME']]. "'" .
                /*v_vendor_code*/               ",'" .$rows[$nom_columnas['VENDOR CODE']]. "'" .
                /*v_country_of_origin*/         ",'" .$rows[$nom_columnas['COUNTRY OF ORIGIN']]. "'" .
                /*v_hko_no_hko*/                ",'" .$rows[$nom_columnas['HKO/NO HKO']]. "'" .
                /*v_target_cost*/               ",'" .$rows[$nom_columnas['TARGET COST']]. "'" .
                /*v_target_budget*/             ",'" .$rows[$nom_columnas['TARGET BUDGET']]. "'" .
                /*v_total_quantity*/            ",'" .$rows[$nom_columnas['TOTAL QUANTITY']]. "'" .
                /*v_final_costo*/               ",'" .$rows[$nom_columnas['FINAL COST']]. "'" .
                /*v_final_burget*/              ",'" .$rows[$nom_columnas['FINAL BUDGET']]. "'" .
                /*v_lead_time_type*/            ",'" .$rows[$nom_columnas['LEAD TIME TYPE']]. "'" .
                /*v_local_buyer*/               ",'" .$rows[$nom_columnas['LOCAL BUYER']]. "'" .
                /*v_local_brand*/               ",'" .$rows[$nom_columnas['LOCAL BRAND']]. "'" .
                /*v_department*/                ",'" .$rows[$nom_columnas['DEPARTMENT']]. "'" .
                /*v_department_code*/           ",'" .$rows[$nom_columnas['DEPARTMENT CODE']]. "'" .
                /*v_temporada*/                 ",'" .$cod_tempo. "'" .
                /*v_line*/                      ",'" .$rows[$nom_columnas['LINE (*)']]. "'" .
                /*v_subline*/                   ",'" .$rows[$nom_columnas['SUBLINE']]. "'" .
                /*v_subline_code*/              ",'" .$rows[$nom_columnas['SUBLNE CODE']]. "'" .
                /*v_hierarchi*/                 ",''".
                /*v_life_cicle*/                ",'" .$rows[$nom_columnas['LIFE CICLE']]. "'" .
                /*v_product_season*/            ",'" .$rows[$nom_columnas['PRODUCT SEASON']]. "'" .
                /*v_pyramid_mix*/               ",'" .$rows[$nom_columnas['PYRAMID MIX']]. "'" .
                /*v_type_product*/              ",'" .$rows[$nom_columnas['TYPE OF PRODUCT']]. "'" .
                /*v_chance_of_user*/            ",'" .$rows[$nom_columnas['CHANCE OF USER']]. "'" .
                /*v_ranking_of_sale*/           ",'" .$rows[$nom_columnas['RANKING OF SALE']]. "'" .
                /*v_life_style*/                ",'" .$rows[$nom_columnas['LIFE STYLE']]. "'" .
                /*v_ratail_price*/              ",'" .$rows[$nom_columnas['RETAIL PRICE']]. "'" .
                /*v_price_range*/               ",'" .$rows[$nom_columnas['PRICE RANGE']]. "'" .
                /*v_dos_x_retail_price*/        ",'" .$rows[$nom_columnas['2 X RETAIL PRICE']]. "'" .
                /*v_antes_ahora*/               ",'" .$rows[$nom_columnas['ANTES/AHORA']]. "'" .
                /*v_evento*/                    ",'" .$rows[$nom_columnas['EVENTO']]. "'" .
                /*v_shipment_mode*/             ",'" .$rows[$nom_columnas['SHIPMENT MODE']]. "'" .
                /*v_ventana*/                   ",'" .$rows[$nom_columnas['VENTANA']]. "'" .
                /*v_mm_dd1*/                    ",'" .$rows[$nom_columnas['mm/dd1']]. "'" .
                /*v_mm_dd2*/                    ",'" .$rows[$nom_columnas['mm/dd2']]. "'" .
                /*v_mm_dd3*/                    ",'" .$rows[$nom_columnas['mm/dd3']]. "'" .
                /*v_mm_dd4*/                    ",'" .$rows[$nom_columnas['mm/dd4']]. "'" .
                /*v_mm_dd5*/                    ",'" .$rows[$nom_columnas['mm/dd5']]. "'" .
                /*v_mm_dd6*/                    ",'" .$rows[$nom_columnas['mm/dd6']]. "'" .
                /*v_mm_dd7*/                    ",'" .$rows[$nom_columnas['mm/dd7']]. "'" .
                /*v_total_quantity_cl*/         ",'" .$rows[$nom_columnas['TOTAL QUANTITY CL']]. "'" .
                /*v_size_type*/                 ",''".
                /*v_size_*/                     ",'" .$rows[$nom_columnas['SIZE']]. "'" .
                /*v_size_por_1*/                ",'" .$rows[$nom_columnas['Size %1']]. "'" .
                /*v_size_por_2*/                ",'" .$rows[$nom_columnas['Size %2']]. "'" .
                /*v_size_por_3*/                ",'" .$rows[$nom_columnas['Size %3']]. "'" .
                /*v_size_por_4*/                ",'" .$rows[$nom_columnas['Size %4']]. "'" .
                /*v_size_por_5*/                ",'" .$rows[$nom_columnas['Size %5']]. "'" .
                /*v_size_por_6*/                ",'" .$rows[$nom_columnas['Size %6']]. "'" .
                /*v_size_por_7*/                ",'" .$rows[$nom_columnas['Size %7']]. "'" .
                /*v_size_por_8*/                ",'" .$rows[$nom_columnas['Size %8']]. "'" .
                /*v_size_por_9*/                ",'" .$rows[$nom_columnas['Size %9']]. "'" .
                /*v_size_por_10*/               ",'" .$rows[$nom_columnas['Size %10']]. "'" .
                /*v_size_por_11*/               ",'" .$rows[$nom_columnas['Size %11']]. "'" .
                /*v_size_por_12*/               ",'" .$rows[$nom_columnas['Size %12']]. "'" .
                /*v_size_por_13*/               ",'" .$rows[$nom_columnas['Size %13']]. "'" .
                /*v_size_por_14*/               ",'" .$rows[$nom_columnas['Size %14']]. "'" .
                /*v_size_por_15*/               ",'" .$rows[$nom_columnas['Size %15']]. "'" .
                /*v_qty_coun_1*/                ",'" .$rows[$nom_columnas['Qty #1']]. "'" .
                /*v_qty_coun_2*/                ",'" .$rows[$nom_columnas['Qty #2']]. "'" .
                /*v_qty_coun_3*/                ",'" .$rows[$nom_columnas['Qty #3']]. "'" .
                /*v_qty_coun_4*/                ",'" .$rows[$nom_columnas['Qty #4']]. "'" .
                /*v_qty_coun_5*/                ",'" .$rows[$nom_columnas['Qty #5']]. "'" .
                /*v_qty_coun_6*/                ",'" .$rows[$nom_columnas['Qty #6']]. "'" .
                /*v_qty_coun_7*/                ",'" .$rows[$nom_columnas['Qty #7']]. "'" .
                /*v_qty_coun_8*/                ",'" .$rows[$nom_columnas['Qty #8']]. "'" .
                /*v_qty_coun_9*/                ",'" .$rows[$nom_columnas['Qty #9']]. "'" .
                /*v_qty_coun_10*/               ",'" .$rows[$nom_columnas['Qty #10']]. "'" .
                /*v_qty_coun_11*/               ",'" .$rows[$nom_columnas['Qty #11']]. "'" .
                /*v_qty_coun_12*/               ",'" .$rows[$nom_columnas['Qty #12']]. "'" .
                /*v_qty_coun_13*/               ",'" .$rows[$nom_columnas['Qty #13']]. "'" .
                /*v_qty_coun_14*/               ",'" .$rows[$nom_columnas['Qty #14']]. "'" .
                /*v_qty_coun_15*/               ",'" .$rows[$nom_columnas['Qty #15']]. "'" .
                /*v_prepack*/                   ",'" .$rows[$nom_columnas['PREPACK']]. "'" .
                /*v_handling_type*/             ",'" .$rows[$nom_columnas['HANDLING TYPE']]. "'" .
                /*v_handling_type_cd*/          ",'" .$rows[$nom_columnas['HANDLING TYPE CD']]. "'" .
                /*v_size_sticker*/              ",'" .$rows[$nom_columnas['SIZE STICKER']]. "'" .
                /*v_units_per_box*/             ",'" .$rows[$nom_columnas['UNITS PER BOX']]. "'" .
                /*v_reorder*/                   ",'" .$rows[$nom_columnas['REORDER']]. "'" .
                /*v_cost_last_purchase*/        ",'" .$rows[$nom_columnas['COST LAST PURCHASE']]. "'" .
                /*v_vendor_last_purchase*/      ",'" .$rows[$nom_columnas['VENDOR LAST PURCHASE']]. "'" .
                /*v_extended_warranty*/         ",'" .$rows[$nom_columnas['EXTENDED WARRANTY']]. "'" .
                /*v_inspection_needed*/         ",''".
                /*v_inspection_cost*/           ",'" .$rows[$nom_columnas['INSPECTION COST']]. "'" .
                /*v_royalty*/                   ",'" .$rows[$nom_columnas['ROYALTY']]. "'" .
                /*v_size_sample*/               ",'" .$rows[$nom_columnas['SIZE SAMPLE']]. "'" .
                /*v_cod_corp*/                  ",'" .$rows[$nom_columnas['COD CORP']]. "'" .
                /*v_internet_description*/      ",'" .$rows[$nom_columnas['DESCRIPCION INTERNET']]. "'" .
                /*v_cluster_r*/                 ",'" .$rows[$nom_columnas['CLUSTER']]. "'" .
                /*v_cost_rfid*/                 ",'" .$rows[$nom_columnas['RFID COST']]. "'" .
                /*v_tipo_exhibicion*/           ",'" .$rows[$nom_columnas['TYPE OF EXHIBITION']]. "'" .
                /*v_local_buyer_peru*/          ",'" .$rows[$nom_columnas['LOCAL BUYER P']]. "'" .
                /*v_local_brand_peru*/          ",'" .$rows[$nom_columnas['LOCAL BRAND P']]. "'" .
                /*v_department_peru*/           ",'" .$rows[$nom_columnas['DEPARTMENT P']]. "'" .
                /*v_department_code_peru*/      ",'" .$rows[$nom_columnas['DEPARTMENT CODE P']]. "'" .
                /*v_line_peru*/                 ",'" .$rows[$nom_columnas['LINE (*) P']]. "'" .
                /*v_subline_peru*/              ",'" .$rows[$nom_columnas['SUBLINE P']]. "'" .
                /*v_subline_code_peru*/         ",'" .$rows[$nom_columnas['SUBLNE CODE P']]. "'" .
                /*v_hierarchi_peru*/            ",'" .$rows[$nom_columnas['HIERARCHI P']]. "'" .
                /*v_life_cicle_peru*/           ",'" .$rows[$nom_columnas['LIFE CICLE P']]. "'" .
                /*v_product_season_peru*/       ",'" .$rows[$nom_columnas['PRODUCT SEASON P']]. "'" .
                /*v_pyramid_mix_peru*/          ",'" .$rows[$nom_columnas['PYRAMID MIX P']]. "'" .
                /*v_chance_of_user_peru*/       ",'" .$rows[$nom_columnas['CHANCE OF USER P']]. "'" .
                /*v_ranking_of_sale_peru*/      ",'" .$rows[$nom_columnas['RANKING OF SALE P']]. "'" .
                /*v_life_style_peru*/           ",'" .$rows[$nom_columnas['LIFE STYLE P']]. "'" .
                /*v_ratail_price_peru*/         ",'" .$rows[$nom_columnas['RETAIL PRICE P']]. "'" .
                /*v_price_range_peru*/          ",'" .$rows[$nom_columnas['2 X RETAIL PRICE P']]. "'" .
                /*v_dos_x_retail_price_peru*/   ",'" .$rows[$nom_columnas['ANTES/AHORA P']]. "'" .
                /*v_antes_ahora_peru*/          ",'" .$rows[$nom_columnas['EVENTO P']]. "'" .
                /*v_evento_peru*/               ",'" .$rows[$nom_columnas['SHIPMENT MODE P']]. "'" .
                /*v_shipment_mode_peru*/        ",'" .$rows[$nom_columnas['SHIPMENT MODE P']]. "'" .
                /*v_ventana_peru*/              ",'" .$rows[$nom_columnas['VENTANA P']]. "'" .
                /*v_mm_dd1_peru*/               ",'" .$rows[$nom_columnas['mm/dd1 P']]. "'" .
                /*v_mm_dd2_peru*/               ",'" .$rows[$nom_columnas['mm/dd2 P']]. "'" .
                /*v_mm_dd3_peru*/               ",'" .$rows[$nom_columnas['mm/dd3 P']]. "'" .
                /*v_mm_dd4_peru*/               ",'" .$rows[$nom_columnas['mm/dd4 P']]. "'" .
                /*v_mm_dd5_peru*/               ",'" .$rows[$nom_columnas['mm/dd5 P']]. "'" .
                /*v_mm_dd6_peru*/               ",'" .$rows[$nom_columnas['mm/dd6 P']]. "'" .
                /*v_mm_dd7_peru*/               ",'" .$rows[$nom_columnas['mm/dd7 P']]. "'" .
                /*v_total_quantity_cl_peru*/    ",'" .$rows[$nom_columnas['TOTAL QUANTITY P']]. "'" .
                /*v_size_type_peru*/            ",'" .$rows[$nom_columnas['SIZE TYPE P']]. "'" .
                /*v_size__peru*/                ",'" .$rows[$nom_columnas['SIZE P']]. "'" .
                /*v_size_por_1_peru*/           ",'" .$rows[$nom_columnas['Size %1 P']]. "'" .
                /*v_size_por_2_peru*/           ",'" .$rows[$nom_columnas['Size %2 P']]. "'" .
                /*v_size_por_3_peru*/           ",'" .$rows[$nom_columnas['Size %3 P']]. "'" .
                /*v_size_por_4_peru*/           ",'" .$rows[$nom_columnas['Size %4 P']]. "'" .
                /*v_size_por_5_peru*/           ",'" .$rows[$nom_columnas['Size %5 P']]. "'" .
                /*v_size_por_6_peru*/           ",'" .$rows[$nom_columnas['Size %6 P']]. "'" .
                /*v_size_por_7_peru*/           ",'" .$rows[$nom_columnas['Size %7 P']]. "'" .
                /*v_size_por_8_peru*/           ",'" .$rows[$nom_columnas['Size %8 P']]. "'" .
                /*v_size_por_9_peru*/           ",'" .$rows[$nom_columnas['Size %9 P']]. "'" .
                /*v_size_por_10_peru*/          ",'" .$rows[$nom_columnas['Size %10 P']]. "'" .
                /*v_size_por_11_peru*/          ",'" .$rows[$nom_columnas['Size %12 P']]. "'" .
                /*v_size_por_12_peru*/          ",'" .$rows[$nom_columnas['Size %13 P']]. "'" .
                /*v_size_por_13_peru*/          ",'" .$rows[$nom_columnas['Size %14 P']]. "'" .
                /*v_size_por_14_peru*/          ",'" .$rows[$nom_columnas['Size %14 P']]. "'" .
                /*v_size_por_15_peru*/          ",'" .$rows[$nom_columnas['Size %15 P']]. "'" .
                /*v_qty_coun_1_peru*/           ",'" .$rows[$nom_columnas['Qty #1 P']]. "'" .
                /*v_qty_coun_2_peru*/           ",'" .$rows[$nom_columnas['Qty #2 P']]. "'" .
                /*v_qty_coun_3_peru*/           ",'" .$rows[$nom_columnas['Qty #3 P']]. "'" .
                /*v_qty_coun_4_peru*/           ",'" .$rows[$nom_columnas['Qty #4 P']]. "'" .
                /*v_qty_coun_5_peru*/           ",'" .$rows[$nom_columnas['Qty #5 P']]. "'" .
                /*v_qty_coun_6_peru*/           ",'" .$rows[$nom_columnas['Qty #6 P']]. "'" .
                /*v_qty_coun_7_peru*/           ",'" .$rows[$nom_columnas['Qty #7 P']]. "'" .
                /*v_qty_coun_8_peru*/           ",'" .$rows[$nom_columnas['Qty #8 P']]. "'" .
                /*v_qty_coun_9_peru*/           ",'" .$rows[$nom_columnas['Qty #9 P']]. "'" .
                /*v_qty_coun_10_peru*/          ",'" .$rows[$nom_columnas['Qty #10 P']]. "'" .
                /*v_qty_coun_11_peru*/          ",'" .$rows[$nom_columnas['Qty #11 P']]. "'" .
                /*v_qty_coun_12_peru*/          ",'" .$rows[$nom_columnas['Qty #12 P']]. "'" .
                /*v_qty_coun_13_peru*/          ",'" .$rows[$nom_columnas['Qty #13 P']]. "'" .
                /*v_qty_coun_14_peru*/          ",'" .$rows[$nom_columnas['Qty #14 P']]. "'" .
                /*v_qty_coun_15_peru*/          ",'" .$rows[$nom_columnas['Qty #15 P']]. "'" .
                /*v_prepack_peru*/              ",'" .$rows[$nom_columnas['PREPACK P']]. "'" .
                /*v_handling_type_peru*/        ",'" .$rows[$nom_columnas['HANDLING TYPE P']]. "'" .
                /*v_size_sticker_peru*/         ",'" .$rows[$nom_columnas['SIZE STICKER P']]. "'" .
                /*v_units_per_box_peru*/        ",'" .$rows[$nom_columnas['UNITS PER BOX P']]. "'" .
                /*v_reorder_peru*/              ",'" .$rows[$nom_columnas['REORDER P']]. "'" .
                /*v_cost_last_purchase_peru*/   ",'" .$rows[$nom_columnas['COST LAST PURCHASE P']]. "'" .
                /*v_vendor_last_purchase_peru*/ ",'" .$rows[$nom_columnas['VENDOR LAST PURCHASE P']]. "'" .
                /*v_extended_warranty_peru*/    ",'" .$rows[$nom_columnas['EXTENDED WARRANTY P']]. "'" .
                /*v_inspection_needed_peru*/    ",'" .$rows[$nom_columnas['INSPECTION NEEDED P']]. "'" .
                /*v_inspection_cost_peru*/      ",'" .$rows[$nom_columnas['INSPECTION COST P']]. "'" .
                /*v_royalty_peru*/              ",'" .$rows[$nom_columnas['ROYALTY P']]. "'" .
                /*v_peru_dumping_peru*/         ",'" .$rows[$nom_columnas['PERU DUMPING P']]. "'" .
                /*v_size_sample_peru*/          ",'" .$rows[$nom_columnas['SIZE SAMPLE P']]. "'" .
                /*v_id_color3*/                 ",0, :error, :data); end;");

        $data = \database::getInstancia()->getConsultaSP($sql, 2);

        $_error = explode("#", $data);
        if ($_error[0] == 1 ){
            $array = array('Tipo' => FALSE,
                'Error'=> "Error en el Insertado Historico =|".$_error[1]."|");
            return $array;
        }else{
            $array = array('Tipo' => TRUE,
                'Error'=> "(".''.") -> ".''."");
            return $array;
        }
    }
    public static function InsertPlanCompraBMT($rows,$limite,$nom_columnas,$cod_tempo,$depto,$login){

        $_insert = TRUE;
        $array=[];

        for ($i = 1; $i <= $limite; $i++) {
            $dtplanCompra = plan_compra::listar_plan_compraPorID($cod_tempo,$depto,$rows[$i][$nom_columnas['ID C1']]);
            $cod_vent = plan_compra::get_codName($rows[$i][$nom_columnas['VENTANA']], plan_compra::list_ventanas($cod_tempo));
            $cod_pais = plan_compra::get_codName($rows[$i][$nom_columnas['COUNTRY OF ORIGIN']], plan_compra::list_pais());
            $cod_via  = plan_compra::get_codName($rows[$i][$nom_columnas['SHIPMENT MODE']], plan_compra::list_via());
            $unidfinal = $rows[$i][$nom_columnas['TOTAL QUANTITY CL']];
            $por_Inicial = plan_compra::get_ComposicionCampos($rows, $nom_columnas, $i, "Size %");
            $dtAjustada = plan_compra::AjustesPrimerRepartobmt($por_Inicial //porcentajes iniciales
                ,$rows[$i][$nom_columnas['TOTAL QUANTITY CL']] //unidades iniciales
                ,$dtplanCompra[0]["CURVATALLA"]// Curvas
                ,$rows[$i][$nom_columnas['SIZE']]//Tallas
                ,$rows[$i]
                ,$nom_columnas
                ,$cod_tempo//Temporada
                ,$depto //depto
                ,plan_compra::get_codMarca($rows[$i][$nom_columnas['LOCAL BRAND']],$depto) //marca
                ,$rows[$i][$nom_columnas['REORDER']]
                ,$rows[$i][$nom_columnas['PREPACK']]
                ,$dtplanCompra[0]["N_CURVASXCAJAS"]
                ,$dtplanCompra[0]["FORMATO"]
                ,$dtplanCompra
                ,$dtplanCompra[0]['MSTPACK']);

            $dtdiviporcent = plan_compra::Division_porcent ($dtAjustada[1]);
            $dtdivicantidad = plan_compra::Division_cantidades($dtAjustada[6]);
            $Cos_Uni_Finl_US = plan_compra::Cost_Uni_final_us ($rows[$i][$nom_columnas['TARGET COST']],$rows[$i][$nom_columnas['FINAL COST']],$rows[$i][$nom_columnas['INSPECTION COST']],$rows[$i][$nom_columnas['RFID COST']]);
            $Cos_Uni_Finl_Pesos = plan_compra::getC_uni_finalbmt($Cos_Uni_Finl_US,$rows[$i][$nom_columnas['VENTANA']],$cod_tempo,$depto,$cod_pais,$cod_via);
            $nomcolor = plan_compra::get_nomColor($rows[$i][$nom_columnas['COLOR CODE']]);

            $sql = "begin PLC_PKG_DESARROLLO.PRC_UPDATE_PLAN_COMPRA_COLOR_3" .
                /*V_COD_TEMPORADA*/             ("('" .$cod_tempo . "'" .
                    /*V_DEP_DEPTO*/             ",'"  .$depto . "'" .
                    /*V_DES_ESTILO*/            ",'"  .$rows[$i][$nom_columnas['STYLE NAME']] . "'" .
                    /*V_ID_COLOR3*/             ","   .$rows[$i][$nom_columnas['ID C1']] . "" .
                    /*V_VENT_EMB*/              ","   .$cod_vent."".
                    /*V_NOM_VENTANA*/           ",'"  .$rows[$i][$nom_columnas['VENTANA']] . "'" .
                    /*V_VENTANA_LLEGADA*/       ","   .$cod_vent."".
                    /*V_COD_COLOR*/             ","   .$rows[$i][$nom_columnas['COLOR CODE']] . "" .
                    /*V_NOM_COLOR*/             ",'"  .$nomcolor . "'" .
                    /*V_TIPO_EMPAQUE*/          ",'"  .$rows[$i][$nom_columnas['PREPACK']] . "'" .
                    /*V_PORTALLA_1_INI*/        ",'"  .$por_Inicial."'".
                    /*V_PORTALLA_1*/            ",'" . $dtAjustada[1]. "'" ./*-Porcentaje Ajustada-*/
                    /*V_UNID_OPCION_INICIO*/    ","   .$rows[$i][$nom_columnas['TOTAL QUANTITY CL']] . "" .
                    /*V_UNID_OPCION_AJUSTADA*/  ","   .$dtAjustada[0]."".
                    /*V_UNIDADES*/              ","   .$dtAjustada[3]."".//unidades
                    /*V_CANT_INNER*/            ","   .$dtAjustada[2].""./*-N_CAJAS.-*/
                    /*V_UND_ASIG_INI*/          ","   .$dtAjustada[4].""./*-Primera_Reparto.-*/
                    /*V_DIFER_REPARTO*/         ","   .$dtAjustada[5].""./*-DIFERENCIA-*/
                    /*V_ROT*/                   ","   .$dtAjustada[5].""./*%tienda*/
                    /*V_VIA*/                   ","   .$cod_via. "" .
                    /*V_NOM_VIA*/               ",'"  .$rows[$i][$nom_columnas['SHIPMENT MODE']] . "'" .
                    /*V_PAIS*/                  ","   .$cod_pais. "" .
                    /*V_NOM_PAIS*/              ",'"  .$rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] . "'" .
                    /*V_MKUP*/                  ","   .round(($rows[$i][$nom_columnas['RETAIL PRICE']]/1.19)/$Cos_Uni_Finl_Pesos,2). "" .
                    /*V_PRECIO_BLANCO*/         ","   .$rows[$i][$nom_columnas['RETAIL PRICE']] . "" .
                    /*V_GM*/                    ","   .round((($rows[$i][$nom_columnas['RETAIL PRICE']]/1.19)-$Cos_Uni_Finl_Pesos) / ($rows[$i][$nom_columnas['RETAIL PRICE']]/1.19) *100,2) ."" .
                    /*V_COSTO_FOB*/             ","   .$rows[$i][$nom_columnas['FINAL COST']] . "" .
                    /*V_COSTO_INSP*/            ","   .$rows[$i][$nom_columnas['INSPECTION COST']] . "" .
                    /*V_COSTO_RFID*/            ","   .$rows[$i][$nom_columnas['RFID COST']] . "" .
                    /*V_COSTO_UNIT*/            ","   .$Cos_Uni_Finl_US. "" .
                    /*V_COSTO_UNITS*/           ","   .$Cos_Uni_Finl_Pesos. "" .
                    /*V_COSTO_TOT*/             ","   .$Cos_Uni_Finl_US * $dtAjustada[3]. "" .
                    /*V_COSTO_TOTS*/            ","   .$Cos_Uni_Finl_Pesos * $dtAjustada[3]. "" .
                    /*V_RETAIL*/                ","   .round(($rows[$i][$nom_columnas['RETAIL PRICE']] * $dtAjustada[3])/1.19). "" .
                    /*V_DEBUT_REODER*/          ",'"  .$rows[$i][$nom_columnas['REORDER']]."'".
                    /*V_SEM_INI*/               ",'"  .plan_compra::SemanasIni_Fin('SemIni',$cod_vent,$cod_tempo,'','') ."'".
                    /*V_SEM_FIN*/               ",'"  .plan_compra::SemanasIni_Fin('SemFin',$cod_vent,$cod_tempo,plan_compra::get_codName($rows[$i][$nom_columnas['LIFE CICLE']], plan_compra::list_ciclo_vida()),$rows[$i][$nom_columnas['REORDER']])  . "'" .
                    /*V_CICLO*/                 ",'"  .plan_compra::getsemliq_cicloA('CicloA',$rows[$i][$nom_columnas['LIFE CICLE']],$rows[$i][$nom_columnas['REORDER']]) . "'" .
                    /*V_SEMLIQ*/                ","   .plan_compra::getsemliq_cicloA('semLiq',$rows[$i][$nom_columnas['LIFE CICLE']],$rows[$i][$nom_columnas['REORDER']]) . "" .
                    /*V_ALIAS_PROV*/            ",'"  .$rows[$i][$nom_columnas['VENDOR NICK NAME']] . "'" .
                    /*V_PORCEN_T1*/             ",'"  . $dtdiviporcent[0]  . "'" .
                    /*V_PORCEN_T2*/             ",'"  . $dtdiviporcent[1]  . "'" .
                    /*V_PORCEN_T3*/             ",'"  . $dtdiviporcent[2]  . "'" .
                    /*V_PORCEN_T4*/             ",'"  . $dtdiviporcent[3]  . "'" .
                    /*V_PORCEN_T5*/             ",'"  . $dtdiviporcent[4]  . "'" .
                    /*V_PORCEN_T6*/             ",'"  . $dtdiviporcent[5]  . "'" .
                    /*V_PORCEN_T7*/             ",'"  . $dtdiviporcent[6]  . "'" .
                    /*V_PORCEN_T8*/             ",'"  . $dtdiviporcent[7]  . "'" .
                    /*V_PORCEN_T9*/             ",'"  . $dtdiviporcent[8]  . "'" .
                    /*V_CANT_T1*/               ","  . $dtdivicantidad[0]  . "" .
                    /*V_CANT_T2*/               ","  . $dtdivicantidad[1]  . "" .
                    /*V_CANT_T3*/               ","  . $dtdivicantidad[2]  . "" .
                    /*V_CANT_T4*/               ","  . $dtdivicantidad[3]  . "" .
                    /*V_CANT_T5*/               ","  . $dtdivicantidad[4]  . "" .
                    /*V_CANT_T6*/               ","  . $dtdivicantidad[5]  . "" .
                    /*V_CANT_T7*/               ","  . $dtdivicantidad[6]  . "" .
                    /*V_CANT_T8*/               ","  . $dtdivicantidad[7]  . "" .
                    /*V_CANT_T9*/               ","  . $dtdivicantidad[8]  . "" . ", :error, :data); end;");

            $data = \database::getInstancia()->getConsultaSP($sql, 2);

            $_error = explode("#", $data);
            if ($_error[0] == 1 ){
                $_insert = false;
                $array = array('Tipo' => FALSE,
                    'Error'=> "Actualizacion Plan de Compra =|".$_error[1]."|");
                break;
            }

            $sql = "delete PLC_AJUSTES_COMPRA"
                . " where cod_temporada = " . $cod_tempo . ""
                . " and dep_depto = '" . $depto . "'"
                . " and id_color3 in (" . $rows[$i][$nom_columnas['ID C1']] . ")";
            \database::getInstancia()->getConsulta($sql);

            //Guardado PLC_AJUSTES_COMPRA $dtAjustada
            $_error = plan_compra::SaveAjuste_Compra(/*AJUSTE DE COMPRA*/  $dtAjustada[8]
                /*AJUSTE CURVADO*/   ,$dtAjustada[9]
                /*AJUSTE CUR SOLIDO*/,$dtAjustada[10]
                /*AJUSTE SOLIDO FUL*/,$dtAjustada[11]
                /*AJUSTE REORDER*/   ,$dtAjustada[12]
                /*DEBUT/REORDER*/    ,$rows[$i][$nom_columnas['REORDER']]
                /*TIPO EMPAQUE*/     ,$rows[$i][$nom_columnas['PREPACK']]
                /*ID_COLOR3*/        ,$rows[$i][$nom_columnas['ID C1']]
                /*Tallas*/           ,$rows[$i][$nom_columnas['SIZE']]
                /*TEMPO*/            ,$cod_tempo
                /*DEPTO*/            ,$depto);
            if (count($_error) == 1 ){
                $_insert = false;
                $array = array('Tipo' =>$_error["Tipo"],
                    'Error'=> "Guardado Plan de Compra Presupuesto =|".$_error["Error"]."|");
                break;
            }
        }

        if ($_insert == false ){
            return $array;
        }else{
            $array = array('Tipo' => TRUE,
                'Error'=> "(".''.") -> ".''."");
        };
        return $array;
    }
    public static function Cost_Uni_final_us ($Target,$FOB,$Insp,$RFID){
        $val = 0;
        if ($FOB > 0.0){
            $val = $FOB+$Insp+$RFID;
        }elseif ($Target > 0.0) {
            $val = $Target+$Insp+$RFID;
        }
        return $val;
    }
    public static function getC_uni_finalbmt($Cos_Uni_FinlUS,$ventana,$cod_temporada,$depto,$pais,$via){
        $costo = 0;
        $factor =  plan_compra::lis_factor($cod_temporada,$depto,$pais,$via,2,$ventana);

        if (count($factor) <> 0 ){
            $costo = round(($Cos_Uni_FinlUS * $factor[0][0]),0);
        }else{
            $tc = plan_compra::lis_tipo_cambio($cod_temporada,$depto,2,$ventana);
            if(count($tc)<> 0){
                $costo = round(($Cos_Uni_FinlUS * $tc[0][0]),0);
            }
        }
        return $costo;
    }
    public static function AjustesPrimerRepartobmt($por_Inicial,$unid_ini,$curva_reparto,$tallas,$rows
        ,$nom_columnas,$cod_tempo,$depto,$marca,$DEBUT,$tipo_empaque
        ,$N_CURVAS_CAJAS,$formato,$dtplanCompra,$mstpack){

        /*******************AJUSTE CUERVA DE COMPRA*********************/
        $dtTabla = []; $dtTablaCurvado = [];$dtTablasSolidoCurvado = [];$dtTablasolidoFULL = [];$dtTablaReorder =[];
        $unid_ajustas = 0;$unid_final = 0;$porcentajeAjust = "";$n_cajasfinales = 0;$totalprimerRepato = 0;$unid_ajustasxtallas = "";
        $N_Columna = count(explode(",", trim($tallas)));

        //*-----------------tallas columnas
        $tallas2 = explode(",", trim($tallas));
        $insert = [];
        foreach ($tallas2 as $var) {
            array_push($insert, $var);
        }
        array_push($insert, "Total");
        array_push($dtTabla, $insert);

        $clusters3 = "";
        IF ($DEBUT == "DEBUT"){
            //*-----------------curva de compra
            $insert = [];$por_Inicial = explode("-", trim($por_Inicial));$total = 0;
            foreach ($por_Inicial as $var) {
                $total += round((($var * $unid_ini) / 100));
                array_push($insert, round((($var * $unid_ini) / 100)));
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);


            //*-----------------Curva del Primer Reparto
            $insert = [];$curvas = explode(",", trim($curva_reparto));$total = 0;
            $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $dtplanCompra[0]['CLUSTER1'], $formato));
            foreach ($curvas as $var) {
                $primer = 0;
                foreach ($clusters as $varc) {
                    $ntdas = 0;
                    if ($formato == "" OR $formato == "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                    }
                    elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                    }
                    $primer += $var * $dtplanCompra[0]["CLUSTER" . $varc] * $ntdas["TIENDAS"];
                }
                $total += $primer;
                array_push($insert, $primer);
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------diferencial
            $key = 0;$insert = [];$total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                if ($dtTabla[1][$key] < $dtTabla[2][$key]) {
                    $val = $dtTabla[1][$key] - $dtTabla[2][$key];
                }
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------Total
            $key = 0;$insert = [];$total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                if ($dtTabla[3][$key] <> 0) {
                    $val = $dtTabla[2][$key];
                } else {
                    $val = $dtTabla[1][$key];
                }
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------CURVA DE COMPRA Ajustada
            $key = 0;$insert = [];$total = "";
            $TotalAjust = $dtTabla[4][$N_Columna];
            foreach ($tallas2 as $var) {
                $val = 0;
                $val = (round((($dtTabla[4][$key] / $TotalAjust) * 100), 5));
                if (strlen($val) > 6) {
                    $val = round($val, 3);
                }
                $total = $total . $val . "-";
                array_push($insert, $val);
                $key += 1;

            }
            $total = substr($total, 0, -1);
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            /*%*/$unid_ajustas = $dtTabla[4][$N_Columna];

            /*CURVADO*/ if ($tipo_empaque == "Curvado" or $tipo_empaque == "CURVADO") {
                //*****************1.-AJUSTE DE CAJAS CURVADOS
                array_push($dtTablaCurvado, $dtTabla[0]);//CABECERA
                array_push($dtTablaCurvado, $dtTabla[4]);//TOTAL AJUSTE COMPRA

                //*-----------------Curva del Primer Reparto
                $insert = [];$total = 0;
                $curvas = explode(",", trim($curva_reparto));
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo,$dtplanCompra[0]['CLUSTER1'], $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $ntdas = 0;
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }
                        $primer += $var * $dtplanCompra[0]["CLUSTER" . $varc] * $ntdas["TIENDAS"];
                    }
                    $total += $primer;
                    array_push($insert, $primer);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);

                //*-----------------Curvas de repartos EJ: 1,2,3,4
                $insert = [];$total = 0;
                foreach ($curvas as $var) {
                    $total += $var;
                    array_push($insert, $var);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);

                //Curva minima * n° de curva/caja
                //$masterCurvado = $dtTablaCurvado [3][$N_Columna] * $N_CURVAS_CAJAS;
                $insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $dtTablaCurvado [3][$N_Columna] * $N_CURVAS_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //total 1er repato / inner(curva min)
                $Curva_repartir = $dtTablaCurvado [2][$N_Columna] / $dtTablaCurvado[3][$N_Columna];$insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $Curva_repartir);
                array_push($dtTablaCurvado, $insert);

                //Curva a repartir / n de curva cajas
                $n_CAJAS = $Curva_repartir / $N_CURVAS_CAJAS;$insert = [];
                foreach ($tallas2 as $vart){array_push($insert, 0);}
                array_push($insert, $n_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //N° de curvas caja
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $N_CURVAS_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //*-------------porcenjas compra curvada
                $key2 = 0;
                foreach ($tallas2 as $vart) {
                    if ($dtTablaCurvado [2][$key2] <> 0) {
                        $porcentajeAjust = $porcentajeAjust . (round(($dtTablaCurvado[2][$key2] / $dtTablaCurvado [2][$N_Columna]) * 100, 3)) . "-";
                    } else {
                        $porcentajeAjust = $porcentajeAjust . "0-";
                    }
                    $key2 += 1;
                }

                //*****************2.-AJUSTE DE CAJAS SOLIDAS
                array_push($dtTablasSolidoCurvado, $dtTabla[0]);//CABECERA
                //total solido
                $insert = [];$total = 0; $keytallas = 0;
                foreach ($tallas2 as $vart) {
                    array_push($insert, $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas]);
                    $total += $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas];
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //n°cajas
                $insert = [];$total = 0;$keytallas = 0;
                foreach ($tallas2 as $vart) {
                    $parametro95 = round($dtTablaCurvado[2][$keytallas] / $dtTablaCurvado[1][$keytallas] * 100, 3);
                    if ($parametro95 >= 95 and $dtTablasSolidoCurvado[1][$keytallas] < $mstpack) {
                        array_push($insert, 0);
                    } elseif ($parametro95 < 95 and $dtTablasSolidoCurvado[1][$keytallas] >= (0.3 * $mstpack)) {//Redondeo hacia arriba
                        array_push($insert, ceil($dtTablasSolidoCurvado[1][$keytallas] / $mstpack));
                        $total += ceil($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                    } else {
                        array_push($insert, floor($dtTablasSolidoCurvado[1][$keytallas] / $mstpack));
                        $total += floor($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                    }
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //total de solido ajustado
                $insert = [];$total = 0;$keytallas = 0;
                foreach ($tallas2 as $vart) {
                    array_push($insert, $dtTablasSolidoCurvado[2][$keytallas] * $mstpack);
                    $total += $dtTablasSolidoCurvado[2][$keytallas] * $mstpack;
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);
                foreach ($clusters as $Var2) {
                    $clusters3 = $clusters3 . $Var2 . "+";
                }

                //MSTPACK
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $mstpack);
                array_push($dtTablasSolidoCurvado, $insert);

                //*-----------------% unid ajustada x tallas TOTALES
                $key = 0; $unid_ajustasxtallas = "";$insert = [];$total= 0;
                foreach ($tallas2 as $var) {
                    $unid_ajustasxtallas = $unid_ajustasxtallas . strval($dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key]) . "-";
                    array_push($insert, $dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key]);
                    $total += $dtTablasSolidoCurvado[3][$key] + $dtTablaCurvado[2][$key];
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //Total numero cajas finales
                $insert = [];
                foreach ($tallas2 as $var) {array_push($insert, 0);}
                array_push($insert, $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS);
                array_push($dtTablasSolidoCurvado, $insert);

                //Total PORCENTAJE TOTAL AJUSTADO
                $insert = [];$key2= 0;
                foreach ($tallas2 as $vart) {
                    if ($dtTablaCurvado [2][$key2] <> 0) {
                        array_push($insert, round(($dtTablaCurvado[2][$key2] / $dtTablaCurvado [2][$N_Columna]) * 100, 3));
                    } else {
                        array_push($insert, 0);
                    }
                    $key2 += 1;
                }
                array_push($insert, 0);
                array_push($dtTablasSolidoCurvado, $insert);

                /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, strlen($porcentajeAjust) - 1);
                /*%*/$n_cajasfinales = $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS; //curvado + solido
                /*%*/$unid_final = $dtTablasSolidoCurvado[3][$N_Columna] + $dtTablaCurvado[2][$N_Columna]; //curvado + solido
                /*%*/$totalprimerRepato = $dtTablaCurvado[2][$N_Columna];
                /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/$clusters3 = substr($clusters3, 0, -1);
            }
            /*SOLIDO*/ else {
                /*******************AJUSTE MST-PACK SOLIDO*********************/
                /*%*/$porcentajeAjust = $dtTabla[5][$N_Columna];
                array_push($dtTablasolidoFULL, $dtTabla[0]);//CABECERA

                //--------------unid iniciales
                $insert = [];$por_ajust = explode("-", trim($porcentajeAjust));$total = 0;
                foreach ($por_ajust as $var) {
                    $total += round((($var * $unid_ajustas) / 100));
                    array_push($insert, round((($var * $unid_ajustas) / 100)));
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------Curva del Primer Reparto
                $insert = []; $curvas = explode(",", trim($curva_reparto));$total = 0;
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $dtplanCompra[0]['CLUSTER1'], $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $ntdas = 0;
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }
                        $primer += $var * $dtplanCompra[0]["CLUSTER" . $varc] * $ntdas["TIENDAS"];
                    }
                    $total += $primer;
                    array_push($insert, $primer);
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //mst pack
                $insert = [];
                foreach ($tallas2 as $var) {
                    array_push($insert, $mstpack);
                }
                array_push($insert, $mstpack);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------N° Cajas
                $key = 0;$insert = [];$total = 0;
                foreach ($tallas2 as $var) {
                    $val = 0;
                    $val = $dtTablasolidoFULL[1][$key] / $dtTablasolidoFULL[3][$key];
                    if (is_float($val) == true) {
                        $val = round($val, 0);
                        if (($val * $dtTablasolidoFULL[3][$key]) < $dtTablasolidoFULL[2][$key]) {
                            $val += 1;
                        }
                    }
                    $total += $val;
                    array_push($insert, $val);
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------UND FINAL
                $key = 0;$insert = [];$total = 0;
                foreach ($tallas2 as $var) {
                    $val = 0;
                    $val = $dtTablasolidoFULL[4][$key] * $dtTablasolidoFULL[3][$key];
                    $total += $val;
                    array_push($insert, $val);
                    $key += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------% pocentaje ajustada por mstpack
                $key = 0;$porcentajeAjust = "";$unid_final = $dtTablasolidoFULL[5][$N_Columna];
                foreach ($tallas2 as $var) {
                    $porcentajeAjust = $porcentajeAjust . round((($dtTablasolidoFULL[5][$key] / $unid_final) * 100), 3) . "-";
                    $key += 1;
                }

                //*-----------------% unid ajustada por mstpack
                $key = 0;
                foreach ($tallas2 as $var) {
                    $unid_ajustasxtallas = $unid_ajustasxtallas . strval(round($dtTablasolidoFULL[5][$key], 0)) . "-";
                    $key += 1;
                }
                foreach ($clusters as $Var2) {
                    $clusters3 = $clusters3 . $Var2 . "+";
                }

                /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, -1);
                /*%*/$n_cajasfinales = $dtTablasolidoFULL[4][$N_Columna];
                /*%*/$unid_final = $dtTablasolidoFULL[5][$N_Columna];
                /*%*/$totalprimerRepato = $dtTablasolidoFULL[2][$N_Columna];
                /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/$clusters3 = substr($clusters3, 0, -1);

            }
        }
        /*REORDER*/ELSE{
            $unid_ajust = $unid_ini;$porcentAjut = $por_Inicial;
            //*-----------------tallas columnas
            array_push($dtTablaReorder,$dtTabla[0]);
            //--------------unid iniciales
            $insert =[]; $por_ajust = explode("-",  trim($porcentAjut)); $total = 0;
            foreach ($por_ajust as $var ){
                $val = round(($var * $unid_ajust)/100,0);
                $total += $val;
                array_push($insert,$val);
            }
            array_push($insert,$total);
            array_push($dtTablaReorder, $insert);

            //-------------los  REORDER NO TIENE PRIMERA CARGA
            //*-----------------N° Cajas
            $key = 0; $insert =[]; $total = 0;
            foreach ($tallas2 as $var ){$val = 0;
                $val = $dtTablaReorder[1][$key] / $mstpack;
                if (is_float($val) == true){
                    $val =round($val ,0);
                }
                $total+= $val;
                array_push($insert,$val);
                $key += 1;
            }
            array_push($insert,$total);
            array_push($dtTablaReorder,$insert);

            //*-----------------UND FINAL
            $key = 0; $insert =[]; $total = 0;
            foreach ($tallas2 as $var ){$val = 0;
                $val = $dtTablaReorder[2][$key] * $mstpack;
                $total+= $val;
                array_push($insert,$val);
                $key += 1;
            }
            array_push($insert,$total);
            array_push($dtTablaReorder,$insert);

            //mstpack
            $insert =[];
            foreach ($tallas2 as $var ){array_push($insert,$mstpack);}
            array_push($insert,$mstpack);
            array_push($dtTablaReorder,$insert);

            //*-----------------% pocentaje ajustada por mstpack
            $key = 0; $porcentAjut = ""; $unid_final  = $dtTablaReorder[3][$N_Columna];
            foreach ($tallas2 as $var ){
                $porcentajeAjust = $porcentajeAjust.round((($dtTablaReorder[3][$key]/$unid_final)*100),3)."-";
                $key += 1;
            }
            //*-----------------% unid ajustada por tallas mstpack
            $key = 0;
            foreach ($tallas2 as $var ){
                $unid_ajustasxtallas = $unid_ajustasxtallas.strval(round($dtTablaReorder[3][$key]))."-";
                $key += 1;
            }

            /*%*/$porcentajeAjust = substr($porcentajeAjust, 0, -1);
            /*%*/$n_cajasfinales = $dtTablaReorder[2][$N_Columna];
            /*%*/$unid_final = $dtTablaReorder[3][$N_Columna];
            /*%*/$totalprimerRepato = 0;
            /*%*/$unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
            /*%*/$clusters3 = "";
            /*%*/$unid_ajustas = $unid_ini;

        }

        // AJUSTE DE COMPRA   = $dtTabla
        // AJUSTE CURVADO     = $dtTablaCurvado + $dtTablasSolidoCurvado
        // AJUSTE SOLIDO FULL = $dtTablasolidoFULL
        // AJUSTE REORDER     = $dtTablaReorder

        $array2 = array(
            /*unid_ajustada*/$unid_ajustas
            /*porcenajust=mstpack*/, $porcentajeAjust
            /*n°cajas*/, $n_cajasfinales
            /*unidfinal*/, $unid_final
            /*primera carga*/, $totalprimerRepato
            /*$tdas*/, round(($totalprimerRepato / $unid_final) * 100, 2)
            /*unidadesajustXtalla*/, $unid_ajustasxtallas
            /*clustes intersecion*/, $clusters3
        ,$dtTabla,$dtTablaCurvado,$dtTablasSolidoCurvado,$dtTablasolidoFULL,$dtTablaReorder);



        return $array2;

    }
    public static function list_Idcolor3x_Grupo($cod_tempo,$depto,$grupo_compra){

        $sql = "select id_color3
                from plc_plan_compra_color_3        
                WHERE  COD_TEMPORADA  = ".$cod_tempo."
                AND    DEP_DEPTO      = '".$depto."'
                AND    grupo_compra   = '".$grupo_compra."'
                order by 1 asc";
        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }
    public static function list_Idcolor3x_Grupo2($cod_tempo,$depto,$grupo_compra){
        $sql = "select ID_COLOR3
                from PLC_PLAN_COMPRA_COLOR_3        
                WHERE  COD_TEMPORADA  = ".$cod_tempo."
                AND    DEP_DEPTO      = '".$depto."'
                AND    GRUPO_COMPRA   = '".$grupo_compra."'
                AND    ESTADO = 0
                order by 1 asc";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }
    public static function list_grupocompraBD($cod_tempo,$depto){

        $sql = "select distinct grupo_compra
                from plc_plan_compra_color_3        
                WHERE  COD_TEMPORADA  = ".$cod_tempo."
                AND    DEP_DEPTO      = '".$depto."'";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function getcodCluster($cluster,$depto,$cod_tempo){

        $cod_cluster = 0;
        $sql = "SELECT COD_SEG COD_CLUSTER
                 FROM   PLC_SEGMENTOS
                 WHERE  COD_TEMPORADA = ".$cod_tempo."
                AND    DEP_DEPTO     = '".$depto."'
                AND    DES_SEG = '".strtoupper($cluster)."'";
        $data = \database::getInstancia()->getFila($sql);

        if (count($data)> 0){
            $cod_cluster = $data["COD_CLUSTER"];
        }
        return $cod_cluster;
    }
    public static function List_tda_Cluster($cod_tempo,$depto,$cod_marca,$codcluster){
        $sql = "SELECT COD_TDA 
                 FROM   PLC_SEGMENTOS_TDA 
                 WHERE  COD_TEMPORADA = ".$cod_tempo."
                 AND    DEP_DEPTO     = '".$depto."'
                 AND    COD_MARCA = ".$cod_marca."
                 AND    COD_SEG = '".$codcluster."'";


        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }
    public static function List_NOpcion_plan($cod_tempo,$depto,$grupo_compra){

        $sql = "SELECT DISTINCT NUM_EMB NUM_OPCION  
                FROM plc_plan_compra_color_3                
                WHERE cod_temporada = ".$cod_tempo."
                and dep_depto = '".$depto."'
                and grupo_compra = '".$grupo_compra."'";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function updateopcioneliminado($cod_tempo,$depto,$grupo_compra,$ids_color3,$USER_LOGIN){

        $error = TRUE;
        $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_3 
                SET ESTADO = 24                
                WHERE cod_temporada = ".$cod_tempo."
                and dep_depto = '".$depto."'
                and id_color3 in (".$ids_color3.")
                and grupo_compra = '".$grupo_compra."'";

        \database::getInstancia()->getConsulta($sql);


        $dt = explode(",", $ids_color3);


        foreach ($dt as $val){
            $error = plan_compra::InsertHistorial2($cod_tempo,$depto,$val,$USER_LOGIN);
        }

        return $error;
    }
    public static function InsertHistorial2($cod_tempo,$depto,$id_color3,$USER_LOGIN){

        $val = TRUE;
        $sql = "begin PLC_PKG_PRUEBA.PRC_INSERT_HISTORIAL" .
            /*V_TEMP*/         ("("  . $cod_tempo . "" .
                /*V_DPTO*/          ",'" . $depto . "'" .
                /*V_ID_COLOR3*/     ","  . $id_color3 . "" .
                /*V_USER_LOGIN*/    ",'" . $USER_LOGIN . "', :error, :data); end;");

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        $_error = explode("#", $data);
        if ($_error[0] == 1 ){
            $val = false;
        }

        return $val;

    }
    public static function existe_opcion_plan_compra($cod_temporada,$depto,$grupo_compra,$marca,$linea,$sublinea,$estilo,$ventana,$num_opcion,$color) {
        $sql = "SELECT COUNT(*) EXISTE 
                FROM PLC_PLAN_COMPRA_COLOR_3 A
                WHERE  A.COD_TEMPORADA  = ".$cod_temporada."
                AND    A.DEP_DEPTO      = '".$depto."'
                AND    A.GRUPO_COMPRA   = '".$grupo_compra."'
                AND    A.COD_MARCA      = ".$marca."
                AND    A.COD_JER2       = '".$linea."'
                AND    A.COD_SUBLIN     = '".$sublinea."'
                AND    A.DES_ESTILO     = '".$estilo."'
                AND    A.NOM_VENTANA    = '".$ventana."'
                AND    A.NUM_EMB        = '".$num_opcion."'
                AND    A.COD_COLOR      = ".$color;

        $data = \database::getInstancia()->getFilas($sql);
        return $data[0]['EXISTE'];
    }
    public static function countPlan_compra($cod_temporada,$depto,$grupo_compra,$marca){

        $sql = "SELECT COUNT(*) N FROM PLC_PLAN_COMPRA_COLOR_3 A 
                WHERE A.COD_TEMPORADA = ".$cod_temporada." 
                AND A.DEP_DEPTO = '".$depto."' 
                AND A.GRUPO_COMPRA = '".$grupo_compra."'
                AND A.COD_MARCA in (".$marca.") ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data[0]['N'];

    }

#endregion;

#region {*************Metodos Exportar*************}

    Public static Function ExportBMT($tempo,$depto,$grupo_compra){
        $array1 = [];
        $grupo_compra = explode(",", trim($grupo_compra));

        foreach ($grupo_compra as $val){

            $sql = "begin PLC_PKG_DESARROLLO.PRC_EXPORT_BMT5WEB(" . $tempo . ",'" . $depto . "','" . $val . "', :data); end;";
            $data = \database::getInstancia()->getConsultaSP($sql, 1);


            foreach ($data as $va1){
                array_push($array1
                    , array( "PURCHASE GROUP"=> $va1[0]
                    ,"CORPORATE BUYER NAME"=> $va1[1]
                    ,"DISIGNER NAME"=> $va1[2]
                    ,"PI SEASON"=> $va1[3]
                    ,"COD CORP"=> $va1[4]
                    ,"OPTION NUMBER"=> $va1[5]
                    ,"STYLE NAME"=> $va1[6]
                    ,"SHORT_NAME"=> $va1[7]
                    ,"PHOTOGRAF"=> $va1[8]
                    ,"COLOR CODE"=> $va1[9]
                    ,"COLOR NAME"=> $va1[10]
                    ,"COLECTION"=> $va1[11]
                    ,"COMPOSITION"=> $va1[12]
                    ,"LINING"=> $va1[13]
                    ,"TYPE OF FABRIC"=> $va1[14]
                    ,"DETAILS"=> $va1[15]
                    ,"DESCRIPCION INTERNET"=> $va1[16]
                    ,"BEFORE MEETING REMARKS"=> $va1[17]
                    ,"AFTER MEETING REMARKS"=> $va1[18]
                    ,"PRODUCT DESCRIPTION"=> $va1[19]
                    ,"STYLE GENDER"=> $va1[20]
                    ,"SEASON"=> $va1[21]
                    ,"TARGET VENDOR"=> $va1[22]
                    ,"VENDOR NICK NAME"=> $va1[23]
                    ,"VENDOR CODE"=> $va1[24]
                    ,"COUNTRY OF ORIGIN"=> $va1[25]
                    ,"HKO/NO HKO"=> $va1[26]
                    ,"TARGET COST"=> $va1[27]
                    ,"TARGET BUDGET"=> $va1[28]
                    ,"TOTAL QUANTITY"=> $va1[29]
                    ,"FINAL COST"=> $va1[30]
                    ,"FINAL BUDGET"=> $va1[31]
                    ,"LEAD TIME TYPE"=> $va1[32]
                    ,"LOCAL BUYER"=> $va1[33]
                    ,"LOCAL BRAND"=> $va1[34]
                    ,"DEPARTMENT"=> $va1[35]
                    ,"DEPARTMENT CODE"=> $va1[36]
                    ,"LINE (*)"=> $va1[37]
                    ,"SUBLINE"=> $va1[38]
                    ,"SUBLNE CODE"=> $va1[39]
                    ,"TYPE OF EXHIBITION"=> $va1[40]
                    ,"LIFE CICLE"=> $va1[41]
                    ,"PRODUCT SEASON"=> $va1[42]
                    ,"TYPE OF PRODUCT"=> $va1[43]
                    ,"PYRAMID MIX"=> $va1[44]
                    ,"CHANCE OF USER"=> $va1[45]
                    ,"RANKING OF SALE"=> $va1[46]
                    ,"LIFE STYLE"=> $va1[47]
                    ,"RETAIL PRICE"=> $va1[48]
                    ,"PRICE RANGE"=> $va1[49]
                    ,"2 X RETAIL PRICE"=> $va1[50]
                    ,"ANTES/AHORA"=> $va1[51]
                    ,"EVENTO"=> $va1[52]
                    ,"SHIPMENT MODE"=> $va1[53]
                    ,"VENTANA"=> $va1[54]
                    ,"mm/dd1"=> $va1[55]
                    ,"mm/dd2"=> $va1[56]
                    ,"mm/dd3"=> $va1[57]
                    ,"mm/dd4"=> $va1[58]
                    ,"mm/dd5"=> $va1[59]
                    ,"mm/dd6"=> $va1[60]
                    ,"mm/dd7"=> $va1[61]
                    ,"TOTAL QUANTITY CL"=> $va1[62]
                    ,"CLUSTER"=> $va1[63]
                    ,"SIZE"=> $va1[64]
                    ,"Size %1"=> $va1[65]
                    ,"Size %2"=> $va1[66]
                    ,"Size %3"=> $va1[67]
                    ,"Size %4"=> $va1[68]
                    ,"Size %5"=> $va1[69]
                    ,"Size %6"=> $va1[70]
                    ,"Size %7"=> $va1[71]
                    ,"Size %8"=> $va1[72]
                    ,"Size %9"=> $va1[73]
                    ,"Size %10"=>$va1[74]
                    ,"Size %11"=> $va1[75]
                    ,"Size %12"=> $va1[76]
                    ,"Size %13"=> $va1[77]
                    ,"Size %14"=> $va1[78]
                    ,"Size %15"=> $va1[79]
                    ,"Qty #1"=> $va1[80]
                    ,"Qty #2"=> $va1[81]
                    ,"Qty #3"=> $va1[82]
                    ,"Qty #4"=> $va1[83]
                    ,"Qty #5"=> $va1[84]
                    ,"Qty #6"=> $va1[85]
                    ,"Qty #7"=> $va1[86]
                    ,"Qty #8"=> $va1[87]
                    ,"Qty #9"=> $va1[88]
                    ,"Qty #10"=> $va1[89]
                    ,"Qty #11"=> $va1[90]
                    ,"Qty #12"=> $va1[91]
                    ,"Qty #13"=> $va1[92]
                    ,"Qty #14"=> $va1[93]
                    ,"Qty #15"=> $va1[94]
                    ,"PREPACK"=> $va1[95]
                    ,"HANDLING TYPE"=> $va1[96]
                    ,"HANDLING TYPE CD"=> $va1[97]
                    ,"SIZE STICKER"=> $va1[98]
                    ,"UNITS PER BOX"=> $va1[99]
                    ,"REORDER"=> $va1[100]
                    ,"COST LAST PURCHASE"=> $va1[101]
                    ,"VENDOR LAST PURCHASE"=> $va1[102]
                    ,"EXTENDED WARRANTY"=> $va1[103]
                    ,"RFID COST"=> $va1[104]
                    ,"INSPECTION COST"=> $va1[105]
                    ,"ROYALTY"=> $va1[106]
                    ,"SIZE SAMPLE"=> $va1[107]
                    ,"LOCAL BUYER P"=> $va1[108]
                    ,"LOCAL BRAND P"=> $va1[109]
                    ,"DEPARTMENT P"=> $va1[110]
                    ,"DEPARTMENT CODE P"=> $va1[111]
                    ,"LINE (*) P"=> $va1[112]
                    ,"SUBLINE P"=> $va1[113]
                    ,"SUBLNE CODE P"=> $va1[114]
                    ,"HIERARCHI P"=> $va1[115]
                    ,"LIFE CICLE P"=> $va1[116]
                    ,"PRODUCT SEASON P"=> $va1[117]
                    ,"PYRAMID MIX P"=> $va1[118]
                    ,"CHANCE OF USER P"=> $va1[119]
                    ,"RANKING OF SALE P"=> $va1[120]
                    ,"LIFE STYLE P"=> $va1[121]
                    ,"RETAIL PRICE P"=> $va1[122]
                    ,"PRICE RANGE P"=> $va1[123]
                    ,"2 X RETAIL PRICE P"=> $va1[124]
                    ,"ANTES/AHORA P"=> $va1[125]
                    ,"EVENTO P"=> $va1[126]
                    ,"SHIPMENT MODE P"=> $va1[127]
                    ,"VENTANA P"=> $va1[128]
                    ,"mm/dd1 P"=> $va1[129]
                    ,"mm/dd2 P"=> $va1[130]
                    ,"mm/dd3 P"=> $va1[131]
                    ,"mm/dd4 P"=> $va1[132]
                    ,"mm/dd5 P"=> $va1[133]
                    ,"mm/dd6 P"=> $va1[134]
                    ,"mm/dd7 P"=> $va1[135]
                    ,"TOTAL QUANTITY P"=> $va1[136]
                    ,"SIZE TYPE P"=> $va1[137]
                    ,"SIZE P"=> $va1[138]
                    ,"Size %1 P"=> $va1[139]
                    ,"Size %2 P"=> $va1[140]
                    ,"Size %3 P"=> $va1[141]
                    ,"Size %4 P"=> $va1[142]
                    ,"Size %5 P"=> $va1[143]
                    ,"Size %6 P"=> $va1[144]
                    ,"Size %7 P"=> $va1[145]
                    ,"Size %8 P"=> $va1[146]
                    ,"Size %9 P"=> $va1[147]
                    ,"Size %10 P"=> $va1[148]
                    ,"Size %11 P"=> $va1[149]
                    ,"Size %12 P"=> $va1[150]
                    ,"Size %13 P"=> $va1[151]
                    ,"Size %14 P"=> $va1[152]
                    ,"Size %15 P"=> $va1[153]
                    ,"Qty #1 P"=> $va1[154]
                    ,"Qty #2 P"=> $va1[155]
                    ,"Qty #3 P"=> $va1[156]
                    ,"Qty #4 P"=> $va1[157]
                    ,"Qty #5 P"=> $va1[158]
                    ,"Qty #6 P"=> $va1[159]
                    ,"Qty #7 P"=> $va1[160]
                    ,"Qty #8 P"=> $va1[161]
                    ,"Qty #9 P"=> $va1[162]
                    ,"Qty #10 P"=> $va1[163]
                    ,"Qty #11 P"=> $va1[164]
                    ,"Qty #12 P"=> $va1[165]
                    ,"Qty #13 P"=> $va1[166]
                    ,"Qty #14 P"=> $va1[167]
                    ,"Qty #15 P"=> $va1[168]
                    ,"PREPACK P"=> $va1[169]
                    ,"HANDLING TYPE P"=> $va1[170]
                    ,"SIZE STICKER P"=> $va1[171]
                    ,"UNITS PER BOX P"=> $va1[172]
                    ,"REORDER P"=> $va1[173]
                    ,"COST LAST PURCHASE P"=> $va1[174]
                    ,"VENDOR LAST PURCHASE P"=> $va1[175]
                    ,"EXTENDED WARRANTY P"=> $va1[176]
                    ,"INSPECTION NEEDED P"=> $va1[177]
                    ,"INSPECTION COST P"=> $va1[178]
                    ,"ROYALTY P"=> $va1[179]
                    ,"PERU DUMPING P"=> $va1[180]
                    ,"SIZE SAMPLE P"=> $va1[181]
                    )
                );
            }
        }

        return $array1;

    }

    Public static Function Exportc1($tempo,$depto){
       $array1 = [];
        $sql = "begin PLC_PKG_DESARROLLO.PRC_EXPORTAR_C1_CONSOLIDAD(" . $tempo . ",'" . $depto . ",', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        foreach ($data as $va1){
            array_push($array1,
                array("Temporada"=> utf8_encode($va1[0])
                ,"Cod Depto"=> utf8_encode($va1[1])
                ,"Nom Depto"=> utf8_encode($va1[2])
                ,"Grupo Compra"=> utf8_encode($va1[3])
                ,"Temp"=> utf8_encode($va1[4])
                ,"Linea"=> utf8_encode($va1[5])
                ,"Sublinea"=> utf8_encode($va1[6])
                ,"Marca"=> utf8_encode($va1[7])
                ,"Nom Estilo"=> utf8_encode($va1[8])
                ,"Nombre Corto"=> utf8_encode($va1[85])
                ,"Cod Corp"=> utf8_encode($va1[9])
                ,"Descripción"=> utf8_encode($va1[10])
                ,"Desc Internet"=> utf8_encode($va1[11])
                ,"Composición"=> utf8_encode($va1[12])
                ,"Colección"=> utf8_encode($va1[13])
                ,"Evento"=> utf8_encode($va1[14])
                ,"Estilo de Vida"=> utf8_encode($va1[15])
                ,"Calidad"=> utf8_encode($va1[16])
                ,"Ocasión de Uso"=> utf8_encode($va1[17])
                ,"Pirámide Mix"=> utf8_encode($va1[18])
                ,"Ventana"=> utf8_encode($va1[19])
                ,"Rank Vta"=> utf8_encode($va1[20])
                ,"Life Cycle"=> utf8_encode($va1[21])
                ,"Color"=> utf8_encode($va1[22])
                ,"Tipo Producto"=> utf8_encode($va1[23])
                ,"Tipo Exhibición"=> utf8_encode($va1[24])
                ,"Tallas"=> utf8_encode($va1[25])
                ,"Tipo Empaque"=> utf8_encode($va1[86])
                ,"% Compra Ini"=> utf8_encode($va1[26])
                ,"% Compra Ajustada"=> utf8_encode($va1[27])
                ,"Curvas de Reparto"=> utf8_encode($va1[28])
                ,"Curva Min"=> utf8_encode($va1[29])
                ,"Unid Ini"=> utf8_encode($va1[30])
                ,"Unid Ajust"=> utf8_encode($va1[31])
                ,"Unid Final"=> utf8_encode($va1[32])
                ,"Mtr Pack"=> utf8_encode($va1[33])
                ,"N° Cajas"=> utf8_encode($va1[34])
                ,"Clúster"=> utf8_encode($va1[35])
                ,"Formato"=> utf8_encode($va1[36])
                ,"Tdas"=> utf8_encode($va1[37])
                ,"A"=> utf8_encode($va1[38])
                ,"B"=> utf8_encode($va1[39])
                ,"C"=> utf8_encode($va1[40])
                ,"I"=> utf8_encode($va1[41])
                ,"Primera Carga"=> utf8_encode($va1[42])
                ,"%Tiendas"=> utf8_encode($va1[43])
                ,"Proced"=>utf8_encode( $va1[44])
                ,"Vía"=> utf8_encode($va1[45])
                ,"País"=> utf8_encode($va1[46])
                ,"Viaje"=> utf8_encode($va1[47])
                ,"Mkup Blanco"=> utf8_encode($va1[48])
                ,"Precio Blanco"=> utf8_encode($va1[49])
                ,"GM Blanco"=>utf8_encode($va1[50])
                ,"Moneda"=> utf8_encode($va1[51])
                ,"Target"=> utf8_encode($va1[52])
                ,"FOB"=> utf8_encode($va1[53])
                ,"Insp"=> utf8_encode($va1[54])
                ,"RFID"=> utf8_encode($va1[55])
                ,"Royalty(%)"=> utf8_encode($va1[56])
                ,"Costo Unitario Final US$"=> utf8_encode($va1[57])
                ,"Costo Unitario Final Pesos"=> utf8_encode($va1[58])
                ,"Total Target US$"=> utf8_encode($va1[59])
                ,"Total Fob US$"=> utf8_encode($va1[60])
                ,"Costo Total Pesos"=> utf8_encode($va1[61])
                ,"Total Retail Pesos(Sin IVA)"=> utf8_encode($va1[62])
                ,"Debut/Reorder"=> utf8_encode($va1[63])
                ,"Sem Ini"=> utf8_encode($va1[64])
                ,"Sem Fin"=> utf8_encode($va1[65])
                ,"Semanas Ciclo de Vida"=> utf8_encode($va1[66])
                ,"Agot Obj"=> utf8_encode($va1[67])
                ,"Semanas Liquidación"=> utf8_encode($va1[68])
                ,"Proveedor"=> utf8_encode($va1[69])
                ,"Razon Social"=> utf8_encode($va1[70])
                ,"Trader"=> utf8_encode($va1[71])
                ,"Cod Sku Proveedor"=> utf8_encode($va1[72])
                ,"Cod. Padre"=> utf8_encode($va1[73])
                ,"Proforma"=> utf8_encode($va1[74])
                ,"Archivo"=> utf8_encode($va1[75])
                ,"Estilo PMM"=> utf8_encode($va1[76])
                ,"Estado Match"=> utf8_encode($va1[77])
                ,"N° OC"=> utf8_encode($va1[78])
                ,"Estado OC"=> utf8_encode($va1[79])
                ,"Fecha Embarque"=> utf8_encode($va1[80])
                ,"Fecha ETA"=> utf8_encode($va1[81])
                ,"Fecha Recepción CD"=> utf8_encode($va1[82])
                ,"Días Atraso CD"=> utf8_encode($va1[83])
                ,"Estado Opción"=> utf8_encode($va1[84])
                )
            );
        }

        return $array1;
    }

    Public static Function Export_c1_presupuestos($tempo,$depto_cadena){

        $array1 = [];
        $sql = "begin PLC_PKG_MIGRACION.PRC_EXPORTAR_C1_PPTO(" . $tempo . ",'" . $depto_cadena . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        $depto_m = explode(',',$depto_cadena);

        $total_costo_ppto =0 ;
        $total_consumo_ppto =0 ;
        $total_saldo_ppto = 0 ;

        $total_costo_retail =0 ;
        $total_consumo_retail =0 ;
        $total_saldo_retail = 0 ;
        $total_costo_embarque =0 ;
        $total_consumo_embarque =0 ;
        $total_saldo_embarque = 0 ;

        $embarque_consumo = 0 ;
        $embarque_saldo = 0 ;

        foreach ($data as $va1) {
            $total_costo_ppto += $va1[2];
            $total_consumo_ppto += $va1[3];

            $total_saldo_ppto += $va1[4];

            $total_costo_retail += $va1[6];
            $total_consumo_retail += $va1[7];
            $total_saldo_retail += $va1[8];

            $total_costo_embarque += $va1[10];}

        foreach ($data as $va1) {
            if ($va1[2] == ''){
                $va1[2] = 0;
            }
            if ($va1[3] == '' ){
                $va1[3] = 0;
            }
            if ($va1[6] == '' ){
                $va1[6] = 0;
            }
            if ($va1[7] == '' ){
                $va1[7] = 0;
            }
            if ($va1[10] == '' ){
                $va1[10] = 0;
            }


            array_push($array1,
                array("DEP_DEPTO"=> $va1[0]
                ,"VENT_DESCRI"=> $va1[1]
                ,"COS_PPTO"=> $va1[2]
                ,"COS_CON"=> $va1[3]
                ,"COS_SAL"=> $va1[4]
                ,"COS_TOL"=> $va1[5]
                ,"RET_PPTO"=> $va1[6]
                ,"RET_CON"=> $va1[7]
                ,"RET_SAL"=> $va1[8]
                ,"RET_TOL"=> $va1[9]
                ,"EMB_PPTO"=> $va1[10]
                ,"EMB_CON"=> $embarque_consumo
                ,"EMB_SAL" => $embarque_saldo *100

                ,"TOL_COS_PPTO"=> $total_costo_ppto
                ,"TOL_CON_PPTO"=> $total_consumo_ppto
                ,"TOL_SAL_PPTO"=> $total_saldo_ppto

                ,"TOL_COS_RET"=> $total_costo_retail
                ,"TOL_CON_RET"=> $total_consumo_retail
                ,"TOL_SAL_RET"=> $total_saldo_retail

                ,"TOL_COS_EMB"=> $total_costo_embarque *100
                ,"TOL_CON_EMB"=> $total_consumo_embarque *100
                ,"TOL_SAL_EMB"=> $total_saldo_embarque *100
                )
            );
        }
        return $array1;
    }

    Public static Function Export_asorment($tempo,$depto){
        $array1 = [];
        $sql = "select * 
                  from plc_historial_assortment 
                  WHERE COD_TEMPORADA = ".$tempo."
                  and dep_depto IN (".$depto.")
                  ORDER BY DEP_DEPTO,CODIGO_MARCA asc";

        $data = \database::getInstancia()->getFilas($sql);

        foreach ($data as $va1){
            array_push($array1,
                array("DEP_DEPTO"=> $va1[1]
                ,"DPTO"=> $va1[2]
                ,"MARCA"=> $va1[3]
                ,"CODIGO_MARCA"=> $va1[4]
                ,"SEASON"=> $va1[5]
                ,"LINEA"=> $va1[6]
                ,"COD_LINEA"=> $va1[7]
                ,"SUBLINEA"=> $va1[8]
                ,"COD_SUBLINEA"=> $va1[9]
                ,"CODIGO_CORPORATIVO"=> $va1[10]
                ,"NOMBRE_ESTILO"=> $va1[11]
                ,"ESTILO_CORTO"=> $va1[12]
                ,"DESCRIPCION_ESTILO"=> $va1[13]
                ,"COLOR"=> $va1[14]
                ,"COD_COLOR"=> $va1[15]
                ,"EVENTO"=> $va1[16]
                ,"GRUPO_DE_COMPRA"=> $va1[17]
                ,"VENTANA_DEBUT"=> $va1[18]
                ,"TIPO_EXHIBICION"=> $va1[19]
                ,"TIPO_PRODUCTO"=> $va1[20]
                ,"DEBUT_O_REORDER"=> $va1[21]
                ,"TEMPORADA"=> $va1[22]
                ,"PRECIO"=> $va1[23]
                ,"RANKING_DE_VENTA"=> $va1[24]
                ,"CICLO_DE_VIDA"=> $va1[25]
                ,"PIRAMIDE_MIX"=> $va1[26]
                ,"RATIO_COMPRA"=> $va1[27]
                ,"FACTOR_AMPLIFICACION"=> $va1[28]
                ,"RATIO_COMPRA_FINAL"=> $va1[29]
                ,"CLUSTER_"=> $va1[30]
                ,"FORMATO"=> $va1[31]
                ,"COMPRA_UNIDADES_ASSORTMENT"=> $va1[32]
                ,"COMPRA_UNIDADES_FINAL"=> $va1[33]
                ,"VAR_PORCE"=> $va1[34]
                ,"TARGET_USD"=> $va1[35]
                ,"RFID_USD"=> $va1[36]
                ,"VIA"=> $va1[37]
                ,"PAIS"=> $va1[38]
                ,"FACTOR"=> $va1[39]
                ,"COSTO_TOTAL"=> $va1[40]
                ,"RETAIL_TOTAL_SIN_IVA"=> $va1[41]
                ,"MUP_COMPRA"=> $va1[42]
                ,"EXHIBICION"=> $va1[43]
                ,"TALLA1"=> $va1[44]
                ,"TALLA2"=> $va1[45]
                ,"TALLA3"=> $va1[46]
                ,"TALLA4"=> $va1[47]
                ,"TALLA5"=> $va1[48]
                ,"TALLA6"=> $va1[49]
                ,"TALLA7"=> $va1[50]
                ,"TALLA8"=> $va1[51]
                ,"TALLA9"=> $va1[52]
                ,"INNER"=> $va1[53]
                ,"CURVA1"=> $va1[54]
                ,"CURVA2"=> $va1[55]
                ,"CURVA3"=> $va1[56]
                ,"CURVA4"=> $va1[57]
                ,"CURVA5"=> $va1[58]
                ,"CURVA6"=> $va1[59]
                ,"CURVA7"=> $va1[60]
                ,"CURVA8"=> $va1[61]
                ,"CURVA9"=> $va1[62]
                ,"VALIDADOR_MASTERPACK_INNER"=> $va1[63]
                ,"TIPO_DE_EMPAQUE"=> $va1[64]
                ,"N_CURVAS_POR_CAJA_CURVADAS"=> $va1[65]
                ,"UNO_POR"=> $va1[66]
                ,"DOS_POR"=> $va1[67]
                ,"TRES_POR"=> $va1[68]
                ,"CUATRO_POR"=> $va1[69]
                ,"CINCO_POR"=> $va1[70]
                ,"SEIS_POR"=> $va1[71]
                ,"SIETE_POR"=> $va1[72]
                ,"OCHO_POR"=> $va1[73]
                ,"NUEVE_POR"=> $va1[74]
                ,"TIENDASA"=> $va1[75]
                ,"TIENDASB"=> $va1[76]
                ,"TIENDASC"=> $va1[77]
                ,"TIENDASI"=> $va1[78]
                ,"CLUSTERA"=> $va1[79]
                ,"CLUSTERB"=> $va1[80]
                ,"CLUSTERC"=> $va1[81]
                ,"CLUSTERI"=> $va1[82]
                ,"SIZE_1"=> $va1[83]
                ,"SIZE_2"=> $va1[84]
                ,"SIZE_3"=> $va1[85]
                ,"SIZE_4"=> $va1[86]
                ,"SIZE_5"=> $va1[87]
                ,"SIZE_6"=> $va1[88]
                ,"SIZE_7"=> $va1[89]
                ,"SIZE_8"=> $va1[90]
                ,"SIZE_9"=> $va1[91]
                ,"VENTA"=> $va1[92]
                ,"VENTB"=> $va1[93]
                ,"VENTC"=> $va1[94]
                ,"VENTD"=> $va1[95]
                ,"VENTE"=> $va1[96]
                ,"VENTF"=> $va1[97]
                ,"VENTG"=> $va1[98]
                ,"VENTH"=> $va1[99]
                ,"VENTI"=> $va1[100]
                ,"COD_OPCION"=> $va1[101]
                )
            );
        }
        return $array1;
    }

    Public static Function Exportcomex_c1_comex($tempo,$depto_cadena,$estado)
    {
        $array1 = [];
        $sql = "begin PLC_PKG_DESARROLLO.PRC_EXPORTAR_C1_COMEX(" . $tempo . ",'" . $depto_cadena . "','".$estado.",', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);


        foreach ($data as $va1){
            array_push($array1,
                array("DEPARTAMENTO"=> $va1[0]
                ,"COD DEPTO"=> $va1[1]
                ,"LINEA"=> $va1[2]
                ,"SUBLINEA"=> $va1[3]
                ,"MARCA"=> $va1[4]
                ,"ESTILO"=> $va1[5]
                ,"VENTANA"=> $va1[6]
                ,"COLOR"=> $va1[7]
                ,"PROFORMA"=> $va1[8]
                ,"ORDEN COMPRA"=> $va1[9]
                ,"ESTADO OPCION"=> $va1[10]
                ,"FECHA ULTIMO ESTADO"=> $va1[11]
                ,"HORA"=> $va1[12]

                )
            );
        }
        return $array1;
    }

    Public static Function Exportcomex_c1_comex_migracion($tempo,$depto_cadena,$estado)
    {
        $array1 = [];
        $sql = "begin PLC_PKG_MIGRACION.PRC_EXPORTAR_C1_COMEX(" . $tempo . ",'" . $depto_cadena . "','".$estado.",', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        foreach ($data as $va1){
            array_push($array1,
                array("TEMPORADA"=> $va1[0]
                ,"DEPARTAMENTO"=> $va1[1]
                ,"COD DEP"=> $va1[2]
                ,"ESTADO OPCION"=> $va1[3]
                ,"PI"=> $va1[4]
                ,"FECHA ÚLTIMO ESTADO"=> $va1[5]
                ,"HORA"=> $va1[6]
                ,"COMPRADOR"=> $va1[7]
                )
            );
        }
        return $array1;
    }

    Public static Function Exportcomex_c1_comex_sin_match($tempo,$depto_cadena,$estado)
    {
        $array1 = [];
        $sql = "begin PLC_PKG_MIGRACION.PRC_EXPORTAR_C1_SIN_MATCH(" . $tempo . ",'" . $depto_cadena . "','".$estado.",', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        foreach ($data as $va1){
            array_push($array1,
                array("DEPARTAMENTO"=> $va1[0]
                ,"DEP_DEPTO"=> $va1[1]
                ,"ESTADO OPCION"=> $va1[2]
                ,"FECHA ÚLTIMO ESTADO"=> $va1[3]
                ,"PI"=> $va1[4]
                ,"UNIDADES"=> $va1[5]
                ,"COSTOS"=> $va1[6]
                )
            );
        }
        return $array1;
    }

    Public static Function Exportcomex_c1_comex_error($tempo,$depto_cadena,$estado)
    {
        $array1 = [];
        $sql = "begin PLC_PKG_MIGRACION.PRC_EXPORTAR_COMEXERROR(" . $tempo . ",'" . $depto_cadena . "','".$estado.",', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        foreach ($data as $va1){
            array_push($array1,
                array("TEMPORADA"=> $va1[0]
                ,"DEPARTAMENTO"=> $va1[1]
                ,"COD DEP"=> $va1[2]
                ,"ESTADO OPCION"=> $va1[3]
                ,"PI"=> $va1[4]
                ,"FECHA ÚLTIMO ESTADO"=> $va1[5]
                ,"HORA"=> $va1[6]
                ,"COMPRADOR"=> $va1[7]
                ,"OBSERVACION"=> $va1[8]
                )
            );
        }
        return $array1;
    }

#endregion
}