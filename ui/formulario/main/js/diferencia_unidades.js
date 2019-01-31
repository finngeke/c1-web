$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikDiferenciaUnidades/";

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
            { template: "<label for='DropDownListDepto'>Departamento:</label>" },
            {
                template: "<input id='DropDownListDepto' style='width: 200px;' />",
                overflow: "never"
            },
            { template: "<label for='DropDownListVentana'>Ventana:</label>" },
            {
                template: "<input id='DropDownListVentana' style='width: 200px;' />",
                overflow: "never"
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

    // Definimos DataSource
    var dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: crudServiceBaseUrl + "ListarDiferenciaUnidades",
                dataType: "json",
                data: function() {
                    return { DEPARTAMENTO:$("#DropDownListDepto").data("kendoDropDownList").value(),
                        VENTANA: $("#DropDownListVentana").data("kendoDropDownList").value()
                    };
                }
            }
        },
        schema: {
            model: {
                fields: {
                    TEMPORADA: { type: "string",editable: false }, // number - string - date
                    GRUPO_COMPRA: { type: "string",editable: false }, // number - string - date
                    VENTANA: { type: "string",editable: false }, // number - string - date
                    ESTILO: { type: "string",editable: false }, // number - string - date
                    COLOR: { type: "string",editable: false }, // number - string - date
                    UNID_PLAN: { type: "number",editable: false }, // number - string - date
                    UNID_ACORD: { type: "number",editable: false }, // number - string - date
                    DIFER_UND: { type: "number",editable: false }, // number - string - date
                    PORCENT_DIFER: { type: "number",editable: false } // number - string - date
                }
            }
            }
    });
    $("#grid").kendoGrid({
        autoBind:false,
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
            {field: "TEMPORADA",title: "Temporada",width: 25,filterable: {multi: true}},
            {field: "GRUPO_COMPRA",title: "Grupo Compra",width: 30,filterable: {multi: true}},
            {field: "VENTANA",title: "Ventana",width: 25,filterable: {multi: true}},
            {field: "ESTILO",title: "Estilo",width: 100,filterable: {multi: true}},
            {field: "COLOR",title: "Color",width: 30,filterable: {multi: true}},
            {field: "UNID_PLAN",title: "Unidades Plan",width: 30,filterable: {multi: true}},
            {field: "UNID_ACORD",title: "Unidades Acordadas",width: 30,filterable: {multi: true}},
            {field: "DIFER_UND",title: "Diferencia Unidades",width: 30,filterable: {multi: true}},
            {field: "PORCENT_DIFER",title: "% Diferencia Unidades",width: 30,filterable: {multi: true}}
        ]/*,
        change: seleccionaOpcion*/ // solo si estamos utilizando un checkbox en la primera columna, quitar si no se utiliza
    });

    $("#DropDownListDepto").kendoDropDownList({
        optionLabel: "Seleccione Departamento",
        dataTextField: "DEP_DESCRIPCION",
        dataValueField: "DEP_DEPTO",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarDepto"
                }
            }
        }
    });

    $("#DropDownListVentana").kendoDropDownList({
        optionLabel: "Seleccione Ventana",
        dataTextField: "VENT_DESCRI",
        dataValueField: "COD_VENTANA",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarVentana"
                }
            }
        },
        change: function(e) {

           // $('#grid').data('kendoGrid').dataSource.read();

                dataSource.read();


        }
    });




// Fin del document ready
});
