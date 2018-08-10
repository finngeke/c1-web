/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author Roberto Pérez (21-05-2018)
 */

$(window).on('load', function () {

   $('.titulo_mantenedor_deptomarca').empty();
   $('.titulo_mantenedor_deptomarca').append("Agregar Marcas");

    // PreCargar CBX
    /*cargaCBXdivision();

    // Delay de 1 segundo para que cargue (Local en 1 funciona perfecto)
    var delay = 1000;
    setTimeout(function () {
        cargaCBXdepto();
    }, delay);

    // Delay de 1 segundo para que cargue (En local en 2 funciona perfecto)
    var delay = 2000;
    setTimeout(function () {
        cargaCBXmarca(1); // Por Defecto C1
    }, delay);*/

    cargaCBXdeptomarca();


// Fin del onload
});

// Al cambiar el estado del radiobuton
$("input[name=deptomarca_radio]:radio").on('change',function() {

        var selected_value= "";

        if ($("#deptomarca_radio").attr("checked")) {
            selected_value = $("input[name='deptomarca_radio']:checked").val();
        }else {
            selected_value = $("input[name='deptomarca_radio']:checked").val();
        }

        // Cargar CBX de Marca
        cargaCBXmarca(selected_value);

});

// Cargar CBX de marca (Cuando cambia radio button)
function cargaCBXmarca(tipo) {

    var division = $('#deptomarca_division').val();
    var depto    = $('#deptomarca_depto').val();

    // si no llega tipo, hay que ir a buscar el seleccionado y enviar su valor
    if(tipo==0){
        tipo = $("input[name='deptomarca_radio']:checked").val();
    }

    // Cargar CBX de Marca
    $('#deptomarca_marca').empty();
    var url_carga_marca = 'ajax_simulador_deptomarca/obtiene_marca';
    var toAppend_marca = "";
    $.getJSON(url_carga_marca,{DIVISION:division,DEPTO:depto,TIPO:tipo},function (data) {
        $.each(data, function (i,o) {
            if(o[0]!=null) {
                toAppend_marca += "<option value=" + o[0] + ">" + o[1] + "</option>";
            }
        });
        $('#deptomarca_marca').append(toAppend_marca);
    }).done( function( data ) {
        conteoMarcasCantidad();
    });




}

// Carga los 3 CBX, considerando si está marcado C1/PMM
function cargaCBXdeptomarca() {
    // Cargar CBX de Division
    $('#deptomarca_division').empty();
    var url_carga_division = 'ajax_simulador_deptomarca/obtiene_division';
    var toAppend_division = "";
    $.getJSON(url_carga_division,function (data) {
        $.each(data, function (i,o) {
            if(o[0]!=null) {
                toAppend_division += '<option value=' + o[0] + '>' + o[1] + '</option>';
            }
        });
        $('#deptomarca_division').append(toAppend_division);
    }).done( function( data ) {

        // ##################### DEPTO #####################

        // Llega con 1 segundo de retraso
        var division = $('#deptomarca_division').val();

        // Cargar CBX de Depto
        $('#deptomarca_depto').empty();
        var url_carga_depto = 'ajax_simulador_deptomarca/obtiene_depto';
        var toAppend_depto = "";
        $.getJSON(url_carga_depto,{DIVISION:division},function (data) {
            $.each(data, function (i,o) {
                if(o[0]!=null) {
                    toAppend_depto += '<option value=' + o[0] + '>' + o[0] + ' - ' + o[1] + '</option>';
                }
            });
            $('#deptomarca_depto').append(toAppend_depto);
        }).done( function( data ) {

            // ##################### MARCA #####################
            var division = $('#deptomarca_division').val();
            var depto = $('#deptomarca_depto').val();
            var tipo = $("input[name='deptomarca_radio']:checked").val();

            // si no llega tipo, hay que ir a buscar el seleccionado y enviar su valor
            if(tipo==0){
                tipo = $("input[name='deptomarca_radio']:checked").val();
            }

            // Cargar CBX de Marca
            $('#deptomarca_marca').empty();
            var url_carga_marca = 'ajax_simulador_deptomarca/obtiene_marca';
            var toAppend_marca = "";
            $.getJSON(url_carga_marca,{DIVISION:division,DEPTO:depto,TIPO:tipo},function (data) {
                $.each(data, function (i,o) {
                    if(o[0]!=null) {
                        toAppend_marca += "<option value=" + o[0] + ">" + o[1] + "</option>";
                    }
                });
                $('#deptomarca_marca').append(toAppend_marca);
            }).done( function( data ) {
                conteoMarcasCantidad();
            });

        });

    });

}

