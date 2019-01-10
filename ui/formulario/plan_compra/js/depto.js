/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Roberto Pérez
 */

$(function () {

    /*$('.simulador').on('click', function () {

        $('.loading').fadeIn();
        // $(this).prop('href', 'lista_master_pack?division=' + $('#SELECT').find('option:selected').val());
        $('.simulador').remove();
        $('.cambia').remove();

    });*/

});

$(window).on('load', function () {

    $('#selecciona_depto').modal('show');

    $('.lista_deptos').DataTable({
        "oLanguage": {
            "sSearch": "Buscar:",
            "sZeroRecords" : "No se encontraron registros"
        },
        paging: false,
        scrollY: "200px",
        scrollCollapse: true
    });

});

function redireccDeptoPopUp(event) {

    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_");
    var depto = separa_barra[3];

    // Restriccion de usuarios lecturas... para los popup de configuracion de tiendas, formatos y presupuestos
    var url_busca_cod_tip_usr     = 'permiso_usuario/busca_cod_tip_usr';
    var flag_cod_tip_usr        = 0;

    $.getJSON(url_busca_cod_tip_usr, function (data) {
        $.each(data, function (i,c) {

            if ((c[0] != null) || (c[0] != '') || (c[0].length > 0)) {

                flag_cod_tip_usr = c[0];

                //estos perfiles ingresan como lectura
                if ((flag_cod_tip_usr == 11) || (flag_cod_tip_usr == 4) || (flag_cod_tip_usr == 7)) {
                    // Llamada a la función de bloqueos de popup cuando es de tipo lectura
                    campos_bloquear_tipo_usuario();

                }
            }
        });
    });


    // Asigno el departamentoa la ventana del mantenedor tipo tienda del popup (desde selección depto)
    $('#select_depto_mant_tipo_tienda_hidden').val($.trim(depto));
    // Lo asigno al campo se replicar tienda
    $('#REPLICAR_TIENDA_DEPARTAMENTO').val($.trim(depto));

    // Limpiar los 3/2 campos asociados al presupuesto antes que los traiga
    // Revisar si calcula al cargar los popup, al ejecutar el js
    $('#input_total_ppto_costo').val('');
    $('#input_total_ppto_retail').val('');
    $('#input_A').val('');
    $('#input_B').val('');
    $('#input_C').val('');
    $('#input_D').val('');
    $('#input_E').val('');
    $('#input_F').val('');
    $('#input_G').val('');
    $('#input_H').val('');
    $('#input_I').val('');
    $('#input_total').val('');


    // Por cada vez que presiona el btn, validar los 3 presupuestos más tiendas
    var url_busca_existe_marca        = 'ajax_simulador_cbx/busca_existe_marca';
    var url_busca_session                   = 'permiso_usuario/busca_session';
    var url_busca_cod_tip_usr               = 'permiso_usuario/busca_cod_tip_usr';
    var url_busca_usuario_tabla_session      = 'permiso_usuario/busca_usuario_tabla_session';
    var url_guardar_concurrencia            = 'permiso_usuario/guardar_concurrencia';
    var url_eliminar_concurrencia           = 'permiso_usuario/eliminar_concurrencia';

    var flag_busca_existe_marca = 0;
    var flag_busca_existe_pto_tienda = 0;
    var flag_cod_tip_usr = 0;
    var flag_cant_usr_session = 0;
    var version_app = $('#version_app').html();
    var user_log_depto = '';

    // Primero se debe verificar si existn marcas asociadas, de lo contrario no debiera continuar con el resto. Desplegar Mensaje: "No existen marcas asociadas en este Departamento, Por favor comunicarse con el administrador del sistema."
    $.getJSON(url_busca_existe_marca, {DEPTO:depto}, function (data) {
        $.each(data, function (i,o) {
            flag_busca_existe_marca++;
        });
    }).done( function( data ) {
        if( flag_busca_existe_marca > 0 ){
//######################################### BUSCAR TIENDAS #########################################


        var dataString_dataDepto = "DEPTO=" + depto;
        $.ajax({
            url: "TelerikPlanCompra/ListarPermisosValidaPresupuestos",
            data: dataString_dataDepto,
            //type: "POST",
            //dataType: "json",
            success: function (result) {

                localStorage.clear();

                var ConteoRegQuery = JSON.parse(result);
                $.each( ConteoRegQuery, function(i, obj) {
                    //localStorage.setItem("TOTALREGPLAN", obj.TOTALREGPLAN);
                    localStorage.setItem(obj.NOMBRE, obj.VALOR);
                });

            },
            error: function (xhr, httpStatusMessage, customErrorMessage) {
                // Limpiar el Local Storage
                localStorage.clear();
            }
        }).done(function (data) {

            /*
           -- no pueden entrar 2 veces al mismo depto (si se agrega uno nuevo agregar en "url_busca_session")
            9	BRAND MANAGER
            10	SUBGERENTES
            3	COMPRADOR
            5	CATEGORY
            2	PLANNER
            99	ADMINISTRADOR
            1	COMEX
            8	GERENTE

            --entran directo como lectura--

            11	INTERNET
            4	ANALISTA COMERCIAL
            7	INVENTORY MANAGER
            */

            $.getJSON(url_busca_cod_tip_usr, function (data) {
                $.each(data, function (i,c) {

                    if ( (c[0] != null) || (c[0] != '') || (c[0].length > 0) ){

                        flag_cod_tip_usr = c[0];

                        //estos perfiles ingresan como lectura
                        if ( (flag_cod_tip_usr == 11) || (flag_cod_tip_usr == 4) ||(flag_cod_tip_usr == 7) ){
                            getjerarquia(depto);
                            location.href='simulador_compra?depto='+depto;

                            //el resto de perfiles que no entran de 2
                        }else {

                            //buscar si hay alguien del mismo grupo escritura
                            $.getJSON(url_busca_session, {DEPTO:depto,COD_TIP_GRP:'1,2,3,5,8,9,10,99,100,101,102'}, function (data) {
                                $.each(data, function (i,s) {

                                    if ( (s[0] == null) || (s[0] == '') || (s[0].length < 0)|| (s[0] == 0) ){
                                        flag_cant_usr_session = '';
                                    }else {
                                        flag_cant_usr_session = s[0];
                                        user_log_depto = s[1];
                                    }

                                });

                                //valida si el existe almenos un usuario logueado de mi grupo
                                if (flag_cant_usr_session != ''){

                                    //Busco si existe un registro asociado al loguin
                                    $.getJSON(url_busca_usuario_tabla_session, {DEPTO:depto}, function (data) {
                                        $.each(data, function (i,t) {

                                            if ( (t[0] == null) || (t[0] == '') || (t[0].length < 0) || (t[0] == 0) ){


                                                //sino es igual mensaje de alerta de modo lectura
                                                var respuesta = confirm("El usuario "+user_log_depto+" está utilizando el departamento,¿Desea entrar en modo Lectura?");
                                                if (respuesta == true){
                                                    getjerarquia(depto);
                                                    location.href='simulador_compra?depto='+depto;
                                                }else {
                                                    alert ("Pongase en contacto con "+user_log_depto+" si desea mdificar el departamento");
                                                    return false;
                                                }

                                            }else {
                                                getjerarquia(depto);
                                                // si es el mismo usuario ingresar directamente
                                                location.href='simulador_compra?depto='+depto;
                                            }
                                        });
                                    });
                                }else {

                                    $.getJSON(url_eliminar_concurrencia,{DEPTO:depto}).done(function (data) {

                                        $.getJSON(url_guardar_concurrencia,{DEPTO:depto,COD_MARC:0,NUM_SESSION:0,VERSION_APP:version_app,CPU_COUNT:'0',CPU_MHZ:'0',CPU_NAME:'0',CPU_VENDOR:'0',CPU_INDENTI:'0',MEM_PHYSIC:'0',MEM_AVAPHY:'0',MEM_TOTVIR:'0',MEM_AVAVIR:'0',MEM_OSNAME:'0',COD_TIP_GRP:'1,2,3,5,8,9,10,99,100,101,102'},function (data2) {

                                            if (data2 == 0){

                                                alert ("Ya existe otro usuario que está utilizando el departamento ");
                                            } else {
                                                getjerarquia(depto);
                                                location.href='simulador_compra?depto='+depto;
                                            }

                                        });
                                    });

                                }
                            });

                            //fin del else de perfiles que no entran de dos
                        }

                    }else{
                        alert("No se pudo identificar al usuario, por favor recargue la pagina.");
                    }
                });
            });

        });


//######################################### FIN BUSCAR TIENDAS #########################################
        // Fin if si llegan marcas
        }else{
            alert("No existen marcas en este Departamento, Informar a Bartolomé Soler.");
        }
    });



// Fin función redirección depto popup
}

