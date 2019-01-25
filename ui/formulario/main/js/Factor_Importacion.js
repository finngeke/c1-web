$(function () {

    kendo.ui.progress.messages = {
        loading: "Processing..."
    };

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikFactorImportacion/";
    var crudServiceBaseUrlpost = "TelerikFactorImportacion2/";
    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // BTN Volver a C1
    function volver_atras_c1(e) {
        window.location.href = "inicio";
    }

    // BTN salir C1
    function salir_c1(e) {

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
    // CBX de Pais emb
    function MonedaDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "COD_TIP_MON",
                dataValueField: "NOM_TIP_MON",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl +"ListartipoMoneda",
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
            },
            update: {
                url: crudServiceBaseUrl + "updateFactorImport",
                dataType: "json"
                }
        },
        //requestEnd: TerminaCargaLeadTime,
        schema: {
            model: {
                id: "ID_FACTOR",
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
                    FACTOR_REAL: { type: "number" ,editable: false} // number - string - date
                }
            }
        },
        change: function () {
        },requestEnd: function (e) {
            if (e.type === 'update'){
               if (e.response === 'OK'){
                    window.location.href = "Factor_Importacion";
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Factor actualizado correctamente.", "success");
                }else{
                    dataSource.fetch();
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(e.response, "info");
                }
            }
        }
    });

    // Definimos KendoGrid
    $("#grilla_factor_importado").kendoGrid({
        dataSource: dataSource,
        editable: true,
        toolbar: [
            { name:"Agregar", text: "Agregar",iconClass: "k-icon k-i-plus"},
            { name: "save", text: "Guardar", iconClass: "k-icon k-i-save"},
            { name: "Eliminar", text: "Eliminar", iconClass: "k-icon k-i-delete"},
            { name: "cancel", text: "Limpiar",iconClass: "k-icon k-i-strip-all-formating"},
            { name: "excel", text: "Exportar",iconClass: "k-icon k-i-file-xls"}
        ],
        height: 550, // Altura del Grid
        resizable: true,
        filterable: true,
        sortable: true, // Se puede ordenar
        change: onChangeID_FACTOR,
        columns: [ // Columnas a Listar
            {selectable: true, width: "50px" },
            {field: "ID_FACTOR", hidden: true},
            {field: "COD_VIA",title: "Vía Trans.",width: 100 ,attributes: {style:"font-size: 11px"}, editor: ViaDropDownEditor,filterable: {multi: true }},
            {field: "COD_PAIS_EMB",title: "País Emb.",width: 100,attributes: {style:"font-size: 11px"}, editor: PaisEmbDropDownEditor,filterable: {multi: true }},
            {field: "COD_PUERTO_EMB",title: "Pto Emb.",width: 100,attributes: {style:"font-size: 11px"}, editor: PtoEmbDropDownEditor,filterable: {multi: true }},
            {field: "COD_PAIS_DESTINO",title: "País Dest.",width: 100,attributes: {style:"font-size: 11px"}, editor: PaisdestDropDownEditor,filterable: {multi: true }},
            {field: "COD_PUERTO_DESTINO",title: "Pto Dest.",width: 100,attributes: {style:"font-size: 11px"}, editor: PtodestDropDownEditor,filterable: {multi: true }},
            {field: "COD_INCOTERM",title: "Incoterm",width: 80,attributes: {style:"font-size: 11px"}, editor: IncotermDropDownEditor,filterable: {multi: true }},
            {field: "COD_DIV",title: "Division",width: 100,attributes: {style:"font-size: 11px"}, editor: DivisionDropDownEditor,filterable: {multi: true }},
            {field: "DEP_DEPTO",title: "Departamento",width: 150,attributes: {style:"font-size: 11px"}, editor: DepartamentoDropDownEditor,filterable: {multi: true }},
            {field: "COD_MARCA",title: "Marca",width: 100,attributes: {style:"font-size: 11px"}, editor: MarcaDropDownEditor,filterable: {multi: true }},
            {field: "COD_TIP_MON",title: "Moneda",width: 95,attributes: {style:"font-size: 11px"}, editor: MonedaDropDownEditor,filterable: {multi: true }},
            {field: "FACTOR_ESTIMADO",title: "F.Est.",width: 70,attributes: {style: "font-size: 11px; color: red"}},
            {field: "FACTOR_REAL",title: "F.Comex",width: 70,attributes: {style:"font-size: 11px"}}
        ],
        excelExport: function(e) {
            e.workbook.fileName = "Factor Importacion.xlsx";
        }
    });
    $(".k-grid-Eliminar").addClass("k-state-disabled").removeClass("k-grid-add");
    function onChangeID_FACTOR(arg) {
        $('#iddelete').val(this.selectedKeyNames().join(", "));
        if ($('#iddelete').val() != "" && $('#iddelete').val() != ""){
            $(".k-grid-Eliminar").removeClass("k-state-disabled").addClass("k-grid-add");
            $(".k-grid-Agregar").addClass("k-state-disabled").removeClass("k-grid-add");
            $(".k-grid-cancel-changes").addClass("k-state-disabled").removeClass("k-grid-add");
        }else{
            $(".k-grid-Eliminar").addClass("k-state-disabled").removeClass("k-grid-add");
            $(".k-grid-Agregar").removeClass("k-state-disabled").addClass("k-grid-add");
            $(".k-grid-cancel-changes").removeClass("k-state-disabled").addClass("k-grid-add");
        }
    }


    //var grid = $("#grilla_factor_importado").data("kendoGrid");
    //grid.saveAsExcel();
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
    $(".k-grid-Agregar").click(function(e){
        var popupaddFactor = $("#POPUP_addfactor");
        popupaddFactor.data("kendoWindow").open();
    });

    /*BTN Eliminar*/
    $(".k-grid-Eliminar").click(function(e){

        var dt_iddelete =$('#iddelete').val();
        $.ajax({
            type: "POST",
            url:   crudServiceBaseUrlpost + "DeleteFactorImport",
            data: { id_delete:String(dt_iddelete)},
            dataType: "json",
            success: function (result) {
                if(result=="OK"){
                    window.location.href = "Factor_Importacion";
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Factor eliminado correctamente.", "success");
                }else{
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Error Eliminación", "error");
                }
            },
            error: function (xhr, httpStatusMessage, customErrorMessage) {
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" Se produjo un error en el guardado.", "error");
            }
        });

    });

    var validator = $("#addfactorForm").kendoValidator().data("kendoValidator"),
        status = $(".status");
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

                                }else if(result=="DUPLICADO"){
                                    popupNotification.getNotifications().parent().remove();
                                    popupNotification.show("Ya se encuentra registrado este factor", "info");
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



});
