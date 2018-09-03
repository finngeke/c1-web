<?php
	/**
	 * Created by PhpStorm.
	 * User: jcandiah
	 * Date: 13-08-2018
	 * Time: 13:39
	 */
	
	class ControlReposicion extends Control {
		
		public static function cargaMensajes($f3) {
			switch ($f3) {
				case $f3->exists('SESSION.error'):
					$mensaje = $f3->get('SESSION.error');
					$f3->set('mensaje', Control::SetMensajePredeterminado(array(
						'head' => "ERROR",
						'msg' => $mensaje,
						'icon' => "danger",
						'color' => "red"
					)));
					$f3->clear('SESSION.error');
					break;
				case $f3->exists('SESSION.success'):
					$mensaje = $f3->get('SESSION.success');
					$f3->set('mensaje', Control::SetMensajePredeterminado(array(
						'head' => "EXITO",
						'msg' => $mensaje,
						'icon' => "success",
						'color' => "green"
					)));
					$f3->clear('SESSION.success');
					break;
				case $f3->exists('SESSION.warning'):
					$mensaje = $f3->get('SESSION.warning');
					$f3->set('mensaje', Control::SetMensajePredeterminado(array(
						'head' => "ADVERTENCIA",
						'msg' => $mensaje,
						'icon' => "warning",
						'color' => "yelloow"
					)));
					$f3->clear('SESSION.warning');
					break;
				default:
					$f3->clear('SESSION.error');
					$f3->clear('SESSION.success');
			}
		}
		
		public function inicio($f3) {
			ControlFormularioMain::cargaMain($f3);
			ControlReposicion::cargaMensajes($f3);
			$f3->set('nombre_form', 'REPOSICION');
			$f3->set('seleccion_contenedor', 'reposicion/seleccion_contenedor.html');
			$f3->set('contenido', 'reposicion/inicio.html');
			echo Template::instance()->render('layout_reposicion.php');
		}
		
		public function prioridades_tienda($f3) {
			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			ControlReposicion::cargaMensajes($f3);
			$f3->set('nombre_form', 'Mantenedor de prioridades por tienda'); //Parametros por cada formulario
			$f3->set('contenido', 'reposicion/prioridades_tienda.html'); //llamas al formulario html
			echo Template::instance()->render('layout_reposicion.php');
		}
		
		public function obtener_temporadas($f3) {
			$temporadas = \temporada\temporada::getListaTemporadasBuscar($f3->get("GET.q"));
			$results = [];
			foreach ($temporadas as $temporada) {
				$results[] = array("id" => $temporada["COD_TEMPORADA"], "text" => $temporada["NOM_TEMPORADA_CORTO"]);
			}
			header("Content-Type: application/json");
			echo \JsonHelper::encode(array("results" => $results), JSON_PRETTY_PRINT);
		}
		
		public function obtener_departamentos($f3) {
			$departamentos = \jerarquia\departamento::getDepartamentoBuscar($f3->get("GET.q"));
			$results = [];
			foreach ($departamentos as $departamento) {
				$results[] = array("id" => $departamento["DEP_DEPTO"], "text" => $departamento["DESCRIPCION"]);
			}
			header("Content-Type: application/json");
			echo \JsonHelper::encode(array("results" => $results), JSON_PRETTY_PRINT);
		}
		
		public function obtener_sucursales_disponibles($f3) {
			$cod_temporada = $f3->get('GET.cod_temporada');
			$dep_depto = $f3->get('GET.dep_depto');
			$data = \reposicion\distribucion::listaSucursalesDisponibles($cod_temporada, $dep_depto);
			$json = [];
			foreach ($data as $row) {
				$json[] = array(
					"codSucursal" => $row[0],
					"sucursal" => $row[1]
				);
			}
			header("Content-Type: application/json");
			echo json_encode($json);
		}
		
		public function obtener_sucursales_seleccionadas($f3) {
			$cod_temporada = $f3->get('GET.cod_temporada');
			$dep_depto = $f3->get('GET.dep_depto');
			$data = \reposicion\distribucion::listaSucursalesSeleccionadas($cod_temporada, $dep_depto);
			$json = [];
			foreach ($data as $row) {
				$json[] = array(
					"codSucursal" => $row[0],
					"sucursal" => $row[1]
				);
			}
			header("Content-Type: application/json");
			echo json_encode($json);
		}
		
		public function guardar_prioridades_tienda($f3) {
			try {
				$cod_temporada = $f3->get('POST.cod_temporada');
				$dep_depto = $f3->get('POST.dep_depto');
				$sucursales = $f3->get('POST.sucursales');
				$data = \reposicion\distribucion::guardar_prioridades_tienda($cod_temporada, $dep_depto, $sucursales);
				header("Content-Type: application/json");
				echo json_encode(array("success" => true, "message" => $data));
			} catch (Exception $ex) {
				header("Content-Type: application/json");
				echo json_encode(array("success" => false, "message" => $ex->getMessage()));
			}
		}
		
		public function obtener_contenedores($f3) {
			$data = \reposicion\distribucion::listarContenedores($f3->get('SESSION.login'));
			$json = [];
			foreach ($data as $row) {
				$json[] = array(
					"nroEmbarque" => $row[0],
					"nroContenedor" => $row[1],
					"fechaETA" => $row[2]
				);
			}
			header("Content-Type: application/json");
			echo json_encode(array("data" => $json));
		}
		
		public function distribucion_mercaderia($f3) {
			ControlFormularioMain::cargaMain($f3);
			ControlReposicion::cargaMensajes($f3);
			$f3->set('nombre_form', 'Distribución de Mercadería');
			$f3->set('nroEmbarque', $f3->get('GET.nroEmbarque'));
			$f3->set('nroContenedor', $f3->get('GET.nroContenedor'));
			$f3->set('contenido', 'reposicion/distribucion_mercaderia.html');
			echo Template::instance()->render('layout_reposicion.php');
		}
		
		public function cargar_distribucion_mercaderia($f3) {
			$nroEmbarque = $f3->get('GET.nroEmbarque');
			$nroContenedor = $f3->get('GET.nroContenedor');
			$login = $f3->get('SESSION.login');
			$detalle = [];
			$sucursales = [];
			$data = \reposicion\distribucion::listaSucursales();
			foreach ($data as $row) {
				$sucursales[] = array(
					"codSucursal" => $row[0],
					"sucursal" => $row[1]
				);
			}
			$data = \reposicion\distribucion::detalleContenedor($nroEmbarque, $nroContenedor, $login);
			foreach ($data as $row) {
				$cajasT = \LibraryHelper::convertNumber($row[9]);
				$cajas = $cajasT;
				$sucs = \reposicion\distribucion::detalleContenedoresSucursales($row[10], $row[11], $row[12], $nroEmbarque, $nroContenedor, $row[2], $login);
				$aux = [];
				foreach ($sucs as $suc) {
					$cantidad = (\LibraryHelper::convertNumber($suc[4]) > 0) ? \LibraryHelper::convertNumber($suc[4]) : \LibraryHelper::convertNumber($suc[3]);
					$c = $cantidad;
					if ($c > $cajas) {
						$c = $cajas;
					}
					$cajas -= $c;
					$aux[] = array(
						"codSucursal" => $suc[0],
						"sucursal" => utf8_encode($suc[1]),
						"habilitada" => \LibraryHelper::convertNumber($suc[2]),
						"cantidad" => $c,
						"fechaDemora" => $suc[5],
						"cluster" => $suc[7]
					);
				}
				usort($aux, array('ControlReposicion', 'cmp'));
				$detalle[] = array(
					"idFila" => $row[0],
					"departamento" => $row[1],
					"codEstilo" => $row[2],
					"estilo" => $row[3],
					"color" => $row[4],
					"ventana" => $row[5],
					"evento" => $row[6],
					"curvaReparto" => $row[7],
					"curvasCaja" => $row[8],
					"cajasEmbarcadas" => $cajasT,
					"diferencia" => $cajas,
					"sucursales" => $aux,
					"codTemporada" => $row[10],
					"depDepto" => $row[11],
					"idColor3" => $row[12]
				);
			}
			header("Content-Type: application/json");
			$json = \JsonHelper::encode(array("sucursales" => $sucursales, "detalle" => $detalle), JSON_PRETTY_PRINT);
			echo $json;
		}
		
		public function guardar_distribucion_tienda($f3) {
			header("Content-Type: application/json");
			try {
				$nro_embarque = $f3->get('POST.nroEmbarque');
				$nro_contenedor = $f3->get('POST.nroContenedor');
				$sucursales = $f3->get('POST.sucursales');
				$data = \reposicion\distribucion::guardar_distribucion_tienda($nro_embarque, $nro_contenedor, $sucursales);
				echo json_encode(array("estado" => 0, "mensaje" => "Datos guardados correctamente"));
			} catch (Exception $ex) {
				echo json_encode(array("estado" => 1, "mensaje" => $ex->getMessage()));
			}
		}
		
		public function aprobar_distribucion_tienda($f3) {
			$estado = false;
			$mensaje = "";
			$etapa = "aprobarDistribucion";
			try {
				// Guarda los datos de sesión
				$etapa = "obtieneParametros";
				$nro_embarque = $f3->get("POST.nro_embarque");
				$nro_contenedor = $f3->get("POST.nro_contenedor");
				$login = $f3->get("SESSION.login");
				// Valida que que haya guardado previamente la distribución
				$etapa = "detalleDistribucionSucursales";
				$sucursales = \reposicion\distribucion::detalle_distribucion_sucursales($nro_embarque, $nro_contenedor, $login);
				if ($sucursales) {
					foreach ($sucursales as $sucursal) {
						$cod_temporada = $sucursal[0];
						$dep_depto = $sucursal[1];
						$id_color3 = $sucursal[2];
						$nro_estilo = $sucursal[5];
						$cod_tda = $sucursal[6];
						$cantidad = $sucursal[7];
						$fecha_demora = $sucursal[8];
						$etapa = "obtenerLPNSDistribucion_$cod_tda";
						$lpns = \reposicion\distribucion::obtener_lpns_distribucion($cod_temporada, $dep_depto, $id_color3, $nro_embarque, $nro_contenedor, $nro_estilo);
						if ($lpns) {
							for ($i = 0; $i < $cantidad; $i++) {
								$lpn_number = $lpns[$i][2];
								$data = \reposicion\distribucion::actualizar_lpns_distribucion($cod_temporada, $dep_depto, $id_color3, $nro_embarque, $nro_contenedor, $lpn_number, $cod_tda, $fecha_demora);
							}
						}
					}
					$estado = 1;
					$mensaje = "Distribución aprobada correctamente.";
				} else {
					$estado = 0;
					$mensaje = "Debe guardar la distribución antes de aprobarla.";
				}
			} catch (Exception $e) {
				$estado = false;
				$mensaje = $e->getMessage();
			}
			header("Content-Type: application/json");
			echo json_encode(array("estado" => $estado, "mensaje" => $mensaje, "etapa" => $etapa));
		}
		
		public function bajada_embarque($f3) {
			ControlFormularioMain::cargaMain($f3); //variable de perfilamiento.
			$data = \reposicion\embarque::listar_bajada_embarque();
			$f3->set('data', $data);
			$f3->set('nombre_form', 'Bajada de Embarque'); //Parametros por cada formulario
			$f3->set('contenido', 'reposicion/bajada_embarque.html'); //llamas al formulario html
			echo Template::instance()->render('layout_reposicion.php');
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
				$data = \reposicion\embarque::generar_asn($nro_embarque, $id_archivo);
				
				// APERTURA DE SESIÓN
				$etapa = "aperturaSesion";
				$asns = \reposicion\embarque::obtener_cabecera_asn_sesion($nro_embarque);
				foreach ($asns as $asn) {
					$etapa = "detalleASNSesion";
					$asn_number = $asn[0];
					$data = \reposicion\embarque::obtener_detalle_asn_sesion($nro_embarque, $asn_number);
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
						echo json_encode(array("estado" => -2, "mensaje" => "No se pudo aperturar la sesión: $msj\n\nPor favor intente nuevamente. Si el error persiste, informe al administrador de sistema."), JSON_PRETTY_PRINT);
						exit();
					} else {
						$id_sesion = $response->Body->sessionid;
						\reposicion\embarque::guardar_sesion_asn($nro_embarque, $asn[0], $id_sesion);
					}
				}
				
				// Procesa el archivo de CITAS
				$etapa = "generarArchivoCITA";
				$data = \reposicion\embarque::generar_archivo_cita($nro_embarque, $id_archivo);
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
				$data = \reposicion\embarque::generar_archivo_asn_hdr($nro_embarque, $host_inpt_id);
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
				$data = \reposicion\embarque::generar_archivo_asn_dtl($nro_embarque, $host_inpt_id);
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
				$data = \reposicion\embarque::generar_archivo_lpn_hdr($nro_embarque, $host_inpt_id);
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
				$data = \reposicion\embarque::generar_archivo_lpn_dtl($nro_embarque, $host_inpt_id);
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
				$data = \reposicion\embarque::generar_archivo_distro($nro_embarque, $host_inpt_id);
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
				$file_name = "CMX$id_archivo.CTR";
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
				$data = \reposicion\embarque::archivar_asn($nro_embarque);
				
				header("Content-Type: application/json");
				echo json_encode(array("estado" => 0, "mensaje" => "Archivo cargado", "etapa" => $etapa), JSON_PRETTY_PRINT);
			} catch (Exception $e) {
				header("Content-Type: application/json");
				echo json_encode(array("estado" => $e->getCode(), "mensaje" => $e->getMessage(), "etapa" => $etapa), JSON_PRETTY_PRINT);
			}
		}
		
		private function cmp($a, $b) {
			if ($a['codSucursal'] == $b['codSucursal']) {
				return 0;
			}
			return ($a['codSucursal'] < $b['codSucursal']) ? -1 : 1;
		}
		
		public function beforeRoute($f3) {
			if ($f3->exists('SESSION.login') == false) {
				$f3->reroute('/fin-sesion');
			}
		}
	}