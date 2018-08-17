/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author Roberto Pérez (28-03-2018)
 */

// Asignar variable para saber cuantas filas tiene la tabla
var cant_fila_tabla_curva = 0;
var cant_vacio_tabla_curva = 0;
var quitar_fila_tabla_curva = 0;

$(window).on('load', function () {

    //alert("¡RECUERDA!\n- Sin presionar el botón guardar, no se almacenan los cambios realizados.");

    // $('.tipo_btn_curva').attr('disabled', 'disabled');

    $('.titulo_mantenedor_curva').empty();
    $('.titulo_mantenedor_curva').append("Curva de Reparto");

// traer los datos en el formato siguiente


// Los datos que me llegan de la Tabla
    var data = [
        ['B-C-D', 1, 1, 1, 1, 1, 'REGUGAL', 'S,M,L,XL,XXL', '1,2,1,2,1', 1, 2, 2, 1],
        ['B-C-D', 2, 2, 2, 2, 2, 'REGUGAL', 'S,M,L,XL,XXL', '1,2,1,2,1', 1, 2, 2, 2],
        ['B-C-D', 3, 3, 3, 3, 3, 'REGUGAL', 'S,M,L,XL,XXL', '1,2,1,2,1', 1, 2, 2, 3],
        ['B-C-D', 3, 3, 3, 3, 3, 'REGUGAL', 'S,M,L,XL,XXL', '1,2,1,2,1', 1, 2, 2, 4]
    ];


    $('#tabla_curva').jexcel({

        data: data,
        colHeaders: ['G. Compra', 'Línea', 'SubLínea', 'Marca', 'Rank. Vta', 'Ciclo de Vida', 'T. Producto', 'Tallas', 'C. Reparto', 'A', 'B', 'C', 'I', 'Eliminar'],
        minDimensions: [13, 1],
        colWidths: [70, 110, 90, 90, 110, 100, 80, 80, 70, 22, 22, 22, 22],
        // Cargo la estructura base de los CBX
        columns: [
            // G. Compra
            {type: 'text', wordWrap: false},
            // Linea
            {
                type: 'dropdown', source: [
                    {'id': '1', 'name': 'Accesorios Playa'},
                    {'id': '2', 'name': 'Linea 2'},
                    {'id': '3', 'name': 'Linea 3'},
                ], wordWrap: false
            },
            // SubLInea
            {
                type: 'dropdown', source: [
                    {'id': '1', 'name': 'Manga Larga'},
                    {'id': '2', 'name': 'SubLinea 2'},
                    {'id': '3', 'name': 'SubLinea 3'},
                ], wordWrap: false
            },
            // Marca
            {
                type: 'dropdown', source: [
                    {'id': '1', 'name': 'Marca 1'},
                    {'id': '2', 'name': 'Marca 2'},
                    {'id': '3', 'name': 'Marca 3'},
                ], wordWrap: false
            },
            // Rank. Vta
            {
                type: 'dropdown', source: [
                    {'id': '1', 'name': 'Normal Seller 1'},
                    {'id': '2', 'name': 'Normal Seller 2'},
                    {'id': '3', 'name': 'Normal Seller 3'},
                ], wordWrap: false
            },
            // Ciclo de Vida
            {
                type: 'dropdown', source: [
                    {'id': '1', 'name': 'Long Term 1'},
                    {'id': '2', 'name': 'Long Term 2'},
                    {'id': '3', 'name': 'Long Term 3'},
                ], wordWrap: false
            },
            // T. Producto
            {type: 'text', readOnly: true},
            // Tallas
            {type: 'text', wordWrap: false},
            // C. Reparto
            {type: 'text', wordWrap: false},
            // A
            {type: 'text', wordWrap: false},
            // B
            {type: 'text', wordWrap: false},
            // C
            {type: 'text', wordWrap: false},
            // I
            {type: 'text', wordWrap: false},
            // Quitar
            {type: 'checkbox', wordWrap: false},
        ],


    });// Fin funcion carga tabla


// Cambio el tamaño del font de la tabla
    $('.jexcel').css("font-size", "11px");


// Para quitar una línea hay que agregar una "x" en la primera columna

    $('#tabla_curva').jexcel('updateSettings', {
        cells: function (cell, col, row) {

            //Construir un string con los valores y ver si se repite


            if (col == 13) {
                $('#tabla_curva').find('input[type="checkbox"]:checked').each(function () {
                    var id = $(this).closest('td').attr('id');
                    var id_fila = id.split('-');
                    //alert(id_fila[1]);
                    $('#tabla_curva').jexcel('deleteRow', id_fila[1]);
                });
            }


            // Se hace revisión por fila
            /*     if (col == 0) {

                     var val = $('#tabla_curva').jexcel('getValue', $(cell));

                     // Si el valor de la celda "n" de la fila "n" es una "x" lo quitamos.
                     if (val == 'x') {
                         // Lo quita de inmediato... preguntar?
                         $('#tabla_curva').jexcel('deleteRow', row);
                     }


                     // Contar los campos extras que pueden existir para descontarlos luego
                     if ((val == null) || (val == "")) {
                         cant_vacio_tabla_curva = cant_vacio_tabla_curva+1;
                     }


                     // Incrementar el contador de filas de la tabla
                     cant_fila_tabla_curva = cant_fila_tabla_curva + 1;


                     // Asignar valores a los hidden, para utilizarlos luego.
                     $('#hidden_filas_con_registro').val(cant_fila_tabla_curva);
                     $('#hidden_filas_sin_registro').val(cant_vacio_tabla_curva);


                 }*/


            // alert("Columna: "+ col +" Fila: "+ row +" Celda: "+$('#tabla_curva').jexcel('getValue', $(cell)));


        }
    });


    $('table.jexcel input[type=checkbox]').attr('disabled', true);


// Fin del OnLoad
});

