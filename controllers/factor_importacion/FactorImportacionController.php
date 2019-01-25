<?php

namespace factor_importacion;

class FactorImportacionController  extends \Control
{
    // Listar factor
    public function List_factor_Importacion($f3){
        echo json_encode(FactorImportacionClass::List_factor_Importacion($f3->get('SESSION.COD_TEMPORADA')));
    }

    // Listar Vía
    public function ListarVia($f3){
        echo json_encode(FactorImportacionClass::ListarVia($f3->get('SESSION.login'),1));
    }

    // Listar País emb
    public function ListarPais($f3){
        echo json_encode(FactorImportacionClass::ListarPais($f3->get('SESSION.login'),1));
    }

    // Listar Puertos
    public function ListarPuertos($f3){
        $pais = $f3->get('GET.PAIS');

        if (strpos($pais, ' - ') !== false) {
            $base_pais = explode(" - ", $pais);
            $pais = trim($base_pais[0]);
        }else{
            $pais = trim($f3->get('GET.PAIS'));
        }
        echo json_encode(FactorImportacionClass::ListarPuertos($f3->get('SESSION.login'),1,$pais));
    }

    // Listar Pais dest
    public function ListarPaisDest($f3){
        $pais = $f3->get('GET.PAIS');

        if (strpos($pais, ' - ') !== false) {
            $base_pais = explode(" - ", $pais);
            $pais = trim($base_pais[0]);
        }else{
            $pais = trim($f3->get('GET.PAIS'));
        }

        echo json_encode(FactorImportacionClass::ListarPaisDest($f3->get('SESSION.login'),1,$pais));

    }

    // Listar Pais dest
    public function ListarIncoterm($f3){
        echo json_encode(FactorImportacionClass::ListarIncoterm($f3->get('SESSION.login'),1));
    }

    // Listar Divisiones
    public function ListarDivisiones($f3){
        echo json_encode(FactorImportacionClass::ListarDivisiones($f3->get('SESSION.login'),1));
    }

    // Listar deptoxdivision
    public function ListarDeptoxDivision($f3){
        $Division = $f3->get('GET.DIVISION');
        if (strpos($Division, ' - ') !== false) {
            $base_pais = explode(" - ", $Division);
            $Division = trim($base_pais[0]);
        }else{
            $Division = trim($f3->get('GET.DIVISION'));
        }
        echo json_encode(FactorImportacionClass::ListarDeptoxDivision($f3->get('SESSION.login'),1,$Division));
    }

    // Listar marcaxdepto
    public function ListarMarcaxDepto ($f3){
        $Depto= $f3->get('GET.Depto');
        if (strpos($Depto, ' - ') !== false) {
            $base_pais = explode(" - ", $Depto);
            $Depto = trim($base_pais[0]);
        }else{
            $Depto = trim($f3->get('GET.Depto'));
        }
        echo json_encode(FactorImportacionClass::ListarMarcaxDepto($f3->get('SESSION.login'),1,$Depto));
    }

    // Listar Tipo Moneda
    public function ListartipoMoneda($f3)
    {
        echo json_encode(FactorImportacionClass::ListartipoMoneda($f3->get('SESSION.login'),1));
    }

