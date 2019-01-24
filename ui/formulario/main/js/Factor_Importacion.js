$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikFactorImportacion/";

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // Barra de menú superior del plan de compra
    $("#toolbar_lead_time").kendoToolBar({
        items: [
            {
                type: "button",
                text: "Volver",
                id: "volver_atras_c1",
                //click: volver_atras_c1
            },
            { type: "separator" },
            {
                type: "button",
                text: "Salir",
                id: "salir_c1",
      //          click: salir_c1,
                overflow: "always"
            }
        ]
    });


//#region /*----------DroplistGrilla---------*/
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
                            url: crudServiceBaseUrl +"ListarVia",
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de Pais emb
    function PaisEmbDropDownEditor(container, options) {
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
                            url: crudServiceBaseUrl +"ListarPais",
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de Pto emb
    function PtoEmbDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "COD_PUERTO",
                dataValueField: "NOM_PUERTO",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl +"ListarPuertos",
                            data:{PAIS:String(options.model.COD_PAIS_EMB)},
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de Pto emb
    function PaisdestDropDownEditor(container, options) {
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
                            url: crudServiceBaseUrl +"ListarPaisDest",
                            data:{PAIS:String(options.model.COD_PAIS_EMB)},
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de Pto dest
    function PtodestDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "COD_PUERTO",
                dataValueField: "NOM_PUERTO",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl +"ListarPuertos",
                            data:{PAIS:String(options.model.COD_PAIS_DESTINO)},
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de incoterm
    function IncotermDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "COD_INCOTERM",
                dataValueField: "NOM_INCOTERM",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl +"ListarIncoterm",
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de Division
    function DivisionDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "COD_DIVISION",
                dataValueField: "NOM_DIVISION",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl +"ListarDivisiones",
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de Departamento
    function DepartamentoDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "DEP_DEPTO",
                dataValueField: "DEP_DESCRIPCION",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl +"ListarDeptoxDivision",
                            data:{DIVISION:String(options.model.COD_DIV)},
                            dataType: "json"
                        }
                    }
                }
            });
    }
    // CBX de Marca
    function MarcaDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "COD_MARCA",
                dataValueField: "NOM_MARCA",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl +"ListarMarcaxDepto",
                            data:{Depto:String(options.model.DEP_DEPTO)},
                            dataType: "json"
                        }
                    }
                }
            });
    }
//#endregion

//#region /*----------Listar Grid---------*/
    // Definimos DataSource
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "List_factor_Importacion",
                dataType: "json"
            }
            /*update: {
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
                id: "ID_FACTOR_IMPORT",
                fields: {
                    COD_VIA: { type: "string" }, // number - string - date
                    COD_PAIS_EMB: { type: "string" }, // number - string - date
                    COD_PUERTO_EMB: { type: "string" }, // number - string - date
                    COD_PAIS_DESTINO: { type: "string" }, // number - string - date
                    COD_PUERTO_DESTINO: { type: "string" }, // number - string - date
                    COD_INCOTERM: { type: "string" }, // number - string - date
                    COD_DIV: { type: "string" }, // number - string - date
                    DEP_DEPTO: { type: "string" }, // number - string - date
                    COD_MARCA: { type: "string" }, // number - string - date
                    COD_TIP_MON: { type: "string" }, // number - string - date
                    FACTOR_ESTIMADO: { type: "number" }, // number - string - date
                    FACTOR_REAL: { type: "number" } // number - string - date
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
    $("#grilla_factor_importado").kendoGrid({
        dataSource: dataSource,
        editable: true,
        toolbar: [
            { name:"Add", text: "Nuevo Factor",iconClass: "k-icon k-i-plus"},
            { name: "save", text: "Guardar", iconClass: "k-icon k-i-save" },
            { name: "cancel", text: "Cancelar Modificaciones" }
        ],
        height: 550, // Altura del Grid
        resizable: true,
        //selectable: "multiple",
        filterable: true,
        sortable: true, // Se puede ordenar
        columns: [ // Columnas a Listar
            {field: "ID_FACTOR_IMPORT", hidden: true},
            {field: "COD_VIA",title: "Vía Trans.",width: 100 ,attributes: {style:"font-size: 11px"}, editor: ViaDropDownEditor,filterable: {multi: true }},
            {field: "COD_PAIS_EMB",title: "País Emb.",width: 100,attributes: {style:"font-size: 11px"}, editor: PaisEmbDropDownEditor,filterable: {multi: true }},
            {field: "COD_PUERTO_EMB",title: "Pto Emb.",width: 100,attributes: {style:"font-size: 11px"}, editor: PtoEmbDropDownEditor,filterable: {multi: true }},
            {field: "COD_PAIS_DESTINO",title: "País Dest.",width: 100,attributes: {style:"font-size: 11px"}, editor: PaisdestDropDownEditor,filterable: {multi: true }},
            {field: "COD_PUERTO_DESTINO",title: "Pto Dest.",width: 100,attributes: {style:"font-size: 11px"}, editor: PtodestDropDownEditor,filterable: {multi: true }},
            {field: "COD_INCOTERM",title: "Incoterm",width: 80,attributes: {style:"font-size: 11px"}, editor: IncotermDropDownEditor,filterable: {multi: true }},
            {field: "COD_DIV",title: "Division",width: 100,attributes: {style:"font-size: 11px"}, editor: DivisionDropDownEditor,filterable: {multi: true }},
            {field: "DEP_DEPTO",title: "Departamento",width: 150,attributes: {style:"font-size: 11px"}, editor: DepartamentoDropDownEditor,filterable: {multi: true }},
            {field: "COD_MARCA",title: "Marca",width: 100,attributes: {style:"font-size: 11px"}, editor: MarcaDropDownEditor,filterable: {multi: true }},
            {field: "COD_TIP_MON",title: "Moneda",width: 95,attributes: {style:"font-size: 11px"}},
            {field: "FACTOR_ESTIMADO",title: "F.Est.",width: 70,attributes: {style:"font-size: 11px"}},
            {field: "FACTOR_REAL",title: "F.Comex",width: 70,attributes: {style:"font-size: 11px"}}
        ]
    });
//#endregion

//#region /*----------POPPUP---------*/
    var ventana_addfactor = $("#POPUP_addfactor");
    ventana_addfactor.kendoWindow({
        width: "750px",
        height: "500px",
        title: "Factor de Importación",//+res_temp_depto_match[1]
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
        close: cerrarPopUpLeadTime*/
    }).data("kendoWindow").center();
