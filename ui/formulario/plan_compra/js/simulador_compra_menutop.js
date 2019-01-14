$(document).ready(function() {

    // BTN Volver a C1
    function volver_atras_c1(e) {

        localStorage.clear();

        $("#spreadsheet").data("kendoSpreadsheet").destroy();
        $("#spreadsheet").empty();
        $("#spreadsheet").remove();

        //kendoConsole.log(e.target.text() + " 'Se presionó el BTN."+ e.id);

        /*var url_eliminar_concurrencia = 'permiso_usuario/eliminar_concurrencia';
        var span_temp_eli_conc = $('#span_temporada').text();
        span_temp_eli_conc = span_temp_eli_conc.replace(/[^a-z0-9\-]/gi,'');
        var separa_tempo = span_temp_eli_conc.split("-");

        var depto_salir_volver_main = separa_tempo[1];

        $.getJSON(url_eliminar_concurrencia,{DEPTO:depto_salir_volver_main}).done(function (data) {*/
        window.location.href = "inicio";
        //});

    }

    // BTN salir C1
    function salir_c1(e) {

        localStorage.clear();

        $("#spreadsheet").data("kendoSpreadsheet").destroy();
        $("#spreadsheet").empty();
        $("#spreadsheet").remove();

        /*var url_eliminar_concurrencia = 'permiso_usuario/eliminar_concurrencia';
        var span_temp_eli_conc = $('#span_temporada').text();
        span_temp_eli_conc = span_temp_eli_conc.replace(/[^a-z0-9\-]/gi,'');
        var separa_tempo = span_temp_eli_conc.split("-");

        var depto_salir_volver_main = separa_tempo[1];

        $.getJSON(url_eliminar_concurrencia,{DEPTO:depto_salir_volver_main}).done(function (data) {*/
            window.location.href = "salir";
       //});


    }

    // BTN Cambiar Clave
    function cambiaclave_c1(e) {

        alert("Cambiar Clave");


    }

    // BTN GuardarCambiosBTN
    function GuardarCambiosBTN(e) {

        var popupNotificationBTN = $("#popupNotification").kendoNotification().data("kendoNotification");

        // Verificar Permisos ()
        if(localStorage.getItem("T0001")){

            if( (localStorage.getItem("M-TIENDA")==0) || (localStorage.getItem("P-COSTO")==0) || (localStorage.getItem("P-RETAIL")==0) || (localStorage.getItem("P-EMBARQUE")!=9)){
                popupNotificationBTN.getNotifications().parent().remove();
                popupNotificationBTN.show(" Necesita Configurar Tiendas y/o Presupuestos.", "error");
            }else{
                $("#tb_guardar_cambios").addClass("k-state-disabled");
                $("#tb_cancelar_cambios").addClass("k-state-disabled");
                // $("#tb_guardar_cambios").removeClass("k-state-disabled");
                // $("#tb_cancelar_cambios").removeClass("k-state-disabled");


                var spreadsheet_validar = $("#spreadsheet").data("kendoSpreadsheet");
                var sheet_validar = spreadsheet_validar.sheetByIndex(0);
                var data_validar = sheet_validar.toJSON();
                var count_validar = data_validar.rows.length;
                count_validar = count_validar+1;
                /*var range_estados = sheet_validar.range("BK2:BM"+count_validar);
                range_estados.forEachCell(function (row, column, value) {
                    //console.log("Row: "+row+" Column: "+column+" Value: "+value);
                    //console.log(value.value);
                    var cel = sheet_validar.range("BJ"+row+":BM"+count_validar).value();
                    var res = cel.toString().replace(",", ".");
                    sheet_validar.range("BJ"+row+":BM"+count_validar).value(res);
                });*/

                var range_estados = sheet_validar.range("BJ2:BJ"+count_validar);
                range_estados.forEachCell(function (row, column, value) {

                    var cel = sheet_validar.range("BJ"+row).value();
                    var res = cel.toString().replace(",", ".");
                    sheet_validar.range("BJ"+row).value(res);

                    var celBK = sheet_validar.range("BK"+row).value();
                    var resBK = celBK.toString().replace(",", ".");
                    sheet_validar.range("BK"+row).value(resBK);

                    var celBL = sheet_validar.range("BL"+row).value();
                    var resBL = celBL.toString().replace(",", ".");
                    sheet_validar.range("BL"+row).value(resBL);

                    var celBM = sheet_validar.range("BM"+row).value();
                    var resBM = celBM.toString().replace(",", ".");
                    sheet_validar.range("BM"+row).value(resBM);


                });


                var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                var sheet = spreadsheet.activeSheet();
                sheet.dataSource.sync();

            }

        }else{
            popupNotificationBTN.getNotifications().parent().remove();
            popupNotificationBTN.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
        }



    }

    // BTN CancelarCambiosBTN
    function CancelarCambiosBTN(e) {

        var popupNotificationBTN = $("#popupNotification").kendoNotification().data("kendoNotification");

        // Verificar Permisos ()
        if(localStorage.getItem("T0001")){

            if( (localStorage.getItem("M-TIENDA")==0) || (localStorage.getItem("P-COSTO")==0) || (localStorage.getItem("P-RETAIL")==0) || (localStorage.getItem("P-EMBARQUE")!=9)){
                popupNotificationBTN.getNotifications().parent().remove();
                popupNotificationBTN.show(" Necesita Configurar Tiendas y/o Presupuestos.", "error");
            }else{
                var spreadsheet = $("#spreadsheet").data("kendoSpreadsheet");
                var sheet = spreadsheet.activeSheet();
                sheet.dataSource.cancelChanges();
            }

        }else{
            popupNotificationBTN.getNotifications().parent().remove();
            popupNotificationBTN.show(" No tiene permisos para realizar esta acción.", "error");
            // Fin Verificar Permisos
        }



    }

    var barra_base_titulo = $("#span_data_temp_depto").text();
    var string_base_titulo = barra_base_titulo.split(" - ");
    var menu_tilulo_raw = string_base_titulo[1];
        menu_tilulo_raw = menu_tilulo_raw.split("-");
    var menu_tilulo = menu_tilulo_raw[0]+" - "+menu_tilulo_raw[1];

    // Barra de menú superior del plan de compra
    $("#toolbar_plan_compra").kendoToolBar({
        items: [
            {
                type: "button",
                text: "Volver",
                id: "volver_atras_c1",
                click: volver_atras_c1
            },
            { type: "separator" },
            {
                type: "button",
                text: "Guardar Cambios",
                id: "tb_guardar_cambios",
                overflow: "never",
                click: GuardarCambiosBTN
            },
            {
                type: "button",
                text: "Cancelar Cambios",
                id: "tb_cancelar_cambios",
                overflow: "never",
                click: CancelarCambiosBTN
            },
            { type: "separator" },
            { template: "<label id='label_cabecera_menu' style='font-weight: bold;text-align: right;'>"+menu_tilulo+"</label>" },
            /*{
                type: "button",
                text: "Cambiar Clave",
                id: "cambiaclave_c1",
                click: cambiaclave_c1,
                overflow: "always"
            },*/
            {
                type: "button",
                text: "Salir",
                id: "salir_c1",
                click: salir_c1,
                overflow: "always"
            }
        ]
    });


// Fin del JS
});
