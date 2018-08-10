<?php
/**
 * Usuario: EDUARDO PACHECO
 * Fecha: 10-07-2018
 * Hora: 10:57
 */
require_once '../PHPExcel/PHPExcel.php';
$depto = $f3->get('SESSION.COD_DEPTO');
$Tempo = $f3->get('SESSION.COD_TEMPORADA');

/*data*/
$data = simulador_compra\plan_compra::ExportBMT($Tempo,$depto,$grupo_compra);
$count = count($data)+14;
$objPHPExcel = new PHPExcel();
$hoy = date("Y-m-d H:i:s");

#region {*************Cabesera*************}
/*CABESERA 12*/
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('AI12:DE12')
->mergeCells('DF12:GA12')
->mergeCells('A1:GA1')
->mergeCells('A2:GA2')
->mergeCells('A3:GA3')
->mergeCells('A11:GA11')
->setCellValue('A11','!NOTA: El campo |ID C1| es el código sistema C1 y se utiliza para importar BMT. Por favor mantener ese código por cada Opción.')
->setCellValue('AI12','  CHILE')
->setCellValue('DF12','  PERU');

/*CABESERA 13*/
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('AI13:AJ13')
->mergeCells('AK13:AQ13')
->mergeCells('AR13:AW13')
->mergeCells('AX13:BB13')
->mergeCells('BC13:BL13')
->mergeCells('BM13:CR13')
->mergeCells('CS13:CW13')
->mergeCells('CX13:CZ13')
->mergeCells('DA13:DE13')
->mergeCells('DF13:DG13')
->mergeCells('DH13:DM13')
->mergeCells('DN13:DS13')
->mergeCells('DT13:DX13')
->mergeCells('DY13:EH13')
->mergeCells('EI13:FN13')
->mergeCells('FO13:FR13')
->mergeCells('FS13:FU13')
->mergeCells('FV13:GA13')

->setCellValue('AK13','HIERARCHI')
->setCellValue('AX13','PRICE')
->setCellValue('BC13','DELIVERY')
->setCellValue('BM13','SIZE BREAK DOWN AND SIZE RATIO')
->setCellValue('CS13','PACKING')
->setCellValue('CX13','REDORDER')
->setCellValue('DA13','OTHERS')
->setCellValue('DH13','HIERARCHI')
->setCellValue('DT13','PRICE')
->setCellValue('DY13','DELIVERY')
->setCellValue('EI13','SIZE BREAK DOWN AND SIZE RATIO')
->setCellValue('FP13','PACKING')
->setCellValue('FS13','REDORDER')
->setCellValue('FV13','OTHERS');

