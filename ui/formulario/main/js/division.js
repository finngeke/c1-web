/*
 * Mantenedores del MAIN
 * @Author Roberto Pérez
 */

$(function () {

    $('.ir_al_master_pack').on('click', function () {

        // Validar que division y departamento tengan datos antes de enviar a la URL
        var popup_masterpack_division = $('#SELECT').find('option:selected').val();
        var popup_masterpack_departamento = $('#popup_masterpack_depto').find('option:selected').val();

        if( (popup_masterpack_division!=null) && (popup_masterpack_departamento!=null) ) {
            $('.loading').fadeIn();
            $(this).prop('href', 'lista_master_pack?division=' + popup_masterpack_division + '&depto_pop_master=' + popup_masterpack_departamento);
            $('.ir_al_master_pack').remove();
        }

    });

});

$(window).on('load', function () {

    // Desabilitar botón por ID
    $(".ir_al_master_pack").attr("disabled", "disabled");

    // Cargar los departamentos
    cargaDeptoPUPMasterPack($('#SELECT').find('option:selected').val());

    // Desplegar el modal
    $('#selecciona_division').modal('show');

});


// Botón OnChange
$("#SELECT").on('change', function () {

    var masterpack_division = $('#SELECT').find('option:selected').val();

    cargaDeptoPUPMasterPack(masterpack_division);

// Fin del onchange division
});


// Botón OnChange
$("#popup_masterpack_depto").on('change', function () {

    var popup_masterpack_division     = $('#SELECT').find('option:selected').val();
    var popup_masterpack_departamento = $('#popup_masterpack_depto').find('option:selected').val();

    // Verificar que division y departamento tengan datos para poder así habilitar el botón
    if( (popup_masterpack_division!=null) && (popup_masterpack_departamento!=null) ){
        $(".ir_al_master_pack").attr("disabled", false);
    }

// Fin del onchange depto
});


function cargaDeptoPUPMasterPack(division){

    // Cargar Departamento
    $('#popup_masterpack_depto').empty();
    var url_carga_depto = 'ajax_simulador_deptomarca/obtiene_depto';
    var toAppend_depto = "";
    $.getJSON(url_carga_depto,{DIVISION:division},function (data) {
        $.each(data, function (i,o) {
            if(o[0]){
                toAppend_depto += '<option value='+o[0]+'>'+o[0]+' - '+o[1]+'</option>';
            }
        });
        $('#popup_masterpack_depto').append(toAppend_depto);
    }).done( function( data ) {
        // Habilitar el btn de ir
        var popup_masterpack_division     = $('#SELECT').find('option:selected').val();
        var popup_masterpack_departamento = $('#popup_masterpack_depto').find('option:selected').val();
        // Verificar que division y departamento tengan datos para poder así habilitar el botón
        if( (popup_masterpack_division!=null) && (popup_masterpack_departamento!=null) ){
            $(".ir_al_master_pack").attr("disabled", false);
        }
    });

}



