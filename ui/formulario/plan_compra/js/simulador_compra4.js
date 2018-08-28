/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 * @Editado Roberto Pérez (tienda, formato, curva, simulador de compra, match)
 */

// Document Ready
$(function () {

    //"use strict";
    validar_aviso_carga_de_simulador();

    /*ABRE POPUP MODAL PERFIL*/
    $('.eliminar_bmt').on('click', function () {
        $('.registro').html('<b> ' + $('.bmt').html() + ' </b>');
    });

    $('.actualiza_grid').on('click', function () {
        location.reload();
    });


    //combobox exportar bmt
    $('#tipos_export').on('change', function () {
        var tipo = $('#tipos_export').val();//variable que llamo a un combox o un text id html
        if (tipo == 3) {

            $("#bmt_export tbody").empty();

            var div1 = document.getElementById("assorment_export");
                div1.style.display = "none";
            var div2 = document.getElementById("depto_selec");
                div2.style.display = "none";
            var div4 = document.getElementById("depto_selec_opcion");
                div4.style.display = "none";
            var div3 = document.getElementById("body_export");
                div3.style.display = "";
            var url_tabla = 'ajax_simulador_cbx/checkboxgrupo';
            var flag_exporta_bmt = 0 ;

            $("#btn_exportar").attr("disabled", "disabled");

            $.getJSON(url_tabla, function (data) {
                $.each(data, function (i,o) {
                    $('#bmt_export').append('<tr class = "check_gr">\n' +
                            '<td class= "checkbox_grupo" id="txt_id_check'+flag_exporta_bmt+'"><input type="checkbox" id="checkbox_grupo" name="check[]" value="'+o[0]+'" onchange="validar()" ></td>\n' +
                            '<td class="ids" id="txt_id_'+flag_exporta_bmt+'">'+o[0]+'</td>\n' +
                            '</tr>');
                    flag_exporta_bmt++;
                    });

            });

        }
        else if (tipo == 2){

            $("#depto_tabla_selec tbody").empty();
            var div_assorment_c1 = document.getElementById("assorment_export");
            div_assorment_c1.style.display = "none";
            var div_depto_c1 = document.getElementById("depto_selec");
            div_depto_c1.style.display = "";
            var div_opcion_c1 = document.getElementById("depto_selec_opcion");
            div_opcion_c1.style.display = "none";
            var div_body_export_c1 = document.getElementById("body_export");
            div_body_export_c1.style.display = "none";
            $("#btn_exportar").attr("disabled", "disabled");

/*################################ trabajo de llenar tabla ########################*/
            var url_llenar_tabla_depto = 'ajax_simulador_cbx/llenar_tabla_depto';
            var flag_llenar_tabla_depto = 0 ;
            $.getJSON(url_llenar_tabla_depto, function (data) {
                $.each(data, function (i,o) {
                    $('#depto_tabla_selec').append('<tr>\n' +
                        '<td id="txt_id_check'+flag_llenar_tabla_depto+'"><input type="checkbox"  id="check_depto"  name="check_depto[]" value="'+o[0]+'" onchange="validarc1()"></td>\n' +
                        '<td class="ids" id="txt_id_'+flag_llenar_tabla_depto+'">'+o[0]+'</td>\n' +
                        '<td class="ids" id="txt_id_'+flag_llenar_tabla_depto+'">'+o[1]+'</td>\n' +
                        '</tr>');
                    flag_llenar_tabla_depto++;
                });
    });
/*################################ trabajo de llenar tabla ########################*/

        }
        else if (tipo == 4){

            $("#depto_tabla_selec tbody").empty();
            $("#depto_tabla_selec_opcion tbody").empty();

            $("#btn_exportar").attr("disabled", "disabled");
            var div_assorment_opcion = document.getElementById("assorment_export");
            div_assorment_opcion.style.display = "none";
            var div_depto_opcion = document.getElementById("depto_selec");
            div_depto_opcion.style.display = "";
            var div_opcion_opcion = document.getElementById("depto_selec_opcion");
            div_opcion_opcion.style.display = "";
            var  div_body_export_opcion = document.getElementById("body_export");
            div_body_export_opcion.style.display = "none";
            /*################################ trabajo de llenar tabla op-4  ########################*/
            var url_llenar_tabla_depto_opcion = 'ajax_simulador_cbx/llenar_tabla_depto';
            var flag_tabla_depto_opcion = 0 ;
            $.getJSON(url_llenar_tabla_depto_opcion, function (data) {
                $.each(data, function (i,o) {
                    $('#depto_tabla_selec').append('<tr>\n' +
                        '<td id="txt_id_check'+flag_tabla_depto_opcion+'"><input type="checkbox"  id="check_depto_estado"  name="check_depto_estado[]" value="'+o[0]+'" onchange="validarc1_estado_depto()"></td>\n' +
                        '<td class="ids" id="txt_id_'+flag_tabla_depto_opcion+'">'+o[0]+'</td>\n' +
                        '<td class="ids" id="txt_id_'+flag_tabla_depto_opcion+'">'+o[1]+'</td>\n' +
                        '</tr>');
                    flag_tabla_depto_opcion++;
                });
            });
            /*################################ trabajo de llenar tabla op 4 ########################*/
            var url_llenar_tabla_opcion = 'ajax_simulador_cbx/llenar_tabla_oc';
            var flag_llenar_tabla_opcion = 0 ;
            $.getJSON(url_llenar_tabla_opcion, function (data) {
                $.each(data, function (i,o) {
                    $('#depto_tabla_selec_opcion').append('<tr>\n' +
                        '<td id="toc_id_check'+flag_llenar_tabla_opcion+'"><input type="checkbox"  id="check_estado"  name="check_estado[]"  value="'+o[0]+'" onchange="validarc1_estado_depto()"></td>\n' +
                        '<td class="ids" id="oc_id_'+flag_llenar_tabla_opcion+'">'+o[1]+'</td>\n' +
                        '</tr>');
                    flag_llenar_tabla_opcion++;
                });
            });
        }
        else {
            $("#btn_exportar").attr("disabled", "disabled");
            $("#depto_tabla_selec tbody").empty();
            var div_assorment_assorment = document.getElementById("assorment_export");
            div_assorment_assorment.style.display = "none";
            var div_depto_assortment = document.getElementById("depto_selec");
            div_depto_assortment.style.display = "";
            var div_opcion_assortment = document.getElementById("depto_selec_opcion");
            div_opcion_assortment.style.display = "none";
            var div_body_export_assortment = document.getElementById("body_export");
            div_body_export_assortment.style.display = "none";
            $("#btn_exportar").attr("disabled", "disabled");
            /*################################ trabajo de llenar tabla ########################*/
            var url_exp_assortment_llenar_tabla_depto = 'ajax_simulador_cbx/llenar_tabla_depto';
            var flag_assortment_tabla_depto = 0 ;
            $.getJSON(url_exp_assortment_llenar_tabla_depto, function (data) {
                $.each(data, function (i,o) {
                    $('#depto_tabla_selec').append('<tr>\n' +
                        '<td id="txt_id_check'+flag_assortment_tabla_depto+'"><input type="checkbox"  id="check_depto"  name="check_depto[]" value="'+o[0]+'" onchange="validarc1()"></td>\n' +
                        '<td class="ids" id="txt_id_'+flag_assortment_tabla_depto+'">'+o[0]+'</td>\n' +
                        '<td class="ids" id="txt_id_'+flag_assortment_tabla_depto+'">'+o[1]+'</td>\n' +
                        '</tr>');
                    flag_assortment_tabla_depto++;
                });
            });
        }
    });

});


