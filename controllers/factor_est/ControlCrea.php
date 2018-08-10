<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of factor_estimado
 *
 * @author epacheco
 */

namespace factor_est;

class ControlCrea  extends \Control {
    //put your code here

    public function guardarFactor($f3) {

         $depto = $f3->get('POST.DEPARTAMENTO');
         $pais = $f3->get('POST.PARAMETROS');
         $via = $f3->get('POST.VIA');
         $factor = $f3->get('POST.FACTOR_DOL');
         $tipo_moneda = $f3->get('POST.TIPO_MONEDA');
         $va = $f3->get('POST.va[]');$vb = $f3->get('POST.vb[]');
         $vc = $f3->get('POST.vc[]');$vd = $f3->get('POST.vd[]');
         $ve = $f3->get('POST.ve[]');$vf = $f3->get('POST.vf[]');
         $vg = $f3->get('POST.vg[]');$vh = $f3->get('POST.vh[]');$vi = $f3->get('POST.vi[]');
        
         $fila= $f3->get('POST.factor'); 

         if ($fila == "") { 

          $_exit = \temporada\Factor_Estimado::existe_Factor($f3->get('SESSION.COD_TEMPORADA'),
                                                              $depto,
                                                              $pais,
                                                              $via,
                                                              $tipo_moneda);
          if ($_exit == 1){
               $f3->set('SESSION.error', 'error_duplicado');
               $f3->reroute('/factor_estimado');
          }
                  
         }else{   
          $_exit = 1; 
         }

        $dttipo_cambio =  \temporada\Factor_Estimado::getTipo_Cambio($f3->get('SESSION.COD_TEMPORADA'));

        $ArrayVent = array("A","B","C","D","E","F","G","H","I");
        //! distinto true
        if ($_exit==0){ 
            $key3 = 0;
            foreach ($dttipo_cambio as $var  )  {//TABLA TIPO DE CAMBIO
                 if ($dttipo_cambio[$key3]['COD_TIP_MON'] == $tipo_moneda) {                                
                     foreach ($ArrayVent as $vent ){    
                        switch ($vent) {
                            case "A":
                                  $va = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "B":
                                  $vb = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "C":
                                  $vc = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "D":
                                  $vd = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "E":
                                  $ve = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "F":
                                  $vf = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "G":
                                  $vg = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "H":
                                  $vh = $factor * $dttipo_cambio[$key3][$vent];
                                  break; 
                            case "I":
                                  $vi = $factor * $dttipo_cambio[$key3][$vent];
                                  break; 
                         }//switch
                     }//foreach2 
                     break;
                 }//if
              $key3++;
            }//foreach 1 
 
            //Insert
             \temporada\factor_estimado::guardaFactorEstimado(1,
                                                              $tipo_moneda,
                                                              $factor,
                                                              $via,
                                                              $pais,
                                                              $depto,
                                                              $f3->get('SESSION.login'),
                                                              $f3->get('SESSION.COD_TEMPORADA'),
                                                              $va,$vb,$vc,$vd, 
                                                              $ve,$vf,$vg,$vh, 
                                                              $vi,
                                                              $fila);
        $f3->set('SESSION.exito', 'exito');
        $f3->reroute('/factor_estimado');
        }else{
            $key3 = 0;
            foreach ($dttipo_cambio as $var  )  {//TABLA TIPO DE CAMBIO
                 if ($dttipo_cambio[$key3]['COD_TIP_MON'] == $tipo_moneda) {                                
                     foreach ($ArrayVent as $vent ){    
                        switch ($vent) {
                            case "A":
                                  $va = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "B":
                                  $vb = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "C":
                                  $vc = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "D":
                                  $vd = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "E":
                                  $ve = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "F":
                                  $vf = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "G":
                                  $vg = $factor * $dttipo_cambio[$key3][$vent];
                                  break;
                            case "H":
                                  $vh = $factor * $dttipo_cambio[$key3][$vent];
                                  break; 
                            case "I":
                                  $vi = $factor * $dttipo_cambio[$key3][$vent];
                                  break; 
                         }//switch
                     }//foreach2 
                     break;
                 }//if
              $key3++;
            }//foreach 1 
            
            
            
            \temporada\factor_estimado::guardaFactorEstimado(2,
                                                              $tipo_moneda,
                                                              $factor,
                                                              $via,
                                                              $pais,
                                                              $depto,
                                                              $f3->get('SESSION.login'),
                                                              $f3->get('SESSION.COD_TEMPORADA'),
                                                              $va,$vb,$vc,$vd, 
                                                              $ve,$vf,$vg,$vh, 
                                                              $vi,
                                                              $fila);
            
        $f3->set('SESSION.modifica', 'exito_modificacion');
        $f3->reroute('/factor_estimado');
        }                 
                
    }
    
    
     public function beforeRoute($f3) {
        if ($f3->exists('SESSION.login') == false) {
            $f3->reroute('/fin-sesion');
        }
    }
}
