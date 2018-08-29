/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author Roberto Pérez (29-03-2018)
 */


$(window).on('load', function () {

    if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
        $('.tipo_btn_formatos').attr('disabled', 'disabled');
    }

   // Asigna titulo a popup
   $('.titulo_mantenedor_formato').empty();
   $('.titulo_mantenedor_formato').append("Formatos");
   
// Traspasar items desde select izquierda(desde_tienda) hasta select derecha (hasta_tienda)
$('.agregar').on('click', function() {

    var options = $('select.DISPONIBLE_FORMATO option:selected').sort().clone();
    $('select.ASIGNADO_FORMATO').append(options);
    $('select.DISPONIBLE_FORMATO option:selected').remove();

});

// Traspasar items desde select derecha (hasta_tienda) hasta select izquierda(desde_tienda)
$('.quitar').on('click', function() {

    var options = $('select.ASIGNADO_FORMATO option:selected').sort().clone();
    $('select.DISPONIBLE_FORMATO').append(options);
    $('select.ASIGNADO_FORMATO option:selected').remove();

});

// Fijar los tamaños de los ListBox
$('.ASIGNADO_FORMATO').attr('size', 10);
$('.DISPONIBLE_FORMATO').attr('size', 10);

// Para CBX de Formato,seteo el seleccionar por default (SELECCIONE)
$(".FORMATO").prop('selectedIndex', 0);

// Para los ListBox seteo el primer item como ya seleccionado
// $(".DISPONIBLE").prop('selectedIndex', 0);
// $(".ASIGNADO").prop('selectedIndex', 0);

    // Check del paso por la carga del modulo
    $('#accion_carga_modulo_formatos').removeClass('fa fa-refresh');
    $('#accion_carga_modulo_formatos').addClass('fa fa-check');

});

// Al cambiar el estado del select, hay que realizar la búsqueda de los ListBox 
$('.FORMATO').on('change', function() {
    $.fn.cargarListBox(); 
});

$.fn.cargarListBox = function(){ 
  //alert( this.value );
  
  // Limpiar ListBox
  $('.DISPONIBLE_FORMATO').empty();
  $('.ASIGNADO_FORMATO').empty();
 
  var formato_seleccionado  = $('.FORMATO').val();

if(formato_seleccionado != 'NULL'){

    if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
          // Se habilita el botón guardar
          $('.tipo_btn_formatos').removeAttr('disabled');
    }

    // Carga ListBox de asignados
    var url_asignado = 'ajax_simulador_formato/obtiene_asignado';
    var toAppend_asignado = "";

  $.getJSON(url_asignado, {FORMATO:formato_seleccionado}, function (data) {
      
        $.each(data, function (i,o) {  
            toAppend_asignado += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        
        $('.ASIGNADO_FORMATO').append(toAppend_asignado);
        
   });
  
  
  // Carga ListBox disponible 
  var url_disponible = 'ajax_simulador_formato/obtiene_disponible';
  var toAppend_disponible = "";
  $.getJSON(url_disponible, {FORMATO:formato_seleccionado}, function (data) {

      $.each(data, function (i,o) {
          var data = o.split('#');
          toAppend_disponible +='<option value=' + data[0] + '>' + data[1] + '</option>';
      });

      $('.DISPONIBLE_FORMATO').append(toAppend_disponible);

   });
  
  

// Fin valucacion de CBX en NULL
}else{
    if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
        $('.tipo_btn_formatos').attr('disabled', 'disabled');
    }
}
 
    
  
};

$('.tipo_btn_formatos').on('click', function () {

var r = confirm("¿Guardar Cambios?");

if (r == true) {

    $('#tipo_btn_formatos').fadeOut();
    $('#btn_cerrar_popup_formato').fadeOut();
    $('#cerrar_btn_popup_formato__x').fadeOut();
    $('#modulo_formato_btn_crear_nuevo').fadeOut();
    $('.loading').fadeIn();

    var formato_seleccionado  = $('#FORMATO').val();
    // Quitar los registros (Cuando NO existen registros)
    var url_quitar_noasignados = 'ajax_simulador_formato/quitar_formato_noasignados';
    // Quitar los registros (Cuando existen registros)
    var url_quitar = 'ajax_simulador_formato/quitar_formato';
    // Agregar Registros
    var url_agrega = 'ajax_simulador_formato/agrega_formato';


    if ($('#ASIGNADO_FORMATO option').length == 0) {

        $.get(url_quitar_noasignados, {FORMATO:formato_seleccionado,ASIGNADO: $(this).attr('value')}).done( function( data ) {

            alert("Registros eliminados, favor revisar.");

            $('#tipo_btn_formatos').fadeIn();
            $('#btn_cerrar_popup_formato').fadeIn();//
            $('#cerrar_btn_popup_formato__x').fadeIn();
            $('#modulo_formato_btn_crear_nuevo').fadeIn();
            $('.loading').fadeOut();

        });

    }else{

        $("#ASIGNADO_FORMATO option").each(function(){
            $.get(url_quitar, {FORMATO:formato_seleccionado,ASIGNADO: $(this).attr('value')});
        });

        // Define Tiempo 1 = 1000
        var delay = 5000;
        setTimeout(function () {

            if ($('#ASIGNADO_FORMATO option').length != 0) {
                $("#ASIGNADO_FORMATO option").each(function () {
                    $.get(url_agrega, {FORMATO: formato_seleccionado, ASIGNADO: $(this).attr('value')});
                }).promise().done(function(data){

                    alert("Se han agregado nuevos registros, favor revisar.");

                    $('#tipo_btn_formatos').fadeIn();
                    $('#btn_cerrar_popup_formato').fadeIn();
                    $('#cerrar_btn_popup_formato__x').fadeIn();
                    $('#modulo_formato_btn_crear_nuevo').fadeIn();
                    $('.loading').fadeOut();

                });
            }

        }, delay);


    // Fin del else
    }


// Fin del else del confirm
} else {
    alert("No se han realizado cambios.");
}


});

