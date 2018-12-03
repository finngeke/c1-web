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
            allowedExtensions: [".xlsx",".XLSX",".xls",".XLS"],
            maxFileSize: 30000000
        },
        upload: AntesCargaArchivoPI,
        complete: function () {

            //$(".k-widget.k-upload").find("ul").remove();

            // Obtengo el nombre de la PI que estoy cargando
            var proforma = $("#NombrePI").val();

            // Calcular Totales en el grilla y rango de datos
            var spreadsheet_carga_pi = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet_carga_pi = spreadsheet_carga_pi.activeSheet();
            var data_conteo_total = sheet_carga_pi.toJSON();
            var total_registros_listados = data_conteo_total.rows.length;

            var range_carga_pi = sheet_carga_pi.range("CD1:CD"+total_registros_listados);

            // Recorre la Grilla y con la PROFORMA que me llega asignar el texto "Cargado.." a las filas que coincidan.
            range_carga_pi.forEachCell(function (row, column, value) {
                if(sheet_carga_pi.range("CD"+row).value() == proforma){
                    sheet_carga_pi.range("CE"+row).value("Cargado..");
                }
            // Fin del Recorrer la Grilla
            });

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
    $("#grid_popup_historial").kendoGrid({
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


    // ############################ MATCH ############################

    function cerrarPopUpMATCH(){
        location.reload();
    }

    // Le da la estructura a la ventana POPUP
    var ventana_match = $("#POPUP_match");
    ventana_match.kendoWindow({
        width: "750px",
        height: "350px",
        title: "Match",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ],
        close: cerrarPopUpMATCH
    }).data("kendoWindow").center();

    // Le da la estructura a la grilla pmm
    $("#grid_match_pmm").kendoGrid({
        schema: {
            model: {
                fields: {
                    ID: {type: "number"},
                    PI: {type: "string"},
                    USUARIO: {type: "string"},
                    ESTADO: {type: "string"}
                }
            }
        },
        height: 300,
        sortable: true
    });


    // Le da la estructura a la grilla plan
    $("#grid_match_plan").kendoGrid({
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









});
