<?php
	/**
	 * Created by PhpStorm.
	 * User: jcandiah
	 * Date: 04-08-2018
	 * Time: 15:05
	 */
	
	class ControlComex extends Control {
		
		public static function cargaMensajes($f3) {
			switch ($f3) {
				case $f3->exists('SESSION.error'):
					$mensaje = $f3->get('SESSION.error');
					$f3->set('mensaje', Control::SetMensajePredeterminado(array(
						'head' => "ERROR",
						'msg' => $mensaje,
						'icon' => "danger",
						'color' => "red"
					)));
					$f3->clear('SESSION.error');
					break;
				case $f3->exists('SESSION.success'):
					$mensaje = $f3->get('SESSION.success');
					$f3->set('mensaje', Control::SetMensajePredeterminado(array(
						'head' => "EXITO",
						'msg' => $mensaje,
						'icon' => "success",
						'color' => "green"
					)));
					$f3->clear('SESSION.success');
					break;
				case $f3->exists('SESSION.warning'):
					$mensaje = $f3->get('SESSION.warning');
					$f3->set('mensaje', Control::SetMensajePredeterminado(array(
						'head' => "ADVERTENCIA",
						'msg' => $mensaje,
						'icon' => "warning",
						'color' => "yelloow"
					)));
					$f3->clear('SESSION.warning');
					break;
				default:
					$f3->clear('SESSION.error');
					$f3->clear('SESSION.success');
			}
		}
		
		public function inicio($f3) {
			ControlFormularioMain::cargaMain($f3);
			ControlComex::cargaMensajes($f3);
			$f3->set('nombre_form', 'Paso 1');
			$f3->set('data', \comex\comex::listarFacturasAprobadas());
			$f3->set('contenido', 'comex/inicio.html');
			echo Template::instance()->render('layout_inicio.php');
		}
		
		public function asociar_contenedor($f3) {
			ControlFormularioMain::cargaMain($f3);
			ControlComex::cargaMensajes($f3);
			$cod_proveedor = $f3->get('GET.cod_proveedor');
			$nro_factura = $f3->get('GET.nro_factura');
			$f3->set('cod_proveedor', $cod_proveedor);
			$f3->set('nro_factura', $nro_factura);
			$f3->set('data', \comex\comex::listarLPNS($cod_proveedor, $nro_factura));
			$f3->set('nombre_form', 'Paso 2');
			$f3->set('contenido', 'comex/asociar_contenedor.html');
			echo Template::instance()->render('layout_inicio.php');
		}
		
		public function guardar_contenedor($f3) {
			try {
				$cod_proveedor = $f3->get('POST.cod_proveedor');
				$nro_factura = $f3->get('POST.nro_factura');
				$nroContenedor = $f3->get('POST.nroContenedor');
				$tipoContenedor = $f3->get('POST.tipoContenedor');
				$bl = $f3->get('POST.bl');
				$viaTransporte = $f3->get('POST.viaTransporte');
				$lpns = $f3->get('POST.lpn');
				if ($lpns) {
					foreach ($lpns as $lpn) {
						$prefijo = substr($lpn, 0, 3);
						$po_number = intval(substr($lpn, 3, 8));
						$lpn_number = intval(substr($lpn, 11, 8));
						\comex\comex::actualizarLPNS($nroContenedor, $tipoContenedor, $bl, $viaTransporte, $nro_factura, $po_number, $lpn_number, $prefijo);
					}
				}
				$f3->set('SESSION.success', "Información almacenada correctamente.");
				$f3->reroute("/asociar_contenedor?cod_proveedor=$cod_proveedor&nro_factura=$nro_factura");
			} catch (Exception $ex) {
				$f3->set('SESSION.error', $ex->getMessage());
				$f3->reroute("/asociar_contenedor?cod_proveedor=$cod_proveedor&nro_factura=$nro_factura");
			}
		}
		
		public function enviar_comex($f3) {
			try {
				$cod_proveedor = $f3->get('GET.cod_proveedor');
				$nro_factura = $f3->get('GET.nro_factura');
				$local_path = "../archivos/factura_comex";
				$remote_path = "/Odbms/sdi/itfwms2006/Carga_PackingList/datos";
				$host = $f3->get('FTP_HOST');
				$port = $f3->get('FTP_PORT');
				$timeout = $f3->get('FTP_TIMEOUT');
				$user = $f3->get('FTP_USER');
				$pass = $f3->get('FTP_PASSWORD');
				$date = new DateTime("now", new DateTimeZone("America/Santiago"));
				$nro_envio = floatval($date->format('YmdHis'));
				$archivos = [];
				// Genera el archivo de encabezado
				$facturas = \comex\comex::obtenerEncabezadoArchivo($cod_proveedor, $nro_factura, $nro_envio);
				$nombre = "IEC$nro_envio";
				$contenido = "";
				$filas = 0;
				foreach ($facturas as $factura) {
					$contenido .= $factura[0] . "|";
					$contenido .= $factura[1] . "|";
					$contenido .= $factura[2] . "|";
					$contenido .= $factura[3] . "|";
					$contenido .= \LibraryHelper::convertNumber($factura[4]) . "|";
					$contenido .= \LibraryHelper::convertNumber($factura[5]) . "\n";
					$filas++;
				}
				file_put_contents("$local_path/$nombre", $contenido);
				$archivos[] = array("nombre" => $nombre, "filas" => $filas);
				// Genera el archivo de detalle
				$detalles = \comex\comex::obtenerDetalleArchivo($cod_proveedor, $nro_factura);
				$nombre = "IDC$nro_envio";
				$contenido = "";
				$filas = 0;
				foreach ($detalles as $detalle) {
					$contenido .= $detalle[0] . "|";
					$contenido .= $detalle[1] . "|";
					$contenido .= \LibraryHelper::convertNumber($detalle[2]) . "|";
					$contenido .= \LibraryHelper::convertNumber($detalle[3]) . "|";
					$contenido .= $detalle[4] . "|";
					$contenido .= \LibraryHelper::convertNumber($detalle[5]) . "|";
					$contenido .= $detalle[6] . "|";
					$contenido .= $detalle[7] . "|";
					$contenido .= \LibraryHelper::convertNumber($detalle[8]) . "|";
					$contenido .= \LibraryHelper::convertNumber($detalle[9]) . "|";
					$contenido .= \LibraryHelper::convertNumber($detalle[10]) . "|";
					$contenido .= $detalle[11] . "|";
					$contenido .= $detalle[12] . "\n";
					$filas++;
				}
				file_put_contents("$local_path/$nombre", $contenido);
				$archivos[] = array("nombre" => $nombre, "filas" => $filas);
				// Genera el archivo de control
				$nombre = "CMX$nro_envio.CTR";
				$contenido = "";
				foreach ($archivos as $archivo) {
					$contenido .= $archivo['nombre'] . " " . $archivo['filas'] . "\n";
				}
				file_put_contents("$local_path/$nombre", $contenido);
				$archivos[] = array("nombre" => $nombre, "filas" => $filas);
				// Genera el envío
				$ftp = ftp_connect($host, $port, $timeout);
				$login = ftp_login($ftp, $user, $pass);
				if ((!$ftp) || (!$login)) {
					$f3->set('SESSION.error', "No se pudo establecer la conexión con el FTP");
					$f3->reroute("/invoices?cod_proveedor=$cod_proveedor");
				} else {
					foreach ($archivos as $archivo) {
						$remote_file = "$remote_path/" . $archivo['nombre'];
						$source_file = "$local_path/" . $archivo['nombre'];
						if (!ftp_put($ftp, $remote_file, $source_file, FTP_BINARY)) {
							ftp_close($ftp);
							$f3->set('SESSION.error', "Ocurrió un error al enviar los archivos a COMEX.");
							$f3->reroute("/asociar_contenedor?cod_proveedor=$cod_proveedor&nro_factura=$nro_factura");
						}
					}
				}
				ftp_close($ftp);
				// Actualiza la factura
				\comex\comex::actualizarFactura($cod_proveedor, $nro_factura);
				$f3->set('SESSION.success', "Archivos enviados correctamente.");
				$f3->reroute("/comex");
			} catch (Exception $ex) {
				$f3->set('SESSION.error', $ex->getMessage());
				$f3->reroute("/asociar_contenedor?cod_proveedor=$cod_proveedor&nro_factura=$nro_factura");
			}
		}
		
		public function beforeRoute($f3) {
			if ($f3->exists('SESSION.login') == false) {
				$f3->reroute('/fin-sesion');
			}
		}
	}