//#endregion

//#region /*----------Botones---------*/
    /*BTN NUEVO FACTOR*/
    $(".k-grid-Add").click(function(e){
        var popupaddFactor = $("#POPUP_addfactor");
        popupaddFactor.data("kendoWindow").open();
    });

    /*BTN CREAR FACTOR*/
    $("form").submit(function(event) {
        event.preventDefault();
        if (validator.validate()) {
            // Seteamos Variables
            var via = $("#COD_VIA").data("kendoComboBox").value(); //$("#COD_VIA").val();
            var pais_emb = $("#COD_PAIS_EMB").data("kendoComboBox").value(); //$("#COD_PAIS_EMB").val();
            var pto_embarque = $("#COD_PUERTO_EMB").data("kendoComboBox").value(); //$("#COD_PUERTO_EMB").val();
            var pais_dest = $("#COD_PAIS_DES").data("kendoComboBox").value(); //$("#COD_PAIS_DES").val();
            var pto_destino = $("#COD_PUERTO_DESTINO").data("kendoComboBox").value(); //$("#COD_PUERTO_DESTINO").val();
            var incoterm = $("#COD_INCOTERM").data("kendoComboBox").value(); //$("#COD_INCOTERM").val();
            var division = $("#COD_DIVISION").data("kendoComboBox").value(); //$("#COD_DIVISION").val();
            var departamento = $("#DEP_DEPTO").data("kendoComboBox").value(); //$("#DEP_DEPTO").val();
            var marca = $("#COD_MARCA").data("kendoComboBox").value(); //$("#COD_MARCA").val();
            var moneda = $("#COD_MONEDA").data("kendoComboBox").value(); //$("#COD_MONEDA").val();
            var factor_est = $("#factor_est").val();

            $.ajax({
                //type: "POST",
                url:   crudServiceBaseUrl + "_existeFactor",
                data: { VIA:String(via),
                    PAIS_EMB:String(pais_emb),
                    PTO_EMBARQUE:String(pto_embarque),
                    PAIS_DEST:String(pais_dest),
                    PTO_DESTINO:String(pto_destino),
                    INCOTERM:String(incoterm),
                    DIVISION:String(division),
                    DEPARTAMENTO:String(departamento),
                    MARCA:String(marca),
                    MONEDA:String(moneda)},
                dataType: "json",
                success: function (result) {
                    if(result>0){
                        // Mensaje
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show("Ya se encuentra registrado este factor", "info");
                    }else{
                        $.ajax({
                            //type: "POST",
                            url:   crudServiceBaseUrl + "InsertFactorImport",
                            data: { VIA:String(via),
                                PAIS_EMB:String(pais_emb),
                                PTO_EMBARQUE:String(pto_embarque),
                                PAIS_DEST:String(pais_dest),
                                PTO_DESTINO:String(pto_destino),
                                INCOTERM:String(incoterm),
                                DIVISION:String(division),
                                DEPARTAMENTO:String(departamento),
                                MARCA:String(marca),
                                MONEDA:String(moneda),
                                FACTOR_EST:kendo.parseFloat(factor_est)},
                            dataType: "json",
                            success: function (result) {

                                if(result=="OK"){
                                    // Recargar El Grid
                                    dataSource.read();
                                    // Limpiar todos los campos del Formulario
                                    $("#COD_VIA").data("kendoComboBox").value("");
                                    $("#COD_PAIS_EMB").data("kendoComboBox").value("");
                                    $("#COD_PUERTO_EMB").data("kendoComboBox").value("");
                                    $("#COD_PAIS_DES").data("kendoComboBox").value("");
                                    $("#COD_PUERTO_DESTINO").data("kendoComboBox").value("");
                                    $("#COD_INCOTERM").data("kendoComboBox").value("");
                                    $("#COD_DIVISION").data("kendoComboBox").value("");
                                    $("#DEP_DEPTO").data("kendoComboBox").value("");
                                    $("#COD_MARCA").data("kendoComboBox").value("");
                                    $("#COD_MONEDA").data("kendoComboBox").value("");
                                    $("#factor_est").val(0);

                                    // Mensaje
                                    popupNotification.getNotifications().parent().remove();
                                    popupNotification.show(" Factor ingresado correctamente.", "success");

                                    // Cerrar PopUp
                                    var popupfactor = $("#POPUP_addfactor");
                                    popupfactor.data("kendoWindow").close();

                                }else{
                                    // Mensaje
                                    popupNotification.getNotifications().parent().remove();
                                    popupNotification.show(" No se pudo guardar el Factor.", "error");
                                }
                            },
                            error: function (xhr, httpStatusMessage, customErrorMessage) {
                                popupNotification.getNotifications().parent().remove();
                                popupNotification.show(" Se produjo un error en el guardado.", "error");
                            }
                        });
                    }
                }
            });




        } else {
            // status.text("Oops! There is invalid data in the form.").removeClass("valid").addClass("invalid");
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Existe datos no válidos en el formulario.", "info");
        }
    });