// Load
$(window).on('load', function () {

    $('#popup_cargando_simulador_compra_4').modal('show');
    // codigo que valida el usuario tipo lectura ...
    // se lleva parte de este codigo a depto.js ya que que
    // se aplican las mismas restricciones a tienda formato y pptos
    // CUALQUIER CAMBIO QUE SE REALIZE AQUI SE DEBE DUPLICAR EN DEPTO.JS//

    var url_busca_cod_tip_usr               = 'permiso_usuario/busca_cod_tip_usr';
    var url_busca_session                   = 'permiso_usuario/busca_session';
    var url_busca_usuario_tabla_session     = 'permiso_usuario/busca_usuario_tabla_session';
    var url_guardar_concurrencia            = 'permiso_usuario/guardar_concurrencia';
    var url_eliminar_concurrencia           = 'permiso_usuario/eliminar_concurrencia';

    var flag_cod_tip_usr = 0;
    var flag_cant_usr_session = 0;
    var version_app = $('#version_app').html();

    var span_depto = $('#span_temporada').text();
        span_depto = span_depto.replace(/[^a-z0-9\-]/gi,'');
    var separa_span_depto = span_depto.split("-");
    var depto = separa_span_depto[1];

    // Validar acceso usuarios lectura y escritura
    $.getJSON(url_busca_cod_tip_usr, function (data) {
        $.each(data, function (i, c) {

            if ((c[0] != null) || (c[0] != '') || (c[0].length > 0)) {

                flag_cod_tip_usr = c[0];

                //estos perfiles ingresan como lectura
                if ((flag_cod_tip_usr == 11) || (flag_cod_tip_usr == 4) || (flag_cod_tip_usr == 7)) {

                    campos_bloquear_tipo_usuario();

                }else{

                    $('#flag_top_menu_tipo_usuario').html('');

                    $.getJSON(url_busca_session, {DEPTO:depto,COD_TIP_GRP:'1,2,3,5,8,9,10,99'}, function (data) {
                        $.each(data, function (i,s) {

                            if ( (s[0] == null) || (s[0] == '') || (s[0].length < 0)|| (s[0] == 0) ){
                                flag_cant_usr_session = '';
                            }else {
                                flag_cant_usr_session = s[0];
                            }

                        });

//#########################################################################################

         if (flag_cant_usr_session != '') {

            if ($('#flag_usuario_no_lectura').text() != 'EPACHECO'){

                //Busco si existe un registro asociado al loguin
                $.getJSON(url_busca_usuario_tabla_session, {DEPTO:depto}, function (data) {
                    $.each(data, function (i,t) {

                        if ( (t[0] == null) || (t[0] == '') || (t[0].length < 0) || (t[0] == 0) ){

                            //el registro que esta en la tabla no es de quien pregunta
                            campos_bloquear_tipo_usuario();

                        }

                    });
                });
            }

        }else {

            $.getJSON(url_eliminar_concurrencia,{DEPTO:depto}).done(function (data) {

                $.getJSON(url_guardar_concurrencia,{DEPTO:depto,COD_MARC:0,NUM_SESSION:0,VERSION_APP:version_app,CPU_COUNT:'0',CPU_MHZ:'0',CPU_NAME:'0',CPU_VENDOR:'0',CPU_INDENTI:'0',MEM_PHYSIC:'0',MEM_AVAPHY:'0',MEM_TOTVIR:'0',MEM_AVAVIR:'0',MEM_OSNAME:'0',COD_TIP_GRP:'1,2,3,5,8,9,10,99'}).done( function( data ){
                    location.reload(true);
                });

            });

        }

//#########################################################################################
                    });

                }

            }else{
                alert ("No se a determinado su perfil de usuario");
                location.href='selecion_depto';
            }

        });
    });

    //"use strict";
    // Desabilitar el boton de carga PI
    $(".carga_pi").attr("disabled", "disabled");

    // Desabilitar botón que Genera Match, el el proceso de match
    $("#btn_generar_match_oc").attr("disabled", "disabled");
    $("#btn_actualizar_match").attr("disabled", "disabled");

    $('.eliminar_bmt').tooltip();
    $('.actualiza_grid').tooltip();
    $('.importar_bmt').tooltip();

    $('.tipo_tienda').on('click', function () {
        $('#selecciona_popup').modal('show');
    });

    $('.tipo_formato').on('click', function () {
        $('#selecciona_popup_formato').modal('show');
    });

    $('.tipo_ventana_llegada').on('click', function () {
        $('#selecciona_popup_ventana_llegada').modal('show');
    });

    $('.tipo_ppto_costo').on('click', function () {
        $('#selecciona_popup_ppto_costo').modal('show');
    });

    $('.tipo_ppto_retail').on('click', function () {
        $('#selecciona_popup_ppto_retail').modal('show');
    });

    // Cargar los CBX del modulo
    var span_temporada = $('#span_temporada').text();
        span_temporada = span_temporada.replace(/[^a-z0-9\-]/gi,'');
    var separa_barra_span = span_temporada.split("-");

    cargaCBX(separa_barra_span[1]);

    // Buscar OC Estado 20 y Estado de la OC en PMM
    var url_busca_oc20              = 'ajax_simulador_cbx/busca_oc_estado_20';           // Devuelve: PROFORMA,PO_NUMBER,COD_JER2,COD_SUBLIN,COD_MARCA,DES_ESTILO,VENTANA_LLEGADA,COD_COLOR,ID_COLOR3,NOM_LINEA,NOM_MARCA,NOM_VENTANA,NOM_COLOR,NOM_SUBLINEA)
    var url_estado_oc_4_inserta     = 'ajax_simulador_cbx/estado_oc_4_inserta_historial'; //Inserta en el historial cuando el estado es 4
    var url_traer_datos_oc_broker   = 'ajax_simulador_cbx/traer_datos_oc'; // Consulta a Broker

    // Busqueda de OC con estado 20
    $.getJSON(url_busca_oc20, function (data) {

        $.each(data, function (i,o) {

            // Si me llega una OC con estado 20, voy a buscar su estado a PMM y de ser 4 lo inserto en el historial
            //if( o[1] > 0 ){ // Está de más dice lalo 13-07-2018 15:30

            $.getJSON(url_traer_datos_oc_broker, {PI:o[0]}, function (data) {

                    var json = JSON.parse(data);
                    // Si se ejecuta correctamente
                    if(json.Body.fault.faultCode == 0) {
                    // Resultado a objeto
                    var detalle = json.Body.detalleConsultaOrdenCompra.detalle;
                        // tomar el priemr registro y ver si llegan datos, para continuar
                        if( detalle[0].ordenCompra.length > 0 ) {

                                // Asignamos las variables que llegan del WS
                                var ordenCompra = detalle[0].ordenCompra;
                                var PI = detalle[0].PI;
                                var estadoOC = detalle[0].estadoOC;

                                if( (estadoOC == 'On Order') || (estadoOC == 'Recepcion Completa') || (estadoOC == 'Recepcion Parcial') ) {

                                    // Insertar en el Historial de Compra
                                    $.getJSON(url_estado_oc_4_inserta, {
                                        LINEA: o[2],
                                        SUBLINEA: o[3],
                                        MARCA: o[4],
                                        ESTILO: o[5],
                                        VENTANA: o[6],
                                        COLOR: o[7],
                                        PI: o[0],
                                        OC: o[1],
                                        ESTADO: 21,
                                        ID_COLOR3: o[8],
                                        TIPO_INSERT: 1,
                                        NOM_LINEA: o[9],
                                        NOM_SUBLINEA: o[13],
                                        NOM_MARCA: o[10],
                                        NOM_VENTANA: o[11],
                                        NOM_COLOR: o[12]
                                    }).done(function () {

                                        // Aquí se debe trabajar con EstadoOpcion_OCPMM() actualiza estado oc segun ocpmm
                                        var url_EstadoOpcion_OCPMM = 'ajax_simulador_cbx/actualiza_estado_oc_segun_ocpmm';
                                        $.getJSON(url_EstadoOpcion_OCPMM,{PI:o[0],ID_COLOR3:o[8],ESTADO:estadoOC});

                                    });

                                // Fin de si el estado es 'On Order' or 'Recepcion Completa' or 'Recepcion Parcial'
                                }

                        // Fin si me llega algún registro
                        }

                    // Fin de si llega código de respuesta correcta
                    }

                // Fin traer datos de la OC de Broker
                });

            //Fin del si llega OC con estado 20
            //}

        // Fin del each de OCs con estado 20
        });

    // Fin de busca OC estado 20... comenzamos con los despliegues
    }).done( function( data ) {

// ############################################## INICIO TRABAJO GRILLA 2 LLENAR GRILLA ##################################################################
        // Cargar datos de la grilla 2
        var url_carga_tabla2 = 'ajax_simulador_cbx/llenar_tabla2';
        var flag_tabla2 = 0 ;
        var flag_cont_registro = 0 ;

        $.ajax({

            type: "GET",
            url: url_carga_tabla2,
            contentType: "application/json; charset=utf-8",
            dataType: "json",

            success: function(data) {

                $.each(data,function () {
                    flag_cont_registro ++;
                });

                $.each(data, function (i,o) {
                    $('#tabla2').append('<tr>\n' +
                        '<td id="txt_id_radio'+flag_tabla2+'"><input type="radio" id="radio" name="radio" value="'+flag_tabla2+'"></td>\n' +
                        '<td class="ids" id="txt_id_'+flag_tabla2+'">'+(flag_tabla2+1)+'</td>\n' +
                        '<td class="columnas" id="txt_gcompra_'+flag_tabla2+'">'+o[1]+'</td>\n' +
                        '<td class="columnas" id="cbx_temp_'+flag_tabla2+'">'+o[2]+'</td>\n' +
                        '<td class="columnas" id="cbx_linea_'+flag_tabla2+'">'+o[3]+'</td>\n' +
                        '<td class="columnas" id="cbx_sublinea_'+flag_tabla2+'">'+o[4]+'</td>\n' +
                        '<td class="columnas" id="cbx_marca_'+flag_tabla2+'">'+o[5]+'</td>\n' +
                        '<td class="columnas" id="txt_estilo_'+flag_tabla2+'">'+o[6]+'</td>\n' +
                        '<td class="columnas" id="txt_estilo_corto_'+flag_tabla2+'">'+o[7]+'</td>\n' +
                        '<td class="columnas" id="txt_codcorp_'+flag_tabla2+'">'+o[8]+'</td>\n' +
                        '<td class="columnas" id="txt_desc_'+flag_tabla2+'">'+o[9]+'</td>\n' +
                        '<td class="columnas" id="txt_descinternet_'+flag_tabla2+'">'+o[10]+'</td>\n' +
                        '<td class="columnas" id="txt_composicion_'+flag_tabla2+'">'+o[11]+'</td>\n' +
                        '<td class="columnas" id="txt_coleccion_'+flag_tabla2+'">'+o[12]+'</td>\n' +
                        '<td class="columnas" id="txt_evento_'+flag_tabla2+'">'+o[13]+'</td>\n' +
                        '<td class="columnas" id="cbx_estilovida_'+flag_tabla2+'">'+o[14]+'</td>\n' +
                        '<td class="columnas" id="txt_calidad_'+flag_tabla2+'">'+o[15]+'</td>\n' +
                        '<td class="columnas" id="cbx_ocacionuso_'+flag_tabla2+'">'+o[16]+'</td>\n' +
                        '<td class="columnas" id="cbx_piramidemix_'+flag_tabla2+'">'+o[17]+'</td>\n' +
                        '<td class="columnas" id="cbx_ventana_'+flag_tabla2+'">'+o[18]+'</td>\n' +
                        '<td class="columnas" id="cbx_rankvta_'+flag_tabla2+'">'+o[19]+'</td>\n' +
                        '<td class="columnas" id="cbx_ciclovida_'+flag_tabla2+'">'+o[20]+'</td>\n' +
                        '<td class="columnas" id="cbx_numemb_'+flag_tabla2+'">'+o[21]+'</td>\n' +
                        '<td class="columnas" id="cbx_color_'+flag_tabla2+'">'+o[22]+'</td>\n' +
                        '<td id="btn_hist_'+flag_tabla2+'"><button type="button" id="btn_hist_'+flag_tabla2+'" name="btn_hist_'+flag_tabla2+'" class="btn_hist_  btn btn-primary fa fa-history btn-sm" value="" onclick="despliegaHistorial(event);"></button></td>\n' +
                        '<td class="columnas" id="cbx_tipoproducto_'+flag_tabla2+'">'+o[23]+'</td>\n' +
                        '<td class="columnas" id="cbx_tipoexhibicion_'+flag_tabla2+'">'+o[24]+'</td>\n' +
                        '<td class="columnas" id="txt_tallas_'+flag_tabla2+'">'+o[25]+'</td>\n' +
                        '<td class="columnas" id="txt_tipoempaque_'+flag_tabla2+'">'+o[26]+'</td>\n' +
                        '<td id="txt_compraini_'+flag_tabla2+'">'+o[27]+'</td>\n' +
                        '<td class="columnas" id="txt_compraajust_'+flag_tabla2+'">'+o[28]+'</td>\n' +
                        '<td class="text-center" id="btn_ajust_'+flag_tabla2+'"><button id="btn_ajust_'+flag_tabla2+'"  style="width:70px; height:25px"  name="btn_ajust_'+flag_tabla2+'" class="btn_ajust_ btn btn-primary fa fa-cog btn-sm" value="A" onclick="despliegaAjust(event);"></button></td>\n' +
                        '<td class="columnas" id="txt_curva_'+flag_tabla2+'">'+o[29]+'</td>\n' +
                        '<td id="txt_curvamin_'+flag_tabla2+'">'+o[30]+'</td>\n' +
                        '<td id="txt_uniini_'+flag_tabla2+'">'+o[31]+'</td>\n' +
                        '<td id="txt_uniajust_'+flag_tabla2+'">'+o[32]+'</td>\n' +
                        '<td class="columnas" id="txt_unifinal_'+flag_tabla2+'">'+o[33]+'</td>\n' +
                        '<td id="txt_mst_'+flag_tabla2+'">'+o[34]+'</td>\n' +
                        '<td id="btn_ncajas_'+flag_tabla2+'"><button id="btn_ncajas_'+flag_tabla2+'" name="btn_ncajas_'+flag_tabla2+'" style="width:70px; height:25px" class="btn_ncajas_ btn btn-primary fa fa-archive btn-sm" value="'+o[35]+'" onclick="despliegaAjustCajas(event);"> '+o[35]+'</button></td>\n' +
                        '<td class="columnas" id="cbx_cluster_'+flag_tabla2+'">'+o[36]+'</td>\n' +
                        '<td class="columnas" id="cbx_formato_'+flag_tabla2+'">'+o[37]+'</td>\n' +
                        '<td id="txt_tdas_'+flag_tabla2+'">'+o[38]+'</td>\n' +
                        '<td class="columnas" id="txt_a_'+flag_tabla2+'">'+o[39]+'</td>\n' +
                        '<td class="columnas" id="txt_b_'+flag_tabla2+'">'+o[40]+'</td>\n' +
                        '<td class="columnas" id="txt_c_'+flag_tabla2+'">'+o[41]+'</td>\n' +
                        '<td class="columnas" id="txt_i_'+flag_tabla2+'">'+o[42]+'</td>\n' +
                        '<td id="txt_primeracarga_'+flag_tabla2+'">'+o[43]+'</td>\n' +
                        '<td id="txt_tiendas_'+flag_tabla2+'">'+o[44]+'% </td>\n' +
                        '<td class="columnas" id="cbx_proced_'+flag_tabla2+'">'+o[45]+'</td>\n' +
                        '<td class="columnas" id="cbx_via_'+flag_tabla2+'">'+o[46]+'</td>\n' +
                        '<td class="columnas" id="cbx_pais_'+flag_tabla2+'">'+o[47]+'</td>\n' +
                        '<td class="columnas" id="txt_viaje_'+flag_tabla2+'">'+o[48]+'</td>\n' +
                        '<td id="txt_mkup_'+flag_tabla2+'">'+o[49]+'</td>\n' +
                        '<td class="columnas" id="txt_precioblanco_'+flag_tabla2+'">'+o[50]+'</td>\n' +
                        '<td id="txt_gm_'+flag_tabla2+'">'+o[51]+'% </td>\n' +
                        '<td class="columnas" id="cbx_moneda_'+flag_tabla2+'">'+o[52]+'</td>\n' +
                        '<td class="columnas" id="txt_target_'+flag_tabla2+'">'+o[53]+'</td>\n' +
                        '<td class="columnas" id="txt_fob_'+flag_tabla2+'">'+o[54]+'</td>\n' +
                        '<td class="columnas" id="txt_insp_'+flag_tabla2+'">'+o[55]+'</td>\n' +
                        '<td class="columnas" id="txt_rfid_'+flag_tabla2+'">'+o[56]+'</td>\n' +
                        '<td class="columnas" id="txt_royalty_'+flag_tabla2+'">'+o[57]+'</td>\n' +
                        '<td id="txt_costounitariofinalusd_'+flag_tabla2+'">'+o[58]+'</td>\n' +
                        '<td id="txt_costounitariofinalpeso_'+flag_tabla2+'">'+o[59]+'</td>\n' +
                        '<td id="txt_totaltargetusd_'+flag_tabla2+'">'+o[60]+'</td>\n' +
                        '<td id="txt_totalfobusd_'+flag_tabla2+'">'+o[61]+'</td>\n' +
                        '<td id="txt_costototalpesos_'+flag_tabla2+'">'+o[62]+'</td>\n' +
                        '<td id="txt_totalretailpesos_'+flag_tabla2+'">'+o[63]+'</td>\n' +
                        '<td id="txt_debutreorder_'+flag_tabla2+'">'+o[64]+'</td>\n' +
                        '<td id="txt_semini_'+flag_tabla2+'">'+o[65]+'</td>\n' +
                        '<td id="txt_semfin_'+flag_tabla2+'">'+o[66]+'</td>\n' +
                        '<td id="txt_semanasciclovida_'+flag_tabla2+'">'+o[67]+'</td>\n' +
                        '<td id="txt_agotobj_'+flag_tabla2+'">'+(o[68]*100)+'</td>\n' +
                        '<td id="txt_semanasliquidacion_'+flag_tabla2+'">'+o[69]+'</td>\n' +
                        '<td class="columnas" id="txt_proveedor_'+flag_tabla2+'">'+o[70]+'</td>\n' +
                        '<td class="columnas" id="cbx_razonsocial_'+flag_tabla2+'">'+o[71]+'</td>\n' +
                        '<td class="columnas" id="cbx_trader_'+flag_tabla2+'">'+o[72]+'</td>\n' +
                        '<td class="columnas" id="txt_cod_sku_proveedor_'+flag_tabla2+'">'+o[73]+'</td>\n' +
                        '<td class="txt_cod_padre_" id="txt_codpadre_'+flag_tabla2+'" onclick="matchOC(event);">'+o[74]+'</td>\n' +
                        '<td class="columnas" id="txt_td_proforma_'+flag_tabla2+'"><input type="text" id="txt_proforma_'+flag_tabla2+'" style="font-size: 10px" name="txt_proforma_'+flag_tabla2+'" class="input-sm txt_proforma_" value="'+o[75]+'" size="9" onchange="actualizaCampoEstadoProforma(event);"></td>\n' +
                        '<td id="detalle_error_pi'+flag_tabla2+'"><button  id="detalle_error_pi_'+flag_tabla2+'" name="detalle_error_pi_'+flag_tabla2+'" style="font-size: 10px" value="E" class="detalle_error_pi_ btn btn-primary btn-sm fa fa-file-text-o errorpi_'+flag_tabla2+ '"  onclick="despliegaDetalleError(event);"></button></td>\n' +
                        '<td class="columnas" id="txt_archivo_'+flag_tabla2+'"><span id="txt_archivo_span_'+flag_tabla2+'">'+o[76]+'</span><button id="txt_archivo_'+flag_tabla2+'" name="txt_archivo_'+flag_tabla2+'" class="txt_archivo_ btn btn-primary fa fa-upload btn-sm archivo_'+flag_tabla2+'" style="font-size: 10px" onclick="cargaArchivo(event);"> Upload</button></td>\n' +
                        '<td id="btn_pi_'+flag_tabla2+'"><button id="btn_pi_'+flag_tabla2+'" name="btn_pi_'+flag_tabla2+'" value="Download" class="btn_pi_ btn btn-primary btn-sm fa fa-download pi_'+flag_tabla2+'" style="font-size: 10px" onclick="descargaPI(event);"> Download</button></td>\n' +
                        '<td id="txt_estiloppm_'+flag_tabla2+'">'+o[77]+'</td>\n' +
                        '<td id="txt_estadomatch_'+flag_tabla2+'">'+o[78]+'</td>\n' +
                        '<td id="txt_noc_'+flag_tabla2+'">'+o[79]+'</td>\n' +
                        '<td id="txt_estadooc_'+flag_tabla2+'">'+o[80]+'</td>\n' +
                        '<td id="txt_fechaembarque_'+flag_tabla2+'">'+o[81]+'</td>\n' +
                        '<td id="txt_fechaeta_'+flag_tabla2+'">'+o[82]+'</td>\n' +
                        '<td id="txt_fecharecepcioncd_'+flag_tabla2+'">'+o[83]+'</td>\n' +
                        '<td id="txt_diasatrasocd_'+flag_tabla2+'">'+o[84]+'</td>\n' +
                        '<td id="cbx_estadoopcion_'+flag_tabla2+'">'+o[85]+'</td>\n' +
                        '<td id="txt_estadoc1_'+flag_tabla2+'" style="display: none">'+o[86]+'</td>\n' +
                        '<td id="txt_id_color_'+flag_tabla2+'" style="display: none">'+o[0]+'</td>\n' +
                        '<td id="txt_estado_cambio_proforma_'+flag_tabla2+'" style="display: none"></td>\n' +
                        '<td id="txt_ventava_numero_'+flag_tabla2+'" style="display: none">'+o[87]+'</td>\n' +
                        '<td id="txt_fecha_recep_c1__'+flag_tabla2+'" style="display: none">'+o[88]+'</td>\n' +
                        '</tr>');
                    flag_tabla2++;
                    // Fin foreach que llena tabla
                });

                if (flag_cont_registro == 0){

                    $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);
                    $('#span_conteo_registro_tabla2').html("Existen:  "+flag_cont_registro+"  registros");

                    //$('#span_accion_cargando').html('Cargando Datos de la tabla');
                    $('#accion_carga_datos_tabla2').removeClass('fa fa-refresh');
                    $('#accion_carga_datos_tabla2').addClass('fa fa-check');

                }else if (flag_tabla2 > 0){

                    $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);

                    $('#accion_carga_datos_tabla2').removeClass('fa fa-refresh');
                    $('#accion_carga_datos_tabla2').addClass('fa fa-check');

                }

            },error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus + " errorThrown: " + errorThrown);
            }

        }).done( function() {

            $(".txt_archivo_").attr("disabled", "disabled");
            $(".btn_pi_").attr("disabled", "disabled");
            $(".detalle_error_pi_").attr("disabled", "disabled");

            // Define Tiempo 1 = 1000 (Colores a presupuesto tabla1)
            var delay_color_presupuesto = 1000;
            setTimeout(function () {
                    $("#tabla1 tbody tr").each(function () {

                        $( this ).find( "td:eq(1)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(2)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(3)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(4)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(5)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(6)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(7)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(8)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(9)" ).addClass('filas_PPTO_AliceBlue');
                        $( this ).find( "td:eq(10)" ).addClass('filas_PPTO_AliceBlue');

                        $( this ).find( "td:eq(11)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(12)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(13)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(14)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(15)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(16)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(17)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(18)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(19)" ).addClass('filas_PPTO_LightPink');
                        $( this ).find( "td:eq(20)" ).addClass('filas_PPTO_LightPink');

                        $( this ).find( "td:eq(21)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(22)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(23)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(24)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(25)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(26)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(27)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(28)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(29)" ).addClass('filas_PPTO_LightSkyBlue');
                        $( this ).find( "td:eq(30)" ).addClass('filas_PPTO_LightSkyBlue');
                    });
                }, delay_color_presupuesto);

            /*cambiar los colores segun de la filas */
            // Define Tiempo 1 = 1000
            var delay_color_segun_fila = 2000;
            setTimeout(function () {
                    var $key = 0;
                    // Recorrer los TR de una Tabla
                    $("#tabla2 > tbody >tr").each(function () {

                        //var reorder = $(this).find("td:eq(66)").text();
                        var reorder = $("#tabla2 #txt_debutreorder_"+$key).text();

                        //var proforma = $(this).find("td:eq(77) input[type='text']").val();
                        var proforma = $("#tabla2 #txt_proforma_"+$key).val();
                            proforma = proforma.replace(/[^a-z0-9\-]/gi,'');
                        //var tipoproducto = $(this).find("td:eq(24)").text();
                        var tipoproducto = $("#tabla2 #cbx_tipoproducto_"+$key).text();
                        //var GMB = ($(this).find("td:eq(52)").text()).replace('%', '');
                        var GMB = ($("#tabla2 #txt_gm_"+$key).text()).replace('%', '');

                        // Buscar el estado de eliminado para darles la clase de tachar
                        //var estado = $(this).find("td:eq(89)").text();
                        var estado = $("#tabla2 #cbx_estadoopcion_"+$key).text();
                        //var archivo_ = $(this).find("td:eq(79)").text();
                        var archivo_ = $("#tabla2 #txt_archivo_"+$key).text();

                        //if (archivo_ == "Cargado.. Upload"){
                        if (archivo_ == "Cargado.. Upload Upload"){
                            $(".pi_"+$key).attr("disabled", false);
                        }else if(estado == "Ingresado" && proforma != 0 && proforma != 'null' && proforma != ''){
                            $(".archivo_"+$key).attr("disabled", false);
                        }

                        // Aparece una "s" ya que el despliegue corrige error de texto
                        if (estado == "Pendiente de Correccisn PI"){
                            $(".errorpi_"+$key).attr("disabled", false);
                        }

                        //var temp_grilla2 = $(this).find("td:eq(3)").text();
                        var temp_grilla2 = $("#tabla2 #cbx_temp_"+$key).text();

                        if(temp_grilla2 == 3){
                            //$(this).find("td:eq(3)").html("Ttemp");
                            $("#tabla2 #cbx_temp_"+$key).html("Ttemp");
                        }else{
                            var span_temporada = $('#span_tempo').text();
                                span_temporada = span_temporada.substring(0, 2);
                            //$(this).find("td:eq(3)").html(span_temporada);
                            $("#tabla2 #cbx_temp_"+$key).html(span_temporada);
                        }

                        // Verificar que reorder no llegue "undefined" o vacio
                        if (typeof(reorder) != "undefined"){
                            if (reorder == "REORDER"){

                                //$( this ).find( "td:eq(21)" ).addClass('columnasreorder');
                                $("#tabla2 #cbx_ciclovida_"+$key).addClass('columnasreorder');

                                /*$( this ).find( "td:eq(38)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(39)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(40)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(41)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(42)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(43)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(44)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(45)" ).addClass('columnasreorder');
                                $( this ).find( "td:eq(46)" ).addClass('columnasreorder');*/

                                $("#tabla2 #cbx_cluster_"+$key).addClass('columnasreorder');
                                $("#tabla2 #cbx_formato_"+$key).addClass('columnasreorder');
                                $("#tabla2 #txt_tdas_"+$key).addClass('columnasreorder');
                                $("#tabla2 #txt_a_"+$key).addClass('columnasreorder');
                                $("#tabla2 #txt_b_"+$key).addClass('columnasreorder');
                                $("#tabla2 #txt_c_"+$key).addClass('columnasreorder');
                                $("#tabla2 #txt_i_"+$key).addClass('columnasreorder');
                                $("#tabla2 #txt_primeracarga_"+$key).addClass('columnasreorder');
                                $("#tabla2 #txt_tiendas_"+$key).addClass('columnasreorder');

                                //$( this ).find( "td:eq(68)" ).addClass('columnasreorder');
                                $("#tabla2 #txt_semfin_"+$key).addClass('columnasreorder');
                                //$( this ).find( "td:eq(69)" ).addClass('columnasreorder');
                                $("#tabla2 #txt_semanasciclovida_"+$key).addClass('columnasreorder');
                                //$( this ).find( "td:eq(71)" ).addClass('columnasreorder');
                                $("#tabla2 #txt_semanasliquidacion_"+$key).addClass('columnasreorder');

                            }else {

                                //$( this ).find( "td:eq(66)" ).css("color", "red");
                                $("#tabla2 #txt_debutreorder_"+$key).css("color", "red");

                            }

                            if (tipoproducto == "REGULAR"){
                                //$( this ).find( "td:eq(25)" ).addClass('columnasreorder');
                                $("#tabla2 #cbx_tipoexhibicion_"+$key).addClass('columnasreorder');
                            }

                            if (GMB < 0){
                                //$( this ).find( "td:eq(53)").css("color", "red");
                                $("#tabla2 #txt_gm_"+$key).css("color", "red");
                            }else if(GMB > 0){
                                //$( this ).find( "td:eq(53)").css("color", "Blue");
                                $("#tabla2 #txt_gm_"+$key).css("color", "Blue");
                            }else{
                                //$( this ).find( "td:eq(53)").css("color", "Gray");
                                $("#tabla2 #txt_gm_"+$key).css("color", "Gray");
                            }

                            // Tachar los campos con estado eliminado
                            if(estado == "Eliminado"){
                                $( this ).find( "td" ).css('text-decoration','line-through');
                            }

                        }

                        $key++;
                    });

                }, delay_color_segun_fila);

            // Cambiar la lógica, recorrer la tabla y si trae una PI busca los datos del
                // Define Tiempo 1 = 1000
            var delay_traer_datos_oc = 6000;
            setTimeout(function () {
                    var flag_tabla_vista_oc_broker = 0;
                    $("#tabla2 >tbody >tr").each(function () {

                        // Traigo la Proforma
                        //var proforma = $(this).find("td:eq(77) input[type='text']").val();
                        var proforma = $("#tabla2 #txt_proforma_"+flag_tabla_vista_oc_broker).val();
                            proforma = proforma.replace(/[^a-z0-9\-]/gi,'');
                        // Traigo el estado, solo para cargar el presupuesto cuando el estado sea 19
                        //var estado_c1 = $(this).find("td:eq(90)").text();
                        var estado_c1 = $("#tabla2 #txt_estadoc1_"+flag_tabla_vista_oc_broker).text();
                        /*var id_fila = $(this).find("td:eq(2)").attr("id");
                            id_fila =  id_fila.split("_");
                            id_fila = id_fila[2];*/
                        var id_fila = flag_tabla_vista_oc_broker;
                        //var fecha_recep_cd_c1 = $(this).find("td:eq(94)").text();
                        var fecha_recep_cd_c1 = $("#tabla2 #txt_fecha_recep_c1__"+flag_tabla_vista_oc_broker).text();
                        var transforma_recep_cd = new Date(fecha_recep_cd_c1);
                            transforma_recep_cd = transforma_recep_cd.toLocaleString();
                            transforma_recep_cd = transforma_recep_cd.split(" ");
                            transforma_recep_cd = transforma_recep_cd[0].split("/");
                            transforma_recep_cd = transforma_recep_cd[0]+'-'+transforma_recep_cd[1]+'-'+transforma_recep_cd[2];


                        if( (proforma!='null') && (proforma!=null) && (proforma!=0) && (proforma!='') && ( estado_c1==18 || estado_c1==19 || estado_c1==22) ){

                            var url_llena_array_oc = 'ajax_simulador_cbx/traer_datos_oc';
                            var url_recep_atraso = 'ajax_simulador_cbx/trae_fecharcd_y_dias_atraso';
                            $.getJSON(url_llena_array_oc, {PI:proforma}, function (data) {

                                var json = JSON.parse(data);
                                //var json = JSON.stringify(data); // JavaScript object a string

                                if(json.Body.fault.faultCode == 0) {

                                    var detalle = json.Body.detalleConsultaOrdenCompra.detalle;

                                    if(detalle[0].ordenCompra.length > 0) {

                                        $('#txt_noc_' + id_fila).html(detalle[0].ordenCompra);
                                        $('#txt_estadooc_' + id_fila).html(detalle[0].estadoOC);
                                        // Modificar despliegue fecha embarque a dd-mm-aaaa
                                        var orden_fecha_embarque = detalle[0].fechaEmbarque.split("-");
                                        orden_fecha_embarque = orden_fecha_embarque[2]+'-'+orden_fecha_embarque[1]+'-'+orden_fecha_embarque[0];
                                        $('#txt_fechaembarque_' + id_fila).html(orden_fecha_embarque);
                                        // Modificar despliegue fecha eta a dd-mm-aaaa
                                        var orden_fecha_eta = detalle[0].fechaEta.split("-");
                                        orden_fecha_eta = orden_fecha_eta[2]+'-'+orden_fecha_eta[1]+'-'+orden_fecha_eta[0];
                                        $('#txt_fechaeta_' + id_fila).html(orden_fecha_eta);

                                        //alert('Fecha ETA: '+orden_fecha_eta+' Fecha Recep. PMM: '+transforma_recep_cd);

                                        // Aquí vamos a calcular "Fecha Recepción CD" y "Días de Atraso" (Enviar formato dd/mm/rrrr)
                                        $.getJSON(url_recep_atraso, {FECHA_ESTA:orden_fecha_eta,FECHA_RECEP_PMM:transforma_recep_cd}, function (data_recep_atraso) {
                                            $.each(data_recep_atraso, function (i,o) {
                                                $('#txt_fecharecepcioncd_' + id_fila).html(o[0]);
                                                $('#txt_diasatrasocd_' + id_fila).html(o[1]);
                                            });
                                        });


                                    }

                                }

                            });

                        // Fin del IF Proforma
                        }

                        // Incremental
                        flag_tabla_vista_oc_broker++;
                        // Fin de la tabla
                    });
                }, delay_traer_datos_oc);

            // Aquí el quitar null de las columnas y colorear estados
            var delay_quitar_null = 2000;
            setTimeout(function () {

                    var id_text_increment = 0;
                        var nColumnas = $("#tabla2 tr:last th").length;
                    $("#tabla2 > tbody >tr").each(function () {
                        var i = 0;

                        if ( $("#txt_archivo_span_"+id_text_increment).html() == 'null'){
                            $("#txt_archivo_span_"+id_text_increment).html('')
                        }

                        for (i = 0; i <= nColumnas; i++) {

                            /*
                            if ($(this).find("td:eq("+i+")").html() == 'null') {
                                $(this).find("td:eq("+i+")").html('');
                            }else if($(this).find("td:eq(12)").text() == '0'){
                                $(this).find("td:eq(12)").html('');
                            }else if($(this).find("td:eq(13)").text() == '0'){
                                $(this).find("td:eq(13)").html('');
                            }else if($(this).find("td:eq(46)").text() == 'null% '){
                                $(this).find("td:eq(46)").html('');
                            }else if($(this).find("td:eq(50)").text() == '0'){
                                $(this).find("td:eq(50)").html('');
                            }else if($(this).find("td:eq(72)").text() == '0'){
                                $(this).find("td:eq(72)").html('');
                            }else if($(this).find("td:eq(73)").text() == '0'){
                                $(this).find("td:eq(73)").html('');
                            }else if($(this).find("td:eq(74)").text() == '0'){
                                $(this).find("td:eq(74)").html('');
                            }else if($(this).find("td:eq(75)").text() == '0'){
                                $(this).find("td:eq(75)").html('');
                            }else if($(this).find("td:eq(77) input[type='text']").val() == 'null'){
                                $(this).find("td:eq(77) input[type='text']").val('');
                            }else if($(this).find("td:eq(77) input[type='text']").val() == '0'){
                                $(this).find("td:eq(77) input[type='text']").val('');
                            }else if($(this).find("td:eq(89)").text() == 'Ingresado'){
                                $(this).find("td:eq(89)").addClass('columnas');
                            }else if($(this).find("td:eq(89)").text() == 'Compra Confirmada con PI'){
                                $(this).find("td:eq(89)").addClass('EstadoCompraConfirmadaPI');
                            }else if($(this).find("td:eq(89)").text() == 'Pendiente de Aprobacion sin Match'){
                                $(this).find("td:eq(89)").addClass('EstadoPendienteAprobacionsinMatch');
                            }else if($(this).find("td:eq(89)").text() == 'Pendiente de Aprobacion'){
                                $(this).find("td:eq(89)").addClass('EstadoAprobado');
                            }else if($(this).find("td:eq(89)").text() == 'Aprobado'){
                                $(this).find("td:eq(89)").addClass('EstadoAprobado');
                            }else if($(this).find("td:eq(89)").text() == 'Pendiente Generacion OC'){
                                $(this).find("td:eq(89)").addClass('EstadoPendienteGeneracionOC');
                            }else if($(this).find("td:eq(89)").text() == 'Pendiente de Correccisn PI'){
                                $(this).find("td:eq(89)").addClass('Estadocorrecionpi');
                            }else if($(this).find("td:eq(89)").text() == 'Eliminado'){
                                $(this).find("td:eq(89)").addClass('EstadoEliminado');
                            }
                            */


                            if ($(this).find("td:eq("+i+")").html() == 'null') {
                                $(this).find("td:eq("+i+")").html('');

                            }else if($("#txt_composicion_"+id_text_increment).html() == '0'){
                                $("#txt_composicion_"+id_text_increment).html('');
                           }else if($("#txt_coleccion_"+id_text_increment).text() == '0'){
                                            $("#txt_coleccion_"+id_text_increment).html('');
                                        }else if($("#txt_tiendas_"+id_text_increment).text() == 'null% '){
                                            $("#txt_tiendas_"+id_text_increment).html('');
                                        }else if($("#txt_viaje_"+id_text_increment).text() == '0'){
                                            $("#txt_viaje_"+id_text_increment).html('');
                                        }else if($("#txt_proveedor_"+id_text_increment).text() == '0'){
                                            $("#txt_proveedor_"+id_text_increment).html('');
                                        }else if($("#cbx_razonsocial_"+id_text_increment).text() == '0'){
                                            $("#cbx_razonsocial_"+id_text_increment).html('');
                                        }else if($("#cbx_trader_"+id_text_increment).text() == '0'){
                                            $("#cbx_trader_"+id_text_increment).html('');
                                        }else if($("#txt_cod_sku_proveedor_"+id_text_increment).text() == '0'){
                                            $("#txt_cod_sku_proveedor_"+id_text_increment).html('');
                                        }else if($("#txt_proforma_"+id_text_increment).val() == 'null'){
                                            $("#txt_proforma_"+id_text_increment).val('');
                                        }else if($("#txt_proforma_"+id_text_increment).val() == '0'){
                                            $("#txt_proforma_"+id_text_increment).val('');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Ingresado'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('columnas');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Compra Confirmada con PI'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('EstadoCompraConfirmadaPI');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Pendiente de Aprobacion sin Match'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('EstadoPendienteAprobacionsinMatch');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Pendiente de Aprobacion'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('EstadoAprobado');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Aprobado'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('EstadoAprobado');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Pendiente Generacion OC'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('EstadoPendienteGeneracionOC');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Pendiente de Correccisn PI'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('Estadocorrecionpi');
                                        }else if($("#cbx_estadoopcion_"+id_text_increment).text() == 'Eliminado'){
                                            $("#cbx_estadoopcion_"+id_text_increment).addClass('EstadoEliminado');
                            }

                        // Fin del for nColumnas
                        }

                        id_text_increment++;

                    });


                //txt profroma bloqueado si el usuario es tipo lectura
                if($('#flag_top_menu_tipo_usuario').html() == 'LECTURA') {
                    $(".txt_proforma_").attr("disabled", "disabled");
                    $(".txt_archivo_").attr("disabled", "disabled");
                }

                    campos_bloquear_despues_llenar_tabla();

                }, delay_quitar_null);

            //aquí se genera un delay para fijar la cabecera
            var delay_thead = 3000;
            setTimeout(function () {

                    $('#tfoot_filtro_columna_individual th').each( function () {
                        var title = $(this).text();
                        title = title.replace(/[^a-z0-9\-]/gi,'');

                        if ( (title !='D') && (title !='Archivo') && (title !='Nº Cajas') && (title !='Hist') && (title !='Ajuste Compra') && (title !='')) {
                            $(this).html('<input id="input_filtros_columna_tabla2" class="filtro" type="text" placeholder="Filtrar" style="width: 100%"/>');
                        }

                    });

                var tabla2_buscar_columnas = $('#tabla2').DataTable({
                      // "ordering": false,
                      // paging: true,
                      paging: false,
                      scrollY: "140px",
                      scrollX: true,
                      "info": false,
                      fixedColumns:true,
                      scrollCollapse: true,
                        "oLanguage": {
                            "sSearch": "Buscar:",
                            "sZeroRecords" : "No se encontraron registros"
                        },
                        columnDefs: [
                            { "type": "html-input", "targets": [78] } // 77 es la posición de la proforma "txt_proforma_"
                        ]

                });

            tabla2_buscar_columnas.columns().every( function () {

            var that = this;

            $( "#input_filtros_columna_tabla2", this.footer() ).on( 'keyup change', function () {

                if ( that.search() !== this.value ) {
                    that.search(this.value).draw();
                    //$('.datatables_empty').remove();
                    cal_campos();
                }

            // Fin de tabla2_buscar_columnas
            });

            // Ocultar campo de búsqueda
            $('#tabla2_filter').css('display','none');

            // Fin tabla2_buscar_columnas
            });


            $("#tabla2 td input").on('change', function() {
                var $td = $(this).closest('td');
                $td.find('input').attr('value', this.value);
                tabla2_buscar_columnas.cell($td).invalidate();
            });


            $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);
                    //$('#span_accion_cargando').html('Cargando estructura de la tabla');
                    $('#accion_carga_estructura_tabla2').removeClass('fa fa-refresh');
                    $('#accion_carga_estructura_tabla2').addClass('fa fa-check');

            // Fin delay para filtrar cabecera
            }, delay_thead);

            //delay calcular totales
            var delay_calculos_totales = 4000;
            setTimeout(function () {
                cal_campos();
            },delay_calculos_totales);

            //delay para las validaciones de concurrencia ("pedida")
            var delay_validaciones = 8000;
            setTimeout(function () {
                validar_usuario_recarga_sesion_expirada();
                Validar_flag_concurrencia_usuario_log();
            }, delay_validaciones);

        // Fin del done carga tabla 2
        });

