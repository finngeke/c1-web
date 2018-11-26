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

	$objPHPExcel->getActiveSheet()->getStyle("B3:P3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("Q3:Q3")->applyFromArray($estiloPetroleo);
	$objPHPExcel->getActiveSheet()->getStyle("R3:AH3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("AI3:AK3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("AL3:AM3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("AN3:AP3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("AQ3:AX3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("AY3:BC3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("BD3:BV3")->applyFromArray($estiloRojo);
	$objPHPExcel->getActiveSheet()->getStyle("BW3:BW3")->applyFromArray($estiloMorado);
	$objPHPExcel->getActiveSheet()->getStyle("BX3:BY3")->applyFromArray($estiloRojo);
    $objPHPExcel->getActiveSheet()->getStyle("BZ3:CL3")->applyFromArray($estiloMorado);
    $objPHPExcel->getActiveSheet()->getStyle("CM3:CZ3")->applyFromArray($estiloRojo);
	//$objPHPExcel->getActiveSheet()->getStyle("CY3:ER3")->applyFromArray($estiloVerde);

	// Se genera la consulta
	$row = 4;
	$assortment = simulador_compra\plan_compra::Export_asorment($cod_temporada, $reemplazo3);

	foreach ($assortment as $item) {
		$objPHPExcel->getActiveSheet()->SetCellValue("B$row", $item["DEP_DEPTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("C$row", $item["DPTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("D$row", $item["MARCA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("E$row", $item["CODIGO_MARCA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("F$row", $item["NOMBRE_COMPRADOR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("G$row", $item["NOMBRE_DISENADOR"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("H$row", $item["SEASON"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("I$row", $item["LINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("J$row", $item["COD_LINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("K$row", $item["SUBLINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("L$row", $item["COD_SUBLINEA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("M$row", $item["CODIGO_CORPORATIVO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("N$row", $item["NOMBRE_ESTILO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("O$row", $item["ESTILO_CORTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("P$row", $item["DESCRIPCION_ESTILO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Q$row", $item["COD_OPCION"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("R$row", $item["COLOR"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("S$row", $item["COD_COLOR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("T$row", $item["COMPOSICION"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("U$row", $item["TIPO_DE_TELA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("V$row", $item["FORRO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("W$row", $item["EVENTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("X$row", $item["GRUPO_DE_COMPRA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Y$row", $item["VENTANA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("Z$row", $item["TIPO_EXHIBICION"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AA$row", $item["TIPO_PRODUCTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AB$row", $item["DEBUT_O_REORDER"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AC$row", $item["TEMPORADA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AD$row", $item["PRECIO"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AE$row", $item["OFERTA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AF$row", $item["RANKING_DE_VENTA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AG$row", $item["CICLO_DE_VIDA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AH$row", $item["PIRAMIDE_MIX"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AI$row", \LibraryHelper::convertNumber($item["RATIO_COMPRA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AJ$row", \LibraryHelper::convertNumber($item["FACTOR_AMPLIFICACION"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AK$row", \LibraryHelper::convertNumber($item["RATIO_COMPRA_FINAL"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AL$row", $item["CLUSTER_"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AM$row", $item["FORMATO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AN$row", \LibraryHelper::convertNumber($item["COMPRA_UNIDADES_ASSORTMENT"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AO$row", \LibraryHelper::convertNumber($item["COMPRA_UNIDADES_FINAL"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AP$row", \LibraryHelper::convertNumber($item["VAR_PORCE"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AQ$row", \LibraryHelper::convertNumber($item["TARGET_USD"]));
        $objPHPExcel->getActiveSheet()->SetCellValue("AR$row", \LibraryHelper::convertNumber($item["FOB_USD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AS$row", \LibraryHelper::convertNumber($item["RFID_USD"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AT$row", $item["VIA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AU$row", $item["PAIS"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AV$row", $item["PROVEEDOR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AW$row", $item["COMENTARIOS_POST_NEGOCIACION"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AX$row", $item["FECHA_EMBARQUE_ACORDADA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AY$row", \LibraryHelper::convertNumber($item["FACTOR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("AZ$row", \LibraryHelper::convertNumber($item["COSTO_TOTAL"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BA$row", \LibraryHelper::convertNumber($item["RETAIL_TOTAL_SIN_IVA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BB$row", \LibraryHelper::convertNumber($item["MUP_COMPRA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BC$row", \LibraryHelper::convertNumber($item["EXHIBICION"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BD$row", $item["TALLA1"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BE$row", $item["TALLA2"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BF$row", $item["TALLA3"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BG$row", $item["TALLA4"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BH$row", $item["TALLA5"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BI$row", $item["TALLA6"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BJ$row", $item["TALLA7"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BK$row", $item["TALLA8"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BL$row", $item["TALLA9"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BM$row", \LibraryHelper::convertNumber($item["INNER"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BN$row", \LibraryHelper::convertNumber($item["CURVA1"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BO$row", \LibraryHelper::convertNumber($item["CURVA2"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BP$row", \LibraryHelper::convertNumber($item["CURVA3"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BQ$row", \LibraryHelper::convertNumber($item["CURVA4"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BR$row", \LibraryHelper::convertNumber($item["CURVA5"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BS$row", \LibraryHelper::convertNumber($item["CURVA6"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BT$row", \LibraryHelper::convertNumber($item["CURVA7"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BU$row", \LibraryHelper::convertNumber($item["CURVA8"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BV$row", \LibraryHelper::convertNumber($item["CURVA9"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BW$row", $item["VALIDADOR_MASTERPACK_INNER"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BX$row", $item["TIPO_DE_EMPAQUE"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BY$row", \LibraryHelper::convertNumber($item["N_CURVAS_POR_CAJA_CURVADAS"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("BZ$row", \LibraryHelper::convertNumber($item["UNO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CA$row", \LibraryHelper::convertNumber($item["DOS_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CB$row", \LibraryHelper::convertNumber($item["TRES_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CC$row", \LibraryHelper::convertNumber($item["CUATRO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CD$row", \LibraryHelper::convertNumber($item["CINCO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CE$row", \LibraryHelper::convertNumber($item["SEIS_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CF$row", \LibraryHelper::convertNumber($item["SIETE_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CG$row", \LibraryHelper::convertNumber($item["OCHO_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CH$row", \LibraryHelper::convertNumber($item["NUEVE_POR"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CI$row", \LibraryHelper::convertNumber($item["TIENDASA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CJ$row", \LibraryHelper::convertNumber($item["TIENDASB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CK$row", \LibraryHelper::convertNumber($item["TIENDASC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CL$row", \LibraryHelper::convertNumber($item["TIENDASI"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CM$row", \LibraryHelper::convertNumber($item["CLUSTERA"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CN$row", \LibraryHelper::convertNumber($item["CLUSTERB"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CO$row", \LibraryHelper::convertNumber($item["CLUSTERC"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CP$row", \LibraryHelper::convertNumber($item["CLUSTERI"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CQ$row", \LibraryHelper::convertNumber($item["SIZE_1"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CR$row", \LibraryHelper::convertNumber($item["SIZE_2"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CS$row", \LibraryHelper::convertNumber($item["SIZE_3"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CT$row", \LibraryHelper::convertNumber($item["SIZE_4"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CU$row", \LibraryHelper::convertNumber($item["SIZE_5"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CV$row", \LibraryHelper::convertNumber($item["SIZE_6"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CW$row", \LibraryHelper::convertNumber($item["SIZE_7"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CX$row", \LibraryHelper::convertNumber($item["SIZE_8"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CY$row", \LibraryHelper::convertNumber($item["SIZE_9"]));
		$objPHPExcel->getActiveSheet()->SetCellValue("CZ$row", \LibraryHelper::convertNumber($item["UNIDADES"]));
		$objPHPExcel->getActiveSheet()->getStyle("B$row:CZ$row")->applyFromArray($estiloCelda);
		$row++;
	}
	// Escribe el archivo Excel
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=C1_Assortment.xlsx");
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');