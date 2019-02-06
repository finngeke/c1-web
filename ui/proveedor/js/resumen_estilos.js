$(function () {

    // Defrine URL Base, para Llamar a los JSON
    var crudServiceBaseUrl = "TelerikResumenEstilos/";
    var crudServiceBaseUrlPOST = "TelerikResumenEstilosPOST/";

    // Se define POPUP de notificación
    var popupNotification = $("#popupNotification").kendoNotification().data("kendoNotification");

    // BTN Volver
    function volver_atras_c1(e) {
        window.location.href = "proveedor?cod_proveedor=18937";
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


    // CBX de Port of Delivery
    function PortDeliveryDropDownEditor(container, options) {
        $('<input name="' + options.field + '"/>')
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
                type: "POST",
                url: crudServiceBaseUrlPOST + "ActualizaResumenEstilos",
                dataType: "json"
            }/*,
            parameterMap: function(options, operation) {
                if (operation !== "read" && options.models) {
                    return {
                        models: kendo.stringify(options.models)
                    };
                }
            }*/
        },
        batch: true,
        schema: {
            model: {
                id: "ID",
                fields: {
                    PROFORMA: { type: "string",validation: { required: false }}, // number - string - date ,validation: { required: true }
                    COD_PUERTO: { type: "string",editable: true }, // number - string - date
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
                    DEP_DEPTO: { type: "string",editable: false } // number - string - date
                }
            }
        },
        change: function (e) {

            var id_registro = e.items[0].ID;
            var fecha_embarque = e.items[0].FECHA_EMBARQUE_ACORDADA;
            var puerto_embarque = e.items[0].COD_PUERTO;
            var proforma = e.items[0].PROFORMA;
            var depto = e.items[0].DEP_DEPTO;

            //var arregloRegistros = [];

            // Si el campo que estoy editando es PROFORMA o COD_PUERTO COLORES
            if(e.field == 'PROFORMA' || e.field == 'COD_PUERTO'){


                var grid = $("#grid").getKendoGrid();
                var ItemsGrid = grid.dataSource.data();
                // var dataItem = grid.dataItem("tbody tr:eq(0)");

                var conteo = 0;
                ItemsGrid.forEach(function(el,row,index){
                    conteo++;
                /*
                var dataItem = grid.dataItem("tbody tr:eq("+row+")");
                dataItem.PROFORMA = 'ettet';
                */

                // Colorear el ROW
                if( (el.FECHA_EMBARQUE_ACORDADA==fecha_embarque) && (el.COD_PUERTO==puerto_embarque) && (el.DEP_DEPTO==depto) && (el.PROFORMA!=proforma) ){
                    $("[data-uid='"+el.uid+"']").css("background", "#FFF380");
                }else if( (el.FECHA_EMBARQUE_ACORDADA==fecha_embarque) && (el.COD_PUERTO==puerto_embarque) && (el.DEP_DEPTO==depto) && (el.PROFORMA==proforma) ){
                    $("[data-uid='"+el.uid+"']").css("background", "#FFF380");
                }else{
                    $("[data-uid='"+el.uid+"']").css("background", "");
                }


                /*if(e.field == 'PROFORMA') {

                    if ( (el.PROFORMA == proforma) && ((el.FECHA_EMBARQUE_ACORDADA != fecha_embarque) || (el.COD_PUERTO != puerto_embarque)) ) {
                        console.log(conteo +" Error en nombre de Proforma");
                        var dataItem = grid.dataItem("tbody tr:eq(" + conteo + ")");
                        dataItem.PROFORMA = 'ERROR';
                        grid.refresh();
                    }

                }*/


                    /*arregloRegistros.push({
                        "ID": String(el.ID),
                        "FECHA_EMBARQUE_ACORDADA": String(el.FECHA_EMBARQUE_ACORDADA),
                        "COD_PUERTO": String(el.COD_PUERTO),
                        "PROFORMA": String(el.PROFORMA),
                        "ROW": row)
                    });*/



                // Fin del foreach
                })

                //console.log(conteo);

            }

            // Del arreglo creado previamente, elimino el registro que esta siendo modificado
            /*
            var removeItem = id_registro;
            for(var i=0;i<arregloRegistros.length;i++){
                if(arregloRegistros[i].ID == removeItem){
                    arregloRegistros.splice(i,1);
                }
            }
            console.log(arregloRegistros);
            */



        },
        requestEnd: function (e) {

            // Si al Finalizar la sincronización es de tipo "update" o "create"
            if ( (e.type === 'update') || (e.type === 'create') ) {
                // Accion
                // $('#grid').data('kendoGrid').dataSource.read();
                // $('#grid').data('kendoGrid').refresh();

                location.reload(true);

            }

        }
    });


    // Definimos KendoGrid
    $("#grid").kendoGrid({
        dataSource: dataSource,
        editable: true,
        //allowCopy: true,
        toolbar: [
            //{ name:"custombutton_nombre_propio", text: "Botón Custom"}, // Solo si se quiere agregar un botón custom
            { name: "save", text: "Save Changes", iconClass: "k-icon k-i-copy" },
            { name: "cancel", text: "Cancel unsaved changes" }
        ],
        //height: 550, // Altura del Grid
        resizable: true, // Las Columnas pueden Cambair de Tamaño
        //filterable: true, // Se puede Filtrar
        sortable: true, // Se puede ordenar
        scrollable: true,
        columns: [ // Columnas a Listar
            {field: "FECHA_EMBARQUE_ACORDADA",title: "Delivery Date",minResizableWidth: 40,width: 40,filterable: {multi: true}},
            {field: "COD_PUERTO",title: "Port or Delivery",minResizableWidth: 110,width: 110, editor: PortDeliveryDropDownEditor},
            {field: "PROFORMA",title: "Vendor PI N°",minResizableWidth: 90,width: 90, editable: function (dataItem) {
                                                                                            return dataItem.COD_PUERTO.length > 0;
                                                                                        }},
            {field: "DEP_DEPTO",title: "Depto",minResizableWidth: 35,width: 35,filterable: {multi: true}},
            {field: "DES_ESTILO",title: "Style Name",minResizableWidth: 150,width: 150,filterable: {multi: true}},
            {field: "COD_MOD_PAIS",title: "Country",minResizableWidth: 50,width: 50,filterable: {multi: true}},
            {field: "NOM_MARCA",title: "Brand",minResizableWidth: 90,width: 90,filterable: {multi: true}},
            {field: "NOM_LINEA",title: "Line",minResizableWidth: 90,width: 90,filterable: {multi: true}},
            {field: "COSTO_INSP",title: "Inspection",minResizableWidth: 50,width: 50,filterable: {multi: true}},
            {field: "UNIDADES",title: "Qtty",minResizableWidth: 30,width: 30,filterable: {multi: true}},
            {field: "COSTO_FOB",title: "Final Price",minResizableWidth: 50,width: 50,filterable: {multi: true}},
            {field: "COSTO_TOT",title: "Total Amount",minResizableWidth: 30,width: 30,filterable: {multi: true}},
            {field: "MTR_PACK",title: "Master Pack",minResizableWidth: 30,width: 30,filterable: {multi: true}},
            {field: "CANT_INNER",title: "# of Cartons",minResizableWidth: 35,width: 35,filterable: {multi: true}}


        ],
        saveChanges: function(e) {
            if (!confirm("Are you sure you want to save all changes?")) {
                e.preventDefault();
            }
        },
        save: function(e) {

            if(e.values.PROFORMA){

                var items = this.dataSource.data();
                //console.log(items);
                for(var i = 0; i < items.length; i++) {

                    if ( (items[i].PROFORMA == e.values.PROFORMA) && ((items[i].FECHA_EMBARQUE_ACORDADA != e.model.FECHA_EMBARQUE_ACORDADA) || (items[i].COD_PUERTO != e.model.COD_PUERTO)) ) {

                        e.preventDefault();
                        //items[i].set("PROFORMA", "");
                        e.model.dirty = true;

                        popupNotification.getNotifications().parent().remove();
                        popupNotification.show(" Vendor PI Number, assigned to another Date and Port.", "error");

                        //this.refresh();

                    }



                }



            }else{
                console.log("Modifica Puerto Embarque");
            }


            /*var items = this.dataSource.data();
            for(var i = 0; i < items.length; i++) {
                items[i].set("Common", 100);
            }
            this.refresh();*/

            //console.log('Proforma: '+e.values.PROFORMA+' Puerto:'+e.model.COD_PUERTO);

            //console.log(e.model);

            /*var gridRows = this.tbody.find("tr");
            gridRows.each(function(e){

                // var duedate = $(this).find(".duedate");

                console.log('Proforma: '+e.values.PROFORMA+' Puerto:'+e.values.COD_PUERTO);


            });*/


            // var grid = $("#grid").getKendoGrid();
            // var firstGridItems = grid.dataSource.data();
            /*var currentGridItems = e.sender.dataSource.data();
            currentGridItems.forEach(function(el){

                // console.log('Puerto'+el.COD_PUERTO+' Proforma:'+el.PROFORMA);

                // Si al momento de realizar un cambio me llega la PI y el Puerto de Embarque
                if( (el.PROFORMA != null) && (el.COD_PUERTO != null)){
                    e.preventDefault();
                    console.log('Llega consola y Puerto');

                    // Revisar que la combinación Fecha Embarque + Puerto de Embarque de todas las otras celdas sea igual

                }else if( (el.PROFORMA != null) && (el.COD_PUERTO == null) ){
                    e.preventDefault();
                    console.log('Llega Proforma no Puerto');

                }

                //console.log(el.COD_PUERTO);

                //console.log(el.ID);
                //firstGridItems.forEach(function(el2){
                    //if(el2.id == el.id){ //'id' is the field that you could check for equality
                        //$("[data-uid='"+el.uid+"']").css("background", "#aaa");
                    //}
                //})


            })*/

            //console.log(e);

            /*var gridRows = this.tbody.find("tr");
            gridRows.each(function(e){
                // var duedate = $(this).find(".duedate");
                // custom logic
                // console.log(e);
            });*/

            /*if (e.values.name !== "") {
                // the user changed the COD_PUERTO field
                if (e.values.name !== e.model.name) {
                    console.log("COD_PUERTO is modified");
                    alert("COD_PUERTO is modified");
                }
            } else {
                e.preventDefault();
                console.log("COD_PUERTO cannot be empty");
                alert("COD_PUERTO cannot be empty");
            }*/


        }/*,
        change: seleccionaOpcion*/ // solo si estamos utilizando un checkbox en la primera columna, quitar si no se utiliza

    });

    // BTN Custom, quitar si no se utiliza
    /*$(".k-grid-custombutton_nombre_propio").click(function(e){
        // Acción
    });*/




// Fin del document ready
});
