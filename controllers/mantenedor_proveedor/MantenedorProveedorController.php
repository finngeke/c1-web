<?php

namespace mantenedor_proveedor;

class MantenedorProveedorController extends \Control
{

    // Listar Proveedor
    public function ListarProveedor($f3){
        echo json_encode(MantenedorProveedorClass::ListarProveedor($f3->get('SESSION.login'),1));
    }

    // Listar Vía
    public function ListarVia($f3){
        echo json_encode(LeadTimeClass::ListarVia($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.login'),1));
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

    // Crear Lead Time
    public function CrearLeadTime($f3) {
        $array_data = $_GET;

        $via_base = $array_data["VIA"];
        $via_base = explode(" - ", $via_base);
        $via = $via_base[0];

        $pais_base = $array_data["PAIS"];
        $pais_base = explode(" - ", $pais_base);
        $pais = $pais_base[0];

        $embarque_base = $array_data["EMBARQUE"];
        $embarque_base = explode(" - ", $embarque_base);
        $embarque = $embarque_base[0];

        // $array_data["LINEA"]
        $destino_base = $array_data["DESTINO"];
        $destino_base = explode(" - ", $destino_base);
        $destino = $destino_base[0];

        $depto_base = $array_data["DEPARTAMENTO"];
        $depto_base = explode(" - ", $depto_base);
        $departamento = $depto_base[0];

        $linea_base = $array_data["LINEA"];
        $linea_base = explode(" - ", $linea_base);
        $linea = $linea_base[0];

        //echo LeadTimeClass::CrearLeadTime($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.login'), $f3->get('GET.VIA'), $f3->get('GET.PAIS'), $f3->get('GET.EMBARQUE'), $f3->get('GET.DESTINO'), $f3->get('GET.DEPARTAMENTO'), $f3->get('GET.LINEA'), $f3->get('GET.TRANSITO'), $f3->get('GET.PUERTOCD'), $f3->get('GET.CDTIENDA'), $f3->get('GET.TOTAL_DIAS_SUCURSAL'), $f3->get('GET.VENTANA_EMBARQUE'), $f3->get('GET.FIRST_FORWARDER'), $f3->get('GET.LASTEST_FORWARDER'));
        echo LeadTimeClass::CrearLeadTime($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.login'),1, $via, $pais, $embarque, $destino, $departamento, $linea, $array_data["TRANSITO"], $array_data["PUERTOCD"], $array_data["CDTIENDA"], $array_data["TOTAL_DIAS_SUCURSAL"], $array_data["VENTANA_EMBARQUE"], $array_data["FIRST_FORWARDER"], $array_data["LASTEST_FORWARDER"]);
    }

    // Actualiza Lead Time
    public function ActualizaLeadTime($f3) {

        $array_data = $_GET;

        $via_base = $array_data["COD_VIA"];
        $via_base = explode(" - ", $via_base);
        $via = $via_base[0];

        $pais_base = $array_data["CNTRY_LVL_CHILD"];
        $pais_base = explode(" - ", $pais_base);
        $pais = $pais_base[0];

        $embarque_base = $array_data["COD_PUERTO_EMB"];
        $embarque_base = explode(" - ", $embarque_base);
        $embarque = $embarque_base[0];

        // $array_data["LINEA"]
        $destino_base = $array_data["COD_PUERTO_DESTINO"];
        $destino_base = explode(" - ", $destino_base);
        $destino = $destino_base[0];

        $depto_base = $array_data["DEP_DEPTO"];
        $depto_base = explode(" - ", $depto_base);
        $departamento = $depto_base[0];

        $linea_base = $array_data["LIN_LINEA"];
        $linea_base = explode(" - ", $linea_base);
        $linea = $linea_base[0];

        echo LeadTimeClass::ActualizaLeadTime($f3->get('SESSION.COD_TEMPORADA'), $f3->get('SESSION.login'),1, $array_data["ID_TRANSITO"], $via, $pais, $embarque, $destino, $departamento, $linea, $array_data["D_TRANSITO"], $array_data["D_PUERTO_CD"], $array_data["D_TIENDAS_CD"], $array_data["T_DIAS_SUCURS"], $array_data["COD_VENTANA_EMB"], $array_data["FIRST_FORWARDER"], $array_data["LASTEST_FORWARDER"]);

    }





// Termina Clase
}