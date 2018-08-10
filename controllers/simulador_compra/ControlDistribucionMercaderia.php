<?php
	
	namespace simulador_compra;
	class ControlDistribucionMercaderia extends \Control {
		
		public function obtener_contenedores($f3) {
			$data = \simulador_compra\distribucion_mercaderia::listarContenedores($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.login'));
			$json = [];
			foreach ($data as $row) {
				$json[] = array(
					"nroOC" => $row[0],
					"nroContenedor" => $row[1],
					"nroEmbarque" => $row[2],
					"fechaETA" => $row[3]
				);
			}
			header("Content-Type: application/json");
			echo json_encode(array("data" => $json));
		}
		
		public function obtener_detalle_contenedor($f3) {
			$temporada = $f3->get("GET.temporada");
			$po_number = $f3->get("GET.po_number");
			$nro_contenedor = $f3->get("GET.nro_contenedor");
			$login = $f3->get("GET.login");
			$detalle = \simulador_compra\distribucion_mercaderia::detalleContenedor($temporada, $po_number, $nro_contenedor, $login);
			//$sucursales
			$json = [];
			foreach ($detalle as $row) {
				$json[] = array(
					"fila" => $row[0],
					"codTemporada" => $row[1],
					"temporada" => $row[2],
					"codEstilo" => $row[3],
					"estilo" => $row[4],
					"color" => $row[5],
					"ventana" => $row[6],
					"evento" => $row[7],
					"curvaReparto" => $row[8],
					"curvasCaja" => $row[9]
				);
			}
			header("Content-Type: application/json");
			//echo json_encode(array("data" => $json));
			echo json_encode($json);
		}
		
		public function obtener_sucursales_disponibles($f3) {
			$cod_temporada = $f3->get('GET.cod_temporada');
			$dep_depto = $f3->get('GET.dep_depto');
			$data = \simulador_compra\distribucion_mercaderia::listaSucursalesDisponibles($cod_temporada, $dep_depto);
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
			$data = \simulador_compra\distribucion_mercaderia::listaSucursalesSeleccionadas($cod_temporada, $dep_depto);
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
			$cod_temporada = $f3->get('POST.cod_temporada');
			$dep_depto = $f3->get('POST.dep_depto');
			$sucursales = $f3->get('POST.sucursales');
			$data = \simulador_compra\distribucion_mercaderia::guardar_prioridades_tienda($cod_temporada, $dep_depto, $sucursales);
			header("Content-Type: application/json");
			echo json_encode($data);
		}
		
		public function guardar_distribucion_tienda($f3) {
			$sucursales = $f3->get('POST.sucursales');
			$data = \simulador_compra\distribucion_mercaderia::guardar_distribucion_tienda($sucursales);
			header("Content-Type: application/json");
			echo json_encode($data);
		}
		
		public function aprobar_distribucion_tienda($f3) {
			$estado = false;
			$mensaje = "";
			try {
				// Guarda los datos de sesión
				$temporada = $f3->get("POST.cod_temporada");
				$po_number = $f3->get("POST.po_number");
				$nro_contenedor = $f3->get("POST.nro_contenedor");
				$login = $f3->get("POST.login");
				// Valida que que haya guardado previamente la distribución
				$sucursales = \simulador_compra\distribucion_mercaderia::detalle_distribucion_sucursales($temporada, $po_number, $nro_contenedor, $login);
				if ($sucursales) {
					foreach ($sucursales as $sucursal) {
						$cod_temporada = $sucursal[0];
						$dep_depto = $sucursal[1];
						$id_color3 = $sucursal[2];
						$cod_tda = $sucursal[3];
						$cantidad = $sucursal[4];
						$fecha_demora = $sucursal[5];
						$lpns = \simulador_compra\distribucion_mercaderia::obtener_lpns_distribucion($cod_temporada, $dep_depto, $id_color3);
						if ($lpns) {
							for ($i = 0; $i < $cantidad; $i++) {
								$lpn_number = $lpns[$i][3];
								$data = \simulador_compra\distribucion_mercaderia::actualizar_lpns_distribucion($cod_temporada, $dep_depto, $id_color3, $lpn_number, $cod_tda, $fecha_demora);
							}
						}
					}
					$estado = true;
					$mensaje = "Distribución aprobada correctamente.";
				} else {
					$estado = false;
					$mensaje = "Debe guardar la distribución antes de aprobarla.";
				}
			} catch (Exception $e) {
				$estado = false;
				$mensaje = $e->getMessage();
			}
			header("Content-Type: application/json");
			echo json_encode(array("estado" => $estado, "mensaje" => $mensaje));
		}
	}