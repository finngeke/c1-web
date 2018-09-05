/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Roberto Pérez
 */


$(window).on('load', function () {

    $('.tipo_deptomarca').on('click', function () {
        $('#selecciona_popup_deptomarca').modal('show');
    });

    //$.fn.datepicker.defaults.format = "dd/mm/yyyy";

    $('.fecha').datepicker({format: 'dd/mm/yyyy',language:'es',orientation: 'bottom'});

    // Carga ListBox de asignados
    var url_lista_recepcion = 'ajax_temporada_fecha_recepcion/listar_ventana_recepcion';
    $.getJSON(url_lista_recepcion, function (data) {

        $.each(data, function (i,o) {

            // Asigna Valor a: "Fec Ini Recep CD"
            //FECHA_RECEPCD_A
            $('.fr_'+o[1]).val(o[2]);
            //document.getElementById('fr_'+o[1]).setAttribute('value', o[2]);

            // Asigna Valor a: "Sem Ini Recep CD"
            //SEMINIRECEPCD_A
            $('#SEMINIRECEPCD_'+o[1]).html(o[3]);

            // Asigna Valor a: "Mes Ini Recep CD"
            //MESINIRECEPCD_A
            $('#MESINIRECEPCD_'+o[1]).html(o[4]);

            // Asigna Valor a: "Fec Ini Venta"
            //FECHA_TDA_A
            $('.ft_'+o[1]).val(o[5]);

            // Asigna Valor a: "Sem Ini Venta"
            //SEMINIVENTA_A
            $('#SEMINIVENTA_'+o[1]).html(o[6]);

            // Asigna Valor a: "Mes Ini Venta"
            //MESINIVENTA_A
            $('#MESINIVENTA_'+o[1]).html(o[7]);
-
            $(".fr_"+o[1]+"[value='']").datepicker("setDate", o[2]);
            $(".ft_"+o[1]+"[value='']").datepicker("setDate", o[5]);

        //Fin de la aignación de resultados de la consulta
        });

    // fin de la lectura de resultados de la consulta
    });

});

$('.btn_guardar_fecha_recepcion').on('click', function () {

    var resp_conf = confirm("¿Guardar Cambios?");

    if (resp_conf == true) {

        // Cargar barra de porcentaje
        // PorcentajeCompletado(3);

        // Validar que la fecha "Fec Ini Recep CD" sea mayor a "Fec Ini Venta" anterior a la línea.
        // contador para sumar cuandono se cumpla una condición
        var contador_fechas = 0;

        // Capturo los valores de "Fec Ini Recep CD"
        var fr_A = $('.fr_A').val();
        var fr_B = $('.fr_B').val();
        var fr_C = $('.fr_C').val();
        var fr_D = $('.fr_D').val();
        var fr_E = $('.fr_E').val();
        var fr_F = $('.fr_F').val();
        var fr_G = $('.fr_G').val();
        var fr_H = $('.fr_H').val();
        var fr_I = $('.fr_I').val();


        // Capturo los valores de "Fec Ini Venta"
        var ft_A = $('.ft_A').val();
        var ft_B = $('.ft_B').val();
        var ft_C = $('.ft_C').val();
        var ft_D = $('.ft_D').val();
        var ft_E = $('.ft_E').val();
        var ft_F = $('.ft_F').val();
        var ft_G = $('.ft_G').val();
        var ft_H = $('.ft_H').val();
        var ft_I = $('.ft_I').val();


        // Validación cruzada de fechas
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_B,ft_A)==1){contador_fechas++;}}else{contador_fechas++;}
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_C,ft_B)==1){contador_fechas++;}}else{contador_fechas++;}
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_D,ft_C)==1){contador_fechas++;}}else{contador_fechas++;}
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_E,ft_D)==1){contador_fechas++;}}else{contador_fechas++;}
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_F,ft_E)==1){contador_fechas++;}}else{contador_fechas++;}
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_G,ft_F)==1){contador_fechas++;}}else{contador_fechas++;}
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_H,ft_G)==1){contador_fechas++;}}else{contador_fechas++;}
        if(fr_B.length == 10){if(validate_fechaMayorQue( fr_I,ft_H)==1){contador_fechas++;}}else{contador_fechas++;}


        // si hubo algún error en la validación de las fechas
        if(contador_fechas > 0){
            alert("Fecha recepción ingresada no puede ser menor a la fecha del embarque anterior.\n\n-Revise que todas las fechas de recepción se encuentren ingresadas y correctas.");
        }else{

            // Traer los datos del usuarios que esta realizando el cambio
            var fecha_recepcion_usuario = $('#fecha_recepcion_usuario').val();
            // Declaramos la URL de guardado
            var url_agregar = 'ajax_temporada_fecha_recepcion/guarda_fecha_recepcion';
            // Declaramos la URL de quitar
            var url_quitar = 'ajax_temporada_fecha_recepcion/quitar_fecha_recepcion';

            // ############## Quitar los registros existentes ##############
            $.get(url_quitar, {USER:fecha_recepcion_usuario}).done( function() {

                // Recoremos los <tr> de la tabla
                $('.tabla_fecha_recepcion tr').each(function () {
                    // Obtengo el valor del <td>
                    var ventana = $(this).find("td:first").html();
                    // Obtengo el valor de "Fec Ini Recep CD"
                    var ini_recep = $(this).find("td:eq(2) input[type='text']").val();
                    // Obtengo el valor de "Fec Ini Venta"
                    var ini_venta = $(this).find("td:eq(5) input[type='text']").val();
                    // Verifico no encontrarme en el primer <tr>
                    if ((typeof ventana !== "undefined") && (typeof ini_recep !== "undefined") && (typeof ini_venta !== "undefined")) {
                        $.get(url_agregar, {VENTANA:ventana, RECEPCION:ini_recep, VENTA:ini_venta,USER:fecha_recepcion_usuario});
                    }
                });

            });


        }// Revisar fechas correctas


        // Un segundo posterior al guardado, se recarga la pàgina. 1 segundo = 1000
        /*var delay = 3000;
        setTimeout(function() {
            // Recargar la Pàgina, para ver la tabla con los cambios
            location.reload();
        }, delay);*/


        // Esperar hasta que todos los REQUEST Ajax terminen, para ejecutar
        $(document).ajaxStop(function () {
            alert("Los cambios han sido almacenados.");
            // Recargar la Pàgina, para ver la tabla con los cambios
            location.reload();
        });



    } else { // Correspondiente a la validación de la confirmación
        alert("No se han realizado cambios.");
    }


});