    // Insert Factor Import
    public function InsertFactorImport($f3) {
        $array_data = $_GET;

        $via_base = $array_data["VIA"];
        $via_base = explode(" - ", $via_base);
        $via = $via_base[0];

        $PAIS_EMB_base = $array_data["PAIS_EMB"];
        $PAIS_EMB_base = explode(" - ", $PAIS_EMB_base);
        $pais_emb = $PAIS_EMB_base[0];

        $embarque_base = $array_data["PTO_EMBARQUE"];
        $embarque_base = explode(" - ", $embarque_base);
        $pto_embarque = $embarque_base[0];

        $PAIS_dest_base = $array_data["PAIS_DEST"];
        $PAIS_dest_base = explode(" - ", $PAIS_dest_base);
        $pais_dest = $PAIS_dest_base[0];

        $destino_base = $array_data["PTO_DESTINO"];
        $destino_base = explode(" - ", $destino_base);
        $pto_destino = $destino_base[0];

        $incoterm_base = $array_data["INCOTERM"];
        $incoterm_base = explode(" - ", $incoterm_base);
        $incoterm = $incoterm_base[0];

        $division_base = $array_data["DIVISION"];
        $division_base = explode(" - ", $division_base);
        $division = $division_base[0];

        $depto_base = $array_data["DEPARTAMENTO"];
        $depto_base = explode(" - ", $depto_base);
        $departamento = $depto_base[0];

        $marca_base = $array_data["MARCA"];
        $marca_base = explode(" - ", $marca_base);
        $marca = $marca_base[0];

        $moneda_base = $array_data["MONEDA"];
        $moneda_base = explode(" - ", $moneda_base);
        $moneda = $moneda_base[0];

        if($pto_destino == ""or $pto_destino == "0" or $pto_destino == null){
            $pto_destino = '';
        }

        if ($marca == ""  or $marca == null){
            $marca = 0;
        }


        $dt = array("via"=>$via
                    ,"pais_emb"=>$pais_emb
                    ,"pto_embarque"=>$pto_embarque
                    ,"pais_dest"=>$pais_dest
                    ,"pto_destino"=>$pto_destino
                    ,"incoterm"=>$incoterm
                    ,"division"=>$division
                    ,"departamento"=>$departamento
                    ,"marca"=>$marca
                    ,"moneda"=>$moneda
                    ,"factor_est"=>$array_data["FACTOR_EST"]);

        echo FactorImportacionClass::InsertFactorImport($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.login'),1,$dt);
    }

    // update Factor Import
    public function updateFactorImport($f3) {

        $array_data = $_GET;

        $via_base = $array_data["COD_VIA"];
        $via_base = explode(" - ", $via_base);
        $via = $via_base[0];

        $PAIS_EMB_base = $array_data["COD_PAIS_EMB"];
        $PAIS_EMB_base = explode(" - ", $PAIS_EMB_base);
        $pais_emb = $PAIS_EMB_base[0];

        $embarque_base = $array_data["COD_PUERTO_EMB"];
        $embarque_base = explode(" - ", $embarque_base);
        $pto_embarque = $embarque_base[0];

        $PAIS_dest_base = $array_data["COD_PAIS_DESTINO"];
        $PAIS_dest_base = explode(" - ", $PAIS_dest_base);
        $pais_dest = $PAIS_dest_base[0];

        $destino_base = $array_data["COD_PUERTO_DESTINO"];
        $destino_base = explode(" - ", $destino_base);
        $pto_destino = $destino_base[0];

        $incoterm_base = $array_data["COD_INCOTERM"];
        $incoterm_base = explode(" - ", $incoterm_base);
        $incoterm = $incoterm_base[0];

        $division_base = $array_data["COD_DIV"];
        $division_base = explode(" - ", $division_base);
        $division = $division_base[0];

        $depto_base = $array_data["DEP_DEPTO"];
        $depto_base = explode(" - ", $depto_base);
        $departamento = $depto_base[0];

        $marca_base = $array_data["COD_MARCA"];
        $marca_base = explode(" - ", $marca_base);
        $marca = $marca_base[0];

        $moneda_base = $array_data["COD_TIP_MON"];
        $moneda_base = explode(" - ", $moneda_base);
        $moneda = $moneda_base[0];

        if($pto_destino == ""or $pto_destino == "0" or $pto_destino == null OR $pto_destino == "ND"){
            $pto_destino = '';
        }

        if ($marca == ""  or $marca == null or $marca == "ND"){
            $marca = 0;
        }


        $dt = array("via"=>$via
        ,"pais_emb"=>$pais_emb
        ,"pto_embarque"=>$pto_embarque
        ,"pais_dest"=>$pais_dest
        ,"pto_destino"=>$pto_destino
        ,"incoterm"=>$incoterm
        ,"division"=>$division
        ,"departamento"=>$departamento
        ,"marca"=>$marca
                    ,"moneda"=>$moneda
                    ,"factor_est"=>$array_data["FACTOR_ESTIMADO"]
                    ,"id_factor"=>$array_data["ID_FACTOR"]);


        echo FactorImportacionClass::updateFactorImport($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),$dt);

    }

    //exportar exportar_excel
    public function exportar_excel($f3) {

        echo json_encode(FactorImportacionClass::exportar_excel($f3->get('SESSION.COD_TEMPORADA')));

    }


    public static function DeleteFactorImport($f3){

        $dtid = explode(",",trim($_POST['id_delete']));

        echo FactorImportacionClass::DeleteFactorImport($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),$dtid);
    }
}