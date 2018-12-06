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

                // Recargar PlanCompra
                var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                var sheet = spreadsheet.activeSheet();
                sheet.dataSource.read();


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
        rows: 400,
        //toolbar: true,
        toolbar: {
            data: [
                {
                    type: "button",
                    text: "Cargar Archivo",
                    imageUrl: "../web/telerik/content/web/toolbar/save.png",
                    //spriteCssClass: "k-icon k-font-icon k-i-cog",
                    click: function() {



                    }
                }
            ]
        },
        sheetsbar: false,
        sheets: [{
            name: "Nombre Pestaña",
            dataSource: dataSource,
            columns: [
                {width: 40},
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

            if(command == "Descarga Archivo PI") {

                // Descarga PI
                if (ESTADOC1 != 0) {

                    var valFileDownloadPath = '../archivos/pi/PI_' + TemporadaArchivoPI + '_' + DeptoArchivoPI + '_' + PROFORMA + '.xlsx';
                    window.open(valFileDownloadPath, '_blank');

                }else{
                    popupNotification.getNotifications().parent().remove();
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
                    popupNotification.getNotifications().parent().remove();
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
                                            dataType: "json"
                                            //type: "POST"
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
                                            dataType: "json"
                                            //type: "POST"
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
                                            dataType: "json"
                                            //type: "POST"
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
                                //type: 'POST',
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
                                dataType: "json"
                            }
                        },/*
                        change: function(e) {

                            // Cantidad de registros de PLAN
                            var TotalRegistroGrillaPMM = this.data();
                            // Cantidad de Registros de PMM
                            var TotalRegistroGrillaPLAN = dataSource_match_pmm.data();


                            console.log(TotalRegistroGrillaPMM.length);
                            console.log(TotalRegistroGrillaPLAN.length);


                        },*/
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

                    if(dataPMM.length != dataPLAN.length){

                        // Ocultar la Botonera
                        $("#grid_match_plan .k-grid-toolbar").hide();

                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" La Cantidad de Registros de PMM y PLAN, no son iguales.", "error");

                    }



                    // Fin TerminaCargaPLAN
                    }


                    // Asigno el DataSet al Grid de PMM
                    $("#grid_match_pmm").kendoGrid({
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
                                    popupNotification.show(" Problemas al Generar Match o Info Devuelta. "+result, "error");
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


            }

            if(command == "Cambio Estado") {


                if( (ID_COLOR3=="ID") || (ID_COLOR3=="") || (ID_COLOR3==null) || (ID_COLOR3.length==0) ){
                    popupNotification.getNotifications().parent().remove();
                    popupNotification.show(" Cambio Estado no disponible para este registro.", "error");
                }else{

                    // Levantar el POPUP
                    var popupCambioEstado = $("#POPUP_cambio_estado");
                    popupCambioEstado.data("kendoWindow").open();

                    // Seteo TextArea en Blanco
                    $("#comentSolicitaCorreccionPI").val("");

                    /*range.forEachCell(function (row, column, value) {
                        console.log(row);
                    });*/



                }





            // Fin del IF Cambio de Estado
            }



        // Fin del (e)
        });
    // Fin del menú contextual






// Fin del document ready
});
