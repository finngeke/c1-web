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
	$headers = \simulador_compra\PlanCompraClass::ListColumnasArchivos(1);

	unset($headers["s"]);
	foreach ($headers as $h) {
        if ($h["COLUMNAS"] != "s") {
            $c = \LibraryHelper::getColumnNameFromNumber($col);
            $objPHPExcel->getActiveSheet()->SetCellValue($c . "3", $h["COLUMNAS"]);
            $col++;
        }
	}

    //Estilo cabesera
    $ColorRojo= array("B3:Q3","S3:AU3","AY3:BG3","BM3:CE3","CG3:CH3","CV3:DI3");
	foreach ($ColorRojo as $letraR){
        $objPHPExcel->getActiveSheet()->getStyle($letraR)->applyFromArray($estiloRojo);
    }
    $ColorMorado= array("AV3:AX3","BH3:BL3","CF3:CF3","CI3:CU3");
    foreach ($ColorMorado as $letraM){
    $objPHPExcel->getActiveSheet()->getStyle($letraM)->applyFromArray($estiloMorado);
    }
	$objPHPExcel->getActiveSheet()->getStyle("R3:R3")->applyFromArray($estiloPetroleo);



	// Se genera la consulta
	$row = 4;
	$assortment = simulador_compra\PlanCompraClass::ListExportAssortment($cod_temporada, $deptosQuery);

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
        $objPHPExcel->getActiveSheet()->SetCellValue("Q$row", $item["DESCRIP_INTERNET"]);//--------------------------------
		$objPHPExcel->getActiveSheet()->SetCellValue("R$row", $item["COD_OPCION"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("S$row", $item["COLOR"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("T$row", $item["COD_COLOR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("U$row", $item["COMPOSICION"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("V$row", $item["TIPO_DE_TELA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("W$row", $item["FORRO"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("X$row", $item["NOM_CALIDAD"]);//--------------------------------
        $objPHPExcel->getActiveSheet()->SetCellValue("Y$row", $item["COLECCION"]);//--------------------------------
        $objPHPExcel->getActiveSheet()->SetCellValue("Z$row", $item["NOM_ESTILOVIDA"]);//--------------------------------
        $objPHPExcel->getActiveSheet()->SetCellValue("AA$row", $item["NOM_OCACIONUSO"]);//--------------------------------
		$objPHPExcel->getActiveSheet()->SetCellValue("AB$row", $item["EVENTO"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AC$row", $item["EVENTO_INSTORE"]);//--------------------------------
		$objPHPExcel->getActiveSheet()->SetCellValue("AD$row", $item["GRUPO_DE_COMPRA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AE$row", $item["VENTANA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AF$row", $item["TIPO_EXHIBICION"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AG$row", $item["TIPO_PRODUCTO"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AH$row", $item["DEBUT_O_REORDER"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AI$row", $item["TEMPORADA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AJ$row", $item["PRECIO"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AK$row", $item["OFERTA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AL$row", $item["DOSX"]);//--------------------------------
        $objPHPExcel->getActiveSheet()->SetCellValue("AM$row", $item["OPEX"]);//--------------------------------
		$objPHPExcel->getActiveSheet()->SetCellValue("AN$row", $item["RANKING_DE_VENTA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AO$row", $item["CICLO_DE_VIDA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AP$row", $item["PIRAMIDE_MIX"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AQ$row", $item["RATIO_COMPRA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AR$row", $item["FACTOR_AMPLIFICACION"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AS$row", $item["RATIO_COMPRA_FINAL"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AT$row", $item["CLUSTER_"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("AU$row", $item["FORMATO"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AV$row", $item["COMPRA_UNIDADES_ASSORTMENT"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AW$row", $item["COMPRA_UNIDADES_FINAL"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AX$row", $item["VAR_PORCE"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AY$row", $item["TARGET_USD"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("AZ$row", $item["FOB_USD"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BA$row", $item["RFID_USD"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BB$row", $item["COSTO_INSP"]);//--------------------------------
		$objPHPExcel->getActiveSheet()->SetCellValue("BC$row", $item["VIA"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BD$row", $item["PAIS"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BE$row", $item["PROVEEDOR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BF$row", $item["COMENTARIOS_POST_NEGOCIACION"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BG$row", $item["FECHA_EMBARQUE_ACORDADA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BH$row", $item["FACTOR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BI$row", $item["COSTO_TOTAL"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BJ$row", $item["RETAIL_TOTAL_SIN_IVA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BK$row", $item["MUP_COMPRA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BL$row", $item["EXHIBICION"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BM$row", $item["TALLA1"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BN$row", $item["TALLA2"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BO$row", $item["TALLA3"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BP$row", $item["TALLA4"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BQ$row", $item["TALLA5"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BR$row", $item["TALLA6"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BS$row", $item["TALLA7"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BT$row", $item["TALLA8"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("BU$row", $item["TALLA9"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BV$row", $item["INNER"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BW$row", $item["CURVA1"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BX$row", $item["CURVA2"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BY$row", $item["CURVA3"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("BZ$row", $item["CURVA4"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CA$row", $item["CURVA5"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CB$row", $item["CURVA6"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CC$row", $item["CURVA7"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CD$row", $item["CURVA8"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CE$row", $item["CURVA9"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("CF$row", $item["VALIDADOR_MASTERPACK_INNER"]);
		$objPHPExcel->getActiveSheet()->SetCellValue("CG$row", $item["TIPO_DE_EMPAQUE"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CH$row", $item["N_CURVAS_POR_CAJA_CURVADAS"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CI$row", $item["UNO_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CJ$row", $item["DOS_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CK$row", $item["TRES_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CL$row",$item["CUATRO_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CM$row", $item["CINCO_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CN$row", $item["SEIS_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CO$row", $item["SIETE_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CP$row", $item["OCHO_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CQ$row", $item["NUEVE_POR"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CR$row", $item["TIENDASA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CS$row", $item["TIENDASB"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CT$row",  $item["TIENDASC"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CU$row", $item["TIENDASI"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CV$row", $item["CLUSTERA"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CW$row", $item["CLUSTERB"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CX$row", $item["CLUSTERC"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CY$row", $item["CLUSTERI"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("CZ$row", $item["SIZE_1"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DA$row", $item["SIZE_2"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DB$row", $item["SIZE_3"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DC$row", $item["SIZE_4"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DD$row", $item["SIZE_5"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DE$row", $item["SIZE_6"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DF$row", $item["SIZE_7"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DG$row", $item["SIZE_8"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DH$row", $item["SIZE_9"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("DI$row", $item["UNIDADES"]);
		$objPHPExcel->getActiveSheet()->getStyle("B$row:DI$row")->applyFromArray($estiloCelda);
		$row++;
	}
	// Escribe el archivo Excel
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment; filename=C1_Assortment_".$f3->get('SESSION.COD_TEMPORADA').".xlsx");
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('php://output');