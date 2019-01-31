<?php
	/**
	 * Created by PhpStorm.
	 * User: jcandiah
	 * Date: 13-08-2018
	 * Time: 14:34
	 */
	
	namespace reposicion;
	
	class distribucion {
		
		public static function listaSucursales() {
			$sql = "SELECT
						A.SUC_SUCURSAL
						, A.SUC_NOMBRE
					FROM GST_MAESUCURS A
					WHERE
						(A.SUC_SUCURSAL IN (10000, 10002, 10003, 10004, 10007, 10009, 10010, 10011, 10012, 10014, 10016, 10017, 10018, 10019, 10021, 10022, 10023, 10025, 10026, 10028, 10029, 10032, 10034, 10037, 10039, 10041, 10045, 10046, 10048, 10049, 10051, 10057, 10059, 10067, 10068, 10069, 10071, 10072, 10074, 10076, 10077, 10078, 10079, 10084, 10085, 10088, 10096, 10097, 10098, 10099))
					ORDER BY A.SUC_SUCURSAL";
			$data = \database::getInstancia()->getFilas($sql);
			return $data;
		}
		
		public static function listaSucursalesDisponibles($cod_temporada, $dep_depto) {
			$sql = "SELECT
						A.SUC_SUCURSAL
						, A.SUC_NOMBRE
					FROM GST_MAESUCURS A
					WHERE
						(A.SUC_SUCURSAL IN (10000, 10002, 10003, 10004, 10007, 10009, 10010, 10011, 10012, 10014, 10016, 10017, 10018, 10019, 10021, 10022, 10023, 10025, 10026, 10028, 10029, 10032, 10034, 10037, 10039, 10041, 10045, 10046, 10048, 10049, 10051, 10057, 10059, 10067, 10068, 10069, 10071, 10072, 10074, 10076, 10077, 10078, 10079, 10084, 10085, 10088, 10096, 10097, 10098, 10099))
						AND (NOT EXISTS(SELECT * FROM PLC_PRIORIDAD_TIENDA B WHERE (B.COD_TDA = A.SUC_SUCURSAL) AND (B.COD_TEMPORADA = $cod_temporada) AND (B.DEP_DEPTO = '$dep_depto')))
					ORDER BY A.SUC_SUCURSAL";
			$data = \database::getInstancia()->getFilas($sql);
			return $data;
		}
		
		public static function listaSucursalesSeleccionadas($cod_temporada, $dep_depto) {
			$sql = "SELECT
						A.SUC_SUCURSAL
						, A.SUC_NOMBRE
					FROM GST_MAESUCURS A
					INNER JOIN PLC_PRIORIDAD_TIENDA B
						ON A.SUC_SUCURSAL = B.COD_TDA
					WHERE
						(A.SUC_SUCURSAL IN (10000, 10002, 10003, 10004, 10007, 10009, 10010, 10011, 10012, 10014, 10016, 10017, 10018, 10019, 10021, 10022, 10023, 10025, 10026, 10028, 10029, 10032, 10034, 10037, 10039, 10041, 10045, 10046, 10048, 10049, 10051, 10057, 10059, 10067, 10068, 10069, 10071, 10072, 10074, 10076, 10077, 10078, 10079, 10084, 10085, 10088, 10096, 10097, 10098, 10099))
						AND (B.COD_TEMPORADA = $cod_temporada)
						AND (B.DEP_DEPTO = '$dep_depto')
					ORDER BY B.PRIORIDAD";
			$data = \database::getInstancia()->getFilas($sql);
			return $data;
		}
		
		public static function guardar_prioridades_tienda($cod_temporada, $dep_depto, $sucursales) {
			$sql = "BEGIN ";
			$sql .= "DELETE FROM PLC_PRIORIDAD_TIENDA WHERE (COD_TEMPORADA = $cod_temporada) AND (DEP_DEPTO = '$dep_depto'); ";
			if (count($sucursales) > 0) {
				foreach ($sucursales as $sucursal) {
					$cod_tda = $sucursal["cod_tda"];
					$prioridad = $sucursal["prioridad"];
					$sql .= "INSERT INTO PLC_PRIORIDAD_TIENDA VALUES ($cod_temporada, '$dep_depto', $cod_tda, $prioridad); ";
				}
			}
			$sql .= "END;";
			\database::getInstancia()->getConsulta($sql);
			return $sql;
		}
		
		public static function listarContenedores($login) {
			$sql = "BEGIN PLC_PKG_DISTRIBUCION.PRC_LISTA_CONTENEDORES('$login', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function detalleContenedor($nro_embarque, $nro_contenedor, $login) {
			$sql = "BEGIN PLC_PKG_DISTRIBUCION.PRC_DETALLE_CONTENEDOR($nro_embarque, '$nro_contenedor', '$login', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function detalleContenedoresSucursales($cod_temporada, $dep_depto, $id_color3, $nro_embarque, $nro_contenedor, $cod_padre, $login) {
			$sql = "BEGIN PLC_PKG_DISTRIBUCION.PRC_SUCURSALES_CONTENEDOR($cod_temporada, '$dep_depto', $id_color3, $nro_embarque, '$nro_contenedor', '$cod_padre', '$login', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function guardar_distribucion_tienda($nro_embarque, $nro_contenedor, $sucursales) {
			//$sql .= "DELETE FROM PLC_DISTRIBUCION WHERE (NRO_EMBARQUE = $nro_embarque) AND (NRO_CONTENEDOR = '$nro_contenedor'); ";
			$delete = [];
			foreach ($sucursales as $sucursal) {
				$cod_temporada = $sucursal["codTemporada"];
				$dep_depto = $sucursal["depDepto"];
				$id_color3 = $sucursal["idColor3"];
				$nro_embarque = $sucursal["nroEmbarque"];
				$nro_contenedor = $sucursal["nroContenedor"];
				$delete[] = array(
					"codTemporada" => $cod_temporada,
					"depDepto" => $dep_depto,
					"idColor3" => $id_color3,
					"nroEmbarque" => $nro_embarque,
					"nroContenedor" => $nro_contenedor
				);
			}
			$delete = array_map("unserialize", array_unique(array_map("serialize", $delete)));
			$sql = "BEGIN ";
			foreach ($delete as $item) {
				$cod_temporada = $item["codTemporada"];
				$dep_depto = $item["depDepto"];
				$id_color3 = $item["idColor3"];
				$nro_embarque = $item["nroEmbarque"];
				$nro_contenedor = $item["nroContenedor"];
				$sql .= "DELETE FROM PLC_DISTRIBUCION WHERE (COD_TEMPORADA = $cod_temporada) AND (DEP_DEPTO = '$dep_depto') AND (ID_COLOR3 = $id_color3) AND (NRO_EMBARQUE = $nro_embarque) AND (NRO_CONTENEDOR = '$nro_contenedor'); ";
			}
			$sql .= "END;";
			//file_put_contents('../archivos/delete.sql', $sql);
			\database::getInstancia()->getConsulta($sql);
			$sql = "BEGIN ";
			foreach ($sucursales as $sucursal) {
				$cod_temporada = $sucursal["codTemporada"];
				$dep_depto = $sucursal["depDepto"];
				$id_color3 = $sucursal["idColor3"];
				$nro_embarque = $sucursal["nroEmbarque"];
				$nro_contenedor = $sucursal["nroContenedor"];
				$nro_estilo = $sucursal["nroEstilo"];
				$cod_tda = $sucursal["codSucursal"];
				$cantidad = $sucursal["cantidad"];
				$fecha_demora = $sucursal["demora"];
				if ($fecha_demora != "") {
					$fecha_demora = "TO_DATE('$fecha_demora', 'DD-MM-YYYY')";
				} else {
					$fecha_demora = "NULL";
				}
				$sql .= "INSERT INTO PLC_DISTRIBUCION (COD_TEMPORADA, DEP_DEPTO, ID_COLOR3, NRO_EMBARQUE, NRO_CONTENEDOR, NRO_ESTILO, COD_TDA, CANTIDAD, FECHA_DEMORA) VALUES ($cod_temporada, '$dep_depto', $id_color3, $nro_embarque, '$nro_contenedor', '$nro_estilo', $cod_tda, $cantidad, $fecha_demora); ";
			}
			$sql .= "END;";
			//file_put_contents('../archivos/insert.sql', $sql);
			$data = \database::getInstancia()->getConsulta($sql);
			return $data;
		}
		
		public static function detalle_distribucion_sucursales($nro_embarque, $nro_contenedor, $login) {
			$sql = "BEGIN PLC_PKG_DISTRIBUCION.PRC_DETALLE_DISTRIB_SUCURSALES($nro_embarque, '$nro_contenedor', '$login', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		/*public static function obtener_lpns_distribucion($cod_temporada, $dep_depto, $id_color3, $nro_embarque, $nro_contenedor, $nro_estilo) {
			$sql = "BEGIN PLC_PKG_DISTRIBUCION.PRC_OBTENER_LPNS_DISTRIB($cod_temporada, '$dep_depto', $id_color3, $nro_embarque, '$nro_contenedor', '$nro_estilo', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}*/
		
		public static function actualizar_lpns_distribucion($cod_temporada, $dep_depto, $id_color3, $nro_embarque, $nro_contenedor, $lpn_number, $cod_tda, $fecha_demora) {
			if ($fecha_demora === null) {
				$fecha_demora = "NULL";
			} else {
				$fecha_demora = "TO_DATE('$fecha_demora', 'YYYY-MM-DD')";
			}
			$sql = "BEGIN
					UPDATE PLC_DETALLE_LPN SET
						COD_TDA = $cod_tda
						, FECHA_DEMORA = $fecha_demora
					WHERE
						(COD_TEMPORADA = $cod_temporada)
						AND (DEP_DEPTO = '$dep_depto')
						AND (ID_COLOR3 = $id_color3)
						AND (NRO_EMBARQUE = $nro_embarque)
						AND (NRO_CONTENEDOR = '$nro_contenedor')
						AND (LPN_NUMBER = '$lpn_number');
					UPDATE PLC_DISTRIBUCION SET
						APROBADA = 1
						, FECHA_APROBACION = SYSDATE
					WHERE
						(COD_TEMPORADA = $cod_temporada)
						AND (DEP_DEPTO = '$dep_depto')
						AND (ID_COLOR3 = $id_color3)
						AND (NRO_EMBARQUE = $nro_embarque)
						AND (NRO_CONTENEDOR = '$nro_contenedor')
						AND (COD_TDA = $cod_tda);
					END;";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function distribuir_lpns($nro_embarque, $nro_contenedor, $login) {
			$sql = "BEGIN PLC_PKG_DISTRIBUCION.PRC_DISTRIBUIR_LPNS($nro_embarque, '$nro_contenedor', '$login'); END;";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function validar_distribucion($nro_embarque, $nro_contenedor) {
			$sql = "SELECT CASE WHEN COUNT(DISTINCT LPN_NUMBER) <> COALESCE((SELECT SUM(CANTIDAD) FROM PLC_DISTRIBUCION WHERE (NRO_EMBARQUE = A.NRO_EMBARQUE) AND (NRO_CONTENEDOR = A.NRO_CONTENEDOR)), 0) THEN 0 ELSE 1 END AS HABILITAR
					FROM PLC_DETALLE_LPN A
					WHERE (A.NRO_EMBARQUE = $nro_embarque) AND (A.NRO_CONTENEDOR = '$nro_contenedor') AND (A.PREFIJO = 'ICC')
					GROUP BY A.NRO_EMBARQUE, A.NRO_CONTENEDOR";
			return \database::getInstancia()->getFila($sql);
		}
	}