function habilitarBoton() {
	$('#btn-save').html('<i class="fa fa-save"></i>Guardar').prop('disabled', false);
}

function deshabilitarBoton() {
	$('#btn-save').html('<i class="fa fa-spinner fa-2x fa-spin"></i>Guardando').prop('disabled', true);
}

function actualizarBadgesDisponibles() {
	$('#badge-disponibles').html($('#disponibles > li').length);
	$('#disponibles > li').sort(function(a, b) {
		var itemA = parseInt($(a).data('sid'));
		var itemB = parseInt($(b).data('sid'));
		return (itemA < itemB) ? -1 : (itemA > itemB) ? 1 : 0;
	}).appendTo('#disponibles');
}

function actualizarBadgesSeleccionadas() {
	$('#badge-seleccionadas').html($('#seleccionadas > li').length);
}

function cargarListas(depto) {
	var temp = $('#cod_temporada').val();
	if (!depto) {
		$('#disponibles').empty();
		$('#seleccionadas').empty();
		return;
	}
	$.getJSON("obtener_sucursales_disponibles?cod_temporada=" + temp + "&dep_depto=" + depto, function(data) {
		$('#disponibles').empty();
		$.each(data, function(index, element) {
			$('#disponibles').append('<li class="list-group-item sortable-item" data-sid="' + element.codSucursal + '">' + element.codSucursal + ' - ' + element.sucursal + '</li>')
		});
		actualizarBadgesDisponibles();
	});
	$.getJSON("obtener_sucursales_seleccionadas?cod_temporada=" + temp + "&dep_depto=" + depto, function(data) {
		$('#seleccionadas').empty();
		$.each(data, function(index, element) {
			$('#seleccionadas').append('<li class="list-group-item sortable-item" data-sid="' + element.codSucursal + '">' + element.codSucursal + ' - ' + element.sucursal + '</li>')
		});
		actualizarBadgesSeleccionadas();
	});
}

$(function() {
	habilitarBoton();

	$('#disponibles').empty();
	$('#seleccionadas').empty();

	//actualizarBadgesDisponibles();
	//actualizarBadgesSeleccionadas();
	cargarListas('');

	$('#departamento').change(function() {
		var depto = $(this).val();
		cargarListas(depto);
	});

	$('#disponibles').sortable({
		connectWith: '#seleccionadas',
		placeholder: 'list-group-item-warning',
		update: function(event, ui) {
			actualizarBadgesDisponibles();
		}
	});

	$('#seleccionadas').sortable({
		connectWith: '#disponibles',
		placeholder: 'list-group-item-warning',
		update: function(event, ui) {
			actualizarBadgesSeleccionadas();
		}
	});

	$('#btn-save').click(function(event) {
		event.preventDefault();
		deshabilitarBoton();
		var cod_temporada = $('#cod_temporada').val();
		var dep_depto = $('#departamento').val();
		var seleccionadas = $('#seleccionadas > li');
		var sucursales = [];
		var prioridad = 1;
		if (dep_depto === "") {
			alert('Debe seleccionar un departamento antes de continuar');
			return;
		}
		if (seleccionadas.length == 0) {
			if (!confirm("No ha seleccionado ninguna sucursal. Esta acción podría eliminar datos previamente cargados. ¿Desea continuar?")) {
				return;
			}
		}
		seleccionadas.each(function(item) {
			var sucursal = {
				'cod_tda': $(this).data('sid'),
				'prioridad': prioridad
			};
			sucursales.push(sucursal);
			prioridad++;
		});

		$.post('guardar_prioridades_tienda', {
			'cod_temporada': cod_temporada,
			'dep_depto': dep_depto,
			'sucursales': sucursales
		}).done(function(data) {
			alert('Datos guardados correctamente');
			//notificacionNavegador('C1 Automática', 'Datos guardados correctamente');
		}).fail(function(error) {
			console.log(error);
			alert('Ha ocurrido un error al guardar los datos');
			//notificacionNavegador('ERROR', 'Ha ocurrido un error al guardar los datos');
		}).always(function() {
			habilitarBoton();
		});
	});
});