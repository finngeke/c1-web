$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikResumenEstilos/";

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // BTN Volver
    function volver_atras_c1(e) {
        window.location.href = "inicio";
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
            {
                type: "button",
                text: "Logout",
                id: "salir_c1",
                click: salir_c1,
                overflow: "always"
            }
        ]
    });


    // CBX de Port of Delivery
    function PortDeliveryDropDownEditor(container, options) {
        $('<input required name="' + options.field + '"/>')
            .appendTo(container)
            .kendoDropDownList({
                autoBind: false,
                filter: "contains",
                dataTextField: "NOM_PUERTO",
                dataValueField: "COD_PUERTO",
                dataSource: {
                    transport: {
                        read:  {
                            url: crudServiceBaseUrl + "ListarPortDelivery",
                            dataType: "json"
                        }
                    }
                }
            });
    }

    // Definimos DataSource
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "ListarResumenEstilos",
                dataType: "json"
            },
            update: {
                url: crudServiceBaseUrl + "ActualizaResumenEstilos",
                dataType: "json"
            }
        },
        schema: {
            model: {
                id: "ID",
                fields: {
                    PROFORMA: { type: "string",editable: true }, // number - string - date
                    DES_ESTILO: { type: "string",editable: false }, // number - string - date
                    COD_MOD_PAIS: { type: "string",editable: false }, // number - string - date
                    NOM_MARCA: { type: "string",editable: false }, // number - string - date
                    NOM_LINEA: { type: "string",editable: false }, // number - string - date
                    COSTO_INSP: { type: "number",editable: false }, // number - string - date
                    UNIDADES: { type: "number",editable: false }, // number - string - date
                    COSTO_FOB: { type: "number",editable: false }, // number - string - date
                    COSTO_TOT: { type: "number",editable: false }, // number - string - date
                    MTR_PACK: { type: "number",editable: false }, // number - string - date
                    CANT_INNER: { type: "number",editable: false }, // number - string - date
                    FECHA_EMBARQUE_ACORDADA: { type: "string",editable: false }, // number - string - date
                    COD_PUERTO: { type: "string",editable: true,validation: { required: true } } // number - string - date
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

    // Definimos KendoGrid
    $("#grid").kendoGrid({
        dataSource: dataSource,
        editable: true,
        toolbar: [
            //{ name:"custombutton_nombre_propio", text: "Botón Custom"}, // Solo si se quiere agregar un botón custom
            { name: "save", text: "Save", iconClass: "k-icon k-i-copy" },
            { name: "cancel", text: "Cancel unsaved changes" }
        ],
        //height: 550, // Altura del Grid
        resizable: true, // Las Columnas pueden Cambair de Tamaño
        filterable: true, // Se puede Filtrar
        sortable: true, // Se puede ordenar
        columns: [ // Columnas a Listar
            {field: "PROFORMA",title: "Vendor PI N°",width: 70},
            {field: "DES_ESTILO",title: "Style Name",width: 70,filterable: {multi: true}},
            {field: "COD_MOD_PAIS",title: "Country",minResizableWidth: 35,width: 35,filterable: {multi: true}},
            {field: "NOM_MARCA",title: "Brand",width: 50,filterable: {multi: true}},
            {field: "NOM_LINEA",title: "Line",width: 50,filterable: {multi: true}},
            {field: "COSTO_INSP",title: "Inspection",width: 30,filterable: {multi: true}},
            {field: "UNIDADES",title: "Qtty",width: 20,filterable: {multi: true}},
            {field: "COSTO_FOB",title: "Final Price",width: 30,filterable: {multi: true}},
            {field: "COSTO_TOT",title: "Total Amount",width: 30,filterable: {multi: true}},
            {field: "MTR_PACK",title: "Master Pack",width: 30,filterable: {multi: true}},
            {field: "CANT_INNER",title: "# of Cartons",width: 35,filterable: {multi: true}},
            {field: "FECHA_EMBARQUE_ACORDADA",title: "Delivery Date",width: 35,filterable: {multi: true}},
            {field: "COD_PUERTO",title: "Port or Delivery",width: 70, editor: PortDeliveryDropDownEditor}
        ]/*,
        change: seleccionaOpcion*/ // solo si estamos utilizando un checkbox en la primera columna, quitar si no se utiliza
    });

    // BTN Custom, quitar si no se utiliza
    /*$(".k-grid-custombutton_nombre_propio").click(function(e){
        // Acción
    });*/




// Fin del document ready
});
