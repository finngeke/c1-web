/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author Roberto Pérez (29-03-2018)
 */


$(window).on('load', function () {

    if($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {
   $('.tipo_btn_formatos').attr('disabled', 'disabled');
    }

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

        var formato_seleccionado  = $('.FORMATO').val();

        if ($('.ASIGNADO_FORMATO option').length == 0) {
            alert("No existen items a guardar.");
        } else {

            // Revisar la lògica del quitar ya que los podría quitar todos de una ()
            // var url_quitar = 'ajax_simulador_formato/quitar_todo_formato';
            // $.get(url_quitar, {FORMATO:formato_seleccionado});


            // Quitar los registros
            var url_quitar = 'ajax_simulador_formato/quitar_formato';
            $("#ASIGNADO_FORMATO option").each(function(){
                $.get(url_quitar, {FORMATO:formato_seleccionado,ASIGNADO: $(this).attr('value')});
            });


            // Agrega Registros
            var url_agrega = 'ajax_simulador_formato/agrega_formato';
            $("#ASIGNADO_FORMATO option").each(function(){
                $.get(url_agrega, {FORMATO:formato_seleccionado,ASIGNADO: $(this).attr('value')});
            });



        } // Fin del else de verificación

// Fin del else del confirm
} else {
    alert("No se han realizado cambios.");
}


});

/*$('.tipo_btn_formatos_nuevo').on('click', function () {


    alert("Cerrar Ventana Actual y Abrir Modal");

    $('.selecciona_popup_formato').modal('toggle');


});*/

// BTN Cancelar del modal de nuevo formato
$('.btn_cancelar_nuevo_formato').on('click', function () {

    // Cerrar solo el modal seleccionado
    $("#nuevoFormatoModal").modal("hide");

});

// BTN Crear nuevo formato
$('.tipo_btn_formatos_nuevo').on('click', function () {

     // Buscar si existe en el CBX si lo que estoy ingresando ya existe
     // Si lo que me encuentro ingresando es distindo al select

    var texto_nuevo  = $('.NUEVO_FORMATO').val();
    var texto_nuevo_formato  =  texto_nuevo.toUpperCase();

    var contador = 0;

    $(".FORMATO option").each(function(){
        //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));
        if($(this).text() == texto_nuevo_formato.trim()){
            contador = 1;
        }

    });


    if(contador == 1){
        alert("El formato que intenta ingresar, ya existe.");
    }else if(contador==0 && texto_nuevo_formato.length>0){

        // Enviar a guardar
         var nuevo_formato = $('.NUEVO_FORMATO').val();
         var url_agrega = 'ajax_simulador_formato/agrega_nuevo_formato';
         $.get(url_agrega, {NUEVO_FORMATO:nuevo_formato.toUpperCase()});


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
        });


        // Limpiar el texto del formulario
        $('.NUEVO_FORMATO').empty();


        // Cerrar la ventana modal
        $("#nuevoFormatoModal").modal("hide");


        // Enviar Alerta cuando se realize la nueva inserción
        alert("Favor revisar el nuevo formato. \n Si no lo encuentra, recargue página o limpie historial.");


    }





});



