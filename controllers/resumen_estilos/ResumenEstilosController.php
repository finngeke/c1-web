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

    // Listar Incoterm COD_PROVEEDOR
    public function ListarIncoterm($f3){
        echo json_encode(ResumenEstilosClass::ListarIncoterm($f3->get('SESSION.login'),1));
    }


    // Actualizar Registros de PIA_RESUMEN_ESTILO_PASO (Procesar Primero)
    public function ActualizaResumenEstilos($f3){

        $tempData = $_REQUEST['models'];

        $arrayRegistrosOK = [];
        $arrayRegistrosERROR = [];

        $arrayRegistrosC3OK = [];
        $arrayRegistrosC3ERROR = [];

        $total_recepcionado = count($tempData);


        // Actualiza PIA_RESUMEN_ESTILO_PASO
        foreach ($tempData as $columna) {

            // Obtengo el ID del Puerto
            $PROC_COD_PUERTO = explode(" - ",trim($columna["COD_PUERTO"]));

            // Asigno el ID de País
            if(trim($columna["COD_MOD_PAIS"])=='CHILE'){
                $PROC_PAIS = 1;
            }else{
                $PROC_PAIS = 2;
            }

            if(trim($columna["PROFORMA"]) == null){
                $PROFORMA_INGRESADA = 'NI';
            }else{
                $PROFORMA_INGRESADA = trim($columna["PROFORMA"]);
            }

            $ID = trim($columna["ID"]);
            $PROFORMA = $PROFORMA_INGRESADA;
            $DES_ESTILO = trim($columna["DES_ESTILO"]);
            $COD_MOD_PAIS = $PROC_PAIS;
            $NOM_MARCA = trim($columna["NOM_MARCA"]);
            $NOM_LINEA = trim($columna["NOM_LINEA"]);
            $FECHA_EMBARQUE_ACORDADA = trim($columna["FECHA_EMBARQUE_ACORDADA"]);
            $COD_PUERTO = trim($PROC_COD_PUERTO[0]);
            $DEP_DEPTO = trim($columna["DEP_DEPTO"]);

            $res = ResumenEstilosClass::ActualizaResumenEstiloPaso($f3->get('SESSION.login'),$ID,$PROFORMA,$DES_ESTILO,$COD_MOD_PAIS,$NOM_MARCA,$NOM_LINEA,$FECHA_EMBARQUE_ACORDADA,$COD_PUERTO,$DEP_DEPTO);

             if($res=='OK'){
                 array_push($arrayRegistrosOK, array(
                 "ID" => $ID
                 ,"PROFORMA" => $PROFORMA
                 ,"DES_ESTILO" => $DES_ESTILO
                 ,"COD_MOD_PAIS" => $COD_MOD_PAIS
                 ,"NOM_MARCA" => $NOM_MARCA
                 ,"NOM_LINEA" => $NOM_LINEA
                 ,"FECHA_EMBARQUE_ACORDADA" => $FECHA_EMBARQUE_ACORDADA
                 ,"COD_PUERTO" => $COD_PUERTO
                 ,"DEP_DEPTO" => $DEP_DEPTO
                 ));
             }elseif($res=='ERROR'){
                 array_push($arrayRegistrosERROR, array(
                  "ID" => $ID
                 ,"PROFORMA" => $PROFORMA
                 ,"DES_ESTILO" => $DES_ESTILO
                 ,"COD_MOD_PAIS" => $COD_MOD_PAIS
                 ,"NOM_MARCA" => $NOM_MARCA
                 ,"NOM_LINEA" => $NOM_LINEA
                 ,"FECHA_EMBARQUE_ACORDADA" => $FECHA_EMBARQUE_ACORDADA
                 ,"COD_PUERTO" => $COD_PUERTO
                 ,"DEP_DEPTO" => $DEP_DEPTO
                 ));
             }

        // Fin ForEach
        }

        /*echo "Recepcionado: ".$total_recepcionado." UPD OK: ".count($arrayRegistrosOK);*/

        // Actualiza COLOR 3
        if( $total_recepcionado == count($arrayRegistrosOK) ){

            foreach ($arrayRegistrosOK as $columna) {

                $ID = $columna["ID"];
                $PROFORMA = $columna["PROFORMA"];
                $DES_ESTILO = $columna["DES_ESTILO"];
                $COD_MOD_PAIS = $columna["COD_MOD_PAIS"];
                $NOM_MARCA = $columna["NOM_MARCA"];
                $NOM_LINEA = $columna["NOM_LINEA"];
                $FECHA_EMBARQUE_ACORDADA = $columna["FECHA_EMBARQUE_ACORDADA"];
                $COD_PUERTO = $columna["COD_PUERTO"];
                $DEP_DEPTO = $columna["DEP_DEPTO"];

                $res2 = ResumenEstilosClass::ActualizaColor3($f3->get('SESSION.login'),$ID,$PROFORMA,$DES_ESTILO,$COD_MOD_PAIS,$NOM_MARCA,$NOM_LINEA,$FECHA_EMBARQUE_ACORDADA,$COD_PUERTO,$DEP_DEPTO);

                if($res2=='OK'){
                    array_push($arrayRegistrosC3OK, array(
                        "ID" => $ID
                    ,"PROFORMA" => $PROFORMA
                    ,"DES_ESTILO" => $DES_ESTILO
                    ,"COD_MOD_PAIS" => $COD_MOD_PAIS
                    ,"NOM_MARCA" => $NOM_MARCA
                    ,"NOM_LINEA" => $NOM_LINEA
                    ,"FECHA_EMBARQUE_ACORDADA" => $FECHA_EMBARQUE_ACORDADA
                    ,"COD_PUERTO" => $COD_PUERTO
                    ,"DEP_DEPTO" => $DEP_DEPTO
                    ));
                }elseif($res2=='ERROR'){
                    array_push($arrayRegistrosC3ERROR, array(
                        "ID" => $ID
                    ,"PROFORMA" => $PROFORMA
                    ,"DES_ESTILO" => $DES_ESTILO
                    ,"COD_MOD_PAIS" => $COD_MOD_PAIS
                    ,"NOM_MARCA" => $NOM_MARCA
                    ,"NOM_LINEA" => $NOM_LINEA
                    ,"FECHA_EMBARQUE_ACORDADA" => $FECHA_EMBARQUE_ACORDADA
                    ,"COD_PUERTO" => $COD_PUERTO
                    ,"DEP_DEPTO" => $DEP_DEPTO
                    ));
                }

            }

        }else{
            return "ERROR";
        }








    // Fin de ActualizaResumenEstilos
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