// BTN Cancelar del modal de nuevo formato
$('.btn_cancelar_nuevo_formato').on('click', function () {

    // Cerrar solo el modal seleccionado
    $("#nuevoFormatoModal").modal("hide");

});

// BTN Crear nuevo formato
$('.tipo_btn_formatos_nuevo').on('click', function () {


    var r = confirm("¿Guardar Nuevo Formato?");

    if (r == true) {

        $('#tipo_btn_formatos').fadeOut();
        $('#btn_cerrar_popup_formato').fadeOut();
        $('#cerrar_btn_popup_formato__x').fadeOut();
        $('#modulo_formato_btn_crear_nuevo').fadeOut();
        $('#btn_cancelar_nuevo_formato').fadeOut();
        $('#tipo_btn_formatos_nuevo').fadeOut();
        $('.loading_nf').fadeIn();

        // Buscar si existe en el CBX si lo que estoy ingresando ya existe
        // Si lo que me encuentro ingresando es distindo al select

        var texto_nuevo  = $('.NUEVO_FORMATO').val();
        var texto_nuevo_formato  =  texto_nuevo.toUpperCase();

        var contador = 0;

        $(".FORMATO option").each(function(){

            if($(this).text() == texto_nuevo_formato.trim()){
                contador = 1;
            }

        });


        if(contador == 1){

            alert("El formato que intenta ingresar, ya existe.");

            $('#tipo_btn_formatos').fadeIn();
            $('#btn_cerrar_popup_formato').fadeIn();
            $('#cerrar_btn_popup_formato__x').fadeIn();
            $('#modulo_formato_btn_crear_nuevo').fadeIn();
            $('#btn_cancelar_nuevo_formato').fadeIn();
            $('#tipo_btn_formatos_nuevo').fadeIn();
            $('.loading_nf').fadeOut();

        }else if(contador==0 && texto_nuevo_formato.length>0){

            // Enviar a guardar
            var nuevo_formato = $('.NUEVO_FORMATO').val();
            var url_agrega = 'ajax_simulador_formato/agrega_nuevo_formato';
            $.get(url_agrega, {NUEVO_FORMATO:nuevo_formato.toUpperCase()}).done(function(){

                // Limpiar BCX de Formato (aun con registros antigüos), luego cargar nuevamente sus items
                $('.FORMATO').empty();

                // Recargar el CBX de Formato, luiego de haber ingresado un nuevo registro
                var url_formato = 'ajax_simulador_formato/obtiene_formato';
                var toAppend_formato = "";
                $.getJSON(url_formato, function (data) {
                    $.each(data, function (i,o) {
                        toAppend_formato += '<option value=' + o[0] + '>' + o[1]  + '</option>';
                    });
                    $('.FORMATO').append(toAppend_formato);
                }).done(function(){

                    // Limpiar el texto del formulario
                    $('#NUEVO_FORMATO').empty();

                    // Cerrar la ventana modal
                    $("#nuevoFormatoModal").modal("hide");

                    // Enviar Alerta cuando se realize la nueva inserción
                    alert("Favor revisar el nuevo formato. \n Si no lo encuentra, recargue página o limpie historial.");

                    $('#tipo_btn_formatos').fadeIn();
                    $('#btn_cerrar_popup_formato').fadeIn();
                    $('#cerrar_btn_popup_formato__x').fadeIn();
                    $('#modulo_formato_btn_crear_nuevo').fadeIn();
                    $('#btn_cancelar_nuevo_formato').fadeIn();
                    $('#tipo_btn_formatos_nuevo').fadeIn();
                    $('.loading_nf').fadeOut();

                });



            // Fin el agregar formato
            });

            // Fin del else asociado a la existencia previa del formato
        }


    } else {
        alert("No se han realizado cambios.");
    }


});



