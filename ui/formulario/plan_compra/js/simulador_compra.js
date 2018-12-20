$(function () {

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
                var el = $("<div data-visible='true' data-role='window' data-modal='true' data-resizable='true' data-title='Seleccione País '>" +
                    "  <div data-role='dropdownlist' data-bind='value: value, source: paises' data-text-field='NOMBRE_PAIS' data-value-field='NOMBRE_PAIS'></div>" +
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

                var elFormato = $("<div data-visible='true' data-role='window' data-modal='true' data-resizable='true' data-title='Seleccione Formato '>" +
                    "  <div data-role='dropdownlist' data-bind='value: value, source: formatos' data-text-field='NOMBRE_FORMATO' data-value-field='NOMBRE_FORMATO'></div>" +
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

                var elProveedor = $("<div data-visible='true' data-role='window' data-modal='true' data-resizable='true' data-title='Seleccione Proveedor '>" +
                    "  <div data-role='dropdownlist' data-bind='value: value, source: proveedores' data-text-field='NOMBRE_PROVEEDOR' data-value-field='NOMBRE_PROVEEDOR'></div>" +
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

    // Función que envia la Data al PHP
    function onSubmit(e) {

        // alert(e.data.updated.length);

        var arregloGuardado = [];
        var i = 0;

        // Recorro por la cantidad de registros para asociar al arreglo
        for (i; i < e.data.updated.length; i++) {

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
                "COSTO_TARGET": kendo.parseInt(e.data.updated[i]["COSTO_TARGET"]), // Decimal
                "COSTO_FOB": kendo.parseInt(e.data.updated[i]["COSTO_FOB"]),
                "COSTO_INSP": kendo.parseInt(e.data.updated[i]["COSTO_INSP"]),
                "COSTO_RFID": kendo.parseInt(e.data.updated[i]["COSTO_RFID"]), // Decimal
                "DEBUT_REODER": String(e.data.updated[i]["DEBUT_REODER"]),
                "TIPO_EMPAQUE_BASE": String(e.data.updated[i]["TIPO_EMPAQUE_BASE"]),
                "UNI_INICIALES_BASE": kendo.parseInt(e.data.updated[i]["UNI_INICIALES_BASE"]),
                "PRECIO_BLANCO_BASE": kendo.parseInt(e.data.updated[i]["PRECIO_BLANCO_BASE"]),
                "COSTO_TARGET_BASE": kendo.parseInt(e.data.updated[i]["COSTO_TARGET_BASE"]), // Decimal
                "COSTO_FOB_BASE": kendo.parseInt(e.data.updated[i]["COSTO_FOB_BASE"]),
                "COSTO_INSP_BASE": kendo.parseInt(e.data.updated[i]["COSTO_INSP_BASE"]),
                "COSTO_RFID_BASE": kendo.parseInt(e.data.updated[i]["COSTO_RFID_BASE"]), // Decimal
                "COD_MARCA": String(e.data.updated[i]["COD_MARCA"]),
                "N_CURVASXCAJAS": kendo.parseInt(e.data.updated[i]["N_CURVASXCAJAS"]),
                "COD_JER2": String(e.data.updated[i]["COD_JER2"]),
                "COD_SUBLIN": String(e.data.updated[i]["COD_SUBLIN"]),
                "FORMATO_BASE": String(e.data.updated[i]["FORMATO_BASE"])
            });

        }


        //console.log(arregloGuardado);

        // console.log(e.data.updated[0]["ALIAS_PROV"]);

        $.ajax({
            url: crudServiceBaseUrl + "ProcesaDataPlanCompra",
            //data: {models: kendo.stringify(e.data)},
            data: {models: kendo.stringify(arregloGuardado)},
            contentType: "application/json",
            //type: "POST",
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



            },
            error: function (xhr, httpStatusMessage, customErrorMessage) {
                console.log(xhr.responseText+" / "+httpStatusMessage+" / "+customErrorMessage);
            }
        });

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

                });
            }

            setTimeout(function (e) {
                if (shouldPopulateHeader) {
                    shouldPopulateHeader = false;
                    var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                    var sheet = spreadsheet.activeSheet();

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
                        sheet.range("CM1").value("Fecha Acordada");
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
                        var bloqueo_columnas_oc = spreadsheet_conteo_total.activeSheet().range("CH1:DB"+total_registros_listados);
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
                    ID_COLOR3: {type: "number"},
                    GRUPO_COMPRA: {type: "string"},
                    COD_TEMP: {type: "number"},
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
                    COLECCION: {type: "string"},
                    EVENTO: {type: "string"},
                    EVENTO_INSTORE: {type: "string"},
                    COD_ESTILO_VIDA: {type: "string"},
                    CALIDAD: {type: "string"},
                    COD_OCASION_USO: {type: "string"},
                    COD_PIRAMIX: {type: "string"},
                    NOM_VENTANA: {type: "string"},
                    COD_RANKVTA: {type: "string"},
                    LIFE_CYCLE: {type: "string"},
                    NUM_EMB: {type: "string"},
                    COD_COLOR: {type: "string"},
                    TIPO_PRODUCTO: {type: "string"},
                    TIPO_EXHIBICION: {type: "string"},
                    DESTALLA: {type: "string"},
                    TIPO_EMPAQUE: {type: "string"},
                    PORTALLA_1_INI: {type: "string"},
                    PORTALLA_1: {type: "string"},
                    CURVATALLA: {type: "string"},
                    CURVAMIN: {type: "number"},
                    UNID_OPCION_INICIO: {type: "number"},
                    UNID_OPCION_AJUSTADA: {type: "number"},
                    CAN: {type: "number"},
                    MTR_PACK: {type: "number"},
                    CANT_INNER: {type: "number"},
                    SEG_ASIG: {type: "string"},
                    FORMATO: {type: "string"},
                    TDAS: {type: "number"},
                    A: {type: "number"},
                    B: {type: "number"},
                    C: {type: "number"},
                    I: {type: "number"},
                    UND_ASIG_INI: {type: "number"},
                    ROT: {type: "number"},
                    NOM_PRECEDENCIA: {type: "string"},
                    NOM_VIA: {type: "string"},
                    NOM_PAIS: {type: "string"},
                    VIAJE: {type: "string"},
                    MKUP: {type: "number"},
                    PRECIO_BLANCO: {type: "number"},
                    GM: {type: "number"},
                    OFERTA: {type: "string"},
                    DOSX: {type: "number"},
                    OPEX: {type: "number"},
                    COD_TIP_MON: {type: "string"},
                    COSTO_TARGET: {type: "number"},
                    COSTO_FOB: {type: "number"},
                    COSTO_INSP: {type: "number"},
                    COSTO_RFID: {type: "percent"},
                    ROYALTY_POR: {type: "number"},
                    COSTO_UNIT: {type: "number"},
                    COSTO_UNITS: {type: "number"},
                    CST_TOTLTARGET: {type: "number"},
                    COSTO_TOT: {type: "number"},
                    COSTO_TOTS: {type: "number"},
                    RETAIL: {type: "number"},
                    DEBUT_REODER: {type: "string"},
                    SEM_INI: {type: "string"},
                    SEM_FIN: {type: "string"},
                    CICLO: {type: "number"},
                    AGOT_OBJ: {type: "number"},
                    SEMLIQ: {type: "number"},
                    ALIAS_PROV: {type: "string"},
                    COD_PROVEEDOR: {type: "string"},
                    COD_TRADER: {type: "string"},
                    AFTER_MEETING_REMARKS: {type: "string"},
                    CODSKUPROVEEDOR: {type: "string"},
                    SKU: {type: "string"},
                    PROFORMA: {type: "string"},
                    ARCHIVO: {type: "string"},
                    ESTILO_PMM: {type: "string"},
                    ESTADO_MATCH: {type: "string"},
                    PO_NUMBER: {type: "number"},
                    ESTADO_OC: {type: "string"},
                    FECHA_ACORDADA: {type: "string"},
                    FECHA_EMBARQUE: {type: "string"},
                    FECHA_ETA: {type: "string"},
                    FECHA_RECEPCION: {type: "string"},
                    DIAS_ATRASO: {type: "number"},
                    CODESTADO: {type: "string"},
                    ESTADO_C1: {type: "string"},
                    VENTANA_LLEGADA: {type: "string"},
                    PROFORMA_BASE: {type: "string"},
                    TIPO_EMPAQUE_BASE: {type: "string"},
                    UNI_INICIALES_BASE: {type: "number"},
                    PRECIO_BLANCO_BASE: {type: "number"},
                    COSTO_TARGET_BASE: {type: "number"},
                    COSTO_FOB_BASE: {type: "number"},
                    COSTO_INSP_BASE: {type: "number"},
                    COSTO_RFID_BASE: {type: "percent"},
                    COD_MARCA: {type: "number"},
                    N_CURVASXCAJAS: {type: "number"},
                    COD_JER2: {type: "string"},
                    COD_SUBLIN: {type: "string"},
                    ARCHIVO_BASE: {type: "string"},
                    FORMATO_BASE: {type: "string"}

                }
            }
        }

    });

    // Asigna la estructura visual de la Grilla tipo Excel
    $("#spreadsheet").kendoSpreadsheet({
        columns: 106, //106 Siempre visible
        rows: 400,
        //toolbar: true,
        toolbar: {
            home: [ //"open" ,
                "exportAs",
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
                    text: "Importar",
                    //showText: "both",
                    imageUrl: "../web/telerik/content/web/24x24/Upload.png",
                    click: Pop_Importar
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
            columns: [
                {width: 40},    // id
                {width: 100},   // G. Compra
                {width: 100},   // Temp
                {width: 150},   // Línea
                {width: 150},   // Sub Línea
                {width: 130},   // Marca
                {width: 230},   // Estilo
                {width: 200},   // Estilo Corto
                {width: 130},   // Cod. Corp
                {width: 250},   // Descripción
                {width: 250},   // Descripción Internet
                {width: 130},   // Nombre Comprador
                {width: 130},   // Nombre Diseñador
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
                {width: 80},    // Ventana
                {width: 200},   // Rank Vta
                {width: 150},   // Life Cycle
                {width: 130},   // Num. Emb
                {width: 100},   // Color
                {width: 120},   // Tipo Producto
                {width: 150},   // Tipo Exhibición
                {width: 140},   // Tallas
                {width: 130},   // Tipo Empaque
                {width: 300},   // % Compra Inicial
                {width: 300},   // % Compra Ajustada
                {width: 150},   // Curvas de Reparto
                {width: 100},   // Curvas Min
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
                {width: 100},   // Primera Carga
                {width: 100},   // % Tiendas
                {width: 100},   // Proced
                {width: 100},   // Vía
                {width: 200},   // País
                {width: 100},   // Viaje
                {width: 90},    // Mkup
                {width: 90},    // Precio Blanco
                {width: 90},    // GM
                {width: 90},    // Oferta
                {width: 90},    // Moneda
                {width: 90},    // 2x
                {width: 90},    // Opex
                {width: 90},    // Target
                {width: 90},    // FOB
                {width: 90},    // Insp
                {width: 90},    // RFID
                {width: 90},    // Royalty
                {width: 150},   // Costo Unitario Final USD
                {width: 160},   // Costo Unitario Final Pesos
                {width: 110},   // Total Target USD
                {width: 100},   // Total FOB USD
                {width: 100},   // Costo Total
                {width: 100},   // Total Retail
                {width: 90},    // Debut/Reorder
                {width: 90},    // Sem Ini
                {width: 90},    // Sem Fin
                {width: 130},   // Sem Ciclo Vida
                {width: 90},    // Agot Obj
                {width: 120},   // Semanas Liquidación
                {width: 250},   // Proveedor
                {width: 100},   // Razón Social
                {width: 100},   // Trader
                {width: 150},   // After Meeting Remark
                {width: 100},   // Cod. SKU Proveedor
                {width: 100},   // Cod. Padre
                {width: 150},   // Proforma
                {width: 90},    // Archivo
                {width: 230},   // Estilo PMM
                {width: 90},    // Estado Match
                {width: 90},    // N OC
                {width: 90},    // Estado OC
                {width: 100},   // Fecha Acordada
                {width: 100},   // Fecha Embarque
                {width: 100},   // Fecha ETA
                {width: 100},   // Fecha Recep CD
                {width: 100},   // Dias Atraso
                {width: 210}    // Estado Opcion

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

            });


            // NO ejecutar acciones cuando el ID_COLOR3 = 0, vacio o null

            if(command == "Descarga Archivo PI") {

                // Actualiza Concurrencia
                ActualizaConcurrencia();

                // Verificar Permisos
                if(localStorage.getItem("T0002")){

                    // Descarga PI
                    if (ESTADOC1 != 0) {

                        // PROFORMA = Archivo Original

                        PROFORMA_ARCHIVO = String(PROFORMA).replace(/[^a-z0-9\-\_]/gi, '-');

                        var valFileDownloadPath = '../archivos/pi/PI_' + TemporadaArchivoPI + '_' + DeptoArchivoPI + '_' + PROFORMA_ARCHIVO + '.xlsx';
                        window.open(valFileDownloadPath, '_blank');

                    }else{
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" En estado Ingresado,No puede descargar el archivo.", "error");
                    }

                }else{
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" No tiene permisos para realizar esta acción.", "error");
                // Fin Verificar Permisos
                }

            // Fin descarga archivo
            }

            if(command == "Cargar Archivo PI") {

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
                        popupNotification.show(" Seleccione un registro con proforma y archivo sin cargar.", "error");
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

            if(command == "Match") {

                // Actualiza Concurrencia
                ActualizaConcurrencia();

                // Verificar Permisos
                if(localStorage.getItem("T0004")){

                    // Que llegue la proforma y el estado sea Pendiente de Aprobación sin Match
                    if( (PROFORMA.length==0) || (PROFORMA==null) || (PROFORMA=="") || (ESTADOC1!=19) ){

                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" Seleccione un registro con Proforma,Pendiente de Aprobacion sin Match y OC no Linkeada.", "error");

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
                                                if( (compara_linea != el2.NRO_LINEA) || (compara_sublinea != el2.NRO_SUB_LINEA) || (compara_color != el2.COD_COLOR) || (compara_estilo != el2.NOMBRE_ESTILO)  ){

                                                    $("[data-uid='"+el.uid+"']").css("background", "#FF2D00");
                                                    flag_errores_match++;

                                                }else{

                                                    $("[data-uid='"+el.uid+"']").css("background", "");
                                                    break loop2;

                                                }




                                        })

                                })

                                // Si hay Errores, oculto el BTN de Match
                                if(flag_errores_match>0){
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

                                                if(result=="OK"){

                                                    // Avisamos que el Match se encuentra OK
                                                    //popupNotification.getNotifications().parent().remove();
                                                    popupNotification.show(" Variaciones OK, Hemos Finalizado.", "success");

                                                    // Se Registró MATCH y Variaciones

                                                    // Recargo el DATASOURCE
                                                    var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                                                    var sheet = spreadsheet.activeSheet();
                                                    sheet.dataSource.read();

                                                    // Cierro el POPUP de MATCH
                                                    popupMatch.data("kendoWindow").close();

                                                    // Recargar
                                                    //location.reload();


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

            if(command == "Cambio Estado") {

                // Actualiza Concurrencia
                ActualizaConcurrencia();

                // Verificar Permisos
                //if(localStorage.getItem("T0002")){

                    if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) || (ID_COLOR3.length==0) || (PROFORMA.length==0) || (PROFORMA==null) || (PROFORMA=="") || (ESTADOC1==24) ){
                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" Cambio Estado no disponible para este registro.", "error");
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

            // Levantamos el popup
            var POPUPDetalleError = $("#POPUP_detalle_error");
            POPUPDetalleError.data("kendoWindow").open();

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
            $("#btn_crea_nuevo_formato").hide();

            // Dejo en Blanco los CBX
            $("#CBXFormato").data("kendoComboBox").value("");

            // Dejo en Blanco el TCT
            $("#TXTnuevoFormato").data("kendoComboBox").value("");

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

        // Actualiza Concurrencia
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
                        data:{ID_COLOR3: kendo.parseInt(ID_COLOR3),_Tallas:String(TALLAS)},
                    },
                }
            });

            // Asignar la cabecera
            var dtt = (String(TALLAS)).split(",");
            var columnsConfig = [];
            columnsConfig.push({ field: "_", title: "" ,width:"100px",attributes: {style: "background-color: rgb(255,255,224); font-size: 12px; color: red"}});
            dtt.forEach(function(entry) {
                var tal=entry.trim();
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

        // Actualiza Concurrencia
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
                    },
                },
            }
        });

        // Asignar la cabecera
        var dtt2 = (String(TALLAS)).split(",");
        var columnsConfig2 = [];
        columnsConfig2.push({ field: String(TIPO_EMPAQUE),title: String(TIPO_EMPAQUE),width:"100px"
            ,attributes: {style: "background-color: rgb(255,255,224); font-size: 12px; color: red"}});
        //style: "text-align: center;
        dtt2.forEach(function(entry) {
            var tal=entry.trim();
            columnsConfig2.push({ field: ("t_" + tal), title: (tal),width:"40px",attributes: {style:"font-size: 12px"}});
        });
        columnsConfig2.push({ field: "Total", title: "Total",width:"50px"
            ,attributes: {style: "background-color: rgb(255,255,224);font-size: 12px; color: red"}});
        $("#grid_ajuste_cajas").data("kendoGrid").setOptions({
            columns: columnsConfig2
        });
        dataSource_ajustes_cajas.read();

        // Asignar el DataSet al Grid
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
                        },

                    },
                }
            });

            // Asignar la cabecera
            var dtt3 = (String(TALLAS)).split(",");
            var columnsConfig3 = [];
            columnsConfig3.push({ field: String(TIPO_EMPAQUE), title: "SOLIDO",width:"100px",attributes: {style: "background-color: rgb(255,255,224); font-size: 12px;; color: red"}
            });
            dtt3.forEach(function(entry) {
                var tal=entry.trim();
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

        // Actualiza Concurrencia
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
                    dataType: "json",
                    data: {}
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

        var popupDe = $("#POPUP_Importar_");
        popupDe.data("kendoWindow").open();
    }

    //pop Presupuestos edit
    function Pop_editPresupuestos(){

        // Actualiza Concurrencia
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


// Fin del document ready
});
