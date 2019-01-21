$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikMantenedorProveedor/";

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
    $("#toolbar").kendoToolBar({
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

    var ventana_formulario = $("#POPUP_PROVEEDOR");
    ventana_formulario.kendoWindow({
        width: "750px",
        height: "550px",
        title: "Mantenedor Proveedor",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
        close: cerrarPopUpLeadTime*/
    }).data("kendoWindow").center();

    var respuestas = [{
        "value": 1,
        "text": "SI"
    },{
        "value": 2,
        "text": "NO"
    }];



    // Definimos DataSource
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "ListarProveedor",
                dataType: "json"
            },
            update: {
                url: crudServiceBaseUrl + "ActualizaLeadTime",
                dataType: "json"
            }
        },
        //requestEnd: TerminaCargaProveedor,
        schema: {
            model: {
                id: "COD_PROVEEDOR",
                fields: {
                    COD_PROVEEDOR: { type: "string",editable: false },    // number - string - date
                    COD_MOD_PAIS: { type: "string",editable: false },    // number - string - date
                    RUT_PROVEEDOR: { type: "string",editable: false }, // number - string - date
                    NOM_PROVEEDOR: { type: "string",editable: false }, // number - string - date
                    PI_AUTOMATICA: { type: "number",field: "PI_AUTOMATICA", defaultValue: 2 },    // number - string - date
                    COMPRA_CURVA: { type: "number" },    // number - string - date
                    RFID: { type: "number" }    // number - string - date
                    /*VEND_TAXID: { type: "string" }, // number - string - date
                    VEND_NAME_DEALER: { type: "string" }, // number - string - date
                    VEND_BENEFICIARY: { type: "string" }, // number - string - date
                    VEND_ADD_BENEFICIARY: { type: "string" }, // number - string - date
                    VEND_CITY: { type: "string" }, // number - string - date
                    VEND_COUNTRY: { type: "string" }, // number - string - date
                    VEND_PHONE: { type: "string" }, // number - string - date
                    VEND_FAX: { type: "string" }, // number - string - date
                    CONT_NAME: { type: "string" }, // number - string - date
                    CONT_ADDRESS: { type: "string" }, // number - string - date
                    CONT_PHONE: { type: "string" },    // number - string - date
                    CONT_EMAIL: { type: "string" },    // number - string - date

                    USU_CREA: { type: "string" },    // number - string - date
                    FECHA_CREA: { type: "string" },    // number - string - date
                    USU_MODIFICA: { type: "string" },    // number - string - date
                    FECHA_MODIFICA: { type: "string" }    // number - string - date*/
                }
            }
        },
        change: function () {

        },
        requestEnd: function (e) {

            /*if ( (e.type === 'update') || (e.type === 'create') ) {
                window.location.href = "lead_time";
            }*/

        }
    });

    // POPUP del Detalle del Proveedor
    var wnd = $("#details")
        .kendoWindow({
            title: "Detalle Proveedor",
            modal: true,
            visible: false,
            resizable: false,
            width: 300
        }).data("kendoWindow");

    // Asignación del Template a Insertar
    var detailsTemplate = kendo.template($("#template").html());

    // Función de despliegue y asignación de variables de detalle
    function muestraDetalles(e) {
        e.preventDefault();

        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
        wnd.content(detailsTemplate(dataItem));
        wnd.center().open();
    }

    // Definimos KendoGrid
    $("#grid").kendoGrid({
        dataSource: dataSource,
        editable: true,
        toolbar: [
            { name:"agregaleadtime", text: "Nuevo Proveedor"},
            { name: "save", text: "Actualizar Registros", iconClass: "k-icon k-i-copy" },
            { name: "cancel", text: "Cancelar Modificaciones" }
        ],
        height: 550, // Altura del Grid
        resizable: true,
        //selectable: "multiple",
        filterable: true,
        sortable: true, // Se puede ordenar
        columns: [ // Columnas a Listar
            {field: "COD_PROVEEDOR",title: "ID",width: 30},
            {field: "COD_MOD_PAIS",title: "País",width: 30,filterable: {multi: true}},
            {field: "RUT_PROVEEDOR",title: "RUT Proveedor",width: 70,filterable: {multi: true}},
            {field: "NOM_PROVEEDOR",title: "Nombre",width: 250,filterable: {multi: true}},
            {field: "PI_AUTOMATICA",title: "PI Automática",width: 50, values: respuestas,filterable: {multi: true}},
            {field: "COMPRA_CURVA",title: "Compra en Curva",width: 60, values: respuestas,filterable: {multi: true}},
            {field: "RFID",title: "RFID",width: 50, values: respuestas,filterable: {multi: true}},
            { command: { text: "Ver", click: muestraDetalles }, title: "Detalle", width: "40px" }
            /*{field: "VEND_TAXID",title: "TAXID",width: 120,filterable: {multi: true}},
            {field: "VEND_NAME_DEALER",title: "Name Dealer",width: 120,filterable: {multi: true}},
            {field: "VEND_BENEFICIARY",title: "Beneficiary",width: 120,filterable: {multi: true}},
            {field: "VEND_ADD_BENEFICIARY",title: "Address Beneficiary",width: 120,filterable: {multi: true}},
            {field: "VEND_CITY",title: "City",width: 120,filterable: {multi: true}},
            {field: "VEND_COUNTRY",title: "Coubtry",width: 120,filterable: {multi: true}},
            {field: "VEND_PHONE",title: "Phone",width: 120,filterable: {multi: true}},
            {field: "VEND_FAX",title: "Fax",width: 120,filterable: {multi: true}},
            {field: "CONT_NAME",title: "Cont. Name",width: 120,filterable: {multi: true}},
            {field: "CONT_ADDRESS",title: "Cont. Address",width: 120,filterable: {multi: true}},
            {field: "CONT_PHONE",title: "Cont. Phone",width: 120,filterable: {multi: true}},
            {field: "CONT_EMAIL",title: "Cont. Email",width: 120,filterable: {multi: true}}
            */

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
