<?php
	/*
	 * To change this license header, choose License Headers in Project Properties.
	 * To change this template file, choose Tools | Templates
	 * and open the template in the editor.
	 */
	
	namespace proveedor;
	
	/**
	 * Description of tipo_de_tienda
	 *
	 * @author José Miguel Candia
	 */
	class proveedor {
		// Carga información del proveedor
		public static function getProveedor($cod_provedor) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_INFO_PROVEEDOR($cod_provedor, :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function getProveedores() {
			//$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_INFO_PROVEEDOR(0, :data); END;";
			//$data = \database::getInstancia()->getConsultaSP($sql, 1);
			$sql = "SELECT COD_PROVEEDOR, RUT_PROVEEDOR, TRIM(NOM_PROVEEDOR) FROM PLC_PROVEEDORES_PMM ORDER BY TRIM(NOM_PROVEEDOR)";
			$data = \database::getInstancia()->getFilas($sql);
			return $data;
		}
		
		public static function getOrdenesCompra($cod_provedor) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_INFO_OC_PROVEEDOR($cod_provedor, :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function getOrdenesCompraSinFactura($cod_provedor) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_INFO_OC_PROVEEDOR_SIN_FACT($cod_provedor, :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function getPackingInstructions($po_number) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_INSTRUCCIONES_EMPAQUE($po_number, :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function getLabelData($po_number) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_DETALLE_LPN($po_number, :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function getPackingList($po_number) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_GENERAR_PACKING_LIST($po_number, :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		public static function saveInvoice($cod_proveedor, $invoiceNumber, $invoiceDate, $invoiceTotalAmount, $invoiceTotalUnits, $selectedPO) {
			$invoiceTotalAmount = \LibraryHelper::convertNumber($invoiceTotalAmount);
			$invoiceTotalUnits = \LibraryHelper::convertNumber($invoiceTotalUnits);
			$sql = "BEGIN ";
			$sql .= "PLC_PKG_PROVEEDOR.PRC_GUARDAR_ENCABEZADO_FACTURA($cod_proveedor, '$invoiceNumber', '$invoiceDate', $invoiceTotalAmount, $invoiceTotalUnits); ";
			foreach ($selectedPO as $item) {
				$fila = explode('|', $item);
				$po_number = $fila[1];
				//$monto = str_replace(",", ".", $fila[2]);
				//$unidades = str_replace(",", ".", $fila[3]);
				$monto = "NULL";
				$unidades = "NULL";
				$sql .= "PLC_PKG_PROVEEDOR.PRC_GUARDAR_DETALLE_FACTURA($cod_proveedor, '$invoiceNumber', $po_number, $monto, $unidades); ";
			}
			$sql .= "END;";
			$data = \database::getInstancia()->getConsulta($sql);
			return $data;
		}
		
		public static function validateInvoiceNumber($cod_proveedor, $invoiceNumber) {
			$sql = "SELECT CASE WHEN EXISTS(SELECT * FROM PLC_CARGA_FACTURAS_HDR WHERE (COD_PROVEEDOR = $cod_proveedor) AND (NRO_FACTURA = '$invoiceNumber')) THEN 1 ELSE 0 END AS EXISTE FROM DUAL";
			return \database::getInstancia()->getFila($sql);
		}
		
		public static function getInvoice($cod_proveedor, $invoiceNumber) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_OBTENER_FACTURA_PROVEEDOR($cod_proveedor, '$invoiceNumber', :data); END;";
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			return $data;
		}
		
		/*
		public static function validateInvoicePL($cod_proveedor, $invoiceNumber) {
			$sql = "SELECT CASE WHEN EXISTS(SELECT * FROM PLC_PACKING_LIST_LOAD WHERE (COD_PROVEEDOR = $cod_proveedor) AND (NRO_FACTURA = '$invoiceNumber')) THEN 1 ELSE 0 END AS EXISTE FROM DUAL";
			return \database::getInstancia()->getFila($sql);
		}
		*/
		
		public static function getPlanData($po_number, $cod_padre, $color) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_OBTENER_DATOS_COMPRA($po_number, '$cod_padre', '$color', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function insertInvoicePL($cod_temporada, $dep_depto, $id_color3, $cod_proveedor, $nro_factura, $container, $pi_number, $po_number, $bl_fcr, $pack_type, $initial_lpn, $final_lpn, $style_number, $style_description, $color, $size_01, $size_02, $size_03, $size_04, $size_05, $size_06, $size_07, $size_08, $size_09, $size_10, $size_11, $size_12, $size_13, $size_14, $size_15, $size_16, $size_17, $n_curves_ctn, $pcs_sets_per_ctn, $n_cartons, $total_pcs_sets, $unit_cost, $subtotal_amount, $gw_per_ctn, $sub_gw, $nw_per_ctn, $sub_nw, $measurement_per_ctn, $sub_volume) {
			$sql = "INSERT INTO PLC_PACKING_LIST_CARGA VALUES ($cod_temporada, '$dep_depto', $id_color3, $cod_proveedor, '$nro_factura', '$container', '$pi_number', $po_number, '$bl_fcr', '$pack_type', '$initial_lpn', '$final_lpn', '$style_number', '$style_description', '$color', $size_01, $size_02, $size_03, $size_04, $size_05, $size_06, $size_07, $size_08, $size_09, $size_10, $size_11, $size_12, $size_13, $size_14, $size_15, $size_16, $size_17, $n_curves_ctn, $pcs_sets_per_ctn, $n_cartons, $total_pcs_sets, $unit_cost, $subtotal_amount, $gw_per_ctn, $sub_gw, $nw_per_ctn, $sub_nw, '$measurement_per_ctn', $sub_volume)";
			$data = \database::getInstancia()->getConsulta($sql);
			return $data;
		}
		
		public static function clearInvoicePLData($invoice_number, $po_number) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PLC_CLEAR_INVOICE_PL_DATA('$invoice_number', $po_number); END;";
			$data = \database::getInstancia()->getConsulta($sql);
			return $data;
		}
		
		public static function getInvoices($cod_proveedor) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_FACTURAS_PROVEEDOR($cod_proveedor, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function getSKU($orden_de_compra, $nro_estilo, $color) {
			$sql = "SELECT DISTINCT
						TRIM(NRO_VARIACION) AS NRO_VARIACION
					FROM B
					WHERE
						(ORDEN_DE_COMPRA = $orden_de_compra)
						AND (NRO_ESTILO = '$nro_estilo')
						AND (TRIM(UPPER(COLOR)) = '$color')
					ORDER BY
						TRIM(NRO_VARIACION)";
			$data = \database::getInstancia()->getFilas($sql);
			
			if (!$data) {
				$sql = "SELECT DISTINCT
							B.PRD_LVL_NUMBER AS NRO_VARIACION
						FROM PRDMSTEE A
						INNER JOIN PRDMSTEE B
							ON A.PRD_LVL_CHILD = B.PRD_LVL_PARENT
						WHERE
							(A.PRD_LVL_NUMBER = '$nro_estilo')
						ORDER BY
							B.PRD_LVL_NUMBER";
				$data = \database::getInstancia()->getFilas($sql);
			}
			
			return $data;
		}
		
		public static function getEncabezadoFactura($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_OBTENER_ENCABEZADO_FACTURA($cod_proveedor, '$nro_factura', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function getEncabezadoFacturaLPN($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_OBTENER_FACTURAS_LPN($cod_proveedor, '$nro_factura', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function getDetalleFactura($cod_proveedor, $nro_factura, $nro_oc) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_OBTENER_DETALLE_FACTURA($cod_proveedor, '$nro_factura', $nro_oc, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function getDetalleFacturaEnviar($cod_proveedor, $nro_factura, $nro_oc) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_OBTENER_FACTURA_ENVIAR($cod_proveedor, '$nro_factura', $nro_oc, :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function getDetalleFacturaEnviarComex($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_OBTENER_FACTURA_ENVIAR_CMX($cod_proveedor, '$nro_factura', :data); END;";
			return \database::getInstancia()->getConsultaSP($sql, 1);
		}
		
		public static function setFacturaAprobada($cod_proveedor, $nro_factura){
			$sql = "UPDATE PLC_CARGA_FACTURAS_HDR SET
						APROBADA = 1
						, FECHA_APROBACION = SYSDATE
					WHERE
						(COD_PROVEEDOR = $cod_proveedor)
						AND (NRO_FACTURA = '$nro_factura')";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function setDetalleFacturaAprobado($cod_proveedor, $nro_factura, $nro_oc) {
			$sql = "UPDATE PLC_CARGA_FACTURAS_DTL SET
						APROBADA = 1
						, FECHA_APROBACION = SYSDATE
					WHERE
						(COD_PROVEEDOR = $cod_proveedor)
						AND (NRO_FACTURA = '$nro_factura')
						AND (PO_NUMBER = $nro_oc)";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function saveLPNDetail($registro) {
			$sql = "INSERT INTO PLC_DETALLE_LPN (
						COD_TEMPORADA
						, DEP_DEPTO
						, ID_COLOR3
						, LPN_NUMBER
						, NRO_VARIACION
						, NRO_FACTURA
						, PI_NUMBER
						, PO_NUMBER
						, COSTO
						, CANTIDAD
						, PREFIJO
						, NRO_CONTENEDOR
						, B_L
					) VALUES (
						" . $registro["cod_temporada"] . "
						, '" . $registro["dep_depto"] . "'
						, " . $registro["id_color3"] . "
						, '" . $registro["lpn_number"] . "'
						, '" . $registro["nro_variacion"] . "'
						, '" . $registro["nro_factura"] . "'
						, '" . $registro["pi_number"] . "'
						, " . $registro["po_number"] . "
						, " . $registro["costo"] . "
						, " . $registro["cantidad"] . "
						, '" . $registro["prefijo"] . "'
						, '" . $registro["nro_contenedor"] . "'
						, '" . $registro["b_l"] . "'
					)";
			$data = \database::getInstancia()->getConsulta($sql);
		}
		
		public static function getInfoPO($po_number) {
			$sql = "SELECT
						A.PO_UNITS_QTY - COALESCE((SELECT SUM(TOTAL_PCS_SETS) AS SUB_TOTAL_AMOUNT FROM PLC_PACKING_LIST_CARGA WHERE (PO_NUMBER = A.PO_NUMBER)), 0) AS PO_UNITS_QTY
						, A.PO_UNITS_COST - COALESCE((SELECT SUM(SUB_TOTAL_AMOUNT) AS SUB_TOTAL_AMOUNT FROM PLC_PACKING_LIST_CARGA WHERE (PO_NUMBER = A.PO_NUMBER)), 0) AS PO_UNITS_COST
					FROM PLC_ORDENES_COMPRA_PMM A
					WHERE
						(A.PO_NUMBER = $po_number)";
			return \database::getInstancia()->getFila($sql);
		}
		
		public static function existeFacturaPO($nro_factura, $po_number) {
			$sql = "SELECT CASE WHEN EXISTS(SELECT * FROM PLC_CARGA_FACTURAS_DTL WHERE (NRO_FACTURA = '$nro_factura') AND (PO_NUMBER = $po_number)) THEN 1 ELSE 0 END AS EXISTE FROM DUAL";
			return \database::getInstancia()->getFila($sql);
		}
		
		public static function crearDetalleLPN($cod_proveedor, $nro_factura) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_PACKING_LIST_LPN($cod_proveedor, '$nro_factura'); END;";
			return \database::getInstancia()->getConsulta($sql);
		}


		public static function get_cod_nom_Prov_Peru($cod_provPeru){
            $nombre = "";
		    $sql = "SELECT nom_proveedor 
                    FROM PLC_PROVEEDORES_PERU  
                    where cod_proveedor =  $cod_provPeru";


            $data= \database::getInstancia()->getFila($sql);
            if (count($data)<>0){
                $nombre =$data[0];
            }
            return $nombre;
        }

public static function guardarPL($pl_id, $clob) {
			$sql = "BEGIN PLC_PKG_PROVEEDOR.PRC_INSERTAR_PL('$pl_id', :clob,:code,:message); END;";
			return \database::getInstancia()->getConsultaClob($sql, $clob);
		}
// Fin de la clase
	}
