/*! Controlador Jquery
 * Mantenedores del MAIN
 * @Author  Jose Miguel Candia
 */

$(function() {
	$('#inicio_popup_contenedor').click(function(event) {
		event.preventDefault();
		$('#divContenedor').on('shown.bs.modal', function(e) {
			var tabla = $('#tablaContenedores').DataTable({
				paging: false,
				scrollY: "200px",
				scrollCollapse: true,
				ordering: false,
				ajax: "obtener_contenedores",
				columns: [
					{data: 'nroOC'},
					{data: 'nroContenedor'},
					{data: 'nroEmbarque'},
					{data: 'fechaETA'},
					{data: null}
				],
				columnDefs: [
					{
						targets: -1,
						data: null,
						defaultContent: "<button class=\"btn btn-primary ir-contenedor\"><i class=\"fa fa-arrow-right\"></i></button>"
					}
				],
				destroy: true,
				initComplete: function(settings, json) {
					$('.ir-contenedor').click(function(event) {
						event.preventDefault();
						var data = tabla.row($(this).parents('tr')).data();
						var url = "distribucion_mercaderia?poNumber=" + data.nroOC + "&nroContenedor=" + data.nroContenedor;
						//console.log(url);
						window.location.href = url;
					});
				}
			});
		}).on('hidden.bs.modal', function(e) {
		}).modal('show');
	});
});