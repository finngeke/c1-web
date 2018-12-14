$(window).on('load', function () {

    $('#guardar_permisos_modulo_acciones').hide();
    $('#guardar_permisos_usuarios').hide();

    var cargar_tipo_usuario = 'permiso_usuario/llenar_tipo_usuario';
    var cargar_usuario = 'permiso_usuario/llenar_usuario';
    var inc_tipo_usu = 0;
    var inc_usu = 0;

    /*############################# se agrega la etiqueta de ul fuera del ciclo ##################################*/
    $('#tabla_tipo_usuario').append('<ul class="nav nav-list">');

    // Se cargan los tipos de usuario
    $.getJSON(cargar_tipo_usuario, function (data) {

        /* se inicia el each que llenara los tipos de usuarios */
        $.each(data, function (i, o) {
            $('#tabla_tipo_usuario').append(
                '<li><label class="tree-toggle nav-header"><a href="#" onclick="cargar_tabla_modulos(&quot;' + o[0] + '&quot;)">' + o[1] + '</a></label>' +
                '<ul id="ul_usu_' + o[0] + '" class="nav nav-list tree">' +
                '</ul>' +
                '</li>'
            );
            inc_tipo_usu++;
        });

        /* FIN DEL each que llenara los tipos de usuarios */

        /*Each por cada tipo de usuaro llenara los usuarios que corresponden*/
        $.each(data, function (i, o) {
            $.getJSON(cargar_usuario, {ID_TIPO_USUARIO: o[0]}, function (data_usu) {
                $.each(data_usu, function (a, b) {
                    var codigo_usuario_permiso = b[0];
                    $("#ul_usu_" + o[0]).append(
                        '<li value="' + b[0] + '"><a href="#" onclick="cargar_tabla_depto(&quot;' + codigo_usuario_permiso + '&quot;)">' + b[1] + '</a></li>'
                    );
                });
            });
            inc_usu++;
        });

        /*FIN DEL EACH que llena los usuarios segun su tipo*/
        $('.tree-toggle').click(function () {
            $(this).parent().children('ul.tree').toggle(200);
        });
        $('.tree-toggle').parent().children('ul.tree').toggle(200);

    });

    $('#tabla_tipo_usuario').append('</ul>');
    /*############################# FIN DE agregar la etiqueta de ul fuera del ciclo ##################################*/


}); //final de onload

$('#guardar_permisos_usuarios').on('click', function () {

    var respuesta_usuarios_permiso = confirm("¿Guardar Los cambios?");
    var validar_guardar_permiso_usuario = 0;

    if (respuesta_usuarios_permiso == true) {

        // Desabilito el BTN guardar
        $('#guardar_permisos_modulo_acciones').fadeOut();
        $('#guardar_permisos_usuarios').fadeOut();
        $('.regresar').fadeOut();
        // Desplegamos POPUP
        $('#popup_guarda_permisos').modal('show');

        // Limpiamos la búsqueda para que el código recorra la tabla completa
        var table = $('#tabla_depto_permiso').DataTable();
        table.search('').draw();

        $("#tabla_depto_permiso >tbody >tr").each(function () {

            var depto_permiso_actualizado = $(this).find("td:eq(4)").text();
            var cod_usu = $("#cod_usu_hidden").html();
            cod_usu = cod_usu.replace(/[^a-z0-9\,]/gi, '');

            var dep_depto = $(this).find("td:eq(1)").text();
            dep_depto = dep_depto.replace(/[^a-z0-9\,]/gi, '');

            var estado = $(this).find("td:eq(3) select").val();
            var flag = 1;
            if (depto_permiso_actualizado == 'U') {

                var url_guarda_permiso = 'permiso_usuario/guardar_permiso_depto';
                $.getJSON(url_guarda_permiso, {
                    COD_USU: cod_usu,
                    DEP_DEPTO: dep_depto,
                    ESTADO: estado,
                    FLAG: flag
                }, function (data) {
                    $('#flag_data_insert_deptos').html(data);
                });

            }
        });

        // Nueva función, corrige el guardado... la función comentada recargaba la página antes de terminar si la cantidad de permisos a asignar eran muchos.
        // Se recarga y entrega el mensaje cuando termina la ejecución de todos los XHR que se realicen
        $(document).ajaxStop(function () {
            alert("Los cambios han sido realizados, favor revisar.");
            location.reload();
        });

        /*var delay_guardar_depto = 5000;
        setTimeout(function () {
            validar_guardar_permiso_usuario =  $('#flag_data_insert_deptos').html();
            if (validar_guardar_permiso_usuario == 1) {
                alert("Los cambios han sido realizados, favor revisar.");
                location.reload();
            }else{
                alert ("Debe modificar un departamento para guardar los cambios.");
                // Habilito el BTN guardar
                //$('#guardar_permisos_usuarios').attr('disable',false);
            }
        }, delay_guardar_depto);*/

    } else {
        return false;
    }

});

