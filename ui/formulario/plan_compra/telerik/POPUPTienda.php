<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<?php require_once '../../../../web/telerik/php/wrappers/php/lib/Kendo/Autoload.php'; ?>

<div role="application">
    <div class="caja-despliegue k-content wide">

        <label for="Marcas">Marcas</label>
        <?php
        $marcas = new \Kendo\Data\DataSource();
        $marcas->data(array(
            array('text' => 'Cotton', 'value'=> 1),
            array('text' => 'Polyester', 'value'=> 2),
            array('text' => 'Cotton/Polyester', 'value'=> 3),
            array('text' => 'Rib Knit', 'value'=> 4)
        ));

        $inputMarcas = new \Kendo\UI\ComboBox('Marcas');
        $inputMarcas->dataSource($marcas)
            ->dataTextField('text')
            ->dataValueField('value')
            //->filter('contains')
            ->placeholder('Seleccione Marca')
            //->suggest(true)
            ->index(3)
            ->attr('style', 'width: 100%;');

        echo $inputMarcas->render();

        echo "";
        ?>

        <br /><br />
        <label for="TipoTienda">Tipo Tienda</label>
        <?php
        $TipoTienda = new \Kendo\Data\DataSource();
        $TipoTienda->data(array(
            array('text' => 'Cotton', 'value'=> 1),
            array('text' => 'Polyester', 'value'=> 2),
            array('text' => 'Cotton/Polyester', 'value'=> 3),
            array('text' => 'Rib Knit', 'value'=> 4)
        ));

        $inputTipoTienda = new \Kendo\UI\ComboBox('TipoTienda');
        $inputTipoTienda->dataSource($TipoTienda)
            ->dataTextField('text')
            ->dataValueField('value')
            //->filter('contains')
            ->placeholder('Seleccione Tipo Tienda')
            //->suggest(true)
            ->index(3)
            ->attr('style', 'width: 100%;');

        echo $inputTipoTienda->render();
        echo "";
        ?>


        <!--<label for="optional" id="disponible">Disponible</label>
        <label for="seleccionado">Asignado</label>-->
        <br /><br />
        <?php
        $attendees = array(
            "Steven White",
            "Nancy King",
            "Nancy Davolio",
            "Robert Davolio",
            "Michael Leverling",
            "Andrew Callahan",
            "Michael Suyama"
        );


        // Caracteristicas de la Barra del Medio
        $listBoxToolbar = new \Kendo\UI\ListBoxToolbar();
        $listBoxToolbar->position("right");
        $listBoxToolbar->tools(array("transferTo", "transferFrom", "transferAllTo", "transferAllFrom"));

        // Cargo Disponible
        $listBoxOptional = new \Kendo\UI\ListBox('disponible');
        $listBoxOptional->toolbar($listBoxToolbar)
            ->dataSource($attendees)
            ->selectable("multiple")
            ->connectWith("seleccionado");
        echo $listBoxOptional->render();

        // Imprime Espacio por design improvements
        echo " ";

        // Cargo Seleccionadas
        $listBoxSelected = new \Kendo\UI\ListBox('seleccionado');
        $listBoxSelected->dataSource(array())
            ->selectable("multiple");
        echo $listBoxSelected->render();


        ?>
    </div>
</div>

<style>
    .caja-despliegue label {
        margin-bottom: 5px;
        font-weight: bold;
        display: inline-block;
    }

    #disponible {
        width: 250px;
    }

    .caja-despliegue label {
        padding-left: 8px;
        margin-bottom: 8px;
        font-weight: bold;
        display: inline-block;
    }
</style>


<!--<script src="../../../../ui/formulario/plan_compra/js/simulador_compra_popuptienda.js?v=A29"></script>-->
</body>
</html>