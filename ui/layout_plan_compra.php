<!DOCTYPE html>
<html>
<head>
    <title>[{{ @BD_CONEXION }}] - {{@TITLE}}</title>
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

</head>
<body>

<!-- Llamada al plan de compra -->
<include href="{{ @contenido }}"/>


<!-- Llamada al JS que trabaja con la Grilla -->
<script src="{{@JQUERY}}ui/formulario/plan_compra/js/simulador_compra.js?v=A20"></script>
<script src="{{@JQUERY}}ui/formulario/plan_compra/js/simulador_compra_menu_top.js?v=A20"></script>
<script src="{{@JQUERY}}ui/formulario/plan_compra/js/simulador_compra_popup_celda.js?v=A20"></script>

</body>
</html>