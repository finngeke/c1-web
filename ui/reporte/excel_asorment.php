<?php
require_once '../PHPExcel/PHPExcel.php';

$Tempo = $f3->get('SESSION.COD_TEMPORADA');
/*Traemos los datos de la clase*/
$arreglo_depto_asorment = simulador_compra\plan_compra::Export_asorment($Tempo, $reemplazo3);

 /*Variables que se utilizaran para estilo hora fecho y otros */
$objPHPExcel = new PHPExcel();
$hoy = date("Y-m-d H:i:s");

/*Se definien variables para trabajar los estilos*/
$borders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        )
    ),
);
$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    )
);
$stylevertical = array(
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 10,
        'name'  => 'Verdana'
    ));
$style_Array_negro = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 10,
        'name'  => 'Verdana'
    ));
$BStyle = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

/*Le damos color a las cabeceras de la hoja de departamentos*/
$objPHPExcel->getActiveSheet()->getStyle('B3:CW3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('C00000');
$objPHPExcel->getActiveSheet()->getStyle('BO2:CA3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9999FF');
$objPHPExcel->getActiveSheet()->getStyle('AG3:AG3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9999FF');
$objPHPExcel->getActiveSheet()->getStyle('AI3:AI3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9999FF');
$objPHPExcel->getActiveSheet()->getStyle('AS2:CW2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9999FF');
$objPHPExcel->getActiveSheet()->getStyle('AN3:AQ3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9999FF');
$objPHPExcel->getActiveSheet()->getStyle('BB3:BB3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9999FF');

/*Se cambia el alto de los titulos (se cambia en px)*/
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(34);

/*Creacion de cabeceras de los departamentos*/
$objPHPExcel->setActiveSheetIndex(0)

    /*Juntar celdas para titulos de arribla, de los titulos de presentacion */
    ->mergeCells('AS2:BA2')
    ->mergeCells('BC2:BK2')
    ->mergeCells('BO2:BW2')
    ->mergeCells('BX2:CA2')
    ->mergeCells('CB2:CE2')
    ->mergeCells('CF2:CN2')

    /*Mandamos a las celdas los titulos superiores*/
    ->setCellValue('AS2','  Tallas  ')
    ->setCellValue('BC2','  Curva de reparto N° Uni  ')
    ->setCellValue('BO2','  Curva de compra %  ')
    ->setCellValue('BX2','  N° Tiendas x cluster  ')
    ->setCellValue('CB2','  N° Curvas x cluster  ')
    ->setCellValue('CF2','  Curva de compra % final  ')

    /*Asignamos los titulos correspondientes a los datos que se mostraran*/
    ->setCellValue('B3',' Cod Dpto ')
    ->setCellValue('C3',' Dpto ')
    ->setCellValue('D3',' Marca ')
    ->setCellValue('E3',' Codigo Marca ')
    ->setCellValue('F3',' Season ')
    ->setCellValue('G3',' Linea ')
    ->setCellValue('H3',' Cod Linea ')
    ->setCellValue('I3',' Sublinea ')
    ->setCellValue('J3',' Cod Sublinea ')
    ->setCellValue('K3',' Codigo corporativo ')
    ->setCellValue('L3',' Nombre Estilo ')
    ->setCellValue('M3',' Estilo Corto ')
    ->setCellValue('N3',' Descripcion Estilo ')
    ->setCellValue('O3',' Color ')
    ->setCellValue('P3',' Cod Color ')
    ->setCellValue('Q3',' Evento ')
    ->setCellValue('R3',' Grupo de compra ')
    ->setCellValue('S3',' Ventana Debut ')
    ->setCellValue('T3',' Tipo exhibicion ')
    ->setCellValue('U3',' Tipo Producto ')
    ->setCellValue('V3',' Debut o Reorder ')
    ->setCellValue('W3',' Temporada ')
    ->setCellValue('X3',' Precio ')
    ->setCellValue('Y3',' Ranking de venta ')
    ->setCellValue('Z3',' Ciclo de Vida ')
    ->setCellValue('AA3',' Piramide Mix ')
    ->setCellValue('AB3',' Ratio compra ')
    ->setCellValue('AC3',' Factor amplificacion ')
    ->setCellValue('AD3',' Ratio compra final ')
    ->setCellValue('AE3',' Cluster ')
    ->setCellValue('AF3',' Formato ')
    ->setCellValue('AG3',' Compra Unidades Assortment ')
    ->setCellValue('AH3',' Compra Unidades final ')
    ->setCellValue('AI3',' Var% ')
    ->setCellValue('AJ3',' Target USD ')
    ->setCellValue('AK3',' RFID USD ')
    ->setCellValue('AL3',' Via ')
    ->setCellValue('AM3',' Pais ')
    ->setCellValue('AN3',' Factor ')
    ->setCellValue('AO3',' Costo Total ')
    ->setCellValue('AP3',' Retail Total sin iva ')
    ->setCellValue('AQ3',' MUP Compra ')
    ->setCellValue('AR3',' Exhibicion ')
    ->setCellValue('AS3',' Talla1 ')
    ->setCellValue('AT3',' Talla2 ')
    ->setCellValue('AU3',' Talla3 ')
    ->setCellValue('AV3',' Talla4 ')
    ->setCellValue('AW3',' Talla5 ')
    ->setCellValue('AX3',' Talla6 ')
    ->setCellValue('AY3',' Talla7 ')
    ->setCellValue('AZ3',' Talla8 ')
    ->setCellValue('BA3',' Talla9 ')
    ->setCellValue('BB3',' Inner ')
    ->setCellValue('BC3',' Curva1 ')
    ->setCellValue('BD3',' Curva2 ')
    ->setCellValue('BE3',' Curva3 ')
    ->setCellValue('BF3',' Curva4 ')
    ->setCellValue('BG3',' Curva5 ')
    ->setCellValue('BH3',' Curva6 ')
    ->setCellValue('BI3',' Curva7 ')
    ->setCellValue('BJ3',' Curva8 ')
    ->setCellValue('BK3',' Curva9 ')
    ->setCellValue('BL3',' Validador Masterpack/Inner ')
    ->setCellValue('BM3',' Tipo de empaque ')
    ->setCellValue('BN3',' N curvas por caja curvadas ')
    ->setCellValue('BO3',' 1_% ')
    ->setCellValue('BP3',' 2_% ')
    ->setCellValue('BQ3',' 3_% ')
    ->setCellValue('BR3',' 4_% ')
    ->setCellValue('BS3',' 5_% ')
    ->setCellValue('BT3',' 6_% ')
    ->setCellValue('BU3',' 7_% ')
    ->setCellValue('BV3',' 8_% ')
    ->setCellValue('BW3',' 9_% ')
    ->setCellValue('BX3',' TiendasA ')
    ->setCellValue('BY3',' TiendasB ')
    ->setCellValue('BZ3',' TiendasC ')
    ->setCellValue('CA3',' TiendasI ')
    ->setCellValue('CB3',' ClusterA ')
    ->setCellValue('CC3',' ClusterB ')
    ->setCellValue('CD3',' ClusterC ')
    ->setCellValue('CE3',' ClusterI ')
    ->setCellValue('CF3',' Size%1 ')
    ->setCellValue('CG3',' Size%2 ')
    ->setCellValue('CH3',' Size%3 ')
    ->setCellValue('CI3',' Size%4 ')
    ->setCellValue('CJ3',' Size%5 ')
    ->setCellValue('CK3',' Size%6 ')
    ->setCellValue('CL3',' Size%7 ')
    ->setCellValue('CM3',' Size%8 ')
    ->setCellValue('CN3',' Size%9 ')
    ->setCellValue('CO3',' VentA ')
    ->setCellValue('CP3',' VentB ')
    ->setCellValue('CQ3',' VentC ')
    ->setCellValue('CR3',' VentD ')
    ->setCellValue('CS3',' VentE ')
    ->setCellValue('CT3',' VentF ')
    ->setCellValue('CU3',' VentG ')
    ->setCellValue('CV3',' VentH ')
    ->setCellValue('CW3',' VentI ');


/*####################fin de la creacion de las cabeceras#################*/

/*congelar cabecera de excel (Titulos)*/
$objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,4);

