/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 */

$(function () {


    /*ABRE POPUP MODAL PERFIL*/
    $('.eliminar_perfil').on('click', function () {
        $('.registro').html('<b> ' + $('.combo_perfil').find('option:selected').text() + ' </b>');
    });

    /*ABRE POPUP MODAL USUARIOS*/
    $('.eliminar_usuario').on('click', function () {
       // alert($("#factor").val());
        //$('.registro').html('<b> ' + $("#factor").val() + ' </b>');
        $('.registro').html('<b> ' + $(".DEPARTAMENTO option:selected").text() + ' - ' +
                $(".PAIS option:selected").text() + ' - ' +
                $(".VIA option:selected").text() + ' - ' +
                $(".TIPO_MONEDA option:selected").text() + ' - ' +
                $('#FACTOR_DOL').val() + ' </b>');

    });

    $('.limpiar_form').on('click', function () {
        $('#lista_funcionarios .filas').each(function () {
            $(this).removeClass("tabla_selecciona");
            $(this).find('input').prop("checked", false);
            //$('.eliminar_usuario').addClass("disabled");
            //$('#usuario').removeAttr("disabled");

            $('#login').val("");
            $('#usuario').val("");
            $('#nombre').val("");
            $('#clave').val("");
            $('#correo').val("");
        });
    });

    /*AJAX DE CREACION PERFIL*/
    $('.crea_perfil').on('click', function () {

        url = 'ajax_funcionario/agrega_perfil';
        $.get(url, {perfil: $(".nuevo_perfil").val()}, function (data) {
            var mensaje = data.split("-");
            notificacionNavegador(mensaje[0], mensaje[1]);
            location.reload();
        });
    });

    /*AJAX DE ELIMINACION PERFIL*/
    $('.elimina_perfil').on('click', function () {
        url = 'ajax_funcionario/elimina_perfil';
        $.get(url, {perfil: $(".COMBO_PERFIL option:selected").val()}, function (data) {
            var mensaje = data.split("-");
            notificacionNavegador(mensaje[0], mensaje[1]);
            location.reload();
        });
    });

    //AJAX BTN ELIMINAR
    $('.elimina_factor').on('click', function () {

        url = 'ajax_factorestimado/elimina_Factor';
        $.get(url, {factor: $(".DEPARTAMENTO option:selected").val() + "$" +
                    $(".PAIS option:selected").val() + "$" +
                    $(".VIA option:selected").val() + "$" +
                    $(".TIPO_MONEDA option:selected").val()}, function (data) {
            var mensaje = data.split("-");
            notificacionNavegador(mensaje[0], mensaje[1]);
            location.reload();
        });

    });

  //  $('.replica_factor').on('click', function () {
   //     alert("a");
   //     url = 'ajax_factorestimado/elimina_Factor';
        //$.get(url, {factor: $(".DEPARTAMENTO option:selected").val()+"$"+
        //                    $(".PAIS option:selected").val()+"$"+
        //                    $(".VIA option:selected").val()+"$"+
        //                    $(".TIPO_MONEDA option:selected").val()}, function (data) {
        //  var mensaje = data.split("-");
        //    notificacionNavegador(mensaje[0], mensaje[1]);
        //    location.reload();
        //});
   // });

    //combox
    $('.LIS_TEMPO').on('change', function () {

        $('.list_factores tbody').append('<tr class="filas" role="row">');
        url = 'ajax_factorestimado/List_factor_replicar';

        $('.list_factores tbody').empty();
        $.getJSON(url, {tempo: $(this).val()}, function (data) {
            var filas = '';
            var factor = '';
            if (data.length >= 1) {
                $.each(data, function (key, value) {
                    $(".guarda_replicar").removeAttr("disabled");//habilita el btn guardar
                    if (value['FACTOR_DOL'] < 1) {
                        factor = '0' + value['FACTOR_DOL'];
                    } else {
                        factor = value['FACTOR_DOL'];
                    }
                    filas += '<tr class="filas odd" role="row">';
                    filas += '<th class="filas comuna_especial text-center" role="row">' + value['DEP_DESCRIPCION'] + '</th>';
                    filas += '<th class="filas comuna_especial text-center" role="row">' + value['NOM_PAIS'] + '</th>';
                    filas += '<th class="filas comuna_especial text-center" role="row">' + value['NOM_VIA'] + '</th>';
                    filas += '<th class="filas comuna_especial text-center" role="row">' + value['NOM_MONEDA'] + '</th>';
                    filas += '<th class="filas comuna_especial text-center" role="row">' + factor + '</th></tr>';
                });
            } else {
                $(".guarda_replicar").attr("disabled");//desahibitar el btn guardar
                filas += '<tr class="filas odd" role="row" style="color: red;">';
                filas += '<th class="filas comuna_especial"  role="row"  colspan="5">No se encuentran datos...</th></tr>';
            }
            $('.list_factores tbody').append(filas);
            //  var mensaje = data.split("-");
            //    notificacionNavegador(mensaje[0], mensaje[1]);
            //    location.reload();
        });
    });

    $('.guarda_replicar').on('click', function () {

        url = 'ajax_factorestimado/guardarReplicar';
        $.get(url, {temporada: $(".LIS_TEMPO option:selected").val() }, function (data) {        
           
          var mensaje = data.split("-");
            notificacionNavegador(mensaje[0], mensaje[1]);
          location.reload();
        });
        
            
    });


});


$(document).ready(function () {

    $('#lista_funcionarios').DataTable({
        paging: false
    });

    $("form.form_tipo_cambio").submit(function (event) {//mensaje guardar
        notificacionNavegador("Control de Cambios", "Se realizo un cambio en BD...");
    });

    $("form.form_factor_Estimado").submit(function (event) {//mensaje guardar
        notificacionNavegador("Control de Cambios", "Se realizo un cambio en BD...");
    });

});



$(window).on('load', function () {

    $('.tipo_deptomarca').on('click', function () {
        $('#selecciona_popup_deptomarca').modal('show');
    });

    $('input.fila').change(function () {

        //selecion en la grilla
        $('#lista_funcionarios tr.filas').each(function () {

            $(this).removeClass("tabla_selecciona");
            $(this).find('th.comuna_especial1').addClass('comuna_especial');
        });

        $(this).parent().parent().addClass("tabla_selecciona");
        $(this).parent().parent().find('th.comuna_especial').removeClass('comuna_especial').addClass('comuna_especial1');

        var cuerpo = $(this).parent().parent().data("factorest").split("$");// rescata los codigo grilla los trasforma una clase 
        $('.eliminar_usuario').removeClass("disabled");
        $('#usuario').prop("disabled", true);
        // alert($(this).parent().parent().data("factorest"));

        $('#factor').val($(this).parent().parent().data("factorest"));
        ////llama id o name de combox o textbox HTML (ID ES (#) Y CLASE CON  (.))
        $('.DEPARTAMENTO').val(cuerpo[0]);
        $('.PAIS').val(cuerpo[1]);
        $('.via').val(cuerpo[2]);
        $('.tipo_moneda').val(cuerpo[3]);
        $('#FACTOR_DOL').val(cuerpo[4]);
    });

});




