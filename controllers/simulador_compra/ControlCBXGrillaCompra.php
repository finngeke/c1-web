<?php
	
	/**
	 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
	 * Descripción:
	 * Fecha: 2018-05-09
	 * @author ROBERTO PÈREZ
	 */
	
	namespace simulador_compra;
	
	class ControlCBXGrillaCompra extends \Control {

		// Llenar Tabla2 (Grilla)
		public function llenar_tabla2($f3) {
		$data = \simulador_compra\cbx_grilla_compra::llenar_tabla2($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'));
			$json = [];$dtPIs =[];

			foreach ($data as $val) {
                //vista y update de estado oc  18= Compra confirmada con PI /22 = solicitud de generacion oc / 19 = pendiente de aprobcion de match
                $proforma = utf8_encode($val["PROFORMA"]);$orden_compra = ""; $estadoOc = "";$f_embarque = "";$f_eta = "";$f_recepcion = "";$dias_atrasado = ""; $_exist = false; $ESTADO= $val["ESTADO_C1"];$nom_estado= $val["CODESTADO"];
                    if ($proforma <> 'null' and $proforma <> null and $proforma <> '0' and $proforma <> '' and
                        ($val["ESTADO_C1"] == 18 or $val["ESTADO_C1"] == 19 or $val["ESTADO_C1"] == 22)) {

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
                            $dt = json_decode(\simulador_compra\cbx_grilla_compra::traer_datos_oc($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $proforma, $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL')));
                            if (($dt->Body->fault->faultCode == 0) and (count($dt->Body->detalleConsultaOrdenCompra->detalle)) > 0) {
                                $orden_compra = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->ordenCompra;
                                $estadoOc = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->estadoOC;
                                $f_embarque = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->fechaEmbarque;
                                $f_eta = $dt->Body->detalleConsultaOrdenCompra->detalle[0]->fechaEta;
                                $f_recepcion = date("d-m-Y", (strtotime(date($f_eta) . "+ 15 days")));

                                try {
                                    $datetime1 = date_create($f_recepcion);
                                    $datetime2 = date_create($val["FECHA_RECEPCD_C1"]);
                                    $interval = date_diff($datetime2, $datetime1);
                                    $dias_atrasado = $interval->format('%R%a');
                                } catch (Exception $e) {
                                    $dias_atrasado = "";
                                }
                                $ESTADO = 19;
                                $nom_estado =  "Pendiente de Aprobacion sin Match";
                                //actualizamos el flujo de estado automatico
                                \simulador_compra\cbx_grilla_compra::Update_flujo_estado_oc_vist($f3->get('SESSION.COD_TEMPORADA')
                                    , $f3->get('SESSION.COD_DEPTO')
                                    , $val["ESTADO_C1"]
                                    , $f3->get('SESSION.login')
                                    , $orden_compra
                                     ,$proforma);
                            }
                            array_push($dtPIs, array($proforma, $orden_compra, $estadoOc, $f_embarque, $f_eta, $f_recepcion, $dias_atrasado,$ESTADO,$nom_estado));
                        }

                    }
                    else{
                     $orden_compra =  utf8_encode($val["PO_NUMBER"]);
                     $estadoOc =  utf8_encode($val["ESTADO_OC"]);
                     $f_embarque = utf8_encode($val["FECHA_EMBARQUE"]);
                     $f_eta =  utf8_encode($val["FECHA_ETA"]);
                     $f_recepcion =  utf8_encode($val["FECHA_RECEPCION"]);
                     $dias_atrasado =  utf8_encode($val["DIAS_ATRASO"]);
                     $ESTADO= $val["ESTADO_C1"];
                     $nom_estado= $val["CODESTADO"];

                    }



//Carga la data plan de compra
				$json[] = array(
					$val["ID_COLOR3"],                      // 0
					utf8_encode($val["GRUPO_COMPRA"]),      // 1
					$val["COD_TEMP"],                       // 2
                    utf8_encode($val["LINEA"]),             // 3
                    utf8_encode($val["SUBLINEA"]),          // 4
                    utf8_encode($val["MARCA"]),             // 5
                    utf8_encode($val["ESTILO"]),            // 6
                    utf8_encode($val["SHORT_NAME"]),        // 7
					utf8_encode($val["ID_CORPORATIVO"]),    // 8
					utf8_encode($val["DESCMODELO"]),        // 9
					utf8_encode($val["DESCRIP_INTERNET"]),  // 10
					utf8_encode($val["COMPOSICION"]),       // 11
					utf8_encode($val["COLECCION"]),         // 12
					utf8_encode($val["EVENTO"]),            // 13
                    utf8_encode($val["COD_ESTILO_VIDA"]),   // 14
					utf8_encode($val["CALIDAD"]),           // 15
					utf8_encode($val["COD_OCASION_USO"]),   // 16
                    utf8_encode($val["COD_PIRAMIX"]),       // 17
                    utf8_encode($val["DESCRIPCION"]),       // 18
                    utf8_encode($val["COD_RANKVTA"]),       // 19
                    utf8_encode($val["LIFE_CYCLE"]),        // 20
                    utf8_encode($val["NUM_EMB"]),           // 21
					utf8_encode($val["COD_COLOR"]),         // 22
					utf8_encode($val["TIPO_PRODUCTO"]),     // 23
					utf8_encode($val["TIPO_EXHIBICION"]),   // 24
					utf8_encode($val["DESTALLA"]),          // 25
					utf8_encode($val["TIPO_EMPAQUE"]),      // 26
					utf8_encode($val["PORTALLA_1_INI"]),    // 27
					utf8_encode($val["PORTALLA_1"]),        // 28
					utf8_encode($val["CURVATALLA"]),        // 29
					$val["CURVAMIN"],                       // 30
					$val["UNID_OPCION_INICIO"],             // 31
					$val["UNID_OPCION_AJUSTADA"],           // 32
					$val["CAN"],                            // 33
					$val["MTR_PACK"],                       // 34
					$val["CANT_INNER"],                     // 35
                    utf8_encode($val["SEG_ASIG"]),          // 36
					utf8_encode($val["FORMATO"]),           // 37
                    utf8_encode($val["TDAS"]),              // 38
					$val["A"],                              // 39
					$val["B"],                              // 40
					$val["C"],                              // 41
					$val["I"],                              // 42
					$val["UND_ASIG_INI"],                   // 43
                    utf8_encode($val["ROT"]),               // 44
					utf8_encode($val["NOM_PRECEDENCIA"]),   // 45
					utf8_encode($val["NOM_VIA"]),           // 46
					utf8_encode($val["NOM_PAIS"]),          // 47
					utf8_encode($val["VIAJE"]),             // 48
					$val["MKUP"],                           // 49
					$val["PRECIO_BLANCO"],                  // 50
					$val["GM"],                             // 51
                    utf8_encode($val["COD_TIP_MON"]),       // 52
					$val["COSTO_TARGET"],                   // 53
					$val["COSTO_FOB"],                      // 54
					$val["COSTO_INSP"],                     // 55
					$val["COSTO_RFID"],                     // 56
					$val["ROYALTY_POR"],                    // 57
					$val["COSTO_UNIT"],                     // 58
					$val["COSTO_UNITS"],                    // 59
					$val["CST_TOTLTARGET"],                 // 60
					$val["COSTO_TOT"],                      // 61
					$val["COSTO_TOTS"],                     // 62
					utf8_encode($val["RETAIL"]),            // 63
					utf8_encode($val["DEBUT_REODER"]),      // 64
					$val["SEM_INI"],                        // 65
					$val["SEM_FIN"],                        // 66
					$val["CICLO"],                          // 67
					$val["AGOT_OBJ"],                       // 68
					$val["SEMLIQ"],                         // 69
					utf8_encode($val["ALIAS_PROV"]),        // 70
					utf8_encode($val["COD_PROVEEDOR"]),     // 71
					utf8_encode($val["COD_TRADER"]),        // 72
					utf8_encode($val["CODSKUPROVEEDOR"]),   // 73
                    utf8_encode($val["SKU"]),               // 74
					utf8_encode($val["PROFORMA"]),          // 75
					$val["ARCHIVO"],                        // 76
                    utf8_encode($val["ESTILO_PMM"]),        // 77
                    utf8_encode($val["ESTADO_MATCH"]),      // 78
                    $orden_compra,                          // 79
					$estadoOc,                              // 80
					$f_embarque,                            // 81
					$f_eta,                                 // 82
                    $f_recepcion,                           // 83
                    $dias_atrasado,                         // 84
                    $nom_estado,                            // 85
                    $ESTADO,                                // 86
					utf8_encode($val["VENTANA_LLEGADA"]),   // 87
					""               // 88
				);
			}

			header("Content-Type: application/json");
			echo json_encode($json, JSON_PRETTY_PRINT);
		}

        public function llenar_edita_grilla($f3) {
        $data = \simulador_compra\cbx_grilla_compra::llenar_edita_grilla($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.ID_COLOR3'));
        $json = [];
        foreach ($data as $val) {
            $json[] = array(
                utf8_encode($val["GRUPO_COMPRA"]),  // 0    grupo compra
                utf8_encode($val["MARCA"]),         // 1    marca
                utf8_encode($val["LINEA"]),         // 2    linea
                utf8_encode($val["SUBLINEA"]),      // 3    sublinea
                utf8_encode($val["ESTILO"]),        // 4    estilo
                utf8_encode($val["SHORT_NAME"]),    // 5    estilo corto
                utf8_encode($val["NOM_VENTANA"]),   // 6    ventana
                utf8_encode($val["COD_COLOR"]),     // 7    color
                $val["CAN"],                        // 8    Uni Final
                $val["COSTO_TARGET"],               // 9    Target
                $val["COSTO_FOB"],                  // 10   FOB
                $val["COSTO_INSP"],                 // 11   Insp
                $val["COSTO_RFID"],                 // 12   RFID
                utf8_encode($val["ALIAS_PROV"]),    // 13   Alias Proveedor
                $val["ID_COLOR3"],                  // 14   id_color3
                $val["MKUP"],                       // 15   mkup
                $val["GM"],                         // 16   GM
                $val["VIA"],                        // 17   NOM_VIA / VIA
                $val["PAIS"],                       // 18   NOM_PAIS / PAIS
                $val["VENTANA_LLEGADA"],            // 19   ventana_llegada
                $val["PRECIO_BLANCO"],              // 20   Precio Blanco
                $val["UNID_OPCION_INICIO"],         // 21   Unid Inicial
                $val["CURVATALLA"],                 // 22   CURVA TALLA
                $val["DESTALLA"],                   // 23   DESTALLA
                $val["SEG_ASIG"],                   // 24   CLUSTER
                $val["A"],                          // 25   A
                $val["B"],                          // 26   B
                $val["C"],                          // 27   C
                $val["I"],                          // 28   I
                $val["FORMATO"],                    // 29   formato
                $val["DEBUT_REODER"],               // 30   DEBUT_REORDER
                $val["PORTALLA_1_INI"],             // 31   PORTALLA_1_INI
                $val["COD_MARCA"],                  // 32   COD MARCA
                $val["N_CURVASXCAJAS"],             // 33   N_CURVASXCAJAS(CURVADO)
                $val["COD_JER2"],                   // 34   COD_JER2
                $val["COD_SUBLIN"],                 // 35   COD_SUBLINEA
                $val["TIPO_EMPAQUE"]                // 36   Tipo de empaque
            );
        }

        header("Content-Type: application/json");
        echo json_encode($json, JSON_PRETTY_PRINT);

    }

		public function llenar_tabla_depto($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::llenar_tabla_depto($f3->get('SESSION.COD_TEMPORADA')));
		}
		
		public function llenar_tabla_oc($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::llenar_tabla_oc($f3->get('SESSION.COD_TEMPORADA')));
		}
		
		// Llenar Tabla2
		public function llenar_parte2_tabla1($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_consumo($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsLinea
		public function listar_optionsLinea($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsLinea($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsSubLinea
		public function listar_optionsSubLinea($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsSubLinea($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.ID_LINEA')));
		}
		
		// Listar CBX optionsMarca
		public function listar_optionsMarca($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsMarca($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsEVida
		public function listar_optionsEVida($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsEVida($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsOcacionUso
		public function listar_optionsOcacionUso($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsOcacionUso($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsPiramideMix
		public function listar_optionsPiramideMix($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsPiramideMix($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsVentanaLlegada
		public function listar_optionsVentanaLlegada($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsVentanaLlegada($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsRankVenta
		public function listar_optionsRankVenta($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsRankVenta($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsLifeCicle
		public function listar_optionsLifeCicle($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsLifeCicle($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsColor
		public function listar_optionsColor($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsColor($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}
		
		// Listar CBX optionsTipoProducto
		public function listar_optionsTipoProducto($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsTipoProducto($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsTipoExhibicion
		public function listar_optionsTipoExhibicion($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsTipoExhibicion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsCluster
		public function listar_optionsCluster($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsCluster($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsFormato
		public function listar_optionsFormato($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsFormato($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsProced
		public function listar_optionsProced($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsProced($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsVia
		public function listar_optionsVia($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsVia($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsPais
		public function listar_optionsPais($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsPais($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsMoneda
		public function listar_optionsMoneda($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsMoneda($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsRazonSocial
		public function listar_optionsRazonSocial($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsRazonSocial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsTrader
		public function listar_optionsTrader($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsTrader($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsEstadoOpcion
		public function listar_optionsEstadoOpcion($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsEstadoOpcion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// Listar CBX optionsProveedor
		public function listar_optionsProveedor($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_optionsProveedor($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
		}
		
		// guarda_solo_proforma
		public function guarda_solo_proforma($f3) {
			echo \simulador_compra\cbx_grilla_compra::guarda_solo_proforma($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'), $f3->get('GET.ID_INSERTAR'));
		}

        // guarda_solo_proforma
        public function guarda_solo_proforma_extra($f3) {
            echo \simulador_compra\cbx_grilla_compra::guarda_solo_proforma_extra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'), $f3->get('GET.ID_INSERTAR'));
        }
		
		// Actualiza Historial
		public function actualiza_historial($f3) {
			echo \simulador_compra\cbx_grilla_compra::actualiza_historial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'), $f3->get('GET.ID_INSERTAR'));
		}

        // Agrega Historial al momento de guardar proforma
        public function guardaHistorial($f3) {
            echo \simulador_compra\cbx_grilla_compra::guardaHistorial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.ID_INSERTAR'), $f3->get('SESSION.login'));
        }
		
		// Se actualiza estado Opcion segun estado OC PMM
		public function actualiza_estado_oc_segun_ocpmm($f3) {
			echo \simulador_compra\cbx_grilla_compra::actualiza_estado_oc_segun_ocpmm($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PI'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.ESTADO'));
		}
		
		// Comentario Corrección estado PI
		public function guarda_comentario_estado_pi($f3) {
			echo \simulador_compra\cbx_grilla_compra::guarda_comentario_estado_pi($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.COMENTARIO'), $f3->get('GET.PROFORMA'));
		}
		
		// Buscar Comentarios asociados a la PI (PROFORAM)
		public function busca_comentario_pi($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_comentario_pi($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PI')));
		}
		
		// Buscar Existe Proforma
		public function busca_existe_proforma($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_existe_proforma($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PI')));
		}
		
		// Buscar Existe Archivo Proforma
		public function busca_existe_archivo($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_existe_archivo($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PI')));
		}

// ######################## INICIO Trabajo con flujo de aprobación ########################
		
		public function trabaja_flujo_aprobacion_insert($f3) {
			echo \simulador_compra\cbx_grilla_compra::trabaja_flujo_aprobacion_insert($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.ESTADO'));
		}
		
		public function trabaja_flujo_aprobacion_update($f3) {
			echo \simulador_compra\cbx_grilla_compra::trabaja_flujo_aprobacion_update($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'), $f3->get('GET.ESTADO'));
		}

        public function trabaja_flujo_aprobacion_dinamico($f3) {
            echo \simulador_compra\cbx_grilla_compra::trabaja_flujo_aprobacion_dinamico($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.ESTADO_INSERT'), $f3->get('GET.PROFORMA'), $f3->get('GET.ESTADO_UPDATE'));
        }

// ######################## FIN Trabajo con flujo de aprobación ########################
		
		// Llenar despliega_hitorial_tabla
		public function llenar_tabla_historial($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::llenar_tabla_historial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.ID_COLOR3')));
		}
		
		// Traer Datos OC cuando existe PROFORMA en la Grilla
		public function traer_datos_oc($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::traer_datos_oc($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.PI'), $f3->get('CURLOPT_PORT'), $f3->get('CURLOPT_URL')));
		}

// ######################## INICIO TRABAJO CON MATCH ########################
		
		public function llenar_tabla_pmm($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::llenar_tabla_pmm($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI')));
		}
		
		public function llenar_tabla_plan($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::llenar_tabla_plan($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI')));
		}
		
		public function consultar_oc_linkeada($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::consultar_oc_linkeada($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI')));
		}
		
		public function quitar_oc_cancelada($f3) {
			echo \simulador_compra\cbx_grilla_compra::quitar_oc_cancelada($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI'));
		}
		
		public function agrega_tabla_b_ocpi($f3) {
			echo \simulador_compra\cbx_grilla_compra::agrega_tabla_b_ocpi($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI'));
		}
		
		public function agrega_registroswsoc_a_tabla_b($f3) {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      //str_replace('.',',',$f3->get('GET.V_COSTO'))
			echo \simulador_compra\cbx_grilla_compra::agrega_registroswsoc_a_tabla_b($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI'), $f3->get('GET.V_NOMBRE_ESTILO'), $f3->get('GET.V_NRO_ESTILO'), $f3->get('GET.V_ESTADO_ESTILO'), $f3->get('GET.V_NOMBRE_VARIACION'), $f3->get('GET.V_NRO_VARIACION'), $f3->get('GET.V_COLOR'), $f3->get('GET.V_COD_COLOR'), $f3->get('GET.V_NOMBRE_LINEA'), $f3->get('GET.V_NRO_LINEA'), $f3->get('GET.V_NOMBRE_SUB_LINEA'), $f3->get('GET.V_NRO_SUB_LINEA'), $f3->get('GET.V_TEMPORADA'), $f3->get('GET.V_CICLO_VIDA'), $f3->get('GET.V_ESTADO_OC'), $f3->get('GET.V_FECHA_EMBARQUE'), $f3->get('GET.V_FECHA_ETA'), $f3->get('GET.V_UNIDADES'), $f3->get('GET.V_COSTO'), $f3->get('GET.V_MONEDA'), $f3->get('GET.V_PAIS'));
		}
		
		public function valida_tablab_cuza_color3($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::valida_tablab_cuza_color3($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI')));
		}
		
		public function btn_actualizar_match($f3) {
			echo \simulador_compra\cbx_grilla_compra::btn_actualizar_match($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.LINEA'), $f3->get('GET.SUBLINEA'), $f3->get('GET.ESTILO'), $f3->get('GET.COLOR'));
		}
		
		public function listar_plan_compra_color($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_plan_compra_color($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA')));
		}
		
		public function generar_match($f3) {
			echo \simulador_compra\cbx_grilla_compra::generar_match($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'), $f3->get('GET.ESTILO'), $f3->get('GET.CODVENTANA'), $f3->get('GET.OC'));
		}
		
		public function aprobar_opcion($f3) {
			echo \simulador_compra\cbx_grilla_compra::aprobar_opcion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.PROFORMA'));
		}
		
		public function listar_idcolor3_compra($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_idcolor3_compra($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3')));
		}
		
		public function insertar_historial($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::insertar_historial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.V_LINEA'), $f3->get('GET.V_SUBLINEA'), $f3->get('GET.V_MARCA'), $f3->get('GET.V_ESTILO'), $f3->get('GET.V_VENTANA'), $f3->get('GET.V_COLOR'), $f3->get('SESSION.login'), $f3->get('GET.V_PI'), $f3->get('GET.V_OC'), $f3->get('GET.V_ESTADO'), $f3->get('GET.V_ID_COLOR3'), $f3->get('GET.V_TIPOINSERT'), $f3->get('GET.V_NOM_LINEA'), $f3->get('GET.V_NOM_SUBLINEA'), $f3->get('GET.V_NOM_MARCA'), $f3->get('GET.V_NOM_VENTANA'), $f3->get('GET.V_NOM_COLOR')));
		}
		
		public function listar_ventana_embarque_llegada($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::listar_ventana_embarque_llegada($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.PROFORMA')));
		}
		
		public function quita_registro_variacion($f3) {
			echo \simulador_compra\cbx_grilla_compra::quita_registro_variacion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI'));
		}
		
		public function agregar_oc_variacion($f3) {
			echo \simulador_compra\cbx_grilla_compra::agregar_oc_variacion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC'), $f3->get('GET.PI'));
		}
		
		public function agregar_new_oc_variacion($f3) {
			echo \simulador_compra\cbx_grilla_compra::agregar_new_oc_variacion($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'));
		}
		
		public function busca_oc_estado_20($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_oc_estado_20($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login')));
		}
		
		public function busca_estado_oc_pmm($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_estado_oc_pmm($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.OC')));
		}
		
		public function estado_oc_4_inserta_historial($f3) {
			echo \simulador_compra\cbx_grilla_compra::estado_oc_4_inserta_historial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.LINEA'), $f3->get('GET.SUBLINEA'), $f3->get('GET.MARCA'), $f3->get('GET.ESTILO'), $f3->get('GET.VENTANA'), $f3->get('GET.COLOR'), $f3->get('SESSION.login'), $f3->get('GET.PI'), $f3->get('GET.OC'), $f3->get('GET.ESTADO'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.TIPO_INSERT'), $f3->get('GET.NOM_LINEA'), $f3->get('GET.NOM_SUBLINEA'), $f3->get('GET.NOM_MARCA'), $f3->get('GET.NOM_VENTANA'), $f3->get('GET.NOM_COLOR'));
		}

// ######################## FIN TRABAJO CON MATCH ########################
		
		public function ComboboxAjusteCompra($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::Combobox_ajust_compra($f3->get('SESSION.COD_TEMPORADA')
				, $f3->get('SESSION.COD_DEPTO')
				, $f3->get('GET.color3')
				, $f3->get('GET.tallas')));
		}
		
		public function ComboboxAjusteNCajas($f3) {
			
			echo json_encode(\simulador_compra\cbx_grilla_compra::Combobox_ajust_n_cajas($f3->get('SESSION.COD_TEMPORADA')
				, $f3->get('SESSION.COD_DEPTO')
				, $f3->get('GET.color3')
				, $f3->get('GET.tallas')
				, $f3->get('GET.t_empaque')
				, $f3->get('GET.debut_reorder')));
			
		}
		
		public function checkboxgrupo($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::checkbox_list_grupocompraXdepto($f3->get('SESSION.COD_TEMPORADA')
				, $f3->get('SESSION.COD_DEPTO')));
			
		}

// ######################## INICIO TRABAJO CON ACCESO SIMULADOR DE COMPRA SELECCIONA DEPARTAMENTO ########################
		
		public function busca_existe_pto_embarque($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_existe_pto_embarque($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPTO'), $f3->get('SESSION.login')));
		}
		
		public function busca_existe_pto_costo($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_existe_pto_costo($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPTO'), $f3->get('SESSION.login')));
		}
		
		public function busca_existe_pto_retail($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_existe_pto_retail($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPTO'), $f3->get('SESSION.login')));
		}
		
		public function busca_existe_val_tienda($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_existe_val_tienda($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPTO'), $f3->get('SESSION.login')));
		}
		
		public function busca_existe_marca($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::busca_existe_marca($f3->get('SESSION.COD_TEMPORADA'), $f3->get('GET.DEPTO'), $f3->get('SESSION.login')));
		}

// ######################## TRAER FECHA RECEPCION CD y DIAS DE ATRASO ########################
		
		public function trae_fecharcd_y_dias_atraso($f3) {
			echo json_encode(\simulador_compra\cbx_grilla_compra::trae_fecharcd_y_dias_atraso($f3->get('GET.FECHA_ESTA'), $f3->get('GET.FECHA_RECEP_PMM')));
		}
// ######################## FIN TRABAJO CON ACCESO SIMULADOR DE COMPRA SELECCIONA DEPARTAMENTO ########################



// ######################## TRABAJO CON GRILLA EDITABLE ########################

        // Busca Factor
        public function listar_factor($f3) { // $pais,$via,$moneda,$ventana
            echo json_encode(\simulador_compra\cbx_grilla_compra::listar_factor($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.PAIS'), $f3->get('GET.VIA'), $f3->get('GET.MONEDA'), $f3->get('GET.VENTANA')));
        }

        // Busca Factor
        public function listar_tipocambio($f3) { // ,$moneda,$ventana
            echo json_encode(\simulador_compra\cbx_grilla_compra::listar_tipocambio($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('GET.MONEDA'), $f3->get('GET.VENTANA')));
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
                $f3->get('GET.unida_ajust_xtallas'),$f3->get('GET.marca_'),$cluster,$f3->get('GET.debut_'));
}

        // Actualizar grilla en PLC_PLAN_COMPRA_COLOR_CIC
        public function actualiza_grilla_plan_compra_color_cic($f3) {
            echo \simulador_compra\cbx_grilla_compra::actualiza_grilla_plan_compra_color_cic($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.ID_COLOR3'), $f3->get('GET.COSTO'));
        }

        // Listar País
        public function listar_pais($f3) {
            echo json_encode(\simulador_compra\cbx_grilla_compra::listar_pais($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
        }

        // Listar Formatos Grilla Editar
        public function listar_formato_grilla_edita($f3) {
            echo json_encode(\simulador_compra\cbx_grilla_compra::listar_formato_grilla_edita($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
        }

        // Listar Ventana Grilla Editar
        public function listar_ventana_grilla_edita($f3) {
            echo json_encode(\simulador_compra\cbx_grilla_compra::listar_ventana_grilla_edita($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO')));
        }

		// CURVADO CON EDITAR GRILLA

        public function CalculoCurvadoGrilla($f3){

           $dt = \simulador_compra\cbx_grilla_compra::CalculoCurvado($_POST['_tipo_empaque']
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
// ######################## FIN TRABAJO CON GRILLA EDITABLE ########################



// ######################## TRABAJO CON CONCURRENCIA ########################
        // Actualiza la fecha del registro de concurrencia
        public function actualiza_fecha_concurrencia($f3) {
            echo \simulador_compra\cbx_grilla_compra::actualiza_fecha_concurrencia($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'));
        }
// ######################## FIN TRABAJO CON CONCURRENCIA ########################





// ######################## TRABAJO CON NUEVO GUARDADO PI ########################

        public function guarda_proforma_cond1($f3) {
            echo \simulador_compra\cbx_grilla_compra::guarda_proforma_cond1($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'), $f3->get('GET.ID_INSERTAR'), $f3->get('GET.ARCHIVO'));
        }

        public function guarda_proforma_cond2($f3) {
            echo \simulador_compra\cbx_grilla_compra::guarda_proforma_cond2($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'), $f3->get('GET.PROFORMA'), $f3->get('GET.ID_INSERTAR'), $f3->get('GET.ARCHIVO'));
        }

// ######################## FIN TRABAJO CON NUEVO GUARDADO PI ########################




// Termina Clase
	}