$('#guardar_permisos_modulo_acciones').on('click', function () {

    var url_guarda_permiso_modulo_accion = 'permiso_usuario/guardar_permiso_modulo_accion';

    var respuesta_modulo_acceso = confirm("¿Guardar Los cambios en permisos de modulos?");
    var validar_guardado = 0;

    if (respuesta_modulo_acceso == true) {

        // Desabilito el BTN guardar
        $('#guardar_permisos_modulo_acciones').fadeOut();
        $('#guardar_permisos_usuarios').fadeOut();
        $('.regresar').fadeOut();
        // Desplegamos POPUP
        $('#popup_guarda_permisos').modal('show');


        $("#tabla_modulo_acceso >tbody >tr").each(function () {

            var modulo_permiso_actualizado = $(this).find("td:eq(2)").text();

            var id_modulo = $(this).find("td:eq(2)").attr("id");
            var cadena = id_modulo,
                separador = "_",
                arregloDeSubCadenas = cadena.split(separador);

            var id_modulo_separado = arregloDeSubCadenas [2];
            var id_accion_separado = arregloDeSubCadenas [3];

            var estado_accion = $(this).find("td:eq(1) select").val();

            if (id_accion_separado == null) {
                id_accion_separado = 0;
                estado_accion = 0;
            }

            var id_tipo_usu = $("#flag_top_menu_tipo_usuario").text();
            id_tipo_usu = id_tipo_usu.replace(/[^a-z0-9\,]/gi, '');

            var estado_modulo = $(this).find("td:eq(1) select").val();

            if (modulo_permiso_actualizado == 'U') {
                $.getJSON(url_guarda_permiso_modulo_accion, {
                    ID_TELERIK: id_accion_separado,
                    TIP_USR: id_tipo_usu,
                    ESTADO_ACCION: estado_accion,
                    ID_MODULO: id_modulo_separado,
                    ESTADO_MODULO: estado_modulo
                }, function (data) {
                    $('#flag_data_insert_modulos').html(data);
                });
            }

        });


        // Nueva función, corrige el guardado... la función comentada recargaba la página antes de terminar si la cantidad de permisos a asignar eran muchos.
        // Se recarga y entrega el mensaje cuando termina la ejecución de todos los XHR que se realicen
        $(document).ajaxStop(function () {
            alert("Los cambios han sido realizados, favor revisar.");
            location.reload();
        });

        /*var delay_validar_guardado = 5000;
        setTimeout(function (){
                validar_guardado = $('#flag_data_insert_modulos').html();
            if (validar_guardado == 1) {
                alert("Los cambios han sido realizados, favor revisar.");
                location.reload();
            }else{
                alert("Debe modificar un estado de modulo/botón para guardar los cambios");
            }
        }, delay_validar_guardado);*/


    } else {
        alert("No se han realizado modificaciones.");
    }

});

function campo_ajustado(inc) {

    $("#col_act_estado_depto_" + inc).html('U');
}

function campo_flag_modulo(inc_modulo) {

    $("#flag_modulo_" + inc_modulo).html('U');
}

