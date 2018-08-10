/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 */
$(function () {

    $('.ir_al_plan').on('click', function () {
        //alert($('#SELECT_TEMPORADA').find('option:selected').val());
        //plan_compra
        $(this).prop('href', 'plan_compra?codigo=' + $('#SELECT_TEMPORADA').find('option:selected').val());

    });

});


// Al cargar la página
$(window).on('load', function () {

    // Desplegar Modal
    //$('#selecciona_temporada').modal('show');

    // Limpiar el SELECT (Funciona cuando se abre por primera vez, al estár en modal se abre una vez)
    $('#SELECT_TEMPORADA').empty();

    // Carga las temporadas ACTIVAS y en orden DESCENDENTES
    var url_lista_temporada = 'ajax_temporada/listar_temporada';
    var toAppend_temporada = "";
    $.getJSON(url_lista_temporada, function (data) {
        $.each(data, function (i, o) {
            toAppend_temporada += '<option value=' + o[0] + '>' + o[1] + '</option>';
        });
        $('#SELECT_TEMPORADA').append(toAppend_temporada);
    });

});


// Botón OnClick
$('#inicio_popup_temporada').on('click', function () {

    // Desplegar Modal
    $('#selecciona_temporada').modal('show');

});