<?php

namespace html;

class element {

    /**
     * Crea un objeto sin necesidad de instanciarlo!
     * @param string $var  Nombre de la etiqueta soportada [a, input, textarea]
     * @param string $tipo Si el tipo es input, permite definir el tipo de input
     * @return \html\class\element
     */
    public static function create($var, $tipo = null) {
        $class = "html\\html\\$var";
        if (class_exists($class) == false)
            throw new Exception('No se existe la clase ' . $var);
        return new $class($tipo);
    }

    /**
     * Aplica atributos al listado de elementos
     * @param array $els       Elementos a aplicar el atributo
     * @param array $atributos Atributos a aplicar
     */
    public static function apply($els = [], $atributos = []) {
        foreach ($els as $elm) {
            $elm->setAtributos($atributos);
        }
    }

    /**
     * Retorna un arreglo de elementos instanciados
     * @param array $els        Listado de nombres de variables a asignar
     * @param string $var       Etiqueta a aplicar
     * @param string $tipo      Tipo de elemento a crear
     * @params array $atributos Atributos a aplicar en la creación
     * @return array
     */
    public static function expand($els = array(), $var = 'input', $tipo = null, $atributos = []) {
        $tmp = array();
        foreach ($els as $el) {
            $tmp[$el] = self::create($var, $tipo)->setAtributos($atributos)->setNombre($el);
        }
        return $tmp;
    }

}
