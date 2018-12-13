$(function () {

    //######################################## BUSCA CONCURRENCIA ########################################

    $.ajax({
        url: "TelerikPlanCompra/RevisaConcurrencia",
        success: function (result) {

            // Limpiar el Local Storage
            localStorage.clear();

            //var arregloPermisosUsuarios = [];
            var PermisosUsuario = JSON.parse(result);
            $.each( PermisosUsuario, function(i, obj) {
                localStorage.setItem(obj.ID_TELERIK, obj.NOMBRE_ACCION);
                //arregloPermisosUsuarios.push( {ID_TELERIK: obj.ID_TELERIK} );
            });


        },
        error: function (xhr, httpStatusMessage, customErrorMessage) {
            console.log("Detalle Error: ".xhr.responseText+" / "+httpStatusMessage+" / "+customErrorMessage);
        }
    });


// Fin del document ready
});
