/*! Controlador Jquery
 * Mantenedores del MAIN
 * @Author
 */


$(window).on('load', function () {


    $('#div_cont_tabla_calculos_nuevos').hide();
    var  url_llenar_departamento_actualizar_calculos = 'actualizar_calculos/llenar_departamento_actualizar_calculos';

    $.getJSON(url_llenar_departamento_actualizar_calculos,function (data_depto_actualizar_calculo) {
        $.each(data_depto_actualizar_calculo,function (r,d) {

            $('#select_depto_actualizar_calculos').append("select_depto_actualizar_calculos" +
                '<option value="'+d[0]+'">'+d[0]+'</option>');
        });
    });


});

//Boton Cargar datos para calcular.
$('#btn_calcular_actualizar_calculos').on('click',function () {

    $('#accion_cargar_datos_para_calcular').addClass('fa fa-refresh');
    $('#accion_calcular_datos').addClass('fa fa-refresh');

    var depto_select = $('#select_depto_actualizar_calculos').val();
    var unidades_selec = $('#select_unid_actualizar_calculos').val();

    $('#tabla_calculos_actualizados_nuevos > tbody').empty();

    if ( (depto_select != 0) && (unidades_selec != 0) ) {

        $('#div_cont_tabla_calculos_nuevos').show();
        $('#popup_carga_actualizar_calculos').modal('show');
        $('#contador_factor_tipo_cambio').html(0);

        $('#tabla_calculos_actualizados_nuevos > tbody').empty();
        $('#tabla_calculos_actualizados').show();
        $('#accion_cargar_datos_para_calcular').removeClass('fa fa-spinner');
        $('#accion_cargar_datos_para_calcular').addClass('fa fa-spinner fa-2x fa-spin');
        $('#accion_calcular_datos').removeClass('fa fa-spinner');
        $('#accion_calcular_datos').addClass('fa fa-spinner fa-2x fa-spin');

        var flag_cont_tabla_calculos = 0;
        var url_traer_datos_para_calcular_query = 'actualizar_calculos/traer_datos_para_calcular_query';

        $.getJSON(url_traer_datos_para_calcular_query, {DEPTO: depto_select, UNID: unidades_selec}, function (data_calcular_query) {
            $('#accion_cargar_datos_para_calcular').removeClass('fa fa-spinner');
            $('#accion_cargar_datos_para_calcular').addClass('fa fa-check');
            $.each(data_calcular_query, function (i, c) {
                $('#tabla_calculos_actualizados_nuevos').append(
                    '<tr>' +
                    '<td align="center" class="ids"  id="ID_ACTUALIZAR_CALCULOS_' + c[0] + '">' + c['ID_COLOR3'] + '</td>' +
                    '<td align="center" class="columnas" id="DEPTO_' + c[0] + '">' + c['DEP_DEPTO'] + '</td>' +
                    '<td align="center" class="columnas" id="VENTANA_' + c[0] + '">' + c['NOM_VENTANA'] + '</td>' +
                    '<td align="center" class="columnas" id="UNID_' + c[0] + '">' + c['UNIDADES'] + '</td>' +
                    '<td class="columnas" id="VIA_' + c[0] + '">' + c['VIA'] + '</td>' +
                    '<td class="columnas" id="PAIS_' + c[0] + '">' + c['PAIS'] + '</td>' +
                    '<td align="center" id="MKUP_' + c[0] + '">' + c['MKUP'] + '</td>' +
                    '<td align="center" class="columnas" id="P_BLANCO_' + c[0] + '">' + c['PRECIO_BLANCO'] + '</td>' +
                    '<td align="center" id="GMB_' + c[0] + '">' + c['GMB'] + '</td>' +
                    '<td id="MONEDA_' + c[0] + '">' + c['COD_TIP_MON'] + '</td>' +
                    '<td align="center" id="FACTOR_' + c[0] + '">' + c['FACTOR'] + '</td>' +
                    '<td class="columnas" id="TARGET_' + c[0] + '">' + c['COSTO_TARGET'] + '</td>' +
                    '<td class="columnas" id="FOB_' + c[0] + '">' + c['COSTO_FOB'] + '</td>' +
                    '<td class="columnas" id="COSTO_INSP_' + c[0] + '">' + c['COSTO_INSP'] + '</td>' +
                    '<td class="columnas" id="COSTO_RFID' + c[0] + '">' + c['COSTO_RFID'] + '</td>' +
                    '<td align="center" id="UNID_UNIT_US_' + c[0] + '">' + c['COSTO_UNIT'] + '</td>' +
                    '<td align="center" id="UNID_UNIT_S_' + c[0] + '">' + c['COSTO_UNITS'] + '</td>' +
                    '<td align="center" id="TOTAL_TARGET_' + c[0] + '">' +c['CST_TOTLTARGET'] + '</td>' +
                    '<td align="center" id="TOTAL_FOB_' + c[0] + '">' + c['COSTO_TOT'] + '</td>' +
                    '<td align="center" id="COSTO_' + c[0] + '">' + c['COSTO_TOTS'] + '</td>' +
                    '<td align="center" id="RETAIL_' + c[0] + '">' + c['RETAIL'] + '</td>' +
                    '</tr>');
                flag_cont_tabla_calculos++;
            });
           // carga_factor_calculos(flag_cont_tabla_calculos);

           /* $.each(data_calcular_query, function (i, c) {
                //valida si existe ventana
                if ((c[1] != '') || (c[1] != null) || (c[1] != 0)) {

                    $.getJSON(url_traer_factor, {VENTANA_LLEGADA: c[1], DEPTO: depto_select, PAIS: c[4], VIA: c[3], COD_TIP_MON: c[7]
                    }, function (data_factor) {
                        if ((data_factor != '') && (data_factor != null) && (data_factor != 0)) {
                            $('#GMB_' + c[0]).after(
                                '<td id="FACTOR_' + c[0] + '">' + data_factor[0]['VENTANA_FACTOR'] + '</td>' +
                                $('#contador_factor_tipo_cambio').html(parseInt($('#contador_factor_tipo_cambio').html()) + 1)
                            );
                        } else {
                            $.getJSON(url_traer_tipo_cambio, {VENTANA_LLEGADA: c[1], COD_TIP_MON: c[7]
                            }, function (data_tipo_cambio) {
                                $('#GMB_' + c[0]).after(
                                    '<td id="TIPO_CAMBIO_' + c[0] + '">' + data_tipo_cambio[0]['VENTANA_TIPO_CAMBIO'] + '</td>' +
                                    $('#contador_factor_tipo_cambio').html(parseInt($('#contador_factor_tipo_cambio').html()) + 1)
                                );
                            });
                        }
                    });
                }
                else {
                    alert("Hay Registros sin ventanas de llegadas.");
                }
            });
*/
        }).done(function () {

            $('#tabla_calculos_actualizados_nuevos').DataTable({
                "order": [1,'asc'],
                retrieve: true,
                destroy: true,
                paging: false,
                scrollY: "400px",
                scrollX: "400px",
                "searching": false,
                "info": false,
                scrollCollapse: true,
                fixedColumns:{
                    leftColumns: 1
                }
            });



            $('#accion_calcular_datos').removeClass('fa fa-spinner');
            $('#accion_calcular_datos').addClass('fa fa-check');




            $("#btn_actualizar_calculos").attr("disabled", false);

            var delay_cerrar_popup_actualizar_calculos = 2000;
            setTimeout(function () {
                $('#popup_carga_actualizar_calculos').modal('hide');
            }, delay_cerrar_popup_actualizar_calculos);

        });

    } else {
        alert("seleccione unidades y departamento ");
    }

});

