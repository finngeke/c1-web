<?php

class datamapper {

    /**
     * Define la tabla de búsqueda
     * @var string 
     */
    protected static $_table = null;

    /**
     * Define los parámetros de búsqueda del WHERE
     * @var array 
     */
    protected static $_where = array();

    /**
     * Define la secuencia de orden
     * @var array
     */
    protected static $_order = array();

    /**
     * Define las llaves primarias del objeto
     * @var array
     */
    protected static $_pk = array('*');

    /**
     * Define los elementos a obtener del select
     * @var array 
     */
    protected static $_select = array();

    /**
     * Define lso parametros a almacenar la para consulta con el where
     * @var array 
     */
    protected static $_param = array();

    /**
     * Relaciones entre objetos
     * @var array 
     */
    protected static $_relaciones = array();

    /**
     * Almacena una instancia de si mismo
     * @var datamapper 
     */
    protected static $_instance = null;
    
    /**
     * Almacen de campos para actualizar
     * @var array
     */
    protected static $_actualizar = array();

    /**
     * Almacén de datos del objeto
     * @var array
     */
    public $_own = array();

    const NULL = 0;
    const FECHA = 1;
    const LIKE = 2;
    const BETWEEN = 3;
    const IN = 4;
    const NOTIN = 5;
    const NOTNULL = 6;

    public $valid = false;

    /**
     * Constructor de clase con parametros variables dependiendo de la clase hija que la invoque.
     */
    public function __construct() {
        if (func_num_args() == 0) {
            return;
        }
        $array = array();
        if (is_array(@func_get_arg(0)) == true) {
            $array = func_get_arg(0);
        } else {
            $array = func_get_args();
        }
        foreach (static::$_pk as $i => $v) {
            $this->{(is_numeric($i) ? $v : $i)} = isset($array[$v]) == false ? (isset($array[$i]) == false ? null : $array[$i]) : $array[$v];
        }
        if (count(array_filter($array))) {
            $this->load();
        }
    }

