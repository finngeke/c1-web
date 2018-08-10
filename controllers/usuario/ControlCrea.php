<?php

/**
 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
 * Descripción: 
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 */

namespace usuario;

class ControlCrea extends \Control {

    public function funcionario($f3) {

        /* echo $f3->get('POST.usuario') . '<br>';
          echo $f3->get('POST.nombre') . '<br>';
          echo $f3->get('POST.clave') . '<br>';
          echo $f3->get('POST.pais') . '<br>';
          echo $f3->get('POST.correo') . '<br>';
          echo $f3->get('POST.PERFIL') . '<br>';
          echo $f3->get('POST.optionsRadiosAct') . '<br>'; */
        
       
        $usuario = $f3->get('POST.usuario') == '' ? $f3->get('POST.login') : $f3->get('POST.usuario');
        
        if ((int) \usuario\funcionario::existeFuncionario($usuario) >= 1) {


            if (funcionario::modificarFuncionario($f3->get('SESSION.login'), $usuario, $f3->get('POST.nombre'), $f3->get('POST.clave'), $f3->get('POST.pais'), $f3->get('POST.correo'), $f3->get('POST.PERFIL'), $f3->get('POST.optionsRadiosAct'))) {
                $f3->set('SESSION.modifica', 'exito_modificacion');
            } else {
                $f3->set('SESSION.error', 'error');
            }
        } else {


            if (funcionario::crearFuncionario($f3->get('SESSION.login'), $usuario, $f3->get('POST.nombre'), $f3->get('POST.clave'), $f3->get('POST.pais'), $f3->get('POST.correo'), $f3->get('POST.PERFIL'), $f3->get('POST.optionsRadiosAct'))) {
                $f3->set('SESSION.exito', 'exito');
            } else {
                $f3->set('SESSION.error', 'error');
            }
        }


        $f3->reroute('/usuarios');
    }

    public function beforeRoute($f3) {
        if ($f3->exists('SESSION.login') == false) {
            $f3->reroute('/fin-sesion');
        }
    }

}
