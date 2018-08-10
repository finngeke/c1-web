/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Roberto Pérez (23-03-2018)
 */

//$(document).on('change', '.TIENDAS', function () {
$( "#TIENDAS" ).change(function() {

    var marca_seleccionada = $('#MARCAS').val();
    var tienda_seleccionada = $(this).val();
    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();

    $('.DISPONIBLE').empty();
    $('.ASIGNADO').empty();

    if ( (marca_seleccionada != 'NULL') && (tienda_seleccionada != 'NULL') && (marca_seleccionada != '') && (tienda_seleccionada != '') ) {

    // Define Tiempo 1 = 1000
    var delay = 1000;
    setTimeout(function () {
        // Si la tienda es "I" tengo que cargar la tienda internet si o si
        if ($('#TIENDAS option:selected').text() == 'I') {

            // Voy a preguntar si existe, si no trae datos los agrego
            var url_existe_internet = 'ajax_simulador_tienda/busca_existe_internet';
            var flag_busca_internet = 0;
            $.getJSON(url_existe_internet, {MARCA: marca_seleccionada, TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto}, function (data) {

                $.each(data, function (i, o) {
                    flag_busca_internet++;
                });

                // Si no existe el registro de internet lo agrego
                if (flag_busca_internet == 0) {
                    // Agregar Internet a los registros
                    var url_agrega_internet = 'ajax_simulador_tienda/agrega_tienda';
                    $.get(url_agrega_internet, {MARCA: marca_seleccionada,TIENDA: tienda_seleccionada,ASIGNADO: 10039,DEPTO: depto_seleccionado_popup_select_depto});
                }

            });

        }
    }, delay);


        // Define Tiempo 1 = 1000
        var delay_list = 2000;
        setTimeout(function () {
            // Carga ListBox disponible
            var url_disponible = 'ajax_simulador_tienda/obtiene_disponible';
            var toAppend_disponible = "";
            $.getJSON(url_disponible, {MARCA: marca_seleccionada, TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto}, function (data) {
                $.each(data, function (i, o) {
                    var data = o.split('#');
                    if(data[0]!=10039){
                    toAppend_disponible += '<option value=' + data[0] + '>' + data[1] + '</option>';
                    }
                });
                $('.DISPONIBLE').append(toAppend_disponible);
            }).done( function( data ) {

                // Carga ListBox asignado
                var url_asignado = 'ajax_simulador_tienda/obtiene_asignado';
                var toAppend_asignado = "";
                $.getJSON(url_asignado, {MARCA: marca_seleccionada, TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto}, function (data) {
                    $.each(data, function (i, o) {
                        toAppend_asignado += '<option value=' + o[0] + '>' + o[1] + '</option>';
                    });
                    $('.ASIGNADO').append(toAppend_asignado);
                });

            } );

        }, delay_list);




    // Si la tienda es internet no puedo mover entre "Disponible" y "Asignado"
    //if (tienda_seleccionada == 4) {
    if ($('#TIENDAS option:selected').text() == 'I') {
        $(".DISPONIBLE").attr('disabled', 'disabled');
        $(".ASIGNADO").attr('disabled', 'disabled');

        if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
        $('.tipo_btn').attr('disabled', 'disabled');
        $('.agregar').attr('disabled', 'disabled');
        $('.quitar').attr('disabled', 'disabled');
        $('#btn_replicar_popup_tipo_tienda').attr('disabled', 'disabled');
        }


    } else {
        $(".DISPONIBLE").removeAttr('disabled');
        $(".ASIGNADO").removeAttr('disabled');

        if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
        $('.tipo_btn').removeAttr('disabled');
        $('.agregar').removeAttr('disabled');
        $('.quitar').removeAttr('disabled');
        $('#btn_replicar_popup_tipo_tienda').removeAttr('disabled');
    }


    }

    // Define Tiempo 1 = 1000
    var delay = 4000;
    setTimeout(function () {
        // Cargar los <SPAN> con la cantidad de items
        $('#span_disponible').html("Registros: " + $('#DISPONIBLE option').length);
        $('#span_asignado').html("Registros: " + $('#ASIGNADO option').length);

        if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
        // Revisar si tengo asignados para habilitar el botón guardar
        if( ($('#TIENDAS option:selected').text() != 'I') ){
            // Se habilita el botóon guardar
            $('.tipo_btn').removeAttr('disabled');
            } else {
            $('.tipo_btn').attr('disabled', 'disabled');
        }
        }

    }, delay);

