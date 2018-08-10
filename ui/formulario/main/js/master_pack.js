/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 * @Author  Rodrigo Rioseco
 */

$('.agrega_master').on('click', function () {

        if ($(".DIVISION option:selected").val() == 'NULL' || $(".depto option:selected").val() == 0 || $(".linea option:selected").val() == 0 || $(".sublinea option:selected").val() == 0) {
            alert("Debe seleccionar los filtros del formulario");
        } else {
            var url = 'ajax_jerarquia/agrega_depto_master_pack';
            $.get(url, {codigos: $(".depto option:selected").val()
                        + '$' + $(".linea option:selected").val()
                        + '$' + $(".sublinea option:selected").val()}, function (data) {
                //var mensaje = data.split("-");
                //notificacionNavegador(mensaje[0], mensaje[1]);
                location.reload();
            });
        }

});

$('.button_form').on('click', function () {

    var r = confirm("¿Quiere guardar los cambios?\n\nEspere a que el sistema le informe que ha terminado.");
    if (r == true) {

        $('#lista_master_pack >tbody >tr').each(function () {

            var masterpack = $(this).find("td:eq(5) input[type='text']").val();
            var actualiza_master  = $(this).find("td:eq(6)").html();

            // Validar que el tr sea modificado para que se guarde (Optimización idea 06062018)

            if( (typeof(masterpack) != "undefined") && (masterpack.length>0) && (actualiza_master=='U')){

                var division = $(this).find("td:eq(0) input[type='radio']").val();
                //division = division.replace(/[^a-z0-9]/gi,'');
                var division_separada = division.split("-");
                division = division_separada[0].replace(/[^a-z0-9]/gi,'');
                var departamento = $(this).find("td:eq(2)").html();
                //departamento = departamento.replace(/[^a-z0-9]/gi,'');
                departamento = division_separada[1].replace(/[^a-z0-9]/gi,'');
                var linea = $(this).find("td:eq(3)").html();
                //linea = linea.replace(/[^a-z0-9]/gi,'');
                linea = division_separada[2].replace(/[^a-z0-9]/gi,'');
                var sublinea = $(this).find("td:eq(4)").html();
                //sublinea = sublinea.replace(/[^a-z0-9]/gi,'');
                sublinea = division_separada[3].replace(/[^a-z0-9]/gi,'');

                var url_carga_masterpack = 'ajax_carga_jerarquia/almacenaMasterPack';
                $.getJSON(url_carga_masterpack, {DIVISION:division,DEPARTAMENTO:departamento,LINEA:linea,SUBLINEA:sublinea,MASTERPACK:masterpack});

            }
        })/*.done( function( data ) {
            alert("Ha terminado el Guardado.");
        } )*/;

        // Se comenta y se pasa al done, solo para ver que el alert aparezca cuando termina de recorrer la fila
        $(document).ajaxStop(function () {
            alert("Ha terminado el Guardado.");
        });

    } else {
        alert("No se han realizado cambios.");
    }

});

$(document).ready(function () {
    $('#lista_master_pack').DataTable({
        paging: false
    });
});

$(document).on('change', '.DIVISION', function () {
    $('.depto').empty();
    $('.linea').empty();
    $('.sublinea').empty();
    var toAppend = '';
    toAppend += '<option value=0>SELECCIONE EL DEPTO.</option>';
    var url = 'ajax_jerarquia/obtiene_departamentos';
    $.getJSON(url, {division: $(this).val()}, function (data) {

        $.each(data, function (i, o) {
            toAppend += '<option value=' + o['DEP_DEPTO'] + '><b>' + o['DEP_DEPTO'] + '<b> - ' + o['DEP_DESCRIPCION'] + '</option>';
        });
        
        $('.depto').append(toAppend);

    });
});

$(document).on('change', '.depto', function () {
    $('.linea').empty();
    $('.sublinea').empty();
    var toAppend = '';
    toAppend += '<option value=0>SELECCIONE LA LINEA.</option>';
    var url = 'ajax_jerarquia/obtiene_lineas';
    $.getJSON(url, {depto: $(this).val()}, function (data) {

        $.each(data, function (i, o) {
            toAppend += '<option value=' + o[0] + '><b>' + o[0] + '<b> - ' + o[1] + '</option>';
        });
        $('.linea').append(toAppend);

    });
});

$(document).on('change', '.linea', function () {
    $('.sublinea').empty();
    var toAppend = '';
    toAppend += '<option value=0>SELECCIONE LA SUBLINEA.</option>';
    url = 'ajax_jerarquia/obtiene_Sublineas';
    $.getJSON(url, {linea: $(this).val()}, function (data) {

        $.each(data, function (i, o) {
            toAppend += '<option value=' + o[0] + '><b>' + o[0] + '<b> - ' + o[1] + '</option>';
        });
        $('.sublinea').append(toAppend);

    });
});

$(window).on('load', function () {


    $('.tipo_deptomarca').on('click', function () {
        $('#selecciona_popup_deptomarca').modal('show');
    });

/*
$('input.fila').change(function () {
alert("cambio en la fila");
        $('#lista_master_pack tr.filas').each(function () {
            $(this).removeClass("tabla_selecciona");
        });
        $(this).parent().parent().addClass("tabla_selecciona");
        var cuerpo = $(this).parent().parent().data("funcionario").split("$");
        $('.eliminar_usuario').removeClass("disabled");
        $('#usuario').prop("disabled", true);

    });
*/




//Fin del load
});


function cambia_estado(event) {

    // hay que cargar nuevamente la sublinea con el id de la linea que ha modificado
    var id = $(event.target);
    id = id.attr('id');
    var separa_barra = id.split("_");

    // Actualizar el Campo de Editado
    $('#actualiza_campo_'+separa_barra[2]).html('U');

}




