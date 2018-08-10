<?php

namespace html;

class url {

    /**
     * Obtiene una URL según parámetros
     * @param string $destino Dirección de destino
     * @param string $accion  Acción a la cual hace referencia
     * @param array  $params  Parámetros de URL
     * @return string
     */
    public static function getURL($destino, $accion, $params = array()) {
        return sprintf('/%s?do=%s&amp;%s', $destino, $accion, http_build_query($params, null, '&amp;'));
    }

    /**
     * Obtiene un enlace HTML para la URL
     * @param string $etiqueta Texto que aparece en el enlace
     * @param string $destino   Dirección de destino
     * @param string $accion   Acción a la cual hace referencia
     * @param array  $params   Parámetros de URL
     * @param string $class    Clase CSS que se añadirá
     * @return string
     */
    public static function getHTML($etiqueta, $destino, $accion, $params = array(), $class = '') {
        return sprintf('<a href="%s" class="%s">%s</a>', self::getURL($destino, $accion, $params), $class, $etiqueta);
    }

    /**
     * Obtiene parámetros para dejarlos como atributos data
     * @param array $params
     * @return string
     */
    public static function getData($params = array()) {
        $txt = '';
        foreach ($params as $idx => $val) {
            $txt .= sprintf('data-%s="%s"', $idx, $val);
        }
        return $txt;
    }

    public static function getValue($params = array()) {
        return implode('-', $params);
    }

}