// Almacena los datos de la tabla en la BD
$('.tipo_btn_curva').click(function () {


    // Verificar que cada columna existente tenga todos los datos requeridos al momento de enviar.
    // 1.- Al presionar el botón de guardar, si la primera celda se encuentra vacia quitar la fila completa id="tr-x" donde "x" corresponde al id.


    // Obtener la cantidad de <tr> que tiene la tabla
    var rowCount = $('.jexcel tr').length;
    // Quitamos una unidad ya que el código cuenta el <tr> de la cabecera
    rowCount = (rowCount-1); // Eata variable almacenó la cantidad de <tr> de la tabla
    alert (rowCount);






     // Quitar Ejemplo
    // Sirve si tienes campos del tipo input
    //Este archivo tiene que estr ahi
    /*$(".jexcel tr.item").each(function() {
        var G_COMPRA = $(this).find("input.G_COMPRA").val();
        alert(G_COMPRA);
    });*/





    // 2.- Verificar que no existan duplicados
    /*
    var check_duplicados = $.fn.verificaDuplicados();

    if (check_duplicados == true) {
        alert("Existen registros duplicados!\n  - Favor corregir antes de proceder al guardado.");
    } else {
        alert("Proceder con el guardado.");
    }
    */


// Fin del guardar
});


// Descarga la tabla en formato excel.
$('#download_linea_curva').on('click', function () {
    $('#tabla_curva').jexcel('download');
});


// Agregar una nueva tabla a  bajo de las existentes.
$('#agrega_nueva_linea_curva').on('click', function () {

    cant_fila_tabla_curva = 0;
    cant_vacio_tabla_curva = 0;

    $('#tabla_curva').jexcel('insertRow', 1);

    // Dejarlas nuevamente como readonly (De lo contrario los checkbox bloqueados en el load se desabilitan)
    $('table.jexcel input[type=checkbox]').attr('disabled', true);

});


// Activar el quitar línea por selección.
$('#quitar_nueva_linea_curva').on('click', function () {

    // Definir la variable que contiene el texto del mensaje de confirmación
    var texto_confirm = "";

    // Definir texto del confirm seg{un estado del botón
    if (quitar_fila_tabla_curva == 0) {
        texto_confirm = "¡ATENCION! - ¿Habilitar Eliminar por Selección?";
    } else {
        texto_confirm = "¿Bloquear Eliminar por Selección?";
    }

    // Proceder con la confirmación
    var resp_confirm = confirm(texto_confirm);
    if (resp_confirm == true) {

        //Se cambia nombre del botón y estado de este
        if (quitar_fila_tabla_curva == 0) {
            $('table.jexcel input[type=checkbox]').attr('disabled', false);
            $("#quitar_nueva_linea_curva").html('Bloquear Eliminar Filas');
            quitar_fila_tabla_curva = 1;
        } else {
            $('table.jexcel input[type=checkbox]').attr('disabled', true);
            $("#quitar_nueva_linea_curva").html('Habilitar Eliminación');
            quitar_fila_tabla_curva = 0;
        }

    } else {
        alert("No se han realizado cambios.");
    }


});


//  Verificar que no existan duplicados en la tabla.
$.fn.verificaDuplicados = function () {
// Solo se puede utilizar, si la tabla tiene ID... de ese modo se pueden leer las filas y columnas
    // Le asigno un ID a la tabla para poder trabajar con ella, y leer sus filas y columnas
    $('.jexcel').attr('id', 'jexcel');

    var table = document.getElementById("jexcel");

    var tableArr = [];

    for (var i = 1; i < table.rows.length; i++) {
        tableArr.push({
            ID: table.rows[i].cells[0].innerHTML,
            G_COMPRA: table.rows[i].cells[1].innerHTML,
            LINEA: table.rows[i].cells[2].innerHTML,
            SUB_LINEA: table.rows[i].cells[3].innerHTML,
            MARCA: table.rows[i].cells[4].innerHTML,
            RNK_VTA: table.rows[i].cells[5].innerHTML,
            CICLO_VIDA: table.rows[i].cells[6].innerHTML,
            TALLAS: table.rows[i].cells[8].innerHTML
        });
    }

    function checkDuplicateInObject(propertyName, inputArray) {
        var seenDuplicate = false,
            testObject = {};

        inputArray.map(function (item) {
            var itemPropertyName = item[propertyName];
            if (itemPropertyName in testObject) {
                testObject[itemPropertyName].duplicate = true;
                item.duplicate = true;
                seenDuplicate = true;
            }
            else {
                testObject[itemPropertyName] = item;
                delete item.duplicate;
            }
        });
        return seenDuplicate;
    }

    // Desplegar en consola
    //console.log(tableArr);
    //console.log('Duplicate G_COMPRA: ' + checkDuplicateInObject('G_COMPRA', tableArr));


    // Determinar el largo del objeto
    //alert(Object.keys(tableArr).length);


    // Hay que comparar los campos en el objeto, para que las "Filas no se repitan"
    // Probar armando un string a comparar

    /*for (i in tableArr) {
        console.log(tableArr[i]);
    }*/


    var valueArr = tableArr.map(function (item) {
        return item.G_COMPRA + item.LINEA + item.SUB_LINEA + item.MARCA + item.RNK_VTA + item.CICLO_VIDA + item.TALLAS
    });
    var isDuplicate = valueArr.some(function (item, idx) {
        return valueArr.indexOf(item) != idx
    });

    //console.log(isDuplicate);
    return isDuplicate;

};
