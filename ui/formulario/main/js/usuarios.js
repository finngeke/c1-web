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
        $('.registro').html('<b> ' + $("#login").val() + ' </b>');
    });

    $('.limpiar_form').on('click', function () {
        $('#lista_funcionarios .filas').each(function () {
            $(this).removeClass("tabla_selecciona");
            $(this).find('input').prop("checked", false);
            $('.eliminar_usuario').addClass("disabled");
            $('#usuario').removeAttr("disabled");
            $('#login').val("");
            $('#usuario').val("");
            $('#nombre').val("");
            $('#clave').val("");
            $('#correo').val("");
            $('.combo_perfil').val(1);
            /* al limpiar se restablece al primer lugar*/
        });
    });
    /*AJAX DE CREACION PERFIL*/
    $('.crea_perfil').on('click', function () {

        
        /*se valida si el campo de nuevo perfil esta vacio*/
        if ($("#nuevo_perfil").val() != "") {
        var url = 'ajax_funcionario/agrega_perfil';
        $.get(url, {perfil: $(".nuevo_perfil").val()}, function (data) {
            var mensaje = data.split("-");
            notificacionNavegador(mensaje[0], mensaje[1]);
            location.reload();
        });
        }else {
            /*advertencias y salida*/
            alert ("Debe ingresar un perfil");
            alert ("No se realizan Cambios");
        }
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
    /*AJAX DE ELIMINACION USUARIO*/
    $('.elimina_usuario').on('click', function () {
        url = 'ajax_funcionario/elimina_usuario';
        $.get(url, {usuario: $("#login").val()}, function (data) {
            var mensaje = data.split("-");
            notificacionNavegador(mensaje[0], mensaje[1]);
            location.reload();
        });
    });
});


$(document).ready(function () {
    /*ENVIO DE FORMULARIO*/
    $("form").submit(function (event) {
        notificacionNavegador("Control de Cambios", "Se realizo un cambio en BD...");
    });
    $('#lista_funcionarios').DataTable({
        paging: false
    });

});



$(window).on('load', function () {

    $('input.fila').change(function () {

        $('#lista_funcionarios tr.filas').each(function () {
            $(this).removeClass("tabla_selecciona");
        });
        $(this).parent().parent().addClass("tabla_selecciona");
        var cuerpo = $(this).parent().parent().data("funcionario").split("$");
        $('.eliminar_usuario').removeClass("disabled");
        $('#usuario').prop("disabled", true);
        $('#login').val(cuerpo[0]);
        $('#usuario').val(cuerpo[0]);
        $('#nombre').val(cuerpo[1]);
        $('#correo').val(cuerpo[2]);
            $('.combo_perfil').val(cuerpo[3]);
        $('#clave').val(cuerpo[4]);

            /*usa la variable hidden para cambiar el listobox*/
    });

});


$('#clave').on('mouseenter',function(){
    clave.type = "text";
});

$('#clave').on('mouseleave',function () {
   clave.type ="password";
});

// Botón OnClick
$('#inicio_popup_temporada').on('click', function () {

    // Desplegar Modal
    $('#selecciona_temporada').modal('show');

});