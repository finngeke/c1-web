<?php

/**
 * CONTROLADOR de ingreso PORTADA
 * Descripción:
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 */
class ControlPortada extends Control {

    public function portada($f3) {

        if ($f3->exists('SESSION.mae_rut') == false) {
            $f3->set('contenido', 'login.php');
            $f3->set('mensaje', Control::setMensajePredeterminado($f3->get('bienvenida')));
        } else {
            $f3->reroute('/inicio');
        }
        echo Template::instance()->render('layout_login.php');
    }

    public function login($f3) {

        $usr_pwd = str_replace(array('"', '.', '=', "'"), '', $f3->get('POST.clave'));
        $usr_nom = str_replace(array('"', '.', '=', "'"), '', $f3->get('POST.usuario'));
        $f3->set('SESSION.BD_control_conexion', $f3->get('POST.select_control_conexion'));

        $error = false;

        $f3->set('mensaje', Control::setMensajePredeterminado($f3->get('error_login')));
        $Funcionario = new usuario\funcionario($usr_nom, $usr_pwd);
        if ($Funcionario->isFuncionario() != true) {
            $f3->set('mensaje[message]', $f3->get('errores.no_data_login'));
            $error = true;
        }
        if ($error === true) {
            $f3->set('contenido', 'login.php');
            echo Template::instance()->render('layout_login.php');
            die();
        }


      /* Comentar para Ingresar a QA*/
        if( ($Funcionario->getDatosFuncionario()->COD_TIPUSR!=99) && ($f3->get('POST.select_control_conexion')!="PROD")&&($Funcionario->getDatosFuncionario()->COD_TIPUSR!=103) ){
            $f3->set('contenido', 'login.php');
            echo Template::instance()->render('layout_login.php');
            die();
        }

        if ($Funcionario->getDatosFuncionario()->COD_TIPUSR==103){
            $f3->reroute('/proveedor?cod_proveedor='.$Funcionario->getDatosFuncionario()->COD_USR);
            die();
        }


        setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish');
        $f3->set('SESSION.login', $Funcionario->getDatosFuncionario()->COD_USR);
        $f3->set('SESSION.nombre', $Funcionario->getDatosFuncionario()->NOM_USR);
        $f3->set('SESSION.estado', $Funcionario->getDatosFuncionario()->ESTADO);
        $f3->set('SESSION.cod_perfil', $Funcionario->getDatosFuncionario()->COD_TIPUSR);
        $f3->set('SESSION.correo', $Funcionario->getDatosFuncionario()->CORREO);
        $f3->set('SESSION.cod_tipusr', $Funcionario->getDatosFuncionario()->COD_TIPUSR);
        $f3->set('SESSION.dia', utf8_encode(strftime('%Y. %B %d. %A')));
        $f3->reroute('/inicio');
    }

    public function salir($f3) {
        $f3->clear('SESSION.login');
        $f3->clear('SESSION.nombre');
        $f3->clear('SESSION.estado');
        $f3->clear('SESSION.correo');
        $f3->clear('SESSION.cod_tipusr');
        $f3->clear('SESSION.dia');
        $f3->clear('SESSION.cod_perfil');
        $f3->clear('SESSION.GLOSA_TEMPORADA');
        $f3->clear('SESSION.COD_TEMPORADA');
        $f3->clear('SESSION.COD_DEPTO');
        $f3->clear('SESSION.BD_control_conexion');
        $f3->clear('SESSION.session_depto_validar_url');
        $f3->reroute('/');
    }

}