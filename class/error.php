<?php

class error {

    /**
     * Obtiene mensaje de error
     * @param string $mensaje Mensaje de alerta
     * @param string $css     [opcional] Clase selectora de error
     * @param string $titulo  [opcional] Titulo de la funcionalidad
     * @return string
     */
    public static function getError($mensaje, $css = 'alerta', $titulo = null) {
        $string = is_null($titulo) === false ? sprintf('<h1>%s</h1>', $titulo) : '';
        $string .= sprintf('<p class="%s">%s</p>', $css, $mensaje);
        return $string;
    }

    /**
     * Obtiene un enlace para volver a una URL o la pagina anterior
     * @param  string $url [opcional] URL a la cual volver
     * @return string
     */
    public static function getVolver($url = null, $mensaje = null) {
        $mensaje = is_null($mensaje) === true ? 'Volver a la p&aacute;gina anterior' : $mensaje;
        $back = is_null($url) === true ? 'javascript:window.history.back()' : $url;
        return sprintf('<center><a href="%s">%s</a></center>', $back, $mensaje);
    }

    /**
     * Obtiene un enlace para cerrar la ventana
     * @return string
     */
    public static function getCerrar() {
        return '<center><a href="javascript:self.close()">Cerrar</a></center>';
    }

    /**
     * Incluye las cabeceras de HTML si fuese necesario
     */
    public function getCabeceras() {
        include_once "../lib/incluye_recursos.php";
        include_once "../lib/head.php";
    }

}
