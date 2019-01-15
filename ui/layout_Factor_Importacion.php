<!DOCTYPE html>
<html>
<head>
    <title>[{{ @BD_CONEXION }}] - {{@TITLE}}</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="utf-8">

    <link href="{{@TELERIK}}web/telerik/content/shared/styles/plan_compra.css" rel="stylesheet">
    <link href="{{@TELERIK}}web/telerik/styles/kendo.common.min.css" rel="stylesheet">
    <link href="{{@TELERIK}}web/telerik/styles/kendo.rtl.min.css" rel="stylesheet">
    <link href="{{@TELERIK}}web/telerik/styles/kendo.default.min.css" rel="stylesheet">
    <link href="{{@TELERIK}}web/telerik/styles/kendo.default.mobile.min.css" rel="stylesheet">
    <script src="{{@TELERIK}}web/telerik/js/jquery.min.js"></script>
    <script src="{{@TELERIK}}web/telerik/js/jszip.min.js"></script>
    <script src="{{@TELERIK}}web/telerik/js/kendo.all.min.js"></script>
    <script src="{{@TELERIK}}web/telerik/content/shared/js/console.js"></script>
    <script src="{{@TELERIK}}web/telerik/js/cultures/kendo.culture.es-CL.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<!-- Llamada al plan de compra -->
<include href="{{ @contenido }}"/>
<script src="{{@TELERIK}}ui/formulario/main/js/Factor_Importacion.js?v={{rand(0,999)}}"></script>
</body>
</html>