//#endregion

//#region /*----------Comboboxs---------*/
    // Seteo DataSet Puerto Embarque
    var dataSource_puerto_embarque = new kendo.data.DataSource({
        transport: {
            read: {
                dataType: "json",
                url: crudServiceBaseUrl +"ListarPuertos",
                data: function() {
                    return { PAIS: $("#COD_PAIS_EMB").data("kendoComboBox").value() };
                }
            }
        }
    });

    // Seteo DataSet pais destino
    var dataSource_pais_destino = new kendo.data.DataSource({
        transport: {
            read: {
                dataType: "json",
                url: crudServiceBaseUrl +"ListarPaisDest",
                data: function() {
                    return { PAIS: $("#COD_PAIS_EMB").data("kendoComboBox").value() };
                }
            }
        }
    });

    // Seteo DataSet Puerto Destino
    var dataSource_puerto_destino = new kendo.data.DataSource({
        transport: {
            read: {
                dataType: "json",
                url: crudServiceBaseUrl +"ListarPuertos",
                data: function() {
                    return { PAIS: $("#COD_PAIS_DES").data("kendoComboBox").value() };
                }
            }
        }
    });

    // Seteo DataSet departamento
    var dataSource_departamento = new kendo.data.DataSource({
        transport: {
            read: {
                dataType: "json",
                url: crudServiceBaseUrl +"ListarDeptoxDivision",
                data: function() {
                    return { DIVISION: $("#COD_DIVISION").data("kendoComboBox").value()};
                }
            }
        }
    });

    // Seteo DataSet marca
    var dataSource_marca = new kendo.data.DataSource({
        transport: {
            read: {
                dataType: "json",
                url: crudServiceBaseUrl +"ListarMarcaxDepto",
                data: function() {
                    return { Depto: $("#DEP_DEPTO").data("kendoComboBox").value()};
                }
            }
        }
    });

    // CBX VIA_PTE
    var COD_VIA = $("#COD_VIA").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Vía",
        dataTextField: "NOM_VIA",
        dataValueField: "COD_VIA",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarVia"
                }
            }
        }
    }).data("kendoComboBox");

    // CBX PAIS_EMB
    var COD_PAIS_EMB = $("#COD_PAIS_EMB").kendoComboBox({
        autoBind: false,
        //cascadeFrom: "COD_VIA",
        optionLabel: "Seleccione País",
        dataTextField: "CNTRY_NAME",
        dataValueField: "CNTRY_LVL_CHILD",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url:  crudServiceBaseUrl + "ListarPais"
                }
            }
        },
        change: function(e) {
            var dataItem = e.sender.dataItem();
            if(dataItem){
                $("#COD_PUERTO_EMB").data("kendoComboBox").value("");
                dataSource_puerto_embarque.read();
                dataSource_pais_destino.read();
            }

        }
    }).data("kendoComboBox");

    // CBX PUERTOS_EMB
    var COD_PUERTO_EMB = $("#COD_PUERTO_EMB").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Embarque",
        dataTextField: "NOM_PUERTO",
        dataValueField: "COD_PUERTO",
        dataSource : dataSource_puerto_embarque
    }).data("kendoComboBox");

    // CBX PAIS_DEST
    var COD_PAIS_DEST= $("#COD_PAIS_DES").kendoComboBox({
        autoBind: false,
        //cascadeFrom: "COD_VIA",
        optionLabel: "Seleccione País",
        dataTextField: "CNTRY_NAME",
        dataValueField: "CNTRY_LVL_CHILD",
        dataSource : dataSource_pais_destino,
        change: function(e) {
            var dataItem = e.sender.dataItem();
            if(dataItem){
                $("#COD_PUERTO_DESTINO").data("kendoComboBox").value("");
                dataSource_puerto_destino.read();
            }

        }
    }).data("kendoComboBox");

    // CBX COD_PUERTO_DEST
    var COD_PUERTO_DEST = $("#COD_PUERTO_DESTINO").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Embarque",
        dataTextField: "NOM_PUERTO",
        dataValueField: "COD_PUERTO",
        dataSource : dataSource_puerto_destino
    }).data("kendoComboBox");

    // CBX COD_INCOTERM
    var COD_INCOTERM = $("#COD_INCOTERM").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Incoterm",
        dataTextField: "NOM_INCOTERM",
        dataValueField: "COD_INCOTERM",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarIncoterm"
                }
            }
        }
    }).data("kendoComboBox");

    // CBX DIVISION
    var COD_DIVISION = $("#COD_DIVISION").kendoComboBox({
        autoBind: false,
        //cascadeFrom: "COD_VIA",
        optionLabel: "Seleccione Division",
        dataTextField: "NOM_DIVISION",
        dataValueField: "COD_DIVISION",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url:  crudServiceBaseUrl + "ListarDivisiones"
                }
            }
        },
        change: function(e) {
            var dataItem = e.sender.dataItem();
            if(dataItem){
                $("#DEP_DEPTO").data("kendoComboBox").value("");
                dataSource_departamento.read();
                dataSource_pais_destino.read();
            }

        }
    }).data("kendoComboBox");

    // CBX DEP_DEPTO
    var COD_DEP_DEPTO = $("#DEP_DEPTO").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Departamento",
        dataTextField: "DEP_DEPTO",
        dataValueField: "DEP_DESCRIPCION",
        dataSource : dataSource_departamento,
        change: function(e) {
            var dataItem = e.sender.dataItem();
            if(dataItem){
                $("#COD_MARCA").data("kendoComboBox").value("");
                dataSource_marca.read();
            }

        }
    }).data("kendoComboBox");

    // CBX MARCA
    var COD_MARCA = $("#COD_MARCA").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Marca",
        dataTextField: "COD_MARCA",
        dataValueField: "NOM_MARCA",
        dataSource : dataSource_marca
    }).data("kendoComboBox");

    // CBX COD_MONEDA
    var COD_MONEDA = $("#COD_MONEDA").kendoComboBox({
        autoBind: false,
        optionLabel: "Seleccione Moneda",
        dataTextField: "COD_TIP_MON",
        dataValueField: "NOM_TIP_MON",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListartipoMoneda"
                }
            }
        }
    }).data("kendoComboBox");

    //#endregion

    $("#factor_est").kendoNumericTextBox({format: "{0:n2}"});

    var validator = $("#addfactorForm").kendoValidator().data("kendoValidator"),
        status = $(".status");




});
