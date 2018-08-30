$(window).on('load', function () {

    var url_busca_cod_tip_usr               = 'permiso_usuario/busca_cod_tip_usr';
    var url_buscar_modulos_estados_desactivado = 'permiso_usuario/buscar_modulos_estados_desactivado';
    var url_buscar_accion_estados_desactivado = 'permiso_usuario/buscar_accion_estados_descativado';
    var tipo_usuario = '';
    var arreglo_modulos_desac = [];
    var arreglo_accion_desac = [];

    $.getJSON(url_busca_cod_tip_usr,function( data ) {

            //se asigna a una variable el tipo de usuario
            tipo_usuario = data[0]['COD_TIPUSR'];
            //la variable se asigna a una span para tener el tipo de usuario presente siempre.
            $('#flag_top_menu_tipo_usuario_num').html(tipo_usuario);

            //llamo a la consulta para saber que modulos estan desabilitados segun su tipo de usuario
            $.getJSON(url_buscar_modulos_estados_desactivado,{ID_TIP_USR:tipo_usuario}, function (data_modulo) {
                $.each(data_modulo, function (i, o) {


                     arreglo_modulos_desac.push({
                         id_modulo:o[0]
                     });


                    });
            }).done(function (data_modulo) {
                $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);

                $.getJSON(url_buscar_accion_estados_desactivado,{ID_TIP_USR:tipo_usuario}, function (data_accion) {
                    $.each(data_accion, function (i, a) {

                        arreglo_accion_desac.push({
                            id_accion:a[0]
                        });

                    });
                }).done(function (data_accion) {

                    //VALIDAR MODULO DE REGISTRO DE COMPRA
                    var verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==7;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_registro_de_compra').remove();
                    }

                    // VALIDAR BOTONES DEL MODULO DE REGISTRO DE COMPRA
                    var verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==25;});
                    if (verifica_accion.length > 0){
                        $(".guarda_proforma").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==26;});
                    if (verifica_accion.length > 0){
                        $(".importar_bmt").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==27;});
                    if (verifica_accion.length > 0){
                        $("#user_file").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==28;});
                    if (verifica_accion.length > 0){
                        $(".carga_bmt").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==74;});
                    if (verifica_accion.length > 0){
                        $("#tipos_import").attr("disabled", "disabled");
                    }


                    //VALIDAR MODULO DE TIENDAS
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==8;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_tipo_tienda').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE TIENDA
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==33;});
                    if (verifica_accion.length > 0){
                        $("#btn_agregar_tipo_tienda").attr("disabled", "disabled");
                        $("#btn_agregar_tipo_tienda").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==34;});
                    if (verifica_accion.length > 0){
                        $("#btn_quitar_tipo_tienda").attr("disabled", "disabled");
                        $("#btn_quitar_tipo_tienda").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==35;});
                    if (verifica_accion.length > 0){
                        $("#btn_replicar_popup_tipo_tienda").attr("disabled", "disabled");
                        $("#btn_replicar_popup_tipo_tienda").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==36;});
                    if (verifica_accion.length > 0){
                        $("#tipo_btn_replicar_tienda").attr("disabled", "disabled");
                        $("#tipo_btn_replicar_tienda").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==37;});
                    if (verifica_accion.length > 0){
                        $("#tipo_btn").attr("disabled", "disabled");
                        $("#tipo_btn").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }



                    //VALIDAR MODULO DE FORMATOS
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==9;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_formatos').remove();

                    }

                    //VALIDAR BOTONES DEL MODULO DE FORMATOS
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==38;});
                    if (verifica_accion.length > 0){
                        $("#modulo_formato_btn_crear_nuevo").attr("disabled", "disabled");
                        $("#modulo_formato_btn_crear_nuevo").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==39;});
                    if (verifica_accion.length > 0){
                        $("#tipo_btn_formatos_nuevo").attr("disabled", "disabled");
                        $("#tipo_btn_formatos_nuevo").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==40;});
                    if (verifica_accion.length > 0){
                        $("#btn_agregar_formato").attr("disabled", "disabled");
                        $("#btn_agregar_formato").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==41;});
                    if (verifica_accion.length > 0){
                        $("#btn_agregar_formato").attr("disabled", "disabled");
                        $("#btn_agregar_formato").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==42;});
                    if (verifica_accion.length > 0){
                        $("#tipo_btn_formatos").attr("disabled", "disabled");
                        $("#tipo_btn_formatos").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }



                    //VALIDAR MODULO DE FLUJO DE APROBACION
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==10;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_flujo_aprob').remove();
                    }

                    //VALIDAR LINK DEL FLUJO DE APROBACION
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==43;});
                    if (verifica_accion.length > 0){
                        $(".solicitud_generacion_oc").css({ 'pointer-events': 'none' });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==44;});
                    if (verifica_accion.length > 0){
                        $(".oc_generada").css({ 'pointer-events': 'none' });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==45;});
                    if (verifica_accion.length > 0){
                        $(".crear_modificacion").css({ 'pointer-events': 'none' });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==46;});
                    if (verifica_accion.length > 0){
                        $(".elimina_opcion").css({ 'pointer-events': 'none' });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==47;});
                    if (verifica_accion.length > 0){
                        $(".solicitud_correccion_pi").css({ 'pointer-events': 'none' });
                    }


                    //VALIDAR MODULO DE VENTANAS DE LLEGADA
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==11;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_tipo_ventana_llegada').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE VENTANAS DE LLEGADA
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==48;});
                    if (verifica_accion.length > 0){
                        $("#tipo_btn_ventana_llegada").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==49;});
                    if (verifica_accion.length > 0){
                        $("#input_A").attr("disabled", "disabled");
                        $("#input_B").attr("disabled", "disabled");
                        $("#input_C").attr("disabled", "disabled");
                        $("#input_D").attr("disabled", "disabled");
                        $("#input_E").attr("disabled", "disabled");
                        $("#input_F").attr("disabled", "disabled");
                        $("#input_G").attr("disabled", "disabled");
                        $("#input_H").attr("disabled", "disabled");
                        $("#input_I").attr("disabled", "disabled");
                    }


                    //VALIDAR MODULO DE PRESUPUESTO COSTO
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==12;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_ppto_costo').remove();
                    }
                    //VALIDAR BOTNOES DEL MODULO DE PRESUPUESTO COSTO
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==50;});
                    if (verifica_accion.length > 0){
                        $("#input_total_ppto_costo").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==51;});
                    if (verifica_accion.length > 0){
                        $("#tipo_btn_ppto_costo").attr("disabled", "disabled");
                    }


                    //VALIDAR MODULO DE PRESUPUESTO RETAIL
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==13;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_ppto_retail').remove();
                    }
                    //VALIDAR BOTONES DEL MODULO DE PRESUPUESTO RETAIL
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==52;});
                    if (verifica_accion.length > 0){
                        $("#input_total_ppto_retail").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==53;});
                    if (verifica_accion.length > 0){
                        $("#tipo_btn_ppto_retail").attr("disabled", "disabled");
                    }
                    $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);
                });

            });

    });

