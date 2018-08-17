<?php

/**
 * CONTROLADOR de FORMULARIOS
 * Descripción: 
 * Fecha: 2018-05-04
 * @author RODRIGO RIOSECO
 * @Edita Roberto Pérez
 */
class ControlFormularioMain extends Control {

    public function inicio($f3) {
        ControlFormularioMain::cargaMain($f3);
        //$f3->set('temporadas', temporada\temporada::getSelect());
        $f3->set('contenido', 'formulario/main/inicio.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
        $f3->set('proveedor', 'formulario/main/proveedor.html');
        echo Template::instance()->render('layout_inicio.php');
    }

    public function usuarios($f3) {
        ControlFormularioMain::cargaMain($f3);
        ControlFormularioMain::cargaMensaje($f3);
        $f3->set('nombre_form', 'USUARIOS');
        $f3->set('perfiles', temporada\perfiles::getSelect());
        $f3->set('Lista_usuario', \usuario\funcionario::getListaFuncionarios());
        $f3->set('contenido', 'formulario/main/usuarios.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
			$f3->set('proveedor', 'formulario/main/proveedor.html');
        echo Template::instance()->render('layout_inicio.php');
    }

    public function sesiones_activas($f3) {
        ControlFormularioMain::cargaMain($f3);
        ControlFormularioMain::cargaMensaje($f3);
        $f3->set('nombre_form', 'SESIONES ACTIVAS');
        $f3->set('Lista_sesiones_activas', sesiones\activas::getSesionesActivas());
        $f3->set('contenido', 'formulario/main/sesiones_activas.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
			$f3->set('proveedor', 'formulario/main/proveedor.html');
        echo Template::instance()->render('layout_inicio.php');
    }

    public function permisos($f3) {
        ControlFormularioMain::cargaMain($f3);
        $f3->set('nombre_form', 'PERFILES DE USUARIO');
        $f3->set('contenido', 'formulario/main/permisos.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
			$f3->set('proveedor', 'formulario/main/proveedor.html');
        echo Template::instance()->render('layout_inicio.php');
    }

    public function mantenimiento_sistema($f3) {
        ControlFormularioMain::cargaMain($f3);
        $f3->set('nombre_form', 'MANTENCIÓN DEL SISTEMA');
        $f3->set('contenido', 'formulario/main/mantenimiento_sistema.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
			$f3->set('proveedor', 'formulario/main/proveedor.html');
        echo Template::instance()->render('layout_inicio.php');
    }

    public function actualizar_calculos($f3) {
        ControlFormularioMain::cargaMain($f3);
        $f3->set('nombre_form', 'ACTUALIZAR CALCULOS');
        $f3->set('contenido', 'formulario/main/actualizar_calculos.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
			$f3->set('proveedor', 'formulario/main/proveedor.html');
        echo Template::instance()->render('layout_inicio.php');
    }

    public function master_pack($f3) {
        ControlFormularioMain::cargaMain($f3);
        $f3->set('nombre_form', 'MASTER PACK');
        $division = jerarquia\division::getListaDivisiones();
        $combo_division = new \html\select($division, 'DIV_DIVISION', 'DIV_DESCRIPCION');
        //$combo_division->setOptionNulo('TODOS');
        $f3->set('Lista_divisiones', $combo_division);
        $f3->set('division', 'formulario/main/division.html');
        $f3->set('contenido', 'formulario/main/master_pack.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
			$f3->set('proveedor', 'formulario/main/proveedor.html');
        $f3->set('tipo_deptomarca', 'formulario/plan_compra/mantenedor/popup_deptomarca.html');
        //echo Template::instance()->render('layout_inicio.php');
        echo Template::instance()->render('layout_simulador.php'); // ( Antes de modificación menú era layout_inicio.php igual que mantenedor_master_pack )
    }

    public function mantenedor_master_pack($f3) {
        ControlFormularioMain::cargaMain($f3);
        $f3->set('nombre_form', 'MASTER PACK');
        $f3->set('filtro', $f3->get('GET.division'));
        $division = jerarquia\division::getListaDivisiones();
        $combo_division = new \html\select($division, 'DIV_DIVISION', 'DIV_DESCRIPCION');
        $combo_division->setOptionNulo('Seleccione la division');
        $f3->set('Lista_master_pack', \jerarquia\departamento::getDepartamentoDivision($f3->get('GET.division'),$f3->get('GET.depto_pop_master')));
        $f3->set('Lista_divisiones', $combo_division);
        $f3->set('contenido', 'formulario/main/lista_master_pack.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
		$f3->set('proveedor', 'formulario/main/proveedor.html');
        $f3->set('tipo_deptomarca', 'formulario/plan_compra/mantenedor/popup_deptomarca.html');
        //echo Template::instance()->render('layout_inicio.php');
        echo Template::instance()->render('layout_simulador.php'); // ( Antes de modificación menú era layout_inicio.php igual que master_pack )
    }

    /*public static function deptomarca($f3) {
        $f3->set('tipo_deptomarca', 'formulario/plan_compra/mantenedor/popup_deptomarca.html');

        $formatos = \simulador_compra\formato::getFormatos($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'));

        foreach($formatos as $val)
        {
            $formato[]= array($val[0] => 'CODIGO', $val[1] => 'DESCRIPCION');
        }

        $select = new html\select($formatos, 0, 1);
        $f3->set('lis_formato', $select);

        $f3->set('depto', $f3->get('SESSION.COD_DEPTO'));
        $f3->set('temporada', $f3->get('SESSION.COD_TEMPORADA'));


    }*/

    /*public function depto_marca($f3) {
        ControlFormularioMain::cargaMain($f3);
        $f3->set('nombre_form', 'DEPARTAMENTO / MARCA');
        $f3->set('contenido', 'formulario/main/depto_marca.html');
        echo Template::instance()->render('layout_inicio.php');
    }*/

    public function temporada_compra($f3) {
        ControlFormularioMain::cargaMain($f3);
        ControlFormularioMain::cargaMensaje($f3);
        $f3->set('nombre_form', 'TEMPORADA DE COMPRA');
        $f3->set('Lista_temporadas', \temporada\temporada::getListaTemporadas());
        $f3->set('contenido', 'formulario/main/temporada_compra.html');
        $f3->set('temporada', 'formulario/main/temporada.html');
        $f3->set('proveedor', 'formulario/main/proveedor.html');
        echo Template::instance()->render('layout_inicio.php');
    }
	
    public function beforeRoute($f3) {
        if ($f3->exists('SESSION.login') == false) {
            $f3->reroute('/fin-sesion');
        }
    }

    public static function cargaMain($f3) {
        $Perfil = new usuario\perfil($f3->get('SESSION.cod_perfil'));
        $f3->set('login', $f3->get('SESSION.login'));
        $f3->set('nombre', $f3->get('SESSION.nombre'));
        $f3->set('estado', $f3->get('SESSION.estado'));
        $f3->set('correo', $f3->get('SESSION.correo'));
        $f3->set('BD_CONEXION', $f3->get('SESSION.BD_control_conexion'));
        $f3->set('dia', $f3->get('SESSION.dia'));
        $f3->set('perfil', $Perfil->getDescripcion()->TIPO_USR);
        $f3->set('activas', count(sesiones\activas::getSesionesActivas())); // Pendiente por TIEMPO DE CARGA...
    }

    public static function cargaMensaje($f3) {

        switch ($f3) {
            case $f3->exists('SESSION.exito'):
                $f3->set('mensaje', Control::SetMensajePredeterminado($f3->get('exito_formulario')));
                $f3->clear('SESSION.exito');
                break;
            case $f3->exists('SESSION.modifica'):
                $f3->set('mensaje', Control::SetMensajePredeterminado($f3->get('exito_modificacion')));
                $f3->clear('SESSION.modifica');
                break;
            case $f3->exists('SESSION.error'):
                $error = $f3->get('SESSION.error');
                $f3->set('mensaje', Control::SetMensajePredeterminado($f3->get($error)));
                $f3->clear('SESSION.error');
                break;
            case $f3->exists('SESSION.archivo'):
                $error = $f3->get('SESSION.archivo');
                $mensaje = explode("$", $error);
                if ($mensaje[6] == 'C') {
                    $msg = $mensaje[5] . ' en la Fila Nro. : [' . $mensaje[2] . '] Columna : [' . $mensaje[0] . ']';
                } else {
                    $msg = $mensaje[5];
                }
                $f3->set('mensaje', Control::SetMensajePredeterminado(array(
                            'head' => $mensaje[4],
                            'msg' => $msg,
                            'icon' => $mensaje[1],
                            'color' => $mensaje[3]
                )));
                $f3->clear('SESSION.archivo');
                break;
            default:
                $f3->clear('SESSION.error');
                $f3->clear('SESSION.archivo');
                $f3->clear('SESSION.exito');
                $f3->clear('SESSION.modifica');
        }

    }



// Fin de la Clase ControlFormularioMain
}
