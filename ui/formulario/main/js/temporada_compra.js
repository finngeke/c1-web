/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author Rodrigo Rioseco
 * @Edita Roberto Pérez
 */

$(function () {

    $('#lista_temporada').DataTable();


    // Abre el popup de confirmación (OK, Listo)
    $('.eliminar_temporada').on('click', function () {
        $('.registro').html('<b> ' + $('#corto_temp').val() + ' </b>');
    });



    // Limpio el <td> seleccionado previamente (OK, Listo)
    $('.limpiar_form').on('click', function () {
        $('#lista_temporada .filas').each(function () {
            $(this).removeClass("tabla_selecciona");
            $(this).find('input').prop("checked", false);
            $('.eliminar_temporada').addClass("disabled");

            //$('#nombre_corto').val("");
            $('#anno').val("2013");
            $('#description').val("");
            $('#cod_temp').val("");
            $('#corto_temp').val("");
        });
    });



    //##### Esto corresponde a cambiar estado ya que el SQL hace un UPDATE del estado ####
    $('.elimina_temporada').on('click', function () {

        // Primero hay que revisar que estado tiene para enviar el estado contrario
        /*$("#lista_temporada tr").each(function () {

        });*/

        var url = 'ajax_temporada/elimina_temporada';
        $.get(url, {temporada: $('#cod_temp').val(),estado_hidden: $('#estado_hidden').val()}, function (data) {
            // Despliega un mensaje en el navegador
            // var mensaje = data.split("-");
            // notificacionNavegador(mensaje[0], mensaje[1]);
            location.reload();
        });
    });


});


$(document).ready(function () {

    // se setea el año actual, para que no se creen temporadas con año menor... siempre mismo año o mayor
    var annoActual = (new Date).getFullYear()-5;

    // Agregar años al CBX de años
    var toAppend_disponible = "";
    for (var i = annoActual; i <= 2030 ; i++) {
        toAppend_disponible += '<option value='+i+'>'+i+'</option>';
    }
    $('#anno').append(toAppend_disponible);
    // Fin del agregar a CBX



    // Al momento de seleccionar un <tr>
    $('input[type=radio][name=carga_temporada]').change(function () {

        $('#lista_temporada .filas').each(function () {
            $(this).removeClass("tabla_selecciona");
        });

        $(this).parent().parent().addClass("tabla_selecciona");
        var cuerpo = $(this).parent().parent().data("temporada").split("$");

        $('.eliminar_temporada').removeClass("disabled");
        $('.quitar_temporada').removeClass("disabled");

        // $('#nombre_corto').val(cuerpo[1]);
        $('#description').val(cuerpo[2]);
        $('#cod_temp').val(cuerpo[0]);
        $('#corto_temp').val(cuerpo[1]);

        // Parapoder completar el CBX
        var str_nombre_corto = cuerpo[1];
        var res_nombre = str_nombre_corto.substring(0, 2);
        var res_anno = str_nombre_corto.substring(2, 6);

        // Del nombre corto extraigo los 2 primeros para cargar el CBX de nombre corto
        $("#nombre_corto").val(res_nombre).change();

        // Del nombre corto extraigo los ultimos 4 para cargar el año
        $("#anno").val(res_anno).change();



        // Revisar si este se encuentra activo o inactivo
        var encuetra_estado = $.trim($("input[name=carga_temporada]:checked").parent().siblings("td:eq(2)").text());

        // Se le asigna el valor 0/1 al campo "estado_hidden" segùn corresponda... esto es para realizar el posterior update
        if(encuetra_estado == 'ACTIVO'){
            $('#estado_hidden').val('1');
        }else{
            $('#estado_hidden').val('0');
        }




    });




    // Al enviar el formulario
    /*$("form").submit(function (event) {
        // Envia un mensaje en pantalla
        // notificacionNavegador("Control de Cambios", "Se realizó un cambio en BD...");
    });*/





});


// Previo a enviar el formulario
$('#form_guarda_temporada').submit(function(event) {

    // Evitar que se envie automáticamente el form
    event.preventDefault();

    // Establecar nombre
    var select_nombre_corto = $("#nombre_corto").val();

    // Realizar Validación
    var select_anno = $("#anno").val();

    // Concatenamos el nombre corto + año del HTML
    var concat_temp = select_nombre_corto+select_anno;

    var flag_crea_temp = 0;

    var texto_tem_td = "";

    // Verificar que el nombre que me encuentro enviando, no existe ya en el listado
    $("#lista_temporada tr").each(function () {
        texto_tem_td = $(this).find("#nombre_temporada_id").html();
        if(texto_tem_td == concat_temp){flag_crea_temp++;}
    });

    // Si el flag es mayor a 0, es por que ya existe uno no el mismo nombre
    if(flag_crea_temp > 0){

        // Hacer confirm indicando que sucede
        var r = confirm("¿Continuar?");
        if (r == true) {
            // Enviar el formulario
            $(this).unbind('submit').submit();
        } //else {
            // No enviar formulario
            //alert("No se han realizado cambios.");
        //}

    }else{
        // Si no existe en el listado, envio el formulario
        $(this).unbind('submit').submit();
    }

    // Enío el formulario, si el nombre no existe previamente
    //$(this).unbind('submit').submit(); // continue the submit unbind preventDefault

})

// OJO el eliminar_temporada, se encuentra cambiando los estados entre activo e inactivo
$('.quitar_temporada').on('click', function () {

    // Validar a nivel de seguridad que la temporada se encuentre desabilitada
    var encuetra_estado = $.trim($("input[name=carga_temporada]:checked").parent().siblings("td:eq(2)").text());

    // Se le asigna el valor 0/1 al campo "estado_hidden" segùn corresponda... esto es para realizar el posterior update
    if(encuetra_estado == 'ACTIVO'){
        // Temporadas activas no pueden ser eliminadas
        alert("Antes de poder eliminar esta temporada, cambie su estado a inactivo.");
    }else{
        // Si la temporada se encuentra inactiva, la puedo eliminar
        var url = 'ajax_temporada/quitar_temporada';
        $.get(url, {temporada: $('#cod_temp').val(),estado_hidden: $('#estado_hidden').val()}, function (data) {
            location.reload();
        });
    }

});


// Botón OnClick
$('#inicio_popup_temporada').on('click', function () {

    // Desplegar Modal
    $('#selecciona_temporada').modal('show');

});