// Fin comprobar tienda (null y vacio)
}


// Fin onChange TIENDA
});

$(window).on('load', function () {

    //$('.tipo_btn').attr('disabled', 'disabled');

    $('.titulo_mantenedor').empty();
    $('.titulo_mantenedor').append("Mantenedor Tipo Tienda");

// Fijar los tamaños de los ListBox
    $('.ASIGNADO').attr('size', 10);
    $('.DISPONIBLE').attr('size', 10);

// Para los CB de Marcas y Tiendas,seteo el seleccionar por default (SELECCIONE)
    $("#MARCAS").prop('selectedIndex', 0);
    $("#TIENDAS").prop('selectedIndex', 0);

    // Define Tiempo 1 = 1000
    var delay = 4000;
    setTimeout(function () {
        // Cargar los <SPAN> con la cantidad de items
        $('#span_disponible').html("Registros: " + $('#DISPONIBLE option').length);
        $('#span_asignado').html("Registros: " + $('#ASIGNADO option').length);
    }, delay);


    var delay_revisa_internet = 6000;
    var url_existe_internet = 'ajax_simulador_tienda/busca_existe_internet';
    var flag_busca_internet = 0;
    var depto_seleccionado_popup_select_depto_load = $('#select_depto_mant_tipo_tienda_hidden').val();
    setTimeout(function () {

        // Por cada marca que tiene el CBX, pregunto si tiene internet... si no tiene se la agrego
        $("#MARCAS option").each(function () {

            if($(this).text()!='SELECCIONE'){
                //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));

                var val_marca = $(this).attr('value');

                // Voy a preguntar si existe, si no trae datos los agrego
                $.getJSON(url_existe_internet, {MARCA: $(this).attr('value'), TIENDA: 4, DEPTO: depto_seleccionado_popup_select_depto_load}, function (data) {

                    $.each(data, function (i, o) {
                        flag_busca_internet++;
                    });

                    // Si no existe el registro de internet lo agrego
                    if (flag_busca_internet == 0) {
                        // Agregar Internet a los registros
                        var url_agrega_internet = 'ajax_simulador_tienda/agrega_tienda';
                        $.get(url_agrega_internet, {MARCA: val_marca,TIENDA: 4,ASIGNADO: 10039,DEPTO: depto_seleccionado_popup_select_depto_load});
                    }

                });

            }


        });

    }, delay_revisa_internet);




});

// Al cambiar el estado del select, hay que realizar la búsqueda de los ListBox 
$('#MARCAS').on('change', function () {

    cargarListBox();

    // Define Tiempo 1 = 1000
    var delay = 2000;
    setTimeout(function () {
        // Cargar los <SPAN> con la cantidad de items
        $('#span_disponible').html("Registros: " + $('.DISPONIBLE').has('option').length);
        $('#span_seleccionado').html("Registros: " + $('.ASIGNADO').has('option').length);
    }, delay);

});

