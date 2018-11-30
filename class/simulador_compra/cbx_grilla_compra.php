<?php

/**
 * CLASS Temporada
 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
 * Fecha: 2018-05-09
 * @author ROBERTO PéREZ
 */

namespace simulador_compra;

class cbx_grilla_compra extends \parametros
{

    // Llenar la Tabla 2
    public static function llenar_tabla2b($temporada, $depto)
    {

        $sql = "SELECT
                C.ID_COLOR3,              -- id
                C.GRUPO_COMPRA,           -- grupo compra
                NVL(TEMP,1) COD_TEMP,     -- temp
                --C.COD_JER2 LINEA,         -- linea
                --(SELECT TRIM( L.PRD_NAME_FULL ) FROM PRDMSTEE P,PRDMSTEE L WHERE P.PRD_LVL_NUMBER = RPAD('" . $depto . "', 15, ' ' ) AND P.PRD_LVL_CHILD  = L.PRD_LVL_PARENT AND L.PRD_STATUS = 0 AND TRIM(L.PRD_LVL_NUMBER)= C.COD_JER2)LINEA,
                C.NOM_LINEA LINEA,
                --C.COD_SUBLIN SUBLINEA,    -- sublinea
                --(SELECT TRIM( L.PRD_NAME_FULL ) FROM PRDMSTEE P,PRDMSTEE L WHERE P.PRD_LVL_NUMBER IN (SELECT RPAD( TRIM( L.PRD_LVL_NUMBER ), 15, ' ' ) AS LIN_LINEA FROM PRDMSTEE P,PRDMSTEE L WHERE  P.PRD_LVL_NUMBER = RPAD( '" . $depto . "', 15, ' ' ) AND P.PRD_LVL_CHILD = L.PRD_LVL_PARENT AND L.PRD_STATUS = 0) AND P.PRD_LVL_CHILD = L.PRD_LVL_PARENT AND L.PRD_STATUS = 0 AND TRIM( L.PRD_LVL_NUMBER )=C.COD_SUBLIN) SUBLINEA,
                C.NOM_SUBLINEA SUBLINEA,
                --C.COD_MARCA,              -- marca
                --(SELECT NOM_MARCA FROM PLC_DEPTO_MARCA WHERE COD_DEPT = '" . $depto . "' AND COD_MARCA = C.COD_MARCA) MARCA,
                C.NOM_MARCA MARCA,
                C.DES_ESTILO ESTILO,      -- estilo
                C.SHORT_NAME,
                C.ID_CORPORATIVO,         -- cod. corp
                C.DESCMODELO,             -- descripción                        (Registro 10)
                C.DESCRIP_INTERNET,       -- Descripción Internet
                C.COMPOSICION,            -- COmposicion
                C.COLECCION,              -- Colección
                C.EVENTO,                 -- Evento
                --C.COD_ESTILO_VIDA,        -- Estilo Vida
                NOM_ESTILOVIDA COD_ESTILO_VIDA,
                --C.CALIDAD,
                '' CALIDAD,               -- Calidad
                --C.COD_OCASION_USO,        -- Ocación Uso
                C.NOM_OCACIONUSO COD_OCASION_USO,
                --C.COD_PIRAMIX,            -- Piramide Mix
                C.NOM_PIRAMIDEMIX COD_PIRAMIX,
                --C.VENTANA_LLEGADA,        -- Ventana
                --(SELECT B.VENT_DESCRI FROM PLC_VENTANA_EMB A,PLC_VENTANA B WHERE A.COD_VENTANA = B.COD_VENTANA AND COD_TEMPORADA = " . $temporada . " AND B.COD_VENTANA = C.VENTANA_LLEGADA)DESCRIPCION,
                C.NOM_VENTANA DESCRIPCION,
                --C.COD_RANKVTA,            -- Rank Ventana
                C.NOM_RNK COD_RANKVTA,                                         --(Registro 20)
                --C.LIFE_CYCLE,             -- Cilco Vida
                C.NOM_LIFECYCLE LIFE_CYCLE,
                --NVL(COD_COLOR,0)COLOR,    -- Color
                --(SELECT INITCAP(descripcion) FROM PLC_MAEDIM WHERE tipo = 'C' AND TRIM(codigo) = NVL(COD_COLOR,0))COD_COLOR,
                C.NOM_COLOR COD_COLOR,
                C.TIPO_PRODUCTO,          -- Tipo Producto
                C.TIPO_EXHIBICION,        -- Tipo Exhibicion
                C.DESTALLA,               -- Tallas
                C.TIPO_EMPAQUE,           -- Tipo empaque
                C.PORTALLA_1_INI,         -- Compra Ini
                C.PORTALLA_1,             -- Compra Ajustada
                --% Ajust
                --'' AJUST,
                C.CURVATALLA,             -- Curva
                C.CURVAMIN,               -- Curva Min                          --(Registro 30)
                C.UNID_OPCION_INICIO,     -- Uni Ini
                C.UNID_OPCION_AJUSTADA,   -- Uni Ajust
                C.UNIDADES CAN,           -- Uni Final
                C.MTR_PACK,               -- Master Pack
                C.CANT_INNER,             -- Nº Cajas
                C.SEG_ASIG,               -- Cluster
                C.FORMATO,                -- Formato
                C.TDAS,                   -- Tdas
                C.A ,                     -- A
                C.B,                      -- B                                  --(Registro 40)
                C.C,                      -- C
                C.I,                      -- I
                C.UND_ASIG_INI,
                C.ROT,
                --C.PROCEDENCIA,
                NOM_PRECEDENCIA,
                --C.VIA,
                NOM_VIA,
                --C.PAIS,
                NOM_PAIS,
                C.VIAJE,
                C.MKUP,
                C.PRECIO_BLANCO,                                                --(Registro 50)
                C.GM,
                --''GM,
            --C.COD_TIP_MON,
            C.NOM_MONEDA  COD_TIP_MON,
                C.COSTO_TARGET,
                C.COSTO_FOB,
                C.COSTO_INSP,
                C.COSTO_RFID,
                C.ROYALTY_POR,
                C.COSTO_UNIT,
                C.COSTO_UNITS,
                C.CST_TOTLTARGET,                                               --(Registro 60)
                C.COSTO_TOT,
                C.COSTO_TOTS,
                C.RETAIL,
                C.DEBUT_REODER,
                C.SEM_INI,
                C.SEM_FIN,
                C.CICLO,
                C.AGOT_OBJ,
                C.SEMLIQ,
                C.ALIAS_PROV,                                                   --(Registro 70)
                C.COD_PROVEEDOR,
                C.COD_TRADER,
                C.CODSKUPROVEEDOR,
                O.COD_PADRE SKU,
                C.PROFORMA,
                O.ARCHIVO,
                O.ESTILO_PMM,
                O.ESTADO_MATCH,
                --0 NUM_OC,
                O.PO_NUMBER,
                O.ESTADO_OC,                                                    --(Registro 80)
                O.FECHA_EMBARQUE,
                O.FECHA_ETA,
                O.FECHA_RECEPCION,
                O.DIAS_ATRASO,
                --0 CODESTADO,
                convert((SELECT nom_est_c1 FROM plc_estado_c1 WHERE cod_est_c1= C.ESTADO),'utf8','us7ascii')CODESTADO,
                C.ESTADO ESTADO_C1,
                C.VENTANA_LLEGADA,
                REPLACE((SELECT DISTINCT FECHA_RECEPCD FROM plc_ventana_emb V WHERE V.cod_temporada = C.COD_TEMPORADA AND V.cod_ventana = C.VENT_EMB),'/','-') FECHA_RECEPCD_C1,
                C.COD_ESTILO,
                PLC_PKG_GENERAL.FUN_GET_DESCOLOR(COD_COLOR) DESCOLOR,
                C.PORTALLA,                                                     --(Registro 90)
                C.PORTALLAS,
                '' TALLA1,
                '' TALLA2,
                '' TALLA3,
                '' TALLA4,
                '' TALLA5,
                '' TALLA6,
                '' TALLA7,
                '' TALLA8,
                '' TALLA9,                                                      --(Registro 100)
                '' TALLA10,
                ROUND( C.PORCENTAJE, 8 ) POR,
                '' TIPO_EMPAQUE,
                '' CURVA_COMPRA,
                C.UND_ASIG,
                C.DIFER_REPARTO,
                C.COSTO_HANGER,
                C.COSTO_STICKER,
                C.TRADER_POR,
                C.TRADER_DOL,                                                   --(Registro 110)
                C.DUMPING_POR,
                C.DUMPING_DOL,
                C.ROYALTY_DOL,
                C.COSTO_TOTH,
                0 PI,
                0 OC_ADD ,
                O.PO_NUMBER OC,
                0 UNDMODELO,
                C.TIPO_CURVA,
                C.NUM_EMB,                                                      --(Registro 120)
                C.EMB_MIN,
                C.EMB_MAX,
                C.COB_CALC,
                C.FLAG_EMB_MANUAL,
                C.VENT_HAB_INI,
                C.VENT_HAB_FIN,
                C.DSCTO_OBJ,
                C.DSCTO_PROM,
                C.STK_MIN,
                C.TIPO_CICLO,                                                   --(Registro 130)
                C.GM,
                C.TIPO_DSCTO,
                C.RATIO,
                C.UNDWHITAKER,
                C.GMB,
                C.VENT_EMB,
                C.COSTO_UNITH,
                C.PRECIO_BLANCOH,
                C.COSTO_HANGER,
                C.COSTO_STICKER,                                                --(Registro 140)
                C.FACTOR_EST,
                C.ESTADOCICLO,
                C.ESTADODIST,
                C.IMG_EST_COLOR,
                C.VENT_EMB_REAL,
                ''FLAG_MAPEO,
                C.EQUIV,
                C.BOLSA,
                C.ITEM_REF,
                ''SEM_ACT_REAL,                                                  --(Registro 150)
                '' NUM_SEM_X_ACT,
                '' NUM_SEM_RETRASO,
                '' STK_OHDISP,
                '' STK_OOCD,
                '' STK_TRAN,
                '' STK_TDAOH,
                '' STK_TDAOO,
                '' UNDAGOTREAL,
                '' PORAGOTREAL,
                ''UNDAGOTOBJ,                                                    --(Registro 160)
                '' PORAGOTOBJ,
                '' PORDESV,
                '' PRECIO_REAL,
                '' POR_PRECIO_REAL,
                '' PRECIO_SUG,
                '' POR_PRECIO_SUG,
                C.TALLA11,
                C.TALLA12,
                C.TALLA13,
                C.TALLA14,                                                       --(Registro 170)
                C.TALLA15,
                C.CURV1,
                C.CURV2,
                C.CURV3,
                C.CURV4,
                C.CURV5,
                C.CURV6,
                C.CURV7,
                C.CURV8,
                C.CURV9,                                                        --(Registro 180)
                C.CURV10,
                C.CURV11,
                C.CURV12,
                C.CURV13,
                C.CURV14,
                C.CURV15,
                C.PORCEN_T1,
                C.PORCEN_T2,
                C.PORCEN_T3,
                C.PORCEN_T4,                                                    --(Registro 190)
                C.PORCEN_T5,
                C.PORCEN_T6,
                C.PORCEN_T7,
                C.PORCEN_T8,
                C.PORCEN_T9,
                C.PORCEN_T10,
                C.PORCEN_T11,
                C.PORCEN_T12,
                C.PORCEN_T13,
                C.PORCEN_T14,                                                   --(Registro 200)
                C.PORCEN_T15,
                C.CANT_T1,
                C.CANT_T2,
                C.CANT_T3,
                C.CANT_T4,
                C.CANT_T5,
                C.CANT_T6,
                C.CANT_T7,
                C.CANT_T8,
                C.CANT_T9,                                                      --(Registro 210)
                C.CANT_T10,
                C.CANT_T11,
                C.CANT_T12,
                C.CANT_T13,
                C.CANT_T14,
                C.CANT_T15,
                C.INDICE,
                C.ITEM,
                C.ID,
                C.DIST                                                          --(Registro 220)
                
                
                  FROM PLC_PLAN_COMPRA_COLOR_3 C
                  LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                  AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                  WHERE C.COD_TEMPORADA =  " . $temporada . " AND C.DEP_DEPTO =  '" . $depto . "'
                  ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER
              ";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;

    }

    public static function llenar_tabla2_base($temporada, $depto)
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
                ''NOMBRE_COMPRADOR,
                ''NOMBRE_DISENADOR,
                C.COMPOSICION,                -- 11 Composicion
                ''TIPO_TELA,
                ''FORRO,
                C.COLECCION,                  -- 12 Colección
                C.EVENTO,                     -- 13 Evento
                NOM_ESTILOVIDA COD_ESTILO_VIDA,  -- 14 estilo vida
                '' CALIDAD,                      -- 15 Calidad
                C.NOM_OCACIONUSO COD_OCASION_USO,-- 16 ocacion uso
                C.NOM_PIRAMIDEMIX COD_PIRAMIX,   -- 17 piramide mix
                C.NOM_VENTANA DESCRIPCION,       -- 18 ventana
                C.NOM_RNK COD_RANKVTA,           -- 19 rank vta
                C.NOM_LIFECYCLE LIFE_CYCLE,      -- 20 ciclo vida
                C.NUM_EMB,                       -- 21 num_emb
                C.NOM_COLOR COD_COLOR,           -- 22 color
                C.TIPO_PRODUCTO,                 -- 23 Tipo Producto
                C.TIPO_EXHIBICION,               -- 24 Tipo Exhibicion
                C.DESTALLA,                      -- 25 Tallas
                C.TIPO_EMPAQUE,                  -- 26 Tipo empaque
                C.PORTALLA_1_INI,                -- 27 Compra Ini
                C.PORTALLA_1,                    -- 28 Compra Ajustada
                C.CURVATALLA,                    -- 29 Curva
                C.CURVAMIN,                      -- 30 Curva Min
                C.UNID_OPCION_INICIO,            -- 31 Uni Ini
                C.UNID_OPCION_AJUSTADA,          -- 32 Uni Ajust
                C.UNIDADES CAN,                  -- 33 Uni Final
                C.MTR_PACK,                      -- 34 Master Pack
                C.CANT_INNER,                    -- 35 Nº Cajas
                C.SEG_ASIG,                      -- 36 Cluster
                C.FORMATO,                       -- 37 Formato
                C.TDAS,                          -- 38 Tdas
                C.A ,                            -- 39 A
                C.B,                             -- 40 B
                C.C,                             -- 41 C
                C.I,                             -- 42 I
                C.UND_ASIG_INI,                  -- 43 Primera Carga
                C.ROT,                           -- 44 %Tiendas
                NOM_PRECEDENCIA,                 -- 45 Proced
                NOM_VIA,                         -- 46 Vìa
                NOM_PAIS,                        -- 47 Paìs
                C.VIAJE,                         -- 48 Viaje
                C.MKUP,                          -- 49 mkup
                C.PRECIO_BLANCO,                 -- 50 Precio Blanco
                '' OFERTA,                       -- 51 Oferta 
                C.GM,                            -- 51 GM
                C.NOM_MONEDA  COD_TIP_MON,       -- 52 Moneda
                C.COSTO_TARGET,                  -- 53 Target
                C.COSTO_FOB,                     -- 54 FOB
                C.COSTO_INSP,                    -- 55 Insp
                C.COSTO_RFID,                    -- 56 RFID
                C.ROYALTY_POR,                   -- 57 Royalty
                C.COSTO_UNIT,                    -- 58 Costo Unitario Final
                C.COSTO_UNITS,                   -- 59 Costo Unitario Final Pesos
                C.CST_TOTLTARGET,                -- 60 Total Target
                C.COSTO_TOT,                     -- 61 Total FOB
                C.COSTO_TOTS,                    -- 62 Costo total pesos
                C.RETAIL,                        -- 63 Total retail pesos
                C.DEBUT_REODER,                  -- 64 Debut/reorder
                C.SEM_INI,                       -- 65 Sem ini
                C.SEM_FIN,                       -- 66 Sem fin
                C.CICLO,                         -- 67 Semanas ciclo via
                C.AGOT_OBJ,                      -- 68 Agot Obj
                C.SEMLIQ,                        -- 69 Semanas Liquidacion
                C.ALIAS_PROV,                    -- 70 Proveedor
                C.COD_PROVEEDOR,                 -- 71 Razon Social
                C.COD_TRADER,                    -- 72 Trader
                ''AFTER_MEETING_REMARKS,
                C.CODSKUPROVEEDOR,               -- 73 Cod SKU Proveedor
                O.COD_PADRE SKU,                 -- 74 Cod Padre
                C.PROFORMA,                      -- 75 Proforma
                O.ARCHIVO,                       -- 76 Archivo
                O.ESTILO_PMM,                    -- 77 Estilo Pmm
                O.ESTADO_MATCH,                  -- 78 Estado Match
                O.PO_NUMBER,                     -- 79 N OC
                O.ESTADO_OC,                     -- 80 Estado OC
                '' FECHA_ACORDADA,
                O.FECHA_EMBARQUE,                -- 81 Fecha Embarque
                O.FECHA_ETA,                     -- 82 Fecha ETA
                O.FECHA_RECEPCION,               -- 83 Fecha Recepciòn
                O.DIAS_ATRASO,                   -- 84 Dias Atraso
                convert((SELECT nom_est_c1 FROM plc_estado_c1 WHERE cod_est_c1= C.ESTADO),'utf8','us7ascii')CODESTADO,  -- 85 Estado Opcion
                C.ESTADO ESTADO_C1,              -- 86 Estado C1
                C.VENTANA_LLEGADA,               -- 87 Ventana Llegada
                REPLACE((SELECT DISTINCT FECHA_RECEPCD FROM plc_ventana_emb V WHERE V.cod_temporada = C.COD_TEMPORADA AND V.cod_ventana = C.VENT_EMB),'/','-') FECHA_RECEPCD_C1 -- 88 Fecha recepcion CD
                FROM PLC_PLAN_COMPRA_COLOR_3 C
                LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
				AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO = '" . $depto . "'
                ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER";

