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
        width: "900px",
        height: "600px",
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
                url: crudServiceBaseUrl + "ActualizaProveedor",
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
    var detalleTemplate = kendo.template($("#template").html());

    // Función de despliegue y asignación de variables de detalle
    function muestraDetalles(e) {
        e.preventDefault();

        var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
        wnd.content(detalleTemplate(dataItem));
        wnd.center().open();
    }

    // Definimos KendoGrid
    $("#grid").kendoGrid({
        dataSource: dataSource,
        editable: true,
        toolbar: [
            { name:"agregaproveedor", text: "Nuevo Proveedor"},
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
    $(".k-grid-agregaproveedor").click(function(e){
        var popupProveedor = $("#POPUP_PROVEEDOR");
        popupProveedor.data("kendoWindow").open();
    });


    // CBX de Vía
    var PUR_INCOTEM = $("#PUR_INCOTEM").kendoComboBox({
        autoBind: false,
        //optionLabel: "Seleccione INCOTERM",
        dataTextField: "NOM_INCOTEM",
        dataValueField: "COD_INCOTEM",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarIncoterm"
                }
            }
        }
    }).data("kendoComboBox");


    // xxx
    /*
    $("#VEND_TAXID").kendoNumericTextBox({});
    $("#VEND_BENEFICIARY").kendoNumericTextBox({});
    $("#VEND_ADD_BENEFICIARY").kendoNumericTextBox({});
    $("#VEND_CITY").kendoNumericTextBox({});
    $("#VEND_COUNTRY").kendoNumericTextBox({});
    $("#VEND_PHONE").kendoNumericTextBox({});
    $("#VEND_FAX").kendoNumericTextBox({});
    $("#VEND_NAME_DEALER").kendoNumericTextBox({});
    $("#CONT_NAME").kendoNumericTextBox({});
    $("#CONT_ADDRESS").kendoNumericTextBox({});
    $("#CONT_PHONE").kendoNumericTextBox({});
    $("#CONT_EMAIL").kendoNumericTextBox({});
    $("#PAY_BANK_NAME_BENEFICIARY").kendoNumericTextBox({});
    $("#PAY_ADD_BANK_BENEFICIARY").kendoNumericTextBox({});
    $("#PAY_CITY_BENEFICIARY_BANK").kendoNumericTextBox({});
    $("#PAY_COUNTRY_BENEFICIARY").kendoNumericTextBox({});
    $("#PAY_SWIFT_CODE").kendoNumericTextBox({});
    $("#PAY_ABA").kendoNumericTextBox({});
    $("#PAY_IBAN").kendoNumericTextBox({});
    $("#PAY_ACC_NUMBER_BENEFICIARY").kendoNumericTextBox({});
    $("#PAY_CURRENCY_ACCOUNT").kendoNumericTextBox({});
    $("#PAY_SECOND_BENEFICIARY").kendoNumericTextBox({});
    $("#INTER_BANK_NAME").kendoNumericTextBox({});
    $("#INTER_SWIFT").kendoNumericTextBox({});
    $("#INTER_COUNTRY").kendoNumericTextBox({});
    $("#INTER_CITY").kendoNumericTextBox({});
    $("#PUR_CURRENCY").kendoNumericTextBox({});
    $("#PUR_INCOTEM").kendoNumericTextBox({});
    $("#PUR_PAYMENTO").kendoNumericTextBox({});
    */




    var validator = $("#ProveedorForm").kendoValidator().data("kendoValidator"),status = $(".status");

    $("form").submit(function(event) {
        event.preventDefault();
        if (validator.validate()) {
            // Seteamos Variables
            var pi_automatica = $("#PI_AUTOMATICA").value();
            var compra_curva = $("#COMPRA_CURVA").value();
            var rfid = $("#RFID").value();
            var taxid = $("#VEND_TAXID").val();
            var beneficiary = $("#VEND_BENEFICIARY").val();
            var add_beneficiary = $("#VEND_ADD_BENEFICIARY").val();
            var city = $("#VEND_CITY").val();
            var country = $("#VEND_COUNTRY").val();
            var phone = $("#VEND_PHONE").val();
            var fax = $("#VEND_FAX").val();
            var name_dealer = $("#VEND_NAME_DEALER").val();
            var cont_name = $("#CONT_NAME").val();
            var cont_address = $("#CONT_ADDRESS").val();
            var cont_phone = $("#CONT_PHONE").val();
            var cont_email = $("#CONT_EMAIL").val();
            var pay_bank_name = $("#PAY_BANK_NAME_BENEFICIARY").val();
            var pay_add_bank_beneficiary = $("#PAY_ADD_BANK_BENEFICIARY").val();
            var pay_city_beneficiary = $("#PAY_CITY_BENEFICIARY_BANK").val();
            var pay_country_beneficiary = $("#PAY_COUNTRY_BENEFICIARY").val();
            var pay_swift = $("#PAY_SWIFT_CODE").val();
            var pay_aba = $("#PAY_ABA").val();
            var pay_iban = $("#PAY_IBAN").val();
            var pay_account_beneficiary = $("#PAY_ACC_NUMBER_BENEFICIARY").val();
            var pay_currency_account = $("#PAY_CURRENCY_ACCOUNT").val();
            var pay_second_beneficiary = $("#PAY_SECOND_BENEFICIARY").val();
            var inter_bank_name = $("#INTER_BANK_NAME").val();
            var inter_swift_code = $("#INTER_SWIFT").val();
            var inter_country = $("#INTER_COUNTRY").val();
            var inter_city = $("#INTER_CITY").val();
            var pur_currency = $("#PUR_CURRENCY").val();
            var pur_incoterm = $("#PUR_INCOTEM").value();
            var pur_payment = $("#PUR_PAYMENTO").val();

            $.ajax({
                //type: "POST",
                url: crudServiceBaseUrl + "CrearProveedor",
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