// Se usa en el onchange #MARCAS
function cargarListBox() {

    // Limpiar ListBox
    $('.DISPONIBLE').empty();
    $('.ASIGNADO').empty();

    var marca_seleccionada = $('#MARCAS').val();
    var tienda_seleccionada = $('#TIENDAS').val();
    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();


    if ( (marca_seleccionada != 'NULL') && (tienda_seleccionada != 'NULL') && (marca_seleccionada != '') && (tienda_seleccionada != '') ) {

        // Define Tiempo 1 = 1000 (revisar,no estaba se agregó luego)
        var delay = 1000;
        setTimeout(function () {
            // Si la tienda es "I" tengo que cargar la tienda internet si o si
            if ($('#TIENDAS option:selected').text() == 'I') {

                // Voy a preguntar si existe, si no trae datos los agrego
                var url_existe_internet = 'ajax_simulador_tienda/busca_existe_internet';
                var flag_busca_internet = 0;
                $.getJSON(url_existe_internet, {MARCA: marca_seleccionada, TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto}, function (data) {

                    $.each(data, function (i, o) {
                        flag_busca_internet++;
                    });

                    // Si no existe el registro de internet lo agrego
                    if (flag_busca_internet == 0) {
                        // Agregar Internet a los registros
                        var url_agrega_internet = 'ajax_simulador_tienda/agrega_tienda';
                        $.get(url_agrega_internet, {MARCA: marca_seleccionada,TIENDA: tienda_seleccionada,ASIGNADO: 10039,DEPTO: depto_seleccionado_popup_select_depto});
                    }

                });
            }
        }, delay);


        // Define Tiempo 1 = 1000
        var delay_list = 2000;
        setTimeout(function () {

            // Carga ListBox disponible
            var url_disponible = 'ajax_simulador_tienda/obtiene_disponible';
            var toAppend_disponible = "";
            $.getJSON(url_disponible, {MARCA: marca_seleccionada, TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto}, function (data) {
                $.each(data, function (i, o) {
                    var data = o.split('#');
                    if(data[0]!=10039) {
                        toAppend_disponible += '<option value=' + data[0] + '>' + data[1] + '</option>';
                    }
                });
                $('.DISPONIBLE').append(toAppend_disponible);
            }).done( function( data ) {

                // Carga ListBox de asignados
                var url_asignado = 'ajax_simulador_tienda/obtiene_asignado';
                var toAppend_asignado = "";
                $.getJSON(url_asignado, {MARCA: marca_seleccionada, TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto}, function (data) {
                    $.each(data, function (i, o) {
                        toAppend_asignado += '<option value=' + o[0] + '>' + o[1] + '</option>';
                    });
                    $('.ASIGNADO').append(toAppend_asignado);
                });

            });

        }, delay_list);





// Si la tienda es internet, bloqueo los dos ListBox junto con botones de accion.

        // Si la tienda es internet no puedo mover entre "Disponible" y "Asignado"
        //if (tienda_seleccionada == 4) {
        if ($('#TIENDAS option:selected').text() == 'I') {
            $(".DISPONIBLE").attr('disabled', 'disabled');
            $(".ASIGNADO").attr('disabled', 'disabled');

            if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
            $('.tipo_btn').attr('disabled', 'disabled');
                $('#btn_replicar_popup_tipo_tienda').attr('disabled', 'disabled');
            $('.agregar').attr('disabled', 'disabled');
            $('.quitar').attr('disabled', 'disabled');
            }


        } else {
            $(".DISPONIBLE").removeAttr('disabled');
            $(".ASIGNADO").removeAttr('disabled');

            if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
            $('.tipo_btn').removeAttr('disabled');
            $('.agregar').removeAttr('disabled');
            $('.quitar').removeAttr('disabled');
            $('#btn_replicar_popup_tipo_tienda').removeAttr('disabled');
        }


        }

        // Define Tiempo 1 = 1000
        var delay = 4000;
        setTimeout(function () {
            // Cargar los <SPAN> con la cantidad de items
            $('#span_disponible').html("Registros: " + $('.DISPONIBLE option').length);
            $('#span_seleccionado').html("Registros: " + $('.ASIGNADO option').length);

            // Revisar si tengo asignados para habilitar el botón guardar
            //if( ($('.ASIGNADO option').length > 0) && ($('#TIENDAS option:selected').text() != 'I') ){
            if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
                if (($('#TIENDAS option:selected').text() != 'I')) {
                // Se habilita el botóon guardar
                $('.tipo_btn').removeAttr('disabled');
                } else {
                $('.tipo_btn').attr('disabled', 'disabled');
            }
            }
        }, delay);

// Fin valucacion de CBX en NULL
    } else {

        if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
        $('.tipo_btn').attr('disabled', 'disabled');
    }
    }


}

