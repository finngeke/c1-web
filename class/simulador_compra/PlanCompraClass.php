<?php

/**
 * CLASS PLAN DE COMPRA
 * Fecha: 22-11-2018
 * @author ROBERTO PéREZ
 */

namespace simulador_compra;

class PlanCompraClass extends \parametros
{

    // Lista el Plan de Compra, según temporada seleccionada
    public static function ListarPlanCompra($temporada, $depto)
    {

        $sql = "SELECT
                C.ID_COLOR3,                  -- 0 id
                C.GRUPO_COMPRA,               -- 1 grupo compra
                NVL(TEMP,1) COD_TEMP,         -- 2 temp
                C.NOM_LINEA LINEA,            -- 3 linea
                C.NOM_SUBLINEA SUBLINEA,      -- 4 sublinea
                C.NOM_MARCA MARCA,            -- 5 marca
                C.DES_ESTILO ESTILO,          -- 6 estilo
                C.SHORT_NAME,                 -- 7 estilo corto
                C.ID_CORPORATIVO,             -- 8 cod. corp
                C.DESCMODELO,                 -- 9 descripción
                C.DESCRIP_INTERNET,           -- 10 Descripción Internet
                ''NOMBRE_COMPRADOR,           -- 11
                ''NOMBRE_DISENADOR,           -- 12 
                C.COMPOSICION,                -- 13 Composicion
                ''TIPO_TELA,                  -- 14
                ''FORRO,                      -- 15
                C.COLECCION,                  -- 16 Colección
                C.EVENTO,                     -- 17 Evento
                NOM_ESTILOVIDA COD_ESTILO_VIDA,  -- 18 estilo vida
                '' CALIDAD,                      -- 19 Calidad
                C.NOM_OCACIONUSO COD_OCASION_USO,-- 20 ocacion uso
                C.NOM_PIRAMIDEMIX COD_PIRAMIX,   -- 21 piramide mix
                C.NOM_VENTANA,       -- 22 ventana
                C.NOM_RNK COD_RANKVTA,           -- 23 rank vta
                C.NOM_LIFECYCLE LIFE_CYCLE,      -- 24 ciclo vida
                C.NUM_EMB,                       -- 25 num_emb
                C.NOM_COLOR COD_COLOR,           -- 26 color
                C.TIPO_PRODUCTO,                 -- 27 Tipo Producto
                C.TIPO_EXHIBICION,               -- 28 Tipo Exhibicion
                C.DESTALLA,                      -- 29 Tallas
                C.TIPO_EMPAQUE,                  -- 30 Tipo empaque
                C.PORTALLA_1_INI,                -- 31 Compra Ini
                C.PORTALLA_1,                    -- 32 Compra Ajustada
                C.CURVATALLA,                    -- 33 Curva
                C.CURVAMIN,                      -- 34 Curva Min
                C.UNID_OPCION_INICIO,            -- 35 Uni Ini
                C.UNID_OPCION_AJUSTADA,          -- 36 Uni Ajust
                C.UNIDADES CAN,                  -- 37 Uni Final
                C.MTR_PACK,                      -- 38 Master Pack
                C.CANT_INNER,                    -- 39 Nº Cajas
                C.SEG_ASIG,                      -- 34 Cluster
                C.FORMATO,                       -- 41 Formato
                C.TDAS,                          -- 42 Tdas
                C.A ,                            -- 43 A
                C.B,                             -- 44 B
                C.C,                             -- 45 C
                C.I,                             -- 46 I
                C.UND_ASIG_INI,                  -- 47 Primera Carga
                C.ROT,                           -- 48 %Tiendas
                NOM_PRECEDENCIA,                 -- 49 Proced
                NOM_VIA,                         -- 50 Vìa
                NOM_PAIS,                        -- 51 Paìs
                C.VIAJE,                         -- 52 Viaje
                C.MKUP,                          -- 53 mkup
                C.PRECIO_BLANCO,                 -- 54 Precio Blanco
                '' OFERTA,                       -- 55 Oferta 
                C.GM,                            -- 56 GM
                C.NOM_MONEDA  COD_TIP_MON,       -- 57 Moneda
                C.COSTO_TARGET,                  -- 58 Target
                C.COSTO_FOB,                     -- 59 FOB
                C.COSTO_INSP,                    -- 60 Insp
                C.COSTO_RFID,                    -- 61 RFID
                C.ROYALTY_POR,                   -- 62 Royalty
                C.COSTO_UNIT,                    -- 63 Costo Unitario Final
                C.COSTO_UNITS,                   -- 64 Costo Unitario Final Pesos
                C.CST_TOTLTARGET,                -- 65 Total Target
                C.COSTO_TOT,                     -- 66 Total FOB
                C.COSTO_TOTS,                    -- 67 Costo total pesos
                C.RETAIL,                        -- 68 Total retail pesos
                C.DEBUT_REODER,                  -- 69 Debut/reorder
                C.SEM_INI,                       -- 70 Sem ini
                C.SEM_FIN,                       -- 71 Sem fin
                C.CICLO,                         -- 72 Semanas ciclo via
                C.AGOT_OBJ,                      -- 73 Agot Obj
                C.SEMLIQ,                        -- 74 Semanas Liquidacion
                C.ALIAS_PROV,                    -- 75 Proveedor
                C.COD_PROVEEDOR,                 -- 76 Razon Social
                C.COD_TRADER,                    -- 77 Trader
                ''AFTER_MEETING_REMARKS,         -- 78
                C.CODSKUPROVEEDOR,               -- 79 Cod SKU Proveedor
                O.COD_PADRE SKU,                 -- 80 Cod Padre
                C.PROFORMA,                      -- 81 Proforma
                O.ARCHIVO,                       -- 82 Archivo
                O.ESTILO_PMM,                    -- 83 Estilo Pmm
                O.ESTADO_MATCH,                  -- 84 Estado Match
                O.PO_NUMBER,                     -- 85 N OC
                O.ESTADO_OC,                     -- 86 Estado OC
                '' FECHA_ACORDADA,               -- 87
                O.FECHA_EMBARQUE,                -- 88 Fecha Embarque
                O.FECHA_ETA,                     -- 89 Fecha ETA
                O.FECHA_RECEPCION,               -- 90 Fecha Recepciòn
                O.DIAS_ATRASO,                   -- 91 Dias Atraso
                convert((SELECT nom_est_c1 FROM plc_estado_c1 WHERE cod_est_c1= C.ESTADO),'utf8','us7ascii')CODESTADO,  -- 92 Estado Opcion
                C.ESTADO ESTADO_C1,              -- 93 Estado C1
                C.VENTANA_LLEGADA,               -- 94 Ventana Llegada
                -- REPLACE((SELECT DISTINCT FECHA_RECEPCD FROM plc_ventana_emb V WHERE V.cod_temporada = C.COD_TEMPORADA AND V.cod_ventana = C.VENT_EMB),'/','-') FECHA_RECEPCD_C1 -- 95 Fecha recepcion CD
                C.PROFORMA PROFORMA_BASE,         -- 95 Proforma Base
                C.TIPO_EMPAQUE TIPO_EMPAQUE_BASE, -- 96 Tipo empaque Base
                C.UNID_OPCION_INICIO UNI_INICIALES_BASE,  -- 97 Unidades Iniciales Base
                C.PRECIO_BLANCO PRECIO_BLANCO_BASE,       -- 98 Precio Blanco Base 
                C.COSTO_TARGET COSTO_TARGET_BASE,         -- 99 Target Base
                C.COSTO_FOB COSTO_FOB_BASE,               -- 100 FOB Base
                C.COSTO_INSP COSTO_INSP_BASE,             -- 101 Insp Base
                C.COSTO_RFID COSTO_RFID_BASE,             -- 102 RFID Base
                
                C.COD_MARCA,                              -- 103 COD_MARCA  
                C.N_CURVASXCAJAS,                         -- 104 N_CURVASXCAJAS
                C.COD_JER2,                               -- 105 cod_linea
                C.COD_SUBLIN                              -- 106 cod_sublin
                
                FROM PLC_PLAN_COMPRA_COLOR_3 C
                LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
				AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO = '" . $depto . "'
                ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER";

        $data = \database::getInstancia()->getFilas($sql);
        /*return $data;*/

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "ID_COLOR3" => $va1[0]
                , "GRUPO_COMPRA" => $va1[1]
                , "COD_TEMP" => $va1[2]
                , "LINEA" => $va1[3]
                , "SUBLINEA" => $va1[4]
                , "MARCA" => $va1[5]
                , "ESTILO" => $va1[6]
                , "SHORT_NAME" => $va1[7]
                , "ID_CORPORATIVO" => $va1[8]
                , "DESCMODELO" => $va1[9]
                , "DESCRIP_INTERNET" => $va1[10]
                , "NOMBRE_COMPRADOR" => $va1[11]
                , "NOMBRE_DISENADOR" => $va1[12]
                , "COMPOSICION" => $va1[13]
                , "TIPO_TELA" => $va1[14]
                , "FORRO" => $va1[15]
                , "COLECCION" => $va1[16]
                , "EVENTO" => $va1[17]
                , "COD_ESTILO_VIDA" => $va1[18]
                , "CALIDAD" => $va1[19]
                , "COD_OCASION_USO" => $va1[20]
                , "COD_PIRAMIX" => $va1[21]
                , "NOM_VENTANA" => $va1[22] //ventana
                , "COD_RANKVTA" => $va1[23]
                , "LIFE_CYCLE" => $va1[24]
                , "NUM_EMB" => $va1[25]
                , "COD_COLOR" => $va1[26]
                , "TIPO_PRODUCTO" => $va1[27]
                , "TIPO_EXHIBICION" => $va1[28]
                , "DESTALLA" => $va1[29]
                , "TIPO_EMPAQUE" => $va1[30]
                , "PORTALLA_1_INI" => $va1[31]
                , "PORTALLA_1" => $va1[32]
                , "CURVATALLA" => $va1[33]
                , "CURVAMIN" => $va1[34]
                , "UNID_OPCION_INICIO" => $va1[35]
                , "UNID_OPCION_AJUSTADA" => $va1[36]
                , "CAN" => $va1[37]
                , "MTR_PACK" => $va1[38]
                , "CANT_INNER" => $va1[39]
                , "SEG_ASIG" => $va1[40]
                , "FORMATO" => $va1[41]
                , "TDAS" => $va1[42]
                , "A" => $va1[43]
                , "B" => $va1[44]
                , "C" => $va1[45]
                , "I" => $va1[46]
                , "UND_ASIG_INI" => $va1[47]
                , "ROT" => $va1[48]
                , "NOM_PRECEDENCIA" => $va1[49]
                , "NOM_VIA" => $va1[50]
                , "NOM_PAIS" => $va1[51]
                , "VIAJE" => $va1[52]
                , "MKUP" => $va1[53]
                , "PRECIO_BLANCO" => $va1[54]
                , "OFERTA" => $va1[55]
                , "GM" => $va1[56]
                , "COD_TIP_MON" => $va1[57]
                , "COSTO_TARGET" => $va1[58]
                , "COSTO_FOB" => $va1[59]
                , "COSTO_INSP" => $va1[60]
                , "COSTO_RFID" => $va1[61]
                , "ROYALTY_POR" => $va1[62]
                , "COSTO_UNIT" => $va1[63]
                , "COSTO_UNITS" => $va1[64]
                , "CST_TOTLTARGET" => $va1[65]
                , "COSTO_TOT" => $va1[66]
                , "COSTO_TOTS" => $va1[67]
                , "RETAIL" => $va1[68]
                , "DEBUT_REODER" => $va1[69]
                , "SEM_INI" => $va1[70]
                , "SEM_FIN" => $va1[71]
                , "CICLO" => $va1[72]
                , "AGOT_OBJ" => $va1[73]
                , "SEMLIQ" => $va1[74]
                , "ALIAS_PROV" => $va1[75]
                , "COD_PROVEEDOR" => $va1[76]
                , "COD_TRADER" => $va1[77]
                , "AFTER_MEETING_REMARKS" => $va1[78]
                , "CODSKUPROVEEDOR" => $va1[79]
                , "SKU" => $va1[80]
                , "PROFORMA" => $va1[81]
                , "ARCHIVO" => $va1[82]
                , "ESTILO_PMM" => $va1[83]
                , "ESTADO_MATCH" => $va1[84]
                , "PO_NUMBER" => $va1[85]
                , "ESTADO_OC" => $va1[86]
                , "FECHA_ACORDADA" => $va1[87]
                , "FECHA_EMBARQUE" => $va1[88]
                , "FECHA_ETA" => $va1[89]
                , "FECHA_RECEPCION" => $va1[90]
                , "DIAS_ATRASO" => $va1[91]
                , "CODESTADO" => $va1[92]
                , "ESTADO_C1" => $va1[93]
                , "VENTANA_LLEGADA" => $va1[94]
                , "PROFORMA_BASE" => $va1[95]
                , "TIPO_EMPAQUE_BASE" => $va1[96]
                , "UNI_INICIALES_BASE" => $va1[97]
                , "PRECIO_BLANCO_BASE" => $va1[98]
                , "COSTO_TARGET_BASE" => $va1[99]
                , "COSTO_FOB_BASE" => $va1[100]
                , "COSTO_INSP_BASE" => $va1[101]
                , "COSTO_RFID_BASE" => $va1[102]

                , "COD_MARCA" => $va1[103]
                , "N_CURVASXCAJAS" => $va1[104]
                , "COD_JER2" => $va1[105] //cod_linea
                , "COD_SUBLIN" => $va1[106]


                )
            );
        }


        return $array1;


    }


    // Actualiza Plan de Compra
    public static function ProcesaDataPlanCompra($TEMPORADA, $DEPTO, $LOGIN, $ID_COLOR3, $GRUPO_COMPRA, $COD_TEMP, $LINEA, $SUBLINEA, $MARCA, $ESTILO, $SHORT_NAME, $ID_CORPORATIVO, $DESCMODELO, $DESCRIP_INTERNET, $NOMBRE_COMPRADOR, $NOMBRE_DISENADOR, $COMPOSICION, $TIPO_TELA, $FORRO, $COLECCION, $EVENTO, $COD_ESTILO_VIDA, $CALIDAD, $COD_OCASION_USO, $COD_PIRAMIX, $NOM_VENTANA, $COD_RANKVTA, $LIFE_CYCLE, $NUM_EMB, $COD_COLOR, $TIPO_PRODUCTO, $TIPO_EXHIBICION, $DESTALLA, $TIPO_EMPAQUE, $PORTALLA_1_INI, $PORTALLA_1, $CURVATALLA, $CURVAMIN, $UNID_OPCION_INICIO, $UNID_OPCION_AJUSTADA, $CAN, $MTR_PACK, $CANT_INNER, $SEG_ASIG, $FORMATO, $TDAS, $A, $B, $C, $I, $UND_ASIG_INI, $ROT, $NOM_PRECEDENCIA, $NOM_VIA, $NOM_PAIS, $VIAJE, $MKUP, $PRECIO_BLANCO, $OFERTA, $GM, $COD_TIP_MON, $COSTO_TARGET, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $ROYALTY_POR, $COSTO_UNIT, $COSTO_UNITS, $CST_TOTLTARGET, $COSTO_TOT, $COSTO_TOTS, $RETAIL, $DEBUT_REODER, $SEM_INI, $SEM_FIN, $CICLO, $AGOT_OBJ, $SEMLIQ, $ALIAS_PROV, $COD_PROVEEDOR, $COD_TRADER, $AFTER_MEETING_REMARKS, $CODSKUPROVEEDOR, $SKU, $PROFORMA, $ARCHIVO, $ESTILO_PMM, $ESTADO_MATCH, $PO_NUMBER, $ESTADO_OC, $FECHA_ACORDADA, $FECHA_EMBARQUE, $FECHA_ETA, $FECHA_RECEPCION, $DIAS_ATRASO, $CODESTADO, $ESTADO_C1, $VENTANA_LLEGADA, $PROFORMA_BASE, $TIPO_EMPAQUE_BASE, $UNI_INICIALES_BASE, $PRECIO_BLANCO_BASE, $COSTO_TARGET_BASE, $COSTO_FOB_BASE, $COSTO_INSP_BASE, $COSTO_RFID_BASE, $COD_MARCA, $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN)
    {

        $COSTO_TARGET = str_replace(",", ".", $COSTO_TARGET);
        if (empty($COSTO_TARGET) || (!is_numeric($COSTO_TARGET)) || ($COSTO_TARGET == null ) || ($COSTO_TARGET == '' ) ) {
            $COSTO_TARGET = 0;
        }
        // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
        if (substr($COSTO_TARGET, 0, 1) == ".") {
            $COSTO_TARGET = "0" . $COSTO_TARGET;
        }

        $COSTO_FOB = str_replace(",", ".", $COSTO_FOB);
        if (empty($COSTO_FOB) || (!is_numeric($COSTO_FOB)) || ($COSTO_FOB == null ) || ($COSTO_FOB == '' ) ) {
            $COSTO_FOB = 0;
        }
        // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
        if (substr($COSTO_FOB, 0, 1) == ".") {
            $COSTO_FOB = "0" . $COSTO_FOB;
        }


        $COSTO_INSP = str_replace(",", ".", $COSTO_INSP);
        if (empty($COSTO_INSP) || (!is_numeric($COSTO_INSP)) || ($COSTO_INSP == null ) || ($COSTO_INSP == '' ) ) {
            $COSTO_INSP = 0;
        }
        // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
        if (substr($COSTO_INSP, 0, 1) == ".") {
            $COSTO_INSP = "0" . $COSTO_INSP;
        }


        $COSTO_RFID = str_replace(",", ".", $COSTO_RFID);
        if (empty($COSTO_RFID) || (!is_numeric($COSTO_RFID)) || ($COSTO_RFID == null ) || ($COSTO_RFID == '' ) ) {
            $COSTO_RFID = 0;
        }
        // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
        if (substr($COSTO_RFID, 0, 1) == ".") {
            $COSTO_RFID = "0" . $COSTO_RFID;
        }


        $factor = 0;
        $tipocambio = 0;
        $factor_est_campo = 0;
        //Curvado
        $und_ajust = 0;
        $porcent_ajust = "";
        $n_cajas = 0;
        $primera_carga = 0;
        $tiendas = "";
        $unida_ajust_xtallas = "";


        //validaciones
        /*if ( !isset($TIPO_EMPAQUE) || !isset($PORTALLA_1_INI) || !isset($DESTALLA) || !isset($CURVATALLA) || ($UNID_OPCION_INICIO<=0) || ($SEG_ASIG==null) || ($SEG_ASIG=='') ){
            return " No pueden estar en blanco los Campos: Tipo Empaque, Porcent Ini,Tallas,Curvas,Und Iniciales.";
            //return " TIPO_EMPAQUE:".$TIPO_EMPAQUE." PORTALLA_1_INI: ".$PORTALLA_1_INI." DESTALLA: ".$DESTALLA." CURVATALLA: ".$CURVATALLA." UND_ASIG_INI: ".$UND_ASIG_INI." SEG_ASIG: ".$SEG_ASIG;
            die();
        }


        // Hay que ir a buscar el Curvado
        $query_curva = PlanCompraClass::CalculoCurvadoPlanCompra($TIPO_EMPAQUE,$DESTALLA,$CURVATALLA,$UNID_OPCION_INICIO,$SEG_ASIG,$FORMATO,$A,$B,$C,$I,$DEBUT_REODER,$PORTALLA_1_INI,$DEPTO,$TEMPORADA,$COD_MARCA,$N_CURVASXCAJAS,$COD_JER2,$COD_SUBLIN,$ID_COLOR3,1);

        // Valido que se pueda realizar la QUERY
        if(!$query_curva){
            return " No se pudo realizar la query del curvado.";
            die();
        }

        $CURVA_UNID_AJUST       = $query_curva[0]; //  unid ajust
        $CURVA_POR_AJUSTE       = $query_curva[1]; //  porcenajust
        $CURVA_N_CAJAS          = $query_curva[2]; //  N° CAJAS
        $CURVA_UNID_FINAL       = $query_curva[3]; //  unidfinal
        $CURVA_PRIMERA_CARGA    = $query_curva[4]; //  primera carga
        $CURVA_TDAS             = $query_curva[5]; //  tiendas
        $CURVA_UNIDAJUSTXTALLA  = $query_curva[6]; //  unidadesajustXtalla

        // Valido que lleguen todos los datos de la QUERY
        if( empty($CURVA_UNID_AJUST) || empty($CURVA_POR_AJUSTE) || empty($CURVA_N_CAJAS) || empty($CURVA_UNID_FINAL) || empty($CURVA_PRIMERA_CARGA) || empty($CURVA_TDAS) || empty($CURVA_UNIDAJUSTXTALLA) ){
            return " No se pudo obtener los datos del curvado, revise la data ingresada.";
            die();
        }*/

        // Transforma a Número el "Nombre de la Vía"
        $NOM_VIA_NUMERO=0;
        if ($NOM_VIA == "MARITIMO") {
            $NOM_VIA_NUMERO = 1;
        } elseif ($NOM_VIA == "AEREA") {
            $NOM_VIA_NUMERO = 2;
        } elseif ($NOM_VIA == "TERRESTRE") {
            $NOM_VIA_NUMERO = 3;
        }

        // Traer Número País
        $query_numero_pais = PlanCompraClass::BuscaNumeroPais($NOM_PAIS);
        $NOM_PAIS_NUMERO = $query_numero_pais[0];
        if (empty($NOM_PAIS_NUMERO)) {
            return " No pudimos encontrar el nombre de país ingresado, verifique que el texto ingresado existe.";
            die();
        }

        // Traer factor
        $query_factor = PlanCompraClass::BuscaFactor($TEMPORADA, $DEPTO, $NOM_PAIS_NUMERO, $NOM_VIA_NUMERO, 2, $NOM_VENTANA);
        if (empty($query_factor[0])) {
            $query_factor = 0;
        }


        // Traer tipo de cambio
        $query_tipo_cambio = PlanCompraClass::BuscaTipoCambio($TEMPORADA, $DEPTO, 2, $NOM_VENTANA);
        if (empty($query_tipo_cambio[0])) {
            $query_tipo_cambio = 0;
        }

        // Valido que factor y tipo de cambio no sean cero
        if (($query_factor == 0) && ($query_tipo_cambio == 0)) {
            return " Factor y Tipo de Cambio llegan en Cero(0).";
            die();
        }


        // Definir la Ruta de Guardado
        //var url_PLC_PLAN_COMPRA_COLOR_3 = 'ajax_simulador_cbx/actualiza_grilla_plan_compra_color3';

        $total_fob_usd = 0;
        $total_target_usd = 0;
        $costo_unitario_final_usd = 0;


        // Cálculos
        // Costo unitarios final US$ : (Fob o target) + insp + rfid
        if ($COSTO_FOB > 0) {
            $costo_unitario_final_usd = $COSTO_FOB + $COSTO_INSP + $COSTO_RFID;
            $costo_unitario_final_usd = number_format($costo_unitario_final_usd, 2, '.', '');
            $total_fob_usd = $costo_unitario_final_usd * $CAN; //$UNID_OPCION_INICIO=iniciales
        } else {
            $costo_unitario_final_usd = $COSTO_TARGET + $COSTO_INSP + $COSTO_RFID;
            $costo_unitario_final_usd = number_format($costo_unitario_final_usd, 2, '.', '');
            $total_target_usd = number_format(($costo_unitario_final_usd * $CAN), 2, '.', '');
        }

        $costo_unitario_final_usd_target = $COSTO_TARGET + $COSTO_INSP + $COSTO_RFID;
        $costo_unitario_final_usd_target = number_format($costo_unitario_final_usd_target, 2, '.', '');
        $total_target_usd = number_format(($costo_unitario_final_usd_target * $CAN), 2, '.', '');

        if ($query_factor > 0) {
            $costo_unitario_final_pesos = $costo_unitario_final_usd * $query_factor;
            $costo_unitario_final_pesos = round($costo_unitario_final_pesos,0);
        } else {
            $costo_unitario_final_pesos = $costo_unitario_final_usd * $query_tipo_cambio;
            $costo_unitario_final_pesos = round($costo_unitario_final_pesos,0);
        }

        // Costo Total Pesos : Costo unitarios final Pesos  *  unidades
        $costo_total_pesos = $costo_unitario_final_pesos * $CAN;
        $costo_total_pesos = number_format($costo_total_pesos, 2, '.', '');
        // Mkup: (Precio blanco /1.19) / Costo unitarios final Pesos  (2 decimales)
        $nuevo_mkup = ($PRECIO_BLANCO / 1.19) / $costo_unitario_final_pesos;
        $nuevo_mkup = number_format($nuevo_mkup, 3, '.', '');

        // GM: ((Precio blanco /1.19)- Costo unitarios final Pesos) /  ((Precio blanco /1.19)*100) (2 decimales)
        $nuevo_gm = (((($PRECIO_BLANCO / 1.19) - $costo_unitario_final_pesos)) / ($PRECIO_BLANCO / 1.19)) * 100;
        $nuevo_gm = number_format($nuevo_gm, 3, '.', '');

        // Si llega Factor factor_est_campo = factor de lo contrario tipocambio = factor_est_campo
        // factor / tipocambio
        if ($query_factor > 0) {
            $factor_est_campo = $query_factor;
        } else {
            $factor_est_campo = $query_tipo_cambio;
        }

                                                                                                                                                                                                                                                                                                                                // +"&TIPO_EMPAQUE="+TIPO_EMPAQUE+"&FORMATO="+FORMATO+"&NOM_VENTANA="+NOM_VENTANA
        if ($COSTO_FOB > 0) {
            $total_fob_usd = number_format($total_fob_usd, 2, '.', '');
        }

        $costo_retail = 0;
        // total retail
        if ( ($PRECIO_BLANCO > 0) &&  ($CAN > 0) ){
            $costo_retail = round((($PRECIO_BLANCO * $CAN)/1.19),0,PHP_ROUND_HALF_UP);
        }


        $COSTO_UNIT = $costo_unitario_final_usd;
        $COSTO_UNITS = $costo_unitario_final_pesos;
        

        $CST_TOTLTARGET=" + total_target_usd + "&COSTO_TOT=" + total_fob_usd + "&COSTO_TOTS=" + costo_total_pesos + "&MKUP=" + nuevo_mkup + "&GM=" + nuevo_gm + "&PROVEEDOR=" + provedor + "&PAIS=" + pais + "&VIA=" + via + "&FACTOR_EST=" + factor_est_campo + "&NOM_VIA=" + nuevo_nom_via + "&NOM_PAIS=" + nuevo_nom_pais + "&TARGET=" + target + "&und_ajust=" + und_ajust + "&porcent_ajust=" + porcent_ajust + "&n_cajas=" + n_cajas + "&primera_carga=" + primera_carga + "&tiendas=" + tiendas + "&unida_ajust_xtallas=" + unida_ajust_xtallas + "&UNIDADES_FINALES=" + unidades_finales + "&UNIDADES_INICIALES=" + und_iniciales + "&cluster_=" + cluster + "&marca_=" + marcas + "&debut_=" + debut_reorder + "&tipo_emp_=" + tipo_empaque + "&formatos_=" + formato+"&precioRetail_=" + costo_retail+"&precio_blanco_=" + precio_blanco+ "&COSTO=" + costo_total_pesos;

        
        // $ID_COLOR3,$COSTO_FOB,$COSTO_INSP,$COSTO_RFID,$COSTO_UNIT,$COSTO_UNITS 

        // SOLO edito si me llegan las variables que actualmente son editables
        // si me llegan las variables que hay que actualizar, realizo el update
        // Se listan "Todas" las columnas, bloquear las que no se van a actualizar
        $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_3 SET";
        // $sql .= "ID_COLOR3 = $ID_COLOR3,";
        $sql .= "GRUPO_COMPRA = $GRUPO_COMPRA,";
        $sql .= "NVL(TEMP,1) COD_TEMP,";
        $sql .= "NOM_LINEA = $LINEA,";
        $sql .= "NOM_SUBLINEA = $SUBLINEA,";
        $sql .= "NOM_MARCA = $MARCA,";
        $sql .= "DES_ESTILO = $ESTILO,";
        $sql .= "SHORT_NAME = $SHORT_NAME,";
        $sql .= "ID_CORPORATIVO = $ID_CORPORATIVO,";
        $sql .= "DESCMODELO = $DESCMODELO,";
        $sql .= "DESCRIP_INTERNET = $DESCRIP_INTERNET,";
        $sql .= "NOMBRE_COMPRADOR = $NOMBRE_COMPRADOR,";
        $sql .= "NOMBRE_DISENADOR = $NOMBRE_DISENADOR,";
        $sql .= "COMPOSICION = $COMPOSICION,";
        $sql .= "TIPO_TELA = $TIPO_TELA,";
        $sql .= "FORRO = $FORRO,";
        $sql .= "COLECCION = $COLECCION,";
        $sql .= "EVENTO = $EVENTO,";
        $sql .= "NOM_ESTILOVIDA = $COD_ESTILO_VIDA,";
        $sql .= "CALIDAD = $CALIDAD,";
        $sql .= "NOM_OCACIONUSO = $NOM_OCACIONUSO,";//$COD_OCASION_USO
        $sql .= "NOM_PIRAMIDEMIX = $NOM_PIRAMIDEMIX,";
        $sql .= "NOM_VENTANA = $NOM_VENTANA,";
        $sql .= "NOM_RNK = $NOM_RNK,";
        $sql .= "NOM_LIFECYCLE = $NOM_LIFECYCLE,";
        $sql .= "NUM_EMB = $NUM_EMB,";
        $sql .= "NOM_COLOR = $NOM_COLOR,";
        $sql .= "TIPO_PRODUCTO = $TIPO_PRODUCTO,";
        $sql .= "TIPO_EXHIBICION = $TIPO_EXHIBICION,";
        $sql .= "DESTALLA = $DESTALLA,";
        $sql .= "TIPO_EMPAQUE = $TIPO_EMPAQUE,";
        $sql .= "PORTALLA_1_INI = $PORTALLA_1_INI,";
        $sql .= "PORTALLA_1 = $PORTALLA_1,";
        $sql .= "CURVATALLA = $CURVATALLA,";
        $sql .= "CURVAMIN = $CURVAMIN,";
        $sql .= "UNID_OPCION_INICIO = $UNID_OPCION_INICIO,";
        $sql .= "UNID_OPCION_AJUSTADA = $UNID_OPCION_AJUSTADA,";
        $sql .= "UNIDADES = $UNIDADES,";
        $sql .= "MTR_PACK = $MTR_PACK,";
        $sql .= "CANT_INNER = $CANT_INNER,";
        $sql .= "SEG_ASIG = $SEG_ASIG,";
        $sql .= "FORMATO = $FORMATO,";
        $sql .= "TDAS = $TDAS,";
        $sql .= "A = $A,";
        $sql .= "B = $B,";
        $sql .= "C = $C,";
        $sql .= "I = $I,";
        $sql .= "UND_ASIG_INI = $UND_ASIG_INI,";
        $sql .= "ROT = $ROT,";
        $sql .= "NOM_PRECEDENCIA = $NOM_PRECEDENCIA,";
        $sql .= "NOM_VIA = $NOM_VIA,";
        $sql .= "NOM_PAIS = $NOM_PAIS,";
        $sql .= "VIAJE = $VIAJE,";
        $sql .= "MKUP = $MKUP,";
        $sql .= "PRECIO_BLANCO = $PRECIO_BLANCO,";
        $sql .= "OFERTA = $OFERTA,";
        $sql .= "GM = $GM,";
        $sql .= "NOM_MONEDA = $NOM_MONEDA,";
        $sql .= "COSTO_TARGET = $COSTO_TARGET,";
        $sql .= "COSTO_FOB = $COSTO_FOB,";
        $sql .= "COSTO_INSP = $COSTO_INSP,";
        $sql .= "COSTO_RFID = $COSTO_RFID,";
        $sql .= "ROYALTY_POR = $ROYALTY_POR,";
        $sql .= "COSTO_UNIT = $COSTO_UNIT,";
        $sql .= "COSTO_UNITS = $COSTO_UNITS,";
        $sql .= "CST_TOTLTARGET = $CST_TOTLTARGET,";
        $sql .= "COSTO_TOT = $COSTO_TOT,";
        $sql .= "COSTO_TOTS = $COSTO_TOTS,";
        $sql .= "RETAIL = $RETAIL,";
        $sql .= "DEBUT_REODER = $DEBUT_REODER,";
        $sql .= "SEM_INI = $SEM_INI,";
        $sql .= "SEM_FIN = $SEM_FIN,";
        $sql .= "CICLO = $CICLO,";
        $sql .= "AGOT_OBJ = $AGOT_OBJ,";
        $sql .= "SEMLIQ = $SEMLIQ,";
        $sql .= "ALIAS_PROV = $ALIAS_PROV,";
        $sql .= "COD_PROVEEDOR = $COD_PROVEEDOR,";
        $sql .= "COD_TRADER = $COD_TRADER,";
        $sql .= "AFTER_MEETING_REMARKS = $AFTER_MEETING_REMARKS,";
        $sql .= "CODSKUPROVEEDOR = $CODSKUPROVEEDOR,";
        $sql .= "PROFORMA = $PROFORMA,";
        $sql .= "ESTADO = $ESTADO,";
        $sql .= "VENTANA_LLEGADA = $VENTANA_LLEGADA,";
        $sql .= "FROM PLC_PLAN_COMPRA_COLOR_3
                WHERE COD_TEMPORADA = $TEMPORADA AND DEP_DEPTO = '" . $DEPTO . "'
                AND ID_COLOR3 = $ID_COLOR3
                ";

        //$data = \database::getInstancia()->getConsulta($sql);
        return "OK";

    }


    // Calcula el Curvado para los campos editados en el plan de compra

    public static function BuscaNumeroPais($pais)
    {

        $sql = "SELECT CNTRY_LVL_CHILD
                FROM plc_pais
                WHERE UPPER(CNTRY_NAME) = '" . $pais . "'
                ";

        $data = \database::getInstancia()->getFilas($sql);
        //return $data;

        foreach ($data as $va1) {
            return $va1[0];
        }


    }


    // Carga POPUP de Historial en Plan de Compra

    public static function BuscaFactor($cod_temporada, $depto, $pais, $via, $moneda, $ventana)
    {

        $sql = "SELECT " . $ventana . " FROM PLC_FACTOR_EST F
                WHERE  F.COD_TEMPORADA   = $cod_temporada
                AND    F.DEP_DEPTO       = '" . $depto . "'
                AND    F.CNTRY_LVL_CHILD = $pais
                AND    F.COD_VIA         = $via
                AND    F.COD_TIP_MON     = $moneda
                ";

        $data = \database::getInstancia()->getFilas($sql);
        //return $data;

        foreach ($data as $va1) {
            return $va1[0];
        }

    }

    public static function BuscaTipoCambio($cod_temporada, $depto, $moneda, $ventana)
    {

        $sql = "SELECT  " . $ventana . "
                FROM   PLC_TIPO_CAMBIO P
                WHERE  P.COD_TEMPORADA = $cod_temporada
                AND    P.COD_TIP_MON = $moneda
                ";

        $data = \database::getInstancia()->getFilas($sql);
        //return $data;

        foreach ($data as $va1) {
            return $va1[0];
        }

    }

    // Buscar Tipo de Cambio

    public static function CalculoCurvadoPlanCompra($tipo_empaque, $tallas, $curvas_talla, $und_iniciales, $cluster, $formato
        , $A, $B, $C, $I, $debut_reoder, $PORTALLA_1_INI, $depto, $cod_tempo, $marca, $N_CURVASXCAJAS
        , $cod_linea, $cod_sublinea, $id_color3, $Guardado)
    {

        //var_dump($_REQUEST);
        //die();

        $dtmstpack = plan_compra::list_mstpack($cod_linea, $cod_sublinea, $depto);
        $mstpack = 0;
        if (count($dtmstpack) <> 0) {
            $mstpack = $dtmstpack[0];
        }

        /*******************AJUSTE CUERVA DE COMPRA*********************/
        $dtTabla = [];
        $dtTablaCurvado = [];
        $dtTablasSolidoCurvado = [];
        $dtTablasolidoFULL = [];
        $dtTablaReorder = [];
        $unid_ajustas = 0;
        $unid_final = 0;
        $porcentajeAjust = "";
        $n_cajasfinales = 0;
        $totalprimerRepato = 0;
        $unid_ajustasxtallas = "";
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
        if ($debut_reoder == "DEBUT") {
            //*-----------------curva de compra
            $insert = [];
            $por_Inicial = explode("-", trim($PORTALLA_1_INI));
            $total = 0;
            foreach ($por_Inicial as $var) {
                $total += round((($var * $und_iniciales) / 100));
                array_push($insert, round((($var * $und_iniciales) / 100)));
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------Curva del Primer Reparto
            $insert = [];
            $curvas = explode(",", trim($curvas_talla));
            $total = 0;
            $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $cluster, $formato));
            foreach ($curvas as $var) {
                $primer = 0;
                foreach ($clusters as $varc) {
                    $clustCurva = 0;
                    if ($varc == "A") {
                        $clustCurva = $A;
                    } elseif ($varc == "B") {
                        $clustCurva = $B;
                    } elseif ($varc == "C") {
                        $clustCurva = $C;
                    } elseif ($varc == "I") {
                        $clustCurva = $I;
                    }

                    $ntdas = 0;
                    if ($formato == "" OR $formato == "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                    } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                        $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                    }
                    $primer += $var * $clustCurva * $ntdas["TIENDAS"];
                }
                $total += $primer;
                array_push($insert, $primer);
            }
            array_push($insert, $total);
            array_push($dtTabla, $insert);

            //*-----------------diferencial
            $key = 0;
            $insert = [];
            $total = 0;
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
            $key = 0;
            $insert = [];
            $total = 0;
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
            $key = 0;
            $insert = [];
            $total = "";
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
            /*%*/
            $unid_ajustas = $dtTabla[4][$N_Columna];

            /*CURVADO*/
            if ($tipo_empaque == "Curvado" or $tipo_empaque == "CURVADO") {
                //*****************1.-AJUSTE DE CAJAS CURVADOS
                array_push($dtTablaCurvado, $dtTabla[0]);//CABECERA
                array_push($dtTablaCurvado, $dtTabla[4]);//TOTAL AJUSTE COMPRA
                //*-----------------Curva del Primer Reparto
                $insert = [];
                $total = 0;
                $curvas = explode(",", trim($curvas_talla));
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $cluster, $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $clustCurva = 0;
                        if ($varc == "A") {
                            $clustCurva = $A;
                        } elseif ($varc == "B") {
                            $clustCurva = $B;
                        } elseif ($varc == "C") {
                            $clustCurva = $C;
                        } elseif ($varc == "I") {
                            $clustCurva = $I;
                        }
                        $ntdas = 0;
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }

                        $primer += $var * $clustCurva * $ntdas["TIENDAS"];
                    }
                    $total += $primer;
                    array_push($insert, $primer);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);

                //*-----------------Curvas de repartos EJ: 1,2,3,4
                $insert = [];
                $total = 0;
                foreach ($curvas as $var) {
                    $total += $var;
                    array_push($insert, $var);
                }
                array_push($insert, $total);
                array_push($dtTablaCurvado, $insert);

                //Curva minima * n° de curva/caja
                //$masterCurvado = $dtTablaCurvado [3][$N_Columna] * $N_CURVAS_CAJAS;
                $insert = [];
                foreach ($tallas2 as $vart) {
                    array_push($insert, 0);
                }
                array_push($insert, $dtTablaCurvado [3][$N_Columna] * $N_CURVASXCAJAS);
                array_push($dtTablaCurvado, $insert);

                //total 1er repato / inner(curva min)
                $Curva_repartir = $dtTablaCurvado [2][$N_Columna] / $dtTablaCurvado[3][$N_Columna];
                $insert = [];
                foreach ($tallas2 as $vart) {
                    array_push($insert, 0);
                }
                array_push($insert, $Curva_repartir);
                array_push($dtTablaCurvado, $insert);

                //Curva a repartir / n de curva cajas
                $n_CAJAS = $Curva_repartir / $N_CURVASXCAJAS;
                $insert = [];
                foreach ($tallas2 as $vart) {
                    array_push($insert, 0);
                }
                array_push($insert, $n_CAJAS);
                array_push($dtTablaCurvado, $insert);

                //N° de curvas caja
                $insert = [];
                foreach ($tallas2 as $var) {
                    array_push($insert, 0);
                }
                array_push($insert, $N_CURVASXCAJAS);
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
                $insert = [];
                $total = 0;
                $keytallas = 0;
                foreach ($tallas2 as $vart) {
                    array_push($insert, $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas]);
                    $total += $dtTablaCurvado[1][$keytallas] - $dtTablaCurvado[2][$keytallas];
                    $keytallas += 1;
                }
                array_push($insert, $total);
                array_push($dtTablasSolidoCurvado, $insert);

                //n°cajas

                $insert = [];
                $total = 0;
                $keytallas = 0;
                foreach ($tallas2 as $vart) {
                    $parametro95 = round($dtTablaCurvado[2][$keytallas] / $dtTablaCurvado[1][$keytallas] * 100, 3);
                    $decimal = 0;
                    if (is_float($parametro95) == true) {
                        $division = 0;
                        if ($dtTablasSolidoCurvado[1][$keytallas] <> 0) {
                            $division = ($dtTablasSolidoCurvado[1][$keytallas] / $mstpack);
                            $decimal = (substr($division, strpos($division, ".")));
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
                $insert = [];
                $total = 0;
                $keytallas = 0;
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
                foreach ($tallas2 as $var) {
                    array_push($insert, 0);
                }
                array_push($insert, $mstpack);
                array_push($dtTablasSolidoCurvado, $insert);

                //*-----------------% unid ajustada x tallas TOTALES
                $key = 0;
                $unid_ajustasxtallas = "";
                $insert = [];
                $total = 0;
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
                foreach ($tallas2 as $var) {
                    array_push($insert, 0);
                }
                array_push($insert, $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS);
                array_push($dtTablasSolidoCurvado, $insert);

                //Total PORCENTAJE TOTAL AJUSTADO
                $insert = [];
                $key2 = 0;
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

                /*%*/
                $porcentajeAjust = substr($porcentajeAjust, 0, strlen($porcentajeAjust) - 1);
                /*%*/
                $n_cajasfinales = $dtTablasSolidoCurvado[2][$N_Columna] + $n_CAJAS; //curvado + solido
                /*%*/
                $unid_final = $dtTablasSolidoCurvado[3][$N_Columna] + $dtTablaCurvado[2][$N_Columna]; //curvado + solido
                /*%*/
                $totalprimerRepato = $dtTablaCurvado[2][$N_Columna];
                /*%*/
                $unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/
                $clusters3 = substr($clusters3, 0, -1);

            } /*SOLIDO*/ else {
                /*******************AJUSTE MST-PACK SOLIDO*********************/
                /*%*/
                $porcentajeAjust = $dtTabla[5][$N_Columna];
                array_push($dtTablasolidoFULL, $dtTabla[0]);//CABECERA

                //--------------unid iniciales
                $insert = [];
                $por_ajust = explode("-", trim($porcentajeAjust));
                $total = 0;
                foreach ($por_ajust as $var) {
                    $total += round((($var * $unid_ajustas) / 100));
                    array_push($insert, round((($var * $unid_ajustas) / 100)));
                }
                array_push($insert, $total);
                array_push($dtTablasolidoFULL, $insert);

                //*-----------------Curva del Primer Reparto
                $insert = [];
                $curvas = explode(",", trim($curvas_talla));
                $total = 0;
                $clusters = explode("+", plan_compra::list_inter_tds_cluster($depto, $marca, $cod_tempo, $cluster, $formato));
                foreach ($curvas as $var) {
                    $primer = 0;
                    foreach ($clusters as $varc) {
                        $ntdas = 0;
                        $clustCurva = 0;
                        if ($varc == "A") {
                            $clustCurva = $A;
                        } elseif ($varc == "B") {
                            $clustCurva = $B;
                        } elseif ($varc == "C") {
                            $clustCurva = $C;
                        } elseif ($varc == "I") {
                            $clustCurva = $I;
                        }
                        if ($formato == "" OR $formato == "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = plan_compra::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
                        }
                        $primer += $var * $clustCurva * $ntdas["TIENDAS"];
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
                $key = 0;
                $insert = [];
                $total = 0;
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
                $key = 0;
                $insert = [];
                $total = 0;
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
                $key = 0;
                $porcentajeAjust = "";
                $unid_final = $dtTablasolidoFULL[5][$N_Columna];
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

                /*%*/
                $porcentajeAjust = substr($porcentajeAjust, 0, -1);
                /*%*/
                $n_cajasfinales = $dtTablasolidoFULL[4][$N_Columna];
                /*%*/
                $unid_final = $dtTablasolidoFULL[5][$N_Columna];
                /*%*/
                $totalprimerRepato = $dtTablasolidoFULL[2][$N_Columna];
                /*%*/
                $unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
                /*%*/
                $clusters3 = substr($clusters3, 0, -1);
            }

        }//fin debut
        /*REORDER*/ ELSE {
            $unid_ajust = $und_iniciales;
            $porcentAjut = $PORTALLA_1_INI;
            //*-----------------tallas columnas
            array_push($dtTablaReorder, $dtTabla[0]);
            //--------------unid iniciales
            $insert = [];
            $por_ajust = explode("-", trim($porcentAjut));
            $total = 0;
            foreach ($por_ajust as $var) {
                $val = round(($var * $unid_ajust) / 100, 0);
                $total += $val;
                array_push($insert, $val);
            }
            array_push($insert, $total);
            array_push($dtTablaReorder, $insert);

            //-------------los  REORDER NO TIENE PRIMERA CARGA
            //*-----------------N° Cajas
            $key = 0;
            $insert = [];
            $total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                $val = $dtTablaReorder[1][$key] / $mstpack;
                if (is_float($val) == true) {
                    $val = round($val, 0);
                }
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTablaReorder, $insert);

            //*-----------------UND FINAL
            $key = 0;
            $insert = [];
            $total = 0;
            foreach ($tallas2 as $var) {
                $val = 0;
                $val = $dtTablaReorder[2][$key] * $mstpack;
                $total += $val;
                array_push($insert, $val);
                $key += 1;
            }
            array_push($insert, $total);
            array_push($dtTablaReorder, $insert);

            //mstpack
            $insert = [];
            foreach ($tallas2 as $var) {
                array_push($insert, $mstpack);
            }
            array_push($insert, $mstpack);
            array_push($dtTablaReorder, $insert);

            //*-----------------% pocentaje ajustada por mstpack
            $key = 0;
            $porcentAjut = "";
            $unid_final = $dtTablaReorder[3][$N_Columna];
            foreach ($tallas2 as $var) {
                $porcentajeAjust = $porcentajeAjust . round((($dtTablaReorder[3][$key] / $unid_final) * 100), 3) . "-";
                $key += 1;
            }
            //*-----------------% unid ajustada por tallas mstpack
            $key = 0;
            foreach ($tallas2 as $var) {
                $unid_ajustasxtallas = $unid_ajustasxtallas . strval(round($dtTablaReorder[3][$key])) . "-";
                $key += 1;
            }

            /*%*/
            $porcentajeAjust = substr($porcentajeAjust, 0, -1);
            /*%*/
            $n_cajasfinales = $dtTablaReorder[2][$N_Columna];
            /*%*/
            $unid_final = $dtTablaReorder[3][$N_Columna];
            /*%*/
            $totalprimerRepato = 0;
            /*%*/
            $unid_ajustasxtallas = substr($unid_ajustasxtallas, 0, -1);
            /*%*/
            $clusters3 = "";
            /*%*/
            $unid_ajustas = $und_iniciales;

        }

        // AJUSTE DE COMPRA   = $dtTabla
        // AJUSTE CURVADO     = $dtTablaCurvado + $dtTablasSolidoCurvado
        // AJUSTE SOLIDO FULL = $dtTablasolidoFULL
        // AJUSTE REORDER     = $dtTablaReorder

        $array2 = array(
            /*unid_ajustada*/
            $unid_ajustas
            /*porcenajust=mstpack*/, $porcentajeAjust
            /*n°cajas*/, $n_cajasfinales
            /*unidfinal*/, $unid_final
            /*primera carga*/, $totalprimerRepato
            /*$tdas*/, round(($totalprimerRepato / $unid_final) * 100, 2)
            /*unidadesajustXtalla*/, $unid_ajustasxtallas
            /*clustes intersecion*/, $clusters3
        , $dtTabla, $dtTablaCurvado, $dtTablasSolidoCurvado, $dtTablasolidoFULL, $dtTablaReorder);


        if ($Guardado == 1) {
            //Guardado PLC_AJUSTES_COMPRA $dtAjustada
            $_query = plan_compra::SaveAjuste_Compra2(/*AJUSTE DE COMPRA*/
                $dtTabla
                /*AJUSTE CURVADO*/, $dtTablaCurvado
                /*AJUSTE CUR SOLIDO*/, $dtTablasSolidoCurvado
                /*AJUSTE SOLIDO FUL*/, $dtTablasolidoFULL
                /*AJUSTE REORDER*/, $dtTablaReorder
                /*DEBUT/REORDER*/, $debut_reoder
                /*TIPO EMPAQUE*/, $tipo_empaque
                /*ID_COLOR3*/, $id_color3
                /*Tallas*/, $tallas
                /*TEMPO*/, $cod_tempo
                /*DEPTO*/, $depto);

            $key4 = 0;
            $logInsert = "";
            $count = count($_query);
            foreach ($_query as $val4) {
                $key4++;
                if ($count == $key4) {
                    $val4 = str_replace("union", "", $val4);
                }
                $logInsert = $logInsert . " " . $val4;
            }

            $sql = "DELETE plc_ajustes_compra
                    WHERE COD_TEMPORADA = " . $cod_tempo . " 
                    AND DEP_DEPTO = '" . $depto . "'
                    AND ID_COLOR3 = " . $id_color3;

            \database::getInstancia()->getConsulta($sql);
            plan_compra::InsertAjustes($logInsert);

        }


        return $array2;

        /*  echo "<pre>";
          echo "/------1 ajuste----";
          var_dump($dtTabla);
          echo "/------2 curvado------";
          var_dump($dtTablaCurvado);
          echo "/------3 solidocurvado------";
          var_dump($dtTablasSolidoCurvado);
          echo "/------4 solidoFULL------";
          var_dump($dtTablasolidoFULL);
          echo "/------5 REORDER------";
          var_dump($dtTablaReorder);
          die();*/
    }

    // Listar País

    public static function ListarHistorial($temporada, $depto, $id_color3)
    {

        $sql = "select   NVL(A.FECHA,''),
                         NVL(A.HORA,''),
                         A.USER_NOM USUARIO,
                         convert(REPLACE(REPLACE(INITCAP(B.NOM_EST_C1),CHR(10),''),CHR(13),''),'utf8','us7ascii') ESTADO
                FROM plc_plan_compra_historica A
                LEFT JOIN PLC_ESTADO_C1 B ON A.ESTADO = B.COD_EST_C1
                WHERE  A.dpto = '" . $depto . "'
                AND    A.TEMP = $temporada
                AND    A.ID_COLOR3 = $id_color3
                ORDER BY A.FECHA, A.HORA ASC
     ";

        $data = \database::getInstancia()->getFilas($sql);
        //return $data;

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "FECHA" => $va1[0]
                , "HORA" => $va1[1]
                , "USUARIO" => $va1[2]
                , "ESTADO" => $va1[3]
                )
            );
        }

        return $array1;

    }

    // Listar País

    public static function ListarPais($cod_temporada, $depto)
    {

        $sql = "SELECT CNTRY_LVL_CHILD,CNTRY_NAME 
                  FROM plc_pais
                  ORDER BY CNTRY_NAME ASC
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Busca Formatos Grilla Editar

    public static function ListarFormato($temporada, $depto)
    {

        $sql = "select distinct b.des_seg,b.cod_seg
                    from plc_formatos_tda a
                    inner join plc_formato b on a.cod_temporada = b.cod_temporada
                                             and a.dep_depto = b.dep_depto
                                             and a.cod_seg = b.cod_seg
                    where a.COD_TEMPORADA = $temporada
                    and a.DEP_DEPTO = '" . $depto . "' 
                    order by 1 asc
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Busca Ventana Grilla Editar
    public static function ListarVentana($temporada, $depto)
    {

        $sql = "SELECT * FROM plc_ventana";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }


// Fin de la Clase
}