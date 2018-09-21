<?php
	
	/**
	 * CONTROLADOR de PROVEEDOR
	 * Descripción:
	 * Fecha: 2018-05-16
	 * @author JOSÉ MIGUEL CANDIA
	 */
	class ControlProveedor extends Control {
		private $estiloCabecera = array(
			'borders' => array(
				'allborders' => array(
					'style' => 'thin',
					'color' => array('rgb' => '000000')
				)
			),
			'alignment' => array(
				'horizontal' => 'center',
				'vertical' => 'center',
			),
			'font' => array(
				'bold' => true
			)
		);
		private $estiloCabeceraP = array(
			'borders' => array(
				'allborders' => array(
					'style' => 'thin',
					'color' => array('rgb' => '000000')
				)
			),
			'alignment' => array(
				'horizontal' => 'center',
				'vertical' => 'center'
			),
			'font' => array(
				'bold' => true
			),
			'fill' => array(
				'type' => 'solid',
				'color' => array('rgb' => 'FFFF00')
			)
		);
		private $estiloCabeceraR = array(
			'borders' => array(
				'allborders' => array(
					'style' => 'thin',
					'color' => array('rgb' => '000000')
				)
			),
			'alignment' => array(
				'horizontal' => 'center',
				'vertical' => 'center'
			),
			'font' => array(
				'bold' => true
			),
			'fill' => array(
				'type' => 'solid',
				'color' => array('rgb' => 'DDEBF7')
			)
		);
		private $estiloCelda = array(
			'borders' => array(
				'allborders' => array(
					'style' => 'thin',
					'color' => array('rgb' => '000000')
				)
			)
		);
		private $estiloCeldaNegrita = array(
			'font' => array(
				'bold' => true
			)
		);
		
		public static function cargaMain($f3) {
			$f3->set('SESSION.COD_PROVEEDOR', $f3->get('GET.cod_proveedor'));
			$cod_proveedor = $f3->get('SESSION.COD_PROVEEDOR');
			$proveedor = \proveedor\proveedor::getProveedor($f3->get('SESSION.COD_PROVEEDOR'));
			$f3->set('cod_proveedor', $cod_proveedor);
			$f3->set('proveedor', $proveedor[0][1]);
		}
		
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
						'head' => "SUCCESS",
						'msg' => $mensaje,
						'icon' => "success",
						'color' => "green"
					)));
					$f3->clear('SESSION.success');
					break;
				case $f3->exists('SESSION.warning'):
					$mensaje = $f3->get('SESSION.warning');
					$f3->set('mensaje', Control::SetMensajePredeterminado(array(
						'head' => "WARNING",
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
		
		public function home($f3) {
			ControlProveedor::cargaMain($f3);
			$f3->set('nombre_form', 'Welcome');
			$f3->set('contenido', 'proveedor/home.html');
			echo Template::instance()->render('layout_proveedor.php');
		}
		
		public function getProveedores($f3) {
			$data = \proveedor\proveedor::getProveedores();
			$json = array();
			foreach ($data as $row) {
				$json[] = array("codigo" => $row[0], "rut" => $row[1], "nombre" => \LibraryHelper::cleanText($row[2]));
			}
			$result = array("data" => $json);
			echo json_encode($result);
		}
		
		public function download_templates($f3) {
			ControlProveedor::cargaMain($f3);
			$data = \proveedor\proveedor::getOrdenesCompra($f3->get('GET.cod_proveedor'));
			$f3->set('nombre_form', 'PO\'s and Packing Instructions');
			$f3->set('lista_oc', $data);
			$f3->set('contenido', 'proveedor/download_templates.html');
			echo Template::instance()->render('layout_proveedor.php');
		}
		
		public function download_packing_instructions($f3) {
			$po_number = $f3->get('GET.po_number');
			$file = "packingInstructions_$po_number.xlsx";
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setTitle("Packing Instructions");
			$objPHPExcel->getActiveSheet()->SetCellValue("A1", "PI Number");
			$objPHPExcel->getActiveSheet()->SetCellValue("A2", "PO Number");
			$objPHPExcel->getActiveSheet()->SetCellValue("A3", "Dpto Code");
			$objPHPExcel->getActiveSheet()->SetCellValue("A4", "Dpto Description");
			$objPHPExcel->getActiveSheet()->getStyle("A1:B4")->applyFromArray($this->estiloCelda);
			$objPHPExcel->getActiveSheet()->mergeCells("A6:H6");
			$objPHPExcel->getActiveSheet()->SetCellValue("A6", "PRODUCT DESCRIPTION");
			$objPHPExcel->getActiveSheet()->mergeCells("I6:L6");
			$objPHPExcel->getActiveSheet()->SetCellValue("I6", "Total Units");
			$objPHPExcel->getActiveSheet()->mergeCells("M6:AC6");
			$objPHPExcel->getActiveSheet()->SetCellValue("M6", "TOTAL PORCENTUAL PURCHASE");
			$objPHPExcel->getActiveSheet()->mergeCells("AD6:AT6");
			$objPHPExcel->getActiveSheet()->SetCellValue("AD6", "TOTAL UNITS PURCHASE");
			$objPHPExcel->getActiveSheet()->mergeCells("AU6:AZ6");
			$objPHPExcel->getActiveSheet()->SetCellValue("AU6", "Assorted Size Solid Color Instructions");
			$objPHPExcel->getActiveSheet()->mergeCells("BA6:CI6");
			$objPHPExcel->getActiveSheet()->SetCellValue("BA6", "Solid Size Solid Color Instructions");
			$objPHPExcel->getActiveSheet()->SetCellValue("A7", "Evento");
			$objPHPExcel->getActiveSheet()->SetCellValue("B7", "Brand");
			$objPHPExcel->getActiveSheet()->SetCellValue("C7", "Line Description");
			$objPHPExcel->getActiveSheet()->SetCellValue("D7", " Subline Description");
			$objPHPExcel->getActiveSheet()->SetCellValue("E7", "Subline Code");
			$objPHPExcel->getActiveSheet()->SetCellValue("F7", "Style Name");
			$objPHPExcel->getActiveSheet()->SetCellValue("G7", "Sizes");
			$objPHPExcel->getActiveSheet()->SetCellValue("H7", "Style Code (Ripley)");
			$objPHPExcel->getActiveSheet()->SetCellValue("I7", "Color");
			$objPHPExcel->getActiveSheet()->SetCellValue("J7", "Total Units");
			$objPHPExcel->getActiveSheet()->SetCellValue("K7", "Total Assorted size Solid Color Units");
			$objPHPExcel->getActiveSheet()->SetCellValue("L7", "Total Solid Size Solid Color");
			for ($x = 1; $x <= 17; $x++) {
				$c = \LibraryHelper::getColumnNameFromNumber($x + 12);
				$objPHPExcel->getActiveSheet()->SetCellValue($c . "7", "% Size $x");
			}
			for ($x = 1; $x <= 17; $x++) {
				$c = \LibraryHelper::getColumnNameFromNumber($x + 29);
				$objPHPExcel->getActiveSheet()->SetCellValue($c . "7", "Qty Size $x");
			}
			$objPHPExcel->getActiveSheet()->SetCellValue("AU7", "Size Breakdown");
			$objPHPExcel->getActiveSheet()->SetCellValue("AV7", "Inner Pack Qty");
			$objPHPExcel->getActiveSheet()->SetCellValue("AW7", "Total # Curves");
			$objPHPExcel->getActiveSheet()->SetCellValue("AX7", "Curves Per CTN");
			$objPHPExcel->getActiveSheet()->SetCellValue("AY7", "Units per CTN");
			$objPHPExcel->getActiveSheet()->SetCellValue("AZ7", "Number of Cartons");
			$objPHPExcel->getActiveSheet()->SetCellValue("BA7", "Master Pack");
			for ($x = 1; $x <= 17; $x++) {
				$c = \LibraryHelper::getColumnNameFromNumber($x + 53);
				$objPHPExcel->getActiveSheet()->SetCellValue($c . "7", "# Units Size $x");
			}
			for ($x = 1; $x <= 17; $x++) {
				$c = \LibraryHelper::getColumnNameFromNumber($x + 70);
				$objPHPExcel->getActiveSheet()->SetCellValue($c . "7", "# Cartons Size $x");
			}
			$objPHPExcel->getActiveSheet()->getStyle("A6:CI7")->applyFromArray($this->estiloCabecera);
			$data = \proveedor\proveedor::getPackingInstructions($po_number);
			$flag = false;
			$r = 8;
			foreach ($data as $row) {
				if (!$flag) {
					$flag = true;
					for ($i = 1; $i <= 4; $i++) {
						$objPHPExcel->getActiveSheet()->SetCellValue("B$i", $row[$i - 1]);
					}
				}
				for ($x = 1; $x <= 87; $x++) {
					$c = \LibraryHelper::getColumnNameFromNumber($x);
					$objPHPExcel->getActiveSheet()->SetCellValue($c . $r, $row[$x + 3]);
				}
				$objPHPExcel->getActiveSheet()->getStyle("M$r:AC$r")->getNumberFormat()->setFormatCode('0.00');
				$objPHPExcel->getActiveSheet()->getStyle("A$r:CI$r")->applyFromArray($this->estiloCelda);
				$r++;
			}
			for ($i = 1; $i <= 87; $i++) {
				$column = \LibraryHelper::getColumnNameFromNumber($i);
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}
			$objPHPExcel->getActiveSheet()->setSelectedCellByColumnAndRow(0, 1);
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment; filename=$file");
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save('php://output');
		}
		
		public function download_label_data($f3) {
			$po_number = $f3->get('GET.po_number');
			$file = "labelData_$po_number.xlsx";
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getActiveSheet()->setTitle("Label Data");
			// Columnas con datos de Ripley
			$objPHPExcel->getActiveSheet()->SetCellValue("B2", "N° LPN");
			$objPHPExcel->getActiveSheet()->SetCellValue("C2", "Packing Type");
			$objPHPExcel->getActiveSheet()->SetCellValue("D2", "Vendor");
			$objPHPExcel->getActiveSheet()->SetCellValue("E2", "PO#");
			$objPHPExcel->getActiveSheet()->getStyle("B2:E2")->applyFromArray($this->estiloCabeceraR);
			// Escribe los datos
			$data = \proveedor\proveedor::getLabelData($po_number);
			$r = 3;
			foreach ($data as $val) {
				for ($x = 2; $x <= 5; $x++) {
					$c = \LibraryHelper::getColumnNameFromNumber($x);
					$objPHPExcel->getActiveSheet()->SetCellValue($c . $r, $val[$x - 2]);
				}
				$objPHPExcel->getActiveSheet()->getStyle("B$r:E$r")->applyFromArray($this->estiloCelda);
				$r++;
			}
			for ($i = 2; $i <= 5; $i++) {
				$column = \LibraryHelper::getColumnNameFromNumber($i);
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}
			$objPHPExcel->getActiveSheet()->setSelectedCellByColumnAndRow(0, 1);
			// Escribe el archivo Excel
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment; filename=$file");
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save('php://output');
		}
		
		public function download_packing_list($f3) {
			$po_number = $f3->get('GET.po_number');
			$file = "packingList_$po_number.xlsx";
			$objPHPExcel = new PHPExcel();
			// Genera los encabezados
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setTitle("Packing List");
			$objPHPExcel->getActiveSheet()->SetCellValue("A1", "");
			$objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($this->estiloCabeceraP);
			$objPHPExcel->getActiveSheet()->SetCellValue("B1", "Vendor Information");
			$objPHPExcel->getActiveSheet()->SetCellValue("A2", "");
			$objPHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($this->estiloCabeceraR);
			$objPHPExcel->getActiveSheet()->SetCellValue("B2", "Ripley Information");
			
			$objPHPExcel->getActiveSheet()->SetCellValue("A4", "Invoice Number");
			$objPHPExcel->getActiveSheet()->getStyle("A4")->applyFromArray($this->estiloCabeceraP);
			$objPHPExcel->getActiveSheet()->getStyle("B4")->applyFromArray($this->estiloCelda);
			$objPHPExcel->getActiveSheet()->SetCellValue("A5", "Invoice Date");
			$objPHPExcel->getActiveSheet()->getStyle("A5")->applyFromArray($this->estiloCabeceraP);
			$objPHPExcel->getActiveSheet()->getStyle("B5")->applyFromArray($this->estiloCelda);
			
			for ($x = 1; $x <= 10; $x++) {
				$c = \LibraryHelper::getColumnNameFromNumber($x);
				$objPHPExcel->getActiveSheet()->mergeCells($c . "7:" . $c . "8");
			}
			$objPHPExcel->getActiveSheet()->mergeCells("K7:AA7");
			for ($x = 28; $x <= 39; $x++) {
				$c = \LibraryHelper::getColumnNameFromNumber($x);
				$objPHPExcel->getActiveSheet()->mergeCells($c . "7:" . $c . "8");
			}
			
			$objPHPExcel->getActiveSheet()->getStyle("A7:A8")->applyFromArray($this->estiloCabeceraP);
			$objPHPExcel->getActiveSheet()->getStyle("B7:C8")->applyFromArray($this->estiloCabeceraR);
			$objPHPExcel->getActiveSheet()->getStyle("D7:D8")->applyFromArray($this->estiloCabeceraP);
			$objPHPExcel->getActiveSheet()->getStyle("E7:E8")->applyFromArray($this->estiloCabeceraR);
			$objPHPExcel->getActiveSheet()->getStyle("F7:G8")->applyFromArray($this->estiloCabeceraP);
			$objPHPExcel->getActiveSheet()->getStyle("H7:AE8")->applyFromArray($this->estiloCabeceraR);
			$objPHPExcel->getActiveSheet()->getStyle("AF7:AM8")->applyFromArray($this->estiloCabeceraP);
			$objPHPExcel->getActiveSheet()->getStyle("K8:AA8")->applyFromArray($this->estiloCabeceraR);
			
			$objPHPExcel->getActiveSheet()->SetCellValue("A7", "CONTAINER");
			$objPHPExcel->getActiveSheet()->SetCellValue("B7", "PI NUMBER");
			$objPHPExcel->getActiveSheet()->SetCellValue("C7", "PO NUMBER");
			$objPHPExcel->getActiveSheet()->SetCellValue("D7", "BL/FCR");
			$objPHPExcel->getActiveSheet()->SetCellValue("E7", "PACK TYPE");
			$objPHPExcel->getActiveSheet()->SetCellValue("F7", "INITIAL LPN NUMBER");
			$objPHPExcel->getActiveSheet()->SetCellValue("G7", "FINAL LPN NUMBER");
			$objPHPExcel->getActiveSheet()->SetCellValue("H7", "STYLE NUMBER (RIPLEY)");
			$objPHPExcel->getActiveSheet()->SetCellValue("I7", "STYLE DESCRIPTION (RIPLEY)");
			$objPHPExcel->getActiveSheet()->SetCellValue("J7", "COLOR");
			$objPHPExcel->getActiveSheet()->SetCellValue("K7", "SIZE BREAKDOWN");
			$objPHPExcel->getActiveSheet()->SetCellValue("AB7", "#CURVES/CTN");
			$objPHPExcel->getActiveSheet()->SetCellValue("AC7", "PCS/SETS PER CTN");
			$objPHPExcel->getActiveSheet()->SetCellValue("AD7", "# CARTONS");
			$objPHPExcel->getActiveSheet()->SetCellValue("AE7", "TOTAL PCS/SETS");
			$objPHPExcel->getActiveSheet()->SetCellValue("AF7", "UNIT COST (ORIGEN CURRENCY) ");
			$objPHPExcel->getActiveSheet()->SetCellValue("AG7", "SUBTOTAL AMOUNT");
			$objPHPExcel->getActiveSheet()->SetCellValue("AH7", "G.W PER CTN (KGS)");
			$objPHPExcel->getActiveSheet()->SetCellValue("AI7", "SUB G.W. (KGS)");
			$objPHPExcel->getActiveSheet()->SetCellValue("AJ7", "N.W PER CTN (KGS)");
			$objPHPExcel->getActiveSheet()->SetCellValue("AK7", "SUB N.W. (KGS)");
			$objPHPExcel->getActiveSheet()->SetCellValue("AL7", "MEASUREMENT PER CTN (CBM)");
			$objPHPExcel->getActiveSheet()->SetCellValue("AM7", "SUB VOLUME (CBM)");
			
			for ($i = 1; $i <= 17; $i++) {
				$c = \LibraryHelper::getColumnNameFromNumber($i + 10);
				$objPHPExcel->getActiveSheet()->SetCellValue($c . "8", "SIZE $i");
			}
			
			// Muestra los datos
			$data = \proveedor\proveedor::getPackingList($po_number);
			$r = 9;
			foreach ($data as $row) {
				for ($i = 1; $i <= 39; $i++) {
					$c = \LibraryHelper::getColumnNameFromNumber($i);
					$objPHPExcel->getActiveSheet()->SetCellValue($c . $r, $row[$i - 1]);
				}
				$r++;
			}
			for ($c = 1; $c <= 26; $c++) {
				$columnID = \LibraryHelper::getColumnNameFromNumber($c);
				$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			$objPHPExcel->getActiveSheet()->setSelectedCellByColumnAndRow(0, 1);
			// Escribe el archivo Excel
			header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Disposition: attachment; filename=$file");
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save('php://output');
		}
		
		public function invoice_income($f3) {
			ControlProveedor::cargaMain($f3);
			ControlProveedor::cargaMensajes($f3);
			$data = \proveedor\proveedor::getOrdenesCompraSinFactura($f3->get('GET.cod_proveedor'));
			$f3->set('cod_proveedor', $f3->get('GET.cod_proveedor'));
			$f3->set('nombre_form', 'Invoice Income');
			$f3->set('lista_oc', $data);
			$f3->set('contenido', 'proveedor/invoice_income.html');
			echo Template::instance()->render('layout_proveedor.php');
		}
		
		public function validate_invoice_number($f3) {
			$data = \proveedor\proveedor::validateInvoiceNumber($f3->get('POST.cod_proveedor'), $f3->get('POST.invoiceNumber'));
			echo $data[0] == "1" ? "false" : "true";
		}
		
		public function save_invoice($f3) {
			$cod_proveedor = $f3->get('POST.cod_proveedor');
			$invoiceNumber = $f3->get('POST.invoiceNumber');
			$invoiceDate = $f3->get('POST.invoiceDate');
			$invoiceTotalAmount = $f3->get('POST.invoiceTotalAmount');
			$invoiceTotalUnits = $f3->get('POST.invoiceTotalUnits');
			$selectedPO = $f3->get('POST.checkOC');
			try {
				\proveedor\proveedor::saveInvoice($cod_proveedor, $invoiceNumber, $invoiceDate, $invoiceTotalAmount, $invoiceTotalUnits, $selectedPO);
				$f3->set('SESSION.success', "Invoice saved successfully");
			} catch (Exception $e) {
				$f3->set('SESSION.error', "An error occurred while saving the invoice");
			}
			$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
		}
		
		public function upload_pl($f3) {
			ControlProveedor::cargaMain($f3);
			ControlProveedor::cargaMensajes($f3);
			$f3->set('nombre_form', 'Packing List');
			$f3->set('contenido', 'proveedor/upload_pl.html');
			echo Template::instance()->render('layout_proveedor.php');
		}
		
		public function save_pl($f3) {
			$cod_proveedor = $f3->get('POST.cod_proveedor');
			$etapa = "Save";
			
			error_reporting(E_ALL);
			ini_set('memory_limit', '-1');
			ini_set('max_execution_time', 9000000);
			$web = \Web::instance();
			$slug = true;
			$overwrite = true; // set to true, to overwrite an existing file; Default: false
			$files = $web->receive(function ($file, $formFieldName) {
				$valido = array('xls', 'xlsx', 'XLS', 'XLSX');
				$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
				if (in_array($extension, $valido)) {
					return true;
				} else {
					return false;
				}
			}, $overwrite, $slug);
			foreach ($files as $key => $val) {
				if ($val != "1") {
					$f3->set('SESSION.error', "The file you tried to upload does not have the required Excel format (.xls or .xlsx)");
					$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
				}
				try {
					require_once('../class/PHPExcel/IOFactory.php');
					$excelReader = \PHPExcel_IOFactory::createReaderForFile($key);
					$excelObj = $excelReader->load($key);
					$worksheet = $excelObj->getActiveSheet(0);
					$lastRow = $worksheet->getHighestRow();
					
					// Obtiene la información de la factura desde el archivo
					$invoiceNumber = $worksheet->getCell('B4')->getCalculatedValue();
					$invoiceDate = $worksheet->getCell('B5')->getCalculatedValue();
					
					if (trim($invoiceNumber) == "") {
						unlink($key);
						$f3->set('SESSION.error', "The invoice number is required. Please check the file.");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}
					
					if (trim($invoiceDate) == "") {
						unlink($key);
						$f3->set('SESSION.error', "The invoice date is required. Please check the file.");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}
					
					// Valida que la fecha ingresada tenga formato fecha
					if (PHPExcel_Shared_Date::isDateTime($worksheet->getCell('B5'))) {
						$invoiceDate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($invoiceDate));
					} else {
						unlink($key);
						$f3->set('SESSION.error', "The invoice date does not have the correct format (yyyy-mm-dd or yyyy/mm/dd).");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}
					
					// Obtiene los datos de la factura
					$etapa = "getInvoice";
					$data = \proveedor\proveedor::getInvoice($cod_proveedor, $invoiceNumber);
					
					// Valida que la factura exista
					if (!$data) {
						unlink($key);
						$f3->set('SESSION.error', "The invoice '$invoiceNumber' was not found. Please go to the <a href=\"invoice_income?cod_proveedor=$cod_proveedor\">Invoice Income</a> option and send the information of the invoice");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}
					
					// Valida la fecha de la factura
					if ($invoiceDate !== $data[0][2]) {
						unlink($key);
						$f3->set('SESSION.error', "The invoice date does not correspond to the invoice '$invoiceNumber'. Please check de file.");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}
					
					$registros = [];
					
					$total_unidades = 0;
					$total_costo = 0;
					
					for ($row = 9; $row <= $lastRow; $row++) {
						$po_number = $worksheet->getCell("C$row")->getCalculatedValue();
						$cod_padre = $worksheet->getCell("H$row")->getCalculatedValue();
						$color = strtoupper(trim($worksheet->getCell("J$row")->getCalculatedValue()));
						
						if ($po_number == "") {
							unlink($key);
							$f3->set('SESSION.error', "The purchase order number in row $row can not be empty. Please check de file.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
						
						$existe = \proveedor\proveedor::existeFacturaPO($invoiceNumber, $po_number);
						if ($existe[0] == 0) {
							unlink($key);
							$f3->set('SESSION.error', "The purchase order number '$po_number' in row $row is not associated with the invoice number '$invoiceNumber'. Please check de file.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
						
						// Obtiene los datos para la cabecera
						$etapa = "getPlanData";
						$datosPlan = \proveedor\proveedor::getPlanData($po_number, $cod_padre, $color);
						if (!$datosPlan) {
							unlink($key);
							//$f3->set('SESSION.error', "The purchase order number '$po_number' with style number '$cod_padre' and color '$color' in row $row does not match any purchase plan. Please check the file and try again.");
							$f3->set('SESSION.error', "The purchase order number '$po_number' in row $row does not match any purchase plan. Please check the file and try again.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
						$etapa = "setVariables";
						$pi_number = trim($worksheet->getCell("B$row")->getCalculatedValue());
						$pack_type = trim($worksheet->getCell("E$row")->getCalculatedValue());
						$initial_lpn = trim($worksheet->getCell("F$row")->getCalculatedValue());
						$final_lpn = trim($worksheet->getCell("G$row")->getCalculatedValue());
						
						if (trim($initial_lpn) == "") {
							unlink($key);
							$f3->set('SESSION.error', "The field 'Initial LPN Number' in row $row can not be empty. Please check the file and try again.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
						
						if (trim($final_lpn) == "") {
							unlink($key);
							$f3->set('SESSION.error', "The field 'Final LPN Number' in row $row can not be empty. Please check the file and try again.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
						
						// Valida que el prefijo coincida con el tipo de empaque
						if ($f3->get("PL_VALIDAR_PREFIJO_LPN") == 1) {
							$prefijo = (strtoupper(trim($pack_type)) == "CURVED") ? "ICC" : "ISC";
							$prefijo_lpn = strtoupper(substr($initial_lpn, 0, 3));
							if ($prefijo != $prefijo_lpn) {
								unlink($key);
								$f3->set('SESSION.error', "The prefix '$prefijo_lpn' of the initial LPN number in row $row does not correspond to pack type. Please check the file and try again.");
								$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
							}
							$prefijo_lpn = strtoupper(substr($final_lpn, 0, 3));
							if ($prefijo != $prefijo_lpn) {
								unlink($key);
								$f3->set('SESSION.error', "The prefix '$prefijo_lpn' of the final LPN number in row $row does not correspond to pack type. Please check the file and try again.");
								$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
							}
						}
						
						// Valida que el número de OC del LPN coincida con el del archivo
						if ($f3->get("PL_VALIDAR_OC_LPN") == 1) {
							$oc_lpn = \LibraryHelper::convertNumber(substr($initial_lpn, 3, 8));
							if ($po_number != $oc_lpn) {
								unlink($key);
								$f3->set('SESSION.error', "The initial LPN number in row $row does not correspond to Purchase Order $po_number. Please check the file and try again.");
								$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
							}
							$oc_lpn = \LibraryHelper::convertNumber(substr($final_lpn, 3, 8));
							if ($po_number != $oc_lpn) {
								unlink($key);
								$f3->set('SESSION.error', "The final LPN number in row $row does not correspond to Purchase Order $po_number. Please check the file and try again.");
								$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
							}
						}
						
						// Valida que el número de LPNs coincida con el número de cajas
						$lpn_i = intval(substr($initial_lpn, -8));
						$lpn_f = intval(substr($final_lpn, -8));
						$n_cartons = intval($worksheet->getCell("AD$row")->getCalculatedValue());
						if ($n_cartons != ($lpn_f - $lpn_i + 1)) {
							unlink($key);
							$f3->set('SESSION.error', "The number of LPNs in row $row does not match the number of cartons. Please check the file and try again.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
						
						if ($pi_number != $datosPlan[0][3]) {
							unlink($key);
							$f3->set('SESSION.error', "The purchase order number '$po_number' in row $row does not match PI number. Please check the file and try again.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
						$etapa = "addRecord";
						$registros[] = array(
							"cod_temporada" => $datosPlan[0][0],
							"dep_depto" => $datosPlan[0][1],
							"id_color3" => $datosPlan[0][2],
							"cod_proveedor" => $cod_proveedor,
							"nro_factura" => $invoiceNumber,
							"container" => $worksheet->getCell("A$row")->getCalculatedValue(),
							"pi_number" => $pi_number,
							"po_number" => $po_number,
							"bl_fcr" => $worksheet->getCell("D$row")->getCalculatedValue(),
							"pack_type" => $worksheet->getCell("E$row")->getCalculatedValue(),
							"initial_lpn" => $initial_lpn,
							"final_lpn" => $final_lpn,
							"style_number" => $worksheet->getCell("H$row")->getCalculatedValue(),
							"style_description" => $worksheet->getCell("I$row")->getCalculatedValue(),
							"color" => $worksheet->getCell("J$row")->getCalculatedValue(),
							"size_01" => $worksheet->getCell("K$row")->getCalculatedValue(),
							"size_02" => $worksheet->getCell("L$row")->getCalculatedValue(),
							"size_03" => $worksheet->getCell("M$row")->getCalculatedValue(),
							"size_04" => $worksheet->getCell("N$row")->getCalculatedValue(),
							"size_05" => $worksheet->getCell("O$row")->getCalculatedValue(),
							"size_06" => $worksheet->getCell("P$row")->getCalculatedValue(),
							"size_07" => $worksheet->getCell("Q$row")->getCalculatedValue(),
							"size_08" => $worksheet->getCell("R$row")->getCalculatedValue(),
							"size_09" => $worksheet->getCell("S$row")->getCalculatedValue(),
							"size_10" => $worksheet->getCell("T$row")->getCalculatedValue(),
							"size_11" => $worksheet->getCell("U$row")->getCalculatedValue(),
							"size_12" => $worksheet->getCell("V$row")->getCalculatedValue(),
							"size_13" => $worksheet->getCell("W$row")->getCalculatedValue(),
							"size_14" => $worksheet->getCell("X$row")->getCalculatedValue(),
							"size_15" => $worksheet->getCell("Y$row")->getCalculatedValue(),
							"size_16" => $worksheet->getCell("Z$row")->getCalculatedValue(),
							"size_17" => $worksheet->getCell("AA$row")->getCalculatedValue(),
							"n_curves_ctn" => $worksheet->getCell("AB$row")->getCalculatedValue(),
							"pcs_sets_per_ctn" => $worksheet->getCell("AC$row")->getCalculatedValue(),
							"n_cartons" => $n_cartons,
							"total_pcs_sets" => $worksheet->getCell("AE$row")->getCalculatedValue(),
							"unit_cost" => $worksheet->getCell("AF$row")->getCalculatedValue(),
							"subtotal_amount" => $worksheet->getCell("AG$row")->getCalculatedValue(),
							"gw_per_ctn" => $worksheet->getCell("AH$row")->getCalculatedValue(),
							"sub_gw" => $worksheet->getCell("AI$row")->getCalculatedValue(),
							"nw_per_ctn" => $worksheet->getCell("AJ$row")->getCalculatedValue(),
							"sub_nw" => $worksheet->getCell("AK$row")->getCalculatedValue(),
							"measurement_per_ctn" => $worksheet->getCell("AL$row")->getCalculatedValue(),
							"sub_volume" => $worksheet->getCell("AM$row")->getCalculatedValue()
						);
						
						$total_unidades += $worksheet->getCell("AE$row")->getCalculatedValue();
						$total_costo += $worksheet->getCell("AG$row")->getCalculatedValue();
					}
					
					/*// Valida los montos de la factura
					$etapa = "validateInvoiceAmount";
					$valor_fila = number_format(\LibraryHelper::convertNumber($data[0][3]), 2, ".", "");
					$total_costo = number_format($total_costo, 2, ".", "");
					if ($total_costo !== $valor_fila) {
						unlink($key);
						$f3->set('SESSION.error', "The total amount of the packing list ($total_costo) does not match to the total amount of the invoice '$invoiceNumber' ($valor_fila). Please check de file.");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}
					// Valida las unidades de la factura
					$etapa = "validateInvoiceQuantity";
					$valor_fila = number_format(\LibraryHelper::convertNumber($data[0][4]), 2, ".", "");
					$total_unidades = number_format($total_unidades, 2, ".", "");
					if ($total_unidades != $valor_fila) {
						unlink($key);
						$f3->set('SESSION.error', "The quantity of units in the packing list ($total_unidades) does not match to the quantity of units in the invoice '$invoiceNumber' ($valor_fila). Please check de file.");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}*/
					
					$temp_u = [];
					$temp_m = [];
					foreach ($registros as $registro) {
						$idx = "'" . $registro['po_number'] . "'";
						if (!array_key_exists($idx, $temp_u)) {
							$temp_u[$idx] = 0;
						}
						if (!array_key_exists($idx, $temp_m)) {
							$temp_m[$idx] = 0;
						}
						$temp_u[$idx] += $registro['total_pcs_sets'];
						$temp_m[$idx] += $registro['subtotal_amount'];
					}
					
					// Valida los costos por PO
					$etapa = "validatePOAmount";
					foreach ($temp_m as $llave => $valor) {
						//TODO: Busca los montos de la PO
						$r = \proveedor\proveedor::getInfoPO($llave);
						$valor_po = number_format(\LibraryHelper::convertNumber($r[1]), 2, ".", "");
						$min_tolerancia = $valor_po * 0.97;
						$max_tolerancia = $valor_po * 1.03;
						$valor_pl = number_format(\LibraryHelper::convertNumber($valor), 2, ".", "");
						//if (!($min_tolerancia <= $valor_pl && $valor_pl <= $max_tolerancia)) {
						if ($valor_pl >= $max_tolerancia) {
							unlink($key);
							$f3->set('SESSION.error', "The total amount in the packing list can not be greater than total amount loaded to purchase order number '$llave'. Please check de file.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
					}
					
					// Valida las unidades por PO
					$etapa = "validatePOQuantity";
					foreach ($temp_u as $llave => $valor) {
						//TODO: Busca las unidades de la PO
						$r = \proveedor\proveedor::getInfoPO($llave);
						$valor_po = number_format(\LibraryHelper::convertNumber($r[0]), 2, ".", "");
						$min_tolerancia = $valor_po * 0.97;
						$max_tolerancia = $valor_po * 1.03;
						$valor_pl = number_format(\LibraryHelper::convertNumber($valor), 2, ".", "");
						//if (!($min_tolerancia <= $valor_pl && $valor_pl <= $max_tolerancia)) {
						if ($valor_pl >= $max_tolerancia) {
							unlink($key);
							$f3->set('SESSION.error', "The quantity of units in the packing list can not be greater than total units loaded to purchase order number '$llave'. Please check de file.");
							$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
						}
					}
					
					$etapa = "clearInvoicePLData";
					foreach ($registros as $registro) {
						\proveedor\proveedor::clearInvoicePLData($registro['nro_factura'], $registro['po_number']);
					}
					
					$etapa = "insertInvoicePL";
					foreach ($registros as $registro) {
						\proveedor\proveedor::insertInvoicePL(
							$registro['cod_temporada'],
							$registro['dep_depto'],
							$registro['id_color3'],
							$registro['cod_proveedor'],
							$registro['nro_factura'],
							$registro['container'],
							$registro['pi_number'],
							$registro['po_number'],
							$registro['bl_fcr'],
							$registro['pack_type'],
							$registro['initial_lpn'],
							$registro['final_lpn'],
							$registro['style_number'],
							$registro['style_description'],
							$registro['color'],
							intval($registro['size_01']),
							intval($registro['size_02']),
							intval($registro['size_03']),
							intval($registro['size_04']),
							intval($registro['size_05']),
							intval($registro['size_06']),
							intval($registro['size_07']),
							intval($registro['size_08']),
							intval($registro['size_09']),
							intval($registro['size_10']),
							intval($registro['size_11']),
							intval($registro['size_12']),
							intval($registro['size_13']),
							intval($registro['size_14']),
							intval($registro['size_15']),
							intval($registro['size_16']),
							intval($registro['size_17']),
							intval($registro['n_curves_ctn']),
							$registro['pcs_sets_per_ctn'],
							$registro['n_cartons'],
							$registro['total_pcs_sets'],
							$registro['unit_cost'],
							$registro['subtotal_amount'],
							$registro['gw_per_ctn'],
							$registro['sub_gw'],
							$registro['nw_per_ctn'],
							$registro['sub_nw'],
							$registro['measurement_per_ctn'],
							$registro['sub_volume']
						);
					}
					
					//TODO: Crear detalle LPN
					$this::crearDetalleLPN($f3, $cod_proveedor, $invoiceNumber);
					
					/*$curlopt_url = $f3->get('CURLOPT_URL') . "/facturaComexrst/v1/facturaComex";
					$curlopt_port = $f3->get('CURLOPT_PORT');
					
					$etapa = "sendInvoice";
					$resp = $this->enviarFacturas($cod_proveedor, $invoiceNumber, $curlopt_url, $curlopt_port);
					
					if ($resp != "") {
						$f3->set('SESSION.warning', "An error occurred while sending the file: $resp");
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}*/
					
				} catch (Exception $e) {
					$msj = $e->getMessage();
					$f3->set('SESSION.error', "An error occurred while processing the file: $msj ($etapa)");
					$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
				}
			}
			$f3->set('SESSION.success', "The packing list load finished correctly.");
			$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
		}
		
		public function invoices($f3) {
			ControlProveedor::cargaMain($f3);
			ControlProveedor::cargaMensajes($f3);
			$data = \proveedor\proveedor::getInvoices($f3->get('GET.cod_proveedor'));
			$f3->set('nombre_form', 'INVOICES');
			$f3->set('invoices', $data);
			$f3->set('contenido', 'proveedor/invoices.html');
			echo Template::instance()->render('layout_proveedor.php');
		}
		
		public function approve_invoice($f3) {
			$cod_proveedor = $f3->get('GET.cod_proveedor');
			$nro_factura = $f3->get('GET.nro_factura');
			$etapa = "generateLPNDetail";
			try {
				$etapa = "getInvoiceHeader";
				$facturas = \proveedor\proveedor::getEncabezadoFacturaLPN($cod_proveedor, $nro_factura);
				$registros = [];
				foreach ($facturas as $factura) {
					$nro_factura = $factura[0];
					$numeroOC = $factura[1];
					$detalles = \proveedor\proveedor::getDetalleFactura($cod_proveedor, $nro_factura, $numeroOC);
					foreach ($detalles as $detalle) {
						$nro_estilo = $detalle[0];
						$etapa = "getSKUInfo";
						$color = strtoupper(trim($detalle[22]));
						$skus = \proveedor\proveedor::getSKU($numeroOC, $nro_estilo, $color);
						$talla = 0;
						foreach ($skus as $sku) {
							$talla++;
							if ($talla <= 17) {
								$nro_variacion = $sku[0];
								$prefijo = strtoupper($detalle[21]);
								$cantidadEmbarcada = \LibraryHelper::convertNumber($detalle[$talla]);
								$valorUnitarioFactura = \LibraryHelper::convertNumber($detalle[18]);
								if ($cantidadEmbarcada > 0) {
									for ($lpn = $detalle[19]; $lpn <= $detalle[20]; $lpn++) {
										$etapa = "getSKUInfo_LPN$lpn";
										$registros[] = array(
											"cod_temporada" => $detalle[23],
											"dep_depto" => $detalle[24],
											"id_color3" => $detalle[25],
											"lpn_number" => $lpn,
											"nro_variacion" => $nro_variacion,
											"nro_factura" => $nro_factura,
											"pi_number" => $detalle[26],
											"po_number" => $numeroOC,
											"costo" => $valorUnitarioFactura,
											"cantidad" => $cantidadEmbarcada,
											"prefijo" => $prefijo
										);
									}
								}
							} else {
								break;
							}
						}
					}
				}
				$etapa = "saveLPNDetail";
				foreach ($registros as $registro) {
					$etapa = "saveLPNDetail_" . $registro["po_number"] . "_" . $registro["nro_variacion"];
					\proveedor\proveedor::saveLPNDetail($registro);
				}
				\proveedor\proveedor::setFacturaAprobada($cod_proveedor, $nro_factura);
			} catch (Exception $e) {
				$msj = $e->getMessage();
				$f3->set('SESSION.error', "An error occurred while processing the file: $msj ($etapa)");
				$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
			}
			$f3->set('SESSION.success', "Invoice approved correctly.");
			$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
		}
		
		private function crearDetalleLPN($f3, $cod_proveedor, $nro_factura) {
			$etapa = "generateLPNDetail";
			try {
				$etapa = "getInvoiceHeader";
				$facturas = \proveedor\proveedor::getEncabezadoFacturaLPN($cod_proveedor, $nro_factura);
				$registros = [];
				foreach ($facturas as $factura) {
					$nro_factura = $factura[0];
					$numeroOC = $factura[1];
					$detalles = \proveedor\proveedor::getDetalleFactura($cod_proveedor, $nro_factura, $numeroOC);
					foreach ($detalles as $detalle) {
						$nro_estilo = $detalle[0];
						$etapa = "getSKUInfo";
						$color = strtoupper(trim($detalle[22]));
						$skus = \proveedor\proveedor::getSKU($numeroOC, $nro_estilo, $color);
						$talla = 0;
						$nro_contenedor = $detalle[27];
						$bl = $detalle[28];
						foreach ($skus as $sku) {
							$talla++;
							if ($talla <= 17) {
								$nro_variacion = $sku[0];
								$cantidadEmbarcada = \LibraryHelper::convertNumber($detalle[$talla]);
								$valorUnitarioFactura = \LibraryHelper::convertNumber($detalle[18]);
								if ($cantidadEmbarcada > 0) {
									$prefijo = substr($detalle[19], 0, strlen($detalle[19]) - 8);
									$lpn_i = \LibraryHelper::convertNumber(substr($detalle[19], -8));
									$lpn_f = \LibraryHelper::convertNumber(substr($detalle[20], -8));
									for ($lpn = $lpn_i; $lpn <= $lpn_f; $lpn++) {
										$lpn_new = $prefijo . str_pad($lpn, 8, '0', STR_PAD_LEFT);
										$etapa = "getSKUInfo_LPN$lpn";
										$registros[] = array(
											"cod_temporada" => $detalle[23],
											"dep_depto" => $detalle[24],
											"id_color3" => $detalle[25],
											"lpn_number" => $lpn_new,
											"nro_variacion" => $nro_variacion,
											"nro_factura" => $nro_factura,
											"pi_number" => $detalle[26],
											"po_number" => $numeroOC,
											"costo" => $valorUnitarioFactura,
											"cantidad" => $cantidadEmbarcada,
											"prefijo" => strtoupper($detalle[21]),
											"nro_contenedor" => $nro_contenedor,
											"b_l" => $bl
										);
									}
								}
							} else {
								break;
							}
						}
					}
				}
				$etapa = "saveLPNDetail";
				foreach ($registros as $registro) {
					$etapa = "saveLPNDetail_" . $registro["po_number"] . "_" . $registro["nro_variacion"];
					\proveedor\proveedor::saveLPNDetail($registro);
				}
			} catch (Exception $e) {
				$msj = $e->getMessage();
				$f3->set('SESSION.error', "An error occurred while processing the file: $msj ($etapa)");
				$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
			}
		}
	}