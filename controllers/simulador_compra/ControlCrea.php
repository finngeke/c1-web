<?php

/**
 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
 * Descripción: 
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 */

namespace simulador_compra;

class ControlCrea extends \Control {

public function importar_bmt($f3) {

       // print_r($_REQUEST); //varibles que se esta pasando por post del formulario
       // die();

        $tipoArchivo = $_POST["tipos_import"];
        $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
        $depto = $f3->get('SESSION.COD_DEPTO');
        $login = $f3->get('SESSION.login');


    if ($tipoArchivo == 1){//ASSORMENT

        error_reporting(E_ALL);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 9000000);
        /* SUBIR ARCHIVO */
        $web = \Web::instance();
        $slug = true;
        $overwrite = true; // set to true, to overwrite an existing file; Default: false
        $files = $web->receive(function($file, $formFieldName) {
            return true;
        }, $overwrite, $slug);
        $valido = array('xls', 'xlsx','XLS','XLSX');

        foreach ($files as $key => $val) {
            $nombre = $key;
            $valido_file = $val;
        }
        $ruta = $nombre;
        $extencion = explode(".", $nombre);

        if (!in_array($extencion[3], $valido) || $valido_file == 0) {
            unlink($ruta);
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->El archivo no tiene el formato correcto. [.xls o .xlsx o .XLS o .XLSX]' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        $temporada = \temporada\temporada::getTemporadaCompra($cod_tempo)->NOM_TEMPORADA_CORTO;
        require_once '../class/PHPExcel/IOFactory.php';
        /* LEER ASSORMENT */
        $objPHPExcel = \PHPExcel_IOFactory::load($ruta);
        $worksheet = $objPHPExcel->getActiveSheet('Shopping List');

        $rows = [];
        $fila = 0;
        //echo count($rows),$limite;


        foreach ($worksheet->getRowIterator() AS $row) {

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            $column = 1;
            $count = 0;
           foreach ($cellIterator as $cell) {
               $count += 1;
               if ($count > 101){
                   break;
               }
                 if ($column <= 1 ){
                     $cells[] = "s";
                 }else {
                     $cells[] = $cell->getValue();
                 }
                /*if ($column == 29 && $fila >= 14) { // TARGET BUDGET
                    $cells[] = $cell->getCalculatedValue();
                } elseif ($column == 30 && $fila >= 14) { //TOTAL QUANTITY
                    $cells[] = $cell->getCalculatedValue();
                } elseif ($column == 32 && $fila >= 14) {
                    $cells[] = $cell->getCalculatedValue();
                } else {
                    $cells[] = $cell->getValue();
                }*/
               //$cells[] = $cell->getValue();
                $column++;
            }
            $rows[] = $cells;
            $fila++;
        }



        //Validacion de Columnas.
        $_ERROR2 = valida_archivo_bmt::Val_CamposObligatorio($rows[2],1);
        if ($_ERROR2 != "" ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->No existe(n) en el archivo campo(s): '.$_ERROR2.'' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        array_push($rows[2],"Unidades");

        //Validacion de Columnas archivo en blanco
        try {
        $nom_columnas = array_flip($rows[2]);
        }catch (Exception $e) {
             $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$-> Existen colummnas en blanco.' . '$');
             $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }
        $limite = (count($rows)-1);
        for($i = 3;$i <= $limite; $i++){
            array_push($rows[$i],0);
        }

        //validacion de temporada
        $_ERROR2 = valida_archivo_bmt::Val_Season($rows,$limite,$nom_columnas,$temporada);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->La temporada del archivo no corresponde a la temporada seleccionada: Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de depto
        $_ERROR2 = valida_archivo_bmt::Val_depto($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){

            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->El codigo depto del archivo no corresponde a su seleccion en la C1: Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de grupo compra
        $_ERROR2 = valida_archivo_bmt::val_grupo_compra($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->El archivo debe tener solo un grupo de compra.' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion existe grupo compra
        $_ERROR2 = valida_archivo_bmt::val_grupo_compra_x_estado($cod_tempo,$depto,$rows[3][$nom_columnas['Grupo de compra']]);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->[' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de una marca por assortment
        $_ERROR2 = valida_archivo_bmt::Val_soloUnaMarca($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2 != "" ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->Existe más de una marca en el archivo: '.$_ERROR2.'' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de marca
        $_ERROR2 = valida_archivo_bmt::Val_marca($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->El codigo marca no corresponde departamento seleccionado en la C1: Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de jerarquia
        $_ERROR2 = valida_archivo_bmt::Val_jerarquia($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->La combinación Linea y Sublinea no existen PMM: Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de colores
        $_ERROR2 = valida_archivo_bmt::Val_Colores($rows,$limite,$nom_columnas);
        if ($_ERROR2["Tipo"] == false ){
            echo "<br>4.1";
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->El codigo de color no existen PMM: Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de tipo producto y tipo de exhibicion
        $_ERROR2 = valida_archivo_bmt::Val_Tipo_Produc_Exhibicion($rows,$limite,$nom_columnas);
        if ($_ERROR2["Tipo"] == false ){
            echo "<br>5.1";
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion Campos
        $_ERROR2 = valida_archivo_bmt::Val_Campos($rows,$limite,$nom_columnas,$cod_tempo,$depto,$f3);
        if ($_ERROR2["Tipo"] == false ){
            echo "<br>6.1";
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de mstpack
        $_ERROR2 = valida_archivo_bmt::val_mstpack($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){
            echo "<br>7.1";
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->No exísten master pack asociado o el master pack tiene que ser mayor a 0: Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion multiplos
        $_ERROR2 = valida_archivo_bmt::valida_Multiplo($rows,$limite,$nom_columnas);
        if ($_ERROR2["Tipo"] == false ){
            echo "<br>8.1";
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->El Número de curva por clúster no es múltiple al número curvas por cajas. Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //borrar datos de basura.
        $rows = valida_archivo_bmt::eliminardatosrows($rows,$limite,$nom_columnas);
        $limite = (count($rows)-1);

        //Guardado Historica ASSORTMENT
        $_ERROR2 = plan_compra::InsertHistoricaAssortment($rows,$limite,$nom_columnas,$cod_tempo,$depto,$rows[3][$nom_columnas['Codigo Marca']],$rows[3][$nom_columnas['Grupo de compra']]);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$-> ' . $_ERROR2["Error"] . '.' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //reabrir datos por ventana
        $rows = valida_archivo_bmt::Separacion_Data_Ventana($rows,$limite,$nom_columnas);
        $limite = (count($rows)-1);
        $nom_columnas = array_flip($rows[0]);

        //*delete plan de compra
        $_ERROR2 = plan_compra::DeleteRowsPlan($cod_tempo,$depto,$rows[1][$nom_columnas['Codigo Marca']],$rows[1][$nom_columnas['Grupo de compra']]);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //Guardado plan de compra
        $_ERROR2 = plan_compra::InsertPlanCompraAssorment($rows,$limite,$nom_columnas,$cod_tempo,$depto,$login);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$-> ' . $_ERROR2["Error"] . '.' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        $f3->set('SESSION.exito', 'Insertado Correctamente');
                $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));

        }//ASSORMMENT EXPORT
    elseif($tipoArchivo == 2){//BMT

            /* LEER BMT */
        error_reporting(E_ALL);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        /* SUBIR ARCHIVO */
        $web = \Web::instance();
        $slug = true;
        $overwrite = true; // set to true, to overwrite an existing file; Default: false
        $files = $web->receive(function($file, $formFieldName) {
            return true;
        }, $overwrite, $slug);
        $valido = array('xls', 'xlsx','XLS','XLSX');
        foreach ($files as $key => $val) {
            $nombre = $key;
            $valido_file = $val;
        }
        $ruta = $nombre;
        $extencion = explode(".", $nombre);

        //Validacion de tipo de archivo.
        if (!in_array($extencion[3], $valido) || $valido_file == 0) {
            unlink($ruta);
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->El archivo no tiene el formato correcto. [.xls o .xlsx o .XLS o .XLSX]' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        $temporada = \temporada\temporada::getTemporadaCompra($cod_tempo)->NOM_TEMPORADA_CORTO;
        require_once '../class/PHPExcel/IOFactory.php';

        //Leer la hoja
        $objPHPExcel = \PHPExcel_IOFactory::load($ruta);
          //$worksheet = $objPHPExcel->getActiveSheet('BMT');
        $worksheet = $objPHPExcel->setActiveSheetIndex(0);$rows = [];$fila = 0;

        //Extracion data del excel
        foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                $column = 1;
            $count = 0;
                foreach ($cellIterator as $cell) {
                    $count += 1;
                    if ($count > 183){
                        break;
                    }
                        $cells[] = $cell->getValue();
                    $column++;
                }
                $rows[] = $cells;
                $fila++;
        }


        //Validacion de Columnas.
        $_ERROR2 = valida_archivo_bmt::Val_CamposObligatorio($rows[13],2);
        if ($_ERROR2 != "" ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->No existe(n) en el archivo campo(s): '.$_ERROR2.'' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //nueva columna
        array_push($rows[13],"Unidades");
        array_push($rows[13],"ID_FILAS");

        $nom_columnas = array_flip($rows[13]);
        $limite = (count($rows)-1);
        for($i = 14;$i <= $limite; $i++){
            array_push($rows[$i],0);
            array_push($rows[$i],$i+1);
        }

        //validacion de temporada
        $_ERROR2 = valida_archivo_bmt::Val_Seasonbmt($rows,$limite,$nom_columnas,$temporada);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->La temporada del archivo no corresponde a la temporada seleccionada: Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //validacion de depto
        $_ERROR2 = valida_archivo_bmt::Val_deptobmt($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->No encuentran datos en el archivo.  Depto: [' . $depto . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }


        //borrar datos de basura.
        $rows = valida_archivo_bmt::eliminardatosrowsBMT($rows,$limite,$nom_columnas);
        $limite = (count($rows)-1);

        //validaciones rows
        $_ERROR2 = valida_archivo_bmt::Val_campos_bmt($rows,$limite,$nom_columnas,$depto,$cod_tempo);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //grupa los deptos.
        $rows = valida_archivo_bmt::Grupar_Depto($rows,$limite,$nom_columnas,$depto);
        $limite = (count($rows)-1);

        //insert historial bmt
        $_ERROR2 = plan_compra::InsertHistorialBmt($rows,$limite,$nom_columnas,$cod_tempo,$depto);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->Fila(s): [' . $_ERROR2["Error"] . ']' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }

        //calculo debut_reorder
        $rows = plan_compra::Calculo_DebutReorder($rows,$limite,$nom_columnas);

        //update color 3
        $_ERROR2 = plan_compra::InsertPlanCompraBMT($rows,$limite,$nom_columnas,$cod_tempo,$depto,$login);
        if ($_ERROR2["Tipo"] == false ){
            $f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$-> ' . $_ERROR2["Error"] . '.' . '$');
            $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
        }
        $f3->set('SESSION.modifica', 'Insertado Correctamente');
        $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));

    }
    }

public function guarda_pi($f3) {

        $estado_c1 = $_POST['send_archivo_estado_c1'];
        $id_color = $_POST['send_archivo_id_color'];
        $archivo_proforma = $_POST['send_archivo_proforma'];
        $archivo_filas = $_POST['send_archivo_filas'];

        $nombre_archivo = "PI_".$f3->get('SESSION.COD_TEMPORADA')."_".$f3->get('SESSION.COD_DEPTO')."_".$archivo_proforma.".xlsx";

        /*echo "<pre>";
        echo "<br>estado_c1:".$estado_c1;
        echo "<br>id_color: ".$id_color;
        echo "<br>archivo_proforma: ".$archivo_proforma;
        echo "<br>archivo_filas: ".$archivo_filas;*/


        $ids_insertar = "";
        $filas = explode("$", $archivo_filas);
        foreach($filas as $fil) {
            $fil_id_color = trim($fil);
            $ids_insertar .= "'$fil_id_color',";
        }

        // Aqui se almacenan las ID COLOR con las que se vaatrabajar.
        $ids_insertar = str_replace(",'',","",$ids_insertar);

        // Ruta Original
        //$dir_subida = $_SERVER['DOCUMENT_ROOT'].'/C1_AUTOMATICA_WEB/archivos/pi/';
        // Se modifica por la URL del config.ini del framework (Solicitud de JMC 27062018)
        $dir_subida = $f3->get('UPLOADS_PI');
        //$fichero_subido = $dir_subida . basename($_FILES['send_archivop_pi']['name']);
        $fichero_subido = $dir_subida . basename($nombre_archivo);

        // Si el archivo se subió correctamente, realizo las actualizaciones de los estados
        if (move_uploaded_file($_FILES['send_archivop_pi']['tmp_name'], $fichero_subido)) {

            // Actualizo Proforma y Estado en plc_plan_compra_color_3
            $update = \simulador_compra\cbx_grilla_compra::actualizaProformaEstado($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$archivo_proforma,$ids_insertar,$f3->get('SESSION.login'));

            // Insertamos en plc_plan_compra_historica
            $insert = \simulador_compra\cbx_grilla_compra::guardaHistorial($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$ids_insertar,$f3->get('SESSION.login'));

            // Insertamos en plc_plan_compra_oc
            $insert = \simulador_compra\cbx_grilla_compra::guardaOc($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$ids_insertar,$archivo_proforma,$f3->get('SESSION.login'));

            $mensaje ="El archivo se ha subido correctamente.";

        } else {
           $mensaje ="No se pudo subir el archivo";
        }

        //echo '<br>Más información de depuración:';
        //print_r($_FILES);

        // Vuelvo al Origen
        //$f3->set('SESSION.archivo', '$' . 'danger$$red$ERROR$->Archivo Enviado correctamente, favor revisar' . '$');
        $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));

    }

public function guarda_pi_server($f3) {

        $archivo_proforma = $_POST['send_archivo_proforma_server'];

        $nombre_archivo = "PI_".$f3->get('SESSION.COD_TEMPORADA')."_".$f3->get('SESSION.COD_DEPTO')."_".$archivo_proforma.".xlsx";

        // Ruta
        $dir_subida = $f3->get('UPLOADS_PI');
        $fichero_subido = $dir_subida . basename($nombre_archivo);

        // Si el archivo se subió correctamente, realizo las actualizaciones de los estados
        if (move_uploaded_file($_FILES['send_archivop_pi_server']['tmp_name'], $fichero_subido)) {
            return 1;
        } else {
            return 0;
        }


    }

public function SubirAssorment($f3){

    $tipo_archivo = $_POST['tipos_import'];

    if ($tipo_archivo == 1){
            $nombre_archivo = "Assorment-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
            $dir_subida = $f3->get('UPLOADSassorment');
            //$fichero_subido = $dir_subida . basename($_FILES['send_archivop_pi']['name']);
            $fichero_subido = $dir_subida . basename($nombre_archivo);

            if (move_uploaded_file($_FILES['user_file']['tmp_name'], $fichero_subido)) {
              echo 1;
            } else {
              echo 0;
            }
    }else{
        $nombre_archivo = "BMT-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
        $dir_subida = $f3->get('UPLOADS');
        //$fichero_subido = $dir_subida . basename($_FILES['send_archivop_pi']['name']);
        $fichero_subido = $dir_subida . basename($nombre_archivo);

        if (move_uploaded_file($_FILES['user_file']['tmp_name'], $fichero_subido)) {
            echo 1;
        } else {
            echo 0;
        }
    }
}

public function getJerarquia($f3){

    $rows = plan_compra::list_jerarquia($f3->get('GET.Depart'));

    $_SESSION['dtjerarquia']= $rows;
}

public function ImportarAssormentValidaciones($f3){

    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $login = $f3->get('SESSION.login');
    #region {*************Extrer Excel*************}
    error_reporting(E_ALL);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 9000000);

    $nombre_archivo = "Assorment-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
    $dir_subida = $f3->get('UPLOADSassorment').$nombre_archivo;

    $temporada = \temporada\temporada::getTemporadaCompra($cod_tempo)->NOM_TEMPORADA_CORTO;
    require_once '../class/PHPExcel/IOFactory.php';

    /* LEER ASSORMENT */
    $objPHPExcel = \PHPExcel_IOFactory::load($dir_subida);
    $worksheet = $objPHPExcel->getActiveSheet('Shopping List');
    $rows = [];
    $fila = 0;

    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        $column = 1;
        $count = 0;
        foreach ($cellIterator as $cell) {
            $count += 1;
            if ($count > 102){
                break;
            }
            if ($column <= 1 ){
                $cells[] = "s";
            }else {
                $cells[] = $cell->getCalculatedValue();
            }
            $column++;
        }
        $rows[] = $cells;
        $fila++;
    }

    $_error = true;
    $_array = [];
#endregion

    //Validacion de Columnas.
    $_ERROR2 = valida_archivo_bmt::Val_CamposObligatorio($rows[2],1);
    if ($_ERROR2 != "" ){
        $_array_error = [];
        array_push($_array_error, "false","No existe(n) en el archivo campo(s): ".$_ERROR2. ".");
        array_push($_array, $_array_error);
        $_error = false;
    }

    //Validacion de Columnas archivo en blanco
    if ($_error == true){
        array_push($rows[2],"Unidades");
        try {
            $nom_columnas = array_flip($rows[2]);
        }catch (Exception $e) {
            $_array_error = [];
            array_push($_array_error, "false","Existen colummnas en blanco.");
            array_push($_array, $_array_error);
            $_error = false;
        }
        $limite = (count($rows)-1);
        for($i = 3;$i <= $limite; $i++){
            array_push($rows[$i],0);
        }
    }

    //validacion de temporada
    if ($_error == true){
    $_ERROR2 = valida_archivo_bmt::Val_Season($rows,$limite,$nom_columnas,$temporada);
        if ($_ERROR2["Tipo"] == false ){
            $_array_error = [];
            array_push($_array_error, "false","La temporada del archivo no corresponde a la temporada seleccionada: Fila(s): " . $_ERROR2["Error"]);
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //validacion de depto
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_depto($rows, $limite, $nom_columnas, $depto);
        if ($_ERROR2["Tipo"] == false) {
            $_array_error = [];
            array_push($_array_error, "false","El código depto del archivo no corresponde a su selección en la C1: Fila(s): " . $_ERROR2["Error"].".");
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //validacion de grupo compra
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::val_grupo_compra($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){
            $_array_error = [];
            array_push($_array_error, "false","El archivo debe tener solo un grupo de compra.");
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //validacion de marca
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_marca($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2["Tipo"] == false ){
            $_array_error = [];
            array_push($_array_error, "false","El código marca no corresponde departamento seleccionado en la C1: Fila(s): ".$_ERROR2["Error"].".");
            array_push($_array, $_array_error);
            $_error = false;
        }}

    //validacion existe grupo compra
    if ($_error == true) {
    $_ERROR2 = valida_archivo_bmt::val_grupo_compra_x_estado($cod_tempo,$depto,$rows[3][$nom_columnas['Grupo de compra']],$rows[3][$nom_columnas['Codigo Marca']]);
    if ($_ERROR2["Tipo"] == false ){
        $_array_error = [];
        array_push($_array_error, "false",$_ERROR2["Error"]);
        array_push($_array, $_array_error);
        $_error = false;
    }}

    //validacion de una marca por assortment
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_soloUnaMarca($rows,$limite,$nom_columnas,$depto);
        if ($_ERROR2 != "" ){
            $_array_error = [];
            array_push($_array_error, "false","Existe más de una marca en el archivo: ".$_ERROR2.".");
            array_push($_array, $_array_error);
            $_error = false;
    }}

    //validacion de jerarquia
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_jerarquia($rows,$limite,$nom_columnas,$_SESSION['dtjerarquia']);
        if ($_ERROR2["Tipo"] == false ){
            $_array_error = [];
            array_push($_array_error, "false","La combinación Linea y Sublinea no existen PMM: Fila(s): ".$_ERROR2["Error"].".");
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //validacion de colores
    if ($_error == true) {
    $_ERROR2 = valida_archivo_bmt::Val_Colores($rows,$limite,$nom_columnas);
    if ($_ERROR2["Tipo"] == false ){
        $_array_error = [];
        array_push($_array_error, "false","El código de color no existen PMM: Fila(s): ".$_ERROR2["Error"].".");
        array_push($_array, $_array_error);
        $_error = false;
    }}

    //validacion del codigo opcion
    if ($_error == true){
        $_ERROR2 = valida_archivo_bmt::ValidaCodOpcion($rows,$limite,$nom_columnas,$temporada);
        if ($_ERROR2["Tipo"] == false ){
            $_array_error = [];
            array_push($_array_error, "false","Fila(s):".$_ERROR2["Error"]);
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //validacion de tipo producto y tipo de exhibicion
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_Tipo_Produc_Exhibicion($rows,$limite,$nom_columnas);
        if ($_ERROR2["Tipo"] == false ){
            $_array_error = [];
            array_push($_array_error, "false","Fila(s):".$_ERROR2["Error"]);
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //validacion Campos
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_Campos($rows, $limite, $nom_columnas,$cod_tempo, $depto,$f3);
        if ($_ERROR2["Tipo"] == false) {
            $_array_error = [];
            array_push($_array_error, "false","Fila(s):".$_ERROR2["Error"]);
            array_push($_array, $_array_error);
            $_error = false;
        }
    }


    //validacion de mstpack
    if ($_error == true) {
    $_ERROR2 = valida_archivo_bmt::val_mstpack($rows,$limite,$nom_columnas,$depto);
    if ($_ERROR2["Tipo"] == false ){
        $_array_error = [];
        array_push($_array_error, "false","No exísten master pack asociado o el master pack tiene que ser mayor a 0: Fila(s):".$_ERROR2["Error"]);
        array_push($_array, $_array_error);
        $_error = false;
     }
    }

    //validacion multiplos
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::valida_Multiplo($rows, $limite, $nom_columnas);
        if ($_ERROR2["Tipo"] == false) {
            $_array_error = [];
            array_push($_array_error, "false","El Número de curva por clúster no es múltiple al número curvas por cajas. Fila(s): ".$_ERROR2["Error"]);
            array_push($_array, $_array_error);
            $_error = false;

        }
    }




    //fin de validacion
    if ($_error == true ){
        $_array_error = [];
        array_push($_array_error, "True","");
        array_push($_array, $_array_error);
        $_error = false;
    }

     echo json_encode($_array);

}

public function ImportarAssormentdelrows($f3){

#region {*************Extrer Excel*************}
        error_reporting(E_ALL);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 9000000);

        $nombre_archivo = "Assorment-" . $f3->get('SESSION.COD_TEMPORADA') . "-" . $f3->get('SESSION.COD_DEPTO') . ".xls";
        $dir_subida = $f3->get('UPLOADSassorment') . $nombre_archivo;

        require_once '../class/PHPExcel/IOFactory.php';

        /* LEER ASSORMENT */
        $objPHPExcel = \PHPExcel_IOFactory::load($dir_subida);
        $worksheet = $objPHPExcel->getActiveSheet('Shopping List');
        $rows = [];
        $fila = 0;

        foreach ($worksheet->getRowIterator() AS $row) {

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            $column = 1;
            $count = 0;
            foreach ($cellIterator as $cell) {
                $count += 1;
                if ($count > 102) {
                    break;
                }
                if ($column <= 1) {
                    $cells[] = "s";
                } else {
                    $cells[] = $cell->getCalculatedValue();
                }
                /*if ($column == 29 && $fila >= 14) { // TARGET BUDGET
                    $cells[] = $cell->getCalculatedValue();
                } elseif ($column == 30 && $fila >= 14) { //TOTAL QUANTITY
                    $cells[] = $cell->getCalculatedValue();
                } elseif ($column == 32 && $fila >= 14) {
                    $cells[] = $cell->getCalculatedValue();
                } else {
                    $cells[] = $cell->getValue();
                }*/
                //$cells[] = $cell->getValue();
                $column++;
            }
            $rows[] = $cells;
            $fila++;
        }

        array_push($rows[2],"Unidades");
        $nom_columnas = array_flip($rows[2]);
        $limite = (count($rows)-1);
        for($i = 3;$i <= $limite; $i++){
            array_push($rows[$i],0);
        }
#endregion
        //borrar datos de basura.
        $rows = valida_archivo_bmt::eliminardatosrows($rows,$limite,$nom_columnas);
        echo json_encode($rows);

}

public function ImportarAssormentInsHistorial($f3){

    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $rows =  $_POST['_rows'];
    $Columnas = array_flip($_POST['_columnas']);
    $codMarca = $rows[$Columnas['Codigo Marca']];


   if ($_POST['_delete'] == 1 ){
        $grupo_compra = $rows[$Columnas['Grupo de compra']];
        plan_compra::InsertHistoricadelAssorment($cod_tempo,$depto,$codMarca,$grupo_compra);
    }

    $_ERROR = plan_compra::InsertHistoricaAssortment2($rows,$Columnas,$cod_tempo,$depto,$codMarca);


   $_val = "";
    if ($_ERROR["Tipo"] == false ){
       $_val = "false".",".$_ERROR["Error"];
    }else{
       $_val = "True".","."1";
    }

    echo $_val;
}

public function ImpAssormAbrirDataVent($f3){
    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');

    #region {*************Extrer Excel*************}
    error_reporting(E_ALL);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 9000000);

    $nombre_archivo = "Assorment-" . $f3->get('SESSION.COD_TEMPORADA') . "-" . $f3->get('SESSION.COD_DEPTO') . ".xls";
    $dir_subida = $f3->get('UPLOADSassorment') . $nombre_archivo;

    require_once '../class/PHPExcel/IOFactory.php';

    /* LEER ASSORMENT */
    $objPHPExcel = \PHPExcel_IOFactory::load($dir_subida);
    $worksheet = $objPHPExcel->getActiveSheet('Shopping List');
    $rows = [];
    $fila = 0;


    foreach ($worksheet->getRowIterator() AS $row) {

        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        $column = 1;
        $count = 0;
        foreach ($cellIterator as $cell) {
            $count += 1;
            if ($count > 102) {
                break;
            }
            if ($column <= 1) {
                $cells[] = "s";
            } else {
                $cells[] = $cell->getCalculatedValue();
            }
            /*if ($column == 29 && $fila >= 14) { // TARGET BUDGET
                $cells[] = $cell->getCalculatedValue();
            } elseif ($column == 30 && $fila >= 14) { //TOTAL QUANTITY
                $cells[] = $cell->getCalculatedValue();
            } elseif ($column == 32 && $fila >= 14) {
                $cells[] = $cell->getCalculatedValue();
            } else {
                $cells[] = $cell->getValue();
            }*/
            //$cells[] = $cell->getValue();
            $column++;
        }
        $rows[] = $cells;
        $fila++;
    }

    array_push($rows[2],"Unidades");
    $nom_columnas = array_flip($rows[2]);
    $limite = (count($rows)-1);
    for($i = 3;$i <= $limite; $i++){
        array_push($rows[$i],0);
    }
#endregion

    //borrar datos de basura.
    $rows = valida_archivo_bmt::eliminardatosrows($rows,$limite,$nom_columnas);
    $limite = (count($rows)-1);


    //reabrir datos por ventana
    $rows = valida_archivo_bmt::Separacion_Data_Ventana2($rows,$nom_columnas,$cod_tempo,$depto);
    //$limite = (count($rows)-1);
    //$nom_columnas = array_flip($rows[0]);

    $_SESSION['dtSeparacionVent']= $rows;

    if ( count($_SESSION['dtSeparacionVent']) > 0){
       echo 1;
    }else{
        echo 0;
    }

}

public function ImpAssormCalculos($f3){

        $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
        $depto = $f3->get('SESSION.COD_DEPTO');
        $rows = $_SESSION['dtSeparacionVent'];
        $Columnas = $rows[0];
        $login = $f3->get('SESSION.login');

       //cabesera
        $addcolumnCabezera =  plan_compra::get_columnas_archivos(3);

        foreach ($addcolumnCabezera as $Val){
            array_push($Columnas,$Val['COLUMNAS']);
        }
        $Columnas = array_flip($Columnas);

        //Calculo del curvado y costos + insert PLC_AJUSTES_COMPRA + delete rows
        $rows = plan_compra::ImpAssorCalculos($rows,$Columnas,$cod_tempo,$depto,$login,$_SESSION['dtjerarquia'],$f3);



        echo json_encode($rows);


    }

public function InsertarAssormentC1($f3){

  $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $rows = $_POST['_rows'];
    $Columnas = $_POST['_columnas'];
    $login = $f3->get('SESSION.login');


    $_ERROR = plan_compra::InsertPlanCompraAssorment2($rows,$Columnas,$cod_tempo,$depto,$login);

    $_val = "";
    if ($_ERROR["Tipo"] == false ){
        $_val = "false".",".$_ERROR["Error"];
    }else{
        $_val = "True".","."1";
    }
    echo $_val;
}

public function Mensaje_Guardado($f3){
        $f3->set('SESSION.exito', 'Insertado Correctamente');
        $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));

}

public function ImportarBmtValidaciones($f3){

    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $login = $f3->get('SESSION.login');
    #region {*************Extrer Excel*************}
    error_reporting(E_ALL);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 9000000);

    $nombre_archivo = "BMT-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
    $dir_subida = $f3->get('UPLOADS').$nombre_archivo;

    $temporada = \temporada\temporada::getTemporadaCompra($cod_tempo)->NOM_TEMPORADA_CORTO;
    require_once '../class/PHPExcel/IOFactory.php';

    /* LEER BMT*/
    $objPHPExcel = \PHPExcel_IOFactory::load($dir_subida);
    $worksheet = $objPHPExcel->getActiveSheet('BMT');
    $rows = [];
    $fila = 0;

    //Extracion data del excel
    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        $column = 1;
        $count = 0;
        foreach ($cellIterator as $cell) {
            $count += 1;
            if ($count > 183){
                break;
            }
            if ($column <= 1 ){
                $cells[] = "s";
            }else {
                $cells[] = $cell->getCalculatedValue();
            }
            $column++;
        }
        $rows[] = $cells;
        $fila++;
    }
    #endregion

    $_error = true;
    $_array = [];
    $nom_columnas = [];
    $limite = 0;

    //Validacion de Columnas.
    $_ERROR2 = valida_archivo_bmt::Val_CamposObligatorio($rows[13],2);
    if ($_ERROR2 != "" ){
        $_array_error = [];
        array_push($_array_error, "false","No existe(n) en el archivo campo(s): ".$_ERROR2. ".");
        array_push($_array, $_array_error);
        $_error = false;
    }

    //Nueva columna
    if ($_error == true) {
        array_push($rows[13], "Unidades");
        array_push($rows[13], "ID_FILAS");
        $nom_columnas = array_flip($rows[13]);
        $limite = (count($rows) - 1);
        for($i = 14;$i <= $limite; $i++){
            array_push($rows[$i],0);
            array_push($rows[$i],$i+1);
        }
    }

    //validacion de temporada
    if ($_error == true){
        $_ERROR2 = valida_archivo_bmt::Val_Seasonbmt($rows,$limite,$nom_columnas,$temporada);
        if ($_ERROR2["Tipo"] == false ){
            $_array_error = [];
            array_push($_array_error, "false","La temporada del archivo no corresponde a la temporada seleccionada: Fila(s): " . $_ERROR2["Error"]);
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //validacion de depto
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_deptobmt($rows, $limite, $nom_columnas, $depto);
        if ($_ERROR2["Tipo"] == false) {
            $_array_error = [];
            array_push($_array_error, "false", "No encuentran datos en el archivo.  Depto: [' . $depto . ']");
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //borrar datos de basura.
    $rows = valida_archivo_bmt::eliminardatosrowsBMT($rows,$limite,$nom_columnas);
    $limite = (count($rows)-1);

    //Validaciones rows
    if ($_error == true) {
        $_ERROR2 = valida_archivo_bmt::Val_campos_bmt($rows, $limite, $nom_columnas, $depto, $cod_tempo,$_SESSION['dtjerarquia'],$f3);
        if ($_ERROR2["Tipo"] == false) {
            $_array_error = [];
            array_push($_array_error, "false","Fila(s):".$_ERROR2["Error"]);
            array_push($_array, $_array_error);
            $_error = false;
        }
    }

    //fin de validacion
    if ($_error == true ){
        $_array_error = [];
        array_push($_array_error, "True","");
        array_push($_array, $_array_error);
        $_error = false;
    }
    echo json_encode($_array);
}

public function ImportarBmtdelrows($f3){

#region {*************Extrer Excel*************}
    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $login = $f3->get('SESSION.login');
    #region {*************Extrer Excel*************}
    error_reporting(E_ALL);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 9000000);

    $nombre_archivo = "BMT-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
    $dir_subida = $f3->get('UPLOADS').$nombre_archivo;

    $temporada = \temporada\temporada::getTemporadaCompra($cod_tempo)->NOM_TEMPORADA_CORTO;
    require_once '../class/PHPExcel/IOFactory.php';

    /* LEER BMT*/
    $objPHPExcel = \PHPExcel_IOFactory::load($dir_subida);
    $worksheet = $objPHPExcel->getActiveSheet('BMT');
    $rows = [];
    $fila = 0;

    //Extracion data del excel
    foreach ($worksheet->getRowIterator() AS $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        $cells = [];
        $column = 1;
        $count = 0;
        foreach ($cellIterator as $cell) {
            $count += 1;
            if ($count > 183){
                break;
            }
            if ($column <= 1 ){
                $cells[] = "s";
            }else {
                $cells[] = $cell->getCalculatedValue();
            }
            $column++;
        }
        $rows[] = $cells;
        $fila++;
    }
    #endregion

    array_push($rows[13], "Unidades");
    array_push($rows[13], "ID_FILAS");
    $nom_columnas = array_flip($rows[13]);
    $limite = (count($rows) - 1);
    for($i = 14;$i <= $limite; $i++){
        array_push($rows[$i],0);
        array_push($rows[$i],$i+1);
    }

#endregion
    //borrar datos de basura.
    $rows = valida_archivo_bmt::eliminardatosrowsBMT($rows,$limite,$nom_columnas);
     $_SESSION['dtBMT']= $rows;


     //borrar historial bmt
        $Columnas = array_flip($rows[0]); $Marcas = [];
        $key = 0;
        foreach ($rows as $t){$key++;
            if($key <> 1){
                array_push($Marcas,strtoupper($t[$Columnas['LOCAL BRAND']]));
            }
        }
        $Marcas = array_unique($Marcas);
        $grupo_compra = $rows[1][$Columnas['PURCHASE GROUP']];;
        plan_compra::InsertHistoricadelBMT($cod_tempo,$depto,$Marcas,$grupo_compra);
     echo json_encode($rows);
    }

public function ImportarBmtInsHistorial($f3){
  $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
  $rows =  $_POST['_rows'];
  $Columnas = array_flip($_POST['_columnas']);

    //insert historial bmt
    $_ERROR = plan_compra::InsertHistorialBmt($rows,$Columnas,$cod_tempo);

    $_val = "";
    if ($_ERROR["Tipo"] == false ){
        $_val = "false".",".$_ERROR["Error"];
    }else{
        $_val = "True".","."1";
    }

    echo $_val;
}

public function ImpBMTCalculoDebut_reorder($f3){

    $rows = $_SESSION['dtBMT'];
    $nom_columnas = array_flip($rows[0]);
    $limite = count($rows)-1;
    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');

    //$rows= plan_compra::Calculo_DebutReorderBMT($rows,$limite,$nom_columnas,$cod_tempo,$depto);
    $_SESSION['dtBMTconReorder']= $rows;
    echo json_encode($rows);
}

public function ImpBMTCalculosCurvado($f3){

    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $rows = $_SESSION['dtBMTconReorder'];
    $nom_columnas = array_flip($rows[0]);
    $limite = count($rows)-1;

    //$_error = valida_archivo_bmt::del_idcolor3_plan_compra($rows,$limite,$nom_columnas,$depto,$cod_tempo,$rows[1][$nom_columnas['PURCHASE GROUP']],$login);
    //if ($_error == true) {
        $rows = plan_compra::ImpBMTCalculos($rows, $limite, $nom_columnas, $cod_tempo, $depto,$f3);
    //}else{
        //$rows =[];
    //}

    echo json_encode($rows);
}

public function ActualizBmtC1($f3){
    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $rows = $_POST['_rows'];
    $Columnas = $_POST['_columnas'];

    $_ERROR = plan_compra::ActualizaPlanCompraBMT($rows,$Columnas,$cod_tempo,$depto);

    $_val = "";
    if ($_ERROR["Tipo"] == false ){
        $_val = "false".",".$_ERROR["Error"];
    }else{
        $_val = "True".","."1";
    }
    echo $_val;
}

public function Mensaje_GuardadoBMT($f3){
        $f3->set('SESSION.modifica', 'Actualizado Correctamente');
        $f3->reroute('/simulador_compra?depto=' . $f3->get('SESSION.COD_DEPTO'));
    }

public function beforeRoute($f3) {
        if ($f3->exists('SESSION.login') == false) {
            $f3->reroute('/fin-sesion');
        }
    }

// Fin del Controlador
}