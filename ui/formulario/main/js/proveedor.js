/*! Controlador Jquery
 * Mantenedores del MAIN
 * @Author  Jose Miguel Candia
 */

$(function() {
	$('#inicio_popup_proveedor').click(function(event) {
		event.preventDefault();
		$('#divProveedor').on('shown.bs.modal', function(e) {
			$('#tablaProveedores').DataTable({
				paging: false,
				scrollY: "200px",
				scrollCollapse: true,
				ajax: 'getProveedores',
				columns: [
					{data: 'codigo'},
					{data: 'rut'},
					{data: 'nombre'},
					{data: 'codigo'}
				],
				columnDefs: [
					{
						render: function(data, type, row) {
							return "<a class=\"btn btn-primary ir-proveedor\" href=\"proveedor?cod_proveedor=" + data + "\" target=\"_blank\"><i class=\"fa fa-arrow-right\"></i></a>";
						},
						targets: 3
					}
				],
				order: [[2, 'asc']],
				//deferRender: true,
				destroy: true,
				initComplete: function(settings, json) {
					$('.ir-proveedor').click(function(event) {
						//event.preventDefault();
						//console.log('Presionó el botón');
						$('#divProveedor').modal('hide');
					});
				}
			});
		}).on('hidden.bs.modal', function(e) {
			$('#tablaProveedores').DataTable().clear().draw();
		}).modal('show');
	});
});