/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author Roberto Pérez (11-04-2018)
 */

$(window).on('load', function () {

    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();

   $('.titulo_mantenedor_ventana_llegada').empty();
   $('.titulo_mantenedor_ventana_llegada').append("Ventanas de Llegada");


    // Recargar el CBX de Formato, luiego de haber ingresado un nuevo registro
    var url_listar_llegada = 'ajax_simulador_ventana_llegada/listar_data';
    var total_porcentaje = 0;
    $.getJSON(url_listar_llegada, {DEPTO: depto_seleccionado_popup_select_depto}, function (data) {
        $.each(data, function (i,o) {

           // A los input que ya son parte de la tabla, les asigno por id su valor
           //$('#input_'+o[1]).val((o[2]*100));

            if( (o[2].charAt(0)==".") || (o[2].charAt(0)==",") ){
                $('#input_'+o[1]).val(parseFloat(o[2].replace(".", "0.")).toFixed(3));
            }else{
                $('#input_'+o[1]).val( parseFloat(o[2]).toFixed(3) );
            }

            // Calcular el total
            // total_porcentaje += Number(o[2]);
            total_porcentaje += Number(o[2]);

        });

        // La presiciòn era 1 originalmente
        //var despliega_input_total = total_porcentaje.toPrecision(1);
        var despliega_input_total = total_porcentaje.toFixed(5);
        $('#input_total').val(despliega_input_total*100);

    });

    // Recalcular el total y validar el 100%
    recTotalVentaLlegada();

    //codigo para cambiar el icono de ventanas de llegada, del popup de cargando, del simulador
    $('#accion_carga_modulo_ventanas_llegada').removeClass('fa fa-refresh');
    $('#accion_carga_modulo_ventanas_llegada').addClass('fa fa-check');

});

$('.tipo_btn_ventana_llegada').on('click', function () {

    //Bloquear btn
    $('#tipo_btn_ventana_llegada').attr('disabled', 'disabled');

    // Verificar que tengamos el nombre de usuario
    var ventana_llegada_usuario = $('#ventana_llegada_usuario').val();
    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();


    if (ventana_llegada_usuario == null){
        alert("No pudimos obtener tu nombre de usuario. Intenta salir del sistema e ingresar nuevamente.");
    }else {

        // Declaramos la URL de guardado
        var url_agregar = 'ajax_simulador_ventana_llegada/agrega_ventana_llegada';

        // Declaramos la URL de eliminar
        var url_eliminar = 'ajax_simulador_ventana_llegada/eliminar_ventana_llegada';


        // 1.- Validar que todos los input tengan algún valor numerico.
        var total_numericos = revisaNumerico();
        // 2.- Verificar que todos los campos tengan un valor numerico y no se encuentren vacios
        if (total_numericos == 0) {

            // 2.- Validar que la suma de 100%
            var total_suma = calculaSumaInput();
            // Verificar que la suma de todos loscampos, incluyendo el total "-" 100... de como resultado 100.
            if (total_suma == 100) {

                // Quitar los registros existentes
                $.get(url_eliminar, {USER:ventana_llegada_usuario, DEPTO: depto_seleccionado_popup_select_depto}).done( function( data ) {

                    // Recorro la tabla
                    $('.tabla_ventana_llegada tr').each(function () {
                        // Obtengo el valor del <td>
                        var ventana = $(this).find("td:first").html();
                        // Obtengo el valor del input dentro del <td>
                        var porcentaje = $(this).find("td:eq(2) input[type='text']").val();
                        //se comenta luego de modificacion
                        //porcentaje = (porcentaje/100);


                        // Verifico no encontrarme en el primer ni ùltimo <tr>
                        if ((typeof ventana !== "undefined") && (typeof porcentaje !== "undefined") && (ventana !== 'TOTAL')) {
                            $.get(url_agregar, {VENTANA:ventana, PORCENTAJE:porcentaje,USER:ventana_llegada_usuario, DEPTO: depto_seleccionado_popup_select_depto});
                            //alert("Debiera ir a guardar Ventana: " + ventana + " Porcentaje: " + porcentaje);
                        }

                    });

                }).done( function() {
                    // Define Tiempo 1 = 1000
                    var delay = 5000;
                    setTimeout(function () {
                        alert("Hemos procesado su solicitud, Recuerde revisar.");
                        $('#tipo_btn_ventana_llegada').removeAttr('disabled');
                        $('#selecciona_popup_ventana_llegada').modal('toggle');
                    }, delay);

                });






            } else {
                alert("¡ATENCIÓN!\n-Revise que los valores ingresados correspondan a un 100%.");
            }


        } else {
            alert("¡ATENCIÓN!\n-Revise que no existan espacios.\n-Revise haber ingresado todos los campos.\n-Revise que los valores sean numéricos.");
        }

    //Fin del else nombre de usuario existente
    }


});

function calculaSumaInput() {

    "use strict";
    var sum = 0;

    //Itera sobre cada uno de los input con class = "clase_input" (Creada, no hace referencia a nada especial)
    $(".clase_input").each(function () {
        // Solo suma si estamos hablando de valores numéricos y el campo contiene algún valor.
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value*100);
        }
    });

    //$("#sum").html(sum.toFixed(2));

    //return sum-100;
    return sum;

}

function revisaNumerico() {

    var num = 0;

    //Itera sobre cada uno de los input con class = "clase_input" (Creada, no hace referencia a nada especial)
    $(".clase_input").each(function () {
        // Solo suma si estamos hablando de valores numéricos y el campo contiene algún valor.
        if ( (isNaN(this.value)==true) || (this.value.length == 0) ) { //|| ($.isNumeric(this.value)==false)
            //num += parseFloat(this.value);
            num += 1;
        }
    });

    return num;

}

function recTotalVentaLlegada() {

    var sum = 0;

    //Itera sobre cada uno de los input con class = "clase_input" (Creada, no hace referencia a nada especial)
    $(".clase_input").each(function () {
        // Solo suma si estamos hablando de valores numéricos y el campo contiene algún valor.
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
        }
    });


    // $('.clase_input_total').val(sum);
    $('.clase_input_total').val(parseFloat(sum).toFixed(3)*100);

    // Para futuras pruebas desplegar en consola
    console.log(parseFloat(sum).toFixed(3)*100);

    /*if(sum>100){
        $('#tipo_btn_ventana_llegada').attr('disabled', 'disabled');
    }else{
        $('#tipo_btn_ventana_llegada').removeAttr('disabled');
    }*/

    if( (sum.toFixed(3)*100)==100){
        $('#tipo_btn_ventana_llegada').removeAttr('disabled');
    }else{
        $('#tipo_btn_ventana_llegada').attr('disabled', 'disabled');
    }

// Fin recTotalVentaLlegada
}


// Recorrer los radio que tengan un nombre específico
$("input[name=nombre_radio]:radio").on('change',function() {
        var selected_value= "";
        if ($("#id_radio").attr("checked")) {
            selected_value = $("input[name='nombre_radio']:checked").val();
        }else {
            selected_value = $("input[name='nombre_radio']:checked").val();
        }
});


// Evitamos que ingrese una ", o espacio "
$('input#input_A').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_B').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_C').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_D').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_E').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_F').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_G').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_H').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });
$('input#input_I').keydown(function(e) { "use strict"; if ( (e.keyCode == 188) || (e.keyCode == 32) ) {return false;} });

