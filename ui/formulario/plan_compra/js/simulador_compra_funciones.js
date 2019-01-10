$(function () {

    // #############################################################################################
    // ################################## AQUÍ VAN FUNCIONES JS ####################################
    // ############### MANTENER FORMATO DE NOMBRES EN JS - CONTROLADOR - CLASE  ####################
    // ################################### Formato: CamelCase ######################################

    if(localStorage.getItem("M-TIENDA")==0){
            // Levantamos el popup
            var POPUPTiendaValidado = $("#POPUP_tienda");
            POPUPTiendaValidado.data("kendoWindow").open();
    }


    if( (localStorage.getItem("P-COSTO")==0) || (localStorage.getItem("P-RETAIL")==0) || (localStorage.getItem("P-EMBARQUE")!=9) ){
            var popupPreTotalValidado = $("#POPUP_presupuestos_total");
            popupPreTotalValidado.data("kendoWindow").open();
    }


// Fin del JS
});
