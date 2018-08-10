<html>
    <head>
        <title>{{@TITLE}}</title>
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="stylesheet" href="{{@BASE}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{@BASE}}/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{@BASE}}/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{@BASE}}/dist/css/AdminLTE.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{@BASE}}/plugins/iCheck/square/blue.css">
        <!-- Animation -->
        <link rel="stylesheet" href="{{@BASE}}/bower_components/animation/animate.min.css">
    </head>
    <body class="hold-transition login-page" style="height: 0%">
        <div class="login-box" >

            <!-- /.login-logo -->
            <div class="login-box-body animated fadeInDown" style="
                 -webkit-box-shadow: 0 0 5px 2px rgba(0, 0, 0, .5);
                 box-shadow: 0 8px 12px 2px rgba(0, 0, 0, .5);
                 border-radius:5px;">
                <include href="{{ @contenido }}" />
                <div class="callout callout-{{@mensaje.color}}" style="filter:alpha(opacity=80); opacity:0.80;">                
                    <h4>	<i class="fa {{@mensaje.icon}}"></i> {{@mensaje.header}}</h4>
                    {{@mensaje.message}}
                </div> 
                <hr>
                <!--¿No puedes acceder a tu cuenta? <a href="mailto:epacheco@ripley.cl&amp;subject=Problemas con el ingreso C1 Web" >Haz clic aquí </a> -->
            </div>

        </div>
        <!-- jQuery 3 -->
        <script src="{{@BASE}}/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{@BASE}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="{{@BASE}}/plugins/iCheck/icheck.min.js"></script>
        <script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
    });
});
        </script>

    </body>
</html>