/*generamos arreglo con letras con el fin de recorrer el excel*/
$var_orden = "B+C+D+E+F+G+H+I+J+K+L+M+N+O+P+Q+R+S+T+U+V+W+X+Y+Z+AA+AB+AC+AD+AE+AF+AG+AH+AI+AJ+AK+AL+AM+AN+AO+AP+AQ+AR+AS+AT+AU+AV+AW+AX+AY+AZ+BA+BB+BC+BD+BE+BF+BG+BH+BI+BJ+BK+BL+BM+BN+BO+BP+BQ+BR+BS+BT+BU+BV+BW+BX+BY+BZ+CA+CB+CC+CD+CE+CF+CG+CH+CI+CJ+CK+CL+CM+CN+CO+CP+CQ+CR+CS+CT+CU+CV+CW";
$array_orden =explode("+", $var_orden);

/*RECORREMOS EL ARREGLO ANTERIOR Y POR CADA LETRA IRA AJUSTANDO AL TEXTO*/
$i = 5 ;
foreach ($array_orden as $columna_letra){

    $objPHPExcel->getActiveSheet()->getStyle($columna_letra.'3')->applyFromArray($BStyle);

    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($columna_letra)
        ->setAutoSize(true);
}


/*genera titulos de la hoja en que se trabaja */
$objPHPExcel->getActiveSheet()->setTitle('Shopping list');

