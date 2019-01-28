$(function () {
    kendo.culture("es-CL");
    // Actualiza Fecha de Concurrencia (Solo se agrega en este JS, ya que desde fuera no se puede llamar)
    function ActualizaConcurrencia() {

        var url_act_fecha_concurrencia = 'TelerikPlanCompra/ActualizaFechaConcurrencia';

        $.ajax({
            type: "GET",
            url: url_act_fecha_concurrencia,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function () {
                // Acción al Ejecutarse correctamente
                console.log("Se Actualiza Fecha de Concurrencia");
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus + " errorThrown: " + errorThrown);
            }
        }).success(function () {
            console.log("Se realiza solicitud de Actualización de Fecha en Concurrencia");
        });

    }

    // Despliega Reloj de Cuenta Atrás (Solo se agrega en este JS, ya que desde fuera no se puede llamar)
    function DespliegaCuentaAtras() {

        var counter = 59;
        var interval = setInterval(function() {

            counter--;
            console.log("Timer --> " + counter);
            // Display 'counter' wherever you want to display it.
            if (counter == 0) {
                clearInterval(interval);
                $('#StopCountDown').html("<h3>Saliendo...</h3>");
                // Sacar al usuario
                window.location.href = "inicio";
                return;

            }else{
                $('#contador_cierra_session').html(counter);
                //console.log("Timer --> " + counter);
            }

        }, 1000);

    }


    // ####################### FUNCIONES ASOCIADAS AL DESPLIEGUE DE DATA #######################

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikPlanCompra/";
    var crudServiceBaseUrlPOST = "TelerikPlanCompraPOST/";

    // Seteo el DropdownList de País, si no ha sido cargado antes
    kendo.spreadsheet.registerEditor("dropdownlistPais", function(){
        var context, dlg, model;

        function create() {
            if (!dlg) {
                model = kendo.observable({
                    value: "#000000",
                    ok: function() {
                        //debugger;
                        // This is the result when OK is clicked. Invoke the
                        // callback with the value.
                        context.callback(model.value);
                        // console.log(model);
                        dlg.close();
                    },
                    paises: new kendo.data.DataSource({
                        transport: {
                            read: {
                                url: crudServiceBaseUrl+"ListarPais",
                                dataType: "json"
                            }
                        }
                    }),
                    cancel: function() {
                        dlg.close();
                    }
                });
                var el = $("<div data-visible='true' data-role='window' data-modal='true' data-resizable='true' data-title='Seleccione País ' style='width: 300px;'>" +
                    "  <div data-role='dropdownlist' data-bind='value: value, source: paises' data-text-field='NOMBRE_PAIS' data-value-field='NOMBRE_PAIS' style='width: 100%;'></div>" +
                    "  <div style='margin-top: 1em; text-align: right'>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: ok'>OK</button>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: cancel'>Cancel</button>" +
                    "  </div>" +
                    "</div>");
                kendo.bind(el, model);

                // Cache the dialog.
                dlg = el.getKendoWindow();
            }
        }

        function open() {
            create();
            dlg.open();
            dlg.center();

            // Si la celda ya tiene un valor, al momento de abrir el editor se carga la que contiene la celca
            var value = context.range.value();
            if (value != null) {
                model.set("value", value);
            }

        }

        return {
            edit: function(options) {
                context = options;
                open();
            },
            icon: "k-icon k-i-arrow-60-down"
        };

    });

    // Seteo el DropdownList de Formato, si no ha sido cargado antes
    kendo.spreadsheet.registerEditor("dropdownlistFormato", function(){
        var context, dlg, model;

        function create() {
            if (!dlg) {
                model = kendo.observable({
                    value: "#000000",
                    ok: function() {
                        //debugger;
                        // This is the result when OK is clicked. Invoke the
                        // callback with the value.
                        context.callback(model.value);
                        // console.log(model);
                        dlg.close();
                    },
                    formatos: new kendo.data.DataSource({
                        transport: {
                            read: {
                                url: crudServiceBaseUrl+"ListarFormato",
                                dataType: "json"
                            }
                        }
                    }),
                    cancel: function() {
                        dlg.close();
                    }
                });

                var elFormato = $("<div data-visible='true' data-role='window' data-modal='true' data-resizable='true' data-title='Seleccione Formato ' style='width: 300px;'>" +
                    "  <div data-role='dropdownlist' data-bind='value: value, source: formatos' data-text-field='NOMBRE_FORMATO' data-value-field='NOMBRE_FORMATO' style='width: 100%;'></div>" +
                    "  <div style='margin-top: 1em; text-align: right'>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: ok'>OK</button>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: cancel'>Cancelar</button>" +
                    "  </div>" +
                    "</div>");
                kendo.bind(elFormato, model);


                // Cache the dialog.
                dlg = elFormato.getKendoWindow();
            }
        }

        function open() {
            create();
            dlg.open();
            dlg.center();

            // Si la celda ya tiene un valor, al momento de abrir el editor se carga la que contiene la celca
            var value = context.range.value();
            if (value != null) {
                model.set("value", value);
            }

        }

        return {
            edit: function(options) {
                context = options;
                open();
            },
            icon: "k-icon k-i-arrow-60-down"
        };

    });

    // Seteo el DropdownList de Proveedor, si no ha sido cargado antes
    kendo.spreadsheet.registerEditor("dropdownlistProveedor", function(){
        var context, dlg, model;

        function create() {
            if (!dlg) {
                model = kendo.observable({
                    value: "#000000",
                    ok: function() {
                        //debugger;
                        // This is the result when OK is clicked. Invoke the
                        // callback with the value.
                        context.callback(model.value);
                        // console.log(model);
                        dlg.close();
                    },
                    proveedores: new kendo.data.DataSource({
                        transport: {
                            read: {
                                url: crudServiceBaseUrl+"ListarProveedor",
                                dataType: "json"
                            }
                        }
                    }),
                    cancel: function() {
                        dlg.close();
                    }
                });

                var elProveedor = $("<div data-visible='true' data-role='window' data-modal='true' data-resizable='true' data-title='Seleccione Proveedor ' style='width: 400px;'>" +
                    "  <div data-role='dropdownlist' data-bind='value: value, source: proveedores' data-text-field='NOMBRE_PROVEEDOR' data-value-field='NOMBRE_PROVEEDOR' style='width: 100%;'></div>" +
                    "  <div style='margin-top: 1em; text-align: right'>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: ok'>OK</button>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: cancel'>Cancelar</button>" +
                    "  </div>" +
                    "</div>");
                kendo.bind(elProveedor, model);


                // Cache the dialog.
                dlg = elProveedor.getKendoWindow();
            }
        }

        function open() {
            create();
            dlg.open();
            dlg.center();

            // Si la celda ya tiene un valor, al momento de abrir el editor se carga la que contiene la celca
            var value = context.range.value();
            if (value != null) {
                model.set("value", value);
            }

        }

        return {
            edit: function(options) {
                context = options;
                open();
            },
            icon: "k-icon k-i-arrow-60-down"
        };

    });

    // Seteo el DropdownList de Evento, si no ha sido cargado antes
    kendo.spreadsheet.registerEditor("dropdownlistEvento", function(){
        var context, dlg, model;

        function create() {
            if (!dlg) {
                model = kendo.observable({
                    value: "#000000",
                    ok: function() {
                        //debugger;
                        // This is the result when OK is clicked. Invoke the
                        // callback with the value.
                        context.callback(model.value);
                        // console.log(model);
                        dlg.close();
                    },
                    eventos: new kendo.data.DataSource({
                        transport: {
                            read: {
                                url: crudServiceBaseUrl+"ListarEventos",
                                dataType: "json"
                            }
                        }
                    }),
                    cancel: function() {
                        dlg.close();
                    }
                });

                var elEvento = $("<div data-visible='true' data-role='window' data-modal='true' data-resizable='true' data-title='Seleccione Evento ' style='width: 200px;'>" +
                    "  <div data-role='dropdownlist' data-bind='value: value, source: eventos' data-text-field='NOMBRE_EVENTO' data-value-field='NOMBRE_EVENTO' style='width: 100%;'></div>" +
                    "  <div style='margin-top: 1em; text-align: right'>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: ok'>OK</button>" +
                    "    <button style='width: 5em' class='k-button' data-bind='click: cancel'>Cancelar</button>" +
                    "  </div>" +
                    "</div>");
                kendo.bind(elEvento, model);


                // Cache the dialog.
                dlg = elEvento.getKendoWindow();
            }
        }

        function open() {
            create();
            dlg.open();
            dlg.center();

            // Si la celda ya tiene un valor, al momento de abrir el editor se carga la que contiene la celca
            var value = context.range.value();
            if (value != null) {
                model.set("value", value);
            }

        }

        return {
            edit: function(options) {
                context = options;
                open();
            },
            icon: "k-icon k-i-arrow-60-down"
        };

    });

    // Función que envia la Data al PHP
    function onSubmit(e) {

        // alert(e.data.updated.length);
        // console.log(e.data.updated.length);

        var arregloGuardado = [];
        var i = 0;

        // Recorro por la cantidad de registros para asociar al arreglo
        for (i; i < e.data.updated.length; i++) {
            // Enviar Registros que existan previamente, no nuevos
            if(e.data.updated[i]["ESTADO_C1"]){
            arregloGuardado.push({
                "ID_COLOR3": kendo.parseInt(e.data.updated[i]["ID_COLOR3"]),
                "ESTADO_C1": kendo.parseInt(e.data.updated[i]["ESTADO_C1"]),
                "PROFORMA": String(e.data.updated[i]["PROFORMA"]),
                "ARCHIVO": String(e.data.updated[i]["ARCHIVO"]),
                "PROFORMA_BASE": String(e.data.updated[i]["PROFORMA_BASE"]),
                "ARCHIVO_BASE": String(e.data.updated[i]["ARCHIVO_BASE"]),
                "ALIAS_PROV": String(e.data.updated[i]["ALIAS_PROV"]),
                "NOM_VENTANA": String(e.data.updated[i]["NOM_VENTANA"]),
                "DESTALLA": String(e.data.updated[i]["DESTALLA"]),
                "TIPO_EMPAQUE": String(e.data.updated[i]["TIPO_EMPAQUE"]),
                "PORTALLA_1_INI": String(e.data.updated[i]["PORTALLA_1_INI"]),
                "CURVATALLA": String(e.data.updated[i]["CURVATALLA"]),
                "UNID_OPCION_INICIO": kendo.parseInt(e.data.updated[i]["UNID_OPCION_INICIO"]),
                "CAN": kendo.parseInt(e.data.updated[i]["CAN"]),
                "SEG_ASIG": String(e.data.updated[i]["SEG_ASIG"]),
                "FORMATO": String(e.data.updated[i]["FORMATO"]),
                "A": kendo.parseInt(e.data.updated[i]["A"]),
                "B": kendo.parseInt(e.data.updated[i]["B"]),
                "C": kendo.parseInt(e.data.updated[i]["C"]),
                "I": kendo.parseInt(e.data.updated[i]["I"]),
                "NOM_VIA": String(e.data.updated[i]["NOM_VIA"]),
                "NOM_PAIS": String(e.data.updated[i]["NOM_PAIS"]),
                "PRECIO_BLANCO": kendo.parseInt(e.data.updated[i]["PRECIO_BLANCO"]),
                "COSTO_TARGET": kendo.parseFloat(e.data.updated[i]["COSTO_TARGET"]), // Decimal
                "COSTO_FOB": kendo.parseFloat(e.data.updated[i]["COSTO_FOB"]),
                "COSTO_INSP": kendo.parseFloat(e.data.updated[i]["COSTO_INSP"]),
                "COSTO_RFID": kendo.parseFloat(e.data.updated[i]["COSTO_RFID"]), // Decimal
                "DEBUT_REODER": String(e.data.updated[i]["DEBUT_REODER"]),
                "COD_MARCA": String(e.data.updated[i]["COD_MARCA"]),
                "N_CURVASXCAJAS": kendo.parseInt(e.data.updated[i]["N_CURVASXCAJAS"]),
                "COD_JER2": String(e.data.updated[i]["COD_JER2"]),
                "COD_SUBLIN": String(e.data.updated[i]["COD_SUBLIN"]),
                //"FECHA_ACORDADA": String(e.data.updated[i]["FECHA_ACORDADA"]),
                "FECHA_ACORDADA": kendo.toString(e.data.updated[i]["FECHA_ACORDADA"],"dd/MM/YYYY"),
                "EVENTO": String(e.data.updated[i]["EVENTO"])
            });
            }

        }


        // console.log(arregloGuardado);
        // console.log(e.data.updated[0]["ALIAS_PROV"]);

        $.post( crudServiceBaseUrlPOST + "ProcesaDataPlanCompra", {models: kendo.stringify(arregloGuardado)},function( data ) {

            // Recargar PlanCompra
            var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet = spreadsheet.activeSheet();
            sheet.dataSource.read();

            // Seteo popup de notoficacion
            var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

            if(data == 0){
                // Mensaje de ok
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" Cambios Almacenados Correctamente.", "success");
            }else{
                // Mensaje de Error
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(data, "error");
            }

            $("#tb_guardar_cambios").removeClass("k-state-disabled");
            $("#tb_cancelar_cambios").removeClass("k-state-disabled");


         } ).fail(function() {

            $("#tb_guardar_cambios").removeClass("k-state-disabled");
            $("#tb_cancelar_cambios").removeClass("k-state-disabled");

            // Mensaje de Error
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" Error en el Guardado.", "error");

        });

        /*$.ajax({
            //type: "POST",
            url: crudServiceBaseUrl + "ProcesaDataPlanCompra",
            //data: {models: kendo.stringify(e.data)},
            data: {models: kendo.stringify(arregloGuardado)},
            contentType: "application/json",
            //dataType: "json",
            success: function (result) {
                //kendo.log(result);
                e.success(result.Updated, "update");
                e.success(result.Created, "create");
                e.success(result.Destroyed, "destroy");

                // Recargar PlanCompra
                var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                var sheet = spreadsheet.activeSheet();
                sheet.dataSource.read();

                // Seteo popup de notoficacion
                var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

                if(result == 0){
                    // Mensaje de ok
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Cambios Almacenados Correctamente.", "success");
                }else{
                    // Mensaje de Error
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(result, "error");
                }

                $("#tb_guardar_cambios").removeClass("k-state-disabled");
                $("#tb_cancelar_cambios").removeClass("k-state-disabled");

            },
            error: function (xhr, httpStatusMessage, customErrorMessage) {

                $("#tb_guardar_cambios").removeClass("k-state-disabled");
                $("#tb_cancelar_cambios").removeClass("k-state-disabled");


                // Mensaje de Error
                popupNotification.getNotifications().parent().remove();
                popupNotification.show(" Error en el Guardado.", "error");

                console.log(xhr.responseText+" / "+httpStatusMessage+" / "+customErrorMessage);
            }
        });*/

    }

    // Función que trae la indormación a cargar el DataTable
    function onRead(options) {
        $.ajax({
            url: crudServiceBaseUrl + "ListarPlanCompra",
            dataType: "json",
            //type: 'POST',
            success: function (result) {
                options.success(result);
                //kendo.console(result);
            },
            error: function (result) {
                options.error(result);
            }
        });
    }

    // Variable siempre a true, para cambiar las cabeceras
    var shouldPopulateHeader = true;

    // Cargar info en el DataSource
    var dataSource = new kendo.data.DataSource({
        /*requestStart:function(e){
        },*/
        requestEnd: function (e) {
            // Una vez que se carga la función de poder editar, asigno la columnaal editor
            if (e.type === 'read') {
                setTimeout(function() {

                    // Asigno el CBX de País
                    var spreadsheet = $('#spreadsheet').getKendoSpreadsheet();
                    var sheet = spreadsheet.activeSheet();
                    var columnBA = sheet.range('BA2:BA' + (e.response.length + 1));
                    columnBA.editor('dropdownlistPais');

                    // Asigno el CBX de Formato
                    var columnAQ = sheet.range('AQ2:AQ' + (e.response.length + 1));
                    columnAQ.editor('dropdownlistFormato');

                    // Asigno el CBX de Proveedor
                    var columnCA = sheet.range('CA2:CA' + (e.response.length + 1));
                    columnCA.editor('dropdownlistProveedor');

                    // Asigno el CBX de Evento
                    var columnR = sheet.range('R2:R' + (e.response.length + 1));
                    columnR.editor('dropdownlistEvento');

                    // Contar el total de registros
                    var spreadsheet1 = $("#spreadsheet").data("kendoSpreadsheet");
                    var sheet_2 = spreadsheet1.sheetByIndex(0);
                    var data_total = sheet_2.toJSON();
                    var count = data_total.rows.length;

                    // Asigno CBX Formato Fecha
                    var columnCM = sheet.range('CM2:CM'+count);
                    columnCM.validation({
                        dataType: "date",
                        showButton: true,
                        comparerType: "between",
                        from: 'DATEVALUE("1/1/1900")',
                        to: 'DATEVALUE("1/1/2100")',
                        allowNulls: true,
                        type: "reject",
                        titleTemplate: "Error en formato de la Fecha",
                        messageTemplate: " Recuerda ingresar la Fecha en formato: dd/mm/aaaa."
                    });
                    columnCM.format('dd/mm/yyyy');

                    /*var columnCG = sheet.range('BJ2:BM'+count);
                    columnCG.validation({
                        from: "0",
                        to: "999",
                        comparerType: "between",
                        dataType: "number",
                        allowNulls: true,
                        type: "reject",
                        titleTemplate: "Error de Formato",
                        messageTemplate: "  Sólo debes utilizar puntos."
                    });*/

                    // Rows red estado Eliminado
                    var range_estados = sheet_2.range("CR2:CR"+count);
                    range_estados.forEachCell(function (row, column, value) {
                       if(sheet_2.range("CR"+row).value() == "Eliminado"){
                           sheet_2.range("A"+row+":CR"+row).background("#cd5c5c");
                           sheet_2.range("A"+row+":CR"+row).color("#ffffff");
                        }

                        /*if(sheet_2.range("CS"+row).value() == 21){
                            spreadsheet1.activeSheet().range("A"+row+":CR"+row).enable(false);
                        }*/

                    // Fin del Recorrer la Grilla
                    });

                    var color_celda_lectura = "#050B5F";
                    // AH % Compra Inicial
                    sheet.range("AH2:AH"+count).color(color_celda_lectura);
                    // AL - AM  Uidad Ajustada/Unidad Final
                    sheet.range("AL2:AM"+count).color(color_celda_lectura);
                    // AR Tdas
                    sheet.range("AR2:AR"+count).color(color_celda_lectura);
                    // AX % Tiendas
                    sheet.range("AX2:AX"+count).color(color_celda_lectura);
                    // BC Mkup
                    sheet.range("BC2:BC"+count).color(color_celda_lectura);
                    // BE GM
                    sheet.range("BE2:BE"+count).color(color_celda_lectura);
                    // BO - BT
                    sheet.range("BO2:BT"+count).color(color_celda_lectura);
                    // BV - BX
                    sheet.range("BV2:BX"+count).color(color_celda_lectura);
                    // CB Razón Social
                    sheet.range("CB2:CB"+count).color(color_celda_lectura);
                    // CF Cod Padre
                    sheet.range("CF2:CF"+count).color(color_celda_lectura);
                    // CH - CL
                    sheet.range("CH2:CL"+count).color(color_celda_lectura);
                    // CN - CR
                    sheet.range("CN2:CR"+count).color(color_celda_lectura);

                    // Formato de Números
                    //sheet.range("AK2:AK40").format("$#,##0.00");
                    //sheet.range("AK2:AL"+count).format("#,##0");
                    //sheet.range("BD2:BD"+count).format("#,##0");

                    // Unidades Iniciales
                    sheet.range("AK2:AK"+count).format("#,##0");
                    // Precio Blanco
                    sheet.range("BD2:BD"+count).format("#,##0");
                    // 4 Columnas -> Target - RFID
                    sheet.range("BJ2:BM"+count).format("#,##0.00");



                });
            }

            // Seteo el Nombre de las Cabeceras, Fijo la primera columna
            setTimeout(function (e) {
                if (shouldPopulateHeader) {
                    shouldPopulateHeader = false;
                    var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                    var sheet = spreadsheet.activeSheet();

                    // Congela la Primera Fila
                    sheet.frozenRows(1);

                    // Modifica las Cabeceras
                    sheet.batch(function () {

                        // Cambiamos Nombre de Cabecera
                        sheet.range("A1").value("ID");
                        sheet.range("B1").value("G. Compra");
                        sheet.range("C1").value("Temp");
                        sheet.range("D1").value("Línea");
                        sheet.range("E1").value("SubLínea");
                        sheet.range("F1").value("Marca");
                        sheet.range("G1").value("Estilo");
                        sheet.range("H1").value("Estilo Corto");
                        sheet.range("I1").value("Cod. Corp");
                        sheet.range("J1").value("Descripción");
                        sheet.range("K1").value("Descripción Internet");
                        sheet.range("L1").value("Nombre Comprador");
                        sheet.range("M1").value("Nombre Diseñador");
                        sheet.range("N1").value("Composición");
                        sheet.range("O1").value("Tipo Tela");
                        sheet.range("P1").value("Forro");
                        sheet.range("Q1").value("Colección");
                        sheet.range("R1").value("Evento");
                        sheet.range("S1").value("Evento In-Store");
                        sheet.range("T1").value("Estilo de Vida");
                        sheet.range("U1").value("Calidad");
                        sheet.range("V1").value("Ocación de Uso");
                        sheet.range("W1").value("Pirámide Mix");
                        sheet.range("X1").value("Ventana");
                        sheet.range("Y1").value("Rank Vta");
                        sheet.range("Z1").value("Life Cycle");
                        sheet.range("AA1").value("Cod. Opción");
                        sheet.range("AB1").value("Color");
                        sheet.range("AC1").value("Tipo Producto");
                        sheet.range("AD1").value("Tipo Exhibición");
                        sheet.range("AE1").value("Tallas");
                        sheet.range("AF1").value("Tipo Empaque");
                        sheet.range("AG1").value("% Compra Inicial");
                        sheet.range("AH1").value("% Compra Ajustada");
                        sheet.range("AI1").value("Curvas de Reparto");
                        sheet.range("AJ1").value("Curvas Min");
                        sheet.range("AK1").value("Unid Ini");
                        sheet.range("AL1").value("Unid Ajust");
                        sheet.range("AM1").value("Unid Final");
                        sheet.range("AN1").value("Mtr Pack");
                        sheet.range("AO1").value("N° Cajas");
                        sheet.range("AP1").value("Cluster");
                        sheet.range("AQ1").value("Formato");
                        sheet.range("AR1").value("Tdas");
                        sheet.range("AS1").value("A");
                        sheet.range("AT1").value("B");
                        sheet.range("AU1").value("C");
                        sheet.range("AV1").value("I");
                        sheet.range("AW1").value("Primera Carga");
                        sheet.range("AX1").value("% Tiendas");
                        sheet.range("AY1").value("Proced");
                        sheet.range("AZ1").value("Vía");
                        sheet.range("BA1").value("País");
                        sheet.range("BB1").value("Viaje");
                        sheet.range("BC1").value("Mkup");
                        sheet.range("BD1").value("Precio Blanco");
                        sheet.range("BE1").value("GM");
                        sheet.range("BF1").value("Oferta");
                        sheet.range("BG1").value("2X");
                        sheet.range("BH1").value("Opex");
                        sheet.range("BI1").value("Moneda");
                        sheet.range("BJ1").value("Target");
                        sheet.range("BK1").value("FOB");
                        sheet.range("BL1").value("Insp");
                        sheet.range("BM1").value("RFID");
                        sheet.range("BN1").value("Royalty(%)");
                        sheet.range("BO1").value("Costo Unitario Final US$");
                        sheet.range("BP1").value("Costo Unitario Final Pesos");
                        sheet.range("BQ1").value("Total Target US$");
                        sheet.range("BR1").value("Total Fob US$");
                        sheet.range("BS1").value("Costo Total");
                        sheet.range("BT1").value("Total Retail");
                        sheet.range("BU1").value("Debut/Reorder");
                        sheet.range("BV1").value("Sem Ini");
                        sheet.range("BW1").value("Sem Fin");
                        sheet.range("BX1").value("Semanas Ciclo de Vida");
                        sheet.range("BY1").value("Agot Obj");
                        sheet.range("BZ1").value("Semanas Liquidación");
                        sheet.range("CA1").value("Proveedor");
                        sheet.range("CB1").value("Razón Social");
                        sheet.range("CC1").value("Trader");
                        sheet.range("CD1").value("After Meeting Remark");
                        sheet.range("CE1").value("Cod. SKU Proveedor");
                        sheet.range("CF1").value("Cod. Padre");
                        sheet.range("CG1").value("Proforma");
                        sheet.range("CH1").value("Archivo");
                        sheet.range("CI1").value("Estilo PMM");
                        sheet.range("CJ1").value("Estado Match");
                        sheet.range("CK1").value("N° OC");
                        sheet.range("CL1").value("Estado OC");
                        sheet.range("CM1").value("Fecha Emb. Acordada");
                        sheet.range("CN1").value("Fecha Embarque");
                        sheet.range("CO1").value("Fecha ETA");
                        sheet.range("CP1").value("Fecha Recepción CD");
                        sheet.range("CQ1").value("Días Atraso CD");
                        sheet.range("CR1").value("Estado Opción");


                        // Contar registros que me trae la grilla
                        var spreadsheet_conteo_total = $("#spreadsheet").data("kendoSpreadsheet");
                        var sheet_conteo_total = spreadsheet_conteo_total.sheetByIndex(0);
                        var data_conteo_total = sheet_conteo_total.toJSON();
                        var total_registros_listados = data_conteo_total.rows.length;


                        // Ocultar Columnas
                        var oculta_columna_spread = spreadsheet_conteo_total.activeSheet();
                        oculta_columna_spread.hideColumn(96);
                        oculta_columna_spread.hideColumn(97);
                        oculta_columna_spread.hideColumn(98);
                        oculta_columna_spread.hideColumn(99);
                        oculta_columna_spread.hideColumn(100);
                        oculta_columna_spread.hideColumn(101);
                        oculta_columna_spread.hideColumn(102);
                        oculta_columna_spread.hideColumn(103);
                        oculta_columna_spread.hideColumn(104);
                        oculta_columna_spread.hideColumn(105);

                        /*var formato_fecha = spreadsheet_conteo_total.activeSheet().range('CM2:CM'+total_registros_listados);
                        formato_fecha.format('dd-mm-YYYY');*/

                        // Bloquear columnas
                        var bloqueo_columna_id = spreadsheet_conteo_total.activeSheet().range("A1:A"+total_registros_listados);
                        var bloqueo_columna_comprajustada = spreadsheet_conteo_total.activeSheet().range("AH1:AH"+total_registros_listados);
                        var bloqueo_columna_uniajustada = spreadsheet_conteo_total.activeSheet().range("AL1:AL"+total_registros_listados);
                        var bloqueo_columna_unifinal = spreadsheet_conteo_total.activeSheet().range("AM1:AM"+total_registros_listados);
                        var bloqueo_columna_tdas = spreadsheet_conteo_total.activeSheet().range("AR1:AR"+total_registros_listados);
                        var bloqueo_columna_portiendas = spreadsheet_conteo_total.activeSheet().range("AX1:AX"+total_registros_listados);
                        var bloqueo_columna_mkup = spreadsheet_conteo_total.activeSheet().range("BC1:BC"+total_registros_listados);
                        var bloqueo_columna_gm = spreadsheet_conteo_total.activeSheet().range("BE1:BE"+total_registros_listados);
                        var bloqueo_columnas_costos = spreadsheet_conteo_total.activeSheet().range("BO1:BT"+total_registros_listados);
                        var bloqueo_columnas_semanas = spreadsheet_conteo_total.activeSheet().range("BV1:BX"+total_registros_listados);
                        var bloqueo_columna_razonsocial = spreadsheet_conteo_total.activeSheet().range("CB1:CB"+total_registros_listados);
                        var bloqueo_columna_codpadre = spreadsheet_conteo_total.activeSheet().range("CF1:CF"+total_registros_listados);
                        var bloqueo_columnas_oc = spreadsheet_conteo_total.activeSheet().range("CH1:CL"+total_registros_listados);
                        var bloqueo_columnas_fecha = spreadsheet_conteo_total.activeSheet().range("CN1:DB"+total_registros_listados);
                        bloqueo_columna_id.enable(false);
                        bloqueo_columna_comprajustada.enable(false);
                        bloqueo_columna_uniajustada.enable(false);
                        bloqueo_columna_unifinal.enable(false);
                        bloqueo_columna_tdas.enable(false);
                        bloqueo_columna_portiendas.enable(false);
                        bloqueo_columna_mkup.enable(false);
                        bloqueo_columna_gm.enable(false);
                        bloqueo_columnas_costos.enable(false);
                        bloqueo_columnas_semanas.enable(false);
                        bloqueo_columna_razonsocial.enable(false);
                        bloqueo_columna_codpadre.enable(false);
                        bloqueo_columnas_oc.enable(false);
                        bloqueo_columnas_fecha.enable(false);


                        var range_via = spreadsheet.activeSheet().range("AZ2:AZ"+total_registros_listados);
                        range_via.validation({
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"AEREA,MARITIMO,TERRESTRE"',
                            allowNulls: false,
                            type: "reject",
                            messageTemplate: "Las opciones permitidas son: AEREA, MARITIMO o TERRESTRE."
                        });

                        var range_tipo_embarque = spreadsheet.activeSheet().range("AF2:AF"+total_registros_listados);
                        range_tipo_embarque.validation({
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"CURVADO,SOLIDO"',
                            allowNulls: false,
                            type: "reject",
                            messageTemplate: "Las opciones permitidas son: CURVADO o SOLIDO."
                        });

                        var range_ventana = spreadsheet.activeSheet().range("X2:X"+total_registros_listados);
                        range_ventana.validation({
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"A,B,C,D,E,F,G,H,I"',
                            allowNulls: false,
                            type: "reject",
                            messageTemplate: "La ventana ingresada, no se encuentra dentro de las permitidas. (Recuerde ingresarla en Mayúsculas.)"
                        });

                    }, {recalc: true});

                }
            }, 0);

        },
        transport: {
            read: onRead,
            /*read: {
                url: crudServiceBaseUrl + "ListarPlanCompra",
                dataType: "json",
                cache: false,
                complete: function(e) {
                    $("#spreadsheet").data("kendoSpreadsheet").dataSource.read();
                    alert("Hola");
                }
            },*/
            submit: onSubmit
        },
        batch: true,
        change: function () {
            $("#cancelar_cambios_pc, #guardar_cambios_pc").toggleClass("k-state-disabled", !this.hasChanges());
        },
        schema: {
            model: {
                id: "ID_COLOR3",
                fields: {
                    ID_COLOR3: {type: "number"}, // Viaja a Controlador
                    /*GRUPO_COMPRA: {type: "string"},
                    COD_TEMP: {type: "string"},
                    LINEA: {type: "string"},
                    SUBLINEA: {type: "string"},
                    MARCA: {type: "string"},
                    ESTILO: {type: "string"},
                    SHORT_NAME: {type: "string"},
                    ID_CORPORATIVO: {type: "string"},
                    DESCMODELO: {type: "string"},
                    DESCRIP_INTERNET: {type: "string"},
                    NOMBRE_COMPRADOR: {type: "string"},
                    NOMBRE_DISENADOR: {type: "string"},
                    COMPOSICION: {type: "string"},
                    TIPO_TELA: {type: "string"},
                    FORRO: {type: "string"},
                    COLECCION: {type: "string"},*/
                    EVENTO: {type: "string"}, // Viaja a Controlador
                    /*EVENTO_INSTORE: {type: "string"},
                    COD_ESTILO_VIDA: {type: "string"},
                    CALIDAD: {type: "string"},
                    COD_OCASION_USO: {type: "string"},
                    COD_PIRAMIX: {type: "string"},*/
                    NOM_VENTANA: {type: "string"}, // Viaja a Controlador
                    /*COD_RANKVTA: {type: "string"},
                    LIFE_CYCLE: {type: "string"},
                    NUM_EMB: {type: "string"},
                    COD_COLOR: {type: "string"},
                    TIPO_PRODUCTO: {type: "string"},
                    TIPO_EXHIBICION: {type: "string"},*/
                    DESTALLA: {type: "string"}, // Viaja a Controlador
                    TIPO_EMPAQUE: {type: "string"}, // Viaja a Controlador
                    PORTALLA_1_INI: {type: "string"}, // Viaja a Controlador
                    //PORTALLA_1: {type: "string"},
                    CURVATALLA: {type: "string"}, // Viaja a Controlador
                    //CURVAMIN: {type: "number"},
                    UNID_OPCION_INICIO: {type: "number"}, // Viaja a Controlador
                    //UNID_OPCION_AJUSTADA: {type: "number"},
                    CAN: {type: "number"}, // Viaja a Controlador
                    //MTR_PACK: {type: "number"},
                    //CANT_INNER: {type: "number"},
                    SEG_ASIG: {type: "string"}, // Viaja a Controlador
                    FORMATO: {type: "string"}, // Viaja a Controlador
                    //TDAS: {type: "number"},
                    A: {type: "number"}, // Viaja a Controlador
                    B: {type: "number"}, // Viaja a Controlador
                    C: {type: "number"}, // Viaja a Controlador
                    I: {type: "number"}, // Viaja a Controlador
                    /*UND_ASIG_INI: {type: "number"},
                    ROT: {type: "number"},
                    NOM_PRECEDENCIA: {type: "string"},*/
                    NOM_VIA: {type: "string"}, // Viaja a Controlador
                    NOM_PAIS: {type: "string"}, // Viaja a Controlador
                    /*VIAJE: {type: "string"},
                    MKUP: {type: "number"},*/
                    PRECIO_BLANCO: {type: "number"}, // Viaja a Controlador
                    /*GM: {type: "number"},
                    OFERTA: {type: "string"},
                    DOSX: {type: "string"},
                    OPEX: {type: "string"},
                    COD_TIP_MON: {type: "string"},*/
                    COSTO_TARGET: {type: "number"}, // Viaja a Controlador
                    COSTO_FOB: {type: "number"}, // Viaja a Controlador
                    COSTO_INSP: {type: "number"}, // Viaja a Controlador
                    COSTO_RFID: {type: "number"}, // Viaja a Controlador
                    /*ROYALTY_POR: {type: "number"},
                    COSTO_UNIT: {type: "number"},
                    COSTO_UNITS: {type: "number"},
                    CST_TOTLTARGET: {type: "percent"},
                    COSTO_TOT: {type: "number"},
                    COSTO_TOTS: {type: "number"},
                    RETAIL: {type: "number"},*/
                    DEBUT_REODER: {type: "string"}, // Viaja a Controlador
                    /*SEM_INI: {type: "string"},
                    SEM_FIN: {type: "string"},
                    CICLO: {type: "number"},
                    AGOT_OBJ: {type: "number"},
                    SEMLIQ: {type: "number"},*/
                    ALIAS_PROV: {type: "string"}, // Viaja a Controlador
                    /*COD_PROVEEDOR: {type: "string"},
                    COD_TRADER: {type: "string"},
                    AFTER_MEETING_REMARKS: {type: "string"},
                    CODSKUPROVEEDOR: {type: "string"},
                    SKU: {type: "string"},*/
                    PROFORMA: {type: "string"}, // Viaja a Controlador
                    ARCHIVO: {type: "string"}, // Viaja a Controlador
                    /*ESTILO_PMM: {type: "string"},
                    ESTADO_MATCH: {type: "string"},
                    PO_NUMBER: {type: "number"},
                    ESTADO_OC: {type: "string"},*/
                    FECHA_ACORDADA: {type: "string"}, // Viaja a Controlador
                    /*FECHA_EMBARQUE: {type: "string"},
                    FECHA_ETA: {type: "string"},
                    FECHA_RECEPCION: {type: "string"},
                    DIAS_ATRASO: {type: "number"},
                    CODESTADO: {type: "string"},*/
                    ESTADO_C1: {type: "string"}, // Viaja a Controlador
                    //VENTANA_LLEGADA: {type: "string"},
                    PROFORMA_BASE: {type: "string"}, // Viaja a Controlador
                    /*TIPO_EMPAQUE_BASE: {type: "string"},
                    UNI_INICIALES_BASE: {type: "number"},
                    PRECIO_BLANCO_BASE: {type: "number"},
                    COSTO_TARGET_BASE: {type: "number"},
                    COSTO_FOB_BASE: {type: "number"},
                    COSTO_INSP_BASE: {type: "number"},
                    COSTO_RFID_BASE: {type: "percent"},*/
                    COD_MARCA: {type: "number"}, // Viaja a Controlador
                    N_CURVASXCAJAS: {type: "number"}, // Viaja a Controlador
                    COD_JER2: {type: "string"}, // Viaja a Controlador
                    COD_SUBLIN: {type: "string"}, // Viaja a Controlador
                    ARCHIVO_BASE: {type: "string"}, // Viaja a Controlador
                    FORMATO_BASE: {type: "string"} // Viaja a Controlador

                }
            }
        }

    });

    // Asigna la estructura visual de la Grilla tipo Excel
    $("#spreadsheet").kendoSpreadsheet({
        columns: 106, //106 Siempre visible
        rows: localStorage.getItem("TOTALREGPLAN"),
        //rows: 800,
        //toolbar: true,
        toolbar: {
            home: [
                { type: "button",
                    text: "Importar",
                    icon: "k-icon k-i-upload",
                    click: Pop_Importar
                },
                { type: "button",
                    text: "Exportar",
                    icon: "k-icon k-i-download",
                    click: Pop_Exportar
                },
                "freeze",
                "filter",
                { type: "button",
                    text: "Ajuste Compra",
                    showText: "both",
                    icon: "k-icon k-i-cog",
                    click: Pop_ajuste_compra
                },
                { type: "button",
                    text: "Ajuste Cajas",
                    showText: "both",
                    icon: "k-icon k-i-greyscale",
                    click: Pop_ajuste_cajas
                },
                { type: "button",
                    text: "Historial",
                    showText: "both",
                    icon: "k-icon k-i-clock",
                    click: Pop_Historial
                },
                { type: "button",
                    text: "Detalle Error",
                    showText: "both",
                    icon: "k-icon k-i-preview",
                    click: POPUPDetalleError
                },
                { type: "button",
                    text: "Tienda",
                    showText: "both",
                    icon: "k-icon k-i-cart",
                    click: POPUPTienda
                },
                { type: "button",
                    text: "Formato",
                    showText: "both",
                    icon: "k-icon k-i-select-box",
                    click: POPUPFormato
                }
            ],
            insert: false,
            data: [
                { type: "button",
                    text: "Plan Presupuestos",
                    showText: "both",
                    imageUrl: "../web/telerik/content/web/16x16/Grid.png",
                    click: Pop_Presupuestos
                }, { type: "button",
                    text: "Presupuestos",
                    showText: "both",
                    icon: "k-icon k-i-currency",
                    click: Pop_editPresupuestos
                    }
            ]
        },
        sheetsbar: false,
        sheets: [{
            name: "PlanDeCompra",
            dataSource: dataSource,
            filter: {
                ref: "A1:CR"+localStorage.getItem("TOTALREGPLAN"),
                //ref: "A1:CR800",
                columns:[]
            },
            columns: [
                {width: 60},    // id
                {width: 110},   // G. Compra
                {width: 100},   // Temp
                {width: 150},   // Línea
                {width: 150},   // Sub Línea
                {width: 130},   // Marca
                {width: 230},   // Estilo
                {width: 200},   // Estilo Corto
                {width: 130},   // Cod. Corp
                {width: 250},   // Descripción
                {width: 250},   // Descripción Internet
                {width: 150},   // Nombre Comprador
                {width: 150},   // Nombre Diseñador
                {width: 200},   // Composición
                {width: 130},   // Tipo Tela
                {width: 130},   // Forro
                {width: 250},   // Colección
                {width: 200},   // Evento
                {width: 200},   // Evento In-Store
                {width: 130},   // Estilo Vida
                {width: 130},   // Calidad
                {width: 200},   // Ocación de Uso
                {width: 150},   // Pirámide Mix
                {width: 90},    // Ventana
                {width: 200},   // Rank Vta
                {width: 150},   // Life Cycle
                {width: 130},   // Num. Emb
                {width: 100},   // Color
                {width: 130},   // Tipo Producto
                {width: 150},   // Tipo Exhibición
                {width: 140},   // Tallas
                {width: 130},   // Tipo Empaque
                {width: 300},   // % Compra Inicial
                {width: 300},   // % Compra Ajustada
                {width: 150},   // Curvas de Reparto
                {width: 110},   // Curvas Min
                {width: 100},   // Unid Ini
                {width: 100},   // Unid Ajust
                {width: 100},   // Unid Final
                {width: 100},   // Mtr Pack
                {width: 100},   // N Cajas
                {width: 100},   // Cluster
                {width: 100},   // Formato
                {width: 80},   // Tdas
                {width: 90},   // A
                {width: 90},   // B
                {width: 90},   // C
                {width: 90},   // I
                {width: 120},   // Primera Carga
                {width: 100},   // % Tiendas
                {width: 100},   // Proced
                {width: 100},   // Vía
                {width: 200},   // País
                {width: 100},   // Viaje
                {width: 90},    // Mkup
                {width: 120},   // Precio Blanco
                {width: 90},    // GM
                {width: 90},    // Oferta
                {width: 90},    // Moneda
                {width: 90},    // 2x
                {width: 90},    // Opex
                {width: 90},    // Target
                {width: 90},    // FOB
                {width: 90},    // Insp
                {width: 90},    // RFID
                {width: 110},    // Royalty
                {width: 180},   // Costo Unitario Final USD
                {width: 180},   // Costo Unitario Final Pesos
                {width: 130},   // Total Target USD
                {width: 130},   // Total FOB USD
                {width: 130},   // Costo Total
                {width: 130},   // Total Retail
                {width: 130},    // Debut/Reorder
                {width: 90},    // Sem Ini
                {width: 90},    // Sem Fin
                {width: 150},   // Sem Ciclo Vida
                {width: 100},    // Agot Obj
                {width: 130},   // Semanas Liquidación
                {width: 250},   // Proveedor
                {width: 120},   // Razón Social
                {width: 100},   // Trader
                {width: 170},   // After Meeting Remark
                {width: 130},   // Cod. SKU Proveedor
                {width: 110},   // Cod. Padre
                {width: 150},   // Proforma
                {width: 90},    // Archivo
                {width: 230},   // Estilo PMM
                {width: 120},    // Estado Match
                {width: 90},    // N OC
                {width: 120},    // Estado OC
                {width: 160},   // Fecha Acordada
                {width: 140},   // Fecha Embarque
                {width: 140},   // Fecha ETA
                {width: 140},   // Fecha Recep CD
                {width: 140},   // Dias Atraso CD
                {width: 220}    // Estado Opcion
            ],
            rows: [
                {
                    //height: 25,
                    cells: [//index: 0,
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, //, background: "rgb(205,255,133)", textAlign: "center"
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // G. Compra
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Temp
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Línea
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // SubLínea
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Marca
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Estilo
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Estilo Corto
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Cod. Corp
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Descripción
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Descripción Internet
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Nombre Comprador
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Nombre Diseñador
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Composición
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Tipo Tela
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Forro
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Colección
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Evento
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Evento In-Store
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Estilo de Vida
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Calidad
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Ocación de Uso
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Pirámide Mix
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Ventana
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Rank Vta
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Life Cycle
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Cod. Opción
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Color
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Tipo Producto
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Tipo Exhibición
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Tallas
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Tipo Empaque
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // % Compra Inicial
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // % Compra Ajustada
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Curvas de Reparto
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Curvas Min
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Unid Ini
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Unid Ajust
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Unid Final
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Mtr Pack
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // N° Cajas
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Cluster
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Formato
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Tdas
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // A
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // B
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // C
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // I
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Primera Carga
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // % Tiendas
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Proced
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Vía
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // País
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Viaje
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Mkup
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Precio Blanco
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // GM
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Oferta
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // 2X
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Opex
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Moneda
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Target
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // FOB
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Insp
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // RFID
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Royalty(%)
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Costo Unitario Final US$
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Costo Unitario Final Pesos
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Total Target US$
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Total Fob US$
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Costo Total
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Total Retail
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Debut/Reorder
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Sem Ini
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Sem Fin
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Semanas Ciclo de Vida
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Agot Obj
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Semanas Liquidación
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Proveedor
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Razón Social
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Trader
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // After Meeting Remark
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Cod. SKU Proveedor
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Cod. Padre
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Proforma
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Archivo
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Estilo PMM
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Estado Match
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // N° OC
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Estado OC
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true, background: "rgb(205,255,133)"}, // Fecha Acordada
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Fecha Embarque
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Fecha ETA
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Fecha Recepción CD
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}, // Días Atraso CD
                        {textAlign: "center", color: "rgb(0,0,0)", enable: false, bold:true}  // Estado Opción
                    ]
                }
            ]
        }]
    });

    // Cambiar Nombre a TABS de la Botonera SPREADSHEET
    var textoTAB = $('#spreadsheet').data('kendoSpreadsheet');
    textoTAB._view.tabstrip.tabGroup.find("li:eq(0) .k-link").text("Home");
    textoTAB._view.tabstrip.tabGroup.find("li:eq(1) .k-link").text("Presupuestos");

    // Evitar que se editen las cabeceras (Escribir Sobre)
    document.querySelector("#spreadsheet").addEventListener("keydown", function(ev) {
        var spread = $("#spreadsheet").getKendoSpreadsheet();
        var sheet = spread.activeSheet()
        var cell = sheet.activeCell();

        if(cell.topLeft.col >=0 && cell.topLeft.row == 0)  {
            ev.stopPropagation();
            ev.preventDefault();
        }
    }, true);

    // Evitar que se editen las cabeceras (Doble Clic)
    document.querySelector("#spreadsheet").addEventListener("dblclick", function(ev) {

        var spread = $("#spreadsheet").getKendoSpreadsheet();
        var sheet = spread.activeSheet()
        var cell = sheet.activeCell();

        if(cell.topLeft.col >=0 && cell.topLeft.row == 0)  {
            ev.stopPropagation();
            ev.preventDefault();
        }
    }, true);


    // $('#spreadsheet').data('kendoSpreadsheet').dataSource.read();
    // $('#spreadsheet').data('kendoSpreadsheet').refresh();

    // ################## OTRAS FUNCIONES ASOCIADAS A LA ESTRUCTURA DE LAGRILLA ####################
    // #############################################################################################
    // ################################# AQUÍ NO VAN ACCIONES JS ###################################
    // ################### AQUÍ SE DEFINE SOLO LA ESTRUCTURA DEL PLAN DE COMPRA ####################
    // ################################### SÓLO CODIGO TELERIK #####################################

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // Función Guardar Cambios Plan de Compra
    $("#guardar_cambios_pc").click(function () {


        // Verificar Permisos ()
        if(localStorage.getItem("T0001")){

            if (!$(this).hasClass("k-state-disabled")) {
                dataSource.sync();
            }

        }else{
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
        }




    });

    // Función Cancelar Plan de Compra
    $("#cancelar_cambios_pc").click(function () {

        // Verificar Permisos ()
        if(localStorage.getItem("T0001")){

            if (!$(this).hasClass("k-state-disabled")) {
                dataSource.cancelChanges();
            }

        }else{
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
        }


    });


    // Agrega ContextMenu en Plan de Compra
    var spreadsheet_contextual = $("#spreadsheet").data("kendoSpreadsheet");
    var menu_celda_archivopi = spreadsheet_contextual._controller.cellContextMenu;
    menu_celda_archivopi.append([
        /*{ cssClass: "k-separator" },
        { text: "Historial" },
        { text: "Ajuste Compra" },
        { text: "Ajuste N° Cajas" },
        { text: "Detalle Error" },*/
        { cssClass: "k-separator" },
        { text: "Descarga Archivo PI" },
        { text: "Cargar Archivo PI" },
        { cssClass: "k-separator" },
        { text: "Match" },
        { cssClass: "k-separator" },
        { text: "Cambio Estado" }
    ]);
    menu_celda_archivopi.bind("select",
        function (e) {

            var command = $(e.item).text();
            var cont_select = 0;

            // Seteo Variable
            var ID_COLOR3 = "";
            var DEBUTREORDER = "";
            var PROFORMA = "";
            var PROFORMA_ARCHIVO = "";
            var ESTADOC1 = "";
            var ARCHIVO = "";
            var OC = "";
            var LINKEADA = "";
            var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet = spreadsheet_id_color3.activeSheet();
            var range = sheet.selection();

            // Busco datos de Temporada y Depto
            var descragapi_data_temp_depto = $("#span_data_temp_depto").text();
                descragapi_data_temp_depto = descragapi_data_temp_depto.toString().replace(/[^a-z0-9\-\_]/gi, '');
            var descragapi_data_separa_barra = descragapi_data_temp_depto.split("-");
            var TemporadaArchivoPI = descragapi_data_separa_barra[0];
            var DeptoArchivoPI = descragapi_data_separa_barra[1];


            range.forEachCell(function (row, column, value) {

                //console.log(row, column, value);

                var fila_id = row+1;
                var range_color3 = sheet.range("A"+fila_id);
                ID_COLOR3 = range_color3.values();
                var range_debutreorder = sheet.range("BU"+fila_id);
                DEBUTREORDER = range_debutreorder.values();
                var range_proforma = sheet.range("CG"+fila_id);
                PROFORMA = range_proforma.values();
                var range_oc = sheet.range("CK"+fila_id);
                OC = range_oc.values();
                var range_linkeada = sheet.range("CJ"+fila_id);
                LINKEADA = range_linkeada.values();
                var range_estadoc1 = sheet.range("CS"+fila_id);
                ESTADOC1 = range_estadoc1.values();
                var range_archivo = sheet.range("CH"+fila_id);
                ARCHIVO = range_archivo.values();
                cont_select++;
            });


            // NO ejecutar acciones cuando el ID_COLOR3 = 0, vacio o null

            if(command == "Descarga Archivo PI") {

                if(cont_select>1){
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No selecciones más de un registro.", "info");
                }else{

                    // Actualiza Concurrencia
                    ActualizaConcurrencia();

                    // Verificar Permisos
                    if(localStorage.getItem("T0002")){

                        // Descarga PI
                        if (ESTADOC1 != 0) {

                            // PROFORMA = Archivo Original

                            //PROFORMA_ARCHIVO = String(PROFORMA).replace(/[^a-z0-9\-\_]/gi, '-');
                            PROFORMA_ARCHIVO = String(PROFORMA).replace(/[^a-z0-9\-\_]/gi, '-');

                            var valFileDownloadPath = '../archivos/pi/PI_' + TemporadaArchivoPI + '_' + DeptoArchivoPI + '_' + PROFORMA_ARCHIVO + '.xlsx';
                            window.open(valFileDownloadPath, '_blank');

                        }else{
                            popupNotification.getNotifications().parent().remove();
                            popupNotification.show(" No puedes descargar en estado Ingresado.", "info");
                        }

                    }else{
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                        // Fin Verificar Permisos
                    }

                }




            // Fin descarga archivo
            }

            if(command == "Cargar Archivo PI") {


                if(cont_select>1){
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No selecciones más de un registro.", "info");
                }else{

                    // Actualiza Concurrencia
                    ActualizaConcurrencia();

                    /*
                    var sheet = spreadsheet.activeSheet(),
                    selection = sheet.selection();
                    selection.background("green");
                    */

                    // Verificar Permisos
                    if(localStorage.getItem("T0003")){


                        if( (PROFORMA.length==0) || (PROFORMA==null) || (PROFORMA=="") || (ARCHIVO=="Cargado..") || (ESTADOC1==24)){
                            popupNotification.getNotifications().parent().remove();
                            popupNotification.show(" Seleccione un registro con proforma y archivo sin cargar.", "info");
                        }else {

                            // Le asigno el nombre de la Proforma al campo de texto
                            $("#NombrePI").val(PROFORMA);

                            // Levantamos el popup
                            var popupArchivoPI = $("#POPUP_carga_archivo_pi");
                            popupArchivoPI.data("kendoWindow").open();

                        }


                    }else{
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                        // Fin Verificar Permisos
                    }

                }






            }

            if(command == "Match") {

                if(cont_select>1){
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No selecciones más de un registro.", "info");
                }else{

                    // Actualiza Concurrencia
                    ActualizaConcurrencia();

                    // Verificar Permisos
                    if(localStorage.getItem("T0004")){

                        // Que llegue la proforma y el estado sea Pendiente de Aprobación sin Match
                        if( (PROFORMA.length==0) || (PROFORMA==null) || (PROFORMA=="") || (ESTADOC1!=19) || (OC=="") || (OC.length==0) || (OC==null) ){

                            popupNotification.getNotifications().parent().remove();
                            popupNotification.show(" Seleccione un registro con Proforma, OC no Linkeada y Pendiente de Aprobacion sin Match.", "info");

                        }else {

                            // Levantar el POPUP
                            var popupMatch = $("#POPUP_match");
                            popupMatch.data("kendoWindow").open();

                            // Antes de volver a cargar la data, reseteo lo existente
                            $("#grid_match_pmm").data("kendoGrid").dataSource.data([]);
                            $("#grid_match_plan").data("kendoGrid").dataSource.data([]);
                            // Destruimos el GRID del PLAN
                            var gridMatchPLAN = $("#grid_match_plan").data("kendoGrid");
                            gridMatchPLAN.destroy();


                            // CBX de País
                            function MatchLineaDropDownEditor(container, options) {
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
                                                    url: "TelerikPlanCompra/ListarLineaCBXMatch",
                                                    dataType: "json"/*
                                            type: "POST"*/
                                                }
                                            }
                                        }//,select: CambiaLineaMatchDropDown
                                    });
                            }

                            // Revisar, asociado a select: CambiaLineaMatchDropDown
                            function CambiaLineaMatchDropDown(e){

                                if (e.dataItem) {
                                    console.log(e.dataItem);
                                    var dataItem = e.dataItem;
                                    console.log("event :: select (" + dataItem.text + " : " + dataItem.value + ")");
                                } else {
                                    console.log("event :: select");
                                }
                            }

                            // CBX de SubLínea
                            function MatchSubLineaDropDownEditor(container, options) {
                                $('<input required name="' + options.field + '"/>')
                                    .appendTo(container)
                                    .kendoDropDownList({
                                        autoBind: false,
                                        filter: "contains",
                                        dataTextField: "SLI_DESCRIPCION",
                                        dataValueField: "SLI_SUBLINEA",
                                        dataSource: {
                                            transport: {
                                                read:  {
                                                    url: "TelerikPlanCompra/ListarSubLineaCBXMatch",
                                                    //data:{LINEA:kendo.parseInt(OC)},
                                                    data:{LINEA:String(options.model.LINEA)},
                                                    dataType: "json"/*,
                                            type: "POST"*/
                                                }
                                            }
                                        }
                                    });
                            }

                            // CBX de Color
                            function MatchColorDropDownEditor(container, options) {
                                $('<input required name="' + options.field + '"/>')
                                    .appendTo(container)
                                    .kendoDropDownList({
                                        autoBind: false,
                                        filter: "contains",
                                        dataTextField: "NOM_COLOR",
                                        dataValueField: "COD_COLOR",
                                        dataSource: {
                                            transport: {
                                                read:  {
                                                    url: "TelerikPlanCompra/ListarColorCBXMatch",
                                                    dataType: "json"/*,
                                            type: "POST"*/
                                                }
                                            }
                                        }
                                    });
                            }



                            // Seteo DataSet
                            var dataSource_match_pmm = new kendo.data.DataSource({
                                transport: {

                                    read:  {
                                        url: "TelerikPlanCompra/MatchLlenarGridPMM",
                                        dataType: "json",
                                        //type: "POST",
                                        data:{OC:kendo.parseInt(OC),PROFORMA:String(PROFORMA)}
                                    }

                                },
                                //complete: TerminaCargaPMM
                                //success: TerminaCargaPMM,
                                //requestEnd: TerminaCargaPMM,
                                //change: TerminaCargaPMM,
                                requestEnd: TerminaCargaPMM,
                                schema: {
                                    model: {
                                        fields: {
                                            ORDEN_DE_COMPRA: {type: "number"},
                                            PI: {type: "string"},
                                            NOMBRE_LINEA: {type: "string"},
                                            NRO_LINEA: {type: "string"},
                                            NOMBRE_SUB_LINEA: {type: "string"},
                                            NRO_SUB_LINEA: {type: "string"},
                                            NOMBRE_ESTILO: {type: "string"},
                                            NRO_ESTILO: {type: "string"},
                                            COLOR: {type: "string"},
                                            COD_COLOR: {type: "string"}
                                        }


                                    }
                                }
                            });

                            var dataSource_match_plan = new kendo.data.DataSource({
                                transport: {
                                    read:  {
                                        url: "TelerikPlanCompra/MatchLlenarGridPlan",
                                        dataType: "json",
                                        //type: 'POST',
                                        data:{OC:kendo.parseInt(OC),PROFORMA:String(PROFORMA)}
                                    },
                                    update: {
                                        url: "TelerikPlanCompra/ActualizaPlanMATCH",
                                        dataType: "json"/*,
                                type: "POST"*/
                                    }
                                },
                                // autoSync: true,
                                // complete: TerminaCargaPLAN
                                // success: TerminaCargaPLAN,
                                // requestEnd: TerminaCargaPLAN,
                                change: TerminaCargaPLAN,
                                schema: {
                                    model: {
                                        id: "ID",
                                        fields: {
                                            ID: {type: "number"},
                                            PROFORMA: {type: "string"},
                                            //LINEA: {type: "string"}, //type: "string", defaultValue: { LIN_LINEA: "002009", LIN_DESCRIPCION: "ABRIGOS"}
                                            COD_LINEA: {type: "string"},
                                            SUB_LINEA: {type: "string"},
                                            COD_SUBLINEA: {type: "string"},
                                            ESTILO: {type: "string"},
                                            NRO_ESTILO: {type: "string"},
                                            COLOR: {type: "string"},
                                            COD_COLOR: {type: "string"}
                                        }
                                    }
                                }
                            });



                            // Cuando Termina la Carga del DataSet de PMM
                            function TerminaCargaPMM(container, options) {
                                // Cantidad de Registros del DatasSet PMM
                                //var data = dataSource_match_pmm.data();
                                //alert(data.length);

                                // Una vez cargado el grid de PMM, cargo el del PLAN
                                dataSource_match_plan.read();

                            }

                            // Cuando Termina la Carga del DataSet de PLAN
                            function TerminaCargaPLAN(container, options) {

                                // Cantidad de Registros del DatasSet PMM
                                var dataPMM = dataSource_match_pmm.data();
                                // Cantidad de Registros del DatasSet PLAN
                                var dataPLAN = dataSource_match_plan.data();
                                //alert(data.length);

                                // Comparo la cantidad de registros de las dos tablas
                                if(dataPMM.length != dataPLAN.length){

                                    // Ocultar la Botonera
                                    $("#grid_match_plan .k-grid-toolbar").hide();

                                    popupNotification.getNotifications().parent().remove();
                                    popupNotification.show(" La Cantidad de Registros de PMM y PLAN, no son iguales.", "error");

                                }else{

                                    // Recargo el DATASOURCE
                                    var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                    var sheet = spreadsheet.activeSheet();
                                    sheet.dataSource.read();

                                }



                                // Fin TerminaCargaPLAN
                            }


                            // Asigno el DataSet al Grid de PMM
                            $("#grid_match_pmm").kendoGrid({
                                columns:[
                                    {title: "PMM",
                                        headerAttributes: {
                                            style: "text-align: center"
                                        },
                                        columns: [
                                            { hidden: true, field: "ORDEN_DE_COMPRA" },
                                            { hidden: true, field: "PI" },
                                            { field: "NOMBRE_LINEA", title: "Línea" },
                                            { field: "NRO_LINEA", title: "Cod. Linea", width: 90 },
                                            { field: "NOMBRE_SUB_LINEA", title: "SubLínea", width:250 },
                                            { field: "NRO_SUB_LINEA", title: "Cod. SubLínea", width: 100 },
                                            { field: "NOMBRE_ESTILO", title: "Estilo", width:280 },
                                            { field: "NRO_ESTILO", title: "N° Estilo", width: 90 },
                                            { field: "COLOR", title: "Color", width: 200 },
                                            { field: "COD_COLOR", title: "Cod. Color", width: 90 }
                                        ]
                                    }
                                ],
                                dataSource: dataSource_match_pmm
                            });

                            // Asigno el DataSet al Grid de PLAN
                            $("#grid_match_plan").kendoGrid({
                                autoBind:false,
                                dataSource: dataSource_match_plan,
                                //dataBound: MatchPlanOnDataBound,
                                //dataBinding: MatchPlanOnDataBinding,
                                dataBound: function(e){

                                    var grid1PMM = $("#grid_match_pmm").getKendoGrid();
                                    var itemsPMM = grid1PMM.dataSource.data();
                                    var itemsPLAN = e.sender.dataSource.data();

                                    var flag_errores_match = 0;

                                    var arregloErroresMatch = [];


                                    itemsPLAN.forEach(function(el){
                                        $("[data-uid='"+el.uid+"']").css("background", "#FF2D00");
                                    })

                                    // Comparar los registros de las grillas
                                    itemsPLAN.forEach(function(el){

                                        //console.log(el.LINEA);

                                        var pre_linea = el.LINEA;
                                        pre_linea = pre_linea.split(' - ');
                                        var compara_linea = pre_linea[0].substring(1, pre_linea[0].length-1);

                                        var pre_sublinea = el.SUB_LINEA;
                                        pre_sublinea = pre_sublinea.split(' - ');
                                        var compara_sublinea =  pre_sublinea[0].substring(1, pre_sublinea[0].length-1);

                                        var pre_color = el.COLOR;
                                        pre_color = pre_color.split(' - ');
                                        var compara_color =  pre_color[0].substring(1, pre_color[0].length-1);

                                        var compara_estilo = el.ESTILO;



                                        loop1:
                                            itemsPMM.forEach(function(el2){

                                                console.log("#######################################################");
                                                console.log(compara_linea+" / "+el2.NRO_LINEA);
                                                console.log(compara_sublinea+" / "+el2.NRO_SUB_LINEA);
                                                console.log(compara_color+" / "+el2.COD_COLOR);
                                                console.log(compara_estilo+" / "+el2.NOMBRE_ESTILO);

                                                loop2:
                                                    /*if( (compara_linea != el2.NRO_LINEA) || (compara_sublinea != el2.NRO_SUB_LINEA) || (compara_color != el2.COD_COLOR) || (compara_estilo != el2.NOMBRE_ESTILO)  ){

                                                        $("[data-uid='"+el.uid+"']").css("background", "#FF2D00");
                                                        flag_errores_match++;

                                                    }else{

                                                        // Agrega Registro al array
                                                        arregloErroresMatch.push({
                                                            "LINEA": compara_linea,
                                                            "SUBLINEA": compara_sublinea,
                                                            "COLOR": compara_color,
                                                            "ESTILO": compara_estilo
                                                        });

                                                        $("[data-uid='"+el.uid+"']").css("background", "");
                                                        break loop2;

                                                    }*/

                                                    if( (compara_linea == el2.NRO_LINEA) && (compara_sublinea == el2.NRO_SUB_LINEA) && (compara_color == el2.COD_COLOR) && (compara_estilo == el2.NOMBRE_ESTILO)  ){

                                                        // Agrega Registro al array
                                                        arregloErroresMatch.push({
                                                            "LINEA": compara_linea,
                                                            "SUBLINEA": compara_sublinea,
                                                            "COLOR": compara_color,
                                                            "ESTILO": compara_estilo
                                                        });

                                                        $("[data-uid='"+el.uid+"']").css("background", "");
                                                        flag_errores_match++;

                                                    }



                                            })

                                    })

                                    //console.log(arregloErroresMatch);

                                    // Si hay Errores, oculto el BTN de Match
                                    var dataPlanConteo = dataSource_match_plan.data();
                                    //dataPlanConteo.length

                                    //if(flag_errores_match>0){
                                    if(dataPlanConteo.length != arregloErroresMatch.length){
                                        $(".k-grid-guardamatch").hide();
                                    }else{
                                        $(".k-grid-guardamatch").show();
                                    }


                                },
                                //toolbar: ["save", "cancel"],
                                toolbar: [
                                    { name: "save", text: "Actualizar Registros", iconClass: "k-icon k-i-copy" },
                                    { name: "cancel", text: "Cancelar Modificaciones" },
                                    { name: 'guardamatch',text: "Realizar Match", iconClass: "k-icon k-i-save" }
                                ],
                                editable: true,
                                columns:[
                                    {title: "PLAN DE COMPRA",
                                        headerAttributes: {
                                            style: "text-align: center"
                                        },
                                        columns: [
                                            { hidden: true,field: "ID" },
                                            { hidden: true, field: "PROFORMA" },
                                            { field: "LINEA", title: "Línea", editor: MatchLineaDropDownEditor }, //, template: "#=LINEA.LIN_DESCRIPCION#"
                                            { field: "COD_LINEA", title: "Cod. Línea", editable: false, width: 90 },
                                            { field: "SUB_LINEA", title: "SubLínea", editor: MatchSubLineaDropDownEditor, width:250 },
                                            { field: "COD_SUBLINEA", title: "Cod. SubLínea", editable: false, width: 100 },
                                            { field: "ESTILO", title: "Estilo", width:280 },
                                            { field: "NRO_ESTILO", title: "N° Estilo", editable: false, width: 90 },
                                            { field: "COLOR", title: "Color", editor: MatchColorDropDownEditor, width: 200 },
                                            { field: "COD_COLOR", title: "Cod. Color", editable: false, width: 90 }
                                        ]}
                                ]


                            });

                            // BTN Guardar Match
                            $(".k-grid-guardamatch").click(function(e){

                                // Actualiza la Fecha de la Concurrencia
                                // act_fecha_concurrencia();

                                $.ajax({
                                    //type: "POST",
                                    url: "TelerikPlanCompra/GenerarMatch",
                                    data: {OC:kendo.parseInt(OC),PROFORMA:String(PROFORMA)},
                                    //contentType: "application/json",
                                    dataType: "json",
                                    success: function (result) {

                                        // kendo.log(result);
                                        /*e.success(result.Updated, "update");
                                        e.success(result.Created, "create");
                                        e.success(result.Destroyed, "destroy");*/

                                        if(result=="OK"){

                                            // Avisamos que el Match se encuentra OK
                                            popupNotification.getNotifications().parent().remove();
                                            popupNotification.show(" Match OK, Esperando Variaciones ...", "success");

                                            // Aquí comenzamos con el Insertar de Variaciones
                                            $.ajax({
                                                //type: "POST",
                                                url: "TelerikPlanCompra/GenerarMatchVariaciones",
                                                data: {OC:kendo.parseInt(OC),PROFORMA:String(PROFORMA)},
                                                //contentType: "application/json",
                                                dataType: "json",
                                                success: function (result) {

                                                    // Se Registró MATCH y Variaciones
                                                    if(result=="OK"){

                                                        // Recargo el DATASOURCE
                                                        /*var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                                        var sheet = spreadsheet.activeSheet();
                                                        sheet.dataSource.read();

                                                        // Avisamos que el Match se encuentra OK
                                                        //popupNotification.getNotifications().parent().remove();
                                                        popupNotification.show(" Variaciones OK, Hemos Finalizado.", "success");

                                                        // Cierro el POPUP de MATCH
                                                        popupMatch.data("kendoWindow").close();*/


                                                        // Inserta o Actualiza Tabla plc_ordenes_compra_pmm (NUEVO, PARCHE LALO)
                                                        $.ajax({
                                                            //type: "POST",
                                                            url: "TelerikPlanCompra/AgregaOcTablaOCPMM",
                                                            data: {OC:kendo.parseInt(OC),PROFORMA:String(PROFORMA)},
                                                            dataType: "json",
                                                            success: function (result) {

                                                                // Se Insertó Registro en plc_ordenes_compra_pmm
                                                                if(result=="OK"){

                                                                    // Recargo el DATASOURCE
                                                                    var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                                                    var sheet = spreadsheet.activeSheet();
                                                                    sheet.dataSource.read();

                                                                    // Avisamos que el Match se encuentra OK
                                                                    //popupNotification.getNotifications().parent().remove();
                                                                    popupNotification.show(" Variaciones OK, Hemos Finalizado.", "success");

                                                                    // Vaciar GRID de Match
                                                                    $("#grid_match_pmm").empty();
                                                                    $("#grid_match_plan").empty();

                                                                    // Cierro el POPUP de MATCH
                                                                    popupMatch.data("kendoWindow").close();


                                                                }else{
                                                                    //popupNotification.getNotifications().parent().remove();
                                                                    popupNotification.show(" No se insertó registro en plc_ordenes_compra_pmm.", "error");
                                                                }

                                                            },
                                                            error: function (xhr, httpStatusMessage, customErrorMessage) {
                                                                popupNotification.getNotifications().parent().remove();
                                                                popupNotification.show(" No se insertó registro en plc_ordenes_compra_pmm. "+result, "error");
                                                            }
                                                        });






                                                    }else{
                                                        //popupNotification.getNotifications().parent().remove();
                                                        popupNotification.show(" Problema al Insertar Variaciones.", "error");
                                                    }

                                                },
                                                error: function (xhr, httpStatusMessage, customErrorMessage) {

                                                    // Tipo Consola
                                                    console.log(xhr.responseText);
                                                    console.log(httpStatusMessage);
                                                    console.log(customErrorMessage);

                                                    popupNotification.getNotifications().parent().remove();
                                                    popupNotification.show(" Problemas la Transferencia de la Data - VARIACIONES. "+result, "error");

                                                }
                                            });


                                        }else{
                                            popupNotification.getNotifications().parent().remove();
                                            popupNotification.show(" Problemas al Generar Match o Info retornada. "+result, "error");
                                        }


                                    },
                                    error: function (xhr, httpStatusMessage, customErrorMessage) {

                                        // Tipo Alerta
                                        /*alert(xhr.responseText);
                                        alert(httpStatusMessage);
                                        alert(customErrorMessage);*/

                                        // Tipo Consola
                                        console.log(xhr.responseText);
                                        console.log(httpStatusMessage);
                                        console.log(customErrorMessage);

                                        popupNotification.getNotifications().parent().remove();
                                        popupNotification.show(" Problemas con la Transferencia de la Data - MATCH.", "error");

                                    }
                                });


                            });


                            // Fin Else
                        }

                    }else{
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                        // Fin Verificar Permisos
                    }

                }



            }

            if(command == "Cambio Estado") {

                if(cont_select>1){
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No selecciones más de un registro.", "info");
                }else{

                    // Actualiza Concurrencia
                    ActualizaConcurrencia();

                    // Verificar Permisos
                    //if(localStorage.getItem("T0002")){

                    if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) || (ID_COLOR3.length==0) || (PROFORMA.length==0) || (PROFORMA==null) || (PROFORMA=="") || (ESTADOC1==24) ){
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" Cambio Estado no disponible para este registro.", "info");
                    }else{

                        // Levantar el POPUP
                        var popupCambioEstado = $("#POPUP_cambio_estado");
                        popupCambioEstado.data("kendoWindow").open();

                        // Desplegar el BTN de Cambio de Estado
                        $("#btn_genera_cambio_estado").show();

                        // Seteo TextArea en Blanco
                        $("#comentSolicitaCorreccionPI").val("");

                        /*range.forEachCell(function (row, column, value) {
                            console.log(row);
                        });*/


                    }

                    /*}else{
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                    // Fin Verificar Permisos
                    }*/

                }

            // Fin del IF Cambio de Estado
            }



        // Fin del (e)
        });
    // Fin del menú contextual


    // POPUP Detalle Error
    function POPUPDetalleError(){

        // Actualiza Concurrencia
        ActualizaConcurrencia();

        // Verificar Permisos
        if(localStorage.getItem("T0013")){

            var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet = spreadsheet_id_color3.activeSheet();
            var range = sheet.selection();
            var ID_COLOR3 = "";
            var PROFORMA = "";
            range.forEachCell(function (row, column, value) {
                var fila_id = row+1;
                var range_color3 = sheet.range("A"+fila_id);
                ID_COLOR3 = range_color3.values();
                var range_proforma = sheet.range("CG"+fila_id);
                PROFORMA = range_proforma.values();
            });


            if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) || (ID_COLOR3.length==0) || (PROFORMA==null) || (PROFORMA=="") || (PROFORMA.length==0) ){
                popupNotification.show(" Detalle Error no disponible para este registro.", "error");
            }else{

                // Levantamos el popup
                var POPUPDetalleError = $("#POPUP_detalle_error");
                POPUPDetalleError.data("kendoWindow").open();

                // Seteo TextArea en Blanco
                // Le entrego el valor al TextArea
                var editorErrorBlanco = $("#TXTdetalleError").data("kendoEditor");
                editorErrorBlanco.value('');

                // Realizo la Búsqueda
                $.ajax({
                    url: "TelerikPlanCompra/BuscaComentarioPI",
                    data: {
                        PI: String(PROFORMA),
                        ID_COLOR3: kendo.parseInt(ID_COLOR3)
                    },
                    //type: "POST",
                    dataType: "json",
                    success: function (data) {

                        if(data){

                            // Le entrego el valor al TextArea
                            var editorError = $("#TXTdetalleError").data("kendoEditor");
                            editorError.value(data);

                        }else{
                            popupNotification.getNotifications().parent().remove();
                            popupNotification.show(" Este registro no tiene comentarios.", "error");
                        }

                    },
                    error: function (request, status, error) {
                        console.log("Restupesta: "+request.responseText+" Status: "+status+" Error: "+error);
                    }
                });

            }



        }else{
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
        }


    }

    // POPUP Tienda
    function POPUPTienda(){

        // Actualiza Concurrencia
        ActualizaConcurrencia();

        // Verificar Permisos
        if(localStorage.getItem("T0016")){

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

            // Levantamos el popup
            var POPUPTienda = $("#POPUP_tienda");
            POPUPTienda.data("kendoWindow").open();


        }else{
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
        }



    }

    // POPUP Formato
    function POPUPFormato(){

        // Actualiza Concurrencia
        ActualizaConcurrencia();

        // Verificar Permisos
        if(localStorage.getItem("T0017")){

            // Oculto los elementos por si se abre por segunda vez
            $("#popformato_asignacion").hide();
            $("#popformato_btns").hide();
            //$("#btn_crea_nuevo_formato").hide();

            // Dejo en Blanco los CBX
            $("#CBXFormato").data("kendoComboBox").value("");

            // Dejo en Blanco el TCT
            //$("#TXTnuevoFormato").value("");

            // Limpiar los ListBox
            var listBox1Formato = $("#formato_disponible").data("kendoListBox");
            listBox1Formato.remove(listBox1Formato.items());
            var listBox2Formato = $("#formato_seleccionado").data("kendoListBox");
            listBox2Formato.remove(listBox2Formato.items());

            // Levantamos el popup
            var POPUPFormato = $("#POPUP_formato");
            POPUPFormato.data("kendoWindow").open();

        }else{
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
        }


    }


    // ########## TRABAJO CON EL CHECK DE CONCURRENCIA ##########
    // Comenzar a ejecutar el temporizador
    $(function() {
        function VerificaConexionUsuario() {

            // Voy a Consultar si mi Registro se encuentra en la tabla
            // Si el registro no se encuentra: Levanto PopUp y Ejecuto contador a tras
            $.ajax({
                url: "TelerikPlanCompra/BuscaUsuarioDesconectado",
                success: function (result) {

                    // Si llega 1 está desconectado

                    // El usuario está desconectado
                    if(result==1){

                        // Levantar POPUP
                        var popupCierraSession = $("#POPUP_cierra_session");
                        popupCierraSession.data("kendoWindow").open();
                        // Comenzamos la cuenta atrás
                        DespliegaCuentaAtras();

                    }


                },
                error: function (xhr, httpStatusMessage, customErrorMessage) {
                    console.log("Detalle Error: ".xhr.responseText+" / "+httpStatusMessage+" / "+customErrorMessage);
                }
            });

        }
        setInterval(VerificaConexionUsuario, 80000); // 1':20'' Pregunta por Concurrencia
        VerificaConexionUsuario();
    });


    //pop ajuste de compra
    function Pop_ajuste_compra(){
        ActualizaConcurrencia();
        // alert($("#comentSolicitaCorreccionPI").val());
        var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
        var sheet = spreadsheet_id_color3.activeSheet();
        var range = sheet.selection();
        var ID_COLOR3 = "";
        var DEBUTREORDER = "";
        var TALLAS = "";
        range.forEachCell(function (row, column, value) {
            var fila_id = row+1;
            var range_color3 = sheet.range("A"+fila_id);
            ID_COLOR3 = range_color3.values();
            var range_debutreorder = sheet.range("BU"+fila_id);
            DEBUTREORDER = range_debutreorder.values();
            var range_tallas = sheet.range("AE"+fila_id);
            TALLAS = range_tallas.values();
        });

        if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) || (DEBUTREORDER=="REORDER")|| (TALLAS=="") ){
            popupNotification.show(" Las opciones REORDER no tienen ajuste de compra.", "error");
        }else{

            // Levantar el POPUP
            var popupajustes = $("#POPUP_ajuste_compra");
            popupajustes.data("kendoWindow").open();

            // Antes de volver a cargar la data, reseteo lo existente
            $("#grid_ajuste_compra").data("kendoGrid").dataSource.data([]);

            // Extrarcion Data
            var dataSource_ajustes = new kendo.data.DataSource({
                transport: {
                    read:  {
                        url: "TelerikPlanCompra/Listar_Pop_Ajuste_Compra",
                        dataType: "json",
                        //type: 'POST',
                        data:{ID_COLOR3: kendo.parseInt(ID_COLOR3),_Tallas:String(TALLAS)}
                    }
                }
            });
            // Asignar la cabecera
            var dtt = (String(TALLAS)).split(",");
            var columnsConfig = [];
            columnsConfig.push({ field: "_", title: "" ,width:"100px",attributes: {style: "background-color: rgb(255,255,224); font-size: 12px; color: red"}});
            dtt.forEach(function(entry) {
                var tal=(entry.trim()).replace("/","_");
                columnsConfig.push({ field: ("t_" + tal), title: (tal) ,width:"40px"});
            });
            columnsConfig.push({ field: "Total", title: "Total" ,width:"50px",attributes: {style: "background-color: rgb(255,255,224); font-size: 12px; color: red"}});
            $("#grid_ajuste_compra").data("kendoGrid").setOptions({
                columns: columnsConfig
            });
            dataSource_ajustes.read();

            // Asignar el DataSet al Grid
            var spreadsheet_ajustes = $("#grid_ajuste_compra").data("kendoGrid");
            spreadsheet_ajustes.setDataSource(dataSource_ajustes);
            // Fin del else
        }
    }

    //pop ajuste de cajas
    function Pop_ajuste_cajas(){
        ActualizaConcurrencia();
    var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
    var sheet = spreadsheet_id_color3.activeSheet();
    var range = sheet.selection();
    var ID_COLOR3 = "";
    var DEBUTREORDER = "";
    var TALLAS = "";
    var TIPO_EMPAQUE = "";
    range.forEachCell(function (row, column, value) {
        var fila_id = row+1;
        var range_color3 = sheet.range("A"+fila_id);
        ID_COLOR3 = range_color3.values();
        var range_debutreorder = sheet.range("BU"+fila_id);
        DEBUTREORDER = range_debutreorder.values();
        var range_tallas = sheet.range("AE"+fila_id);
        TALLAS = range_tallas.values();
        var range_empaque = sheet.range("AF"+fila_id);
        TIPO_EMPAQUE = range_empaque.values();
    });
    if(TALLAS=="" || TIPO_EMPAQUE == "" || DEBUTREORDER == ""){
        popupNotification.show("No se encuentran datos.", "error");
    }else{
        var popupAjusteCajas = $("#POPUP_ajuste_cajas");
        popupAjusteCajas.data("kendoWindow").open();

        // Antes de volver a cargar la data, reseteo lo existente
        $("#grid_ajuste_cajas").data("kendoGrid").dataSource.data([]);
        $("#grid_ajuste_cajas2").data("kendoGrid").dataSource.data([]);
        // Extrarcion Data
        var dataSource_ajustes_cajas = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "TelerikPlanCompra/Listar_Pop_Ajuste_Cajas",
                    dataType: "json",
                    //type: 'POST',
                    data: {
                        ID_COLOR3: kendo.parseInt(ID_COLOR3)
                        , _Tallas: String(TALLAS)
                        , _TipoEmpaque: String(TIPO_EMPAQUE)
                        , _DebutReorder: String(DEBUTREORDER)
                    }
                }
            }
        });

        // Asignar la cabecera
        var dtt2 = (String(TALLAS)).split(",");
        var columnsConfig2 = [];
        columnsConfig2.push({ field: String(TIPO_EMPAQUE),title: String(TIPO_EMPAQUE),width:"100px"
            ,attributes: {style: "background-color: rgb(255,255,224); font-size: 12px; color: red"}});
        //style: "text-align: center;
        dtt2.forEach(function(entry) {
              var tal=(entry.trim()).replace("/","_");
            columnsConfig2.push({ field: ("t_" + tal), title: (tal),width:"40px",attributes: {style:"font-size: 12px"}});
        });
        columnsConfig2.push({ field: "Total", title: "Total",width:"50px"
            ,attributes: {style: "background-color: rgb(255,255,224);font-size: 12px; color: red"}});
        $("#grid_ajuste_cajas").data("kendoGrid").setOptions({
            columns: columnsConfig2
        });
        dataSource_ajustes_cajas.read();


          // Asignar el DataSet al Grid*/
        var spreadsheet_ajustes_compra = $("#grid_ajuste_cajas").data("kendoGrid");
        spreadsheet_ajustes_compra.setDataSource(dataSource_ajustes_cajas);

        if (TIPO_EMPAQUE == "CURVADO"){
            // Extrarcion Data
            var dataSource_ajustes_cajas2 = new kendo.data.DataSource({
                transport: {
                    read: {
                        url: "TelerikPlanCompra/Listar_Pop_Ajuste_Cajas_curvado_solido",
                        dataType: "json",
                        //type: 'POST',
                        data: {
                            ID_COLOR3: kendo.parseInt(ID_COLOR3)
                            , _Tallas: String(TALLAS)
                            , _TipoEmpaque: String(TIPO_EMPAQUE)
                            , _DebutReorder: String(DEBUTREORDER)
                        }
                    }
                }
            });

            // Asignar la cabecera
            var dtt3 = (String(TALLAS)).split(",");
            var columnsConfig3 = [];
            columnsConfig3.push({ field: String(TIPO_EMPAQUE), title: "SOLIDO",width:"100px",attributes: {style: "background-color: rgb(255,255,224); font-size: 12px;; color: red"}
            });
            dtt3.forEach(function(entry) {
                var tal=(entry.trim()).replace("/","_");
                columnsConfig3.push({ field: ("t_" + tal), title: (tal) ,width:"40px",attributes: {style: "font-size: 12px"}});
            });
            columnsConfig3.push({ field: "Total", title: "Total" ,width:"50px",attributes: {style: "background-color: rgb(255,255,224); font-size: 12px; color: red"}});
            $("#grid_ajuste_cajas2").data("kendoGrid").setOptions({
                columns: columnsConfig3
            });
            dataSource_ajustes_cajas2.read();

            // Asignar el DataSet al Grid
            var spreadsheet_ajustes_compra2 = $("#grid_ajuste_cajas2").data("kendoGrid");
            spreadsheet_ajustes_compra2.setDataSource(dataSource_ajustes_cajas2);
        }

    }
}

    //pop historical
    function Pop_Historial(){
        ActualizaConcurrencia();
        // alert($("#comentSolicitaCorreccionPI").val());
        var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
        var sheet = spreadsheet_id_color3.activeSheet();
        var range = sheet.selection();
        var ID_COLOR3 = "";
        range.forEachCell(function (row, column, value) {
            var fila_id = row+1;
            var range_color3 = sheet.range("A"+fila_id);
            ID_COLOR3 = range_color3.values();
        });

        if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) || (ID_COLOR3.length==0) ){
            popupNotification.show(" Historial no disponible para este registro.", "error");
        }else{

            // Levantar el POPUP
            var popupHistorial = $("#POPUP_historial");
            popupHistorial.data("kendoWindow").open();

            // Antes de volver a cargar la data, reseteo lo existente
            $("#grid_popup_historial").data("kendoGrid").dataSource.data([]);

            // Seteo DataSet
            var dataSource_historial = new kendo.data.DataSource({
                transport: {
                    read:  {
                        url: "TelerikPlanCompra/ListarHistorial",
                        dataType: "json",
                        //type: 'POST',
                        data:{ID_COLOR3: kendo.parseInt(ID_COLOR3)}
                    }
                }
            });
            // Asigno el DataSet al Grid
            var spreadsheet_hist = $("#grid_popup_historial").data("kendoGrid");
            spreadsheet_hist.setDataSource(dataSource_historial, [
                { field: "FECHA", title: "FECHA" },
                { field: "HORA", title: "HORA" },
                { field: "USUARIO", title: "USUARIO" },
                { field: "ESTADO", title: "ESTADO" }
            ]);
        }

    }

    //pop Presupuesto Total
    function Pop_Presupuestos(){

        // Actualiza Concurrencia
        ActualizaConcurrencia();

        var popupPreTotal = $("#POPUP_presupuestos_total");
        popupPreTotal.data("kendoWindow").open();

        var dataSource_presu = new kendo.data.DataSource({
            transport: {
                read: {
                    url: "TelerikPlanCompra/Listar_Pop_Presupuestos",
                    dataType: "json"
                }
            }
        });

        // Asignar el DataSet al Grid
        var spreadsheet_presupuesto = $("#grid_presupuestos_total").data("kendoGrid");
        spreadsheet_presupuesto.setDataSource(dataSource_presu);

    }

    //pop importar assorment
    function Pop_Importar(){
        // Actualiza Concurrencia
        ActualizaConcurrencia();
        // Verificar Permisos
        if(localStorage.getItem("T0025")) {

            if( (localStorage.getItem("M-TIENDA")==0) || (localStorage.getItem("P-COSTO")==0) || (localStorage.getItem("P-RETAIL")==0) || (localStorage.getItem("P-EMBARQUE")!=9)){
                var popupNotificationValida = $("#popupNotification").kendoNotification().data("kendoNotification");
                popupNotificationValida.getNotifications().parent().remove();
                popupNotificationValida.show(" Necesita Configurar Tiendas y/o Presupuestos.", "error");
            }else{
                var popupDe = $("#POPUP_Importar_");
                popupDe.data("kendoWindow").open();
            }

        }else{
            popupNotification.getNotifications().parent().remove();
            popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
        }
    }

    //pop Presupuestos edit
    function Pop_editPresupuestos(){
        ActualizaConcurrencia();
        //COSTO
        var costo = $("#Costo").val();
        var retail = $("#Retail").val();
        var VentA =  $("#PorVentA").val();
        if (costo == 0){
            $.ajax({
                url: "TelerikPlanCompra/ListarPopEditPresupuestos",
                dataType: "json",
                type: 'GET',
                data: {tipo:1},
                success: function (data) {
                    $("#Costo").kendoNumericTextBox({
                        culture: "es-CL",
                        format: "c0",
                        value: data
                    });
                }
            });
        }
        if(retail == 0){
            $.ajax({
                url: "TelerikPlanCompra/ListarPopEditPresupuestos",
                dataType: "json",
                type: 'GET',
                data: {tipo:2},
                success: function (data) {
                    $("#Retail").kendoNumericTextBox({
                        culture: "es-CL",
                        format: "c0",
                        value: data
                    });
                }
            });
         }

        if (VentA == 0.00){
            $.ajax({
                url: "TelerikPlanCompra/ListarPopEditPresupuestos",
                dataType: "json",
                type: 'GET',
                data: {tipo:3},
                success: function (data) {
                    $.each(data, function (i, o) {
                        $("#PorVent"+o["VENT_DESCRI"]).kendoNumericTextBox({
                            format: "p0",
                            value: o["PORCENTAJE"]
                        });
                    });
                }
            });
        }
        var editPresupuestos = $("#POPUP_Presupuestos");
        editPresupuestos.data("kendoWindow").open();
    }

    //pop exportar
    function Pop_Exportar(){
        ActualizaConcurrencia();
        $("#CBXtipoExport").kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                { text: "Assortment", value: "1" },
                { text: "C1", value: "2" },
                { text: "Opciones por Estados", value: "3" },
                { text: "Formato Assortment", value: "4" }
            ],
            filter: "contains",
            suggest: false
        });

        var pop_export = $("#POPUP_Exportar");
        pop_export.data("kendoWindow").open();

    }

// Fin del document ready
});
