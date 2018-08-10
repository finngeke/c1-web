<?php
require_once '../PHPExcel/PHPExcel.php';
$Tempo = $f3->get('SESSION.COD_TEMPORADA');

$objPHPExcel = new PHPExcel();
$borders = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        )
    ),
);
$hoy = date("Y-m-d H:i:s");

$estado_cadena_sin = substr($estado_cadena,0,-1);
$array_estado = explode("," ,$estado_cadena_sin);
$cont_estados = count($array_estado);


for ($i=0 ; $i < $cont_estados ;$i++) {
   if ($array_estado[$i] == 0) {
     $arreglo_estado_0 = simulador_compra\plan_compra::Exportcomex_c1_comex($Tempo, $depto_cadena,$array_estado[$i]);
     $count_0 = count($arreglo_estado_0);
     $objPHPExcel->setActiveSheetIndex($i)
       ->setCellValue('A6','DEPARTAMENTO')
         ->mergeCells('A5:M5')
           ->setCellValue('B6','COD DEPTO')
           ->setCellValue('C6','LINEA')
            ->setCellValue('D6','SUBLINEA')
           ->setCellValue('E6','MARCA')
           ->setCellValue('F6','ESTILO')
           ->setCellValue('G6','VENTANA')
           ->setCellValue('H6','COLOR')
           ->setCellValue('I6','PROFORMA')
           ->setCellValue('J6','ORDEN COMPRA')
           ->setCellValue('K6','ESTADO OPCION')
           ->setCellValue('L6','FECHA ULTIMO ESTADO')
           ->setCellValue('M6','HORA');
       foreach(range('A','M') as $columnID) {
           $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
               ->setAutoSize(true);
       }

    $objPHPExcel->setActiveSheetIndex($i)
    ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
    ->setCellValue('A2', 'Fecha :  '.$hoy);
    $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
    $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
    $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
    $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($borders);
    $objPHPExcel->getActiveSheet()->fromArray($arreglo_estado_0, null, 'A7');
    $objPHPExcel->getActiveSheet()->setTitle('Ingresados');
    }
    /*ingresado*/
    if ($array_estado[$i] == 18) {
        $arreglo_estado_18 = simulador_compra\plan_compra::Exportcomex_c1_comex($Tempo, $depto_cadena,$array_estado[$i]);
        $count_18 = count($arreglo_estado_18);
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex($i)
            ->mergeCells('A5:M5')
        ->setCellValue('A6','DEPARTAMENTO')
            ->setCellValue('B6','COD DEPTO')
            ->setCellValue('C6','LINEA')
            ->setCellValue('D6','SUBLINEA')
            ->setCellValue('E6','MARCA')
            ->setCellValue('F6','ESTILO')
            ->setCellValue('G6','VENTANA')
            ->setCellValue('H6','COLOR')
            ->setCellValue('I6','PROFORMA')
            ->setCellValue('J6','ORDEN COMPRA')
            ->setCellValue('K6','ESTADO OPCION')
            ->setCellValue('L6','FECHA ULTIMO ESTADO')
            ->setCellValue('M6','HORA');
        foreach(range('A','M') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex($i)
            ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
        ->setCellValue('A2', 'Fecha :  '.$hoy);
        $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
        $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
        $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->fromArray($arreglo_estado_18, null, 'A7');
        $objPHPExcel->getActiveSheet()->setTitle('Compra Confirmada con PI');
    }
    /*Compra Confirmada con PI*/
    if ($array_estado[$i] == 19) {
        $arreglo_estado_19 = simulador_compra\plan_compra::Exportcomex_c1_comex_sin_match($Tempo, $depto_cadena,$array_estado[$i]);
        $count_19 = count ($arreglo_estado_19);
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex($i)
            ->mergeCells('A5:G5')
            ->setCellValue('A6','DEPARTAMENTO')
            ->setCellValue('B6','DEP_DEPTO')
            ->setCellValue('C6','ESTADO OPCION')
            ->setCellValue('D6','FECHA ÚLTIMO ESTADO')
            ->setCellValue('E6','PI')
            ->setCellValue('F6','UNIDADES')
            ->setCellValue('G6','COSTOS');

        foreach(range('A','G') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex($i)
            ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
            ->setCellValue('A2', 'Fecha :  '.$hoy);
        $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
        $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
        $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A6:G6')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->fromArray($arreglo_estado_19, null, 'A7');
        $objPHPExcel->getActiveSheet()->setTitle('P. de Aprobación sin Match');
    }
    /*P. de Aprobación sin Match*/
      if ($array_estado[$i] == 20) {
         $arreglo_estado_20 = simulador_compra\plan_compra::Exportcomex_c1_comex($Tempo, $depto_cadena,$array_estado[$i]);
        $count_20 = count($arreglo_estado_20);
         $objPHPExcel->createSheet();
         $objPHPExcel->setActiveSheetIndex($i)
             ->mergeCells('A5:M5')
          ->setCellValue('A6','DEPARTAMENTO')
              ->setCellValue('B6','COD DEPTO')
              ->setCellValue('C6','LINEA')
              ->setCellValue('D6','SUBLINEA')
              ->setCellValue('E6','MARCA')
              ->setCellValue('F6','ESTILO')
              ->setCellValue('G6','VENTANA')
              ->setCellValue('H6','COLOR')
              ->setCellValue('I6','PROFORMA')
              ->setCellValue('J6','ORDEN COMPRA')
              ->setCellValue('K6','ESTADO OPCION')
              ->setCellValue('L6','FECHA ULTIMO ESTADO')
              ->setCellValue('M6','HORA');
          foreach(range('A','M') as $columnID) {
              $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                  ->setAutoSize(true);
          }
          $objPHPExcel->setActiveSheetIndex($i)
              ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
              ->setCellValue('A2', 'Fecha :  '.$hoy);
          $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
          $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
          $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
          $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($borders);
          $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($borders);
          $objPHPExcel->getActiveSheet()->fromArray($arreglo_estado_20, null, 'A7');
         $objPHPExcel->getActiveSheet()->setTitle('Pendiente Aprobación');
     }
    /*Pendiente Aprobación*/
      if ($array_estado[$i] == 21) {
          $arreglo_estado_21 = simulador_compra\plan_compra::Exportcomex_c1_comex($Tempo, $depto_cadena,$array_estado[$i]);
          $objPHPExcel->createSheet();
          $objPHPExcel->setActiveSheetIndex($i)
              ->mergeCells('A5:M5')
          ->setCellValue('A6','DEPARTAMENTO')
              ->setCellValue('B6','COD DEPTO')
              ->setCellValue('C6','LINEA')
              ->setCellValue('D6','SUBLINEA')
              ->setCellValue('E6','MARCA')
              ->setCellValue('F6','ESTILO')
              ->setCellValue('G6','VENTANA')
              ->setCellValue('H6','COLOR')
              ->setCellValue('I6','PROFORMA')
              ->setCellValue('J6','ORDEN COMPRA')
              ->setCellValue('K6','ESTADO OPCION')
              ->setCellValue('L6','FECHA ULTIMO ESTADO')
              ->setCellValue('M6','HORA');
          foreach(range('A','M') as $columnID) {
              $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                  ->setAutoSize(true);
          }
          $objPHPExcel->getActiveSheet()
              ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
          ->setCellValue('A2', 'Fecha :  '.$hoy);
          $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
          $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
          $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
          $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($borders);
          $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($borders);
          $objPHPExcel->getActiveSheet()->fromArray($arreglo_estado_21, null, 'A7');
          $objPHPExcel->getActiveSheet()->setTitle('Aprobado');
      }
    /*Aprobado*/
    if ($array_estado[$i] == 22) {
         $arreglo_estado_22 = simulador_compra\plan_compra::Exportcomex_c1_comex_migracion($Tempo, $depto_cadena,$array_estado[$i]);
         $count_22 = count ($arreglo_estado_22);
         $objPHPExcel->createSheet();
         $objPHPExcel->setActiveSheetIndex($i)
        ->setCellValue('A6','TEMPORADA')
             ->mergeCells('A5:H5')
            ->setCellValue('B6','DEPARTAMENTO')
            ->setCellValue('C6','COD DEP')
            ->setCellValue('D6','ESTADO OPCION')
            ->setCellValue('E6','PI')
            ->setCellValue('F6','FECHA ÚLTIMO ESTADO')
            ->setCellValue('G6','HORA')
            ->setCellValue('H6','COMPRADOR');

        foreach(range('A','H') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $objPHPExcel->getActiveSheet()->getStyle('A6:H6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
        $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->fromArray($arreglo_estado_22, null, 'A7');
        for ($w = 0; $w <= $count_22-1; $w++) {
            $objPHPExcel->setActiveSheetIndex($i)
                ->setCellValue('E'.($w+7), '=Hyperlink("http://localhost:8181/C1_AUTOMATICA_WEB/archivos/pi/PI-'.$Tempo.'-'.$arreglo_estado_22[$w]["COD DEP"].'-'.$arreglo_estado_22[$w]["PI"].'.xls","'.$arreglo_estado_22[$w]["PI"].'")');
        }
        $objPHPExcel->setActiveSheetIndex($i)
            ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
            ->setCellValue('A2', 'Fecha :  '.$hoy);
        $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
        $objPHPExcel->getActiveSheet()->setTitle('Pendiente Generacion OC');
     }
    /*Pendiente Generacion OC*/
    if ($array_estado[$i] == 23) {
          $arreglo_estado_23 = simulador_compra\plan_compra::Exportcomex_c1_comex_error($Tempo, $depto_cadena,$array_estado[$i]);
          $count_23 = count ($arreglo_estado_23);
          $objPHPExcel->createSheet();
          $objPHPExcel->setActiveSheetIndex($i)
              ->mergeCells('A5:I5')
             ->setCellValue('A6','TEMPORADA')
            ->setCellValue('B6','DEPARTAMENTO')
            ->setCellValue('C6','COD DEP')
            ->setCellValue('D6','ESTADO OPCION')
            ->setCellValue('E6','PI')
            ->setCellValue('F6','FECHA ÚLTIMO ESTADO')
            ->setCellValue('G6','HORA')
            ->setCellValue('H6','COMPRADOR')
            ->setCellValue('I6','OBSERVACION');
        foreach(range('A','I') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A5:I5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $objPHPExcel->getActiveSheet()->getStyle('A6:I6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
        $objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray($borders);

        for ($vt = 0 ; $vt < $count_23 ; $vt ++){
            $objPHPExcel->setActiveSheetIndex($i)
            ->setCellValue('A1', $arreglo_estado_23[$vt]["DEPARTAMENTO"])
            ->setCellValue('A' .($vt+7), $arreglo_estado_23[$vt]["TEMPORADA"])
            ->setCellValue('B' .($vt+7),  $arreglo_estado_23[$vt]["DEPARTAMENTO"])
            ->setCellValue('C' .($vt+7),  $arreglo_estado_23[$vt]["COD DEP"])
            ->setCellValue('D' .($vt+7),  "Pendiente de Correcion PI")
            ->setCellValue('E' .($vt+7),  $arreglo_estado_23[$vt]["PI"])
            ->setCellValue('F' .($vt+7),  $arreglo_estado_23[$vt]["FECHA ÚLTIMO ESTADO"])
            ->setCellValue('G' .($vt+7), $arreglo_estado_23[$vt]["HORA"])
            ->setCellValue('H' .($vt+7),  $arreglo_estado_23[$vt]["COMPRADOR"])
            ->setCellValue('I' .($vt+7),  $arreglo_estado_23[$vt]["OBSERVACION"]);
        }
        $objPHPExcel->setActiveSheetIndex($i)
            ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
            ->setCellValue('A2', 'Fecha :  '.$hoy);
        $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
        $objPHPExcel->getActiveSheet()->setTitle('Pendiente de Correccion PI');
      }
    /*P. de Corrección PI*/
    if ($array_estado[$i] == 24) {
        $arreglo_estado_24 = simulador_compra\plan_compra::Exportcomex_c1_comex($Tempo, $depto_cadena,$array_estado[$i]);
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex($i)
            ->mergeCells('A5:M5')
        ->setCellValue('A6','DEPARTAMENTO')
            ->setCellValue('B6','COD DEPTO')
            ->setCellValue('C6','LINEA')
            ->setCellValue('D6','SUBLINEA')
            ->setCellValue('E6','MARCA')
            ->setCellValue('F6','ESTILO')
            ->setCellValue('G6','VENTANA')
            ->setCellValue('H6','COLOR')
            ->setCellValue('I6','PROFORMA')
            ->setCellValue('J6','ORDEN COMPRA')
            ->setCellValue('K6','ESTADO OPCION')
            ->setCellValue('L6','FECHA ULTIMO ESTADO')
            ->setCellValue('M6','HORA');
        foreach(range('A','M') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $objPHPExcel->setActiveSheetIndex($i)
            ->setCellValue('A1', 'Departamentos :  '.$depto_cadena)
            ->setCellValue('A2', 'Fecha :  '.$hoy);
        $objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
        $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('DCDCDC');
        $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
        $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->getStyle('A6:M6')->applyFromArray($borders);
        $objPHPExcel->getActiveSheet()->fromArray($arreglo_estado_24, null, 'A7');
        $objPHPExcel->getActiveSheet()->setTitle('Eliminado');
    }
    /*Eliminado*/

}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="C1_Por_opciones_'.$Tempo.'_'.$hoy.'.xls"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');