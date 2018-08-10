/*! Controlador Jquery 
 * Mantenedores del MAIN
 * @Author  Rodrigo Rioseco
 * @Editado Roberto Pérez (tienda, formato, curva)
 */

$(function () {

    /*ABRE POPUP MODAL PERFIL*/
    $('.eliminar_bmt').on('click', function () {
        $('.registro').html('<b> ' + $('.bmt').html() + ' </b>');
    });

    $('.actualiza_grid').on('click', function () {
        location.reload();
    });

    $('.carga_bmt').on('click', function () {
            $('.loading').fadeIn();
            $('.pull-left').remove();
            $('.carga_bmt').remove();
            $('.close').remove();
            $('.form_import_bmt').submit();
        //}

    });

});


$(window).on('load', function () {


    $('#hot-display-license-info').remove();
    $('#hot-display-license-info').remove();

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



// ############################################## TRABAJO GRILLA 2 LLENAR GRILLA ##################################################################

// 1.- Llenar Grilla
// 2.- Cargar CBX
// 3.- Asignar a CBX los valoles que llegan



    // Cargar Línea
    /*var url_cargalinea = 'ajax_simulador_cbx/listar_optionsLinea';
    var cbx_cargalinea = [];
    $.getJSON(url_cargalinea, function (data) {
        $.each(data, function (i,o) {
            cbx_cargalinea.push({ "id" : o[0], "name" : o[1] });
        });
    });


    cbx_cargalinea.forEach(function(item) {
        alert(item.key+'-'+item.value);
    });*/


    /*var options = [];
    $('#mySelect option').each(function() {
        options.push({ "id" : this.value, "name" : this.textContent });
    });*/

    // Encontar elemento en select
    /*var result = [{"id":"1","price":"20.46"},{"id":"2","price":"40.00"}]
    var userinputid = 1;
    result.forEach(function(e) {
        if (userinputid == e.id) alert(e.price);
    });*/

    //var arrNames = [];
    /*options.forEach(function(item) {
        //var val = item.name
        //arrNames.push(val);
        alert(item.id+'-'+item.name);
    });*/



    /*var url_asignado = 'ajax_simulador_cbx/listar_optionsLinea';
    var toAppend_asignado = "";

    $.getJSON(url_asignado, {FORMATO:formato_seleccionado}, function (data) {

        $.each(data, function (i,o) {
            toAppend_asignado += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });

        $('.cbx_linea_').append(toAppend_asignado);

    });*/

    //onchange="buscarSubLinea(this.value)"

    // Cargar datos de la grilla 2
    var url_carga_tabla2 = 'ajax_simulador_cbx/llenar_tabla2';
    var flag_tabla2 = 0 ;
    $.getJSON(url_carga_tabla2, function (data) {
        $.each(data, function (i,o) {
            $('#tabla2').append('<tr>\n' +
                '<td><input type="text" id="txt_gcompra_'+flag_tabla2+'" name="txt_gcompra_'+flag_tabla2+'" class="form-control input-sm" value="'+o[1]+'"></td>\n' +
                '<td><select id="cbx_temp_'+flag_tabla2+'" name="cbx_temp_'+flag_tabla2+'" class="form-control input-sm"></select></td>\n' +
                '<td><select id="cbx_linea_'+flag_tabla2+'" name="cbx_linea_'+flag_tabla2+'" class="input-sm cbx_linea_" onchange="buscarSubLinea(this.id,this.value)"></select></td>\n' +
                '<td><select id="cbx_sublinea_'+flag_tabla2+'" name="cbx_sublinea_'+flag_tabla2+'" class="input-sm cbx_sublinea_"></select></td>\n' +
                '<td><select id="cbx_marca_'+flag_tabla2+'" name="cbx_marca_'+flag_tabla2+'" class="input-sm cbx_marca_"></select></td>\n' +
                '<td><input type="text" id="txt_estilo_'+flag_tabla2+'" name="txt_estilo_'+flag_tabla2+'" class="form-control input-sm" value="'+o[6]+'"></td>\n' +
                '<td><input type="text" id="txt_codcorp_'+flag_tabla2+'" name="txt_codcorp_'+flag_tabla2+'" class="form-control input-sm" value="'+o[7]+'"></td>\n' +
                '<td><input type="text" id="txt_desc_'+flag_tabla2+'" name="txt_desc_'+flag_tabla2+'" class="form-control input-sm" value="'+o[8]+'"></td>\n' +
                '<td><input type="text" id="txt_descinternet_'+flag_tabla2+'" name="txt_descinternet_'+flag_tabla2+'" class="form-control input-sm" value="'+o[9]+'"></td>\n' +
                '<td><input type="text" id="txt_composicion_'+flag_tabla2+'" name="txt_composicion_'+flag_tabla2+'" class="form-control input-sm" value="'+o[10]+'"></td>\n' +
                '<td><input type="text" id="txt_coleccion_'+flag_tabla2+'" name="txt_coleccion_'+flag_tabla2+'" class="form-control input-sm" value="'+o[11]+'"></td>\n' +
                '<td><input type="text" id="txt_evento_'+flag_tabla2+'" name="txt_evento_'+flag_tabla2+'" class="form-control input-sm" value="'+o[12]+'"></td>\n' +
                '<td><select id="cbx_estilovida_'+flag_tabla2+'" name="cbx_estilovida_'+flag_tabla2+'" class="input-sm cbx_estilovida_"></select></td>\n' +
                '<td><input type="text" id="txt_calidad_'+flag_tabla2+'" name="txt_calidad_'+flag_tabla2+'" class="form-control input-sm" value="'+o[14]+'"></td>\n' +
                '<td><select id="cbx_ocacionuso_'+flag_tabla2+'" name="cbx_ocacionuso_'+flag_tabla2+'" class="input-sm cbx_ocacionuso_"></select></td>\n' +
                '<td><select id="cbx_piramidemix_'+flag_tabla2+'" name="cbx_piramidemix_'+flag_tabla2+'" class="input-sm cbx_piramidemix_"></select></td>\n' +
                '<td><select id="cbx_ventana_'+flag_tabla2+'" name="cbx_ventana_'+flag_tabla2+'" class="input-sm cbx_ventana_"></select></td>\n' +
                '<td><select id="cbx_rankvta_'+flag_tabla2+'" name="cbx_rankvta_'+flag_tabla2+'" class="input-sm cbx_rankvta_"></select></td>\n' +
                '<td><select id="cbx_ciclovida_'+flag_tabla2+'" name="cbx_ciclovida_'+flag_tabla2+'" class="input-sm cbx_ciclovida_"></select></td>\n' +
                '<td><select id="cbx_color_'+flag_tabla2+'" name="cbx_color_'+flag_tabla2+'" class="input-sm cbx_color_"></select></td>\n' +
                '<td><input type="button" id="btn_hist_'+flag_tabla2+'" name="btn_hist_'+flag_tabla2+'" class="form-control input-sm" value="Boton"></td>\n' +
                '<td><select id="cbx_tipoproducto_'+flag_tabla2+'" name="cbx_tipoproducto_'+flag_tabla2+'" class="input-sm cbx_tipoproducto_"></select></td>\n' +
                '<td><select id="cbx_tipoexhibicion_'+flag_tabla2+'" name="cbx_tipoexhibicion_'+flag_tabla2+'" class="input-sm cbx_tipoexhibicion_"></select></td>\n' +
                '<td><input type="text" id="txt_tallas_'+flag_tabla2+'" name="txt_tallas_'+flag_tabla2+'" class="form-control input-sm" value="'+o[23]+'"></td>\n' +
                '<td><input type="text" id="txt_compraini_'+flag_tabla2+'" name="txt_compraini_'+flag_tabla2+'" class="form-control input-sm" value="'+o[24]+'"></td>\n' +
                '<td><input type="text" id="txt_compraajust_'+flag_tabla2+'" name="txt_compraajust_'+flag_tabla2+'" class="form-control input-sm" value="'+o[25]+'"></td>\n' +
                '<td><input type="button" id="btn_ajust_'+flag_tabla2+'" name="btn_ajust_'+flag_tabla2+'" class="form-control input-sm" value="boton"></td>\n' +
                '<td><input type="text" id="txt_curva_'+flag_tabla2+'" name="txt_curva_'+flag_tabla2+'" class="form-control input-sm" value="'+o[26]+'"></td>\n' +
                '<td><input type="text" id="txt_curvamin_'+flag_tabla2+'" name="txt_curvamin_'+flag_tabla2+'" class="form-control input-sm" value="'+o[27]+'"></td>\n' +
                '<td><input type="text" id="txt_uniini_'+flag_tabla2+'" name="txt_uniini_'+flag_tabla2+'" class="form-control input-sm" value="'+o[28]+'"></td>\n' +
                '<td><input type="text" id="txt_uniajust_'+flag_tabla2+'" name="txt_uniajust_'+flag_tabla2+'" class="form-control input-sm" value="'+o[29]+'"></td>\n' +
                '<td><input type="text" id="txt_unifinal_'+flag_tabla2+'" name="txt_unifinal_'+flag_tabla2+'" class="form-control input-sm" value="'+o[30]+'"></td>\n' +
                '<td><input type="text" id="txt_mtrpack_'+flag_tabla2+'" name="txt_mtrpack_'+flag_tabla2+'" class="form-control input-sm" value="'+o[31]+'"></td>\n' +
                '<td><input type="text" id="txt_ncajas_'+flag_tabla2+'" name="txt_ncajas_'+flag_tabla2+'" class="form-control input-sm" value="'+o[32]+'"></td>\n' +
                '<td><select id="cbx_cluster_'+flag_tabla2+'" name="cbx_cluster_'+flag_tabla2+'" class="input-sm cbx_cluster_"></select></td>\n' +
                '<td><select id="cbx_formato_'+flag_tabla2+'" name="cbx_formato_'+flag_tabla2+'" class="input-sm cbx_formato_"></select></td>\n' +
                '<td><input type="text" id="txt_tdas_'+flag_tabla2+'" name="txt_tdas_'+flag_tabla2+'" class="form-control input-sm" value="'+o[35]+'"></td>\n' +
                '<td><input type="text" id="txt_a_'+flag_tabla2+'" name="txt_a_'+flag_tabla2+'" class="form-control input-sm" value="'+o[36]+'"></td>\n' +
                '<td><input type="text" id="txt_b_'+flag_tabla2+'" name="txt_b_'+flag_tabla2+'" class="form-control input-sm" value="'+o[37]+'"></td>\n' +
                '<td><input type="text" id="txt_c_'+flag_tabla2+'" name="txt_c_'+flag_tabla2+'" class="form-control input-sm" value="'+o[38]+'"></td>\n' +
                '<td><input type="text" id="txt_i_'+flag_tabla2+'" name="txt_i_'+flag_tabla2+'" class="form-control input-sm" value="'+o[39]+'"></td>\n' +
                '<td><input type="text" id="txt_primeracarga_'+flag_tabla2+'" name="txt_primeracarga_'+flag_tabla2+'" class="form-control input-sm" value="'+o[40]+'"></td>\n' +
                '<td><input type="text" id="txt_tiendas_'+flag_tabla2+'" name="txt_tiendas_'+flag_tabla2+'" class="form-control input-sm" value="'+o[41]+'"></td>\n' +
                '<td><select id="cbx_proced_'+flag_tabla2+'" name="cbx_proced_'+flag_tabla2+'" class="input-sm cbx_proced_"></select></td>\n' +
                '<td><select id="cbx_via_'+flag_tabla2+'" name="cbx_via_'+flag_tabla2+'" class="input-sm cbx_via_"></select></td>\n' +
                '<td><select id="cbx_pais_'+flag_tabla2+'" name="cbx_pais_'+flag_tabla2+'" class="input-sm cbx_pais_"></select></td>\n' +
                '<td><input type="text" id="txt_viaje_'+flag_tabla2+'" name="txt_viaje_'+flag_tabla2+'" class="form-control input-sm" value="'+o[45]+'"></td>\n' +
                '<td><input type="text" id="txt_mkup_'+flag_tabla2+'" name="txt_mkup_'+flag_tabla2+'" class="form-control input-sm" value="'+o[46]+'"></td>\n' +
                '<td><input type="text" id="txt_precioblanco_'+flag_tabla2+'" name="txt_precioblanco_'+flag_tabla2+'" class="form-control input-sm" value="'+o[47]+'"></td>\n' +
                '<td><input type="text" id="txt_gm_'+flag_tabla2+'" name="txt_gm_'+flag_tabla2+'" class="form-control input-sm" value=""></td>\n' +
                '<td><select id="cbx_moneda_'+flag_tabla2+'" name="cbx_moneda_'+flag_tabla2+'" class="input-sm cbx_moneda_"></select></td>\n' +
                '<td><input type="text" id="txt_target_'+flag_tabla2+'" name="txt_target_'+flag_tabla2+'" class="form-control input-sm" value="'+o[49]+'"></td>\n' +
                '<td><input type="text" id="txt_fob_'+flag_tabla2+'" name="txt_fob_'+flag_tabla2+'" class="form-control input-sm" value="'+o[50]+'"></td>\n' +
                '<td><input type="text" id="txt_insp_'+flag_tabla2+'" name="txt_insp_'+flag_tabla2+'" class="form-control input-sm" value="'+o[51]+'"></td>\n' +
                '<td><input type="text" id="txt_rfid_'+flag_tabla2+'" name="txt_rfid_'+flag_tabla2+'" class="form-control input-sm" value="'+o[52]+'"></td>\n' +
                '<td><input type="text" id="txt_royalty_'+flag_tabla2+'" name="txt_royalty_'+flag_tabla2+'" class="form-control input-sm" value="'+o[53]+'"></td>\n' +
                '<td><input type="text" id="txt_costounitariofinalusd_'+flag_tabla2+'" name="txt_costounitariofinalusd_'+flag_tabla2+'" class="form-control input-sm" value="'+o[54]+'"></td>\n' +
                '<td><input type="text" id="txt_costounitariofinalpeso_'+flag_tabla2+'" name="txt_costounitariofinalpeso_'+flag_tabla2+'" class="form-control input-sm" value="'+o[55]+'"></td>\n' +
                '<td><input type="text" id="txt_totaltargetusd_'+flag_tabla2+'" name="txt_totaltargetusd_'+flag_tabla2+'" class="form-control input-sm" value="'+o[56]+'"></td>\n' +
                '<td><input type="text" id="txt_totalfobusd_'+flag_tabla2+'" name="txt_totalfobusd_'+flag_tabla2+'" class="form-control input-sm" value="'+o[57]+'"></td>\n' +
                '<td><input type="text" id="txt_costototalpesos_'+flag_tabla2+'" name="txt_costototalpesos_'+flag_tabla2+'" class="form-control input-sm" value="'+o[58]+'"></td>\n' +
                '<td><input type="text" id="txt_totalretailpesos_'+flag_tabla2+'" name="txt_totalretailpesos_'+flag_tabla2+'" class="form-control input-sm" value="'+o[59]+'"></td>\n' +
                '<td><input type="text" id="txt_debutreorder_'+flag_tabla2+'" name="txt_debutreorder_'+flag_tabla2+'" class="form-control input-sm" value="'+o[60]+'"></td>\n' +
                '<td><input type="text" id="txt_semini_'+flag_tabla2+'" name="txt_semini_'+flag_tabla2+'" class="form-control input-sm" value="'+o[61]+'"></td>\n' +
                '<td><input type="text" id="txt_semfin_'+flag_tabla2+'" name="txt_semfin_'+flag_tabla2+'" class="form-control input-sm" value="'+o[62]+'"></td>\n' +
                '<td><input type="text" id="txt_semanasciclovida_'+flag_tabla2+'" name="txt_semanasciclovida_'+flag_tabla2+'" class="form-control input-sm" value="'+o[63]+'"></td>\n' +
                '<td><input type="text" id="txt_agotobj_'+flag_tabla2+'" name="txt_agotobj_'+flag_tabla2+'" class="form-control input-sm" value="'+(o[64]*100)+'"></td>\n' +
                '<td><input type="text" id="txt_semanasliquidacion_'+flag_tabla2+'" name="txt_semanasliquidacion_'+flag_tabla2+'" class="form-control input-sm" value="'+o[65]+'"></td>\n' +
                '<td><input type="text" id="txt_proveedor_'+flag_tabla2+'" name="txt_proveedor_'+flag_tabla2+'" class="form-control input-sm" value="'+o[66]+'"></td>\n' +
                '<td><select id="cbx_razonsocial_'+flag_tabla2+'" name="cbx_razonsocial_'+flag_tabla2+'" class="input-sm cbx_razonsocial_"></select></td>\n' +
                '<td><select id="cbx_trader_'+flag_tabla2+'" name="cbx_trader_'+flag_tabla2+'" class="input-sm cbx_trader_"></select></td>\n' +
                '<td><input type="text" id="txt_cod_sku_proveedor_'+flag_tabla2+'" name="txt_cod_sku_proveedor_'+flag_tabla2+'" class="form-control input-sm" value="'+o[69]+'"></td>\n' +
                '<td><input type="text" id="txt_codpadre_'+flag_tabla2+'" name="txt_codpadre_'+flag_tabla2+'" class="form-control input-sm" value="'+o[70]+'"></td>\n' +
                '<td><input type="text" id="txt_proforma_'+flag_tabla2+'" name="txt_proforma_'+flag_tabla2+'" class="form-control input-sm" value="'+o[71]+'"></td>\n' +
                '<td><input type="text" id="txt_archivo_'+flag_tabla2+'" name="txt_archivo_'+flag_tabla2+'" class="form-control input-sm" value="'+o[72]+'"></td>\n' +
                '<td><input type="button" id="btn_pi_'+flag_tabla2+'" name="btn_pi_'+flag_tabla2+'" class="form-control input-sm" value="boton"></td>\n' +
                '<td><input type="text" id="txt_estiloppm_'+flag_tabla2+'" name="txt_estiloppm_'+flag_tabla2+'" class="form-control input-sm" value="'+o[73]+'"></td>\n' +
                '<td><input type="text" id="txt_estadomatch_'+flag_tabla2+'" name="txt_estadomatch_'+flag_tabla2+'" class="form-control input-sm" value="'+o[74]+'"></td>\n' +
                '<td><input type="text" id="txt_noc_'+flag_tabla2+'" name="txt_noc_'+flag_tabla2+'" class="form-control input-sm" value="'+o[75]+'"></td>\n' +
                '<td><input type="text" id="txt_estadooc_'+flag_tabla2+'" name="txt_estadooc_'+flag_tabla2+'" class="form-control input-sm" value="'+o[76]+'"></td>\n' +
                '<td><input type="text" id="txt_fechaembarque_'+flag_tabla2+'" name="txt_fechaembarque_'+flag_tabla2+'" class="form-control input-sm" value="'+o[77]+'"></td>\n' +
                '<td><input type="text" id="txt_fechaeta_'+flag_tabla2+'" name="txt_fechaeta_'+flag_tabla2+'" class="form-control input-sm" value="'+o[78]+'"></td>\n' +
                '<td><input type="text" id="txt_fecharecepcioncd_'+flag_tabla2+'" name="txt_fecharecepcioncd_'+flag_tabla2+'" class="form-control input-sm" value="'+o[79]+'"></td>\n' +
                '<td><input type="text" id="txt_diasatrasocd_'+flag_tabla2+'" name="txt_diasatrasocd_'+flag_tabla2+'" class="form-control input-sm" value="'+o[80]+'"></td>\n' +
                '<td><select id="cbx_estadoopcion_'+flag_tabla2+'" name="cbx_estadoopcion_'+flag_tabla2+'" class="input-sm cbx_estadoopcion_"></select></td>\n' +
                '</tr>');


            flag_tabla2++;

        // Fin foreach que llena tabla
        });

// Fin de carga datos grilñla 2
    });



// ############################################## CARGAR CBX Y ASIGNACION DE SELECTED ##################################################################

    // Carga CBX de Línea
    var url_cbx_linea = 'ajax_simulador_cbx/listar_optionsLinea';
    var adjunt_cbx_opcion = "";
    $.getJSON(url_cbx_linea, function (data) {
        $.each(data, function (i,o) {
            adjunt_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });

        $('.cbx_linea_').append(adjunt_cbx_opcion);

        // Verificar si tiene cargado datos, si no los tiene los vuelvo a cargar por si algo sucede con la carga...
        /*if ($('.cbx_linea_ option').length < 0){
            $('.cbx_linea_').append(adjunt_cbx_opcion);
        }*/

    });

    // Carga CBX de SubLinea -> Se realiza en el siguiente paso ya que primero debe estar seleccionada la línea

   /* // Carga Marca
    var url_cbx_marca = 'ajax_simulador_cbx/listar_optionsMarca';
    var marca_cbx_opcion = "";
    $.getJSON(url_cbx_marca, function (data) {
        $.each(data, function (i,o) {
            marca_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_marca_').append(marca_cbx_opcion);
    });


    // Carga Estilo Vida
    var url_cbx_evida = 'ajax_simulador_cbx/listar_optionsEVida';
    var evida_cbx_opcion = "";
    $.getJSON(url_cbx_evida, function (data) {
        $.each(data, function (i,o) {
            evida_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_estilovida_').append(evida_cbx_opcion);
    });


    // Carga Ocacion Uso
    var url_cbx_OcacionUso = 'ajax_simulador_cbx/listar_optionsOcacionUso';
    var OcacionUso_cbx_opcion = "";
    $.getJSON(url_cbx_OcacionUso, function (data) {
        $.each(data, function (i,o) {
            OcacionUso_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_ocacionuso_').append(OcacionUso_cbx_opcion);
    });


    // Carga Piramide Mix
    var url_cbx_PiramideMix = 'ajax_simulador_cbx/listar_optionsPiramideMix';
    var PiramideMix_cbx_opcion = "";
    $.getJSON(url_cbx_PiramideMix, function (data) {
        $.each(data, function (i,o) {
            PiramideMix_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_piramidemix_').append(PiramideMix_cbx_opcion);
    });


    // Carga Ventana
    var url_cbx_VentanaLlegada = 'ajax_simulador_cbx/listar_optionsVentanaLlegada';
    var VentanaLlegada_cbx_opcion = "";
    $.getJSON(url_cbx_VentanaLlegada, function (data) {
        $.each(data, function (i,o) {
            VentanaLlegada_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_ventana_').append(VentanaLlegada_cbx_opcion);
    });


    // Carga RankVenta
    var url_cbx_RankVenta = 'ajax_simulador_cbx/listar_optionsRankVenta';
    var RankVenta_cbx_opcion = "";
    $.getJSON(url_cbx_RankVenta, function (data) {
        $.each(data, function (i,o) {
            RankVenta_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_rankvta_').append(RankVenta_cbx_opcion);
    });


    // Carga LifeCicle
    var url_cbx_LifeCicle = 'ajax_simulador_cbx/listar_optionsLifeCicle';
    var LifeCicle_cbx_opcion = "";
    $.getJSON(url_cbx_LifeCicle, function (data) {
        $.each(data, function (i,o) {
            LifeCicle_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_ciclovida_').append(LifeCicle_cbx_opcion);
    });


    // Carga Color
    var url_cbx_Color = 'ajax_simulador_cbx/listar_optionsColor';
    var Color_cbx_opcion = "";
    $.getJSON(url_cbx_Color, function (data) {
        $.each(data, function (i,o) {
            Color_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_color_').append(Color_cbx_opcion);
    });


    // Carga TipoProducto
    var url_cbx_TipoProducto = 'ajax_simulador_cbx/listar_optionsTipoProducto';
    var TipoProducto_cbx_opcion = "";
    $.getJSON(url_cbx_TipoProducto, function (data) {
        $.each(data, function (i,o) {
            TipoProducto_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_tipoproducto_').append(TipoProducto_cbx_opcion);
    });


    // Carga TipoExhibicion
    var url_cbx_TipoExhibicion = 'ajax_simulador_cbx/listar_optionsTipoExhibicion';
    var TipoExhibicion_cbx_opcion = "";
    $.getJSON(url_cbx_TipoExhibicion, function (data) {
        $.each(data, function (i,o) {
            TipoExhibicion_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_tipoexhibicion_').append(TipoExhibicion_cbx_opcion);
    });


    // Carga Cluster
    var url_cbx_Cluster = 'ajax_simulador_cbx/listar_optionsCluster';
    var Cluster_cbx_opcion = "";
    $.getJSON(url_cbx_Cluster, function (data) {
        $.each(data, function (i,o) {
            Cluster_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_cluster_').append(Cluster_cbx_opcion);
    });


    // Carga Formato
    var url_cbx_Formato = 'ajax_simulador_cbx/listar_optionsFormato';
    var Formato_cbx_opcion = "";
    $.getJSON(url_cbx_Formato, function (data) {
        $.each(data, function (i,o) {
            Formato_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_formato_').append(Formato_cbx_opcion);
    });


    // Carga Via
    var url_cbx_Via = 'ajax_simulador_cbx/listar_optionsVia';
    var Via_cbx_opcion = "";
    $.getJSON(url_cbx_Via, function (data) {
        $.each(data, function (i,o) {
            Via_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_via_').append(Via_cbx_opcion);
    });


    // Carga Pais
    var url_cbx_Pais = 'ajax_simulador_cbx/listar_optionsPais';
    var Pais_cbx_opcion = "";
    $.getJSON(url_cbx_Pais, function (data) {
        $.each(data, function (i,o) {
            Pais_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_pais_').append(Pais_cbx_opcion);
    });


    // Carga Moneda
    var url_cbx_Moneda = 'ajax_simulador_cbx/listar_optionsMoneda';
    var Moneda_cbx_opcion = "";
    $.getJSON(url_cbx_Moneda, function (data) {
        $.each(data, function (i,o) {
            Moneda_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_moneda_').append(Moneda_cbx_opcion);
    });


    // Carga RazonSocial
    var url_cbx_RazonSocial = 'ajax_simulador_cbx/listar_optionsProveedor';
    var RazonSocial_cbx_opcion = "";
    $.getJSON(url_cbx_RazonSocial, function (data) {
        $.each(data, function (i,o) {
            RazonSocial_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });
        $('.cbx_razonsocial_').append(RazonSocial_cbx_opcion);
        $('.cbx_trader_').append(RazonSocial_cbx_opcion);
    });
*/

// fin de onload
});