/*imprime el arreglo en excel*/
$objPHPExcel->getActiveSheet()->fromArray($arreglo_depto_asorment, null, 'B4');
/*###########fin de impresion#########*/

/*Obtener la ultima fila con el fin de poner bordes hasta ella*/
$ultima_fila =$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

/*aplican bordes para la hoja de asorment*/
$objPHPExcel->getActiveSheet()->getStyle('AS1:CW1')->applyFromArray($borders);

/*aplicar bordes al arreglo que tiene la informacion */
$objPHPExcel->getActiveSheet()->getStyle('B4:CW'.$ultima_fila)->applyFromArray($borders);

/*Se centran los titulos del excel tanto horizontal como vertical*/
$objPHPExcel->getActiveSheet()->getStyle('B2:CW3')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('B2:CW3')->applyFromArray($stylevertical);

/*se da color y formato a los titulos (cabecera)*/
$objPHPExcel->getActiveSheet()->getStyle('B2:CW3')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B2:CW2')->applyFromArray($style_Array_negro);
$objPHPExcel->getActiveSheet()->getStyle('BO3:CA3')->applyFromArray($style_Array_negro);
$objPHPExcel->getActiveSheet()->getStyle('AN3:AQ3')->applyFromArray($style_Array_negro);
$objPHPExcel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_Array_negro);
$objPHPExcel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_Array_negro);
$objPHPExcel->getActiveSheet()->getStyle('BB3')->applyFromArray($style_Array_negro);

/*Dar formato de solo dos decimales a las distintas celda que requieran*/
$objPHPExcel->getActiveSheet()->getStyle("AQ4:AQ".$ultima_fila)
    ->getNumberFormat()->applyFromArray(
        array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
        )
    );

/*dar formato de texto a la celda cod linea */
$objPHPExcel->getActiveSheet()->getStyle("H4:H".$ultima_fila)
->getNumberFormat()->applyFromArray(
        array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        )
    );

/*Se da formato de tipo texto a las celdas de tallas */
$objPHPExcel->getActiveSheet()->getStyle("AS4:BA".$ultima_fila)
    ->getNumberFormat()->applyFromArray(
        array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT
        )
    );

$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="C1_assortment_'.$Tempo.'_'.$hoy.'.xls"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');