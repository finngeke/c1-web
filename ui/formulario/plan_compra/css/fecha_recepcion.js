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
    });

});




