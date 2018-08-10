$.fn.onlynum = function (event) {
    if ($.inArray(event.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
                    (event.keyCode == 86 || event.keyCode == 67 || event.keyCode == 13) ||
                    // Allow: home, end, left, right
                            (event.keyCode >= 35 && event.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            else {
                // Ensure that it is a number and stop the keypress
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                    event.preventDefault();
                }
            }
        }
        $.fn.numero = function () {
            var valor = $(this).text().length > 0 ? $(this).text() : $(this).val();
            valor = parseInt(valor.replace(/\D/g, ''), 10);
            return isNaN(valor) ? 0 : valor;
        }
        $.fn.rut = function () {
            var T = $(this).numero();
            var M = 0, S = 1;
            for (; T; T = Math.floor(T / 10))
                S = (S + T % 10 * (9 - M++ % 6)) % 11;
            return S ? S - 1 : 'K';
        }
        $.fn.suma = function () {
            var arreglo = $(this), suma = 0;
            for (var i = arreglo.length - 1; i >= 0; i--)
                suma += $(arreglo[i]).numero();
            return suma;
        }
        $.fn.aplicarNumero = function () {
            var arreglo = $(this);
            for (var i = arreglo.length - 1; i >= 0; i--)
                $(arreglo[i]).val($(arreglo[i]).numero());
        }
        $.fn.isNum = function (input) {
            if (isNaN(input.val())) {
                return false; //string
            } else {
                return true; // numeric
            }
        }



        /*notificaciones navegador*/

        window.addEventListener('load', function () {
            $('.label_solicitud').fadeOut(2000).html('');
            $('.label_tarea').fadeOut(2000).html('');
            if ($('.dropdown').length) {
                setInterval(function () {
                    url = 'anadir/parametros/ver_tareas';
                    $.get(url, {mae_rut: $('.tecnico_tarea').val()}, function (data) {
                        texto = data.split('|');

                        $('title').html(texto[1]);
                        $('.label_solicitud').fadeIn(3000).html(texto[3]);
                        $('.label_tarea').fadeIn(3000).html(texto[2]);
                        $('span.total_correos').fadeIn(3000).html(texto[4]);


                        // At first, let's check if we have permission for notification
                        // If not, let's ask for it                

                        if (texto[0] === '1') {

                            if (window.Notification && Notification.permission !== "granted") {
                                Notification.requestPermission(function (status) {
                                    if (Notification.permission !== status) {
                                        Notification.permission = status;
                                    }
                                });
                            }

                            // var button = document.getElementsByClassName('button')[0];

                            // button.addEventListener('click', function() {
                            // If the user agreed to get notified
                            if (window.Notification && Notification.permission === "granted") {
                                var n = new Notification(texto[1], {tag: 'soManyNotification'});
                                // var n = new Notification(data);                            

                            }


                            // If the user hasn't told if he wants to be notified or not
                            // Note: because of Chrome, we are not sure the permission property
                            // is set, therefore it's unsafe to check for the "default" value.
                            else if (window.Notification && Notification.permission !== "denied") {
                                Notification.requestPermission(function (status) {
                                    if (Notification.permission !== status) {
                                        Notification.permission = status;
                                    }

                                    // If the user said okay
                                    if (status === "granted") {
                                        var n = new Notification(texto[1], {tag: 'soManyNotification'});
                                        //var n = new Notification(data);
                                        //alert('texto[1]');
                                    }

                                    // Otherwise, we can fallback to a regular modal alert
                                    else {
                                        alert(texto[1]);
                                    }
                                });
                            }

                            // If the user refuses to get notified
                            else {
                                // We can fallback to a regular modal alert
                                alert(texto[1]);
                            }
                        }
                        // });
                    });
                }, 12000);
            }
        });


        $(document).on('keydown', 'input[name=usuario]', function (event) {
            $.fn.onlynum(event);
        });
        $(document).on('keydown', 'input[name=fono]', function (event) {
            $.fn.onlynum(event);
        });

        $(document).ready(function () {

            $('button.s_vista').on('click', function () {
                $('.op').val('0');
            });
            $('button.s_excel').on('click', function () {
                $('.op').val('1');
            });

            $('button.t_vista').on('click', function () {
                $('.op').val('0');
            });
            $('button.t_excel').on('click', function () {
                $('.op').val('1');
            });

            $('form.f_rep_solicitud').on('submit', function (evt) {

                evt.preventDefault();

                if ($('.op').val() === '1') {
                    $(this).removeAttr('action');
                    $(this).attr('action', 'rpt_solicitud_excel').off('submit').submit();
                    $('#wrapper').load('rpt_solicitud');
                } else {
                    $(this).removeAttr('action');
                    $(this).attr('action', 'rpt_solicitud').off('submit').submit();
                }



            });

            $('form.f_rep_tarea').on('submit', function (evt) {

                evt.preventDefault();


                if ($('.op').val() === '1') {
                    $(this).removeAttr('action');
                    $(this).attr('action', 'rpt_tarea_excel').off('submit').submit();
                    $('#wrapper').load('rpt_tarea');
                } else {
                    $(this).attr('action', 'rpt_tarea').off('submit').submit();

                }

            });

            $('#buscar_faq').on('change', function () {

                $('#wrapper').load('f_general?consulta=' + $(this).val());

            });
            $("div:contains('inicio')").css("font-weight", "bold");
            /*setTimeout(function () {
             
             if ($('.dropdown').length) {
             url = 'anadir/parametros/ver_tareas';
             $.get(url, {mae_rut: $('.tecnico_tarea').val()}, function (data) {
             $('title').html(data);
             
             });
             }
             }, 5000);
             if ($('.dropdown').length) {
             
             setTimeout(function () {
             url = 'anadir/parametros/ver_tareas';
             $.get(url, {mae_rut: $('.tecnico_tarea').val()}, function (data) {
             $('title').html(data);
             
             });
             }, 5000);
             }*/


            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

            var checkin = $('#fecha_1').datepicker({
                onRender: function (date) {
                    return date.valueOf() < now.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function (ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('#fecha_2')[0].focus();
            }).data('datepicker');
            var checkout = $('#fecha_2').datepicker({
                onRender: function (date) {
                    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
                }
            }).on('changeDate', function (ev) {
                checkout.hide();
            }).data('datepicker');

            setInterval(function () {
                $('.table tr').each(function () {
                    if ($(this).attr('id') === 'blink') {
                        if ($(this).attr('class') === 'luz') {
                            $(this).removeClass();
                            $(this).addClass('panne luz on');

                        } else {
                            $(this).removeClass();
                            $(this).addClass('luz');
                        }
                    }
                });
            }, 700);





            var listCentroCosto = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('scalar'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: 'http://helpdesk.utem.cl/web/test',
                remote: 'http://localhost/crs.helpdesk.demo/web/getCentroCosto?query=%QUERY'
            });

            listCentroCosto.initialize();

            $('#bs-centro-costo .typeahead').typeahead(null, {
                name: 'bs-centro-costo',
                displayKey: 'scalar',
                source: listCentroCosto.ttAdapter()
            });
            //tecnicos
            var listTecnicos = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('scalar'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: 'http://helpdesk.utem.cl/web/test',
                remote: 'http://localhost/crs.helpdesk.demo/web/getTecnicos?query=%QUERY'
            });

            listTecnicos.initialize();

            $('#bs-tecnico .typeahead').typeahead(null, {
                name: 'bs-tecnico',
                displayKey: 'scalar',
                source: listTecnicos.ttAdapter()
            });

            // autocomplete funcionarios
            var listFunionarios = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('scalar'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: 'http://helpdesk.utem.cl/web/test',
                remote: 'http://localhost/crs.helpdesk.demo/web/getFunionarios?query=%QUERY'
            });

            listFunionarios.initialize();

            $('#bs-example .typeahead').typeahead(null, {
                name: 'bs-example',
                displayKey: 'scalar',
                source: listFunionarios.ttAdapter()

            });
            //autocomplete ubicaciones
            var listUbicaciones = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('scalar'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: 'http://helpdesk.utem.cl/web/test',
                remote: 'http://localhost/crs.helpdesk.demo/web/getUbicaciones?query=%QUERY'
            });

            listUbicaciones.initialize();

            $('#bs-ubicacion .typeahead').typeahead(null, {
                name: 'bs-example',
                displayKey: 'scalar',
                source: listUbicaciones.ttAdapter()
            });

            //autocompleta tipo problema    
            var listProblemas = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('scalar'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                //prefetch: 'http://helpdesk.utem.cl/web/test',
                remote: 'http://localhost/crs.helpdesk.demo/web/getProblemas?query=%QUERY'
            });

            listProblemas.initialize();

            $('#bs-problema .typeahead').typeahead(null, {
                name: 'bs-example',
                displayKey: 'scalar',
                source: listProblemas.ttAdapter()
            });

            $('.dropdown_telefono').on('click', function () {
                $('.cuerpo_log_telefono').empty();
                url = 'anadir/parametros/log_telefono';

                $.get(url, function (data) {
                    $('.cuerpo_log_telefono').append(data);
                });

            });

            //tool butones grillas*/
            $(".tooltip_crea").tooltip({
                title: 'Crear Tarea'
            });
            $(".tooltip_m").tooltip({
                title: 'Modificar'
            });
            $(".tooltip_e").tooltip({
                title: 'Desactivar'
            });
            $(".tooltip_anular").tooltip({
                title: 'Anular'
            });
            $(".tooltip_a").tooltip({
                title: 'Activar'
            });
            $(".tooltip_examinar").tooltip({
                title: 'Ver detalle'
            });
            $(".tooltip_fin").tooltip({
                title: 'Finalizar'
            });


            $(".tooltip_realiza").tooltip({
                title: 'Realizar Tarea'
            });
            $(".tooltip_print").tooltip({
                title: 'Imprimir'
            });
            $(".tooltip_malta").tooltip({
                title: 'Muy Alta'
            });
            $(".tooltip_alta").tooltip({
                title: 'Alta'
            });
            $(".tooltip_normal").tooltip({
                title: 'Normal'
            });
            $(".tooltip_leer").tooltip({
                title: 'Marcar como no leído'
            });
            $(".tooltip_sol_correo").tooltip({
                title: 'Ingresar Solicitud'
            });
            /*
             $('.sso_fono').keypress(function(tecla) {
             if (tecla.charCode < 48 || tecla.charCode > 57)
             return false;
             });
             $('.ticket').keypress(function(tecla) {
             if (tecla.charCode < 48 || tecla.charCode > 57)
             return false;
             });
             */
            $('#dataTables-example').dataTable();

            /*Mantenedor de usurios*/
            $('form.usuario').on('submit', function (evt) {
                $('.log_error').empty();
                evt.preventDefault();
                val = true;

                if ($.fn.isNum($('.mae_rut')) === false) {
                    val = false;
                }
                if ($(this).find('input[name=mae_clave_1]').val() !== $(this).find('input[name=mae_clave_2]').val()) {
                    msg = 'las contraseñas no coinciden, vuelva a ingresarla.';
                    val = false;
                }
                if ($(this).find('.perfil').val() === 'NULL') {
                    msg = 'Debe seleccionar el perfil.';
                    val = false;
                }
                if ($(this).find('.rol').val() === 'NULL') {
                    msg = 'Debe seleccionar el rol.';
                    val = false;
                }

                if ($('.detalle_ficha').is(':empty')) {
                    msg = 'El rut ingresado no existe en los registros de la BD.';
                    val = false;
                }

                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $('form.usuario_clave').on('submit', function (evt) {
                $('.log_error').empty();
                evt.preventDefault();
                val = true;


                if ($(this).find('input[name=mae_clave_1]').val() !== $(this).find('input[name=mae_clave_2]').val()) {
                    msg = 'las contraseñas no coinciden, vuelva a ingresarla.';
                    val = false;
                }

                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $('form.modifica_usuario').on('submit', function (evt) {
                $('.log_error').empty();
                evt.preventDefault();
                val = true;


                if ($(this).find('input[name=mae_clave_1]').val() !== $(this).find('input[name=mae_clave_2]').val()) {
                    msg = 'las contraseñas no coinciden, vuelva a ingresarla.';
                    val = false;
                }
                if ($(this).find('.perfil').val() === 'NULL') {
                    msg = 'Debe seleccionar el perfil.';
                    val = false;
                }
                if ($(this).find('.rol').val() === 'NULL') {
                    msg = 'Debe seleccionar el rol.';
                    val = false;
                }

                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $(document).on('click', '.modificar_t', function () {

                $('.cuerpo_modifica_usuario').empty();
                url = 'anadir/parametros/modifica_tecnico';


                $.get(url, {mae_rut: $(this).parent().parent().parent().find('td.mae_rut').html()}, function (data) {
                    $('.cuerpo_modifica_usuario').append(data);
                });
            });

            //correo

            $('.messages').on('click', function () {

                url = 'anadir/parametros/correos';

                $.get(url, function (data) {
                    $('.cuerpo_mensajes').empty().append(data);
                });
            });


            $(document).on('change', '.mae_rut', function () {
                mae_rut = $(this).val();

                if ($.fn.isNum($('.mae_rut')) === true) {
                    $('.detalle_ficha').empty();
                    var $this = $(this);
                    switch ($(this).data('tipo')) {
                        case 'ingreso':
                            url = 'anadir/parametros/consultar_tecnico';
                            break;
                    }

                    $.get(url, {mae_rut: mae_rut}, function (data) {
                        $('.detalle_ficha').append(data);
                    });

                } else {
                    $('.detalle_ficha').empty();
                }
            });

            $(document).on('click', '.desactivar_u', function () {

                $('.cuerpo_desactiva_usuario').empty();
                url = 'anadir/parametros/consultar_tecnico';

                $.get(url, {mae_rut: $(this).parent().parent().parent().find('td.mae_rut').html()}, function (data) {
                    $('.cuerpo_desactiva_usuario').append(data);
                });
            });

            $(document).on('click', '.activar_u', function () {
                //alert($(this).parent().parent().find('td.mae_rut').html());

                url = 'activar/usuario';

                $.get(url, {mae_rut: $(this).parent().parent().parent().find('td.mae_rut').html()});
                $('form.activar_usuario').submit();
            });

            /*Mantenedor de estados*/
            $('.modificar_s').on('click', function () {


                $('.cuerpo_modifica_estado_solicitud').empty();
                url = 'anadir/parametros/modifica_estado_solicitud';

                $.get(url, {eso_codigo: $(this).parent().parent().parent().find('td.eso_codigo').html()}, function (data) {
                    $('.cuerpo_modifica_estado_solicitud').append(data);
                });
            });

            /*tipo de problemas*/
            $('form.tipos_problemas').on('submit', function (evt) {
                $('.log_error').empty();
                evt.preventDefault();
                val = true;



                if ($(this).find('.origen_problema').val() === 'NULL') {
                    msg = 'Debe seleccionar el origen.';
                    val = false;
                }
                if ($(this).find('.tipo_problema').val() === 'NULL') {
                    msg = 'Debe seleccionar el tipo.';
                    val = false;
                }



                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $(document).on('click', '.modificar_tipo', function () {


                $('.cuerpo_modifica_tipo_problema').empty();
                url = 'anadir/parametros/modifica_tipo_problema';

                $.get(url, {dpr_codigo: $(this).parent().parent().parent().find('td.dpr_codigo').html()}, function (data) {
                    $('.cuerpo_modifica_tipo_problema').append(data);
                });
            });

            $('form.modifica_pregunta').on('submit', function (evt) {
                $('.log_error').empty();
                evt.preventDefault();
                val = true;


                if ($(this).find('#ESTADO').val() === 'NULL') {
                    msg = 'Debe seleccionar el estado.';
                    val = false;
                }
                if ($(this).find('input[name=pgt_codigo]').val() === 'NULL') {
                    msg = 'Error al cargar la pregunta';
                    val = false;
                }


                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $(document).on('click', '.desactivar_p', function () {

                $('.cuerpo_desactiva_problema').empty();
                url = 'anadir/parametros/desactivar_tipo_problema';

                $.get(url, {dpr_codigo: $(this).parent().parent().parent().find('td.dpr_codigo').html()}, function (data) {
                    $('.cuerpo_desactiva_problema').append(data);
                });
            });

            $(document).on('click', '.activar_p', function () {
                //alert($(this).parent().parent().find('td.mae_rut').html());

                url = 'activar/tipo_problema';

                $.get(url, {dpr_codigo: $(this).parent().parent().parent().find('td.dpr_codigo').html()});
                $('form.activar_tipo_problema').submit();
            });

            $(document).on('click', '.desactivar_pregunta', function () {

                $('.cuerpo_desactiva_pregunta').empty();
                url = 'anadir/parametros/desactivar_pregunta';

                $.get(url, {pgt_codigo: $(this).parent().parent().parent().find('td.pgt_codigo').html()}, function (data) {
                    $('.cuerpo_desactiva_pregunta').append(data);
                });
            });

            $(document).on('click', '.activar_pregunta', function () {

                url = 'activar/pregunta';

                $.get(url, {pgt_codigo: $(this).parent().parent().parent().find('td.pgt_codigo').html()});
                $('form.activar_pregunta_f').submit();
            });

            $(document).on('click', '.modificar_pregunta', function () {

                $('.cuerpo_modifica_pregunta').empty();
                url = 'anadir/parametros/modifica_pregunta';

                $.get(url, {pgt_codigo: $(this).parent().parent().parent().find('td.pgt_codigo').html()}, function (data) {
                    $('.cuerpo_modifica_pregunta').append(data);
                });
            });


            /*Ingreso solicitud*/
            $('form.solicitud_funcionario').on('submit', function (evt) {
                $('.log_error').empty();

                evt.preventDefault();
                val = true;


                if ($(this).find('.problema').val() === 'null') {
                    msg = 'Debe seleccionar el tipo problema.';
                    val = false;
                }

                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $(document).on("click", ".igual", function () {
                if ($(this).is(":checked")) {
                    $('.mae_solicita').removeClass('typeahead').attr('readonly', 'readonly');
                } else {
                    $('.mae_solicita').val('').addClass('typeahead').removeAttr('readonly');
                }
            });

            $(document).on("click", ".pull-right .btn-primary", function () {
                $('.loading').css('display', 'inline');
                $('.mae_solicita').removeClass('typeahead').attr('readonly', 'readonly');

                $('.detalle_historico_usuario').empty();
                mae_nombre = $("#mae_solicitado_por").val().split(' ');
                mae_rut = mae_nombre[0];

                url = 'anadir/parametros/consulta_historial_usuario';
                $.get(url, {mae_rut: mae_rut}, function (data) {

                    $('.detalle_historico_usuario').append(data);
                    $('.loading').css('display', 'none');

                }).fail(function () {
                    $('.loading').css('display', 'none');
                });
            });

            $(document).on('click', '.desactivar_solicitud', function () {


                $('.cuerpo_desactiva_solicitud').empty();
                url = 'anadir/parametros/consultar_solicitud';

                $.get(url, {sso_codigo: $(this).parent().parent().parent().find('td.sso_codigo').html()}, function (data) {
                    $('.cuerpo_desactiva_solicitud').append(data);
                });
            });

            //tarea
            $('.cola').on('click', function () {

                $('.segun_origen').fadeOut();
                url = 'anadir/parametros/elemento_tarea';


                $.get(url, {opr_codigo: $(this).val()}, function (data) {
                    $('.segun_origen').empty();
                    $('.segun_origen').append(data).fadeIn();
                });

            });

            $('form.asignar_tarea').on('submit', function (evt) {
                $('.log_error').empty();


                evt.preventDefault();
                val = true;



                if ($(this).find('#problema').val() === 'null') {
                    msg = 'Debe seleccionar la área del problema.';
                    val = false;
                }
                if ($(this).find('#tecnico').val() === 'null') {
                    msg = 'Debe seleccionar el técnico.';
                    val = false;
                }
                if ($(this).find('#tipo_problema').val() === 'null') {
                    msg = 'Debe seleccionar el tipo de problema.';
                    val = false;
                }


                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $(document).on('click', '.desactivar_tarea', function () {

                $('.cuerpo_desactiva_tarea').empty();
                url = 'anadir/parametros/consultar_tarea';

                $.get(url, {codigo: $('input[name=sso_codigo]').val() + '-' + $(this).parent().parent().find('td.dss_correlativo b').html()}, function (data) {
                    $('.cuerpo_desactiva_tarea').append(data);
                });
            });

            $(document).on('click', '.modificar_tarea', function () {

                $('.cuerpo_modifica_tarea').empty();
                url = 'anadir/parametros/consultar_modifica_tarea';

                $.get(url, {codigo: $('input[name=sso_codigo]').val() + '-' + $(this).parent().parent().find('td.dss_correlativo b').html()}, function (data) {
                    $('.cuerpo_modifica_tarea').append(data);
                });
            });

            $('form.modifica_tarea').on('submit', function (evt) {
                $('#form_modificar .log_error').empty();

                evt.preventDefault();
                val = true;

                if ($(this).find('#tecnico').val() === 'null') {
                    msg = 'Debe seleccionar el técnico.';
                    val = false;
                }
                if ($(this).find('#tipo_problema').val() === 'null') {
                    msg = 'Debe seleccionar el tipo de problema.';
                    val = false;
                }

                if (val) {
                    $('#form_modificar .log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('#form_modificar .log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $(document).on('click', '.finaliza_tarea', function () {

                $('.cuerpo_finaliza_tarea').empty();
                url = 'anadir/parametros/consultar_finaliza_tarea';

                $.get(url, {codigo: $('input[name=sso_codigo]').val() + '-' + $(this).parent().parent().find('td.dss_correlativo b').html()}, function (data) {
                    $('.cuerpo_finaliza_tarea').append(data);
                });
            });

            $(document).on('click', '.procesa_tarea', function () {

                $('.cuerpo_en_proceso').empty();
                url = 'anadir/parametros/consultar_en_proceso';

                $.get(url, {codigo: $(this).parent().parent().find('td.sso_codigo b').html() + '-' + $(this).parent().parent().find('td.dss_correlativo b').html()}, function (data) {
                    $('.cuerpo_en_proceso').append(data);
                });
            });

            $(document).on('click', '.finaliza_tarea_usuario', function () {

                $('.cuerpo_finaliza_tarea').empty();
                url = 'anadir/parametros/consultar_finaliza_tarea';

                $.get(url, {codigo: $(this).parent().parent().parent().find('td.sso_codigo b').html() + '-' + $(this).parent().parent().find('td.dss_correlativo b').html()}, function (data) {
                    $('.cuerpo_finaliza_tarea').append(data);
                });
            });

            $('form.fin_tarea').on('submit', function (evt) {
                $('.fin_tarea .log_error').empty();

                evt.preventDefault();
                val = true;


                if ($(this).find('.FORMA_SOPORTE').val() === 'NULL') {
                    msg = 'Debe seleccionar la forma solución.';
                    val = false;
                }


                if (val) {
                    $('.fin_tarea .log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.fin_tarea .log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            $(document).on('click', '.imprimir', function (evt) {
                url = 'http://localhost/crs.helpdesk.demo/web/informe_on_site?sso_codigo=' + $(this).parent().parent().find('td.sso_codigo b').html() + '&dss_correlativo=' + $(this).parent().parent().find('td.dss_correlativo b').html();

                evt.preventDefault();
                $(".cuerpo_pdf").attr('data', url);


            });

            /*Reportes*/
            $(document).on('click', '.todos', function () {
                if ($(this).is(':checked')) {
                    $(this).parents('div.all').find('input').not(".todos").attr('disabled', true);
                } else {
                    $(this).parents('div.all').find('input').not(".todos").attr('disabled', false);
                }
            });

            $(document).on('click', '.todos_auto', function () {


                if ($(this).is(':checked')) {
                    $(this).parents('div.all').find('span').find('input').not(".todos").attr('disabled', true);
                } else {
                    $(this).parents('div.all').find('span').find('input').not(".todos").attr('disabled', false);
                }
            });

            $(document).on('mouseover', '.examinar_solicitud', function () {

                fila = $(this);

                url = 'anadir/parametros/consulta_rep_solicitud';
                $.get(url, {codigo: $(this).parent().parent().find('.eso_codigo').val() + '-' + $(this).parent().parent().find('td.sso_codigo').html()}, function (data) {
                    $(fila).tooltip({
                        title: data
                    });
                });

            });
            $(document).on('mouseover', '.examinar_tarea', function () {

                fila = $(this);

                url = 'anadir/parametros/consulta_rep_tarea';
                $.get(url, {codigo: $(this).parent().parent().find('td.dss_correlativo').html() + '-' + $(this).parent().parent().find('.eta_codigo').val() + '-' + $(this).parent().parent().find('td.sso_codigo').html()}, function (data) {
                    $(fila).tooltip({
                        title: data
                    });
                });

            });

            $(document).on('click', '.examinar_tarea', function () {
                $('.cuerpo_detalle_tarea').empty();

                url = 'anadir/parametros/consulta_detalle_tarea';
                $.get(url, {codigo: $(this).parent().parent().find('td.dss_correlativo').html() + '-' + $(this).parent().parent().find('td.sso_codigo').html()}, function (data) {
                    $('.cuerpo_detalle_tarea').append(data);
                });

            });

            $(document).on('click', '.examinar_mis_tarea', function () {

                $('.cuerpo_detalle_tarea').empty();

                url = 'anadir/parametros/consulta_detalle_tarea';
                $.get(url, {codigo: $(this).parent().parent().find('td.dss_correlativo b').html() + '-' + $(this).parent().parent().find('td.sso_codigo b').html()}, function (data) {
                    $('.cuerpo_detalle_tarea').append(data);
                });


            });

            /*correo*/

            $(document).on('click', '.correo_no_leido', function () {


                url = 'anadir/parametros/marcar_correo_no_leido';
                $.get(url, {codigo: $(this).parent().parent().find('.id_email').html()}, function (data) {
                    $(fila).tooltip({
                        title: data
                    });
                });

            });

            $(document).on('click', '.solicitud_correo', function () {
                $('.det_problema').val('');
                $('.det_problema').val($(this).parent().parent().find('td.cuerpo').html());

                $('.cuerpo_sol_correo').empty();
                url = 'anadir/parametros/solicitud_correo';

                $.get(url, {correo: $(this).parent().parent().find('td.sso_correo').html() + '|' +
                            $(this).parent().parent().find('td.mae_nombre').html() + '|' +
                            $(this).parent().parent().find('td.id_email').html() + '|' +
                            $(this).parent().parent().find('td.fecha_ing').html()
                }, function (data) {
                    $('.cuerpo_sol_correo').append(data);
                });

            });

            /*Ingreso solicitud correo*/
            $('form.sol_correo').on('submit', function (evt) {
                $('.log_error').empty();
                evt.preventDefault();
                val = true;

                if ($(this).find('.problema').val() === 'null') {
                    msg = 'Debe seleccionar el área del problema.';
                    val = false;
                }

                if (val) {
                    $('.log_error').remove();
                    $(this).off('submit').submit();
                } else {
                    $('.log_error').css('display', 'block').append('<i class="icon fa fa-ban"></i> ' + msg);
                    return false;
                }
            });

            /*Reportes*/
            $(".ver_graficos_solicitud").click(function () {

                if ($(this).is(':checked')) {
                    $("#morris-donut-chart").empty();
                    $("#morris-bar-chart").empty();

                    $.getJSON("anadir/parametros/genera_graf1_solicitud", function (data) {
                        Morris.Donut({
                            element: 'morris-donut-chart',
                            data: data, // $.get('ajax/graficos/genera_grafico_servicios.php'),
                            resize: true
                        });
                    });

                    $.getJSON("anadir/parametros/genera_graf2_solicitud", function (data) {
                        Morris.Bar({
                            element: 'morris-bar-chart',
                            data: data,
                            xkey: 'title',
                            ykeys: ['label', 'value'],
                            labels: ['', 'Solicitudes'],
                            hideHover: 'auto',
                            resize: true
                        });
                    });


                    $("#det_graf").fadeToggle("slow");

                } else {
                    $("#det_graf").fadeToggle("slow");
                }
            });


            $(".ver_graficos_problema").click(function () {

                if ($(this).is(':checked')) {

                    $("#morris-bar-chart1").empty();
                    $("#morris-bar-chart2").empty();

                    $.getJSON("anadir/parametros/genera_graf_tareas_frecuentes", function (data) {
                        var i = 0;
                        Morris.Bar({
                            element: 'morris-bar-chart1',
                            data: data,
                            xkey: 'title',
                            ykeys: ['value'],
                            labels: ['Cant. Solicitudes'],
                            hideHover: 'auto',
                            barColors: function (row, series, type) {
                                if (i > 9) {
                                    i = 0;
                                }

                                arrayColors = ["#052A47", "#084676", "#0B62A4", "#0D72BF", "#108DEE", "#2799F1", "#56AFF4", "#87C6F7", "#B6DCFA", "#E7F3FD"];
                                if (type === 'bar') {
                                    return arrayColors[i++];
                                }
                                else {
                                    return '#000';
                                }
                            },
                            resize: true

                        });

                    });

                    /*$.getJSON("anadir/parametros/genera_graf_tareas_frecuentes", function (data) {
                     Morris.Donut({
                     element: 'morris-bar-chart1',
                     data: data, // $.get('ajax/graficos/genera_grafico_servicios.php'),
                     resize: true
                     });
                     });
                     */
                    $.getJSON("anadir/parametros/genera_tiempo_por_tarea", function (data) {
                        var i = 0;
                        Morris.Bar({
                            element: 'morris-bar-chart2',
                            data: data,
                            xkey: 'title',
                            ykeys: ['value'],
                            labels: ['Tiempo Promedio'],
                            hideHover: 'auto',
                            barColors: function (row, series, type) {
                                if (i > 9) {
                                    i = 0;
                                }

                                arrayColors = ["#052A47", "#084676", "#0B62A4", "#0D72BF", "#108DEE", "#2799F1", "#56AFF4", "#87C6F7", "#B6DCFA", "#E7F3FD"];
                                if (type === 'bar') {
                                    return arrayColors[i++];
                                }
                                else {
                                    return '#000';
                                }
                            },
                            resize: true,
                            postUnits: ' minutos'
                        });
                    });

                    $("#det_graf").fadeToggle("slow");

                } else {
                    $("#det_graf").fadeToggle("slow");
                }
            });

            $(".ver_graficos_encuesta").click(function () {

                if ($(this).is(':checked')) {
                    $("#morris-donut-chart").empty();
                    $("#morris-bar-chart").empty();

                    $.getJSON("anadir/parametros/genera_graf1_encuesta", function (data) {
                        Morris.Donut({
                            element: 'morris-donut-chart',
                            data: data, // $.get('ajax/graficos/genera_grafico_servicios.php'),
                            resize: true
                        });
                    });


                    $.getJSON("anadir/parametros/genera_graf2_encuesta", function (data) {
                        var area = new Morris.Area({
                            element: 'morris-bar-chart',
                            resize: true,
                            data: data, 
                            xkey: 'y',
                            ykeys: ['item1', 'item2'],
                            labels: ['Nivel', 'Puntaje'],
                            parseTime: false,

                            fillOpacity: 0.6,
                            hideHover: 'auto',
                            behaveLikeLine: true,
                            lineColors: ['#a0d0e0', '#3c8dbc'],
                        });
                    });
                    $("#det_graf").fadeToggle("slow");

                } else {
                    $("#det_graf").fadeToggle("slow");
                }
            });

            $(".ver_graficos_tareas").click(function () {

                if ($(this).is(':checked')) {
                    $("#morris-donut-chart").empty();
                    $("#morris-bar-chart").empty();
                    $("#graph_rounded").empty();
                    $.getJSON("anadir/parametros/genera_graf1_tarea", function (data) {
                        Morris.Donut({
                            element: 'morris-donut-chart',
                            data: data, // $.get('ajax/graficos/genera_grafico_servicios.php'),
                            resize: true
                        });
                    });

                    $.getJSON("anadir/parametros/genera_graf2_tarea", function (data) {
                        Morris.Bar({
                            element: 'graph_rounded',
                            data: data,
                            xkey: 'x',
                            ykeys: ['y'],
                            labels: ['Término en (min)'],
                            hideHover: 'auto',
                            resize: true
                        });
                    });

                    $.getJSON("anadir/parametros/genera_graf3_tarea", function (data) {
                        Morris.Donut({
                            element: 'morris-bar-chart',
                            data: data,
                            resize: true
                        });
                    });
                    $("#det_graf").fadeToggle("slow");

                } else {
                    $("#det_graf").fadeToggle("slow");
                }

            });

            /* Pasa a paso*/
            //$.fn.wizard.logging = true;
            var wizard = $('#satellite-wizard').wizard({
                keyboard: false,
                contentHeight: 400,
                contentWidth: 700,
                backdrop: 'static'
            });

            wizard.on('closed', function () {
                wizard.reset();
                //  $('#wrapper').load('/web/solicitud');
            });

            wizard.on("reset", function () {
                wizard.modal.find(':input').val('').removeAttr('disabled');
                wizard.modal.find('.form-group').removeClass('has-error').removeClass('has-succes');
                wizard.modal.find('#fqdn').data('is-valid', 0).data('lookup', 0);
            });

            wizard.on("submit", function (wizard) {
                $('.log_error').empty();
                $('.result_ok').empty();
                $('.log_error').css('display', 'block');
                $.ajax({
                    url: "ingresar/solicitud",
                    type: "GET",
                    data: wizard.serialize(),
                    success: function (data) {
                        retorno = data.split('-');


                        if (retorno[1] === '1') {
                            $('.log_error').append(retorno[0]);
                            wizard.submitError();
                            wizard.hideButtons();
                            wizard.updateProgressBar(0);
                        } else {
                            $('.result_ok').append(retorno[0]);
                            wizard.submitSuccess();
                            wizard.hideButtons();
                            wizard.updateProgressBar(0);
                            $('#wrapper').load('solicitud');
                        }


                    },
                    error: function () {
                        wizard.submitError();
                        wizard.hideButtons();
                        wizard.updateProgressBar(0);
                    }
                });
            });

            wizard.el.find(".im-done").click(function () {


                wizard.hide();
                setTimeout(function () {
                    wizard.reset();
                }, 250);

            });

            wizard.el.find(".create-another-server").click(function () {

                wizard.reset();
            });

            $(".wizard-group-list").click(function () {
                alert("Disabled for demo.");
            });

            $('#open-wizard').click(function (e) {
                e.preventDefault();
                wizard.show();
            });
        });

        $(document).on('click', '.cola_modifica', function () {

            $('.segun_origen_modifica').fadeOut();
            url = 'anadir/parametros/elemento_tarea';


            $.get(url, {opr_codigo: $(this).val()}, function (data) {
                $('.segun_origen_modifica').empty();
                $('.segun_origen_modifica').append(data).fadeIn();
            });

        });

        function lookup() {

            // Normally a ajax call to the server to preform a lookup
            $('#mae_nombre').data('lookup', 1);
            $('#mae_nombre').data('is-valid', 1);
            $('#mae_solicitado_por').val($('#mae_nombre').val());
        }
        ;
        function validateServerLabel(el) {

            var name = el.val();

            var retValue = {};

            if (name == "") {
                retValue.status = false;
                retValue.msg = "Complete el campo.";
            } else {
                retValue.status = true;
            }

            return retValue;
        }
        ;
        function validateFQDN(el) {

            var $this = $(el);
            var retValue = {};

            if ($this.is(':disabled')) {
                // FQDN Disabled
                retValue.status = true;
            } else {


                /* if ($this.data('lookup') === 0) {
                 retValue.status = false;
                 retValue.msg = "Preform lookup first";
                 } else {*/
                if ($this.data('is-valid') === 0) {
                    retValue.status = false;
                    retValue.msg = "Lookup Failed";
                } else {
                    retValue.status = true;
                }
                //}
            }

            return retValue;
        }
        ;