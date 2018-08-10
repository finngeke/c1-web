<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace temporada;

/**
 * Description of Calculos
 *
 * @author epacheco
 */
class calculos {
    public static function RecarcularFactorEst($Tempo,$login){
        
        $dtfactor = \temporada\Factor_Estimado::getFactor_Estimado($Tempo);
        $dttipo_cambio =  \temporada\Factor_Estimado::getTipo_Cambio($Tempo);
       // var_dump($dtfactor[0]['DEP_DEPTO']);
        //die();
        $ArrayVent = array("A","B","C","D","E","F","G","H","I");
        $key2 = 0;
        foreach ($dtfactor as $val){      //TABLA FACTOR
          $monfact = $dtfactor[$key2]['COD_MONEDA'];   
          $key3 = 0;
          $CambioXVentana = "";
          //--------Carga los tipo de cambio por ventana
          foreach ($dttipo_cambio as $var  )  {//TABLA TIPO DE CAMBIO
              if ($dttipo_cambio[$key3]['COD_TIP_MON'] == $monfact) {
                  foreach ($ArrayVent as $vent ){ 
                     $CambioXVentana = $CambioXVentana.$dttipo_cambio[$key3][$vent]."-"; 
                  } 
                  $CambioXVentana = substr($CambioXVentana, 0, -1);
                   break ;                 
              }
              $key3++;
          }         
          $cambios = explode("-", $CambioXVentana);
          
        $i = 0;
        foreach ($cambios as $val4){
            if ($i== 0){
               $vA = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }elseif ($i== 1) {
                   $vB = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ; 
            }elseif ($i== 2) {
                   $vC = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }elseif ($i== 3) {
                   $vD = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }elseif ($i== 4) {
                   $vE = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }elseif ($i== 5) {
                   $vF = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }elseif ($i== 6) {
                   $vG = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }elseif ($i== 7) {
                   $vH = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }else{
                   $vI = $val4 * $dtfactor[$key2]['FACTOR_DOL'] ;
            }
             $i++;
        }            
         \temporada\factor_estimado::updateFactorEstimadoV($monfact,
                                                           $dtfactor[$key2]['FACTOR_DOL'],
                                                           $dtfactor[$key2]['COD_VIA'],
                                                           $dtfactor[$key2]['COD_PAIS'],
                                                           $dtfactor[$key2]['DEP_DEPTO'],
                                                           $login,
                                                           $Tempo,
                                                           $vA, 
                                                           $vB, 
                                                           $vC, 
                                                           $vD, 
                                                           $vE, 
                                                           $vF, 
                                                           $vG, 
                                                           $vH, 
                                                           $vI);
          
         $key2++;             
        }
    }
}
