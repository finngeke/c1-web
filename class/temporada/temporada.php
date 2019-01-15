<?php
	
	/**
	 * CLASS Temporada
	 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
	 * Fecha: 2018-02-07
	 * @author RODRIGO RIOSECO
	 * @edita Roberto Pérez
	 */
	
	namespace temporada;
	
	class temporada extends \parametros {
		
		protected static $_table = 'PLC_TEMPORADA';
		protected static $_pk = 'COD_TEMPORADA';
		protected static $_parametro = 'NOM_TEMPORADA_CORTO';
		
		/**
		 * Constructor de clase
		 */
		public function __construct() {
			call_user_func_array(array('parent', '__construct'), func_get_args());
		}
		
		public static function getListaTemporadas() {
			// Este corresponde al listado de temporada de compra, no al popup de bienvenidos
			$data = \database::getInstancia()->getFilas("select COD_TEMPORADA,NOM_TEMPORADA_CORTO,"
				. " NOM_TEMPORADA_BMT,FEC_CRE,NOM_TEMPORADA,COD_EST_TEMP, USR_CRE FROM PLC_TEMPORADA ORDER BY COD_TEMPORADA DESC");
			return $data;
		}
		
		public static function getListaTemporadasBuscar($temporada) {
			// Este corresponde al listado de temporada de compra, no al popup de bienvenidos
			$temporada = strtoupper($temporada);
			$sql = "SELECT COD_TEMPORADA, NOM_TEMPORADA_CORTO FROM PLC_TEMPORADA WHERE (NOM_TEMPORADA_CORTO LIKE '%$temporada%') ORDER BY NOM_TEMPORADA_CORTO";
			$data = \database::getInstancia()->getFilas($sql);
			return $data;
		}
		
		public static function getTemporadaCompra($COD_TEMPORADA) {
			
			$data = (object)\database::getInstancia()->getFila("select COD_TEMPORADA,NOM_TEMPORADA_CORTO,"
				. " NOM_TEMPORADA_BMT,FEC_CRE,NOM_TEMPORADA,COD_EST_TEMP, USR_CRE FROM PLC_TEMPORADA"
				. " WHERE COD_TEMPORADA=" . $COD_TEMPORADA);
			return $data;
		}
		
		/**
		 * Valida si existe Temporada
		 * @return array
		 */
		public static function existeTemporada($TEMPORADA) {
			
			$sql = "SELECT 1 FROM PLC_TEMPORADA WHERE COD_TEMPORADA=" . $TEMPORADA;
			return \database::getInstancia()->getFila($sql);
		}
		
		/**
		 * Cambia el estado d ela temporada de compra
		 * @return array
		 */
		public static function eliminaTemporada($LOGIN, $TEMPORADA, $ESTADO_HIDDEN) {
			$sql = "UPDATE PLC_TEMPORADA
                SET COD_EST_TEMP=$ESTADO_HIDDEN,
                USR_MOD ='" . $LOGIN . "'"
				. ", FEC_MOD=current_date  WHERE COD_TEMPORADA=" . $TEMPORADA;
			
			// Almacenar TXT
			$stamp = date("Y-m-d_H-i-s");
			$rand = rand(1, 999);
			$content = $sql;
			$fp = fopen("../archivos/log_querys/TEMPORADA_COMPRA-ESTADO--" . $LOGIN . "-" . $stamp . " R" . $rand . ".txt", "wb");
			fwrite($fp, $content);
			fclose($fp);
			
			return \database::getInstancia()->getConsulta($sql);
			
		}
		
		/**
		 * Elimina un temporada de compra, siempre y cuando su estado sea inactivo
		 * @return array
		 */
		public static function quitarTemporada($LOGIN, $TEMPORADA) {
			
			// Cuando la temporada este desabilitada, esa es la condición
			$sql = "DELETE FROM PLC_TEMPORADA
                WHERE COD_TEMPORADA = $TEMPORADA
                AND COD_EST_TEMP = 1";
			
			// Almacenar TXT
			$stamp = date("Y-m-d_H-i-s");
			$rand = rand(1, 999);
			$content = $sql;
			$fp = fopen("../archivos/log_querys/TEMPORADA_COMPRA-QUITAR--" . $LOGIN . "-" . $stamp . " R" . $rand . ".txt", "wb");
			fwrite($fp, $content);
			fclose($fp);
			
			
			return \database::getInstancia()->getConsulta($sql);
			
		}
		
		
		public static function listarTemporada() {
			
			// Listar las tempradas par desplegarlas en elinici de bienvenida de las temporadas en el select
			$sql = "SELECT COD_TEMPORADA,NOM_TEMPORADA_CORTO
                FROM PLC_TEMPORADA
                WHERE cod_est_temp = 0
                ORDER BY COD_TEMPORADA DESC";
			
			$data = \database::getInstancia()->getFilas($sql);
			return $data;
		}
		
		
		/**
		 * Crear Temporada
		 * @return array
		 */
		public static function crearTemporada($LOGIN, $NOM_TEMPORADA_CORTO, $ANNO, $NOM_TEMPORADA) {
			
			$sql = "insert into PLC_TEMPORADA values ( (select (max(A.COD_TEMPORADA) + 1) AS ID from PLC_TEMPORADA A)"
				//. ",UPPER('" . $NOM_TEMPORADA_CORTO . "')"
				. ",'" . $NOM_TEMPORADA_CORTO . $ANNO . "'"
				. ",UPPER('" . $NOM_TEMPORADA . "')"
				. ",0"
				. ",'" . $LOGIN . "'"
				. ",current_date"
				. ",NULL"
				. ",NULL"
				. ",NULL"
				. ",0"
				. ",1,1)";
			return \database::getInstancia()->getConsulta($sql);
		}
		
		/**
		 * Modificar Temporada
		 * @return array
		 */
		public static function modificarTemporada($LOGIN, $COD_TEMPORADA, $NOM_TEMPORADA_CORTO, $ANNO, $NOM_TEMPORADA) {
			
			$sql = "update PLC_TEMPORADA set "
				//. "   NOM_TEMPORADA_CORTO=UPPER('" . str_replace("'", '"', $NOM_TEMPORADA_CORTO) . "')"
				. "   NOM_TEMPORADA_CORTO='" . $NOM_TEMPORADA_CORTO . $ANNO . "'"
				. " , NOM_TEMPORADA='" . str_replace("'", '"', $NOM_TEMPORADA) . "'"
				. " , COD_EST_TEMP=0"
				. " , USR_MOD='" . $LOGIN . "'"
				. " , FEC_MOD=current_date"
				. " where COD_TEMPORADA=" . $COD_TEMPORADA;
			
			//echo $sql;
			//die();
			return \database::getInstancia()->getConsulta($sql);
		}
		
		public static function obtieneDepartamentoSimulador($usuario, $temporada) {
			
			$sql = "begin PLC_PKG_SEGURIDAD.PRC_GET_DEPTOS_TIPUSR(99,'" . $usuario . "'," . $temporada . ", :data); end;";
			
			$data = \database::getInstancia()->getConsultaSP($sql, 1);
			
			return $data;
			
		}

/*MANTENEDOR FACTOR_IMPORTACION*/
		public static function List_factor_Importacion($cod_temporada){
            $array1 = [];
            // Listar las tempradas par desplegarlas en elinici de bienvenida de las temporadas en el select
            $sql = "SELECT ID_FACTOR_IMPORT ID_FACTOR
                           ,COD_VIA 
                           ,COD_PUERTO_EMB
                           ,COD_PUERTO_DESTINO
                           ,COD_INCOTERM
                           ,COD_DIV
                           ,DEP_DEPTO
                           ,COD_MARCA
                           ,FACTOR
                    FROM PIA_FACTOR_IMPORT
                    WHERE COD_TEMPORADA = $cod_temporada
                    ORDER BY 2,3,4,5,7,8,9";

            $data = \database::getInstancia()->getFilas($sql);

            // Transformo a array asociativo
            foreach ($data as $va1) {
                array_push($array1
                    , array("ID_FACTOR" => $va1[0]
                        , "VIA" => $va1[1]
                        , "PUERTO_EMB" => $va1[2]
                        , "PUERTO_DESTINO" => $va1[3]
                        , "INCOTERM" => $va1[4]
                        , "DIVISION" => $va1[5]
                        , "DEPARTAMENTO" => $va1[6]
                        , "MARCA" => $va1[7]
                        , "FACTOR" => $va1[8]
                    )
                );
            }

            return $array1;

        }

// Fin de la clase
	}
