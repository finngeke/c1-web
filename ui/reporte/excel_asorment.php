<?php
	//require_once '../PHPExcel/PHPExcel.php';
	// Obtiene la temporada para la generación de los datos
	$cod_temporada = $f3->get('SESSION.COD_TEMPORADA');
	
	// Variables que se utilizaran para estilo hora fecha y otros
	$hoy = date("YmdHis");
	
	// Crea el objeto Excel PHP
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getActiveSheet()->setTitle("Shopping List");
	
	// Se definien variables para trabajar los estilos
	$estiloRojo = array(
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
			'bold' => true,
			'color' => array('rgb' => 'FFFFFF')
		),
		'fill' => array(
			'type' => 'solid',
			'color' => array('rgb' => 'C00000')
		)
	);
	$estiloPetroleo = array(
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
			'bold' => true,
			'color' => array('rgb' => 'FFFFFF')
		),
		'fill' => array(
			'type' => 'solid',
			'color' => array('rgb' => '215967')
		)
	);
	$estiloMorado = array(
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
		),
		'fill' => array(
			'type' => 'solid',
			'color' => array('rgb' => '9999FF')
		)
	);
	$estiloVerde = array(
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
			'bold' => false
		),
		'fill' => array(
			'type' => 'solid',
			'color' => array('rgb' => '92D050')
		)
	);
	$estiloCelda = array(
		'borders' => array(
			'allborders' => array(
				'style' => 'thin',
				'color' => array('rgb' => '000000')
			)
		)
	);
	
	// Establece la cabecera
	$col = 2;
	$headers = array("Cod Dpto", "Dpto", "Marca", "Codigo Marca", "Season", "Linea", "Cod Linea", "Sublinea", "Cod Sublinea", "Codigo corporativo", "Nombre Estilo", "Estilo Corto", "Descripcion Estilo", "Cod Opcion", "Color", "Cod Color", "Evento", "Grupo de compra", "Ventana Debut", "Tipo exhibicion", "Tipo Producto", "Debut o Reorder", "Temporada", "Precio", "Ranking de venta", "Ciclo de Vida", "Piramide Mix", "Ratio compra", "Factor amplificacion", "Ratio compra final", "Cluster", "Formato", "Compra Unidades Assortment", "Compra Unidades final", "Var%", "Target USD", "RFID USD", "Via", "Pais", "Factor", "Costo Total", "Retail Total sin iva", "MUP Compra", "Exhibicion", "Talla1", "Talla2", "Talla3", "Talla4", "Talla5", "Talla6", "Talla7", "Talla8", "Talla9", "Inner", "Curva1", "Curva2", "Curva3", "Curva4", "Curva5", "Curva6", "Curva7", "Curva8", "Curva9", "Validador Masterpack/Inner", "Tipo de empaque", "N curvas por caja curvadas", "1_%", "2_%", "3_%", "4_%", "5_%", "6_%", "7_%", "8_%", "9_%", "TiendasA", "TiendasB", "TiendasC", "TiendasI", "ClusterA", "ClusterB", "ClusterC", "ClusterI", "Size%1", "Size%2", "Size%3", "Size%4", "Size%5", "Size%6", "Size%7", "Size%8", "Size%9", "VentA", "VentB", "VentC", "VentD", "VentE", "VentF", "VentG", "VentH", "VentI", "Total_ex", "Curvado_ex", "Solido_ex", "Tallas_1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Cant Curvas_ex", "Curva de Tallas_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Inner_ex", "Nº curvas x caja_ex", "Cajas_ex", "Unidades por caja_ex", "Master Pack_ex", "% Ocup_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex");
	foreach ($headers as $h) {
		$c = \LibraryHelper::getColumnNameFromNumber($col);
		$objPHPExcel->getActiveSheet()->SetCellValue($c . "3", $h);
		$col++;
	}
	$objPHPExcel->getActiveSheet()->getStyle("B3:N3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("O3:O3")->applyFromArray($estiloPetroleo);
	$objPHPExcel->getActiveSheet()->getStyle("P3:AG3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("AH3:AJ3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("AK3:AN3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("AO3:AS3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("AT3:BB3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("BC3:BC3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("BD3:BL3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("BM3:BM3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("BN3:BO3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("BP3:CB3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("CC3:CX3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("CY3:ER3")->applyFromArray($estiloVerde);
	
	// Se genera la consulta
	$row = 4;
	$assortment = simulador_compra\plan_compra::Export_asorment($cod_temporada, $reemplazo3);
	foreach ($assortment as $item) {
		$objPHPExcel->getActiveSheet()->SetCellValue("B$row", $item["Cod Dpto"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("C$row", $item["Dpto"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("D$row", $item["Marca"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("E$row", $item["Codigo Marca"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("F$row", $item["Season"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["Linea"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("H$row", $item["Cod Linea"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("I$row", $item["Sublinea"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("J$row", $item["Cod Sublinea"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("K$row", $item["Codigo corporativo"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("L$row", $item["Nombre Estilo"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("M$row", $item["Estilo Corto"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("N$row", $item["Descripcion Estilo"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("O$row", $item["Cod Opcion"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("P$row", $item["Color"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Q$row", $item["Cod Color"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("R$row", $item["Evento"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("S$row", $item["Grupo de compra"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("T$row", $item["Ventana Debut"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("U$row", $item["Tipo exhibicion"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("V$row", $item["Tipo Producto"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("W$row", $item["Debut o Reorder"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("X$row", $item["Temporada"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Y$row", $item["Precio"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Z$row", $item["Ranking de venta"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AA$row", $item["Ciclo de Vida"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AB$row", $item["Piramide Mix"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AC$row", \LibraryHelper::convertNumber($item["Ratio compra"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AD$row", \LibraryHelper::convertNumber($item["Factor amplificacion"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AE$row", \LibraryHelper::convertNumber($item["Ratio compra final"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AF$row", $item["Cluster"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AG$row", $item["Formato"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AH$row", \LibraryHelper::convertNumber($item["Compra Unidades Assortment"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AI$row", \LibraryHelper::convertNumber($item["Compra Unidades final"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AJ$row", \LibraryHelper::convertNumber($item["Var%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AK$row", \LibraryHelper::convertNumber($item["Target USD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AL$row", \LibraryHelper::convertNumber($item["RFID USD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AM$row", $item["Via"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AN$row", $item["Pais"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AO$row", \LibraryHelper::convertNumber($item["Factor"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AP$row", \LibraryHelper::convertNumber($item["Costo Total"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AQ$row", \LibraryHelper::convertNumber($item["Retail Total sin iva"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AR$row", \LibraryHelper::convertNumber($item["MUP Compra"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AS$row", \LibraryHelper::convertNumber($item["Exhibicion"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AT$row", $item["Talla1"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AU$row", $item["Talla2"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AV$row", $item["Talla3"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AW$row", $item["Talla4"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AX$row", $item["Talla5"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AY$row", $item["Talla6"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AZ$row", $item["Talla7"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BA$row", $item["Talla8"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BB$row", $item["Talla9"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BC$row", \LibraryHelper::convertNumber($item["Inner"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BD$row", \LibraryHelper::convertNumber($item["Curva1"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BE$row", \LibraryHelper::convertNumber($item["Curva2"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BF$row", \LibraryHelper::convertNumber($item["Curva3"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BG$row", \LibraryHelper::convertNumber($item["Curva4"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BH$row", \LibraryHelper::convertNumber($item["Curva5"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BI$row", \LibraryHelper::convertNumber($item["Curva6"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BJ$row", \LibraryHelper::convertNumber($item["Curva7"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BK$row", \LibraryHelper::convertNumber($item["Curva8"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BL$row", \LibraryHelper::convertNumber($item["Curva9"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BM$row", $item["Validador Masterpack/Inner"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BN$row", $item["Tipo de empaque"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BO$row", \LibraryHelper::convertNumber($item["N curvas por caja curvadas"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BP$row", \LibraryHelper::convertNumber($item["1_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BQ$row", \LibraryHelper::convertNumber($item["2_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BR$row", \LibraryHelper::convertNumber($item["3_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BS$row", \LibraryHelper::convertNumber($item["4_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BT$row", \LibraryHelper::convertNumber($item["5_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BU$row", \LibraryHelper::convertNumber($item["6_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BV$row", \LibraryHelper::convertNumber($item["7_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BW$row", \LibraryHelper::convertNumber($item["8_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BX$row", \LibraryHelper::convertNumber($item["9_%"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BY$row", \LibraryHelper::convertNumber($item["TiendasA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BZ$row", \LibraryHelper::convertNumber($item["TiendasB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CA$row", \LibraryHelper::convertNumber($item["TiendasC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CB$row", \LibraryHelper::convertNumber($item["TiendasI"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CC$row", \LibraryHelper::convertNumber($item["ClusterA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CD$row", \LibraryHelper::convertNumber($item["ClusterB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CE$row", \LibraryHelper::convertNumber($item["ClusterC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CF$row", \LibraryHelper::convertNumber($item["ClusterI"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CG$row", \LibraryHelper::convertNumber($item["Size%1"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CH$row", \LibraryHelper::convertNumber($item["Size%2"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CI$row", \LibraryHelper::convertNumber($item["Size%3"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CJ$row", \LibraryHelper::convertNumber($item["Size%4"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CK$row", \LibraryHelper::convertNumber($item["Size%5"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CL$row", \LibraryHelper::convertNumber($item["Size%6"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CM$row", \LibraryHelper::convertNumber($item["Size%7"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CN$row", \LibraryHelper::convertNumber($item["Size%8"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CO$row", \LibraryHelper::convertNumber($item["Size%9"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CP$row", \LibraryHelper::convertNumber($item["VentA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CQ$row", \LibraryHelper::convertNumber($item["VentB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CR$row", \LibraryHelper::convertNumber($item["VentC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CS$row", \LibraryHelper::convertNumber($item["VentD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CT$row", \LibraryHelper::convertNumber($item["VentE"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CU$row", \LibraryHelper::convertNumber($item["VentF"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CV$row", \LibraryHelper::convertNumber($item["VentG"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CW$row", \LibraryHelper::convertNumber($item["VentH"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CX$row", \LibraryHelper::convertNumber($item["VentI"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CY$row", $item["Total_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("CZ$row", $item["Curvado_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DA$row", $item["Solido_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DB$row", $item["Tallas_1_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DC$row", $item["Tallas 2_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DD$row", $item["Tallas 3_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DE$row", $item["Tallas 4_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DF$row", $item["Tallas 5_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DG$row", $item["Tallas 6_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DH$row", $item["Tallas 7_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DI$row", $item["Tallas 1_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DJ$row", $item["Tallas 2_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DK$row", $item["Tallas 3_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DL$row", $item["Tallas 4_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DM$row", $item["Tallas 5_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DN$row", $item["Tallas 6_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DO$row", $item["Tallas 7_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DP$row", $item["Cant Curvas_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DQ$row", $item["Curva de Tallas_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DR$row", $item["Tallas 1_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DS$row", $item["Tallas 2_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DT$row", $item["Tallas 3_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DU$row", $item["Tallas 4_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DV$row", $item["Tallas 5_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DW$row", $item["Tallas 6_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DX$row", $item["Tallas 7_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DY$row", $item["Inner_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("DZ$row", $item["Nº curvas x caja_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EA$row", $item["Cajas_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EB$row", $item["Unidades por caja_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EC$row", $item["Master Pack_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("ED$row", $item["% Ocup_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EE$row", $item["Tallas 1_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EF$row", $item["Tallas 2_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EG$row", $item["Tallas 3_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EH$row", $item["Tallas 4_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EI$row", $item["Tallas 5_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EJ$row", $item["Tallas 6_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EK$row", $item["Tallas 7_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EL$row", $item["Tallas 1_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EM$row", $item["Tallas 2_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EN$row", $item["Tallas 3_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EO$row", $item["Tallas 4_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EP$row", $item["Tallas 5_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("EQ$row", $item["Tallas 6_ex"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("ER$row", $item["Tallas 7_ex"]);
		$objPHPExcel->getActiveSheet()->getStyle("B$row:ER$row")->applyFromArray($estiloCelda);
		$row++;
	}
	// Escribe el archivo Excel
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=C1_Assortment.xlsx");
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');