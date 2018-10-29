<?php
require_once '../PHPExcel/PHPExcel.php';

$depto = $f3->get('SESSION.COD_DEPTO');
$Tempo = $f3->get('SESSION.COD_TEMPORADA');

$arreglo_depto = simulador_compra\plan_compra::Exportc1($Tempo, $depto_cadena);
$arreglo_ppto = simulador_compra\plan_compra::Export_c1_presupuestos($Tempo, $depto_cadena);
$count_c1 = count($arreglo_depto);
$count_c1_ppto = count($arreglo_ppto);
$depto_cadena = substr($depto_cadena,0,-1);
$array_depto = explode("," ,$depto_cadena);
$count_depto = count($array_depto)-1;

$objPHPExcel = new PHPExcel();

$hoy = date("Y-m-d H:i:s");
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
$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 12,
        'name'  => 'Verdana'
    ));
$BStyle = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A4:CI4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A5:CI5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A6:CI6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A4:C5')
    ->mergeCells('D4:T5')
    ->mergeCells('U4:X5')
    ->mergeCells('Y4:Z5')
    ->mergeCells('AA4:AF5')
    ->mergeCells('AG4:AK5')
    ->mergeCells('AL4:AN5')
    ->mergeCells('AO4:AT5')
    ->mergeCells('AU4:AX5')
    ->mergeCells('AY4:BA5')
    ->mergeCells('BB4:BI5')
    ->mergeCells('BJ4:BM5')
    ->mergeCells('BN4:BS5')
    ->mergeCells('BT4:BW5')
    ->mergeCells('BX4:CH5')
    ->mergeCells('CI4:CI5')

    ->setCellValue('A4','Descripcion depto')
    ->setCellValue('D4','Descripciòn por Estilo')
    ->setCellValue('U4','Definiciòn de Opcion/Color')
    ->setCellValue('Y4','Definiciones Generales')
    ->setCellValue('AA4','Definiciòn de Tallas')
    ->setCellValue('AG4','Dfeniciòn de Unidades')
    ->setCellValue('AL4','Definiciòn de Tiendas')
    ->setCellValue('AO4','Curva por tipos de Tiendas')
    ->setCellValue('AU4','Definiciòn de Procedencia')
    ->setCellValue('AY4','Precio Blanco CH/.')
    ->setCellValue('BB4','Definiciòn de Costo Uniario')
    ->setCellValue('BJ4','Costo Total')
    ->setCellValue('BN4','Ciclo de vida')
    ->setCellValue('BT4','Definiciòn de Proveedores')
    ->setCellValue('BX4','Gestiòn in Season')
    ->setCellValue('CI4','Estados')

    ->setCellValue('A6','Temporada')
    ->setCellValue('B6','Cod Depto')
    ->setCellValue('C6','Nom Depto')
    ->setCellValue('D6','Grupo Compra')
    ->setCellValue('E6','Temp')
    ->setCellValue('F6','Linea')
    ->setCellValue('G6','Sublinea')
    ->setCellValue('H6','Marca')
    ->setCellValue('I6','Nom Estilo')
    ->setCellValue('J6','Nombre Corto')
    ->setCellValue('K6','Cod Corp')
    ->setCellValue('L6','Descripción')
    ->setCellValue('M6','Desc Internet')
    ->setCellValue('N6','Composición')
    ->setCellValue('O6','Colección')
    ->setCellValue('P6','Evento')
    ->setCellValue('Q6','Estilo de Vida')
    ->setCellValue('R6','Calidad')
    ->setCellValue('S6','Ocasión de Uso')
    ->setCellValue('T6','Pirámide Mix')
    ->setCellValue('U6','Ventana')
    ->setCellValue('V6','Rank Vta')
    ->setCellValue('W6','Life Cycle')
    ->setCellValue('X6','Color')
    ->setCellValue('Y6','Tipo Producto')
    ->setCellValue('Z6','Tipo Exhibición')
    ->setCellValue('AA6','Tallas')
    ->setCellValue('AB6','Tipo Empaque')
    ->setCellValue('AC6','% Compra Ini')
    ->setCellValue('AD6','% Compra Ajustada')
    ->setCellValue('AE6','Curvas de Reparto')
    ->setCellValue('AF6','Curva Min')
    ->setCellValue('AG6','Unid Ini')
    ->setCellValue('AH6','Unid Ajust')
    ->setCellValue('AI6','Unid Final')
    ->setCellValue('AJ6','Mtr Pack')
    ->setCellValue('AK6','N° Cajas')
    ->setCellValue('AL6','Clúster')
    ->setCellValue('AM6','Formato')
    ->setCellValue('AN6','Tdas')
    ->setCellValue('AO6','A')
    ->setCellValue('AP6','B')
    ->setCellValue('AQ6','C')
    ->setCellValue('AR6','I')
    ->setCellValue('AS6','Primera Carga')
    ->setCellValue('AT6','%Tiendas')
    ->setCellValue('AU6','Proced')
    ->setCellValue('AV6','Vía')
    ->setCellValue('AW6','País')
    ->setCellValue('AX6','Viaje')
    ->setCellValue('AY6','Mkup Blanco')
    ->setCellValue('AZ6','Precio Blanco')
    ->setCellValue('BA6','GM Blanco')
    ->setCellValue('BB6','Moneda')
    ->setCellValue('BC6','Target')
    ->setCellValue('BD6','FOB')
    ->setCellValue('BE6','Insp')
    ->setCellValue('BF6','RFID')
    ->setCellValue('BG6','Royalty(%)')
    ->setCellValue('BH6','Costo Unitario Final US$')
    ->setCellValue('BI6','Costo Unitario Final Pesos')
    ->setCellValue('BJ6','Total Target US$')
    ->setCellValue('BK6','Total Fob US$')
    ->setCellValue('BL6','Costo Total Pesos')
    ->setCellValue('BM6','Total Retail Pesos(Sin IVA)')
    ->setCellValue('BN6','Debut/Reorder')
    ->setCellValue('BO6','Sem Ini')
    ->setCellValue('BP6','Sem Fin')
    ->setCellValue('BQ6','Semanas Ciclo de Vida')
    ->setCellValue('BR6','Agot Obj')
    ->setCellValue('BS6','Semanas Liquidación')
    ->setCellValue('BT6','Proveedor')
    ->setCellValue('BU6','Razon Social')
    ->setCellValue('BV6','Trader')
    ->setCellValue('BW6','Cod Sku Proveedor')
    ->setCellValue('BX6','Cod. Padre')
    ->setCellValue('BY6','Proforma')
    ->setCellValue('BZ6','Archivo')
    ->setCellValue('CA6','Estilo PMM')
    ->setCellValue('CB6','Estado Match')
    ->setCellValue('CC6','N° OC')
    ->setCellValue('CD6','Estado OC')
    ->setCellValue('CE6','Fecha Embarque')
    ->setCellValue('CF6','Fecha ETA')
    ->setCellValue('CG6','Fecha Recepción CD')
    ->setCellValue('CH6','Días Atraso CD')
    ->setCellValue('CI6','Estado Opción')
    ->setCellValue('A1','Departamentos:  '.$depto_cadena)
    ->setCellValue('A2','Fecha:  '.$hoy);

$objPHPExcel->getActiveSheet()->getStyle('A4:CI5')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('A6:CI6')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CI5')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CI5')->applyFromArray($styleArray);


$objPHPExcel->getActiveSheet()->setTitle('DEPARTAMENTOS');

$objPHPExcel->getActiveSheet()->fromArray($arreglo_depto, null, 'A7');


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="C1_consolidada_'.$Tempo.'_'.$hoy.'.xls"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');