/*CABESERA 14*/
$LetraExcelCabecera = array("A14","B14","C14","D14","E14","F14","G14","H14","I14","J14","K14","L14","M14","N14","O14","P14","Q14","R14","S14","T14","U14","V14","W14","X14","Y14","Z14","AA14"	,"AB14"	,"AC14"	,"AD14"	,"AE14"	,"AF14"	,"AG14"	,"AH14"	,"AI14"	,"AJ14"	,"AK14"	,"AL14"	,"AM14"	,"AN14"	,"AO14"	,"AP14"	,"AQ14"	,"AR14"	,"AS14"	,"AT14"	,"AU14"	,"AV14"	,"AW14"	,"AX14"	,"AY14"	,"AZ14","BA14"	,"BB14"	,"BC14"	,"BD14"	,"BE14"	,"BF14"	,"BG14"	,"BH14"	,"BI14"	,"BJ14"	,"BK14"	,"BL14"	,"BM14"	,"BN14"	,"BO14"	,"BP14"	,"BQ14"	,"BR14"	,"BS14"	,"BT14"	,"BU14"	,"BV14"	,"BW14"	,"BX14"	,"BY14"	,"BZ14","CA14"	,"CB14"	,"CC14"	,"CD14"	,"CE14"	,"CF14"	,"CG14"	,"CH14"	,"CI14"	,"CJ14"	,"CK14"	,"CL14"	,"CM14"	,"CN14"	,"CO14"	,"CP14"	,"CQ14"	,"CR14"	,"CS14"	,"CT14"	,"CU14"	,"CV14"	,"CW14"	,"CX14"	,"CY14"	,"CZ14","DA14"	,"DB14"	,"DC14"	,"DD14"	,"DE14"	,"DF14"	,"DG14"	,"DH14"	,"DI14"	,"DJ14"	,"DK14"	,"DL14"	,"DM14"	,"DN14"	,"DO14"	,"DP14"	,"DQ14"	,"DR14"	,"DS14"	,"DT14"	,"DU14"	,"DV14"	,"DW14"	,"DX14"	,"DY14"	,"DZ14","EA14"	,"EB14"	,"EC14"	,"ED14"	,"EE14"	,"EF14"	,"EG14"	,"EH14"	,"EI14"	,"EJ14"	,"EK14"	,"EL14"	,"EM14"	,"EN14"	,"EO14"	,"EP14"	,"EQ14"	,"ER14"	,"ES14"	,"ET14"	,"EU14"	,"EV14"	,"EW14"	,"EX14"	,"EY14"	,"EZ14","FA14"	,"FB14"	,"FC14"	,"FD14"	,"FE14"	,"FF14"	,"FG14"	,"FH14"	,"FI14"	,"FJ14"	,"FK14"	,"FL14"	,"FM14"	,"FN14"	,"FO14"	,"FP14"	,"FQ14"	,"FR14"	,"FS14"	,"FT14"	,"FU14"	,"FV14"	,"FW14"	,"FX14"	,"FY14"	,"FZ14","GA14");
$CabeceraBMT = simulador_compra\plan_compra::get_columnas_archivos(2);
$_key=1;
foreach ($LetraExcelCabecera as $letra) {$_key2=1;
    foreach ($CabeceraBMT as $Nomcabecera){
        if ($_key2 == $_key){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($letra,$Nomcabecera['COLUMNAS']);
            break;
        }$_key2++;
    } $_key++;
}

/*fijamos la cabecera*/
$objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,15);

/*style*/
$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
$style2 = array(
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 9,
        'name'  => 'Calibri'
));
$borders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array('rgb' => 'FFFFFF'),
        )
    ),
);

$objPHPExcel->getActiveSheet()->getStyle('AI12:DE12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1f497d');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('DF12:GA12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff0000');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('AI12:GA12')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('AI12:GA12')->applyFromArray($style2);
$objPHPExcel->getActiveSheet()->getStyle('AI12:GA12')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A12:AH12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('0,0,0');//brangraund

$objPHPExcel->getActiveSheet()->getStyle('AI13:DE13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1f497d');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('DF13:GA13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff0000');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('AI13:GA13')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('AI13:GA13')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('AI13:GA13')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A13:AH13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('0,0,0');//brangraund

