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
	//$headers = array("Cod Dpto", "Dpto", "Marca", "Codigo Marca", "Season", "Linea", "Cod Linea", "Sublinea", "Cod Sublinea", "Codigo corporativo", "Nombre Estilo", "Estilo Corto", "Descripcion Estilo", "Cod Opcion", "Color", "Cod Color", "Evento", "Grupo de compra", "Ventana Debut", "Tipo exhibicion", "Tipo Producto", "Debut o Reorder", "Temporada", "Precio", "Ranking de venta", "Ciclo de Vida", "Piramide Mix", "Ratio compra", "Factor amplificacion", "Ratio compra final", "Cluster", "Formato", "Compra Unidades Assortment", "Compra Unidades final", "Var%", "Target USD", "RFID USD", "Via", "Pais", "Factor", "Costo Total", "Retail Total sin iva", "MUP Compra", "Exhibicion", "Talla1", "Talla2", "Talla3", "Talla4", "Talla5", "Talla6", "Talla7", "Talla8", "Talla9", "Inner", "Curva1", "Curva2", "Curva3", "Curva4", "Curva5", "Curva6", "Curva7", "Curva8", "Curva9", "Validador Masterpack/Inner", "Tipo de empaque", "N curvas por caja curvadas", "1_%", "2_%", "3_%", "4_%", "5_%", "6_%", "7_%", "8_%", "9_%", "TiendasA", "TiendasB", "TiendasC", "TiendasI", "ClusterA", "ClusterB", "ClusterC", "ClusterI", "Size%1", "Size%2", "Size%3", "Size%4", "Size%5", "Size%6", "Size%7", "Size%8", "Size%9", "VentA", "VentB", "VentC", "VentD", "VentE", "VentF", "VentG", "VentH", "VentI", "Total_ex", "Curvado_ex", "Solido_ex", "Tallas_1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Cant Curvas_ex", "Curva de Tallas_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Inner_ex", "Nº curvas x caja_ex", "Cajas_ex", "Unidades por caja_ex", "Master Pack_ex", "% Ocup_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex", "Tallas 1_ex", "Tallas 2_ex", "Tallas 3_ex", "Tallas 4_ex", "Tallas 5_ex", "Tallas 6_ex", "Tallas 7_ex");
	$headers = \simulador_compra\plan_compra::get_columnas_archivos(1);

	unset($headers["s"]);
	foreach ($headers as $h) {
        if ($h["COLUMNAS"] != "s") {
            $c = \LibraryHelper::getColumnNameFromNumber($col);
            $objPHPExcel->getActiveSheet()->SetCellValue($c . "3", $h["COLUMNAS"]);
            $col++;
        }
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
	//$objPHPExcel->getActiveSheet()->getStyle("CY3:ER3")->applyFromArray($estiloVerde);

	// Se genera la consulta
	$row = 4;
	$assortment = simulador_compra\plan_compra::Export_asorment($cod_temporada, $reemplazo3);

	foreach ($assortment as $item) {
		$objPHPExcel->getActiveSheet()->SetCellValue("B$row", $item["DEP_DEPTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("C$row", $item["DPTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("D$row", $item["MARCA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("E$row", $item["CODIGO_MARCA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("F$row", $item["SEASON"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["LINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("H$row", $item["COD_LINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("I$row", $item["SUBLINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("J$row", $item["COD_SUBLINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("K$row", $item["CODIGO_CORPORATIVO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("L$row", $item["NOMBRE_ESTILO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("M$row", $item["ESTILO_CORTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("N$row", $item["DESCRIPCION_ESTILO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("O$row", $item["COD_OPCION"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("P$row", $item["COLOR"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Q$row", $item["COD_COLOR"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("R$row", $item["EVENTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("S$row", $item["GRUPO_DE_COMPRA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("T$row", $item["VENTANA_DEBUT"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("U$row", $item["TIPO_EXHIBICION"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("V$row", $item["TIPO_PRODUCTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("W$row", $item["DEBUT_O_REORDER"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("X$row", $item["TEMPORADA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Y$row", $item["PRECIO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Z$row", $item["RANKING_DE_VENTA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AA$row", $item["CICLO_DE_VIDA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AB$row", $item["PIRAMIDE_MIX"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AC$row", \LibraryHelper::convertNumber($item["RATIO_COMPRA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AD$row", \LibraryHelper::convertNumber($item["FACTOR_AMPLIFICACION"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AE$row", \LibraryHelper::convertNumber($item["RATIO_COMPRA_FINAL"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AF$row", $item["CLUSTER_"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AG$row", $item["FORMATO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AH$row", \LibraryHelper::convertNumber($item["COMPRA_UNIDADES_ASSORTMENT"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AI$row", \LibraryHelper::convertNumber($item["COMPRA_UNIDADES_FINAL"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AJ$row", \LibraryHelper::convertNumber($item["VAR_PORCE"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AK$row", \LibraryHelper::convertNumber($item["TARGET_USD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AL$row", \LibraryHelper::convertNumber($item["RFID_USD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AM$row", $item["VIA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AN$row", $item["PAIS"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AO$row", \LibraryHelper::convertNumber($item["FACTOR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AP$row", \LibraryHelper::convertNumber($item["COSTO_TOTAL"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AQ$row", \LibraryHelper::convertNumber($item["RETAIL_TOTAL_SIN_IVA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AR$row", \LibraryHelper::convertNumber($item["MUP_COMPRA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AS$row", \LibraryHelper::convertNumber($item["EXHIBICION"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AT$row", $item["TALLA1"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AU$row", $item["TALLA2"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AV$row", $item["TALLA3"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AW$row", $item["TALLA4"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AX$row", $item["TALLA5"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AY$row", $item["TALLA6"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AZ$row", $item["TALLA7"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BA$row", $item["TALLA8"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BB$row", $item["TALLA9"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BC$row", \LibraryHelper::convertNumber($item["INNER"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BD$row", \LibraryHelper::convertNumber($item["CURVA1"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BE$row", \LibraryHelper::convertNumber($item["CURVA2"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BF$row", \LibraryHelper::convertNumber($item["CURVA3"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BG$row", \LibraryHelper::convertNumber($item["CURVA4"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BH$row", \LibraryHelper::convertNumber($item["CURVA5"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BI$row", \LibraryHelper::convertNumber($item["CURVA6"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BJ$row", \LibraryHelper::convertNumber($item["CURVA7"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BK$row", \LibraryHelper::convertNumber($item["CURVA8"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BL$row", \LibraryHelper::convertNumber($item["CURVA9"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BM$row", $item["VALIDADOR_MASTERPACK_INNER"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BN$row", $item["TIPO_DE_EMPAQUE"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BO$row", \LibraryHelper::convertNumber($item["N_CURVAS_POR_CAJA_CURVADAS"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BP$row", \LibraryHelper::convertNumber($item["UNO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BQ$row", \LibraryHelper::convertNumber($item["DOS_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BR$row", \LibraryHelper::convertNumber($item["TRES_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BS$row", \LibraryHelper::convertNumber($item["CUATRO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BT$row", \LibraryHelper::convertNumber($item["CINCO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BU$row", \LibraryHelper::convertNumber($item["SEIS_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BV$row", \LibraryHelper::convertNumber($item["SIETE_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BW$row", \LibraryHelper::convertNumber($item["OCHO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BX$row", \LibraryHelper::convertNumber($item["NUEVE_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BY$row", \LibraryHelper::convertNumber($item["TIENDASA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BZ$row", \LibraryHelper::convertNumber($item["TIENDASB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CA$row", \LibraryHelper::convertNumber($item["TIENDASC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CB$row", \LibraryHelper::convertNumber($item["TIENDASI"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CC$row", \LibraryHelper::convertNumber($item["CLUSTERA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CD$row", \LibraryHelper::convertNumber($item["CLUSTERB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CE$row", \LibraryHelper::convertNumber($item["CLUSTERC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CF$row", \LibraryHelper::convertNumber($item["CLUSTERI"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CG$row", \LibraryHelper::convertNumber($item["SIZE_1"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CH$row", \LibraryHelper::convertNumber($item["SIZE_2"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CI$row", \LibraryHelper::convertNumber($item["SIZE_3"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CJ$row", \LibraryHelper::convertNumber($item["SIZE_4"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CK$row", \LibraryHelper::convertNumber($item["SIZE_5"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CL$row", \LibraryHelper::convertNumber($item["SIZE_6"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CM$row", \LibraryHelper::convertNumber($item["SIZE_7"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CN$row", \LibraryHelper::convertNumber($item["SIZE_8"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CO$row", \LibraryHelper::convertNumber($item["SIZE_9"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CP$row", \LibraryHelper::convertNumber($item["VENTA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CQ$row", \LibraryHelper::convertNumber($item["VENTB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CR$row", \LibraryHelper::convertNumber($item["VENTC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CS$row", \LibraryHelper::convertNumber($item["VENTD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CT$row", \LibraryHelper::convertNumber($item["VENTE"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CU$row", \LibraryHelper::convertNumber($item["VENTF"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CV$row", \LibraryHelper::convertNumber($item["VENTG"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CW$row", \LibraryHelper::convertNumber($item["VENTH"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CX$row", \LibraryHelper::convertNumber($item["VENTI"]));
		/*$objPHPExcel->getActiveSheet()->SetCellValue("CY$row", $item["Total_ex"]);
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
		$objPHPExcel->getActiveSheet()->SetCellValue("ER$row", $item["Tallas 7_ex"]);*/
		$objPHPExcel->getActiveSheet()->getStyle("B$row:CX$row")->applyFromArray($estiloCelda);
		$row++;
	}
	// Escribe el archivo Excel
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=C1_Assortment.xlsx");
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');