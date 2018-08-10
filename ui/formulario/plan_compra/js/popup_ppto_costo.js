/* Controlador Jquery
 * Mantenedores del MAIN
 * @Author Roberto Pérez (18-04-2018)
 */


$(window).on('load', function () {
   
   $('.titulo_mantenedor_ppto_costo').empty();
   $('.titulo_mantenedor_ppto_costo').append("Presupuesto Costo");

    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();

    // Utilizado para completar el input de presupuesto
    var url_listar_ppto = 'ajax_simulador_ppto_costo/busca_ppto';
    $.getJSON(url_listar_ppto, {DEPTO: depto_seleccionado_popup_select_depto}, function (data) {
        $.each(data, function (i,o) {
            // Le asignamos el valor al input de total presupuesto
            $('#input_total_ppto_costo').val(o[0]);
        });
    });



});


// Botòn agregarf
$('.tipo_btn_ppto_costo').on('click', function () {

    //Bloquear btn
    $('#tipo_btn_ppto_costo').attr('disabled', 'disabled');

   // Verificar que el campo presupuesto tenga datos
    var total_ppto_costo = $('#input_total_ppto_costo').val();
    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();


    if (total_ppto_costo == null ||total_ppto_costo == 0){
        alert("Para poder guardar, debe ingresar un valor o este ser mayor a cero.");
    }else {

        // Verificar que tengamos el nombre de usuario
        var ppto_costo_usuario = $('#ppto_costo_usuario').val();

        // declaramos la URL de eliminaciòn y eliminamos
        var url_eliminar = 'ajax_simulador_ppto_costo/eliminar_ppto_costo';
        $.get(url_eliminar, {USER:ppto_costo_usuario, DEPTO: depto_seleccionado_popup_select_depto}).done( function( data ) {

            // Declaramos la URL de guardado y guardamos
            var url_agregar = 'ajax_simulador_ppto_costo/agrega_ppto_costo';
            $.get(url_agregar, {PRESUPUESTO: total_ppto_costo, USER:ppto_costo_usuario, DEPTO: depto_seleccionado_popup_select_depto}).done( function( data ) {
                alert("Hemos procesado su solicitud, Recuerde revisar.");
                $('#tipo_btn_ppto_costo').removeAttr('disabled');
                $('#selecciona_popup_ppto_costo').modal('toggle');
            });

        } );




    }


});




