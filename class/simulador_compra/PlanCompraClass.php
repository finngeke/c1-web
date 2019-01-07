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
    public static function ListarPlanCompra($temporada, $depto, $login,$CURLOPT_PORT,$CURLOPT_URL,$nom_temp_corto)
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
                C.NOMBRE_COMPRADOR,           -- 11
                C.NOMBRE_DISENADOR,           -- 12 
                C.COMPOSICION,                -- 13 Composicion
                C.TIPO_DE_TELA,               -- 14
                C.FORRO,                      -- 15
                C.COLECCION,                  -- 16 Colección
                C.EVENTO,                     -- 17 Evento
                NOM_ESTILOVIDA COD_ESTILO_VIDA,  -- 18 estilo vida
                NOM_CALIDAD CALIDAD,             -- 19 Calidad
                C.NOM_OCACIONUSO COD_OCASION_USO,-- 20 ocacion uso
                C.NOM_PIRAMIDEMIX COD_PIRAMIX,   -- 21 piramide mix
                C.NOM_VENTANA,                   -- 22 ventana
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
                C.GM,                            -- 55 GM
                C.OFERTA,                        -- 56 Oferta 
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
                C.COMENTARIOS_POST_NEGOCIACION,  -- 78
                C.CODSKUPROVEEDOR,               -- 79 Cod SKU Proveedor
                O.COD_PADRE SKU,                 -- 80 Cod Padre
                C.PROFORMA,                      -- 81 Proforma
                O.ARCHIVO,                       -- 82 Archivo
                O.ESTILO_PMM,                    -- 83 Estilo Pmm
                O.ESTADO_MATCH,                  -- 84 Estado Match
                O.PO_NUMBER,                     -- 85 N OC
                O.ESTADO_OC,                     -- 86 Estado OC
                C.FECHA_EMBARQUE_ACORDADA,       -- 87
                O.FECHA_EMBARQUE,                -- 88 Fecha Embarque
                O.FECHA_ETA,                     -- 89 Fecha ETA
                O.FECHA_RECEPCION,               -- 90 Fecha Recepciòn
                O.DIAS_ATRASO,                   -- 91 Dias Atraso
                convert((SELECT nom_est_c1 FROM plc_estado_c1 WHERE cod_est_c1= C.ESTADO),'utf8','us7ascii')CODESTADO,  -- 92 Estado Opcion
                C.ESTADO ESTADO_C1,                       -- 93 Estado C1
                C.VENTANA_LLEGADA,                        -- 94 Ventana Llegada
                C.PROFORMA PROFORMA_BASE,                 -- 95 Proforma Base
                C.TIPO_EMPAQUE TIPO_EMPAQUE_BASE,         -- 96 Tipo empaque Base
                C.UNID_OPCION_INICIO UNI_INICIALES_BASE,  -- 97 Unidades Iniciales Base
                C.PRECIO_BLANCO PRECIO_BLANCO_BASE,       -- 98 Precio Blanco Base 
                C.COSTO_TARGET COSTO_TARGET_BASE,         -- 99 Target Base
                C.COSTO_FOB COSTO_FOB_BASE,               -- 100 FOB Base
                C.COSTO_INSP COSTO_INSP_BASE,             -- 101 Insp Base
                C.COSTO_RFID COSTO_RFID_BASE,             -- 102 RFID Base
                C.COD_MARCA,                              -- 103 COD_MARCA  
                C.N_CURVASXCAJAS,                         -- 104 N_CURVASXCAJAS
                C.COD_JER2,                               -- 105 cod_linea
                C.COD_SUBLIN,                             -- 106 cod_sublin
                O.ARCHIVO ARCHIVO_BASE,                   -- 107 Archivo
                REPLACE((SELECT DISTINCT FECHA_RECEPCD FROM plc_ventana_emb V WHERE V.cod_temporada = C.COD_TEMPORADA AND V.cod_ventana = C.VENT_EMB),'/','-') FECHA_RECEPCD_C1, -- 108 Fecha recepcion CD
                C.FORMATO FORMATO_BASE,                    -- 109 Formato
                C.EVENTO_INSTORE,                          -- 110 Evento In-Store
                C.DOSX,                                    -- 111 2X
                C.OPEX                                     -- 112 Opex
                FROM PLC_PLAN_COMPRA_COLOR_3 C
                LEFT JOIN PLC_PLAN_COMPRA_OC O ON C.COD_TEMPORADA = O.COD_TEMPORADA
				AND C.DEP_DEPTO = O.DEP_DEPTO AND C.ID_COLOR3 = O.ID_COLOR3
                WHERE C.COD_TEMPORADA = $temporada AND C.DEP_DEPTO = '" . $depto . "'
                ORDER BY C.ID_COLOR3, C.COD_JER2,C.COD_SUBLIN,C.COD_ESTILO,NVL(COD_COLOR,0) ,C.VENTANA_LLEGADA,C.DEBUT_REODER";

        $data = \database::getInstancia()->getFilas($sql);
        $dtPIs =[];$dt2021 =[];

        // Transformo a array asociativo (Para campos de texto utilizar UTF-8)
        $array1 = [];
        foreach ($data as $va1) {

            #region Vista oc + Cambio de estado Automatica
            $proforma = utf8_encode($va1["PROFORMA"]);$orden_compra = ""; $estadoOc = "";$f_embarque = "";$f_eta = "";$f_recepcion = "";$dias_atrasado = ""; $_exist = false; $ESTADO= $va1["ESTADO_C1"];$nom_estado= $va1["CODESTADO"];$estilo_pmm = utf8_encode($va1["ESTILO_PMM"]);$estado_match = utf8_encode($va1["ESTADO_MATCH"]);
            if ($proforma <> 'null' and $proforma <> null and $proforma <> '0' and $proforma <> '' and
                ($va1["ESTADO_C1"] == 18 or $va1["ESTADO_C1"] == 19 or $va1["ESTADO_C1"] == 22)) {

                //si ya paso por esta pi
                foreach ($dtPIs as $valor){
                    if ($valor[0] == $proforma){
                        $_exist = true;
                        $orden_compra =$valor[1];
                        $estadoOc = $valor[2];
                        $f_embarque =$valor[3];
                        $f_eta = $valor[4];
                        $f_recepcion = $valor[5];
                        $dias_atrasado = $valor[6];
                        $ESTADO = $valor[7];
                        $nom_estado =  $valor[8];
                    }
                }
                if ($_exist == false) {
                    //extracion broker por pi
                    $dt = json_decode(\simulador_compra\PlanCompraClass::TraerDatosOC2($proforma,0, $CURLOPT_PORT, $CURLOPT_URL));

                    if (($dt->Body->fault->faultCode == 0) and (count($dt->Body->detalleConsultaOrdenCompra->detalle)) > 0) {
                        $orden_compra = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->ordenCompra;
                        $estadoOc = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->estadoOC;
                        $f_embarque = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->fechaEmbarque;
                        $f_eta = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->fechaEta;
                        $f_recepcion = date("d-m-Y", (strtotime(date($f_eta) . "+ 15 days")));

                        try {
                            $datetime1 = date_create($f_recepcion);
                            $datetime2 = date_create($va1["FECHA_RECEPCD_C1"]);
                            $interval = date_diff($datetime2, $datetime1);
                            $dias_atrasado = $interval->format('%R%a');
                        } catch (Exception $e) {
                            $dias_atrasado = "";
                        }

                        $ESTADO = 19;
                        $nom_estado =  "Pendiente de Aprobacion sin Match";
                        //actualizamos el flujo de estado automatico
                        \simulador_compra\PlanCompraClass::UpdateEstavoVistaOC($temporada
                            , $depto
                            , $va1["ESTADO_C1"]
                            , $login
                            , $orden_compra
                            , $proforma
                            , $estadoOc);
                    }
                    array_push($dtPIs, array($proforma, $orden_compra, $estadoOc, $f_embarque, $f_eta, $f_recepcion, $dias_atrasado,$ESTADO,$nom_estado));
                }
            }
            elseif (($va1["ESTADO_C1"] == 20 or $va1["ESTADO_C1"] == 21) and $va1["PO_NUMBER"] <> null and $va1["PO_NUMBER"] <> ''){$_exist2 = false;
                //si ya paso por esta oc
                foreach ($dt2021 as $valor){
                    if ($valor[1] == $va1["PO_NUMBER"]){
                        $_exist2 = true;
                        if ($valor[4] == ""){
                            $orden_compra ="";
                        }else{
                            $orden_compra =$valor[1];
                        }
                        $estadoOc = $valor[2];
                        $f_embarque =$valor[3];
                        $f_eta = $valor[4];
                        $f_recepcion = $valor[5];
                        $dias_atrasado = $valor[6];
                        $ESTADO = $valor[7];
                        $nom_estado =  $valor[8];
                        $estilo_pmm =  $valor[9];
                        $estado_match =  $valor[10];
                    }
                }
                if ($_exist2 == false){
                    //extracion broker por oc
                    $dt = \simulador_compra\PlanCompraClass::TraerDatosOC3(utf8_encode($va1["PO_NUMBER"]));
                    if(count($dt) > 0) {
                        if ($dt[0]["COD_ESTADO"] == 7){
                            //actualizamos el flujo de estado automatico con oc estado cancelado
                            \simulador_compra\PlanCompraClass::UpdateEstavoVistaOC($temporada, $depto, $va1["ESTADO_C1"], $login, utf8_encode($va1["PO_NUMBER"]), $proforma, "");
                            $orden_compra =  "";
                            $estadoOc =  "";
                            $f_embarque = "";
                            $f_eta =  "";
                            $f_recepcion =  "";
                            $dias_atrasado =  "";
                            $ESTADO= 0;
                            $nom_estado= "Ingresado";
                            $estilo_pmm = "";
                            $estado_match="";
                            ;
                            array_push($dt2021, array($proforma, $va1["PO_NUMBER"], $estadoOc, $f_embarque, $f_eta, $f_recepcion, $dias_atrasado,$ESTADO,$nom_estado,$estilo_pmm,$estado_match));
                        }
                        elseif ($va1["ESTADO_C1"] == 20 and ($dt[0]["COD_ESTADO"] == 4 or $dt[0]["COD_ESTADO"] == 5 or $dt[0]["COD_ESTADO"] == 6 )){
                            $estadoOc = $dt[0]["NOM_ESTADO"];
                            $orden_compra =  utf8_encode($va1["PO_NUMBER"]);
                            $f_embarque = utf8_encode($va1["FECHA_EMBARQUE"]);
                            $f_eta =  utf8_encode($va1["FECHA_ETA"]);
                            $f_recepcion =  utf8_encode($va1["FECHA_RECEPCION"]);
                            $dias_atrasado =  utf8_encode($va1["DIAS_ATRASO"]);
                            $ESTADO= 21;
                            $nom_estado= "Aprobado";
                            //actualizamos el flujo de estado automatico
                            \simulador_compra\PlanCompraClass::UpdateEstavoVistaOC($temporada
                                , $depto
                                , $va1["ESTADO_C1"]
                                , $login
                                , $orden_compra
                                , $proforma
                                , $estadoOc);
                            array_push($dt2021, array($proforma, $va1["PO_NUMBER"], $estadoOc, $f_embarque, $f_eta, $f_recepcion, $dias_atrasado,$ESTADO,$nom_estado,$estilo_pmm,$estado_match));
                        }
                        else{
                            $orden_compra = $va1["PO_NUMBER"];
                            $estadoOc = ($va1["ESTADO_OC"]<> null ? ($va1["ESTADO_OC"]) :"");
                            $f_embarque =$va1["FECHA_EMBARQUE"];
                            $f_eta = $va1["FECHA_ETA"];
                            $f_recepcion = $va1["FECHA_RECEPCION"];
                            $dias_atrasado = ($va1["DIAS_ATRASO"]<> null ? ($va1["DIAS_ATRASO"]) :"");
                            $ESTADO= $va1["ESTADO_C1"];
                            $nom_estado= $va1["CODESTADO"];
							$estilo_pmm = $va1["ESTILO_PMM"];
							$estado_match = $va1["ESTADO_MATCH"];
                            array_push($dt2021, array($proforma, $va1["PO_NUMBER"], $estadoOc, $f_embarque, $f_eta, $f_recepcion, $dias_atrasado,$ESTADO,$nom_estado,$estilo_pmm,$estado_match));
                        }
                    }
                    else{
                        $orden_compra = $va1["PO_NUMBER"];
                        $estadoOc = ($va1["ESTADO_OC"]<> null ? ($va1["ESTADO_OC"]) :"");
                        $f_embarque =$va1["FECHA_EMBARQUE"];
                        $f_eta = $va1["FECHA_ETA"];
                        $f_recepcion = $va1["FECHA_RECEPCION"];
                        $dias_atrasado = ($va1["DIAS_ATRASO"]<> null ? ($va1["DIAS_ATRASO"]) :"");
                        $ESTADO= $va1["ESTADO_C1"];
                        $nom_estado= $va1["CODESTADO"];
                        $estilo_pmm = $va1["ESTILO_PMM"];
                        $estado_match = $va1["ESTADO_MATCH"];
                        array_push($dt2021, array($proforma, $va1["PO_NUMBER"], $estadoOc, $f_embarque, $f_eta, $f_recepcion, $dias_atrasado,$ESTADO,$nom_estado,$estilo_pmm,$estado_match));}

                }
            }


            // Agrega el Cero (0) al comienzo de la "," que aparecia
            if(substr($va1[61],0,1)==","){
                $rfid_corregido = str_replace(",","0,",$va1[61]);
            }else{
                $rfid_corregido = $va1[61];
            }

            // Agrega el Cero (0) al comienzo de la "," que aparecia
            if(substr($va1[73],0,1)==","){
                $agot_obj_corregido = str_replace(",","0,",$va1[73]);
            }else{
                $agot_obj_corregido = $va1[73];
            }

            // Nombre de la Temporada en Grilla
            if($va1[2]==3){
                $var_mom_temp = "Ttemp";
            }else{
                $var_mom_temp = substr($nom_temp_corto,0,2); //$va1[2];
            }


            array_push($array1
                , array(
                    "ID_COLOR3" => $va1[0]
                , "GRUPO_COMPRA" => $va1[1]
                , "COD_TEMP" => $var_mom_temp //$va1[2]
                , "LINEA" => $va1[3]
                , "SUBLINEA" => $va1[4]
                , "MARCA" => $va1[5]
                , "ESTILO" => utf8_encode($va1[6])
                , "SHORT_NAME" => $va1[7]
                , "ID_CORPORATIVO" => $va1[8]
                , "DESCMODELO" => utf8_encode($va1[9])
                , "DESCRIP_INTERNET" => utf8_encode($va1[10])
                , "NOMBRE_COMPRADOR" => utf8_encode($va1[11])
                , "NOMBRE_DISENADOR" => utf8_encode($va1[12])
                , "COMPOSICION" => utf8_encode($va1[13])
                , "TIPO_TELA" => utf8_encode($va1[14])
                , "FORRO" => utf8_encode($va1[15])
                , "COLECCION" => utf8_encode($va1[16])
                , "EVENTO" => utf8_encode($va1[17])
                , "EVENTO_INSTORE" => utf8_encode($va1[110]) // Evento In-Store
                , "COD_ESTILO_VIDA" => utf8_encode($va1[18])
                , "CALIDAD" => utf8_encode($va1[19])
                , "COD_OCASION_USO" => utf8_encode($va1[20])
                , "COD_PIRAMIX" => utf8_encode($va1[21])
                , "NOM_VENTANA" => utf8_encode($va1[22]) //ventana
                , "COD_RANKVTA" => utf8_encode($va1[23])
                , "LIFE_CYCLE" => utf8_encode($va1[24])
                , "NUM_EMB" => utf8_encode($va1[25])
                , "COD_COLOR" => utf8_encode($va1[26])
                , "TIPO_PRODUCTO" => utf8_encode($va1[27])
                , "TIPO_EXHIBICION" => utf8_encode($va1[28])
                , "DESTALLA" => utf8_encode(trim(str_replace(" ","",$va1[29])))
                , "TIPO_EMPAQUE" => utf8_encode($va1[30])
                , "PORTALLA_1_INI" => utf8_encode($va1[31])
                , "PORTALLA_1" => utf8_encode($va1[32])
                , "CURVATALLA" => utf8_encode($va1[33])
                , "CURVAMIN" => utf8_encode($va1[34])
                , "UNID_OPCION_INICIO" => $va1[35]
                , "UNID_OPCION_AJUSTADA" => $va1[36]
                , "CAN" => $va1[37]
                , "MTR_PACK" => $va1[38]
                , "CANT_INNER" => $va1[39]
                , "SEG_ASIG" => utf8_encode($va1[40])
                , "FORMATO" => utf8_encode($va1[41])
                , "TDAS" => utf8_encode($va1[42])
                , "A" => $va1[43]
                , "B" => $va1[44]
                , "C" => $va1[45]
                , "I" => $va1[46]
                , "UND_ASIG_INI" => $va1[47]
                , "ROT" => $va1[48]
                , "NOM_PRECEDENCIA" => utf8_encode($va1[49])
                , "NOM_VIA" => utf8_encode($va1[50])
                , "NOM_PAIS" => utf8_encode($va1[51])
                , "VIAJE" => utf8_encode($va1[52])
                , "MKUP" => utf8_encode($va1[53])
                , "PRECIO_BLANCO" => $va1[54]
                , "GM" => $va1[55]
                , "OFERTA" => utf8_encode($va1[56])
                , "DOSX" => trim($va1[111])
                , "OPEX" => trim($va1[112])
                , "COD_TIP_MON" => utf8_encode($va1[57])
                , "COSTO_TARGET" => $va1[58]
                , "COSTO_FOB" => $va1[59]
                , "COSTO_INSP" => $va1[60]
                , "COSTO_RFID" => $rfid_corregido //$va1[61]
                , "ROYALTY_POR" => $va1[62]
                , "COSTO_UNIT" => $va1[63]
                , "COSTO_UNITS" => $va1[64]
                , "CST_TOTLTARGET" => $va1[65]
                , "COSTO_TOT" => $va1[66]
                , "COSTO_TOTS" => $va1[67]
                , "RETAIL" => $va1[68]
                , "DEBUT_REODER" => utf8_encode($va1[69])
                , "SEM_INI" => $va1[70]
                , "SEM_FIN" => $va1[71]
                , "CICLO" => utf8_encode($va1[72])
                , "AGOT_OBJ" => $agot_obj_corregido //$va1[73]
                , "SEMLIQ" => $va1[74]
                , "ALIAS_PROV" => utf8_encode($va1[75])
                , "COD_PROVEEDOR" => utf8_encode($va1[76])
                , "COD_TRADER" => utf8_encode($va1[77])
                , "AFTER_MEETING_REMARKS" => utf8_encode($va1[78])
                , "CODSKUPROVEEDOR" => utf8_encode($va1[79])
                , "SKU" => utf8_encode($va1[80])
                , "PROFORMA" => utf8_encode($va1[81])
                , "ARCHIVO" => str_replace("null","",utf8_encode($va1[82]))
                , "ESTILO_PMM" => utf8_encode($estilo_pmm)
                , "ESTADO_MATCH" => utf8_encode($estado_match)
                , "PO_NUMBER" => utf8_encode($orden_compra)
                , "ESTADO_OC" => utf8_encode($estadoOc)
                , "FECHA_ACORDADA" => $va1[87]
                , "FECHA_EMBARQUE" => $f_embarque
                , "FECHA_ETA" => $f_eta
                , "FECHA_RECEPCION" => $f_recepcion
                , "DIAS_ATRASO" => $dias_atrasado
                , "CODESTADO" => utf8_encode($nom_estado)
                , "ESTADO_C1" => $ESTADO
                , "VENTANA_LLEGADA" => utf8_encode($va1[94])
                , "PROFORMA_BASE" => utf8_encode($va1[95])
                , "TIPO_EMPAQUE_BASE" => utf8_encode($va1[96])
                , "UNI_INICIALES_BASE" => $va1[97]
                , "PRECIO_BLANCO_BASE" => $va1[98]
                , "COSTO_TARGET_BASE" => $va1[99]
                , "COSTO_FOB_BASE" => $va1[100]
                , "COSTO_INSP_BASE" => $va1[101]
                , "COSTO_RFID_BASE" => $rfid_corregido //$va1[102]
                , "COD_MARCA" => $va1[103]
                , "N_CURVASXCAJAS" => $va1[104]
                , "COD_JER2" => $va1[105] //cod_linea
                , "COD_SUBLIN" => $va1[106]
                , "ARCHIVO_BASE" => $va1[107]
                , "FORMATO_BASE" => utf8_encode($va1[41])


                )
            );


        }


        return $array1;



    }

    // Devuelve la Cantidad de Registros
    public static function CantidadRegistrosPlanCompra($temporada, $depto, $login,$CURLOPT_PORT,$CURLOPT_URL)
    {

        $sql = "SELECT COUNT(*)
                FROM PLC_PLAN_COMPRA_COLOR_3
                WHERE COD_TEMPORADA = $temporada AND DEP_DEPTO = '" . $depto . "'";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    //extraer datos orden de compra poc OC o PI
    public static function TraerDatosOC2($pi,$oc,$puerto,$url){
        $curl = curl_init();



        if ($pi){
            $oc = "";
        }elseif($oc){
            $pi = "";
        }

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

    public static function UpdateEstavoVistaOC($temporada, $depto, $estado, $login, $po_number, $proforma,$estado_oc)
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

    Public static function TraerDatosOC3($oc){
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

    function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","Ñ");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","N");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }

    //##################################################### FIN LISTAR PLANCOMPRA ##########################################################


    // Guarda datos asociado a la Proforma y Archivo
    public static function GuardaProforma($temporada, $depto, $login, $proforma, $id_insertar, $archivo)
    {

        /*$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","Ñ");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","N");
        $proforma = str_replace($no_permitidas, $permitidas ,$proforma);*/

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
                AND C.ID_COLOR3 = $id_insertar";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_plan_compra_oc;
            $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA-COND1A-INSCOMPRAOC-" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data_plan_compra_oc = \database::getInstancia()->getConsulta($sql_plan_compra_oc);


            // Aquí voy a buscar todos los registros de plan color 3 que tengan la misma PI (Excluyendo el id_color 3 ya ingresado) y los agrego a plc_plan_compra_oc


            // Si puedo guardar en plc_plan_compra_oc, actualizo plc_plan_compra_color_3
            if ($data_plan_compra_oc) {

                // 2.- Actualiza plc_plan_compra_color3 estado=18 y proforma = $proforma
                $sql_plan_compra_color_3 = "UPDATE plc_plan_compra_color_3
                SET proforma = '" . $proforma . "',
                estado = 19
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
                $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA-COND1A-UPDPLANCOLOR3-" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
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
                    $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA-COND1A-INSERTHISTORIAL-" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
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
            $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA-COND2SA-UPDPLANCOLOR3-" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
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
                $fp = fopen("../archivos/log_querys/" . $login . "/ACTPROFORMA-COND2SA-INSERTHISTORIAL-" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
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


    // Procesar el JSON que llega (Devolvemos 0 (Cero) cuando la ejecución sea correcta)
    // public static function ProcesaDataPlanCompra($TEMPORADA, $DEPTO, $LOGIN, $ID_COLOR3, $GRUPO_COMPRA, $COD_TEMP, $LINEA, $SUBLINEA, $MARCA, $ESTILO, $SHORT_NAME, $ID_CORPORATIVO, $DESCMODELO, $DESCRIP_INTERNET, $NOMBRE_COMPRADOR, $NOMBRE_DISENADOR, $COMPOSICION, $TIPO_TELA, $FORRO, $COLECCION, $EVENTO, $COD_ESTILO_VIDA, $CALIDAD, $COD_OCASION_USO, $COD_PIRAMIX, $NOM_VENTANA, $COD_RANKVTA, $LIFE_CYCLE, $NUM_EMB, $COD_COLOR, $TIPO_PRODUCTO, $TIPO_EXHIBICION, $DESTALLA, $TIPO_EMPAQUE, $PORTALLA_1_INI, $PORTALLA_1, $CURVATALLA, $CURVAMIN, $UNID_OPCION_INICIO, $UNID_OPCION_AJUSTADA, $CAN, $MTR_PACK, $CANT_INNER, $SEG_ASIG, $FORMATO, $TDAS, $A, $B, $C, $I, $UND_ASIG_INI, $ROT, $NOM_PRECEDENCIA, $NOM_VIA, $NOM_PAIS, $VIAJE, $MKUP, $PRECIO_BLANCO, $OFERTA, $GM, $COD_TIP_MON, $COSTO_TARGET, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $ROYALTY_POR, $COSTO_UNIT, $COSTO_UNITS, $CST_TOTLTARGET, $COSTO_TOT, $COSTO_TOTS, $RETAIL, $DEBUT_REODER, $SEM_INI, $SEM_FIN, $CICLO, $AGOT_OBJ, $SEMLIQ, $ALIAS_PROV, $COD_PROVEEDOR, $COD_TRADER, $AFTER_MEETING_REMARKS, $CODSKUPROVEEDOR, $SKU, $PROFORMA, $ARCHIVO, $ESTILO_PMM, $ESTADO_MATCH, $PO_NUMBER, $ESTADO_OC, $FECHA_ACORDADA, $FECHA_EMBARQUE, $FECHA_ETA, $FECHA_RECEPCION, $DIAS_ATRASO, $CODESTADO, $ESTADO_C1, $VENTANA_LLEGADA, $PROFORMA_BASE, $TIPO_EMPAQUE_BASE, $UNI_INICIALES_BASE, $PRECIO_BLANCO_BASE, $COSTO_TARGET_BASE, $COSTO_FOB_BASE, $COSTO_INSP_BASE, $COSTO_RFID_BASE, $COD_MARCA, $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN, $ARCHIVO_BASE)
    // public static function ProcesaDataPlanCompra($TEMPORADA, $DEPTO, $LOGIN, $ID_COLOR3, $NOM_VENTANA,$DESTALLA, $TIPO_EMPAQUE, $PORTALLA_1_INI, $CURVATALLA, $UNID_OPCION_INICIO, $CAN, $SEG_ASIG, $FORMATO, $A, $B, $C, $I, $NOM_VIA, $NOM_PAIS, $PRECIO_BLANCO, $COSTO_TARGET, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $DEBUT_REODER, $TIPO_EMPAQUE_BASE, $UNI_INICIALES_BASE, $PRECIO_BLANCO_BASE, $COSTO_TARGET_BASE, $COSTO_FOB_BASE, $COSTO_INSP_BASE, $COSTO_RFID_BASE, $COD_MARCA, $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN)
    public static function ProcesaDataPlanCompra($TEMPORADA, $DEPTO, $LOGIN, $ID_COLOR3,$ESTADO_C1, $PROFORMA, $ARCHIVO,$PROFORMA_BASE,$ARCHIVO_BASE,$ALIAS_PROV, $NOM_VENTANA,$DESTALLA, $TIPO_EMPAQUE, $PORTALLA_1_INI, $CURVATALLA, $UNID_OPCION_INICIO, $CAN, $SEG_ASIG, $FORMATO, $A, $B, $C, $I, $NOM_VIA, $NOM_PAIS, $PRECIO_BLANCO, $COSTO_TARGET, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $DEBUT_REODER, $TIPO_EMPAQUE_BASE, $UNI_INICIALES_BASE, $PRECIO_BLANCO_BASE, $COSTO_TARGET_BASE, $COSTO_FOB_BASE, $COSTO_INSP_BASE, $COSTO_RFID_BASE, $COD_MARCA, $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN,$FORMATO_BASE)
    {

        // ############################################# 1 VALIDACION CURVADO #############################################
        // Validar Tipo Empaque (DEBUT=Curvado)
        if (($TIPO_EMPAQUE == null) || ($TIPO_EMPAQUE == "") || ($TIPO_EMPAQUE == "null")) {
            return " ID: " . $ID_COLOR3 . " - Se ha enviado un empaque vacio.";
            die();
        }

            if($TIPO_EMPAQUE == "CURVADO"){

                // Validar Unidades Iniciales
                if (($UNID_OPCION_INICIO == null) || ($UNID_OPCION_INICIO == "") || ($UNID_OPCION_INICIO == "null") || (!$UNID_OPCION_INICIO)) {
                    return " ID: " . $ID_COLOR3 . " - Se ha enviado Unidad Iniciales vacia.";
                    die();
                }

                // Validar Formato
                if (($FORMATO == null) || ($FORMATO == "") || ($FORMATO == "null") || (strlen($FORMATO)==0)) {
                    return " ID: " . $ID_COLOR3 . " - Se ha enviado un formato vacio.";
                    die();
                }

                // Validar Ventana
                if (($NOM_VENTANA == null) || ($NOM_VENTANA == "") || ($NOM_VENTANA == "null")) {
                    return " ID: " . $ID_COLOR3 . " - Se ha enviado un registro sin ventana.";
                    die();
                }

                // Validar que llega la Vía
                $array_vias = array("MARITIMO", "AEREA", "TERRESTRE");
                if (!in_array(strtoupper($NOM_VIA), $array_vias)) {
                    return " ID: " . $ID_COLOR3 . " - El valor enviado en la columna Via, no corresponde.";
                    die();
                }

                // Validar que lleguen los datos asociados al curvado
                if (!isset($TIPO_EMPAQUE) || !isset($PORTALLA_1_INI) || !isset($DESTALLA) || !isset($CURVATALLA) || ($UNID_OPCION_INICIO <= 0) || ($SEG_ASIG == null) || ($SEG_ASIG == '')) {
                    return " ID: " . $ID_COLOR3 . " - No pueden estar en blanco los Campos: Tipo Empaque, Porcent Ini,Tallas,Curvas,Und Iniciales.";
                    die();
                }
            }
        // ########################################### FIN VALIDACION CURVADO ###########################################


        // ################################# 2 VALIDACION FOB - PROV - FECHA ACORDADA #############################################
        // Validar Costo FOB
        if (($COSTO_FOB != 0) && ($COSTO_FOB != null) && ($COSTO_FOB != "") && ($COSTO_FOB != "null")) {

            // Validar Proveedor
            if (($ALIAS_PROV == null) || ($ALIAS_PROV == "") || ($ALIAS_PROV == "null") || (is_numeric($ALIAS_PROV))) {
                return " ID: " . $ID_COLOR3 . " - Se ha enviado campo Proveedor Vacio.";
                die();
            }

            // Validar Fecha Acordada
            /*if (($FECHA_ACORDADA == null) || ($FECHA_ACORDADA == "") || ($FECHA_ACORDADA == "null")) {
                return " ID: " . $ID_COLOR3 . " - Se ha enviado campo Fecha Acordada Vacio.";
                die();
            }*/

        }
        // Validar Proveedor
        if (($ALIAS_PROV != null) && ($ALIAS_PROV != "") && ($ALIAS_PROV != "null") ) {

            // Validar Costo FOB
            if (($COSTO_FOB == 0) || ($COSTO_FOB == null) || ($COSTO_FOB == "") || ($COSTO_FOB == "null")) {
                return " ID: " . $ID_COLOR3 . " - Se ha enviado campo FOB Vacio o Cero.";
                die();
            }

            // Validar Fecha Acordada
            /*if (($FECHA_ACORDADA == null) || ($FECHA_ACORDADA == "") || ($FECHA_ACORDADA == "null")) {
                return " ID: " . $ID_COLOR3 . " - Se ha enviado campo Fecha Acordada Vacio.";
                die();
            }*/

        }
        // Validar Fecha Acordada
        /*if (($FECHA_ACORDADA != null) && ($FECHA_ACORDADA != "") && ($FECHA_ACORDADA != "null")) {

            // Validar Proveedor
            if (($ALIAS_PROV == null) || ($ALIAS_PROV == "") || ($ALIAS_PROV == "null") ) {
                return " ID: " . $ID_COLOR3 . " - Se ha enviado campo Proveedor Vacio.";
                die();
            }

            // Validar Costo FOB
            if (($COSTO_FOB == null) || ($COSTO_FOB == "") || ($COSTO_FOB == "null")) {
                return " ID: " . $ID_COLOR3 . " - Se ha enviado campo FOB Vacio.";
                die();
            }

        }*/
        // ################################# FIN VALIDACION FOB - PROV - FECHA ACORDADA #############################################


        // ###################################### 3 GUARDADO CAMPOS DE TEXTO SIMPLE ####################################
        // ######################### (Campos de Texto que no requieren validación, update directo) #####################
        $query_campos_libres = PlanCompraClass::ActualizaPlanCompraCamposLibre($TEMPORADA, $DEPTO, $LOGIN, $ID_COLOR3,$ALIAS_PROV);
        if($query_campos_libres != "OK"){
            return " ID: " . $ID_COLOR3 . " - No se pudo Actualizar Campo de Libre Edicion.";
            die();
        }
        // ###################################### FIN GUARDADO CAMPOS DE TEXTO SIMPLE ####################################


        // ############################################# 4 GUARDADO PROFORMA ###########################################
        // ############################ (Independiente de Curvado y Otras Actualizaciones) #############################
        // 1.- Si la proforma base no es igual a la que nos llega, hay que aplicar la función de guardado de proforma.
        if ((($PROFORMA_BASE != $PROFORMA) && (is_null($PROFORMA_BASE))) || ($ARCHIVO_BASE != $ARCHIVO)) {

            // Si llega $PROFORMA y $ID_COLOR3
            if ((!empty($PROFORMA)) && (!empty($ID_COLOR3)) && ($ESTADO_C1 == 0)) {

                $sube_archivo = 0;
                if ($ARCHIVO == "Cargado..") {
                    $sube_archivo = 1;
                }

                // Aplicar guardado de proforma
                $query_proforma = PlanCompraClass::GuardaProforma($TEMPORADA, $DEPTO, $LOGIN, $PROFORMA, $ID_COLOR3, $sube_archivo);
                if (!$query_proforma) {
                    return " ID: " . $ID_COLOR3 . " - No se pudo realizar la actualización de la proforma.";
                    die();
                }/*else{
                    return 0;
                }*/


                // Fin Validación Campos Necesarios
            }

            // Fin validación PROFORMA
        }
        // ########################################## FIN GUARDADO PROFORMA ############################################




        // ############################################# SETEO DE VARIABLES #############################################
         // Validar Campo $COSTO_TARGET
         $COSTO_TARGET = str_replace(",", ".", $COSTO_TARGET);
         if (empty($COSTO_TARGET) || (!is_numeric($COSTO_TARGET)) || ($COSTO_TARGET == null) || ($COSTO_TARGET == '')) {
             $COSTO_TARGET = 0;
         }
         // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
         if (substr($COSTO_TARGET, 0, 1) == ".") {
             $COSTO_TARGET = "0" . $COSTO_TARGET;
         }

         // Validar Campo $COSTO_FOB
         $COSTO_FOB = str_replace(",", ".", $COSTO_FOB);
         if (empty($COSTO_FOB) || (!is_numeric($COSTO_FOB)) || ($COSTO_FOB == null) || ($COSTO_FOB == '')) {
             $COSTO_FOB = 0;
         }
         // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
         if (substr($COSTO_FOB, 0, 1) == ".") {
             $COSTO_FOB = "0" . $COSTO_FOB;
         }

         // Validar Campo $COSTO_INSP
         $COSTO_INSP = str_replace(",", ".", $COSTO_INSP);
         if (empty($COSTO_INSP) || (!is_numeric($COSTO_INSP)) || ($COSTO_INSP == null) || ($COSTO_INSP == '')) {
             $COSTO_INSP = 0;
         }
         // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
         if (substr($COSTO_INSP, 0, 1) == ".") {
             $COSTO_INSP = "0" . $COSTO_INSP;
         }

         // Validar Campo $COSTO_RFID
         $COSTO_RFID = str_replace(",", ".", $COSTO_RFID);
         if (empty($COSTO_RFID) || (!is_numeric($COSTO_RFID)) || ($COSTO_RFID == null) || ($COSTO_RFID == '')) {
             $COSTO_RFID = 0;
         }
         // Si el primer caracter es solo un punto, le concateno un "cero" para poder trabajar con el
         if (substr($COSTO_RFID, 0, 1) == ".") {
             $COSTO_RFID = "0" . $COSTO_RFID;
         }

         // Transforma a Número el "Nombre de la Vía"
         $NOM_VIA_NUMERO = 0;
         if ($NOM_VIA == "MARITIMO") {
             $NOM_VIA_NUMERO = 1;
         } elseif ($NOM_VIA == "AEREA") {
             $NOM_VIA_NUMERO = 2;
         } elseif ($NOM_VIA == "TERRESTRE") {
             $NOM_VIA_NUMERO = 3;
         }

         // Traer Número País
         $query_numero_pais = PlanCompraClass::BuscaNumeroPais(strtoupper($NOM_PAIS));
         $NOM_PAIS_NUMERO = $query_numero_pais[0];
         if (empty($NOM_PAIS_NUMERO)) {
             return " ID: " . $ID_COLOR3 . " - No pudimos encontrar el nombre de pais ingresado, verifique que el texto ingresado existe.";
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
             return " ID: " . $ID_COLOR3 . " - Factor y Tipo de Cambio llegan en Cero(0).";
             die();
         }
         // ########################################## FIN SETEO DE VARIABLES ############################################


        // ############################### CÁLCULO CON LAS VARIABLES DEFINIDAS PREVIAMENTE ##############################
        $total_fob_usd = 0;
        $total_target_usd = 0;
        $costo_unitario_final_usd = 0;


        // Cálculos
        // Costo unitarios final US$ : (Fob o target) + insp + rfid
        if ($COSTO_FOB > 0) {
            $costo_unitario_final_usd = $COSTO_FOB + $COSTO_INSP + $COSTO_RFID;
            $costo_unitario_final_usd = number_format($costo_unitario_final_usd, 2, '.', '');
            $total_fob_usd = $costo_unitario_final_usd * $CAN;
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
            $costo_unitario_final_pesos = round($costo_unitario_final_pesos, 0);
        } else {
            $costo_unitario_final_pesos = $costo_unitario_final_usd * $query_tipo_cambio;
            $costo_unitario_final_pesos = round($costo_unitario_final_pesos, 0);
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
        if (($PRECIO_BLANCO > 0) && ($CAN > 0)) {
            $costo_retail = round((($PRECIO_BLANCO * $CAN) / 1.19), 0, PHP_ROUND_HALF_UP);
        }


        //validaciones
       if ($DEBUT_REODER == "DEBUT"){
           if ( ($TIPO_EMPAQUE == '') || ($TIPO_EMPAQUE == null) || ($PORTALLA_1_INI == '') || ($PORTALLA_1_INI == null) || ($DESTALLA == '') || ($DESTALLA == null) || ($CURVATALLA == '') || ($CURVATALLA == null) || ($UNID_OPCION_INICIO == 0) || ($SEG_ASIG == null) || ($SEG_ASIG == '') ){
               return " ID: " . $ID_COLOR3 . " - DEBUT Error validacion curvado. ";
               die();
           }
       }else{
           if ( ($TIPO_EMPAQUE == '') || ($TIPO_EMPAQUE == null) || ($PORTALLA_1_INI == '') || ($PORTALLA_1_INI == null) || ($DESTALLA == '') || ($DESTALLA == null) || ($CURVATALLA == '') || ($CURVATALLA == null) || ($UNID_OPCION_INICIO == 0) ){
               return " ID: " . $ID_COLOR3 . " - REORDER Error validacion Ajuste MasterPack. ";
               die();
           }
       }


        // 1.- Realizar cálculos del curvado... siempre y cuando los datos que llegan sean distinto de los datos base

        // Hay que ir a buscar el Curvado
        $query_curva = PlanCompraClass::CalculoCurvadoPlanCompra($TIPO_EMPAQUE, $DESTALLA, $CURVATALLA, $UNID_OPCION_INICIO, $SEG_ASIG, $FORMATO, $A, $B, $C, $I, $DEBUT_REODER, $PORTALLA_1_INI, $DEPTO, $TEMPORADA, $COD_MARCA, $N_CURVASXCAJAS, $COD_JER2, $COD_SUBLIN, $ID_COLOR3, 1);
        // Valido que se pueda realizar la QUERY
        if (!$query_curva) {
            return " ID: " . $ID_COLOR3 . " - No se pudo buscar curvado.";
            die();
        }
        $CURVA_UNID_AJUST = $query_curva[0]; //  unid ajust
        $CURVA_POR_AJUSTE = $query_curva[1]; //  porcenajust
        $CURVA_N_CAJAS = $query_curva[2]; //  N° CAJAS
        $CURVA_UNID_FINAL = $query_curva[3]; //  unidfinal
        $CURVA_PRIMERA_CARGA = $query_curva[4]; //  primera carga
        $CURVA_TDAS = $query_curva[5]; //  tiendas
        $CURVA_UNIDAJUSTXTALLA = $query_curva[6]; //  unidadesajustXtalla


        // Valido que lleguen todos los datos de la QUERY
        /*if (empty($CURVA_UNID_AJUST) || empty($CURVA_POR_AJUSTE) || empty($CURVA_N_CAJAS) || empty($CURVA_UNID_FINAL) || empty($CURVA_PRIMERA_CARGA) || empty($CURVA_TDAS) || empty($CURVA_UNIDAJUSTXTALLA)) {
            return " ID: " . $ID_COLOR3 . " - No se pudo obtener los datos del curvado, revise la data ingresada.";
            die();
        }*/


        // Variables que se van enviar al UPDATE
        $COSTO_UNIT = $costo_unitario_final_usd;
        $COSTO_UNITS = $costo_unitario_final_pesos;
        $CST_TOTLTARGET = $total_target_usd;
        $COSTO_TOT = $total_fob_usd;
        $COSTO_TOTS = $costo_total_pesos;
        $MKUP = $nuevo_mkup;
        $GM = $nuevo_gm;
        $PROVEEDOR = $ALIAS_PROV;
        $PAIS = $NOM_PAIS_NUMERO;
        $NOM_PAIS = $NOM_PAIS;
        $VIA = $NOM_VIA_NUMERO;
        $NOM_VIA = $NOM_VIA;
        $FACTOR_EST = $factor_est_campo;
        $TARGET = $COSTO_TARGET;
        // Nombres Propios (Cálculo Curvado)
        // $CURVA_UNID_AJUST       //  unid ajust (Enviado a ActualizaPlanCompra)
        // $CURVA_POR_AJUSTE       //  porcenajust (Enviado a ActualizaPlanCompra)
        // $CURVA_N_CAJAS          //  N° CAJAS (Enviado a ActualizaPlanCompra)
        // $CURVA_UNID_FINAL       //  unidfinal
        // $CURVA_PRIMERA_CARGA    //  primera carga
        // $CURVA_TDAS             //  tiendas (Enviado a ActualizaPlanCompra)
        // $CURVA_UNIDAJUSTXTALLA  //  unidadesajustXtalla (Enviado a ActualizaPlanCompra)
        $UNIDADES_FINALES = $CAN;
        $UNIDADES_INICIALES = $UNID_OPCION_INICIO;
        $cluster_ = $SEG_ASIG;
        $marca_ = $COD_MARCA;
        $debut_ = $DEBUT_REODER;
        $tipo_emp_ = $TIPO_EMPAQUE;
        $formatos_ = $FORMATO;
        $precioRetail_ = $costo_retail;
        $precio_blanco_ = $PRECIO_BLANCO;
        $COSTO = $costo_total_pesos;


        // Actualizar PLC_PLAN_COMPRA_COLOR_3 incluye PLC_PLAN_COMPRA_COLOR_CIC
        $query_tipo_cambio = PlanCompraClass::ActualizaPlanCompra($TEMPORADA, $DEPTO, $LOGIN, $ID_COLOR3, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $COSTO_UNIT, $COSTO_UNITS, $CST_TOTLTARGET,
            $COSTO_TOT, $COSTO_TOTS, $MKUP, $GM, $PROVEEDOR, $VIA, $PAIS, $FACTOR_EST, $NOM_VIA, $NOM_PAIS, $TARGET, $tipo_emp_, $UNIDADES_INICIALES, $CURVA_UNID_AJUST, $UNIDADES_FINALES,
            $CURVA_POR_AJUSTE, $CURVA_TDAS, $formatos_, $CURVA_N_CAJAS, $CURVA_UNIDAJUSTXTALLA, $marca_, $cluster_, $debut_, $precioRetail_, $precio_blanco_, $COSTO);
        if (!$query_tipo_cambio) {
            return " ID: " . $ID_COLOR3 . " - No se pudo ejecutar la función ActualizaPlanCompra.";
            die();
        }else{
            return 0;
        }


    // Fin ProcesaDataPlanCompra
    }


    public static function CalculoCurvadoPlanCompra($tipo_empaque, $tallas, $curvas_talla, $und_iniciales, $cluster, $formato
        , $A, $B, $C, $I, $debut_reoder, $PORTALLA_1_INI, $depto, $cod_tempo, $marca, $N_CURVASXCAJAS
        , $cod_linea, $cod_sublinea, $id_color3, $Guardado)
    {

        // echo $cod_linea." / ".$cod_sublinea." / ".$depto;
        // die();

        //var_dump($_REQUEST);
        //die();

        $dtmstpack = PlanCompraClass::list_mstpack($cod_linea, $cod_sublinea, $depto);
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
            $clusters = explode("+", PlanCompraClass::list_inter_tds_cluster($depto, $marca, $cod_tempo, $cluster, $formato));
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
                        $ntdas = PlanCompraClass::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                    } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                        $ntdas = PlanCompraClass::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
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
                $clusters = explode("+", PlanCompraClass::list_inter_tds_cluster($depto, $marca, $cod_tempo, $cluster, $formato));
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
                            $ntdas = PlanCompraClass::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = PlanCompraClass::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
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
                $clusters = explode("+", PlanCompraClass::list_inter_tds_cluster($depto, $marca, $cod_tempo, $cluster, $formato));
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
                            $ntdas = PlanCompraClass::list_tdas_sin_formato($depto, $marca, $cod_tempo, $varc);
                        } elseif ($formato <> "" AND $formato <> "SIN FORMATO") {
                            $ntdas = PlanCompraClass::list_tdas_con_formato($depto, $marca, $cod_tempo, $varc, $formato);
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
            $_query = PlanCompraClass::SaveAjuste_Compra2(/*AJUSTE DE COMPRA*/
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


    // Actualiza PlanCompra, incluye calculos del curvado si aplican
    public static function ActualizaPlanCompra($temporada, $depto, $login, $ID_COLOR3, $COSTO_FOB, $COSTO_INSP, $COSTO_RFID, $COSTO_UNIT, $COSTO_UNITS, $CST_TOTLTARGET, $COSTO_TOT,
                                               $COSTO_TOTS, $MKUP, $GM, $PROVEEDOR
        , $VIA, $PAIS, $FACTOR_EST, $NOM_VIA, $NOM_PAIS, $TARGET
        , $tipo_empaque, $und_inicial, $und_ajust, $und_final, $porcent_ajust, $porcent_tdas, $formato
        , $cant_cajas, $und_ajust_xtallas, $cod_marca, $cluster, $debut_, $retail, $precio_blanco, $COSTO)
    {


        $_Error = false;
        $und_ajust_xtallas = str_replace("\"", "", $und_ajust_xtallas);
        $und_ajust = str_replace("\"", "", $und_ajust);
        $dtdivicantidad = PlanCompraClass::Division_cantidades($und_ajust_xtallas);
        $dtdiviporcent = PlanCompraClass::Division_porcent($porcent_ajust);

        $tdas = 0;
        if (strtoupper($debut_) == "DEBUT") {
            $tdas = PlanCompraClass::get_N_tdas($depto, $cod_marca, $temporada, $cluster, $formato);
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
                    NOM_VIA = '" . strtoupper($NOM_VIA) . "', 
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
            $_Error = true;
        }

        //UPDATE PLC_PLAN_COMPRA_COLOR_CIC
        if ($_Error == true) {

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

            if (\database::getInstancia()->getConsulta($sql)) {
                return 1;
            } else {
                return 0;
            }


        } else {
            return 0;
        }

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


    Public static function list_mstpack ($linea,$sublinea,$depto){

        $sql = "SELECT MSTPACK FROM PLC_MSTPACK
                WHERE COD_DEPTO = '".$depto."'
                AND COD_LIN =  '".$linea."'
                AND COD_SUBLIN = '".$sublinea."'";
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


    // Al Actualizar la grilla, los campos que no requieren ser calculados... se actualizan antes del match
    public static function ActualizaPlanCompraCamposLibre($temporada, $depto, $login, $ID_COLOR3, $ALIAS_PROV)
    {

        $sql = "UPDATE PLC_PLAN_COMPRA_COLOR_3 
                  SET ALIAS_PROV = '" . $ALIAS_PROV . "'
                WHERE COD_TEMPORADA = $temporada
                    AND DEP_DEPTO = '" . $depto . "'
                    AND ID_COLOR3 = $ID_COLOR3";

        // Almacenar TXT LOG
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }

        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/" . $login . "/PLANCOMPRA-ActualizaPlanCompraCamposLibre--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);
        $data = \database::getInstancia()->getConsulta($sql);

        if($data){
            return "OK";
        }else{
            return "ERROR";
        }

    }

    // Actualiza la fecha del registro de concurrencia
    public static function ActualizaFechaConcurrencia($temporada, $depto, $login)
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


    // Busca Numero País por Nombre Ingresado
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


    // Busca Factor
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


    // Buscar Tipo de Cambio
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


    // Listar Historial
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
        //return $data;

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "ID" => $va1[0]
                , "NOMBRE_PAIS" => $va1[1]
                )
            );
        }


        return $array1;


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
        // return $data;

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "ID" => $va1[1]
                , "NOMBRE_FORMATO" => $va1[0]
                )
            );
        }

        return $array1;



    }

    // Busca Proveedor Grilla Editar
    public static function ListarProveedor($temporada, $depto)
    {

        $sql = "SELECT COD_PROVEEDOR,NOM_PROVEEDOR FROM plc_proveedores_pmm";

        $data = \database::getInstancia()->getFilas($sql);
        // return $data;

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "ID" => $va1[0]
                , "NOMBRE_PROVEEDOR" => $va1[1]
                )
            );
        }

        return $array1;



    }


    // Busca Ventana Grilla Editar
    public static function ListarVentana($temporada, $depto)
    {

        $sql = "SELECT * FROM plc_ventana";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }


    // Consultar OC Linkeada
    public static function ConsultaOCLinkeada($temporada, $depto, $login, $oc){

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
    public static function QuitarOCCancelada($login,$pi,$oc)
    {

        // Quito Registros Extras por OC
        $sql_oc = "DELETE FROM B
                   WHERE ORDEN_DE_COMPRA = $oc";
        $data_oc = \database::getInstancia()->getConsulta($sql_oc);

        // Quito los registros por PI
        $sql_pi = "DELETE FROM B
                   WHERE PI = '" . $pi . "'";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql_pi;
        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-QUITAOCCANCELADA--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql_pi);

        if($data){
            return 1;
        }else{
            return 0;
        }

    }


    // Trabajando en MATCH llenar tabla PMM
    public static function MatchLlenarGridPMM($temporada, $depto, $login, $oc, $pi,$puerto,$url)
    {

        // $oc = 9146497;
        // Consulta OC Linkeada (Revisar, no se agrega por que se valida antes de levantar popup match)

        // Quitar OC Cancelada
        $query_quitar_OC_cancelada = PlanCompraClass::QuitarOCCancelada($login,$pi,$oc);
        if ($query_quitar_OC_cancelada == 0) {
            return json_encode("error-No se pudo quitar las OC Canceladas.");
            die();
        // Se quitaron las OC Canceladas
        }else{

            // Traer Datos OC desde WS
            $query_trae_datos_oc = json_decode(PlanCompraClass::BrokerTraerDatosOC($pi,$puerto,$url));
            if ($query_trae_datos_oc->Body->fault->faultCode != 0) {
                return json_encode("error-No Conecta a BROKER para Traer Datos OC.");
                die();
            }else{

                // Recorre los Datos y los guarda en tabla B
                $flag_incremental = 0;
                foreach ($query_trae_datos_oc->Body->detalleConsultaOrdenCompra as $columna){
                    foreach($columna as $columna2){

                        $ordenCompra = $columna[$flag_incremental]->ordenCompra;
                        $PI = $columna[$flag_incremental]->PI;
                        $nombreEstilo = trim($columna[$flag_incremental]->nombreEstilo);
                        $numeroEstilo = trim($columna[$flag_incremental]->numeroEstilo);
                        $estado = $columna[$flag_incremental]->estado;
                        $nombreVariacion = trim($columna[$flag_incremental]->nombreVariacion);
                        $numeroVariacion = trim($columna[$flag_incremental]->numeroVariacion);
                        $color = $columna[$flag_incremental]->color;
                        $codColor = trim($columna[$flag_incremental]->codColor);
                        $nombreLinea = $columna[$flag_incremental]->nombreLinea;
                        $numeroLinea = trim($columna[$flag_incremental]->numeroLinea);
                        $nombreSubLinea = $columna[$flag_incremental]->nombreSubLinea;
                        $numeroSubLinea = trim($columna[$flag_incremental]->numeroSubLinea);
                        $temporada2 = $columna[$flag_incremental]->temporada;
                        $cicloVida = $columna[$flag_incremental]->cicloVida;
                        $estadoOC = $columna[$flag_incremental]->estadoOC;
                        $fechaEmbarque = $columna[$flag_incremental]->fechaEmbarque;
                        $fechaEta = $columna[$flag_incremental]->fechaEta;
                        $unidades = $columna[$flag_incremental]->unidades;
                        $costo = $columna[$flag_incremental]->costo;
                        $moneda = $columna[$flag_incremental]->moneda;
                        $pais = $columna[$flag_incremental]->pais;


                        $query_agrega_registro_tabla_b = PlanCompraClass::AgregaRegistrosTablaB($temporada, $depto, $login, $oc, $pi, $nombreEstilo, $numeroEstilo,$estado, $nombreVariacion, $numeroVariacion, $color, $codColor, $nombreLinea, $numeroLinea, $nombreSubLinea, $numeroSubLinea, $temporada2, $cicloVida, $estadoOC, $fechaEmbarque, $fechaEta, $unidades, $costo, $moneda, $pais);
                        if ($query_agrega_registro_tabla_b == 0) {
                            return json_encode("error-No se pudo insertar en Tabla B, intente cargar nuevamente.");
                            die();
                        }

                    // Incremental
                        $flag_incremental++;

                    }
                }


                // Listar Grilla PMM (Tabla B)
                $sql = "SELECT ORDEN_DE_COMPRA, PI, NOMBRE_LINEA, NRO_LINEA, NOMBRE_SUB_LINEA, NRO_SUB_LINEA, NOMBRE_ESTILO, NRO_ESTILO, COLOR, COD_COLOR
                        FROM B
                        WHERE ORDEN_DE_COMPRA = '" . $oc . "'
                        AND PI = '" . $pi . "'
                        GROUP BY NOMBRE_ESTILO, NRO_ESTILO, COD_COLOR, ORDEN_DE_COMPRA, PI, NOMBRE_LINEA, NOMBRE_SUB_LINEA, COLOR, NRO_LINEA, NRO_SUB_LINEA
                        ORDER BY NRO_LINEA,NRO_SUB_LINEA,COD_COLOR
                    ";
                $data = \database::getInstancia()->getFilas($sql);

                // Transformo a array asociativo (Para campos de texto utilizar UTF-8)
                $array1 = [];
                foreach ($data as $va1) {
                    array_push($array1
                        , array(
                          "ORDEN_DE_COMPRA" => trim($va1[0])
                        , "PI" => trim($va1[1])
                        , "NOMBRE_LINEA" => utf8_encode($va1[2])
                        , "NRO_LINEA" => trim($va1[3])
                        , "NOMBRE_SUB_LINEA" => utf8_encode($va1[4])
                        , "NRO_SUB_LINEA" => utf8_encode(trim($va1[5]))
                        , "NOMBRE_ESTILO" => utf8_encode($va1[6])
                        , "NRO_ESTILO" => $va1[7]
                        , "COLOR" => utf8_encode(trim($va1[8]))
                        , "COD_COLOR" => $va1[9]
                        )
                    );
                }

                return $array1;



            // Fin del else trae data
            }

        // Fin del si no puedo quitar OC Canceladas
        }




    }


    // Trabajando en MATCH llenar tabla PLAN
    public static function MatchLlenarGridPlan($temporada, $depto, $login, $oc, $pi, $puerto, $url)
    {


        $sql = "SELECT c.id_color3 ID,
                     c.proforma PROFORMA,
                     nvl(C.NOM_LINEA,'Sin Informacion') LINEA,
                     c.cod_jer2 COD_LINEA,
                     nvl(C.NOM_SUBLINEA,'Sin Informacion') SUB_LINEA,
                     c.cod_sublin COD_SUBLINEA,
                     nvl(c.DES_ESTILO,'Sin Informacion') ESTILO,
                     'ND' NRO_ESTILO,
                     nvl(c.Nom_Color,'Sin Informacion') COLOR,
                     c.cod_color COD_COLOR  
                FROM  plc_plan_compra_color_3 c
                WHERE C.PROFORMA = '" . $pi . "' 
                AND C.COD_TEMPORADA = $temporada 
                AND C.DEP_DEPTO = '" . $depto . "' 
                AND C.ESTADO !=24
                ORDER BY COD_LINEA,COD_SUBLINEA,COD_COLOR
               ";

        $data = \database::getInstancia()->getFilas($sql);
        // return $data;

        // Transformo a array asociativo (Para campos de texto utilizar UTF-8)
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                  "ID" => $va1[0]
                , "PROFORMA" => $va1[1]
                , "LINEA" => utf8_encode("(".trim($va1[3]).") - ".trim($va1[2]))
                , "COD_LINEA" => $va1[3]
                , "SUB_LINEA" => utf8_encode("(".trim($va1[5]).") - ".trim($va1[4]))
                , "COD_SUBLINEA" => trim($va1[5])
                , "ESTILO" => utf8_encode(trim($va1[6]))
                , "NRO_ESTILO" => $va1[7]
                , "COLOR" => utf8_encode("(".trim($va1[9]).") - ".trim($va1[8]))
                , "COD_COLOR" => $va1[9]
                )
            );
        }

        return $array1;


    }


    // Llenar Tabla llenar_tabla_historial (POPUP de la Grilla)
    public static function BrokerTraerDatosOC($pi, $puerto, $url)
    {

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


    // Agrega registros que llegan del WS a la Tabla B
    public static function AgregaRegistrosTablaB($temporada, $depto, $login, $oc, $pi, $nombreEstilo, $numeroEstilo,$estado, $nombreVariacion, $numeroVariacion, $color,
                                                 $codColor, $nombreLinea, $numeroLinea, $nombreSubLinea, $numeroSubLinea, $temporada2, $cicloVida, $estadoOC, $fechaEmbarque,
                                                 $fechaEta, $unidades, $costo, $moneda, $pais)
    {

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
                    ,'" . $nombreEstilo . "'
                    ,$numeroEstilo
                    ,'" . $estado . "'
                    ,'" . $nombreVariacion . "'
                    ,$numeroVariacion
                    ,'" . $color . "'
                    ,$codColor
                    ,'" . $nombreLinea . "'
                    ,'" . $numeroLinea . "'
                    ,'" . $nombreSubLinea . "'
                    ,'" . $numeroSubLinea . "'
                    ,'" . $temporada2 . "'
                    ,'" . $cicloVida . "'
                    ,'" . $estadoOC . "'
                    ,to_date('" . $fechaEmbarque . "','YYYY-MM-DD')
                    ,to_date('" . $fechaEta . "','YYYY-MM-DD')
                    ," . $unidades . "
                    ," . $costo . "
                    ,'" . $moneda . "'
                    ,'" . $pais . "')
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
        //return $data;

        if($data){
            return 1;
        }else{
            return 0;
        }



    }

    // Listar CBX Línea en Match
    public static function ListarLineaCBXMatch($temporada, $depto)
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
        //return $data;

        // Transformo a array asociativo (Para campos de texto utilizar UTF-8)
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                  "LIN_LINEA" => utf8_encode("(".trim($va1[0]).") - ".trim($va1[1]))        //utf8_encode(trim($va1[0]))
                , "LIN_DESCRIPCION" => utf8_encode("(".trim($va1[0]).") - ".trim($va1[1]))
                )
            );
        }

        return $array1;

    }

    // Listar CBX SubLinea en Match
    public static function ListarSubLineaCBXMatch($temporada, $depto, $linea)
    {

        $LINEA_EXPLODE = explode(" - ", $linea);
        $LINEA_REPLACE1 =  str_replace("(","",$LINEA_EXPLODE[0]);
        $LINEA_REPLACE2 = str_replace(")","",$LINEA_REPLACE1);
        $LINEA = $LINEA_REPLACE2;

        $sql = "SELECT TRIM( L.PRD_LVL_NUMBER ) AS SLI_SUBLINEA,
                       TRIM( L.PRD_NAME_FULL ) AS SLI_DESCRIPCION
                FROM   PRDMSTEE         P,
                       PRDMSTEE         L
                WHERE  P.PRD_LVL_NUMBER = RPAD( '" . $LINEA . "', 15, ' ' )
                AND    P.PRD_LVL_CHILD  = L.PRD_LVL_PARENT
                AND    L.PRD_STATUS = 0
                ORDER BY 2 ASC
                ";

        $data = \database::getInstancia()->getFilas($sql);
        // return $data;

        // Transformo a array asociativo (Para campos de texto utilizar UTF-8)
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "SLI_SUBLINEA" => utf8_encode("(".trim($va1[0]).") - ".trim($va1[1]))   //utf8_encode(trim($va1[0]))
                , "SLI_DESCRIPCION" => utf8_encode("(".trim($va1[0]).") - ".trim($va1[1]))
                )
            );
        }

        return $array1;

    }

    // Listar CBX Color en Match
     public static function ListarColorCBXMatch($temporada, $depto)
    {

        $sql = "SELECT
                REPLACE(REPLACE(trim(t.codigo),CHR(10),''),CHR(13),'') AS COD_COLOR,
                convert(REPLACE(REPLACE(INITCAP( t.descripcion),CHR(10),''),CHR(13),''),'utf8','us7ascii') AS NOM_COLOR
                FROM PLC_MAEDIM T
                WHERE T.TIPO = 'C'
                ORDER BY t.descripcion ASC
                ";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo (Para campos de texto utilizar UTF-8)
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                  "COD_COLOR" => utf8_encode("(".trim($va1[0]).") - ".trim($va1[1]))        //utf8_encode(trim($va1[0]))
                , "NOM_COLOR" => utf8_encode("(".trim($va1[0]).") - ".trim($va1[1]))
                )
            );
        }

        return $array1;

    }

    // Actualizar Plan de Compra
    public static function ActualizaPlanMATCH($temporada, $depto, $login, $id_color, $linea, $sublinea, $estilo, $color)
    {

        $LINEA_EXPLODE = explode(" - ", $linea);
        $LINEA_REPLACE1 =  str_replace("(","",$LINEA_EXPLODE[0]);
        $LINEA_REPLACE2 = str_replace(")","",$LINEA_REPLACE1);
        $LINEA = trim($LINEA_REPLACE2);

        $SUBLINEA_EXPLODE = explode(" - ", $sublinea);
        $SUBLINEA_REPLACE1 = str_replace("(","",$SUBLINEA_EXPLODE[0]);
        $SUBLINEA_REPLACE2 = str_replace(")","",$SUBLINEA_REPLACE1);
        $SUB_LINEA = trim($SUBLINEA_REPLACE2);

        $COLOR_EXPLODE = explode(" - ", $color);
        $COLOR_REPLACE1 = str_replace("(","",$COLOR_EXPLODE[0]);
        $COLOR_REPLACE2 = str_replace(")","",$COLOR_REPLACE1);
        $COLOR = trim($COLOR_REPLACE2);
        $NOM_COLOR = trim($COLOR_EXPLODE[1]);

        $sql = "begin PLC_PKG_DESARROLLO.PRC_UPDATE_COLOR3_OC($temporada,'" . $depto . "',$id_color, '" . $LINEA . "', '" . $SUB_LINEA . "', '" . $estilo . "', '" . $COLOR . "', '" . $NOM_COLOR . "',:error, :data); end;";

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

        if ($data) {
            return 1;
        } else {
            return 0;
        }



    // Fin del ActualizaPlanMATCH
    }

    // Match - Generar Match (En estado 19)
    public static function GenerarMatch($temporada, $depto, $login, $oc, $proforma)
    {

        // Traigo la Misma Data del Plan que ve el usuario
        $sql_trae_data = "SELECT  C.ID_COLOR3,                  
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
                            AND C.PROFORMA = '" . $proforma . "' ";
        $data = \database::getInstancia()->getFilas($sql_trae_data);

        if($data){

            // Recorro los resultados
            foreach ($data as $va1) {

                // Generar Match                                                                   Estilo        Ventana
                $sql_genera_match = "begin PLC_PKG_UTILS.PRC_GENERAR_MATCH('" . $proforma . "','" . $va1[1] . "', $va1[2],'" . $depto . "',$temporada,'" . $oc . "', :error, :data); end;";
                    // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                    if (!file_exists('../archivos/log_querys/' . $login)) {
                        mkdir('../archivos/log_querys/' . $login, 0775, true);
                    }
                    $stamp = date("Y-m-d_H-i-s");
                    $rand = rand(1, 999);
                    $content = $sql_genera_match;
                    $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-PRC_GENERAR_MATCH--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                    fwrite($fp, $content);
                    fclose($fp);
                $data_genera_match = \database::getInstancia()->getConsultaSP($sql_genera_match, 2);

                if($data_genera_match){

                    // Aprobar Opcion                                                                           ID_COLOR3
                    $sql_aprobar_opcion = "begin PLC_PKG_UTILS.PRC_APROBACION_PLAN_2($temporada,'" . $depto . "',$va1[0],'" . $proforma . "', :error, :data); end;";
                    // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                    if (!file_exists('../archivos/log_querys/' . $login)) {
                        mkdir('../archivos/log_querys/' . $login, 0775, true);
                    }
                    $stamp = date("Y-m-d_H-i-s");
                    $rand = rand(1, 999);
                    $content = $sql_aprobar_opcion;
                    $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-PRC_APROBACION_PLAN_2--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                    fwrite($fp, $content);
                    fclose($fp);
                    $data_aprobar_opcion = \database::getInstancia()->getConsultaSP($sql_aprobar_opcion, 2);

                    if($data_aprobar_opcion){

                        // PLC_PKG_MIGRACION.PRC_LIS_COLOR3_IDCOLOR3                                              ID_COLOR3
                        $sql_parte2 = "begin PLC_PKG_MIGRACION.PRC_LIS_COLOR3_IDCOLOR3($temporada,'" . $depto . "',$va1[0], :data); end;";
                        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                        if (!file_exists('../archivos/log_querys/' . $login)) {
                            mkdir('../archivos/log_querys/' . $login, 0775, true);
                        }
                        $stamp = date("Y-m-d_H-i-s");
                        $rand = rand(1, 999);
                        $content = $sql_parte2;
                        $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-PRC_LIS_COLOR3_IDCOLOR3--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                        fwrite($fp, $content);
                        fclose($fp);
                        $data_parte2 = \database::getInstancia()->getConsultaSP($sql_parte2, 1);

                        if($data_parte2){

                            // Recorro los resultados de PLC_PKG_MIGRACION.PRC_LIS_COLOR3_IDCOLOR3
                            foreach ($data_parte2 as $va2) {

                                $sql_historial = "INSERT INTO PLC_PLAN_COMPRA_HISTORICA (
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
                                                            ,'" . $va1[5] . "'
                                                            ,'" . $va1[6] . "'
                                                            ,$va1[7]
                                                            ,'" . $va1[1] . "'
                                                            ,$va1[2]
                                                            ,$va1[8]
                                                            ,'" . $login . "'
                                                            ,(SELECT NOM_USR FROM PLC_USUARIO WHERE COD_USR = '" . $login . "')
                                                            ,(SELECT SUBSTR(TO_CHAR(SYSDATE, 'DD-MM-YYYY'),1,10)N FROM DUAL)
                                                            ,(SELECT TO_CHAR(SYSDATE, 'HH24:MI:SS') FROM DUAL)
                                                            ,'" . $proforma . "'
                                                            ,'" . $oc . "'
                                                            ,$va2[1]
                                                            ,$temporada
                                                            ,$va1[0]
                                                            ,'" . $va1[10] . "'
                                                            ,'" . $va1[11] . "'
                                                            ,'" . $va1[12] . "'
                                                            ,'" . $va1[13] . "'
                                                            ,'" . $va1[14] . "' )";
                                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                                if (!file_exists('../archivos/log_querys/' . $login)) {
                                    mkdir('../archivos/log_querys/' . $login, 0775, true);
                                }
                                $stamp = date("Y-m-d_H-i-s");
                                $rand = rand(1, 999);
                                $content = $sql_historial;
                                $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-PLC_PLAN_COMPRA_HISTORICA--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                                fwrite($fp, $content);
                                fclose($fp);
                                $data_historial = \database::getInstancia()->getConsulta($sql_historial);
                                //return $data_historial;

                                // Fin del FOREACH2
                            }

                            //return json_encode("OK");

                        }else{
                            return json_encode("Problemas en PRC_LIS_COLOR3_IDCOLOR3.");
                            die();
                        }

                    }else{
                        return json_encode("Problemas en PRC_APROBACION_PLAN_2.");
                        die();
                    }

                }else{
                    return json_encode("Problemas en PRC_GENERAR_MATCH.");
                    die();
                }


            // Fin FOREACH
            }

            return json_encode("OK");

        }else{
            return json_encode("No hemos podido encontrar la información asociada a la Proforma.");
            die();
        }


    }

    // Match - Generar Match Variacion
    public static function GenerarMatchVariaciones($temporada, $depto, $login, $oc, $proforma)
    {

        // Prueba de Recepción de GRID Telerik
        // return json_encode("OK");
        // die();

        // Trabajo con las Variaciones
        $sql_agrega_variacion = "begin PLC_PKG_UTILS.PRC_AGREGAR_OC_VARIACION2('" . $oc . "','" . $proforma . "', :error, :data); end;";
            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_agrega_variacion;
            $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-PRC_AGREGAR_OC_VARIACION2--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);
        $data_agrega_variacion = \database::getInstancia()->getConsultaSP($sql_agrega_variacion, 2);

        // Si se pudo realizar el ingreso de la primera variación, continueo con el de la nueva variación
        if ($data_agrega_variacion) {

            // Agregamos la Nueva Variación
            $sql_nueva_variacion = "begin PLC_PKG_UTILS.PRC_AGREGAR_NUEVA_VARIACION(" . $temporada . ",'" . $depto . "','" . $oc . "', :error, :data); end;";
                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                if (!file_exists('../archivos/log_querys/' . $login)) {
                    mkdir('../archivos/log_querys/' . $login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql_nueva_variacion;
                $fp = fopen("../archivos/log_querys/" . $login . "/MATCH-PRC_AGREGAR_NUEVA_VARIACION--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                fwrite($fp, $content);
                fclose($fp);

            $data = \database::getInstancia()->getConsultaSP($sql_nueva_variacion, 2);

            if ($data) {
                return json_encode("OK");
            } else {

                $query_revertir_match = PlanCompraClass::RevertirMatch($temporada, $depto, $login, $proforma);

                return json_encode(" ROLLBACK MATCH... Problema Insertar Variacion. ");
                die();

            }


        } else{

            $query_revertir_match = PlanCompraClass::RevertirMatch($temporada, $depto, $login, $proforma);

            return json_encode(" ROLLBACK MATCH... Problema en Variacion2. ");
            die();
        }




    }

    // Match - Revertir Match
    public static function RevertirMatch($temporada, $depto, $login, $proforma)
    {

        $sql_update = "begin PLC_PKG_UTILS.PRC_SOLOC($temporada,'" . $depto . "','" . $proforma . "',3, :error, :data); end;";
        $data_update = \database::getInstancia()->getConsultaSP($sql_update, 2);

        if ($data_update) {

            /*$sql_variacion = "DELETE FROM PLC_OC_VARIACION
                              WHERE PI = '" . $proforma . "'";
            $data_variacion = \database::getInstancia()->getConsulta($sql_variacion);

            if($data_variacion){
                return json_encode("OK");
                die();
            }else{
                return json_encode("ERROR");
                die();
            }*/

            return json_encode("OK");
            die();

        } else {
            return json_encode("ERROR");
            die();
        }

    }

    // Match - Agregar OC a Tabla plc_ordenes_compra_pmm
    public static function AgregaOcTablaOCPMM($temporada, $depto, $login, $oc, $proforma)
    {

        $sql_busca_estado_oc = "SELECT
                                            CASE 
                                            WHEN ESTADO_OC = 'Modo Ingreso' THEN 1 
                                            WHEN ESTADO_OC = 'Pendiente Autorizacion' THEN 2
                                            WHEN ESTADO_OC = 'Autorizada' THEN 3
                                            WHEN ESTADO_OC = 'On Order' THEN 4
                                            WHEN ESTADO_OC = 'Recepcion Parcial' THEN 5
                                            WHEN ESTADO_OC = 'Recepcion Completa' THEN 6
                                            WHEN ESTADO_OC = 'Cancelada' THEN 7 END ESTADO_OC 
                                        FROM B
                                        WHERE ORDEN_DE_COMPRA = $oc
                                        GROUP BY ESTADO_OC";
        $data_estado = \database::getInstancia()->getFila($sql_busca_estado_oc);

        // Verifico que tenga el estado de la OC
        if($data_estado){

            // Verificar si la OC existe en plc_ordenes_compra_pmm
            $sql_existe_oc = "SELECT 1 FROM plc_ordenes_compra_pmm
                              WHERE po_number = $oc";
            $existe_oc = (int) \database::getInstancia()->getFila($sql_existe_oc);

            // Si existe lo actualizo
            if ($existe_oc == 1){

                $sql_update_oc = "UPDATE plc_ordenes_compra_pmm 
                                  SET COD_ESTADO = $data_estado[0]
                                  WHERE po_number = $oc";

                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                if (!file_exists('../archivos/log_querys/' . $login)) {
                    mkdir('../archivos/log_querys/' . $login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql_update_oc;
                $fp = fopen("../archivos/log_querys/" . $login . "/PARCHEMATCH-ACTUALIZAOCPMM--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                fwrite($fp, $content);
                fclose($fp);

                $data_update_oc = \database::getInstancia()->getConsulta($sql_update_oc);

                if($data_update_oc){
                    return "OK";
                }else{
                    return "ERROR";
                }

            // No existe lo agrego
            }else{

                $sql_insert_oc = "INSERT INTO plc_ordenes_compra_pmm (PO_NUMBER,COD_PROVEEDOR,COD_ESTADO,PO_DATE,PO_UNITS_QTY,PO_UNITS_COST) 
                                      VALUES ($oc,0,$data_estado[0],SYSDATE,0,0)";

                // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
                if (!file_exists('../archivos/log_querys/' . $login)) {
                    mkdir('../archivos/log_querys/' . $login, 0775, true);
                }
                $stamp = date("Y-m-d_H-i-s");
                $rand = rand(1, 999);
                $content = $sql_insert_oc;
                $fp = fopen("../archivos/log_querys/" . $login . "/PARCHEMATCH-INSERTAOCPMM--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
                fwrite($fp, $content);
                fclose($fp);

                $data_insert_oc = \database::getInstancia()->getConsulta($sql_insert_oc);

                if($data_insert_oc){
                    return "OK";
                }else{
                    return "ERROR";
                }

            }





        }





    }



    // ######################## INICIO Trabajo con flujo de aprobación ########################
    // Trabajo con Flujo Dinámico de Aprobación
    public static function ModificaEstadoDinamico($temporada, $depto, $login, $id_color3, $estado_insert, $proforma, $estado_update)
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
                  AND C.ID_COLOR3 = $id_color3";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql_insert;
        $fp = fopen("../archivos/log_querys/" . $login . "/FLUJO-FLUJOHISTORIALINSERT--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
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
            $fp = fopen("../archivos/log_querys/" . $login . "/FLUJO-FLUJOHISTORIALUPDATE--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data_update = \database::getInstancia()->getConsultaSP($sql_update, 2);

            if ($data_update) {

                if($estado_update==3){

                    $query_elimina_variacion = PlanCompraClass::EliminaVariaciones($temporada, $depto, $login, $proforma);

                    if($query_elimina_variacion){
                        return json_encode("OK");
                        die();
                    } else {
                        return json_encode("ERROR");
                        die();
                    }

                }else{
                    return json_encode("OK");
                    die();
                }

            } else {
                return json_encode("ERROR");
                die();
            }

        // Si la consulta no se puede realizar
        } else {
            return json_encode("ERROR");
            die();
        }

        // Fin de la clase
    }
    // Trabajo con Flujo Dinámico de Aprobación
    public static function ModificaEstadoDinamicoCorreccion($temporada, $depto, $login, $id_color3, $estado_insert, $proforma, $estado_update, $comentario){

        $sql_comentario = "UPDATE PLC_PLAN_COMPRA_COLOR_3 A
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
        $content = $sql_comentario;
        $fp = fopen("../archivos/log_querys/" . $login . "/FLUJO-COMENTARIOSOLCORRECCIONPI--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);

        $data_comentario = \database::getInstancia()->getConsulta($sql_comentario);
        if($data_comentario){

            $query_modifica_estado = PlanCompraClass::ModificaEstadoDinamico($temporada, $depto, $login, $id_color3, $estado_insert, $proforma, $estado_update);
            if($query_modifica_estado){
                return json_encode("OK");
                die();
            }else{
                return json_encode("No se pudo actualizar registro.");
                die();
            }

        }else{
            return json_encode("No se pudo actualizar comentario.");
            die();
        }


    // Fin de ModificaEstadoDinamicoCorreccion
    }
    // Eliminar Variaciones
    public static function EliminaVariaciones($temporada, $depto, $login, $proforma)
    {

        $sql_variacion = "DELETE FROM PLC_OC_VARIACION
                          WHERE PI = '" . $proforma . "'";
        $data_variacion = \database::getInstancia()->getConsulta($sql_variacion);

        if($data_variacion){
            return json_encode("OK");
            die();
        }else{
            return json_encode("ERROR");
            die();
        }

    // Fin de la clase
    }
    // ######################## FIN Trabajo con flujo de aprobación ########################


    // ######################## INICIO Permisos de Usuario ########################
    // Listar Total Registros Grilla
    public static function ListarRegistrosGrilla($temporada, $depto, $login)
    {

        $sql_limpia_depto = "DELETE FROM PLC_CONCURRENCIA HR
                       WHERE EXISTS  (SELECT * FROM PLC_USUARIO US WHERE US.COD_TIPUSR <>99) 
                       AND (TO_NUMBER(TO_CHAR(SYSDATE,'HH24')-TO_CHAR(HR.FECHA,'HH24') )*60)+ TO_NUMBER(TO_CHAR(SYSDATE,'MI')-TO_CHAR(HR.FECHA,'MI'))>=30";
        $data_limpia = \database::getInstancia()->getConsulta($sql_limpia_depto);


        $sql = "SELECT 'TOTALREGPLAN' ID_TELERIK, TO_CHAR(COUNT(*)+1) NOMBRE_ACCION
                    FROM PLC_PLAN_COMPRA_COLOR_3
                    WHERE COD_TEMPORADA = $temporada AND DEP_DEPTO = '" . $depto . "'";

        $data = \database::getInstancia()->getFilas($sql);
        //return $data;

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                   "TOTALREGPLAN" => $va1[1]+2
                )
            );
        }
        return $array1;

    }

    // Listar Permiso de Usuario Original
    public static function ListarPermisosUsuarioOriginal($temporada, $depto, $login, $cod_tipusr)
    {

        // Si es administrador, le agrego todas las acciones
        if( $cod_tipusr == 99 ) {

            $sql = "SELECT 'TOTALREGPLAN' ID_TELERIK, TO_CHAR(COUNT(*)+1) NOMBRE_ACCION
                    FROM PLC_PLAN_COMPRA_COLOR_3
                    WHERE COD_TEMPORADA = $temporada AND DEP_DEPTO = '" . $depto . "'
                    UNION ALL
                    SELECT id_telerik ID_TELERIK, nombre_accion NOMBRE_ACCION 
                    FROM plc_modulo_accion";
        } else {

            $sql = "SELECT 'TOTALREGPLAN' ID_TELERIK, TO_CHAR(COUNT(*)+1) NOMBRE_ACCION
                    FROM PLC_PLAN_COMPRA_COLOR_3
                    WHERE COD_TEMPORADA = $temporada AND DEP_DEPTO = '" . $depto . "'
                    UNION ALL
                    SELECT t1.id_telerik ID_TELERIK, t2.nombre_accion NOMBRE_ACCION 
                    FROM plc_permiso_modulo_accion t1
                    INNER JOIN plc_modulo_accion t2 ON t2.id_telerik=t1.id_telerik
                    INNER JOIN plc_usuario t3 ON t3.cod_tipusr=t1.id_tip_usr
                    WHERE t3.cod_usr = '" . $login . "'
                    AND t1.estado_accion=1";

        }

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

        // Transformo a array asociativo
        /*$array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                   "ID_ACCION" => $va1[0]
                //, "NOMBRE_ACCION" => $va1[1]
                )
            );
        }
        return $array1;*/


    }

    // Listar Permiso de Usuario
    public static function ListarPermisosUsuario($temporada, $depto, $login, $cod_tipusr)
    {

        // Si es administrador, le agrego todas las acciones
        if( $cod_tipusr == 99 ) {

            $sql = "SELECT id_telerik ID_TELERIK, nombre_accion NOMBRE_ACCION 
                    FROM plc_modulo_accion";
        } else {

            $sql = "SELECT t1.id_telerik ID_TELERIK, t2.nombre_accion NOMBRE_ACCION 
                    FROM plc_permiso_modulo_accion t1
                    INNER JOIN plc_modulo_accion t2 ON t2.id_telerik=t1.id_telerik
                    INNER JOIN plc_usuario t3 ON t3.cod_tipusr=t1.id_tip_usr
                    WHERE t3.cod_usr = '" . $login . "'
                    AND t1.estado_accion=1";

        }

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

        // Transformo a array asociativo
        /*$array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                   "ID_ACCION" => $va1[0]
                //, "NOMBRE_ACCION" => $va1[1]
                )
            );
        }
        return $array1;*/


    }
    // Revisar Concurrencia
    public static function RevisaConcurrencia($temporada, $depto, $login,$cod_tipusr)
    {

        // Si es administrador, le agrego todas las acciones
        if( $cod_tipusr == 99 ) {

            return 0;

        } else {

            $sql = "SELECT 1 CANTIDAD, t2.nom_usr NOMBRE
                    FROM PLC_CONCURRENCIA t1
                    INNER JOIN plc_usuario t2 ON t2.cod_usr=t1.cod_usr
                    WHERE t1.COD_TEMPORADA = $temporada
                    AND t1.DEP_DEPTO = '" . $depto . "'
                    AND t1.USER_LOGIN != '" . $login . "'";

        $data = \database::getInstancia()->getFilas($sql);

            // Si no llega data borro mis registros anteriores y agrego uno nuevo (evaluar, revisar primero)
            // simulando que el usuario cierrabien sessión y yo lectura recargo????
            // (Si no trae data)

            return $data;

    }




    }
    // Busca Usuario Desconectado
    public static function BuscaUsuarioDesconectado($temporada, $depto, $login,$cod_tipusr)
    {

        // Verifico si el usuario está dentro de los que tienen mas de 30 Min sin conexión
        $sql_desconectado = "SELECT 1 FROM PLC_CONCURRENCIA HR
                             WHERE EXISTS  (SELECT * FROM PLC_USUARIO US WHERE US.COD_TIPUSR <>99) 
                             AND (TO_NUMBER(TO_CHAR(SYSDATE,'HH24')-TO_CHAR(HR.FECHA,'HH24') )*60)+ TO_NUMBER(TO_CHAR(SYSDATE,'MI')-TO_CHAR(HR.FECHA,'MI')) >= 30
                             AND HR.COD_USR = '".$login."'";
        $existe_desconectado = (int) \database::getInstancia()->getFila($sql_desconectado);

        // Si está en la lista, actualizo IS_OFFLINE = 1 y ejecuto la query original
        if ($existe_desconectado == 1){

            $sql_update_offline = "UPDATE PLC_CONCURRENCIA 
                                   SET IS_OFFLINE = 1
                                   WHERE COD_USR = '".$login."'";
            $data_update_offline = \database::getInstancia()->getConsulta($sql_update_offline);


            if($data_update_offline){

                $sql = "SELECT 1 
                FROM PLC_CONCURRENCIA 
                WHERE COD_TEMPORADA = $temporada
                AND DEP_DEPTO = '".$depto."' 
                AND COD_USR = '".$cod_tipusr."'
                AND IS_OFFLINE = 1";

                $existe = (int) \database::getInstancia()->getFila($sql);

                if ($existe == 1){

                    // Quitar su registro (Si el usuario recarga, va ingresar en modo lectura)
                    $sql_quitar = "DELETE FROM PLC_CONCURRENCIA
                            WHERE COD_TEMPORADA = $temporada
                            AND DEP_DEPTO = '".$depto."'
                            AND COD_USR = '".$cod_tipusr."' 
                            ";
                    $data_quitar = \database::getInstancia()->getConsulta($sql_quitar);

                    return 1;

                }else{
                    return 0;
                }

            }

        }else{
            return 0;
        }
        // si no está en la lista retorno 0











    }
    // ######################## FIN Permisos de Usuario ########################


    // ######################## INICIO Trabajo POPUP Tienda ########################
    // Listar Marca
    public static function ListarMarca($temporada, $depto)
    {

        /*$sql = "begin PLC_PKG_PRUEBA.PRC_LISTAR_DEPTO_MARCA('" . $depto . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;*/

        $sql = "SELECT DISTINCT COD_MARCA, NOM_MARCA
        FROM PLC_DEPTO_MARCA
        WHERE COD_DEPT = '" . $depto . "'";
        $data = \database::getInstancia()->getFilas($sql);
        //return $data;

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                  "CODIGO" => $va1[0]
                , "DESCRIPCION" => $va1[1]
                )
            );
        }
        return $array1;


    }
    // Listar Tipo Tienda
    public static function ListarTipoTienda($temporada, $depto)
    {

        // pregunto si tiene cluster, si no tiene los agrego y luego listo
        $sql = "SELECT 1
                 FROM   PLC_SEGMENTOS
                 WHERE  COD_TEMPORADA = '" . $temporada . "'
                 AND    DEP_DEPTO     = '" . $depto . "'
                 ";

        $existe = (int)\database::getInstancia()->getFila($sql);


        if ($existe == 1) {

            // Listar Clusters
            $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_SEGMENTOS('" . $temporada . "','" . $depto . "',0,0, :data); end;";
            $data = \database::getInstancia()->getConsultaSP($sql, 1);
             //return $data;

        } else {

            // Inserto los Clusters
            $sql_inserta = "INSERT INTO PLC_SEGMENTOS (cod_temporada,dep_depto,niv_jer1,cod_jer1,cod_seg,des_seg)
                        select " . $temporada . ",'" . $depto . "',0,'0',1,'A' from dual union
                        select " . $temporada . ",'" . $depto . "',0,'0',2,'B' from dual union
                        select " . $temporada . ",'" . $depto . "',0,'0',3,'C' from dual union
                        select " . $temporada . ",'" . $depto . "',0,'0',4,'I' from dual";

            $data_inserta = \database::getInstancia()->getConsulta($sql_inserta);

            // Listar clusters insertados previamente
            $sql = "begin PLC_PKG_GENERAL.PRC_LISTAR_SEGMENTOS('" . $temporada . "','" . $depto . "',0,0, :data); end;";
            $data = \database::getInstancia()->getConsultaSP($sql, 1);
             //return $data;

        }

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "CODIGO" => $va1[0]
                , "DESCRIPCION" => $va1[1]
                )
            );
        }


        return $array1;


    }
    // Llenar ListBox de Disponible
    public static function TiendaObtieneDisponible($temporada, $depto, $marca, $tienda)
    {

        $sql = "begin PLC_PKG_PRUEBA.PRC_LISTAR_TDA($temporada,'" . $depto . "',$marca, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "CODIGO" => $va1[0]
                , "DESCRIPCION" => $va1[1]
                , "ESTADO" => false
                )
            );
        }
        return $array1;

    }
    // Llenar ListBox de Asignado
    public static function TiendaObtieneAsignado($temporada, $depto, $marca, $tienda)
    {

        $sql = "SELECT DISTINCT
                P.COD_TDA AS COD_SUC,
                INITCAP( TRIM( BOSACC_FUN_OBT_NOM_SUC( P.COD_TDA ) ) ) AS DES_SUC
                 FROM   PLC_SEGMENTOS_TDA P
                 WHERE  P.COD_TEMPORADA = $temporada
                 AND    P.DEP_DEPTO     = '" . $depto . "'
                 AND    P.COD_MARCA = $marca
                 AND    DECODE( $tienda, 0, 0,P.COD_SEG ) = $tienda
                 ORDER BY 2
                ";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                  "CODIGO" => $va1[0]
                , "DESCRIPCION" => $va1[1]
                , "ESTADO" => true

                )
            );
        }
        return $array1;


    }
    // Llenar ListBox de TiendaObtieneDisponibleAsignado
    public static function TiendaObtieneDisponibleAsignado($temporada, $depto, $marca, $tienda)
    {

        $sql = "SELECT  S.SUC_SUCURSAL AS CODIGO,
                             convert(REPLACE(REPLACE(REPLACE(INITCAP(TRIM(S.SUC_NOMBRE)),CHR(9),''),CHR(10),''),CHR(13),''),'utf8','us7ascii') AS DESCRIPCION,
                             0 ESTADO
                FROM GST_MAESUCURS S
                WHERE SUC_SUCURSAL NOT IN (SELECT DISTINCT P.COD_TDA AS COD_SUC
                                           FROM PLC_SEGMENTOS_TDA P
                                           WHERE P.COD_TEMPORADA = $temporada
                                           AND P.DEP_DEPTO = '" . $depto . "'
                                           AND P.COD_MARCA = $marca)
                                           
                UNION ALL 
                
                SELECT DISTINCT
                                P.COD_TDA AS CODIGO,
                                INITCAP( TRIM( BOSACC_FUN_OBT_NOM_SUC( P.COD_TDA ) ) ) AS DESCRIPCION,
                                1 ESTADO
                                 FROM   PLC_SEGMENTOS_TDA P
                                 WHERE  P.COD_TEMPORADA = $temporada
                                 AND    P.DEP_DEPTO     = '" . $depto . "'
                                 AND    P.COD_MARCA = $marca
                                 AND    DECODE( $tienda, 0, 0,P.COD_SEG ) = $tienda
                ORDER BY 2";
        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {

            if($va1[2]==0){
                $estado = false;
            }else{
                $estado = true;
            }


            array_push($array1
                , array(
                    "CODIGO" => $va1[0]
                , "DESCRIPCION" => utf8_encode($va1[1])
                , "ESTADO" => $estado

                )
            );
        }
        return $array1;


    }
    // Actualiza Asignados
    public static function TiendaActualizaAsignado($temporada, $depto, $login, $codigo, $descripcion, $estado, $marca, $tipo_tenda){

    // El estado me dice si hay que quitar o agregar el registro

        // Elimino
        if($estado == "false"){

            $sql_quitar = "DELETE FROM PLC_SEGMENTOS_TDA
                            WHERE cod_temporada = $temporada
                            AND dep_depto = '" . $depto . "'
                            AND cod_seg = $tipo_tenda
                            AND cod_marca = $marca
                            AND cod_tda = $codigo
                            ";

            // Guardamos registros
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_quitar;
            $fp = fopen("../archivos/log_querys/" . $login . "/MANTENEDORTIENDA-QUITAR--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $quitar = \database::getInstancia()->getConsulta($sql_quitar);

            if($quitar){
                return "OK";
            }else{
                return "ERROR";
            }

        // Agregar Registro
        }else{

            $sql_agregar = "INSERT INTO PLC_SEGMENTOS_TDA(COD_TEMPORADA,DEP_DEPTO,NIV_JER1,COD_JER1,COD_SEG,COD_TDA,COD_MARCA)
                                VALUES($temporada,'" . $depto . "',0,0,$tipo_tenda,$codigo,$marca)
                                ";

            // Guardamos registros del agregar
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_agregar;
            $fp = fopen("../archivos/log_querys/" . $login . "/MANTENEDORTIENDA-AGREGAR--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $agrega = \database::getInstancia()->getConsulta($sql_agregar);

            if($agrega){
                return "OK";
            }else{
                return "ERROR";
            }

        }


    }
    // Actualiza Asignados Otras Marcas
    public static function TiendaActualizaAsignadoOtrasMarcas($temporada, $depto, $login, $marca, $tipo_tenda){


        $status = 0;

        // 1.- Listar Todas las marcas restantes
        $sql_marca = "SELECT DISTINCT COD_MARCA, NOM_MARCA
                FROM PLC_DEPTO_MARCA
                WHERE COD_DEPT = '" . $depto . "'
                AND COD_MARCA <> $marca";
        $data_marca = \database::getInstancia()->getFilas($sql_marca);


        // Recorro las marcas restantes y le asigno las mismas tiendas de mi selección actual
        foreach ($data_marca as $va1) {

            // Quito los Registros Existentes de Esta Marca/Tipo Tienda
            $sql_quitar = "DELETE FROM PLC_SEGMENTOS_TDA
                           WHERE COD_TEMPORADA = $temporada
                           AND DEP_DEPTO = '" . $depto . "'
                           AND COD_SEG = $tipo_tenda
                           AND COD_MARCA = $va1[0]";
            $data_quitar = \database::getInstancia()->getConsulta($sql_quitar);

            if(!$data_quitar){ $status = $status + 1; }

            $sql_agregar = "INSERT INTO PLC_SEGMENTOS_TDA (COD_TEMPORADA,DEP_DEPTO,NIV_JER1,COD_JER1,COD_SEG,COD_TDA,COD_MARCA)
                            SELECT COD_TEMPORADA, DEP_DEPTO, 0 NIV_JER1, 0 COD_JER1,COD_SEG,COD_TDA,$va1[0] COD_MARCA 
                            FROM PLC_SEGMENTOS_TDA
                            WHERE COD_TEMPORADA = $temporada
                            AND DEP_DEPTO = '" . $depto . "'
                            AND COD_SEG = $tipo_tenda
                            AND COD_MARCA = $marca";
            $agrega = \database::getInstancia()->getConsulta($sql_agregar);

            if(!$agrega){ $status = $status + 1; }

        }



        if($status==0){
            return "OK";
        }else{
            return "ERROR";
        }





    }
    // Llenar el CBX de las Temporadas a duplicar del popup
    public static function ListarTemporadasDuplicar($temporada, $depto,$login)
    {
        //  PLC_PKG_MIGRACION.PRC_TEMP_CONFIGTIENDAS
        $sql = "begin PLC_PKG_MIGRACION.PRC_TEMP_CONFIGTIENDAS($temporada, :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "CODIGO" => $va1[0]
                , "DESCRIPCION" => $va1[1]
                )
            );
        }
        return $array1;
    }
    // Duplicar Temporada
    public static function TiendaDuplicarTemporada($temporada, $depto, $login, $temp_selecc, $marca)
    {

        $sql_duplicar = "begin PLC_PKG_MIGRACION.PRC_DELFULL_CONFIGTIENDAS_WEB($temporada,$temp_selecc,'" . $depto . "',$marca, :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/' . $login)) {
            mkdir('../archivos/log_querys/' . $login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql_duplicar;
        $fp = fopen("../archivos/log_querys/" . $login . "/MANTENEDORTIENDA-DUPLICARTEMPORADA--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
        fwrite($fp, $content);
        fclose($fp);
        $data_duplicar = \database::getInstancia()->getConsultaSP($sql_duplicar, 2);

        if ($data_duplicar) {
            return "OK";
        } else {
            return "ERROR";
        }


    }
    // ######################## FIN Trabajo POPUP Tienda ########################



    // ######################## INICIO Trabajo POPUP Formato ########################
    // Listar Formato
    public static function MantenedorListarFormato($temporada, $depto)
    {

        $sql = "SELECT COD_SEG,DES_SEG 
                FROM PLC_FORMATO 
                WHERE COD_TEMPORADA = $temporada 
                AND DEP_DEPTO = '" . $depto . "' 
                ORDER BY COD_SEG";

        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {
            array_push($array1
                , array(
                    "CODIGO" => $va1[0]
                , "DESCRIPCION" => $va1[1]
                )
            );
        }
        return $array1;


    }
    // Llenar ListBox de TiendaObtieneDisponibleAsignado
    public static function FormatoObtieneDisponibleAsignado($temporada, $depto, $formato)
    {

        $sql = "SELECT  S.SUC_SUCURSAL AS CODIGO,
                        INITCAP(TRIM(S.SUC_NOMBRE)) AS DESCRIPCION,
                        0 ESTADO
                 FROM GST_MAESUCURS S
                 WHERE SUC_SUCURSAL NOT IN (SELECT DISTINCT P.COD_TDA AS COD_SUC
                                              FROM   PLC_FORMATOS_TDA P
                                              WHERE  P.COD_TEMPORADA = $temporada
                                              AND    P.DEP_DEPTO     = '" . $depto . "'
                                              AND    DECODE( " . $formato . ", 0, 0,P.COD_SEG ) = " . $formato . "
                                              )
                UNION ALL
                SELECT DISTINCT
                                P.COD_TDA                                              AS CODIGO,
                                INITCAP( TRIM( BOSACC_FUN_OBT_NOM_SUC( P.COD_TDA ) ) ) AS DESCRIPCION,
                                1 ESTADO
                         FROM   PLC_FORMATOS_TDA P
                         WHERE  P.COD_TEMPORADA = $temporada
                         AND    P.DEP_DEPTO     = '" . $depto . "'
                         AND    DECODE( " . $formato . ", 0, 0,P.COD_SEG ) = " . $formato . "
                         ORDER BY 2";

        $data = \database::getInstancia()->getFilas($sql);

        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {

            if($va1[2]==0){
                $estado = false;
            }else{
                $estado = true;
            }

            array_push($array1
                , array(
                    "CODIGO" => $va1[0]
                , "DESCRIPCION" => utf8_encode($va1[1])
                , "ESTADO" => $estado

                )
            );
        }
        return $array1;



    }
    // Actualiza Asignados
    public static function FormatoActualizaAsignado($temporada, $depto, $login, $formato,$codigo,$descripcion,$estado){

        // $codigo      = Corresponde a la Tienda Número
        // $descripcion = Corresponde a la Tienda Texto
        // $estado      = El estado me dice si hay que quitar o agregar el registro
        // $formato     = El valor del CBX de formato

        // Elimino
        if($estado == "false"){

            $sql_quitar = "DELETE FROM plc_formatos_tda
                            WHERE COD_TEMPORADA = $temporada
                            AND DEP_DEPTO = '" . $depto . "'
                            AND COD_TDA = $codigo
                            AND COD_SEG = $formato";

            // Guardamos registros
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_quitar;
            $fp = fopen("../archivos/log_querys/" . $login . "/MANTENEDORFORMATO-QUITAR--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $quitar = \database::getInstancia()->getConsulta($sql_quitar);

            if($quitar){
                return "OK";
            }else{
                return "ERROR";
            }

            // Agregar Registro
        }else{

            $sql_agregar = "INSERT INTO plc_formatos_tda (COD_TEMPORADA,DEP_DEPTO,NIV_JER1,COD_JER1,COD_SEG,COD_TDA)
                            VALUES($temporada,'" . $depto . "',0,0,$formato,$codigo)";

            // Guardamos registros del agregar
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql_agregar;
            $fp = fopen("../archivos/log_querys/" . $login . "/MANTENEDORFORMATO-AGREGAR--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $agrega = \database::getInstancia()->getConsulta($sql_agregar);

            if($agrega){
                return "OK";
            }else{
                return "ERROR";
            }

        }


    }
    // Crear Nuevo Formato
    public static function FormatoCrearNuevo($temporada, $depto, $login, $formato){

        $sql = "INSERT INTO PLC_Formato (COD_TEMPORADA,DEP_DEPTO,NIV_JER1,COD_JER1,COD_SEG,DES_SEG) 
                VALUES( "
            . $temporada . ","
            . "'" . $depto . "',0,0,"
            . " (SELECT (NVL( MAX( TO_NUMBER( COD_SEG ) ), 0 ) + 1 ) AS INCREMENTAL FROM"
            . " PLC_Formato WHERE  COD_TEMPORADA = "
            . $temporada . " AND DEP_DEPTO = '" . $depto . "')," .
            "'" . $formato . "')";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/MANTENEDORFORMATO-NUEVOFORMATO--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);

        if($data){
            return "OK";
        }else{
            return "ERROR";
        }


    }
    // ######################## FIN Trabajo POPUP Formato ########################


    // ######################## DETALLE ERROR PI ########################
    public static function BuscaComentarioPI($temporada, $depto, $login, $pi, $id_color3)
    {

        $sql = "SELECT ERROR_PI
                FROM PLC_PLAN_COMPRA_COLOR_3
                WHERE cod_temporada = $temporada
                AND dep_depto = '" . $depto . "'
                AND proforma = '" . $pi . "'
                AND ID_COLOR3 = $id_color3
                ";
        $data = \database::getInstancia()->getFilas($sql);


        // Transformo a array asociativo
        $array1 = [];
        foreach ($data as $va1) {

            return utf8_encode($va1[0]);
            /*array_push($array1
                , array(
                    "ERROR_PI" => $va1[0]
                )
            );*/
        }
        //return $array1;

    }
    // ######################## FIN Trabajo POPUP Formatos ########################








  //listar data pop ajuste de compra
    public static function Listar_Pop_Ajuste_Compra($tempo, $depto, $id_color3, $tallas){


        $n_tallas = explode(",", $tallas);
        $columtallas = "";$t1= "";$t2= "";$t3= "";$t4= "";$t5= "";$t6= "";$t7= "";$t8= "";$t9= "";
        $countt = count($n_tallas);
        
        $i= 0;
        foreach($n_tallas as $val){$i++;
            if ($i==1){$t1= trim($val);
            }elseif($i==2){$t2= trim($val);
            }elseif($i==3){$t3= trim($val);
            }elseif($i==4){$t4= trim($val);
            }elseif($i==5){$t5= trim($val);
            }elseif($i==6){$t6= trim($val);
            }elseif($i==7){$t7= trim($val);
            }elseif($i==8){$t8= trim($val);
            }elseif($i==9){$t9= trim($val);
            }
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
                        where cod_temporada = " . $tempo . " 
                        and dep_depto = '" . $depto . "'
                        and  id_color3 = " . $id_color3 . "
                        and Tipo_ajuste = 'Ajuste de Compra')A
                ORDER BY order_ ASC";

        $data = \database::getInstancia()->getFilas($sql);
        $array1 = [];
        foreach ($data as $va1) {
            if ($countt == 1){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "Total" => $va1[2]
                    )
                );
            }
            elseif ($countt == 2){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1)=> $va1[1]
                                                , "t_".str_replace("/","_",$t2)=> $va1[2]
                                                , "Total" => $va1[3]
                                                )
                );
            }
            elseif ($countt == 3){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "t_".str_replace("/","_",$t2) => $va1[2]
                                                , "t_".str_replace("/","_",$t3) => $va1[3]
                                                , "Total" => $va1[4]
                    )
                );
            }
            elseif ($countt == 4){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "t_".str_replace("/","_",$t2) => $va1[2]
                                                , "t_".str_replace("/","_",$t3) => $va1[3]
                                                , "t_".str_replace("/","_",$t4) => $va1[4]
                                                , "Total" => $va1[5]
                    )
                );
            }
            elseif ($countt == 5){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "t_".str_replace("/","_",$t2) => $va1[2]
                                                , "t_".str_replace("/","_",$t3) => $va1[3]
                                                , "t_".str_replace("/","_",$t4) => $va1[4]
                                                , "t_".str_replace("/","_",$t5) => $va1[5]
                                                , "Total" => $va1[6]
                    )
                );
            }
            elseif ($countt == 6){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "t_".str_replace("/","_",$t2) => $va1[2]
                                                , "t_".str_replace("/","_",$t3) => $va1[3]
                                                , "t_".str_replace("/","_",$t4) => $va1[4]
                                                , "t_".str_replace("/","_",$t5) => $va1[5]
                                                , "t_".str_replace("/","_",$t6) => $va1[6]
                                                , "Total" => $va1[7]
                                                )
                );
            }
            elseif ($countt == 7){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "t_".str_replace("/","_",$t2) => $va1[2]
                                                , "t_".str_replace("/","_",$t3) => $va1[3]
                                                , "t_".str_replace("/","_",$t4) => $va1[4]
                                                , "t_".str_replace("/","_",$t5) => $va1[5]
                                                , "t_".str_replace("/","_",$t6) => $va1[6]
                                                , "t_".str_replace("/","_",$t7) => $va1[7]
                                                , "Total" => $va1[8]
                    )
                );
            }
            elseif ($countt == 8){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "t_".str_replace("/","_",$t2) => $va1[2]
                                                , "t_".str_replace("/","_",$t3) => $va1[3]
                                                , "t_".str_replace("/","_",$t4) => $va1[4]
                                                , "t_".str_replace("/","_",$t5) => $va1[5]
                                                , "t_".str_replace("/","_",$t6) => $va1[6]
                                                , "t_".str_replace("/","_",$t7) => $va1[7]
                                                , "t_".str_replace("/","_",$t8) => $va1[8]
                                                , "Total" => $va1[9]
                    )
                );
            }
            elseif ($countt == 9){
                array_push($array1, array("_" => $va1[0]
                                                , "t_".str_replace("/","_",$t1) => $va1[1]
                                                , "t_".str_replace("/","_",$t2) => $va1[2]
                                                , "t_".str_replace("/","_",$t3) => $va1[3]
                                                , "t_".str_replace("/","_",$t4) => $va1[4]
                                                , "t_".str_replace("/","_",$t5) => $va1[5]
                                                , "t_".str_replace("/","_",$t6) => $va1[6]
                                                , "t_".str_replace("/","_",$t7) => $va1[7]
                                                , "t_".str_replace("/","_",$t8) => $va1[8]
                                                , "t_".str_replace("/","_",$t9) => $va1[9]
                                                , "Total" => $va1[10]
                    )
                );
            }
        }

            return $array1;
    }

    public static function Listar_Pop_Ajuste_Cajas($tempo, $depto, $id_color3, $tallas, $tipo_empaque, $debut_reorder)
    {

        $sql="";

        $n_tallas = explode(",", $tallas);
        $columtallas = "";$t1= "";$t2= "";$t3= "";$t4= "";$t5= "";$t6= "";$t7= "";$t8= "";$t9= "";
        $countt = count($n_tallas);

        $i= 0;
        foreach($n_tallas as $val){$i++;
            if ($i==1){$t1= trim($val);
            }elseif($i==2){$t2= trim($val);
            }elseif($i==3){$t3= trim($val);
            }elseif($i==4){$t4= trim($val);
            }elseif($i==5){$t5= trim($val);
            }elseif($i==6){$t6= trim($val);
            }elseif($i==7){$t7= trim($val);
            }elseif($i==8){$t8= trim($val);
            }elseif($i==9){$t9= trim($val);
            }
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
                  where cod_temporada = " . $tempo . "
                  and dep_depto = '" . $depto . "'
                  and id_color3 = " . $id_color3 . "
                 and tipo_ajuste in ('Ajuste Curvado'))a order by n asc";
        }
        ELSEIF ($tipo_empaque == "SOLIDO" and $debut_reorder == "DEBUT") {

            $sql = "select COLUMNAS," . $columtallas . ",TOTAL
                     from(select COLUMNAS
                                       ,TALLA_1,TALLA_2,TALLA_3,TALLA_4,TALLA_5,TALLA_6,TALLA_7,TALLA_8,TALLA_9
                                       ,CASE WHEN COLUMNAS = 'Unid Ini' THEN 1 WHEN COLUMNAS = 'Primer Reparto' THEN 2
                                             WHEN COLUMNAS = '1er Reparto' THEN 3 WHEN COLUMNAS = 'Master Pack' THEN 4
                                             WHEN COLUMNAS = 'N Cajas' THEN 5 WHEN COLUMNAS = 'Unid Final' THEN 6 end n
                                       ,TOTAL
                         from plc_ajustes_compra
                         where cod_temporada = " . $tempo . " 
                         and dep_depto = '" . $depto . "'
                         and id_color3 = " . $id_color3 . "
                         and tipo_ajuste in ('Ajuste Master Pack'))a order by n asc";

        }
        ELSEIF ($tipo_empaque == "SOLIDO" and $debut_reorder == "REORDER") {
            $sql = "select COLUMNAS," . $columtallas . ",TOTAL
                     from(select COLUMNAS
                                       ,TALLA_1,TALLA_2,TALLA_3,TALLA_4,TALLA_5,TALLA_6,TALLA_7,TALLA_8,TALLA_9
                                       ,CASE WHEN COLUMNAS = 'Unid Ini' THEN 1
                                             WHEN COLUMNAS = 'Mst Pack' THEN 2
                                             WHEN COLUMNAS = 'N Cajas' THEN 3
                                             WHEN COLUMNAS = 'Und Final' THEN 4 end n
                                       ,TOTAL
                          from plc_ajustes_compra
                          where cod_temporada = " . $tempo . "
                          and dep_depto = '" . $depto . "'
                          and id_color3 = " . $id_color3 . "
                          and tipo_ajuste in ('Ajuste Master Pack'))a order by n asc";
        }



        $data = \database::getInstancia()->getFilas($sql);
        $array1 = [];
        foreach ($data as $va1) {
            if ($countt == 1){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "Total" => $va1[2]
                    )
                );
            }

            elseif ($countt == 2){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "Total" => $va1[3]
                    )
                );
            }
            elseif ($countt == 3){
                array_push($array1, array("_" => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "Total" => $va1[4]
                    )
                );
            }
            elseif ($countt == 4){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "Total" => $va1[5]
                    )
                );
            }
            elseif ($countt == 5){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "Total" => $va1[6]
                    )
                );
            }
            elseif ($countt == 6){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "Total" => $va1[7]
                    )
                );
            }
            elseif ($countt == 7){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4)=> $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "t_".str_replace("/","_",$t7) => $va1[7]
                    , "Total" => $va1[8]
                    )
                );
            }
            elseif ($countt == 8){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "t_".str_replace("/","_",$t7) => $va1[7]
                    , "t_".str_replace("/","_",$t8) => $va1[8]
                    , "Total" => $va1[9]
                    )
                );
            }
            elseif ($countt == 9){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "t_".str_replace("/","_",$t7) => $va1[7]
                    , "t_".str_replace("/","_",$t8) => $va1[8]
                    , "t_".str_replace("/","_",$t9) => $va1[9]
                    , "Total" => $va1[10]
                    )
                );
            }
        }
        return $array1;


    }

    public static function Listar_Pop_Ajuste_Cajas_curvado_solido($tempo, $depto, $id_color3, $tallas, $tipo_empaque, $debut_reorder)
    {

        $sql="";

        $n_tallas = explode(",", $tallas);
        $columtallas = "";$t1= "";$t2= "";$t3= "";$t4= "";$t5= "";$t6= "";$t7= "";$t8= "";$t9= "";
        $countt = count($n_tallas);

        $i= 0;
        foreach($n_tallas as $val){$i++;
            if ($i==1){$t1= trim($val);
            }elseif($i==2){$t2= trim($val);
            }elseif($i==3){$t3= trim($val);
            }elseif($i==4){$t4= trim($val);
            }elseif($i==5){$t5= trim($val);
            }elseif($i==6){$t6= trim($val);
            }elseif($i==7){$t7= trim($val);
            }elseif($i==8){$t8= trim($val);
            }elseif($i==9){$t9= trim($val);
            }
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
                  where cod_temporada = " . $tempo . "
                  and dep_depto = '" . $depto . "'
                  and id_color3 = " . $id_color3 . "
                 and tipo_ajuste in ('Solido Curvado'))a order by n asc";
        }


        $data = \database::getInstancia()->getFilas($sql);
        $array1 = [];
        foreach ($data as $va1) {
            if ($countt == 1){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "Total" => $va1[2]
                    )
                );
            }
            elseif ($countt == 2){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "Total" => $va1[3]
                    )
                );
            }
            elseif ($countt == 3){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3)=> $va1[3]
                    , "Total" => $va1[4]
                    )
                );
            }
            elseif ($countt == 4){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "Total" => $va1[5]
                    )
                );
            }
            elseif ($countt == 5){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "Total" => $va1[6]
                    )
                );
            }
            elseif ($countt == 6){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "Total" => $va1[7]
                    )
                );
            }
            elseif ($countt == 7){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "t_".str_replace("/","_",$t7) => $va1[7]
                    , "Total" => $va1[8]
                    )
                );
            }
            elseif ($countt == 8){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "t_".str_replace("/","_",$t7) => $va1[7]
                    , "t_".str_replace("/","_",$t8) => $va1[8]
                    , "Total" => $va1[9]
                    )
                );
            }
            elseif ($countt == 9){
                array_push($array1, array($tipo_empaque => $va1[0]
                    , "t_".str_replace("/","_",$t1) => $va1[1]
                    , "t_".str_replace("/","_",$t2) => $va1[2]
                    , "t_".str_replace("/","_",$t3) => $va1[3]
                    , "t_".str_replace("/","_",$t4) => $va1[4]
                    , "t_".str_replace("/","_",$t5) => $va1[5]
                    , "t_".str_replace("/","_",$t6) => $va1[6]
                    , "t_".str_replace("/","_",$t7) => $va1[7]
                    , "t_".str_replace("/","_",$t8) => $va1[8]
                    , "t_".str_replace("/","_",$t9) => $va1[9]
                    , "Total" => $va1[10]
                    )
                );
            }
        }
        return $array1;

    }


    //presupuestos
    public static function obtienePptoCosto($temporada, $depto) {

        $sql =  " SELECT PRESUPUESTO as VALOR_UNI"
            ." FROM   PLC_PPTO_COSTO C"
            ." WHERE  C.COD_TEMPORADA =" . $temporada
            ." AND    C.DEP_DEPTO     = '" . $depto . "'";

        $data = \database::getInstancia()->getFila($sql);
        $data2 = (object) \database::getInstancia()->getFila($sql);

        if (!$data){
            return 0;
        }else {
            return $data2->VALOR_UNI;
        }
    }

    public static function obtienePptoRetail($temporada, $depto) {

        $sql =  " SELECT MATI as VALOR_UNI"
            ." FROM   PLC_PPTO_RETAIL C"
            ." WHERE  C.COD_TEMPORADA =" . $temporada
            ." AND    C.DEP_DEPTO     = '" . $depto . "'";

        $data = \database::getInstancia()->getFila($sql);
        $data2 = (object) \database::getInstancia()->getFila($sql);

        if (!$data){
            return 0;
        }else {
            return $data2->VALOR_UNI;
        }

    }

    public static function obtienePptosemb($temporada, $depto) {

        $sql = "SELECT B.VENT_DESCRI
                      ,sum(A.PORCENTAJE) AS PORCENTAJE 
                FROM  PLC_PPTO_EMB A"
            . " INNER JOIN PLC_VENTANA B ON A.COD_VENTANA=B.COD_VENTANA"
            . " WHERE A.COD_TEMPORADA =" . $temporada . " AND A.DEP_DEPTO='" . $depto . "' "
            . " GROUP BY A.COD_VENTANA,B.VENT_DESCRI ORDER BY B.VENT_DESCRI ASC";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    public static function obtieneConsumo($temporada, $depto)
    {

        $sql = "SELECT PERIODO VENTANA
                      ,SUM(COSTO) COSTO
                      ,SUM(VTA_CDSCTO) RETAIL
                FROM plc_plan_compra_color_CIC A
                WHERE A.cod_temporada = " . $temporada . "
                AND A.dep_depto = '" . $depto . "'
                GROUP BY PERIODO
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }

    //POR PRESUPUESTOS EDIT
    public static function InsertPptoCosto($temporada,$depto,$presupuesto,$login)
    {

        $sql = "INSERT INTO PLC_PPTO_COSTO( COD_TEMPORADA,
                                   DEP_DEPTO,
                                   NIV_JER1,
                                   COD_JER1,
                                   NIV_JER2,
                                   COD_JER2,
                                   PRESUPUESTO,
                                   USR_CRE,
                                   FEC_CRE )
                           VALUES( $temporada,
                                   '" . $depto . "',
                                   0,
                                   0,
                                   0,
                                   0,
                                   $presupuesto,
                                   '" . $login . "',
                                   SYSDATE )
                                   ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTOCOSTO-AGREGA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }
    public static function EliminarPptoCosto($temporada, $depto, $login)
    {

        $sql = "DELETE FROM PLC_PPTO_COSTO 
                WHERE cod_temporada = $temporada 
                AND dep_depto = '" . $depto . "'
                ";
        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTOCOSTO-QUITAR--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);
        $data = \database::getInstancia()->getConsulta($sql);
        return $data;
    }
    public static function InsertPptoRetail($temporada,$depto,$presupuesto, $login)
    {

        $sql = "INSERT INTO PLC_PPTO_RETAIL( COD_TEMPORADA,
                                   DEP_DEPTO,
                                   NIV_JER1,
                                   COD_JER1,
                                   NIV_JER2,
                                   COD_JER2,
                                   MATI,
                                   USR_CRE,
                                   FEC_CRE )
                           VALUES( $temporada,
                                   '" . $depto . "',
                                   0,
                                   0,
                                   0,
                                   0,
                                   $presupuesto,
                                   '" . $login . "',
                                   SYSDATE )";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTORETAIL-AGREGA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }
    public static function EliminarPptoRetail($temporada, $depto, $login)
    {
        $sql = "DELETE FROM PLC_PPTO_RETAIL P
                WHERE P.COD_TEMPORADA = $temporada          
                AND P.DEP_DEPTO = '".$depto."'
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PPTORETAIL-QUITAR--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;
    }
    public static function InsertVentEmb($temporada, $depto, $ventana, $porcentaje, $login)
    {
        $cod_ventana= 0;
        $sql = "SELECT COD_VENTANA
                FROM PLC_VENTANA
                WHERE VENT_DESCRI = '".strtoupper($ventana)."'";
        $data = \database::getInstancia()->getFila($sql);
        if (count($data) > 1){
            $cod_ventana = $data['COD_VENTANA'];
        }

        $sql = "INSERT INTO PLC_PPTO_EMB ( COD_TEMPORADA,
                                  DEP_DEPTO,
                                  NIV_JERARQUIA,
                                  COD_JERARQUIA,
                                  COD_VENTANA,
                                  PORCENTAJE,
                                  USR_CRE,
                                  FEC_CRE )
               VALUES($temporada,
                    '".$depto."',
                    0,
                    0,
                    ".$cod_ventana.",
                    ".$porcentaje.",
                    '".$login."',
                    SYSDATE)
                    ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/VENTANALLEGADA-AGREGA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }
    public static function EliminarVentEmb($temporada, $depto, $login)
    {
        $sql = "DELETE FROM PLC_PPTO_EMB 
                WHERE cod_temporada = $temporada 
                AND dep_depto = '" . $depto . "'
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/VENTANALLEGADA-QUITAR--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);


        return $data;
        //return 0;
    }



    public static function ListarDeptosTemp($temporada)
    {
        $ArrayAsociativo =[];
        $sql = "begin PLC_PKG_DESARROLLO.PRC_LISTDEPTXTEMP(" . $temporada . ", :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        foreach ($data as $va1) {
            array_push($ArrayAsociativo
                       , array("COD_DEPARTAMENTO" => $va1[0]
                              ,"DEPARTAMENTO" => $va1[1])
            );
        }

        return $ArrayAsociativo;
    }
    Public static Function ListarDeptosTempAssortment($temporada){
        $ArrayAsociativo=[];
        $sql = "SELECT DISTINCT  A.DEP_DEPTO          COD_DEPARTAMENTO
                                ,F.DEPARTMENT         DEPARTAMENTO
               FROM PLC_HISTORIAL_ASSORTMENT A
               LEFT JOIN(SELECT DEP_DESCRIPCION DEPARTMENT
                                    ,DEP_DEPTO
                               FROM GST_MAEDEPTOS
                        )F ON  F.DEP_DEPTO = A.DEP_DEPTO
               WHERE A.COD_TEMPORADA = ".$temporada." order by  A.DEP_DEPTO asc";
        $data = \database::getInstancia()->getFilas($sql);

        foreach ($data as $va1) {
            array_push($ArrayAsociativo
                , array("COD_DEPARTAMENTO" => $va1[0]
                ,"DEPARTAMENTO" => $va1[1])
            );
        }

        return $ArrayAsociativo;
    }
    Public static Function ListExportAssortment($tempo,$depto){
        $sql = "select DEP_DEPTO,DPTO,MARCA,CODIGO_MARCA,NOMBRE_COMPRADOR,NOMBRE_DISENADOR,SEASON,LINEA,COD_LINEA,SUBLINEA,COD_SUBLINEA
                       ,CODIGO_CORPORATIVO,NOMBRE_ESTILO,ESTILO_CORTO,DESCRIPCION_ESTILO,DESCRIP_INTERNET,NUM_EMB AS COD_OPCION,COLOR,COD_COLOR
                       ,COMPOSICION,TIPO_DE_TELA,FORRO,NOM_CALIDAD,COLECCION,NOM_ESTILOVIDA,NOM_OCACIONUSO
                       ,EVENTO,EVENTO_INSTORE, GRUPO_DE_COMPRA,VENTANA,TIPO_EXHIBICION,TIPO_PRODUCTO, DEBUT_O_REORDER
                       ,TEMPORADA,PRECIO,OFERTA,DOSX,OPEX, RANKING_DE_VENTA, CICLO_DE_VIDA, PIRAMIDE_MIX, RATIO_COMPRA, FACTOR_AMPLIFICACION
                       ,RATIO_COMPRA_FINAL, CLUSTER_, FORMATO, COMPRA_UNIDADES_ASSORTMENT, COMPRA_UNIDADES_FINAL,VAR_PORCE
                       ,TARGET_USD, FOB_USD, RFID_USD,COSTO_INSP, VIA, PAIS, PROVEEDOR, COMENTARIOS_POST_NEGOCIACION, FECHA_EMBARQUE_ACORDADA
                       ,FACTOR, COSTO_TOTAL, RETAIL_TOTAL_SIN_IVA, MUP_COMPRA, EXHIBICION, TALLA1, TALLA2
                       ,TALLA3, TALLA4, TALLA5, TALLA6, TALLA7, TALLA8, TALLA9,INNER , CURVA1, CURVA2, CURVA3, CURVA4, CURVA5, CURVA6, CURVA7, CURVA8
                       ,CURVA9, VALIDADOR_MASTERPACK_INNER, TIPO_DE_EMPAQUE, N_CURVAS_POR_CAJA_CURVADAS, UNO_POR, DOS_POR, TRES_POR
                       ,CUATRO_POR, CINCO_POR, SEIS_POR, SIETE_POR, OCHO_POR, NUEVE_POR, TIENDASA, TIENDASB, TIENDASC, TIENDASI
                       ,CLUSTERA, CLUSTERB, CLUSTERC, CLUSTERI, SIZE_1, SIZE_2, SIZE_3, SIZE_4, SIZE_5
                       ,SIZE_6, SIZE_7, SIZE_8, SIZE_9,UNIDADES
                  from plc_historial_assortment 
                  WHERE COD_TEMPORADA = ".$tempo."
                  and dep_depto IN (".$depto.")
                  ORDER BY DEP_DEPTO,CODIGO_MARCA asc";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;
    }
    public static function ListColumnasArchivos($tipo){
        //1.- Assortment
        //2.- BMT
        //3.- columnas nuevas assortment

        $sql = "select COLUMNAS".
            " from plc_columnas_archivos".
            " WHERE COD_TIPOARCHIVO =".$tipo."";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;

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
                ,"Nombre Corto"=> utf8_encode($va1[9])
                ,"Cod Corp"=> utf8_encode($va1[10])
                ,"Descripción"=> utf8_encode($va1[11])
                ,"Desc Internet"=> utf8_encode($va1[12])
                ,"Nombre Comprador"=> utf8_encode($va1[13])
                ,"Nombre Disenador"=> utf8_encode($va1[14])
                ,"Composición"=> utf8_encode($va1[15])
                ,"Tipo de Tela"=> utf8_encode($va1[16])
                ,"Forro"=> utf8_encode($va1[17])
                ,"Colección"=> utf8_encode($va1[18])
                ,"Evento"=> utf8_encode($va1[19])
                ,"Evento In-Store"=> utf8_encode($va1[94])
                ,"Estilo de Vida"=> utf8_encode($va1[20])
                ,"Calidad"=> utf8_encode($va1[21])
                ,"Ocasión de Uso"=> utf8_encode($va1[22])
                ,"Pirámide Mix"=> utf8_encode($va1[23])
                ,"Ventana"=> utf8_encode($va1[24])
                ,"Rank Vta"=> utf8_encode($va1[25])
                ,"Life Cycle"=> utf8_encode($va1[26])
                ,"Color"=> utf8_encode($va1[27])
                ,"Tipo Producto"=> utf8_encode($va1[28])
                ,"Tipo Exhibición"=> utf8_encode($va1[29])
                ,"Tallas"=> utf8_encode($va1[30])
                ,"Tipo Empaque"=> utf8_encode($va1[31])
                ,"% Compra Ini"=> utf8_encode($va1[32])
                ,"% Compra Ajustada"=> utf8_encode($va1[33])
                ,"Curvas de Reparto"=> utf8_encode($va1[34])
                ,"Curva Min"=> utf8_encode($va1[35])
                ,"Unid Ini"=> utf8_encode($va1[36])
                ,"Unid Ajust"=> utf8_encode($va1[37])
                ,"Unid Final"=> utf8_encode($va1[38])
                ,"Mtr Pack"=> utf8_encode($va1[39])
                ,"N° Cajas"=> utf8_encode($va1[40])
                ,"Clúster"=> utf8_encode($va1[41])
                ,"Formato"=> utf8_encode($va1[42])
                ,"Tdas"=> utf8_encode($va1[43])
                ,"A"=> utf8_encode($va1[44])
                ,"B"=> utf8_encode($va1[45])
                ,"C"=> utf8_encode($va1[46])
                ,"I"=> utf8_encode($va1[47])
                ,"Primera Carga"=> utf8_encode($va1[48])
                ,"%Tiendas"=> utf8_encode($va1[49])
                ,"Proced"=>utf8_encode( $va1[50])
                ,"Vía"=> utf8_encode($va1[51])
                ,"País"=> utf8_encode($va1[52])
                ,"Viaje"=> utf8_encode($va1[53])
                ,"Mkup Blanco"=> utf8_encode($va1[54])
                ,"Precio Blanco"=> utf8_encode($va1[55])
                ,"GM Blanco"=>utf8_encode($va1[56])
                ,"Oferta"=>utf8_encode($va1[57])
                ,"2X"=>utf8_encode($va1[95])
                ,"Opex"=>utf8_encode($va1[96])
                ,"Moneda"=> utf8_encode($va1[58])
                ,"Target"=> utf8_encode($va1[59])
                ,"FOB"=> utf8_encode($va1[60])
                ,"Insp"=> utf8_encode($va1[61])
                ,"RFID"=> utf8_encode($va1[62])
                ,"Royalty(%)"=> utf8_encode($va1[63])
                ,"Costo Unitario Final US$"=> utf8_encode($va1[64])
                ,"Costo Unitario Final Pesos"=> utf8_encode($va1[65])
                ,"Total Target US$"=> utf8_encode($va1[66])
                ,"Total Fob US$"=> utf8_encode($va1[67])
                ,"Costo Total Pesos"=> utf8_encode($va1[68])
                ,"Total Retail Pesos(Sin IVA)"=> utf8_encode($va1[69])
                ,"Debut/Reorder"=> utf8_encode($va1[70])
                ,"Sem Ini"=> utf8_encode($va1[71])
                ,"Sem Fin"=> utf8_encode($va1[72])
                ,"Semanas Ciclo de Vida"=> utf8_encode($va1[73])
                ,"Agot Obj"=> utf8_encode($va1[74])
                ,"Semanas Liquidación"=> utf8_encode($va1[75])
                ,"Proveedor"=> utf8_encode($va1[76])
                ,"Razon Social"=> utf8_encode($va1[77])
                ,"Trader"=> utf8_encode($va1[78])
                ,"Comentarios Post Negociacion"=> utf8_encode($va1[79])
                ,"Cod Sku Proveedor"=> utf8_encode($va1[80])
                ,"Cod. Padre"=> utf8_encode($va1[81])
                ,"Proforma"=> utf8_encode($va1[82])
                ,"Archivo"=> utf8_encode($va1[83])
                ,"Estilo PMM"=> utf8_encode($va1[84])
                ,"Estado Match"=> utf8_encode($va1[85])
                ,"N° OC"=> utf8_encode($va1[86])
                ,"Estado OC"=> utf8_encode($va1[87])
                ,"Fecha Embarque Acordada"=> utf8_encode($va1[88])
                ,"Fecha Embarque"=> utf8_encode($va1[89])
                ,"Fecha ETA"=> utf8_encode($va1[90])
                ,"Fecha Recepción CD"=> utf8_encode($va1[91])
                ,"Días Atraso CD"=> utf8_encode($va1[92])
                ,"Estado Opción"=> utf8_encode($va1[93])
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
    public static function ListarEstadosPlan($temporada)
    {
        $ArrayAsociativo=[];
        $sql = "begin PLC_PKG_DESARROLLO.PRC_LISTAR_ESTADOS(" . $temporada . ", :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);

        foreach ($data as $va1) {
            array_push($ArrayAsociativo
                , array("CODIGO" => $va1[0]
                        ,"NOM_ESTADO" => $va1[1])
            );
        }
        return $ArrayAsociativo;
    }
    Public static Function ListExportEstados($tempo,$depto_cadena,$estado)
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

    Public static Function ListExportEstados18($tempo,$depto_cadena,$estado)
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

    Public static Function ListExportEstados19($tempo,$depto_cadena,$estado)
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

    Public static Function ListExportEstados23($tempo,$depto_cadena,$estado)
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
// Fin de la Clase
}