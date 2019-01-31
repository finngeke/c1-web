<?php
	require_once '../../PHPExcel/PHPExcel.php';
	// Obtiene la temporada para la generación de los datos
	//$cod_temporada = $f3->get('SESSION.COD_TEMPORADA');

    $nroEmbarqueHidden = $_POST['nroEmbarqueHidden'];

	// Variables que se utilizaran para estilo hora fecha y otros
	$hoy = date("YmdHis");

    $distribucion = \reposicion\distribucion::excel_distribucion_mercaderia($nroEmbarqueHidden);

	// Crea el objeto Excel PHP
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle("Distribución de Mercadería");

	$headers = array("TEMPORADA", "COD_DEPTO", "DES_DEPTO", "COD_ESTILO", "DES_ESTILO", "DES_COLOR", "VENTANA", "NOM_MARCA", "EVENTO", "NRO_EMBARQUE", "CURVATALLA", "CURVAS_CAJAS", "LPN_NUMBER", "COD_TDA", "TIPO_EMPAQUE", "UNIDADES");

	// Se genera la consulta
	$row = 4;

	foreach ($distribucion as $item) {
		$objPHPExcel->getActiveSheet()->SetCellValue("B$row", $item["TEMPORADA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("C$row", $item["COD_DEPTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("D$row", $item["DES_DEPTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("E$row", $item["COD_ESTILO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("F$row", $item["DES_ESTILO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["DES_COLOR"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["VENTANA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["NOM_MARCA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["EVENTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["NRO_EMBARQUE"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["CURVATALLA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["CURVAS_CAJAS"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["LPN_NUMBER"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["COD_TDA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["TIPO_EMPAQUE"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["UNIDADES"]);

		// $objPHPExcel->getActiveSheet()->getStyle("B$row:CX$row")->applyFromArray($estiloCelda);
		$row++;
	}
	// Escribe el archivo Excel
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=Distribucion.xlsx");
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');