//cronometro que valida si los factores estan cargados
function carga_factor_calculos(flag_cont_tabla_calculos) {

    var contador_seg_carga = 0;

    var cont_reg = flag_cont_tabla_calculos;

    var seg_cal = document.getElementById("segundos_calculos");

    var cronometro = setInterval(
        function () {

            var cont_factor_tipo = parseInt($('#contador_factor_tipo_cambio').html());

            if (contador_seg_carga == 6) {
                contador_seg_carga = 0;
            }

            if (contador_seg_carga == 5) {
                if (cont_reg == cont_factor_tipo){

                    //detener el cronometro (no preguntar mas)
                    clearInterval(cronometro);

                    //dar propiedades de datatable
                    $('#tabla_calculos_actualizados_nuevos').DataTable({
                        retrieve: true,
                        destroy: true,
                        paging: false,
                        scrollY: "400px",
                        scrollX: "400px",
                        "searching": false,
                        "info": false,
                        scrollCollapse: true
                    });

                    const noTruncarDecimales = {maximumFractionDigits: 2};

                    //recorrer la tabla, sacar calculos y asignarlos (a una tabla nueva)(o a la misma tabla)
                    $("#tabla_calculos_actualizados_nuevos > tbody >tr").each(function () {

                        if ($(this).find("td:eq(9)").html() == 0 ){

                            var insp_target = parseFloat($(this).find("td:eq(10)").html());
                            var rfid_target = parseFloat($(this).find("td:eq(11)").html());
                            var factor_tc = parseFloat($(this).find("td:eq(19)").html());
                            var target = parseFloat($(this).find("td:eq(8)").html());

                            //conto unitario final pesos
                            //TC * (target+insp+rfid)
                            $(this).find("td:eq(13)").html(    Math.round(  (factor_tc* (target+insp_target+rfid_target) )  )    );

                            //costo total (costo fob)
                            //si el fob es 0 costo total (costo fob = 0)
                            $(this).find("td:eq(15)").html(0);


                        }else {

                            var unid = parseFloat($(this).find("td:eq(2)").html());
                            var insp = parseFloat($(this).find("td:eq(10)").html());
                            var rfid = parseFloat($(this).find("td:eq(11)").html());
                            var factor = parseFloat($(this).find("td:eq(19)").html());
                            var fob = parseFloat($(this).find("td:eq(9)").html());

                            //consto unitario final pesos
                            //factor * (fob+insp+rfid)
                            $(this).find("td:eq(13)").html( Math.round(   (factor * (fob + insp + rfid))   ) );

                            //Costo total (Total Fob)
                            // Si el fob no es 0  ((fob+insp+rfid)*unidades)
                            $(this).find("td:eq(15)").html( parseFloat(((fob+insp+rfid)*unid)).toFixed(2) );

                        }

                        var unid_gral = parseFloat($(this).find("td:eq(2)").html());
                        var target_gral = parseFloat($(this).find("td:eq(8)").html());
                        var precio_blanco_gral = parseFloat($(this).find("td:eq(6)").html());
                        var insp_gral = parseFloat($(this).find("td:eq(10)").html());
                        var rfid_gral = parseFloat($(this).find("td:eq(11)").html());
                        var costo_total_unitario_pesos = parseFloat($(this).find("td:eq(13)").html());

                        //costo total en pesos
                        //costo unitario final pesos * can unidades
                        $(this).find("td:eq(16)").html($(this).find("td:eq(2)").html()*$(this).find("td:eq(13)").html());

                        //retail
                        //(precio blanco * can unidades)/1.19
                        $(this).find("td:eq(17)").html( Math.round(($(this).find("td:eq(6)").html()*$(this).find("td:eq(2)").html())/1.19) );

                        //total Taget
                        //(target+insp+rfid)*can unidades
                        //aproximar ?
                        $(this).find("td:eq(14)").html( parseFloat((target_gral+insp_gral+rfid_gral)*unid_gral).toFixed(2));

                        if ($(this).find("td:eq(7)").html() != 0 ){
                            $(this).find("td:eq(5)").html(  parseFloat(((precio_blanco_gral/1.19)/costo_total_unitario_pesos).toLocaleString(noTruncarDecimales)).toFixed(2) ); // (precio blanco (7)/1.19)/costo unid $ (14)
                            $(this).find("td:eq(18)").html(  parseFloat((((precio_blanco_gral/1.19)-costo_total_unitario_pesos)/(precio_blanco_gral/1.19))*100).toFixed(2)   ); // (precio blanco (7)/1.19)/costo unid $ (14)/precio blanco/1.19)
                        }


                    });

                    $('#accion_calcular_datos').removeClass('fa fa-refresh');
                    $('#accion_calcular_datos').addClass('fa fa-check');

                    $("#btn_actualizar_calculos").attr("disabled", false);

                    var delay_cerrar_popup_actualizar_calculos = 2000;
                    setTimeout(function () {
                        $('#popup_carga_actualizar_calculos').modal('hide');
                    }, delay_cerrar_popup_actualizar_calculos);



                }
            }

            seg_cal.innerHTML = contador_seg_carga;
            contador_seg_carga++;

        },1000);
}

