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

function cargarListas() {
	var temp = $('#temporada').val();
	var depto = $('#departamento').val();
	if (!depto || !temp) {
		$('#disponibles').empty();
		actualizarBadgesDisponibles();
		$('#seleccionadas').empty();
		actualizarBadgesSeleccionadas();
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

	$('#temporada').select2({
		ajax: {
			url: 'obtener_temporadas',
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term
				}
			}
		},
		placeholder: 'Seleccione una opción',
		language: "es",
		allowClear: true
	});

	$('#departamento').select2({
		ajax: {
			url: 'obtener_departamentos',
			dataType: 'json',
			data: function(params) {
				return {
					q: params.term
				}
			}
		},
		placeholder: 'Seleccione una opción',
		language: "es",
		allowClear: true
	});

	habilitarBoton();

	$('#disponibles').empty();
	$('#seleccionadas').empty();

	cargarListas();

	$('#temporada').change(function() {
		cargarListas();
	});

	$('#departamento').change(function() {
		cargarListas();
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
		var cod_temporada = $('#temporada').val();
		var dep_depto = $('#departamento').val();
		var seleccionadas = $('#seleccionadas > li');
		var sucursales = [];
		var prioridad = 1;
		if (cod_temporada === "") {
			alert('Debe seleccionar una temporada antes de continuar');
			habilitarBoton();
			return;
		}
		if (dep_depto === "") {
			alert('Debe seleccionar un departamento antes de continuar');
			habilitarBoton();
			return;
		}
		if (seleccionadas.length == 0) {
			if (!confirm("No ha seleccionado ninguna sucursal. Esta acción podría eliminar datos previamente cargados. ¿Desea continuar?")) {
				habilitarBoton();
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
		}, function(data) {
			console.log(data.message);
			if (data.success) {
				alert('Datos guardados correctamente');
			} else {
				alert('Ha ocurrido un error al guardar los datos');
			}
			habilitarBoton();
		});
	});
});