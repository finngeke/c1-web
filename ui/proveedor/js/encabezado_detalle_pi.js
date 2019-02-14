$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikEncabezadoDetallePi/";
    var crudServiceBaseUrlPOST = "TelerikEncabezadoDetallePiPOST/";

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // BTN Volver
    function volver_atras_c1(e) {
        var volver_proveedor = $("#span_cod_proveedor").text();
        window.location.href = "proveedor?cod_proveedor="+volver_proveedor;
    }

    // BTN salir
    function salir_c1(e) {
        window.location.href = "salir";
    }

    // Barra de menú superior
    $("#toolbar").kendoToolBar({
        items: [
            {
                type: "button",
                text: "Back",
                id: "volver_atras_c1",
                click: volver_atras_c1
            },
            { type: "separator" },
            { template: "<label id='label_cabecera_menu' style='font-weight: bold;text-align: right;'>PI Management</label>" },
            //{ type: "separator" },
            {
                type: "button",
                text: "Logout",
                id: "salir_c1",
                click: salir_c1,
                overflow: "always"
            }
        ]
    });

    // CBX de Incoterm
    function IncotermDropDownEditor(container, options) {
        $('<input name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "NOM_INCOTERM",
                dataValueField: "COD_INCOTERM",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl+"ListarIncoterm",
                            dataType: "json"/*
                                            type: "POST"*/
                        }
                    }
                }
            });
    }

    var ventana_cuerpo = $("#cuerpo");
    ventana_cuerpo.kendoWindow({
        width: "800px",
        title: "Detail",
        visible: false,
        actions: [
            //"Pin",
            "Minimize",
            "Maximize",
            "Close"
        ]/*,
    close: onClose*/
    }).data("kendoWindow").center();

    // Definimos DataSource de la "Cabecera"
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "ListarP5Encabezado",
                dataType: "json"
            },
            update: {
                type: "POST",
                url: crudServiceBaseUrlPOST + "ActualizaIncoterm",
                dataType: "json"
            }
        },
        batch: true,
        schema: {
            model: {
                id: "ID",
                fields: {
                    NOM_EST_C1: { type: "string",editable: false }, // number - string - date
                    PI_VENDOR: { type: "string",editable: false }, // number - string - date
                    PROFORMA: { type: "string",editable: false }, // number - string - date
                    NOM_PAIS: { type: "string",editable: false }, // number - string - date
                    INCOTERM: { type: "string",editable: true }, // number - string - date
                    COD_PUERTO: { type: "string",editable: false }, // number - string - date
                    TOTAL_WEIGHT: { type: "number",editable: false }, // number - string - date
                    CBM: { type: "number",editable: false }, // number - string - date
                    ESTADO: { type: "number",editable: false }, // number - string - date
                    COD_PUERTO_COD: { type: "string",editable: false }, // number - string - date
                    DEP_DEPTO: { type: "string",editable: false } // number - string - date
                }
            }
        }/*,
        change: function () {
            // Si existen un cambio en la data
        }*//*,
        requestEnd: function (e) {

            // Si al Finalizar la sincronización es de tipo "update" o "create"
            if ( (e.type === 'update') || (e.type === 'create') ) {
                // Accion
            }

        }*/
    });

    // Solo si utilizo checkbox en la grilla, quitar si no se utiliza
    /*function seleccionaOpcion(arg) {
        $("#span_checkbox_grilla").text(this.selectedKeyNames().join(", "));
    }*/

    // Definimos GRID de la Cabecera
    $("#grid").kendoGrid({
        dataSource: dataSource,
        editable: true,
        //selectable: true,
        toolbar: [
            { name:"aprobar_pi", text: "Botón Custom"}, // Solo si se quiere agregar un botón custom
            { name: "save", text: "Save Changes", iconClass: "k-icon k-i-copy" },
            { name: "cancel", text: "Cancel unsaved changes" }
        ],
        //height: 550, // Altura del Grid
        resizable: true, // Las Columnas pueden Cambair de Tamaño
        //filterable: true, // Se puede Filtrar
        sortable: true, // Se puede ordenar
        scrollable: true,
        columns: [ // Columnas a Listar
            {field: "NOM_EST_C1",title: "PI Status",width: 50,filterable: {multi: true}},
            {field: "PI_VENDOR",title: "Vendor PI N°",width: 40,filterable: {multi: true}},
            {field: "PROFORMA",title: "Ripley PI N°",width: 40,filterable: {multi: true}},
            {field: "NOM_PAIS",title: "Origin of Goods",width: 30,filterable: {multi: true}},
            {field: "INCOTERM",title: "Terms of Delivery",width: 30,filterable: {multi: true}, editor: IncotermDropDownEditor},
            {field: "COD_PUERTO",title: "Port of Delivery",width: 50,filterable: {multi: true}},
            {field: "TOTAL_WEIGHT",title: "Total Weight (Kg)",width: 30,filterable: {multi: true}},
            {field: "CBM",title: "Total Measurement (CBM)",width: 40,filterable: {multi: true}},
            {field: "ESTADO", hidden: true},
            {field: "COD_PUERTO_COD", hidden: true},
            {field: "DEP_DEPTO", hidden: true},
            {field: "COD_MOD_PAIS", hidden: true}
        ]/*,
        change: seleccionaOpcion*/
    });

    var dataSource_cuerpo = "";

    // Definimos GRID del Cuerpo
    $("#grid_cuerpo").kendoGrid({
        autoBind: false,
        dataSource: dataSource_cuerpo,
        editable: true,
        resizable: true, // Las Columnas pueden Cambair de Tamaño
        //filterable: true, // Se puede Filtrar
        sortable: true, // Se puede ordenar
        scrollable: true,
        columns: [ // Columnas a Listar
            {field: "NOM_EST_C1",title: "PI Status",width: 50,filterable: {multi: true}},
            {field: "PI_VENDOR",title: "Vendor PI N°",width: 40,filterable: {multi: true}},
            {field: "PROFORMA",title: "Ripley PI N°",width: 40,filterable: {multi: true}},
            {field: "DES_ESTILO",title: "Style Name",width: 40,filterable: {multi: true}},
            {field: "NOM_PAIS",title: "Country",width: 30,filterable: {multi: true}},
            {field: "NOM_MARCA",title: "Brand",width: 30,filterable: {multi: true}},
            {field: "NOM_LINEA",title: "Line",width: 50,filterable: {multi: true}},
            {field: "COSTO_INSP",title: "Inspection",width: 30},
            {field: "UNIDADES",title: "Qtty",width: 40},
            {field: "COSTO_FOB",title: "Final Price",width: 40},
            {field: "COSTO_TOT",title: "Total Amount",width: 40},
            {field: "MTR_PACK",title: "Master Pack",width: 40},
            {field: "CANT_INNER",title: "# of Cartons",width: 40},
            {field: "FECHA_EMBARQUE_ACORDADA",title: "Delivery Date",width: 40},
            {field: "NOM_PUERTO",title: "Port of Delivery",width: 40},
            {field: "DESTALLA",title: "Sizes",width: 40},
            {field: "COLOR",title: "Colors",width: 40},
            {field: "ESTADO", hidden: true},
            {field: "COD_PUERTO", hidden: true}
        ]/*,
        change: seleccionaOpcion*/
    });


    $("#grid").dblclick(function (event) {

    // row html element
    var row = $(event.target).closest('tr');

    // data key value
    //var key = row.attr("data-id");

    // Obtengo el Valor de la Proforma
    var proforma = row.find('td:eq(2)').text();
    var cod_mod_pais = row.find('td:eq(11)').text();

    // Si puede obtener la PROFORMA, levanta el POPUP
    if(proforma.length>0){

        // Levantamos el POPUP del Cuerpo
        var POPUPCuerpo = $("#cuerpo");
        POPUPCuerpo.data("kendoWindow").open();

        var tit_popup = $("#cuerpo").data("kendoWindow");
        tit_popup.title("Vendor PI N°: "+proforma);

        // Definimos DataSource de la "Cabecera"
        dataSource_cuerpo = new kendo.data.DataSource({
            transport: {
                read:  {
                    //type: "POST",
                    url: crudServiceBaseUrl + "ListarP5Cuerpo",
                    dataType: "json",
                    data: function() {
                        return { COD_MOD_PAIS:cod_mod_pais,PROFORMA: proforma};
                    }
                }
            },
            //batch: true,
            schema: {
                model: {
                    id: "ID",
                    fields: {
                        NOM_EST_C1: { type: "string",editable: false }, // number - string - date
                        PI_VENDOR: { type: "string",editable: false }, // number - string - date
                        PROFORMA: { type: "string",editable: false }, // number - string - date
                        DES_ESTILO: { type: "string",editable: false }, // number - string - date
                        NOM_PAIS: { type: "string",editable: false }, // number - string - date
                        NOM_MARCA: { type: "string",editable: true }, // number - string - date
                        NOM_LINEA: { type: "string",editable: false }, // number - string - date
                        COSTO_INSP: { type: "number",editable: false }, // number - string - date
                        UNIDADES: { type: "number",editable: false }, // number - string - date
                        COSTO_FOB: { type: "number",editable: false }, // number - string - date
                        COSTO_TOT: { type: "number",editable: false }, // number - string - date
                        MTR_PACK: { type: "number",editable: false }, // number - string - date
                        CANT_INNER: { type: "number",editable: false }, // number - string - date
                        FECHA_EMBARQUE_ACORDADA: { type: "string",editable: false }, // number - string - date
                        NOM_PUERTO: { type: "string",editable: false }, // number - string - date
                        DESTALLA: { type: "string",editable: false }, // number - string - date
                        COLOR: { type: "string",editable: false }, // number - string - date
                        ESTADO: { type: "number",editable: false }, // number - string - date
                        COD_PUERTO: { type: "string",editable: false } // number - string - date
                    }
                }
            }
        });


        $("#grid_cuerpo").data("kendoGrid").setDataSource(dataSource_cuerpo);
        $('#grid_cuerpo').data('kendoGrid').dataSource.read();
        $('#grid_cuerpo').data('kendoGrid').refresh();


        //dataSource_cuerpo.read();
        //$("#grid_cuerpo").data("kendoGrid").dataSource.read();
        //$("#grid_cuerpo").dataSource.read();





    // Fin de si llega PROFORMA
    }







     });

    // BTN Custom, quitar si no se utiliza
    $(".k-grid-aprobar_pi").click(function(e){
        // Acción
    });




// Fin del document ready
});
