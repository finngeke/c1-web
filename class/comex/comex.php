<?php
	/**
	 * Created by PhpStorm.
	 * User: jcandiah
	 * Date: 04-08-2018
	 * Time: 15:24
	 */
	
	namespace comex;
	
	class comex {
		public static function listarFacturasAprobadas() {
			$sql = "BEGIN PLC_PKG_COMEX.PRC_LISTAR_FACTURAS_APROB(:data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function listarLPNS($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_COMEX.PRC_LISTAR_LPNS($cod_proveedor, '$nro_factura', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function actualizarLPNS($nro_contenedor, $tipo_contenedor, $b_l, $via_transporte, $nro_factura, $po_number, $lpn_number) {
			$sql = "BEGIN PLC_PKG_COMEX.PRC_ACTUALIZAR_LPNS('$nro_contenedor', '$tipo_contenedor', '$b_l', '$via_transporte', '$nro_factura', $po_number, '$lpn_number'); END;";
			$data = \database::getInstancia()->getConsulta($sql);
			return $data;
		}
		
		public static function actualizarFactura($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_COMEX.PRC_ACTUALIZAR_FACTURA($cod_proveedor, '$nro_factura'); END;";
			$data = \database::getInstancia()->getConsulta($sql);
			return $data;
		}
		
		public static function actualizarNroEnvio($cod_proveedor, $nro_factura, $nro_envio) {
			$sql = "BEGIN PLC_PKG_COMEX.PRC_ACTUALIZAR_NRO_ENVIO($cod_proveedor, '$nro_factura', $nro_envio); END;";
			$data = \database::getInstancia()->getConsulta($sql);
			return $data;
		}
		
		public static function obtenerEncabezadoArchivo($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_COMEX.PRC_ENCABEZADO_ARCHIVO($cod_proveedor, '$nro_factura', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function obtenerDetalleArchivo($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_COMEX.PRC_DETALLE_ARCHIVO($cod_proveedor, '$nro_factura', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
	}