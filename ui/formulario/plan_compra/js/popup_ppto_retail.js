/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author Roberto Pérez (18-04-2018)
 */



$(window).on('load', function () {

    $('.titulo_mantenedor_ppto_retail').empty();
    $('.titulo_mantenedor_ppto_retail').append("Presupuesto Retail");

    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();

    // Utilizado para completar el input de presupuesto
    var url_listar_ppto = 'ajax_simulador_ppto_retail/busca_ppto';
    $.getJSON(url_listar_ppto, {DEPTO: depto_seleccionado_popup_select_depto},function (data) {
        $.each(data, function (i,o) {
            // Le asignamos el valor al input de total presupuesto
            $('#input_total_ppto_retail').val(o[0]);
        });
        $('#accion_carga_modulo_ppto_retail').removeClass('fa fa-refresh');
        $('#accion_carga_modulo_ppto_retail').addClass('fa fa-check');
    });



});


// Botòn agregarf
$('.tipo_btn_ppto_retail').on('click', function () {

    $('#tipo_btn_ppto_retail').attr('disabled', 'disabled');

    // Verificar que el campo presupuesto tenga datos
    var total_ppto_retail = $('#input_total_ppto_retail').val();
    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();


    if (total_ppto_retail == null ||total_ppto_retail == 0){
        alert("Para poder guardar, debe ingresar un valor o este ser mayor a cero.");
    }else {

        // Verificar que tengamos el nombre de usuario
        var ppto_retail_usuario = $('#ppto_retail_usuario').val();


        // declaramos la URL de eliminaciòn y eliminamos
        var url_eliminar = 'ajax_simulador_ppto_retail/eliminar_ppto_retail';
        $.get(url_eliminar, {USER:ppto_retail_usuario, DEPTO: depto_seleccionado_popup_select_depto}).done( function( data ) {

            // Declaramos la URL de guardado y guardamos
            var url_agregar = 'ajax_simulador_ppto_retail/agrega_ppto_retail';
            $.get(url_agregar, {PRESUPUESTO: total_ppto_retail, USER:ppto_retail_usuario, DEPTO: depto_seleccionado_popup_select_depto}).done( function( data ) {
                alert("Hemos procesado su solicitud, Recuerde revisar.");
                $('#tipo_btn_ppto_retail').removeAttr('disabled');
                $('#selecciona_popup_ppto_retail').modal('toggle');
            } );

        } );




    }


});





