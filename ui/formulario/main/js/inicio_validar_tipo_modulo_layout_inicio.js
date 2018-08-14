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

                    // VALIDAR MODULO  DE USUARIO
                    var verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==1;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_usuario_validar_tipo_usuario').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE USUARIO
                    var verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==1;});
                    if (verifica_accion.length > 0){
                        $("#btn_grabar_usuario").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==2;});
                    if (verifica_accion.length > 0){
                        $(".eliminar_usuario").attr("disabled", "disabled");
                        $('.eliminar_usuario').each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==3;});
                    if (verifica_accion.length > 0){
                        $("#btn_agrega_perfil_usuario").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==4;});
                    if (verifica_accion.length > 0){
                        $(".crea_perfil").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==67;});
                    if (verifica_accion.length > 0){
                        $(".eliminar_perfil").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==68;});
                    if (verifica_accion.length > 0){
                        $(".elimina_perfil").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==71;});
                    if (verifica_accion.length > 0){
                        $(".elimina_usuario").attr("disabled", "disabled");
                    }


                    //VALIDAR MODULO DE PERMISOS
                     verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==2;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_permiso_validar_tipo_usuario').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE PERMISOS
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==5;});
                    if (verifica_accion.length > 0){
                        $("#guardar_permisos_usuarios").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==66;});
                    if (verifica_accion.length > 0){
                        $("#guardar_permisos_modulo_acciones").attr("disabled", "disabled");
                    }




                    // VALIDAR MODULO TEMPORADA COMPRA
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==3;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_temporada_compra_validar_tipo_usuario').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO TEMPORADA COMPRA
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==6;});
                    if (verifica_accion.length > 0){
                        $("#button_guarda_temporada").attr("disabled", "disabled");

                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==7;});
                    if (verifica_accion.length > 0){
                        $(".eliminar_temporada").attr("disabled", "disabled");
                        $(".eliminar_temporada").each(function (){
                            this.style.pointerEvents = 'none';
                        });

                    }
                     verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==8;});
                    if (verifica_accion.length > 0){
                        $(".elimina_temporada").attr("disabled", "disabled");

                    }
                     verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==9;});
                    if (verifica_accion.length > 0){
                        $(".quitar_temporada").attr("disabled", "disabled");
                        $(".quitar_temporada").each(function (){
                            this.style.pointerEvents = 'none';
                        });

                    }


                    //VALIDAR MODULO DE PLAN DE COMPRA
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==4;});
                    if (verifica_modulo.length > 0){
                        $('#inicio_popup_temporada').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE PLAN DE COMPRA
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==10;});
                    if (verifica_accion.length > 0){
                        $(".temporada_compra_validar_tipo_usr").remove();

                    }


                    //VALIDAR MODULO DE PROVEEDOR
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==19;});
                    if (verifica_modulo.length > 0){
                        $('#inicio_popup_proveedor').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE PROVEEDOR



                    //VALIDAR MODULO DE SESSION ACTIVAS
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==23;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_session_validar_tipo_usuario').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE SESSION ACTIVAS
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==63;});
                    if (verifica_accion.length > 0){
                        $("#btn_guardar_sesiones_activas").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==64;});
                    if (verifica_accion.length > 0){
                        $(".eliminar_sesion").attr("disabled", "disabled");
                        $(".eliminar_sesion").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==65;});
                    if (verifica_accion.length > 0){
                        $(".elimina_sesion").attr("disabled", "disabled");
                    }


                    //Validar modulo COMEX
                    verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo== 24;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_comex').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE COMEX
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion== 75;});
                    if (verifica_accion.length > 0){
                        $("#btn_guardar_modulo_comex").attr("disabled", "disabled");
                        $("#btn_guardar_modulo_comex").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion== 76;});
                    if (verifica_accion.length > 0){
                        $("#btn_enviar_a_comex").attr("disabled", "disabled");
                        $("#btn_enviar_a_comex").each(function (){
                            this.style.pointerEvents = 'none';
                        });
                    }



                });

            });

    });

//fin del onload //
});
