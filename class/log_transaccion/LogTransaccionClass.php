<?php

namespace log_transaccion;

class LogTransaccionClass extends \parametros
{

    // Almacena Log Transacción
    public static function GuardaLogTransaccion($login, $temporada, $depto, $modulo, $accion, $query, $mensaje )
    {

        if(!$mensaje){$mensaje = "NI";}
        if(!$temporada){$temporada = 0;}
        if(!$depto){$depto = "ND";}

        $query = str_replace("'","#",str_replace("'","#",$query));
        $query = str_replace(" ","",$query);

        $sql = "INSERT INTO C1_LOG_TRANSACCIONES (USUARIO,COD_TEMPORADA,DEPARTAMENTO,MODULO,ACCION,QUERY,MENSAJE,FECHA)
                VALUES ('".$login."',$temporada,'".$depto."','".$modulo."','".$accion."','".$query."','".$mensaje."',SYSDATE)";
        $data = \database::getInstancia()->getConsulta($sql);
        return $data;

    }


// Fin de la Clase
}