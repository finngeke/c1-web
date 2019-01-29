$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikDiferenciaFechas/";

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
                text: "Volver",
                id: "volver_atras_c1",
                click: volver_atras_c1
            },
            { type: "separator" },
            { template: "<label for='DropDownListTemporada'>Temporada:</label>" },
            { template: "<label for='DropDownListVentana'>Ventana:</label>" },
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

    // Definimos DataSource
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "ListarDiferenciaFechas",
                dataType: "json"
            },
            data: function() {
                return { TEMPORADA: String($("#DropDownListTemporada").data("kendoComboBox").value()),
                    VENTANA: $("#DropDownListVentana").data("kendoComboBox").value()
                };
            }
        },
        schema: {
            model: {
                id: "ID_DEL_REGISTO_QUE_LLEGA",
                fields: {
                    CAMPO1BD: { type: "string",editable: false }, // number - string - date
                    CAMPO2BD: { type: "string",editable: false }, // number - string - date
                    CAMPO3BD: { type: "string",editable: false } // number - string - date
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
            { name: "save", text: "Guardar Cambios", iconClass: "k-icon k-i-copy" },
            { name: "cancel", text: "Cancela Modificaciones sin Guardar" }
        ],
        height: 550, // Altura del Grid
        resizable: true, // Las Columnas pueden Cambair de Tamaño
        filterable: true, // Se puede Filtrar
        sortable: true, // Se puede ordenar
        columns: [ // Columnas a Listar
            { selectable: true, width: "13px" }, // checkbox en la Primera Columna
            {field: "CAMPO1BD",title: "Nombre del Campo Para el Usuario",width: 30,filterable: {multi: true}},
            {field: "CAMPO2BD",title: "Nombre del Campo Para el Usuario",width: 30,filterable: {multi: true}},
            {field: "CAMPO3BD",title: "Nombre del Campo Para el Usuario",width: 30,filterable: {multi: true}}
        ]/*,
        change: seleccionaOpcion*/ // solo si estamos utilizando un checkbox en la primera columna, quitar si no se utiliza
    });

    // BTN Custom, quitar si no se utiliza
    /*$(".k-grid-custombutton_nombre_propio").click(function(e){
        // Acción
    });*/



    $("#DropDownListTemporada").kendoDropDownList({
        optionLabel: "Seleccione Temporada",
        dataTextField: "NOMBRE_TEMPORACA_CAMPO_BD",
        dataValueField: "VALOR_TEMPORACA_CAMPO_BD",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarTemporada" // Depto llega al controlador por session
                }
            }
        }
    });

    $("#DropDownListVentana").kendoDropDownList({
        optionLabel: "Seleccione Ventana",
        dataTextField: "NOMBRE_VENTANA_CAMPO_BD",
        dataValueField: "VALOR_VENTANA_CAMPO_BD",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarVentana" // Depto llega al controlador por session, si necesita capturar CBX anterior llamar al data de la misma forma que el datasource
                }
            }
        },
        change: function(e) {

            /*var dataItem = e.sender.dataItem();

            if(dataItem){
                dataSource.read();
            }*/

        }
    });




// Fin del document ready
});
