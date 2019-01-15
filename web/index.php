<?php

$f3 = require('../lib/base.php');

$f3->config('../config.ini');
session_start();

\Template::instance()->extend('mensaje', 'MensajeHelper::render');
\Template::instance()->extend('msj', 'MensajeHelper::easy');

if (!$f3->exists("max_file_size"))
		$f3->set("max_file_size", 30);

/* VERIFICA LAS CARPETAS DE ARCHIVO */
$carpetas[] = '../archivos/Assortments';
$carpetas[] = '../archivos/bajada_embarque';
$carpetas[] = '../archivos/bmt';
$carpetas[] = '../archivos/curva';
$carpetas[] = '../archivos/factura_comex';
$carpetas[] = '../archivos/json';
$carpetas[] = '../archivos/log_querys';
$carpetas[] = '../archivos/pi';

foreach ($carpetas as $carpeta) {
	if (!file_exists($carpeta)) {
		mkdir($carpeta);
	}
}

/* CONTROL DE RUTERO */
$f3->route('GET /', 'ControlPortada->portada', 0, 512);
$f3->route('POST /login', 'ControlPortada->login', 0, 5);
$f3->route('GET /salir', 'ControlPortada->salir');
$f3->route('GET /fin-sesion', 'ControlPortada->salir');

/* INICIO */
$f3->route('GET /inicio', 'ControlFormularioMain->inicio');

/* USUARIOS */
$f3->route('GET /usuarios', 'ControlFormularioMain->usuarios');
$f3->route('POST /guardar/funcionario', 'usuario\ControlCrea->funcionario');
$f3->route('GET /ajax_funcionario/@tipo [ajax]', 'usuario\ControlAjax->@tipo');

/*Cambiar clave*/
$f3->route('GET /cambiar_clave/@tipo [ajax]', 'usuario\Control_usuario_cambios->@tipo');

/* PERMISOS */
$f3->route('GET /ver_sesiones', 'ControlFormularioMain->sesiones_activas');
$f3->route('GET /permisos', 'ControlFormularioMain->permisos');
$f3->route('GET /permiso_usuario/@tipo [ajax]', 'permisos\PermisoTipoUsuario->@tipo');

/* MANTENIMIENTO DE SISTEMA */
$f3->route('GET /mantenimiento_sistema', 'ControlFormularioMain->mantenimiento_sistema');
$f3->route('GET /actualizar_calculos', 'ControlFormularioMain->actualizar_calculos');
$f3->route('GET /depto_marca', 'ControlFormularioMain->depto_marca');

/* TEMPORADA */
$f3->route('GET /temporada_compra', 'ControlFormularioMain->temporada_compra');
$f3->route('GET /ajax_temporada/@tipo [ajax]', 'temporada\ControlAjax->@tipo');
$f3->route('POST /guardar/temporada', 'temporada\ControlCrea->temporada');

/* FACTOR ESTIMADO */
$f3->route('GET /ajax_factorestimado/@tipo [ajax]', 'factor_est\ControlAjax->@tipo');
$f3->route('GET /factor_estimado', 'ControlFormularioCompra->factor_estimado');
$f3->route('POST /guardar/factorestimado', 'factor_est\ControlCrea->guardarFactor');

/*FACTOR IMPORTACION*/
$f3->route('GET /Factor_import/@tipo [ajax]', 'temporada\ControlCrea->@tipo');

/* FECHA RECEPCION */
$f3->route('GET /fecha_recepcion', 'ControlFormularioCompra->fecha_recepcion');
$f3->route('GET /ajax_temporada_fecha_recepcion/@tipo [ajax]', 'temporada\ControlFechaRecepcion->@tipo');

/*FACTOR IMPORTACION*/
$f3->route('GET /Factor_Importacion', 'ControlFormularioCompra->Factor_Importacion');

/* PLAN DE COMPRA */
$f3->route('GET /plan_compra', 'ControlFormularioCompra->inicio');
$f3->route('GET /selecion_depto', 'ControlFormularioCompra->selecciona_depto');

/* ACTUALIZAR CALCULOS*/
$f3->route('GET /actualizar_calculos/@tipo [ajax]', 'simulador_compra\Control_actualizar_calculos->@tipo');

