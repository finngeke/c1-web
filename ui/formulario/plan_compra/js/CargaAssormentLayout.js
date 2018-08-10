/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 * @Editado Roberto Pérez (tienda, formato, curva, simulador de compra, match)
 */

// Document Ready
$(function () {

    //"use strict";
    /*ABRE POPUP MODAL PERFIL*/
    $('.eliminar_bmt').on('click', function () {
        $('.registro').html('<b> ' + $('.bmt').html() + ' </b>');
    });

    $('.actualiza_grid').on('click', function () {
        location.reload();
    });

    $('.carga_bmt').on('click', function () {
            $('.loading').fadeIn();
            $('.pull-left').remove();
            $('.carga_bmt').remove();
            $('.close').remove();
            $('.form_import_bmt').submit();
        //}

    });




// Load
$(window).on('load', function () {


// fin de onload
});

});