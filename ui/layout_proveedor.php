<html>
<head>
	
	<title>{{@TITLE}}</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="{{@BASE}}/bower_components/bootstrap/dist/css/bootstrap.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{@BASE}}/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{@BASE}}/bower_components/Ionicons/css/ionicons.min.css">
	<!-- jvectormap -->
	<!--<link rel="stylesheet" href="{{@BASE}}/bower_components/jvectormap/jquery-jvectormap.css">-->
	
	<!-- Theme style -->
	<link rel="stylesheet" href="{{@BASE}}/dist/css/AdminLTE.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		 folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{@BASE}}/dist/css/skins/_all-skins.min.css">
	<!-- Animation -->
	<link rel="stylesheet" href="{{@BASE}}/bower_components/animation/animate.min.css">
	
	<!-- jQuery 3 -->
	<script src="{{@BASE}}/bower_components/jquery/dist/jquery.min.js"></script>
</head>
<body class="skin-blue sidebar-mini sidebar-collapse">
	<div class="content">
		<check if="{{ isset(@mensaje) }}">
			<div class="alert alert-{{@mensaje.icon}}" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<strong>{{@mensaje.header}}:</strong> {{@mensaje.message|raw}}
			</div>
		</check>
		<include href="{{ @contenido }}" />
	</div>
	<!-- ./content -->

    <!-- TRAE LOS PERMISOS DE USUARIOS -->
    <script src="{{@TELERIK}}ui/formulario/plan_compra/js/simulador_compra_permisos.js?v=A25"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{@BASE}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="{{@BASE}}/bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="{{@BASE}}/dist/js/adminlte.js"></script>
	<!-- Sparkline -->
	<!--<script src="{{@BASE}}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>-->
	<!-- jvectormap  -->
	<!--<script src="{{@BASE}}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="{{@BASE}}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>-->
	<!-- SlimScroll -->
	<script src="{{@BASE}}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- ChartJS -->
	<!--<script src="{{@BASE}}/bower_components/chart.js/Chart.js"></script>-->
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!--<<script src="{{@BASE}}/dist/js/pages/dashboard2.js"></script>-->
	<!-- AdminLTE for demo purposes -->
	<script src="{{@BASE}}/dist/js/demo.js"></script>
	<script src="{{@BASE}}/dist/js/notificaciones.js"></script>
	
	<!-- JQuery Validation -->

</body>
</html>
