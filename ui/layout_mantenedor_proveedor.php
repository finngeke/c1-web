<!DOCTYPE html>
<html>
<head>
    <title>[{{ @BD_CONEXION }}] - {{@TITLE}}</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="utf-8">
    <link href="{{@TELERIK}}web/telerik/content/shared/styles/plan_compra.css" rel="stylesheet">
    <!--<link href="{{@TELERIK}}web/telerik/styles/PlanCompraRipley/all.css" rel="stylesheet">-->
    <link href="{{@TELERIK}}web/telerik/styles/kendo.common.min.css" rel="stylesheet">
    <link href="{{@TELERIK}}web/telerik/styles/kendo.rtl.min.css" rel="stylesheet">
    <link href="{{@TELERIK}}web/telerik/styles/kendo.default.min.css" rel="stylesheet">
    <link href="{{@TELERIK}}web/telerik/styles/kendo.default.mobile.min.css" rel="stylesheet">
    <link href="{{@BOOTSTRAP}}web/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{@TELERIK}}web/telerik/js/jquery.min.js"></script>
    <script src="{{@TELERIK}}web/telerik/js/jszip.min.js"></script>
    <script src="{{@TELERIK}}web/telerik/js/kendo.all.min.js"></script>
    <script src="{{@TELERIK}}web/telerik/content/shared/js/console.js"></script>
    <script src="{{@TELERIK}}web/telerik/js/cultures/kendo.culture.es-CL.min.js"></script>
</head>
<body>

<!-- Llamada a mantenedor_proveedor.html -->
<include href="{{ @contenido }}"/>

<!-- 0 En Cargar (Orden Obligatorio) -->
<script src="{{@TELERIK}}ui/formulario/main/js/mantenedor_proveedor.js?v={{rand(0,99999)}}"></script>

</body>
</html>