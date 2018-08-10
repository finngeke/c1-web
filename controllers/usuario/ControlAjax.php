<?php
/**
 * CONTROLADOR de AJAX Formulario de USURAIO
 * Descripción: 
 * Fecha: 2018-02-14
 * @author RODRIGO RIOSECO
 */

namespace usuario;

class ControlAjax extends \Control {

    public function agrega_perfil($f3) {

        
        try {
            perfil::crearPerfil($f3->get('SESSION.login'), $f3->get('GET.perfil'));
        } catch (Exception $ex) {
            echo 'ERROR-En el insert PLC_TIPO_USUARIO.';
        }
        
        echo 'OK-El nuevo perfil ['.strtoupper($f3->get('GET.perfil')).'] fue cargado con éxito..';
       
    }
    
     public function elimina_perfil($f3) {

        
        try {
            perfil::eliminaPerfil($f3->get('SESSION.login'), $f3->get('GET.perfil'));
        } catch (Exception $ex) {
            echo 'ERROR-En la eliminación PLC_TIPO_USUARIO.';
        }
        
        echo 'OK-El perfil ['.$f3->get('GET.perfil').'] fue eliminado con éxito..';
       
    }
    
    public function elimina_usuario($f3) {

        
        try {
            funcionario::eliminaFuncionario($f3->get('SESSION.login'), $f3->get('GET.usuario'));
        } catch (Exception $ex) {
            echo 'ERROR-En la eliminación PLC_USUARIO.';
        }
        
        echo 'OK-El usuario ['.$f3->get('GET.usuario').'] fue eliminado con éxito..';
       
    }

}

