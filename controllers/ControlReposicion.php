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

            // Eliminar toda consurrencia del ususario
            \permisos\permiso_usuario::eliminar_toda_concurrencia($f3->get('SESSION.login'));

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
                $distEstilo = \LibraryHelper::convertNumber($row[15]);
                $codMarca = \LibraryHelper::convertNumber($row[20]);
                $sucs = \reposicion\distribucion::detalleContenedoresSucursales($row[10], $row[11], $row[12], $nroEmbarque, $nroContenedor, $row[2],$codMarca, $login);
				$aux = [];
                $totalDist = 0;
                $cantTPlan = 0;
                $tdas_repartidas = 0;
                $tdas_a = \LibraryHelper::convertNumber($row[16]);
                $tdas_b = \LibraryHelper::convertNumber($row[17]);
                $tdas_c = \LibraryHelper::convertNumber($row[18]);
                $tdas_i = \LibraryHelper::convertNumber($row[19]);


				foreach ($sucs as $suc) {
					$codSucursal = \LibraryHelper::convertNumber($suc[0]);
					$sucursal = \LibraryHelper::cleanText($suc[1]);
					$cantidad = \LibraryHelper::convertNumber($suc[2]);
					$fechaDemora = $suc[3];
					$cluster = $suc[4];

                    $cant_a = \LibraryHelper::convertNumber($suc[6]);
                    $cant_b = \LibraryHelper::convertNumber($suc[7]);
                    $cant_c = \LibraryHelper::convertNumber($suc[8]);
                    $cant_i = \LibraryHelper::convertNumber($suc[9]);
                    $cantTPlan = ($cant_a * $tdas_a) + ($cant_b * $tdas_b) + ($cant_c * $tdas_c) + ($cant_i * $tdas_i);
                    $distEstiloTda = \LibraryHelper::convertNumber($suc[10]);

                    $hayDist = \LibraryHelper::convertNumber($suc[11]);

                    $c = 0;
                    $distOld =false;

                    switch  ($cluster){
                        case 'A':
                            $cantPlan = $cant_a;
                            break;
                        case 'B':
                            $cantPlan = $cant_b;
                            break;
                        case 'C':
                            $cantPlan = $cant_c;
                            break;
                        case 'I':
                            $cantPlan = $cant_i;
                            break;
                        default:
                            $cantPlan= '0';
                    }

                    if($hayDist == 1){
                        $c = $cantidad;

                    }else {

                        if ($distEstiloTda < $cantPlan) {

                            if ($cluster != '-' and $cantTPlan > $totalDist and $cantTPlan > $cajasT) {
                            $reparto = $cantidad - $distEstiloTda;
                            $reparto = ceil($reparto);
                                if ($reparto + $totalDist <= $cajasT) {
                                $c = $reparto;
                                } else {
                                $c = $cajasT - $totalDist;
					}
                        } else {
                                if ($cluster != '-' and $cantTPlan > $totalDist and $cajasT >= $cantTPlan) {
                                $reparto = $cantidad - $distEstiloTda;
                                $reparto = ceil($reparto);
                                    if ($reparto + $totalDist <= $cajasT) {
                                    $c = $reparto;
                                    } else {
                                    $c = $cajasT - $totalDist;
                                }
                            }
                        }

                        }

                    }
                        $totalDist += $c;

                        $cajas = $cantTPlan - $totalDist;

                    if ($cantTPlan > $cajasT) {
                            $cajas = $cajasT - $totalDist;
                        }
                        $tdas_repartidas++;

                    if($distEstiloTda != 0 ){
                        $distOld = true;
                    }


					$aux[] = array(
						"codSucursal" => $codSucursal,
						"sucursal" => $sucursal,
						"cantidad" => $c,
						"fechaDemora" => $fechaDemora,
                        "cluster" => $cluster,
                        "cantPlan" => $cantPlan,
                        "cantTotalPlan" => $cantTPlan,
                        "distEstiloTda" => $distEstiloTda,
                        "distOld" => $distOld
					);
				}

                $cantSuc = count($aux);
				$existe = false;
                $puntero = 0;
                for ($i = 0; $i < $cantSuc; $i++) {
                    if ($aux[$i]['cluster'] != "-" and $aux[$i]['cantTotalPlan'] != 0) {
                        $cantTPlan = $aux[$i]['cantTotalPlan'];
                        $puntero = $i;
						$existe = true;
						break;
					}
				}
                if (!$existe and $aux and $aux[$puntero] != null and $aux[$puntero]['cantTotalPlan'] != 0
                    and $aux[$puntero]['distEstiloTda'] > $aux[$puntero]['cantPlan']) {
                    while ($cajas > 0 and $totalDist <= $cajasT) {
                        for ($i = $puntero; $i < $cantSuc; $i++) {
							$aux[$i]['cantidad']++;
							$cajas--;
							if ($cajas == 0) {
								break;
							}
						}
					}
				} else {
                    while ($aux and $aux[$puntero] != null and $aux[$puntero]['cantTotalPlan'] != 0
                        and $cajas > 0 and $totalDist <= $cajasT
                        and $aux[$puntero]['distEstiloTda'] > $aux[$puntero]['cantPlan']) {
                        for ($i = $puntero; $i < $cantSuc; $i++) {
							if ($aux[$i]['cluster'] != "-") {
								$aux[$i]['cantidad']++;
								$cajas--;
								if ($cajas == 0) {
									break;
								}
							}
						}
					}
				}
                if($cajasT > $cantTPlan){
                    $diferencia = $cajasT - $totalDist;
                }else {
                    $diferencia = -$cantTPlan + $totalDist;
                }

				usort($aux, array('ControlReposicion', 'cmp'));

				$detalle[] = array(
					"idFila" => $row[0],
					"departamento" => utf8_encode($row[1]),
					"codEstilo" => $row[2],
					"estilo" => utf8_encode($row[3]),
					"color" => utf8_encode($row[4]),
					"ventana" => utf8_encode($row[5]),
					"evento" => utf8_encode($row[6]),
					"curvaReparto" => $row[7],
					"curvasCaja" => $row[8],
					"cajasEmbarcadas" => $cajasT,
                    "diferencia" => $diferencia,
					"sucursales" => $aux,
					"codTemporada" => $row[10],
					"depDepto" => $row[11],
                    "idColor3" => $row[12],
                    "marca" => $row[13],
                    "clusterPlan" => $row[14],
                    "asignadas" => $totalDist
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
				$habilitar = \reposicion\distribucion::validar_distribucion($nro_embarque, $nro_contenedor);
				if ($habilitar[0] == 1) {
					$data = \reposicion\distribucion::distribuir_lpns($nro_embarque, $nro_contenedor, $login);
					$estado = 1;
					$mensaje = "Distribución aprobada correctamente.";
				} else {
					$estado = 0;
					$mensaje = "Debe guardar la distribución de TODOS los departamentos en el embarque/contenedor antes de aprobar.";
				}
			} catch (Exception $e) {
				$estado = -1;
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
			ini_set('memory_limit', '1024M');
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
				$file_name = "IAS$id_archivo";
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
				file_put_contents("$local_path/$file_name", $cita);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				unset($cita);
				
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
				unset($asn);
				
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
				unset($asn);
				
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
				unset($lpn);
				
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
				unset($lpn);
				
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
				unset($distro);
				
				// Procesa el archivo CANCELACION
				$etapa = "generarArchivoCANCELACION";
				$cancelacion = "";
				$r = 0;
				$file_name = "ICL$id_archivo";
				file_put_contents("$local_path/$file_name", $cancelacion);
				$archivos[] = $file_name;
				$ctr[] = array("file_name" => $file_name, "registros" => $r);
				unset($cancelacion);
				
				// Procesa el archivo CONTROL
				$etapa = "generarArchivoCONTROL";
				$control = "";
				foreach ($ctr as $item) {
					$control .= implode(' ', array_values($item)) . "\n";
				}
				$file_name = "CMX$id_archivo.CTR";
				file_put_contents("$local_path/$file_name", $control);
				$archivos[] = $file_name;
				unset($control);
				
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

        public function excel_distribucion_mercaderia($f3) {

            $nroEmbarqueHidden = $_POST['nroEmbarqueHidden'];

            $distribucion = \reposicion\distribucion::excel_distribucion_mercaderia($nroEmbarqueHidden);


            // Crea el objeto Excel PHP
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle("Distribución de Mercadería");

            $objPHPExcel->getActiveSheet()->SetCellValue("A1", "TEMPORADA");
            $objPHPExcel->getActiveSheet()->SetCellValue("B1", "COD_DEPTO");
            $objPHPExcel->getActiveSheet()->SetCellValue("C1", "DES_DEPTO");
            $objPHPExcel->getActiveSheet()->SetCellValue("D1", "COD_ESTILO");
            $objPHPExcel->getActiveSheet()->SetCellValue("E1", "DES_ESTILO");
            $objPHPExcel->getActiveSheet()->SetCellValue("F1", "DES_COLOR");
            $objPHPExcel->getActiveSheet()->SetCellValue("G1", "VENTANA");
            $objPHPExcel->getActiveSheet()->SetCellValue("H1", "NOM_MARCA");
            $objPHPExcel->getActiveSheet()->SetCellValue("I1", "EVENTO");
            $objPHPExcel->getActiveSheet()->SetCellValue("J1", "NRO_EMBARQUE");
            $objPHPExcel->getActiveSheet()->SetCellValue("K1", "CURVATALLA");
            $objPHPExcel->getActiveSheet()->SetCellValue("L1", "CURVAS_CAJAS");
            $objPHPExcel->getActiveSheet()->SetCellValue("M1", "LPN_NUMBER");
            $objPHPExcel->getActiveSheet()->SetCellValue("N1", "COD_TDA");
            $objPHPExcel->getActiveSheet()->SetCellValue("O1", "TIPO_EMPAQUE");
            $objPHPExcel->getActiveSheet()->SetCellValue("P1", "UNIDADES");


            // Se genera la consulta
            $row = 2;

            foreach ($distribucion as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue("A$row", $item["TEMPORADA"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("B$row", $item["COD_DEPTO"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("C$row", $item["DES_DEPTO"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("D$row", $item["COD_ESTILO"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("E$row", $item["DES_ESTILO"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("F$row", $item["DES_COLOR"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["VENTANA"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("H$row", $item["NOM_MARCA"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("I$row", $item["EVENTO"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("J$row", $item["NRO_EMBARQUE"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("K$row", $item["CURVATALLA"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("L$row", $item["CURVAS_CAJAS"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("M$row", $item["LPN_NUMBER"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("N$row", $item["COD_TDA"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("O$row", $item["TIPO_EMPAQUE"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("P$row", $item["UNIDADES"]);

                // $objPHPExcel->getActiveSheet()->getStyle("B$row:CX$row")->applyFromArray($estiloCelda);
                $row++;
            }
            // Escribe el archivo Excel
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=Distribucion.xlsx");
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save('php://output');



		}

        public function reporteria_distribucion_mercaderia($f3) {
            ControlFormularioMain::cargaMain($f3);
            ControlReposicion::cargaMensajes($f3);
            $f3->set('nombre_form', 'Reporteria Embarques');
            //$f3->set('nroEmbarque', $f3->get('GET.nroEmbarque'));
            //$f3->set('nroContenedor', $f3->get('GET.nroContenedor'));
            $f3->set('contenido', 'reporteriaEmbarques/reporteria_embarques.html');
            echo Template::instance()->render('layout_reporteria_embarques.php');
        }

        public function obtener_embarques_reporteria($f3) {
            $data =\reposicion\distribucion::listaEmbarquesReporteria();
            $json = [];
            foreach ($data as $row) {
                array_push($json
                    , array(
                        "nroEmbarque" => $row[0],
                        "Estado" => $row[2],
                        "fechaETA" => date_format(date_create($row[1]),'Y-m-d')
                    )
                );
            }
            header("Content-Type: application/json");
            echo json_encode($json);
        }

        public function excel_reporte_embarques($f3) {

            $listNroEmbarque = explode(',',strval($_GET['envia_embarque']));

            $i = 0;
            // Crea el objeto Excel PHP
            $objPHPExcel = new PHPExcel();

            foreach($listNroEmbarque as $rowNroEmbarque){

                $distribucion = \reposicion\distribucion::excel_distribucion_mercaderia(intval($rowNroEmbarque));

                if($distribucion) {

                    $sheetTitle = strval($rowNroEmbarque);

                    if($i>0){
                        $objPHPExcel->createSheet($i);
                    }
                    $objPHPExcel->getSheet($i)->setTitle($sheetTitle);

                    $objPHPExcel->getSheet($i)->SetCellValue("A1", "TEMPORADA");
                    $objPHPExcel->getSheet($i)->SetCellValue("B1", "COD_DEPTO");
                    $objPHPExcel->getSheet($i)->SetCellValue("C1", "DES_DEPTO");
                    $objPHPExcel->getSheet($i)->SetCellValue("D1", "COD_ESTILO");
                    $objPHPExcel->getSheet($i)->SetCellValue("E1", "DES_ESTILO");
                    $objPHPExcel->getSheet($i)->SetCellValue("F1", "DES_COLOR");
                    $objPHPExcel->getSheet($i)->SetCellValue("G1", "VENTANA");
                    $objPHPExcel->getSheet($i)->SetCellValue("H1", "NOM_MARCA");
                    $objPHPExcel->getSheet($i)->SetCellValue("I1", "EVENTO");
                    $objPHPExcel->getSheet($i)->SetCellValue("J1", "NRO_EMBARQUE");
                    $objPHPExcel->getSheet($i)->SetCellValue("K1", "CURVATALLA");
                    $objPHPExcel->getSheet($i)->SetCellValue("L1", "CURVAS_CAJAS");
                    $objPHPExcel->getSheet($i)->SetCellValue("M1", "LPN_NUMBER");
                    $objPHPExcel->getSheet($i)->SetCellValue("N1", "COD_TDA");
                    $objPHPExcel->getSheet($i)->SetCellValue("O1", "TIPO_EMPAQUE");
                    $objPHPExcel->getSheet($i)->SetCellValue("P1", "UNIDADES");
                    $objPHPExcel->getSheet($i)->SetCellValue("Q1", "NRO_VARIACION");
                    $objPHPExcel->getSheet($i)->SetCellValue("R1", "NRO_FACTURA");
                    $objPHPExcel->getSheet($i)->SetCellValue("S1", "PI_NUMBER");
                    $objPHPExcel->getSheet($i)->SetCellValue("T1", "PO_NUMBER");
                    $objPHPExcel->getSheet($i)->SetCellValue("U1", "COSTO");
                    $objPHPExcel->getSheet($i)->SetCellValue("V1", "PREFIJO");
                    $objPHPExcel->getSheet($i)->SetCellValue("W1", "FECHA_DEMORA");
                    $objPHPExcel->getSheet($i)->SetCellValue("X1", "NRO_CONTENEDOR");
                    $objPHPExcel->getSheet($i)->SetCellValue("Y1", "NRO_CITA");
                    $objPHPExcel->getSheet($i)->SetCellValue("Z1", "NRO_DISTRO");

                    // Se genera la consulta
                    $row = 2;

                    foreach ($distribucion as $item) {
                        $objPHPExcel->getSheet($i)->SetCellValue("A$row", $item["TEMPORADA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("B$row", $item["COD_DEPTO"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("C$row", $item["DES_DEPTO"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("D$row", $item["COD_ESTILO"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("E$row", $item["DES_ESTILO"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("F$row", $item["DES_COLOR"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("G$row", $item["VENTANA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("H$row", $item["NOM_MARCA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("I$row", $item["EVENTO"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("J$row", $item["NRO_EMBARQUE"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("K$row", $item["CURVATALLA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("L$row", $item["CURVAS_CAJAS"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("M$row", $item["LPN_NUMBER"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("N$row", $item["COD_TDA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("O$row", $item["TIPO_EMPAQUE"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("P$row", $item["UNIDADES"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("Q$row", $item["NRO_VARIACION"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("R$row", $item["NRO_FACTURA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("S$row", $item["PI_NUMBER"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("T$row", $item["PO_NUMBER"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("U$row", $item["COSTO"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("V$row", $item["PREFIJO"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("W$row", $item["FECHA_DEMORA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("X$row", $item["NRO_CONTENEDOR"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("Y$row", $item["NRO_CITA"]);
                        $objPHPExcel->getSheet($i)->SetCellValue("Z$row", $item["NRO_DISTRO"]);
                        // $objPHPExcel->getActiveSheet()->getStyle("B$row:CX$row")->applyFromArray($estiloCelda);
                        $row++;
                    }
                    $i++;
                }
            }
            // Escribe el archivo Excel
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=Distribucion.xlsx");
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save('php://output');

		}

	}