$('.tipo_btn').on('click', function () {

    $('#btn_cancelar_replicar_tienda').fadeOut();
    $('#tipo_btn_replicar_tienda').fadeOut();
    $('#tipo_btn').fadeOut();
    $('#btn_cerrar_popup_tienda').fadeOut();
    $('#cerrar_btn_popup_x').fadeOut();
    $('.loading').fadeIn();

    var tipo_guardado = 0;
    var flag_guarda = 0;

    // Revisar si hay mas de dos registros en marcas, si es así conrinuo con el flujo normal
    var cant_reg_marcas = $('#MARCAS option').length;

    // Si llegan dos registros es por que hay solo 1 marca, el otro es el select
    // tipo_guardado = 0; Almacena solo una marca
    // tipo_guardado = 1; Todas las marcas

    if(cant_reg_marcas==2){
        tipo_guardado = 0;
    }else{

        // Preguntar si aplica para todas las tiendas
        var conf_todas_tiendas = confirm("¿Desea Guardar la configuración para todas las marcas?");

        // Si aplica para todas las tiendas
        if (conf_todas_tiendas == true) {
            // Aplica para todas las tiendas
            tipo_guardado = 1;
            // Si no aplica para una tienda
        } else {
            tipo_guardado = 0;
        }

    }

    var marca_seleccionada = $('#MARCAS').val();
    var tienda_seleccionada = $('#TIENDAS').val();
    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();

    //if ($('.ASIGNADO option').length == 0){
    if ( (marca_seleccionada.length <= 0) && (tienda_seleccionada.length<=0)){

        alert("Seleccione Marca y Tipo Tienda.");

        $('#btn_cancelar_replicar_tienda').fadeIn();
        $('#tipo_btn_replicar_tienda').fadeIn();
        $('#tipo_btn').fadeIn();
        $('#btn_cerrar_popup_tienda').fadeIn();
        $('#cerrar_btn_popup_x').fadeIn();
        $('.loading').fadeOut();

    } else {

        // Solo para una tienda seleccionada
        if (tipo_guardado == 0) {
            //alert("Una Tienda");

            // 1.- Almacenar todos los asignados en una variable
            var string_asignados = "";
            $("#ASIGNADO option").each(function () {
                //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));
                string_asignados = string_asignados+','+$(this).attr('value');
            });

            // 1.1.- Quitamos la primera coma de string_asignados
            string_asignados = string_asignados.substring(1);


            // Quitar todos los registros asociados
            var url_quitar = 'ajax_simulador_tienda/quitar_todas_tienda';
            $.get(url_quitar, {MARCA: marca_seleccionada,TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto,STRING_ASIGNADOS:string_asignados}).done( function( data ) {

                $('#btn_cancelar_replicar_tienda').fadeIn();
                $('#tipo_btn_replicar_tienda').fadeIn();
                $('#tipo_btn').fadeIn();
                $('#btn_cerrar_popup_tienda').fadeIn();
                $('#cerrar_btn_popup_x').fadeIn();
                $('.loading').fadeOut();

                // Mensaje para confirmar cambios
                alert("Recuerde revisar que los cambios se realizaron correctamente.");

            });

        // realizo un foreach de cada una de las tiendas que se encuentran en el CBX de
        } else {
            //alert("Todas las Tienda");

            // 1.- Almacenar todos los asignados en una variable
            var string_asignados = "";
            $("#ASIGNADO option").each(function () {
                //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));
                string_asignados = string_asignados+','+$(this).attr('value');
            });

            // 1.1.- Quitamos la primera coma de string_asignados
            string_asignados = string_asignados.substring(1);

            // Por cada una de las marcas del CBX Marca, realizo la misma acción
            var marca_selecc_foreach = "";
            //Foreach para recorrer el CBX de Marca (Antes decia #ASIGNADO)
            $("#MARCAS option").each(function () {

                //marca_selecc_foreach2 = marca_selecc_foreach2 +","+$(this).attr('value');
                // Le asigno el valor de la marca seleccionada
                marca_selecc_foreach = $(this).attr('value');

                // Existe un select que no trae datos (SELECCIONE), hay que validar no incluirlo en el recorrido
                if( (marca_selecc_foreach != null) && (marca_selecc_foreach != "") && (marca_selecc_foreach.length>0)) {

                    // Quitar todos los registros de una vez
                    var url_quitar = 'ajax_simulador_tienda/quitar_todas_tienda';

                    $.get(url_quitar, {MARCA: marca_selecc_foreach,TIENDA: tienda_seleccionada, DEPTO: depto_seleccionado_popup_select_depto,STRING_ASIGNADOS:string_asignados}).done(function(){

                        $('#btn_cancelar_replicar_tienda').fadeIn();
                        $('#tipo_btn_replicar_tienda').fadeIn();
                        $('#tipo_btn').fadeIn();
                        $('#btn_cerrar_popup_tienda').fadeIn();
                        $('#cerrar_btn_popup_x').fadeIn();
                        $('.loading').fadeOut();

                    });

                }// Fin de la validación de

            });

            // Aquí el mensaje luego de terminar de quitar y agregar
            $(document).ajaxStop(function () {

                /*$('#btn_cancelar_replicar_tienda').fadeIn();
                $('#tipo_btn_replicar_tienda').fadeIn();
                $('#tipo_btn').fadeIn();
                $('#btn_cerrar_popup_tienda').fadeIn();
                $('#cerrar_btn_popup_x').fadeIn();
                $('.loading').fadeOut();

                // Mensaje para confirmar cambios
                // alert("Recuerde revisar que los cambios se realizaron correctamente.");*/

                // Mensaje para confirmar cambios
                //alert("Recuerde revisar que los cambios se realizaron correctamente.");

            });


        }// Fin else


    }//Fin del else




});

