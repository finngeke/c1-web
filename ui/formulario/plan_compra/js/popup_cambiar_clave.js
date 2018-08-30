$(window).on('load', function () {

    //traer datos para mostrar

    var url_carga_datos_usuario_cambiar_clave   = 'cambiar_clave/trae_datos_cambio';

    $.getJSON(url_carga_datos_usuario_cambiar_clave,function( data ) {

        $('#input_clave_desde_bd').val(data[0]['CONTRASENIA']);
        $('#tabla_cambiar_clave').append(
            '<td align="center" id="td_id_cod_usuario_cambiar_clave">'+data[0]['COD_USR']+'</td>'
        );

    });

});


$('#input_clave_nueva').on('mouseenter',function(){
    input_clave_nueva.type = "text";
});

$('#input_clave_nueva').on('mouseleave',function () {
    input_clave_nueva.type ="password";
});

$('#btn_actualizar_clave').on('click',function () {

    var clave_desde_bd = $('#input_clave_anterior').val();
    var antigua_clave_tipeada = $('#input_clave_desde_bd').val();

    if (clave_desde_bd == antigua_clave_tipeada){

        var nueva_clave_tipeada = $('#input_clave_nueva').val();

        if (nueva_clave_tipeada != antigua_clave_tipeada){

            var url_actualizar_clave   = 'cambiar_clave/actualizar_clave';

            $.getJSON(url_actualizar_clave,{CLAVE:nueva_clave_tipeada}).done(function () {
                alert ("Clave actualizada");
                $('#popup_cambiar_clave').modal('hide');
                window.location.reload();
            });

        }else{
            alert("La nueva clave no debe ser igual a la anterior");
        }


    }else{
        alert ("La contraseña anterior no es correcta");
    }


});