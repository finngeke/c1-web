$(function () {

    var ventana_lead_time = $("#POPUP_reporteria_embarques");
    ventana_lead_time.kendoWindow({
        width: "750px",
        height: "550px",
        title: "Reporteria de embarques",
        visible: false,
        actions: [
            "Minimize",
            "Maximize",
            "Close"
        ],
        close: salirReporteriaEmbarques
    }).data("kendoWindow").center();

    $(".reporteria_embarques").ready(function(e){
        var popupLeadTime = $("#POPUP_reporteria_embarques");
        popupLeadTime.data("kendoWindow").open();

        var bDescDistribucion = $("#textButton").kendoButton({
            click: descargarDistribucionEmbarques
        });
        var grid = $("#grid");

    });

    dataSource = new kendo.data.DataSource({
        transport: {
            read:  {
                url: "obtener_embarques_reporteria",
                dataType: "json"
            }
        }
        ,
        schema: {
            model: {
                id: "nroEmbarque",
                fields: {
                        nroEmbarque: {type: "number"}, // number - string - date
                        Estado: {type: "string"}, // number - string - date
                        fechaAprobacion: {type: "string"},    // number - string - date
						fechaEnvio: {type: "string"}    // number - string - date
                    }
            }
        },
        pageSize: 15,
    });


    $("#grid").kendoGrid({
        autoBind: true,
        dataSource: dataSource,
        height: 480, // Altura del Grid
        //groupable: true, // Las columnas se pueden agrupar
        sortable: true, // Se puede ordenar
        pageable: true,
        filterable: true,
        scrollable: false,
        change: onChange,
        columns: [ // Columnas a Listar
            {selectable: true, width: "50px" },
            {field: "nroEmbarque",title: "# Embarque",width: 240},
            {field: "Estado",title: "Estado"},
            {field: "fechaAprobacion",title: "Fecha Aprobado.",width: 150},
			{field: "fechaEnvio",title: "Fecha Bajada Emb.",width: 150}
        ]
    });

    function onChange(arg) {
        $("#numero_embarque_span").text(this.selectedKeyNames().join(",")) ;
        console.log("The selected product ids are: [" + this.selectedKeyNames().join(",") + "]");
    }

    function descargarDistribucionEmbarques(arg) {
        var envia_embarque = $("#numero_embarque_span").text();
        console.log(envia_embarque);

        window.location.href = 'excel_reporte_embarques?envia_embarque='+envia_embarque;
    }
    function salirReporteriaEmbarques() {
        window.location.href = 'reposicion';
    }


});