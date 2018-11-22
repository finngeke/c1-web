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
            url: crudServiceBaseUrl + "ActualizaPlanCompra",
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
                    DESCRIPCION: {type: "string"},
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
                    COSTO_RFID_BASE: {type: "number"}

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



    // ####################### OTRAS FUNCIONES ASOCIADAS A LA GRILLA #######################

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // Función Guardar cambios en Grilla
    $("#guardar_cambios_pc").click(function () {
        if (!$(this).hasClass("k-state-disabled")) {
            dataSource.sync();
        }
    });

    // Función Cancelar cambios en Grilla
    $("#cancelar_cambios_pc").click(function () {
        if (!$(this).hasClass("k-state-disabled")) {
            dataSource.cancelChanges();
        }
    });


    // Agrega ContextMenu para cargar la PI a un registro
    var spreadsheet_contextual = $("#spreadsheet").data("kendoSpreadsheet");
    var menu_celda_archivopi = spreadsheet_contextual._controller.cellContextMenu;
    menu_celda_archivopi.append([
        { cssClass: "k-separator" },
        { text: "Historial" },
        { text: "Ajuste Compra" },
        { text: "Ajuste N° Cajas" },
        { text: "Detalle Error" },
        { text: "Descarga Archivo PI" },
        { cssClass: "k-separator" },
        { text: "Cargar Archivo PI" }
    ]);
    menu_celda_archivopi.bind("select",
        function (e) {

            var command = $(e.item).text();

            // Busco el ID_COLOR3
            var ID_COLOR3 ="";
            var DEBUTREORDER ="";
            var spreadsheet_id_color3 = $("#spreadsheet").data("kendoSpreadsheet");
            var sheet = spreadsheet_id_color3.activeSheet();
            var range = sheet.selection();

            range.forEachCell(function (row, column, value) {
                //console.log(row, column, value);

                var fila_id = row+1;
                var range_color3 = sheet.range("A"+fila_id);
                ID_COLOR3 = range_color3.values();
                var range_debutreorder = sheet.range("BR"+fila_id);
                DEBUTREORDER = range_debutreorder.values();

            });

            // NO ejecutar acciones cuando el ID_COLOR3 = 0, vacio o null

            if(command == "Historial") {

                if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) ){
                    popupNotification.show(" Historial no disponible para este registro.", "error");
                }else{

                    // Levantar el POPUP
                    var popupHistorial = $("#POPUP_historial");
                    popupHistorial.data("kendoWindow").open();

                    // Antes de volver a cargar la data, reseteo lo existente
                    $("#POPUP_historial").data("kendoGrid").dataSource.data([]);

                    // Seteo DataSet
                    var dataSource_historial = new kendo.data.DataSource({
                        transport: {
                            read:  {
                                url: "TelerikPlanCompra/ListarHistorial",
                                dataType: "json",
                                data:{ID_COLOR3: kendo.parseInt(ID_COLOR3)}
                            }
                        }
                    });

                    // Asigno el DataSet al Grid
                    var spreadsheet_hist = $("#POPUP_historial").data("kendoGrid");
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
            }

            if(command == "Cargar Archivo PI") {
                /*var sheet = spreadsheet.activeSheet(),
                    selection = sheet.selection();
                selection.background("green");*/

                var popupArchivoPI = $("#POPUP_carga_archivo_pi");
                popupArchivoPI.data("kendoWindow").open();

            }



        });










    // revisar su uso
    function onSelect(arg) {
        var cellvalue = arg.range.value();
        var topLeft = arg.range.topLeft();
        var row = topLeft.row;
        var col = topLeft.col;

        console.log(row);
        console.log(col);
    }





});
