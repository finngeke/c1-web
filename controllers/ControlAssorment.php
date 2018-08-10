<?php
	
	/**
	 * CONTROLADOR de PROVEEDOR
	 * Descripción:
	 * Fecha: 2018-05-16
	 * @author JOSÉ MIGUEL CANDIA
	 */
	class ControlAssorment extends Control {

		public function home($f3) {
			//ControlProveedor::cargaMain($f3);
			$f3->set('nombre_form', 'Welcome');
			$f3->set('contenido', 'CargaAssorment/home.html');
			echo Template::instance()->render('layout_Assorment.php');
		}
		

	}

?>
