$(function () {

    $("#toolbar").kendoToolBar({
        items: [
            {type: "button", text: "Guardar" },
            {type: "button", text: "Salir" },
            {type: "button", text: "Add" }
            ]
    });




   // $("#grilla_factor_importado").data("kendoGrid").dataSource.data([]);


    $("#grilla_factor_importado").kendoGrid({
        dataSource: {
            transport: {
                read: { url: "Factor_import/List_factor_Importacion",
                        dataType: "json"
                        //type: 'POST',
                    }
            },
            schema: {
                model: {
                    fields: {
                        ID_FACTOR: { type: "number" },
                        VIA: { type: "string" },
                        PUERTO_EMB: { type: "string" },
                        PUERTO_DESTINO: { type: "string" },
                        INCOTERM: { type: "string" },
                        DIVISION: { type: "string" },
                        DEPARTAMENTO: { type: "string" },
                        MARCA: { type: "string" },
                        FACTOR: { type: "number" }
                    }
                }
            }
        },
        height: 550,
        filterable: true,
        sortable: true,
        columns:    [ {field:"ID_FACTOR",
                       filterable: false,
                       title: "ID"
                    },{field: "VIA",
                        title: "Vía de transporte"
                    },{field: "PUERTO_EMB",
                        title: "Puerto Embarque"
                    },{field: "PUERTO_DESTINO",
                        title: "Puerto Destino"
                    },{field: "INCOTERM",
                        title: "Incoterm"
                    },{field: "DIVISION",
                        title: "División"
                    },{field: "DEPARTAMENTO",
                        title: "Departamento"
                    },{field: "MARCA",
                        title: "Marca"
                    },{field: "FACTOR",
                        title: "Factor"
                    }
        ]
    });


});