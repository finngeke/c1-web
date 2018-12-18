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

            var range_carga_pi = sheet_carga_pi.range("CH1:CH"+total_registros_listados);

            // Recorre la Grilla y con la PROFORMA que me llega asignar el texto "Cargado.." a las filas que coincidan.
            range_carga_pi.forEachCell(function (row, column, value) {
                if(sheet_carga_pi.range("CG"+row).value() == proforma){
                    sheet_carga_pi.range("CH"+row).value("Cargado..");
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
        }



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
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
                close: onClose*/
    }).data("kendoWindow").center();



    // ############################ TIENDAS ############################

    // Le da la estructura a la ventana POPUP
    var ventana_tienda = $("#POPUP_tienda");
    ventana_tienda.kendoWindow({
        width: "470px",
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
                if(dataItem.DESCRIPCION.length>0){
                    $("#poptienda_asignacion").show();
                }
            }else{
                $("#poptienda_asignacion").hide();
            }

        }
    }).data("kendoComboBox");

    // Seteo DataSet Disponible
    var dataSource_cbx_disponible = new kendo.data.DataSource({
        transport: {
            read: {
                url: "TelerikPlanCompra/TiendaObtieneDisponible",
                data: {
                    MARCA: kendo.parseInt(ID_COLOR3),
                    TIENDA: kendo.parseInt(0)
                },
                dataType: "json"
            }
        }
    });

    // Seteo DataSet Asignado
    var dataSource_cbx_asignado = new kendo.data.DataSource({
        transport: {
            read: {
                url: "TelerikPlanCompra/TiendaObtieneAsignado",
                data: {
                    MARCA: kendo.parseInt(ID_COLOR3),
                    TIENDA: kendo.parseInt(0)
                },
                dataType: "json"
            }
        }
    });



    // Definimos la estructura del ListBox
    var cbx_disponible = $("#tienda_disponible").kendoListBox({
        autoBind: false,
        dataSource:dataSource_cbx_disponible,
        connectWith: "tienda_seleccionado",
        toolbar: {
            tools: ["transferTo", "transferFrom", "transferAllTo", "transferAllFrom"]
        }
    });

    var cbx_asignado = $("#tienda_seleccionado").kendoListBox({
        autoBind: false,
        dataSource:dataSource_cbx_asignado
    });








    // ############################ FORMATOS ############################

    // Le da la estructura a la ventana POPUP
    var ventana_formato = $("#POPUP_formato");
    ventana_formato.kendoWindow({
        width: "500px",
        height: "360px",
        title: "Formatos",
        //content: "../ui/formulario/plan_compra/telerik/POPUPFormato.php",
        visible: false/*,
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

    //Upload del archivo
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

        //***********************************Insertar historial
                                                                                            $.each(data, function (i, o) {$key++;
                                                                                                if ($key != 1){$key2 ++;
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
                                                                                                                                                                                        var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                                                                                                                                                                        var sheet = spreadsheet.activeSheet();
                                                                                                                                                                                        sheet.dataSource.read();

                                                                                                                                                                                    }else{
                                                                                                                                                                                        clearInterval(interval);
                                                                                                                                                                                    }
                                                                                                                                                                                }, 30);
                                                                                                                                                                            }
                                                                                                                                                                        }
                                                                                                                                                                    });
                                                                                                                                                                }
                                                                                                                                                            });
                                                                                                                                                        }
                                                                                                                                                    }, 30);

                                                                                                                                                }
                                                                                                                                            });
                                                                                                                                        }
                                                                                                                                    }, 30);
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
                                                                                    }, 30);
                                                                                }
                                                                            });
                                                                        }
                                                                    }, 30);
                                                                }
                                                            }
                                                    });
                                                }
                                            }, 30);
                                        }
                                    }
                            });
                        }
                    }, 30);
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






// Fin de la función
});
