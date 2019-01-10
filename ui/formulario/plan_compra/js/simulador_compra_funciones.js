$(function () {

    // #############################################################################################
    // ################################## AQUÍ VAN FUNCIONES JS ####################################
    // ############### MANTENER FORMATO DE NOMBRES EN JS - CONTROLADOR - CLASE  ####################
    // ################################### Formato: CamelCase ######################################

    if(localStorage.getItem("M-TIENDA")==0){

        // Verificar Permisos
        if(localStorage.getItem("T0016")){

            $("#poptienda_tipotienda").hide();
            $("#poptienda_asignacion").hide();
            $("#poptienda_btns").hide();
            $("#btn_replica_temporada_tienda").hide();

            // Levantamos el popup
            var POPUPTiendaValidado = $("#POPUP_tienda");
            POPUPTiendaValidado.data("kendoWindow").open();

        }else{
            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Necesitas Configurar Tiendas... Pero Necesitas Permisos.", "error");
            // Fin Verificar Permisos
        }

    }


    if( (localStorage.getItem("P-COSTO")==0) || (localStorage.getItem("P-RETAIL")==0) || (localStorage.getItem("P-EMBARQUE")!=9) ){

        // Verificar Permisos
        if(localStorage.getItem("T0016")){

            var popupPreTotalValidado = $("#POPUP_presupuestos_total");
            popupPreTotalValidado.data("kendoWindow").open();

        }else{
            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Necesitas Configurar Presupuestos... Pero Necesitas Permisos.", "error");
            // Fin Verificar Permisos
        }

    }


// Fin del JS
});
