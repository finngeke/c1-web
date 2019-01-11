$(function () {

    // #############################################################################################
    // ################################# AQUÍ NO VAN ACCIONES JS ###################################
    // ################## AQUÍ SE DEFINE SOLO LA ESTRUCTURA DE POPUPS/BOTONES ######################
    // ################################### SÓLO CODIGO TELERIK #####################################



    // ############################ CARGA ARCHIVO PI ############################

    var normalize = (function() {
        var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇçñÑ",
            to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunnccnN",
            mapping = {};

        for(var i = 0, j = from.length; i < j; i++ )
            mapping[ from.charAt( i ) ] = to.charAt( i );

        return function( str ) {
            var ret = [];
            for( var i = 0, j = str.length; i < j; i++ ) {
                var c = str.charAt( i );
                if( mapping.hasOwnProperty( str.charAt( i ) ) )
                    ret.push( mapping[ c ] );
                else
                    ret.push( c );
            }
            return ret.join( '' );
        }

    })();

    // Asigno el nombre que debe tener el archivo a subir
    function AntesCargaArchivoPI(e) {

        // Este es el nombre que se le da al Archivo de la PI (Le quitamos caracteres especiales)
        var nom_pi_popup = $("#NombrePI").val();
        //var corrige_nombre_archivo_pi = nom_pi_popup.replace(/[^a-z0-9\-\_]/gi, '-');
        var corrige_nombre_archivo_pi = normalize(nom_pi_popup);
            corrige_nombre_archivo_pi = corrige_nombre_archivo_pi.replace(/[^a-z0-9\-\_]/gi, '-');

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


            //var sheet = $("#spreadsheet").data("kendoSpreadsheet").activeSheet();
            //sheet.insertRow(13);

            //$(".k-widget.k-upload").find("ul").remove();

            // Obtengo el nombre de la PI que estoy cargando
            var proforma = $("#NombrePI").val();

            // Calcular Totales en el grilla y rango de datos
            var spreadsheet_carga_pi = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet_carga_pi = spreadsheet_carga_pi.activeSheet();
            var data_conteo_total = sheet_carga_pi.toJSON();
            var total_registros_listados = data_conteo_total.rows.length;
                total_registros_listados = parseInt(total_registros_listados,10) + 2;

            var range_carga_pi = sheet_carga_pi.range("CH1:CH"+total_registros_listados);

            // Recorre la Grilla y con la PROFORMA que me llega asignar el texto "Cargado.." a las filas que coincidan.
            range_carga_pi.forEachCell(function (row, column, value) {
                if(sheet_carga_pi.range("CG"+row).value() == proforma){
                    sheet_carga_pi.range("CH"+row).value("Cargado..");
                }
            // Fin del Recorrer la Grilla
            });

            //sheet.deleteRow(13);

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



    // ############################ MATCH ############################

    function cerrarPopUpMATCH(){

        $("#grid_match_pmm").empty();
        $("#grid_match_plan").empty();

        // $("#grid_match_pmm").data("kendoGrid").destroy();
        // $("#grid_match_plan").data("kendoGrid").destroy();

    }

    // var nom_temp_depto_match =  $("#span_data_temp_depto").text();
    // var res_temp_depto_match = nom_temp_depto_match.split(" - ");
    // Le da la estructura a la ventana POPUP
    var ventana_match = $("#POPUP_match");
    ventana_match.kendoWindow({
        width: "750px",
        height: "350px",
        title: "Match",//+res_temp_depto_match[1]
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

        /*var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
        var sheet = spreadsheet.activeSheet();
        sheet.dataSource.read();*/

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

        var permisoCBX = $("#NuevoEstadoPopUp").val();

        /*
        <option value="0">Crear Modificación</option>
        <option value="1">Solicitud Corrección PI</option>
        <option value="2">Eliminar Opción</option>
         */

        var permisoCBXmodificacion = 0;
        var permisoCBXcorreccion = 0;
        var permisoCBXeliminar = 0;

        // [T] Estado - Crear Modificación
        if(localStorage.getItem("T0006")){
            permisoCBXmodificacion = 1;
        }

        // [T] Estado - Solicitud Corrección PI
        if(localStorage.getItem("T0007")){
            permisoCBXcorreccion = 1;
        }

        // [T] Estado - Eliminar Opción
        if(localStorage.getItem("T0008")){
            permisoCBXeliminar = 1;
        }

        // Verifica si los Permisos Cumplen
        if( (permisoCBX==0) && (permisoCBXmodificacion==0) ){
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            return false;
        }
        if( (permisoCBX==1) && (permisoCBXcorreccion==0) ){
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            return false;
        }
        if( (permisoCBX==2) && (permisoCBXeliminar==0) ){
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            return false;
        }



        kendo.confirm("¿Realizo los Cambios?").then(function () {

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
            // Traigo el Valor del Comentario
            var comentarioEstadoSeleccionado = $("#comentSolicitaCorreccionPI").val();

            // Var Arreglo Errores
            var arregloErrores = [];

            range.forEachCell(function (row, column, value) {

                var fila_id = row + 1;
                var range_color3 = sheet.range("A" + fila_id);
                ID_COLOR3 = range_color3.values();
                var range_proforma = sheet.range("CG" + fila_id);
                PROFORMA = range_proforma.values();
                var range_oc = sheet.range("CK" + fila_id);
                OC = range_oc.values();
                var range_estadoc1 = sheet.range("CS" + fila_id);
                ESTADOC1 = range_estadoc1.values();
                var range_descripcion = sheet.range("J" + fila_id);
                DESCRIPCION = range_descripcion.values();
                var range_color = sheet.range("AB" + fila_id);
                COLOR = range_color.values();

                // Crear Modificación
                if (cbxCambioEstadoSeleccionado == 0) {

                    // estado_c1 != 24 && Proforma
                    if ((ESTADOC1 != 24) && (PROFORMA.length > 0)) {

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado,
                            data: {
                                ID_COLOR3: kendo.parseInt(ID_COLOR3),
                                ESTADO_INSERT: kendo.parseInt(0),
                                PROFORMA: String(PROFORMA),
                                ESTADO_UPDATE: kendo.parseInt(3)
                            },
                            // contentType: "application/json",
                            dataType: "json"
                        });


                    } else {

                        // Descripción - Color
                        // Agregar al arreglo de errores
                        arregloErrores.push({
                            "DESCRIPCION": String(DESCRIPCION),
                            "COLOR": String(COLOR),
                            "MOTIVO": "Estado Eliminado o Sin Proforma"
                        });

                    }


                    // Solicitud Corrección PI
                } else if (cbxCambioEstadoSeleccionado == 1) {

                    // estado_c1 == 18 (se pasa de 18 a 22)
                    if (ESTADOC1 == 18) {

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado_coreccion,
                            data: {
                                ID_COLOR3: kendo.parseInt(ID_COLOR3),
                                ESTADO_INSERT: kendo.parseInt(23),
                                PROFORMA: String(PROFORMA),
                                ESTADO_UPDATE: kendo.parseInt(4),
                                COMENTARIO: String(comentarioEstadoSeleccionado)
                            },
                            // contentType: "application/json",
                            dataType: "json"
                        });

                    } else {

                        // Descripción - Color
                        // Agregar al arreglo de errores
                        arregloErrores.push({
                            "DESCRIPCION": String(DESCRIPCION),
                            "COLOR": String(COLOR),
                            "MOTIVO": "Estado distinto a: Compra Confirmada con PI"
                        });

                    }


                    // Eliminar Opción
                } else if (cbxCambioEstadoSeleccionado == 2) {

                    // estado_c1 != 21 && Proforma
                    if (ESTADOC1 == 0) {
                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado,
                            data: {
                                ID_COLOR3: kendo.parseInt(ID_COLOR3),
                                ESTADO_INSERT: kendo.parseInt(24),
                                PROFORMA: String(PROFORMA),
                                ESTADO_UPDATE: kendo.parseInt(0)
                            },
                            // contentType: "application/json",
                            dataType: "json"
                        });
                    }else if ((ESTADOC1 != 21) && (PROFORMA.length > 0)){
                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado,
                            data: {
                                ID_COLOR3: kendo.parseInt(ID_COLOR3),
                                ESTADO_INSERT: kendo.parseInt(24),
                                PROFORMA: String(PROFORMA),
                                ESTADO_UPDATE: kendo.parseInt(4)
                            },
                            // contentType: "application/json",
                            dataType: "json"
                        });
                    }else{
                        // Descripción - Color
                        // Agregar al arreglo de errores
                        arregloErrores.push({
                            "DESCRIPCION": String(DESCRIPCION),
                            "COLOR": String(COLOR),
                            "MOTIVO": "Estado Aprobado o Sin Proforma"
                        });

                    }

                }


            });


            // Desplegar Grilla con Info
            //console.log(arregloErrores);
            if (arregloErrores.length > 0) {

                $("#resumenErrorCorreccionPILI").css("display", "");

                var gridtest = $("#gridErrorCambioEstado").data("kendoGrid");
                var sel = gridtest.select();
                var sel_idx = sel.index();
                var item = gridtest.dataItem(sel);              // Get the item
                var idx = gridtest.dataSource.indexOf(item);    // Get the index in the DataSource (not in current page of the grid)
                arregloErrores.forEach(function (err, index) {
                    gridtest.dataSource.insert(idx + 1, {
                        DESCRIPCION: err.DESCRIPCION,
                        COLOR: err.COLOR,
                        MOTIVO: err.MOTIVO
                    });
                });
            } else {
                $("#resumenErrorCorreccionPILI").css("display", "none");
            }


            // Recargo el DATASOURCE
            var spreadsheet_reload = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet_reload = spreadsheet_reload.activeSheet();
            sheet_reload.dataSource.read();

            // Al Finalizar los cambios de estado
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Favor de Revisar los Estados.", "info");


        }, function () {
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No se han realizado Cambios de Estado.", "info");
        });



        /*var respuesta = confirm("¿Quiere realizar los cambios?");

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
            // Traigo el Valor del Comentario
            var comentarioEstadoSeleccionado = $("#comentSolicitaCorreccionPI").val();

            // Var Arreglo Errores
            var arregloErrores = [];

            range.forEachCell(function (row, column, value) {

                var fila_id = row + 1;
                var range_color3 = sheet.range("A" + fila_id);
                ID_COLOR3 = range_color3.values();
                var range_proforma = sheet.range("CG" + fila_id);
                PROFORMA = range_proforma.values();
                var range_oc = sheet.range("CK" + fila_id);
                OC = range_oc.values();
                var range_estadoc1 = sheet.range("CS" + fila_id);
                ESTADOC1 = range_estadoc1.values();
                var range_descripcion = sheet.range("J" + fila_id);
                DESCRIPCION = range_descripcion.values();
                var range_color = sheet.range("AB" + fila_id);
                COLOR = range_color.values();

                // Crear Modificación
                if (cbxCambioEstadoSeleccionado == 0) {

                    // estado_c1 != 24 && Proforma
                    if ((ESTADOC1 != 24) && (PROFORMA.length > 0)) {

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado,
                            data: {
                                ID_COLOR3: kendo.parseInt(ID_COLOR3),
                                ESTADO_INSERT: kendo.parseInt(0),
                                PROFORMA: String(PROFORMA),
                                ESTADO_UPDATE: kendo.parseInt(3)
                            },
                            // contentType: "application/json",
                            dataType: "json"
                        });


                    } else {

                        // Descripción - Color
                        // Agregar al arreglo de errores
                        arregloErrores.push({
                            "DESCRIPCION": String(DESCRIPCION),
                            "COLOR": String(COLOR),
                            "MOTIVO": "Estado Eliminado o Sin Proforma"
                        });

                    }


                    // Solicitud Corrección PI
                } else if (cbxCambioEstadoSeleccionado == 1) {

                    // estado_c1 == 18 (se pasa de 18 a 22)
                    if (ESTADOC1 == 22) {

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado_coreccion,
                            data: {
                                ID_COLOR3: kendo.parseInt(ID_COLOR3),
                                ESTADO_INSERT: kendo.parseInt(23),
                                PROFORMA: String(PROFORMA),
                                ESTADO_UPDATE: kendo.parseInt(4),
                                COMENTARIO: String(comentarioEstadoSeleccionado)
                            },
                            // contentType: "application/json",
                            dataType: "json"
                        });

                    } else {

                        // Descripción - Color
                        // Agregar al arreglo de errores
                        arregloErrores.push({
                            "DESCRIPCION": String(DESCRIPCION),
                            "COLOR": String(COLOR),
                            "MOTIVO": "Estado distinto a: Pendiente Generacion OC"
                        });

                    }


                    // Eliminar Opción
                } else if (cbxCambioEstadoSeleccionado == 2) {

                    // estado_c1 != 21 && Proforma
                    if ((ESTADOC1 != 21) && (PROFORMA.length > 0)) {

                        $.ajax({
                            //type: "POST",
                            url: url_cambio_estado,
                            data: {
                                ID_COLOR3: kendo.parseInt(ID_COLOR3),
                                ESTADO_INSERT: kendo.parseInt(24),
                                PROFORMA: String(PROFORMA),
                                ESTADO_UPDATE: kendo.parseInt(4)
                            },
                            // contentType: "application/json",
                            dataType: "json"
                        });

                    } else {

                        // Descripción - Color
                        // Agregar al arreglo de errores
                        arregloErrores.push({
                            "DESCRIPCION": String(DESCRIPCION),
                            "COLOR": String(COLOR),
                            "MOTIVO": "Estado Aprobado o Sin Proforma"
                        });

                    }

                }


            });


            // Desplegar Grilla con Info
            //console.log(arregloErrores);
            if (arregloErrores.length > 0) {

                $("#resumenErrorCorreccionPILI").css("display", "");

                var gridtest = $("#gridErrorCambioEstado").data("kendoGrid");
                var sel = gridtest.select();
                var sel_idx = sel.index();
                var item = gridtest.dataItem(sel);              // Get the item
                var idx = gridtest.dataSource.indexOf(item);    // Get the index in the DataSource (not in current page of the grid)
                arregloErrores.forEach(function (err, index) {
                    gridtest.dataSource.insert(idx + 1, {
                        DESCRIPCION: err.DESCRIPCION,
                        COLOR: err.COLOR,
                        MOTIVO: err.MOTIVO
                    });
                });
            } else {
                $("#resumenErrorCorreccionPILI").css("display", "none");
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
        }*/



    });



    // ############################ CIERRE DE SESSIÓN ############################

    // Le da la estructura a la ventana POPUP Cierre de Session
    var ventana_cierre_session = $("#POPUP_cierra_session");
    ventana_cierre_session.kendoWindow({
        width: "250px",
        height: "90px",
        title: "Saliendo del Plan de Compra...",
        visible: false,
        actions: [
            /*"Minimize",
            "Maximize",
            "Close"*/
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
            /*"Minimize",
            "Maximize",*/
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();

    // Estructura Campo TextArea
    $("#TXTdetalleError").kendoEditor({
        tools: []
    });




    // ############################ TIENDAS ############################

    var dataSource_cbxDisponibleAsignado = "";
    var cbx_marca_valor = "";
    var cbx_tipotienda_valor = "";


    // Le da la estructura a la ventana POPUP
    var ventana_tienda = $("#POPUP_tienda");
    ventana_tienda.kendoWindow({
        width: "710px",
        title: "Mantenedor Tipo Tienda",
        visible: false,
        actions: [
            //"Pin",
            //"Minimize",
            //"Maximize",
            "Close"
        ]/*,
        close: onClose*/
    }).data("kendoWindow").center();

    var ventana_replicar_tienda = $("#POPUP_replicar_tienda");
    ventana_replicar_tienda.kendoWindow({
        width: "300px",
        title: "Replicar Temporada",
        visible: false,
        actions: [
            //"Pin",
            //"Minimize",
            //"Maximize",
            "Close"
        ]/*,
        close: onClose*/
    }).data("kendoWindow").center();

    // Definimos la estructura del ListBox
    $("#tienda_disponible").kendoListBox({
        autoBind: true,
        //selectable: "multiple",
        connectWith: "tienda_seleccionado",
        dropSources: ["tienda_seleccionado"],
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        toolbar: {
            tools: ["transferTo", "transferFrom", "transferAllTo", "transferAllFrom"]
        }
    });

    $("#tienda_seleccionado").kendoListBox({
        autoBind: true,
        //selectable: "multiple",
        connectWith: "tienda_disponible",
        dropSources: ["tienda_disponible"],
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        remove: function (e) {
            setTiendaModificado(e, false);
        },
        add: function (e) {
            setTiendaModificado(e, true);
        }
    });


    // Seteo DataSet Marca
    var dataSource_cbx_marca = new kendo.data.DataSource({
        transport: {
            read: {
                url: "TelerikPlanCompra/ListarMarca",
                dataType: "json"
            }
        }
    });

    // Seteo DataSet TipoTienda
    var dataSource_cbx_tipotienda = new kendo.data.DataSource({
        transport: {
            read: {
                url: "TelerikPlanCompra/ListarTipoTienda",
                dataType: "json"
            }
        }
    });

    // Seteo DataSet Temporadas Duplicar
    var dataSource_cbx_duplicatemp = new kendo.data.DataSource({
        transport: {
            read: {
                url: "TelerikPlanCompra/ListarTemporadasDuplicar",
                dataType: "json"
            }
        }
    });

    // Seteo CBX Marca
    var cbx_marca = $("#CBXMarca").kendoComboBox({
        autoBind: false,
        dataSource:dataSource_cbx_marca,
        placeholder: "Seleccione Marca...",
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        change: function (e) {

            var dataItem = e.sender.dataItem();

            // alert(dataItem.CODIGO);
            // alert(dataItem.DESCRIPCION);
            // console.log(dataItem);

            if(dataItem){
                if(dataItem.DESCRIPCION.length>0){

                    $("#poptienda_tipotienda").show();
                    $("#btn_replica_temporada_tienda").hide();

                    // Dejo en Blanco el CBX Siguiente
                    $("#CBXTipoTienda").data("kendoComboBox").value("");
                    // Limpiar los ListBox
                    var listBox1Tienda = $("#tienda_disponible").data("kendoListBox");
                    listBox1Tienda.remove(listBox1Tienda.items());
                    var listBox2Tienda = $("#tienda_seleccionado").data("kendoListBox");
                    listBox2Tienda.remove(listBox2Tienda.items());

                    // Valor del CBX poptienda_tipotienda
                    cbx_marca_valor = dataItem.CODIGO;
                }
            }else{
                $("#poptienda_tipotienda").hide();
                $("#poptienda_asignacion").hide();
            }

        }
    }).data("kendoComboBox");

    // Seteo CBX TipoTienda
    var cbx_tipotienda = $("#CBXTipoTienda").kendoComboBox({
        autoBind: false,
        dataSource:dataSource_cbx_tipotienda,
        cascadeFrom: "cbx_marca",
        placeholder: "Seleccione Tipo Tienda...",
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        change: function (e) {

            var dataItem = e.sender.dataItem();

            if(dataItem){
                if(dataItem.DESCRIPCION.length > 0){

                    // Despliego el ListBox
                    $("#poptienda_asignacion").show();
                    $("#poptienda_btns").show();
                    $("#btn_replica_temporada_tienda").hide();

                    // Limpiar los ListBox
                    var listBox1Tienda = $("#tienda_disponible").data("kendoListBox");
                    listBox1Tienda.remove(listBox1Tienda.items());
                    var listBox2Tienda = $("#tienda_seleccionado").data("kendoListBox");
                    listBox2Tienda.remove(listBox2Tienda.items());


                    // Bloqueo el ListBox si el campo seleccionado es internet
                    if(dataItem.DESCRIPCION == "I"){

                        $('.k-listbox-toolbar').hide();

                        // Ocultar LI de Botonera
                        $("#poptienda_btns").hide();

                    }else{

                        $('.k-listbox-toolbar').show();

                        // Desplegar LI de Botonera
                        $("#poptienda_btns").show();

                    }

                    // Valor del CBX poptienda_asignacion
                    cbx_tipotienda_valor = dataItem.CODIGO;

                    // ############## Cargo lo DataSet ##############
                    // Seteo DataSet Disponible
                    dataSource_cbxDisponibleAsignado = new kendo.data.DataSource({
                        transport: {
                            read: {
                                url: "TelerikPlanCompra/TiendaObtieneDisponibleAsignado",
                                data: {
                                    MARCA: kendo.parseInt(cbx_marca_valor),
                                    TIENDA: kendo.parseInt(cbx_tipotienda_valor)
                                },
                                dataType: "json"
                            },
                            update: {
                                url: "TelerikPlanCompra/TiendaActualizaAsignado",
                                dataType: "json",
                                data: {
                                    MARCA:kendo.parseInt(cbx_marca_valor),
                                    TIPO_TIENDA:kendo.parseInt(cbx_tipotienda_valor)
                                }
                            }
                        },
                        schema: {
                            model: {
                                id: "CODIGO",
                                fields: {
                                    CODIGO: { type: "number" },
                                    DESCRIPCION: { type: "string" },
                                    ESTADO: { type: "boolean" }
                                }
                            }
                        }
                    });

                    // ############## Cargar Elementos en el ListBox ##############
                    dataSource_cbxDisponibleAsignado.fetch(function () {
                        var data = this.data();
                        var disponible = $("#tienda_disponible").data("kendoListBox");
                        var asignado = $("#tienda_seleccionado").data("kendoListBox");

                        for (var i = 0; i < data.length; i++) {
                            if (data[i].ESTADO) {
                                asignado.add(data[i]);
                            } else {
                                disponible.add(data[i]);
                            }
                        }

                    });

                }
            }else{
                $("#poptienda_asignacion").hide();
            }

        }
    }).data("kendoComboBox");

    // Seteo CBX Temporada a Replicar
    var cbx_temp_replicar = $("#CBXTemporadaReplica").kendoComboBox({
        autoBind: false,
        dataSource:dataSource_cbx_duplicatemp,
        placeholder: "Seleccione Temporada...",
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        change: function (e) {

            var dataItem = e.sender.dataItem();

            if(dataItem){
                if(dataItem.DESCRIPCION.length > 0){
                    $("#btn_replica_temporada_tienda").show();
                }
            }else{
                $("#btn_replica_temporada_tienda").hide();
            }

        }
    }).data("kendoComboBox");

    // Setea true/false de las Asignaciones
    function setTiendaModificado(e, flag) {
        var removedItems = e.dataItems;
        for (var i = 0; i < removedItems.length; i++) {
            var item = dataSource_cbxDisponibleAsignado.get(removedItems[i].CODIGO);
            item.ESTADO = flag;
            item.dirty = !item.dirty;
        }
    }

    // Seteo del BTN Guardar
    $("#guarda_cambios_tienda").kendoButton({
        click: function (e) {

            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

            // Verificar Permisos
            if(localStorage.getItem("T0021")){

                kendo.confirm("¿Guardo los Cambios?").then(function () {

                    // Sincronizar DataSource
                    dataSource_cbxDisponibleAsignado.sync();

                    // Aviso que todos salió correctamente (Probar en DataSource)
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Los cambios fueron realizados.", "success");

                    // Si aún no me llegan tiendas
                    if(localStorage.getItem("M-TIENDA")==0){

                        var dataString_dataDepto = "DEPTO=" + depto;
                        $.ajax({
                            url: "TelerikPlanCompra/ValidarTiendasPresupuestos",
                            data: dataString_dataDepto,
                            success: function (result) {

                                var ConteoRegQuery = JSON.parse(result);
                                $.each( ConteoRegQuery, function(i, obj) {
                                    localStorage.setItem(obj.NOMBRE, obj.VALOR);
                                });

                                location.reload(true);

                            },
                            error: function (xhr, httpStatusMessage, customErrorMessage) {
                                // Limpiar el Local Storage
                                localStorage.clear();

                                $("#spreadsheet").data("kendoSpreadsheet").destroy();
                                $("#spreadsheet").empty();
                                $("#spreadsheet").remove();

                                window.location.href = "salir";

                            }
                        })

                    }


                    // ############## Revisar si hay más marcas ##############
                    /*dataSource_cbx_marca.fetch(function () {
                        var data = this.data();

                        // Existe más de una marca
                        if(data.length>1){
                            kendo.confirm("¿Agrego a tus otras Marcas, la misma configuración de tiendas para el mismo Tipo Tienda?").then(function () {

                                // Llamado Ajax
                                $.ajax({
                                    url: "TelerikPlanCompra/TiendaActualizaAsignadoOtrasMarcas",
                                    data: {
                                        MARCA:kendo.parseInt(cbx_marca_valor),
                                        TIPO_TIENDA:kendo.parseInt(cbx_tipotienda_valor)
                                    },
                                    dataType: "json",
                                    success: function (data) {

                                        if(data=="OK"){

                                            // Recargo la Grilla Trasera
                                            var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                            var sheet = spreadsheet.activeSheet();
                                            sheet.dataSource.read();

                                            popupNotification.getNotifications().parent().remove();
                                            popupNotification.show(" Todo OK, repliqué para tus otras marcas la misma configuración.", "success");

                                        }else{
                                            popupNotification.getNotifications().parent().remove();
                                            popupNotification.show(" Ups, no pude realizar la asignación a tus otras Marcas.", "error");
                                        }

                                    }
                                });


                            }, function () {
                                popupNotification.getNotifications().parent().remove();
                                popupNotification.show(" Ok, no realicé otros cambios.", "info");
                            });
                        }else{
                            // Recargo la Grilla Trasera
                            var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                            var sheet = spreadsheet.activeSheet();
                            sheet.dataSource.read();
                        }

                    });*/





                }, function () {
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No se han realizado Cambios.", "info");
                });

            }else{
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
            }

            // Preguntar si aplica para todas las tiendas
            /*var conf_todas_tiendas = confirm("¿Guardo los Cambios?");

            // Si aplica para todas las tiendas
            if (conf_todas_tiendas == true) {

                // Sincronizar DataSource
                dataSource_cbxDisponibleAsignado.sync();

                // Aviso que todos salió correctamente (Probar en DataSource)
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" Los cambios fueron realizados.", "success");

            // Si no aplica para una tienda
            } else {
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" No se han realizado Cambios.", "info");
            }*/



        }
    });

    // Seteo del BTN Replicar
    $("#replica_temporada_tienda").kendoButton({
        click: function (e) {

            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

            // Verificar Permisos
            if(localStorage.getItem("T0022")){
                // Levantamos el popup de Replicar Tienda
                var POPUPReplicarTienda = $("#POPUP_replicar_tienda");
                POPUPReplicarTienda.data("kendoWindow").open();
            }else{
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
            }


        }
    });

    // Seteo del BTN que realiza la accion de Replicar
    $("#btn_replica_temporada_tienda").kendoButton({
        click: function (e) {

            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

            // Verificar Permisos
            if(localStorage.getItem("T0022")){

                kendo.confirm("¿Replico la Información del Depto Seleccionado?").then(function () {

                    var tem_selecc_duplicar = $("#CBXTemporadaReplica").val();

                    if(cbx_marca_valor && tem_selecc_duplicar){
                        // Llamado Ajax
                        $.ajax({
                            url: "TelerikPlanCompra/TiendaDuplicarTemporada",
                            data: {
                                MARCA:kendo.parseInt(cbx_marca_valor),
                                TEMP_SELECCIONADA:kendo.parseInt(tem_selecc_duplicar)
                            },
                            dataType: "json",
                            success: function (data) {

                                if(data=="OK"){

                                    // Si aún no me llegan tiendas
                                    if(localStorage.getItem("M-TIENDA")>0){


                                        // Recargo la Grilla Trasera
                                        var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                        var sheet = spreadsheet.activeSheet();
                                        sheet.dataSource.read();

                                        // Oculto los elementos por si se abre por segunda vez
                                        $("#poptienda_tipotienda").hide();
                                        $("#poptienda_asignacion").hide();
                                        $("#poptienda_btns").hide();
                                        $("#btn_replica_temporada_tienda").hide();

                                        // Dejo en Blanco los CBX
                                        $("#CBXMarca").data("kendoComboBox").value("");
                                        $("#CBXTipoTienda").data("kendoComboBox").value("");
                                        $("#CBXTemporadaReplica").data("kendoComboBox").value("");
                                        // Limpiar los ListBox
                                        var listBox1Tienda = $("#tienda_disponible").data("kendoListBox");
                                        listBox1Tienda.remove(listBox1Tienda.items());
                                        var listBox2Tienda = $("#tienda_seleccionado").data("kendoListBox");
                                        listBox2Tienda.remove(listBox2Tienda.items());

                                        popupNotification.getNotifications().parent().remove();
                                        popupNotification.show(" Todo OK, he duplicado la temporada.", "success");


                                    }else{
                                        var dataString_dataDepto = "DEPTO=" + depto;
                                        $.ajax({
                                            url: "TelerikPlanCompra/ValidarTiendasPresupuestos",
                                            data: dataString_dataDepto,
                                            success: function (result) {

                                                var ConteoRegQuery = JSON.parse(result);
                                                $.each( ConteoRegQuery, function(i, obj) {
                                                    localStorage.setItem(obj.NOMBRE, obj.VALOR);
                                                });

                                                location.reload(true);

                                            },
                                            error: function (xhr, httpStatusMessage, customErrorMessage) {
                                                // Limpiar el Local Storage
                                                localStorage.clear();

                                                $("#spreadsheet").data("kendoSpreadsheet").destroy();
                                                $("#spreadsheet").empty();
                                                $("#spreadsheet").remove();

                                                window.location.href = "salir";

                                            }
                                        })
                                    }


                                }else{
                                    popupNotification.getNotifications().parent().remove();
                                    popupNotification.show(" Ups, no pude duplicar la temporada.", "error");
                                }

                            },
                            error: function (request, status, error) {
                                console.log("Restupesta: "+request.responseText+" Status: "+status+" Error: "+error);
                            }
                        });
                    }else{
                        console.log("Marca: "+cbx_marca_valor+" Temp. Selecc: "+tem_selecc_duplicar);
                    }



                }, function () {
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No se han realizado Cambios.", "info");
                });

            }else{
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
            }



        }
    });

    $("#CBXTipoTienda").change(function () {

        if( ($('#tienda_seleccionado > option').length>0) && ($("#CBXTipoTienda").val()!=4) ){
            // Sincronizar DataSource
            dataSource_cbxDisponibleAsignado.sync();

            if(localStorage.getItem("M-TIENDA")==0){
                var popupNotificationBTN = $("#popupNotification").kendoNotification().data("kendoNotification");
                popupNotificationBTN.getNotifications().parent().remove();
                popupNotificationBTN.show(" Configuración de Mantenedor Inicial, Recuerda Presionar Guardar.", "info");
            }

        }
    });



    // ############################ FORMATOS ############################

    var dataSource_cbxFormatoDisponibleAsignado = "";
    var cbx_formato_valor = "";

    // Le da la estructura a la ventana POPUP
    var ventana_formato = $("#POPUP_formato");
    ventana_formato.kendoWindow({
        width: "710px",
        title: "Formatos",
        //content: "../ui/formulario/plan_compra/telerik/POPUPFormato.php",
        visible: false/*,
        close: onClose*/
    }).data("kendoWindow").center();

    var ventana_nuevo_formato = $("#POPUP_nuevo_formato");
    ventana_nuevo_formato.kendoWindow({
        width: "350px",
        title: "Nuevo Formato",
        visible: false,
        actions: [
            //"Pin",
            //"Minimize",
            //"Maximize",
            "Close"
        ]/*,
        close: onClose*/
    }).data("kendoWindow").center();

    // Le doy formato de enmascarado al TextBox
    $("#TXTnuevoFormato").kendoMaskedTextBox();

    // Definimos la estructura del ListBox
    $("#formato_disponible").kendoListBox({
        autoBind: true,
        //selectable: "multiple",
        connectWith: "formato_seleccionado",
        dropSources: ["formato_seleccionado"],
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        toolbar: {
            tools: ["transferTo", "transferFrom", "transferAllTo", "transferAllFrom"]
        }
    });

    $("#formato_seleccionado").kendoListBox({
        autoBind: true,
        //selectable: "multiple",
        connectWith: "formato_disponible",
        dropSources: ["formato_disponible"],
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        remove: function (e) {
            setFormatoModificado(e, false);
        },
        add: function (e) {
            setFormatoModificado(e, true);
        }
    });

    // Seteo DataSet Formato
    var dataSource_cbx_formato = new kendo.data.DataSource({
        transport: {
            read: {
                url: "TelerikPlanCompra/MantenedorListarFormato",
                dataType: "json"
            }
        }
    });

    // Seteo CBX Formato y onChange
    var cbx_formato = $("#CBXFormato").kendoComboBox({
        autoBind: false,
        dataSource:dataSource_cbx_formato,
        placeholder: "Seleccione Formato...",
        dataTextField: "DESCRIPCION",
        dataValueField: "CODIGO",
        change: function (e) {

            var dataItem = e.sender.dataItem();

            if(dataItem){
                if(dataItem.DESCRIPCION.length>0){

                    $("#popformato_asignacion").show();
                    $("#popformato_btns").show();

                    // Limpiar los ListBox
                    var listBox1Formato = $("#formato_disponible").data("kendoListBox");
                    listBox1Formato.remove(listBox1Formato.items());
                    var listBox2Formato = $("#formato_seleccionado").data("kendoListBox");
                    listBox2Formato.remove(listBox2Formato.items());

                    // Valor del CBX poptienda_tipotienda
                    cbx_formato_valor = dataItem.CODIGO;

                    // ############## Cargo lo DataSet ##############
                    // Seteo DataSet Disponible
                    dataSource_cbxFormatoDisponibleAsignado = new kendo.data.DataSource({
                        transport: {
                            read: {
                                url: "TelerikPlanCompra/FormatoObtieneDisponibleAsignado",
                                data: {
                                    FORMATO: kendo.parseInt(cbx_formato_valor)
                                },
                                dataType: "json"
                            },
                            update: {
                                url: "TelerikPlanCompra/FormatoActualizaAsignado",
                                dataType: "json",
                                data: {
                                    FORMATO:kendo.parseInt(cbx_formato_valor)
                                }
                            }
                        },
                        schema: {
                            model: {
                                id: "CODIGO",
                                fields: {
                                    CODIGO: { type: "number" },
                                    DESCRIPCION: { type: "string" },
                                    ESTADO: { type: "boolean" }
                                }
                            }
                        }
                    });

                    // ############## Cargar Elementos en el ListBox ##############
                    dataSource_cbxFormatoDisponibleAsignado.fetch(function () {
                        var data = this.data();
                        var disponible = $("#formato_disponible").data("kendoListBox");
                        var asignado = $("#formato_seleccionado").data("kendoListBox");

                        for (var i = 0; i < data.length; i++) {
                            if (data[i].ESTADO) {
                                asignado.add(data[i]);
                            } else {
                                disponible.add(data[i]);
                            }
                        }

                    });




                }
            }else{
                $("#popformato_asignacion").hide();
                $("#popformato_btns").hide();
            }

        }
    }).data("kendoComboBox");


    // Setea true/false de las Asignaciones
    function setFormatoModificado(e, flag) {
        var removedItems = e.dataItems;
        for (var i = 0; i < removedItems.length; i++) {
            var item = dataSource_cbxFormatoDisponibleAsignado.get(removedItems[i].CODIGO);
            item.ESTADO = flag;
            item.dirty = !item.dirty;
        }
    }

    // Seteo del BTN Guardar
    $("#guarda_cambios_formato").kendoButton({
        click: function (e) {

            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

            // Verificar Permisos
            if(localStorage.getItem("T0023")){

                kendo.confirm("¿Guardo los Cambios?").then(function () {

                    // Sincronizar DataSource
                    dataSource_cbxFormatoDisponibleAsignado.sync();

                    // Aviso que todos salió correctamente (Probar en DataSource)
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Los cambios fueron realizados.", "success");

                    // Recargo la Grilla Trasera
                    var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                    var sheet = spreadsheet.activeSheet();
                    sheet.dataSource.read();


                }, function () {
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No se han realizado Cambios.", "info");
                });

            }else{
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                // Fin Verificar Permisos
            }




        }
    });

    // Seteo del BTN Nuevo Formato
    $("#nuevo_formato").kendoButton({
        click: function (e) {

            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

            // Verificar Permisos
            if(localStorage.getItem("T0024")){
                // Levantamos el popup de Replicar Tienda
                var POPUPnuevoFormato = $("#POPUP_nuevo_formato");
                POPUPnuevoFormato.data("kendoWindow").open();
            }else{
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                // Fin Verificar Permisos
            }


        }
    });

    // Seteo del BTN que crea nuevo formato
    $("#btn_crea_nuevo_formato").kendoButton({
        click: function (e) {

            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

            // Verificar Permisos
            if(localStorage.getItem("T0024")){

                kendo.confirm("¿Crear nuevo formato?").then(function () {

                    var nuevo_formato = $("#TXTnuevoFormato").data("kendoMaskedTextBox");
                    var value_nuevo_formato = nuevo_formato.value();

                    if(value_nuevo_formato){
                        // Llamado Ajax
                        $.ajax({
                            url: "TelerikPlanCompra/FormatoCrearNuevo",
                            data: {
                                FORMATO:String(value_nuevo_formato)
                            },
                            /*dataType: "json",*/
                            success: function (data) {

                                if(data=="OK"){

                                    // Recargo la Grilla Trasera
                                    var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                    var sheet = spreadsheet.activeSheet();
                                    sheet.dataSource.read();

                                    // Recargar el CBX de Formato
                                    $("#CBXFormato").data("kendoComboBox").dataSource.read();

                                    // Oculto POPUP de Nuevo Formato
                                    var POPUPnuevoFormatoClose = $("#POPUP_nuevo_formato");
                                    POPUPnuevoFormatoClose.data("kendoWindow").close();

                                    // Oculto el ListBox y la Botonera
                                    $("#popformato_asignacion").hide();
                                    $("#popformato_btns").hide();

                                    // Dejo en Blanco el CBX
                                    $("#CBXFormato").data("kendoComboBox").value("");

                                    // Limpiar los ListBox
                                    var listBox1Formato = $("#formato_disponible").data("kendoListBox");
                                    listBox1Formato.remove(listBox1Formato.items());
                                    var listBox2Formato = $("#formato_seleccionado").data("kendoListBox");
                                    listBox2Formato.remove(listBox2Formato.items());

                                    popupNotification.getNotifications().parent().remove();
                                    popupNotification.show(" Todo OK, Nuevo Formato ya Creado.", "success");

                                }else{
                                    popupNotification.getNotifications().parent().remove();
                                    popupNotification.show(" Ups, no pude crear el nuevo formato.", "error");
                                }

                            },
                            error: function (request, status, error) {
                                console.log("Restupesta: "+request.responseText+" Status: "+status+" Error: "+error);
                            }
                        });
                    }else{
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" Debes ingresar el nombre del Nuevo Formato.", "error");
                        // Fin Verificar Permisos
                        console.log("Formato: "+nuevo_formato);
                    }



                }, function () {
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No se han realizado Cambios.", "info");
                });

            }else{
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                // Fin Verificar Permisos
            }



        }
    });









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
            /*"Minimize",
            "Maximize",*/
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



// ############################ Importar Achivos ############################

    // Ventana Pop
    var ventana_loading= $("#Pop_loading_Archivo");
    ventana_loading.kendoWindow({
        width: "350px",
        align: "400px",
        title: "Importar Archivo",
        visible: false,
        close: function() {
            $(".open-button").show();},
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
        close: onClose*/
    }).data("kendoWindow").center();
    $("#totalProgressBar").kendoProgressBar({
        type: "chunk",
        chunkCount: 4,
        min: 0,
        max: 4,
        orientation: "vertical",

    });
    $("#loadingProgressBar").kendoProgressBar({
        orientation: "vertical",
        showStatus: false,
        animation: false,
    });
    $("#gridErrores").kendoGrid({
        dataSource: {
            schema: {
                model: {
                    fields: {
                        Errores: { type: "string" }
                    }
                }
            },
            pageSize: 0
        },
        height: 90,
        scrollable: true,
        sortable: true,
        columns: [
            { field: "Errores" }
        ]
    });

    // ############################ Importar Assortment ############################
    $("#txt_archivo").kendoUpload({
        async: {
            saveUrl: "guardar/archivoAssorment",
            autoUpload: true,
            saveField: "JSONGuardaArhcivo"
            /*,removeUrl: "TelerikGuardar/QuitarArhcivoPI"*/
        },validation: {
            allowedExtensions: [".xlsx",".XLSX",".xls",".XLS"],
            maxFileSize: 30000000
        },
        upload: AntesCargaArchivo,
        success: function () {
            $(".chunkStatus").text(1);
            $(".Rows1").text(0+ "/"+0);

            var popupDe = $("#Pop_loading_Archivo");
            popupDe.data("kendoWindow").open();
            $("#gridErrores").data("kendoGrid").dataSource.data([]);
            $("#_Errores").css("display", "none");
            CargaAssortment();
        }
    });
    function AntesCargaArchivo(e){
        e.data = {
            Tipo_archivo: $("#tipo_archivo").val()
        };
    }
    function CargaAssortment() {
        var pb = $("#loadingProgressBar").data("kendoProgressBar");pb.value(0);
        var pbt = $("#totalProgressBar").data("kendoProgressBar");pbt.value(1);
        var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");


        $('#Loaded').html("Extrayendo de datos.");
        $.ajax({
            url: "importar_archivo/ImportarAssormentExtraccionDatos",
            dataType: "json",
            success: function (data) {
                if (data["Error"] == true){
                    Msj_Errores(data["msjError"]);
                }else{
                    var interval = setInterval(function () {
                        if (pb.value() < 10) {pb.value(pb.value() + 1);
                            $(".loadingStatus").text(pb.value() + "%");
                        }else if(pb.value() == 10) {
//***********************************Validando Jerarquias
                            clearInterval(interval);
                            $('#Loaded').html("Validando Depto y Jerarquías.");
                            $.ajax({ url: "importar_archivo/ImportarAssormentValidaciones"
                                    ,type: 'GET'
                                    ,data: {Tipo:1}
                                    ,dataType: "json"
                                    ,success: function(data) {
                                        if (data["Error"] == true){
                                            Msj_Errores(data["msjError"]);
                                        }else{pb.value(10);
                                            var interval = setInterval(function () {
                                                if (pb.value() < 40) {
                                                    pb.value(pb.value() + 1);
                                                    $(".loadingStatus").text(pb.value() + "%");
                                                }else if(pb.value() == 40) {
//***********************************Validando datos.
                                                    clearInterval(interval);
                                                    $('#Loaded').html("Validando Datos.");
                                                    $.ajax({ url: "importar_archivo/ImportarAssormentValidaciones"
                                                            ,type: 'GET'
                                                            ,data: {Tipo:2}
                                                            ,dataType: "json"
                                                            ,success: function(data) {
                                                                if (data["Error"] == true){
                                                                    Msj_Errores(data["msjError"]);
                                                                }else{pb.value(40);
                                                                    var interval = setInterval(function () {
                                                                        if (pb.value() < 90) {
                                                                            pb.value(pb.value() + 1);
                                                                            $(".loadingStatus").text(pb.value() + "%");
                                                                        }else if(pb.value() == 90) {
//***********************************Validando limpiado datos.
                                                                            clearInterval(interval);
                                                                            $('#Loaded').html("Limpiando Data.");
                                                                            $.ajax({ url: "importar_archivo/ImportarAssormentdelrows"
                                                                                    ,type: 'GET'
                                                                                    ,dataType: "json"
                                                                                    ,success: function(data) {pb.value(90);
                                                                                        var interval = setInterval(function () {
                                                                                        if (pb.value() < 100) {
                                                                                            pb.value(pb.value() + 1);
                                                                                            $(".loadingStatus").text(pb.value() + "%");
                                                                                        }else if(pb.value() == 100) {
                                                                                            clearInterval(interval);
                                                                                            pb.value(0);pbt.value(2);
                                                                                            var $key = 0;var $key2 = 0;var count = data.length - 1;var _Int = 0;
                                                                                            $(".loadingStatus").text(0 + "%");
                                                                                            $(".chunkStatus").text(2);
                                                                                            $('#Loaded').html("Insertanto Historial.");
                                                                                            $(".Rows1").text(0+ "/"+count);
                                                                                            var depto = "";

                                                                                            //var depto = o ;
        //***********************************Insertar historial
                                                                                            $.each(data, function (i, o) {$key++;

                                                                                                if ($key != 1){$key2 ++;
                                                                                                    depto = o["Cod Dpto"];
                                                                                                    $.ajax({ url: "importar_archivo_3/ImportarAssormentInsHistorial"
                                                                                                        ,type: 'POST'
                                                                                                        ,data: {_rows:o,_delete:$key2}
                                                                                                        ,dataType: "json"
                                                                                                        ,success: function(data) {
                                                                                                            if (data["Error"] == true){
                                                                                                                Msj_Errores(data["msjError"]);
                                                                                                            }else{
                                                                                                                pb.value(pb.value());
                                                                                                                _Int = Number(data["msjError"]) + Number(_Int);
                                                                                                                var _total =  (Number(_Int)*100) /count;
                                                                                                                var interval = setInterval(function () {
                                                                                                                    if (pb.value() <= _total) {
                                                                                                                        pb.value(pb.value()+1);
                                                                                                                        $(".loadingStatus").text(pb.value() + "%");
                                                                                                                    }else{clearInterval(interval);}
                                                                                                                }, 30);
                                                                                                                $(".Rows1").text(_Int+ "/"+count);

                                                                                                                if (Number(_Int) == count){
                                                                                                                    clearInterval(interval);
                                                                                                                    pbt.value(3);pb.value(0);
                                                                                                                    $(".chunkStatus").text(3);
                                                                                                                    $(".loadingStatus").text(0 + "%");
                                                                                                                    $('#Loaded').html("Limpiando Data Debut/Reorder - Costos.");
                                                                                                                    $(".Rows1").text(0+ "/"+0);
                                                                                                                    //***********************************Limpiando datos DEBUT- REORDER
                                                                                                                    $.ajax({ url: "importar_archivo/ImpAssormAbrirDataVent"
                                                                                                                            ,type: 'GET'
                                                                                                                            ,dataType: "json"
                                                                                                                            ,success: function(data) {
                                                                                                                                if (data["Error"] == true){
                                                                                                                                    Msj_Errores(data["msjError"]);
                                                                                                                                }else{pb.value(0);
                                                                                                                                    var interval = setInterval(function () {
                                                                                                                                        if (pb.value() < 20) {
                                                                                                                                            pb.value(pb.value() + 1);
                                                                                                                                            $(".loadingStatus").text(pb.value() + "%");
                                                                                                                                        }else if(pb.value() == 20){
                                                                                                                                            clearInterval(interval);
                                                                                                                                            $('#Loaded').html("Calculando Curvado - Costos.");
//***********************************Limpiando datos DEBUT- REORDER
                                                                                                                                            $.ajax({ url: "importar_archivo/ImpAssormCalculos"
                                                                                                                                                    ,type: 'GET'
                                                                                                                                                    ,dataType: "json"
                                                                                                                                                    ,success: function(data2) {pb.value(20);
                                                                                                                                                    var interval = setInterval(function () {
                                                                                                                                                        if (pb.value() < 100) {
                                                                                                                                                            pb.value(pb.value() + 1);
                                                                                                                                                            $(".loadingStatus").text(pb.value() + "%");
                                                                                                                                                        }else if(pb.value() == 100){
                                                                                                                                                            clearInterval(interval);
                                                                                                                                                            pbt.value(4);pb.value(0);
                                                                                                                                                            var count2 = data2.length - 1;
                                                                                                                                                            var _Int2 = 0; var _final = 0;var $key1 = 0;
                                                                                                                                                            $(".chunkStatus").text(4);
                                                                                                                                                            $(".loadingStatus").text(0 + "%");
                                                                                                                                                            $('#Loaded').html("Insertanto Plan de Compra.");
                                                                                                                                                            $(".Rows1").text(0+ "/"+count2);

                                                                                                                                                            $.each(data2, function (i, o) {$key1++;
                                                                                                                                                                if($key1 != 1){
                                                                                                                                                                    $.ajax({ url: "importar_archivo_3/InsertarAssormentC1"
                                                                                                                                                                        ,type: 'POST'
                                                                                                                                                                        ,data: {_rows:o}
                                                                                                                                                                        ,dataType: "json"
                                                                                                                                                                        ,success: function(data3) {
                                                                                                                                                                            if (data3["Error"] == true){
                                                                                                                                                                                Msj_Errores(data["msjError"]);
                                                                                                                                                                            }else{
                                                                                                                                                                                _Int2 = Number(data3["msjError"]) + Number(_Int2);
                                                                                                                                                                                var _total =  (Number(_Int2)*100) /count2;
                                                                                                                                                                                pb.value(pb.value());
                                                                                                                                                                                var interval = setInterval(function () {
                                                                                                                                                                                    if (pb.value() < _total) {
                                                                                                                                                                                        pb.value(pb.value()+1);
                                                                                                                                                                                        $(".loadingStatus").text(pb.value() + "%");
                                                                                                                                                                                        $(".Rows1").text(_Int2+ "/"+count2);
                                                                                                                                                                                    }else if(pb.value()==100 && _final == 0 ){
                                                                                                                                                                                        $('#Loaded').html("Importación Completa.");
                                                                                                                                                                                        clearInterval(interval);
                                                                                                                                                                                        $(".Rows1").text(_Int2+ "/"+count2);
                                                                                                                                                                                        _final = 1;
                                                                                                                                                                                        popupNotification.show(kendo.toString("Insertado Correctamente"), "success");
                                                                                                                                                                                        var dataString_dataDepto = "DEPTO=" + depto;
                                                                                                                                                                                        $.ajax({
                                                                                                                                                                                            url: "TelerikPlanCompra/ListarPermisosValidaPresupuestos",
                                                                                                                                                                                            data: dataString_dataDepto,

                                                                                                                                                                                            success: function (result) {
                                                                                                                                                                                                localStorage.clear();
                                                                                                                                                                                                var ConteoRegQuery = JSON.parse(result);
                                                                                                                                                                                                $.each( ConteoRegQuery, function(i, obj) {
                                                                                                                                                                                                    //console.log(obj.TOTALREGPLAN);
                                                                                                                                                                                                    //localStorage.setItem("TOTALREGPLAN", obj.TOTALREGPLAN);
                                                                                                                                                                                                    localStorage.setItem(obj.NOMBRE, obj.VALOR);
                                                                                                                                                                                                });

                                                                                                                                                                                                location.reload(true);
                                                
                                                                                                                                                                                            },
                                                                                                                                                                                            error: function (xhr, httpStatusMessage, customErrorMessage) {
                                                                                                                                                                                                // Limpiar el Local Storage
                                                                                                                                                                                                localStorage.clear();
                                                                                                                                                                                            }
                                                                                                                                                                                        });

                                                                                                                                                                                    }else{
                                                                                                                                                                                        clearInterval(interval);
                                                                                                                                                                                    }
                                                                                                                                                                                });
                                                                                                                                                                            }
                                                                                                                                                                        }
                                                                                                                                                                    });
                                                                                                                                                                }
                                                                                                                                                            });
                                                                                                                                                        }
                                                                                                                                                    });

                                                                                                                                                }
                                                                                                                                            });
                                                                                                                                        }
                                                                                                                                    });
                                                                                                                                }
                                                                                                                        }
                                                                                                                    });
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                    });
                                                                                                }
                                                                                            });
                                                                                        }
                                                                                    });
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                    });
                                                }
                                            });
                                        }
                                    }
                            });
                        }
                    });
                }
            }
        });
    }

    function Msj_Errores(e){
        var arregloErrores = [];
        arregloErrores.push({"Errores":e});
        $("#_Errores").css("display", "");
        var grilla = $("#gridErrores").data("kendoGrid");// Get the item
        var sel = grilla.select();
        var item = grilla.dataItem(sel);              // Get the item
        var idx = grilla.dataSource.indexOf(item);
        arregloErrores.forEach(function (err, index) {
            grilla.dataSource.insert(idx + 1, {
                Errores: err.Errores
            });
        });
    }

    $("#editor").kendoEditor({
        tools: [
            "bold",
            "italic",
            "underline",
            "foreColor"
        ]
    });

    // Le da la estructura a la ventana POPUP
    var ventana_import= $("#POPUP_Importar_");
    ventana_import.kendoWindow({
        width: "360px",
        title: "Importar Archivo",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();



    // ############################ AJUSTE COMPRA ############################

    // Le da la estructura a la ventana POPUP
    var ventana_ajuste_compra = $("#POPUP_ajuste_compra");
    ventana_ajuste_compra.kendoWindow({
        width: "600px",
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

    // Le da la estructura a la grilla
    $("#grid_ajuste_compra").kendoGrid({
        height: 164,
        sortable: true
    });



    // ############################ AJUSTE N CAJAS ############################

    // Le da la estructura a la ventana POPUP
    var ventana_ajuste_cajas = $("#POPUP_ajuste_cajas");
    ventana_ajuste_cajas.kendoWindow({
        width: "650px",
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
    // Le da la estructura a la grilla
    $("#grid_ajuste_cajas").kendoGrid({
        height: 220,
        sortable: true,
        align : "center"
    });

    // Le da la estructura a la grilla
    $("#grid_ajuste_cajas2").kendoGrid({
        height: 220,
        sortable: true
    });


// ############################ presupuesto total ############################

    // pop grilla presupuesto total.
    var ventana_presupuestos = $("#POPUP_presupuestos_total");
    ventana_presupuestos.kendoWindow({
        width: "650px",
        title: "Presupuestos",
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
    $("#grid_presupuestos_total").kendoGrid({
        height: 127,
        sortable: true,
        align : "center",
        scrollable: true,
        columns: [
            { field: "Tipo", width:"70px" },
            { field: "Ac" , width:"90px", title: "A" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Bc" , width:"90px", title: "B" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Cc" , width:"90px", title: "C" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Dc" , width:"90px", title: "D" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Ec" , width:"90px", title: "E" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Fc" , width:"90px", title: "F" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Gc" , width:"90px", title: "G" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Hc" , width:"90px", title: "H" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Ic" , width:"90px", title: "I" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Totalc" , width:"100px", title: "Total" ,attributes: {style: "background-color: rgb(240,248,255); font-size: 12px"}},
            { field: "Ar" , width:"90px", title: "A" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Br" , width:"90px", title: "B" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Cr" , width:"90px", title: "C" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Dr" , width:"90px", title: "D" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Er" , width:"90px", title: "E" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Fr" , width:"90px", title: "F" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Gr" , width:"90px", title: "G" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Hr" , width:"90px", title: "H" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Ir" , width:"90px", title: "I" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Totalr" , width:"100px", title: "Total" ,attributes: {style: "background-color: rgb(255,182,193); font-size: 12px"}},
            { field: "Ae" , width:"60px", title: "A" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "Be" , width:"60px", title: "B" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "Ce" , width:"60px", title: "C" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "De" , width:"60px", title: "D" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "Ee" , width:"60px", title: "E" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "Fe" , width:"60px", title: "F" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "Ge" , width:"60px", title: "G" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "He" , width:"60px", title: "H" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "Ie" , width:"60px", title: "I" ,attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}},
            { field: "Totale" , width:"60px", title: "Total",attributes: {style: "background-color: rgb(135,206,250); font-size: 12px"}}
        ]
    });


// ############################ Presupuestos Edit ############################
    var ventana_editpresupuestos = $("#POPUP_Presupuestos");
    ventana_editpresupuestos.kendoWindow({
                    width: "300px",
                    title: "Presupuestos",
                    visible: false,
                    actions: [
                        //"Pin",
                        "Minimize",
                        "Maximize",
                        "Close"
                    ]/*,
                            close: onClose*/
    }).data("kendoWindow").center();
//onchange costo
    $("#Costo").change (function () {
        var valor = $("#Update").text();
        valor = valor + "1,"
        $("#btnGuardar").prop("disabled", false);
        $('#Update').html(valor);
    });
//onchange retail
    $("#Retail").change (function () {
        var valor = $("#Update").text();
        valor = valor + "2,"
        $("#btnGuardar").prop("disabled", false);
        $('#Update').html(valor);
    });
//onchange emb
    $(".Emb").change (function () {
        var valor = $("#Update").text();
        valor = valor.substring(0, valor.length - 1);
        var dt = valor.split(','); var _existe = false;
        dt.forEach(function (value) {
            if (value == 3){
                _existe = true;
            }
        });
       if (_existe == false){
           $("#btnGuardar").prop("disabled", false);
           valor = valor + "3,"
           $('#Update').html(valor);
       }
    });
// BTN Actualiza Grilla
    $('#btnGuardar').on('click', function () {
        var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");
        if(localStorage.getItem("T0019")) {
        var valor = $("#Update").text();
        $("#btnGuardar").prop("disabled", true);
        var costo = $("#Costo").val();
        var retail = $("#Retail").val();
        $('#Update').html("");
        if (valor != "") {
            var valor = valor.substring(0, valor.length - 1);
            var dt = valor.split(',');
            var _error = true;
            dt.forEach(function (value) {
                if (_error == true){
                    if (value == 1){
                        if (costo == 0){
                            popupNotification.show(kendo.toString("El presupuesto de costo no debe estar en 0."), "error");
                            $("#btnGuardar").prop("disabled", false);
                            _error = false;
                        }else{
                            //ADD COSTO
                            $.ajax({ url: "TelerikPlanCompra/InsertPptoCosto"
                                ,type: 'GET'
                                ,data: {PRESUPUESTO:costo}
                                ,dataType: "json"
                                ,success: function(data) {
                                    if (data ==1){
                                        popupNotification.show(kendo.toString(" Guardado Correctamente Costo."), "success");
                                    }else{
                                        popupNotification.show(kendo.toString(" Error en el guardado costo."), "error");
                                        $("#btnGuardar").prop("disabled", false);
                                        _error = false;
                                    }
                                }
                            });
                        }
                    }
                    else if(value == 2){
                        if (retail == 0){
                            popupNotification.show(kendo.toString("El presupuesto de retail no debe estar en 0."), "error");
                            $("#btnGuardar").prop("disabled", false);
                            _error = false;
                        }else{
                            //ADD RETAIL
                            $.ajax({ url: "TelerikPlanCompra/InsertPptoRetail"
                                ,type: 'GET'
                                ,data: {PRESUPUESTO:retail}
                                ,dataType: "json"
                                ,success: function(data) {
                                    if (data ==1){
                                        popupNotification.show(kendo.toString(" Guardado Correctamente Retail."), "success");
                                        //popupNotification.show(kendo.toString(" Guardado Correctamente."), "success");
                                    }else{
                                        popupNotification.show(kendo.toString(" Error en el guardado Retail."), "error");
                                        $("#btnGuardar").prop("disabled", false);
                                        _error = false;
                                    }
                                }
                            });
                        }
                    }
                    else if(value == 3){
                        //Valicacion Ventanas embarque
                        var Ventanas = ["A","B","C","D","E","F","G","H","I"];
                        var Porcent = "";
                        Ventanas.forEach(function (value) {
                            Porcent += $("#PorVent"+value).val() + "-";
                        });
                        $.ajax({ url: "TelerikPlanCompra/Sumaporcent"
                            ,type: 'GET'
                            ,data: {_Porcent:Porcent}
                            ,dataType: "json"
                            ,success: function(data) {
                                if (data == 0){
                                    popupNotification.show(kendo.toString("Los porcentajes de embarques deben sumar 100%."), "error");
                                    _error = false;
                                }else{
                                    $.ajax({ url: "TelerikPlanCompra/DeleteVentEm"
                                        ,type: 'GET'
                                        ,dataType: "json"
                                        ,success: function(data) {
                                            if (data == 1){
                                                var _insert = 0;
                                                Ventanas.forEach(function (value) {
                                                    $.ajax({ url: "TelerikPlanCompra/InsertVentEmb"
                                                        ,type: 'GET'
                                                        ,data: {VENTANA:value,PORCENTAJE:$("#PorVent"+value).val()}
                                                        ,dataType: "json"
                                                        ,success: function(data) {
                                                            if (data == 1){
                                                                _insert = parseInt(_insert) + parseInt(data);
                                                            }else{
                                                                popupNotification.show(kendo.toString(" Error en el guardado Ppto Emb Vent:".value), "error")
                                                                $("#btnGuardar").prop("disabled", false);
                                                                _error = false;
                                                            }
                                                            if (_insert == 9){
                                                                popupNotification.show(kendo.toString(" Guardado Correctamente Ppto Emb."), "success");
                                                            }
                                                        }
                                                    });
                                                });
                                            }else {
                                                popupNotification.show(kendo.toString(" Error delete Ppto Emb"));
                                                $("#btnGuardar").prop("disabled", false);
                                                _error = false;
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
        }else{
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
        }

    });


// ############################ Export Excel############################
    var ventana_export = $("#POPUP_Exportar");
    ventana_export.kendoWindow({
        width: "400px",
        title: "Exportar",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]
    }).data("kendoWindow").center();
    //Combobox Tipo Export
    $("#CBXtipoExport").change (function () {
        var tipo = $("#CBXtipoExport").val();
        if (tipo == 1){
            $('#btnExportar').prop('disabled',true)
            $("#lblEstados").hide();
            $("#lblDepartmento").show();
            $("#gridDepto").kendoGrid({
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikPlanCompra/ListarDeptosTempAssortment",
                            dataType: "json"
                        }
                    },
                    schema: {
                        model: {
                            id: "COD_DEPARTAMENTO"
                        }
                    }
                },
                scrollable: true,
                height: 200,
                sortable: true,
                change: onChangedepart,
                columns: [
                    { selectable: true, width: "30px" },
                    { field:"COD_DEPARTAMENTO", title: "Codigo",width: "60px" },
                    { field:"DEPARTAMENTO"    , title:"Nombre"}]
            });
        }
        else if (tipo == 2){
            $('#btnExportar').prop('disabled',true)
            $("#lblEstados").hide();
            $("#lblDepartmento").show();
            $("#gridDepto").kendoGrid({
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikPlanCompra/ListarDeptosTemp",
                            dataType: "json"
                        }
                    },
                    schema: {
                        model: {
                            id: "COD_DEPARTAMENTO"
                        }
                    }
                },
                scrollable: true,
                height: 200,
                sortable: true,
                change: onChangedepart,
                columns: [
                    { selectable: true, width: "30px" },
                    { field:"COD_DEPARTAMENTO", title: "Codigo",width: "60px" },
                    { field:"DEPARTAMENTO"    , title:"Nombre"}]
            });
        }
        else if (tipo == 3){
            $('#btnExportar').prop('disabled',true)
            $("#lblEstados").show();
            $("#lblDepartmento").show();
            $("#gridEstados").kendoGrid({
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikPlanCompra/ListarEstadosPlan",
                            dataType: "json"
                        }
                    },
                    schema: {
                        model: {
                            id: "CODIGO"
                        }
                    }
                },
                scrollable: true,
                height: 150,
                sortable: true,
                change: onChangeEstados,
                columns: [
                    { selectable: true, width: "30px" },
                    { field:"NOM_ESTADO", title:"Nombre"}],
                dataBound: function(e) {
                    var items = this._data;
                    var tableRows = $(this.table).find("tr");
                    tableRows.each(function(index) {
                        var row = $(this);
                        var Item = items[index];
                        if (Item.CODIGO == 18) {
                            row.addClass("EstadoCompraConfirmadaPI");
                        }else if(Item.CODIGO == 19){
                            row.addClass("EstadoPendienteAprobacionsinMatch");
                        }else if (Item.CODIGO == 20||Item.CODIGO == 21){
                            row.addClass("EstadoAprobado");
                        }else if (Item.CODIGO == 23||Item.CODIGO == 24){
                            row.addClass("EstadoEliminado");
                        }else{
                            row.addClass("columnas");
                        }
                    });
                }
            });

            $("#gridDepto").kendoGrid({
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikPlanCompra/ListarDeptosTemp",
                            dataType: "json"
                        }
                    },
                    schema: {
                        model: {
                            id: "COD_DEPARTAMENTO"
                        }
                    }
                },
                scrollable: true,
                height: 150,
                sortable: true,
                change: onChangedepart,
                columns: [
                    { selectable: true, width: "30px" },
                    { field:"COD_DEPARTAMENTO", title: "Codigo",width: "60px" },
                    { field:"DEPARTAMENTO"    , title:"Nombre"}]
            });

        }
        else if (tipo == 4){
            $('#btnExportar').prop('disabled',false)
            $("#lblEstados").hide();
            $("#lblDepartmento").hide();
        }
    });
    //onchange List Departamento check box
    function onChangedepart(arg) {

        $('#SeleccionDepto').val(this.selectedKeyNames().join(", "));
        var tipo = $("#CBXtipoExport").val();
        if (tipo == 3){
            if ($('#Seleccionestados').val() != "" && $('#SeleccionDepto').val() != ""){
                $('#btnExportar').prop('disabled',false);
            }else{
                $('#btnExportar').prop('disabled',true);
            }
        }else{
        if ($('#SeleccionDepto').val() == ""){
            $('#btnExportar').prop('disabled',true);
        }else{
            $('#btnExportar').prop('disabled',false);
        }
        }
    }
    //onchange List Estados check box
    function onChangeEstados(arg) {
        $('#btnExportar').prop('disabled',false);
        $('#Seleccionestados').val(this.selectedKeyNames().join(", "));

        if ($('#Seleccionestados').val() != "" && $('#SeleccionDepto').val() != ""){
            $('#btnExportar').prop('disabled',false);
        }else{
            $('#btnExportar').prop('disabled',true);
        }
    }

// Fin de la función
});
