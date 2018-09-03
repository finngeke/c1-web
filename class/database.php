<?php
	
	/**
	 * CONECTOR PRINCIPAL DE BASE DE DATOS
	 * INTEGRACION LIB OCI8 PARA SP
	 * UTILIZA PDO: OCI Oracle 9 y 11
	 * @author RODRIGO RIOSECO
	 */
	class database {
		
		static $instancia = null;
		private $_conexion = null;
		private $_conexion_basico = null;
		private $_rs_basico = null;
		private $_error = null;
		static private $st = null;
		
		static public $ARCHIVO = null;
		
		
		/**
		 * Constructor de clase
		 * @return \database
		 * @throws Exception
		 */
		public function __construct() {
			
			if ($_SESSION["BD_control_conexion"] == "PROD") {
				$ARCHIVO = 'esab_PRO';
			} elseif ($_SESSION["BD_control_conexion"] == "QACLOUD") {
				$ARCHIVO = 'esab_QACLOUD';
			} else {
				$ARCHIVO = 'esab_QA';
			}
			
			if (file_exists($ARCHIVO . '.php') == false && file_exists('../' . $ARCHIVO . '.php') == false && file_exists('../../' . $ARCHIVO . '.php') == false && file_exists('../../../' . $ARCHIVO . '.php') == false)
				throw new excepciones\ErrorArchivo;
			elseif (file_exists($ARCHIVO . '.php'))
				include $ARCHIVO . '.php';
			elseif (file_exists('../' . $ARCHIVO . '.php'))
				include '../' . $ARCHIVO . '.php';
			elseif (file_exists('../../' . $ARCHIVO . '.php'))
				include '../../' . $ARCHIVO . '.php';
			elseif (file_exists('../../../' . $ARCHIVO . '.php'))
				include '../../../' . $ARCHIVO . '.php';
			$this->conecta(_SERVER_, _USR_, _PWD_, _DB_, _TNSNAMES_);
			return $this;
			
		}
		
		/**
		 * Realiza una conexion con PDO al servidor
		 * @param string $servidor URL o IP del servidor
		 * @param string $usuario Usuario de conexion
		 * @param string $contrasena Contrase?a de conexion
		 * @param string $db Base de datos de conexion
		 * @return \database
		 * @throws Exception
		 */
		public function conecta($servidor, $usuario, $contrasena, $db, $tnsnames) {
			
			
			if (!$this->_conexion = new PDO("oci:dbname=" . $tnsnames, $usuario, $contrasena))
				throw new excepciones\ErrorPDO;
			$this->_conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $this;
		}
		
		/**
		 * Obtiene una fila a partir de $sql, parseando parametros en el arreglo $param (llave => $valor) e instancia la clase class)
		 * @param string $sql Consulta a ejecutar
		 * @param array $params (opcional) Arreglo de parametros
		 * @param string $class (opcional) Clase a la cual se asignaran los valores
		 * @return array
		 */
		public function getFila($sql, $params = array(), $class = null, $constructor = array()) {
			
			return $this->consulta($sql, $params, $class, $constructor)->fetch();
		}
		
		/**
		 * Obtiene varias filas a partir de $sql, parseando parametros en el arreglo $param (llave => $valor) e instancia la clase class)
		 * @param string $sql Consulta a ejecutar
		 * @param array $params (opcional) Arreglo de parametros
		 * @param string $class (opcional) Clase a la cual se asignaran los valores
		 * @return array
		 */
		public function getFilas($sql, $params = array(), $class = null, $constructor = array()) {
			return $this->consulta($sql, $params, $class, $constructor)->fetchAll();
			
		}
		
		/**
		 * Obtiene datasets muy extensos para ser cargados en memoria
		 * @param string $sql Consulta a ejecutar
		 * @param array $params (opcional) Arreglo de parametros
		 * @param string $class (opcional) Clase a la cual se asignaran los valores
		 * @return array
		 */
		public function getMuchasFilas($sql, $params = array(), $class = null, $constructor = array()) {
			return self::$st = $this->consulta($sql, $params, $class, $constructor);
		}
		
		/**
		 * Obtiene la siguiente fila de una instancia de getMuchasFilas
		 * @return array
		 */
		public function getNextFila() {
			return is_null(self::$st) ? false : self::$st->fetch();
		}
		
		/**
		 * Obtiene la cantidad de filas obtenidas por la consulta derivada de getMuchasFilas
		 * @return int
		 */
		public function getConteoFilas() {
			return is_null(self::$st) ? 0 : self::$st->rowCount();
		}
		
		/**
		 * Ejecuta una consulta a partir de $sql, parseando parametros en el arreglo $param (llave => $valor) e instancia la clase class)
		 * @param string $sql Consulta a ejecutar
		 * @param array $params (opcional) Arreglo de parametros
		 * @param string $class (opcional) Clase a la cual se asignaran los valores
		 * @return bool Siempre retorna TRUE
		 */
		public function getConsulta($sql, $params = array(), $class = null, $constructor = array()) {
			$this->consulta($sql, $params, $class, $constructor);
			return TRUE;
		}
		
		public function getConsultaSP($sql, $retornos) {
			return $this->consultaSP($sql, $retornos);
		}
		
		private function consultaSP($sql, $retornos) {
			
			$conn = ocilogon(_USR_, _PWD_, _TNSNAMES_);
			if (!$conn) {
				$e = oci_error();
				trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
				die();
			}
			
			if ($retornos == 1) { // MOD RETORNO CURSOR
				$curs = oci_new_cursor($conn);
				$stmt = oci_parse($conn, $sql);
				oci_bind_by_name($stmt, "data", $curs, -1, OCI_B_CURSOR);
				oci_execute($stmt);
				oci_execute($curs);
				
				$key = 0;
				while ($data = oci_fetch_row($curs)) {
					$key = 1;
					$datos[] = $data;
				}
				if ($key == 0) {
					//$datos[] = 0;
					$datos = [];
				}
				
				oci_free_statement($stmt);
				oci_free_statement($curs);
				
			} else { // MODO RETORNO INT - VARCHAR
				$stmt = oci_parse($conn, $sql);
				
				$cod_error = 0;
				$mensaje = '';
				oci_bind_by_name($stmt, "error", $cod_error, 11, SQLT_INT);
				oci_bind_by_name($stmt, "data", $mensaje, -1, SQLT_CHR);
				
				try {
					oci_execute($stmt);
					oci_free_statement($stmt);
					$datos = $cod_error . '#' . $mensaje;
				} catch (Exception $e) {
					$datos = 1 . '#' . $e->getMessage();
				}
			}
			
			oci_close($conn);
			
			return $datos;
			
		}
		
		/**
		 * Ejecuta una consulta a partir de $sql, parseando parametros en el arreglo $param (llave => $valor) e instancia la clase class)
		 * @param string $sql Consulta a ejecutar
		 * @param array $params (opcional) Arreglo de parametros
		 * @param string $class (opcional) Clase a la cual se asignaran los valores
		 * @return \PDO_Statement
		 */
		public function getIterador($sql, $params = array(), $class = null, $constructor = array()) {
			return $this->consulta($sql, $params, $class, $constructor);
		}
		
		/**
		 * Ejecuta una consulta a partir de $sql, parseando parametros en el arreglo $param (llave => $valor) e instancia la clase class)
		 * @param string $sql Consulta a ejecutar
		 * @param array $params (opcional) Arreglo de parametros
		 * @param string $class (opcional) Clase a la cual se asignaran los valores
		 * @return array
		 */
		private function consulta($sql, $params = array(), $class = null, $constructor = array()) {
			
			try {
				if (empty($params) == true) {
					try {
						return $this->_conexion->query($sql);
					} catch (\Exception $e) {
						throw $e;
						//throw new excepciones\generales\database\ErrorPDO;
					}
				}
				
				$pdoSt = $this->_conexion->prepare($sql, array(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY, PDO::ATTR_PREFETCH, PDO::PARAM_STR, PDO::PARAM_INPUT_OUTPUT));
				
				foreach ($params as $idx => $val) {
					$pdoSt->bindParam(":" . $idx, $params[$idx]);
				}
				if ($pdoSt->execute() == false || is_null($pdoSt) == true || !$pdoSt instanceof PDOStatement) {
					throw new excepciones\generales\database\ErrorEjecucion;
				}
				if ($pdoSt->errorCode() !== PDO::ERR_NONE) {
					$this->_error = $pdoSt->fetch();
					throw new excepciones\generales\database\ErrorCode('', $pdoSt->errorInfo()[1]);
				}
				if (isset($class) == true) {
					$pdoSt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class, $constructor);
				} else {
					$pdoSt->setFetchMode(PDO::FETCH_ASSOC);
				}
				return $pdoSt;
			} catch (\PDOException $e) {
				throw $e;
				//throw new excepciones\generales\database\ErrorPreparar;
			}
		}
		
		/**
		 * Se conecta en forma basica al servidor (usando las funciones mssql)
		 * @return resource
		 * @throws Exception
		 */
		private function conectaBasico() {
			
			// Llega el tipo de conexiòn que selecciona el usuario
			if ($_SESSION["BD_control_conexion"] == "PROD") {
				$ARCHIVO_BASICO = 'esab_PRO';
			} elseif ($_SESSION["BD_control_conexion"] == "QAPRO") {
				$ARCHIVO_BASICO = 'esab_QAPRO';
			} else {
				$ARCHIVO_BASICO = 'esab_QA';
			}
			
			if (file_exists($ARCHIVO_BASICO . '.php') == FALSE && file_exists('../' . $ARCHIVO_BASICO . '.php') == FALSE && file_exists('../../' . $ARCHIVO_BASICO . '.php') == FALSE)
				throw new Exception('$ARCHIVO_BASICO de conexi&oacute;n no existe: ' . $ARCHIVO_BASICO . '.php');
			elseif (file_exists($ARCHIVO_BASICO . '.php'))
				include $ARCHIVO_BASICO . '.php';
			elseif (file_exists('../' . $ARCHIVO_BASICO . '.php'))
				include '../' . $ARCHIVO_BASICO . '.php';
			elseif (file_exists('../../' . $ARCHIVO_BASICO . '.php'))
				include '../../' . $ARCHIVO_BASICO . '.php';
			if (!$this->conexion_basico = @mssql_connect(_SERVER_, _USR_, _PWD_))
				die("No se ha logrado una conexi&oacute;n al servidor de base de datos");
			if (!mssql_select_db(_DB_))
				die("No se ha podido encontrar la base de datos seleccionada");
			return $this->_conexion_basico;
		}
		
		/**
		 * Ejecuta una consulta usando las funciones por defecto de mssql
		 * @param string $sql Consulta
		 * @return resource Resultado
		 */
		public function doConsultaBasica($sql) {
			$this->conectaBasico();
			return $this->_rs_basico = mssql_query($sql);
		}
		
		/**
		 * Obtiene una fila desde la consulta basica
		 * @return array
		 */
		public function getFilaBasica() {
			return mssql_fetch_assoc($this->_rs_basico);
		}
		
		/**
		 * Obtiene las columnas de una tabla con el fin de construir un objeto vacio
		 * @param string $database nombre de la base de datos
		 * @param string $tabla nombre de la tabla
		 * @return array
		 */
		public function getColumnasTabla($database, $tabla) {
			$params = array('t' => $tabla);
			$tmp = array();
			$res = $this->getFilas(sprintf('SELECT column_name FROM %s.INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME=:t', $database), $params);
			array_walk($res, function ($f) use (&$tmp) {
				$tmp[$f['column_name']] = null;
			});
			return $tmp;
		}
		
		/**
		 * Obtiene una instancia del servidor, siguiendo el patron singleton
		 * @return database
		 */
		static function getInstancia() {
			if (!self::$instancia instanceof self) {
				self::$instancia = new self;
			}
			return self::$instancia;
		}
		
		/**
		 * Obtiene el dato de conexion
		 * @return PDO
		 */
		public function getConexion() {
			return $this->_conexion;
		}
		
		/**
		 * Inicia una transaccion de base de datos
		 * @return \database
		 */
		public function setTransaction() {
			$this->getConexion()->beginTransaction();
			return $this;
		}
		
		/**
		 * Almacena los cambios de uns transaccion de base de datos
		 * @return \database
		 */
		public function doCommit() {
			if ($this->isTransaction() === true) {
				$this->getConexion()->commit();
			} else {
				throw new \excepciones\generales\database\ErrorAlHacerCommit;
			}
			return $this;
		}
		
		/**
		 * Descarta los cambios de una transaccion de base de datos
		 * @return \database
		 */
		public function doRollback() {
			if ($this->isTransaction() === true) {
				$this->getConexion()->rollback();
			} else {
				throw new \excepciones\generales\database\ErrorAlHacerRollback;
			}
			return $this;
		}
		
		/**
		 * Retorna si está en transacción o no
		 * @return bool true si está en transaccion
		 */
		public function isTransaction() {
			return $this->getConexion()->inTransaction();
		}
		
		/**
		 * Obtiene el error generado por errorInfo
		 * @return array|null
		 */
		public function getError() {
			return $this->_error;
		}
		
	}