/* MASTER PACK */
$f3->route('GET /master_pack', 'ControlFormularioMain->master_pack');
$f3->route('GET /lista_master_pack', 'ControlFormularioMain->mantenedor_master_pack');
$f3->route('GET /ajax_master_pack/@tipo [ajax]', 'mantenedores\ControlAjax->@tipo');
$f3->route('GET /ajax_jerarquia/@tipo [ajax]', 'mantenedores\ControlAjax->@tipo');
$f3->route('GET /ajax_carga_jerarquia/@tipo [ajax]', 'jerarquia\ControlJerarquia->@tipo');
$f3->route('GET /ajax_simulador_deptomarca/@tipo [ajax]', 'mantenedores\ControlDeptoMarca->@tipo');

/* SIMULADOR DE COMPRA */
$f3->route('GET /simulador_compra', 'ControlFormularioCompra->simulador_compra');
$f3->route('POST /guardar/archivo_bmt', 'simulador_compra\ControlCrea->importar_bmt');
$f3->route('GET /ajax_simulador_tienda/@tipo [ajax]', 'mantenedores\ControlTipoTienda->@tipo');
$f3->route('GET /ajax_simulador_tienda_cbx/@tipo [ajax]', 'ControlFormularioMantenedores->@tipo');
$f3->route('GET /ajax_simulador_formato/@tipo [ajax]', 'mantenedores\ControlFormato->@tipo');
$f3->route('GET /ajax_simulador_ventana_llegada/@tipo [ajax]', 'mantenedores\ControlVentanaLlegada->@tipo');
$f3->route('GET /ajax_simulador_ppto_costo/@tipo [ajax]', 'mantenedores\ControlPptoCosto->@tipo');
$f3->route('GET /ajax_simulador_ppto_retail/@tipo [ajax]', 'mantenedores\ControlPptoRetail->@tipo');
$f3->route('POST /guardar/archivo_pi', 'simulador_compra\ControlCrea->guarda_pi');
$f3->route('POST /guardar/archivo_pi_server', 'simulador_compra\ControlCrea->guarda_pi_server');
$f3->route('POST /TelerikGuardar/GuardaArhcivoPI', 'simulador_compra\PlanCompraController->GuardaArhcivoPI');
$f3->route('GET /ajax_simulador_cbx/@tipo [ajax]', 'simulador_compra\ControlCBXGrillaCompra->@tipo');
$f3->route('GET /TelerikPlanCompra/@tipo [ajax]', 'simulador_compra\PlanCompraController->@tipo');
$f3->route('POST /TelerikPlanCompraPOST/@tipo [ajax]', 'simulador_compra\PlanCompraController->@tipo');
$f3->route('POST /ajax_simulador_cbx2/@tipo [ajax]', 'simulador_compra\ControlCBXGrillaCompra->@tipo');
$f3->route('GET /VerificaTiendaPlanCompra/@tipo [ajax]', 'simulador_compra\PlanCompraController->@tipo');

/*Importar archivo*/
$f3->route('POST /guardar/archivoAssorment', 'simulador_compra\ControlCrea->SubirAssorment');
$f3->route('GET /importar_archivo/@tipo [ajax]', 'simulador_compra\ControlCrea->@tipo');
$f3->route('GET /importar_archivo2', 'simulador_compra\ControlCrea->Mensaje_Guardado');
$f3->route('GET /importar_archivo3', 'simulador_compra\ControlCrea->Mensaje_GuardadoBMT');
//$f3->route('GET /importar_archivo_2/@tipo [ajax]', 'simulador_compra\ControlCrea->@tipo');
$f3->route('POST /importar_archivo_3/@tipo [ajax]', 'simulador_compra\ControlCrea->@tipo');

/*FACTOR ESTIMADO*/
$f3->route('GET /fecha_recepcion', 'ControlFormularioCompra->fecha_recepcion');
$f3->route('GET /factor_estimado', 'ControlFormularioCompra->factor_estimado');
$f3->route('POST /guardar/tipo_cambio', 'tipo_cambio\ControlCrea->tipo_cambio');
$f3->route('POST /guardar/factorestimado', 'factor_est\ControlCrea->guardarFactor');


