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
                url: crudServiceBaseUrl + "ActualizaPortada",
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

            if ( (e.type === 'update') || (e.type === 'create') ) {
                window.location.href = "mantenedor_proveedor";
            }

        }
    });

    // POPUP del Detalle del Proveedor
    var wnd = $("#details")
        .kendoWindow({
            title: "Detalle Proveedor",
            modal: true,
            visible: false,
            resizable: false,
            width: 900
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

    function onChange(arg) {
        $("#span_proveedor_sepeccionado").text(this.selectedKeyNames().join(", "));
        // console.log("ID Proveedor Seleccionado: [" + this.selectedKeyNames().join(", ") + "]");
    }

    // Definimos KendoGrid
    $("#grid").kendoGrid({
        dataSource: dataSource,
        editable: true,
        toolbar: [
            { name:"agregaproveedor", text: "Nuevo Proveedor"},
            { name:"editaproveedor", text: "Editar Proveedor"},
            { name: "save", text: "Actualizar Grilla", iconClass: "k-icon k-i-copy" },
            { name: "cancel", text: "Cancela Modificaciones sin Guardar" }
        ],
        height: 550, // Altura del Grid
        resizable: true,
        //selectable: "multiple",
        filterable: true,
        sortable: true, // Se puede ordenar
        columns: [ // Columnas a Listar
            { selectable: true, width: "13px" },
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

        ],
        change: onChange
    });

    // BTN Crear Registro
    $(".k-grid-agregaproveedor").click(function(e){

        // Asigna el Texto de Crear el BTN
        $("#BTN_FORM").html('Crear Proveedor');
        $("#TIPO_OPERACION").val("CREAR");
        $('#COD_PROVEEDOR').prop('readonly', false);

        var popupProveedor = $("#POPUP_PROVEEDOR");
        popupProveedor.data("kendoWindow").open();

    });

    // BTN Edita Registro
    $(".k-grid-editaproveedor").click(function(e){

        // 1.- Seleccionar solo un elemento
        var cant_seleccionada_span = $("#span_proveedor_sepeccionado").text();
        var cant_seleccionada = cant_seleccionada_span.split(",");

        var seleccionados_check = 0;
        $.each( cant_seleccionada, function( index, value ) {
            if(value.length>0){
                seleccionados_check++;
                //console.log("Valor:"+value.length);
            }
        });

        //console.log(seleccionados_check);

        if(seleccionados_check==0){
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Seleccione Proveedor.", "info");
        }else if(seleccionados_check>1){
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No seleccione más de 1 Proveedor.", "info");
        }else{

            // 2.- Del registro seleccionado, busco su data
            $.ajax({
                url: crudServiceBaseUrl + "BuscaProveedor",
                data: {COD_PROVEEDOR:String(cant_seleccionada[0])},
                dataType: "json",
                success: function (result) {

                    // 3.- De la data que llega, pueblo los campos
                    jQuery.each(result, function(index, itemData) {

                        //console.log(itemData.COD_MOD_PAIS);

                        // Seteamos Variables
                        $("#COD_PROVEEDOR").val(itemData.COD_PROVEEDOR);
                        $("#RUT_PROVEEDOR").val(itemData.RUT_PROVEEDOR);
                        $("#NOM_PROVEEDOR").val(itemData.NOM_PROVEEDOR);
                        $("#PI_AUTOMATICA").val(itemData.PI_AUTOMATICA);
                        $("#COMPRA_CURVA").val(itemData.COMPRA_CURVA);
                        $("#RFID").val(itemData.RFID);
                        $("#COD_MOD_PAIS").val(itemData.COD_MOD_PAIS);
                        $("#VEND_TAXID").val(itemData.VEND_TAXID);
                        $("#VEND_BENEFICIARY").val(itemData.VEND_BENEFICIARY);
                        $("#VEND_ADD_BENEFICIARY").val(itemData.VEND_ADD_BENEFICIARY);
                        $("#VEND_CITY").val(itemData.VEND_CITY);
                        $("#VEND_COUNTRY").val(itemData.VEND_COUNTRY);
                        $("#VEND_PHONE").val(itemData.VEND_PHONE);
                        $("#VEND_FAX").val(itemData.VEND_FAX);
                        $("#VEND_NAME_DEALER").val(itemData.VEND_NAME_DEALER);
                        $("#CONT_NAME").val(itemData.CONT_NAME);
                        $("#CONT_ADDRESS").val(itemData.CONT_ADDRESS);
                        $("#CONT_PHONE").val(itemData.CONT_PHONE);
                        $("#CONT_EMAIL").val(itemData.CONT_EMAIL);
                        $("#PAY_BANK_NAME_BENEFICIARY").val(itemData.PAY_BANK_NAME_BENEFICIARY);
                        $("#PAY_ADD_BANK_BENEFICIARY").val(itemData.PAY_ADD_BANK_BENEFICIARY);
                        $("#PAY_CITY_BENEFICIARY_BANK").val(itemData.PAY_CITY_BENEFICIARY_BANK);
                        $("#PAY_COUNTRY_BENEFICIARY").val(itemData.PAY_COUNTRY_BENEFICIARY);
                        $("#PAY_SWIFT_CODE").val(itemData.PAY_SWIFT_CODE);
                        $("#PAY_ABA").val(itemData.PAY_ABA);
                        $("#PAY_IBAN").val(itemData.PAY_IBAN);
                        $("#PAY_ACC_NUMBER_BENEFICIARY").val(itemData.PAY_ACC_NUMBER_BENEFICIARY);
                        $("#PAY_CURRENCY_ACCOUNT").val(itemData.PAY_CURRENCY_ACCOUNT);
                        $("#PAY_SECOND_BENEFICIARY").val(itemData.PAY_SECOND_BENEFICIARY);
                        $("#INTER_BANK_NAME").val(itemData.INTER_BANK_NAME);
                        $("#INTER_SWIFT").val(itemData.INTER_SWIFT);
                        $("#INTER_COUNTRY").val(itemData.INTER_COUNTRY);
                        $("#INTER_CITY").val(itemData.INTER_CITY);
                        $("#PUR_CURRENCY").val(itemData.PUR_CURRENCY);
                        //$("#PUR_INCOTEM").val(itemData.PUR_INCOTEM);
                        $("#PUR_PAYMENTO").val(itemData.PUR_PAYMENTO);

                        var comboxPUR_INCOTEM = $('#PUR_INCOTEM').data("kendoComboBox");
                        comboxPUR_INCOTEM.value(itemData.PUR_INCOTEM);


                    });

                    // 4.- Ocultar BTN de Crear
                    $("#BTN_FORM").html('Actualizar Proveedor');
                    $("#TIPO_OPERACION").val("ACTUALIZAR");
                    $('#COD_PROVEEDOR').prop('readonly', true);

                    // 5.- Levantar POPUP
                    var popupProveedor = $("#POPUP_PROVEEDOR");
                    popupProveedor.data("kendoWindow").open();

                },
                error: function (xhr, httpStatusMessage, customErrorMessage) {
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Se produjo un error en el guardado.", "error");
                }
            });






        }




    });


    // CBX de Incoterm
    var PUR_INCOTEM = $("#PUR_INCOTEM").kendoComboBox({
        autoBind: true,
        //optionLabel: "Seleccione INCOTERM",
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


    var validator = $("#ProveedorForm").kendoValidator().data("kendoValidator"),status = $(".status");

    $("form").submit(function(event) {
        event.preventDefault();
        if (validator.validate()) {


            var tipo_operacion = $("#TIPO_OPERACION").val();

            // Seteamos Variables
            var cod_proveedor = $("#COD_PROVEEDOR").val();
            var rut_proveedor = $("#RUT_PROVEEDOR").val();
            var nom_proveedor = $("#NOM_PROVEEDOR").val();
            var pi_automatica = $("#PI_AUTOMATICA").val();
            var compra_curva = $("#COMPRA_CURVA").val();
            var rfid = $("#RFID").val();
            var cod_mod_pais = $("#COD_MOD_PAIS").val();
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
            var pur_incoterm = $("#PUR_INCOTEM").val();
            var pur_payment = $("#PUR_PAYMENTO").val();

            var operacion = "";

            if(tipo_operacion=="CREAR"){
                operacion = "CrearProveedor";
            }else{
                operacion = "ActualizaProveedor";
            }

            $.ajax({
                //type: "POST",
                url: crudServiceBaseUrl + operacion, //"CrearProveedor",
                    data: {
                        COD_PROVEEDOR:String(cod_proveedor),
                        RUT_PROVEEDOR:String(rut_proveedor),
                        NOM_PROVEEDOR:String(nom_proveedor),
                        PI_AUTOMATICA:kendo.parseInt(pi_automatica),
                        COMPRA_CURVA:kendo.parseInt(compra_curva),
                        COD_MOD_PAIS:kendo.parseInt(cod_mod_pais),
                        RFID:kendo.parseInt(rfid),
                        VEND_TAXID:String(taxid),
                        VEND_BENEFICIARY:String(beneficiary),
                        VEND_ADD_BENEFICIARY:String(add_beneficiary),
                        VEND_CITY:String(city),
                        VEND_COUNTRY:String(country),
                        VEND_PHONE:String(phone),
                        VEND_FAX:String(fax),
                        VEND_NAME_DEALER:String(name_dealer),
                        CONT_NAME:String(cont_name),
                        CONT_ADDRESS:String(cont_address),
                        CONT_PHONE:String(cont_phone),
                        CONT_EMAIL:String(cont_email),
                        PAY_BANK_NAME_BENEFICIARY:String(pay_bank_name),
                        PAY_ADD_BANK_BENEFICIARY:String(pay_add_bank_beneficiary),
                        PAY_CITY_BENEFICIARY_BANK:String(pay_city_beneficiary),
                        PAY_COUNTRY_BENEFICIARY:String(pay_country_beneficiary),
                        PAY_SWIFT_CODE:String(pay_swift),
                        PAY_ABA:String(pay_aba),
                        PAY_IBAN:String(pay_iban),
                        PAY_ACC_NUMBER_BENEFICIARY:String(pay_account_beneficiary),
                        PAY_CURRENCY_ACCOUNT:String(pay_currency_account),
                        PAY_SECOND_BENEFICIARY:String(pay_second_beneficiary),
                        INTER_BANK_NAME:String(inter_bank_name),
                        INTER_SWIFT:String(inter_swift_code),
                        INTER_COUNTRY:String(inter_country),
                        INTER_CITY:String(inter_city),
                        PUR_CURRENCY:String(pur_currency),
                        PUR_INCOTEM:String(pur_incoterm),
                        PUR_PAYMENTO:String(pur_payment)},
                dataType: "json",
                success: function (result) {

                    if(result=="OK"){

                        // Recargar El Grid
                        dataSource.read();

                        // Limpiar todos los campos del Formulario
                        $("#NOM_PROVEEDOR").val("");
                        $("#COD_PROVEEDOR").val("");
                        $("#RUT_PROVEEDOR").val("");
                        $("#PI_AUTOMATICA").val("");
                        $("#COMPRA_CURVA").val("");
                        $("#RFID").val("");
                        $("#COD_MOD_PAIS").val("");
                        $("#VEND_TAXID").val("");
                        $("#VEND_BENEFICIARY").val("");
                        $("#VEND_ADD_BENEFICIARY").val("");
                        $("#VEND_CITY").val("");
                        $("#VEND_COUNTRY").val("");
                        $("#VEND_PHONE").val("");
                        $("#VEND_FAX").val("");
                        $("#VEND_NAME_DEALER").val("");
                        $("#CONT_NAME").val("");
                        $("#CONT_ADDRESS").val("");
                        $("#CONT_PHONE").val("");
                        $("#CONT_EMAIL").val("");
                        $("#PAY_BANK_NAME_BENEFICIARY").val("");
                        $("#PAY_ADD_BANK_BENEFICIARY").val("");
                        $("#PAY_CITY_BENEFICIARY_BANK").val("");
                        $("#PAY_COUNTRY_BENEFICIARY").val("");
                        $("#PAY_SWIFT_CODE").val("");
                        $("#PAY_ABA").val("");
                        $("#PAY_IBAN").val("");
                        $("#PAY_ACC_NUMBER_BENEFICIARY").val("");
                        $("#PAY_CURRENCY_ACCOUNT").val("");
                        $("#PAY_SECOND_BENEFICIARY").val("");
                        $("#INTER_BANK_NAME").val("");
                        $("#INTER_SWIFT").val("");
                        $("#INTER_COUNTRY").val("");
                        $("#INTER_CITY").val("");
                        $("#PUR_CURRENCY").val("");
                        $("#PUR_INCOTEM").val("");
                        $("#PUR_PAYMENTO").val("");

                        // Mensaje
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" Proveedor ingresado correctamente.", "success");

                        // Cerrar PopUp
                        var popupProveedor = $("#POPUP_PROVEEDOR");
                        popupProveedor.data("kendoWindow").close();

                    }else{
                        // Mensaje
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" No se pudo guardar el Proveedor.", "error");
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
