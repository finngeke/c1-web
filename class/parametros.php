<?php

class parametros extends datamapper {

    protected static $_table = null;
    protected static $_pk = null;
    protected static $_parametro = null;

    /**
     * Obtiene un parámetro de la base de datos
     * @param string $valor Valor de la base de datos a obtener
     * @param string $campo Campo específico de la base de datos a obtener
     * @return mixed|null 
     */
    public static function getParametro($valor, $campo = null) {
        
        $class = get_called_class();
        $campo = is_null($campo) ? static::$_parametro : $campo;
       
        $a = $class::query()->select($campo)->where(static::$_pk, '=', $valor)->prepare();
        return empty($a) ? null : $a[0][$campo];
    }

    /**
     * Obtiene una lista de parámetros a partir de la tabla de base de datos
     * @param string $order Campo de la tabla que permite el ordenamiento
     * @param string $sort  Orden del retorno de datos
     * @return array
     */
    public static function getParametros($order = null, $sort = 'ASC') {
        $class = get_called_class();
        return $class::query()
                        ->select(static::$_parametro)
                        ->select(static::$_pk)
                        ->order(is_null($order) ? static::$_pk : $order, $sort)
                        ->prepare();
    }

    /**
     * Obtiene un arreglo ordenado como [clave => valor] desde la base de datos
     * @param string $order Campo de la tabla que permite el ordenamiento
     * @param string $sort  Orden del retorno de datos
     * @return array
     */
    public static function getArreglo($order = null, $sort = 'ASC') {
        $tmp = array();
        foreach (self::getParametros($order, $sort) as $i) {
            $tmp[$i[static::$_pk]] = $i[static::$_parametro];
        }
        return $tmp;
    }

    /**
     * Obtiene una consulta sobre sí misma que retorna los parámetros cabeceras del parámetro
     * @return \datamapper
     */
    public static function getOwnQuery() {
        $class = get_called_class();
        return $class::query()
                        ->select(static::$_parametro)
                        ->select(static::$_pk);
    }

    /**
     * Obtiene un objeto select construido
     * @param string $order Campo de la tabla que permite el ordenamiento
     * @param string $sort  Orden del retorno de datos
     * @return \html\select
     */
    public static function getSelect($order = null, $sort = 'ASC') {
        return new \html\select(self::getParametros($order, $sort), static::$_pk, static::$_parametro);
    }

}