    /**
     * Ejecuta una consulta ya filtrada por where
     * @param bool $iterador Determina si retornamos el iterador o el arreglo
     * @return array
     */
    public function prepare($iterador = false) {
        
        $where = empty(static::$_where) ? '' : 'WHERE ' . implode(" AND ", static::$_where);
        $order = empty(static::$_order) ? '' : 'ORDER BY ' . implode(", ", static::$_order);
        $select = empty(static::$_select) ? '*' : implode(", ", static::$_select);
        $params = static::$_param;
        static::$_where = static::$_order = static::$_select = static::$_param = array();
        $q = sprintf("SELECT %s FROM %s %s %s", $select, static::$_table, $where, $order);       
        try {
            return $iterador ?
            database::getInstancia()->getIterador($q, $params) : database::getInstancia()->getFilas($q, $params);
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Obtiene todas las filas de la tabla
     * @return class
     */
    public static function all() {
        static::$_select = static::$_pk;
        $tmp = array();
        $class = get_called_class();
        foreach (static::prepare() as $r) {
            $tmp[] = new $class($r);
        }
        return $tmp;
    }

    /**
     * Añade una opción de filtrado
     * @param string $data campo de la base de datos
     * @param string $op comparador (=, <>, <, >)
     * @param mixed $value valor de búsqueda
     * @return \datamapper
     */
    public function where($data, $op, $value) {
        static::$_where[] = sprintf('%s %s isnull(:%s, %s)', $data, $op, $data, $data);
        static::$_param[$data] = $value;
        return $this;
    }

    /**
     * Función de resumen de la consulta de igualdad
     * @param string $data campo de la base de datos
     * @param mixed $value valor de búsqueda
     * @return \datamapper
     */
    public function isEqual($data, $value) {
        return self::where($data, "=", $value);
    }

    /**
     * Función de resumen de la consulta de desigualdad
     * @param string $data campo de la base de datos
     * @param mixed $value valor de búsqueda
     * @return \datamapper
     */
    public function isNotEqual($data, $value) {
        return self::where($data, "<>", $value);
    }

    /**
     * Función de filtrado para el campo que es nulo
     * @param string $data campo de la base de datos
     * @return \datamapper
     */
    public function isNull($data) {
        static::$_where[] = sprintf('%s is null', $data);
        return $this;
    }

    /**
     * Función de filtrado para el campo que es no-nulo
     * @param string $data campo de la base de datos
     * @return \datamapper
     */
    public function isNotnull($data) {
        static::$_where[] = sprintf('%s is not null', $data);
        return $this;
    }

    /**
     * Función de filtrado donde el campo puede ser cualquiera de los elementos listados en el arreglo
     * @param string $data campo de la base de datos
     * @param array $valor valores de búsqueda
     * @return \datamapper
     */
    public function in($data, array $valor = array()) {
        $tmp = array();
        foreach ($valor as $i => $v) {
            static::$_param[$data . $i] = $v;
            $tmp[] = ":{$data}{$i}";
        }
        static::$_where[] = sprintf("%s in (%s)", $data, implode(", ", $tmp));
        return $this;
    }

    /**
     * Función de filtrado donde el campo no debe ser cualquiera de los elementos listados en el arreglo
     * @param string $data campo de la base de datos
     * @param array $valor valores de búsqueda
     * @return \datamapper
     */
    public function notIn($data, array $valor = array()) {
        $tmp = array();
        foreach ($valor as $i => $v) {
            static::$_param[$data . $i] = $v;
            $tmp[] = ":{$data}{$i}";
        }
        static::$_where[] = sprintf("%s not in (%s)", $data, implode(", ", $tmp));
        return $this;
    }

    public function isEqualDate($data, $value, $format = 112) {
        if (is_null($value) == false) {
            static::$_where[] = sprintf('convert (varchar, %s, %s) = %s', $data, $format, $value);
        }
        return $this;
    }

    /**
     * Obtiene una instancia sin inializar del elemento
     * @return \datamapper
     */
    public static function query() {
        if (!static::$_instance instanceof static) {
            static::$_instance = @new static;
        }
        return static::$_instance;
    }

    /**
     * Añade un elemento a la selección de valores
     * @param string $valor campo de la base de datos
     * @return \datamapper
     */
    public function select($valor) {
        static::$_select[] = $valor;
        return $this;
    }

    /**
     * Incluye dentro del select un retorno de fecha en un formato especial
     * @param string $valor   campo de la tabla que es datetime
     * @param int    $formato valor númerico que determina el formato de salida
     * @param string $alias   nombre del campo a ser renombrado en caso de otra salida
     * @return \datamapper
     */
    public function selectDate($valor, $formato = 103, $alias = null) {
        $alias = is_null($alias) ? $valor : $alias;
        return $this->select("convert(varchar, {$valor}, {$formato}) AS {$alias}");
    }

    /**
     * Obtiene una condición con el tipo de búsqueda like
     * @param string $data  Nombre del campo que se buscará en la base de datos
     * @param string $valor Valor buscado en el like
     * @return \datamapper
     */
    public function like($data, $valor) {
        $valor = "%" . $valor . "%";
        return self::where($data, "like", $valor);
    }

    /**
     * Obtiene una condición de búsqueda entre dos valores
     * @param string $data   Nombre del campo de búsqueda en la tabla
     * @param mixed  $inicio Valor de búsqueda mínimo
     * @param mixed  $fin    Valor de búsqueda máxima
     * @return \datamapper
     */
    public function between($data, $inicio, $fin) {
        self::$_where[] = sprintf('%s BETWEEN $s AND $s', $data, $inicio, $fin);
        return $this;
    }

    /**
     * Determina un nuevo criterio de orden
     * @param string $campo campo de la base de datos
     * @param string $orden Ordenamiento [ASC|DESC]
     * @return \datamapper
     */
    public function order($campo, $orden = 'ASC') {
        static::$_order[] = "{$campo} {$orden}";
        return $this;
    }

    /**
     * Carga un objeto de la base de datos en memoria
     */
    public function load() {
        foreach (static::$_pk as $pk) {
            $this->isEqual($pk, $this->_own[$pk]);
        }
        $res = static::prepare();
        if (empty($res)) {
            $this->valid = false;
            return;
        }
        $this->valid = true;
        foreach (array_pop($res) as $i => $v) {
            if (is_numeric($i)) {
                continue;
            }
            $this->_own[$i] = $v;
        }
    }

    /**
     * Busca en la tabla según filtros que indiquen
     * @param array $filtros Arreglo de filtros que son serializados como llave => valor
     * @param bool  $obj     Determina si se genera el objeto o un arreglo
     * @param array $campos  Indica qué campos retorna el arreglo
     * @param array $order   Indica el ordenamiento de los campos
     * @return mixed
     */
    public static function getBuscar(array $filtros = [], $obj = true, array $campos = [], array $order = []) {
        $qry = self::query()->select(implode(",", count($campos) ? $campos : array_merge(static::$_pk, $campos)));
        $retorno = array();
        foreach (array_keys($filtros) as $campo) {
            if (is_array($filtros[$campo]) === false) {
                $qry->isEqual($campo, $filtros[$campo]);
            } else {
                $campos = $filtros[$campo];
                switch ($campos[0]) {
                    case static::NULL:
                    $qry->isNull($campo);
                        break;
                    case static::FECHA:
                        $qry->isEqualDate($campos[1], $campos[2], isset($campos[3]) ? $campos[3] : 103);
                        break;
                    case static::LIKE:
                        $qry->like($campo, $campos[1]);
                        break;
                    case static::BETWEEN:
                        $qry->between($campo, $campos[1], $campos[2]);
                        break;
                    case static::IN:
                        $qry->in($campo, $campos[1]);
                        break;
                    case static::NOTIN:
                        $qry->notIn($campo, $campos[1]);
                        break;
                    case static::NOTNULL:
                        $qry->isNotNull($campo);
                        break;
                }
            }
        }
        foreach($order as $campo => $ordenamiento){
            is_numeric($campo) ? $qry->order($ordenamiento) : $qry->order($campo, $ordenamiento);
        }
        if ($obj == false) {
            return $qry->prepare();
        }
        foreach ($qry->prepare() as $p) {
            $retorno[] = @new static($p);
        }
        return $retorno;
    }
    
    /**
     * Almacena un posible cambio
     * @param string $elemento
     * @param mixed $valor
     * @return \datamapper
     * @throws \excepciones\generales\database\ModificandoUnaPK
     */
    public function setCambio($elemento, $valor) {
        if (in_array($elemento, static::$_pk)) {
            throw new \excepciones\generales\database\ModificandoUnaPK;
        }
        static::$_actualizar[$elemento] = $valor;
        return $this;
    }

    /**
     * Almacena varios cambios
     * @param array $array
     * @return \datamapper
     */
    public function setCambios($array = []) {
        foreach ($array as $elemento => $valor) {
            $this->setCambio($elemento, $valor);
        }
        return $this;
    }

    /**
     * Realiza una transformacion en la cadena para la actualizacion
     * @return string
     */
    private function doTransformacionUpdate() {
        $tmp = [];
        foreach (array_keys(static::$_actualizar) as $elemento) {
            $tmp[] = sprintf("%s = :%s", $elemento, $elemento);
        }
        return implode(", ", $tmp);
    }

    /**
     * Almacenamos en el where los datos que definimos como llave primaria
     */
    private function doPK() {
        foreach (static::$_pk as $pk) {
            $this->isEqual($pk, $this->_own[$pk]);
        }
    }

    /**
     * Ejecutamos los cambios
     * @param array $array
     */
    public function doCambios($array = []) {
        if (empty($array) === false) {
            $this->setCambios($array);
        }
        $this->doPK();
        $where = empty(static::$_where) ? '' : 'WHERE ' . implode(" AND ", static::$_where);
        $qUpdate = sprintf("UPDATE %s SET %s %s", static::$_table, $this->doTransformacionUpdate(), $where);
        database::getInstancia()->getConsulta($qUpdate, array_merge(static::$_actualizar, static::$_param));
        static::$_where = static::$_actualizar = static::$_param = array();
    }

    /**
     * Obtiene los resultados de la consulta ya instanciados
     * @param type $obj
     * @return \obj
     */
    public function create($obj = null) {
        $obj = is_null($obj) ? get_called_class() : $obj;
        $tmp = array();
        foreach ($this->prepare() as $el) {
            $tmp[] = new $obj($el);
        }
        return $tmp;
    }

    /**
     * Obtiene un elemtno dependiende, según la relación
     * @param string $rel
     * @return \datamapper
     */
    public function one($rel) {
        return array_pop($this->get($rel));
    }

    /**
     * Obtiene todos los objetos dependientes según la $rel que se indique en el objeto
     * @param string $rel
     * @return null
     */
    public function get($rel) {
        if (!isset(static::$_relaciones[$rel])) {
            return null;
        }
        $el = static::$_relaciones[$rel];
        $class = $el['class'];
        $rel = $class::getPK();
        $class = $class::query();
        foreach ($el['data'] as $origen => $actual) {
            $class->isEqual($origen, $this->{$actual});
        }
        return $class->create();
    }

    /**
     * Obtiene las llaves primarias de un objeto
     * @return array
     */
    public function getPK() {
        return self::$_pk;
    }

    /**
     * Función mágica
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        $this->_own[$name] = $value;
    }

    /**
     * Función mágica
     * @param string $name
     * @return mixed|null
     */
    public function __get($name) {
        if (isset($this->_own[$name])) {
            return $this->_own[$name];
        }
        if ($this->valid === true) {
            $this->load();
        }
        return isset($this->_own[$name]) ? $this->_own[$name] : null;
    }

    /**
     * Obtiene el nombre de la clase
     * @return string
     */
    public function __toString() {
        return get_called_class();
    }

}
