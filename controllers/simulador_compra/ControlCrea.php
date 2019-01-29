<?php

/**
 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
 * Descripción: 
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 * @edita ROBERTO PEREZ
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

        $id_color = $_POST['send_archivo_id_color_server'];
        $archivo_proforma = $_POST['send_archivo_proforma_server'];
        $nombre_archivo = "PI_".$f3->get('SESSION.COD_TEMPORADA')."_".$f3->get('SESSION.COD_DEPTO')."_".$archivo_proforma.".xlsx";

        // Ruta
        $dir_subida = $f3->get('UPLOADS_PI');
        $fichero_subido = $dir_subida . basename($nombre_archivo);

        // Si el archivo se subió correctamente, realizo las actualizaciones de los estados
        if (move_uploaded_file($_FILES['send_archivop_pi_server']['tmp_name'], $fichero_subido)) {
                echo $archivo_proforma;
        } else {
            echo "ERROR";
        }


    }

public function SubirAssorment($f3){

    $tipo_archivo = $_POST['Tipo_archivo'];
    if ($tipo_archivo == 1){
            $nombre_archivo = "Assorment-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
            $dir_subida = $f3->get('UPLOADSassorment');
            //$fichero_subido = $dir_subida . basename($_FILES['send_archivop_pi']['name']);
            $fichero_subido = $dir_subida . basename($nombre_archivo);

            if (move_uploaded_file($_FILES['JSONGuardaArhcivo']['tmp_name'], $fichero_subido)) {
              echo "";
            } else {
              echo "ERROR";
            }
    }else{
        $nombre_archivo = "BMT-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
        $dir_subida = $f3->get('UPLOADS');
        //$fichero_subido = $dir_subida . basename($_FILES['send_archivop_pi']['name']);
        $fichero_subido = $dir_subida . basename($nombre_archivo);

        if (move_uploaded_file($_FILES['JSONGuardaArhcivo']['tmp_name'], $fichero_subido)) {
            echo "";
        } else {
            echo "ERROR";
        }
    }
}

public function getJerarquia($f3){

    $rows = plan_compra::list_jerarquia($f3->get('GET.Depart'));

    $_SESSION['dtjerarquia']= $rows;
}


public function ImportarAssormentValidaciones2($f3){

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
            if ($count > 104){
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

    //Validacion de Columnas archivo en bl8anco
    if ($_error == true){
        try {$nom_columnas = array_flip($rows[2]);
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
public function ImportarAssormentInsHistorial2($f3){

    $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
    $depto = $f3->get('SESSION.COD_DEPTO');
    $rows =  $_POST['_rows'];
    $Columnas = array_flip($_POST['_columnas']);
    $codMarca = $rows[$Columnas['Codigo Marca']];

   if ($_POST['_delete'] == 1 ){
        $grupo_compra = $rows[$Columnas['Grupo de compra']];
        plan_compra::InsertHistoricadelAssorment($cod_tempo,$depto,$codMarca,$grupo_compra);
    }

    $_ERROR = plan_compra::InsertHistoricaAssortment2($rows,$cod_tempo,$depto,$codMarca);

   $_val = "";
    if ($_ERROR["Tipo"] == false ){
       $_val = "false".",".$_ERROR["Error"];
    }else{
       $_val = "True".","."1";
    }

    echo $_val;
    }
public function ImpAssormAbrirDataVent2($f3){

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
            if ($count > 104) {
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

    $nom_columnas = array_flip($rows[2]);
    $limite = (count($rows)-1);
    for($i = 3;$i <= $limite; $i++){
        array_push($rows[$i],0);
    }
#endregion



    //borrar datos de basura.
    $rows = valida_archivo_bmt::eliminardatosrows($rows,$limite,$nom_columnas);
    $limite = (count($rows)-1);

        //reabrir datos
    $rows = valida_archivo_bmt::Limpieza_data_Assortment($rows,$nom_columnas);
    $_SESSION['dtAssorment']= $rows;

    if ( count($_SESSION['dtAssorment']) > 0){
       echo 1;
    }else{
        echo 0;
    }

    }
public function ImpAssormCalculos2($f3){

        $cod_tempo = $f3->get('SESSION.COD_TEMPORADA');
        $depto = $f3->get('SESSION.COD_DEPTO');
        $rows = $_SESSION['dtAssorment'];
        $Columnas = $rows[0];
        $login = $f3->get('SESSION.login');

       //cabesera
        $addcolumnCabezera =  plan_compra::get_columnas_archivos(3);

        foreach ($addcolumnCabezera as $Val){
            array_push($Columnas,$Val['COLUMNAS']);
        }
        $Columnas = array_flip($Columnas);

        //Calculo del curvado y costos + insert PLC_AJUSTES_COMPRA + delete rows
        $rows = plan_compra::ImpAssorCalculos($rows,$Columnas,$cod_tempo,$depto,$_SESSION['dtjerarquia'],$f3);
        echo json_encode($rows);
    }
public function InsertarAssormentC12($f3){

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

//Importar Assortment
Public function ImportarAssormentExtraccionDatos($f3){

        #region {*************Extrer Excel*************}
        $_array = array("Error" => "","msjError" => "");
        try {
            error_reporting(E_ALL);
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 9000000);

            $nombre_archivo = "Assorment-".$f3->get('SESSION.COD_TEMPORADA')."-".$f3->get('SESSION.COD_DEPTO').".xls";
            $dir_subida = $f3->get('UPLOADSassorment').$nombre_archivo;
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
                    if ($count > 113){
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

            $_SESSION['dtAssorment'] = $rows;
            $_array["Error"] = false;
            $_array["msjError"]= "";
            echo json_encode($_array);
        } catch (Exception $e) {

            $_array["Error"] = true;
            $_array["msjError"]= "Error de Carga del archivo";
            echo json_encode($_array);
        }


    }
public function ImportarAssormentValidaciones($f3){

    $rows = $_SESSION['dtAssorment'];
    $tipo = $_GET["Tipo"];
    $_error = true;
    $_array = array("Error" => "","msjError" => "");
    $temporada = \temporada\temporada::getTemporadaCompra($f3->get('SESSION.COD_TEMPORADA'))->NOM_TEMPORADA_CORTO;

    if ($tipo == 1){
        //Validacion de Columnas.
        $_ERROR2 = valida_archivo_bmt::Val_CamposObligatorio($rows[2],1);
        if ($_ERROR2 != "" ){
            $_array["Error"] = true;
            $_array["msjError"]= "No existe(n) en el archivo campo(s): ".$_ERROR2. ".";
            $_error = false;
        }

        //Validacion de Columnas archivo en blanco
        if ($_error == true){
            try {$nom_columnas = array_flip($rows[2]);
            }catch (Exception $e) {
                $_array["Error"] = true;
                $_array["msjError"]= "Existen colummnas en blanco.";
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
                $_array["Error"] = true;
                $_array["msjError"]= "La temporada del archivo no corresponde a la temporada seleccionada: Fila(s): " . $_ERROR2["Error"];
                $_error = false;
            }
        }

        //validacion de depto
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::Val_depto($rows, $limite, $nom_columnas, $f3->get('SESSION.COD_DEPTO'));
            if ($_ERROR2["Tipo"] == false) {
                $_array["Error"] = true;
                $_array["msjError"]= "El código depto del archivo no corresponde a su selección en la C1: Fila(s): " . $_ERROR2["Error"];
                $_error = false;
            }
        }

        //validacion de grupo compra
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::val_grupo_compra($rows,$limite,$nom_columnas);
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "El archivo debe tener solo un grupo de compra.";
                $_error = false;
            }
        }

        //validacion de marca
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::Val_marca($rows,$limite,$nom_columnas,$f3->get('SESSION.COD_DEPTO'));
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "El código marca no corresponde departamento seleccionado en la C1: Fila(s): ".$_ERROR2["Error"];
                $_error = false;
            }}

        //validacion existe grupo compra
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::val_grupo_compra_x_estado($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$rows[3][$nom_columnas['Grupo de compra']],$rows[3][$nom_columnas['Codigo Marca']]);
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= $_ERROR2["Error"];
                $_error = false;
            }}

        //validacion de una marca por assortment
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::Val_soloUnaMarca($rows,$limite,$nom_columnas,$f3->get('SESSION.COD_DEPTO'));
            if ($_ERROR2 != "" ){
                $_array["Error"] = true;
                $_array["msjError"]= "Existe más de una marca en el archivo: ".$_ERROR2;
                $_error = false;

            }}

        //validacion de jerarquia
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::Val_jerarquia($rows,$limite,$nom_columnas,$_SESSION['dtjerarquia']);
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "La combinación Linea y Sublinea no existen PMM: Fila(s): ".$_ERROR2["Error"];
                $_error = false;
            }
        }
        //validacion de colores
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::Val_Colores($rows,$limite,$nom_columnas);
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "El código de color no existen PMM: Fila(s): ".$_ERROR2["Error"];
                $_error = false;
            }
        }

        if ($_error == true){
        for($i = 3;$i <= $limite; $i++){
            if ($rows[$i][$nom_columnas['Fecha de Embarque Acordada']] != null and $rows[$i][$nom_columnas['Fecha de Embarque Acordada']] != "" and $rows[$i][$nom_columnas['Fecha de Embarque Acordada']] != "0"){
               if (is_numeric($rows[$i][$nom_columnas['Fecha de Embarque Acordada']]) == true){
                   $rows[$i][$nom_columnas['Fecha de Embarque Acordada']] = plan_compra::format_fecha($rows[$i][$nom_columnas['Fecha de Embarque Acordada']]);
               }else{
                   $rows[$i][$nom_columnas['Fecha de Embarque Acordada']] = str_replace("-","/",$rows[$i][$nom_columnas['Fecha de Embarque Acordada']]);
               }
            }
        }
        }
        $_SESSION['dtAssorment']=$rows;
    }
    else{

        $limite = (count($rows)-1);
        $nom_columnas = array_flip($rows[2]);
        //validacion del codigo opcion
        if ($_error == true){
            $_ERROR2 = valida_archivo_bmt::ValidaCodOpcion($rows,$limite,$nom_columnas,$temporada,$f3->get('SESSION.COD_DEPTO'),$f3->get('SESSION.COD_TEMPORADA'));
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "Fila(s):".$_ERROR2["Error"];
                $_error = false;
            }
        }
        //validacion del codigo corporativo
        if ($_error == true){
            $_ERROR2 = valida_archivo_bmt::ValidaCodCorporativo($rows,$limite,$nom_columnas,$temporada,$f3->get('SESSION.COD_DEPTO'),$f3->get('SESSION.COD_TEMPORADA'));
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "Fila(s):".$_ERROR2["Error"];
                $_error = false;
            }
        }



        //validacion de tipo producto y tipo de exhibicion
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::Val_Tipo_Produc_Exhibicion($rows,$limite,$nom_columnas);
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "Fila(s):".$_ERROR2["Error"];
                $_error = false;
            }
        }

        //validacion Campos
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::Val_Campos($rows, $limite, $nom_columnas,$f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'),$f3,$temporada);
            if ($_ERROR2["Tipo"] == false) {
                $_array["Error"] = true;
                $_array["msjError"]= "Fila(s):".$_ERROR2["Error"];
                $_error = false;
            }
        }

        //validacion de mstpack
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::val_mstpack($rows,$limite,$nom_columnas,$f3->get('SESSION.COD_DEPTO'));
            if ($_ERROR2["Tipo"] == false ){
                $_array["Error"] = true;
                $_array["msjError"]= "No exísten master pack asociado o el master pack tiene que ser mayor a 0: Fila(s):".$_ERROR2["Error"];
                $_error = false;
            }
        }

        //validacion multiplos
        if ($_error == true) {
            $_ERROR2 = valida_archivo_bmt::valida_Multiplo($rows, $limite, $nom_columnas);
            if ($_ERROR2["Tipo"] == false) {
                $_array["Error"] = true;
                $_array["msjError"]= "El Número de curva por clúster no es múltiple al número curvas por cajas. Fila(s): ".$_ERROR2["Error"];
                $_error = false;

            }
        }
    }
    //fin de validacion
    if ($_error == true ){
        $_array["Error"] = false;
        $_array["msjError"]= "";
    }
    echo json_encode($_array);

}
public function ImportarAssormentdelrows(){

#region {*************Extrer Excel*************}
    $rows = $_SESSION['dtAssorment'];
    $limite = (count($rows)-1);
    $nom_columnas = array_flip($rows[2]);

        //borrar datos de basura.
        $rows = valida_archivo_bmt::eliminardatosrows2($rows,$limite,$nom_columnas);
        $array_asoc = [];
        //array asociativo
        foreach ($rows as $val){
            array_push($array_asoc
                ,array("s"=>$val[0],
                    "Cod Dpto"=>$val[1],
                    "Dpto"=>$val[2],
                    "Marca"=>$val[3],
                    "Codigo Marca"=>$val[4],
                    "Nombre Comprador"=>$val[5],
                    "Nombre Disenador"=>$val[6],
                    "Season"=>$val[7],
                    "Linea"=>$val[8],
                    "Cod Linea"=>$val[9],
                    "Sublinea"=>$val[10],
                    "Cod Sublinea"=>$val[11],
                    "Codigo corporativo"=>$val[12],
                    "Nombre Estilo"=>$val[13],
                    "Estilo Corto"=>$val[14],
                    "Descripcion Estilo"=>$val[15],
                    "Descripcion Internet"=>$val[16],
                    "Cod Opcion"=>$val[17],
                    "Color"=>$val[18],
                    "Cod Color"=>$val[19],
                    "Composicion"=>$val[20],
                    "Tipo de Tela"=>$val[21],
                    "Forro"=>$val[22],
                    "Calidad"=>$val[23],
                    "Coleccion"=>$val[24],
                    "Estilo de Vida"=>$val[25],
                    "Ocasion de uso"=>$val[26],
                    "Evento"=>$val[27],
                    "Evento In Store"=>$val[28],
                    "Grupo de compra"=>$val[29],
                    "Ventana"=>$val[30],
                    "Tipo exhibicion"=>$val[31],
                    "Tipo Producto"=>$val[32],
                    "Debut o Reorder"=>$val[33],
                    "Temporada"=>$val[34],
                    "Precio"=>$val[35],
                    "Oferta"=>$val[36],
                    "2x"=>$val[37],
                    "Opex"=>$val[38],
                    "Ranking de venta"=>$val[39],
                    "Ciclo de Vida"=>$val[40],
                    "Piramide Mix"=>$val[41],
                    "Ratio compra"=>$val[42],
                    "Factor amplificacion"=>$val[43],
                    "Ratio compra final"=>$val[44],
                    "Cluster"=>$val[45],
                    "Formato"=>$val[46],
                    "Compra Unidades Assortment"=>$val[47],
                    "Compra Unidades final"=>$val[48],
                    "Var%"=>$val[49],
                    "Target USD"=>$val[50],
                    "FOB USD"=>$val[51],
                    "RFID USD"=>$val[52],
                    "INSP USD"=>$val[53],
                    "Via"=>$val[54],
                    "Pais"=>$val[55],
                    "Proveedor"=>$val[56],
                    "Comentarios Post Negociacion"=>$val[57],
                    "Fecha de Embarque Acordada"=>$val[58],
                    "Factor"=>$val[59],
                    "Costo Total"=>$val[60],
                    "Retail Total sin iva"=>$val[61],
                    "MUP Compra"=>$val[62],
                    "Exhibicion"=>$val[63],
                    "Talla1"=>$val[64],
                    "Talla2"=>$val[65],
                    "Talla3"=>$val[66],
                    "Talla4"=>$val[67],
                    "Talla5"=>$val[68],
                    "Talla6"=>$val[69],
                    "Talla7"=>$val[70],
                    "Talla8"=>$val[71],
                    "Talla9"=>$val[72],
                    "Inner"=>$val[73],
                    "Curva1"=>$val[74],
                    "Curva2"=>$val[75],
                    "Curva3"=>$val[76],
                    "Curva4"=>$val[77],
                    "Curva5"=>$val[78],
                    "Curva6"=>$val[79],
                    "Curva7"=>$val[80],
                    "Curva8"=>$val[81],
                    "Curva9"=>$val[82],
                    "Validador Masterpack/Inner"=>$val[83],
                    "Tipo de empaque"=>$val[84],
                    "N curvas por caja curvadas"=>$val[85],
                    "1_%"=>$val[86],
                    "2_%"=>$val[87],
                    "3_%"=>$val[88],
                    "4_%"=>$val[89],
                    "5_%"=>$val[90],
                    "6_%"=>$val[91],
                    "7_%"=>$val[92],
                    "8_%"=>$val[93],
                    "9_%"=>$val[94],
                    "TiendasA"=>$val[95],
                    "TiendasB"=>$val[96],
                    "TiendasC"=>$val[97],
                    "TiendasI"=>$val[98],
                    "ClusterA"=>$val[99],
                    "ClusterB"=>$val[100],
                    "ClusterC"=>$val[101],
                    "ClusterI"=>$val[102],
                    "Size%1"=>$val[103],
                    "Size%2"=>$val[104],
                    "Size%3"=>$val[105],
                    "Size%4"=>$val[106],
                    "Size%5"=>$val[107],
                    "Size%6"=>$val[108],
                    "Size%7"=>$val[109],
                    "Size%8"=>$val[110],
                    "Size%9"=>$val[111],
                    "UNIDADES"=>$val[112],
                    "cod_piramidemix"=>"",
                    "und_finales"=>"",
                    "Sem_ini"=>"",
                    "sem_fin"=>"",
                    "ciclo"=>"",
                    "cod_rnk"=>"",
                    "tdas"=>"",
                    "GM"=>"",
                    "cod_vent"=>"",
                    "semliq"=>"",
                    "cos_uni_finalUS"=>"",
                    "cos_uni_final$"=>"",
                    "cos_total_$"=>"",
                    "cod_ciclo_vida"=>"",
                    "cos_retail"=>"",
                    "mst_pack"=>"",
                    "mkup"=>"",
                    "cod_via"=>"",
                    "cod_pais"=>"",
                    "cos_total_target"=>"",
                    "n_cajas"=>"",
                    "primer_reparto"=>"",
                    "tallas"=>"",
                    "curva_reparto"=>"",
                    "porcent_ajust"=>"",
                    "cod_temp"=>"",
                    "diferencia"=>"",
                    "nom_linea"=>"",
                    "nom_sublinea"=>"",
                    "nom_marca"=>"",
                    "porcent_1"=>"",
                    "porcent_2"=>"",
                    "porcent_3"=>"",
                    "porcent_4"=>"",
                    "porcent_5"=>"",
                    "porcent_6"=>"",
                    "porcent_7"=>"",
                    "porcent_8"=>"",
                    "porcent_9"=>"",
                    "cant_1"=>"",
                    "cant_2"=>"",
                    "cant_3"=>"",
                    "cant_4"=>"",
                    "cant_5"=>"",
                    "cant_6"=>"",
                    "cant_7"=>"",
                    "cant_8"=>"",
                    "cant_9"=>"",
                    "porcent_ini"=>"",
                    "opcion_ajus"=>"",
                    "id_color3"=>"",
                    "n_tdas"=>"",
                    "cos_total_fob_us"=>"",
                    "cod_estilo_vida"=>"",
                    "cod_ocacion_uso"=>"",
                    "cod_calidad"=>""
                ));
        }


        $_SESSION['dtAssorment'] = $array_asoc;
        echo json_encode($array_asoc);
}
public function ImportarAssormentInsHistorial($f3){

        $rows =  $_POST['_rows'];
        //borrado Historial assortment;
        if ($_POST['_delete'] == 1 ){
            $grupo_compra = $rows['Grupo de compra'];
            plan_compra::InsertHistoricadelAssorment($f3->get('SESSION.COD_TEMPORADA')
                                                    ,$f3->get('SESSION.COD_DEPTO')
                                                    ,$rows['Codigo Marca']
                                                    ,$grupo_compra);
        }
        //Insertado Historial assortment;
        $_ERROR = plan_compra::InsertHistoricaAssortment2($rows
                                                          ,$f3->get('SESSION.COD_TEMPORADA')
                                                          ,$f3->get('SESSION.COD_DEPTO')
                                                          ,$rows['Codigo Marca']);
        echo json_encode($_ERROR);
    }
public function ImpAssormAbrirDataVent(){
        $_array = array("Error" => "","msjError" => "");
        $rows = $_SESSION['dtAssorment'];
        $limite = (count($rows)-1);
        //reabrir datos
        $rows = valida_archivo_bmt::Limpieza_data_Assortment($rows,$limite);
        $_SESSION['dtAssorment']= $rows;

        if ( count($_SESSION['dtAssorment']) > 0){
            $_array["Error"] = false;
            $_array["msjError"]= "";
        }else{
            $_array["Error"] = true;
            $_array["msjError"]= "No exísten datos calculables, porque no tiene la jerarquía completa.";
        }
        echo json_encode($_array);
    }
public function ImpAssormCalculos($f3){

        $rows = $_SESSION['dtAssorment'];
        $limite = (count($rows)-1);

        //Calculo del curvado y costos + insert PLC_AJUSTES_COMPRA + delete rows
        $rows = plan_compra::ImpAssorCalculos($rows,$f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$_SESSION['dtjerarquia'],$f3,$limite);
        
        echo json_encode($rows);
    }
public function InsertarAssormentC1($f3){

    //insertado en el plan
        $_ERROR = plan_compra::InsertPlanCompraAssorment2($_POST['_rows']
                                                         ,$f3->get('SESSION.COD_TEMPORADA')
                                                         ,$f3->get('SESSION.COD_DEPTO')
                                                         ,$f3->get('SESSION.login'));

        echo json_encode($_ERROR);
}
//FIN IMPORTAR ASSORTMENT

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