//boton que manda fila por fila actualizando
$('#btn_actualizar_calculos').on('click',function () {

    $('#contador_update').html(0);

    $('#popup_carga_update').modal('show');

    var depto_select = $('#select_depto_actualizar_calculos').val();
    var url_actualizar_calculos_depto = 'actualizar_calculos/actualizar_calculos_departamento';
    var url_actualizar_calculos_depto_CIC = 'actualizar_calculos/actualizar_calculos_departamento_CIC';

    $("#tabla_calculos_actualizados_nuevos >tbody >tr").each(function () {

        var Id_color3 = $(this).find("td:eq(0)").html();
        var departmentos = $(this).find("td:eq(1)").html();
        var COSTO_UNIT = $(this).find("td:eq(15)").html() ;
        var COSTO_UNITS = $(this).find("td:eq(16)").html() ;
        var CST_TOTLTARGET = $(this).find("td:eq(17)").html();
        var COSTO_TOT = $(this).find("td:eq(18)").html(); // total FOB
        var COSTO_TOTS = $(this).find("td:eq(19)").html();
        var RETAIL_actual = $(this).find("td:eq(20)").html();
        var mkup = parseFloat($(this).find("td:eq(6)").html());
        var GMB_actualizado = parseFloat($(this).find("td:eq(8)").html());
        var nfilas = $('#tabla_calculos_actualizados_nuevos > tbody > tr').length;

        $.getJSON(url_actualizar_calculos_depto,{DEPTO:departmentos,ID_COLOR3:Id_color3,MKUP:mkup,GMB:GMB_actualizado,COSTO_UNITARIO_US:COSTO_UNIT,COSTO_UNITARIO_PESO:COSTO_UNITS,TOTAL_TARGET:CST_TOTLTARGET,TOTAL_FOB:COSTO_TOT,COSTO_TOTAL_PESO:COSTO_TOTS,RETAIL:RETAIL_actual}, function (data1){

            if (data1[0] == "True") {
                var _span1 = $('#count').html();
                var _int1 = data1[1];
                var  _total1 = Number(_span1) + Number(_int1);
                $('#seguimiento').html("Actualizando Registros: ("+departmentos+") (" +_total1+ "/" + nfilas +")." );
                $('#count').html(_total1);
            }

        }).done(function () {
            //creo un span que se sumara
            parseFloat($('#contador_update').html(parseFloat($('#contador_update').html())+1));
            //alert ("pasa 1 ?");

        });

      /*  $.getJSON(url_actualizar_calculos_depto_CIC,{DEPTO:departmentos,ID_COLOR3:Id_color3,MKUP:mkup,GMB:GMB_actualizado,COSTO_UNITARIO_US:COSTO_UNIT,COSTO_UNITARIO_PESO:COSTO_UNITS,TOTAL_TARGET:CST_TOTLTARGET,TOTAL_FOB:COSTO_TOT,COSTO_TOTAL_PESO:COSTO_TOTS,RETAIL:RETAIL_actual}).done(function () {
            //creo un span que se sumara
            parseFloat($('#contador_update').html(parseFloat($('#contador_update').html())+1));
            //alert ("pasa 1 ?");

        });*/
    });


    //llamar a la funcion para validar
    validar_update_actualizar_calculos();
});

