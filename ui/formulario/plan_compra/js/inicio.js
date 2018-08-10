/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Roberto Pérez (tienda, formato, curva)
 */



$(window).on('load', function () {
    "use strict";
    $('.tipo_deptomarca').on('click', function () {
        $('#selecciona_popup_deptomarca').modal('show');
    });

// fin de onload
});


// Botón OnClick
$('#tcrc_opcion3_link').on('click', function () {

    //"use strict";
    var flag_tiene_factor_estimado = 0;
    var flag_tiene_tipo_cambio = 0;
    var flag_tiene_fecha_recepcion = 0;

    // Aquí validar si hay registros en factor estimado
    var url_verifica_factor_estiamdo = 'ajax_factorestimado/conteo_factor_estimado';
    $.getJSON(url_verifica_factor_estiamdo, function (data) {
        $.each(data, function (i, o) {
            flag_tiene_factor_estimado = o[0];
        });
    // Fin de verificar factor estimado
    }).done( function() {

        // Aquí validar si hay registros en tipo cambio
        var flag_tiene_tipo_cambio = 'ajax_factorestimado/conteo_tipo_cambio';
        $.getJSON(flag_tiene_tipo_cambio, function (data) {
            $.each(data, function (i, o) {
                flag_tiene_tipo_cambio = o[0];
            });
        // Fin de verificar tipo cambio
        }).done( function() {

            // Aquí validar si existe Fecha Recepción
            var url_verifica_fecha_recepcion = 'ajax_temporada_fecha_recepcion/contarRegistros';
            $.getJSON(url_verifica_fecha_recepcion, function (data) {
                $.each(data, function (i, o) {
                    flag_tiene_fecha_recepcion = o[0];
                });
                // Fin de verificar Fecha Recepción
            }).done( function(  ) {

                // Si existe Factor Estimado y Fecha Recepción (Levantar PopUp)
                if( ((flag_tiene_factor_estimado+flag_tiene_tipo_cambio)>0) && (flag_tiene_fecha_recepcion=9)){
                    window.location.href = "selecion_depto";
                }else{
                    alert("Verifique que existan datos en Factor Estimado (Factor Estimado o Tipo Cambio) y Fecha Recepción (Todas las Ventanas).");
                }

            } );

        });

    });



});