// Cargar CBX de depto
function cargaCBXdepto() {

    // Llega con 1 segundo de retraso
    var division = $('#deptomarca_division').val();

    // Cargar CBX de Depto
    $('#deptomarca_depto').empty();
    var url_carga_depto = 'ajax_simulador_deptomarca/obtiene_depto';
    var toAppend_depto = "";
    $.getJSON(url_carga_depto,{DIVISION:division},function (data) {
        $.each(data, function (i,o) {
            if(o[0]!=null) {
                toAppend_depto += '<option value=' + o[0] + '>' + o[0] + ' - ' + o[1] + '</option>';
            }
        });
        $('#deptomarca_depto').append(toAppend_depto);
    }).done( function( data ) {
        // Cargar CBX Marca

        var selected_value = $("input[name='deptomarca_radio']:checked").val();

        // Cargar CBX de Marca
        cargaCBXmarca(selected_value);

    });

}


// Agregar
$('#deptomarca_agregar').on('click', function () {

    var respuesta = confirm("¿Agregar Marca Seleccionada?");
    if (respuesta == true) {

        var division = $('#deptomarca_division').val();
        var nom_division = $('#deptomarca_division option:selected').text();
        nom_division = nom_division.replace(/[^a-z0-9]/gi,'');
        var depto = $('#deptomarca_depto').val();
        var nom_depto_full = $('#deptomarca_depto option:selected').text();
        var nom_depto = nom_depto_full.split(' - ');
        nom_depto = nom_depto[1].replace(/[^a-z0-9]/gi,'');
        var marca = $('#deptomarca_marca').val();
        var nom_marca = $('#deptomarca_marca option:selected').text();
        nom_marca = nom_marca.replace(/[^a-z0-9]/gi,'');

        if( (division!="") && (depto!="") && (marca!="") ){
            var url_agrega_marca = 'ajax_simulador_deptomarca/agrega_marca';
            $.getJSON(url_agrega_marca,{DIVISION:division,NOM_DIVISION:nom_division,DEPTO:depto,NOM_DEPTO:nom_depto,MARCA:marca,NOM_MARCA:nom_marca}).done( function() {
                alert("La marca seleccionada fue agregada, favor revisar.");
            }).fail( function( reason ) {
                // Handles errors only
                console.debug( reason );
            } );

        }else{
            alert("No se puede guardar, faltan campos.");
        }

    } else {
        alert("No se han realizado cambios.");
    }




});

// Quitar
$('#deptomarca_quitar').on('click', function () {

    var respuesta = confirm("¿Quitar Marca Seleccionada?");
    if (respuesta == true) {

        var division = $('#deptomarca_division').val();
        var depto = $('#deptomarca_depto').val();
        var marca = $('#deptomarca_marca').val();

        var url_quitar_marca = 'ajax_simulador_deptomarca/quitar_marca';
        $.getJSON(url_quitar_marca,{DIVISION:division,DEPTO:depto,MARCA:marca}).done( function() {
            alert("La marca seleccionada fue eliminada, favor revisar.");
        });

    } else {
        alert("No se han realizado cambios.");
    }




});

// Contar los elementos que existen
function conteoMarcasCantidad(){

    // Contar cantidad de elementos en el campo MARCA
    if ($('#deptomarca_marca option').length == 0) {
        // Bloquear el botón de agregar cuando encuentre elementos
        $("#deptomarca_agregar").attr("disabled", "disabled");
        $("#deptomarca_quitar").attr("disabled", "disabled");

        // Le ASIGNA un valor a un ELEMENTO
        $('#depto_marca_sinmarca_span').html('Departamento Sin Marca.');

    } else {
        // Habilitar el botón de agregar cuando encuentre elementos
        $("#deptomarca_agregar").attr("disabled", false);
        $("#deptomarca_quitar").attr("disabled", false);

        $('#depto_marca_sinmarca_span').html('');

    }

}

// Cargar CBX de division
function cargaCBXdivision() {
    // Cargar CBX de Division
    $('#deptomarca_division').empty();
    var url_carga_division = 'ajax_simulador_deptomarca/obtiene_division';
    var toAppend_division = "";
    $.getJSON(url_carga_division,function (data) {
        $.each(data, function (i,o) {
            toAppend_division += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('#deptomarca_division').append(toAppend_division);
    });

}