// Eliminar un registro especifico
$('.btn_eliminar_fecha_recepcion').on('click', function () {

    // Cargar barra de porcentaje
    // PorcentajeCompletado(2);

    // Contar cuantos check han sido marcados para validar que al menos exista uno y podamos proceder con el resto del código
    var conteo_selecc_eliminar = 0;
    $('#tabla_fecha_recepcion').find('input[type="checkbox"]:checked').each(function () {
        conteo_selecc_eliminar++;
    });

    // Validamos que al menos exista uno seleccionado.
if(conteo_selecc_eliminar == 0){
    alert("Primero debe seleccionar una ventana a eliminar.");
}else {

    // Confirmar que se quiere eliminar
    var resp_conf = confirm("¿Desea eliminar la ventana seleccionada?");

    if (resp_conf == true) {

        // Declaramos la URL de quitar
        var url_quitar = 'ajax_temporada_fecha_recepcion/quitar_ventana_recepcion';

        // Traer los datos del usuarios que esta realizando el cambio
        var fecha_recepcion_usuario = $('#fecha_recepcion_usuario').val();

        $('#tabla_fecha_recepcion').find('input[type="checkbox"]:checked').each(function () {

            // Quitamos el registro (Funciona perfecto con el SP)
            $.get(url_quitar, {VENTANA: $(this).val(), USER: fecha_recepcion_usuario});

        });

        // Esperar hasta que todos los REQUEST Ajax terminen, para ejecutar
        $(document).ajaxStop(function () {
            alert("Los cambios han sido realizados.");
            // Recargar la Pàgina, para ver la tabla con los cambios
            location.reload();
        });


    } else {
        alert("No se han realizado cambios.");
    }

// Fin del else que valida que existan ventanas seleccionadas
}

// Fin de la función eliminar ventana
});

// Función para generar el excel
$('.btn_exportar_fecha_recepcion').on('click', function () {

    // Quitamos las cabeceras de la tabla
    $('.tabla_fecha_recepcion th:nth-child(1),#table td:nth-child(1)').remove();
    $('.tabla_fecha_recepcion th:nth-child(8),#table td:nth-child(8)').remove();

    // Quitamos las filas de la tabla
    $(".tabla_fecha_recepcion tbody tr").each(function() {
        $(this).find("td:first").remove();
        $(this).find("td:last").remove();
    });

    // transforma a excel la tabla completa, se le puede asignar un nombre a la hoja
    var table2excel = new Table2Excel();
    table2excel.export(document.querySelectorAll("table"));

    // Luego de descargar el excel, recargo la página para hacer aparecer las columnas que se quitaron.
    var delay = 1000;
    setTimeout(function() {
        // Recargar la Pàgina, para ver la tabla con los cambios
        location.reload();
    }, delay);


});


// Validar fechas
function validate_fechaMayorQue(fechaInicial,fechaFinal) {
    valuesStart = fechaInicial.split("/");
    valuesEnd = fechaFinal.split("/");

    // Verificamos que la fecha no sea posterior a la actual
    var dateStart = new Date(valuesStart[2],(valuesStart[1]-1),valuesStart[0]);
    var dateEnd = new Date(valuesEnd[2],(valuesEnd[1]-1),valuesEnd[0]);
    if(dateStart >= dateEnd)
    {
        return 0;
    }
    return 1;
}


// Para Desplegar la Barra de Porcentaje
function PorcentajeCompletado(duracion) {

    // Descomentar "jquery-ui.js" de fecha_recepcion.html para poder utilizarlo
    // Tomar como referencia, esto desordena el calendario de esta pàgina, se debe utilizar en otro logar y revisar conflictos con otros css y js
    // La duración se envia como parametro, para calzar con los tiempos de los procesos

    // Bloquear botones hasta que la pàgina se recarga
    $(".btn_guardar_fecha_recepcion").attr("disabled","disabled");
    $(".btn_exportar_fecha_recepcion").attr("disabled","disabled");
    $(".btn_eliminar_fecha_recepcion").attr("disabled","disabled");

    var progressbar = $( "#progressbar" ),
        progressLabel = $( ".progress-label" );

    progressbar.progressbar({
        value: false,
        change: function() {
            progressLabel.text( progressbar.progressbar( "value" ) + "%" );
        },
        complete: function() {
            progressLabel.text( "100%" );
        }
    });

    function progress() {
        var val = progressbar.progressbar( "value" ) || 0;

        progressbar.progressbar( "value", val + duracion );

        if ( val < 99 ) {
            setTimeout( progress, 80 );
        }
    }

    setTimeout( progress, 0 );


    // Desbloquear botones hasta que la pàgina se recarga
    $(".btn_guardar_fecha_recepcion").attr("disabled",false);
    $(".btn_exportar_fecha_recepcion").attr("disabled",false);
    $(".btn_eliminar_fecha_recepcion").attr("disabled",false);

}