// ############################################## FIN TRABAJO GRILLA 2 LLENAR GRILLA ##################################################################

    // Fin del done busca OC estado 20
    });

// fin de onload
});

// ############################################ FUNCIONES QUE SON LLAMADAS DE LA GRILLA O POR LOS POPUP QUE SE CARGAN ############################################

// Si escriben algo en la proforma actualizar el estado de la linea
function actualizaCampoEstadoProforma(event){

    var id_carga_pi  = $(event.target);
        id_carga_pi  = id_carga_pi.attr('id');
    var separa_barra = id_carga_pi.split("_");
    var estado_c1    = $("#tabla2 #txt_estadoc1_"+separa_barra[2]).text();

    // 1.- Valor del campo asociado a la PRODORMA con la que estamos tabajando
    var valor_campo = $('#txt_proforma_'+separa_barra[2]).val();
        valor_campo = valor_campo.replace(/[^a-z0-9\-]/gi,'');

    // 1.1.- Verifico que el estado sea 0 por si el usuario escribe sobre una PI existente
    if( (valor_campo!=0) && (valor_campo!="" && (estado_c1==0))){
        $('#txt_estado_cambio_proforma_'+separa_barra[2]).html("U");
    }else{
        $('#txt_estado_cambio_proforma_'+separa_barra[2]).html("");
    }

    // 2.- Verificar que el valor del campo ingresado (PROFORMA) no exista previamente con estado mayor a cero (0)
    var url_act_campo_busca_proforma = 'ajax_simulador_cbx/busca_existe_proforma';
    var url_act_campo_busca_archivo  = 'ajax_simulador_cbx/busca_existe_archivo';
    var count_pro_existe = 0;
    var count_archivo_existe = 0;

    $.getJSON(url_act_campo_busca_proforma,{PI:valor_campo}).done( function( data ) {
        $.each(data, function (i, o) {
            count_pro_existe++;
        });
    }).done( function() {

        // Existe la Proforma con estado 20 o 21
        if( count_pro_existe > 0){
            alert("Si olvidó registrar una opción, tiene que Crear Una Modificación de la PI. Si es una nueva PI, el nombre ingresado ya existe.");
            $('#txt_proforma_'+separa_barra[2]).val('');
        }else{

            // Consultamso por archivo
            $.getJSON(url_act_campo_busca_archivo,{PI:valor_campo}).done( function( data ) {
                $.each(data, function (i, o) {
                    count_archivo_existe++;
                });
            }).done( function() {

                // Si no existe archivo (0 = Sin Resultados desde la query)
                if( count_archivo_existe==0 ){

                    // Si no trae archivo de trabajo con la activación de botones
                    // Activar o desactivar boton de cargar archivo
                    if(valor_campo != "" && valor_campo != "0" && valor_campo != " " && valor_campo != null ){
                        $(".archivo_"+separa_barra[2]).attr("disabled", false);
                    }else {
                        $(".archivo_"+separa_barra[2]).attr("disabled", true);
                    }

                   // se quito de aquí la actualización del campo "U"

                // Si trae archivos deshabilito boton subir archivo y agrago texto cargado
                }else{

                    // Desabilito Campo
                    $(".archivo_"+separa_barra[2]).attr("disabled", true);
                    // Agregar texto Cargado..
                    $("#txt_archivo_span_"+separa_barra[2]).html('Cargado..');

                }

            });

        }

    });

}

//validador del checkbox en export bmt
function validar(event){

    if( ($("#checkbox_grupo:checked").val() ) != null ){
        $("#btn_exportar").prop("disabled", false);
    }else{
        $("#btn_exportar").prop("disabled", true);
    }

}

function validarc1(event){

    if(($("#check_depto:checked").val() ) != null ){
        $("#btn_exportar").attr("disabled", false);
    }else{
        $("#btn_exportar").attr("disabled", "disabled");
    }

}

function validarc1_estado_depto(event){

    if($("#check_estado:checked").val() != null && $("#check_depto_estado:checked").val() != null ){
        $("#btn_exportar").attr("disabled", false);
    }else{
        $("#btn_exportar").attr("disabled", "disabled");
    }

}

// Boton de Cargar Archivo
function cargaArchivo(event){

    // Bloqueo el botón para validar que se sube archivo
    $(".carga_pi").attr("disabled", "disabled");
    $("#send_archivop_pi").val('');

    var id_carga_pi  = $(event.target);
        id_carga_pi  = id_carga_pi.attr('id');
    var separa_barra = id_carga_pi.split("_");
    var estado_c1 = $("#tabla2 #txt_estadoc1_"+separa_barra[2]).text();
    var id_color  = $("#tabla2 #txt_id_color_"+separa_barra[2]).text();
    var proforma  = $("#tabla2 #txt_proforma_"+separa_barra[2]).val();
        proforma  = proforma.replace(/[^a-z0-9\-]/gi,'');

    if( (estado_c1 == 0) && (proforma!=0) && (proforma!="") && (proforma!="null")&& (proforma!=null) ){

        // Desplegar el  modal
        $('#carga_pi').modal('show');
        // Le asigno el estado c1 al input
        $('#send_archivo_estado_c1').val(estado_c1);
        $('#send_archivo_id_color').val(id_color);
        $('#send_archivo_proforma').val(proforma);
        // Modifico el campo de la proforma y lo limpio de caracteres no deseados
        $("#tabla2 #txt_proforma_"+separa_barra[2]).val(proforma);

        var conta_rectd_pro = 0;
        var string_a_php = "";

        // Recorrer la tabla y traer los datos de las proformas que tenga un valor igual a las del archivo que se sube
        $("#tabla2 > tbody > tr").each(function () {

            // Solo para validar que no me encuentro en las cabeceras
            //var correlativo_tabla = $(this).find("td:eq(1)").text();
            var correlativo_tabla = $("#tabla2 #txt_id_"+conta_rectd_pro).text();

            //var prof_otros_campos  = $(this).find("td:eq(77) input[type='text']").val();
            var prof_otros_campos = $("#tabla2 #txt_proforma_"+conta_rectd_pro).val();
                prof_otros_campos = prof_otros_campos.replace(/[^a-z0-9\-]/gi,'');

            var td_id_color = "";

            // Verificar que el campo sea distindo de undefined y espacio (era||)
            if ( (proforma == prof_otros_campos) && (estado_c1 == 0)){

                // td_id_color = $(this).find("td:eq(91)").text();
                td_id_color = $("#tabla2 #txt_id_color_"+conta_rectd_pro).text();
                string_a_php += td_id_color+"$";

            // Fin de buscar si la columna trae datos
            }

            conta_rectd_pro++;

        });

        $('#send_archivo_filas').val(string_a_php);

    }else{
        alert("Archivo ya existe o debe ingresar proforma antes de subir la PI.");
    }

}

