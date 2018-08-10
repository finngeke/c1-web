
<html>
<link rel="stylesheet" href="{{@BASE}}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<head>
	
	<title>carga</title>
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

</head>
<body class="skin-blue sidebar-mini sidebar-collapse">
<div class="modal-dialog">
    <div class="modal-content borde_especial">
        <div class="modal-header">
            <h4 class="modal-title">Carga Archivos </h4>
        </div>
        <div class="modal-body">

            <div>
                <td colspan="2"><label class="titulo" id="titulo" for="tipos">Temporada:</label><input type="text" id="tempo"></td>
            </div>
            <div>
                <td colspan="2"><label class="titulo" id="titulo" for="tipos">Depto:</label><input type="text" id="dep_depto"></td>
            </div>
            <div>
                <td colspan="2"><label class="titulo" id="titulo" for="tipos">Grupo Compra:</label><input type="text" id="grupo"></td>
            </div>


        </div>
        <div class="modal-footer">
            <!--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>-->
            <div class="loading" style="display: none"><i class='fa fa-spinner fa-2x fa-spin '></i> Buscando</div>
            <input type="submit" class="btn btn-primary carga_bmt"  id = "btn_import" value="Carga">

        </div>
    </div>
</div>
</body>
</html>
<!-- Llamados a los JS -->
<script src="{{@JQUERY}}ui/formulario/plan_compra/js/CargaAssormentLayout.js"></script>