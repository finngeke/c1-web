<?php
require_once '../PHPExcel/PHPExcel.php';

$depto = $f3->get('SESSION.COD_DEPTO');
$Tempo = $f3->get('SESSION.COD_TEMPORADA');
/*Traemos los datos de la clase*/
$arreglo_depto = simulador_compra\plan_compra::Exportc1($Tempo, $depto_cadena);
$arreglo_ppto = simulador_compra\plan_compra::Export_c1_presupuestos($Tempo, $depto_cadena);
/*Contamos los datos para recorrer posteriormente*/
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
/*Le damos color a las cabeceras de la hoja de departamentos*/
$objPHPExcel->getActiveSheet()->getStyle('A4:CI4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A5:CI5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A6:CI6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');
/*Creacion de cabeceras de los departamentos*/
$objPHPExcel->setActiveSheetIndex(0)
    /*Se juntan las celdas*/
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

    ->setCellValue('A4','descripcion depto')
    ->setCellValue('D4','Descripciòn por Estilo')
    ->setCellValue('U4','definiciòn de Opcion/Color')
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
/*####################fin de la creacion de las cabeceras#################*/

/*aplican bordes para la hoja de departamentos*/
$objPHPExcel->getActiveSheet()->getStyle('A4:CI5')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('A6:CI6')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CI5')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:CI5')->applyFromArray($styleArray);

/*genera titulos*/
$objPHPExcel->getActiveSheet()->setTitle('DEPARTAMENTOS');

/*imprime el arreglo en excel*/
$objPHPExcel->getActiveSheet()->fromArray($arreglo_depto, null, 'A7');
/*###########fin de impresion#########*/

/*generamos arreglo con letras con el fin de recorrer el excel*/
$var_orden = "A+B+C+D+E+F+G+H+I+J+K+L+M+N+O+P+Q+R+S+T+U+V+W+X+Y+Z+AA+AB+AC+AD+AE+AF+AG+AH+AI+AJ+AK+AL+AM+AN+AO+AP+AQ+AR+AS+AT+AU+AV+AW+AX+AY+AZ+BA+BB+BC+BD+BE+BF+BG+BH+BI+BJ+BK+BL+BM+BN+BO+BP+BQ+BR+BS+BT+BU+BV+BW+BX+BY+BZ+CA+CB+CC+CD+CE+CF+CG+CH+CI";
$array_orden =explode("+", $var_orden);

/*fijamos la cabecera*/
$objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);

/*Ajustamos la dimensiones de las celdas*/
foreach ($array_orden as $columna_letra){
$objPHPExcel->getActiveSheet()
    ->getColumnDimension($columna_letra)
    ->setAutoSize(true);
}
/*Se crean las cabeceras de los presupouestos*/
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1)
    ->mergeCells('A4:L5')
    ->mergeCells('M4:V5')
    ->mergeCells('W4:AF5')

    ->setCellValue('A4', 'Compra Costo CH/.')
    ->setCellValue('M4', 'Compra Retail CH/.')
    ->setCellValue('W4', 'Embarque %')

    ->setCellValue('A6', 'DEPTO')
    ->setCellValue('B6', 'TIPO')
    ->setCellValue('C6', 'A')
    ->setCellValue('D6', 'B')
    ->setCellValue('E6', 'C')
    ->setCellValue('F6', 'D')
    ->setCellValue('G6', 'E')
    ->setCellValue('H6', 'F')
    ->setCellValue('I6', 'G')
    ->setCellValue('J6', 'H')
    ->setCellValue('K6', 'I')
    ->setCellValue('L6', 'TOTAL')
    ->setCellValue('M6', 'A')
    ->setCellValue('N6', 'B')
    ->setCellValue('O6', 'C')
    ->setCellValue('P6', 'D')
    ->setCellValue('Q6', 'E')
    ->setCellValue('R6', 'F')
    ->setCellValue('S6', 'G')
    ->setCellValue('T6', 'H')
    ->setCellValue('U6', 'I')
    ->setCellValue('V6', 'TOTAL')
    ->setCellValue('W6', 'A')
    ->setCellValue('X6', 'B')
    ->setCellValue('Y6', 'C')
    ->setCellValue('Z6', 'D')
    ->setCellValue('AA6', 'E')
    ->setCellValue('AB6', 'F')
    ->setCellValue('AC6', 'G')
    ->setCellValue('AD6', 'H')
    ->setCellValue('AE6', 'I')
    ->setCellValue('AF6', 'TOTAL');

