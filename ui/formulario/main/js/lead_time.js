$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikLeadTime/";

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // BTN Volver a C1
    function volver_atras_c1(e) {
        window.location.href = "inicio";
    }

    // BTN salir C1
    function salir_c1(e) {

        $("#grid").data("kendoSpreadsheet").destroy();
        $("#grid").empty();
        $("#grid").remove();

        window.location.href = "salir";

    }

    // Barra de menú superior del plan de compra
    $("#toolbar_lead_time").kendoToolBar({
        items: [
            {
                type: "button",
                text: "Volver",
                id: "volver_atras_c1",
                click: volver_atras_c1
            },
            { type: "separator" },
            {
                type: "button",
                text: "Salir",
                id: "salir_c1",
                click: salir_c1,
                overflow: "always"
            }
        ]
    });

    var ventana_match = $("#POPUP_leadtime");
    ventana_match.kendoWindow({
        width: "750px",
        height: "550px",
        title: "Lead Time",//+res_temp_depto_match[1]
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
        close: cerrarPopUpLeadTime*/
    }).data("kendoWindow").center();


    // CBX de Vía
    function ViaDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "NOM_VIA",
                dataValueField: "COD_VIA",
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikLeadTime/ListarVia",
                            dataType: "json"/*
                                            type: "POST"*/
                        }
                    }
                }
            });
    }

    // CBX de País
    function PaisDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "CNTRY_NAME",
                dataValueField: "CNTRY_LVL_CHILD",
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikLeadTime/ListarPais",
                            dataType: "json"/*
                                            type: "POST"*/
                        }
                    }
                }
            });
    }

    // CBX de Puerto Embarque
    function EmbarqueDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "NOM_PUERTO",
                dataValueField: "COD_PUERTO",
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikLeadTime/ListarEmbarque",
                            data:{PAIS:String(options.model.CNTRY_LVL_CHILD)},
                            dataType: "json"/*
                                            type: "POST"*/
                        }
                    }
                }
            });
    }

    // CBX de Puerto Destino
    function DestinoDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "NOM_PUERTO",
                dataValueField: "COD_PUERTO",
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikLeadTime/ListarDestino",
                            dataType: "json"/*
                                            type: "POST"*/
                        }
                    }
                }
            });
    }

    // CBX de Depto
    function DeptoDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "DEP_DESCRIPCION",
                dataValueField: "DEP_DEPTO",
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikLeadTime/ListarDepto",
                            dataType: "json"/*
                                            type: "POST"*/
                        }
                    }
                }//,select: CambiaLineaMatchDropDown
            });
    }

    // CBX de Línea
    function LineaDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "LIN_DESCRIPCION",
                dataValueField: "LIN_LINEA",
                dataSource: {
                    transport: {
                        read:  {
                            url: "TelerikLeadTime/ListarLinea",
                            //data:{LINEA:kendo.parseInt(OC)},
                            data:{DEPTOCBX:String(options.model.DEP_DEPTO)},
                            dataType: "json"
                        }
                    }
                }
            });
    }

    // Cuando Termina la Carga del DataSet de Lead Time
    function TerminaCargaLeadTime(container, options) {
        dataSource.read();
    }

    // Definimos DataSource
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "ListarLeadTime",
                dataType: "json"
            },
            update: {
                url: crudServiceBaseUrl + "ActualizaLeadTime",
                dataType: "json"
            }/*,
            // Quitar si sólo estamos listando data
            parameterMap: function(options, operation) {
                if (operation !== "read" && options.models) {
                    return {models: kendo.stringify(options.models)};
                }
            }*/
        },
        //requestEnd: TerminaCargaLeadTime,
        schema: {
            model: {
                id: "ID_TRANSITO",
                fields: {
                    COD_TEMPORADA: { type: "number" }, // number - string - date
                    COD_VIA: { type: "string" }, // number - string - date
                    CNTRY_LVL_CHILD: { type: "string" }, // number - string - date
                    COD_PUERTO_EMB: { type: "string" }, // number - string - date
                    COD_PUERTO_DESTINO: { type: "string" }, // number - string - date
                    LIN_LINEA: { type: "string" }, // number - string - date
                    DEP_DEPTO: { type: "string" }, // number - string - date
                    D_TRANSITO: { type: "number" }, // number - string - date
                    D_PUERTO_CD: { type: "number" }, // number - string - date
                    D_TIENDAS_CD: { type: "number" }, // number - string - date
                    T_DIAS_SUCURS: { type: "number" }, // number - string - date
                    COD_VENTANA_EMB: { type: "number" }, // number - string - date
                    FIRST_FORWARDER: { type: "number" },    // number - string - date
                    LASTEST_FORWARDER: { type: "number" }    // number - string - date
                }
            }
        },
        change: function () {

        },requestEnd: function (e) {

            if ( (e.type === 'update') || (e.type === 'create') ) {
                window.location.href = "lead_time";
            }

        }
    });

    // Definimos KendoGrid
    $("#grid").kendoGrid({
        dataSource: dataSource,
        editable: true,
        toolbar: [
            { name:"agregaleadtime", text: "Nuevo Lead Time"},
            { name: "save", text: "Actualizar Registros", iconClass: "k-icon k-i-copy" },
            { name: "cancel", text: "Cancelar Modificaciones" }
        ],
        height: 550, // Altura del Grid
        resizable: true,
        //selectable: "multiple",
        filterable: true,
        sortable: true, // Se puede ordenar
        columns: [ // Columnas a Listar
            {field: "ID_TRANSITO", hidden: true},
            {field: "COD_TEMPORADA", hidden: true},
            {field: "COD_VIA",title: "Vía Tpte.",width: 120, editor: ViaDropDownEditor,filterable: {
                    multi: true /*,
                    dataSource: {
                        transport: {
                            read: {
                                url: crudServiceBaseUrl + "ListarVia",
                                dataType: "json",
                                data: {
                                    field: "COD_VIA"
                                }
                            }
                        }
                    }*/
                }},
            {field: "CNTRY_LVL_CHILD",title: "País",width: 190, editor: PaisDropDownEditor,filterable: {
                    multi: true /*,
                    dataSource: {
                        transport: {
                            read: {
                                url: crudServiceBaseUrl + "ListarPais",
                                dataType: "json",
                                data: {
                                    field: "CNTRY_LVL_CHILD"
                                }
                            }
                        }
                    }*/
                }},
            {field: "COD_PUERTO_EMB",title: "Puerto Embarque",width: 200, editor: EmbarqueDropDownEditor,filterable: {
                    multi: true /*,
                    dataSource: {
                        transport: {
                            read: {
                                url: crudServiceBaseUrl + "ListarEmbarque",
                                dataType: "json",
                                data: {
                                    field: "COD_PUERTO_EMB"
                                }
                            }
                        }
                    }*/
                }},
            {field: "COD_PUERTO_DESTINO",title: "Puerto Destino",width: 150, editor: DestinoDropDownEditor,filterable: {
                    multi: true /*,
                    dataSource: {
                        transport: {
                            read: {
                                url: crudServiceBaseUrl + "ListarDestino",
                                dataType: "json",
                                data: {
                                    field: "NOM_PUERTO"
                                }
                            }
                        }
                    }*/
                }},
            {field: "DEP_DEPTO",title: "Depto",width: 200, editor: DeptoDropDownEditor,filterable: {
                    multi: true /*,
                    dataSource: {
                        transport: {
                            read: {
                                url: crudServiceBaseUrl + "ListarDepto",
                                dataType: "json",
                                data: {
                                    field: "DEP_DEPTO"
                                }
                            }
                        }
                    }*/
                }},
            {field: "LIN_LINEA",title: "Línea",width: 200, editor: LineaDropDownEditor,filterable: {
                    multi: true /*,
                    dataSource: {
                        transport: {
                            read: {
                                url: crudServiceBaseUrl + "ListarLinea",
                                dataType: "json",
                                data: {
                                    field: "LIN_LINEA"
                                }
                            }
                        }
                    }*/
                }},
            {field: "D_TRANSITO",title: "Tránsito",width: 90,filterable: {
                    multi: true
                }},
            {field: "D_PUERTO_CD",title: "Puerto/CD",width: 120,filterable: {
                    multi: true
                }},
            {field: "D_TIENDAS_CD",title: "CD/Tienda",width: 120,filterable: {
                    multi: true
                }},
            {field: "T_DIAS_SUCURS",title: "Total Días Sucursal",width: 120,filterable: {
                    multi: true
                }},
            {field: "COD_VENTANA_EMB",title: "Ventana Emb",width: 120,filterable: {
                    multi: true
                }},
            {field: "FIRST_FORWARDER",title: "1° Forwarder",width: 120,filterable: {
                    multi: true
                }},
            {field: "LASTEST_FORWARDER",title: "2° Forwarder",width: 120,filterable: {
                    multi: true
                }}
        ]
    });

    // BTN Crear Registro
    $(".k-grid-agregaleadtime").click(function(e){
        var popupLeadTime = $("#POPUP_leadtime");
        popupLeadTime.data("kendoWindow").open();
    });


    // CBX de Vía
    var COD_VIA = $("#COD_VIA").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Vía",
        dataTextField: "NOM_VIA",
        dataValueField: "COD_VIA",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: "TelerikLeadTime/ListarVia"
                }
            }
        }
    }).data("kendoComboBox");

    // Seteo DataSet Puerto Embarque
    var dataSource_puerto_embarque = new kendo.data.DataSource({
        transport: {
            read: {
                dataType: "json",
                url: "TelerikLeadTime/ListarEmbarque",
                data: function() {
                    return { PAIS: $("#CNTRY_LVL_CHILD").data("kendoComboBox").value() };
                }
            }
        }
    });

    // CBX de País
    var CNTRY_LVL_CHILD = $("#CNTRY_LVL_CHILD").kendoComboBox({
        autoBind: false,
        //cascadeFrom: "COD_VIA",
        optionLabel: "Seleccione País",
        dataTextField: "CNTRY_NAME",
        dataValueField: "CNTRY_LVL_CHILD",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: "TelerikLeadTime/ListarPais"
                }
            }
        },
        change: function(e) {
            var dataItem = e.sender.dataItem();

            if(dataItem){
                $("#COD_PUERTO_EMB").data("kendoComboBox").value("");
                dataSource_puerto_embarque.read();
            }

        }
    }).data("kendoComboBox");

    // CBX de ListarEmbarque
    var COD_PUERTO_EMB = $("#COD_PUERTO_EMB").kendoComboBox({
        autoBind: false,
        //cascadeFrom: "CNTRY_LVL_CHILD",
        optionLabel: "Seleccione Embarque",
        dataTextField: "NOM_PUERTO",
        dataValueField: "COD_PUERTO",
        dataSource : dataSource_puerto_embarque
        /*dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: "TelerikLeadTime/ListarEmbarque",
                    data: function() {
                        return { PAIS: $("#CNTRY_LVL_CHILD").val() };
                    }
                }
            }
        }*/
    }).data("kendoComboBox");

    // CBX de Destino
    var COD_PUERTO_DESTINO = $("#COD_PUERTO_DESTINO").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Destino",
        dataTextField: "NOM_PUERTO",
        dataValueField: "COD_PUERTO",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: "TelerikLeadTime/ListarDestino"
                }
            }
        }
    }).data("kendoComboBox");

    // Seteo DataSet Linea
    var dataSource_linea = new kendo.data.DataSource({
        transport: {
            read: {
                dataType: "json",
                url: "TelerikLeadTime/ListarLinea",
                data: function() {
                    return { DEPTOCBX: $("#DEP_DEPTO").data("kendoComboBox").value() };
                }
            }
        }
    });

    // CBX de Depto
    var DEP_DEPTO = $("#DEP_DEPTO").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Departamento",
        dataTextField: "DEP_DESCRIPCION",
        dataValueField: "DEP_DEPTO",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: "TelerikLeadTime/ListarDepto"
                }
            }
        },
        change: function(e) {
            var dataItem = e.sender.dataItem();

            if(dataItem){
                $("#LIN_LINEA").data("kendoComboBox").value("");
                dataSource_linea.read();
            }

        }
    }).data("kendoComboBox");

    // CBX de Línea
    var LIN_LINEA = $("#LIN_LINEA").kendoComboBox({
        autoBind: false,
        //cascadeFrom: "CNTRY_LVL_CHILD",
        optionLabel: "Seleccione Línea",
        dataTextField: "LIN_DESCRIPCION",
        dataValueField: "LIN_LINEA",
        dataSource: dataSource_linea
        /*dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: "TelerikLeadTime/ListarLinea",
                    data: function() {
                        return { DEPTOCBX: $("#DEP_DEPTO").val() };
                    }
                }
            }
        }*/
    }).data("kendoComboBox");

    // TXTBX Tránsito
    $("#D_TRANSITO").kendoNumericTextBox({format: "# Días"});

    // TXTBX Puerto CD
    $("#D_PUERTO_CD").kendoNumericTextBox({format: "# Días"});

    // TXTBX CD Tienda
    $("#D_TIENDAS_CD").kendoNumericTextBox({format: "# Días"});

    // TXTBX Total Días Sucursal
    $("#T_DIAS_SUCURS").kendoNumericTextBox({format: "# Días"});

    // TXTBX Ventana Embarque
    $("#COD_VENTANA_EMB").kendoNumericTextBox({format: "# Días"});

    // TXTBX 1° Forwarder
    $("#FIRST_FORWARDER").kendoNumericTextBox({format: "# Días"});

    // TXTBX Last Forwarder
    $("#LASTEST_FORWARDER").kendoNumericTextBox({format: "# Días"});


    var validator = $("#LeadTimeForm").kendoValidator().data("kendoValidator"),
        status = $(".status");

    $("form").submit(function(event) {
        event.preventDefault();
        if (validator.validate()) {
            // Seteamos Variables
            var via = $("#COD_VIA").data("kendoComboBox").value(); //$("#COD_VIA").val();
            var pais = $("#CNTRY_LVL_CHILD").data("kendoComboBox").value(); //$("#CNTRY_LVL_CHILD").val();
            var embarque = $("#COD_PUERTO_EMB").data("kendoComboBox").value(); //$("#COD_PUERTO_EMB").val();
            var destino = $("#COD_PUERTO_DESTINO").data("kendoComboBox").value(); //$("#COD_PUERTO_DESTINO").val();
            var departamento = $("#DEP_DEPTO").data("kendoComboBox").value(); //$("#DEP_DEPTO").val();
            var linea = $("#LIN_LINEA").data("kendoComboBox").value(); //$("#LIN_LINEA").val();
            var transito = $("#D_TRANSITO").val();
            var puertocd = $("#D_PUERTO_CD").val();
            var cdtienda = $("#D_TIENDAS_CD").val();
            var total_dias_sucursal = $("#T_DIAS_SUCURS").val();
            var ventana_embarque = $("#COD_VENTANA_EMB").val();
            var first_forwarder = $("#FIRST_FORWARDER").val();
            var lastest_forwarder = $("#LASTEST_FORWARDER").val();

            $.ajax({
                //type: "POST",
                url: "TelerikLeadTime/CrearLeadTime",
                    data: { VIA:String(via),
                            PAIS:String(pais),
                            EMBARQUE:String(embarque),
                            DESTINO:String(destino),
                            DEPARTAMENTO:String(departamento),
                            LINEA:String(linea),
                            TRANSITO:kendo.parseInt(transito),
                            PUERTOCD:kendo.parseInt(puertocd),
                            CDTIENDA:kendo.parseInt(cdtienda),
                            TOTAL_DIAS_SUCURSAL:kendo.parseInt(total_dias_sucursal),
                            VENTANA_EMBARQUE:kendo.parseInt(ventana_embarque),
                            FIRST_FORWARDER:kendo.parseInt(first_forwarder),
                            LASTEST_FORWARDER:kendo.parseInt(lastest_forwarder)},
                dataType: "json",
                success: function (result) {

                    if(result=="OK"){

                        // Recargar El Grid
                        dataSource.read();

                        // Limpiar todos los campos del Formulario
                        $("#COD_VIA").data("kendoComboBox").value("");
                        $("#CNTRY_LVL_CHILD").data("kendoComboBox").value("");
                        $("#COD_PUERTO_EMB").data("kendoComboBox").value("");
                        $("#COD_PUERTO_DESTINO").data("kendoComboBox").value("");
                        $("#DEP_DEPTO").data("kendoComboBox").value("");
                        $("#LIN_LINEA").data("kendoComboBox").value("");
                        $("#D_TRANSITO").val("");
                        $("#D_PUERTO_CD").val("");
                        $("#D_TIENDAS_CD").val("");
                        $("#T_DIAS_SUCURS").val("");
                        $("#COD_VENTANA_EMB").val("");
                        $("#FIRST_FORWARDER").val("");
                        $("#LASTEST_FORWARDER").val("");

                        // Mensaje
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" Lead Time ingresado correctamente.", "success");

                        // Cerrar PopUp
                        var popupLeadTime = $("#POPUP_leadtime");
                        popupLeadTime.data("kendoWindow").close();

                    }else{
                        // Mensaje
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" No se pudo guardar el Lead Time.", "error");
                    }


                },
                error: function (xhr, httpStatusMessage, customErrorMessage) {
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Se produjo un error en el guardado.", "error");
                }
            });

        } else {
            // status.text("Oops! There is invalid data in the form.").removeClass("valid").addClass("invalid");
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Existe datos no válidos en el formulario.", "info");
        }
    });


// Fin del document ready
});
