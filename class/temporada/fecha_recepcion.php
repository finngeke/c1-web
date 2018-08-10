<?php

namespace temporada;

/**
 * Description of fecha_recepcion
 *
 * @author Roberto Pérez
 */

class fecha_recepcion {

    // Listar
    public static function getListafecharecepcion($cod_temp) {
          
        $data = \database::getInstancia()->getFilas( " SELECT E.COD_VENTANA
                                                            ,V.VENT_DESCRI                                         
                                                            --,E.FECHA_RECEPCD                                      
                                                           ,TO_CHAR(to_date(E.FECHA_RECEPCD,'dd-mm-yy'),'dd') || '/' ||  TO_CHAR(to_date(E.FECHA_RECEPCD,'dd-mm-yy'),'mm') || '/' ||  TO_CHAR(to_date(E.FECHA_RECEPCD,'dd-mm-yy'),'YYYY') FECHA_RECEPCD                                   
                                                            ,( SELECT G.SEMANA
                                                              FROM   GST_CALENDARIO G
                                                              WHERE  G.FECHA        = E.FECHA_RECEPCD ) as SEMINIRECEPCD           
                                                            ,TRIM( TO_CHAR( E.FECHA_RECEPCD, 'Month' ) ) || ' - ' || 
                                                             TRIM( TO_CHAR( E.FECHA_RECEPCD, 'YYYY' ) )  as MESINIRECEPCD       
                                                            --,E.FECHA_TDA
                                                            --,TO_CHAR(to_date(E.FECHA_TDA,'dd/mm/yy'),'dd/mm/yy') FECHA_TDA                                                                       
                                                            ,TO_CHAR(to_date(E.FECHA_TDA,'dd-mm-yy'),'dd') || '/' ||  TO_CHAR(to_date(E.FECHA_TDA,'dd-mm-yy'),'mm') || '/' ||  TO_CHAR(to_date(E.FECHA_TDA,'dd-mm-yy'),'YYYY') FECHA_TDA                                                                     
                                                            ,( SELECT G.SEMANA FROM   GST_CALENDARIO G
                                                              WHERE  G.FECHA        = E.FECHA_TDA )  AS SEMINIVENTA             
                                                            ,TRIM( TO_CHAR( E.FECHA_TDA, 'Month' ) ) || ' - ' || 
                                                             TRIM( TO_CHAR( E.FECHA_TDA, 'YYYY' ) )  AS MESINIVENTA               
                                                     FROM   PLC_VENTANA_EMB E,
                                                            PLC_VENTANA     V
                                                     WHERE  E.COD_VENTANA   = V.COD_VENTANA
                                                     AND    E.COD_TEMPORADA = ". $cod_temp." 
                                                     ORDER BY V.VENT_DESCRI");

        return $data;
    }

    // Guardar Registros
    public static function guardarFechaRecepcion($temporada, $depto, $vent_descri, $fecha_recepcd, $fecha_tda, $user, $login)
    {

        $sql = "INSERT INTO PLC_VENTANA_EMB( COD_TEMPORADA,
                                               COD_VENTANA,
                                               FECHA_RECEPCD,
                                               USR_CRE,
                                               FEC_CRE ,
                                              FECHA_TDA ,
                                              FECHA_LIQ1,
                                              FECHA_LIQ2)
                                       VALUES( $temporada,
                                               '" . $vent_descri . "',
                                               to_date('" . $fecha_recepcd . "','DD/MM/RR'),
                                               '" . $user . "',
                                               SYSDATE ,
                                               to_date('" . $fecha_tda . "','DD/MM/RR'),
                                               SYSDATE,
                                               SYSDATE)";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/FECHARECEPCION-AGREGAR--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }

    // Quitar todos Registros
    public static function quitarFechaRecepcion($temporada, $depto, $user, $login)
    {

        $sql = "DELETE FROM PLC_VENTANA_EMB
                WHERE cod_temporada = $temporada";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/FECHARECEPCION-QUITARRECEPCION--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }

    // Quitar ventana
    public static function quitarVentanaRecepcion($temporada, $depto, $ventana, $user, $login)
    {

        $sql = "begin PLC_PKG_GENERAL.PRC_DEL_VENTANA($temporada,$ventana, :error, :data); end;";

        // Almacenar TXT (Agregado antes del $data para hacer traza en el caso de haber error, considerar que si la ruta del archivo no existe el código no va pasar al $data)
        if (!file_exists('../archivos/log_querys/'.$login)) {
            mkdir('../archivos/log_querys/'.$login, 0775, true);
        }
        $stamp = date("Y-m-d_H-i-s");
        $rand = rand(1, 999);
        $content = $sql;
        $fp = fopen("../archivos/log_querys/".$login."/FECHARECEPCION-QUITARVENTANA--".$login."-".$stamp." R".$rand.".txt","wb");
        fwrite($fp,$content);
        fclose($fp);

        $data = \database::getInstancia()->getConsultaSP($sql, 2);
        return $data;

    }

    // Listar
    public static function contarRegistros($cod_temp) {

        $data = \database::getInstancia()->getFilas( " SELECT COUNT(*)TOTAL 
                                                            FROM PLC_VENTANA_EMB
                                                            WHERE COD_TEMPORADA = $cod_temp
                                                            ");

        return $data;

    }


// Fin clase fecha_recepcion
}
