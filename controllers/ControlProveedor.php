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
			
			// Eliminar toda consurrencia del ususario
			\permisos\permiso_usuario::eliminar_toda_concurrencia($f3->get('SESSION.login'));
			
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
			
			$u = 0;
			foreach ($data as $t) {
				array_push($data[$u], "", "Chile");
				$u++;
			}
			
			$_SESSION['RutaArchivoPeru'] = "D:/ftp/Peru/";
			$nom_proveedorChile = $f3->get('GET.nom_proveedor');
			//extracion de oc peruanas
			$_SESSION['Archivos'] = "";
			ControlProveedor::obtener_estructura_directorios($_SESSION['RutaArchivoPeru']);
			$dtarchivos = explode("$", (substr($_SESSION['Archivos'], 0, -1)));
            $dtprovoc = [];
			foreach ($dtarchivos as $val) {
				$stringarchiv = explode("_", $val);
						$_exist2 = false;
                foreach ($dtprovoc as $var) {
                    if ($var[0] == $stringarchiv[1] and $var[1] ==$stringarchiv[3]) {
                        $_exist2 = true; break;
							}
						}
                if ($_exist2==false){
                    $nom_Proveedorperu = \proveedor\proveedor::get_cod_nom_Prov_Peru($stringarchiv[1]);
							if ($nom_Proveedorperu <> "" and $nom_Proveedorperu == $nom_proveedorChile) {
                        array_push($dtprovoc,array($stringarchiv[1],$stringarchiv[3]));
                        array_push($data, array("", $stringarchiv[3], 0, "", 0, 0, $val, "Peru"));
							}

				}
			}
			
			$f3->set('nombre_form', 'PO\'s and Packing Instructions');
			$f3->set('lista_oc', $data);
			$f3->set('contenido', 'proveedor/download_templates.html');
			echo Template::instance()->render('layout_proveedor.php');
		}
		
		function obtener_estructura_directorios($ruta) {
			// Se comprueba que realmente sea la ruta de un directorio
			if (is_dir($ruta)) {
				// Abre un gestor de directorios para la ruta indicada
				$gestor = opendir($ruta);
				// echo "<ul>";
				
				// Recorre todos los elementos del directorio
				while (($archivo = readdir($gestor)) !== false) {
					
					$ruta_completa = $ruta . "/" . $archivo;
					
					// Se muestran todos los archivos y carpetas excepto "." y ".."
					if ($archivo != "." && $archivo != "..") {
						// Si es un directorio se recorre recursivamente
						if (is_dir($ruta_completa)) {
							//echo "$" . $archivo ;
							ControlProveedor::obtener_estructura_directorios($ruta_completa);
							$_SESSION['Archivos'] = $_SESSION['Archivos'] . $archivo . "$";
							
						} else {
							$_SESSION['Archivos'] = $_SESSION['Archivos'] . $archivo . "$";
							//echo "$" . $archivo ;
						}
					}
				}
				
				// Cierra el gestor de directorios
				closedir($gestor);
				//echo "</ul>";
			} else {
				//echo "No es una ruta de directorio valida<br/>";
			}
		}
		
		public function download_packing_instructions($f3) {
			
			if ($f3->get('GET.pais') == "Chile") {
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
				
			} elseif ($f3->get('GET.pais') == "Peru") {
				$file = $f3->get('GET.Archivo'); // Decode URL-encoded string
				$filepath = $_SESSION['RutaArchivoPeru'] . $file;
				
				// Process download
				if (file_exists($filepath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $file . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filepath));
					
					flush(); // Flush system output buffer
					readfile($filepath);
					exit;
				}
			}
		}
		
		public function download_label_data($f3) {
			
			if ($f3->get('GET.pais') == "Chile") {
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
				
			} elseif ($f3->get('GET.pais') == "Peru") {
				$file = str_replace("INST", "LPN", $f3->get('GET.Archivo')); // Decode URL-encoded string
				$filepath = $_SESSION['RutaArchivoPeru'] . $file;
				// Process download
				if (file_exists($filepath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $file . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filepath));
					
					flush(); // Flush system output buffer
					readfile($filepath);
					exit;
				}
				
				
			}
		}
		
		public function download_packing_list($f3) {
			if ($f3->get('GET.pais') == "Chile") {
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
				$objPHPExcel->getActiveSheet()->mergeCells("K7:AE7");
				$objPHPExcel->getActiveSheet()->mergeCells("AF7:AZ7");
				$objPHPExcel->getActiveSheet()->mergeCells("BA7:BU7");
				for ($x = 74; $x <= 85; $x++) {
					$c = \LibraryHelper::getColumnNameFromNumber($x);
					$objPHPExcel->getActiveSheet()->mergeCells($c . "7:" . $c . "8");
				}
				
				$objPHPExcel->getActiveSheet()->getStyle("A7:A8")->applyFromArray($this->estiloCabeceraP);
				$objPHPExcel->getActiveSheet()->getStyle("B7:C8")->applyFromArray($this->estiloCabeceraR);
				$objPHPExcel->getActiveSheet()->getStyle("D7:D8")->applyFromArray($this->estiloCabeceraP);
				$objPHPExcel->getActiveSheet()->getStyle("E7:E8")->applyFromArray($this->estiloCabeceraR);
				$objPHPExcel->getActiveSheet()->getStyle("F7:G8")->applyFromArray($this->estiloCabeceraP);
				$objPHPExcel->getActiveSheet()->getStyle("H7:BY8")->applyFromArray($this->estiloCabeceraR);
				$objPHPExcel->getActiveSheet()->getStyle("BZ7:CG8")->applyFromArray($this->estiloCabeceraP);
				$objPHPExcel->getActiveSheet()->getStyle("K8:BU8")->applyFromArray($this->estiloCabeceraR);
				
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
				$objPHPExcel->getActiveSheet()->SetCellValue("AF7", "SKU BREAKDOWN");
				$objPHPExcel->getActiveSheet()->SetCellValue("BA7", "SIZE NAME BREAKDOWN");
				$objPHPExcel->getActiveSheet()->SetCellValue("BV7", "#CURVES/CTN");
				$objPHPExcel->getActiveSheet()->SetCellValue("BW7", "PCS/SETS PER CTN");
				$objPHPExcel->getActiveSheet()->SetCellValue("BX7", "# CARTONS");
				$objPHPExcel->getActiveSheet()->SetCellValue("BY7", "TOTAL PCS/SETS");
				$objPHPExcel->getActiveSheet()->SetCellValue("BZ7", "UNIT COST (ORIGEN CURRENCY) ");
				$objPHPExcel->getActiveSheet()->SetCellValue("CA7", "SUBTOTAL AMOUNT");
				$objPHPExcel->getActiveSheet()->SetCellValue("CB7", "G.W PER CTN (KGS)");
				$objPHPExcel->getActiveSheet()->SetCellValue("CC7", "SUB G.W. (KGS)");
				$objPHPExcel->getActiveSheet()->SetCellValue("CD7", "N.W PER CTN (KGS)");
				$objPHPExcel->getActiveSheet()->SetCellValue("CE7", "SUB N.W. (KGS)");
				$objPHPExcel->getActiveSheet()->SetCellValue("CF7", "MEASUREMENT PER CTN (CBM)");
				$objPHPExcel->getActiveSheet()->SetCellValue("CG7", "SUB VOLUME (CBM)");
				
				for ($i = 1; $i <= 21; $i++) {
					$c = \LibraryHelper::getColumnNameFromNumber($i + 10);
					$objPHPExcel->getActiveSheet()->SetCellValue($c . "8", "SIZE $i");
					$c = \LibraryHelper::getColumnNameFromNumber($i + 31);
					$objPHPExcel->getActiveSheet()->SetCellValue($c . "8", "SKU SIZE $i");
					$c = \LibraryHelper::getColumnNameFromNumber($i + 52);
					$objPHPExcel->getActiveSheet()->SetCellValue($c . "8", "NAME SIZE $i");
				}
				
				// Muestra los datos
				$data = \proveedor\proveedor::getPackingList($po_number);
				$r = 9;
				foreach ($data as $row) {
					for ($i = 1; $i <= 85; $i++) {
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
			} elseif ($f3->get('GET.pais') == "Peru") {
				$file = str_replace("INST", "PL", $f3->get('GET.Archivo')); // Decode URL-encoded string
				$filepath = $_SESSION['RutaArchivoPeru'] . $file;
				// Process download
				if (file_exists($filepath)) {
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="' . $file . '"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filepath));
					
					flush(); // Flush system output buffer
					readfile($filepath);
					exit;
				}
				
				
			}
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
					
					$pl_id = \LibraryHelper::guid();
					$filas = [];
					for ($row = 9; $row <= $lastRow; $row++) {
						$filas[] = array(
							"PL_ID" => $pl_id,
							"NRO_FILA" => $row,
							"COD_PROVEEDOR" => $cod_proveedor,
							"NRO_FACTURA" => $invoiceNumber,
							"CONTAINER" => $worksheet->getCell("A$row")->getCalculatedValue(),
							"PI_NUMBER" => trim($worksheet->getCell("B$row")->getCalculatedValue()),
							"PO_NUMBER" => $worksheet->getCell("C$row")->getCalculatedValue(),
							"BL_FCR" => $worksheet->getCell("D$row")->getCalculatedValue(),
							"PACK_TYPE" => trim($worksheet->getCell("E$row")->getCalculatedValue()),
							"INITIAL_LPN_NUMBER" => trim($worksheet->getCell("F$row")->getCalculatedValue()),
							"FINAL_LPN_NUMBER" => trim($worksheet->getCell("G$row")->getCalculatedValue()),
							"STYLE_NUMBER" => $worksheet->getCell("H$row")->getCalculatedValue(),
							"STYLE_DESCRIPTION" => $worksheet->getCell("I$row")->getCalculatedValue(),
							"COLOR" => $worksheet->getCell("J$row")->getCalculatedValue(),
							"SIZE_01" => $worksheet->getCell("K$row")->getCalculatedValue(),
							"SIZE_02" => $worksheet->getCell("L$row")->getCalculatedValue(),
							"SIZE_03" => $worksheet->getCell("M$row")->getCalculatedValue(),
							"SIZE_04" => $worksheet->getCell("N$row")->getCalculatedValue(),
							"SIZE_05" => $worksheet->getCell("O$row")->getCalculatedValue(),
							"SIZE_06" => $worksheet->getCell("P$row")->getCalculatedValue(),
							"SIZE_07" => $worksheet->getCell("Q$row")->getCalculatedValue(),
							"SIZE_08" => $worksheet->getCell("R$row")->getCalculatedValue(),
							"SIZE_09" => $worksheet->getCell("S$row")->getCalculatedValue(),
							"SIZE_10" => $worksheet->getCell("T$row")->getCalculatedValue(),
							"SIZE_11" => $worksheet->getCell("U$row")->getCalculatedValue(),
							"SIZE_12" => $worksheet->getCell("V$row")->getCalculatedValue(),
							"SIZE_13" => $worksheet->getCell("W$row")->getCalculatedValue(),
							"SIZE_14" => $worksheet->getCell("X$row")->getCalculatedValue(),
							"SIZE_15" => $worksheet->getCell("Y$row")->getCalculatedValue(),
							"SIZE_16" => $worksheet->getCell("Z$row")->getCalculatedValue(),
							"SIZE_17" => $worksheet->getCell("AA$row")->getCalculatedValue(),
							"SIZE_18" => (trim(strtoupper($worksheet->getCell("AB8")->getCalculatedValue())) == "SIZE 18") ? $worksheet->getCell("AB$row")->getCalculatedValue() : "",
							"SIZE_19" => (trim(strtoupper($worksheet->getCell("AC8")->getCalculatedValue())) == "SIZE 19") ? $worksheet->getCell("AC$row")->getCalculatedValue() : "",
							"SIZE_20" => (trim(strtoupper($worksheet->getCell("AD8")->getCalculatedValue())) == "SIZE 20") ? $worksheet->getCell("AD$row")->getCalculatedValue() : "",
							"SIZE_21" => (trim(strtoupper($worksheet->getCell("AE8")->getCalculatedValue())) == "SIZE 21") ? $worksheet->getCell("AE$row")->getCalculatedValue() : "",
							
							"SIZE_SKU_01" => (trim(strtoupper($worksheet->getCell("AF8")->getCalculatedValue())) == "SKU SIZE 1") ? $worksheet->getCell("AF$row")->getCalculatedValue() : "",
							"SIZE_SKU_02" => (trim(strtoupper($worksheet->getCell("AG8")->getCalculatedValue())) == "SKU SIZE 2") ? $worksheet->getCell("AG$row")->getCalculatedValue() : "",
							"SIZE_SKU_03" => (trim(strtoupper($worksheet->getCell("AH8")->getCalculatedValue())) == "SKU SIZE 3") ? $worksheet->getCell("AH$row")->getCalculatedValue() : "",
							"SIZE_SKU_04" => (trim(strtoupper($worksheet->getCell("AI8")->getCalculatedValue())) == "SKU SIZE 4") ? $worksheet->getCell("AI$row")->getCalculatedValue() : "",
							"SIZE_SKU_05" => (trim(strtoupper($worksheet->getCell("AJ8")->getCalculatedValue())) == "SKU SIZE 5") ? $worksheet->getCell("AJ$row")->getCalculatedValue() : "",
							"SIZE_SKU_06" => (trim(strtoupper($worksheet->getCell("AK8")->getCalculatedValue())) == "SKU SIZE 6") ? $worksheet->getCell("AK$row")->getCalculatedValue() : "",
							"SIZE_SKU_07" => (trim(strtoupper($worksheet->getCell("AL8")->getCalculatedValue())) == "SKU SIZE 7") ? $worksheet->getCell("AL$row")->getCalculatedValue() : "",
							"SIZE_SKU_08" => (trim(strtoupper($worksheet->getCell("AM8")->getCalculatedValue())) == "SKU SIZE 8") ? $worksheet->getCell("AM$row")->getCalculatedValue() : "",
							"SIZE_SKU_09" => (trim(strtoupper($worksheet->getCell("AN8")->getCalculatedValue())) == "SKU SIZE 9") ? $worksheet->getCell("AN$row")->getCalculatedValue() : "",
							"SIZE_SKU_10" => (trim(strtoupper($worksheet->getCell("AO8")->getCalculatedValue())) == "SKU SIZE 10") ? $worksheet->getCell("AO$row")->getCalculatedValue() : "",
							"SIZE_SKU_11" => (trim(strtoupper($worksheet->getCell("AP8")->getCalculatedValue())) == "SKU SIZE 11") ? $worksheet->getCell("AP$row")->getCalculatedValue() : "",
							"SIZE_SKU_12" => (trim(strtoupper($worksheet->getCell("AQ8")->getCalculatedValue())) == "SKU SIZE 12") ? $worksheet->getCell("AQ$row")->getCalculatedValue() : "",
							"SIZE_SKU_13" => (trim(strtoupper($worksheet->getCell("AR8")->getCalculatedValue())) == "SKU SIZE 13") ? $worksheet->getCell("AR$row")->getCalculatedValue() : "",
							"SIZE_SKU_14" => (trim(strtoupper($worksheet->getCell("AS8")->getCalculatedValue())) == "SKU SIZE 14") ? $worksheet->getCell("AS$row")->getCalculatedValue() : "",
							"SIZE_SKU_15" => (trim(strtoupper($worksheet->getCell("AT8")->getCalculatedValue())) == "SKU SIZE 15") ? $worksheet->getCell("AT$row")->getCalculatedValue() : "",
							"SIZE_SKU_16" => (trim(strtoupper($worksheet->getCell("AU8")->getCalculatedValue())) == "SKU SIZE 16") ? $worksheet->getCell("AU$row")->getCalculatedValue() : "",
							"SIZE_SKU_17" => (trim(strtoupper($worksheet->getCell("AV8")->getCalculatedValue())) == "SKU SIZE 17") ? $worksheet->getCell("AV$row")->getCalculatedValue() : "",
							"SIZE_SKU_18" => (trim(strtoupper($worksheet->getCell("AW8")->getCalculatedValue())) == "SKU SIZE 18") ? $worksheet->getCell("AW$row")->getCalculatedValue() : "",
							"SIZE_SKU_19" => (trim(strtoupper($worksheet->getCell("AX8")->getCalculatedValue())) == "SKU SIZE 19") ? $worksheet->getCell("AX$row")->getCalculatedValue() : "",
							"SIZE_SKU_20" => (trim(strtoupper($worksheet->getCell("AY8")->getCalculatedValue())) == "SKU SIZE 20") ? $worksheet->getCell("AY$row")->getCalculatedValue() : "",
							"SIZE_SKU_21" => (trim(strtoupper($worksheet->getCell("AZ8")->getCalculatedValue())) == "SKU SIZE 21") ? $worksheet->getCell("AZ$row")->getCalculatedValue() : "",
							
							"SIZE_DES_01" => (trim(strtoupper($worksheet->getCell("BA8")->getCalculatedValue())) == "NAME SIZE 1") ? $worksheet->getCell("BA$row")->getCalculatedValue() : "",
							"SIZE_DES_02" => (trim(strtoupper($worksheet->getCell("BB8")->getCalculatedValue())) == "NAME SIZE 2") ? $worksheet->getCell("BB$row")->getCalculatedValue() : "",
							"SIZE_DES_03" => (trim(strtoupper($worksheet->getCell("BC8")->getCalculatedValue())) == "NAME SIZE 3") ? $worksheet->getCell("BC$row")->getCalculatedValue() : "",
							"SIZE_DES_04" => (trim(strtoupper($worksheet->getCell("BD8")->getCalculatedValue())) == "NAME SIZE 4") ? $worksheet->getCell("BD$row")->getCalculatedValue() : "",
							"SIZE_DES_05" => (trim(strtoupper($worksheet->getCell("BE8")->getCalculatedValue())) == "NAME SIZE 5") ? $worksheet->getCell("BE$row")->getCalculatedValue() : "",
							"SIZE_DES_06" => (trim(strtoupper($worksheet->getCell("BF8")->getCalculatedValue())) == "NAME SIZE 6") ? $worksheet->getCell("BF$row")->getCalculatedValue() : "",
							"SIZE_DES_07" => (trim(strtoupper($worksheet->getCell("BG8")->getCalculatedValue())) == "NAME SIZE 7") ? $worksheet->getCell("BG$row")->getCalculatedValue() : "",
							"SIZE_DES_08" => (trim(strtoupper($worksheet->getCell("BH8")->getCalculatedValue())) == "NAME SIZE 8") ? $worksheet->getCell("BH$row")->getCalculatedValue() : "",
							"SIZE_DES_09" => (trim(strtoupper($worksheet->getCell("BI8")->getCalculatedValue())) == "NAME SIZE 9") ? $worksheet->getCell("BI$row")->getCalculatedValue() : "",
							"SIZE_DES_10" => (trim(strtoupper($worksheet->getCell("BJ8")->getCalculatedValue())) == "NAME SIZE 10") ? $worksheet->getCell("BJ$row")->getCalculatedValue() : "",
							"SIZE_DES_11" => (trim(strtoupper($worksheet->getCell("BK8")->getCalculatedValue())) == "NAME SIZE 11") ? $worksheet->getCell("BK$row")->getCalculatedValue() : "",
							"SIZE_DES_12" => (trim(strtoupper($worksheet->getCell("BL8")->getCalculatedValue())) == "NAME SIZE 12") ? $worksheet->getCell("BL$row")->getCalculatedValue() : "",
							"SIZE_DES_13" => (trim(strtoupper($worksheet->getCell("BM8")->getCalculatedValue())) == "NAME SIZE 13") ? $worksheet->getCell("BM$row")->getCalculatedValue() : "",
							"SIZE_DES_14" => (trim(strtoupper($worksheet->getCell("BN8")->getCalculatedValue())) == "NAME SIZE 14") ? $worksheet->getCell("BN$row")->getCalculatedValue() : "",
							"SIZE_DES_15" => (trim(strtoupper($worksheet->getCell("BO8")->getCalculatedValue())) == "NAME SIZE 15") ? $worksheet->getCell("BO$row")->getCalculatedValue() : "",
							"SIZE_DES_16" => (trim(strtoupper($worksheet->getCell("BP8")->getCalculatedValue())) == "NAME SIZE 16") ? $worksheet->getCell("BP$row")->getCalculatedValue() : "",
							"SIZE_DES_17" => (trim(strtoupper($worksheet->getCell("BQ8")->getCalculatedValue())) == "NAME SIZE 17") ? $worksheet->getCell("BQ$row")->getCalculatedValue() : "",
							"SIZE_DES_18" => (trim(strtoupper($worksheet->getCell("BR8")->getCalculatedValue())) == "NAME SIZE 18") ? $worksheet->getCell("BR$row")->getCalculatedValue() : "",
							"SIZE_DES_19" => (trim(strtoupper($worksheet->getCell("BS8")->getCalculatedValue())) == "NAME SIZE 19") ? $worksheet->getCell("BS$row")->getCalculatedValue() : "",
							"SIZE_DES_20" => (trim(strtoupper($worksheet->getCell("BT8")->getCalculatedValue())) == "NAME SIZE 20") ? $worksheet->getCell("BT$row")->getCalculatedValue() : "",
							"SIZE_DES_21" => (trim(strtoupper($worksheet->getCell("BU8")->getCalculatedValue())) == "NAME SIZE 21") ? $worksheet->getCell("BU$row")->getCalculatedValue() : "",
							
							"N_CURVES_CTN" => round((trim(strtoupper($worksheet->getCell("AB7")->getCalculatedValue())) == "#CURVES/CTN") ? \LibraryHelper::convertNumber($worksheet->getCell("AB$row")->getCalculatedValue()) : \LibraryHelper::convertNumber($worksheet->getCell("BV$row")->getCalculatedValue()), 4),
							"PCS_SETS_PER_CTN" => round((trim(strtoupper($worksheet->getCell("AC7")->getCalculatedValue())) == "PCS/SETS PER CTN") ? $worksheet->getCell("AC$row")->getCalculatedValue() : $worksheet->getCell("BW$row")->getCalculatedValue(), 4),
							"N_CARTONS" => round((trim(strtoupper($worksheet->getCell("AD7")->getCalculatedValue())) == "# CARTONS") ? intval($worksheet->getCell("AD$row")->getCalculatedValue()) : intval($worksheet->getCell("BX$row")->getCalculatedValue()), 4),
							"TOTAL_PCS_SETS" => round((trim(strtoupper($worksheet->getCell("AE7")->getCalculatedValue())) == "TOTAL PCS/SETS") ? $worksheet->getCell("AE$row")->getCalculatedValue() : $worksheet->getCell("BY$row")->getCalculatedValue(), 4),
							"UNIT_COST" => round((trim(strtoupper($worksheet->getCell("AF7")->getCalculatedValue())) == "UNIT COST (ORIGEN CURRENCY)") ? $worksheet->getCell("AF$row")->getCalculatedValue() : $worksheet->getCell("BZ$row")->getCalculatedValue(), 4),
							"SUB_TOTAL_AMOUNT" => round((trim(strtoupper($worksheet->getCell("AG7")->getCalculatedValue())) == "SUBTOTAL AMOUNT") ? $worksheet->getCell("AG$row")->getCalculatedValue() : $worksheet->getCell("CA$row")->getCalculatedValue(), 4),
							"GW_PER_CTN" => round((trim(strtoupper($worksheet->getCell("AH7")->getCalculatedValue())) == "G.W PER CTN (KGS)") ? $worksheet->getCell("AH$row")->getCalculatedValue() : $worksheet->getCell("CB$row")->getCalculatedValue(), 4),
							"SUB_GW" => round((trim(strtoupper($worksheet->getCell("AI7")->getCalculatedValue())) == "SUB G.W. (KGS)") ? $worksheet->getCell("AI$row")->getCalculatedValue() : $worksheet->getCell("CCF$row")->getCalculatedValue(), 4),
							"NW_PER_CTN" => round((trim(strtoupper($worksheet->getCell("AJ7")->getCalculatedValue())) == "N.W PER CTN (KGS)") ? $worksheet->getCell("AJ$row")->getCalculatedValue() : $worksheet->getCell("CD$row")->getCalculatedValue(), 4),
							"SUB_NEW" => round((trim(strtoupper($worksheet->getCell("AK7")->getCalculatedValue())) == "SUB N.W. (KGS)") ? $worksheet->getCell("AK$row")->getCalculatedValue() : $worksheet->getCell("CE$row")->getCalculatedValue(), 4),
							"MEASUREMENT_PER_CTN" => (trim(strtoupper($worksheet->getCell("AL7")->getCalculatedValue())) == "MEASUREMENT PER CTN (CBM)") ? $worksheet->getCell("AL$row")->getCalculatedValue() : $worksheet->getCell("CF$row")->getCalculatedValue(),
							"SUB_VOLUME" => round((trim(strtoupper($worksheet->getCell("AM7")->getCalculatedValue())) == "SUB VOLUME (CBM)") ? $worksheet->getCell("AM$row")->getCalculatedValue() : $worksheet->getCell("CG$row")->getCalculatedValue(), 4),
							
							"FORMATO"=>(trim(strtoupper($worksheet->getCell("AF8")->getCalculatedValue())) == "SKU SIZE 1") ? 1 : 0
						);
					}
					$xml = new SimpleXMLElement("<filas />");
					\LibraryHelper::array_to_xml($filas, $xml, "fila");
					$clob = $xml->asXML();
					// Para guardar el XML (debug)
					//header("Content-type: text/xml");
					//header("Content-Disposition: attachment; filename=\"$pl_id.xml\"");
					//echo $clob;
					//exit();
					// Fin para guardar el XML (debug)
					$data = \proveedor\proveedor::guardarPL($pl_id, $clob);
					
					if ($data["code"] != 0) {
						unlink($key);
						$msj = "An error occurred while processing the file: <br>" . $data["message"] . "<br>Please check the log:<br>";
						$data = \proveedor\proveedor::erroresPL($pl_id);
						$lista = "<ul>";
						foreach ($data as $datum) {
							$lista .= "<li>" . $datum[0] . "</li>";
						}
						$lista .= "</ul>";
						$msj .= $lista;
						$f3->set('SESSION.error', $msj);
						$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
					}
					
					\proveedor\proveedor::crearDetalleLPN($cod_proveedor, $invoiceNumber);
					
				} catch (Exception $e) {
					$msj = $e->getMessage();
					$f3->set('SESSION.error', "An error occurred while processing the file: $msj ($etapa - $pl_id)");
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
			$etapa = "setFacturaAprobada";
			try {
				\proveedor\proveedor::setFacturaAprobada($cod_proveedor, $nro_factura);
			} catch (Exception $e) {
				$msj = $e->getMessage();
				$f3->set('SESSION.error', "An error occurred while processing the file: $msj ($etapa)");
				$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
			}
			$f3->set('SESSION.success', "Invoice approved correctly.");
			$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
		}

        public function resumen_estilos($f3){

            ControlFormularioMain::cargaMain($f3);
            $f3->set('nombre_form', 'Resumen Estilos');
            $f3->set('temporada_form', $f3->get('SESSION.COD_TEMPORADA'));
            $f3->set('contenido', 'formulario/main/resumen_estilos.html');
            echo Template::instance()->render('layout_resumen_estilos.php');

        }

        public function encabezado_detalle_pi($f3){

            ControlFormularioMain::cargaMain($f3);
            $f3->set('nombre_form', 'Encabezado Detalle PI');
            $f3->set('temporada_form', $f3->get('SESSION.COD_TEMPORADA'));
            $f3->set('contenido', 'formulario/main/encabezado_detalle_pi.html');
            echo Template::instance()->render('layout_encabezado_detalle_pi.php');

        }



	}