// Boton Descarga PI
function descargaPI(event) {

    var id_carga_pi  = $(event.target);
        id_carga_pi  = id_carga_pi.attr('id');
    var separa_barra = id_carga_pi.split("_");
    var estado_c1 = $("#tabla2 #txt_estadoc1_" + separa_barra[2]).text();
    var proforma  = $("#tabla2 #txt_proforma_" + separa_barra[2]).val();
        proforma  = proforma.replace(/[^a-z0-9\-]/gi, '');

    var span_temporada = $('#span_temporada').text();
        span_temporada = span_temporada.replace(/[^a-z0-9\-]/gi,'');
    var separa_barra_span = span_temporada.split("-");

    if (estado_c1!=0) {
        var valFileDownloadPath = '../archivos/pi/PI-'+separa_barra_span[0]+'-'+separa_barra_span[1]+'-' + proforma + '.xls';
        window.open(valFileDownloadPath, '_blank');
    }

}

// Guarda Proforma
$('.guarda_proforma').on('click', function () {

    var respuesta = confirm("¿Guardar la Proforma Ingresada?");
    if (respuesta == true) {

        // Recorrer la tabla y traer los datos de la proforma a guardar
        var conta_datos_tr = 0;
        $("#tabla2 >tbody >tr").each(function () {

            // Solo para validar que no me encuentro en las cabeceras (sirve como ID del Campo)
            var correlativo_tabla = conta_datos_tr;
            //var estado_c1 = $(this).find("td:eq(90)").text();
            var estado_c1 = $("#tabla2 #txt_estadoc1_"+conta_datos_tr).text();
            //var busca_campo_actualizado = $(this).find("td:eq(92)").text();
            var busca_campo_actualizado = $("#tabla2 #txt_estado_cambio_proforma_"+conta_datos_tr).text();
            //var id_color  = $(this).find("td:eq(91)").text();
            var id_color  = $("#tabla2 #txt_id_color_"+conta_datos_tr).text();
            //var proforma  = $(this).find("td:eq(77) input[type='text']").val();
            var proforma = $("#tabla2 #txt_proforma_"+conta_datos_tr).val();
                proforma  = proforma.replace(/[^a-z0-9\-]/gi,'');

            if( (busca_campo_actualizado == "U") && (estado_c1 == 0)){

                    // Limpio el campo de la proforma de caracteres no deseados
                    $("#tabla2 #txt_proforma_"+correlativo_tabla).val(proforma);

                    // Actualizar solo proforma
                    var url_guarda_proforma = 'ajax_simulador_cbx/guarda_solo_proforma';
                    $.getJSON(url_guarda_proforma,{PROFORMA:proforma,ID_INSERTAR:id_color}).done( function( data ) {

                        // Actualiza Historial
                        var url_actualiza_historial = 'ajax_simulador_cbx/actualiza_historial';
                        $.getJSON(url_actualiza_historial,{PROFORMA:proforma,ID_INSERTAR:id_color});

                    } );

                // Fin del if que considera solo los registros con estado cero y nombre proforma valido
                }

            conta_datos_tr++;

        // Fin de la tabla
        });

                alert("Se han guardado los cambios, favor recargar para revisar.");
                location.reload(true);

    } else {
        return false;
    }

});

// Asociado acargar archivo PI
$('#form_carga_pi').submit(function(event) {

    // Evitar que se envie automáticamente el form
    event.preventDefault();

    // Verificar que se está cargando un archivo
    var llega_archivo = $('#send_archivop_pi').val();

    // Si existe un archivo seleccinado, envío el formulario
    if(llega_archivo.length > 0){
        // Envío el formulario
        $(this).unbind('submit').submit();
    }else{
        alert("Debe ingresar un archivo .xls");
        return false;
    }

});

$('.solicitud_generacion_oc').on('click', function () {

    var valor_radio = $("input[name='radio']:checked").val();
    var proforma = $("#txt_proforma_"+valor_radio).val();
        proforma = proforma.replace(/[^a-z0-9\-]/gi,'');
    var id_color3 = $("#txt_id_color_"+valor_radio).text();
    var estado_c1 = $("#tabla2 #txt_estadoc1_"+valor_radio).text();

    var respuesta = confirm("¿Quiere realizar los cambios?");

if (respuesta == true) {

    if(estado_c1 == 18) {

        // Llamar al INSERT
        var url_inserta = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_insert';
        // Llamar al UPDATE
        var url_actualiza = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_update';

        $.getJSON(url_inserta, {ID_COLOR3: id_color3, ESTADO: 22}).done( function( data ) {

            $.getJSON(url_actualiza, {PROFORMA: proforma, ESTADO: 1});

        }).done( function( data ) {
            // Define Tiempo 1 = 1000
            var delay_recarga_pagina = 2000;
            setTimeout(function () {
                // Recargar Página
                location.reload(true);
            }, delay_recarga_pagina);
        });

    }else{
        alert("Requiere: Compra Confirmada PI.");
    }

} else {
    alert("No se han Realizado Cambios.");
}



});

$('.oc_generada').on('click', function () {

    var valor_radio = $("input[name='radio']:checked").val();
    var proforma  = $("#txt_proforma_"+valor_radio).val();
        proforma  = proforma.replace(/[^a-z0-9\-]/gi,'');
    var id_color3 = $("#txt_id_color_"+valor_radio).text();
    var estado_c1 = $("#tabla2 #txt_estadoc1_"+valor_radio).text();

var respuesta = confirm("¿Quiere realizar los cambios?");

if (respuesta == true) {

    if(estado_c1 == 22) {

    // Llamar al INSERT
    var url_inserta = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_insert';
    $.getJSON(url_inserta,{ID_COLOR3:id_color3,ESTADO:19}).done( function( data ) {

        // Llamar al UPDATE
        var url_actualiza = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_update';
        $.getJSON(url_actualiza,{PROFORMA:proforma,ESTADO:2});

        // Recargar Página
        location.reload(true);

    } );


    }else{
        alert("Requiere: Pendiente Generacion OC.");
    }

} else {
    alert("No se han Realizado Cambios.");
}

});

$('.crear_modificacion').on('click', function () {

    var valor_radio = $("input[name='radio']:checked").val();
    var proforma = $("#txt_proforma_"+valor_radio).val();
        proforma = proforma.replace(/[^a-z0-9\-]/gi,'');
    var id_color3 = $("#txt_id_color_"+valor_radio).text();
    var estado_c1 = $("#tabla2 #txt_estadoc1_"+valor_radio).text();


var respuesta = confirm("¿Quiere realizar los cambios?");

if (respuesta == true) {

    // Llamar al INSERT
    var url_inserta = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_insert';
    $.getJSON(url_inserta,{ID_COLOR3:id_color3,ESTADO:0}).done( function( data ) {

        // Llamar al UPDATE
        var url_actualiza = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_update';
        $.getJSON(url_actualiza,{PROFORMA:proforma,ESTADO:3});

        // Recargar Página
        location.reload(true);

    } );

} else {
    alert("No se han Realizado Cambios.");
}


});

$('.elimina_opcion').on('click', function () {

    var valor_radio = $("input[name='radio']:checked").val();
    var proforma = $("#txt_proforma_"+valor_radio).val();
        proforma = proforma.replace(/[^a-z0-9\-]/gi,'');
    var id_color3 = $("#txt_id_color_"+valor_radio).text();
    var estado_c1 = $("#tabla2 #txt_estadoc1_"+valor_radio).text();

    if( (proforma!=null) && (proforma!=0) && (proforma!="") ){ //&& (proforma.length>5)

    var respuesta = confirm("¿Quiere realizar los cambios?");
    if (respuesta == true) {

        // Llamar al INSERT
        var url_inserta = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_insert';
        $.getJSON(url_inserta,{ID_COLOR3:id_color3,ESTADO:24}).done( function( data ) {

            // Llamar al UPDATE
            var url_actualiza = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_update';
            $.getJSON(url_actualiza,{PROFORMA:proforma,ESTADO:4});

            // Recargar Página
            location.reload(true);

        } );


    } else {
        alert("No se han Realizado Cambios.");
    }

    // Cuando no llega la proforma
    }else{
        alert("No puede cambiar estado si no existe proforma.");
    }


});

$('.solicitud_correccion_pi').on('click', function () {

    var valor_radio = $("input[name='radio']:checked").val();
    var proforma  = $("#txt_proforma_"+valor_radio).val();
        proforma  = proforma.replace(/[^a-z0-9\-]/gi,'');
    var id_color3 = $("#txt_id_color_"+valor_radio).text();
    var estado_c1 = $("#tabla2 #txt_estadoc1_"+valor_radio).text();

    var respuesta = confirm("¿Quiere realizar los cambios?");
    if (respuesta == true) {

        // 22 según C1 escritorio (Pendinte Generación OC)
        if( (estado_c1 == 22) ) {

            // Pregunto si quiere agregar comentario, de lo contrario....paso directamente a las querys
            var respuesta_comentario = confirm("¿Quiere agregar un comentario?");
            if (respuesta_comentario == true) {

                $("#id_color3_solic_comentario").val(id_color3);
                $("#proforma_solic_comentario").val(proforma);

                // Levantamso el popup de coemntarios
                $('#solic_correccion_comentario').modal('show');

            } else {
                // Enviamos los datos a guarcar
                solicitud_correccion_pi_funcion(id_color3, proforma);
            }

        }else{
            alert("No se puede solicitar corrección PI, al menos una opción no se encuentra en el estado correcto (22 Pendinte Generación OC).");
        }

    } else {
        alert("No se han Realizado Cambios.");
    }

});

// Botón OnClick
$('#btn_solic_correccion_comentario').on('click', function () {

    // Validar que llega id_color3 y proforma, de lo contrario detener ejecución del script
    var id_color3 = $("#id_color3_solic_comentario").val();
    var proforma = $("#proforma_solic_comentario").val();
    var comentario = $.trim($("#comentario_sol_coreccion").val());

    if( (id_color3!="") && (id_color3!=null) && (proforma!="") && (proforma!=null)  && (comentario.length > 2) ){

        // Guardamos el comentario, luego (done) enviamos los datos a guardar.
        var url_guarda_comentario_solic = 'ajax_simulador_cbx/guarda_comentario_estado_pi';
        $.getJSON(url_guarda_comentario_solic,{COMENTARIO:comentario,PROFORMA:proforma}).done( function( data ) {

            // Enviamos los datos a guardar, despues del done
            solicitud_correccion_pi_funcion(id_color3, proforma);

            // Se agrega un recargar con delay de 1, por si la funciòn previa no lo hace
            var delay = 1000;
            setTimeout(function () {
                location.reload(true);
            }, delay);

        } );

    }else{
        alert("Hay campos faltantes, que impiden enviar el comentario.");
    }


});

function solicitud_correccion_pi_funcion(id_color3, proforma) {

    // Llamar al INSERT
    var url_inserta = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_insert';
    $.getJSON(url_inserta,{ID_COLOR3:id_color3,ESTADO:23}).done( function( data ) {

        // Llamar al UPDATE
        var url_actualiza = 'ajax_simulador_cbx/trabaja_flujo_aprobacion_update';
        $.getJSON(url_actualiza,{PROFORMA:proforma,ESTADO:5}).done( function( data ) {
            // Ocultar Modal
            $('#solic_correccion_comentario').modal('toggle');
            // Recargar Página
            location.reload(true);
        } );

    });


}

// Otros Botones de la Grilla
function despliegaHistorial(event) {

    // Despliega Modal (Solo si pruedo traer el dato que produce que esta se llene)
    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_");

    //var estado_c1 = $("#despliega_hitorial_tabla #txt_estadoc1_"+separa_barra[2]).text();
    var estilo    = $("#tabla2 #txt_estilo_"+separa_barra[2]).text();
    var ventana   = $("#tabla2 #cbx_ventana_"+separa_barra[2]).text();
    var color     = $("#tabla2 #cbx_color_"+separa_barra[2]).text();
    var cod_padre = $("#tabla2 #txt_codpadre_"+separa_barra[2]).text();
    var id_color  = $("#tabla2 #txt_id_color_"+separa_barra[2]).text();

    // Le asigno Valor a los Campos de Texto
    $('#despliega_hitorial_estilo').val(estilo);
    $('#despliega_hitorial_ventana').val(ventana);
    $('#despliega_hitorial_color').val(color);
    $('#despliega_hitorial_cpadre').val(cod_padre);

    // Despliegue Modal
    $('#despliega_hitorial').modal('show');

    // Limpiar la carga de la tabla existente
    $('#despliega_hitorial_tabla tbody tr').remove();

    // Llenar la Tabla flag_despliega_hitorial_tabla
    var url_carga_despliega_hitorial_tabla = 'ajax_simulador_cbx/llenar_tabla_historial';
    var flag_despliega_hitorial_tabla = 0 ;

    $.getJSON(url_carga_despliega_hitorial_tabla,{ID_COLOR3:id_color},function (data) {
        $.each(data, function (i,o) {
            $('#despliega_hitorial_tabla').append(
                '<tr>\n' +
                    '<td id="txt_thistorial_fecha'+flag_despliega_hitorial_tabla+'">'+o[0]+'</td>\n' +
                    '<td id="txt_thistorial_hora'+flag_despliega_hitorial_tabla+'">'+o[1]+'</td>\n' +
                    '<td id="txt_thistorial_usuario'+flag_despliega_hitorial_tabla+'">'+o[2]+'</td>\n' +
                    '<td id="txt_thistorial_estado'+flag_despliega_hitorial_tabla+'">'+o[3]+'</td>\n' +
                '</tr>');
            flag_despliega_hitorial_tabla++;
        });
     // Fin de carga datos flag_despliega_hitorial_tabla
    });


}

$('#despliega_hitorial_excel').on('click', function () {

    /*var table2excel = new Table2Excel();
    table2excel.export(document.querySelectorAll("table"));

    $(".despliega_hitorial_tabla").table2excel({
        exclude: ".noExl",
        name: "Excel Document Name",
        filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, ""),
        fileext: ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true
    });*/

    alert("Imprimir");


});

