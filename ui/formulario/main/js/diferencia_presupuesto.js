$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikDiferenciaPresupuesto/";

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
             read: {
                url: crudServiceBaseUrl + "ListarDiferenciaPresupuesto",
                dataType: "json",
                 data: function () {
                     return {
                         DEPARTAMENTO: $("#DropDownListDepto").data("kendoDropDownList").value(),
                         VENTANA: $("#DropDownListVentana").data("kendoMultiSelect").value()
                     };
                 }
            }
        },
        schema: {
            model: {
                id: "ID",
                fields: {
                    NOM_LINEA: { type: "string",editable: false }, // number - string - date
                    COSTO_PLAN: { type: "string",editable: false }, // number - string - date
                    COSTO_REAL: { type: "string",editable: false }, // number - string - date
                    VARIACION_COSTO: { type: "string",editable: false }, // number - string - date
                    UNIDADES_REAL: { type: "string",editable: false }, // number - string - date
                    VARIACION_UNIDADES: { type: "string",editable: false }, // number - string - date
                    RETAIL_PLAN: { type: "string",editable: false }, // number - string - date
                    RETAIL_REAL: { type: "string",editable: false }, // number - string - date
                    VARIACION_RETAIL: { type: "string",editable: false } // number - string - date
                }
            }
        }
    });

    function seleccionaOpcion(arg) {
        $("#span_checkbox_grilla").text(this.selectedKeyNames().join("*"));
    }

    // Definimos KendoGrid
    $("#grid").kendoGrid({
        autoBind:false,
        dataSource: dataSource,
        editable: true,
        toolbar: [
            { name:"custombutton_aprobar", text: "Aprobar"}, // Solo si se quiere agregar un botón custom
            { name:"custombutton_rechazar", text: "Rechazar"}
        ],
        height: 550, // Altura del Grid
        resizable: true, // Las Columnas pueden Cambair de Tamaño
        filterable: true, // Se puede Filtrar
        sortable: true, // Se puede ordenar
        columns: [ // Columnas a Listar
            { selectable: true, width: "13px" }, // checkbox en la Primera Columna
            {field: "NOM_LINEA",title: "Linea",width: 30,filterable: {multi: true}
            ,headerAttributes: {
                    style: "text-align: center"
                }},
            {label: "COSTO", title: "Costo",width: 90, columns:[
                    {field: "COSTO_PLAN",title: "Presupuesto",width: 30,filterable: {multi: true}},
                    {field: "COSTO_REAL",title: "Real",width: 30,filterable: {multi: true}},
                    {field: "VARIACION_COSTO",title: "Variacion",width: 30,filterable: {multi: true}}
                ]
                ,headerAttributes: {
                    style: "text-align: center"
                }},
            {label: "UNIDADES", title: "Unidades",width: 90, textAlign:"center", columns:[
                    {field: "UNIDADES_PLAN",title: "Presupuesto",width: 30,filterable: {multi: true}},
                    {field: "UNIDADES_REAL",title: "Real",width: 30,filterable: {multi: true}},
                    {field: "VARIACION_UNIDADES",title: "Variacion",width: 30,filterable: {multi: true}}
                ],headerAttributes: {
                    style: "text-align: center"
                }},
            {label: "RETAIL", title: "Retail",width: 90, textAlign:"center", columns:[
                    {field: "RETAIL_PLAN",title: "Presupuesto",width: 30,filterable: {multi: true}},
                    {field: "RETAIL_REAL",title: "Real",width: 30,filterable: {multi: true}},
                    {field: "VARIACION_RETAIL",title: "Variacion",width: 30,filterable: {multi: true}}
                ],headerAttributes: {
                    style: "text-align: center"
                }},

        ],
        change: seleccionaOpcion // solo si estamos utilizando un checkbox en la primera columna, quitar si no se utiliza
    });


    // BTN Custom, quitar si no se utiliza
    $(".k-grid-custombutton_aprobar").click(function(e){
        var res = confirm("Esta seguro de aprobar?");
        seleccion = $("#span_checkbox_grilla").text();
        console.log(seleccion);
        if(res) {
            $.ajax({
                url: crudServiceBaseUrl + "aprobar",
                data: {SELECCION: seleccion},
                dataType: "text",
                method: 'GET',
                success: function (result) {
                    popupNotification.show("Aprobado con exito!", "success");
                    dataSource.read();
                },
                error: function (xhr, httpStatusMessage, customErrorMessage) {
                    console.log(xhr);
                    popupNotification.show("Error al aprobar.", "error");
                }
            });
        }
    });
    $(".k-grid-custombutton_rechazar").click(function(e){
        var res = confirm("Esta seguro de rechazar?");
        seleccion = $("#span_checkbox_grilla").text();
        console.log(seleccion);
        if(res) {
            $.ajax({
                url: crudServiceBaseUrl + "rechazar",
                data: {SELECCION: seleccion},
                dataType: "text",
                method: 'GET',
                success: function (result) {
                    popupNotification.show("rechazado con exito!", "success");
                    dataSource.read();
                },
                error: function (xhr, httpStatusMessage, customErrorMessage) {
                    console.log(xhr);
                    popupNotification.show("Error al rechazar.", "error");
                }
            });
        }
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
        },
        change: function(e) {
            dataSource.read();
        }
    });

    $("#DropDownListVentana").kendoMultiSelect({
        optionLabel: "Seleccione Ventana",
        dataTextField: "VENT_DESCRI",
        dataValueField: "VENT_DESCRI",
        dataSource: {
            transport: {
                read: {
                    dataType: "json",
                    url: crudServiceBaseUrl + "ListarVentana"
                }
            }
        },
        change: function(e) {
            dataSource.read();
        }
    });


// Fin del document ready
});