//cronometro para validar los update estan realizados
function validar_update_actualizar_calculos() {

    var contador_seg_carga = 0;

    var nfilas = $('#tabla_calculos_actualizados_nuevos > tbody > tr').length;
    nfilas = nfilas;
    var seg_update = document.getElementById("segundos_update");

    var cronometro_update = setInterval(
        function () {

            var cont_update = parseFloat($('#contador_update').html());

            if (contador_seg_carga == 6) {
                contador_seg_carga = 0;
            }

            if (contador_seg_carga == 5) {
                if (cont_update == nfilas ){
                    $('#seguimiento').html("Actualizando Registros:" );
                    $('#count').html(0);
                    $('#popup_carga_update').modal('hide');
                    alert ("Se han actualizado los registros");
                    clearInterval(cronometro_update);
                }

            }

            seg_update.innerHTML = contador_seg_carga;
            contador_seg_carga++;

        },1000);

}

$('#btn_salir_main_actualizar_calculos').on('click', function () {

    var span_temp_volver_main_actualizar_calculos = $('#span_temporada_devolver_actualizar_calculos').text();
    span_temp_volver_main_actualizar_calculos = span_temp_volver_main_actualizar_calculos.replace(/[^a-z0-9\-]/gi,'');
    var separa_tempo_actualizar_calculos = span_temp_volver_main_actualizar_calculos.split("-");

    var temp_salir_volver_main_actualizar_calculos = separa_tempo_actualizar_calculos[1];

    window.location.href = "plan_compra?codigo="+temp_salir_volver_main_actualizar_calculos;

});