        $data = \database::getInstancia()->getFilas($sql);
        /*return $data;*/

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1){
            array_push($array1
                , array(
                 "ID_COLOR3"=> $va1[0]
                ,"GRUPO_COMPRA"=> $va1[1]
                ,"COD_TEMP"=> $va1[2]
                ,"LINEA"=> $va1[3]
                ,"SUBLINEA"=> $va1[4]
                ,"MARCA"=> $va1[5]
                ,"ESTILO"=> $va1[6]
                ,"SHORT_NAME"=> $va1[7]
                ,"ID_CORPORATIVO"=> $va1[8]
                ,"DESCMODELO"=> $va1[9]
                ,"DESCRIP_INTERNET"=> $va1[10]
                ,"NOMBRE_COMPRADOR"=> $va1[11]
                ,"NOMBRE_DISENADOR"=> $va1[12]
                ,"COMPOSICION"=> $va1[13]
                ,"TIPO_TELA"=> $va1[14]
                ,"FORRO"=> $va1[15]
                ,"COLECCION"=> $va1[16]
                ,"EVENTO"=> $va1[17]
                ,"COD_ESTILO_VIDA"=> $va1[18]
                ,"CALIDAD"=> $va1[19]
                ,"COD_OCASION_USO"=> $va1[20]
                ,"COD_PIRAMIX"=> $va1[21]
                ,"DESCRIPCION"=> $va1[22] //ventana
                ,"COD_RANKVTA"=> $va1[23]
                ,"LIFE_CYCLE"=> $va1[24]
                ,"NUM_EMB"=> $va1[25]
                ,"COD_COLOR"=> $va1[26]
                ,"TIPO_PRODUCTO"=> $va1[27]
                ,"TIPO_EXHIBICION"=> $va1[28]
                ,"DESTALLA"=> $va1[29]
                ,"TIPO_EMPAQUE"=> $va1[30]
                ,"PORTALLA_1_INI"=> $va1[31]
                ,"PORTALLA_1"=> $va1[32]
                ,"CURVATALLA"=> $va1[33]
                ,"CURVAMIN"=> $va1[34]
                ,"UNID_OPCION_INICIO"=> $va1[35]
                ,"UNID_OPCION_AJUSTADA"=> $va1[36]
                ,"CAN"=> $va1[37]
                ,"MTR_PACK"=> $va1[38]
                ,"CANT_INNER"=> $va1[39]
                ,"SEG_ASIG"=> $va1[40]
                ,"FORMATO"=> $va1[41]
                ,"TDAS"=> $va1[42]
                ,"A"=> $va1[43]
                ,"B"=> $va1[44]
                ,"C"=> $va1[45]
                ,"I"=> $va1[46]
                ,"UND_ASIG_INI"=> $va1[47]
                ,"ROT"=> $va1[48]
                ,"NOM_PRECEDENCIA"=> $va1[49]
                ,"NOM_VIA"=> $va1[50]
                ,"NOM_PAIS"=> $va1[51]
                ,"VIAJE"=> $va1[52]
                ,"MKUP"=> $va1[53]
                ,"PRECIO_BLANCO"=> $va1[54]
                ,"OFERTA"=> $va1[55]
                ,"GM"=> $va1[56]
                ,"COD_TIP_MON"=> $va1[57]
                ,"COSTO_TARGET"=> $va1[58]
                ,"COSTO_FOB"=> $va1[59]
                ,"COSTO_INSP"=> $va1[60]
                ,"COSTO_RFID"=> $va1[61]
                ,"ROYALTY_POR"=> $va1[62]
                ,"COSTO_UNIT"=> $va1[63]
                ,"COSTO_UNITS"=> $va1[64]
                ,"CST_TOTLTARGET"=> $va1[65]
                ,"COSTO_TOT"=> $va1[66]
                ,"COSTO_TOTS"=> $va1[67]
                ,"RETAIL"=> $va1[68]
                ,"DEBUT_REODER"=> $va1[69]
                ,"SEM_INI"=> $va1[70]
                ,"SEM_FIN"=> $va1[71]
                ,"CICLO"=> $va1[72]
                ,"AGOT_OBJ"=> $va1[73]
                ,"SEMLIQ"=> $va1[74]
                ,"ALIAS_PROV"=> $va1[75]
                ,"COD_PROVEEDOR"=> $va1[76]
                ,"COD_TRADER"=>$va1[77]
                ,"AFTER_MEETING_REMARKS"=>$va1[78]
                ,"CODSKUPROVEEDOR"=> $va1[79]
                ,"SKU"=> $va1[80]
                ,"PROFORMA"=> $va1[81]
                ,"ARCHIVO"=> $va1[82]
                ,"ESTILO_PMM"=> $va1[83]
                ,"ESTADO_MATCH"=> $va1[84]
                ,"PO_NUMBER"=> $va1[85]
                ,"ESTADO_OC"=> $va1[86]
                ,"FECHA_ACORDADA"=> $va1[87]
                ,"FECHA_EMBARQUE"=> $va1[88]
                ,"FECHA_ETA"=> $va1[89]
                ,"FECHA_RECEPCION"=> $va1[90]
                ,"DIAS_ATRASO"=> $va1[91]
                ,"CODESTADO"=> $va1[92]
                ,"ESTADO_C1"=> $va1[93]
                ,"VENTANA_LLEGADA"=> $va1[94]
                ,"FECHA_RECEPCD_C1"=> $va1[95]
                )
            );
        }


        return $array1;



    }

    public static function llenar_tabla2_telerik($temporada, $depto)
    {

        $sql = "SELECT
                C.NOM_SUBLINEA ID_COLOR3
                FROM PLC_PLAN_COMPRA_COLOR_3 C
                LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
				AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO = '" . $depto . "'
                ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function llenar_tabla2($temporada, $depto)
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
                CASE WHEN C.COMPOSICION = '0' THEN '' ELSE C.COMPOSICION END COMPOSICION, -- 11 Composicion
                CASE WHEN C.COLECCION = '0' THEN '' ELSE C.COLECCION END COLECCION,       -- 12 Colección
                C.EVENTO,                     -- 13 Evento
                CASE WHEN C.NOM_ESTILOVIDA IS NULL THEN '' ELSE C.NOM_ESTILOVIDA END COD_ESTILO_VIDA, -- 14 estilo vida
                '' CALIDAD,                      -- 15 Calidad
                C.NOM_OCACIONUSO COD_OCASION_USO,-- 16 ocacion uso
                C.NOM_PIRAMIDEMIX COD_PIRAMIX,   -- 17 piramide mix
                C.NOM_VENTANA DESCRIPCION,       -- 18 ventana
                C.NOM_RNK COD_RANKVTA,           -- 19 rank vta
                C.NOM_LIFECYCLE LIFE_CYCLE,      -- 20 ciclo vida
                C.NUM_EMB,                       -- 21 num_emb
                C.NOM_COLOR COD_COLOR,           -- 22 color
                C.TIPO_PRODUCTO,                 -- 23 Tipo Producto
                C.TIPO_EXHIBICION,               -- 24 Tipo Exhibicion
                C.DESTALLA,                      -- 25 Tallas
                C.TIPO_EMPAQUE,                  -- 26 Tipo empaque
                C.PORTALLA_1_INI,                -- 27 Compra Ini
                C.PORTALLA_1,                    -- 28 Compra Ajustada
                C.CURVATALLA,                    -- 29 Curva
                C.CURVAMIN,                      -- 30 Curva Min
                C.UNID_OPCION_INICIO,            -- 31 Uni Ini
                C.UNID_OPCION_AJUSTADA,          -- 32 Uni Ajust
                C.UNIDADES CAN,                  -- 33 Uni Final
                C.MTR_PACK,                      -- 34 Master Pack
                C.CANT_INNER,                    -- 35 Nº Cajas
                C.SEG_ASIG,                      -- 36 Cluster
                C.FORMATO,                       -- 37 Formato
                C.TDAS,                          -- 38 Tdas
                C.A ,                            -- 39 A
                C.B,                             -- 40 B
                C.C,                             -- 41 C
                C.I,                             -- 42 I
                C.UND_ASIG_INI,                  -- 43 Primera Carga
                C.ROT,                           -- 44 %Tiendas
                NOM_PRECEDENCIA,                 -- 45 Proced
                NOM_VIA,                         -- 46 Vìa
                NOM_PAIS,                        -- 47 Paìs
                C.VIAJE,                         -- 48 Viaje
                C.MKUP,                          -- 49 mkup
                C.PRECIO_BLANCO,                 -- 50 Precio Blanco
                C.GM,                            -- 51 GM
                C.NOM_MONEDA  COD_TIP_MON,       -- 52 Moneda
                C.COSTO_TARGET,                  -- 53 Target
                C.COSTO_FOB,                     -- 54 FOB
                C.COSTO_INSP,                    -- 55 Insp
                C.COSTO_RFID,                    -- 56 RFID
                C.ROYALTY_POR,                   -- 57 Royalty
                C.COSTO_UNIT,                    -- 58 Costo Unitario Final
                C.COSTO_UNITS,                   -- 59 Costo Unitario Final Pesos
                C.CST_TOTLTARGET,                -- 60 Total Target
                C.COSTO_TOT,                     -- 61 Total FOB
                C.COSTO_TOTS,                    -- 62 Costo total pesos
                C.RETAIL,                        -- 63 Total retail pesos
                C.DEBUT_REODER,                  -- 64 Debut/reorder
                C.SEM_INI,                       -- 65 Sem ini
                C.SEM_FIN,                       -- 66 Sem fin
                C.CICLO,                         -- 67 Semanas ciclo via
                C.AGOT_OBJ,                      -- 68 Agot Obj
                C.SEMLIQ,                        -- 69 Semanas Liquidacion
                --C.ALIAS_PROV,                    -- 70 Proveedor
                CASE WHEN C.ALIAS_PROV = '0' THEN '' ELSE C.ALIAS_PROV END ALIAS_PROV,                            -- 70 Proveedor
                -- C.COD_PROVEEDOR,                 -- 71 Razon Social
                CASE WHEN C.COD_PROVEEDOR = '0' THEN '' ELSE C.COD_PROVEEDOR END COD_PROVEEDOR,                   -- 71 Razon Social
                -- C.COD_TRADER,                    -- 72 Trader
                CASE WHEN C.COD_TRADER = '0' THEN '' ELSE C.COD_TRADER END COD_TRADER,                            -- 72 Trader
                --C.CODSKUPROVEEDOR,               -- 73 Cod SKU Proveedor
                CASE WHEN C.CODSKUPROVEEDOR = '0' THEN '' ELSE C.CODSKUPROVEEDOR END CODSKUPROVEEDOR,             -- 73 Cod SKU Proveedor
                O.COD_PADRE SKU,                 -- 74 Cod Padre
                --C.PROFORMA,                      -- 75 Proforma
                CASE WHEN C.PROFORMA IS NULL THEN '' WHEN C.PROFORMA = '0' THEN '' ELSE C.PROFORMA END PROFORMA,  -- 75 Proforma
                O.ARCHIVO,                       -- 76 Archivo
                O.ESTILO_PMM,                    -- 77 Estilo Pmm
                O.ESTADO_MATCH,                  -- 78 Estado Match
                O.PO_NUMBER,                     -- 79 N OC
                O.ESTADO_OC,                     -- 80 Estado OC
                O.FECHA_EMBARQUE,                -- 81 Fecha Embarque
                O.FECHA_ETA,                     -- 82 Fecha ETA
                O.FECHA_RECEPCION,               -- 83 Fecha Recepciòn
                O.DIAS_ATRASO,                   -- 84 Dias Atraso
                convert((SELECT nom_est_c1 FROM plc_estado_c1 WHERE cod_est_c1= C.ESTADO),'utf8','us7ascii')CODESTADO,  -- 85 Estado Opcion
                C.ESTADO ESTADO_C1,              -- 86 Estado C1
                C.VENTANA_LLEGADA,               -- 87 Ventana Llegada
                (SELECT DISTINCT TO_CHAR(FECHA_RECEPCD, 'dd-mm-yyyy')FECHA_RECEPCD FROM plc_ventana_emb V WHERE V.cod_temporada = C.COD_TEMPORADA AND V.cod_ventana = C.VENT_EMB) FECHA_RECEPCD_C1 -- 88 Fecha recepcion CD
                FROM PLC_PLAN_COMPRA_COLOR_3 C
                LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
				AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO = '" . $depto . "'
                ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER
                ";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;

    }

    public static function actualiza_tabla2()
    {

        $content = trim(file_get_contents("php://input"));

        $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_3 SET";
        $sql .= "ID_COLOR3 = $ID_COLOR3,";
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
        $sql .= "NOM_OCACIONUSO = $NOM_OCACIONUSO,";
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
                WHERE COD_TEMPORADA = $temporada AND DEP_DEPTO = '" . $depto . "'
                AND ID_COLOR3 = $ID_COLOR3
                ";

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;



    }


    public static function llenar_edita_grilla($temporada, $depto, $id_color3)
    {

        $sql = "SELECT
                  C.GRUPO_COMPRA,               -- 0 grupo compra        
                  C.NOM_MARCA MARCA,            -- 1 marca
                  C.NOM_LINEA LINEA,            -- 2 linea
                  C.NOM_SUBLINEA SUBLINEA,      -- 3 sublinea
                  C.DES_ESTILO ESTILO,          -- 4 estilo
                  C.SHORT_NAME,                 -- 5 estilo corto                
                  C.NOM_VENTANA,                -- 6 ventana          
                  C.NOM_COLOR COD_COLOR,        -- 7 color                
                  C.UNIDADES CAN,               -- 8 Uni Final                
                  C.COSTO_TARGET,               -- 9 Target                
                  C.COSTO_FOB,                  -- 10 FOB           
                  C.COSTO_INSP,                 -- 11 Insp
                  C.COSTO_RFID,                 -- 12 RFID
                  C.ALIAS_PROV,                 -- 13 Alias Proveedor
                  
                  -- Para los cálculos
                  C.ID_COLOR3,                  -- 14 id_color3
                  C.MKUP,                       -- 15 mkup
                  C.GM,                         -- 16 GM
                  C.VIA,                        -- 17 NOM_VIA / VIA
                  C.PAIS,                       -- 18 NOM_PAIS / PAIS
                  C.VENTANA_LLEGADA,            -- 19 ventana llegada
                  C.PRECIO_BLANCO,              -- 20 Precio Blanco
                    
                  C.TIPO_EMPAQUE,               -- 21 Tipo Embarque
                  C.FORMATO,                    -- 22 Formato
                  C.NOM_VENTANA,                -- 23 Ventana
                  C.UNID_OPCION_INICIO,         -- 24 Unid Iniciales
                  C.CURVATALLA,                 -- 25 curvatalla
                  C.DESTALLA,                   -- 26 tallas
                  C.SEG_ASIG                    -- 27 curvatalla
                  ,C.A                          -- 28 curvas a
                  ,C.B                          -- 29 curvas b
                  ,C.C                          -- 30 curvas c
                  ,C.I                          -- 31 curvas i
                  ,C.DEBUT_REODER               -- 32 DEBUT_REORDER
                  ,C.PORTALLA_1_INI             -- 33 PORTALLA_1_INI
                  ,C.COD_MARCA                  -- 34 COD_MARCA  
                  ,C.N_CURVASXCAJAS             -- 35 N_CURVASXCAJAS
                  ,C.COD_JER2                   -- 36 cod_linea
                  ,C.COD_SUBLIN                 -- 37 cod_sublin
                  
            FROM PLC_PLAN_COMPRA_COLOR_3 C
            LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
            AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
            WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO = '" . $depto . "'
            AND C.ID_COLOR3 IN ($id_color3)
            ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER
            ";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;

    }

    public static function llenar_tabla_depto($temporada)
    {

        $sql = "begin PLC_PKG_DESARROLLO.PRC_LISTDEPTXTEMP(" . $temporada . ", :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;
    }

    public static function llenar_tabla_oc($temporada)
    {

        $sql = "begin PLC_PKG_DESARROLLO.PRC_LISTAR_ESTADOS(" . $temporada . ", :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        array_pop($data);
        return $data;
    }


    // Parte 2 Tabla 1
    public static function listar_consumo($temporada, $depto)
    {

        $sql = "SELECT PERIODO VENTANA
                      ,SUM(COSTO) COSTO
                      ,SUM(VTA_CDSCTO) RETAIL
                FROM plc_plan_compra_color_CIC A
                WHERE A.cod_temporada = $temporada
                AND A.dep_depto = '" . $depto . "'
                GROUP BY PERIODO
                ";

        $data = \database::getInstancia()->getFilas($sql);

        //return $data;

        $json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;

    }

    // Actualizo Proforma y Estado en plc_plan_compra_color_3 (Se envió Archivo + Proforma)
    public static function actualizaProformaEstado($temporada, $depto, $proforma, $id_color, $login)
    {

        $sql = "UPDATE plc_plan_compra_color_3
                SET proforma = '" . $proforma . "',
                estado = 18
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND id_color3 IN ($id_color)
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-1d3ACTESTADOYPROFORMA--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);


        $data = \database::getInstancia()->getConsulta($sql);

        return $data;

    }

    // Guardar Historial en plc_plan_compra_historica (Se envió Archivo + Proforma)
    public static function guardaHistorial($temporada, $depto, $ids_insertar, $login)
    {

        $sql = "INSERT INTO plc_plan_compra_historica (temp,dpto,linea,sublinea,marca,estilo,ventana,color,user_login,user_nom,fecha,hora,pi,oc,estado,id_color3,nom_linea,nom_sublinea,nom_marca,nom_ventana,nom_color)
                SELECT
                      C.COD_TEMPORADA,
                      C.DEP_DEPTO,
                      C.COD_JER2 LINEA,         -- linea
                      C.COD_SUBLIN SUBLINEA,    -- sublinea
                      C.COD_MARCA,              -- marca
                      C.DES_ESTILO ESTILO,      -- estilo
                      C.VENTANA_LLEGADA,        -- Ventana
                      NVL(COD_COLOR,0)COLOR,    -- Color
                      '" . $login . "',
                      (SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "'),
                      (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                      (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                      C.PROFORMA,
                      O.PO_NUMBER,
                      C.ESTADO,
                      C.ID_COLOR3,
                      C.NOM_LINEA LINEA,
                      C.NOM_SUBLINEA SUBLINEA,
                      C.NOM_MARCA MARCA,
                      C.NOM_VENTANA VENTANA,
                      C.NOM_COLOR COD_COLOR
                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                      LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                      AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                AND C.ID_COLOR3 IN ($ids_insertar)
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-2d3ARCHIVOYPROFORMAHISTORIAL--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);

        return $data;

    }

    // Guardar en OC plc_plan_compra_oc (Se envió Archivo + Proforma)
    public static function guardaOc($temporada, $depto, $id_color, $archivo_proforma, $login)
    {

        $sql = "INSERT INTO plc_plan_compra_oc (cod_temporada,dep_depto,niv_jer1,cod_jer1,niv_jer2,cod_jer2,item,cod_sublin,cod_estilo,des_estilo,vent_emb,proforma,archivo,id_color3, estado_oc,estilo_pmm)
                SELECT
                      C.COD_TEMPORADA,
                      C.DEP_DEPTO,
                      0 NJ1,
                      0 CJ1,
                      0 NJ2,
                      C.COD_JER2,
                      0 ITEM,
                      C.COD_SUBLIN,
                      0 COD_ESTILO,
                      C.DES_ESTILO,
                      C.VENTANA_LLEGADA,
                      '" . $archivo_proforma . "',
                      'Cargado..' ARCHIVO,
                      C.ID_COLOR3,
                      '' Estado_oc,
                      '' estilo_pmm
                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                      LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                      AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                AND C.ID_COLOR3 IN ($id_color)
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-3d3ARCHIVOYPROFORMAGUARDAOC--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }

    // Guardar Solo Proforma
    public static function guarda_solo_proforma($temporada, $depto, $login, $proforma, $id_insertar)
    {

        $sql = "UPDATE plc_plan_compra_color_3
                SET proforma = '" . $proforma . "'
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND id_color3 = $id_insertar
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-ACTUALIZASOLOPROFORMA--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        //return $data;

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Guardar Solo Proforma Extra (Las Proformas ingresadas luego de guardar, proforma, archivo y/o cambios de estados)
    public static function guarda_solo_proforma_extra($temporada, $depto, $login, $proforma, $id_insertar)
    {

        $sql = "UPDATE plc_plan_compra_color_3
                SET proforma = '" . $proforma . "',
                estado = 18
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND id_color3 = $id_insertar
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-ACTSOLOPROFORMAEXTRA--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        //return $data;

        // Si puede actualizar ejecuto la otra consulta
        if ($data) {


            $sql = "INSERT INTO plc_plan_compra_oc (cod_temporada,dep_depto,niv_jer1,cod_jer1,niv_jer2,cod_jer2,item,cod_sublin,cod_estilo,des_estilo,vent_emb,proforma,archivo,id_color3, estado_oc,estilo_pmm)
                SELECT
                      C.COD_TEMPORADA,
                      C.DEP_DEPTO,
                      0 NJ1,
                      0 CJ1,
                      0 NJ2,
                      C.COD_JER2,
                      0 ITEM,
                      C.COD_SUBLIN,
                      0 COD_ESTILO,
                      C.DES_ESTILO,
                      C.VENTANA_LLEGADA,
                      '" . $proforma . "',
                      'Cargado..' ARCHIVO,
                      C.ID_COLOR3,
                      '' Estado_oc,
                      '' estilo_pmm
                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                      LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                      AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                AND C.ID_COLOR3 IN ($id_insertar)
                ";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql;
            $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-ACTSOLOPROFORMAEXTRAPLAN_COMPRA_OC_--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data = \database::getInstancia()->getConsulta($sql);
            //return $data;

            if ($data) {
                return 1;
            } else {
                return 0;
            }


        } else {
            return 0;
        }

    }

    // Actualiza Historial
    public static function actualiza_historial($temporada, $depto, $login, $proforma, $id_insertar)
    {

        $sql = "UPDATE plc_plan_compra_historica
                SET PI = '" . $proforma . "'
                WHERE TEMP = $temporada
                AND DPTO = '" . $depto . "'
                AND id_color3 = $id_insertar
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-ACTUALIZAPROFORMAHISTORIAL--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        //return $data;

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Actualiza Estado Opcion según estado OC PMM
    public static function actualiza_estado_oc_segun_ocpmm($temporada, $depto, $login, $pi, $id_color3, $estado)
    {

        // $sql = "begin PLC_PKG_UTILS.PRC_ESTADO_OCPMM($temporada,'".$depto."', :error, :data); end;"; (Contra PMM)
        $sql = "begin PLC_PKG_UTILS.PRC_ESTADO_OCPMM_2($temporada,'" . $depto . "','" . $pi . "',$id_color3,'" . $estado . "', :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2ESTADO20a21-ACTESTADOCSEGUNPMM_BROKER--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;

    }


    // Trabajo con Flujo de Aprobación Insert
    public static function trabaja_flujo_aprobacion_insert($temporada, $depto, $login, $id_coloor3, $estado)
    {

        $sql = "INSERT INTO PLC_PLAN_COMPRA_HISTORICA (DPTO,LINEA,SUBLINEA,MARCA,ESTILO,VENTANA,COLOR,USER_LOGIN,USER_NOM,FECHA,HORA,PI,OC,ESTADO,TEMP,ID_COLOR3,NOM_LINEA,NOM_MARCA,NOM_VENTANA,NOM_COLOR,NOM_SUBLINEA)
                SELECT
                        C.DEP_DEPTO,
                        C.COD_JER2 LINEA,         -- linea
                        C.COD_SUBLIN SUBLINEA,    -- sublinea
                        C.COD_MARCA,              -- marca
                        C.DES_ESTILO ESTILO,      -- estilo
                        C.VENTANA_LLEGADA,        -- Ventana
                        NVL(COD_COLOR,0)COLOR,    -- Color
                        '" . $login . "',
                        (SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "'),
                        (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                        (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                        C.PROFORMA,
                        O.PO_NUMBER,
                        $estado,
                        C.COD_TEMPORADA,
                        C.ID_COLOR3,
                        C.NOM_LINEA LINEA,
                        C.NOM_MARCA MARCA,
                        C.NOM_VENTANA VENTANA,
                        C.NOM_COLOR COD_COLOR,
                        C.NOM_SUBLINEA SUBLINEA
                        FROM PLC_PLAN_COMPRA_COLOR_3 C
                        LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                        AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                  WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                  AND C.ID_COLOR3 IN ($id_coloor3)
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-FLUJOHISTORIALINSERT--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }

    // Trabajo con Flujo de Aprobación Update
    public static function trabaja_flujo_aprobacion_update($temporada, $depto, $login, $proforma, $estado)
    {

        $sql = "begin PLC_PKG_UTILS.PRC_SOLOC($temporada,'" . $depto . "','" . $proforma . "',$estado, :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-FLUJOHISTORIALUPDATE--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;

    }

    // Trabajo con Flujo Dinámico de Aprobación
    public static function trabaja_flujo_aprobacion_dinamico($temporada, $depto, $login, $id_color3, $estado_insert, $proforma, $estado_update)
    {

        $sql_insert = "INSERT INTO PLC_PLAN_COMPRA_HISTORICA (DPTO,LINEA,SUBLINEA,MARCA,ESTILO,VENTANA,COLOR,USER_LOGIN,USER_NOM,FECHA,HORA,PI,OC,ESTADO,TEMP,ID_COLOR3,NOM_LINEA,NOM_MARCA,NOM_VENTANA,NOM_COLOR,NOM_SUBLINEA)
                SELECT
                        C.DEP_DEPTO,
                        C.COD_JER2 LINEA,         -- linea
                        C.COD_SUBLIN SUBLINEA,    -- sublinea
                        C.COD_MARCA,              -- marca
                        C.DES_ESTILO ESTILO,      -- estilo
                        C.VENTANA_LLEGADA,        -- Ventana
                        NVL(COD_COLOR,0)COLOR,    -- Color
                        '" . $login . "',
                        (SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "'),
                        (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                        (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                        C.PROFORMA,
                        O.PO_NUMBER,
                        $estado_insert,
                        C.COD_TEMPORADA,
                        C.ID_COLOR3,
                        C.NOM_LINEA LINEA,
                        C.NOM_MARCA MARCA,
                        C.NOM_VENTANA VENTANA,
                        C.NOM_COLOR COD_COLOR,
                        C.NOM_SUBLINEA SUBLINEA
                        FROM PLC_PLAN_COMPRA_COLOR_3 C
                        LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                        AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                  WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                  AND C.ID_COLOR3 = $id_color3
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql_insert;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-FLUJOHISTORIALINSERT--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        // Ejecuto la query
        $data_insert = \database::getInstancia()->getConsulta($sql_insert);

        // Si se ejecuta la consulta
        if ($data_insert) {

            $sql_update = "begin PLC_PKG_UTILS.PRC_SOLOC($temporada,'" . $depto . "','" . $proforma . "',$estado_update, :error, :data); end;";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_update;
            $fp = fopen("../archivos/log_querys/" . $login . "/GRILLA2-FLUJOHISTORIALUPDATE--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data_update = \database::getInstancia()->getConsultaSP($sql_update, 2);

            if ($data_update) {
                return "OK";
            } else {
                return "ERROR";
            }

            // Si la consulta no se puede realizar
        } else {
            return "ERROR";
        }

        // Fin de la clase
    }

    public static function Update_flujo_estado_oc_vist($temporada, $depto, $estado, $login, $po_number, $proforma,$estado_oc)
    {

     if ($estado == 20){
         //actualiza el estado color3 en 21 (aprobado)
         $sql = "update plc_plan_compra_color_3
                    set estado = 21
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and PROFORMA = '" . $proforma . "'";
         \database::getInstancia()->getConsulta($sql);

         //dt id_color actualizar para historial
         $sql = "select distinct id_color3 from plc_plan_compra_color_3
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and PROFORMA = '" . $proforma . "'";
         $id_color3s = \database::getInstancia()->getFilas($sql);

                $sql = "update plc_plan_compra_oc
                   set estado_oc = '" . $estado_oc . "'
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and PROFORMA = '" . $proforma . "'";

         if (!file_exists('../archivos/log_querys/' . $login)) {
             mkdir('../archivos/log_querys/' . $login, 0775, true);
         }
         $stamp = date("Y-m-d_H-i-s");
         $rand = rand(1, 999);
         $content = $sql;
         $fp = fopen("../archivos/log_querys/" . $login . "/update20oc--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
         fwrite($fp, $content);
         fclose($fp);
                \database::getInstancia()->getConsulta($sql);

         foreach ($id_color3s as $val) {
             $id_color3 = $val['ID_COLOR3'];
             $sql_insert = "INSERT INTO PLC_PLAN_COMPRA_HISTORICA (DPTO,LINEA,SUBLINEA,MARCA,ESTILO,VENTANA,COLOR,USER_LOGIN,USER_NOM,FECHA,HORA,PI,OC,ESTADO,TEMP,ID_COLOR3,NOM_LINEA,NOM_MARCA,NOM_VENTANA,NOM_COLOR,NOM_SUBLINEA)
                                    SELECT C.DEP_DEPTO,
                                            C.COD_JER2 LINEA,         -- linea
                                            C.COD_SUBLIN SUBLINEA,    -- sublinea
                                            C.COD_MARCA,              -- marca
                                            C.DES_ESTILO ESTILO,      -- estilo
                                            C.VENTANA_LLEGADA,        -- Ventana
                                            NVL(COD_COLOR,0)COLOR,    -- Color
                                            '" . $login . "',
                                            (SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "'),
                                            (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                                            (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                                            C.PROFORMA,
                                            $po_number,
                                            21,
                                            C.COD_TEMPORADA,
                                            C.ID_COLOR3,
                                            C.NOM_LINEA LINEA,
                                            C.NOM_MARCA MARCA,
                                            C.NOM_VENTANA VENTANA,
                                            C.NOM_COLOR COD_COLOR,
                                            C.NOM_SUBLINEA SUBLINEA
                                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                                      WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                                      AND C.ID_COLOR3 = $id_color3";
             \database::getInstancia()->getConsulta($sql_insert);
         }
     }
     elseif($estado == 18 or $estado == 19 or $estado == 22){
        //actualiza el estado color3 en 19 (pendiente de aprobacion sin match)
        $sql = "update plc_plan_compra_color_3
                    set estado = 19
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and PROFORMA = '" . $proforma . "'";
        \database::getInstancia()->getConsulta($sql);

        if ($estado <> 19) {
            //dt id_color actualizar para historial
            $sql = "select distinct id_color3 from plc_plan_compra_color_3
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and PROFORMA = '" . $proforma . "'";
            $id_color3s = \database::getInstancia()->getFilas($sql);
            //insert historial
            foreach ($id_color3s as $val) {
                $id_color3 = $val['ID_COLOR3'];
                $count = 0;
                if ($estado == 18) {
                    $count = 2;
                } else {
                    $count = 1;
                };
                for ($i = 1; $i <= $count; $i++) {
                    $estadofor = 0;
                    if ($i == 1) {
                        $estadofor = 22;
                    } else {
                        $estadofor = 19;
                    };
                    $sql_insert = "INSERT INTO PLC_PLAN_COMPRA_HISTORICA (DPTO,LINEA,SUBLINEA,MARCA,ESTILO,VENTANA,COLOR,USER_LOGIN,USER_NOM,FECHA,HORA,PI,OC,ESTADO,TEMP,ID_COLOR3,NOM_LINEA,NOM_MARCA,NOM_VENTANA,NOM_COLOR,NOM_SUBLINEA)
                                    SELECT C.DEP_DEPTO,
                                            C.COD_JER2 LINEA,         -- linea
                                            C.COD_SUBLIN SUBLINEA,    -- sublinea
                                            C.COD_MARCA,              -- marca
                                            C.DES_ESTILO ESTILO,      -- estilo
                                            C.VENTANA_LLEGADA,        -- Ventana
                                            NVL(COD_COLOR,0)COLOR,    -- Color
                                            '" . $login . "',
                                            (SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "'),
                                            (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                                            (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                                            C.PROFORMA,
                                            $po_number,
                                            $estadofor,
                                            C.COD_TEMPORADA,
                                            C.ID_COLOR3,
                                            C.NOM_LINEA LINEA,
                                            C.NOM_MARCA MARCA,
                                            C.NOM_VENTANA VENTANA,
                                            C.NOM_COLOR COD_COLOR,
                                            C.NOM_SUBLINEA SUBLINEA
                                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                                      WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                                      AND C.ID_COLOR3 = $id_color3";
                    \database::getInstancia()->getConsulta($sql_insert);
                }
            }
        } else {
            $sql = "update plc_plan_compra_oc
                   set po_number = NULL
                       ,estado_oc = NULL
                       ,fecha_embarque = NULL
                       ,fecha_eta = NULL
                       ,fecha_recepcion = NULL
                       ,dias_atraso = NULL
                       ,COD_PADRE = NULL
                       ,ESTADO_MATCH = NULL
                       ,ESTILO_PMM = NULL
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and PROFORMA = '" . $proforma . "'";

            \database::getInstancia()->getConsulta($sql);
        }
       }
     elseif($estado == 21){

         //dt id_color actualizar
         $sql = "select distinct id_color3 from plc_plan_compra_oc
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and po_number = '" . $po_number . "'";
         $id_color3s = \database::getInstancia()->getFilas($sql);

         if (count($id_color3s)> 0){
             $ids = "";
             foreach ($id_color3s as $val) {
                 $ids = $ids.$val['ID_COLOR3'].",";
    }
             $ids = substr ($ids, 0, -1);

             //actualiza el estado color3 en 0 (ingresado)
             $sql = "update plc_plan_compra_color_3
                    set estado = 0
                        ,proforma = null
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and id_color3 in(" . $ids . ")";
             \database::getInstancia()->getConsulta($sql);

             //insert historial
             $sql_insert = "INSERT INTO PLC_PLAN_COMPRA_HISTORICA (DPTO,LINEA,SUBLINEA,MARCA,ESTILO,VENTANA,COLOR,USER_LOGIN,USER_NOM,FECHA,HORA,PI,OC,ESTADO,TEMP,ID_COLOR3,NOM_LINEA,NOM_MARCA,NOM_VENTANA,NOM_COLOR,NOM_SUBLINEA)
                                    SELECT C.DEP_DEPTO,
                                            C.COD_JER2 LINEA,         -- linea
                                            C.COD_SUBLIN SUBLINEA,    -- sublinea
                                            C.COD_MARCA,              -- marca
                                            C.DES_ESTILO ESTILO,      -- estilo
                                            C.VENTANA_LLEGADA,        -- Ventana
                                            NVL(COD_COLOR,0)COLOR,    -- Color
                                            '" . $login . "',
                                            'OC=" . $po_number . "',
                                            (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                                            (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                                            C.PROFORMA,
                                            $po_number,
                                            25,
                                            C.COD_TEMPORADA,
                                            C.ID_COLOR3,
                                            C.NOM_LINEA LINEA,
                                            C.NOM_MARCA MARCA,
                                            C.NOM_VENTANA VENTANA,
                                            C.NOM_COLOR COD_COLOR,
                                            C.NOM_SUBLINEA SUBLINEA
                                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                                      WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                                      AND C.ID_COLOR3 IN (".$ids.")";
             \database::getInstancia()->getConsulta($sql_insert);


            //borramos la  compra_oc
             $sql = "delete plc_plan_compra_oc
                    where cod_temporada = " . $temporada . "
                    and dep_depto =  '" . $depto . "'
                    and id_color3 in(" . $ids . ")";;
             \database::getInstancia()->getConsulta($sql);
         }
     }
    }

    // Listar el coemntario de la PI que se solcititò modificar
    public static function busca_comentario_pi($temporada, $depto, $login, $pi)
    {

        $sql = "SELECT ERROR_PI,proforma
                FROM PLC_PLAN_COMPRA_COLOR_3
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND proforma = '" . $pi . "'
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }


    // Buscar si la OC esta con estado 20/21 en PLC_PLAN_COMPRA_COLOR_3
    public static function busca_existe_proforma($temporada, $depto, $login, $pi)
    {

        $sql = "SELECT PROFORMA FROM PLC_PLAN_COMPRA_COLOR_3
                WHERE COD_TEMPORADA = $temporada
                AND DEP_DEPTO = '" . $depto . "'
                AND PROFORMA = '" . $pi . "'
                AND ESTADO IN (20,21)
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }


    // Buscar si existe archivo en PLC_PLAN_COMPRA_OC
    public static function busca_existe_archivo($temporada, $depto, $login, $pi)
    {

        $sql = "SELECT 1 FROM PLC_PLAN_COMPRA_OC
                WHERE COD_TEMPORADA = $temporada
                AND DEP_DEPTO = '" . $depto . "'
                AND PROFORMA = '" . $pi . "'
                AND ROWNUM <= 1
                ";

        $data = \database::getInstancia()->getFilas($sql);
        //return $data;

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Llenar Tabla llenar_tabla_historial (POPUP de la Grilla)
    public static function llenar_tabla_historial($temporada, $depto, $id_color3)
    {

        $sql = "select   NVL(A.FECHA,''),
                         NVL(A.HORA,''),
                         A.USER_NOM USUARIO,
                         --B.NOM_EST_C1 ESTADO
                         convert(REPLACE(REPLACE(INITCAP(B.NOM_EST_C1),CHR(10),''),CHR(13),''),'utf8','us7ascii') ESTADO
                FROM plc_plan_compra_historica A
                LEFT JOIN PLC_ESTADO_C1 B ON A.ESTADO = B.COD_EST_C1
                WHERE  A.dpto = '" . $depto . "'
                AND    A.TEMP = $temporada
                AND    A.ID_COLOR3 = $id_color3
                ORDER BY A.FECHA, A.HORA ASC
     ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Llenar Tabla llenar_tabla_historial (POPUP de la Grilla)
    public static function traer_datos_oc($temporada, $depto, $pi, $puerto, $url)
    {

        /*$sql = " SELECT  sts.pmg_stat_name      Nom_Estado
                    ,M.PMG_PO_NUMBER        N_OC
                    ,M.ECV_NIPI             N_PI
                    ,m.fecha_ini_embarque   Fecha_Embarque_pmm
                    ,m.fecha_eta            Fecha_Eta
                    ,fecha_eta+15           fecha_recepcion
                    ,c.vent_emb vent_emb
                    ,c.ventana_llegada  ventana_llegada
                    ,e.fecha_recepcd as fecha_recepcd_c1
                    ,((fecha_eta+15)- e.fecha_recepcd) dias
                   FROM rpypcree m
                   LEFT JOIN  pmghdree hdr on  m.pmg_po_number= hdr.PMG_PO_NUMBER
                   LEFT JOIN pmgstscd sts on sts.pmg_stat_code = hdr.pmg_stat_code
                   LEFT JOIN PLC_PLAN_COMPRA_COLOR_3 C on C.PROFORMA = M.ECV_NIPI
                   inner JOIN plc_ventana_emb e on e.cod_ventana = c.vent_emb
                                              and e.cod_temporada = c.cod_temporada
                   WHERE sts.pmg_stat_code <> 7
                   AND C.COD_TEMPORADA =  $temporada
                   AND C.DEP_DEPTO =  '".$depto."'
                   AND C.PROFORMA <> '0'
                   AND sts.pmg_stat_name <> 'Cancelada'
                   GROUP BY sts.pmg_stat_name,M.PMG_PO_NUMBER,M.ECV_NIPI,m.fecha_ini_embarque,m.fecha_eta,fecha_eta+15,c.vent_emb,c.ventana_llegada,e.fecha_recepcd
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;*/

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => $puerto,
            CURLOPT_URL => $url . "/consultaOrdenComprarst/v1/consultaOrdenCompra",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            //CURLOPT_POSTFIELDS => "{\n\t\"HeaderRply\": {\n\t\t\"servicio\": {\n\t\t\t\"nombreServicio\": \"string\",\n\t\t\t\"operacion\": \"string\",\n\t\t\t\"idTransaccion\": \"string\",\n\t\t\t\"tipoMensaje\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\",\n\t\t\t\"usuario\": \"string\",\n\t\t\t\"dominioPais\": \"string\",\n\t\t\t\"ipOrigen\": \"string\",\n\t\t\t\"servidor\": \"string\",\n\t\t\t\"timeStamp\": \"string\"\n\t\t},\n\t\t\"paginacion\": {\n\t\t\t\"numPagina\": \"string\",\n\t\t\t\"cantidadRegistros\": \"string\",\n\t\t\t\"totalRegistros\": \"string\"\n\t\t},\n\t\t\"track\": {\n\t\t\t\"idTrack\": \"string\",\n\t\t\t\"codSistema\": \"string\",\n\t\t\t\"codAplicacion\": \"string\",\n\t\t\t\"componente\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"dataLogger\": \"string\",\n\t\t\t\"flagTracking\": \"string\",\n\t\t\t\"flagLog\": \"string\"\n\t\t},\n\t\t\"error\": [\n\t\t\t{\n\t\t\t\t\"errorCode\": \"string\",\n\t\t\t\t\"errorGlosa\": \"string\"\n\t\t\t}\n\t\t],\n\t\t\"reproceso\": {\n\t\t\t\"countReproceso\": \"string\",\n\t\t\t\"intervaloReintento\": \"string\",\n\t\t\t\"objetoReproceso\": \"string\"\n\t\t},\n\t\t\"filler\": \"string\"\n\t},\n\t\"Body\": {\n\t\t\"headerServicio\": {\n\t\t\t\"version\": \"string\",\n\t\t\t\"canal\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"comercio\": \"string\",\n\t\t\t\"fecha\": \"string\",\n\t\t\t\"hora\": \"string\",\n\t\t\t\"nroTransaccion\": \"string\",\n\t\t\t\"sucursal\": \"string\",\n\t\t\t\"terminal\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\",\n\t\t\t\"codigoUsusario\": \"string\",\n\t\t\t\"entidad\": \"string\",\n\t\t\t\"dominioPais\": \"string\"\n\t\t},\n\t\t\"ordenCompra\": \"".$po."\",\n\t\t\"numeroPI\": \"".$pi."\"\n\t}\n}",
            CURLOPT_POSTFIELDS => "{
               \"HeaderRply\": {
                              \"servicio\": {
                                            \"nombreServicio\": \"string\",
                                            \"operacion\": \"string\",
                                            \"idTransaccion\": \"string\",
                                            \"tipoMensaje\": \"string\",
                                            \"tipoTransaccion\": \"string\",
                                            \"usuario\": \"string\",
                                            \"dominioPais\": \"string\",
                                            \"ipOrigen\": \"string\",
                                            \"servidor\": \"string\",
                                            \"timeStamp\": \"string\"
                              },
                              \"paginacion\": {
                                            \"numPagina\": \"string\",
                                            \"cantidadRegistros\": \"string\",
                                            \"totalRegistros\": \"string\"
                              },
                              \"track\": {
                                            \"idTrack\": \"string\",
                                            \"codSistema\": \"string\",
                                            \"codAplicacion\": \"string\",
                                            \"componente\": \"string\",
                                            \"estado\": \"string\",
                                            \"dataLogger\": \"string\",
                                            \"flagTracking\": \"string\",
                                            \"flagLog\": \"string\"
                              },
                              \"error\": [
                                            {
                                                           \"errorCode\": \"string\",
                                                           \"errorGlosa\": \"string\"
                                            }
                              ],
                              \"reproceso\": {
                                            \"countReproceso\": \"string\",
                                            \"intervaloReintento\": \"string\",
                                            \"objetoReproceso\": \"string\"
                              },
                              \"filler\": \"string\"
               },
               \"Body\": {
                              \"headerServicio\": {
                                            \"version\": \"string\",
                                            \"canal\": \"string\",
                                            \"estado\": \"string\",
                                            \"comercio\": \"string\",
                                            \"fecha\": \"string\",
                                            \"hora\": \"string\",
                                            \"nroTransaccion\": \"string\",
                                            \"sucursal\": \"string\",
                                            \"terminal\": \"string\",
                                            \"tipoTransaccion\": \"string\",
                                            \"codigoUsusario\": \"string\",
                                            \"entidad\": \"string\",
                                            \"dominioPais\": \"string\"
                              },
                              \"ordenCompra\": \"0\",
                              \"numeroPI\": \"" . $pi . "\"
               }
}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }


    }

    //extraer datos orden de compra poc OC o PI
    public static function traer_datos_oc_2($pi,$oc,$puerto,$url){
        $curl = curl_init();

        if ($pi <> ""){
            curl_setopt_array($curl, array(
                CURLOPT_PORT => $puerto,
                CURLOPT_URL => $url . "/consultaOrdenComprarst/v1/consultaOrdenCompra",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                //CURLOPT_POSTFIELDS => "{\n\t\"HeaderRply\": {\n\t\t\"servicio\": {\n\t\t\t\"nombreServicio\": \"string\",\n\t\t\t\"operacion\": \"string\",\n\t\t\t\"idTransaccion\": \"string\",\n\t\t\t\"tipoMensaje\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\",\n\t\t\t\"usuario\": \"string\",\n\t\t\t\"dominioPais\": \"string\",\n\t\t\t\"ipOrigen\": \"string\",\n\t\t\t\"servidor\": \"string\",\n\t\t\t\"timeStamp\": \"string\"\n\t\t},\n\t\t\"paginacion\": {\n\t\t\t\"numPagina\": \"string\",\n\t\t\t\"cantidadRegistros\": \"string\",\n\t\t\t\"totalRegistros\": \"string\"\n\t\t},\n\t\t\"track\": {\n\t\t\t\"idTrack\": \"string\",\n\t\t\t\"codSistema\": \"string\",\n\t\t\t\"codAplicacion\": \"string\",\n\t\t\t\"componente\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"dataLogger\": \"string\",\n\t\t\t\"flagTracking\": \"string\",\n\t\t\t\"flagLog\": \"string\"\n\t\t},\n\t\t\"error\": [\n\t\t\t{\n\t\t\t\t\"errorCode\": \"string\",\n\t\t\t\t\"errorGlosa\": \"string\"\n\t\t\t}\n\t\t],\n\t\t\"reproceso\": {\n\t\t\t\"countReproceso\": \"string\",\n\t\t\t\"intervaloReintento\": \"string\",\n\t\t\t\"objetoReproceso\": \"string\"\n\t\t},\n\t\t\"filler\": \"string\"\n\t},\n\t\"Body\": {\n\t\t\"headerServicio\": {\n\t\t\t\"version\": \"string\",\n\t\t\t\"canal\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"comercio\": \"string\",\n\t\t\t\"fecha\": \"string\",\n\t\t\t\"hora\": \"string\",\n\t\t\t\"nroTransaccion\": \"string\",\n\t\t\t\"sucursal\": \"string\",\n\t\t\t\"terminal\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\",\n\t\t\t\"codigoUsusario\": \"string\",\n\t\t\t\"entidad\": \"string\",\n\t\t\t\"dominioPais\": \"string\"\n\t\t},\n\t\t\"ordenCompra\": \"".$po."\",\n\t\t\"numeroPI\": \"".$pi."\"\n\t}\n}",
                CURLOPT_POSTFIELDS => "{
               \"HeaderRply\": {
                              \"servicio\": {
                                            \"nombreServicio\": \"string\",
                                            \"operacion\": \"string\",
                                            \"idTransaccion\": \"string\",
                                            \"tipoMensaje\": \"string\",
                                            \"tipoTransaccion\": \"string\",
                                            \"usuario\": \"string\",
                                            \"dominioPais\": \"string\",
                                            \"ipOrigen\": \"string\",
                                            \"servidor\": \"string\",
                                            \"timeStamp\": \"string\"
                              },
                              \"paginacion\": {
                                            \"numPagina\": \"string\",
                                            \"cantidadRegistros\": \"string\",
                                            \"totalRegistros\": \"string\"
                              },
                              \"track\": {
                                            \"idTrack\": \"string\",
                                            \"codSistema\": \"string\",
                                            \"codAplicacion\": \"string\",
                                            \"componente\": \"string\",
                                            \"estado\": \"string\",
                                            \"dataLogger\": \"string\",
                                            \"flagTracking\": \"string\",
                                            \"flagLog\": \"string\"
                              },
                              \"error\": [
                                            {
                                                           \"errorCode\": \"string\",
                                                           \"errorGlosa\": \"string\"
                                            }
                              ],
                              \"reproceso\": {
                                            \"countReproceso\": \"string\",
                                            \"intervaloReintento\": \"string\",
                                            \"objetoReproceso\": \"string\"
                              },
                              \"filler\": \"string\"
               },
               \"Body\": {
                              \"headerServicio\": {
                                            \"version\": \"string\",
                                            \"canal\": \"string\",
                                            \"estado\": \"string\",
                                            \"comercio\": \"string\",
                                            \"fecha\": \"string\",
                                            \"hora\": \"string\",
                                            \"nroTransaccion\": \"string\",
                                            \"sucursal\": \"string\",
                                            \"terminal\": \"string\",
                                            \"tipoTransaccion\": \"string\",
                                            \"codigoUsusario\": \"string\",
                                            \"entidad\": \"string\",
                                            \"dominioPais\": \"string\"
                              },
                              \"ordenCompra\": \"0\",
                              \"numeroPI\": \"" . $pi . "\"
               }
}",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
            ));
        }
        else{
            curl_setopt_array($curl, array(
                CURLOPT_PORT => $puerto,
                CURLOPT_URL => $url . "/consultaOrdenComprarst/v1/consultaOrdenCompra",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                //CURLOPT_POSTFIELDS => "{\n\t\"HeaderRply\": {\n\t\t\"servicio\": {\n\t\t\t\"nombreServicio\": \"string\",\n\t\t\t\"operacion\": \"string\",\n\t\t\t\"idTransaccion\": \"string\",\n\t\t\t\"tipoMensaje\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\",\n\t\t\t\"usuario\": \"string\",\n\t\t\t\"dominioPais\": \"string\",\n\t\t\t\"ipOrigen\": \"string\",\n\t\t\t\"servidor\": \"string\",\n\t\t\t\"timeStamp\": \"string\"\n\t\t},\n\t\t\"paginacion\": {\n\t\t\t\"numPagina\": \"string\",\n\t\t\t\"cantidadRegistros\": \"string\",\n\t\t\t\"totalRegistros\": \"string\"\n\t\t},\n\t\t\"track\": {\n\t\t\t\"idTrack\": \"string\",\n\t\t\t\"codSistema\": \"string\",\n\t\t\t\"codAplicacion\": \"string\",\n\t\t\t\"componente\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"dataLogger\": \"string\",\n\t\t\t\"flagTracking\": \"string\",\n\t\t\t\"flagLog\": \"string\"\n\t\t},\n\t\t\"error\": [\n\t\t\t{\n\t\t\t\t\"errorCode\": \"string\",\n\t\t\t\t\"errorGlosa\": \"string\"\n\t\t\t}\n\t\t],\n\t\t\"reproceso\": {\n\t\t\t\"countReproceso\": \"string\",\n\t\t\t\"intervaloReintento\": \"string\",\n\t\t\t\"objetoReproceso\": \"string\"\n\t\t},\n\t\t\"filler\": \"string\"\n\t},\n\t\"Body\": {\n\t\t\"headerServicio\": {\n\t\t\t\"version\": \"string\",\n\t\t\t\"canal\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"comercio\": \"string\",\n\t\t\t\"fecha\": \"string\",\n\t\t\t\"hora\": \"string\",\n\t\t\t\"nroTransaccion\": \"string\",\n\t\t\t\"sucursal\": \"string\",\n\t\t\t\"terminal\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\",\n\t\t\t\"codigoUsusario\": \"string\",\n\t\t\t\"entidad\": \"string\",\n\t\t\t\"dominioPais\": \"string\"\n\t\t},\n\t\t\"ordenCompra\": \"".$po."\",\n\t\t\"numeroPI\": \"".$pi."\"\n\t}\n}",
                CURLOPT_POSTFIELDS => "{
               \"HeaderRply\": {
                              \"servicio\": {
                                            \"nombreServicio\": \"string\",
                                            \"operacion\": \"string\",
                                            \"idTransaccion\": \"string\",
                                            \"tipoMensaje\": \"string\",
                                            \"tipoTransaccion\": \"string\",
                                            \"usuario\": \"string\",
                                            \"dominioPais\": \"string\",
                                            \"ipOrigen\": \"string\",
                                            \"servidor\": \"string\",
                                            \"timeStamp\": \"string\"
                              },
                              \"paginacion\": {
                                            \"numPagina\": \"string\",
                                            \"cantidadRegistros\": \"string\",
                                            \"totalRegistros\": \"string\"
                              },
                              \"track\": {
                                            \"idTrack\": \"string\",
                                            \"codSistema\": \"string\",
                                            \"codAplicacion\": \"string\",
                                            \"componente\": \"string\",
                                            \"estado\": \"string\",
                                            \"dataLogger\": \"string\",
                                            \"flagTracking\": \"string\",
                                            \"flagLog\": \"string\"
                              },
                              \"error\": [
                                            {
                                                           \"errorCode\": \"string\",
                                                           \"errorGlosa\": \"string\"
                                            }
                              ],
                              \"reproceso\": {
                                            \"countReproceso\": \"string\",
                                            \"intervaloReintento\": \"string\",
                                            \"objetoReproceso\": \"string\"
                              },
                              \"filler\": \"string\"
               },
               \"Body\": {
                              \"headerServicio\": {
                                            \"version\": \"string\",
                                            \"canal\": \"string\",
                                            \"estado\": \"string\",
                                            \"comercio\": \"string\",
                                            \"fecha\": \"string\",
                                            \"hora\": \"string\",
                                            \"nroTransaccion\": \"string\",
                                            \"sucursal\": \"string\",
                                            \"terminal\": \"string\",
                                            \"tipoTransaccion\": \"string\",
                                            \"codigoUsusario\": \"string\",
                                            \"entidad\": \"string\",
                                            \"dominioPais\": \"string\"
                              },
                              \"ordenCompra\": \"" . $oc . "\",
                              \"numeroPI\": \"0\"
               }
}",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
            ));
        }


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }


    }

    Public static function traer_datos_oc_3($oc){
        $sql = "select po_number
                       ,cod_estado 
                       ,case when cod_estado = 1 then 'Modo Ingreso' 
                             when cod_estado = 2 then 'Pendiente Autorizacion'
                             when cod_estado = 3 then 'Autorizada'
                             when cod_estado = 4 then 'On Order'
                             when cod_estado = 5 then 'Recepcion Parcial'
                             when cod_estado = 6 then 'Recepcion Completa'
                             when cod_estado = 7 then 'Cancelada' end  NOM_ESTADO
                from plc_ordenes_compra_pmm
                where po_number = ". $oc ;

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }


    // Trabajando en MATCH llenar tabla PMM
    public static function llenar_tabla_pmm($temporada, $depto, $login, $oc, $pi)
    {

        $sql = "SELECT ORDEN_DE_COMPRA, PI, NOMBRE_LINEA, NOMBRE_SUB_LINEA, NOMBRE_ESTILO, NRO_ESTILO, COLOR, COD_COLOR, NRO_LINEA, NRO_SUB_LINEA
                FROM B
                WHERE ORDEN_DE_COMPRA = '" . $oc . "'
                AND PI = '" . $pi . "'
                GROUP BY NOMBRE_ESTILO, NRO_ESTILO, COD_COLOR, ORDEN_DE_COMPRA, PI, NOMBRE_LINEA, NOMBRE_SUB_LINEA, COLOR, NRO_LINEA, NRO_SUB_LINEA
                ORDER BY NRO_LINEA,NRO_SUB_LINEA,COD_COLOR
            ";

        //ORDER BY NRO_LINEA,NRO_SUB_LINEA,COD_COLOR

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Trabajando en MATCH llenar tabla PLAN
    public static function llenar_tabla_plan($temporada, $depto, $login)
    {

        $sql = "";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Consultar OC Linkeada
    public static function consultar_oc_linkeada($temporada, $depto, $login, $oc, $pi)
    {

        // Devuelve el estado de la OC, para saber si se encuentra linkeada (Funcionando)
        /*$sql = "begin PLC_PKG_UTILS.PRC_CONSULTAR_OC('" . $oc . "','" . $pi . "',$temporada,'" . $depto . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;*/

        // Devuelve el estado de la OC, para saber si se encuentra linkeada (Funcionando)
        $sql = "SELECT ESTADO_MATCH
                  FROM PLC_PLAN_COMPRA_OC
                  WHERE PO_NUMBER = '" . $oc . "'
                  AND ESTADO_MATCH = 'Linkeada'
                  AND COD_TEMPORADA = $temporada
                  AND DEP_DEPTO = '" . $depto . "'
            ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;


    }

    // Quitar OC Eliminada
    public static function quitar_oc_cancelada($temporada, $depto, $login, $oc, $pi)
    {

        /*$sql = " DELETE FROM B
                 WHERE PI = '" . $pi . "'
                 AND orden_de_compra <> '" . $oc . "'
                ";*/

        $sql = " DELETE FROM B
                 WHERE orden_de_compra = '" . $oc . "'
                ";

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }

    // Agrega Tabla B OC o PI
    public static function agrega_tabla_b_ocpi($temporada, $depto, $login, $oc, $pi)
    {

        // Funciona (Versión de Escritorio)
        /*$sql = "begin PLC_PKG_UTILS.PRC_AGREGAR_OCPMM('" . $oc . "','" . $pi . "',:error, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;*/

        $sql = "begin PLC_PKG_UTILS.PRC_AGREGAR_OCPMM2('" . $oc . "','" . $pi . "',:error, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;

    }

    // Agrega registros que llegan del WS a la Tabla B
    public static function agrega_registroswsoc_a_tabla_b($temporada, $depto, $login, $oc, $pi, $V_NOMBRE_ESTILO, $V_NRO_ESTILO, $V_ESTADO_ESTILO, $V_NOMBRE_VARIACION, $V_NRO_VARIACION, $V_COLOR, $V_COD_COLOR, $V_NOMBRE_LINEA, $V_NRO_LINEA, $V_NOMBRE_SUB_LINEA, $V_NRO_SUB_LINEA, $V_TEMPORADA, $V_CICLO_VIDA, $V_ESTADO_OC, $V_FECHA_EMBARQUE, $V_FECHA_ETA, $V_UNIDADES, $V_COSTO, $V_MONEDA, $V_PAIS)
    {

        /*$sql = "begin PLC_PKG_UTILS.PRC_ADD_OC_B($oc,'".$pi."','".$V_NOMBRE_ESTILO."',$V_NRO_ESTILO,'".$V_ESTADO_ESTILO."','".$V_NOMBRE_VARIACION."',$V_NRO_VARIACION,'".$V_COLOR."',$V_COD_COLOR,'".$V_NOMBRE_LINEA."','".$V_NRO_LINEA."','".$V_NOMBRE_SUB_LINEA."','".$V_NRO_SUB_LINEA."','".$V_TEMPORADA."','".$V_CICLO_VIDA."','".$V_ESTADO_OC."','".$V_FECHA_EMBARQUE."','".$V_FECHA_ETA."','".$V_UNIDADES."',$V_COSTO,'".$V_MONEDA."','".$V_PAIS."',:error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MATCH-REGISTROSWSOCATABLAB--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;*/


        $sql = "INSERT INTO B(
                     ORDEN_DE_COMPRA
                    ,PI
                    ,NOMBRE_ESTILO
                    ,NRO_ESTILO
                    ,ESTADO_ESTILO
                    ,NOMBRE_VARIACION
                    ,NRO_VARIACION
                    ,COLOR
                    ,COD_COLOR
                    ,NOMBRE_LINEA
                    ,NRO_LINEA
                    ,NOMBRE_SUB_LINEA
                    ,NRO_SUB_LINEA
                    ,TEMPORADA
                    ,CICLO_VIDA
                    ,ESTADO_OC
                    ,FECHA_EMBARQUE
                    ,FECHA_ETA
                    ,UNIDADES
                    ,COSTO
                    ,MONEDA
                    ,PAIS)
            VALUES(  $oc
                    ,'" . $pi . "'
                    ,'" . $V_NOMBRE_ESTILO . "'
                    ,$V_NRO_ESTILO
                    ,'" . $V_ESTADO_ESTILO . "'
                    ,'" . $V_NOMBRE_VARIACION . "'
                    ,$V_NRO_VARIACION
                    ,'" . $V_COLOR . "'
                    ,$V_COD_COLOR
                    ,'" . $V_NOMBRE_LINEA . "'
                    ,'" . $V_NRO_LINEA . "'
                    ,'" . $V_NOMBRE_SUB_LINEA . "'
                    ,'" . $V_NRO_SUB_LINEA . "'
                    ,'" . $V_TEMPORADA . "'
                    ,'" . $V_CICLO_VIDA . "'
                    ,'" . $V_ESTADO_OC . "'
                    ,to_date('" . $V_FECHA_EMBARQUE . "','YYYY-MM-DD')
                    ,to_date('" . $V_FECHA_ETA . "','YYYY-MM-DD')
                    ," . $V_UNIDADES . "
                    ," . $V_COSTO . "
                    ,'" . $V_MONEDA . "'
                    ,'" . $V_PAIS . "')
";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-REGISTROSWSOCATABLAB--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;


    }

    // Validar que tabla B Cruza con el color 3
    public static function valida_tablab_cuza_color3($temporada, $depto, $login, $oc, $pi)
    {

        /*$sql = "begin PLC_PKG_UTILS.PRC_LISTAR_OCPMMIN('" . $oc . "','" . $pi . "',$temporada,'" . $depto . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;*/


        $sql = "SELECT c.id_color3 ID,
                     c.proforma,
                     nvl(C.NOM_LINEA,'Sin Informacion') LINEA,
                     c.cod_jer2 cod_linea,
                     nvl(C.NOM_SUBLINEA,'Sin Informacion') SUB_LINEA,
                     c.cod_sublin cod_sublinea,
                     nvl(c.DES_ESTILO,'Sin Informacion') ESTILO,
                     nvl(c.Nom_Color,'Sin Informacion') COLOR,
                     c.cod_color 
                FROM  plc_plan_compra_color_3 c
                WHERE C.PROFORMA = '" . $pi . "' 
                AND C.COD_TEMPORADA = $temporada 
                AND C.DEP_DEPTO = '" . $depto . "' 
                AND C.ESTADO <> 24
                ORDER BY COD_LINEA,COD_SUBLINEA,COD_COLOR
               ";
        $data = \database::getInstancia()->getFilas($sql);

        return $data;

    }

    // Validar que tabla B Cruza con el color 3
    public static function btn_actualizar_match($temporada, $depto, $login, $id_color, $linea, $sublinea, $estilo, $color)
    {

        $sql = "begin PLC_PKG_DESARROLLO.PRC_UPDATE_COLOR3_OC($temporada,'" . $depto . "',$id_color, '" . $linea . "', '" . $sublinea . "', '" . $estilo . "', '" . $color . "',:error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-ACTUALIZACAMPOS--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        //return $data;

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Listar plan compra color
    public static function listar_plan_compra_color($temporada, $depto, $login, $proforema)
    {

        /*$sql = "begin PLC_PKG_MIGRACION.PRC_GRID_PLAN_COMPRA_COLOR_4($temporada,'".$depto."',0,0, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;*/

        $sql = "SELECT
                    C.ID_COLOR3,
                    C.DES_ESTILO ESTILO,
                    C.VENTANA_LLEGADA VENTANA,
                    C.PROFORMA,
                    O.PO_NUMBER OC,
                    C.COD_JER2 LINEA,
                    C.COD_SUBLIN SUBLINEA,
                    C.COD_MARCA MARCA,
                    NVL(COD_COLOR,0) COLOR,
                    C.ESTADO,
                    C.NOM_LINEA NOM_LINEA,
                    C.NOM_SUBLINEA NOM_SUBLINEA,
                    C.NOM_MARCA NOM_MARCA,
                    C.NOM_VENTANA NOM_VENTANA,
                    C.NOM_COLOR NOM_COLOR,
                    O.ESTADO_MATCH ESTADO_OC
                FROM PLC_PLAN_COMPRA_COLOR_3 C
                LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                                               AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada
                AND C.DEP_DEPTO = '" . $depto . "'
                AND C.ESTADO = 19
                AND C.PROFORMA = '" . $proforema . "'
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Listar plan compra color
    public static function generar_match($temporada, $depto, $login, $proforma, $estilo, $codventana, $oc)
    {

        $sql = "begin PLC_PKG_UTILS.PRC_GENERAR_MATCH('" . $proforma . "','" . $estilo . "', $codventana,'" . $depto . "',$temporada,'" . $oc . "', :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-VALIDACIONMATCH--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        //return $data;

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Aprobar Opción
    public static function aprobar_opcion($temporada, $depto, $login, $id_color3, $proforma)
    {

        $sql = "begin PLC_PKG_UTILS.PRC_APROBACION_PLAN_2($temporada,'" . $depto . "',$id_color3,'" . $proforma . "', :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-APROBAROPCION--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        //return $data;

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Listar IDCOLOR3 Compra
    public static function listar_idcolor3_compra($temporada, $depto, $login, $id_color3)
    {

        $sql = "begin PLC_PKG_MIGRACION.PRC_LIS_COLOR3_IDCOLOR3($temporada,'" . $depto . "',$id_color3, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;

    }

    // Insertar Historial
    public static function insertar_historial($temporada, $depto, $V_LINEA, $V_SUBLINEA, $V_MARCA, $V_ESTILO, $V_VENTANA, $V_COLOR, $V_USER_LOGIN, $V_PI, $V_OC, $V_ESTADO, $V_ID_COLOR3, $V_TIPOINSERT, $V_NOM_LINEA, $V_NOM_SUBLINEA, $V_NOM_MARCA, $V_NOM_VENTANA, $V_NOM_COLOR)
    {

        $sql = "INSERT INTO PLC_PLAN_COMPRA_HISTORICA (
                                             DPTO
                                            ,LINEA
                                            ,SUBLINEA
                                            ,MARCA
                                            ,ESTILO
                                            ,VENTANA
                                            ,COLOR
                                            ,USER_LOGIN
                                            ,USER_NOM
                                            ,FECHA
                                            ,HORA
                                            ,PI
                                            ,OC
                                            ,ESTADO
                                            ,TEMP
                                            ,ID_COLOR3
                                            ,NOM_LINEA
                                            ,NOM_MARCA
                                            ,NOM_VENTANA
                                            ,NOM_COLOR
                                            ,NOM_SUBLINEA)

                                     VALUES ('" . $depto . "'
                                            ,'" . $V_LINEA . "'
                                            ,'" . $V_SUBLINEA . "'
                                            ,$V_MARCA
                                            ,'" . $V_ESTILO . "'
                                            ,$V_VENTANA
                                            ,$V_COLOR
                                            ,'" . $V_USER_LOGIN . "'
                                            ,(SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $V_USER_LOGIN . "')
                                            ,(SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL)
                                            ,(SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL)
                                            ,'" . $V_PI . "'
                                            ,'" . $V_OC . "'
                                            ,$V_ESTADO
                                            ,$temporada
                                            ,$V_ID_COLOR3
                                            ,'" . $V_NOM_LINEA . "'
                                            ,'" . $V_NOM_MARCA . "'
                                            ,'" . $V_NOM_VENTANA . "'
                                            ,'" . $V_NOM_COLOR . "'
                                            ,'" . $V_NOM_SUBLINEA . "' )
                ";


        $data = \database::getInstancia()->getConsulta($sql);
        return $data;


    }

    // Listar Ventana Embarque Llegada
    public static function listar_ventana_embarque_llegada($temporada, $depto, $login)
    {

        $sql = "begin PLC_PKG_PRUEBA.PRC_VENTA_EMBAR_COMPRA($temporada, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;

    }

    // 6 Agregar OC Variación
    public static function agregar_oc_variacion($login, $oc, $proforma)
    {

        $sql = "begin PLC_PKG_UTILS.PRC_AGREGAR_OC_VARIACION2('" . $oc . "','" . $proforma . "', :error, :data); end;";


        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-AGREGAOCVARIACION--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);


        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        //return $data;
        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // 7 Agregar New OC Variación
    public static function agregar_new_oc_variacion($temporada, $depto,$oc, $login)
    {

        $sql = "begin PLC_PKG_UTILS.PRC_AGREGAR_NUEVA_VARIACION(" . $temporada . ",'" . $depto . "','" . $oc . "', :error, :data); end;";

        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-AGREGANEWOCVARIACION--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        //return $data;

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Buscar OC con estado 20
    public static function busca_oc_estado_20($temporada, $depto, $login)
    {

        $sql = "begin PLC_PKG_MIGRACION.PRC_LISTAR_OPCION20($temporada,'" . $depto . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;

    }

    // Busca Estado OC PMM
    public static function busca_estado_oc_pmm($temporada, $depto, $login, $oc)
    {

        $sql = "begin PLC_PKG_MIGRACION.PRC_VALIDACION_OC_PMM('" . $oc . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;

    }

    // Estado 4 OC PMM, Inserto a Historial
    public static function estado_oc_4_inserta_historial($temporada, $depto, $LINEA, $SUBLINEA, $MARCA, $ESTILO, $VENTANA, $COLOR, $login, $PI, $OC, $ESTADO, $ID_COLOR3, $TIPO_INSERT, $NOM_LINEA, $NOM_SUBLINEA, $NOM_MARCA, $NOM_VENTANA, $NOM_COLOR)
    {

        $sql = "begin PLC_PKG_PRUEBA.PRC_ADD_PLAN_HISTORICO($temporada, '" . $depto . "', '" . $LINEA . "','" . $SUBLINEA . "',$MARCA,'" . $ESTILO . "',$VENTANA,$COLOR,'" . $login . "','" . $PI . "',$OC,'" . $ESTADO . "',$ID_COLOR3,$TIPO_INSERT,'" . $NOM_LINEA . "','" . $NOM_SUBLINEA . "','" . $NOM_MARCA . "','" . $NOM_VENTANA . "','" . $NOM_COLOR . "', :error,:data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/GRID2AHISTORIAL-ESTADOC4INSERTAHISTORIAL--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);

        if ($data) {
            return 1;
        } else {
            return 0;
        }

    }

    // Guarda Comentario del estado PI para flujo "Solicitud Corrección PI"
    public static function guarda_comentario_estado_pi($temporada, $depto, $login, $comentario, $proforma)
    {

        $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_3 A
                SET   A.ERROR_PI      = '" . $comentario . "'
                WHERE A.COD_TEMPORADA = $temporada
                AND   A.DEP_DEPTO     = '" . $depto . "'
                AND   A.PROFORMA      = '" . $proforma . "'
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/FLUJO-COMENTARIOSOLCORRECCIONPI--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }




// TERMINADO

    // CBX optionsLinea
    public static function listar_optionsLinea($temporada, $depto)
    {

        $sql = "SELECT TRIM( L.PRD_LVL_NUMBER ) AS LIN_LINEA,
                       TRIM( L.PRD_NAME_FULL ) AS LIN_DESCRIPCION
                FROM   PRDMSTEE         P,
                       PRDMSTEE         L
                WHERE  P.PRD_LVL_NUMBER = RPAD('" . $depto . "', 15, ' ' )
                AND    P.PRD_LVL_CHILD  = L.PRD_LVL_PARENT
                AND    L.PRD_STATUS = 0
                ORDER BY 2 ASC
                ";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsSubLinea
    public static function listar_optionsSubLinea($temporada, $depto, $id_linea)
    {

        $sql = "SELECT TRIM( L.PRD_LVL_NUMBER ) AS SLI_SUBLINEA,
                       TRIM( L.PRD_NAME_FULL ) AS SLI_DESCRIPCION
                FROM   PRDMSTEE         P,
                       PRDMSTEE         L
                WHERE  P.PRD_LVL_NUMBER = RPAD( '" . $id_linea . "', 15, ' ' )
                AND    P.PRD_LVL_CHILD  = L.PRD_LVL_PARENT
                AND    L.PRD_STATUS = 0
                ORDER BY 2 ASC
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // CBX optionsMarca
    public static function listar_optionsMarca($temporada, $depto)
    {

        $data = plan_compra::list_Marcas($depto);

        return $data;

        /*$json = array();
        foreach ($data as $val) {
             array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }

        return $json;*/

    }

    // CBX optionsColor
    public static function listar_optionsColor($temporada, $depto)
    {

        /*$data = plan_compra::list_colores();
        return $data;*/

        $sql = "SELECT
                REPLACE(REPLACE(trim(t.codigo),CHR(10),''),CHR(13),'') AS COD_COLOR,
                convert(REPLACE(REPLACE(INITCAP( t.descripcion),CHR(10),''),CHR(13),''),'utf8','us7ascii') AS NOM_COLOR
                FROM PLC_MAEDIM T
                WHERE T.TIPO = 'C'
                ORDER BY t.descripcion ASC
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;


        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }

//preg_replace('/\x{EF}\x{BF}\x{BD}/u', '', iconv(mb_detect_encoding($val[1]), 'UTF-8', $val[1]))])

        return $json;*/

    }

    // CBX optionsTipoExhibicion
    public static function listar_optionsTipoExhibicion($temporada, $depto)
    {

        $data = plan_compra::list_tipoexhibicion();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsTipoProducto
    public static function listar_optionsTipoProducto($temporada, $depto)
    {

        $data = plan_compra::list_tipoProducto();

        return $data;

        /* $json = array();
         foreach ($data as $val) {
             array_push($json, ["id" => $val[0], "name" => $val[1]]);
         }
         return $json;*/

    }

    // CBX optionsLifeCicle
    public static function listar_optionsLifeCicle($temporada, $depto)
    {

        $data = plan_compra::list_ciclo_vida();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsRankVenta
    public static function listar_optionsRankVenta($temporada, $depto)
    {

        $data = plan_compra::list_rnk();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsPiramideMix
    public static function listar_optionsPiramideMix($temporada, $depto)
    {

        $data = plan_compra::list_piramidemix();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsCluster
    public static function listar_optionsCluster($temporada, $depto)
    {

        $data = plan_compra::list_cluster($temporada, $depto);

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsFormato
    public static function listar_optionsFormato($temporada, $depto)
    {

        $data = plan_compra::list_Formato($temporada, $depto);

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsVia
    public static function listar_optionsVia($temporada, $depto)
    {

        $data = plan_compra::list_via();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsPais
    public static function listar_optionsPais($temporada, $depto)
    {

        $data = plan_compra::list_pais();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsVentanaLlegada
    public static function listar_optionsVentanaLlegada($temporada, $depto)
    {

        $data = plan_compra::list_ventanas($temporada);

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsEVida
    public static function listar_optionsEVida($temporada, $depto)
    {

        $data = plan_compra::list_EVida();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsMoneda
    public static function listar_optionsMoneda($temporada, $depto)
    {

        $data = plan_compra::list_Moneda();

        return $data;


        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsOcupacionUso
    public static function listar_optionsOcacionUso($temporada, $depto)
    {

        $data = plan_compra::list_OcacionUso();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }

    // CBX optionsProveedor
    public static function listar_optionsProveedor($temporada, $depto)
    {

        $data = plan_compra::list_Proveedor();

        return $data;

        /*$json = array();
        foreach ($data as $val) {
            array_push($json, ["id" => $val[0], "name" => $val[1]]);
        }
        return $json;*/

    }


    //combobox ajuste compra
    public static function Combobox_ajust_compra($tempo, $depto, $id_color3, $tallas)
    {

        $n_tallas = explode(",", $tallas);
        $columtallas = "";

        for ($i = 1; $i <= count($n_tallas); $i++) {
            $columtallas = $columtallas . "TALLA_" . $i . ",";
        }
        $columtallas = substr($columtallas, 0, strlen($columtallas) - 1);
        $sql = "select COLUMNAS
                    ," . $columtallas . "
                    ,TOTAL
                from (select COLUMNAS
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_1||'%' else TALLA_1 end TALLA_1
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_2||'%' else TALLA_2 end TALLA_2
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_3||'%' else TALLA_3 end TALLA_3
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_4||'%' else TALLA_4 end TALLA_4
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_5||'%' else TALLA_5 end TALLA_5
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_6||'%' else TALLA_6 end TALLA_6
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_7||'%' else TALLA_7 end TALLA_7
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_8||'%' else TALLA_8 end TALLA_8
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then TALLA_9||'%' else TALLA_9 end TALLA_9
                        ,case when COLUMNAS = 'Curva de compra Ajustada' then '-' else to_char(TOTAL) end TOTAL
                        ,case when COLUMNAS = 'Curva de Compra' then  1
                              when COLUMNAS = 'Curva Primer Reparto' then 2
                              when COLUMNAS = 'Diferencial' then 3
                              when COLUMNAS = 'Total' then 4
                              when COLUMNAS = 'Curva de compra Ajustada' then 5 end order_
                        from plc_ajustes_compra
                        where id_color3 = " . $id_color3 . "
                        and cod_temporada = " . $tempo . "
                        and dep_depto = '" . $depto . "'
                        and Tipo_ajuste = 'Ajuste de Compra')A
                ORDER BY order_ ASC";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    public static function Combobox_ajust_n_cajas($tempo, $depto, $id_color3, $tallas, $tipo_empaque, $debut_reorder)
    {


        $n_tallas = explode(",", $tallas);
        $columtallas = "";
        for ($i = 1; $i <= count($n_tallas); $i++) {
            $columtallas = $columtallas . "TALLA_" . $i . ",";
        }
        $columtallas = substr($columtallas, 0, strlen($columtallas) - 1);

        if ($tipo_empaque == "CURVADO" and $debut_reorder == "DEBUT") {


            $sql = " select COLUMNAS," . $columtallas . ",TOTAL
                   from(select COLUMNAS
                               ,TALLA_1,TALLA_2,TALLA_3,TALLA_4,TALLA_5,TALLA_6,TALLA_7,TALLA_8,TALLA_9
                                ,CASE WHEN COLUMNAS = 'N de curvas x cajas' THEN 1
                                     WHEN COLUMNAS = 'Compra Total' THEN 2  WHEN COLUMNAS = '1er Reparto' THEN 3 WHEN COLUMNAS = 'Curva 1er Reparto' THEN 4
                                     WHEN COLUMNAS = 'Master Curvado' THEN 5 WHEN COLUMNAS = 'Curvas a repartir' THEN 6 WHEN COLUMNAS = 'N de Cajas' THEN 7
                                     WHEN COLUMNAS = 'Total Solido' THEN 8 WHEN COLUMNAS = 'Master Pack' THEN 9 WHEN COLUMNAS = 'N Cajas' THEN 10
                                     WHEN COLUMNAS = 'Total Solido Ajustado' THEN 11 WHEN COLUMNAS = 'Total Unidades Final' THEN 12 WHEN COLUMNAS = 'Total N Cajas Final' THEN 13
                                     WHEN COLUMNAS = 'Total Porcentajes Ajust Final' THEN 14 end n
                               ,TOTAL
                        from plc_ajustes_compra
                        where id_color3 = " . $id_color3 . "
                 and cod_temporada = " . $tempo . "
                 and dep_depto = '" . $depto . "'
                 and tipo_ajuste in ('Ajuste Curvado','Solido Curvado'))a order by n asc";
        } ELSEIF ($tipo_empaque == "SOLIDO" and $debut_reorder == "DEBUT") {

            $sql = "select COLUMNAS," . $columtallas . ",TOTAL
                     from(select COLUMNAS
                                       ,TALLA_1,TALLA_2,TALLA_3,TALLA_4,TALLA_5,TALLA_6,TALLA_7,TALLA_8,TALLA_9
                                       ,CASE WHEN COLUMNAS = 'Unid Ini' THEN 1 WHEN COLUMNAS = 'Primer Reparto' THEN 2
                                             WHEN COLUMNAS = '1er Reparto' THEN 3 WHEN COLUMNAS = 'Master Pack' THEN 4
                                             WHEN COLUMNAS = 'N Cajas' THEN 5 WHEN COLUMNAS = 'Unid Final' THEN 6 end n
                                       ,TOTAL
                         from plc_ajustes_compra
                         where id_color3 = " . $id_color3 . "
                    and cod_temporada = " . $tempo . "
                    and dep_depto = '" . $depto . "'
                    and tipo_ajuste in ('Ajuste Master Pack'))a order by n asc";

        } ELSEIF ($tipo_empaque == "SOLIDO" and $debut_reorder == "REORDER") {
            $sql = "select COLUMNAS," . $columtallas . ",TOTAL
                     from(select COLUMNAS
                                       ,TALLA_1,TALLA_2,TALLA_3,TALLA_4,TALLA_5,TALLA_6,TALLA_7,TALLA_8,TALLA_9
                                       ,CASE WHEN COLUMNAS = 'Unid Ini' THEN 1
                                             WHEN COLUMNAS = 'Mst Pack' THEN 2
                                             WHEN COLUMNAS = 'N Cajas' THEN 3
                                             WHEN COLUMNAS = 'Und Final' THEN 4 end n
                                       ,TOTAL
                          from plc_ajustes_compra
                          where id_color3 = " . $id_color3 . "
                    and cod_temporada = " . $tempo . "
                    and dep_depto = '" . $depto . "'
                    and tipo_ajuste in ('Ajuste Master Pack'))a order by n asc";
        }

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function checkbox_list_grupocompraXdepto($tempo, $depto)
    {
        $sql = "SELECT DISTINCT GRUPO_COMPRA
                FROM PLC_PLAN_COMPRA_COLOR_3
                WHERE COD_TEMPORADA = " . $tempo . "
                        AND DEP_DEPTO = '" . $depto . "'
                ORDER BY 1 ASC";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    // ######################## TRABAJO CON ACCESO SIMULADOR DE COMPRA ########################

    public static function busca_existe_pto_retail($temporada, $depto, $login)
    {

        $sql = "SELECT MATI FROM PLC_PPTO_RETAIL
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function busca_existe_pto_embarque($temporada, $depto, $login)
    {

        $sql = "SELECT count(*)total FROM PLC_PPTO_EMB
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function busca_existe_pto_costo($temporada, $depto, $login)
    {

        $sql = "SELECT presupuesto FROM PLC_PPTO_COSTO
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function busca_existe_val_tienda($temporada, $depto, $login)
    {

        $sql = "SELECT * FROM PLC_SEGMENTOS_TDA
                WHERE COD_TEMPORADA = $temporada
                AND DEP_DEPTO = '" . $depto . "'
                AND COD_SEG <> 4
                 ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function busca_existe_marca($temporada, $depto, $login)
    {

        $sql = "SELECT count(*) TOTAL
                    FROM PLC_DEPTO_MARCA 
                    WHERE LTRIM(RTRIM(COD_DEPT)) = LTRIM(RTRIM('" . $depto . "'))
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }


    // ######################## VISTA OC FECHA RECEPCIÓN Y DIAS ATRASO ########################

    public static function trae_fecharcd_y_dias_atraso($fecha_esta, $fecha_recep_pmm)
    {

        $sql = "begin PLC_PKG_DESARROLLO.PRC_LIS_FECHASOCVISTA('" . $fecha_esta . "', '" . $fecha_recep_pmm . "', :data); end;";

        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        return $data;

    }


    // ######################## TRABAJO CON GRILLA EDITABLE ########################

    public static function listar_factor($cod_temporada, $depto, $pais, $via, $moneda, $ventana)
    {

        $sql = "SELECT " . $ventana . " FROM PLC_FACTOR_EST F
                WHERE  F.COD_TEMPORADA   = $cod_temporada
                AND    F.DEP_DEPTO       = '" . $depto . "'
                AND    F.CNTRY_LVL_CHILD = $pais
                AND    F.COD_VIA         = $via
                AND    F.COD_TIP_MON     = $moneda
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function listar_tipocambio($cod_temporada, $depto, $moneda, $ventana)
    {

        $sql = "SELECT  " . $ventana . "
                FROM   PLC_TIPO_CAMBIO P
                WHERE  P.COD_TEMPORADA = $cod_temporada
                AND    P.COD_TIP_MON = $moneda
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    // Actualizar grilla en plan_compra_color3                                                                                                                                                                                             // ,$TIPO_EMPAQUE,$FORMATO,$NOM_VENTANA
    public static function actualiza_grilla_plan_compra_color3($temporada, $depto, $login, $ID_COLOR3, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $COSTO_UNIT, $COSTO_UNITS, $CST_TOTLTARGET, $COSTO_TOT, $COSTO_TOTS, $MKUP, $GM, $PROVEEDOR
        , $VIA, $PAIS, $FACTOR_EST, $NOM_VIA, $NOM_PAIS, $TARGET
        , $tipo_empaque, $und_inicial, $und_ajust, $und_final, $porcent_ajust, $porcent_tdas, $formato
        , $cant_cajas, $und_ajust_xtallas, $cod_marca, $cluster, $debut_,$retail,$precio_blanco,$COSTO){

        $_Error = false;
        $und_ajust_xtallas = str_replace("\"", "", $und_ajust_xtallas);
        $und_ajust = str_replace("\"", "", $und_ajust);
        $dtdivicantidad = plan_compra::Division_cantidades($und_ajust_xtallas);
        $dtdiviporcent = plan_compra::Division_porcent($porcent_ajust);

        $tdas = 0;
        if (strtoupper($debut_) == "DEBUT") {
            $tdas = plan_compra::get_N_tdas($depto
                , $cod_marca
                , $temporada
                , $cluster
                , $formato);
        }
        //UPDATE PLC_PLAN_COMPRA_COLOR_3
        $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_3 
                    SET COSTO_FOB = $COSTO_FOB,
                    COSTO_INSP = $COSTO_INSP,
                    COSTO_RFID = $COSTO_RFID,
                    COSTO_UNIT = $COSTO_UNIT,
                    COSTO_UNITS = $COSTO_UNITS,
                    CST_TOTLTARGET = $CST_TOTLTARGET,
                    COSTO_TOT = $COSTO_TOT,
                    COSTO_TOTS = $COSTO_TOTS,
                    MKUP = $MKUP,
                    GM = $GM,
                    ALIAS_PROV = '" . $PROVEEDOR . "',
                    VIA = $VIA,
                    PAIS = $PAIS,
                    NOM_VIA = '" . $NOM_VIA . "', 
                    NOM_PAIS = '" . $NOM_PAIS . "',
                    FACTOR_EST = $FACTOR_EST,
                    USR_MOD = '" . $login . "',
                    COSTO_TARGET = $TARGET,
                    FEC_MOD = current_date,
                     tipo_empaque = '" . $tipo_empaque . "' 
                    ,unid_opcion_inicio = $und_inicial
                    ,unid_opcion_ajustada = $und_ajust
                    ,unidades = $und_final
                    ,PORTALLA_1 = '" . $porcent_ajust . "' 
                    ,tdas  = $tdas--NUMERO DE TIENDAS
                    ,ROT  = $porcent_tdas --%TIENDAS
                    ,formato = '" . $formato . "' 
                    ,CANT_INNER = $cant_cajas
                    ,Cant_T1 = $dtdivicantidad[0]
                    ,Cant_T2 = $dtdivicantidad[1]
                    ,Cant_T3 = $dtdivicantidad[2]
                    ,Cant_T4 = $dtdivicantidad[3]
                    ,Cant_T5 = $dtdivicantidad[4]
                    ,Cant_T6 = $dtdivicantidad[5]
                    ,Cant_T7 = $dtdivicantidad[6]
                    ,Cant_T8 = $dtdivicantidad[7]
                    ,Cant_T9 = $dtdivicantidad[8]
                    ,PORCEN_T1 = '" . $dtdiviporcent[0] . "' 
                    ,PORCEN_T2 = '" . $dtdiviporcent[1] . "'
                    ,PORCEN_T3 = '" . $dtdiviporcent[2] . "'
                    ,PORCEN_T4 = '" . $dtdiviporcent[3] . "'
                    ,PORCEN_T5 = '" . $dtdiviporcent[4] . "'
                    ,PORCEN_T6 = '" . $dtdiviporcent[5] . "'
                    ,PORCEN_T7 = '" . $dtdiviporcent[6] . "'
                    ,PORCEN_T8 = '" . $dtdiviporcent[7] . "'
                    ,PORCEN_T9 = '" . $dtdiviporcent[8] . "'
                    ,retail = $retail
                    ,precio_blanco = $precio_blanco
                WHERE COD_TEMPORADA = $temporada
                    AND DEP_DEPTO = '" . $depto . "'
                    AND ID_COLOR3 = $ID_COLOR3
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/EDITAGRILLA-PLC_PLAN_COMPRA_COLOR_3--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);
        if (\database::getInstancia()->getConsulta($sql)) {
            $_Error = true ;
        }

        //UPDATE PLC_PLAN_COMPRA_COLOR_CIC
        if ($_Error == true){
            $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_CIC 
                SET COSTO = $COSTO,
                    USR_MOD = '" . $login . "',
                    FEC_MOD = current_date,
                    VTA_CDSCTO = $retail
                WHERE COD_TEMPORADA = $temporada
                    AND DEP_DEPTO = '" . $depto . "'
                    AND ID_COLOR3 = $ID_COLOR3
                ";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql;
            $fp = fopen("../archivos/log_querys/" . $login . "/EDITAGRILLA-PLC_PLAN_COMPRA_COLOR_CIC--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

        // $data = \database::getInstancia()->getConsulta($sql);
        // return $data;

        if (\database::getInstancia()->getConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
        }else{
            return 0;
        }
    }


    // Actualizar grilla en PLC_PLAN_COMPRA_COLOR_CIC
    public static function actualiza_grilla_plan_compra_color_cic($temporada, $depto, $login, $ID_COLOR3, $COSTO,$retail )
    {

        $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_CIC 
                SET COSTO = $COSTO,
                    USR_MOD = '" . $login . "',
                    FEC_MOD = current_date,
                    VTA_CDSCTO = $retail
                WHERE COD_TEMPORADA = $temporada
                    AND DEP_DEPTO = '" . $depto . "'
                    AND ID_COLOR3 = $ID_COLOR3
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/EDITAGRILLA-PLC_PLAN_COMPRA_COLOR_CIC--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        // $data = \database::getInstancia()->getConsulta($sql);
        // return $data;

        if (\database::getInstancia()->getConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }


    }

    // Listar País
    public static function listar_pais($cod_temporada, $depto)
    {

        $sql = "SELECT CNTRY_LVL_CHILD,CNTRY_NAME 
                  FROM plc_pais
                  ORDER BY CNTRY_NAME ASC
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    // Busca Formatos Grilla Editar
    public static function listar_formato_grilla_edita($temporada, $depto)
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
    public static function listar_ventana_grilla_edita($temporada, $depto)
    {

        $sql = "SELECT * FROM plc_ventana";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function CalculoCurvado($tipo_empaque, $tallas, $curvas_talla, $und_iniciales, $cluster, $formato
        , $A, $B, $C, $I, $debut_reoder, $PORTALLA_1_INI, $depto, $cod_tempo, $marca, $N_CURVASXCAJAS
        , $cod_linea, $cod_sublinea, $id_color3, $Guardado)
    {

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

    // Actualiza la fecha del registro de concurrencia
    public static function actualiza_fecha_concurrencia($temporada, $depto, $login)
    {

        $sql = "UPDATE PLC_CONCURRENCIA
                SET FECHA = SYSDATE
                WHERE COD_USR = '" . $login . "'
                AND COD_TEMPORADA =  $temporada
                AND DEP_DEPTO = '" . $depto . "' 
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/PERMISO-ACTFECHA--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);

        if ($data) {
            return 0;
        } else {
            return 1;
        }


    }



    // ######################## TRABAJO CON NUEVA CARGA DE PROFORMA ########################

    // Actualmente se utiliza 29102018
    public static function guarda_proforma_cond1($temporada, $depto, $login, $proforma, $id_insertar, $archivo)
    {

        if ($archivo == 1) {

            // 1.- Guarda Registro en plc_plan_compra_oc

            // Agrego el registro del archivo en plan_compra_oc
            $sql_plan_compra_oc = "INSERT INTO plc_plan_compra_oc (cod_temporada,dep_depto,niv_jer1,cod_jer1,niv_jer2,cod_jer2,item,cod_sublin,cod_estilo,des_estilo,vent_emb,proforma,archivo,id_color3, estado_oc,estilo_pmm)
                SELECT
                      C.COD_TEMPORADA,
                      C.DEP_DEPTO,
                      0 NJ1,
                      0 CJ1,
                      0 NJ2,
                      C.COD_JER2,
                      0 ITEM,
                      C.COD_SUBLIN,
                      0 COD_ESTILO,
                      C.DES_ESTILO,
                      C.VENTANA_LLEGADA,
                      '" . $proforma . "',
                      'Cargado..' ARCHIVO,
                      C.ID_COLOR3,
                      '' Estado_oc,
                      '' estilo_pmm
                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                      LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                      AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                AND C.ID_COLOR3 = $id_insertar
                ";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_plan_compra_oc;
            $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND2--INSCOMPRAOC--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data_plan_compra_oc = \database::getInstancia()->getConsulta($sql_plan_compra_oc);


            // Aquí voy a buscar todos los registros de plan color 3 que tengan la misma PI (Excluyendo el id_color 3 ya ingresado) y los agrego a plc_plan_compra_oc


            // Si puedo guardar en plc_plan_compra_oc, actualizo plc_plan_compra_color_3
            if ($data_plan_compra_oc) {

                // 2.- Actualiza plc_plan_compra_color3 estado=18 y proforma = $proforma
                $sql_plan_compra_color_3 = "UPDATE plc_plan_compra_color_3
                SET proforma = '" . $proforma . "',
                estado = 18
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND id_color3 = $id_insertar
                ";

                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                if (!file_exists('../archivos/log_querys/' . $login)) {
                    mkdir('../archivos/log_querys/' . $login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql_plan_compra_color_3;
                $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND2--UPDPLANCOLOR3--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                fwrite($fp, $content);
                fclose($fp);

                $data_plan_compra_color_3 = \database::getInstancia()->getConsulta($sql_plan_compra_color_3);

                // Si se pudo actualizar plc_plan_compra_color_3, guardo en el historial
                if ($data_plan_compra_color_3) {

                    // 3.- Guarda Historial (Incluye el registro + los datos de la PI)
                    $sql_historial = "INSERT INTO plc_plan_compra_historica (temp,dpto,linea,sublinea,marca,estilo,ventana,color,user_login,user_nom,fecha,hora,pi,oc,estado,id_color3,nom_linea,nom_sublinea,nom_marca,nom_ventana,nom_color)
                SELECT
                      C.COD_TEMPORADA,
                      C.DEP_DEPTO,
                      C.COD_JER2 LINEA,         -- linea
                      C.COD_SUBLIN SUBLINEA,    -- sublinea
                      C.COD_MARCA,              -- marca
                      C.DES_ESTILO ESTILO,      -- estilo
                      C.VENTANA_LLEGADA,        -- Ventana
                      NVL(COD_COLOR,0)COLOR,    -- Color
                      '" . $login . "',
                      (SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "'),
                      (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                      (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                      '" . $proforma . "',
                      O.PO_NUMBER,
                      C.ESTADO,
                      C.ID_COLOR3,
                      C.NOM_LINEA LINEA,
                      C.NOM_SUBLINEA SUBLINEA,
                      C.NOM_MARCA MARCA,
                      C.NOM_VENTANA VENTANA,
                      C.NOM_COLOR COD_COLOR
                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                      LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                      AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                AND C.ID_COLOR3 = $id_insertar
                ";

                    // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                    if (!file_exists('../archivos/log_querys/' . $login)) {
                        mkdir('../archivos/log_querys/' . $login, 0775, true);
                    }
                    $stamp = date("Y-m-d_H-i-s");
                    $rand = rand(1, 999);
                    $content = $sql_historial;
                    $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND2--INSERTHISTORIAL--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                    fwrite($fp, $content);
                    fclose($fp);

                    $data_historial = \database::getInstancia()->getConsulta($sql_historial);

                    if ($data_historial) {
                        return "OK";
                    } else {
                        return "ERROR";
                    }


                } else {
                    return "ERROR";
                }


            } else {
                return "ERROR";
            }


            // No llega con archivo
        } else {

            // voy a buscra si en plc_plan_compra_oc hay algun registro de esa PI

            // si hay, se inserta registro en plc_plan_compra_oc y se actualiza estado en plc_plan_compra_color_3=18 ... historial

            // si NO hay,


            // 1.- Actualiza plc_plan_compra_color3 proforma = $proforma
            // Actualizo plan_compra_color3 estado=18 y proforma=$proforma
            $sql_plan_compra_color_3 = "UPDATE plc_plan_compra_color_3
                SET proforma = '" . $proforma . "'
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND id_color3 = $id_insertar
                ";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_plan_compra_color_3;
            $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND2--UPDPLANCOLOR3--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data_plan_compra_color_3 = \database::getInstancia()->getConsulta($sql_plan_compra_color_3);

            // 2.- Guarda Historial
            if ($data_plan_compra_color_3) {

                // Guardo Historial
                $sql_historial = "INSERT INTO plc_plan_compra_historica (temp,dpto,linea,sublinea,marca,estilo,ventana,color,user_login,user_nom,fecha,hora,pi,oc,estado,id_color3,nom_linea,nom_sublinea,nom_marca,nom_ventana,nom_color)
                SELECT
                      C.COD_TEMPORADA,
                      C.DEP_DEPTO,
                      C.COD_JER2 LINEA,         -- linea
                      C.COD_SUBLIN SUBLINEA,    -- sublinea
                      C.COD_MARCA,              -- marca
                      C.DES_ESTILO ESTILO,      -- estilo
                      C.VENTANA_LLEGADA,        -- Ventana
                      NVL(COD_COLOR,0)COLOR,    -- Color
                      '" . $login . "',
                      (SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "'),
                      (SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL),
                      (SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL),
                      C.PROFORMA,
                      O.PO_NUMBER,
                      C.ESTADO,
                      C.ID_COLOR3,
                      C.NOM_LINEA LINEA,
                      C.NOM_SUBLINEA SUBLINEA,
                      C.NOM_MARCA MARCA,
                      C.NOM_VENTANA VENTANA,
                      C.NOM_COLOR COD_COLOR
                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                      LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                      AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                AND C.ID_COLOR3 = $id_insertar
                ";

                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                if (!file_exists('../archivos/log_querys/' . $login)) {
                    mkdir('../archivos/log_querys/' . $login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql_historial;
                $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND2--INSERTHISTORIAL--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                fwrite($fp, $content);
                fclose($fp);

                $data_historial = \database::getInstancia()->getConsulta($sql_historial);

                if ($data_historial) {
                    return "OK";
                } else {
                    return "ERROR";
                }


            } else {
                return "ERROR";
            }

        }


    }

    public static function guarda_proforma_cond2($temporada, $depto, $login, $proforma, $id_insertar, $archivo)
    {

        $sql_archivo = "SELECT 1 FROM plc_plan_compra_oc
                WHERE COD_TEMPORADA = $temporada 
                AND DEP_DEPTO = '" . $depto . "'
                AND PROFORMA = '" . $proforma . "'
                AND ARCHIVO = 'Cargado..'
                AND ID_COLOR3 = $id_insertar
                ";

        $existe_archivo = (int)\database::getInstancia()->getFila($sql_archivo);

        // Si existe archivo
        if ($existe_archivo == 1) {

            // Actualizo plan_compra_color3 estado=18 y proforma=$proforma
            $sql = "UPDATE plc_plan_compra_color_3
                SET estado = 18
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND id_color3 = $id_insertar
                ";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql;
            $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND1--UPDPLANCOLOR3--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data = \database::getInstancia()->getConsulta($sql);

            if ($data) {
                return "OK";
            } else {
                return "ERROR";
            }

            // No tiene archivo
        } else {

            // Agrego el registro del archivo en plan_compra_oc
            $sql_plan_compra_oc = "INSERT INTO plc_plan_compra_oc (cod_temporada,dep_depto,niv_jer1,cod_jer1,niv_jer2,cod_jer2,item,cod_sublin,cod_estilo,des_estilo,vent_emb,proforma,archivo,id_color3, estado_oc,estilo_pmm)
                SELECT
                      C.COD_TEMPORADA,
                      C.DEP_DEPTO,
                      0 NJ1,
                      0 CJ1,
                      0 NJ2,
                      C.COD_JER2,
                      0 ITEM,
                      C.COD_SUBLIN,
                      0 COD_ESTILO,
                      C.DES_ESTILO,
                      C.VENTANA_LLEGADA,
                      '" . $proforma . "',
                      'Cargado..' ARCHIVO,
                      C.ID_COLOR3,
                      '' Estado_oc,
                      '' estilo_pmm
                      FROM PLC_PLAN_COMPRA_COLOR_3 C
                      LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
                      AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO =  '" . $depto . "'
                AND C.ID_COLOR3 = $id_insertar
                ";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_plan_compra_oc;
            $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND1--INSCOMPRAOC--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data_plan_compra_oc = \database::getInstancia()->getConsulta($sql_plan_compra_oc);

            // Se pudo ingresar el registro del archivo en plc_plan_compra_oc
            if ($data_plan_compra_oc) {

                // Actualizo plan_compra_color3 estado=18 y proforma=$proforma
                $sql_plan_compra_color_3 = "UPDATE plc_plan_compra_color_3
                SET estado = 18,
                proforma = '" . $proforma . "'
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND id_color3 = $id_insertar
                ";

                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                if (!file_exists('../archivos/log_querys/' . $login)) {
                    mkdir('../archivos/log_querys/' . $login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql_plan_compra_color_3;
                $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA--COND1--UPDPLANCOLOR3--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                fwrite($fp, $content);
                fclose($fp);

                $data_plan_compra_color_3 = \database::getInstancia()->getConsulta($sql_plan_compra_color_3);

                if ($data_plan_compra_color_3) {
                    return "OK";
                } else {
                    return "ERROR";
                }


            } else {
                return "ERROR";
            }


        }


    }



    // ######################## FIN TRABAJO CON NUEVA CARGA DE PROFORMA ########################


// Fin de la Clase
}