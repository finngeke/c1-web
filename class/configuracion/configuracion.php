<?php
	/**
	 * Created by PhpStorm.
	 * User: jcandiah
	 * Date: 21-09-2018
	 * Time: 10:20
	 */
	
	namespace configuracion;
	
	class configuracion {
		public static function obtenerConfiguracion() {
			$sql = "SELECT CONFIG_NAME, CONFIG_VALUE, CONFIG_TYPE, CONFIG_COMMENT FROM PLC_CONFIGURACION";
			return \database::getInstancia()->getFilas($sql);
		}
		
		public static function obtenerConfiguracionItem($nombre) {
			$sql = "SELECT CONFIG_NAME, CONFIG_VALUE, CONFIG_TYPE, CONFIG_COMMENT FROM PLC_CONFIGURACION WHERE (CONFIG_NAME = '$nombre')";
			return \database::getInstancia()->getFila($sql);
		}
	}