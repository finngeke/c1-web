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

        $dt = actualizar_calculos::traer_datos_para_calcular_query($f3->get('SESSION.COD_TEMPORADA'),($f3->get('GET.DEPTO')),($f3->get('GET.UNID')));
        $limite = count($dt)-1;
        $dtfactores = [];

         for($i = 0;$i <= $limite; $i++){

             //(Costo unitarios final US$) CALCULO:(FOB O TARGET)+INSP+RFID.
             if($dt[$i]["COSTO_FOB"] <> null and $dt[$i]["COSTO_FOB"] <> 0){
                 $dt[$i]["COSTO_UNIT"] = $dt[$i]["COSTO_FOB"]+$dt[$i]["COSTO_INSP"]+$dt[$i]["COSTO_RFID"];
             }else{
                 $dt[$i]["COSTO_UNIT"] = $dt[$i]["COSTO_TARGET"]+$dt[$i]["COSTO_INSP"]+$dt[$i]["COSTO_RFID"];
             }
             $cst_uni_final_us_target = $dt[$i]["COSTO_TARGET"]+$dt[$i]["COSTO_INSP"]+$dt[$i]["COSTO_RFID"];


             //(Costo unitarios final Pesos) CALCULO:FACTOR * COSTO UNITARIO US$.
             $factor = 0;
             foreach($dtfactores as $f){
                if ($f[0] == $dt[$i]["DEP_DEPTO"] and
                    $f[1] == $dt[$i]["PAIS"] and
                    $f[2] == $dt[$i]["VIA"] and
                    $f[3] == $dt[$i]["COD_TIP_MON"] and
                    $f[4] == $dt[$i]["NOM_VENTANA"] ){
                    $factor = $f[5]; break;
                }
             }
             if ($factor == 0){
                 if ($dt[$i]["NOM_VENTANA"] <> null ){
                     $factor = Control_actualizar_calculos::Factores($f3,$dt[$i]["DEP_DEPTO"],$dt[$i]["PAIS"],$dt[$i]["VIA"],$dt[$i]["COD_TIP_MON"],$dt[$i]["NOM_VENTANA"]);
                     array_push($dtfactores,array($dt[$i]["DEP_DEPTO"],$dt[$i]["PAIS"],$dt[$i]["VIA"],$dt[$i]["COD_TIP_MON"],$dt[$i]["NOM_VENTANA"],$factor));
                 }else{
                     $factor = 0;
                 }
             }

             $dt[$i]["COSTO_UNITS"] = round($dt[$i]["COSTO_UNIT"] * $factor);

             //FACTOR  FACTOR ESTIMADO O EL TIPO DE CAMNBIO
             $dt[$i]["FACTOR"] = $factor;

             //(Total Target US$) CALCULO: COSTO UNITARIO US TARGET * UNIDADES.
             $dt[$i]["CST_TOTLTARGET"] = $cst_uni_final_us_target * $dt[$i]["UNIDADES"];

             //(Total Fob US$)     CALCULO: COSTO UNITARIO US * UNIDADES
             $dt[$i]["COSTO_TOT"] = $dt[$i]["COSTO_UNIT"] * $dt[$i]["UNIDADES"];

             //(Costo Total Pesos) CALCULO: COSTO UNITARIO PESOS * UNIDADES
             $dt[$i]["COSTO_TOTS"] = ($dt[$i]["COSTO_UNITS"] * $dt[$i]["UNIDADES"]);



             //MKUP CALCULO: (PRECIO BLANCO/IVA) * COSTO UNITARIO PESOS
             if ($dt[$i]["PRECIO_BLANCO"] <> 0 and $dt[$i]["PRECIO_BLANCO"] <> null and $dt[$i]["UNIDADES"] <> 0 and  $dt[$i]["UNIDADES"] <> null ){
                 $dt[$i]["MKUP"] = round((($dt[$i]["PRECIO_BLANCO"]/1.19) / $dt[$i]["UNIDADES"]),2);
             }else{
                 $dt[$i]["MKUP"] = 0;
             }

             //GM CALCULO: (((PRECIO BLANCO/IVA) - COSTO UNITARIO PESOS) /  (PRECIO BLANCO/IVA)) * 100
             if ($dt[$i]["PRECIO_BLANCO"] <> 0 and $dt[$i]["PRECIO_BLANCO"] <> null){
                 $dt[$i]["GMB"] = ROUND((((($dt[$i]["PRECIO_BLANCO"]/1.19)-$dt[$i]["COSTO_UNIT"])/($dt[$i]["PRECIO_BLANCO"]/1.19)) * 100),2) ;
             }else{
                 $dt[$i]["GMB"] = 0;
             }

         }

        //echo json_encode(\simulador_compra\actualizar_calculos::traer_datos_para_calcular_query($f3->get('SESSION.COD_TEMPORADA'),($f3->get('GET.DEPTO')),($f3->get('GET.UNID'))));
        echo json_encode($dt);
    }


    public function traer_factor($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::traer_factor($f3->get('GET.VENTANA_LLEGADA'),$f3->get('SESSION.COD_TEMPORADA'),$f3->get('GET.DEPTO'),$f3->get('GET.PAIS'),$f3->get('GET.VIA'),$f3->get('GET.COD_TIP_MON')));
    }

    public function traer_tipo_cambio($f3)
    {
        echo json_encode(\simulador_compra\actualizar_calculos::traer_tipo_cambio($f3->get('GET.VENTANA_LLEGADA'),$f3->get('SESSION.COD_TEMPORADA'),$f3->get('GET.COD_TIP_MON')));
    }

    public function Factores($f3,$depto,$pais,$via,$moneda,$nom_ventana){
        $factor = plan_compra::lis_factor($f3->get('SESSION.COD_TEMPORADA'),$depto,$pais,$via,$moneda,$nom_ventana);
        if (count($factor)== 0){
            $factor = plan_compra::lis_tipo_cambio($f3->get('SESSION.COD_TEMPORADA'),$depto,$moneda,$nom_ventana);
            if (count($factor)== 0){
                $factor= 0;
            }else{
                $factor = $factor[0][0];
            }
        }else {
            $factor = $factor[0][0];
        }

        return $factor;
    }
    public function actualizar_calculos_departamento($f3)
    {

        $dt  = json_encode(\simulador_compra\actualizar_calculos::actualizar_calculos_departamento(
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

        if ($dt == true){
            echo json_encode(array("True",1));
        }else{
            echo json_encode(array("False",0));
        }

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