/*EXPORTA EXCEL*/
$f3->route('GET /exporta_factor', 'ControlFormularioExport->excelFactorEstimado');
//$f3->route('GET /exporta_excel/@tipo [ajax]', 'ControlFormularioExport->excelPlanDeCompra->@tipo');
$f3->route('POST /exporta_excelTelerik', 'simulador_compra\PlanCompraController->ExportarArchivos');
$f3->route('POST /exporta_excel', 'ControlFormularioExport->excelPlanDeCompra');
$f3->route('POST /exporta_excel_distribucion', 'ControlReposicion->excel_distribucion_mercaderia');
$f3->route('GET /exporta_ARCHIVO', 'usuario->PRUEBAEXCEL');
$f3->route('GET /exportar_simulador/@tipo [ajax]', 'ControlFormularioExport->@tipo');
$f3->route('GET /exportar_simulador2', 'simulador\plan_compra');

/* PROVEEDOR */
$f3->route('GET /proveedor', 'ControlProveedor->home');
$f3->route('GET /getProveedores', 'ControlProveedor->getProveedores');
// Para la descarga de archivos
$f3->route('GET /download_templates', 'ControlProveedor->download_templates');
$f3->route('GET /download_packing_instructions', 'ControlProveedor->download_packing_instructions');
$f3->route('GET /download_label_data', 'ControlProveedor->download_label_data');
$f3->route('GET /download_packing_list', 'ControlProveedor->download_packing_list');
// Para la carga de factura
$f3->route('GET /invoice_income', 'ControlProveedor->invoice_income');
$f3->route('POST /validate_invoice_number', 'ControlProveedor->validate_invoice_number');
$f3->route('POST /save_invoice', 'ControlProveedor->save_invoice');
// Para la carga de packing lists
$f3->route('GET /upload_pl', 'ControlProveedor->upload_pl');
$f3->route('POST /save_pl', 'ControlProveedor->save_pl');
// Para el envío de packing list a COMEX
$f3->route('GET /invoices', 'ControlProveedor->invoices');
$f3->route('GET /approve_invoice', 'ControlProveedor->approve_invoice');

/* DISTRIBUCION DE MERCADERIA */
$f3->route('GET /reposicion', 'ControlReposicion->inicio');
$f3->route('GET /prioridades_tienda', 'ControlReposicion->prioridades_tienda');
$f3->route('GET /obtener_temporadas', 'ControlReposicion->obtener_temporadas');
$f3->route('GET /obtener_departamentos', 'ControlReposicion->obtener_departamentos');
$f3->route('GET /obtener_sucursales_disponibles', 'ControlReposicion->obtener_sucursales_disponibles');
$f3->route('GET /obtener_sucursales_seleccionadas', 'ControlReposicion->obtener_sucursales_seleccionadas');
$f3->route('POST /guardar_prioridades_tienda', 'ControlReposicion->guardar_prioridades_tienda');
$f3->route('GET /distribucion_mercaderia', 'ControlReposicion->distribucion_mercaderia');
$f3->route('GET /obtener_contenedores', 'ControlReposicion->obtener_contenedores');
$f3->route('GET /cargar_distribucion_mercaderia', 'ControlReposicion->cargar_distribucion_mercaderia');
$f3->route('GET /detalle_contenedores_sucursales', 'ControlReposicion->detalle_contenedores_sucursales');
$f3->route('POST /guardar_distribucion_tienda', 'ControlReposicion->guardar_distribucion_tienda');
$f3->route('POST /aprobar_distribucion_tienda', 'ControlReposicion->aprobar_distribucion_tienda');

/* BAJADA DE EMBARQUE */
$f3->route('GET /bajada_embarque', 'ControlReposicion->bajada_embarque');
$f3->route('GET /generar_archivos', 'ControlReposicion->generar_archivos');

/* COMEX*/
$f3->route('GET /comex', 'ControlComex->inicio');
$f3->route('GET /asociar_contenedor', 'ControlComex->asociar_contenedor');
$f3->route('POST /guardar_contenedor', 'ControlComex->guardar_contenedor');
$f3->route('GET /enviar_comex', 'ControlComex->enviar_comex');


/* LOG TRANSACCIONES*/
$f3->route('GET /GuardarLogTransaccion/@tipo [ajax]', 'log_transaccion\GuardaLogTransaccion->@tipo');

$f3->run();
