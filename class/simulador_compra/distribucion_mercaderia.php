<?php
	
	namespace simulador_compra;
	
	/**
	 * Descripción de formato
	 *
	 * @author Jose Miguel Candia 13-04-2018
	 */
	
	class distribucion_mercaderia {
		public static function listarContenedores($temporada, $login) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_LISTA_CONTENEDORES($temporada, '$login', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function detalleContenedor($temporada, $po_number, $nro_contenedor, $login) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_DETALLE_CONTENEDOR($temporada, $po_number, '$nro_contenedor', '$login', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function detalleContenedoresSucursales($temporada, $po_number, $nro_contenedor, $cod_padre, $login, $cod_tda, $id_color3) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_SUCURSALES_CONTENEDOR($temporada, $po_number, '$nro_contenedor', '$cod_padre', $id_color3, '$login', $cod_tda, :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
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
		
		public static function listaSucursalesPrioridad($cod_temporada, $dep_depto) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_SUCURSALES_PRIORIDAD($cod_temporada, '$dep_depto', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function guardar_prioridades_tienda($cod_temporada, $dep_depto, $sucursales) {
			$sql = "DELETE FROM PLC_PRIORIDAD_TIENDA WHERE (COD_TEMPORADA = $cod_temporada) AND (DEP_DEPTO = '$dep_depto')";
			$data = \database::getInstancia()->getConsulta($sql);
			foreach ($sucursales as $sucursal) {
				$cod_tda = $sucursal["cod_tda"];
				$prioridad = $sucursal["prioridad"];
				$sql = "INSERT INTO PLC_PRIORIDAD_TIENDA VALUES ($cod_temporada, '$dep_depto', $cod_tda, $prioridad)";
				$data = \database::getInstancia()->getConsulta($sql);
			}
			return $data;
		}
		
		public static function obtener_lpns_distribucion($cod_temporada, $dep_depto, $id_color3) {
			$sql = "SELECT
						COD_TEMPORADA
						, DEP_DEPTO
						, ID_COLOR3
						, LPN_NUMBER
					FROM PLC_DETALLE_LPN
					WHERE
						(COD_TEMPORADA = $cod_temporada)
						AND (DEP_DEPTO = '$dep_depto')
						AND (ID_COLOR3 = $id_color3)
						AND (PREFIJO = 'ICC')
						AND (COD_TDA IS NULL)
					GROUP BY
						COD_TEMPORADA
						, DEP_DEPTO
						, ID_COLOR3
						, LPN_NUMBER
					ORDER BY
						LPN_NUMBER";
			return \database::getInstancia()->getFilas($sql);
		}
		
		public static function actualizar_lpns_distribucion($cod_temporada, $dep_depto, $id_color3, $lpn_number, $cod_tda, $fecha_demora) {
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
						AND (LPN_NUMBER = $lpn_number);
					UPDATE PLC_DISTRIB_MERCADERIA SET
						APROBADA = 1
						, FECHA_APROBACION = SYSDATE
					WHERE
						(COD_TEMPORADA = $cod_temporada)
						AND (DEP_DEPTO = '$dep_depto')
						AND (ID_COLOR3 = $id_color3);
					END;";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function guardar_distribucion_tienda($sucursales) {
			$cod_temporada_old = 0;
			$dep_depto_old = "";
			$id_color3_old = 0;
			foreach ($sucursales as $sucursal) {
				$cod_temporada = $sucursal["codTemporada"];
				$dep_depto = $sucursal["depDepto"];
				$id_color3 = $sucursal["idColor3"];
				$cod_tda = $sucursal["codSucursal"];
				$cantidad = $sucursal["cantidad"];
				$fecha_demora = $sucursal["demora"];
				if ($fecha_demora != "") {
					$fecha_demora = "TO_DATE('$fecha_demora', 'DD-MM-YYYY')";
				} else {
					$fecha_demora = "NULL";
				}
				if ($cod_temporada != $cod_temporada_old || $dep_depto != $dep_depto_old || $id_color3 != $id_color3_old) {
					$sql = "DELETE FROM PLC_DISTRIB_MERCADERIA WHERE (COD_TEMPORADA = $cod_temporada) AND (DEP_DEPTO = '$dep_depto') AND (ID_COLOR3 = $id_color3)";
					$data = \database::getInstancia()->getConsulta($sql);
					$cod_temporada_old = $cod_temporada;
					$dep_depto_old = $dep_depto;
					$id_color3_old = $id_color3;
				}
				$sql = "INSERT INTO PLC_DISTRIB_MERCADERIA VALUES ($cod_temporada, '$dep_depto', $id_color3, $cod_tda, $cantidad, $fecha_demora, NULL, NULL)";
				$data = \database::getInstancia()->getConsulta($sql);
			}
			return $data;
		}
		
		public static function listar_bajada_embarque($cod_temporada) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_LISTA_BAJADA_EMBARQUE($cod_temporada, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function obtener_cabecera_asn($nro_embarque) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_OBTENER_CABECERA_ASN($nro_embarque, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function obtener_detalle_asn($nro_asn) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_OBTENER_DETALLE_ASN($nro_asn, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_cita($nro_embarque, $id_archivo) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_GENERAR_ARCHIVO_CITA($nro_embarque, '$id_archivo', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_asn_hdr($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_GENERAR_ARCHIVO_ASN_HDR($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_asn_dtl($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_GENERAR_ARCHIVO_ASN_DTL($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_lpn_hdr($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_GENERAR_ARCHIVO_LPN_HDR($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_lpn_dtl($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_GENERAR_ARCHIVO_LPN_DTL($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_distro($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_GENERAR_ARCHIVO_DISTRO($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function obtener_detalle_asn_sesion($nro_embarque) {
			$sql = "SELECT
						10095 AS SUCURSAL
						, NRO_FACTURA
						, 'COM' || LPAD(TO_CHAR(ASN_NUMBER), 6, '0') AS ASN_NUMBER
						, NRO_EMBARQUE
						, PO_NUMBER
						, NRO_VARIACION
						, NRO_CONTENEDOR
						, AVG(COSTO) AS COSTO
						, SUM(CANTIDAD) AS CANTIDAD
					FROM PLC_ASN_DETALLE
					WHERE
						(NRO_EMBARQUE = $nro_embarque)
					GROUP BY
						NRO_FACTURA
						, ASN_NUMBER
						, NRO_EMBARQUE
						, PO_NUMBER
						, NRO_VARIACION
						, NRO_CONTENEDOR
					ORDER BY
						NRO_FACTURA
						, NRO_EMBARQUE
						, PO_NUMBER
						, NRO_VARIACION";
			return \database::getInstancia()->getFilas($sql);
		}
		
		public static function generar_asn($nro_embarque, $id_archivo) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_GENERAR_ASN($nro_embarque, '$id_archivo', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function archivar_asn($nro_embarque, $id_sesion) {
			$sql = "UPDATE PLC_ASN_CABECERA SET
						ENVIADO = 1
						, FECHA_ENVIO = SYSDATE
						, ID_SESION = $id_sesion
					WHERE
						(NRO_EMBARQUE = $nro_embarque)";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function detalle_distribucion_sucursales($temporada, $po_number, $nro_contenedor, $login) {
			$sql = "BEGIN PLC_PKG_DISTRIB_MERCADERIA.PRC_DETALLE_DISTRIB_SUCURSALES($temporada, $po_number, '$nro_contenedor', '$login', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
	}
