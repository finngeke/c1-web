<?php
require_once '../PHPExcel/PHPExcel.php';

$depto = $f3->get('SESSION.COD_DEPTO');
$Tempo = $f3->get('SESSION.COD_TEMPORADA');


$arreglo_depto = simulador_compra\PlanCompraClass::Exportc1($Tempo, $deptos);

$arreglo_ppto = simulador_compra\PlanCompraClass::Export_c1_presupuestos($Tempo, trim($deptos));
$count_c1 = count($arreglo_depto);
$count_c1_ppto = count($arreglo_ppto);
$array_depto = explode("," ,$deptos);
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

$objPHPExcel->getActiveSheet()->getStyle('A4:CS4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A5:CS5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A6:CS6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A4:C5')
    ->mergeCells('D4:Y5')
    ->mergeCells('Z4:AC5')
    ->mergeCells('AD4:AE5')
    ->mergeCells('AF4:AK5')
    ->mergeCells('AL4:AP5')
    ->mergeCells('AQ4:AS5')
    ->mergeCells('AT4:AY5')
    ->mergeCells('AZ4:BC5')
    ->mergeCells('BD4:BI5')
    ->mergeCells('BJ4:BQ5')
    ->mergeCells('BR4:BU5')
    ->mergeCells('BV4:CA5')
    ->mergeCells('CB4:CF5')
    ->mergeCells('CG4:CR5')
    ->mergeCells('CS4:CS5')

    ->setCellValue('A4','Descripción depto')
    ->setCellValue('D4','Descripción por Estilo')
    ->setCellValue('Z4','Definición de Opcion/Color')
    ->setCellValue('AD4','Definiciones Generales')
    ->setCellValue('AF4','Definición de Tallas')
    ->setCellValue('AL4','Defenición de Unidades')
    ->setCellValue('AQ4','Definición de Tiendas')
    ->setCellValue('AT4','Curva por Tiendas')
    ->setCellValue('AZ4','Definición de Procedencia')
    ->setCellValue('BD4','Precio Blanco CH/.')
    ->setCellValue('BJ4','Definición de Costos Unitarios')
    ->setCellValue('BR4','Costo Total')
    ->setCellValue('BV4','Ciclo de vida')
    ->setCellValue('CB4','Definición de Proveedores')
    ->setCellValue('CG4','Gestión in Season')
    ->setCellValue('CS4','Estados')

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
    ->setCellValue('N6','Nombre Comprador')
    ->setCellValue('O6','Nombre Disenador')
    ->setCellValue('P6','Composición')
    ->setCellValue('Q6','Tipo de Tela')
    ->setCellValue('R6','Forro')
    ->setCellValue('S6','Colección')
    ->setCellValue('T6','Evento')
    ->setCellValue('U6','Evento In-Store')
    ->setCellValue('V6','Estilo de Vida')
    ->setCellValue('W6','Calidad')
    ->setCellValue('X6','Ocasión de Uso')
    ->setCellValue('Y6','Pirámide Mix')
    ->setCellValue('Z6','Ventana')
    ->setCellValue('AA6','Rank Vta')
    ->setCellValue('AB6','Life Cycle')
    ->setCellValue('AC6','Color')
    ->setCellValue('AD6','Tipo Producto')
    ->setCellValue('AE6','Tipo Exhibición')
    ->setCellValue('AF6','Tallas')
    ->setCellValue('AG6','Tipo Empaque')
    ->setCellValue('AH6','% Compra Ini')
    ->setCellValue('AI6','% Compra Ajustada')
    ->setCellValue('AJ6','Curvas de Reparto')
    ->setCellValue('AK6','Curva Min')
    ->setCellValue('AL6','Unid Ini')
    ->setCellValue('AM6','Unid Ajust')
    ->setCellValue('AN6','Unid Final')
    ->setCellValue('AO6','Mtr Pack')
    ->setCellValue('AP6','N° Cajas')
    ->setCellValue('AQ6','Clúster')
    ->setCellValue('AR6','Formato')
    ->setCellValue('AS6','Tdas')
    ->setCellValue('AT6','A')
    ->setCellValue('AU6','B')
    ->setCellValue('AV6','C')
    ->setCellValue('AW6','I')
    ->setCellValue('AX6','Primera Carga')
    ->setCellValue('AY6','%Tiendas')
    ->setCellValue('AZ6','Proced')
    ->setCellValue('BA6','Vía')
    ->setCellValue('BB6','País')
    ->setCellValue('BC6','Viaje')
    ->setCellValue('BD6','Mkup Blanco')
    ->setCellValue('BE6','Precio Blanco')
    ->setCellValue('BF6','GM Blanco')
    ->setCellValue('BG6','Oferta')
    ->setCellValue('BH6','2X')
    ->setCellValue('BI6','Opex')
    ->setCellValue('BJ6','Moneda')
    ->setCellValue('BK6','Target')
    ->setCellValue('BL6','FOB')
    ->setCellValue('BM6','Insp')
    ->setCellValue('BN6','RFID')
    ->setCellValue('BO6','Royalty(%)')
    ->setCellValue('BP6','Costo Unitario Final US$')
    ->setCellValue('BQ6','Costo Unitario Final Pesos')
    ->setCellValue('BR6','Total Target US$')
    ->setCellValue('BS6','Total Fob US$')
    ->setCellValue('BT6','Costo Total Pesos')
    ->setCellValue('BU6','Total Retail Pesos(Sin IVA)')
    ->setCellValue('BV6','Debut/Reorder')
    ->setCellValue('BW6','Sem Ini')
    ->setCellValue('BX6','Sem Fin')
    ->setCellValue('BY6','Semanas Ciclo de Vida')
    ->setCellValue('BZ6','Agot Obj')
    ->setCellValue('CA6','Semanas Liquidación')
    ->setCellValue('CB6','Proveedor')
    ->setCellValue('CC6','Razon Social')
    ->setCellValue('CD6','Trader')
    ->setCellValue('CE6','Comentarios Post Negociacion')
    ->setCellValue('CF6','Cod Sku Proveedor')
    ->setCellValue('CG6','Cod. Padre')
    ->setCellValue('CH6','Proforma')
    ->setCellValue('CI6','Archivo')
    ->setCellValue('CJ6','Estilo PMM')
    ->setCellValue('CK6','Estado Match')
    ->setCellValue('CL6','N° OC')
    ->setCellValue('CM6','Estado OC')
    ->setCellValue('CN6','Fecha Embarque Acordada')
    ->setCellValue('CO6','Fecha Embarque')
    ->setCellValue('CP6','Fecha ETA')
    ->setCellValue('CQ6','Fecha Recepción CD')
    ->setCellValue('CR6','Días Atraso CD')
    ->setCellValue('CS6','Estado Opción')
    ->setCellValue('A1','Departamentos:  '.$deptos)
    ->setCellValue('A2','Fecha:  '.$hoy);

$objPHPExcel->getActiveSheet()->getStyle('A4:CS5')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('A6:CS6')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CS5')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CS5')->applyFromArray($styleArray);


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
//$objWriter->save(str_replace(__FILE__,'../roberto.xlsx',__FILE__));