//fin del onload //
});

$('#btn_salir_sistemas_despues_simulador').on('click', function () {

    var url_eliminar_concurrencia           = 'permiso_usuario/eliminar_concurrencia';
    var span_temp_eli_conc = $('#span_temporada').text();
    span_temp_eli_conc = span_temp_eli_conc.replace(/[^a-z0-9\-]/gi,'');
    var separa_tempo = span_temp_eli_conc.split("-");

    var depto_salir_volver_main = separa_tempo[1];

    $.getJSON(url_eliminar_concurrencia,{DEPTO:depto_salir_volver_main}).done(function (data) {
        window.location.href = "salir";
    });
});

$('#btn_c1_cambiar_inicio').on('click', function () {

    var url_eliminar_concurrencia           = 'permiso_usuario/eliminar_concurrencia';
    var span_temp_eli_conc = $('#span_temporada').text();
    span_temp_eli_conc = span_temp_eli_conc.replace(/[^a-z0-9\-]/gi,'');
    var separa_tempo = span_temp_eli_conc.split("-");

    var depto_salir_volver_main = separa_tempo[1];

    $.getJSON(url_eliminar_concurrencia,{DEPTO:depto_salir_volver_main}).done(function (data) {
        window.location.href = "inicio";
    });
});

$('#btn_salir_main').on('click', function () {

    var url_eliminar_concurrencia = 'permiso_usuario/eliminar_concurrencia';

    var span_temp_eli_conc = $('#span_temporada').text();
    span_temp_eli_conc = span_temp_eli_conc.replace(/[^a-z0-9\-]/gi,'');
    var separa_tempo = span_temp_eli_conc.split("-");

    var temp_salir_volver_main = separa_tempo[0];
    var depto_salir_volver_main = separa_tempo[1];


    $.getJSON(url_eliminar_concurrencia,{DEPTO:depto_salir_volver_main}).done(function (data) {
        window.location.href = "plan_compra?codigo="+temp_salir_volver_main;
    });

});

$('#link_ir_a_home').on('click', function () {

    var url_eliminar_concurrencia           = 'permiso_usuario/eliminar_concurrencia';
    var span_temp_eli_conc = $('#span_temporada').text();
    span_temp_eli_conc = span_temp_eli_conc.replace(/[^a-z0-9\-]/gi,'');
    var separa_tempo = span_temp_eli_conc.split("-");

    var depto_salir_volver_main = separa_tempo[1];


    $.getJSON(url_eliminar_concurrencia,{DEPTO:depto_salir_volver_main}).done(function (data) {
        window.location.href = "inicio";
    });
});

$('#btn_cambiar_clave_lyt_simulador_b').on('click',function () {

    var url_carga_datos_usuario_cambiar_clave   = 'cambiar_clave/trae_datos_cambio';

    $.getJSON(url_carga_datos_usuario_cambiar_clave,function( data ) {

        $('#input_clave_desde_bd').val(data[0]['CONTRASENIA']);
        $('#tabla_cambiar_clave').append(
            '<td align="center" id="td_id_cod_usuario_cambiar_clave">'+data[0]['COD_USR']+'</td>'
        );

    });

    $('#popup_cambiar_clave').modal('show');

});





