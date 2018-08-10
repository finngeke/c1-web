$(function() {
	$('.select-container').click(function(event) {
		event.preventDefault();
		var url = "obtener_detalle_contenedor?temporada=" + $(this).data('temporada') + "&po_number=" + $(this).data('po-number') + "&nro_contenedor=" + $(this).data('container-number') + "&login=" + $(this).data('login');
		/*$('#tabla_secundaria').DataTable({
			paging: false,
			scrollY: "200px",
			scrollCollapse: true,
			ajax: url,
			columns: [
				{data: 'fila'},
				{data: 'codTemporada'},
				{data: 'temporada'},
				{data: 'codEstilo'},
				{data: 'estilo'},
				{data: 'color'},
				{data: 'ventana'},
				{data: 'evento'},
				{data: 'curvaReparto'},
				{data: 'curvasCaja'}
			],
			destroy: true
		});*/
		$.getJSON(url, function(data, status, xhr) {
			var tabla = $('#tabla_secundaria > tbody');
			tabla.empty();
			$.each(data, function(key, val) {
				var fila = "<tr>\n";
				fila += "<td>" + val.fila + "</td>\n";
				fila += "<td>" + val.temporada + "</td>\n";
				fila += "<td>" + val.codEstilo + "</td>\n";
				fila += "<td>" + val.estilo + "</td>\n";
				fila += "<td>" + val.color + "</td>\n";
				fila += "<td>" + val.ventana + "</td>\n";
				fila += "<td>" + val.evento + "</td>\n";
				fila += "<td>" + val.curvaReparto + "</td>\n";
				fila += "<td>" + val.curvasCaja + "</td>\n";
				fila += "</tr>\n";
				tabla.append(fila);
			});
		});
	});
	/*$("#tabla_principal").DataTable({
		paging: false,
		scrollY: "200px",
		scrollCollapse: true,
		info: false,
		searching: false
	}).draw();*/
});