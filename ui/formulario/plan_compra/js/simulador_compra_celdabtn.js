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


    // ############################ CAMBIO DE ESTADO ############################

    // Le da la estructura a la ventana POPUP
    var ventana_cambio_estado = $("#POPUP_cambio_estado");
    ventana_cambio_estado.kendoWindow({
        width: "360px",
        title: "Cambio de Estado",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]
    }).data("kendoWindow").center();

    // Revisamos el cambio de selección en el CBX
    function verificaCambioEstadoCBX(){
        var cbxCambioEstado = $("#NuevoEstadoPopUp").val();

        // <option value="0">Crear Modificación</option>
        // <option value="1">Solicitud Corrección PI</option>
        // <option value="2">Eliminar Opción</option>

        if(cbxCambioEstado==1){
            $("#comentSolicitaCorreccionPILI").css("display","");
        }else{
            $("#comentSolicitaCorreccionPILI").css("display","none");
        }

    }

    // Estructura CXB
    $("#NuevoEstadoPopUp").kendoDropDownList({
        change : verificaCambioEstadoCBX
    });

    // Estructura Campo Texto
    $("#comentSolicitaCorreccionPI").kendoEditor({
        tools: []
    });

    // BTN que Genera el Cambio de Estado
    $("#btn_genera_cambio_estado").on('click', function () {

        var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

        var respuesta = confirm("¿Quiere realizar los cambios?");

        if (respuesta == true) {

            var url_cambio_estado = 'TelerikPlanCompra/ModificaEstadoDinamico';
            var url_cambio_estado_coreccion = 'TelerikPlanCompra/ModificaEstadoDinamicoCorreccion';

            // Seteo Variables
            var ID_COLOR3 = "";
            var PROFORMA = "";
            var ESTADOC1 = "";

            // Obterer las celdas seleccionadas
            var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet = spreadsheet_id_color3.activeSheet();
            var range = sheet.selection();

            // Traigo el Valor del CBX
            var cbxCambioEstadoSeleccionado = $("#NuevoEstadoPopUp").val();
            // Traigo el Valor eel Comentario
            var comentarioEstadoSeleccionado = $("#comentSolicitaCorreccionPI").val();

            range.forEachCell(function (row, column, value) {

                var fila_id = row+1;
                var range_color3 = sheet.range("A"+fila_id);
                ID_COLOR3 = range_color3.values();
                var range_proforma = sheet.range("CD"+fila_id);
                PROFORMA = range_proforma.values();
                var range_oc = sheet.range("CH"+fila_id);
                OC = range_oc.values();
                var range_estadoc1 = sheet.range("CP"+fila_id);
                ESTADOC1 = range_estadoc1.values();

                // Crear Modificación
                if(cbxCambioEstadoSeleccionado == 0){

                    // estado_c1 != 24 && Proforma
                    if( (ESTADOC1!=24) && (PROFORMA.length>0) ){

                        //$.getJSON(url_cambio_estado, {ID_COLOR3: ID_COLOR3, ESTADO_INSERT: 0, PROFORMA: PROFORMA, ESTADO_UPDATE: 3});

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado,
                            data: {ID_COLOR3: kendo.parseInt(ID_COLOR3), ESTADO_INSERT: kendo.parseInt(0), PROFORMA: String(PROFORMA), ESTADO_UPDATE: kendo.parseInt(3)},
                            // contentType: "application/json",
                            dataType: "json"
                        });


                    }else{

                        // Descripción - Color
                        // Agregar al arreglo de errores

                    }


                // Solicitud Corrección PI
                }else if(cbxCambioEstadoSeleccionado == 1){

                    // estado_c1 == 18
                    if( ESTADOC1==18){

                        // $.getJSON(url_cambio_estado_coreccion, {ID_COLOR3: ID_COLOR3, ESTADO_INSERT: 23, PROFORMA: PROFORMA, ESTADO_UPDATE: 5, COMENTARIO: comentarioEstadoSeleccionado});

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado_coreccion,
                            data: {ID_COLOR3: kendo.parseInt(ID_COLOR3), ESTADO_INSERT: kendo.parseInt(24), PROFORMA: String(PROFORMA), ESTADO_UPDATE: kendo.parseInt(4), COMENTARIO: String(comentarioEstadoSeleccionado)},
                            // contentType: "application/json",
                            dataType: "json"
                        });

                    }else{

                        // Descripción - Color
                        // Agregar al arreglo de errores

                    }


                 // Eliminar Opción
                }else if(cbxCambioEstadoSeleccionado == 2){

                    // estado_c1 != 21 && Proforma
                    if( (ESTADOC1!=21) && (PROFORMA.length>0) ){

                        // $.getJSON(url_cambio_estado, {ID_COLOR3: ID_COLOR3, ESTADO_INSERT: 24, PROFORMA: PROFORMA, ESTADO_UPDATE: 4});

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado,
                            data: {ID_COLOR3: kendo.parseInt(ID_COLOR3), ESTADO_INSERT: kendo.parseInt(24), PROFORMA: String(PROFORMA), ESTADO_UPDATE: kendo.parseInt(4)},
                            // contentType: "application/json",
                            dataType: "json"
                        });

                    }else{

                        // Descripción - Color
                        // Agregar al arreglo de errores

                    }

                }


            });

            // Al Finalizar los cambios de estado
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Favor de Revisar los Estados.", "info");

        // Si el usuario no acepta realizar cambios
        } else {
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No se han realizado Cambios de Estado.", "info");
        }









    });








// Fin de la función
});
