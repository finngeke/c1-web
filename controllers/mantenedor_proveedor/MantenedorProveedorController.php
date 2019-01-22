<?php

namespace mantenedor_proveedor;

class MantenedorProveedorController extends \Control
{

    // Listar Proveedor
    public function ListarProveedor($f3){
        echo json_encode(MantenedorProveedorClass::ListarProveedor($f3->get('SESSION.login'),1));
    }

    // Crear Proveedor
    public function CrearProveedor($f3) {

        var_dump($_REQUEST);
        die();

        $array_data = $_GET;

        $incoterm_base = $array_data["INCOTERM"];
        $incoterm_base = explode(" - ", $incoterm_base);
        $incoterm = $incoterm_base[0];

        echo MantenedorProveedorClass::CrearProveedor($f3->get('SESSION.login'),1, $array_data["PI_AUTOMATICA"],
                                                                                    $array_data["COMPRA_CURVA"],
                                                                                    $array_data["RFID"],
                                                                                    $array_data["VEND_TAXID"],
                                                                                    $array_data["VEND_BENEFICIARY"],
                                                                                    $array_data["VEND_ADD_BENEFICIARY"],
                                                                                    $array_data["VEND_CITY"],
                                                                                    $array_data["VEND_COUNTRY"],
                                                                                    $array_data["VEND_PHONE"],
                                                                                    $array_data["VEND_FAX"],
                                                                                    $array_data["VEND_NAME_DEALER"],
                                                                                    $array_data["CONT_NAME"],
                                                                                    $array_data["CONT_ADDRESS"],
                                                                                    $array_data["CONT_PHONE"],
                                                                                    $array_data["CONT_EMAIL"],
                                                                                    $array_data["PAY_BANK_NAME_BENEFICIARY"],
                                                                                    $array_data["PAY_ADD_BANK_BENEFICIARY"],
                                                                                    $array_data["PAY_CITY_BENEFICIARY_BANK"],
                                                                                    $array_data["PAY_COUNTRY_BENEFICIARY"],
                                                                                    $array_data["PAY_SWIFT_CODE"],
                                                                                    $array_data["PAY_ABA"],
                                                                                    $array_data["PAY_IBAN"],
                                                                                    $array_data["PAY_ACC_NUMBER_BENEFICIARY"],
                                                                                    $array_data["PAY_CURRENCY_ACCOUNT"],
                                                                                    $array_data["PAY_SECOND_BENEFICIARY"],
                                                                                    $array_data["INTER_BANK_NAME"],
                                                                                    $array_data["INTER_SWIFT"],
                                                                                    $array_data["INTER_COUNTRY"],
                                                                                    $array_data["INTER_CITY"],
                                                                                    $array_data["PUR_CURRENCY"],
                                                                                    $incoterm,
                                                                                    $array_data["PUR_PAYMENTO"]);

    }

    // Actualiza Proveedor
    public function ActualizaProveedor($f3) {

        $array_data = $_GET;

        $incoterm_base = $array_data["INCOTERM"];
        $incoterm_base = explode(" - ", $incoterm_base);
        $incoterm = $incoterm_base[0];

        echo MantenedorProveedorClass::ActualizaProveedor($f3->get('SESSION.login'),1, $array_data["COD_PROVEEDOR"],
                                                                                    $array_data["PI_AUTOMATICA"],
                                                                                    $array_data["COMPRA_CURVA"],
                                                                                    $array_data["RFID"],
                                                                                    $array_data["VEND_TAXID"],
                                                                                    $array_data["VEND_BENEFICIARY"],
                                                                                    $array_data["VEND_ADD_BENEFICIARY"],
                                                                                    $array_data["VEND_CITY"],
                                                                                    $array_data["VEND_COUNTRY"],
                                                                                    $array_data["VEND_PHONE"],
                                                                                    $array_data["VEND_FAX"],
                                                                                    $array_data["VEND_NAME_DEALER"],
                                                                                    $array_data["CONT_NAME"],
                                                                                    $array_data["CONT_ADDRESS"],
                                                                                    $array_data["CONT_PHONE"],
                                                                                    $array_data["CONT_EMAIL"],
                                                                                    $array_data["PAY_BANK_NAME_BENEFICIARY"],
                                                                                    $array_data["PAY_ADD_BANK_BENEFICIARY"],
                                                                                    $array_data["PAY_CITY_BENEFICIARY_BANK"],
                                                                                    $array_data["PAY_COUNTRY_BENEFICIARY"],
                                                                                    $array_data["PAY_SWIFT_CODE"],
                                                                                    $array_data["PAY_ABA"],
                                                                                    $array_data["PAY_IBAN"],
                                                                                    $array_data["PAY_ACC_NUMBER_BENEFICIARY"],
                                                                                    $array_data["PAY_CURRENCY_ACCOUNT"],
                                                                                    $array_data["PAY_SECOND_BENEFICIARY"],
                                                                                    $array_data["INTER_BANK_NAME"],
                                                                                    $array_data["INTER_SWIFT"],
                                                                                    $array_data["INTER_COUNTRY"],
                                                                                    $array_data["INTER_CITY"],
                                                                                    $array_data["PUR_CURRENCY"],
                                                                                    $incoterm,
                                                                                    $array_data["PUR_PAYMENTO"]);
    }

    // Actualiza Proveedor
    public function ActualizaPortada($f3) {

        $array_data = $_GET;

        echo MantenedorProveedorClass::ActualizaPortada($f3->get('SESSION.login'),1, $array_data["COD_PROVEEDOR"],$array_data["PI_AUTOMATICA"],$array_data["COMPRA_CURVA"],$array_data["RFID"]);
    }

    // Listar Incoterm COD_PROVEEDOR
    public function ListarIncoterm($f3){
        echo json_encode(MantenedorProveedorClass::ListarIncoterm($f3->get('SESSION.login'),1));
    }




    // Listar País
    public function ListarPais($f3){
        echo json_encode(LeadTimeClass::ListarPais($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),1));
    }

    // Listar Embarque
    public function ListarEmbarque($f3){

        $pais = $f3->get('GET.PAIS');

        if (strpos($pais, ' - ') !== false) {
            $base_pais = explode(" - ", $pais);
            $pais = trim($base_pais[0]);
        }else{
            $pais = trim($f3->get('GET.PAIS'));
        }

        echo json_encode(LeadTimeClass::ListarEmbarque($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),1,$pais));
    }

    // Listar Destino
    public function ListarDestino($f3){
        echo json_encode(LeadTimeClass::ListarDestino($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),1));
    }

    // Listar Depto
    public function ListarDepto($f3){
        echo json_encode(LeadTimeClass::ListarDepto($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),1));
    }

    // Listar Línea
    public function ListarLinea($f3){

        $depto = $f3->get('GET.DEPTOCBX');

        if (strpos($depto, ' - ') !== false) {
            $base_depto = explode(" - ", $depto);
            $depto = trim($base_depto[0]);
        }else{
            $pais = trim($f3->get('GET.DEPTOCBX'));
        }

        echo json_encode(LeadTimeClass::ListarLinea($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),1,$depto));
    }







// Termina Clase
}