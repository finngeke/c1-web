<?php

namespace resumen_estilos;

class ResumenEstilosController extends \Control
{

    // Listar Resumen Estilos => El 1 Corresponde al país, el que se va enviar como variable en algún momento
    public function ListarResumenEstilos($f3){
        echo json_encode(ResumenEstilosClass::ListarResumenEstilos($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.COD_DEPTO'), $f3->get('SESSION.login'),1));
    }

    // Listar Temporada
    public function ListarTemporada($f3){
        echo json_encode(ResumenEstilosClass::ListarTemporada($f3->get('SESSION.login'),1));
    }

    // Listar Ventana
    public function ListarVentana($f3){
        echo json_encode(ResumenEstilosClass::ListarVentana($f3->get('SESSION.login'),1));
    }

    // Listar Depto
    public function ListarDepto($f3){
        echo json_encode(ResumenEstilosClass::ListarDepto($f3->get('SESSION.login'),1));
    }

    // Listar Port of Delivery
    public function ListarPortDelivery($f3){
        echo json_encode(ResumenEstilosClass::ListarPortDelivery($f3->get('SESSION.login'),1));
    }


    // Actualizar Registros de PIA_RESUMEN_ESTILO_PASO (Procesar Primero)
    public function ActualizaResumenEstilos($f3){

        /*echo "<pre>";
        var_dump($_REQUEST['models']);
        echo "</pre>";
        die();*/

        $tempData = $_REQUEST['models'];
        //$tempData = html_entity_decode($_REQUEST['models']);
        //$json = json_decode($tempData, true);

        $arrayRegistros = [];

        foreach ($tempData as $columna) {

            // Obtengo el ID del Puerto
            $PROC_COD_PUERTO = explode(" - ",trim($columna["COD_PUERTO"]));
            // Asigno el ID de País
            if(trim($columna["COD_MOD_PAIS"])=='CHILE'){
                $PROC_PAIS = 1;
            }else{
                $PROC_PAIS = 2;
            }

            $ID = trim($columna["ID"]);
            $PROFORMA = trim($columna["PROFORMA"]);
            $DES_ESTILO = trim($columna["DES_ESTILO"]);
            $COD_MOD_PAIS = $PROC_PAIS;
            $NOM_MARCA = trim($columna["NOM_MARCA"]);
            $NOM_LINEA = trim($columna["NOM_LINEA"]);
            $FECHA_EMBARQUE_ACORDADA = trim($columna["FECHA_EMBARQUE_ACORDADA"]);
            $COD_PUERTO = trim($PROC_COD_PUERTO[0]);
            $DEP_DEPTO = trim($columna["DEP_DEPTO"]);

            // Alamcenar en Array los resultados
            array_push($arrayRegistros, array(
                "ID" => trim($ID)
                ,"PROFORMA" => trim($PROFORMA)
                ,"DES_ESTILO" => trim($DES_ESTILO)
                ,"COD_MOD_PAIS" => trim($COD_MOD_PAIS)
                ,"NOM_MARCA" => trim($NOM_MARCA)
                ,"NOM_LINEA" => trim($NOM_LINEA)
                ,"FECHA_EMBARQUE_ACORDADA" => trim($FECHA_EMBARQUE_ACORDADA)
                ,"COD_PUERTO" => trim($COD_PUERTO)
                ,"DEP_DEPTO" => trim($DEP_DEPTO)
            ));

            // Actualizar Registros en PIA_RESUMEN_ESTILO_PASO
            echo ResumenEstilosClass::ActualizaResumenEstilos($f3->get('SESSION.login'),$ID,$PROFORMA,$DES_ESTILO,$COD_MOD_PAIS,$NOM_MARCA,$NOM_LINEA,$FECHA_EMBARQUE_ACORDADA,$COD_PUERTO,$DEP_DEPTO);


        // Fin ForEach
        }

         /*echo "<pre>";
         var_export($arrayRegistros);
         echo "</pre>";
         die();*/



    }




    function AgrupaArreglos($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }




// Termina Clase
}