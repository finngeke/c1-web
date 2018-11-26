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

$objPHPExcel->getActiveSheet()->getStyle('A4:CP4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A5:CP5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A6:CP6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A4:C5')
    ->mergeCells('D4:X5')
    ->mergeCells('Y4:AB5')
    ->mergeCells('AC4:AD5')
    ->mergeCells('AE4:AJ5')
    ->mergeCells('AK4:AO5')
    ->mergeCells('AP4:AR5')
    ->mergeCells('AS4:AX5')
    ->mergeCells('AY4:BB5')
    ->mergeCells('BC4:BF5')
    ->mergeCells('BG4:BN5')
    ->mergeCells('BO4:BR5')
    ->mergeCells('BS4:BX5')
    ->mergeCells('AY4:BA5')
    ->mergeCells('BY4:CC5')
    ->mergeCells('CD4:CO5')
    ->mergeCells('CP4:CP5')


    ->setCellValue('A4','Descripción depto')
    ->setCellValue('D4','Descripción por Estilo')
    ->setCellValue('Y4','Definición de Opcion/Color')
    ->setCellValue('AC4','Definiciones Generales')
    ->setCellValue('AE4','Definición de Tallas')
    ->setCellValue('AK4','Defenición de Unidades')
    ->setCellValue('AP4','Definición de Tiendas')
    ->setCellValue('AS4','Curva por Tiendas')
    ->setCellValue('AY4','Definición de Procedencia')
    ->setCellValue('BC4','Precio Blanco CH/.')
    ->setCellValue('BG4','Definición de Costos Unitarios')
    ->setCellValue('BO4','Costo Total')
    ->setCellValue('BS4','Ciclo de vida')
    ->setCellValue('BY4','Definición de Proveedores')
    ->setCellValue('CD4','Gestión in Season')
    ->setCellValue('CP4','Estados')

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
    ->setCellValue('U6','Estilo de Vida')
    ->setCellValue('V6','Calidad')
    ->setCellValue('W6','Ocasión de Uso')
    ->setCellValue('X6','Pirámide Mix')
    ->setCellValue('Y6','Ventana')
    ->setCellValue('Z6','Rank Vta')
    ->setCellValue('AA6','Life Cycle')
    ->setCellValue('AB6','Color')
    ->setCellValue('AC6','Tipo Producto')
    ->setCellValue('AD6','Tipo Exhibición')
    ->setCellValue('AE6','Tallas')
    ->setCellValue('AF6','Tipo Empaque')
    ->setCellValue('AG6','% Compra Ini')
    ->setCellValue('AH6','% Compra Ajustada')
    ->setCellValue('AI6','Curvas de Reparto')
    ->setCellValue('AJ6','Curva Min')
    ->setCellValue('AK6','Unid Ini')
    ->setCellValue('AL6','Unid Ajust')
    ->setCellValue('AM6','Unid Final')
    ->setCellValue('AN6','Mtr Pack')
    ->setCellValue('AO6','N° Cajas')
    ->setCellValue('AP6','Clúster')
    ->setCellValue('AQ6','Formato')
    ->setCellValue('AR6','Tdas')
    ->setCellValue('AS6','A')
    ->setCellValue('AT6','B')
    ->setCellValue('AU6','C')
    ->setCellValue('AV6','I')
    ->setCellValue('AW6','Primera Carga')
    ->setCellValue('AX6','%Tiendas')
    ->setCellValue('AY6','Proced')
    ->setCellValue('AZ6','Vía')
    ->setCellValue('BA6','País')
    ->setCellValue('BB6','Viaje')
    ->setCellValue('BC6','Mkup Blanco')
    ->setCellValue('BD6','Precio Blanco')
    ->setCellValue('BE6','GM Blanco')
    ->setCellValue('BF6','Oferta')
    ->setCellValue('BG6','Moneda')
    ->setCellValue('BH6','Target')
    ->setCellValue('BI6','FOB')
    ->setCellValue('BJ6','Insp')
    ->setCellValue('BK6','RFID')
    ->setCellValue('BL6','Royalty(%)')
    ->setCellValue('BM6','Costo Unitario Final US$')
    ->setCellValue('BN6','Costo Unitario Final Pesos')
    ->setCellValue('BO6','Total Target US$')
    ->setCellValue('BP6','Total Fob US$')
    ->setCellValue('BQ6','Costo Total Pesos')
    ->setCellValue('BR6','Total Retail Pesos(Sin IVA)')
    ->setCellValue('BS6','Debut/Reorder')
    ->setCellValue('BT6','Sem Ini')
    ->setCellValue('BU6','Sem Fin')
    ->setCellValue('BV6','Semanas Ciclo de Vida')
    ->setCellValue('BW6','Agot Obj')
    ->setCellValue('BX6','Semanas Liquidación')
    ->setCellValue('BY6','Proveedor')
    ->setCellValue('BZ6','Razon Social')
    ->setCellValue('CA6','Trader')
    ->setCellValue('CB6','Comentarios Post Negociacion')
    ->setCellValue('CC6','Cod Sku Proveedor')
    ->setCellValue('CD6','Cod. Padre')
    ->setCellValue('CE6','Proforma')
    ->setCellValue('CF6','Archivo')
    ->setCellValue('CG6','Estilo PMM')
    ->setCellValue('CH6','Estado Match')
    ->setCellValue('CI6','N° OC')
    ->setCellValue('CJ6','Estado OC')
    ->setCellValue('CK6','Fecha Embarque Acordada')
    ->setCellValue('CL6','Fecha Embarque')
    ->setCellValue('CM6','Fecha ETA')
    ->setCellValue('CN6','Fecha Recepción CD')
    ->setCellValue('CO6','Días Atraso CD')
    ->setCellValue('CP6','Estado Opción')
    ->setCellValue('A1','Departamentos:  '.$depto_cadena)
    ->setCellValue('A2','Fecha:  '.$hoy);

$objPHPExcel->getActiveSheet()->getStyle('A4:CP5')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('A6:CP6')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CP5')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CP5')->applyFromArray($styleArray);


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