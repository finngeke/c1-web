/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 * @Editado Roberto Pérez (tienda, formato, curva)
 */

$(function () {

    /*ABRE POPUP MODAL PERFIL*/
    $('.eliminar_bmt').on('click', function () {
        $('.registro').html('<b> ' + $('.bmt').html() + ' </b>');
    });

    $('.actualiza_grid').on('click', function () {
        location.reload();
    });

    $('.carga_bmt').on('click', function () {

        /*if ($('.file').val() == '') {
            alert('Debe Ingresar el archivo BMT.');
            return false;
        } else {*/
            $('.loading').fadeIn();
            $('.pull-left').remove();
            $('.carga_bmt').remove();
            $('.close').remove();
            $('.form_import_bmt').submit();
        //}

    });

});


$(document).ready(function () {

    $('#hot-display-license-info').remove();
    $('#hot-display-license-info').remove();

});

/*
 * $('.loading').fadeIn();
 // $(this).prop('href', 'lista_master_pack?division=' + $('#SELECT').find('option:selected').val());
 $('.simulador').remove();
 $('.cambia').remove();
 */


$(window).on('load', function () {

    $('.eliminar_bmt').tooltip();
    $('.actualiza_grid').tooltip();
    $('.importar_bmt').tooltip();


    $('.tipo_tienda').on('click', function () {
        $('#selecciona_popup').modal('show');
    });


    $('.tipo_formato').on('click', function () {
        $('#selecciona_popup_formato').modal('show');
    });


    $('.tipo_ventana_llegada').on('click', function () {
        $('#selecciona_popup_ventana_llegada').modal('show');
    });


    $('.tipo_ppto_costo').on('click', function () {
        $('#selecciona_popup_ppto_costo').modal('show');
    });


    $('.tipo_ppto_retail').on('click', function () {
        $('#selecciona_popup_ppto_retail').modal('show');
    });







// Trabajo con la segunda grilla
// Los datos que me llegan de la Tabla


    var data = [
        ['B-C-D', 1, '007008', 1, 1, 1, 1, 1, 1, 1, 2, 2, 1],
        ['B-C-D', 1, '005014', 1, 1, 1, 1, 1, 1, 1, 2, 2, 1],
        ['B-C-D', 1, '009002', 1, 1, 1, 1, 1, 1, 1, 2, 2, 1],
        ['B-C-D', 1, '500094', 1, 1, 1, 1, 1, 1, 1, 2, 2, 1]
    ];


    $('#tabla_grilla2').jexcel({
        data: data,
        colHeaders: ['G. Compra', 'Temp', 'Línea', 'SubLínea', 'Marca', 'Estilo', 'Cod. Corp', 'Descrip.', 'Descrip. Internet', 'Composición', 'Colección',
                     'Evento', 'Estilo Vida', 'Calidad', 'Ocación Uso', 'Piramide Mix', 'Ventana', 'Rank Vta', 'Ciclo Vida', 'Color','Hist', 'Tipo Producto',
                     'Tipo Exhibición', 'Tallas', '% Compra Ini', '% Compra Ajust', '% Ajust', 'Curva', 'Curva Min', 'Uni Ini', 'Uni Ajust', 'Uni Final', 'MtrPack',
                     'Nº Cajas', 'Cluster', 'Formato', 'Tdas', 'A', 'B', 'C', 'I', 'Primera Carga', '% Tiendas', 'Proced', 'Vía', 'País', 'Viaje', 'Mkup', 'Precio Blanco',
                     'GM', 'Moneda', 'Target', 'FOB', 'Insp', 'RFID', 'Royalty (%)', 'Costo Unitarios Final US$', 'Costo Unitario Final Pesos', 'Total Target US$',
                     'Total FOB US$', 'Costo Total Pesos', 'Total Retail Pesos (Sin IVA)', 'Debut/Reorder', 'Sem Ini', 'Sem Fin', 'Semanas Ciclo Vida', 'Agot Obj',
                     'Semanas Liquidación', 'Proveedor', 'Razon Social', 'Trader', 'Cod. SKU Proveedor', 'Cod. Padre', 'Proforma', 'Archivo', 'Estilo PPM', 'Estado Match',
                     'Nº OC', 'Estado OC', 'Fecha Embarque', 'Fecha ETA', 'Fecha Recepción CD', 'Días Atraso CD', 'Estado Opción'],
        //minDimensions: [13, 1],
        tableOverflow:true,
        colWidths: [90, 90, 180, 90, 110, 100, 80, 80, 70, 22, 22, 22, 22],
        // Cargo la estructura base de los CBX
        columns: [
            // T. Producto
            //{type: 'text', readOnly: true},
            // Grupo Compra
            {type: 'text', wordWrap: false},
            // Temp
            {
                type: 'dropdown', source: [
                    {'id': '1', 'name': 'Linea 1'},
                    {'id': '2', 'name': 'Linea 2'}
                ], wordWrap: false
            },
            // Línea
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsLinea',wordWrap: false},
            // SubLínea
            {type: 'text', wordWrap: false},
            // Marca
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsMarca', wordWrap: false},
            // Estilo
            {type: 'text', wordWrap: false},
            // Cod. Corp
            {type: 'text', wordWrap: false},
            // Descrip.
            {type: 'text', wordWrap: false},
            // Descrip. Internet
            {type: 'text', wordWrap: false},
            // Composición
            {type: 'text', wordWrap: false},
            // Colección
            {type: 'text', wordWrap: false},
            // Evento
            {type: 'text', wordWrap: false},
            // Estilo Vida
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsEVida', wordWrap: false},
            // Calidad
            {type: 'text', wordWrap: false},
            // Ocación Uso
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsOcacionUso', wordWrap: false},
            // Piramide Mix
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsPiramideMix', wordWrap: false},
            // Ventana
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsVentanaLlegada', wordWrap: false},
            // Rank Vta
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsRankVenta', wordWrap: false},
            // Ciclo Vida
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsLifeCicle', wordWrap: false},
            // Color
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsColor',  wordWrap: false},
            // Hist
            {type: 'text', wordWrap: false},
            // Tipo Producto
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsTipoProducto', wordWrap: false},
            // Tipo Exhibición
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsTipoExhibicion', wordWrap: false},
            // Tallas
            {type: 'text', wordWrap: false},
            // % Compra Ini
            {type: 'text', wordWrap: false},
            // % Compra Ajust
            {type: 'text', wordWrap: false},
            // % Ajust
            {type: 'text', wordWrap: false},
            // Curva
            {type: 'text', wordWrap: false},
            // Curva Min
            {type: 'text', wordWrap: false},
            // Unid Ini.
            {type: 'text', wordWrap: false},
            // Unid Ajust
            {type: 'text', wordWrap: false},
            // Unid Final
            {type: 'text', wordWrap: false},
            // Mtr Pack
            {type: 'text', wordWrap: false},
            // Nº Cajas
            {type: 'text', wordWrap: false},
            // Cluster
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsCluster', wordWrap: false},
            // Formato
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsFormato', wordWrap: false},
            // Tdas
            {type: 'text', wordWrap: false},
            // A
            {type: 'text', wordWrap: false},
            // B
            {type: 'text', wordWrap: false},
            // C
            {type: 'text', wordWrap: false},
            // I
            {type: 'text', wordWrap: false},
            // Primera Carga
            {type: 'text', wordWrap: false},
            // % Tiendas
            {type: 'text', wordWrap: false},
            // Proced
            {type: 'text', wordWrap: false},
            // Vía
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsVia', wordWrap: false},
            // País
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsPais', wordWrap: false},
            // Viaje
            {type: 'text', wordWrap: false},
            // Mkup
            {type: 'text', wordWrap: false},
            // Precio Blanco
            {type: 'text', wordWrap: false},
            // GM
            {type: 'text', wordWrap: false},
            // Moneda
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsMoneda', wordWrap: false},
            // Target
            {type: 'text', wordWrap: false},
            // FOB
            {type: 'text', wordWrap: false},
            // Insp
            {type: 'text', wordWrap: false},
            // RFID
            {type: 'text', wordWrap: false},
            // Royalty (%)
            {type: 'text', wordWrap: false},
            // Costo Unitario Final US$
            {type: 'text', wordWrap: false},
            // Costo Unitario Final Pesos
            {type: 'text', wordWrap: false},
            // Total Target US$
            {type: 'text', wordWrap: false},
            // Total FOB US$
            {type: 'text', wordWrap: false},
            // Costo Total Pesos
            {type: 'text', wordWrap: false},
            // Total Retail Peoso (Sin IVA)
            {type: 'text', wordWrap: false},
            // Debut/Reorder
            {type: 'text', wordWrap: false},
            // Sem Ini
            {type: 'text', wordWrap: false},
            // Sem Fin
            {type: 'text', wordWrap: false},
            // Semanas Ciclo de Vida
            {type: 'text', wordWrap: false},
            // Agot Obj
            {type: 'text', wordWrap: false},
            // Semanas Liquidación
            {type: 'text', wordWrap: false},
            // Proveedor
            {type: 'dropdown', url: 'ajax_simulador_cbx/listar_optionsProveedor', wordWrap: false},
            // Razon Social
            {type: 'text', wordWrap: false},
            // Trader
            {type: 'text', wordWrap: false},
            // Cod. SKU Proveedor
            {type: 'text', wordWrap: false},
            // Cod. Padre
            {type: 'text', wordWrap: false},
            // Proforma
            {type: 'text', wordWrap: false},
            // Archivo
            {type: 'text', wordWrap: false},
            // Estilo PMM
            {type: 'text', wordWrap: false},
            // Estado Match
            {type: 'text', wordWrap: false},
            // Nº OC
            {type: 'text', wordWrap: false},
            // Estado OC
            {type: 'text', wordWrap: false},
            // Fecha Embarque
            {type: 'text', wordWrap: false},
            // Fecha ETA
            {type: 'text', wordWrap: false},
            // Fecha Recepción CD
            {type: 'text', wordWrap: false},
            // Días Atraso CD
            {type: 'text', wordWrap: false},
            // Estado Opción
            {type: 'text', wordWrap: false}
        ]


    });


    // Cambio el tamaño del font de la tabla
    $('.jexcel').css("font-size", "9px");






});

//carga_bmt






//type: 'dropdown', source:[dropdown], wordWrap: false
/*var dropdown = function () {
       var url_optionsLinea = "ajax_simulador_cbx/listar_optionsLinea";
       var var_optionsLinea = "";
        $.getJSON(url_optionsLinea,function (data) {
            $.each(data, function (i,o) {
                //var_optionsLinea += "'"+o[0]+"':'"+o[1]+"',";
                var_optionsLinea += "{'id': '"+o[0]+"', 'name': '"+o[1]+"'},";
            });
            //var_optionsLinea = var_optionsLinea.slice(0,-1);
            //return "["+var_optionsLinea+"]";
            return var_optionsLinea;
            //return "[{'id': '1', 'name': 'qqq'}]";
            //alert(var_optionsLinea);
        });


    var person = {id:1, name:"Doe"};

       return person;

    }();

console.log(dropdown);
*/