$(function () {

    // #############################################################################################
    // ################################## AQUÍ VAN ACCIONES JS #####################################
    // ################## AQUÍ SE DEFINE SOLO LA ESTRUCTURA DE POPUPS/BOTONES ######################
    // ################################### SÓLO CODIGO TELERIK #####################################

    // Actualiza Fecha de Concurrencia
    function act_fecha_concurrencia() {

        var url_act_fecha_concurrencia = 'TelerikPlanCompra/actualiza_fecha_concurrencia';

        $.ajax({
            type: "GET",
            url: url_act_fecha_concurrencia,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function () {
                // Acción al Ejecutarse correctamente
                console.log("Se Actualiza Fecha de Concurrencia");
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus + " errorThrown: " + errorThrown);
            }
        }).done(function () {
            console.log("Se realiza solicitud de Actualización de Fecha en Concurrencia");
        });

    }




// Fin del JS
});