// Traspasar items desde select izquierda(desde_tienda) hasta select derecha (hasta_tienda)
$('.agregar').on('click', function () {

    var options = $('select.DISPONIBLE option:selected').sort().clone();
    $('select.ASIGNADO').append(options);
    $('select.DISPONIBLE option:selected').remove();

    // Revisar si tengo asignados para habilitar el botón guardar
    /*if( $('.ASIGNADO option').length > 0 ){
        // Se habilita el botóon guardar
        $('.tipo_btn').removeAttr('disabled');
    }else{
        $('.tipo_btn').attr('disabled', 'disabled');
    }*/

    // Define Tiempo 1 = 1000
    var delay = 2000;
    setTimeout(function () {
        // Cargar los <SPAN> con la cantidad de items
        $('#span_disponible').html("Registros: " + $('.DISPONIBLE option').length);
        $('#span_seleccionado').html("Registros: " + $('.ASIGNADO option').length);
    }, delay);

});

// Traspasar items desde select derecha (hasta_tienda) hasta select izquierda(desde_tienda)
$('.quitar').on('click', function () {

    var options = $('select.ASIGNADO option:selected').sort().clone();
    $('select.DISPONIBLE').append(options);
    $('select.ASIGNADO option:selected').remove();

    // Revisar si tengo asignados para habilitar el botón guardar
    /*if( $('.ASIGNADO option').length > 0 ){
        // Se habilita el botóon guardar
        $('.tipo_btn').removeAttr('disabled');
    }else{
        $('.tipo_btn').attr('disabled', 'disabled');
    }*/

    // Define Tiempo 1 = 1000
    var delay = 2000;
    setTimeout(function () {
        // Cargar los <SPAN> con la cantidad de items
        $('#span_disponible').html("Registros: " + $('.DISPONIBLE option').length);
        $('#span_seleccionado').html("Registros: " + $('.ASIGNADO option').length);
    }, delay);

});

// ######################### MANTENEDOR DE REPLICAR #########################
// BTN Cancelar del modal de replicar
$('.btn_cancelar_replicar_tienda').on('click', function () {

    // Cerrar solo el modal seleccionado
    $("#replicarTiendaModal").modal("hide");

});

