<?php
/**
 * CONTROLADOR de MENSAJES
 * Descripción: 
 * Fecha: 2018-02-06
 * @author RODRIGO RIOSECO
 */
class Control
{

    /**
     * Establece las pautas de mensajes...
     * @param string $tipo    tipo de mensaje: info, warning, error
     * @param string $mensaje texto del mensaje
     * @param string $header  cabecera de sección
     * @param string $icon    icono
     * @return string
     */
    public static function setMensaje($color = 'blue', $msg = '', $header = '', $icon = "")
    {
        $mensaje = array();
        $mensaje['color'] = $color;
        $mensaje['message'] = $msg;
        $mensaje['header'] = $header;
        $mensaje['icon'] = $icon;
        return $mensaje;
    }

    public static function SetMensajePredeterminado(array $arreglo)
    {
        return self::setMensaje($arreglo['color'], $arreglo['msg'], $arreglo['head'], $arreglo['icon']);
    }
    

}
