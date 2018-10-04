<?php

/**
 * Descripción: 
 * Fecha: 2018-05-09
 */

namespace permisos;

class PermisoTipoUsuario extends \Control {

    // funciones el modulo de asignar departamentos//
    public function llenar_tipo_usuario($f3) {
        echo json_encode(\permisos\permiso_usuario::llenar_tipo_usuario($f3->get('SESSION.COD_TEMPORADA')) );
    }

    public function llenar_usuario($f3) {

        // Se modifica por el código que sigue... para evitar el problema con los caracteres especiales
        //echo json_encode(\permisos\permiso_usuario::llenar_usuario($f3->get('GET.ID_TIPO_USUARIO')) );

        $data = \permisos\permiso_usuario::llenar_usuario($f3->get('GET.ID_TIPO_USUARIO'));
        $json = [];
        foreach ($data as $val) {
            $json[] = array(
                utf8_encode($val["COD_USR"]),   // String
                utf8_encode($val["NOM_USR"]),   // String
                $val["COD_TIPUSR"]              // Int
            );
        }
        header("Content-Type: application/json");
        echo json_encode($json, JSON_PRETTY_PRINT);

    }

    public function llenar_tabla_depto_permisos($f3) {
        echo json_encode(\permisos\permiso_usuario::llenar_tabla_depto_permisos($f3->get('GET.CODIGO_USUARIO_PERMISO')) );
    }

    public function guardar_permiso_depto($f3) {
        echo \permisos\permiso_usuario::guardar_permiso_depto($f3->get('GET.COD_USU'),$f3->get('GET.DEP_DEPTO'),$f3->get('GET.ESTADO'),$f3->get('SESSION.login'),$f3->get('GET.FLAG'));
    }


    /*funciones para validar si es el segundo usuario */
    public function busca_session($f3) {

        echo json_encode(\permisos\permiso_usuario::busca_session($f3->get('SESSION.login'),$f3->get('GET.DEPTO'),$f3->get('SESSION.COD_TEMPORADA'),$f3->get('GET.COD_TIP_GRP')) );
    }

    public function busca_cod_tip_usr($f3) {
        echo json_encode(\permisos\permiso_usuario::busca_cod_tip_usr($f3->get('SESSION.login')));
    }

    public function busca_usuario_tabla_session($f3) {
        echo json_encode(\permisos\permiso_usuario::busca_usuario_tabla_session($f3->get('SESSION.login'),$f3->get('GET.DEPTO'),$f3->get('SESSION.COD_TEMPORADA')));
    }

    public function guardar_concurrencia($f3) {
        $hostname = getenv('HTTP_HOST');
        $ip = @$_SERVER['HTTP_CLIENT_IP'] ?: @$_SERVER['HTTP_X_FORWARDED_FOR'] ?: @$_SERVER['REMOTE_ADDR'];

        echo \permisos\permiso_usuario::guardar_concurrencia(
            $f3->get('SESSION.COD_TEMPORADA')
            ,$f3->get('GET.DEPTO')
            ,$f3->get('GET.COD_MARC')
            ,$f3->get('GET.NUM_SESSION')
            ,$f3->get('SESSION.login')
            //,$f3->get('GET.USER_LOGIN')
            ,$hostname
            ,$ip
            ,$f3->get('GET.VERSION_APP')
            ,$f3->get('GET.CPU_COUNT')
            ,$f3->get('GET.CPU_MHZ')
            ,$f3->get('GET.CPU_NAME')
            ,$f3->get('GET.CPU_VENDOR')
            ,$f3->get('GET.CPU_INDENTI')
            ,$f3->get('GET.MEM_PHYSIC')
            ,$f3->get('GET.MEM_AVAPHY')
            ,$f3->get('GET.MEM_TOTVIR')
            ,$f3->get('GET.MEM_AVAVIR')
            ,$f3->get('GET.MEM_OSNAME')
            ,$f3->get('GET.COD_TIP_GRP'));
    }

    public function eliminar_concurrencia($f3) {

        echo \permisos\permiso_usuario::eliminar_concurrencia(
            $f3->get('SESSION.COD_TEMPORADA'),
            $f3->get('GET.DEPTO'),
            $f3->get('SESSION.login')
           );

    }

    // Funciones para el modulo de permisos.//
    public function cargar_modulos($f3) {
        echo json_encode(\permisos\permiso_usuario::cargar_modulos());
    }

    public function cargar_modulos_acciones($f3) {
        echo json_encode(\permisos\permiso_usuario::cargar_modulos_acciones($f3->get('GET.ID_MODULO')));
    }

    public function guardar_permiso_modulo_accion($f3) {

        echo \permisos\permiso_usuario::guardar_permiso_modulo_accion($f3->get('GET.ID_ACCION'),$f3->get('GET.TIP_USR'),$f3->get('GET.ESTADO_ACCION'),$f3->get('GET.ID_MODULO'),$f3->get('GET.ESTADO_MODULO'),$f3->get('SESSION.login'));
    }

    public function cargar_modulos_estados($f3) {
        echo json_encode(\permisos\permiso_usuario::cargar_modulos_estados($f3->get('GET.ID_TIP_USR'),$f3->get('GET.ID_MODULO')));
    }

    public function cargar_accion_estados($f3) {
        echo json_encode(\permisos\permiso_usuario::cargar_accion_estados($f3->get('GET.ID_TIP_USR'),$f3->get('GET.ID_MODULO'),$f3->get('GET.ID_ACCION')));
    }

    public function buscar_modulos_estados_desactivado($f3) {
        echo json_encode(\permisos\permiso_usuario::buscar_modulos_estados_desactivado($f3->get('GET.ID_TIP_USR')));
    }

    public function buscar_accion_estados_descativado($f3) {
        echo json_encode(\permisos\permiso_usuario::buscar_accion_estados_descativado($f3->get('GET.ID_TIP_USR')));
    }


    //funciones para el modulo de sessiones activas//
    public function actualiza_sesion_activa($f3) {

        echo \permisos\permiso_usuario::actualiza_sesion_activa(
            $f3->get('GET.TEMPO'),
            $f3->get('GET.DEPTO'),
            $f3->get('GET.COD_USU'),
            $f3->get('SESSION.login')

        );
    }

    public function buscar_sesion_activa_usuario_log($f3) {

        echo \permisos\permiso_usuario::buscar_sesion_activa_usuario_log(
            $f3->get('SESSION.COD_TEMPORADA'),
            $f3->get('GET.DEPTO'),
            $f3->get('SESSION.login')
        );
    }

    public function buscar_sesion_usuarios_log_out($f3) {

        echo \permisos\permiso_usuario::buscar_sesion_usuarios_log_out(
            $f3->get('GET.TEMPO'),
            $f3->get('GET.DEPTO'),
            $f3->get('GET.COD_USU')
        );
    }

    public function eliminar_concurrencia_sessiones_activas($f3) {

        echo \permisos\permiso_usuario::eliminar_concurrencia_sessiones_activas(
            $f3->get('GET.TEMPO'),
            $f3->get('GET.DEPTO'),
            $f3->get('GET.COD_USU'),
            $f3->get('SESSION.login')
        );
    }

// Termina Clase
}
