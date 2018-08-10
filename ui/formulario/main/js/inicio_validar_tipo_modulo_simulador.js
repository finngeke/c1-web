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


                $.getJSON(url_buscar_accion_estados_desactivado,{ID_TIP_USR:tipo_usuario}, function (data_accion) {
                    $.each(data_accion, function (i, a) {

                        arreglo_accion_desac.push({
                            id_accion:a[0]
                        });

                    });
                }).done(function (data_accion) {



                    //VALIDAR MODULO DE FACTOR ESTIMADO
                    var verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==5;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_factor_estimado').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE FACTOR ESTIMADO
                    var verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==11;});
                    if (verifica_accion.length > 0){
                        $("#btn_grabar_factor_estimado").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==12;});
                    if (verifica_accion.length > 0){
                        $(".elimina_factor").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==13;});
                    if (verifica_accion.length > 0){
                        $(".replicar_factor").attr("disabled", "disabled");
                        $(".replicar_factor").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==14;});
                    if (verifica_accion.length > 0){
                        $("#btn_tipo_de_cambio_modificar").attr("disabled", "disabled");
                        $("#btn_tipo_de_cambio_modificar").each(function (){
                            this.style.pointerEvents = 'none';
                        });

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==15;});
                    if (verifica_accion.length > 0){
                        $("#guardar_tipo_cambio").attr("disabled", "disabled");
                        $(".TxtboxTipocambio").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==72;});
                    if (verifica_accion.length > 0){
                        $(".guarda_replicar").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==73;});
                    if (verifica_accion.length > 0){
                        $("#btn_eliminar_factor_estimado").attr("disabled", "disabled");
                        $("#btn_eliminar_factor_estimado").each(function (){
                            this.style.pointerEvents = 'none';
                        });

                    }



                    // VALIDAR MODULO DE FECHA DE RECEPCION
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==6;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_fecha_recepcion_cd').remove();
                    }

                    // VALIDAR BOTONES DEL MODULO DE FECHA DE RECEPCION
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==16;});
                    if (verifica_accion.length > 0){
                        $(".btn_guardar_fecha_recepcion").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==17;});
                    if (verifica_accion.length > 0){
                        $(".btn_eliminar_fecha_recepcion").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==18;});
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


                    //VALIDAR MODULO DE REGISTRO DE COMPRA
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==7;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_registro_de_compra').remove();
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


                    //VALIDAR MODULO DE MASTER PACK
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==14;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_master_pack').remove();
                    }
                    // VALIDAR BOTONES DEL MODULO DE MASTER PACK
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==54;});
                    if (verifica_accion.length > 0){
                        $("#btn_guardar_master_pack").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==55;});
                    if (verifica_accion.length > 0){
                        $(".agregar_master").attr("disabled", "disabled");
                        $(".agregar_master").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==56;});
                    if (verifica_accion.length > 0){
                        $(".agrega_master").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==57;});
                    /*if (verifica_accion.length > 0){
                        $("#btn_cambiar_division_master_pack").attr("disabled", "disabled");
                    }*/
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==58;});
                    if (verifica_accion.length > 0){
                        $(".cantidad_master").attr("disabled", "disabled");
                    }

                    // VALIDAR MODULO DE DEPARTAMENTO MARCA
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==15;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_depto_marca').remove();
                    }
                    //VALIDAR BOTONES DEL MODULO DE DEPARTAMENTO MARCA
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==59;});
                    if (verifica_accion.length > 0){
                        $("#deptomarca_agregar").attr("disabled", "disabled");
                        $("#deptomarca_agregar").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==60;});
                    if (verifica_accion.length > 0){
                        $("#deptomarca_quitar").attr("disabled", "disabled");
                        $("#deptomarca_quitar").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }

                    //VALIDAR MODULO DE PRIORIDADES DE TIENDA
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==16;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_prioridades_tienda').remove();
                    }
                    // VALIDAR BOTONES DEL MODULO DE PRIORIDADES TIENDA
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==61;});
                    if (verifica_accion.length > 0){
                        $("#btn-save").attr("disabled", "disabled");
                    }

                    //VALIDAR MODULO DE DISTRIBUCION DE MERCADERIA
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==17;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_distribucion_mercaderia').remove();
                    }
                    //VALIDAR BOTONES DEL MODULO DE DISTRIBUCION DE MERCADERIA


                    //VALIDAR MODULO DE BAJADA DE EMBARQUE
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==18;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_bajada_embarque').remove();
                    }
                    //VALIDAR BOTONES DEL MODULO DE BAJADA DE EMBARQUE




                });

            });

    });
//fin del onload //
});