$count_fila =7;
$depto_selec =0;
$depto_total =8;
$var = "A+B+C+D+E+F+G+H+I+J+K+L+M+N+O+P+Q+R+S+T+U+V+W+X+Y+Z+AA+AB+AC+AD+AE+AF";
$array =explode("+", $var);
/*Generacon de bordes cabecera cuerpo y otros*/
$objPHPExcel->getActiveSheet()->getStyle('A4:AF5')->applyFromArray($style);
$objPHPExcel->getActiveSheet()->getStyle('A6:AF6')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:AF5')->applyFromArray($borders);
$objPHPExcel->getActiveSheet()->getStyle('A4:AF5')->applyFromArray($styleArray);

/*Funcion que ajusta las columnas a los campos */
foreach ($array as $columna){
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($columna)
        ->setAutoSize(true);
}
/*Asigna los colores a las cabeceras */
$objPHPExcel->getActiveSheet()->getStyle('A4:AF5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('909090');
$objPHPExcel->getActiveSheet()->getStyle('A6:AF6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('D9D9D9');

for ($i = 0 ; $i <= $count_depto ;$i++) {
    foreach ($array as $val) {
        if ($val == "A") {
            $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue($val . $count_fila, $arreglo_ppto[$depto_selec]["DEP_DEPTO"])
                ->setCellValue($val . ($count_fila+1), $arreglo_ppto[$depto_selec]["DEP_DEPTO"])
                ->setCellValue($val . ($count_fila+2), $arreglo_ppto[$depto_selec]["DEP_DEPTO"]);
        }
        if ($val == "B") {
            $objPHPExcel->setActiveSheetIndex(1)
                ->setCellValue($val . $count_fila, 'PPTO')
                ->setCellValue($val .($count_fila+1), 'CONSUMO')
                ->setCellValue($val .($count_fila+2), 'SALDO');
        }
        if ($val == "C") {
            for ($c = 0; $c <= 8; $c++) {
                /*Asigna valores a las columnas desde C hasta la letra L*/
                $objPHPExcel->setActiveSheetIndex(1)
                    ->setCellValue($val . $count_fila, $arreglo_ppto[($depto_selec+$c)]["COS_PPTO"])
                    ->setCellValue($val . ($count_fila + 1), $arreglo_ppto[($depto_selec+$c)]["COS_CON"])
                    ->setCellValue($val . ($count_fila + 2), '='.$val.$count_fila.'-'.$val.($count_fila+1))
                    /*Se calculan los totales de compra ppto - compra consumo - compra saldo*/
                    ->setCellValue('L'.$count_fila, '=C'.$count_fila.'+D'.$count_fila.'+E'.$count_fila.'+F'.$count_fila.'+G'.$count_fila.'+H'.$count_fila.'+I'.$count_fila.'+J'.$count_fila.'+K'.$count_fila)
                    ->setCellValue('L'.($count_fila+1), '=C'.($count_fila+1).'+D'.($count_fila+1).'+E'.($count_fila+1).'+F'.($count_fila+1).'+G'.($count_fila+1).'+H'.($count_fila+1).'+I'.($count_fila+1).'+J'.($count_fila+1).'+K'.($count_fila+1))
                    ->setCellValue('L'.($count_fila+2), '=C'.($count_fila+2).'+D'.($count_fila+2).'+E'.($count_fila+2).'+F'.($count_fila+2).'+G'.($count_fila+2).'+H'.($count_fila+2).'+I'.($count_fila+2).'+J'.($count_fila+2).'+K'.($count_fila+2));
               /*se solorea la tabla*/
                $objPHPExcel->getActiveSheet()->getStyle('A'.$count_fila.':L'.$count_fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f0f8ff');
                $objPHPExcel->getActiveSheet()->getStyle('A'.($count_fila+1).':L'.($count_fila+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f0f8ff');
                $objPHPExcel->getActiveSheet()->getStyle('A'.($count_fila+2).':L'.($count_fila+2))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f0f8ff');
                $val++;
            }
        }
        if ($val == "M") {
            for ($m = 0; $m <= 8; $m++) {
                /*Asigna valores a las columnas desde M hasta la letra V*/
                $objPHPExcel->setActiveSheetIndex(1)
                    /*Se llenan los campos con el arreglo*/
                    ->setCellValue($val . $count_fila, $arreglo_ppto[($depto_selec+$m)]["RET_PPTO"])
                    ->setCellValue($val . ($count_fila + 1), $arreglo_ppto[($depto_selec+$m)]["RET_CON"])
                    ->setCellValue($val . ($count_fila + 2), '='.$val.$count_fila.'-'.$val.($count_fila+1))
                    /*Se calculan los totales de Retail ppto - retail consumo - retail saldo*/
                    ->setCellValue('V'.$count_fila, '=M'.$count_fila.'+N'.$count_fila.'+O'.$count_fila.'+P'.$count_fila.'+Q'.$count_fila.'+R'.$count_fila.'+S'.$count_fila.'+T'.$count_fila.'+U'.$count_fila)
                    ->setCellValue('V'.($count_fila+1), '=M'.($count_fila+1).'+N'.($count_fila+1).'+O'.($count_fila+1).'+P'.($count_fila+1).'+Q'.($count_fila+1).'+R'.($count_fila+1).'+S'.($count_fila+1).'+T'.($count_fila+1).'+U'.($count_fila+1))
                    ->setCellValue('V'.($count_fila+2), '=M'.($count_fila+2).'+N'.($count_fila+2).'+O'.($count_fila+2).'+P'.($count_fila+2).'+Q'.($count_fila+2).'+R'.($count_fila+2).'+S'.($count_fila+2).'+T'.($count_fila+2).'+U'.($count_fila+2));
                /*SE colorea la tabla*/
                $objPHPExcel->getActiveSheet()->getStyle('M'.$count_fila.':V'.$count_fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffb6c1');
                $objPHPExcel->getActiveSheet()->getStyle('M'.($count_fila+1).':V'.($count_fila+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffb6c1');
                $objPHPExcel->getActiveSheet()->getStyle('M'.($count_fila+2).':V'.($count_fila+2))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffb6c1');
                $val++;
            }
        }
        if ($val == "W") {
            for ($w = 0; $w <= 8; $w++) {
                $objPHPExcel->setActiveSheetIndex(1)
                    /*Asigna valores a las columnas desde W hasta el final*/
                    ->setCellValue($val .$count_fila, $arreglo_ppto[($depto_selec+$w)]["EMB_PPTO"])
                    /*Se calculan los totales de Embarque ppto - Embarque consumo - Embarque saldo */
                    ->setCellValue('AF'.$count_fila, '=W'.$count_fila.'+X'.$count_fila.'+Y'.$count_fila.'+Z'.$count_fila.'+AA'.$count_fila.'+AB'.$count_fila.'+AC'.$count_fila.'+AD'.$count_fila.'+AE'.$count_fila)
                    ->setCellValue('AF'.($count_fila+1), '=W'.($count_fila+1).'+X'.($count_fila+1).'+Y'.($count_fila+1).'+Z'.($count_fila+1).'+AA'.($count_fila+1).'+AB'.($count_fila+1).'+AC'.($count_fila+1).'+AD'.($count_fila+1).'+AE'.($count_fila+1))
                    ->setCellValue('AF'.($count_fila+2), '=W'.($count_fila+2).'+X'.($count_fila+2).'+Y'.($count_fila+2).'+Z'.($count_fila+2).'+AA'.($count_fila+2).'+AB'.($count_fila+2).'+AC'.($count_fila+2).'+AD'.($count_fila+2).'+AE'.($count_fila+2));
                    /*SE colorea la tabla de embarque */
                $objPHPExcel->getActiveSheet()->getStyle('W'.$count_fila.':AF'.$count_fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('87cefa');
                $objPHPExcel->getActiveSheet()->getStyle('W'.($count_fila+1).':AF'.($count_fila+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('87cefa');
                $objPHPExcel->getActiveSheet()->getStyle('W'.($count_fila+2).':AF'.($count_fila+2))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('87cefa');
                $val++;
            }
            /*Calcular campos de embarque ##consumo##*/
            $valor_L = $objPHPExcel->getActiveSheet()->getCell('L'.($count_fila+1))->getCalculatedValue();
            if ( $valor_L == 0){
                $objPHPExcel->setActiveSheetIndex(1)
                    ->setCellValue('W' .($count_fila+1), "0")
                    ->setCellValue('X' .($count_fila+1), "0")
                    ->setCellValue('Y' .($count_fila+1), '0')
                    ->setCellValue('Z' .($count_fila+1), '0')
                    ->setCellValue('AA' .($count_fila+1), '0')
                    ->setCellValue('AB' .($count_fila+1), '0')
                    ->setCellValue('AC' .($count_fila+1), '0')
                    ->setCellValue('AD' .($count_fila+1), '0')
                    ->setCellValue('AE' .($count_fila+1), '0');
            }else {
                $objPHPExcel->setActiveSheetIndex(1)
                    ->setCellValue('W' . ($count_fila + 1), "=C" . ($count_fila + 1) . "/L" . ($count_fila + 1))
                    ->setCellValue('X' . ($count_fila + 1), '=D' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1))
                    ->setCellValue('Y' . ($count_fila + 1), '=E' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1))
                    ->setCellValue('Z' . ($count_fila + 1), '=F' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1))
                    ->setCellValue('AA' . ($count_fila + 1), '=G' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1))
                    ->setCellValue('AB' . ($count_fila + 1), '=H' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1))
                    ->setCellValue('AC' . ($count_fila + 1), '=I' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1))
                    ->setCellValue('AD' . ($count_fila + 1), '=J' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1))
                    ->setCellValue('AE' . ($count_fila + 1), '=K' . ($count_fila + 2) . '/' . 'L' . ($count_fila + 1));
                }
            /*Calcular Campos de embarque ##saldo (Total)##*/
            $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('W' .($count_fila+2), "=C".($count_fila+2)."/L".($count_fila+2))
            ->setCellValue('X' .($count_fila+2), '=D'.($count_fila+2).'/'.'L'.($count_fila+2))
            ->setCellValue('Y' .($count_fila+2), '=E'.($count_fila+2).'/'.'L'.($count_fila+2))
            ->setCellValue('Z' .($count_fila+2), '=F'.($count_fila+2).'/'.'L'.($count_fila+2))
            ->setCellValue('AA' .($count_fila+2),'=G'.($count_fila+2).'/'.'L'.($count_fila+2))
            ->setCellValue('AB' .($count_fila+2), '=H'.($count_fila+2).'/'.'L'.($count_fila+2))
            ->setCellValue('AC' .($count_fila+2), '=I'.($count_fila+2).'/'.'L'.($count_fila+2))
            ->setCellValue('AD' .($count_fila+2), '=J'.($count_fila+2).'/'.'L'.($count_fila+2))
                ->setCellValue('AE' .($count_fila+2), '=K'.($count_fila+2).'/'.'L'.($count_fila+2));

            /*Se cambian los formatos de la seccion de embarque a porcentajes */
                $objPHPExcel->getActiveSheet()->getStyle("W".$count_fila.":AE".($count_fila+2))
                ->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                    )
                );
            /*####Dar formato a los totales####*/
          $objPHPExcel->getActiveSheet()->getStyle("AF".$count_fila)->getNumberFormat()->applyFromArray(["code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE]);
          $objPHPExcel->getActiveSheet()->getStyle("AF".($count_fila+1))->getNumberFormat()->applyFromArray(["code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE]);
          $objPHPExcel->getActiveSheet()->getStyle("AF".($count_fila+2))->getNumberFormat()->applyFromArray(["code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE]);
        }
    }
    /*Da Color las columnas A y B ####gris####*/
    $objPHPExcel->getActiveSheet()->getStyle('A'.$count_fila.':B'.$count_fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('B6B4B4');
    $objPHPExcel->getActiveSheet()->getStyle('A'.($count_fila+1).':B'.($count_fila+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('B6B4B4');
    $objPHPExcel->getActiveSheet()->getStyle('A'.($count_fila+2).':B'.($count_fila+2))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('B6B4B4');

    $objPHPExcel->getActiveSheet()->getStyle('A'.$count_fila.':AF'.($count_fila+2))->applyFromArray($BStyle);
    $count_fila = $count_fila +3;
    $depto_selec = $depto_selec +9;
    $depto_total = $depto_total +8;
}

$objPHPExcel->getActiveSheet()
    ->getColumnDimension('A')
    ->setAutoSize(false);

$objPHPExcel->getActiveSheet()
    ->setCellValue('A1','Departamentos: '.$depto_cadena)
    ->setCellValue('A2','Fecha:  '.$hoy);
$objPHPExcel->getActiveSheet()->freezePaneByColumnAndRow(0,7);
$objPHPExcel->getActiveSheet()->setTitle('PRESUPUESTOS');
$objPHPExcel->setActiveSheetIndex(0);


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