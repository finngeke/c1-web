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
    <script src="{{@TELERIK}}web/telerik/js/cultures/kendo.culture.es-CL.min.js"></script>
</head>
<body>

<!-- Llamada al plan de compra -->
<include href="{{ @contenido }}"/>


<!-- 1 En Cargar (Orden Obligatorio) -->
<script src="{{@TELERIK}}ui/formulario/plan_compra/js/simulador_compra_lectura.js?v=A29"></script>
<!-- 2 En Cargar (Orden Obligatorio) -->
<script src="{{@TELERIK}}ui/formulario/plan_compra/js/simulador_compra.js?v=A29"></script>
<!-- 3 En Cargar (Orden Obligatorio) -->
<script src="{{@TELERIK}}ui/formulario/plan_compra/js/simulador_compra_menutop.js?v=A29"></script>
<!-- 4 En Cargar (Orden Obligatorio) -->
<script src="{{@TELERIK}}ui/formulario/plan_compra/js/simulador_compra_celdabtn.js?v=A29"></script>
<!-- 5 En Cargar (Orden Obligatorio) -->
<script src="{{@TELERIK}}ui/formulario/plan_compra/js/simulador_compra_funciones.js?v=A29"></script>

</body>
</html>