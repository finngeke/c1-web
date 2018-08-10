/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 */

$(function () {

    $('#lista_sesiones').DataTable({
        // "ordering": false,
        paging: false,
        "info": false,
        fixedColumns:true,
        scrollCollapse: true,
        "oLanguage": {
            "sSearch": "Buscar:"
        }
    });


    /*ABRE POPUP MODAL USUARIOS*/
    $('.eliminar_sesion').on('click', function () {
        $('.registro').html('<b> ' + $("#codigo_usuario").val() + ' </b>');

    });

    $('.limpiar_form').on('click', function () {
        $('#lista_sesiones .filas').each(function () {
            $(this).removeClass("tabla_selecciona");
            $(this).find('input').prop("checked", false);
            $('.eliminar_sesion').addClass("disabled");

            $('#temporada').val("");
            $('#depto').val("");
            $('#codigo_usuario').val("");
            $('#usuario_log').val("");
        });
    });

    /*AJAX DE ELIMINACION PERFIL*/

    //boton que actualiza el estado de la concurrencia, a ("pedido")
    $('.elimina_sesion').on('click', function () {

       var tempo = $('#temporada').val();
       var depto =$('#depto').val();
       var cod_usu =$('#codigo_usuario').val();

        var url_actualizar_session_activa           = 'permiso_usuario/actualiza_sesion_activa';

        //llamada para actualizar la tabla de concurrencia, utiliza las variables cargadas.
        $.getJSON(url_actualizar_session_activa,{TEMPO:tempo,DEPTO:depto,COD_USU:cod_usu}).done(function (data) {

            $('#popup_cerrando_session').modal('show');

            //llamo a funcion del tipo cronometro que valida los usuarios expulsados.
            validar_session_usuario_logout();
        });

        /*url = 'ajax/elimina_perfil';
         $.get(url, {perfil: $(".COMBO_PERFIL option:selected").val()}, function (data) {
         var mensaje = data.split("-");
         notificacionNavegador(mensaje[0], mensaje[1]);
         location.reload();
         });*/
    });
});

$(document).ready(function () {
    /*SELECCION DE FILA GRILLA*/
    $('input[type=radio][name=carga_sesion]').change(function () {
        $('#lista_sesiones .filas').each(function () {
            $(this).removeClass("tabla_selecciona");
        });
        $(this).parent().parent().addClass("tabla_selecciona");
        $('.eliminar_sesion').removeClass("disabled");
        var cuerpo = $(this).parent().parent().data("sesiones").split("$");
        $('#temporada').val(cuerpo[0]);
        $('#depto').val(cuerpo[3]);
        $('#codigo_usuario').val(cuerpo[4]);
        $('#usuario_log').val(cuerpo[5]);
    });


});
// Botón OnClick
$('#inicio_popup_temporada').on('click', function () {

    // Desplegar Modal
    $('#selecciona_temporada').modal('show');

});

$('#bnt_refrescar_sessiones_activas').on('click', function () {
    location.reload();
});

//funcion de tipo cronometro que valida en intervalos, los usuarios que ya fueron expulsados de los departamentos
function validar_session_usuario_logout() {

var url_buscar_sesion_usuarios_log_out    = 'permiso_usuario/buscar_sesion_usuarios_log_out';
var url_eliminar_concurrencia_sessiones_activas          = 'permiso_usuario/eliminar_concurrencia_sessiones_activas';

var tempo = $('#temporada').val();
var depto =$('#depto').val();
var cod_usu =$('#codigo_usuario').val();

    var contador_s = 0;
    var contador_m = 0;

    var s = document.getElementById("segundos");
    var m = document.getElementById("minutos");

var cronometro = setInterval(
    function () {

        if (contador_s == 60) {
            contador_s = 0;
            contador_m++;
            m.innerHTML = contador_m;

            if (contador_m == 4) {
                contador_m = 0;
            }
        }
            if ((contador_s == 20) || (contador_s == 40) || (contador_s == 59)) {
                $.getJSON(url_buscar_sesion_usuarios_log_out, {TEMPO: tempo, DEPTO: depto,COD_USU:cod_usu}, function (data) {
                    if (data == 0) {
                        //levantar pop
                        $('#popup_cerrando_session').modal('hide');
                        location.reload();
                    }
                });
            }

            //validacion... si no hay respuesta de parte del usuario el sistema lo expulsara
            if ((contador_m == 3) && (contador_s == 5)){
                $.getJSON(url_eliminar_concurrencia_sessiones_activas,{TEMPO:tempo, DEPTO:depto,COD_USU:cod_usu});
            }

        s.innerHTML = contador_s;
        contador_s++;

    },1000);
}


