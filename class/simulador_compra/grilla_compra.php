<?php

/**
 * CLASS Temporada
 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
 * Fecha: 2018-02-07
 * @author RODRIGO RIOSECO
 */

namespace simulador_compra;

class grilla_compra extends \parametros {

    public static function obtieneDatosGrilla($temporada, $depto) {
        
        $sql = "begin PLC_PKG_MIGRACION.PRC_GRID_PLAN_COMPRA_COLOR_4(" . $temporada . ",'" . $depto . "','','', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);
        $cont = 0;

        foreach ($data as $val) {
            //if ($cont <= 1) {
                $grilla[] = array("id" => $val[0],
                    "grupo_compra" => $val[8],
                    "temporada" => $val[9],
                    "linea" => $val[12],
                    "sublinea" => $val[6],
                    "marca" => $val[21],
                    "estilo" =>  utf8_encode($val[11]),
                    "cod_corp" => $val[7],
                    "descri" => $val[12],
                    "descri_internet" => utf8_encode($val[214]),
                    "composicion" => utf8_encode($val[13]),              
                    "coleccion" => $val[14],
                    "evento" => $val[15],
                    "cod_estilo" => $val[16],
                    "Calidad" => $val[17],
                    "Ocasion" => $val[18],
                    "piramide" => $val[19],
                    "ventana" => $val[22],
                    "rank_vta" => $val[23],
                    "ciclo_vida" => $val[24],
                    "color" => $val[25],
                    "tipo_producto" => $val[27],
                    "exhibicion" => $val[28],
                    "tallas" => $val[29],
                    "%compra" => $val[31],
                    "curva" => $val[33],
                    "curva_min" => $val[35],
                    "uni_ini" => $val[46],
                    "uni_ajust" => $val[162],
                    "uni_fisica" => $val[47],
                    "master_pack" => $val[49],
                    "caja" => $val[50],
                    "cluster" => $val[56]
                );
            //}
            $cont++;
        }
      

        return $grilla;
    }

