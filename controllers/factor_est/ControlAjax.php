<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace factor_est;

/**
 * Description of ControlAjax
 *
 * @author epacheco
 */
class ControlAjax extends \Control  {
    //put your code here
    
         //$depto = $f3->get('POST.DEPARTAMENTO');
         //$pais = $f3->get('POST.PARAMETROS');
         //$via = $f3->get('POST.VIA');
        //$factor = $f3->get('POST.FACTOR_DOL');
        // $tipo_moneda = $f3->get('POST.TIPO_MONEDA');
        // $va = $f3->get('POST.va[]');$vb = $f3->get('POST.vb[]');
        // $vc = $f3->get('POST.vc[]');$vd = $f3->get('POST.vd[]');
        // $ve = $f3->get('POST.ve[]');$vf = $f3->get('POST.vf[]');
        // $vg = $f3->get('POST.vg[]');$vh = $f3->get('POST.vh[]');$vi = $f3->get('POST.vi[]');
    
    public function elimina_Factor($f3) {
         
         $row = explode("$", $f3->get('GET.factor'));    
         $depto = $row[0];
         $pais = $row[1];
         $via = $row[2];
         $tipo_moneda = $row[3];
          
        try {
            \temporada\factor_estimado::delete_Factor($f3->get('SESSION.COD_TEMPORADA'),
                                           $depto,
                                           $pais,
                                           $via,
                                           $tipo_moneda);
           
          
        } catch (Exception $ex) {
            echo 'ERROR-En la eliminación PLC_FACTOR_EST.';
        }
        
        echo 'OK-Registro fue eliminado con éxito..';
       
    }
    
    public function List_factor_replicar($f3){
        
        $tempo = $f3->get('GET.tempo');       
       
        echo json_encode(\temporada\factor_estimado::getFactor_Estimado($tempo));
        
    }
    
    public function guardarReplicar($f3){
        try {
                //delete factor
                 \temporada\factor_estimado::delete_Factor_all($f3->get('SESSION.COD_TEMPORADA'));

                //dt factor a replicar
                $dtfactorReplicar = \temporada\factor_estimado::getFactor_Estimado($f3->get('GET.temporada'));

                //dt tipo de cambio
                $dttipo_cambio =  \temporada\Factor_Estimado::getTipo_Cambio($f3->get('SESSION.COD_TEMPORADA'));

                $i = 0;
                foreach ($dtfactorReplicar as $var){
                    $factor = $dtfactorReplicar[$i]["FACTOR_DOL"] ; 
                    $t=0;
                    foreach ($dttipo_cambio as $var2){
                        if ($dttipo_cambio[$t]["COD_TIP_MON"] == $dtfactorReplicar[$i]["COD_MONEDA"]){    
                            $va = $dttipo_cambio[$t]["A"] * $factor;
                            $vb = $dttipo_cambio[$t]["B"] * $factor;
                            $vc = $dttipo_cambio[$t]["C"] * $factor;
                            $vd = $dttipo_cambio[$t]["D"] * $factor;
                            $ve = $dttipo_cambio[$t]["E"] * $factor;
                            $vf = $dttipo_cambio[$t]["F"] * $factor;
                            $vg = $dttipo_cambio[$t]["G"] * $factor;
                            $vh = $dttipo_cambio[$t]["H"] * $factor;
                            $vi = $dttipo_cambio[$t]["I"] * $factor;
                        break;
                        } 
                       $t++; 
                    }
                    
                    
                   
                       \temporada\factor_estimado::guardaFactorEstimado(1,
                                                                     $dtfactorReplicar[$i]["COD_MONEDA"],
                                                                     $factor,
                                                                     $dtfactorReplicar[$i]["COD_VIA"],
                                                                     $dtfactorReplicar[$i]["COD_PAIS"],
                                                                     $dtfactorReplicar[$i]["DEP_DEPTO"],
                                                                     $f3->get('SESSION.login'),
                                                                     $f3->get('SESSION.COD_TEMPORADA'),
                                                                     $va,$vb,$vc,$vd, 
                                                                     $ve,$vf,$vg,$vh, 
                                                                     $vi,
                                                                     "Sin fila");
                    $i++;
                }
               echo 'OK-fue cargado con éxito.';
       
        
        }catch (Exception $e){
           
            echo 'ERROR-'.$e->getMessage();
        }     
    }

    // Contar cuantos registros llegan de factor estimado
    public function conteo_factor_estimado($f3) {
        echo json_encode(\temporada\factor_estimado::conteo_factor_estimado($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('SESSION.login')));
    }

    // Contar cuantos registros llegan de tipo cambio
    public function conteo_tipo_cambio($f3) {
        echo json_encode(\temporada\factor_estimado::conteo_tipo_cambio($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('SESSION.login')));
    }

    public function ActualizarfactorPromedio($f3){
        try {
        \temporada\factor_estimado::ActualizarfactorPromedio($f3->get('SESSION.COD_TEMPORADA'));
            echo 'OK-fue actualizado con exito.';
        }catch (Exception $e){
            echo 'ERROR-'.$e->getMessage();
        }
    }

}
