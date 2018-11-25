$(function () {

    // #############################################################################################
    // ################################# AQUÍ NO VAN ACCIONES JS ###################################
    // ################## AQUÍ SE DEFINE SOLO LA ESTRUCTURA DE POPUPS/BOTONES ######################
    // ################################### SÓLO CODIGO TELERIK #####################################



    // ############################ CARGA ARCHIVO PI ############################

    // Asigno el nombre que debe tener el archivo a subir
    function AntesCargaArchivoPI(e) {
        e.data = {
            NombreArchivoProforma: $("#NombrePI").val()
        };
    }

    // Setea el campo input para la carga de PI
    $("#txt_archivo_pi").kendoUpload({
        async: {
            saveUrl: "TelerikGuardar/GuardaArhcivoPI",
            autoUpload: true,
            saveField: "JSONGuardaArhcivoPI"
            /*,removeUrl: "TelerikGuardar/QuitarArhcivoPI"*/
        },validation: {
            allowedExtensions: [".xlsx",".XLSX",".xls",".xlsx"],
            maxFileSize: 30000000
        },
        upload: AntesCargaArchivoPI,
        complete: function () {
            //$(".k-widget.k-upload").find("ul").remove();
        },
        success: function () {

            // Avisar que el archivo se subió
            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");
            popupNotification.show(" El archivo asociado a la Proforma: "+$("#NombrePI").val()+" fue guardado.", "success");

            /*var file0Uid = e.files[0].uid;
            $(".k-file[data-uid='" + file0Uid + "']").find(".k-file-name").text("New Filename");*/

            // Hay que buscar en la grilla, sobre escribir la PI


        }

    });

    // Le da la estructura a la ventana POPUP
    var ventana_carga_pi = $("#POPUP_carga_archivo_pi");
    ventana_carga_pi.kendoWindow({
        width: "360px",
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
                    FECHA: {type: "string"},
                    HORA: {type: "string"},
                    USUARIO: {type: "string"},
                    ESTADO: {type: "string"}
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