function campos_bloquear_tipo_usuario() {
    $('#flag_top_menu_tipo_usuario').html('LECTURA');

    //botones del mantenedor de tipo tiendas //
    $("#tipo_btn").attr("disabled", "disabled"); 
    $("#btn_replicar_popup_tipo_tienda").attr("disabled", "disabled");
    $("#tipo_btn_replicar_tienda").attr("disabled", "disabled");


    //botones del mantenedor de formato//
    $("#tipo_btn_formatos_nuevo").attr("disabled", "disabled");
    $("#modulo_formato_btn_crear_nuevo").attr("disabled", "disabled");// aqui
    $("#tipo_btn_formatos").attr("disabled", "disabled");
    $(".quitar").attr("disabled", "disabled");
    $(".agregar").attr("disabled", "disabled");

    //botones del mantenedor ventanas de llegada//
    $("#tipo_btn_ventana_llegada").attr("disabled", "disabled");
    $("#input_A").attr("disabled", "disabled");
    $("#input_B").attr("disabled", "disabled");
    $("#input_C").attr("disabled", "disabled");
    $("#input_D").attr("disabled", "disabled");
    $("#input_E").attr("disabled", "disabled");
    $("#input_F").attr("disabled", "disabled");
    $("#input_G").attr("disabled", "disabled");
    $("#input_H").attr("disabled", "disabled");
    $("#input_I").attr("disabled", "disabled");

    //botones del mantenedor de presupuesto costo//
    $("#tipo_btn_ppto_costo").attr("disabled", "disabled");
    $("#input_total_ppto_costo").attr("disabled", "disabled");

    //botones del mantenedor de presupuesto Retail//
    $("#tipo_btn_ppto_retail").attr("disabled", "disabled");
    $("#input_total_ppto_retail").attr("disabled", "disabled");

}

function getjerarquia ($depto) {
    var url_jerarquia = 'importar_archivo/getJerarquia';
    var jerarquia = "";
   $.getJSON(url_jerarquia,{Depart:$depto},function (_data) {


    });

}

