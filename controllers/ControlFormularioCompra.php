<?php
	
	/**
	 * CONTROLADOR de SIMULADOR DE COMPRA
	 * Descripción:
	 * Fecha: 2018-02-15
	 * @author RODRIGO RIOSECO
	 * @edita EDUARDO PACHECO
	 * @edita ROBERTO PÉREZ (02-10-2018)
	 */
	class ControlFormularioCompra extends Control {
		
		public function inicio($f3) {

            // Eliminar toda consurrencia del ususario (Luego de seleccionar una temporada)
            //\permisos\permiso_usuario::eliminar_toda_concurrencia($f3->get('SESSION.login'));

            unset($_SESSION['session_depto_validar_url']);

			ControlFormularioMain::cargaMain($f3);
			$f3->set('temporadas', temporada\temporada::getSelect());
			$temporada = temporada\temporada::getTemporadaCompra($f3->get('GET.codigo'));
			$f3->set('SESSION.COD_TEMPORADA', $f3->get('GET.codigo'));
			$f3->set('NOM_TEMPORADA', $temporada->NOM_TEMPORADA);
			$f3->set('NOM_TEMPORADA_CORTO', $temporada->NOM_TEMPORADA_CORTO);
			$f3->set('COD_TEMPORADA', $f3->get('GET.codigo'));
			$f3->set('COD_EST_TEMP', $temporada->COD_EST_TEMP);
			$f3->set('USR_CRE', $temporada->USR_CRE);
			$f3->set('contenido', 'formulario/plan_compra/inicio.html');
			$f3->set('seleccion_contenedor', 'formulario/plan_compra/seleccion_contenedor.html');
			$f3->set('tipo_deptomarca', 'formulario/plan_compra/mantenedor/popup_deptomarca.html');
			echo Template::instance()->render('layout_simulador.php');
			
		}
		
		public function simulador_compra($f3) {

            $depto_entrar = substr($_SERVER['REQUEST_URI'],-4);

            if (isset( $_SESSION['session_depto_validar_url'])){
                //si tiene algo
                //segunda validacion si el dpto entrar es igual a la session
                if ($depto_entrar != $_SESSION['session_depto_validar_url']) {
                    //matar sesion depto
                    unset($_SESSION['session_depto_validar_url']);
                    //redireccionar
                    header("Location: salir");
                    //pausar codigo
                    die();
                }

            }else{
                $_SESSION['session_depto_validar_url'] = substr($_SERVER['REQUEST_URI'],-4);
            }

			ControlFormularioMain::cargaMain($f3);
			//ControlFormularioMain::cargaMensaje($f3);
			$f3->set('temporadas', temporada\temporada::getSelect());
			$f3->set('nombre_form', 'SIMULADOR DE COMPRA');
			$f3->set('depto_form', $f3->get('SESSION.COD_TEMPORADA') . ' - ' . $f3->get('GET.depto'));
			$f3->set('SESSION.COD_DEPTO', $f3->get('GET.depto'));
			$f3->set('COD_DEPTO_ACTUAL', $f3->get('GET.depto'));

			$temporada = temporada\temporada::getTemporadaCompra($f3->get('SESSION.COD_TEMPORADA'));

			$f3->set('NOM_TEMPORADA', $temporada->NOM_TEMPORADA);
			$f3->set('NOM_TEMPORADA_CORTO', $temporada->NOM_TEMPORADA_CORTO);
			$f3->set('SESSION.NOM_TEMPORADA_CORTO', $temporada->NOM_TEMPORADA_CORTO);
			$f3->set('COD_TEMPORADA', $f3->get('SESSION.COD_TEMPORADA'));
			$f3->set('COD_EST_TEMP', $temporada->COD_EST_TEMP);
			$f3->set('USR_CRE', $temporada->USR_CRE);

            $f3->set('contenido', 'formulario/plan_compra/simulador_compra.html');
            echo Template::instance()->render('layout_plan_compra.php');

		}
		
		public function selecciona_depto($f3) {

            // Eliminar toda consurrencia del ususario (BTN Registro de Compra)
            //\permisos\permiso_usuario::eliminar_toda_concurrencia($f3->get('SESSION.login'));

            unset($_SESSION['session_depto_validar_url']);
			ControlFormularioMain::cargaMain($f3);
			
			$f3->set('nombre_form', 'SIMULADOR DE COMPRA');
			
			$temporada = temporada\temporada::getTemporadaCompra($f3->get('SESSION.COD_TEMPORADA'));
			
			$f3->set('NOM_TEMPORADA', $temporada->NOM_TEMPORADA);
			$f3->set('NOM_TEMPORADA_CORTO', $temporada->NOM_TEMPORADA_CORTO);
			$f3->set('COD_TEMPORADA', $f3->get('SESSION.COD_TEMPORADA'));
			$f3->set('COD_EST_TEMP', $temporada->COD_EST_TEMP);
			$f3->set('USR_CRE', $temporada->USR_CRE);
			
			$f3->set('Lista_deptos', temporada\temporada::obtieneDepartamentoSimulador($f3->get('SESSION.login'), $f3->get('SESSION.COD_TEMPORADA')));
			
			// se agrega producto de la validación de presupuestos y tiendas antes de ingresar al simulador de compra
			//ControlFormularioMantenedores::tipo_tienda($f3);
			ControlFormularioMantenedores::tipo_ventana_llegada($f3);
			ControlFormularioMantenedores::tipo_ppto_costo($f3);
			ControlFormularioMantenedores::tipo_ppto_retail($f3);
			
			$f3->set('tipo_tienda', 'formulario/plan_compra/mantenedor/popup_tipo_tienda.html');
			$f3->set('departamento', 'formulario/plan_compra/depto.html');
			$f3->set('contenido', 'formulario/plan_compra/seleccion_depto.html');
			echo Template::instance()->render('layout_simulador.php');
		}
		
		public function curva_reparto($f3) {

            // Eliminar toda consurrencia del ususario
            //\permisos\permiso_usuario::eliminar_toda_concurrencia($f3->get('SESSION.login'));

			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			$f3->set('nombre_form', 'CURVA DE REPARTO'); //Parametros por cada formulario
			$f3->set('depto_form', 'D125'); //Parametros por cada formulario
			$f3->set('contenido', 'formulario/plan_compra/mantenedor/curva_reparto.html'); //llamas al formulario html
			echo Template::instance()->render('layout_simulador.php');
		}
		
		public function factor_estimado($f3) {

            // Eliminar toda consurrencia del ususario
            //\permisos\permiso_usuario::eliminar_toda_concurrencia($f3->get('SESSION.login'));

			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			ControlFormularioMain::cargaMensaje($f3);
			$f3->set('nombre_form', 'Factor Estimado'); //Parametros por cada formulario
			$f3->set('depto_form', ''); //Parametros por cada formulario
			//Combox depto
			$departamento = \jerarquia\departamento::getdepartament();
			$select = new html\select($departamento, 'DEP_DEPTO', 'DEP_DESCRIPCION');
			$f3->set('departamento', $select);
			//combox pais
			$pais = \temporada\parametros::getPaises();
			$select = new html\select($pais, 'COD_PAIS', 'NOM_PAIS');
			$f3->set('parametros', $select);
			//combox via
			$via = \temporada\parametros::getVia();
			$select = new html\select($via, 'COD_VIA', 'NOM_VIA');
			$f3->set('via', $select);
			//combox tipo moneda
			$via = \temporada\parametros::getTipoMoneda();
			$select = new html\select($via, 'COD_TIP_MON', 'NOM_TIP_MON');
			$f3->set('tipo_moneda', $select);
			//combox tempo replicar
			$tempo = \temporada\temporada::getListaTemporadas();
			$select = new html\select($tempo, 'COD_TEMPORADA', 'NOM_TEMPORADA_CORTO');
			$f3->set('lis_tempo', $select);
			//Listar Grilla
			$f3->set('Lista_FactorEstimado', \temporada\Factor_Estimado::getFactor_Estimado($f3->get('SESSION.COD_TEMPORADA')));
			$f3->set('Lista_TipoCambio', \temporada\Factor_Estimado::getTipo_Cambio($f3->get('SESSION.COD_TEMPORADA')));
			$f3->set('Lista_FactorEst', '');
			$f3->set('tipo_deptomarca', 'formulario/plan_compra/mantenedor/popup_deptomarca.html');
			$f3->set('contenido', 'formulario/plan_compra/factor_estimado.html'); //llamas al formulario html
			echo Template::instance()->render('layout_simulador.php');
		}
		
		public function fecha_recepcion($f3) {

            // Eliminar toda consurrencia del ususario
            //\permisos\permiso_usuario::eliminar_toda_concurrencia($f3->get('SESSION.login'));

			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			$f3->set('nombre_form', 'Fecha de Recepción'); //Parametros por cada formulario
			$f3->set('depto_form', '-'); //Parametros por cada formulario
			
			$f3->set('Lista_fechasrecep', \temporada\fecha_recepcion::getListafecharecepcion($f3->get('SESSION.COD_TEMPORADA')));
			$f3->set('tipo_deptomarca', 'formulario/plan_compra/mantenedor/popup_deptomarca.html');
			$f3->set('contenido', 'formulario/plan_compra/fecha_recepcion.html'); //llamas al formulario html
			echo Template::instance()->render('layout_simulador.php');
		}

		public function Factor_Importacion($f3){
            ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
            $f3->set('nombre_form', 'Factor Importación'); //Parametros por cada formulario
            $f3->set('depto_form', ''); //Parametros por cada formulario

            //$f3->set('Lista_fechasrecep', \temporada\fecha_recepcion::getListafecharecepcion($f3->get('SESSION.COD_TEMPORADA')));
            //$f3->set('tipo_deptomarca', 'formulario/plan_compra/mantenedor/popup_deptomarca.html');
            $f3->set('contenido', 'formulario/main/Factor_Importacion.html'); //llamas al formulario html
            echo Template::instance()->render('layout_Factor_Importacion.php');
        }

		public function distribucion_mercaderia($f3) {
			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			$detalle = [];
			$codTemporada = $f3->get('SESSION.COD_TEMPORADA');
			$poNumber = $f3->get('GET.poNumber');
			$f3->set('SESSION.PO_NUMBER', $poNumber);
			$nroContenedor = $f3->get('GET.nroContenedor');
			$f3->set('SESSION.NRO_CONTENEDOR', $nroContenedor);
			$login = $f3->get('SESSION.login');
			$data = \simulador_compra\distribucion_mercaderia::listaSucursales();
			foreach ($data as $row) {
				$detalleSucursales[] = array(
					"codSucursal" => $row[0],
					"sucursal" => $row[1]
				);
			}
			$f3->set('sucursales', $detalleSucursales);
			$data = \simulador_compra\distribucion_mercaderia::detalleContenedor($codTemporada, $poNumber, $nroContenedor, $login);
			foreach ($data as $row) {
				$sucursales = [];
				foreach ($detalleSucursales as $sucursal) {
					$habilitada = \simulador_compra\distribucion_mercaderia::detalleContenedoresSucursales($codTemporada, $poNumber, $nroContenedor, $row[3], $login, $sucursal["codSucursal"], $row[12]);
					$cantidad = ($habilitada[0][4] > 0) ? $habilitada[0][4] : $habilitada[0][3];
					$sucursales[] = array(
						"codSucursal" => $sucursal['codSucursal'],
						"sucursal" => $sucursal['sucursal'],
						"habilitada" => $habilitada[0][2],
						"cantidad" => $cantidad,
						"fechaDemora" => $habilitada[0][5]
					);
				}
				
				$prioridad = \simulador_compra\distribucion_mercaderia::listaSucursalesPrioridad($row[1], $row[10]);
				$cajasT = $row[11];
				$cajas = $cajasT;
				foreach ($prioridad as $p) {
					for ($i = 0; $i < count($sucursales); $i++) {
						if ($sucursales[$i]['codSucursal'] == $p[0] && $sucursales[$i]['habilitada'] == "1") {
							//echo $p[0] . ": ". $cajas . "<br>";
							//TODO: Rescatar la información de las cajas si ya se guardó previamente la distribución
							$c = $sucursales[$i]['cantidad'];
							if ($c > $cajas) {
								$c = $cajas;
							}
							$sucursales[$i]['cantidad'] = $c;
							$cajas -= $c;
							break;
						}
					}
				}
				$detalle[] = array(
					"idFila" => $row[0],
					"codTemporada" => $row[1],
					"temporada" => $row[2],
					"codDepto" => $row[10],
					"codEstilo" => $row[3],
					"estilo" => $row[4],
					"color" => $row[5],
					"ventana" => $row[6],
					"evento" => $row[7],
					"curvaReparto" => $row[8],
					"curvasCajas" => $row[9],
					"cajasEmbarcadas" => $cajasT,
					"diferencia" => $cajas,
					"sucursales" => $sucursales,
					"idColor3" => $row[12]
				);
			}
			$f3->set('detalle', $detalle);
			$f3->set('nombre_form', 'Distribución de Mercadería'); //Parametros por cada formulario
			$f3->set('contenido', 'formulario/plan_compra/distribucion_mercaderia.html'); //llamas al formulario html
			echo Template::instance()->render('layout_simulador.php');
		}
		
		public function prioridades_tienda($f3) {
			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			$departamento = \jerarquia\departamento::getdepartamentSorted();
			array_unshift($departamento, array(
				"DEP_DEPTO" => "",
				"0" => "",
				"DEP_DESCRIPCION" => "Seleccione un departamento",
				"1" => "Seleccione un departamento"
			));
			$select = new html\select($departamento, 'DEP_DEPTO', 'DEP_DESCRIPCION');
			$f3->set('departamento', $select);
			$f3->set('nombre_form', 'Mantenedor de prioridades por tienda'); //Parametros por cada formulario
			$f3->set('contenido', 'formulario/plan_compra/prioridades_tienda.html'); //llamas al formulario html
			echo Template::instance()->render('layout_simulador.php');
		}
		
		public function bajada_embarque($f3) {
			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			$codTemporada = $f3->get('SESSION.COD_TEMPORADA');
			$data = \simulador_compra\distribucion_mercaderia::listar_bajada_embarque($codTemporada);
			$f3->set('data', $data);
			$f3->set('nombre_form', 'Bajada de Embarque'); //Parametros por cada formulario
			$f3->set('contenido', 'formulario/plan_compra/bajada_embarque.html'); //llamas al formulario html
			echo Template::instance()->render('layout_simulador.php');
		}
		
		public function generar_archivos($f3) {
			$etapa = "generarArchivos";
			try {
				$archivos = [];
				$ctr = [];
				$local_path = "../archivos/bajada_embarque";
				$remote_path = "/Odbms/sdi/itfwms2006/asn_imp_c1/datos";
				$host = $f3->get('FTP_HOST');
				$port = $f3->get('FTP_PORT');
				$timeout = $f3->get('FTP_TIMEOUT');
				$user = $f3->get('FTP_USER');
				$pass = $f3->get('FTP_PASSWORD');
				
				$date = new DateTime("now", new DateTimeZone("America/Santiago"));
				$host_inpt_id = $date->format('ymdHi');
				$id_archivo = str_pad($date->format('YmdHis'), 17, "0", STR_PAD_LEFT);
				$nro_embarque = $f3->get('GET.nro_embarque');
				
				// Crear el detalle de ASN
				$etapa = "generarASN";
				$data = \simulador_compra\distribucion_mercaderia::generar_asn($nro_embarque, $id_archivo);
				
				// APERTURA DE SESIÓN
				$etapa = "aperturaSesion";
				$asns = \simulador_compra\distribucion_mercaderia::obtener_cabecera_asn_sesion($nro_embarque);
				foreach ($asns as $asn) {
					$etapa = "detalleASNSesion";
					$asn_number = $asn[0];
					$data = \simulador_compra\distribucion_mercaderia::obtener_detalle_asn_sesion($nro_embarque, $asn_number);
					$detalleSesionRecibo = [];
					foreach ($data as $item) {
						$v_sucursal = $item[0];
						$v_numeroFactura = $item[1];
						$v_asn = $item[2];
						$v_numeroEmbarque = $item[3];
						$v_numeroOC = $item[4];
						$v_sku = $item[5];
						$v_contenedor = $item[6];
						$v_costo = \LibraryHelper::convertNumber($item[7]);
						$v_cantidadRecibir = \LibraryHelper::convertNumber($item[8]);
						$detalleSesionRecibo[] = array(
							"sucursal" => "$v_sucursal",
							"numeroFactura" => "$v_numeroFactura",
							"ASN" => "$v_asn",
							"numeroEmbarque" => "$v_numeroEmbarque",
							"numeroOC" => "$v_numeroOC",
							"SKU" => "$v_sku",
							"contenedor" => "$v_contenedor",
							"cantidadRecibir" => "$v_cantidadRecibir",
							"costo" => "$v_costo"
						);
					}
					$json = json_encode($detalleSesionRecibo, JSON_PRETTY_PRINT);
					$json = "{\n\t\"HeaderRply\": {\n\t\t\"servicio\": {\n\t\t\t\"nombreServicio\": \"string\",\n\t\t\t\"operacion\": \"string\",\n\t\t\t\"idTransaccion\": \"string\",\n\t\t\t\"tipoMensaje\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\",\n\t\t\t\"usuario\": \"string\",\n\t\t\t\"dominioPais\": \"string\",\n\t\t\t\"ipOrigen\": \"string\",\n\t\t\t\"servidor\": \"string\",\n\t\t\t\"timeStamp\": \"string\"\n\t\t},\n\t\t\"paginacion\": {\n\t\t\t\"numPagina\": \"string\",\n\t\t\t\"cantidadregisros\": \"string\",\n\t\t\t\"totalRegistros\": \"string\"\n\t\t},\n\t\t\"track\": {\n\t\t\t\"idTrack\": \"string\",\n\t\t\t\"codSistema\": \"string\",\n\t\t\t\"codAplicacion\": \"string\",\n\t\t\t\"componente\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"dataLogger\": \"string\",\n\t\t\t\"flagTracking\": \"string\",\n\t\t\t\"flagLog\": \"string\"\n\t\t},\n\t\t\"error\": [\n\t\t\t{\n\t\t\t\t\"errorCode\": \"string\",\n\t\t\t\t\"errorGlosa\": \"string\"\n\t\t\t}\n\t\t],\n\t\t\"reproceso\": {\n\t\t\t\"countReproceso\": \"string\",\n\t\t\t\"intervaloReintento\": \"string\",\n\t\t\t\"objetoReproceso\": \"string\"\n\t\t},\n\t\t\"filler\": \"string\"\n\t},\n\t\"Body\": {\n\t\t\"headerServicio\": {\n\t\t\t\"version\": \"string\",\n\t\t\t\"nombre\": \"string\",\n\t\t\t\"estado\": \"string\",\n\t\t\t\"fecha\": \"string\",\n\t\t\t\"hora\": \"string\",\n\t\t\t\"nroTransaccion\": \"string\",\n\t\t\t\"sucursal\": \"10095\",\n\t\t\t\"terminal\": \"string\",\n\t\t\t\"tipoTransaccion\": \"string\"\n\t\t},\n\t\t\"detalleSesionRecibo\": $json\n\t}\n}";
					
					$curlopt_url = $f3->get('CURLOPT_URL') . "/aperturasesionreciborst/v1/aperturaSesionRecibo";
					$curlopt_port = $f3->get('CURLOPT_PORT');
					
					$filename = "aperturaSesionReciboRequest" . $nro_embarque . "_COM" . str_pad($asn_number, 6, "0", STR_PAD_LEFT) . ".json";
					file_put_contents("../archivos/json/$filename", $json);
					
					$etapa = "abrirSesion";
					$response = \broker::post($json, $curlopt_url, $curlopt_port);
					
					if (strtoupper($response->Body->fault->faultString) != "OK") {
						$msj = $response->Body->fault->faultString;
						header("Content-Type: application/json");
						echo json_encode(array("estado" => -2, "mensaje" => "No se pudo aperturar la sesión: $msj"), JSON_PRETTY_PRINT);
						exit();
					} else {
						$id_sesion = $response->Body->sessionid;
						\simulador_compra\distribucion_mercaderia::guardar_sesion_asn($nro_embarque, $asn[0], $id_sesion);
					}
				}
				
				// Procesa el archivo de CITAS
				$etapa = "generarArchivoCITA";
				$data = \simulador_compra\distribucion_mercaderia::generar_archivo_cita($nro_embarque, $id_archivo);
				$id_archivo = $data[0][16];
				$cita = "";
				$r = 0;
				foreach ($data as $item) {
					$aux = [];
					for ($i = 0; $i < count($item) - 1; $i++) {
						$aux[] = $item[$i];
					}
					$cita .= implode('|', array_values($aux)) . "\n";
					$r++;
				}
				$file_name = "IAS$id_archivo";
				file_put_contents("$local_path/$file_name", $cita);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				
				// Procesa el archivo ASN_HDR
				$etapa = "generarArchivoASN_HDR";
				$data = \simulador_compra\distribucion_mercaderia::generar_archivo_asn_hdr($nro_embarque, $host_inpt_id);
				$asn = "";
				$r = 0;
				foreach ($data as $item) {
					$asn .= implode('|', array_values($item)) . "\n";
					$r++;
				}
				$file_name = "IAH$id_archivo";
				file_put_contents("$local_path/$file_name", $asn);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				
				// Procesa el archivo ASN_DTL
				$etapa = "generarArchivoASN_DTL";
				$data = \simulador_compra\distribucion_mercaderia::generar_archivo_asn_dtl($nro_embarque, $host_inpt_id);
				$asn = "";
				$r = 0;
				foreach ($data as $item) {
					$asn .= implode('|', array_values($item)) . "\n";
					$r++;
				}
				$file_name = "IAD$id_archivo";
				file_put_contents("$local_path/$file_name", $asn);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				
				// Procesa el archivo LPN_HDR
				$etapa = "generarArchivoLPN_HDR";
				$data = \simulador_compra\distribucion_mercaderia::generar_archivo_lpn_hdr($nro_embarque, $host_inpt_id);
				$lpn = "";
				$r = 0;
				foreach ($data as $item) {
					$lpn .= implode('|', array_values($item)) . "\n";
					$r++;
				}
				$file_name = "ICH$id_archivo";
				file_put_contents("$local_path/$file_name", $lpn);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				
				// Procesa el archivo LPN_DTL
				$etapa = "generarArchivoLPN_DTL";
				$data = \simulador_compra\distribucion_mercaderia::generar_archivo_lpn_dtl($nro_embarque, $host_inpt_id);
				$lpn = "";
				$r = 0;
				foreach ($data as $item) {
					$lpn .= implode('|', array_values($item)) . "\n";
					$r++;
				}
				$file_name = "ICD$id_archivo";
				file_put_contents("$local_path/$file_name", $lpn);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				
				// Procesa el archivo DISTRO
				$etapa = "generarArchivoDISTRO";
				$data = \simulador_compra\distribucion_mercaderia::generar_archivo_distro($nro_embarque, $host_inpt_id);
				$distro = "";
				$r = 0;
				foreach ($data as $item) {
					$distro .= implode('|', array_values($item)) . "\n";
					$r++;
				}
				$file_name = "ISD$id_archivo";
				file_put_contents("$local_path/$file_name", $distro);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				
				// Procesa el archivo CANCELACION
				$etapa = "generarArchivoCANCELACION";
				$cancelacion = "";
				$r = 0;
				$file_name = "ICL$id_archivo";
				file_put_contents("$local_path/$file_name", $cancelacion);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				
				// Procesa el archivo CONTROL
				$etapa = "generarArchivoCONTROL";
				$control = "";
				foreach ($ctr as $item) {
					$control .= implode(' ', array_values($item)) . "\n";
				}
				$file_name = "CMX$id_archivo . CTR";
				file_put_contents("$local_path/$file_name", $control);
				$archivos[] = $file_name;
				
				$etapa = "conectarFTP";
				$ftp = ftp_connect($host, $port, $timeout);
				$login = ftp_login($ftp, $user, $pass);
				ftp_pasv($ftp, true);
				if ((!$ftp) || (!$login)) {
					header("Content-Type: application/json");
					echo json_encode(array("estado" => -1, "mensaje" => "Error de conexión con el FTP"), JSON_PRETTY_PRINT);
					exit();
				} else {
					$etapa = "enviarArchivos";
					foreach ($archivos as $archivo) {
						$remote_file = "$remote_path/$archivo";
						$source_file = "$local_path/$archivo";
						if (!ftp_put($ftp, $remote_file, $source_file, FTP_BINARY)) {
							ftp_close($ftp);
							header("Content-Type: application/json");
							echo json_encode(array("estado" => -2, "mensaje" => "No se pudo procesar el archivo de cita"), JSON_PRETTY_PRINT);
							exit();
						}
					}
				}
				ftp_close($ftp);
				
				//TODO: Actualiza el embarque
				$etapa = "archivarASN";
				$data = \simulador_compra\distribucion_mercaderia::archivar_asn($nro_embarque);
				
				header("Content-Type: application/json");
				echo json_encode(array("estado" => 0, "mensaje" => "Archivo cargado", "etapa" => $etapa), JSON_PRETTY_PRINT);
			} catch (Exception $e) {
				header("Content-Type: application/json");
				echo json_encode(array("estado" => $e->getCode(), "mensaje" => $e->getMessage(), "etapa" => $etapa), JSON_PRETTY_PRINT);
			}
		}
		
		public function beforeRoute($f3) {
			if ($f3->exists('SESSION.login') == false) {
				$f3->reroute('/fin-sesion');
			}
		}
		
		
	}
