<?php

namespace html;

class select {

    var $serializado = null;
    var $attr = null;
    var $nombre = 'select';
    var $html = null;
    var $def = null;
    var $cod = false;

    /**
     * Constructor de clase
     * @param array $arreglo Arreglo donde buscar los id y valores
     * @param string $id Identificador que es el atributo "value" de la etiqueta opcion
     * @param string $valor Valor de la etiqueta option
     * @param string $nombre Nombre del Select
     * @param mixed $defecto Valor por defecto del select
     * @param array $attr Atributos opcionales del select
     */
    public function __construct($arreglo, $id, $valor, $nombre = 'select', $defecto = null, $attr = array()) {
        $this->_serializar($arreglo, $id, $valor, $defecto)->setAtributos($attr);
        $this->setNombre($nombre);
    }

    /**
     * Serializacion del arreglo y aplicacion del valor por defecto si hubiere
     * @param array $arreglo Arreglo donde buscar los id y valores
     * @param string $id Identificador que es el atributo "value" de la etiqueta opcion
     * @param string $valor Valor de la etiqueta option
     * @param string $nombre Nombre del Select
     * @param mixed $defecto Valor por defecto del select
     * @return \Select 
     */
    private function _serializar($arreglo, $id, $valor, $defecto = null) {
        $tmp = array();
        foreach ($arreglo as $val) {
            if (count(array_intersect(array($id, $valor), array_keys($val))) == 2) {
                $tmp[] = array($val[$id], $val[$valor], !is_null($defecto) && $val[$id] == $defecto);
            }
        }
        $this->serializado = $tmp;
        return $this;
    }

    /**
     * Indica los atributos del select
     * @param array $attr Arreglo identificado por atributo=>valor atributo
     * @return \Select 
     */
    public function setAtributos($attr) {
        $this->attr = implode(" ", array_map(function($k, $v) {
                    return "{$k}=\"{$v}\"";
                }, array_keys($attr), array_values($attr)));
        return $this;
    }

    /**
     * Agrega un option nulo al inicio del select
     * @param string $st Cadena de texto a exponer
     * @return \Select
     */
    public function setOptionNulo($st) {
        $this->def = $st;
        return $this;
    }

    /**
     * Establece si el select sera codigo y valor como muestra del option
     * @param bool $st TRUE si muestra codigo valor
     * @return \Select
     */
    public function setCodigoValor($bool) {
        $this->cod = $bool;
        return $this;
    }

    /**
     * Aplica valores unicode a los textos de salids (util para ajax!)
     * @return \html\Select
     */
    public function setUnicode() {
        $serializado = $this->serializado;
        array_walk($serializado, function(&$item, $k, $val) {
            $item[1] = utf8_encode($item[1]);
        }, null);
        $this->serializado = $serializado;
        return $this;
    }

    /**
     * Indica el valor por defecto del select
     * @param mixed $valor
     * @return \Select 
     */
    public function setDefecto($valor) {
        $serializado = $this->serializado;
        array_walk($serializado, function(&$item, $k, $val) {
            $item[2] = ($item[0] == $val);
        }, $valor);
        $this->serializado = $serializado;
        return $this;
    }

    /**
     * Elimina un valor del arreglo
     * @param mixed $indice
     * @return \Select
     */
    public function doBorrarOpcion($indice) {
        $this->serializado = array_filter($this->serializado, function($f) use ($indice) {
            return ($indice != $f[0]);
        });
        return $this;
    }

    /**
     * Obtiene el HTML y limpia las variables si se desea. Se puede indicar el nombre del select si varia
     * @param bool (opcional) $unset Si es verdadero, se borra el serializado
     * @param string (opcional) $nombre Nombre del select
     * @return type 
     */
    public function getHTML($unset = true, $nombre = NULL) {
        $nombre = is_null($nombre) ? $this->nombre : $nombre;
        $tmp = sprintf('<select name="%s" id="%s" %s>', $nombre, $nombre, $this->attr);
        if (is_null($this->def) == FALSE)
            $tmp .= '<option value="null">' . $this->def . '</option>';
        foreach ($this->serializado as $v) {
            $tmp .= sprintf('<option value="%s"%s>%s</option>', $v[0], $v[2] ? ' selected="selected"' : '', ($this->cod == TRUE ? $v[0] . "-" : '') . $v[1]);
        }
        $tmp .= '</select>';
        $this->html = $tmp;
        if ($unset)
            unset($this->serializado, $this->attr, $this->nombre);
        return $this->html;
    }

    /**
     * Asigna un nombre al select
     * @param string $nombre
     * @return \html\select
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

}
