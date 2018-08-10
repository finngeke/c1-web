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


                    //VALIDAR MODULO DE UPLOAD_PACKING_LIST
                    var verifica_modulo = $.grep(arreglo_modulos_desac,function(e){return e.id_modulo==22;});
                    if (verifica_modulo.length > 0){
                        $('#modulo_upload_packing_list').remove();
                    }

                    //VALIDAR BOTONES DEL MODULO DE UPLOAD_PACKING_LIST
                    var verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==69;});
                    if (verifica_accion.length > 0){
                        $("#btn_save_packing_list").attr("disabled", "disabled");
                    }
                    verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==70;});
                    if (verifica_accion.length > 0){
                        $("#packingListFile").attr("disabled", "disabled");
                    }


                });
            });

    });
//fin del onload //
});
