$(function () {

    // ####################### FUNCIONES ASOCIADAS AL DESPLIEGUE DE DATA #######################

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikPlanCompra/";

    // Función que envia la Data al PHP
    function onSubmit(e) {

        /*var url_tabla = 'ajax_simulador_cbx/actualiza_tabla2';
        $.getJSON(url_tabla, {models: kendo.stringify(e.data)});*/

        $.ajax({
            //type: "POST",
            url: crudServiceBaseUrl + "ProcesaDataPlanCompra",
            data: {models: kendo.stringify(e.data)},
            contentType: "application/json",
            //dataType: "json",
            success: function (result) {
                //kendo.log(result);
                e.success(result.Updated, "update");
                e.success(result.Created, "create");
                e.success(result.Destroyed, "destroy");
            },
            error: function (xhr, httpStatusMessage, customErrorMessage) {
                alert(xhr.responseText);
                alert(httpStatusMessage);
                alert(customErrorMessage);
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
                        sheet.range("S1").value("Estilo de Vida");
                        sheet.range("T1").value("Calidad");
                        sheet.range("U1").value("Ocación de Uso");
                        sheet.range("V1").value("Pirámide Mix");
                        sheet.range("W1").value("Ventana");
                        sheet.range("X1").value("Rank Vta");
                        sheet.range("Y1").value("Life Cycle");
                        sheet.range("Z1").value("Num. Emb");
                        sheet.range("AA1").value("Color");
                        sheet.range("AB1").value("Tipo Producto");
                        sheet.range("AC1").value("Tipo Exhibición");
                        sheet.range("AD1").value("Tallas");
                        sheet.range("AE1").value("Tipo Empaque");
                        sheet.range("AF1").value("% Compra Inicial");
                        sheet.range("AG1").value("% Compra Ajustada");
                        sheet.range("AH1").value("Curvas de Reparto");
                        sheet.range("AI1").value("Curvas Min");
                        sheet.range("AJ1").value("Unid Ini");
                        sheet.range("AK1").value("Unid Ajust");
                        sheet.range("AL1").value("Unid Final");
                        sheet.range("AM1").value("Mtr Pack");
                        sheet.range("AN1").value("N° Cajas");
                        sheet.range("AO1").value("Cluster");
                        sheet.range("AP1").value("Formato");
                        sheet.range("AQ1").value("Tdas");
                        sheet.range("AR1").value("A");
                        sheet.range("AS1").value("B");
                        sheet.range("AT1").value("C");
                        sheet.range("AU1").value("I");
                        sheet.range("AV1").value("Primera Carga");
                        sheet.range("AW1").value("% Tiendas");
                        sheet.range("AX1").value("Proced");
                        sheet.range("AY1").value("Vía");
                        sheet.range("AZ1").value("País");
                        sheet.range("BA1").value("Viaje");
                        sheet.range("BB1").value("Mkup");
                        sheet.range("BC1").value("Precio Blanco");
                        sheet.range("BD1").value("GM");
                        sheet.range("BE1").value("Oferta");
                        sheet.range("BF1").value("Moneda");
                        sheet.range("BG1").value("Target");
                        sheet.range("BH1").value("FOB");
                        sheet.range("BI1").value("Insp");
                        sheet.range("BJ1").value("RFID");
                        sheet.range("BK1").value("Royalty(%)");
                        sheet.range("BL1").value("Costo Unitario Final US$");
                        sheet.range("BM1").value("Costo Unitario Final Pesos");
                        sheet.range("BN1").value("Total Target US$");
                        sheet.range("BO1").value("Total Fob US$");
                        sheet.range("BP1").value("Costo Total");
                        sheet.range("BQ1").value("Total Retail");
                        sheet.range("BR1").value("Debut/Reorder");
                        sheet.range("BS1").value("Sem Ini");
                        sheet.range("BT1").value("Sem Fin");
                        sheet.range("BU1").value("Semanas Ciclo de Vida");
                        sheet.range("BV1").value("Agot Obj");
                        sheet.range("BW1").value("Semanas Liquidación");
                        sheet.range("BX1").value("Proveedor");
                        sheet.range("BY1").value("Razón Social");
                        sheet.range("BZ1").value("Trader");
                        sheet.range("CA1").value("After Meeting Remark");
                        sheet.range("CB1").value("Cod. SKU Proveedor");
                        sheet.range("CC1").value("Cod. Padre");
                        sheet.range("CD1").value("Proforma");
                        sheet.range("CE1").value("Archivo");
                        sheet.range("CF1").value("Estilo PMM");
                        sheet.range("CG1").value("Estado Match");
                        sheet.range("CH1").value("N° OC");
                        sheet.range("CI1").value("Estado OC");
                        sheet.range("CJ1").value("Fecha Acordada");
                        sheet.range("CK1").value("Fecha Embarque");
                        sheet.range("CL1").value("Fecha ETA");
                        sheet.range("CM1").value("Fecha Recepción CD");
                        sheet.range("CN1").value("Días Atraso CD");
                        sheet.range("CO1").value("Estado Opción");


                        // Contar registros que me trae la grilla
                        var spreadsheet_conteo_total = $("#spreadsheet").data("kendoSpreadsheet");
                        var sheet_conteo_total = spreadsheet_conteo_total.sheetByIndex(0);
                        var data_conteo_total = sheet_conteo_total.toJSON();
                        var total_registros_listados = data_conteo_total.rows.length;

                        // Ocultar Columnas
                        var oculta_columna_spread = spreadsheet_conteo_total.activeSheet();
                        oculta_columna_spread.hideColumn(93);
                        oculta_columna_spread.hideColumn(94);
                        oculta_columna_spread.hideColumn(95);
                        oculta_columna_spread.hideColumn(96);
                        oculta_columna_spread.hideColumn(97);
                        oculta_columna_spread.hideColumn(98);
                        oculta_columna_spread.hideColumn(99);
                        oculta_columna_spread.hideColumn(100);
                        oculta_columna_spread.hideColumn(101);
                        oculta_columna_spread.hideColumn(102);

                        // Bloquear columnas
                        var bloqueo_columna_id = spreadsheet_conteo_total.activeSheet().range("A1:A"+total_registros_listados);
                        var bloqueo_columna_comprajustada = spreadsheet_conteo_total.activeSheet().range("AG1:AG"+total_registros_listados);
                        var bloqueo_columna_uniajustada = spreadsheet_conteo_total.activeSheet().range("AK1:AK"+total_registros_listados);
                        var bloqueo_columna_unifinal = spreadsheet_conteo_total.activeSheet().range("AL1:AL"+total_registros_listados);
                        var bloqueo_columna_tdas = spreadsheet_conteo_total.activeSheet().range("AQ1:AQ"+total_registros_listados);
                        var bloqueo_columna_portiendas = spreadsheet_conteo_total.activeSheet().range("AW1:AW"+total_registros_listados);
                        var bloqueo_columna_mkup = spreadsheet_conteo_total.activeSheet().range("BB1:BB"+total_registros_listados);
                        var bloqueo_columna_gm = spreadsheet_conteo_total.activeSheet().range("BD1:BD"+total_registros_listados);
                        var bloqueo_columnas_costos = spreadsheet_conteo_total.activeSheet().range("BL1:BQ"+total_registros_listados);
                        var bloqueo_columnas_semanas = spreadsheet_conteo_total.activeSheet().range("BS1:BU"+total_registros_listados);
                        var bloqueo_columna_razonsocial = spreadsheet_conteo_total.activeSheet().range("BY1:BY"+total_registros_listados);
                        var bloqueo_columna_codpadre = spreadsheet_conteo_total.activeSheet().range("CC1:CC"+total_registros_listados);
                        var bloqueo_columnas_oc = spreadsheet_conteo_total.activeSheet().range("CE1:CY"+total_registros_listados);
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


                        var range_via = spreadsheet.activeSheet().range("AY2:AY"+total_registros_listados);
                        range_via.validation({
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"AEREA,MARITIMO,TERRESTRE"',
                            allowNulls: false,
                            type: "reject",
                            messageTemplate: "Las opciones permitidas son: AEREA, MARITIMO o TERRESTRE."
                        });

                        var range_tipo_embarque = spreadsheet.activeSheet().range("AE2:AE"+total_registros_listados);
                        range_tipo_embarque.validation({
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"CURVADO,SOLIDO"',
                            allowNulls: false,
                            type: "reject",
                            messageTemplate: "Las opciones permitidas son: CURVADO o SOLIDO."
                        });

                        var range_ventana = spreadsheet.activeSheet().range("W2:W"+total_registros_listados);
                        range_ventana.validation({
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"A,B,C,D,E,F,G,H,I"',
                            allowNulls: false,
                            type: "reject",
                            messageTemplate: "La ventana ingresada, no se encuentra dentro de las permitidas. (Recuerde ingresarla en Mayúsculas.)"
                        });

                        /*var range_pais = spreadsheet.activeSheet().range("AZ2:AZ"+total_registros_listados);
                        range_pais.validation({
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"A,B,C,D,E,F,G,H,I"',
                            allowNulls: false,
                            type: "reject",
                            messageTemplate: "La ventana ingresada, no se encuentra dentro de las permitidas. (Recuerde ingresarla en Mayúsculas.)"
                        });*/



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
                    OFERTA: {type: "string"},
                    GM: {type: "number"},
                    COD_TIP_MON: {type: "string"},
                    COSTO_TARGET: {type: "number"},
                    COSTO_FOB: {type: "number"},
                    COSTO_INSP: {type: "number"},
                    COSTO_RFID: {type: "number"},
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
                    FECHA_EMBARQUE: {type: "date"},
                    FECHA_ETA: {type: "date"},
                    FECHA_RECEPCION: {type: "date"},
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
                    COSTO_RFID_BASE: {type: "number"},
                    COD_MARCA: {type: "number"},
                    N_CURVASXCAJAS: {type: "number"},
                    COD_JER2: {type: "number"},
                    COD_SUBLIN: {type: "number"},
                    ARCHIVO_BASE: {type: "string"}

                }
            }
        }

    });

    // Asigna la estructura visual de la Grilla tipo Excel
    $("#spreadsheet").kendoSpreadsheet({
        columns: 103, //103 Siempre visible
        //rows: 10,
        //toolbar: true,
        toolbar: {
            data: [
                {
                    type: "button",
                    text: "Cargar Archivo",
                    imageUrl: "../web/telerik/content/web/toolbar/save.png",
                    //spriteCssClass: "k-icon k-font-icon k-i-cog",
                    click: function() {
                        //window.alert("custom tool");
                        var myWindow = $("#POPUP_carga_archivo_pi");
                        myWindow.data("kendoWindow").open();
                    }
                }
            ]
        },
        sheetsbar: false,
        sheets: [{
            name: "Nombre Pestaña",
            dataSource: dataSource,
            columns: [
                {width: 80},
                {width: 100},
                {width: 100},
                {width: 150},
                {width: 150},
                {width: 130},
                {width: 130}
            ]/*,

            rows: [{
                cells: [
                    {value: "Select item:", bold: true},
                    {
                        background: "#fef0cd",
                        validation: {
                            dataType: "list",
                            showButton: true,
                            comparerType: "list",
                            from: '"Foo item 1,Bar item 2,Baz item 3"',
                            allowNulls: true,
                            type: "reject"
                        }
                    }
                ]
            }]*/


        }]
    });



    // ################## OTRAS FUNCIONES ASOCIADAS A LA ESTRUCTURA DE LAGRILLA ####################
    // #############################################################################################
    // ################################# AQUÍ NO VAN ACCIONES JS ###################################
    // ################### AQUÍ SE DEFINE SOLO LA ESTRUCTURA DEL PLAN DE COMPRA ####################
    // ################################### SÓLO CODIGO TELERIK #####################################

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // Función Guardar Cambios Plan de Compra
    $("#guardar_cambios_pc").click(function () {
        if (!$(this).hasClass("k-state-disabled")) {
            dataSource.sync();
        }
    });

    // Función Cancelar Plan de Compra
    $("#cancelar_cambios_pc").click(function () {
        if (!$(this).hasClass("k-state-disabled")) {
            dataSource.cancelChanges();
        }
    });

    // Agrega ContextMenu en Plan de Compra
    var spreadsheet_contextual = $("#spreadsheet").data("kendoSpreadsheet");
    var menu_celda_archivopi = spreadsheet_contextual._controller.cellContextMenu;
    menu_celda_archivopi.append([
        { cssClass: "k-separator" },
        { text: "Historial" },
        { text: "Ajuste Compra" },
        { text: "Ajuste N° Cajas" },
        { text: "Detalle Error" },
        { cssClass: "k-separator" },
        { text: "Descarga Archivo PI" },
        { text: "Cargar Archivo PI" },
        { cssClass: "k-separator" },
        { text: "Match" }
    ]);
    menu_celda_archivopi.bind("select",
        function (e) {

            var command = $(e.item).text();

            // Busco el ID_COLOR3
            var ID_COLOR3 = "";
            var DEBUTREORDER = "";
            var PROFORMA = "";
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
                var range_debutreorder = sheet.range("BR"+fila_id);
                DEBUTREORDER = range_debutreorder.values();
                var range_proforma = sheet.range("CD"+fila_id);
                PROFORMA = range_proforma.values();
                var range_oc = sheet.range("CH"+fila_id);
                OC = range_oc.values();
                var range_linkeada = sheet.range("CG"+fila_id);
                LINKEADA = range_linkeada.values();
                var range_estadoc1 = sheet.range("CP"+fila_id);
                ESTADOC1 = range_estadoc1.values();
                var range_archivo = sheet.range("CE"+fila_id);
                ARCHIVO = range_archivo.values();

            });

            // NO ejecutar acciones cuando el ID_COLOR3 = 0, vacio o null

            if(command == "Historial") {

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

            if(command == "Ajuste Compra") {

                if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) || (DEBUTREORDER=="REORDER")){
                    popupNotification.show(" Las opciones REORDER no tienen ajuste de compra.", "error");
                }else{

                    // Levantar el POPUP
                    var popupAjusteCompra = $("#POPUP_ajuste_compra");
                    popupAjusteCompra.data("kendoWindow").open();

                    // Antes de volver a cargar la data, reseteo lo existente
                    $("#POPUP_ajuste_compra").data("kendoGrid").dataSource.data([]);

                    // Seteo DataSet
                    var dataSource_ajuste_compra = new kendo.data.DataSource({
                        transport: {
                            read:  {
                                url: "TelerikPlanCompra/ListarHistorial",
                                dataType: "json",
                                data:{ID_COLOR3: kendo.parseInt(ID_COLOR3)}
                            }
                        }
                    });

                    // Asigno el DataSet al Grid
                    var spreadsheet_ajuste_compra = $("#POPUP_ajuste_compra").data("kendoGrid");
                    spreadsheet_ajuste_compra.setDataSource(dataSource_ajuste_compra, [
                        { field: "FECHA", title: "FECHA" },
                        { field: "HORA", title: "HORA" },
                        { field: "USUARIO", title: "USUARIO" },
                        { field: "ESTADO", title: "ESTADO" }
                    ]);



                // Fin del else
                }



            }

            if(command == "Ajuste N° Cajas") {
                var popupAjusteCajas = $("#POPUP_ajuste_cajas");
                popupAjusteCajas.data("kendoWindow").open();
            }

            if(command == "Detalle Error") {
                var popupDetalleError = $("#POPUP_detalle_error");
                popupDetalleError.data("kendoWindow").open();
            }

            if(command == "Descarga Archivo PI") {

                // Descarga PI
                if (ESTADOC1 != 0) {

                    var valFileDownloadPath = '../archivos/pi/PI_' + TemporadaArchivoPI + '_' + DeptoArchivoPI + '_' + PROFORMA + '.xlsx';
                    window.open(valFileDownloadPath, '_blank');

                }else{
                    popupNotification.show(" En estado Ingresado,No puede descargar el archivo.", "error");
                }


            // Fin descarga archivo
            }

            if(command == "Cargar Archivo PI") {

                /*
                var sheet = spreadsheet.activeSheet(),
                selection = sheet.selection();
                selection.background("green");
                */

                if( (PROFORMA.length==0) || (PROFORMA==null) || (PROFORMA=="") || (ARCHIVO=="Cargado..") ){
                    popupNotification.show(" Seleccione un registro con proforma y archivo sin cargar.", "error");
                }else {

                    // Le asigno el nombre de la Proforma al campo de texto
                    $("#NombrePI").val(PROFORMA);

                    // Levantamos el popup
                    var popupArchivoPI = $("#POPUP_carga_archivo_pi");
                    popupArchivoPI.data("kendoWindow").open();

                }


            }

            if(command == "Match") {

                // BLOQUEAR si el usuario es solo de lectura

                // Que llegue la proforma y el estado sea Pendiente de Aprobación sin Match
                if( (PROFORMA.length==0) || (PROFORMA==null) || (PROFORMA=="") || (ESTADOC1==19) ){

                    popupNotification.show(" Seleccione un registro con Proforma,Pendiente de Aprobacion sin Match y OC no Linkeada.", "error");

                }else {

                    // Levantar el POPUP
                    var popupMatch = $("#POPUP_match");
                    popupMatch.data("kendoWindow").open();

                    // Antes de volver a cargar la data, reseteo lo existente
                    $("#grid_match_pmm").data("kendoGrid").dataSource.data([]);
                    $("#grid_match_plan").data("kendoGrid").dataSource.data([]);

                    // Seteo DataSet
                    var dataSource_match_pmm = new kendo.data.DataSource({
                        transport: {
                            read:  {
                                url: "TelerikPlanCompra/MatchLlenarGridPMM",
                                dataType: "json",
                                data:{ID_COLOR3: kendo.parseInt(ID_COLOR3), OC: OC, PI:PROFORMA}
                            }
                        }
                    });

                    var dataSource_match_plan = new kendo.data.DataSource({
                        transport: {
                            read:  {
                                url: "TelerikPlanCompra/MatchLlenarGridPlan",
                                dataType: "json",
                                data:{ID_COLOR3: kendo.parseInt(ID_COLOR3), OC: OC, PI:PROFORMA}
                            }
                        }
                    });

                    // Asigno el DataSet al Grid de PMM
                    var spreadsheet_match_pmm = $("#grid_match_pmm").data("kendoGrid");
                    spreadsheet_match_pmm.setDataSource(dataSource_match_pmm, [
                        { field: "FECHA", title: "ID" },
                        { field: "HORA", title: "PI" },
                        { field: "USUARIO", title: ">Cod. Línea" },
                        { field: "ESTADO", title: "Línea" },
                        { field: "ESTADO", title: "Cod. Sublinea" },
                        { field: "ESTADO", title: "Sublinea" },
                        { field: "ESTADO", title: "Estilo" },
                        { field: "ESTADO", title: "N° Estilo" },
                        { field: "ESTADO", title: "Color" },
                        { field: "ESTADO", title: "Cod. Color" }
                    ]);


                    // Asigno el DataSet al Grid de PLAN
                    var spreadsheet_match_plan = $("#grid_match_plan").data("kendoGrid");
                    spreadsheet_match_plan.setDataSource(dataSource_match_plan, [
                        { field: "FECHA", title: "ID" },
                        { field: "HORA", title: "PI" },
                        { field: "USUARIO", title: ">Cod. Línea" },
                        { field: "ESTADO", title: "Línea" },
                        { field: "ESTADO", title: "Cod. Sublinea" },
                        { field: "ESTADO", title: "Sublinea" },
                        { field: "ESTADO", title: "Estilo" },
                        { field: "ESTADO", title: "Color" },
                        { field: "ESTADO", title: "Cod. Color" },
                        { field: "ESTADO", title: "Valor Línea" },
                        { field: "ESTADO", title: "Valor SubLínea" },
                        { field: "ESTADO", title: "Valor Color" },
                        { field: "ESTADO", title: "Valor Estilo" },
                        { field: "ESTADO", title: "Correlativo" }
                    ]);



                // Fin Else
                }


            }

        });
    // Fin del menú contextual






// Fin del document ready
});