function campo_flag_acciones(inc_modulo, inc_accion) {

    $("#flag_accion_" + inc_modulo + "_" + inc_accion).html('U');
}

function cargar_tabla_depto(codigo_usu_permiso) {

    // Despliega POPUP de carga de contenido/permisos
    $('#popup_carga_permisos').modal('show');

    $('#guardar_permisos_usuarios').show();
    $('#guardar_permisos_modulo_acciones').hide();

    $('#tabla_modulo_acceso tbody').empty();
    $('#tabla_depto_permiso tbody').empty();

    var div1 = document.getElementById("div_tabla_depto_permiso");
    div1.style.display = "";

    var div2 = document.getElementById("div_tabla_modulo_acceso");
    div2.style.display = "none";

    $('#cod_usu_hidden').html(codigo_usu_permiso);
    var cargar_tabla_depto_permisos = 'permiso_usuario/llenar_tabla_depto_permisos';
    var inc_depto_permisos = 0;

    // se construye la segunda tabla cada vez que seleccione un usuario//
    $.getJSON(cargar_tabla_depto_permisos, {CODIGO_USUARIO_PERMISO: codigo_usu_permiso}, function (data_depto) {
        $.each(data_depto, function (r, d) {
            $('#tabla_depto_permiso').append(
                '<tr>' +
                '<td>' + d[0] + '</td>' +
                '<td>' + d[1] + '</td>' +
                '<td>' + d[2] + '</td>' +
                '<td><select id="selec_estado_depto_' + inc_depto_permisos + '" name="selec_estado_depto"  onchange="campo_ajustado(' + inc_depto_permisos + ');">' +
                '<option value="0" >No Permitido</option>' +
                '<!-- <option value="1" >Lectura</option> -->' +
                '<option value="2" >Permitido</option>' +
                '</select></td>' +
                '<td id="col_act_estado_depto_' + inc_depto_permisos + '" style="display: none;"></td>' +
                '</tr>');
            $("#selec_estado_depto_" + inc_depto_permisos).val(d[3]);
            inc_depto_permisos++;
        });

        /* La tabla toma las propiedades de datatable con el fin de mantener los titulos fijos*/
        var delay_thead = 2000;
        setTimeout(function () {
            $('#tabla_depto_permiso').DataTable({
                retrieve: true,
                destroy: true,
                paging: false,
                scrollY: "400px",
                scrollX: "500px",
                "info": false,
                scrollCollapse: true,
                "oLanguage": {
                    "sSearch": "Buscar:",
                    "sZeroRecords": "No se encontraron registros"
                }
            });

            $('#tabla_depto_permiso_filter label input').attr('id', 'filtro_perfil_usuario');

        }, delay_thead);

    });

    // Define Tiempo 1 = 1000
    var delay = 5000;
    setTimeout(function () {
        // Ocultar POPUP de carga de contenido/permisos
        $('#popup_carga_permisos').modal('hide');
    }, delay);

}