// BTN Replicar
$('.tipo_btn_replicar_tienda').on('click', function () {



    // Trae el valor de la marca
    var marca_seleccionada = $('#MARCAS').val();
    // Valor del CBX de Temporada
    var temp_replica_selecc = $('#REPLICAR_TIENDA_TEMPORADA').val();
    // Valor del CBX de Departamento
    var depto_replica_selecc = $('.REPLICAR_TIENDA_DEPARTAMENTO').val();
    // Valor del depto seleccionado en la selección de depto
    var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();

    // Si el sistema de trae temporadas a replicar
    if(temp_replica_selecc){

        $('#btn_cancelar_replicar_tienda').fadeOut();
        $('#tipo_btn_replicar_tienda').fadeOut();
        $('#tipo_btn').fadeOut();
        $('#btn_cerrar_popup_tienda').fadeOut();
        $('#cerrar_btn_popup_x').fadeOut();
        $('.loading').fadeIn();

        var r = confirm("¿Proceder con los Cambios?");

        if (r == true) {

            // Validar que seleccione una temporada
            if ($('#REPLICAR_TIENDA_TEMPORADA option').length == 0){
                alert("No existe temporada seleccionada.");
            } else {

                // Carga el select oculto (este select es el que utiliza para cargar los nuevos registros)
                var url_listar_replica_tienda_temp = 'ajax_simulador_tienda/listar_carga_temporada';
                var url_agrega_replica_tienda_temp = 'ajax_simulador_tienda/agrega_carga_temporada';

                var flag_enc_temp_anterior = 0;

                // Quitar los registros
                var url_quitar = 'ajax_simulador_tienda/quitar_carga_temporada';
                $.get(url_quitar, {TEMPORADA: temp_replica_selecc, DEPARTAMENTO: depto_replica_selecc, DEPTO: depto_seleccionado_popup_select_depto, MARCA:marca_seleccionada}).done( function( data ) {

                    $('#btn_cancelar_replicar_tienda').fadeIn();
                    $('#tipo_btn_replicar_tienda').fadeIn();
                    $('#tipo_btn').fadeIn();
                    $('#btn_cerrar_popup_tienda').fadeIn();
                    $('#cerrar_btn_popup_x').fadeIn();
                    $('.loading').fadeOut();

                    alert("Recuerde revisar que los cambios se realizaron correctamente. ");

                    $('#replicarTiendaModal').modal('toggle');

                // Fin quitar los registros y insert/select por procedimiento
                } );

            } // Fin del else de verificación

    // Fin del else del confirm
        } else {

            $('#btn_cancelar_replicar_tienda').fadeIn();
            $('#tipo_btn_replicar_tienda').fadeIn();
            $('#tipo_btn').fadeIn();
            $('#btn_cerrar_popup_tienda').fadeIn();
            $('#cerrar_btn_popup_x').fadeIn();
            $('.loading').fadeOut();

            alert("No se han realizado cambios.");

        }

    }else{

        $('#btn_cancelar_replicar_tienda').fadeIn();
        $('#tipo_btn_replicar_tienda').fadeIn();
        $('#tipo_btn').fadeIn();
        $('#btn_cerrar_popup_tienda').fadeIn();
        $('#cerrar_btn_popup_x').fadeIn();
        $('.loading').fadeOut();

        $('#MARCAS option:contains("SELECCIONE")')
        $('#TIENDAS option:contains("SELECCIONE")')

        alert("No existen temporadas a replicar.");
    }

});

// BTN para levantar el popup de replicar tienda
$('#btn_replicar_popup_tipo_tienda').on('click', function () {

    // Trae el valor de la marca
    var marca_seleccionada = $('#MARCAS').val();

    if( (marca_seleccionada != null) && (marca_seleccionada != '') && (marca_seleccionada.length > 0) ){

        // Cerrar solo el modal seleccionado
        $("#replicarTiendaModal").modal("show");

        // Limpiar CBX
        $('#REPLICAR_TIENDA_TEMPORADA').empty();

        // Valor del depto seleccionado en la selección de depto
        var depto_seleccionado_popup_select_depto = $('#select_depto_mant_tipo_tienda_hidden').val();

        // Cargar CBX con temporadas
        var url_depto_replica = 'ajax_simulador_tienda/replicar_tienda';
        var toAppend_depto_replica_cbx = "";
        $.getJSON(url_depto_replica, {MARCA: marca_seleccionada,DEPTO: depto_seleccionado_popup_select_depto}, function (data) {
            $.each(data, function (i, o) {
                    toAppend_depto_replica_cbx += '<option value=' + o[0] + '>' + o[1] + '</option>';
            });
            $('#REPLICAR_TIENDA_TEMPORADA').append(toAppend_depto_replica_cbx);
        });

    }else{
        alert("Seleccione una Marca.");
    }



// Fin btn_replicar_popup_tipo_tienda
});
