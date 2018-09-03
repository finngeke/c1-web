<?php

/**
 * Fecha: 2018-12-07
 */

namespace permisos;

class permiso_usuario extends \parametros {

    //funciones para la asignacion de departamentos a usuarios//
    public static function llenar_tipo_usuario() {
        $sql = "begin PLC_PKG_SEGURIDAD.PRC_LISTAR_TIPO_USUARIO(:data); end;";
        $data_tipo = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data_tipo;
    }

    public static function llenar_usuario($id_tipo_usuario) {

        $sql = "SELECT COD_USR, nom_usr, cod_tipusr 
                    FROM plc_usuario 
                    where cod_tipusr = $id_tipo_usuario ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function llenar_tabla_depto_permisos($CODIGO_USUARIO_PERMISO) {
        $sql = "begin plc_pkg_seguridad.PRC_LISTAR_DEPTOS_TIPUSR('".$CODIGO_USUARIO_PERMISO."','','',:data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql, 1);
        return $data;
    }

    public static function guardar_permiso_depto($COD_USU,$DEP_DEPTO,$ESTADO,$login,$FLAG) {
        $sql = "begin PLC_PKG_SEGURIDAD.PRC_ADD_ACCESO_DEPTOS('".$COD_USU."','".$DEP_DEPTO."',$ESTADO,'".$login."',$FLAG,:error,:data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PERMISOS-GUARDAR_PERMISO_DEPTO--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        //$data_tipo = \database::getInstancia()->getConsultaSP($sql, 2);
       //return $data_tipo;

        if( \database::getInstancia()->getConsultaSP($sql, 2)){
            echo 1;
        }else{
            echo 0;
        }

    }


/*codigo para validar si es el segundo usuario */
    public static function busca_session($login,$depto,$temporada,$COD_TIP_GRP) {

        $sql = "SELECT T.cod_tipusr,u.nom_usr
                FROM PLC_CONCURRENCIA S
                INNER JOIN plc_usuario U ON u.cod_usr=s.cod_usr
                INNER JOIN plc_tipo_usuario T ON t.cod_tipusr = u.cod_tipusr
                WHERE s.cod_temporada = $temporada
                AND s.dep_depto = '".$depto."'
                AND t.cod_tipusr IN ($COD_TIP_GRP)";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function busca_cod_tip_usr($login) {

        $sql = "SELECT cod_tipusr
                FROM plc_usuario 
                where cod_usr ='".$login."' ";

        $data = \database::getInstancia()->getFilas($sql);

        return $data;
    }

    public static function busca_usuario_tabla_session($login,$depto,$temporada) {

        $sql = "SELECT COUNT(distinct( S.cod_usr))
                        FROM PLC_CONCURRENCIA S
                        INNER JOIN plc_usuario U ON u.cod_usr=s.cod_usr
                        INNER JOIN plc_tipo_usuario T ON t.cod_tipusr = u.cod_tipusr
                        WHERE s.cod_temporada = $temporada
                        AND s.dep_depto = '".$depto."' 
                        AND S.cod_usr = '".$login."'  
                        ";
        $data = \database::getInstancia()->getFilas($sql);

        return $data;

    }

    public static function guardar_concurrencia($COD_TEMPORADA,$DEPTO,$COD_MARC,$NUM_SESSION,$login,$HOST,$IP,$VERSION_APP,$CPU_COUNT,$CPU_MHZ,$CPU_NAME,$CPU_VENDOR,$CPU_INDENTI,$MEM_PHYSIC,$MEM_AVAPHY,$MEM_TOTVIR,$MEM_AVAVIR,$MEM_OSNAME,$COD_TIP_GRP)
    {

        $sql_existe = "SELECT 1
                FROM PLC_CONCURRENCIA S
                INNER JOIN plc_usuario U ON u.cod_usr=s.cod_usr
                INNER JOIN plc_tipo_usuario T ON t.cod_tipusr = u.cod_tipusr
                WHERE s.cod_temporada = $COD_TEMPORADA
                AND s.dep_depto = '".$DEPTO."'
                AND t.cod_tipusr IN ($COD_TIP_GRP)";

        $existe = (int) \database::getInstancia()->getFila($sql_existe);

        if ($existe == 1) {
            return 0 ;

        }else {

            $sql = "INSERT INTO PLC_CONCURRENCIA(COD_TEMPORADA,
                                       DEP_DEPTO,
                                       COD_MAR,
                                       NUM_SESION,
                                       COD_USR,
                                       USER_LOGIN,
                                       HOST,
                                       IP,
                                       VERSION_APP,
                                       FECHA,
                                       CPU_COUNT,
                                       CPU_MHZ,
                                       CPU_NAME,
                                       CPU_VENDOR,
                                       CPU_IDENTI,
                                       MEM_PHYSIC,
                                       MEM_AVAPHY,
                                       MEM_TOTVIR,
                                       MEM_AVAVIR,
                                       MEM_OSNAME)
                               VALUES($COD_TEMPORADA,'" . $DEPTO . "',$COD_MARC,$NUM_SESSION,'" . $login . "','" . $login . "','" . $HOST . "','" . $IP . "','" . $VERSION_APP . "',SYSDATE,'" . $CPU_COUNT . "','" . $CPU_MHZ . "','" . $CPU_NAME . "','" . $CPU_VENDOR . "','" . $CPU_INDENTI . "','" . $MEM_PHYSIC . "','" . $MEM_AVAPHY . "','" . $MEM_TOTVIR . "','" . $MEM_AVAVIR . "','" . $MEM_OSNAME . "')
                               ";

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql;
            $fp = fopen("../archivos/log_querys/" . $login . "/PERMISO-INSERTARLOGIN--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            $data = \database::getInstancia()->getConsulta($sql);
            return $data;

        }
    }

    public static function eliminar_concurrencia($TEMPO,$DEPTO,$login) {


        $sql = "delete from plc_concurrencia 
                where COD_TEMPORADA = $TEMPO
                and DEP_DEPTO = '".$DEPTO."'
                and cod_usr = '".$login."' 
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PERMISO-BORRAR-SESSION--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;
    }


//codigo de modulo de permisos validar y asignar permisos//
    public static function cargar_modulos() {

        $sql = "SELECT ID_MODULO,NOMBRE_MODULO 
                FROM PLC_MODULO_ACCESO_TIPO_USR 
                ORDER BY ID_MODULO ASC
                ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function cargar_modulos_acciones($ID_MODULO) {

        $sql = "SELECT ID_ACCION,ID_MODULO,NOMBRE_ACCION FROM PLC_MODULO_ACCION
                WHERE ID_MODULO = '".$ID_MODULO."' ";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function guardar_permiso_modulo_accion($ID_ACCION,$TIP_USR,$ESTADO_ACCION,$ID_MODULO,$ESTADO_MODULO,$login)
    {
        $sql_existe = "SELECT 1
                        FROM PLC_PERMISO_MODULO_ACCION 
                        WHERE ID_ACCION = $ID_ACCION 
                        AND ID_MODULO = $ID_MODULO
                        AND ID_TIP_USR = $TIP_USR";

        $existe = (int) \database::getInstancia()->getFila($sql_existe);

        if ($existe == 1) {

            $sql = " UPDATE PLC_PERMISO_MODULO_ACCION
                       SET   ESTADO_ACCION   =  $ESTADO_ACCION,
                             ESTADO_MODULO  =   $ESTADO_MODULO
                       WHERE ID_ACCION = $ID_ACCION 
                        AND ID_MODULO = $ID_MODULO
                        AND ID_TIP_USR = $TIP_USR";

        }else {

            $sql = "INSERT INTO PLC_PERMISO_MODULO_ACCION (ID_ACCION,ID_TIP_USR,ESTADO_ACCION,ID_MODULO,ESTADO_MODULO)
                          VALUES ($ID_ACCION,$TIP_USR,$ESTADO_ACCION,$ID_MODULO,$ESTADO_MODULO)";
        }

            // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
            if (!file_exists('../archivos/log_querys/' . $login)) {
                mkdir('../archivos/log_querys/' . $login, 0775, true);
            }
            $stamp = date("Y-m-d_H-i-s");
            $rand = rand(1, 999);
            $content = $sql;
            $fp = fopen("../archivos/log_querys/" . $login . "/PERMISOS-MODULO-ACCION-INSERTAR-PERMISO--" . $login . "-" . $stamp . " R" . $rand . ".txt", "wb");
            fwrite($fp, $content);
            fclose($fp);

            //$data = \database::getInstancia()->getConsulta($sql);
            //return $data;
            if(\database::getInstancia()->getConsulta($sql)){
                echo 1;
            }else{
                echo 0;
            }


        }

    public static function cargar_modulos_estados($ID_TIP_USR,$ID_MODULO) {

        $sql = "SELECT ID_MODULO,ESTADO_MODULO FROM PLC_PERMISO_MODULO_ACCION
                where ID_TIP_USR = $ID_TIP_USR
                and ID_MODULO = $ID_MODULO
                and ID_ACCION = 0";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function cargar_accion_estados($ID_TIP_USR,$ID_MODULO,$ID_ACCION) {

        $sql = "SELECT ID_ACCION,ESTADO_ACCION,ID_MODULO FROM PLC_PERMISO_MODULO_ACCION
                where ID_TIP_USR = $ID_TIP_USR
                and ID_MODULO= $ID_MODULO
                and ID_ACCION = $ID_ACCION 
                and ID_ACCION != 0";

        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function buscar_modulos_estados_desactivado($ID_TIP_USR) {

        $sql = " SELECT M.ID_MODULO,M.NOMBRE_MODULO,P.ESTADO_MODULO
                FROM PLC_PERMISO_MODULO_ACCION P,
                     PLC_MODULO_ACCESO_TIPO_USR M
                where M.id_modulo = P.id_modulo
                and P.ID_TIP_USR= $ID_TIP_USR
                and P.ID_ACCION= 0
                and P.ESTADO_MODULO= 0
                ";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }

    public static function buscar_accion_estados_descativado($ID_TIP_USR) {

        $sql = "SELECT P.ID_ACCION
                FROM plc_permiso_modulo_accion P,
                    plc_modulo_accion M
                where P.ID_ACCION= M.ID_ACCION
                and P.ID_TIP_USR= $ID_TIP_USR
                and P.ID_ACCION!= 0
                and P.ESTADO_ACCION= 0";
        $data = \database::getInstancia()->getFilas($sql);
        return $data;

    }


    //funciones modulo de sessiones activas//

    //Funcion que cambia el el estado de la session ("cambia a pendiente de salir")
    public static function actualiza_sesion_activa($TEMPO,$DEPTO,$COD_USU,$login) {


        $sql = "update plc_concurrencia 
                set IS_OFFLINE = 1
                where COD_TEMPORADA = $TEMPO
                and DEP_DEPTO =  '".$DEPTO."' 
                and user_login = '".$COD_USU."' ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/SESSION-ACTIVA-ACTUALIZAR-SESSION--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;
    }

    //funcion busca cuando el usuario esta en el simulador//
    public static function buscar_sesion_activa_usuario_log($TEMPO,$DEPTO,$login) {


        $sql = "SELECT 1 
                    FROM PLC_CONCURRENCIA 
                    WHERE COD_TEMPORADA = $TEMPO
                    AND DEP_DEPTO = '".$DEPTO."' 
                    AND user_login = '".$login."'
                    AND IS_OFFLINE = 1
                    ";

        $existe = (int) \database::getInstancia()->getFila($sql);

        if ($existe == 1){
            return 1;

        }else{
            return 0;
        }

        //$data = \database::getInstancia()->getFilas($sql);
        //echo $data;
    }

    //funcion busca cuando el usuario fue seleccionado en el modulo de sessiones activas.//
    public static function buscar_sesion_usuarios_log_out($TEMPO,$DEPTO,$COD_USU) {


        $sql = "SELECT 1 
                    FROM PLC_CONCURRENCIA 
                    WHERE COD_TEMPORADA = $TEMPO
                    AND DEP_DEPTO = '".$DEPTO."' 
                    AND COD_USR = '".$COD_USU."'
                    AND IS_OFFLINE = 1
                    ";

        $existe = (int) \database::getInstancia()->getFila($sql);

        if ($existe == 1){
            return 1;

        }else{
            return 0;
        }

        //$data = \database::getInstancia()->getFilas($sql);
        //echo $data;
    }

    public static function eliminar_concurrencia_sessiones_activas($TEMPO,$DEPTO,$COD_USU,$login) {


        $sql = "delete from PLC_CONCURRENCIA
                where COD_TEMPORADA = $TEMPO
                and DEP_DEPTO = '".$DEPTO."'
                and COD_USR = '".$COD_USU."' 
                ";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/PERMISO-BORRAR-SESSION--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;
    }
// Fin de la Clase
}


