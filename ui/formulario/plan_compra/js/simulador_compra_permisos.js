$(function () {

    //######################################## BUSCA PERMISOS ########################################

    $.ajax({
        url: "TelerikPlanCompra/ListarPermisosUsuario",
        //type: "POST",
        //dataType: "json",
        success: function (result) {

            // Limpiar el Local Storage
            // localStorage.clear();
            // Limpiar el Session Storage
            // sessionStorage.removeItem('RECARGAGRILLA');

            //var arregloPermisosUsuarios = [];
            var PermisosUsuario = JSON.parse(result);
            $.each( PermisosUsuario, function(i, obj) {
                localStorage.setItem(obj.ID_TELERIK, obj.NOMBRE_ACCION);
                //arregloPermisosUsuarios.push( {ID_TELERIK: obj.ID_TELERIK} );
            });

        },
        error: function (xhr, httpStatusMessage, customErrorMessage) {
            // Limpiar el Local Storage
            //localStorage.clear();
            //console.log("Detalle Error: ".xhr.responseText+" / "+httpStatusMessage+" / "+customErrorMessage);
        }
    });


// Fin del document ready
});
