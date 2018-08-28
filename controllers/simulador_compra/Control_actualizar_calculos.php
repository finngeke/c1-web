<?php
/**
 * Created by PhpStorm.
 * Date: 17/08/2018
 * Time: 12:55
 */
namespace simulador_compra;

class Control_actualizar_calculos extends \Control
{
    //llenar combo box de actualizar calculos
    public function llenar_departamento_actualizar_calculos($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::llenar_departamento_actualizar_calculos($f3->get('SESSION.COD_TEMPORADA')));
    }

    public function traer_datos_para_calcular_query($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::traer_datos_para_calcular_query($f3->get('SESSION.COD_TEMPORADA'),($f3->get('GET.DEPTO'))));
    }

    public function traer_factor($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::traer_factor($f3->get('GET.VENTANA_LLEGADA'),$f3->get('SESSION.COD_TEMPORADA'),$f3->get('GET.DEPTO'),$f3->get('GET.PAIS'),$f3->get('GET.VIA'),$f3->get('GET.COD_TIP_MON')));
    }

    public function traer_tipo_cambio($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::traer_tipo_cambio($f3->get('GET.VENTANA_LLEGADA'),$f3->get('SESSION.COD_TEMPORADA'),$f3->get('GET.COD_TIP_MON')));
    }

    public function actualizar_calculos_departamento($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::actualizar_calculos_departamento(
            $f3->get('SESSION.login')
            ,$f3->get('SESSION.COD_TEMPORADA')
            ,$f3->get('GET.DEPTO')
            ,$f3->get('GET.ID_COLOR3')
            ,$f3->get('GET.MKUP')
            ,$f3->get('GET.GMB')
            ,$f3->get('GET.COSTO_UNITARIO_US')
            ,$f3->get('GET.COSTO_UNITARIO_PESO')
            ,$f3->get('GET.TOTAL_TARGET')
            ,$f3->get('GET.TOTAL_FOB')
            ,$f3->get('GET.COSTO_TOTAL_PESO')
            ,$f3->get('GET.RETAIL')));
    }

    public function actualizar_calculos_departamento_CIC($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::actualizar_calculos_departamento(
            $f3->get('SESSION.login')
            ,$f3->get('SESSION.COD_TEMPORADA')
            ,$f3->get('GET.DEPTO')
            ,$f3->get('GET.ID_COLOR3')
            ,$f3->get('GET.MKUP')
            ,$f3->get('GET.GMB')
            ,$f3->get('GET.COSTO_UNITARIO_US')
            ,$f3->get('GET.COSTO_UNITARIO_PESO')
            ,$f3->get('GET.TOTAL_TARGET')
            ,$f3->get('GET.TOTAL_FOB')
            ,$f3->get('GET.COSTO_TOTAL_PESO')
            ,$f3->get('GET.RETAIL')));
    }
}