function despliegaAjust(event) {

    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_");
    var id_color3 = $('#txt_id_color_'+separa_barra[2]).html();//id_color3 del grilla
    var talla = $('#txt_tallas_'+separa_barra[2]).html();//tallas de la grilla
    var debut_reorders = $('#txt_debutreorder_'+separa_barra[2]).html();//debut reorder de la grilla
        talla = talla.replace(/[^a-z0-9\,]/gi,'');//quitar los espacios

    var flag_tabla2 = 0 ;

    var url_tabla = 'ajax_simulador_cbx/ComboboxAjusteCompra';

    var dttalla = talla.split(",");

    $('#tablajustcom thead' ).empty();
    $('#tablajustcom tbody' ).empty();

if (debut_reorders != "REORDER"){
// head
     $('#tablajustcom thead' ).append('<th class=" text-center"  height="30px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_colum_descrip'+flag_tabla2+'"></th>');
     dttalla.forEach(function (entry) {
         $('#tablajustcom thead' ).append('<th class=" text-center "  height="30px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_talla'+flag_tabla2+'">'+entry+'</th>');
         flag_tabla2 ++;
     });
     $('#tablajustcom thead' ).append('<th class=" text-center" height="30px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Total</th>');
// body
         flag_tabla2 = 0;

         $.getJSON(url_tabla, {color3: id_color3, tallas: talla}, function (data) {
             $.each(data, function (i, o) {
                 flag_tablat = 1;
                 $('#tablajustcom tbody' ).append('<tr>');
                 $('#tablajustcom tbody' ).append('<td class="columnas"  height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4; padding-left: 10px" id="txt_colum_descrip'+flag_tabla2+'">'+o[0]+'</td>');

                 dttalla.forEach(function (entry) {
                     $('#tablajustcom tbody' ).append('<td class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
                     flag_tablat ++;
                 });

                 $('#tablajustcom tbody' ).append('<td class="columnas text-center" height="20px" style="border-top:1px solid #f4f4f4 ; border-right:1px solid #f4f4f4" id="txt_total'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
                 $('#tablajustcom tbody' ).append('</tr>');
                 flag_tabla2++;
             });
         });

    $('#despliega_ajust').modal('show');

}else {
    alert("Las opciones REORDER no tiene ajuste de compra.");
}

// Fin de despliegaAjust
}

function despliegaAjustCajas(event){

    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_");
    var id_color3 = $('#txt_id_color_'+separa_barra[2]).html();//id_color3 del grilla
    var talla = $('#txt_tallas_'+separa_barra[2]).html();//tallas de la grilla
    var t_empaques = $('#txt_tipoempaque_'+separa_barra[2]).html();//tipo de empaque de la grilla
    var debut_reorders = $('#txt_debutreorder_'+separa_barra[2]).html();//debut reorder de la grilla
        talla = talla.replace(/[^a-z0-9\,]/gi,'');//sacar los espacios
    var flag_tabla2 = 0 ;
    var url_tabla = 'ajax_simulador_cbx/ComboboxAjusteNCajas';
    var dttalla = talla.split(",");
    var n = (dttalla.length)+2;
    var n2 = (dttalla.length)+1;

    $('#tablajustN_Cajas thead' ).empty();//limpiar la tabla
    $('#tablajustN_Cajas tbody' ).empty();

if (t_empaques == "CURVADO" && debut_reorders == "DEBUT"){
    //head
    $('#tablajustN_Cajas thead' ).append('<tr>');
    $('#tablajustN_Cajas thead' ).append('<th colspan="'+n+'" class=" text-center" height="30px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Ajuste de cajas curvadas</th>');
    $('#tablajustN_Cajas thead' ).append('</tr>');

    $('#tablajustN_Cajas thead' ).append('<tr>');
    $('#tablajustN_Cajas thead' ).append('<th class=" text-center"  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_colum_descrip'+flag_tabla2+'"></th>');
    dttalla.forEach(function (entry) {
        $('#tablajustN_Cajas thead' ).append('<th class=" text-center "  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_talla'+flag_tabla2+'">'+entry+'</th>');
        flag_tabla2 ++;
    });
    $('#tablajustN_Cajas thead' ).append('<th class=" text-center" height="25px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Total</th>');
    $('#tablajustN_Cajas thead' ).append('</tr>');

    //body
    flag_tabla2 = 0;
    $.getJSON(url_tabla, {color3: id_color3, tallas: talla, t_empaque:t_empaques, debut_reorder:debut_reorders }, function (data) {
        $.each(data, function (i, o) {
            flag_tablat = 1;
            $('#tablajustN_Cajas tbody' ).append('<tr>');
            $('#tablajustN_Cajas tbody' ).append('<td class="columnas"  height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4; padding-left: 10px" id="txt_colum_descrip'+flag_tabla2+'">'+o[0]+'</td>');

            if(o[0]== "N de curvas x cajas"|| o[0]== "Master Curvado"|| o[0]== "Curvas a repartir"|| o[0]== "N de Cajas" || o[0]== "Master Pack" ||
                o[0]== "Total N Cajas Final"){
                dttalla.forEach(function (entry) {
                    flag_tablat ++;
                });
                $('#tablajustN_Cajas tbody' ).append('<td colspan = "'+n2+'"  class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
                if (o[0]== "N de Cajas"){
                    $('#tablajustN_Cajas tbody' ).append('<tr>');
                    $('#tablajustN_Cajas tbody' ).append('<th colspan="'+n+'" class=" text-center" height="30px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Ajuste de cajas solidas</th>');
                    $('#tablajustN_Cajas tbody' ).append('</tr>');

                    $('#tablajustN_Cajas tbody' ).append('<tr>');
                    $('#tablajustN_Cajas tbody' ).append('<th class=" text-center"  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_colum_descrip'+flag_tabla2+'"></th>');
                    dttalla.forEach(function (entry) {
                        $('#tablajustN_Cajas tbody' ).append('<th class=" text-center "  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_talla'+flag_tabla2+'">'+entry+'</th>');
                        flag_tabla2 ++;
                    });
                    $('#tablajustN_Cajas tbody' ).append('<th class=" text-center" height="25px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Total</th>');
                    $('#tablajustN_Cajas tbody' ).append('<tr>');
                }

            }else{
                if(o[0]== "Total Porcentajes Ajust Final") {
                    dttalla.forEach(function (entry) {
                        $('#tablajustN_Cajas tbody' ).append('<td class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'%</td>');
                        flag_tablat ++;
                    });
                    $('#tablajustN_Cajas tbody' ).append('<td class="columnas text-center" height="20px" style="border-top:1px solid #f4f4f4 ; border-right:1px solid #f4f4f4" id="txt_total'+flag_tabla2+'"></td>');
            }else{
                dttalla.forEach(function (entry) {
                    $('#tablajustN_Cajas tbody' ).append('<td class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
                    flag_tablat ++;
                });
                $('#tablajustN_Cajas tbody' ).append('<td class="columnas text-center" height="20px" style="border-top:1px solid #f4f4f4 ; border-right:1px solid #f4f4f4" id="txt_total'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
            }

                if(o[0]== "Total Solido Ajustado"){
                        $('#tablajustN_Cajas tbody' ).append('<tr>');
                        $('#tablajustN_Cajas tbody' ).append('<th colspan="'+n+'" class=" text-center" height="20px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'"></th>');
                        $('#tablajustN_Cajas tbody' ).append('</tr>');
                }
            }
            $('#tablajustN_Cajas tbody' ).append('</tr>');
            flag_tabla2++;
        });
     });
  }
else if (t_empaques == "SOLIDO" && debut_reorders == "DEBUT"){

    //head
    $('#tablajustN_Cajas thead' ).append('<tr>');
    $('#tablajustN_Cajas thead' ).append('<th colspan="'+n+'" class=" text-center" height="30px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Ajuste Master Pack</th>');
    $('#tablajustN_Cajas thead' ).append('</tr>');

    $('#tablajustN_Cajas thead' ).append('<tr>');
    $('#tablajustN_Cajas thead' ).append('<th class=" text-center"  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_colum_descrip'+flag_tabla2+'"></th>');
    dttalla.forEach(function (entry) {
        $('#tablajustN_Cajas thead' ).append('<th class=" text-center "  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_talla'+flag_tabla2+'">'+entry+'</th>');
        flag_tabla2 ++;
    });
    $('#tablajustN_Cajas thead' ).append('<th class=" text-center" height="25px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Total</th>');
    $('#tablajustN_Cajas thead' ).append('</tr>');

    //body
    flag_tabla2 = 0;
    $.getJSON(url_tabla, {color3: id_color3, tallas: talla, t_empaque:t_empaques, debut_reorder:debut_reorders }, function (data) {
        $.each(data, function (i, o) {
            flag_tablat = 1;
            $('#tablajustN_Cajas tbody' ).append('<tr>');
            $('#tablajustN_Cajas tbody' ).append('<td class="columnas"  height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4; padding-left: 10px" id="txt_colum_descrip'+flag_tabla2+'">'+o[0]+'</td>');

            if (o[0]== "Master Pack"){
                dttalla.forEach(function (entry) {
                    flag_tablat ++;
                });
                $('#tablajustN_Cajas tbody' ).append('<td colspan = "'+n2+'"  class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'</td>');

            }else{
            dttalla.forEach(function (entry) {
                $('#tablajustN_Cajas tbody' ).append('<td class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
                flag_tablat ++;
            });
            $('#tablajustN_Cajas tbody' ).append('<td class="columnas text-center" height="20px" style="border-top:1px solid #f4f4f4 ; border-right:1px solid #f4f4f4" id="txt_total'+flag_tabla2+'">'+o[flag_tablat]+'</td>');

            $('#tablajustN_Cajas tbody' ).append('</tr>');
            flag_tabla2++;
            }
        });

    });



}
else if (t_empaques == "SOLIDO" && debut_reorders == "REORDER"){
    //head
    $('#tablajustN_Cajas thead' ).append('<tr>');
    $('#tablajustN_Cajas thead' ).append('<th colspan="'+n+'" class=" text-center" height="30px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Ajuste Master Pack</th>');
    $('#tablajustN_Cajas thead' ).append('</tr>');

    $('#tablajustN_Cajas thead' ).append('<tr>');
    $('#tablajustN_Cajas thead' ).append('<th class=" text-center"  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_colum_descrip'+flag_tabla2+'"></th>');
    dttalla.forEach(function (entry) {
        $('#tablajustN_Cajas thead' ).append('<th class=" text-center "  height="25px" style="border-top:2px solid #f4f4f4; border-right:1px solid #f4f4f4" id="txt_talla'+flag_tabla2+'">'+entry+'</th>');
        flag_tabla2 ++;
    });
    $('#tablajustN_Cajas thead' ).append('<th class=" text-center" height="25px" style="border-top:2px solid #f4f4f4 ; border-right:1px solid #f4f4f4 " id="txt_total'+flag_tabla2+'">Total</th>');
    $('#tablajustN_Cajas thead' ).append('</tr>');

    //body
    flag_tabla2 = 0;
    $.getJSON(url_tabla, {color3: id_color3, tallas: talla, t_empaque:t_empaques, debut_reorder:debut_reorders }, function (data) {
        $.each(data, function (i, o) {
            flag_tablat = 1;
            $('#tablajustN_Cajas tbody' ).append('<tr>');
            $('#tablajustN_Cajas tbody' ).append('<td class="columnas"  height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4; padding-left: 10px" id="txt_colum_descrip'+flag_tabla2+'">'+o[0]+'</td>');

            if (o[0]== "Mst Pack"){
                dttalla.forEach(function (entry) {
                    flag_tablat ++;
                });
                $('#tablajustN_Cajas tbody' ).append('<td colspan = "'+n2+'"  class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
            }else{
                dttalla.forEach(function (entry) {
                    $('#tablajustN_Cajas tbody' ).append('<td class=" text-center" height="20px" style="border-top:1px solid #f4f4f4; border-right:1px solid #f4f4f4 "id="txt_talla'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
                    flag_tablat ++;
                });
                $('#tablajustN_Cajas tbody' ).append('<td class="columnas text-center" height="20px" style="border-top:1px solid #f4f4f4 ; border-right:1px solid #f4f4f4" id="txt_total'+flag_tabla2+'">'+o[flag_tablat]+'</td>');
                $('#tablajustN_Cajas tbody' ).append('</tr>');
                flag_tabla2++;
            }
        });

    });

}


    $('#despliega_n_cajas').modal('show');

}

function despliegaDetalleError(event) {

    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_");
    var proforma = $("#txt_proforma_"+separa_barra[3]).val();
        proforma = proforma.replace(/[^a-z0-9\-]/gi,'');

    $('#detalle_comentario_sol_coreccion').val('');

    //Voy a buscar los datos y si llega info despliego el modal, de lo contrario envio mensaje de no detale
    var url_busca_coemntario_pi = 'ajax_simulador_cbx/busca_comentario_pi';
    var flag_busca_comentario=0;

    $.getJSON(url_busca_coemntario_pi,{PI:proforma}, function (data) {

        $.each(data, function (i,o) {

            // Le ASIGNA un valor a un ELEMENTO
            $('#detalle_comentario_sol_coreccion').val(o[0]);

            flag_busca_comentario++;
        });

        if(flag_busca_comentario>0){
            // Si hay mensaje lo despliego, de lo contrario mensaje
            $('#despliega_detalle_error').modal('show');
        }else{
            alert("Sin Comentario.");
        }

    // Fin busca comentario PI
    });





}

function matchOC(event) {

    if ($('#flag_top_menu_tipo_usuario').html() != 'LECTURA') {

        // Limpiar las clases de revision
        $("#popup_match_paso_oclinkeada").removeClass("fa fa-check");
        $("#popup_match_paso_oclinkeada").addClass('fa fa-refresh');
        $("#popup_match_paso_cargarpmm").removeClass("fa fa-check");
        $("#popup_match_paso_cargarpmm").addClass('fa fa-refresh');
        $("#popup_match_paso_cargarplan").removeClass("fa fa-check");
        $("#popup_match_paso_cargarplan").addClass('fa fa-refresh');
        $("#popup_match_paso_planvspmm").removeClass("fa fa-check");
        $("#popup_match_paso_planvspmm").addClass('fa fa-refresh');
        $("#popup_match_paso_existeerror").removeClass("fa fa-check");
        $("#popup_match_paso_existeerror").addClass('fa fa-refresh');
        $("#popup_match_paso_puedeeditar").removeClass("fa fa-check");
        $("#popup_match_paso_puedeeditar").addClass('fa fa-refresh');


        // quitar el show que biene, ya que se encuentra abajo
        // $('#match_oc').modal('show');

        // Existe una cascada grande de acciones, hay que verificar que una se cumpla antes de pasar a la otra
        // 1.- Limpiar la carga de la tabla existente
        $('#match_tabla_pmm tbody tr').remove();
        $('#match_tabla_plan tbody tr').remove();


        // 2.- Voy a buscar los valores a la tabla
        var id = $(event.target);
            id = id.attr('id');
        var separa_barra = id.split("_");
        var orden_compra = $("#tabla2 #txt_noc_" + separa_barra[2]).text();
        var id_color = $("#tabla2 #txt_id_color_" + separa_barra[2]).text();
        var proforma = $("#tabla2 #txt_proforma_" + separa_barra[2]).val();
        proforma = proforma.replace(/[^a-z0-9\-]/gi, '');

        // Buscar Estado del Registro
        var check_estado_oc = $("#tabla2 #txt_estadoc1_" + separa_barra[2]).text();


        if ((orden_compra != 0) && (proforma != "") && (proforma != 0) && (check_estado_oc == 19)) {

            // Abrir modal de revision
            $('#popup_loading_match').modal('show');

            // 3.- Asigno los valores a los campos de la tabla de match
            $('#txt_match_oc').val(orden_compra);
            $('#txt_match_pi').val(proforma);

            // ############################ VALIDAR QUE TENGO OC y PI, DE LO CONTRARIO NO DESPLEGAR EL POPUP y ENVIAR MENSAJE  ############################ PENDIENTE!!!!!!

            // 4.- Consultar si OC se encuentra Linkeada PLC_PKG_UTILS.PRC_CONSULTAR_OC
            var url_verifica_oc_linkeada = 'ajax_simulador_cbx/consultar_oc_linkeada';
            var count_oc_linkeada = 0;
            $.getJSON(url_verifica_oc_linkeada, {OC: orden_compra, PI: proforma}, function (data) {
                $.each(data, function (i, o) {
                    count_oc_linkeada++;
                });
            }).done(function (data) {

                // Este paso estaría ok para el modal
                $("#popup_match_paso_oclinkeada").removeClass("fa fa-refresh");
                $("#popup_match_paso_oclinkeada").addClass('fa fa-check');

                // Si count_oc_linkeada==0 significa que no encontró registros... por lo que se puede realizar el match
                if (count_oc_linkeada == 0) {

                    // 5.- Eliminar Registros con OC Canceladas
                    var url_elimina_oc_canceladas = 'ajax_simulador_cbx/quitar_oc_cancelada';
                    $.getJSON(url_elimina_oc_canceladas, {OC: orden_compra, PI: proforma});


                    // 6.- Agrega la tabla "B" OC o PI (PLC_PKG_UTILS.PRC_AGREGAR_OCPMM)
                    var url_atablab_oc_pi = 'ajax_simulador_cbx/agrega_tabla_b_ocpi';
                    $.getJSON(url_atablab_oc_pi, {OC: orden_compra, PI: proforma});


                    // 6.1 - Llamar WS OC y enviar a guardar cada dato a Tabla B (NUEVO, se agrega para funcionar con broker)
                    var url_traer_datos_oc = 'ajax_simulador_cbx/traer_datos_oc';
                    var url_agrega_registroswsoc = 'ajax_simulador_cbx/agrega_registroswsoc_a_tabla_b'; //PLC_PKG_UTILS.PRC_ADD_OC_B
                    $.getJSON(url_traer_datos_oc, {PI: proforma}, function (data) {

                        var json = JSON.parse(data);

                        if (json.Body.fault.faultCode == 0) {
                            var detalle = json.Body.detalleConsultaOrdenCompra.detalle;

                            if ((detalle[0].ordenCompra.length > 0)) { //&& (orden_compra == detalle.ordenCompra) && (proforma == detalle.PI)

                                $.each(detalle, function (index, object) {

                                    // Asignamos las variables que llegan del WS
                                    var ordenCompra = object.ordenCompra;
                                    var PI = object.PI;
                                    var nombreEstilo = object.nombreEstilo;
                                    var numeroEstilo = object.numeroEstilo;
                                    var estado = object.estado;
                                    var nombreVariacion = object.nombreVariacion;
                                    var numeroVariacion = object.numeroVariacion;
                                    var color = object.color;
                                    var codColor = object.codColor;
                                    var nombreLinea = object.nombreLinea;
                                    var numeroLinea = object.numeroLinea;
                                    var nombreSubLinea = object.nombreSubLinea;
                                    var numeroSubLinea = object.numeroSubLinea;
                                    var temporada = object.temporada;
                                    var cicloVida = object.cicloVida;
                                    var estadoOC = object.estadoOC;
                                    var fechaEmbarque = object.fechaEmbarque;
                                    var fechaEta = object.fechaEta;
                                    var unidades = object.unidades;
                                    var costo = object.costo;
                                    var moneda = object.moneda;
                                    var pais = object.pais;

                                    // Se envian a guardar los datos a tabla B
                                    $.getJSON(url_agrega_registroswsoc, {
                                        OC: orden_compra,
                                        PI: proforma,
                                        V_NOMBRE_ESTILO: nombreEstilo,
                                        V_NRO_ESTILO: numeroEstilo.replace(/[^a-z0-9\-]/gi, ''),
                                        V_ESTADO_ESTILO: estado,
                                        V_NOMBRE_VARIACION: nombreVariacion,
                                        V_NRO_VARIACION: numeroVariacion.replace(/[^a-z0-9\-]/gi, ''),
                                        V_COLOR: color,
                                        V_COD_COLOR: codColor.replace(/[^a-z0-9\-]/gi, ''),
                                        V_NOMBRE_LINEA: nombreLinea,
                                        V_NRO_LINEA: numeroLinea.replace(/[^a-z0-9\-]/gi, ''),
                                        V_NOMBRE_SUB_LINEA: nombreSubLinea,
                                        V_NRO_SUB_LINEA: numeroSubLinea,
                                        V_TEMPORADA: temporada,
                                        V_CICLO_VIDA: cicloVida,
                                        V_ESTADO_OC: estadoOC,
                                        V_FECHA_EMBARQUE: fechaEmbarque,
                                        V_FECHA_ETA: fechaEta,
                                        V_UNIDADES: unidades,
                                        V_COSTO: costo,
                                        V_MONEDA: moneda,
                                        V_PAIS: pais
                                    });

                                });

                            }
                        }

                    }).done(function (data) {

                        // 7.- Cargar los datos de la tabla PMM (PLC_PKG_UTILS.PRC_LISTAR_OCPMM)
                        // En visual está como: CargaGrillaPMM(dt)
                        // Voya a buscar los valores a PMM
                        // Hay que ir a buscar a tabla B los mismos datos por GROUP BY************************************************************************************
                        var url_carga_tabla_pmm = 'ajax_simulador_cbx/llenar_tabla_pmm';
                        var flag_carga_tabla_pmm = 0;
                        $.getJSON(url_carga_tabla_pmm, {OC: orden_compra, PI: proforma}, function (data) {
                            $.each(data, function (i, o) {
                                $('#match_tabla_pmm').append(
                                    '<tr>\n' +
                                    '<td id="txt_matchpmm_id' + flag_carga_tabla_pmm + '" style="visibility: hidden"></td>\n' +  // o[0]
                                    '<td id="txt_matchpmm_pi' + flag_carga_tabla_pmm + '">' + o[1].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '<td id="txt_matchpmm_codlinea' + flag_carga_tabla_pmm + '">' + o[8].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '<td id="txt_matchpmm_linea' + flag_carga_tabla_pmm + '">' + o[2].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '<td id="txt_matchpmm_codsublinea' + flag_carga_tabla_pmm + '">' + o[9].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '<td id="txt_matchpmm_sublinea' + flag_carga_tabla_pmm + '">' + o[3].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '<td id="txt_matchpmm_estilo' + flag_carga_tabla_pmm + '"><input type="text" id="txt_matchpmm_estilo_input_' + flag_carga_tabla_pmm + '" value="' + o[4] + '" readonly></td>\n' + //.replace(/[^a-z0-9\-]/gi, '')
                                    '<td id="txt_matchpmm_codestilo' + flag_carga_tabla_pmm + '">' + o[5].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '<td id="txt_matchpmm_color' + flag_carga_tabla_pmm + '">' + o[6].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '<td id="txt_matchpmm_codcolor' + flag_carga_tabla_pmm + '">' + o[7].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                    '</tr>');
                                flag_carga_tabla_pmm++;
                            });
                        }).done(function (data) {

                            // Define Tiempo 1 = 1000 (4 segundos, por si se demora en cargar la tabla anterior)
                            var delay = 4000;
                            setTimeout(function () {

                                // Como el contador no me toma lo que hay dentro del foreach, cuento las filas que se cargaron en la tabla
                                flag_carga_tabla_pmm = $('#match_tabla_pmm tbody tr').length;

                                if (flag_carga_tabla_pmm == 0) {
                                    alert("Orden de Compra o PI no se encuentra en PMM");
                                    $('#popup_loading_match').modal('toggle');
                                    return false;
                                } else {

                                    // Este paso estaría ok para el modal
                                    $("#popup_match_paso_cargarpmm").removeClass("fa fa-refresh");
                                    $("#popup_match_paso_cargarpmm").addClass('fa fa-check');


                                    // 8.- Validar la Tabla, hacer el match (PLC_PKG_UTILS.PRC_LISTAR_OCPMMIN) ... que cruza con color3
                                    var url_valida_cruza_color3 = 'ajax_simulador_cbx/valida_tablab_cuza_color3';
                                    var flag_carga_tabla_plan = 0;
                                    $.getJSON(url_valida_cruza_color3, {
                                        OC: orden_compra,
                                        PI: proforma
                                    }, function (data) {
                                        $.each(data, function (i, o) {
                                            $('#match_tabla_plan').append(
                                                '<tr>\n' +
                                                '<td id="txt_matchplan_id' + flag_carga_tabla_plan + '">' + o[0] + '</td>\n' +
                                                '<td id="txt_matchplan_pi' + flag_carga_tabla_plan + '">' + o[1].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                                '<td id="txt_matchplan_codlinea' + flag_carga_tabla_plan + '">' + o[3].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                                '<td id="txt_matchplan_linea' + flag_carga_tabla_plan + '"><select id="txt_matchplan_linea_cbx_' + flag_carga_tabla_plan + '" name ="txt_matchplan_linea_cbx' + flag_carga_tabla_plan + '" class="linea_cbx_" onchange="matchCargaSublinea(event);"></select></td>\n' + //'+o[2]+'
                                                '<td id="txt_matchplan_codsublinea' + flag_carga_tabla_plan + '">' + o[5].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                                '<td id="txt_matchplan_sublinea' + flag_carga_tabla_plan + '"><select id="txt_matchplan_sublinea_cbx_' + flag_carga_tabla_plan + '" name ="txt_matchplan_sublinea_cbx' + flag_carga_tabla_plan + '" class="sublinea_cbx_" onchange="editaSublinea(event);"></select></td>\n' + //'+o[4]+'
                                                '<td id="txt_matchplan_estilo' + flag_carga_tabla_plan + '"><input type="text" id="input_matchplan_estilo_' + flag_carga_tabla_plan + '" name="input_matchplan_estilo_' + flag_carga_tabla_plan + '" value="' + o[6] + '" onchange="editaEstilo(event);" onpaste="editaEstilo(event);"></td>\n' + //.replace(/[^a-z0-9\-]/gi, '')
                                                '<td id="txt_matchplan_color' + flag_carga_tabla_plan + '"><select id="txt_matchplan_color_cbx_' + flag_carga_tabla_plan + '" name ="txt_matchplan_color_cbx' + flag_carga_tabla_plan + '" class="color_cbx_" onchange="editaColor(event);"></select></td>\n' + //'+o[7]+'
                                                '<td id="txt_matchplan_codcolor' + flag_carga_tabla_plan + '">' + o[8].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +

                                                '<td id="txt_matchplan_valLinea' + flag_carga_tabla_plan + '" style="visibility: hidden">' + o[3].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                                '<td id="txt_matchplan_valSubLinea' + flag_carga_tabla_plan + '" style="visibility: hidden">' + o[5].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                                '<td id="txt_matchplan_valColor' + flag_carga_tabla_plan + '" style="visibility: hidden">' + o[8].replace(/[^a-z0-9\-]/gi, '') + '</td>\n' +
                                                '<td id="txt_matchplan_valEstilo' + flag_carga_tabla_plan + '" style="visibility: hidden">' + o[6] + '</td>\n' + //.replace(/[^a-z0-9\-]/gi, '')
                                                '<td id="txt_matchplan_correlativo' + flag_carga_tabla_plan + '" style="visibility: hidden">' + flag_carga_tabla_plan + '</td>\n' +
                                                '<td id="txt_matchplan_updated_' + flag_carga_tabla_plan + '" style="visibility: hidden"></td>\n' +
                                                '</tr>');
                                            flag_carga_tabla_plan++;
                                        });
                                    }).done(function (data) {

                                        var delay = 4000;
                                        setTimeout(function () {

                                            flag_carga_tabla_plan = $('#match_tabla_plan tbody tr').length;

                                            // Contar la Cantidad de registros de las dos tablas, si no coinciden "La cantidad de opciones PMM VS Plan no coinciden."
                                            // de lo contreario, continuo con el match
                                            if (flag_carga_tabla_pmm != flag_carga_tabla_plan) {
                                                alert("La cantidad de opciones PMM VS Plan no coinciden.");
                                                // Despliego de todos modos el popup, pero no debiera dejar hacar nada asociado a los botones de guardado y edición
                                                // $('#match_oc').modal('show'); //(Si el mensaje no es suficiente desoomentar el mensaje para que aparezca el popup con los registros)
                                                $('#popup_loading_match').modal('toggle');
                                                // Vuelvo a desabilitar los botones para cuando se despleigue en popupde match
                                                $("#btn_generar_match_oc").attr("disabled", "disabled");
                                                $("#btn_actualizar_match").attr("disabled", "disabled");

                                            } else {

                                                // 1.- Cargar CBX de Linea
                                                $('.linea_cbx_').empty();
                                                var toAppend_linea = '';
                                                var url = 'ajax_simulador_cbx/listar_optionsLinea';
                                                $.getJSON(url, {OC: orden_compra, PI: proforma}, function (data) {
                                                    $.each(data, function (i, o) {
                                                        toAppend_linea += '<option value=' + o[0].replace(/[^a-z0-9\-]/gi, '') + '><b>' + o[0].replace(/[^a-z0-9\-]/gi, '') + '<b> - ' + o[1].replace(/[^a-z0-9\-]/gi, '') + '</option>';
                                                    });
                                                    $('.linea_cbx_').append(toAppend_linea);
                                                }).done(function (data) {

                                                    // 2.- Cargar CBX de Color
                                                    $('.color_cbx_').empty();
                                                    var toAppend_color = '';
                                                    var url = 'ajax_simulador_cbx/listar_optionsColor';
                                                    $.getJSON(url, function (data) {
                                                        $.each(data, function (i, o) {
                                                            toAppend_color += '<option value=' + o[0].replace(/[^a-z0-9\-]/gi, '') + '><b>' + o[0].replace(/[^a-z0-9\-]/gi, '') + '<b> - ' + o[1].replace(/[^a-z0-9\-]/gi, '') + '</option>';
                                                        });
                                                        $('.color_cbx_').append(toAppend_color);
                                                    }).done(function (data) {

                                                        // Este paso estaría ok para el modal
                                                        $("#popup_match_paso_cargarplan").removeClass("fa fa-refresh");
                                                        $("#popup_match_paso_cargarplan").addClass('fa fa-check');


                                                        // Define Tiempo 1 = 1000
                                                        var delay = 3000;
                                                        setTimeout(function () {

                                                            var flag_tabla_plan = 0;

// se necesita asignar los select que trae la consulta
$("#match_tabla_plan tbody tr").each(function () {

// Obtengo el ID del primer Registro
var correlativo = $(this).find("td:eq(13)").html();
//var correlativo = $("#match_tabla_plan #txt_matchplan_correlativo"+flag_tabla_plan).html();

                                                                // Tengo el valor de los <td> al pasar por cada <tr>
                                                                var linea = $(this).find("td:eq(9)").html();
                                                                //var linea = $("#match_tabla_plan #txt_matchplan_valLinea"+flag_tabla_plan).html();

                                                                // Aquí cargar la sublinea ya que tengo el valor de la linea, luego asignar el select

                                                                var sublinea = $(this).find("td:eq(10)").html();
                                                                //var sublinea = $("#match_tabla_plan #txt_matchplan_valSubLinea"+flag_tabla_plan).html();
                                                                var color = $(this).find("td:eq(11)").html();
                                                                //var color = $("#match_tabla_plan #txt_matchplan_valColor"+flag_tabla_plan).html();
                                                                var estilo = $(this).find("td:eq(12)").html();
                                                                //var estilo = $("#match_tabla_plan #txt_matchplan_valEstilo"+flag_tabla_plan).html();

                                                                // Asignar el valor de la BD al select
                                                                $('#txt_matchplan_linea_cbx_' + correlativo).val(linea);
                                                                $('#txt_matchplan_color_cbx_' + correlativo).val(color);

                                                                // Cargar CBX de SubLínea (Dejar para luego del recorrido de la tabla, se necesita recorrer la tabla)
                                                                $('#txt_matchplan_sublinea_cbx_' + correlativo).empty();

                                                                var toAppend_subl = '';
                                                                var url = 'ajax_simulador_cbx/listar_optionsSubLinea';
                                                                $.getJSON(url, {ID_LINEA: linea}, function (data) {
                                                                    $.each(data, function (i, o) {
                                                                        toAppend_subl += '<option value=' + o[0].replace(/[^a-z0-9\-]/gi, '') + '><b>' + o[0].replace(/[^a-z0-9\-]/gi, '') + '<b> - ' + o[1].replace(/[^a-z0-9\-]/gi, '') + '</option>';
                                                                    });
                                                                    $('#txt_matchplan_sublinea_cbx_' + correlativo).append(toAppend_subl);
                                                                }).done(function (data) {

                                                                    // Define Tiempo 1 = 1000
                                                                    var delay = 1000;
                                                                    setTimeout(function () {
                                                                        // Asignar el valor de la BD al select
                                                                        $('#txt_matchplan_sublinea_cbx_' + correlativo).val(sublinea);
                                                                    }, delay);

                                                                    // Fin DONE caga CBX sublinea
                                                                });

                                                                flag_tabla_planflag_tabla_plan++;

                                                            });

                                                        }, delay);

                                                        // Se cargan "bien" las dos tablas, puedo desplegar el botòn de actualizar
                                                        $("#btn_actualizar_match").attr("disabled", false);

                                                        // Este paso estaría ok para el modal
                                                        $("#popup_match_paso_puedeeditar").removeClass("fa fa-refresh");
                                                        $("#popup_match_paso_puedeeditar").addClass('fa fa-check');


                                                        // Define Tiempo 1 = 1000
                                                        var delay_colorea = 9000;
                                                        setTimeout(function () {

                                                            // Este paso estaría ok para el modal
                                                            $("#popup_match_paso_existeerror").removeClass("fa fa-refresh");
                                                            $("#popup_match_paso_existeerror").addClass('fa fa-check');

                                                            // Por cada registro de la tabla Plan, recorro PMM a ver si la encuentro
                                                            var flag_encuentra_match = 0;
                                                            $('#match_tabla_plan >tbody >tr').each(function () {

                                                                var linea_plan = $(this).find("td:eq(3) select").val();
                                                                var sublinea_plan = $(this).find("td:eq(5) select").val();
                                                                var estilo_plan = $(this).find("td:eq(6) input[type='text']").val();
                                                                var color_plan = $(this).find("td:eq(7) select").val();

                                                                // Aqui las variables que ven por fila enviada, si no cambia abajo dejo igual o cambio de color
                                                                flag_encuentra_match = 0;

                                                                $('#match_tabla_pmm >tbody >tr').each(function () {
                                                                    var linea_pmm = $(this).find("td:eq(2)").html();
                                                                    var sublinea_pmm = $(this).find("td:eq(4)").html();
                                                                    var estilo_pmm = $(this).find("td:eq(6) input[type='text']").val();
                                                                    var color_pmm = $(this).find("td:eq(9)").html();

                                                                    // Para revisión Web
                                                                    //console.log('LineaPlan:'+linea_plan+' LíneaPMM:'+linea_pmm+' \nSubPlan:'+sublinea_plan+' SubPMM:'+sublinea_pmm+' \nEstiloPlan:'+estilo_plan+' EstiloPMM:'+estilo_pmm+' \nColorPlan:'+color_plan+' ColorPMM:'+color_pmm);
                                                                    console.log('LineaPlan:' + linea_plan + '\nLíneaPMM:' + linea_pmm + '\nSubPlan:' + sublinea_plan + '\nSubPMM:' + sublinea_pmm + '\nEstiloPlan:' + estilo_plan + '\nEstiloPMM:' + estilo_pmm + '\nColorPlan:' + color_plan + '\nColorPMM:' + color_pmm);

                                                                    if ((linea_plan == linea_pmm) && (sublinea_plan == sublinea_pmm) && (estilo_plan == estilo_pmm) && (color_plan == color_pmm)) {
                                                                        flag_encuentra_match++;
                                                                        return false;
                                                                    }


                                                                    // Fin recorrido segunda tabla
                                                                });


                                                                //Si flag_encuentra_match > 0, coloreo el fondo del ID
                                                                if (flag_encuentra_match == 0) {
                                                                    $(this).find("td:eq(0)").css('background-color', 'red');
                                                                    $(this).find("td:eq(0)").css('color', 'white');
                                                                } else {
                                                                    $(this).find("td:eq(0)").css('background-color', 'white');
                                                                    $(this).find("td:eq(0)").css('color', 'black');
                                                                }


                                                            // Fin recorrido primera tabla
                                                            });

                                                            if (flag_encuentra_match == 0) {
                                                                // No puerdo habilitar botón "Generar Match"

                                                            } else {
                                                                // Habilitar botón que Genera Match, el el proceso de match
                                                                $("#btn_generar_match_oc").attr("disabled", false);
                                                            }

                                                            // Este paso estaría ok para el modal
                                                            $("#popup_match_paso_planvspmm").removeClass("fa fa-refresh");
                                                            $("#popup_match_paso_planvspmm").addClass('fa fa-check');

                                                        }, delay_colorea);


                                                        // FIN DEL MODAL DE VALIDACIONES
                                                        var delay = 8000;
                                                        setTimeout(function () {
                                                            // No desplegar el popup hasta pasar por algunas validaciones previas
                                                            $('#match_oc').modal('show');
                                                            $('#popup_loading_match').modal('toggle');
                                                        }, delay);


                                                        // Fin DONE cargar CBX de color
                                                    });

                                                    // Fin DONE carga CBX Línea
                                                });


                                                //aqui estaba el show


                                                // Fin de control de cantidad de registros por tabla PMM v/s PLAN
                                            }


                                            // Fin delay para comenzar a llenar grillas y buscar las diferencias entre tablaas
                                        }, delay);


                                        // Fin del DONE llenar tabla plan
                                    });


                                    // Fin else si la tabla PMM tiene datos
                                }


                            }, delay);


                            // Fin del DONE llenat tabla PMM
                        });

                        // Fon del DONE traer datos OC desde WS
                    });


                    // Fin si la OC se encuentra linkeada
                } else {
                    alert("La OC se encuentra linkeada previamente.");
                    $('#popup_loading_match').modal('toggle');
                    return false;
                }


                //Fin DONE si está linkeada la OC
            });

        } else {
            alert("Para poder realizar el Match, se necesita Proforma, Nº OC y Estado Opción: Pendiente de Aprobación sin Match");
        }

    }

}

function matchCargaSublinea(event) {

    // hay que cargar nuevamente la sublinea con el id de la linea que ha modificado
    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_"); //separa_barra[4]

    // Actualizar el Campo de Editado
    $('#txt_matchplan_updated_'+separa_barra[4]).html('U');

    // Traer valor de un select
    var valor_linea = $("#txt_matchplan_linea_cbx_"+separa_barra[4]).val();

    // Cargar CBX de SubLínea (Dejar para luego del recorrido de la tabla, se necesita recorrer la tabla)
    $('#txt_matchplan_sublinea_cbx_'+separa_barra[4]).empty();
    var toAppend_subl = '';
    var url = 'ajax_simulador_cbx/listar_optionsSubLinea';
    $.getJSON(url, {ID_LINEA:valor_linea}, function (data) {
        $.each(data, function (i, o) {
            toAppend_subl += '<option value=' + o[0].replace(/[^a-z0-9\-]/gi,'') + '><b>' + o[0].replace(/[^a-z0-9\-]/gi,'') + '<b> - ' + o[1].replace(/[^a-z0-9\-]/gi,'') + '</option>';
        });
        $('#txt_matchplan_sublinea_cbx_'+separa_barra[4]).append(toAppend_subl);
    });

}

$('#btn_generar_match_oc').on('click', function () {

    // Ocualto el btn de actualizar y match
    $('#btn_generar_match_oc').fadeOut();
    $('#btn_actualizar_match').fadeOut();
    $('.loading').fadeIn();

    // Traer la PROFORMA del campo de Texto
    var proforma = $('#txt_match_pi').val();
    var oc = $('#txt_match_oc').val();

    var listarOC_oc = "";
    var listarOC_estado = "";
    var listarOC_estado_oc = "";

    // Se llama solo una vez y se trabaja dos veces con la información (Listar)
    // 1.- Listar Plan de Compra Color ( PLC_PKG_MIGRACION.PRC_GRID_PLAN_COMPRA_COLOR_4 )
    var url_listar_plan_compra = 'ajax_simulador_cbx/listar_plan_compra_color';
    $.getJSON(url_listar_plan_compra,{PROFORMA:proforma}, function (data) {
        $.each(data, function (i, o) {

            // 2.- Generar Match (PLC_PKG_UTILS.PRC_GENERAR_MATCH)
             var url_generar_match = 'ajax_simulador_cbx/generar_match';
             $.getJSON(url_generar_match, {PROFORMA: proforma,ESTILO: o[1],CODVENTANA: o[2],OC: oc}).done( function( data ) {

                 // 3.- Aprobar Opción ( PLC_PKG_UTILS.PRC_APROBACION_PLAN_2 )
                 var url_aprobar_opcion = 'ajax_simulador_cbx/aprobar_opcion';
                 $.getJSON(url_aprobar_opcion, {ID_COLOR3: o[0],PROFORMA: proforma}).done( function( data ) {

                     // 4.- Listar id_color_3_compra ( PLC_PKG_MIGRACION.PRC_LIS_COLOR3_IDCOLOR3 )
                     var url_listar_id_color_3_compra = 'ajax_simulador_cbx/listar_idcolor3_compra';
                     $.getJSON(url_listar_id_color_3_compra, {ID_COLOR3: o[0]}, function (data) {
                         $.each(data, function (a, b) {
                             listarOC_oc = b[0];
                             listarOC_estado = b[1];
                             listarOC_estado_oc = b[2];
                         });

                         // 5.- Insertar Historial ( PLC_PKG_PRUEBA.PRC_ADD_PLAN_HISTORICO )
                         var url_insertar_historial = 'ajax_simulador_cbx/insertar_historial';
                         $.getJSON(url_insertar_historial, {V_LINEA:o[5],V_SUBLINEA:o[6],V_MARCA:o[7],V_ESTILO:o[1],V_VENTANA:o[2],V_COLOR:o[8],V_PI:proforma,V_OC:oc,V_ESTADO:listarOC_estado,V_ID_COLOR3:o[0],V_TIPOINSERT:1,V_NOM_LINEA:o[10],V_NOM_SUBLINEA:o[11],V_NOM_MARCA:o[12],V_NOM_VENTANA:o[13],V_NOM_COLOR:o[14]});

                     });

                 } );

             } );

        });

    // Fin del listar plan color
    }).done( function(data) {

        // Me espero 3 segundo antes de ejecutar las últimas sentencias (Funcionando antes de agregarlo al DONE)
        // Define Tiempo 1 = 1000 ()
        var delay = 4000;
        setTimeout(function () {

            // 5_1.- Quitar los registros asociados a las variaciones (Con el fin de limpiar cargas pre-existentes)
            var url_quita_registro_variacion = 'ajax_simulador_cbx/quita_registro_variacion';
            $.getJSON(url_quita_registro_variacion, {OC: oc, PI: proforma}).done( function( data ) {

                // 6.- Agregar OC Variación ( PLC_PKG_UTILS.PRC_AGREGAR_OC_VARIACION )
                var url_agrega_oc_variacion = 'ajax_simulador_cbx/agregar_oc_variacion';
                $.getJSON(url_agrega_oc_variacion, {OC: oc, PI: proforma}).done( function( data ) {

                    // 7.- Agregar New OC Variación ( PLC_PKG_UTILS.PRC_AGREGAR_NUEVA_VARIACION )
                    var url_agrega_new_oc_variacion = 'ajax_simulador_cbx/agregar_new_oc_variacion';
                    $.getJSON(url_agrega_new_oc_variacion).done( function(data) {

                        alert("Orden de Compra Linkeada.");
                        $('#match_oc').modal('hide');
                        location.reload(true);

                    // Fin de url_agrega_new_oc_variacion
                    });

                // Fin de url_agrega_oc_variacion
                });

            // Fin del quitar variaciones
            });

        }, delay);

    } );




});

$('#btn_actualizar_match').on('click', function () {

    var respuesta = confirm("¿Está seguro(a) de actualizar la información?");
    if (respuesta == true) {

        // Recorrer la tabla y actualizar por <tr> (PLC_PKG_DESARROLLO.PRC_UPDATE_COLOR3_OC)
        $("#match_tabla_plan tbody tr").each(function () {

            var campo_actualizado = $(this).find("td:eq(14)").text();

            if(campo_actualizado == 'U') {

                var id_color3 = $(this).find("td:eq(0)").text();
                var linea = $(this).find("td:eq(3) select").val();
                var sublinea = $(this).find("td:eq(5) select").val();
                var estilo = $(this).find("td:eq(6) input[type='text']").val();
                //estilo = estilo.replace(/[^a-z0-9\-]/gi, ''); // Verificar como se guarda en la BD, ya que se estan quitando los campos que no sean nùmericos y /o guiòn (Comentar si existe algún problema)
                var color = $(this).find("td:eq(7) select").val();

                // Realizamos la carga por <tr>
                if ((id_color3 != "") && (linea != "") && (sublinea != "") && (estilo != "") && (color != "")) {
                    var url_actualiza_match = 'ajax_simulador_cbx/btn_actualizar_match';
                    $.getJSON(url_actualiza_match, {ID_COLOR3: id_color3,LINEA: linea,SUBLINEA: sublinea,ESTILO: estilo,COLOR: color});

                    // Define Tiempo 1 = 1000
                    var delay = 5000;
                    setTimeout(function () {

                        // INI Tablas
                        var flag_encuentra_match = 0;
                        $('#match_tabla_plan >tbody >tr').each(function(){

                            var linea_plan = $(this).find("td:eq(3) select").val();
                            var sublinea_plan = $(this).find("td:eq(5) select").val();
                            var estilo_plan = $(this).find("td:eq(6) input[type='text']").val();
                            var color_plan = $(this).find("td:eq(7) select").val();

                            // Aqui las variables que ven por fila enviada, si no cambia abajo dejo igual o cambio de color
                            flag_encuentra_match = 0;

                            $('#match_tabla_pmm >tbody >tr').each(function(){
                                var linea_pmm = $(this).find("td:eq(2)").html();
                                var sublinea_pmm = $(this).find("td:eq(4)").html();
                                var estilo_pmm = $(this).find("td:eq(6) input[type='text']").val();
                                var color_pmm = $(this).find("td:eq(9)").html();

                                if( (linea_plan==linea_pmm) && (sublinea_plan==sublinea_pmm) && (estilo_plan==estilo_pmm) && (color_plan==color_pmm) ){
                                    flag_encuentra_match++;
                                    return false;
                                }

                                // Fin recorrido segunda tabla
                            });


                            //Si flag_encuentra_match > 0, coloreo el fondo del ID
                            if(flag_encuentra_match == 0) {
                                $(this).find("td:eq(0)").css('background-color', 'red');
                                $(this).find("td:eq(0)").css('color', 'white');
                            }else{
                                $(this).find("td:eq(0)").css('background-color', 'white');
                                $(this).find("td:eq(0)").css('color', 'black');
                            }

                            // Fin recorrido primera tabla
                        });

                        if (flag_encuentra_match == 0) {
                            // No puerdo habilitar botón "Generar Match"
                        } else {
                            // Habilitar botón que Genera Match, el el proceso de match
                            $("#btn_generar_match_oc").attr("disabled", false);
                        }
                        // FIN Tablas

                    }, delay);

                } else {
                    alert("El sistema no pudo obtener un campo necesario para realizar la actualización.\nLamentamos el inconveniente, intente nuevamente o tendrá que realizar los cambios nuevamente.");
                    return false;
                }

            }

            alert("Favor revisar que los cambios fueron realizados.");

        });

    } else {
        alert("No se han realizado cambios");
    }


});

function editaSublinea(event) {

    // hay que cargar nuevamente la sublinea con el id de la linea que ha modificado
    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_"); //separa_barra[4]

    $('#txt_matchplan_updated_'+separa_barra[4]).html("U");

}

function editaEstilo(event) {

    // hay que cargar nuevamente la sublinea con el id de la linea que ha modificado
    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_"); //separa_barra[3]

    $('#txt_matchplan_updated_'+separa_barra[3]).html("U");

}

function editaColor(event) {

    // hay que cargar nuevamente la sublinea con el id de la linea que ha modificado
    var id = $(event.target);
        id = id.attr('id');
    var separa_barra = id.split("_"); //separa_barra[4]

    $('#txt_matchplan_updated_'+separa_barra[4]).html("U");

}

function cargaCBX(depto){

    $('#MARCAS').empty();
    $('#TIENDAS').empty();
    $('#REPLICAR_TIENDA_TEMPORADA').empty();
    $('#DISPONIBLE').empty();
    $('#ASIGNADO').empty();

    $('#MARCAS').append('<option value="">SELECCIONE</option>');
    $('#TIENDAS').append('<option value="">SELECCIONE</option>');

    var url_cbx_popup_tipo_tienda_marca  = 'ajax_simulador_tienda_cbx/cbxMarca';
    var url_cbx_popup_tipo_tienda_ventana = 'ajax_simulador_tienda_cbx/cbxVentana';
    var url_cbx_popup_tipo_tienda_replicatienda = 'ajax_simulador_tienda_cbx/cbxReplicaTienda';

    // Cargar Marcas (MARCAS)
    var toAppend_marca = "";
    $.getJSON(url_cbx_popup_tipo_tienda_marca, {DEPTO:depto}, function (data) {
        $.each(data, function (i,o) {
            if(o[0]!= null){
                toAppend_marca += '<option value='+o[0]+'>'+o[1]+'</option>';
            }
        });
        $('#MARCAS').append(toAppend_marca);
    }).done( function( data ) {

        // Cargar tipo de tienda (TIENDAS)
        var toAppend_ventana = "";
        $.getJSON(url_cbx_popup_tipo_tienda_ventana, {DEPTO:depto}, function (data) {
            $.each(data, function (i,o) {
                if(o[0]!= null) {
                    toAppend_ventana += '<option value=' + o[0] + '>' + o[1] + '</option>';
                }
            });
            $('#TIENDAS').append(toAppend_ventana);
        }).done( function( data ) {

            // Cargar por defecto la tienda internet
            //$("#TIENDAS option:last").attr("selected", "selected");

            // Replica Tienda (REPLICAR_TIENDA_TEMPORADA)
            /*var toAppend_replicar = "";
            $.getJSON(url_cbx_popup_tipo_tienda_replicatienda, {DEPTO:depto}, function (data) {
                $.each(data, function (i,o) {
                    if(o[0]!= null) {
                        toAppend_replicar += '<option value=' + o[0] + '>' + o[1] + '</option>';
                    }
                });
                $('#REPLICAR_TIENDA_TEMPORADA').append(toAppend_replicar);
            });*/

            $('#accion_carga_modulo_tienda').removeClass('fa fa-refresh');
            $('#accion_carga_modulo_tienda').addClass('fa fa-check');

        } );

    } );

// Fin del CBX de tiendas
}

// Verificar el archivo de la PI a subir (Duplicar y poner otras condiciones al validar otro popup, ir a simulador_compra4.html para ver como se llama)
function verificaFormatoArchivo(sender) {

    var validExts = [".xlsx", ".XLS", ".xls", ".XLSX"];
    var fileExt = sender.value;
        fileExt = fileExt.substring(fileExt.lastIndexOf('.'));

    if (validExts.indexOf(fileExt) < 0) {
        alert("RECUERDE: Los formatos de archivos admitidos son: " + validExts.toString());
        // Desabilitar botón por ID
        $(".carga_pi").attr("disabled", "disabled");
        $("#send_archivop_pi").val('');
    }else {
        // Habilitar botón por ID
        $(".carga_pi").attr("disabled", false);
    }

}

// Carga Assortment
$('#form_import_bmt').submit(function(event) {

    // Evitar que se envie automáticamente el form
    event.preventDefault();

    /*$('.loading').fadeIn();
    $('.pull-left').remove();
    $('.carga_bmt').remove();
    $('.close').remove();
*/
    // Verificar que se está cargando un archivo
    var llega_archivo = $('#user_file').val();

    if(llega_archivo.length > 0){
/*exporto Archivo excel a la carpeta del Assorments  ControlCrea/SubirAssorment*/
        $('#seguimiento').html(" Extrayendo Archivo...");
        var form = event.target;
        var data = new FormData(form);
        $.ajax({
            url: form.action,
            method: form.method,
            processData: false,
            contentType: false,
            data: data,
            processData: false,
            success: function (data_sube_archivo) {

                /*Valida si el archivo se cargo*/
                if (data_sube_archivo == 1) {

                    $('#user_file').val('');
                    $('.loading').fadeIn();
                    //$('.carga_bmt').remove();
                    $('.carga_bmt').hide();

                    /*LLamo a las validadciones del archivo*/
                    $('#seguimiento').html(" Validando Datos...");
                    var url_importa_assortment = 'importar_archivo/ImportarAssormentValidaciones';
                    /*Validaciones*/   $.getJSON(url_importa_assortment, function (data_importar) {
                        if (data_importar[0][0] == "false"){
                            $('.loading').hide();
                            $('.pull-left').show();

                            $('.carga_bmt').show();
                            $('#mensaje_error_pop').show();
                            $('#_errorImportar').html(data_importar[0][1]);
                        }else {
                            var insert_historial = 'importar_archivo/ImportarAssormentdelrows';
                            $.getJSON(insert_historial, function (data_insert) {
                                var columnas = data_insert[0];var key = 0;var key2 = 0; var count = data_insert.length - 1; // para que no pase por la rows de la cabecera
                                $('#seguimiento').html(" Insertando Historial Filas: 0/"+count);
                                /*Insert Historial*/             $.each(data_insert, function (i, o) { key2++;
                                    if (key2 !=  1) {key++;
                                        var historial = 'importar_archivo_3/ImportarAssormentInsHistorial';
                                        $.ajax({url: historial,type: 'POST',data: jQuery.param({_rows: o,_columnas:columnas,_delete:key}) ,
                                            success: function (data2) {var _result = data2.split(",");
                                                if (_result[0] == "false"){
                                                    $('.loading').hide();
                                                    $('.pull-left').show();
                                                    $('.carga_bmt').show();
                                                    $('#mensaje_error_pop').show();
                                                    $('#_errorImportar').html(_result[1]);
                                                    return false;
                                                }else{
                                                    var _span1= $('#count').html();
                                                    var _int1 = _result[1];
                                                    var _total1 = Number(_span1) +Number(_int1);
                                                    $('#seguimiento').html(" Insertando Historial Filas: "+_total1  +"/"+count);
                                                    $('#count').html(_total1);
                                                    if (_total1 == count){
                                                        $('#seguimiento').html("  Separación de filas por ventana.");
                                                        var _data = 'importar_archivo/ImpAssormAbrirDataVent';
                                                        $.getJSON(_data, function (_Rowss) {
                                                            if (_Rowss == 0 ){
                                                                $('.loading').hide();
                                                                $('.pull-left').show();
                                                                $('.carga_bmt').show();
                                                                $('#mensaje_error_pop').show();
                                                                $('#_errorImportar').html("Error en separador de ventana.");
                                                                return false;
                                                            }else{
                                                                $('#seguimiento').html("  Calculando Curvado y Costos.");
                                                                var calculos = 'importar_archivo/ImpAssormCalculos';
                                                                $.getJSON(calculos, function (_Rowss) {



                                                                    var columnas2 = _Rowss[0]; var key3 = 0;var key4 =0; var count2 = _Rowss.length-1; $('#count').html(0);
                                                                    /*Insert C1 Assorment*/                                              $.each(_Rowss, function (i, o) {key3++;
                                                                        if (key3 !=  1) {key4++;
                                                                            var _Insert = 'importar_archivo_3/InsertarAssormentC1';
                                                                            $('#seguimiento').html(" Insertando Plan de Compra Filas: 0/" + count2);
                                                                            $.ajax({url: _Insert,type: 'POST',data: jQuery.param({_rows: o,_columnas:columnas2,_delete:key4}) ,
                                                                                success: function (data3) {var _result = data3.split(",");
                                                                                    if (_result[0] == "false"){
                                                                                        $('.loading').hide();
                                                                                        $('.pull-left').show();
                                                                                        $('.carga_bmt').show();
                                                                                        $('#mensaje_error_pop').show();
                                                                                        $('#_errorImportar').html(_result[1]);
                                                                                        return false;
                                                                                    }else{
                                                                                        var _span= $('#count').html();
                                                                                        var _int = _result[1];
                                                                                        var _total = Number(_span) +Number(_int);
                                                                                        $('#seguimiento').html(" Insertando Plan de Compra Filas: "+_total  +"/"+count2);
                                                                                        $('#count').html(_total);
                                                                                        /*Salir*/                                                                        if(_total == count2 ) {
                                                                                            window.location = "importar_archivo2";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                });
                                                            }
                                                        });
                                                    }
                                                }
                                            }
                                        });
                                    }
                                });
                            });
                        }
                    });
                    // fin del if si se carga archivo
                }

            }
        });

    }else{
        alert("Debe ingresar un archivo.");
        return false;
    }

});

function campos_bloquear_tipo_usuario() {

    $('#flag_top_menu_tipo_usuario').html('LECTURA');

    //botones de simulador de compra 4 //
    $(".guarda_proforma").attr("disabled", "disabled");
    $(".detalle_error_pi_").attr("disabled", "disabled");
    //no se crean aun //

    $(".btn_pi_ ").attr("disabled", "disabled");
    $(".txt_proforma_").attr("disabled", "disabled");

    //botnes de importar archivo  //
    $(".importar_bmt").attr("disabled", "disabled");
    $(".carga_bmt").attr("disabled", "disabled");
    $("#modulo_simulador_imp_bmt_subir_archivo").attr("disabled", "disabled");

    //botones del mantenedor de tipo tiendas //
    //$("#MARCAS").attr("disabled", "disabled");
    //$("#TIENDAS").attr("disabled", "disabled");
    $("#tipo_btn").attr("disabled", "disabled"); //guardar abajo del mantenedor tipo tienda
    $("#btn_replicar_popup_tipo_tienda").attr("disabled", "disabled");
    $("#tipo_btn_replicar_tienda").attr("disabled", "disabled");

    // botones del mantenedor de formato//
    // no tiene class o id se les agraga un id y se les llama
    $("#tipo_btn_formatos_nuevo").attr("disabled", "disabled");
    $("#modulo_formato_btn_crear_nuevo").attr("disabled", "disabled");
    $("#tipo_btn_formatos").attr("disabled", "disabled");
    //$("#FORMATO").attr("disabled", "disabled");
    $(".quitar").attr("disabled", "disabled"); // tienen la msima clase que tipo tienda por ende desabilito
    $(".agregar").attr("disabled", "disabled");// tienen la msima clase que tipo tienda por ende desabilito

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

    // botones del mantenedor de presupuesto costo//
    $("#tipo_btn_ppto_costo").attr("disabled", "disabled");
    $("#input_total_ppto_costo").attr("disabled", "disabled");

    // botones del mantenedor de presupuesto Retail//
    $("#tipo_btn_ppto_retail").attr("disabled", "disabled");
    $("#input_total_ppto_retail").attr("disabled", "disabled");

    // links de simulador de compra (flujo de aprobacion)
    $(".solicitud_generacion_oc").css({'pointer-events': 'none'});
    $(".oc_generada").css({'pointer-events': 'none'});
    $(".crear_modificacion").css({'pointer-events': 'none'});
    $(".elimina_opcion").css({'pointer-events': 'none'});
    $(".solicitud_correccion_pi").css({'pointer-events': 'none'});

}

function campos_bloquear_despues_llenar_tabla(){

    var url_busca_cod_tip_usr                   = 'permiso_usuario/busca_cod_tip_usr';
    var url_buscar_modulos_estados_desactivado  = 'permiso_usuario/buscar_modulos_estados_desactivado';
    var url_buscar_accion_estados_desactivado   = 'permiso_usuario/buscar_accion_estados_descativado';
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

            //aumentar flag para validar carga del simulador
            $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);

            $('#accion_carga_permisos_simulador').removeClass('fa fa-refresh');
            $('#accion_carga_permisos_simulador').addClass('fa fa-check');

            $.getJSON(url_buscar_accion_estados_desactivado,{ID_TIP_USR:tipo_usuario}, function (data_accion) {
                $.each(data_accion, function (i, a) {

                    arreglo_accion_desac.push({
                        id_accion:a[0]
                    });

                });
            }).done(function (data_accion) {

                // VALIDAR MODULO DE REGISTRO DE COMPRA
                // VALIDAR BOTONES DEL MODULO DE REGISTRO DE COMPRA
                var verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==29;});

                if (verifica_accion.length > 0){
                    $(".txt_cod_padre_").each(function (){
                        this.style.pointerEvents = 'none';
                    });
                }

                verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==30;});
                if (verifica_accion.length > 0){
                    $(".txt_proforma_").attr("disabled", "disabled");
                }

                verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==31;});
                if (verifica_accion.length > 0){
                    $(".detalle_error_pi_").attr("disabled", "disabled");
                }

                verifica_accion = $.grep(arreglo_accion_desac,function(e){return e.id_accion==32;});
                if (verifica_accion.length > 0){
                    $(".btn_pi_").attr("disabled", "disabled");
                }

                //aumentar flag para validar carga del simulador
                $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);

                $('#accion_carga_configuracion_permisos_simulador').removeClass('fa fa-refresh');
                $('#accion_carga_configuracion_permisos_simulador').addClass('fa fa-check');
            });

        });

    });

}

$('#btn_esconder_tabla1').on('click',function () {

    $('#div_contenedor_tabla1').hide();
    $('#btn_esconder_tabla1').hide();
    $('#btn_mostrar_tabla1').show();

    $('.dataTables_scrollBody').attr('style','position: relative; overflow: auto; width: 100%; max-height: 60%;');

});

$('#btn_mostrar_tabla1').on('click',function () {

    $('#div_contenedor_tabla1').show();
    $('#btn_esconder_tabla1').show();
    $('#btn_mostrar_tabla1').hide();

    $('.dataTables_scrollBody').attr('style','position: relative; overflow: auto; width: 100%; max-height: 140px;');

});

//funcion que genera un cronometro y segun iontervalos valida a los usuarios con estado ("pedido")
function Validar_flag_concurrencia_usuario_log() {

    var flag_detener_validar = $('#flag_detener_validar_session').html();

    var url_buscar_sesion_activa_usuario_log = 'permiso_usuario/buscar_sesion_activa_usuario_log';

    var span_depto_validar_concurrencia = $('#span_temporada').text();
        span_depto_validar_concurrencia = span_depto_validar_concurrencia.replace(/[^a-z0-9\-]/gi, '');
    var separa_span_depto_validar = span_depto_validar_concurrencia.split("-");

    var depto = separa_span_depto_validar[1];
    var tempo = separa_span_depto_validar[0];

    var flag_lectura = '';
        flag_lectura = flag_lectura.replace(/[^a-z0-9\-]/gi, '');

    var contador_s = 0;
    var contador_m = 0;

    var s = document.getElementById("segundos");
    var m = document.getElementById("minutos");

    var  cronometro_session = setInterval(
        function () {

            if (contador_s == 60) {
                contador_s = 0;
                contador_m++;
                m.innerHTML = contador_m;

                if (contador_m == 2) {
                    contador_m = 0;
                }
            }

            //los usuarios de tipo lectura no generan concurrencia por ende no se consideran.
            flag_lectura = $('#flag_top_menu_tipo_usuario').text();

            if (flag_lectura != 'LECTURA') {

                if ((contador_m == 0) && (contador_s == 30)) {

                    //llamada para saber si el usuario logueado en el departamento tiene el estado de ("pedido")//
                    // ("pedido") quiere decir que esta siendo expulsado//
                    $.getJSON(url_buscar_sesion_activa_usuario_log, {DEPTO: depto}, function (data) {
                        if (data == 1) {

                            //asiganeremos a un flag el estado 1, cuando el primer popup de aviso se haya mostrado
                            $('#flag_top_primer_aviso').html('1');
                            $('#pop_up_usuario_quitar').modal('show');

                            //llamo a la funcion que sirve para mostrar y establecer el tiempo restante del usuario
                            conteo_regresivo();
                        }
                    });
                }

                var primer_aviso = $('#flag_top_primer_aviso').text();

                //se toma el valor del flag para validar si ya aviso por primera vez
                if ((primer_aviso == 1) && (contador_m == 1) && (contador_s == 20)) {

                    $('#popup_usario_expirado').modal('show');

                    var delay_salir_main = 3000;
                    setTimeout(function () {
                        $('#btn_salir_main').click();
                    }, delay_salir_main);

                }

            }else{
                clearInterval(cronometro_session);
            }

            s.innerHTML = contador_s;
            contador_s++;

        }, 1000);

}

//Validar si el usuario esta ("pedido")
function validar_usuario_recarga_sesion_expirada() {

    var url_buscar_sesion_activa_usuario_log = 'permiso_usuario/buscar_sesion_activa_usuario_log';

    var separa_span_depto_validar_flag_concurrencia = $('#span_temporada').text();
        separa_span_depto_validar_flag_concurrencia = separa_span_depto_validar_flag_concurrencia.replace(/[^a-z0-9\-]/gi,'');
    var separa_span_depto_validar = separa_span_depto_validar_flag_concurrencia.split("-");

    var depto = separa_span_depto_validar[1];

    $.getJSON(url_buscar_sesion_activa_usuario_log, {DEPTO: depto}, function (data) {
        if (data == 1) {
            $('#popup_cargando_simulador_compra_4').modal('hide');
            $('#popup_usario_expirado').modal('show');

            var delay_salir_main = 3000;
            setTimeout(function () {
                $('#btn_salir_main').click();
            }, delay_salir_main);

        }
    });

}

//genero y muestro un conteo regresivo
function conteo_regresivo() {

    //hacer visible el cronometro
    $('#conteo_regresivo_seg_div').show();
    var cont_seg = 50;

    var seg = document.getElementById("seg_cont_regresivo");

    var cronometro = setInterval(
        function () {

            if (cont_seg == 0) {
                cont_seg = 50;
                clearInterval(cronometro);
            }

            seg.innerHTML = cont_seg;
            cont_seg--;

        },1000);

}

$('#btn_limpiar_filtro_sim_comp').on('click',function () {

    $('input.filtro').val('');

    var table = $('#tabla2').DataTable();
        table.search('').columns().search('').draw();
    cal_campos();

});

function cal_campos() {

    $('.datatables_empty').remove();

    //conteo de registros de la grilla (tabla 2)
    var nfilas  = $("#tabla2 tbody tr").length;
    var nColumnas = $("#tabla2 tbody td").length;

    if (nColumnas == 0){
        $('.odd').append("<td class='dataTables_empty' style='alignment: center' colspan='91'>No se encontraron registros</td>");
        $('#span_conteo_registro_tabla2').html("Existen:  "+nColumnas+"  registros");
        $('#tfoot_totales_campos_calculados').css('display','none');
    } else {
        $('#span_conteo_registro_tabla2').html("Existen:  "+nfilas+"  registros");
        $('#tfoot_totales_campos_calculados').css('display','');
    }

    //definicion de variables para calcular totales de la grilla
    var sum_unid_ini = 0;
    var sum_unid_ajust = 0;
    var sum_unid_final = 0;

    var sum_primera_carga = 0;

    const noTruncarDecimales = {maximumFractionDigits: 2};
    const noTruncarDecimales2 = {maximumFractionDigits: 0};

    var sum_costo_unitario_final_us = 0;
    var sum_costo_unitario_final_pesos = 0;
    var sum_total_target_us = 0;
    var sum_total_fob_us = 0;
    var sum_costo_total_pesos = 0;
    var sum_total_retail_pesos_sin_iva = 0;

    var cal_costo_costo_unit_final_pesos = 0;
    var cal_costos_unitarios_final_us = 0;
    var total_fob_sin_costo = 0;

    var cal_fob = 0 ;
    var cal_target = 0 ;
    var cal_precio_blanco = 0;
    var cal_mkup = 0;
    var cal_tienda = 0;

    var flag_sum_campos = 0;

    var elem = $('#tabla2 thead tr:last th');
    var rIndex;


    var txt_uniini = elem.filter(
        function(txt_uniini){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Uni Ini';
            if (result)
                rIndex = txt_uniini;
            return result;
        }).index();

    var txt_uni_ajust = elem.filter(
        function(txt_uni_ajust){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Uni Ajust';
            if (result)
                rIndex = txt_uni_ajust;
            return result;
        }).index();

    var txt_uni_final = elem.filter(
        function(txt_uni_final){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Uni Final';
            if (result)
                rIndex = txt_uni_final;
            return result;
        }).index();

    var txt_primera_carga = elem.filter(
        function(txt_primera_carga){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Primera Carga';
            if (result)
                rIndex = txt_primera_carga;
            return result;
        }).index();

    var txt_tiendas = elem.filter(
        function(txt_tiendas){
            var labelText = $(this).find('labele').text();
            var result = labelText == '% Tiendas';
            if (result)
                rIndex = txt_tiendas;
            return result;
        }).index();

    var txt_mkup = elem.filter(
        function(txt_mkup){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Mkup';
            if (result)
                rIndex = txt_mkup;
            return result;
        }).index();

    var txt_precio_blanco = elem.filter(
        function(txt_precio_blanco){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Precio Blanco';
            if (result)
                rIndex = txt_precio_blanco;
            return result;
        }).index();

    var txt_target = elem.filter(
        function(txt_target){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Target';
            if (result)
                rIndex = txt_target;
            return result;
        }).index();

    var txt_fob = elem.filter(
        function(txt_fob){
            var labelText = $(this).find('labele').text();
            //alert(index + ' - ' + labelText);
            var result = labelText == 'FOB';
            if (result)
                rIndex = txt_fob;
            return result;
        }).index();

    var txt_costo_unitario_final_us = elem.filter(
        function(txt_costo_unitario_final_us){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Costo Unitarios Final US';
            if (result)
                rIndex = txt_costo_unitario_final_us;
            return result;
        }).index();

    var txt_costo_unitario_final_pesos = elem.filter(
        function(txt_costo_unitario_final_pesos){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Costo Unitario Final Pesos';
            if (result)
                rIndex = txt_costo_unitario_final_pesos;
            return result;
        }).index();

    var txt_total_tarjet_us = elem.filter(
        function(txt_total_tarjet_us){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Total Target US$';
            if (result)
                rIndex = txt_total_tarjet_us;
            return result;
        }).index();

    var txt_total_fob_us = elem.filter(
        function(txt_total_fob_us){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Total FOB US$';
            if (result)
                rIndex = txt_total_fob_us;
            return result;
        }).index();

    var txt_costo_total_pesos = elem.filter(
        function(txt_costo_total_pesos){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Costo Total Pesos';
            if (result)
                rIndex = txt_costo_total_pesos;
            return result;
        }).index();

     var txt_costo_total_reatil_pesos = elem.filter(
        function(txt_costo_total_reatil_pesos){
            var labelText = $(this).find('labele').text();
            var result = labelText == 'Total Retail Pesos (Sin IVA)';
            if (result)
                rIndex = txt_costo_total_reatil_pesos;
            return result;
        }).index();


    // recorrer tabla para sumar totales
    $(".tabla2 > tbody >tr").each(function () {

        // 24 Eliminado

        if ($(".tabla2 #txt_estadoc1_"+flag_sum_campos).html() != 24) {

            sum_unid_ini += parseInt($(this).find("td:eq("+txt_uniini+")").html()); //SUM
            sum_unid_ajust += parseInt($(this).find("td:eq("+txt_uni_ajust+")").html()); // SUM
            sum_unid_final += parseInt($(this).find("td:eq("+txt_uni_final+")").html()); // SUM

            sum_primera_carga += parseInt($(this).find("td:eq("+txt_primera_carga+")").html()); //SUM

            total_fob_sin_costo += (parseFloat($(this).find("td:eq("+txt_primera_carga+")").html()) * parseFloat($(this).find("td:eq("+txt_target+")").html()));

            sum_costo_unitario_final_us += parseInt($(this).find("td:eq("+txt_costo_unitario_final_us+")").html()); //CAL (costo_total_fob_us/unid_final)
            sum_costo_unitario_final_pesos += parseInt($(this).find("td:eq("+txt_costo_unitario_final_pesos+")").html()); //CAL (sum_costo_total_pesos/unid_final)
            sum_total_target_us += parseFloat($(this).find("td:eq("+txt_total_tarjet_us+")").html()); //SUM
            sum_total_fob_us += parseFloat($(this).find("td:eq("+txt_total_fob_us+")").html()); //SUM
            sum_costo_total_pesos += parseInt($(this).find("td:eq("+txt_costo_total_pesos+")").html()); //SUM
            sum_total_retail_pesos_sin_iva += parseInt($(this).find("td:eq("+txt_costo_total_reatil_pesos+")").html()); //SUM


        }

        flag_sum_campos++;

    });

    //calcular Columna "Costo unitario Final pesos"
    cal_costo_costo_unit_final_pesos = sum_costo_total_pesos/sum_unid_final;
    cal_costo_costo_unit_final_pesos = cal_costo_costo_unit_final_pesos.toLocaleString('es', noTruncarDecimales);

    //Calcular columna "Costo Unitarios Final Us" = sum(total fob us) / sum(uni final)
    cal_costos_unitarios_final_us = sum_total_fob_us/sum_unid_final;
    cal_costos_unitarios_final_us = cal_costos_unitarios_final_us.toLocaleString('es', noTruncarDecimales);

    //calcular columna "FOB"  (total FOB sin costo) = sum(unid fin * fob)
    // (total FOB sin costo) /sum (unid fin)
    cal_fob = total_fob_sin_costo/sum_unid_final;
    cal_fob = cal_fob.toLocaleString('es', noTruncarDecimales);

    //calcular columna "target" = sum(total target) / sum(unid fin)
    cal_target = sum_total_target_us/sum_unid_final;
    cal_target = cal_target.toLocaleString('es', noTruncarDecimales);

    //calular columna "precio blanco" = sum(total ret sin iva) / sum(unid fin)
    cal_precio_blanco = ((sum_total_retail_pesos_sin_iva/sum_unid_final)*1.19);
    cal_precio_blanco = cal_precio_blanco.toLocaleString('es', noTruncarDecimales2);

    //calcular mkup =sum(total ret sin iva) / sum(total costo pesos)
    cal_mkup = sum_total_retail_pesos_sin_iva/sum_costo_total_pesos;
    cal_mkup =  cal_mkup.toLocaleString('es', noTruncarDecimales);

    //cal % tienda  = sum(primera_carga) / sum(unid fin)
    cal_tienda = (sum_primera_carga/sum_unid_final)*100;
    cal_tienda = cal_tienda.toLocaleString('es', noTruncarDecimales);

    //seteo a formato miles para sumas totales
    sum_unid_ini = sum_unid_ini.toLocaleString('es', noTruncarDecimales);
    sum_unid_ajust = sum_unid_ajust.toLocaleString('es', noTruncarDecimales);
    sum_unid_final = sum_unid_final.toLocaleString('es', noTruncarDecimales);

    sum_primera_carga = sum_primera_carga.toLocaleString('es', noTruncarDecimales);

    sum_total_fob_us = sum_total_fob_us.toLocaleString('es', noTruncarDecimales);
    sum_total_target_us = sum_total_target_us.toLocaleString('es', noTruncarDecimales);
    sum_total_retail_pesos_sin_iva = sum_total_retail_pesos_sin_iva.toLocaleString('es', noTruncarDecimales);
    sum_costo_total_pesos = sum_costo_total_pesos.toLocaleString('es', noTruncarDecimales);

    $('#campo_total_uni_ini').html(sum_unid_ini);
    $('#campo_total_uni_ajust').html(sum_unid_ajust);
    $('#campo_total_uni_final').html(sum_unid_final);

    $('#campo_total_primera_carga').html(sum_primera_carga);
    $('#campo_total_tiendas').html(cal_tienda+"%");

    $('#campo_total_mkup').html(cal_mkup);
    $('#campo_total_precio_blanco').html(cal_precio_blanco);

    $('#campo_total_target').html(cal_target);
    $('#campo_total_fob').html(cal_fob);

    $('#campo_total_costo_unitario_final_us').html(cal_costos_unitarios_final_us);
    $('#campo_total_costo_unitario_final_pesos').html(cal_costo_costo_unit_final_pesos);
    $('#campo_total_target_us').html(sum_total_target_us);
    $('#campo_total_fob_us').html(sum_total_fob_us);
    $('#campo_total_costo_total_pesos').html(sum_costo_total_pesos);
    $('#campo_total_retail_pesos_sin_iva').html(sum_total_retail_pesos_sin_iva);

    // -- validar -- momento en que termine --
    $('#flag_top_aviso_termino_carga').html( parseInt($('#flag_top_aviso_termino_carga').html())+1);

    $('#accion_carga_totales_tabla2').removeClass('fa fa-refresh');
    $('#accion_carga_totales_tabla2').addClass('fa fa-check');


}

function validar_aviso_carga_de_simulador() {

    var contador_seg_carga = 0;
    var contador_m = 0;

    var seg_carga = document.getElementById("segundos_simulador");

    var cronometro = setInterval(
        function () {

            if (contador_seg_carga == 31) {
                contador_seg_carga = 0;
            }

            if (contador_seg_carga == 30) {
                //Validar flag_top_aviso_termino_carga
                if ($('#flag_top_aviso_termino_carga').text() == 7){

                    //$('#span_accion_cargando').html('Datos Cargados');
                    $('#accion_carga_completo').removeClass('fa fa-refresh');
                    $('#accion_carga_completo').addClass('fa fa-check');

                    var delay_salir_main = 2000;
                    setTimeout(function () {
                    $('#popup_cargando_simulador_compra_4').modal('hide');
                    }, delay_salir_main);

                }

            }


            seg_carga.innerHTML = contador_seg_carga;
            contador_seg_carga++;

        },1000);

}

$('.importar_bmt').on('click',function () {

    $('#flag_top_menu_tipo_usuario').html('LECTURA');

});

$('#btn_salir_popup_import_bmt').on('click' ,function () {

    $('#flag_top_menu_tipo_usuario').html('');
   Validar_flag_concurrencia_usuario_log();
   
});


