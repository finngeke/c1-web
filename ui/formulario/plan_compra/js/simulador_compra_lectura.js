$(function () {

    //######################################## BUSCA CONCURRENCIA ########################################

    // Revisar Concurrencia para Verificar Permisos de Usuarios
    $.ajax({
        url: "TelerikPlanCompra/RevisaConcurrencia",
        success: function (result) {

            var popupModoIngreso = $("#popupNotification").kendoNotification().data("kendoNotification");

            //var arregloPermisosUsuarios = [];
            var TipoPermisos = JSON.parse(result);

            // Existe ya alguien en el departamento (No es Administrador)
            if( TipoPermisos.length > 0 ){

                // Limpiar el Local Storage
                localStorage.clear();

                $.each( TipoPermisos, function(i, obj) {
                    // Avisar Modo Lectura
                    popupModoIngreso.getNotifications().parent().remove();
                    popupModoIngreso.show(" Modo Lectura. " + obj.NOMBRE + " ya se encuentra en este Depto. ", "info");
                });

            }else{
                // Avisar Modo Escritura
                popupModoIngreso.getNotifications().parent().remove();
                popupModoIngreso.show(" Modo Escritura. ", "success");
            }


        },
        error: function (xhr, httpStatusMessage, customErrorMessage) {
            console.log("Detalle Error: ".xhr.responseText+" / "+httpStatusMessage+" / "+customErrorMessage);
        }
    });




// Fin del document ready
});
