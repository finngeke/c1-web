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
	<div class="wrapper" style="overflow: hidden;">
		
		<header class="main-header">
			
			<!-- Logo -->
			<a href="{{@BASE}}/inicio" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>C</b>1</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>C1</b> Plan de Compra</span>
			</a>
			
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- Tasks: style can be found in dropdown.less -->
						<li class="dropdown tasks-menu">
							<!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<span class="label bg-green">2</span>
							</a>-->
							<ul class="dropdown-menu">
								<li class="header"># OC Sin Gestión C1</li>
								<li>
									<!-- inner menu: contains the actual data -->
									<ul class="menu">
										<li><!-- Task item -->
											<a href="#">
												<h3>
													PI Pendientes
													<small class="pull-right">20%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
														 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">20% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<!-- end task item -->
										<li><!-- Task item -->
											<a href="#">
												<h3>
													PI Ingresadas
													<small class="pull-right">40%</small>
												</h3>
												<div class="progress xs">
													<div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
														 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">40% Complete</span>
													</div>
												</div>
											</a>
										</li>
										<!-- end task item -->
									
									</ul>
								</li>
								<li class="footer">
									<a href="#">Ver más detalle</a>
								</li>
							</ul>
						</li>
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<!--<img src="dist/img/avatar_generica.png" class="user-image" alt="{{ @nombre }}">-->
								<span class="hidden-xs">{{ @nombre }}</span>
								&nbsp;<span id="control_conexion" style="color: red"><b>[{{ @BD_CONEXION }}]</b></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="dist/img/avatar_generica.png" class="img-circle" alt="{{ @nombre }}">
									<p>
										{{ @nombre }} <br> <b>{{ @perfil }}</b>
										<small>{{ @dia }}</small>
										<span id="flag_top_menu_tipo_usuario" style="display: none"></span>
										<span id="flag_top_menu_tipo_usuario_num" style="display: none"></span>
									</p>
								</li>
								
								<li class="user-footer">
									<div class="pull-right">
										<a href="{{@BASE}}/salir" class="btn btn-default btn-flat">Salir del Sistema</a>
									</div>
								</li>
							</ul>
						</li>
						<!-- Control Sidebar Toggle Button -->
						<!--<li>
							<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
						</li>-->
					</ul>
				</div>
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
						<img src="dist/img/avatar_generica.png" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
						<p>{{ @login }}</p>
						<!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
					</div>
				</div>
				
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu tree" data-widget="tree">
					
					
					<li class="header">MANTENEDORES</li>
					<li id="modulo_master_pack">
						<a href="master_pack">
							<i class="fa fa-archive"></i>
							<span> Master Pack</span>
						</a>
					</li>
					<li id="modulo_depto_marca">
						<!--depto_marca-->
						<a href="#" class="tipo_deptomarca">
							<i class="fa fa-edit"></i>
							<span> Mantenedor Depto/Marca</span>
						</a>
					</li>
					<!--<li id="modulo_prioridades_tienda">
						<a href="prioridades_tienda" class="prioridad_tienda">
							<i class="fa fa-sort-numeric-asc"></i>
							<span>Prioridades Tienda</span>
						</a>
					</li>-->
					
					<li id="modulo_actualizar_calculos">
						<!-- Modulo actualizar Datos -->
						<a href="actualizar_calculos">
							<i class="fa fa-calculator"></i>
							<span>Actualizar Calculos</span>
						</a>
					</li>
				
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>
		<!-- Right side column. Contains the navbar and content of the page -->
		<div class="content-wrapper">
			<include href="{{ @contenido }}" />
		</div>
		
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> {{ @VERSION }}
			</div>
			<strong>Copyright &copy; 2018 RIPLEY Sistemas GESTION + BI BIGDATA.</strong>
		</footer>
		
		<!-- Control Sidebar -->
		<!--<aside class="control-sidebar control-sidebar-dark">
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
				<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
				<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane" id="control-sidebar-home-tab">
					<h3 class="control-sidebar-heading">Log de Usuario</h3>
					<ul class="control-sidebar-menu">
						<li>
							<a href="javascript:void(0)">
								<i class="menu-icon fa fa-user bg-blue"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">{{ @login}}</h4>

									<p>{{@dia}}</p>
									<p>Módulo :</p>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</aside>

		<div class="control-sidebar-bg"></div>-->
	
	
	</div>
	<!-- ./wrapper -->
	
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
	<script src="{{@JQUERY}}/ui/formulario/main/js/inicio_validar_tipo_modulo_simulador.js"></script>


</body>
</html>