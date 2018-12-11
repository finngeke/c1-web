$(function () {

    // #############################################################################################
    // ################################# AQUÍ NO VAN ACCIONES JS ###################################
    // ################## AQUÍ SE DEFINE SOLO LA ESTRUCTURA DE POPUPS/BOTONES ######################
    // ################################### SÓLO CODIGO TELERIK #####################################



    // ############################ CARGA ARCHIVO PI ############################

    // Asigno el nombre que debe tener el archivo a subir
    function AntesCargaArchivoPI(e) {

        // Este es el nombre que se le da al Archivo de la PI (Le quitamos caracteres especiales)
        var nom_pi_popup = $("#NombrePI").val();
        var corrige_nombre_archivo_pi = nom_pi_popup.replace(/[^a-z0-9\-\_]/gi, '-');

        e.data = {
            NombreArchivoProforma: corrige_nombre_archivo_pi //$("#NombrePI").val()
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
            popupNotification.show(" Archivo asociado a la Proforma: "+$("#NombrePI").val()+" fue guardado.", "success");

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

        //location.reload();

        // Recargo el DATASOURCE
        var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
        var sheet = spreadsheet.activeSheet();
        sheet.dataSource.read();

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
        ]/*,
        close: cerrarPopUpMATCH*/
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

    function cerrarPopUpCambioEstado(){

        // location.reload();

        var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
        var sheet = spreadsheet.activeSheet();
        sheet.dataSource.read();

    }


    // Le da la estructura a la ventana POPUP
    var ventana_cambio_estado = $("#POPUP_cambio_estado");
    ventana_cambio_estado.kendoWindow({
        width: "550px",
        title: "Cambio de Estado",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ],
        close: cerrarPopUpCambioEstado
    }).data("kendoWindow").center();


    // Revisamos el cambio de selección en el CBX
    function verificaCambioEstadoCBX(){

        var cbxCambioEstado = $("#NuevoEstadoPopUp").val();

        $("#resumenErrorCorreccionPILI").hide();

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


    $("#gridErrorCambioEstado").kendoGrid({
        dataSource: {
            schema: {
                model: {
                    fields: {
                        DESCRIPCION: { type: "string" },
                        COLOR: { type: "string" },
                        MOTIVO: { type: "string" }
                    }
                }
            },
            pageSize: 20
        },
        height: 250,
        scrollable: true,
        sortable: true,
        /*pageable: {
            input: true,
            numeric: false
        },*/
        columns: [
            { field: "DESCRIPCION" },
            { field: "COLOR" },
            { field: "MOTIVO" }
        ]
    });


    // BTN que Genera el Cambio de Estado
    $("#btn_genera_cambio_estado").on('click', function () {

        var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

        var respuesta = confirm("¿Quiere realizar los cambios?");

        if (respuesta == true) {

            // Ocultar el BTN
            $("#btn_genera_cambio_estado").hide();
            $("#resumenErrorCorreccionPILI").hide();


            var url_cambio_estado = 'TelerikPlanCompra/ModificaEstadoDinamico';
            var url_cambio_estado_coreccion = 'TelerikPlanCompra/ModificaEstadoDinamicoCorreccion';

            // Seteo Variables
            var ID_COLOR3 = "";
            var PROFORMA = "";
            var OC = "";
            var ESTADOC1 = "";
            var DESCRIPCION = "";
            var COLOR = "";

            // Obterer las celdas seleccionadas
            var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet = spreadsheet_id_color3.activeSheet();
            var range = sheet.selection();

            // Traigo el Valor del CBX
            var cbxCambioEstadoSeleccionado = $("#NuevoEstadoPopUp").val();
            // Traigo el Valor eel Comentario
            var comentarioEstadoSeleccionado = $("#comentSolicitaCorreccionPI").val();

           // Var Arreglo Errores
            var arregloErrores = [];

            range.forEachCell(function (row, column, value) {

                var fila_id = row+1;
                var range_color3 = sheet.range("A"+fila_id);
                ID_COLOR3 = range_color3.values();
                var range_proforma = sheet.range("CG"+fila_id);
                PROFORMA = range_proforma.values();
                var range_oc = sheet.range("CK"+fila_id);
                OC = range_oc.values();
                var range_estadoc1 = sheet.range("CS"+fila_id);
                ESTADOC1 = range_estadoc1.values();
                var range_descripcion = sheet.range("J"+fila_id);
                DESCRIPCION = range_descripcion.values();
                var range_color = sheet.range("AB"+fila_id);
                COLOR = range_color.values();

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
                        arregloErrores.push({"DESCRIPCION": String(DESCRIPCION), "COLOR": String(COLOR), "MOTIVO": "Estado Eliminado o Sin Proforma"});

                    }


                // Solicitud Corrección PI
                }else if(cbxCambioEstadoSeleccionado == 1){

                    // estado_c1 == 18 (se pasa de 18 a 22)
                    if( ESTADOC1==22){

                        // $.getJSON(url_cambio_estado_coreccion, {ID_COLOR3: ID_COLOR3, ESTADO_INSERT: 23, PROFORMA: PROFORMA, ESTADO_UPDATE: 5, COMENTARIO: comentarioEstadoSeleccionado});

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado_coreccion,
                            data: {ID_COLOR3: kendo.parseInt(ID_COLOR3), ESTADO_INSERT: kendo.parseInt(23), PROFORMA: String(PROFORMA), ESTADO_UPDATE: kendo.parseInt(4), COMENTARIO: String(comentarioEstadoSeleccionado)},
                            // contentType: "application/json",
                            dataType: "json"
                        });

                    }else{

                        // Descripción - Color
                        // Agregar al arreglo de errores
                        arregloErrores.push({"DESCRIPCION": String(DESCRIPCION), "COLOR": String(COLOR), "MOTIVO": "Estado distinto a: Pendiente Generacion OC"});

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
                        arregloErrores.push({"DESCRIPCION": String(DESCRIPCION), "COLOR": String(COLOR), "MOTIVO": "Estado Aprobado o Sin Proforma"});

                    }

                }


            });


            // Desplegar Grilla con Info
            //console.log(arregloErrores);
            if(arregloErrores.length > 0){

                $("#resumenErrorCorreccionPILI").css("display","");

                var gridtest = $("#gridErrorCambioEstado").data("kendoGrid");
                var sel = gridtest.select();
                var sel_idx = sel.index();
                var item = gridtest.dataItem(sel);              // Get the item
                var idx = gridtest.dataSource.indexOf(item);    // Get the index in the DataSource (not in current page of the grid)
                arregloErrores.forEach(function(err, index) {
                    gridtest.dataSource.insert(idx + 1, { DESCRIPCION: err.DESCRIPCION, COLOR: err.COLOR, MOTIVO: err.MOTIVO });
                });
            }else{
                $("#resumenErrorCorreccionPILI").css("display","none");
            }

            // Al Finalizar los cambios de estado
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Favor de Revisar los Estados.", "info");

            // Recargo el DATASOURCE
            var spreadsheet_reload = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet_reload = spreadsheet_reload.activeSheet();
            sheet_reload.dataSource.read();


        // Si el usuario no acepta realizar cambios
        } else {
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No se han realizado Cambios de Estado.", "info");
        }









    });








// Fin de la función
});
