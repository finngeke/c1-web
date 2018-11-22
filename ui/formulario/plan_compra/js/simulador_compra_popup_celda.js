$(function () {


    // ############################ CARGA ARCHIVO PI ############################

    // Setea el campo input para la carga de PI
    $("#txt_archivo_pi").kendoUpload();

    // Le da la estructura a la ventana POPUP
    var ventana_carga_pi = $("#POPUP_carga_archivo_pi");
    ventana_carga_pi.kendoWindow({
        width: "300px",
        title: "Cargar Archivo PI",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();


    // ############################ HISTORIAL ############################

    // Le da la estructura a la ventana POPUP
    var ventana_historial = $("#POPUP_historial");
    ventana_historial.kendoWindow({
        width: "550px",
        height: "320px",
        title: "Historial",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();

    // Le da la estructura a la grilla
    $("#POPUP_historial").kendoGrid({
        schema: {
            model: {
                fields: {
                    FECHA: { type: "string" },
                    HORA: { type: "string" },
                    USUARIO: { type: "string" },
                    ESTADO: { type: "string" }
                }
            }
        },
        height: 300,
        sortable: true
    });



    // ############################ AJUSTE COMPRA ############################

    // Le da la estructura a la ventana POPUP
    var ventana_ajuste_compra = $("#POPUP_ajuste_compra");
    ventana_ajuste_compra.kendoWindow({
        width: "500px",
        title: "Ajuste Compra",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();



    // ############################ AJUSTE N CAJAS ############################

    // Le da la estructura a la ventana POPUP
    var ventana_ajuste_cajas = $("#POPUP_ajuste_cajas");
    ventana_ajuste_cajas.kendoWindow({
        width: "500px",
        title: "Ajuste N° Cajas",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();


    // ############################ DETALLE ERROR ############################

    // Le da la estructura a la ventana POPUP
    var ventana_detalle_error = $("#POPUP_detalle_error");
    ventana_detalle_error.kendoWindow({
        width: "500px",
        title: "Motivo - Solicitud de Modificación",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();


});