    public static function obtieneDatosGrilla2($temporada, $depto) {

        $sql = "SELECT C.ID_COLOR3,C.ESTADO CODESTADO,C.INDICE,C.ITEM,  C.ID,C.COD_JER2 LINEA,  C.COD_SUBLIN SUBLINEA,  C.ID_CORPORATIVO,  C.GRUPO_COMPRA,  NVL(TEMP,1) COD_TEMP  ,  C.COD_ESTILO,  C.DES_ESTILO ESTILO,  C.DESCMODELO
                  ,C.COMPOSICION,C.COLECCION,  C.EVENTO,  C.COD_ESTILO_VIDA,  C.CALIDAD,  C.COD_OCASION_USO,  C.COD_PIRAMIX,  C.COD_TIP_MON,  C.COD_MARCA,  C.VENTANA_LLEGADA,  C.COD_RANKVTA,  C.LIFE_CYCLE
                  ,NVL(COD_COLOR,0)COLOR ,PLC_PKG_GENERAL.FUN_GET_DESCOLOR(COD_COLOR)  DESCOLOR,  C.TIPO_PRODUCTO,  C.TIPO_EXHIBICION,  C.DESTALLA ,  C.PORTALLA
                  , C.PORTALLA_1,  C.PORTALLAS,  C.CURVATALLA,  C.DIST,  C.CURVAMIN,  '' TALLA1,'' TALLA2,'' TALLA3,'' TALLA4,'' TALLA5,'' TALLA6,'' TALLA7,'' TALLA8,'' TALLA9,'' TALLA10,  C.UNID_OPCION_INICIO,  C.UNIDADES CAN,  ROUND( C.PORCENTAJE, 8 )  POR ,  C.MTR_PACK,  C.CANT_INNER,  '' TIPO_EMPAQUE,  '' CURVA_COMPRA,  C.A ,  C.B,  C.C,  C.SEG_ASIG,  C.FORMATO,  C.TDAS,  C.UND_ASIG_INI,  C.UND_ASIG,  C.ROT,  C.DIFER_REPARTO,  C.PROCEDENCIA,  C.VIA,  C.PAIS,  C.VIAJE,  C.MKUP,  C.PRECIO_BLANCO,  C.COSTO_TARGET,  C.COSTO_FOB,  C.COSTO_INSP,  C.COSTO_HANGER,  C.COSTO_STICKER,  C.TRADER_POR,  C.TRADER_DOL,  C.DUMPING_POR,  C.DUMPING_DOL,  C.ROYALTY_POR,  C.ROYALTY_DOL,  C.COSTO_UNIT,  C.COSTO_UNITS,  C.CST_TOTLTARGET,  C.COSTO_TOTS,  C.COSTO_TOTH,  C.COSTO_TOT,  C.RETAIL,  C.DEBUT_REODER,  C.SEM_INI,  C.SEM_FIN,  C.CICLO,  C.AGOT_OBJ,  C.SEMLIQ,  C.ALIAS_PROV,  C.COD_PROVEEDOR,  C.COD_TRADER,  C.CODSKUPROVEEDOR,  C.PROFORMA,  O.COD_PADRE SKU,  O.ESTADO_MATCH,  0 PI,  O.ARCHIVO,  0 OC_ADD ,  0 NUM_OC ,  O.PO_NUMBER OC
                  ,(SELECT INITCAP( X.PMG_STAT_NAME )FROM PMGHDREE A,PMGSTSCD X WHERE  A.PMG_PO_NUMBER = O.PO_NUMBER AND A.PMG_STAT_CODE = X.PMG_STAT_CODE )         AS ESTACO_OC  
                  ,(SELECT FUPMM_REPLACE_CHR13( AA.PRD_NAME_FULL )FROM PRDMSTEE AA WHERE  AA.PRD_LVL_NUMBER = RPAD( O.COD_PADRE, 15, ' ' )) AS ESTILOPMM
                  ,O.FECHA_EMBARQUE,  O.FECHA_ETA,  O.FECHA_RECEPCION,  O.DIAS_ATRASO,  0 CODESTADO,  0 UNDMODELO,  C.TIPO_CURVA,  C.NUM_EMB,  C.EMB_MIN,  C.EMB_MAX,  C.COB_CALC ,  C.FLAG_EMB_MANUAL,  C.VENT_HAB_INI,  C.VENT_HAB_FIN,  C.DSCTO_OBJ,  C.DSCTO_PROM,  C.STK_MIN,  C.TIPO_CICLO,  C.GM,  C.TIPO_DSCTO,  C.RATIO,  C.UNDWHITAKER,  C.GMB ,  C.VENT_EMB,  C.COSTO_UNITH,  C.PRECIO_BLANCOH,  C.COSTO_HANGER,  C.COSTO_STICKER,  C.FACTOR_EST,  C.ESTADOCICLO,  C.ESTADODIST,  C.IMG_EST_COLOR,  C.VENT_EMB_REAL
                  ,''FLAG_MAPEO,  C.EQUIV,  C.BOLSA,  C.ITEM_REF,''SEM_ACT_REAL,'' NUM_SEM_X_ACT,'' NUM_SEM_RETRASO,'' STK_OHDISP,'' STK_OOCD,'' STK_TRAN,'' STK_TDAOH,'' STK_TDAOO,'' UNDAGOTREAL,'' PORAGOTREAL
                  ,''UNDAGOTOBJ,'' PORAGOTOBJ,'' PORDESV,'' PRECIO_REAL,'' POR_PRECIO_REAL,'' PRECIO_SUG,'' POR_PRECIO_SUG,C.PORTALLA_1_INI,C.UNID_OPCION_AJUSTADA
                  ,C.TALLA11,C.TALLA12,C.TALLA13,C.TALLA14,C.TALLA15,C.CURV1,C.CURV2,C.CURV3,C.CURV4,C.CURV5,C.CURV6,C.CURV7,C.CURV8,C.CURV9,C.CURV10,C.CURV11,C.CURV12,C.CURV13,C.CURV14,C.CURV15          
                  ,C.PORCEN_T1,C.PORCEN_T2,C.PORCEN_T3,C.PORCEN_T4,C.PORCEN_T5,C.PORCEN_T6,C.PORCEN_T7,C.PORCEN_T8,C.PORCEN_T9,C.PORCEN_T10,C.PORCEN_T11,C.PORCEN_T12,C.PORCEN_T13,C.PORCEN_T14,C.PORCEN_T15     
                  ,C.CANT_T1,C.CANT_T2,C.CANT_T3,C.CANT_T4,C.CANT_T5,C.CANT_T6,C.CANT_T7,C.CANT_T8,C.CANT_T9,C.CANT_T10,C.CANT_T11,C.CANT_T12,C.CANT_T13,C.CANT_T14,C.CANT_T15,C.I,C.DESCRIP_INTERNET,C.COSTO_RFID
                  FROM PLC_PLAN_COMPRA_COLOR_3 C
                  LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                  AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                  WHERE C.COD_TEMPORADA =  " . $temporada . " AND C.DEP_DEPTO =  '" . $depto . "'   
                  ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER";

        $data = \database::getInstancia()->getFilas($sql);

        $i = 0;
        foreach ($data as $val) {
            $grilla[] = array("ID" => $data[$i]['ID_COLOR3'],
                            "Grupo Compra" =>  $data[$i]['GRUPO_COMPRA'],
                            "Temp" => $data[$i]['COD_TEMP'],
                            "Linea" => $data[$i]['LINEA'],
                            "Sublinea" => $data[$i]['SUBLINEA'],
                            "Marca" => $data[$i]['COD_MARCA'],
                            "Estilo" =>  utf8_encode($data[$i]['ESTILO']),
                            "Cod corp" =>$data[$i]['ID_CORPORATIVO'],
                            "Descrip." => $data[$i]['DESCMODELO'],
                            "Descri Internet" => utf8_encode($data[$i]['DESCRIP_INTERNET']),
                            "Composicion" => utf8_encode($data[$i]['COMPOSICION']),
                            "Coleccion" => $data[$i]['COLECCION'],
                            "Evento" => $data[$i]['EVENTO'],
                            "Estilo Vida" => $data[$i]['COD_ESTILO_VIDA'],
                            "Calidad" => "",
                            "Ocasion Uso" => $data[$i]['COD_OCASION_USO'],
                            "Piramide Mix" => $data[$i]['COD_PIRAMIX'],
                            "Ventana" => $data[$i]['VENTANA_LLEGADA'],
                            "Rank Vta" => $data[$i]['COD_RANKVTA'],
                            "Ciclo Vida" => $data[$i]['LIFE_CYCLE'],
                            "Color" => $data[$i]['COLOR'],
                            "Tipo Producto" => $data[$i]['TIPO_PRODUCTO'],
                            "Tipo Exhibicion" => $data[$i]['TIPO_EXHIBICION'],
                            "Tallas" => $data[$i]['DESTALLA'],
                            "% Compra Ini" => $data[$i]['PORTALLA_1_INI'],
                            "% Compra Ajust" => $data[$i]['PORTALLA_1'],
                            "% Ajust" => "",
                            "Curva" => $data[$i]['CURVATALLA'],
                            "Curva Min" => $data[$i]['CURVAMIN'],
                            "Uni Ini" => $data[$i]['UNID_OPCION_INICIO'],
                            "Uni Ajust" => $data[$i]['UNID_OPCION_AJUSTADA'],
                            "Uni Final" => $data[$i]['CAN'],



                            "MtrPack" => $data[$i]['MTR_PACK'],
                            "Nº Cajas" => $data[$i]['CANT_INNER'],
                            "Cluster" => $data[$i]['SEG_ASIG'],
                            "Formato" =>$data[$i]['FORMATO'],
                            "Tdas" =>$data[$i]['TDAS'],
                            "A" =>$data[$i]['A'],
                            "B" =>$data[$i]['B'],
                            "C" =>$data[$i]['C'],
                            "I" =>$data[$i]['I'],
                            "Primera Carga" =>$data[$i]['UND_ASIG_INI'],
                            "%Tiendas" =>$data[$i]['ROT'],
                            "Proced" =>$data[$i]['PROCEDENCIA'],
                            "Vía" =>$data[$i]['VIA'],
                            "País" =>$data[$i]['PAIS'],
                            "Viaje" =>$data[$i]['VIAJE'],
                            "Mkup" =>$data[$i]['MKUP'],
                            "Precio Blanco" =>$data[$i]['PRECIO_BLANCO'],
                            "GM" =>"",//FALTA EL CALCULO
                            "Moneda" =>$data[$i]['COD_TIP_MON'],
                            "Target" =>$data[$i]['COSTO_TARGET'],
                            "FOB" =>$data[$i]['COSTO_FOB'],
                            "Insp" =>$data[$i]['COSTO_INSP'],
                            "RFID" =>$data[$i]['COSTO_RFID'],
                            "Royalty(%)" =>$data[$i]['ROYALTY_POR'],
                            "Costo Unitario Final US$" =>$data[$i]['COSTO_UNIT'],
                            "Costo Unitario Final Pesos" =>$data[$i]['COSTO_UNITS'],
                            "Total Target US$" =>$data[$i]['CST_TOTLTARGET'],
                            "Total Fob US$" =>$data[$i]['COSTO_TOT'],
                            "Costo Total Pesos" =>$data[$i]['COSTO_TOTS'],
                            "Total Retail Pesos(Sin IVA)" =>$data[$i]['RETAIL'],
                            "Debut/Reorder" =>$data[$i]['DEBUT_REODER'],
                            "Sem Ini" =>$data[$i]['SEM_INI'],
                            "Sem Fin" =>$data[$i]['SEM_FIN'],
                            "Semanas Ciclo de Vida" =>$data[$i]['CICLO'],
                            "Agot Obj" => strval($data[$i]['AGOT_OBJ']*100)."%" ,
                            "Semanas Liquidación" =>$data[$i]['SEMLIQ'],
                            "Proveedor" =>$data[$i]['ALIAS_PROV'],
                            "Razon Social" =>$data[$i]['COD_PROVEEDOR'],
                            "Trader" =>$data[$i]['COD_TRADER'],
                            "Cod Sku Proveedor" =>$data[$i]['CODSKUPROVEEDOR'],
                            "Cod. Padre" =>$data[$i]['SKU'],
                            "Proforma" =>$data[$i]['PROFORMA'],
                            "Archivo" =>$data[$i]['ARCHIVO'],
                            "Estilo PMM" =>$data[$i]['ESTILOPMM'],
                            "Estado Match" =>$data[$i]['ESTADO_MATCH'],
                            "N° OC" =>$data[$i]['NUM_OC'],
                            "Estado OC" =>$data[$i]['ESTACO_OC'],
                            "Fecha Embarque" =>$data[$i]['FECHA_EMBARQUE'],
                            "Fecha ETA" =>$data[$i]['FECHA_ETA'],
                            "Fecha Recepción CD" =>$data[$i]['FECHA_RECEPCION'],
                            "Días Atraso CD" =>$data[$i]['DIAS_ATRASO'],
                            "Estado Opción" =>$data[$i]['CODESTADO']
            );
            //}
            $i++;
        }

        if (count($data)> 0){
        return $grilla;
    }

    }



// Fin de la clase
}