$objPHPExcel->getActiveSheet()->getStyle('A14:GA14')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('A14:GA14')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A14:GA14')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('963634');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('CU14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('963634');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('B14:AH14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('0,0,0');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('AI14:CT14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1f497d');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('CV14:DE14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('1f497d');//brangraund
$objPHPExcel->getActiveSheet()->getStyle('DF14:GA14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff0000');//brangraund

$objPHPExcel->getActiveSheet()->getRowDimension(14)->setRowHeight(32);//height
/*Ajustamos la dimensiones de las celdas*/
$var_orden = "A+B+C+D+E+F+G+H+I+J+K+L+M+N+O+P+Q+R+S+T+U+V+W+X+Y+Z+AA+AB+AC+AD+AE+AF+AG+AH+AI+AJ+AK+AL+AM+AN+AO+AP+AQ+AR+AS+AT+AU+AV+AW+AX+AY+AZ+BA+BB+BC+BD+BE+BF+BG+BH+BI+BJ+BK+BL+BM+BN+BO+BP+BQ+BR+BS+BT+BU+BV+BW+BX+BY+BZ+CA+CB+CC+CD+CE+CF+CG+CH+CI+CJ+CK+CL+CM+CN+CO+CP+CQ+CR+CS+CT+CU+CV+CW+CX+CY+CZ+DA+DB+DC+DD+DE+DF+DG+DH+DI+DJ+DK+DL+DM+DN+DO+DP+DQ+DR+DS+DT+DU+DV+DW+DX+DY+DZ+FA+FB+FC+FD+FE+FF+FG+FH+FI+FJ+FK+FL+FM+FN+FO+FP+FQ+FR+FS+FT+FU+FV+FW+FX+FY+FZ+GA";
$array_orden =explode("+", $var_orden);
foreach ($array_orden as $columna_letra){
    $objPHPExcel->getActiveSheet()->getColumnDimension($columna_letra)->setAutoSize(true);
}
#endregion;

#region {*************Cuerpo*************}

/*Imprime los datos*/
$objPHPExcel->getActiveSheet()->fromArray($data, null, 'A15');

$objPHPExcel->getActiveSheet()->getStyle("BO15:CC".($count))
    ->getNumberFormat()->applyFromArray(
        array(
            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
        )
    );
/*font*/
$styleArray3 = array(
    'font'  => array(
        'size'  => 9,
        'name'  => 'Calibri'
    ));
$objPHPExcel->getActiveSheet()->getStyle('A1:GA1'.$count)->applyFromArray($styleArray3);
$objPHPExcel->getActiveSheet()->getStyle('A15:GA'.$count)->applyFromArray($styleArray3);
$objPHPExcel->getActiveSheet()->getStyle('A15:GA'.$count)->applyFromArray($style);

/*Colores datos*/
$objPHPExcel->getActiveSheet()->getStyle('A15:A'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D7D6D8');
$_Azul = array("B15:G","I15:K","L15:Y","AA15:AC","AF15:AF","AH15:AH","AJ15:AJ","AL15:AL","AP15:AP","AT15:AT","AW15:AW","BM15:BM","DG15:DG","DI15:DI","DP15:DP","DS15:DS","EI15:EI");
foreach ($_Azul as $rango){
    $objPHPExcel->getActiveSheet()->getStyle($rango.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('B8CCE4');
}
$_Verde_Claro = array("AI15:AI","AQ15:AS","AU15:AV","AX15:BL","BN15:CS","CV15:CV","CX15:DF","DN15:DO","DQ15:DR","DT15:EG","EJ15:FO","FQ15:FQ","FS15:GA");
foreach ($_Verde_Claro as $rango){
    $objPHPExcel->getActiveSheet()->getStyle($rango.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('C4D79B');
}
$_Blanco = array("H15:H","L15:L","Z15:Z","AD15:AE","AG15:AG","AK15:AK","AM15:AN","CT15:CU","CW15:CW","DH15:DH","DJ15:DK","DM15:DM","EH15:EH","FP15:FP","FR15:FR");
foreach ($_Blanco as $rango){
    $objPHPExcel->getActiveSheet()->getStyle($rango.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');
}

$objPHPExcel->getActiveSheet()->getStyle('AO15:AO'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FF0000');//ROJO
$objPHPExcel->getActiveSheet()->getStyle('DL15:DL'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FF0000');//ROJO
$objPHPExcel->getActiveSheet()->getStyle('H15:H'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('92D050');//VERD
$objPHPExcel->getActiveSheet()->getStyle('A1:GX11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');//BLANCO
$objPHPExcel->getActiveSheet()->getStyle('GB1:GX'.$count)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');//BLANCO
$objPHPExcel->getActiveSheet()->getStyle('A'.($count+1).':GX'.($count+30))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');//BLANCO

#endregion;

$objPHPExcel->getActiveSheet()
    ->setCellValue('A1','Temporada: '.$nomtempo)
    ->setCellValue('A2','Departamento: '.$depto)
    ->setCellValue('A3','Fecha:  '.$hoy);
$objPHPExcel->getActiveSheet()->setTitle('BMT');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="BMT_'.$nomtempo.'_'.$depto.'.xls"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