function cargar_tabla_modulos(tip_usr) {

    if (tip_usr != 99) {

        // Despliega POPUP de carga de contenido/permisos
        $('#popup_carga_permisos').modal('show');

        $('#flag_top_menu_tipo_usuario').html(tip_usr);

        $('#guardar_permisos_modulo_acciones').show();
        $('#guardar_permisos_usuarios').hide();

        $('#tabla_modulo_acceso tbody').empty();
        $('#tabla_depto_permiso tbody').empty();

        var div1 = document.getElementById("div_tabla_depto_permiso");
        div1.style.display = "none";

        var div2 = document.getElementById("div_tabla_modulo_acceso");
        div2.style.display = "";

        var url_cargar_modulos = 'permiso_usuario/cargar_modulos';
        var url_cargar_modulos_acciones = 'permiso_usuario/cargar_modulos_acciones';
        var url_cargar_modulos_estados = 'permiso_usuario/cargar_modulos_estados';
        var url_cargar_accion_estados = 'permiso_usuario/cargar_accion_estados';
        var tipo_usr = $('#flag_top_menu_tipo_usuario').text();

        $.getJSON(url_cargar_modulos, function (data) {

            $.each(data, function (i, o) {
                $('#tabla_modulo_acceso').append(
                    '<tr id="tr_modulo_' + o[0] + '">' +
                    '<td style="background-color: lightgrey"> <a>' + o[0] + ' - ' + o[1] + '</a>' +
                    '</td>' +

                    '<td style="background-color: lightgrey" >' +
                    '<select id="select_mod_' + o[0] + '"  onchange="campo_flag_modulo(' + o[0] + ')">' +
                    '<option >Seleccione</option>' +
                    '<option value="0" >No Permitido</option>' +
                    '<option value="1" >Permitido</option>' +
                    '</select>' +
                    '</td>' +

                    '<td id="flag_modulo_' + o[0] + '" style="display: none">' +
                    '<span id="flag_modulo_' + o[0] + '"></span>' +
                    '</td>' +

                    '</tr>'
                );
                $.getJSON(url_cargar_modulos_estados, {ID_TIP_USR: tipo_usr, ID_MODULO: o[0]}, function (data) {
                    $.each(data, function (i, t) {
                        $("#select_mod_" + o[0]).val(t[1]);
                    });
                });
            });

            /* FIN DEL each que llenara los modulos */
            /*Each que llena las acciones(botnoes) por modulo correspondiente*/
            // revisar el ID que se ñe asigna a cada elemento b[3] ex b[0] revisar si asigna la misma variable
            $.each(data, function (i, o) {
                $.getJSON(url_cargar_modulos_acciones, {ID_MODULO: o[0]}, function (data_usu) {
                    $.each(data_usu, function (a, b) {
                        $('#tr_modulo_' + o[0]).after(
                            '<tr>' +

                            '<td>' + b[2] + '</td>' +

                            '<td>' +
                            '<select id="select_modulo_accion_' + b[3] + '" onchange="campo_flag_acciones(' + o[0] + ',\'' + b[3] + '\')">' +
                            '<option>seleccione</option>' +
                            '<option value="0">Lectura</option>' +
                            '<option value="1">Escritura</option>' +
                            '</select>' +
                            '</td>' +

                            '<td  id="td_accion_' + o[0] + '_' + b[3] + '" style="display: none">' +
                            '<span id="flag_accion_' + o[0] + '_' + b[3] + '"></span>' +
                            '</td>' +

                            '</tr>'
                        );

                        $.getJSON(url_cargar_accion_estados, {
                            ID_TIP_USR: tipo_usr,
                            ID_MODULO: o[0],
                            ID_TELERIK: b[3]
                        }, function (data) {
                            $.each(data, function (i, t) {
                                $("#select_modulo_accion_" + b[3]).val(t[1]);
                            });
                        });

                    });
                });
            });
            /*FIN DEL EACH que llena los botones segun su modulo*/

            //Propiedades de datatable para la tabla de permisos de modulos//
            var delay_thead = 1000;
            setTimeout(function () {
                $('#tabla_modulo_acceso').DataTable({
                    retrieve: true,
                    destroy: true,
                    paging: false,
                    scrollY: "400px",
                    //scrollX: "500px",
                    "searching": false,
                    "info": false,
                    "ordering": false,
                    "bSort": false,
                    scrollCollapse: true
                });

                //$('body, input[type=search]').addClass('roberto');
                //$('#tabla_depto_permiso_filter label input').attr ('id', 'filtro_perfil_usuario');

            }, delay_thead);

        });

        // Define Tiempo 1 = 1000
        var delay = 10000;
        setTimeout(function () {
            // Ocultar POPUP de carga de contenido/permisos
            $('#popup_carga_permisos').modal('hide');
        }, delay);


    } else {

        $('#tabla_modulo_acceso tbody').empty();
        $('#tabla_depto_permiso tbody').empty();
        //alert ("No se pueden modificar los permisos de administrador");

    }

}

