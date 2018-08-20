<?php
	/**
	 * Created by PhpStorm.
	 * User: jcandiah
	 * Date: 17-08-2018
	 * Time: 17:10
	 */
	
	namespace reposicion;
	
	class embarque {
		
		public static function listar_bajada_embarque() {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_LISTA_BAJADA_EMBARQUE(:data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function obtener_cabecera_asn($nro_embarque) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_OBTENER_CABECERA_ASN($nro_embarque, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function obtener_detalle_asn($nro_asn) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_OBTENER_DETALLE_ASN($nro_asn, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_cita($nro_embarque, $id_archivo) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_GENERAR_ARCHIVO_CITA($nro_embarque, '$id_archivo', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_asn_hdr($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_GENERAR_ARCHIVO_ASN_HDR($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_asn_dtl($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_GENERAR_ARCHIVO_ASN_DTL($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_lpn_hdr($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_GENERAR_ARCHIVO_LPN_HDR($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_lpn_dtl($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_GENERAR_ARCHIVO_LPN_DTL($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function generar_archivo_distro($nro_embarque, $host_inpt_id) {
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_GENERAR_ARCHIVO_DISTRO($nro_embarque, '$host_inpt_id', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function obtener_cabecera_asn_sesion($nro_embarque){
			$sql = "SELECT ASN_NUMBER FROM PLC_ASN_CABECERA WHERE (NRO_EMBARQUE = $nro_embarque) AND (COALESCE(ID_SESION, 0) = 0) ORDER BY ASN_NUMBER";
			return \database::getInstancia()->getFilas($sql);
		}
		
		public static function obtener_detalle_asn_sesion($nro_embarque, $asn_number) {
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
						AND (ASN_NUMBER = $asn_number)
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
			$sql = "BEGIN PLC_PKG_EMBARQUE.PRC_GENERAR_ASN($nro_embarque, '$id_archivo', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function guardar_sesion_asn($nro_embarque, $asn_number, $id_sesion){
			$sql = "UPDATE PLC_ASN_CABECERA SET
						ID_SESION = $id_sesion
					WHERE
						(NRO_EMBARQUE = $nro_embarque)
						AND (ASN_NUMBER = $asn_number)";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function archivar_asn($nro_embarque) {
			$sql = "UPDATE PLC_ASN_CABECERA SET
						ENVIADO = 1
						, FECHA_ENVIO = SYSDATE
					WHERE
						(NRO_EMBARQUE = $nro_embarque)";
			return \database::getInstancia()->getConsulta($sql);
		}
	}