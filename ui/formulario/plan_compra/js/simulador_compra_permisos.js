$(function () {

    //######################################## BUSCA PERMISOS ########################################

    $.ajax({
        url: "TelerikPlanCompra/ListarPermisosUsuario",
        //type: "POST",
        //dataType: "json",
        success: function (result) {

            /*var arregloPermisosUsuarios = [];
            $.each(result, function (i, a) {
                alert(a['ID_ACCION']);
                //arregloPermisosUsuarios.push( {ID_ACCION: a[0]} );
            });*/

            //console.log(arregloPermisosUsuarios);

            /*var algo =  $.grep(arregloPermisosUsuarios, function (e) {
                return e.ID_ACCION == 79;
            });
            alert(algo);*/

            // Limpiar el localStorage
            /*localStorage.clear();
            // Agregar al localStorage
            localStorage.setItem("PermisosUsuario", JSON.stringify(result));
            // sessionStorage.setItem("jsonData", JSON.stringify(result));
            var PermisosUsuario = JSON.parse(localStorage.getItem("PermisosUsuario"));*/


            // Limpiar el Local Storage
            localStorage.clear();

            //var arregloPermisosUsuarios = [];
            var PermisosUsuario = JSON.parse(result);
            $.each( PermisosUsuario, function(i, obj) {
                //localStorage.setItem(obj.NOMBRE_ACCION, obj.ID_ACCION);
                localStorage.setItem(obj.ID_ACCION, obj.ID_ACCION);
                //arregloPermisosUsuarios.push( {ID_ACCION: obj.ID_ACCION} );
            });


        },
        error: function (xhr, httpStatusMessage, customErrorMessage) {
            console.log(xhr.responseText+" / "+httpStatusMessage+" / "+customErrorMessage);
        }
    });


// Fin del document ready
});
