/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author
 */


$(window).on('load', function () {

    $('#tabla_calculos_actualizados').hide();
    var  url_llenar_departamento_actualizar_calculos = 'actualizar_calculos/llenar_departamento_actualizar_calculos';

    $.getJSON(url_llenar_departamento_actualizar_calculos,function (data_depto_actualizar_calculo) {
        $.each(data_depto_actualizar_calculo,function (r,d) {

            $('#select_depto_actualizar_calculos').append("select_depto_actualizar_calculos" +
                '<option value="'+d[0]+'">'+d[0]+'</option>')
            });
        });


});

//Boton Cargar datos para calcular.
$('#btn_calcular_actualizar_calculos').on('click',function () {

    $('#tabla_calculos_actualizados_nuevos > tbody').empty();

    if ( $('#select_depto_actualizar_calculos').val() != 0){

        $('#popup_carga_actualizar_calculos').modal('show');
        $('#contador_factor_tipo_cambio').html(0);

       var depto_select = $('#select_depto_actualizar_calculos').val();

       $('#tabla_calculos_actualizados_nuevos > tbody').empty();
       $('#tabla_calculos_actualizados').show();

       var flag_cont_tabla_calculos = 0 ;
       var  url_traer_datos_para_calcular_query = 'actualizar_calculos/traer_datos_para_calcular_query';
       var  url_traer_factor = 'actualizar_calculos/traer_factor';
       var  url_traer_tipo_cambio = 'actualizar_calculos/traer_tipo_cambio';

        $.getJSON(url_traer_datos_para_calcular_query,{DEPTO:depto_select},function (data_calcular_query) {

            $.each(data_calcular_query,function (i,c) {
                $('#tabla_calculos_actualizados_nuevos').append(

                    '<tr>' +
                    '<td id="ID_ACTUALIZAR_CALCULOS_'+c[0]+'">'+c[0]+'</td>' +
                    '<td id="VENTANA_'+c[0]+'">'+c[1]+'</td>' +
                    '<td id="UNID_'+c[0]+'">'+c[2]+'</td>' +
                    '<td id="VIA_'+c[0]+'">'+c[3]+'</td>' +
                    '<td id="PAIS_'+c[0]+'">'+c[4]+'</td>' +
                    '<td id="MKUP_'+c[0]+'">'+c[5]+'</td>' +
                    '<td id="P_BLANCO_'+c[0]+'">'+c[6]+'</td>' +
                    '<td id="MONEDA_'+c[0]+'">'+c[7]+'</td>' +
                    '<td id="TARGET_'+c[0]+'">'+c[8]+'</td>' +
                    '<td id="FOB_'+c[0]+'">'+c[9]+'</td>' +
                    '<td id="COSTO_INSP_'+c[0]+'">'+c[10]+'</td>' +
                    '<td id="COSTO_RFID'+c[0]+'">'+c[11]+'</td>' +
                    '<td id="UNID_UNIT_US_'+c[0]+'">'+c[12]+'</td>' +
                    '<td id="UNID_UNIT_S_'+c[0]+'">'+c[13]+'</td>' +
                    '<td id="TOTAL_TARGET_'+c[0]+'">'+c[14]+'</td>' +
                    '<td id="TOTAL_FOB_'+c[0]+'">'+c[15]+'</td>' +
                    '<td id="COSTO_'+c[0]+'">'+c[16]+'</td>' +
                    '<td id="RETAIL_'+c[0]+'">'+c[17]+'</td>' +
                    '<td id="GMB_'+c[0]+'">'+c[18]+'</td>' +
                    '</tr>');
                flag_cont_tabla_calculos++;
            });
            carga_factor_calculos(flag_cont_tabla_calculos);

            $.each(data_calcular_query,function (i,c) {
                //valida si existe ventana
                if ((c[1] != '') || (c[1] != null) || (c[1] != 0) ) {

                    $.getJSON(url_traer_factor, {VENTANA_LLEGADA: c[1], DEPTO: depto_select, PAIS: c[4], VIA: c[3], COD_TIP_MON: c[7]}, function (data_factor) {
                        if (( data_factor != '') && ( data_factor != null) && ( data_factor != 0) ) {
                            $('#GMB_' + c[0]).after(
                                '<td id="FACTOR_' + c[0] + '">' + data_factor[0]['VENTANA_FACTOR'] + '</td>'+
                                $('#contador_factor_tipo_cambio').html( parseInt($('#contador_factor_tipo_cambio').html())+1)
                            );
                        }else {
                            $.getJSON(url_traer_tipo_cambio, {VENTANA_LLEGADA: c[1], COD_TIP_MON: c[7]}, function (data_tipo_cambio) {
                                $('#GMB_' + c[0]).after(
                                    '<td id="TIPO_CAMBIO_' + c[0] + '">' + data_tipo_cambio[0]['VENTANA_TIPO_CAMBIO'] + '</td>'+
                                    $('#contador_factor_tipo_cambio').html( parseInt($('#contador_factor_tipo_cambio').html())+1)
                                );
                            });
                        }
                    });
                }
                else{
                    alert("Hay Registros sin ventanas de llegadas.");
                }
            });

        }).done(function () {
            $('#accion_cargar_datos_para_calcular').removeClass('fa fa-refresh');
            $('#accion_cargar_datos_para_calcular').addClass('fa fa-check');
        });


    } else {
        alert ("Debe seleccionar un Departamento");
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
                            $(this).find("td:eq(15)").html( Math.round(((fob+insp+rfid)*unid)) );

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
                        $(this).find("td:eq(14)").html( Math.round((target_gral+insp_gral+rfid_gral)*unid_gral));

                        if ($(this).find("td:eq(7)").html() != 0 ){
                            $(this).find("td:eq(5)").html( ((precio_blanco_gral/1.19)/costo_total_unitario_pesos).toLocaleString(noTruncarDecimales)); // (precio blanco (7)/1.19)/costo unid $ (14)
                            $(this).find("td:eq(18)").html(  ((((precio_blanco_gral/1.19)-costo_total_unitario_pesos)/(precio_blanco_gral/1.19))*100).toLocaleString(noTruncarDecimales)   ); // (precio blanco (7)/1.19)/costo unid $ (14)/precio blanco/1.19)
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

        var id_color3 = $(this).find("td:eq(0)").html();
        var mkup = parseFloat($(this).find("td:eq(5)").html());
        var GMB_actualizado = parseFloat($(this).find("td:eq(18)").html());
        var COSTO_UNIT = $(this).find("td:eq(12)").html() ;
        var COSTO_UNITS = $(this).find("td:eq(13)").html() ;
        var CST_TOTLTARGET = $(this).find("td:eq(14)").html();
        var COSTO_TOT = $(this).find("td:eq(15)").html(); // total FOB
        var COSTO_TOTS = $(this).find("td:eq(16)").html();
        var RETAIL_actual = $(this).find("td:eq(17)").html();

        $.getJSON(url_actualizar_calculos_depto,{DEPTO:depto_select,ID_COLOR3:id_color3,MKUP:mkup,GMB:GMB_actualizado,COSTO_UNITARIO_US:COSTO_UNIT,COSTO_UNITARIO_PESO:COSTO_UNITS,TOTAL_TARGET:CST_TOTLTARGET,TOTAL_FOB:COSTO_TOT,COSTO_TOTAL_PESO:COSTO_TOTS,RETAIL:RETAIL_actual}).done(function () {
            //creo un span que se sumara
            parseFloat($('#contador_update').html(parseFloat($('#contador_update').html())+1));
            //alert ("pasa 1 ?");

        });

        $.getJSON(url_actualizar_calculos_depto_CIC,{DEPTO:depto_select,ID_COLOR3:id_color3,MKUP:mkup,GMB:GMB_actualizado,COSTO_UNITARIO_US:COSTO_UNIT,COSTO_UNITARIO_PESO:COSTO_UNITS,TOTAL_TARGET:CST_TOTLTARGET,TOTAL_FOB:COSTO_TOT,COSTO_TOTAL_PESO:COSTO_TOTS,RETAIL:RETAIL_actual}).done(function () {
            //creo un span que se sumara
            parseFloat($('#contador_update').html(parseFloat($('#contador_update').html())+1));
            //alert ("pasa 1 ?");

        });
    });


    //llamar a la funcion para validar
    validar_update_actualizar_calculos();
});

//cronometro para validar los update estan realizados
function validar_update_actualizar_calculos() {

    var contador_seg_carga = 0;

    var nfilas = $('#tabla_calculos_actualizados_nuevos > tbody > tr').length;
    nfilas = nfilas*2;
    var seg_update = document.getElementById("segundos_update");

    var cronometro_update = setInterval(
        function () {

            var cont_update = parseFloat($('#contador_update').html());

            if (contador_seg_carga == 6) {
                contador_seg_carga = 0;
            }

            if (contador_seg_carga == 5) {
                if (cont_update == nfilas ){
                    $('#popup_carga_update').modal('hide');
                    alert ("Se han actualizado los registros");
                    clearInterval(cronometro_update);
                }

            }

            seg_update.innerHTML = contador_seg_carga;
            contador_seg_carga++;

        },1000);

}