$( document ).ready(function() {

// ############################################## ASIGNAR OPCION SELECCIONADA A LOS SELECT  ##################################################################

    // Se llama nuevamente al JSON de carga para realizar las asignaciones
    /*var url_carga_tabla2_asignacion = 'ajax_simulador_cbx/llenar_tabla2';
    var flag_tabla2_asignacion = 0 ;
    $.getJSON(url_carga_tabla2_asignacion, function (data) {
        $.each(data, function (i,o) {
            // Asigno los valores a los select, cualquiér cambio en el orden de despliegue en la tabla del còdigo de arriba se debe reflejar aquí
            $(".cbx_linea_"+flag_tabla2_asignacion).val(o[3]);
            $(".cbx_marca_"+flag_tabla2_asignacion).val(o[5]);
            $(".cbx_estilovida_"+flag_tabla2_asignacion).val(o[13]);
            $(".cbx_ocacionuso_"+flag_tabla2_asignacion).val(o[15]);
            $(".cbx_piramidemix_"+flag_tabla2_asignacion).val(o[16]);
            $(".cbx_ventana_"+flag_tabla2_asignacion).val(o[17]);
            $(".cbx_rankvta_"+flag_tabla2_asignacion).val(o[18]);
            $(".cbx_ciclovida_"+flag_tabla2_asignacion).val(o[19]);
            $(".cbx_color_"+flag_tabla2_asignacion).val(o[20]);
            $(".cbx_tipoproducto_"+flag_tabla2_asignacion).val(o[21]);
            $(".cbx_tipoexhibicion_"+flag_tabla2_asignacion).val(o[22]);
            $(".cbx_cluster_"+flag_tabla2_asignacion).val(o[33]);
            $(".cbx_formato_"+flag_tabla2_asignacion).val(o[34]);
            $(".cbx_proced_ "+flag_tabla2_asignacion).val(o[42]);
            $(".cbx_via_"+flag_tabla2_asignacion).val(o[43]);
            $(".cbx_pais_"+flag_tabla2_asignacion).val(o[44]);
            $(".cbx_moneda_"+flag_tabla2_asignacion).val(o[48]);
            $(".cbx_razonsocial_"+flag_tabla2_asignacion).val(o[67]);
            $(".cbx_trader_"+flag_tabla2_asignacion).val(o[68]);
            $(".cbx_estadoopcion_"+flag_tabla2_asignacion).val(o[81]);
            flag_tabla2_asignacion++;
        // Fin foreach que llena tabla
        });
    // Fin de asignacion de datos grilñla 2
    });*/




});




//$('#my_select option:selected').attr('id');

/*$(".cbx_linea_").change(function() {
    var id = $(this).children(":selected").attr("id");
    alert(id);
});*/



function buscarSubLinea(id,value) {

    // alert(id);
    //alert(value);
    var id_select_linea = id.toString();
    var imprime = $( "#"+id_select_linea).val();
    var obtener_numero_id = id_select_linea.split('_');
    var nunero_id_del_campo = obtener_numero_id[2];

    // Carga SubLínea
    var url_cbx_sublinea = 'ajax_simulador_cbx/listar_optionsSubLinea';
    var sublinea_cbx_opcion = "";
    $.getJSON(url_cbx_sublinea,{ID_LINEA: value}, function (data) {
        $.each(data, function (i,o) {
            sublinea_cbx_opcion += '<option value=' + o[0] + '>' + o[1]  + '</option>';
        });

        $("#cbx_sublinea_"+nunero_id_del_campo).empty();
        $("#cbx_sublinea_"+nunero_id_del_campo).append(sublinea_cbx_opcion);
    });


}



