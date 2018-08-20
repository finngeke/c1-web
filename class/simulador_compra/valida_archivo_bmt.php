<?php

/**
 * CLASS Temporada
 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
 * Fecha: 2018-02-07
 * @author RODRIGO RIOSECO
 */

namespace simulador_compra;

class valida_archivo_bmt extends \parametros {

#region {*************Metodos Importar Assortment*************}


    public static function Val_depto($rows,$limite,$nom_columnas,$depto){
        $filarow = "";
        $val = TRUE;

        for($i = 3;$i <= $limite; $i++){
            if ($rows[$i][$nom_columnas['Cod Dpto']] != null ) {
                if ($rows[$i][$nom_columnas['Cod Dpto']] != $depto) {

                    $val = false;
                    $filarow = $filarow . strval($i+1) . ",";
                }
            }
        }

        if ($val == false ) {
            $array = array('Tipo' => $val,
                           'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                           'Error'=> $filarow);
        }
        return  $array;
    }
    public static function Val_marca($rows,$limite,$nom_columnas,$depto){
        $filarow = "";
        $val = TRUE;
        $marcas = plan_compra::list_codMarca($depto);


        for($i = 3;$i <= $limite; $i++){
            if ($rows[$i][$nom_columnas['Codigo Marca']] != null ) {
                $_exist = false;
                foreach ($marcas as $valor){
                    if ($rows[$i][$nom_columnas['Codigo Marca']] == $valor) {
                        $_exist = true;
                        break;
                    }
                }
                if ($_exist == false) {
                    $val = FALSE;
                    $filarow = $filarow . strval($i+1) . ",";
                }
            }
        }

        if ($val == FALSE ) {
            $array = array('Tipo' => $val,
                'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;
    }

    public static function Val_soloUnaMarca($rows,$limite,$nom_columnas,$depto){
        $array1 = [];$_Mensaje= "";
        for($i = 3;$i <= $limite; $i++){
           $key = false;
            foreach ($array1 as $val){
                if($rows[$i][$nom_columnas['Codigo Marca']] == $val){
                    $key = true ; break;
                }
            }
            if ($key == false){
                $_Mensaje = $_Mensaje. $rows[$i][$nom_columnas['Marca']]." ," ;
                array_push($array1,$rows[$i][$nom_columnas['Codigo Marca']]);
            }
        }

        if (count($array1) > 1){
            $_Mensaje =substr($_Mensaje, 0, -1);
        }else{
            $_Mensaje = "";
        }

        return  $_Mensaje;
    }

    public static function Val_Season($rows,$limite,$nom_columnas,$temporada){
        $filarow = "";
        $val = TRUE;
        for($i = 3;$i <= $limite; $i++){
            if ($rows[$i][$nom_columnas['Season']] != null ) {
                 if ($rows[$i][$nom_columnas['Season']] != $temporada) {
                     $val = FALSE;
                     $filarow = $filarow . strval($i + 1) . ",";
                 }
            }
        }

        if ($val == FALSE ) {
            $array = array('Tipo' => $val,
                'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;
    }
    public static Function Val_jerarquia($rows,$limite,$nom_columnas,$dtjerarquia){
        $filarow = "";
        $val = TRUE;

        for($i = 3;$i <= $limite; $i++){
            $val2 = false;
                $key3 = 0;
                foreach ($dtjerarquia as $var  )  {//TABLA TIPO DE CAMBIO
                    if (strval($dtjerarquia[$key3]['LIN_LINEA']) === strval($rows[$i][$nom_columnas['Cod Linea']]) and
                        $dtjerarquia[$key3]['SLI_SUBLINEA'] === $rows[$i][$nom_columnas['Cod Sublinea']]) {
                        $val2 = true;
                        break;
                    }
                    $key3++;
                }
                if ($val2 == false ){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                 }
        }
        if ($val == FALSE ) {
            $array = array('Tipo' => $val,
                'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;
    }
    public static function Val_Colores($rows,$limite,$nom_columnas){
        $filarow = "";
        $val = TRUE;

        $dtcolores = plan_compra::list_colores();
        for($i = 3;$i <= $limite; $i++){
            $val2 = false;
                $key3 = 0;
                foreach ($dtcolores as $var  )  {//TABLA TIPO DE CAMBIO
                    if ($dtcolores[$key3]['COD_COLOR'] == $rows[$i][$nom_columnas['Cod Color']]) {
                        $val2 = true;
                        break;
                    }
                    $key3++;
                }
                if ($val2 == false ){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
        }

        if ($val == FALSE ) {
            $array = array('Tipo' => $val,
                'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;

    }
    public static function Val_Tipo_Produc_Exhibicion($rows,$limite,$nom_columnas){
        $filarow = "";
        $val = TRUE;


        $dttipo_producto = plan_compra::list_tipoProducto();
        $dttipo_exhibicion= plan_compra::list_tipoexhibicion();

        /*validacion de tipo de productos.*/
        $tipoVal = 1;
        for($i = 3;$i <= $limite; $i++){
            $val2 = false;
            if ($rows[$i][$nom_columnas['Tipo Producto']] != null ) {
                $key3 = 0;
                foreach ($dttipo_producto as $var)  {
                    if ($dttipo_producto[$key3]['NOM_TIPOPRODUC'] == $rows[$i][$nom_columnas['Tipo Producto']]) {
                        $val2 = true;
                        break;
                    }
                    $key3++;
                }
                if ($val2 == false ){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }
        }


        if ($val == TRUE ) {
            $tipoVal = 2;
            /*validacion de tipo exhibicion.*/
            for ($i = 3; $i <= $limite; $i++) {
                $val2 = false;
                if ($rows[$i][$nom_columnas['Tipo exhibicion']] != null) {
                    $key3 = 0;
                    foreach ($dttipo_exhibicion as $var) {
                        if ($dttipo_exhibicion[$key3]['NOM_EXHIBICION'] == $rows[$i][$nom_columnas['Tipo exhibicion']]) {
                            $val2 = true;
                            break;
                        }
                        $key3++;
                    }
                    if ($val2 == false) {
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }
        }

        if ($val == TRUE ) {
            $tipoVal = 3;
            for ($i = 3; $i <= $limite; $i++) {
                $val2 = false;
                if (strtoupper($rows[$i][$nom_columnas['Tipo Producto']])== "REGULAR" ) {
                    if (strtoupper($rows[$i][$nom_columnas['Tipo exhibicion']])== "" ){
                        $val2 = true;
                    }
                    if ($val2 == false) {
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }
        }

        if ($val == FALSE ) {
            if ($tipoVal == 1){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Tipo de Producto no se encuentra en BD C1.");
            }elseif ($tipoVal == 2){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Tipo de exhibición no se encuentra en BD C1.");
            }else{
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Los Tipos de Productos 'REGULARES' no deben tener Tipo Exhibición.");
            }
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;
    }
    public static function Val_Campos($rows,$limite,$nom_columnas,$cod_tempo,$depto){
        $filarow = "";
        $val = TRUE;

        /*Validacion temporda del season 1*/ $tipoVal = 1;
        $dttipoTemporda = array("CL - INVIERNO","CL - OTOÑO","CL - PRIMAVERA","CL - VERANO","CL - TODA TEMPORADA");
        for($i = 3;$i <= $limite; $i++){
            $val2 = false;
                foreach ($dttipoTemporda as $var)  {
                    if ($var == strtoupper($rows[$i][$nom_columnas['Temporada']])) {
                        $val2 = true; break;
                    }
                }
                if ($val2 == false){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
            }
        }

        if ($val == TRUE) {
        /*Validacion ciclo de vida */ $tipoVal = 2; $dtciclo_vida = plan_compra::list_ciclo_vida();
            for($i = 3;$i <= $limite; $i++){
            $val2 = false;
            if ($rows[$i][$nom_columnas['Ciclo de Vida']] != null ) {
                $key3 = 0;
                foreach ($dtciclo_vida as $var)  {
                    if ($dtciclo_vida[$key3]['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Ciclo de Vida']])) {
                        $val2 = true; break;
                    }$key3++;
                }
                if ($val2 == false){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }
        }}

        if ($val == TRUE) {
            /*Validacion RNK VTA */ $tipoVal = 3; $dtrnkventa = plan_compra::list_rnk();
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                if ($rows[$i][$nom_columnas['Ranking de venta']] != null ) {
                    $key3 = 0;
                    foreach ($dtrnkventa as $var)  {
                        if ($dtrnkventa[$key3]['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Ranking de venta']])) {
                            $val2 = true;break;
                        }$key3++;
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
        }}

        if ($val == TRUE) {
            /*Validacion PIRAMIDE MIX */ $tipoVal = 4; $dtpiramidemix = plan_compra::list_piramidemix();
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                if ($rows[$i][$nom_columnas['Piramide Mix']] != null ) {
                    $key3 = 0;
                    foreach ($dtpiramidemix as $var)  {
                        if ($dtpiramidemix[$key3]['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Piramide Mix']])) {
                            $val2 = true;break;
                        }$key3++;
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }}

        if ($val == TRUE) {
            /*Validacion cluster */ $tipoVal = 5; $dtcluster = plan_compra::list_cluster($cod_tempo,$depto);
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                    $key3 = 0;
                    foreach ($dtcluster as $var)  {
                        if ($dtcluster[$key3]['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Cluster']])) {
                            $val2 = true; break;
                        }$key3++;
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                }
            }}

        if ($val == TRUE) {
            /*Validacion formato */ $tipoVal = 6; $dtformato = plan_compra::list_Formato($cod_tempo,$depto);
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                if ($rows[$i][$nom_columnas['Formato']] != null ) {
                    $key3 = 0;
                    foreach ($dtformato as $var)  {
                        if ($dtformato[$key3]['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Formato']])) {
                            $val2 = true;break;
                        }$key3++;
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }}
        if ($val == TRUE) {
            /*Validacion via */ $tipoVal = 7; $dtvia = plan_compra::list_via();
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                if ($rows[$i][$nom_columnas['Via']] != null ) {
                    $key3 = 0;
                    foreach ($dtvia as $var)  {
                        if ($dtvia[$key3]['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Via']])) {
                            $val2 = true;break;
                        }$key3++;
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }}
        if ($val == TRUE) {
            /*Validacion pais */ $tipoVal = 8; $dtpais =  plan_compra::list_pais();
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                if ($rows[$i][$nom_columnas['Pais']] != null ) {
                    $key3 = 0;
                    foreach ($dtpais as $var)  {
                        if (strtoupper($dtpais[$key3]['DESCRIPCION']) == strtoupper($rows[$i][$nom_columnas['Pais']])) {
                            $val2 = true;break;
                        }$key3++;
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }}
        if ($val == TRUE) {
            /*Validacion Ventana Debut */ $tipoVal = 9; $ventanas = array("A","B","C","D","E","F","G","H","I");
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                    foreach ($ventanas as $var)  {
                        if ($var == strtoupper($rows[$i][$nom_columnas['Ventana Debut']])) {
                            $val2 = true;break;
                        };
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
            }}
        if ($val == TRUE) {
            /*Validacion Precio Blanco*/ $tipoVal = 10;
            for($i = 3;$i <= $limite; $i++){
                $val2 = true;
                if ( ($rows[$i][$nom_columnas['Precio']] != null)) {
                    $numero = explode(".", $rows[$i][$nom_columnas['Precio']]);
                    if (count($numero) > 1){
                        $val2 = false;
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }}
        if ($val == TRUE) {
            /*Validacion Tallas y Curvas*/ $tipoVal = 11;
            for($i = 3;$i <= $limite; $i++){
                $arraytalla = [];$arraycurva = [];
                for($x = 1;$x <= 9; $x++){
                    if ($rows[$i][$nom_columnas['Talla'.$x]] != null and $rows[$i][$nom_columnas['Talla'.$x]] <> "0" and $rows[$i][$nom_columnas['Talla'.$x]] <> "") {
                        array_push($arraytalla, $rows[$i][$nom_columnas['Talla'.$x]]);
                    }
                }
                for($x = 1;$x <= 9; $x++){
                    if ($rows[$i][$nom_columnas['Curva'.$x]] != null and $rows[$i][$nom_columnas['Curva'.$x]] <> "0" and $rows[$i][$nom_columnas['Curva'.$x]] <> "") {
                        array_push($arraycurva, $rows[$i][$nom_columnas['Curva'.$x]]);
                    }
                }

                if (count($arraycurva) <> count($arraytalla)){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }}
        if ($val == TRUE) {
            /*Validacion tipo empaque*/ $tipoVal = 12;
            for($i = 3;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['Tipo de empaque']] != null and $rows[$i][$nom_columnas['Tipo de empaque']] <> "0" and $rows[$i][$nom_columnas['Tipo de empaque']] <> "") {
                    if (strtoupper($rows[$i][$nom_columnas['Tipo de empaque']]) == "SOLIDO" or strtoupper($rows[$i][$nom_columnas['Tipo de empaque']])== "CURVADO") {
                    }else{
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }}
        if ($val == TRUE) {
            /*Validacion porcentaje*/ $tipoVal = 13;
            for($i = 3;$i <= $limite; $i++){
                $arraytalla = [];$arraypocentaje= [];
                for($x = 1;$x <= 9; $x++){
                    if ($rows[$i][$nom_columnas['Talla'.$x]] != null and $rows[$i][$nom_columnas['Talla'.$x]] <> "0" and $rows[$i][$nom_columnas['Talla'.$x]] <> "") {
                        array_push($arraytalla, $rows[$i][$nom_columnas['Talla'.$x]]);
                    }
                }
                for($x = 1;$x <= 9; $x++){
                    if ($rows[$i][$nom_columnas['Size%'.$x]] != null and $rows[$i][$nom_columnas['Size%'.$x]] <> "0" and $rows[$i][$nom_columnas['Size%'.$x]] <> "") {
                        if(floor($rows[$i][$nom_columnas['Size%'.$x]]) == 0){
                            array_push($arraypocentaje, round($rows[$i][$nom_columnas['Size%'.$x]]*100,3));
                        }else{
                            array_push($arraypocentaje, round($rows[$i][$nom_columnas['Size%'.$x]],3));
                        }

                    }
                }
                if (count($arraypocentaje) <> count($arraytalla)){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }else{ $total = 0;

                    foreach ($arraypocentaje as $var){
                        $total += $var;
                    }
                    if ($total >= 99 and $total <= 101){
                    }else{
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }

            }}
        if ($val == TRUE) {
            /*Validacion de Unidades*/ $tipoVal = 14;
            for($i = 3;$i <= $limite; $i++){
                $ventana =  $rows[$i][$nom_columnas['Ventana Debut']] ;

                if ($rows[$i][$nom_columnas['Vent'.$ventana]] == null or
                    $rows[$i][$nom_columnas['Vent'.$ventana]] == "0" or
                    $rows[$i][$nom_columnas['Vent'.$ventana]] == "") {

                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }

            }}
        if ($val == TRUE) {
            /*Validacion short name vacios*/ $tipoVal = 15;
            for($i = 3;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['Estilo Corto']] == null or
                    $rows[$i][$nom_columnas['Estilo Corto']] == "0" or
                    $rows[$i][$nom_columnas['Estilo Corto']] == "") {
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }

            }}
        if ($val == TRUE) {
            /*Validacion ID_CORPORTAIVO 10 LEN*/ $tipoVal = 16;
            for($i = 3;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['Codigo corporativo']] <> null or
                    $rows[$i][$nom_columnas['Codigo corporativo']] <> "0" or
                    $rows[$i][$nom_columnas['Codigo corporativo']] <> "") {

                    if(strlen($rows[$i][$nom_columnas['Codigo corporativo']]) > 10 ){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }

            }}
        if ($val == TRUE) {
            /*Validacion tdas por cluster*/ $tipoVal = 17;
            $array1 = [];
            for($i = 3;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['Codigo Marca']] <> null and
                    $rows[$i][$nom_columnas['Codigo Marca']] <> "0"  and
                    $rows[$i][$nom_columnas['Codigo Marca']] <> ""   and
                    $rows[$i][$nom_columnas['Cluster']]  <> null and
                    $rows[$i][$nom_columnas['Cluster']]  <> "0" and
                    $rows[$i][$nom_columnas['Cluster']]  <> "" ) {

                    $key2 = false;
                    foreach ($array1 as $val){ $var1Est = substr($val, 0,1);$var1Clust = substr($val, 1,strlen($val));
                        if ($var1Clust == $rows[$i][$nom_columnas['Cluster']] and $var1Est == 1){
                            $filarow = $filarow . strval($i + 1) . ",";
                            $key2 = true;
                            break;
                        }elseif($var1Clust == $rows[$i][$nom_columnas['Cluster']] and $var1Est == 0){
                            $key2 = true;
                            break;
                        }
                    }

                    if($key2 == false){
                        $dtcluster = explode("+", $rows[$i][$nom_columnas['Cluster']]);
                        $_existe = true;
                        foreach ($dtcluster as $var){
                            $codClus = plan_compra::getcodCluster($var,$depto,$cod_tempo);
                            $tdas = plan_compra::List_tda_Cluster($cod_tempo,$depto,$rows[$i][$nom_columnas['Codigo Marca']],$codClus);
                            if(count($tdas) == 0) {
                                $_existe = false;
                            }
                        }
                        if ($_existe == false){
                            array_push($array1,1 .$rows[$i][$nom_columnas['Cluster']]);
                            $val = FALSE;
                            $filarow = $filarow . strval($i + 1) . ",";
                        }else {
                            array_push($array1,0 .$rows[$i][$nom_columnas['Cluster']]);
                        }
                    }
                }

            }
        }



        if ($val == FALSE ) {
            if ($tipoVal == 1){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Temporada no se encuentra BD. Ej: CL - INVIERNO,CL - OTOÑO,CL - PRIMAVERA,CL - VERANO,CL - TODA TEMPORADA");
            }
            elseif ($tipoVal == 2){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Ciclo de vida no se encuentra en BD C1.");
            }
            elseif ($tipoVal == 3){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Ranking de venta no se encuentra en BD C1.");
            }
            elseif ($tipoVal == 4){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Pirámide Mix no se encuentra en BD C1.");
            }
            elseif ($tipoVal == 5){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Cluster(s) no se encuentra en BD C1.");
            }
            elseif ($tipoVal == 6){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Formato no se encuentran en BD C1.");
            }
            elseif ($tipoVal == 7){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Vía no se encuentran en BD C1.");
            }
            elseif ($tipoVal == 8){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> País(es) no se encuentran en BD PMM.");
            }
            elseif ($tipoVal == 9){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Ventana no se encuentra BD C1.");
            }
            elseif ($tipoVal == 10){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El precio no puede ser decimal.");
            }
            elseif ($tipoVal == 11){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> Las cantidades de tallas vs curva no cuadran.");
            }
            elseif ($tipoVal == 12){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El tipo empaque no encuentran bd C1.");
            }
            elseif ($tipoVal == 13){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.Las cantidades de porcentajes no cuadran con las cantidades de tallas o la suma de los porcentajes son mayor o menor 100%.");
            }
            elseif ($tipoVal == 14){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.Las unidades por ventana no deben estar en 0.");
            }
            elseif ($tipoVal == 15){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.El estilo corto no debe estar en blanco.");
            }
            elseif ($tipoVal == 16){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.El Código corporativo tiene que ser máximo 10 caracteres.");
            }
            elseif ($tipoVal == 17){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.No existen tdas configurada por clúster.");
            }
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;

    }
    public static function val_grupo_compra($rows,$limite,$nom_columnas){
        $val= "";
        for($i = 3;$i <= $limite; $i++) {
            if (($rows[$i][$nom_columnas['Grupo de compra']] <> "") and ($rows[$i][$nom_columnas['Grupo de compra']] != null) ){
            $val = $val.$rows[$i][$nom_columnas['Grupo de compra']].",";
            }
        }
        if ($val <> ""){
            $val =substr($val, 0, -1);
            $porciones = explode(",", $val);
            $porciones = array_unique($porciones);

            if (count($porciones) > 1){
                $array = array('Tipo' => false,
                    'Error'=> "El archivo debe tener solo un grupo de compra.");
            }else{
                $array = array('Tipo' => true,
                    'Error'=> "");
            }
        }
        return  $array;
    }
    public static function val_grupo_compra_x_estado($cod_tempo,$depto,$grupo_compra){
    $plan = plan_compra::list_plan_compraxgrupo($cod_tempo,$depto,$grupo_compra);
    if (count($plan) > 0){
        $array = array('Tipo' => false,
                    'Error'=> "Ya existen datos con estado distinto a ingresado en este grupo de compra(".$grupo_compra.").");
    }else{
        $array = array('Tipo' => true,
                    'Error'=> "");
    }
        return  $array;
    }
    public static function val_mstpack($rows,$limite,$nom_columnas,$depto){
        $val = TRUE;
        $filarow = "";
        for($i = 3;$i <= $limite; $i++) {
            if ($rows[$i][$nom_columnas['Cod Linea']] <> null and $rows[$i][$nom_columnas['Cod Sublinea']] <> null){
            $dtmstpack = plan_compra::get_mst_pack($depto,$rows[$i][$nom_columnas['Cod Linea']],$rows[$i][$nom_columnas['Cod Sublinea']]);

            if (count($dtmstpack)== 0){
                $filarow = $filarow . strval($i + 1) . ",";
                $val = FALSE;
             }elseif($dtmstpack == 0){
                $filarow = $filarow . strval($i + 1) . ",";
                $val = FALSE;
            }
            }
        }

        if ($val == FALSE ) {
            $array = array('Tipo' => $val,
                'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;

    }
    public static function eliminardatosrows($rows,$limite,$nom_columnas){
        $val_delete = "";
        for($i = 0;$i <= $limite; $i++){
            if($i < 2) {
                $val_delete = $val_delete . $i . ",";
            }else{
            if ($rows[$i][$nom_columnas['Linea']] == null or
                $rows[$i][$nom_columnas['Sublinea']] ==  null or
                $rows[$i][$nom_columnas['Estilo Corto']] ==  null or
                $rows[$i][$nom_columnas['Color']] ==  null or
                $rows[$i][$nom_columnas['Cod Dpto']] ==  null) {
                $val_delete = $val_delete .$i.",";
            }
            }
        }

        if ($val_delete <> ""){
            $val_delete = substr($val_delete, 0, - 1);
            $val_delete = explode(",", $val_delete);
            foreach ($val_delete as $var ){
                unset($rows[$var]);
            }
        }

        $rows = array_values($rows);// reordena los array

        return $rows;
    }
    public static function Separacion_Data_Ventana($rows,$limite,$nom_columnas){

        $arrayinsert =[];
        $vent = array("VentA","VentB","VentC","VentD","VentE","VentF","VentG","VentH","VentI");
       // array_push($arrayinsert,$rows[2]);
        $data2 = plan_compra::get_columnas_archivos(1);
        $arraycabezera = [];

        foreach ($rows[2] as $val){

            if ($val == "s" or $val == "Unidades"){
                array_push($arraycabezera,$val);
            }else{
                foreach ($data2 as $val2){
                    if ($val2["COLUMNAS"]== $val){
                        array_push($arraycabezera,$val);
                        break;
                    }
                }
            }
        }

        array_push($arrayinsert,$arraycabezera);


        for($i = 3;$i <= $limite; $i++) {
            if ($rows[$i][$nom_columnas['Linea']] != null and
                $rows[$i][$nom_columnas['Sublinea']] != null and
                $rows[$i][$nom_columnas['Estilo Corto']] != null and
                $rows[$i][$nom_columnas['Color']] != null) {

                $rows[$i][$nom_columnas["Unidades"]] = $rows[$i][$nom_columnas["Vent" . strtoupper($rows[$i][$nom_columnas["Ventana Debut"]])]];
                /*Que empieze de ls ventana debut hacia adelante*/
                $key = 0;
                foreach ($vent as $var) {
                    $key += 1;
                    if (("Vent" . strtoupper($rows[$i][$nom_columnas["Ventana Debut"]])) == $var) {
                        break;
                    }
                }
                /*datos nuevos por ventana.*/
                $key2 = 0;
                foreach ($vent as $var) {
                    $key2 += 1;
                    If ($rows[$i][$nom_columnas[$var]] > 0
                        and $key2 >= $key) {
                        $ventanas = substr($var, 4, 1);
                        $debut = "REORDER";
                        $ciclovida = "";$tipo_empaque = 'Solido';
                        if ($ventanas == strtoupper($rows[$i][$nom_columnas["Ventana Debut"]])){
                            $debut ="DEBUT";
                        }
                        if($debut == "DEBUT"){
                            $ciclovida =$rows[$i][$nom_columnas["Ciclo de Vida"]];
                        }
                        if($debut == "DEBUT" and $rows[$i][$nom_columnas["Tipo de empaque"]] == "Curvado"){
                            $tipo_empaque = 'Curvado';
                        }


                        array_push($arrayinsert
                            , array($rows[$i][$nom_columnas["s"]]
                            , $rows[$i][$nom_columnas["Cod Dpto"]]
                            , $rows[$i][$nom_columnas["Dpto"]]
                            , $rows[$i][$nom_columnas["Marca"]]
                            , $rows[$i][$nom_columnas["Codigo Marca"]]
                            , $rows[$i][$nom_columnas["Season"]]
                            , $rows[$i][$nom_columnas["Linea"]]
                            , $rows[$i][$nom_columnas["Cod Linea"]]
                            , $rows[$i][$nom_columnas["Sublinea"]]
                            , $rows[$i][$nom_columnas["Cod Sublinea"]]
                            , $rows[$i][$nom_columnas["Codigo corporativo"]]
                            , $rows[$i][$nom_columnas["Nombre Estilo"]]
                            , $rows[$i][$nom_columnas["Estilo Corto"]]
                            , $rows[$i][$nom_columnas["Descripcion Estilo"]]
                            , $rows[$i][$nom_columnas["Color"]]
                            , $rows[$i][$nom_columnas["Cod Color"]]
                            , $rows[$i][$nom_columnas["Evento"]]
                            , $rows[$i][$nom_columnas["Grupo de compra"]]
                            , $ventanas
                            , $rows[$i][$nom_columnas["Tipo exhibicion"]]
                            , $rows[$i][$nom_columnas["Tipo Producto"]] 
                            , $debut
                            , $rows[$i][$nom_columnas["Temporada"]]
                            , $rows[$i][$nom_columnas["Precio"]]
                            , $rows[$i][$nom_columnas["Ranking de venta"]]
                            , $ciclovida
                            , $rows[$i][$nom_columnas["Piramide Mix"]]
                            , $rows[$i][$nom_columnas["Ratio compra"]]
                            , $rows[$i][$nom_columnas["Factor amplificacion"]]
                            , $rows[$i][$nom_columnas["Ratio compra final"]]
                            , valida_archivo_bmt::Valida_DEBUT_REORDER($rows[$i][$nom_columnas["Cluster"]],$debut,"CLUSTER")
                            , valida_archivo_bmt::Valida_DEBUT_REORDER($rows[$i][$nom_columnas["Formato"]],$debut,"FORMATO")
                            , $rows[$i][$nom_columnas["Compra Unidades Assortment"]]
                            , $rows[$i][$nom_columnas["Compra Unidades final"]]
                            , $rows[$i][$nom_columnas["Var%"]]
                            , $rows[$i][$nom_columnas["Target USD"]]
                            , $rows[$i][$nom_columnas["RFID USD"]]
                            , $rows[$i][$nom_columnas["Via"]]
                            , $rows[$i][$nom_columnas["Pais"]]
                            , $rows[$i][$nom_columnas["Factor"]]
                            , $rows[$i][$nom_columnas["Costo Total"]]
                            , $rows[$i][$nom_columnas["Retail Total sin iva"]]
                            , $rows[$i][$nom_columnas["MUP Compra"]]
                            , $rows[$i][$nom_columnas["Exhibicion"]]
                            , $rows[$i][$nom_columnas["Talla1"]], $rows[$i][$nom_columnas["Talla2"]], $rows[$i][$nom_columnas["Talla3"]]
                            , $rows[$i][$nom_columnas["Talla4"]], $rows[$i][$nom_columnas["Talla5"]], $rows[$i][$nom_columnas["Talla6"]]
                            , $rows[$i][$nom_columnas["Talla7"]], $rows[$i][$nom_columnas["Talla8"]], $rows[$i][$nom_columnas["Talla9"]]
                            , $rows[$i][$nom_columnas["Inner"]]
                            , $rows[$i][$nom_columnas["Curva1"]], $rows[$i][$nom_columnas["Curva2"]], $rows[$i][$nom_columnas["Curva3"]]
                            , $rows[$i][$nom_columnas["Curva4"]], $rows[$i][$nom_columnas["Curva5"]], $rows[$i][$nom_columnas["Curva6"]]
                            , $rows[$i][$nom_columnas["Curva7"]], $rows[$i][$nom_columnas["Curva8"]], $rows[$i][$nom_columnas["Curva9"]]
                            , $rows[$i][$nom_columnas["Validador Masterpack/Inner"]]
                            , $tipo_empaque
                            //, $rows[$i][$nom_columnas["Tipo de empaque"]]
                            , $rows[$i][$nom_columnas["N curvas por caja curvadas"]]
                            , $rows[$i][$nom_columnas["1_%"]], $rows[$i][$nom_columnas["2_%"]], $rows[$i][$nom_columnas["3_%"]]
                            , $rows[$i][$nom_columnas["4_%"]], $rows[$i][$nom_columnas["5_%"]], $rows[$i][$nom_columnas["6_%"]]
                            , $rows[$i][$nom_columnas["7_%"]], $rows[$i][$nom_columnas["8_%"]], $rows[$i][$nom_columnas["9_%"]]
                            , $rows[$i][$nom_columnas["TiendasA"]]
                            , $rows[$i][$nom_columnas["TiendasB"]]
                            , $rows[$i][$nom_columnas["TiendasC"]]
                            , $rows[$i][$nom_columnas["TiendasI"]]
                            , valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i][$nom_columnas["ClusterA"]],$debut)
                            , valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i][$nom_columnas["ClusterB"]],$debut)
                            , valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i][$nom_columnas["ClusterC"]],$debut)
                            , valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i][$nom_columnas["ClusterI"]],$debut)
                            , $rows[$i][$nom_columnas["Size%1"]], $rows[$i][$nom_columnas["Size%2"]], $rows[$i][$nom_columnas["Size%3"]]
                            , $rows[$i][$nom_columnas["Size%4"]], $rows[$i][$nom_columnas["Size%5"]], $rows[$i][$nom_columnas["Size%6"]]
                            , $rows[$i][$nom_columnas["Size%7"]], $rows[$i][$nom_columnas["Size%8"]], $rows[$i][$nom_columnas["Size%9"]]
                            , $rows[$i][$nom_columnas["VentA"]], $rows[$i][$nom_columnas["VentB"]], $rows[$i][$nom_columnas["VentC"]]
                            , $rows[$i][$nom_columnas["VentD"]], $rows[$i][$nom_columnas["VentE"]], $rows[$i][$nom_columnas["VentF"]]
                            , $rows[$i][$nom_columnas["VentG"]], $rows[$i][$nom_columnas["VentH"]], $rows[$i][$nom_columnas["VentI"]]
                            , $rows[$i][$nom_columnas[$var]]
                            ));

                    }
                }
            }
        }
        return $arrayinsert;
    }

    public static function Separacion_Data_Ventana2($rows,$limite,$nom_columnas){

        $arrayinsert =[];
        $vent = array("VentA","VentB","VentC","VentD","VentE","VentF","VentG","VentH","VentI");
        // array_push($arrayinsert,$rows[2]);
        $data2 = plan_compra::get_columnas_archivos(1);
        $arraycabezera = [];

        foreach ($rows[0] as $val){
            if ($val == "s" or $val == "Unidades"){
                array_push($arraycabezera,$val);
            }else{
                foreach ($data2 as $val2){
                    if ($val2["COLUMNAS"]== $val){
                        array_push($arraycabezera,$val);
                        break;
                    }
                }
            }
        }


        array_push($arrayinsert,$arraycabezera);

        $key4 = 0;
        foreach ($rows as $val2) {$key4++;
            if ($key4<>1){
                if ($val2[$nom_columnas['Linea']] != null and
                    $val2[$nom_columnas['Sublinea']] != null and
                    $val2[$nom_columnas['Estilo Corto']] != null and
                    $val2[$nom_columnas['Color']] != null) {

                    $val2[$nom_columnas["Unidades"]] = $val2[$nom_columnas["Vent" . strtoupper($val2[$nom_columnas["Ventana Debut"]])]];
                    /*Que empieze de ls ventana debut hacia adelante*/
                    $key = 0;
                    foreach ($vent as $var) {
                        $key += 1;
                        if (("Vent" . strtoupper($val2[$nom_columnas["Ventana Debut"]])) == $var) {
                            break;
                        }
                    }
                    /*datos nuevos por ventana.*/
                    $key2 = 0;
                    foreach ($vent as $var) {
                        $key2 += 1;
                        If ($val2[$nom_columnas[$var]] > 0
                            and $key2 >= $key) {
                            $ventanas = substr($var, 4, 1);
                            $debut = "REORDER";
                            $ciclovida = "";$tipo_empaque = 'Solido';
                            if ($ventanas == strtoupper($val2[$nom_columnas["Ventana Debut"]])){
                                $debut ="DEBUT";
                            }
                            if($debut == "DEBUT"){
                                $ciclovida =$val2[$nom_columnas["Ciclo de Vida"]];
                            }
                            if($debut == "DEBUT" and $val2[$nom_columnas["Tipo de empaque"]] == "Curvado"){
                                $tipo_empaque = 'Curvado';
                            }


                            array_push($arrayinsert
                                , array($val2[$nom_columnas["s"]]
                                , $val2[$nom_columnas["Cod Dpto"]]
                                , $val2[$nom_columnas["Dpto"]]
                                , $val2[$nom_columnas["Marca"]]
                                , $val2[$nom_columnas["Codigo Marca"]]
                                , $val2[$nom_columnas["Season"]]
                                , $val2[$nom_columnas["Linea"]]
                                , $val2[$nom_columnas["Cod Linea"]]
                                , $val2[$nom_columnas["Sublinea"]]
                                , $val2[$nom_columnas["Cod Sublinea"]]
                                , $val2[$nom_columnas["Codigo corporativo"]]
                                , $val2[$nom_columnas["Nombre Estilo"]]
                                , $val2[$nom_columnas["Estilo Corto"]]
                                , $val2[$nom_columnas["Descripcion Estilo"]]
                                , $val2[$nom_columnas["Color"]]
                                , $val2[$nom_columnas["Cod Color"]]
                                , $val2[$nom_columnas["Evento"]]
                                , $val2[$nom_columnas["Grupo de compra"]]
                                , $ventanas
                                , $val2[$nom_columnas["Tipo exhibicion"]]
                                , $val2[$nom_columnas["Tipo Producto"]]
                                , $debut
                                , $val2[$nom_columnas["Temporada"]]
                                , $val2[$nom_columnas["Precio"]]
                                , $val2[$nom_columnas["Ranking de venta"]]
                                , $ciclovida
                                , $val2[$nom_columnas["Piramide Mix"]]
                                , $val2[$nom_columnas["Ratio compra"]]
                                , $val2[$nom_columnas["Factor amplificacion"]]
                                , $val2[$nom_columnas["Ratio compra final"]]
                                , valida_archivo_bmt::Valida_DEBUT_REORDER($val2[$nom_columnas["Cluster"]],$debut,"CLUSTER")
                                , valida_archivo_bmt::Valida_DEBUT_REORDER($val2[$nom_columnas["Formato"]],$debut,"FORMATO")
                                , $val2[$nom_columnas["Compra Unidades Assortment"]]
                                , $val2[$nom_columnas["Compra Unidades final"]]
                                , $val2[$nom_columnas["Var%"]]
                                , $val2[$nom_columnas["Target USD"]]
                                , $val2[$nom_columnas["RFID USD"]]
                                , $val2[$nom_columnas["Via"]]
                                , $val2[$nom_columnas["Pais"]]
                                , $val2[$nom_columnas["Factor"]]
                                , $val2[$nom_columnas["Costo Total"]]
                                , $val2[$nom_columnas["Retail Total sin iva"]]
                                , $val2[$nom_columnas["MUP Compra"]]
                                , $val2[$nom_columnas["Exhibicion"]]
                                , $val2[$nom_columnas["Talla1"]], $val2[$nom_columnas["Talla2"]], $val2[$nom_columnas["Talla3"]]
                                , $val2[$nom_columnas["Talla4"]], $val2[$nom_columnas["Talla5"]], $val2[$nom_columnas["Talla6"]]
                                , $val2[$nom_columnas["Talla7"]], $val2[$nom_columnas["Talla8"]], $val2[$nom_columnas["Talla9"]]
                                , $val2[$nom_columnas["Inner"]]
                                , $val2[$nom_columnas["Curva1"]], $val2[$nom_columnas["Curva2"]], $val2[$nom_columnas["Curva3"]]
                                , $val2[$nom_columnas["Curva4"]], $val2[$nom_columnas["Curva5"]], $val2[$nom_columnas["Curva6"]]
                                , $val2[$nom_columnas["Curva7"]], $val2[$nom_columnas["Curva8"]], $val2[$nom_columnas["Curva9"]]
                                , $val2[$nom_columnas["Validador Masterpack/Inner"]]
                                , $tipo_empaque
                                    //, $rows[$i][$nom_columnas["Tipo de empaque"]]
                                , $val2[$nom_columnas["N curvas por caja curvadas"]]
                                , $val2[$nom_columnas["1_%"]], $val2[$nom_columnas["2_%"]], $val2[$nom_columnas["3_%"]]
                                , $val2[$nom_columnas["4_%"]], $val2[$nom_columnas["5_%"]], $val2[$nom_columnas["6_%"]]
                                , $val2[$nom_columnas["7_%"]], $val2[$nom_columnas["8_%"]], $val2[$nom_columnas["9_%"]]
                                , $val2[$nom_columnas["TiendasA"]]
                                , $val2[$nom_columnas["TiendasB"]]
                                , $val2[$nom_columnas["TiendasC"]]
                                , $val2[$nom_columnas["TiendasI"]]
                                , valida_archivo_bmt::ValidaCurvasxtdasDebut($val2[$nom_columnas["ClusterA"]],$debut)
                                , valida_archivo_bmt::ValidaCurvasxtdasDebut($val2[$nom_columnas["ClusterB"]],$debut)
                                , valida_archivo_bmt::ValidaCurvasxtdasDebut($val2[$nom_columnas["ClusterC"]],$debut)
                                , valida_archivo_bmt::ValidaCurvasxtdasDebut($val2[$nom_columnas["ClusterI"]],$debut)
                                , $val2[$nom_columnas["Size%1"]], $val2[$nom_columnas["Size%2"]], $val2[$nom_columnas["Size%3"]]
                                , $val2[$nom_columnas["Size%4"]], $val2[$nom_columnas["Size%5"]], $val2[$nom_columnas["Size%6"]]
                                , $val2[$nom_columnas["Size%7"]], $val2[$nom_columnas["Size%8"]], $val2[$nom_columnas["Size%9"]]
                                , $val2[$nom_columnas["VentA"]], $val2[$nom_columnas["VentB"]], $val2[$nom_columnas["VentC"]]
                                , $val2[$nom_columnas["VentD"]], $val2[$nom_columnas["VentE"]], $val2[$nom_columnas["VentF"]]
                                , $val2[$nom_columnas["VentG"]], $val2[$nom_columnas["VentH"]], $val2[$nom_columnas["VentI"]]
                                , $val2[$nom_columnas[$var]]
                                ));
                        }
                    }
            }
        }
        }
        return $arrayinsert;
    }

    public static function existenCamposVacios($fila, $campo, $columnas, $datos) {

        $valor = '';
        foreach ($campo as $val) {
            $valida[] = array($val => $datos[$columnas[$val]] == '' ? '1' : '0');
        }
        if (strlen(array_search("1", array_reduce($valida, 'array_merge', []))) > 0) {
            $fila = $fila + 1;
            $valor = array_search("1", array_reduce($valida, 'array_merge', [])) . '#' . $fila;
        }
        return $valor;
    }
    public static function existenCamposCero($fila, $campo, $columnas, $datos) {

        $valor = '';
        foreach ($campo as $val) {
            $valida[] = array($val => $datos[$columnas[$val]] == 0 ? '1' : '0');
        }
        if (strlen(array_search("1", array_reduce($valida, 'array_merge', []))) > 0) {
            $fila = $fila + 1;
            $valor = array_search("1", array_reduce($valida, 'array_merge', [])) . '#' . $fila;
        }
        return $valor;
    }
    public static function esEntero($fila, $campo, $columnas, $datos) {
        $fila++;
        foreach ($campo as $val) {
            if (filter_var($datos[$columnas[$val]], FILTER_VALIDATE_INT) === false && strlen($datos[$columnas[$val]]) > 0) {
                $valida[$val] = 1;
            } else {
                $valida[$val] = 0;
            }
        }
        if (count(array_search(1, $valida)) > 0) {
            $respuesta = array_search(1, $valida);
        } else {
            $respuesta = '';
        }
        return $fila . '#' . $respuesta;
    }
    public static function validaTempSeason($fila, $dato) {

        $criterios = array("CL - INVIERNO", "CL - OTOÑO", "CL - PRIMAVERA", "CL - VERANO", "CL - TODA TEMPORADA");
        $criterios = array_flip($criterios);
        $respuesta = '';
        $fila++;
        if (array_key_exists($dato, $criterios) == 1) {
            $respuesta = 0;
        } else {
            $respuesta = 1;
        }
        return $fila . '#' . $respuesta;
    }
    public static function validaGrupoCompra($fila, $dato) {
        $criterios = "-";
        $respuesta = '';
        $fila++;
        if (!strpos($dato, $criterios)) {
            $respuesta = 1;
        } else {
            $respuesta = 0;
        }
        return $fila . '#' . $respuesta;
    }
    public static function valida_Multiplo($rows,$limite,$nom_columnas ){

        $filarow = "";
        $val = TRUE;
        for($i = 3 ;$i <= $limite; $i++) {
            if (strtoupper($rows[$i][$nom_columnas['Tipo de empaque']]) == "CURVADO") {
                $val2 = true;
                $n_curvaxcajas = $rows[$i][$nom_columnas['N curvas por caja curvadas']];
                $cluster = explode("+", $rows[$i][$nom_columnas['Cluster']]);
                foreach ($cluster as $vals) {
                    if (fmod($rows[$i][$nom_columnas['Cluster' . $vals]], $n_curvaxcajas) <> 0) {
                        $val2 = false;
                        break;
                    }
                }
                if ($val2 == false) {
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }
        }


        if ($val == FALSE ) {
            $array = array('Tipo' => $val,
                'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;

    }
    //COD CORP
    public static function validaCodCorpLargo($fila, $dato) {

        $respuesta = '';
        $fila++;
        if (strlen($dato) > 10) {
            $respuesta = 1;
        } else {
            $respuesta = 0;
        }
        return $fila . '#' . $respuesta;
    }
    public static function validaGrupoCompraEstado($fila, $dato) {

        $respuesta = '';
        $fila++;
        if (strlen($dato) < 10) {
            $respuesta = 1;
        } else {
            $respuesta = 0;
        }
        return $fila . '#' . $respuesta;
    }
    public static function existeUnidades($fila, $columnas, $datos) {
        //echo $datos[$columnas['SIZE']];
        $recorre = explode(",", $datos[$columnas['SIZE']]);
        $total_unidades = 0;
        $respuesta = 0;
        // Si las unidades % estan en cero
        if ($datos[$columnas['Size %1']] == 0 && $datos[$columnas['Qty #1']] > 0) {
            for ($cont = 1; $cont <= count($recorre); $cont++) {
                $datos = array_replace($datos, array($columnas['Size %' . $cont] => round(($datos[$columnas['Qty #' . $cont]] / $datos[$columnas['TOTAL QUANTITY CL']]), 2)));
            }
            $respuesta = 0;
        } elseif ($datos[$columnas['Qty #1']] == 0 && $datos[$columnas['Size %1']] > 0) {
            for ($cont = 1; $cont <= count($recorre); $cont++) {
                $datos = array_replace($datos, array($columnas['Qty #' . $cont] => round(($datos[$columnas['Size %' . $cont]] * $datos[$columnas['TOTAL QUANTITY CL']]))));
            }
            $respuesta = 0;
        } else {
            for ($cont = 1; $cont <= count($recorre); $cont++) {
                $total_unidades = $total_unidades + $datos[$columnas['Qty #' . $cont]];
            }
            if ($total_unidades != $datos[$columnas['TOTAL QUANTITY CL']]) {
                $respuesta = 1;
            }
        }
        return $fila . '#' . $respuesta;
    }
    public static function validaCicloVida($fila, $dato) {
        $criterios = array("LONG TERM", "MID TERM", "SHORT TERM");
        $criterios = array_flip($criterios);
        $respuesta = '';
        $fila++;

        if (array_key_exists($dato, $criterios) == 1) {
            $respuesta = 0;
        } else {
            $respuesta = 1;
        }

        return $fila . '#' . $respuesta;
    }
    public static function validaVentana($fila, $dato) {

        $criterios = array("A", "B", "C", "D", "E", "F", "G", "H", "I");
        $criterios = array_flip($criterios);
        $respuesta = '';
        $fila++;

        if (array_key_exists($dato, $criterios) == 1) {
            $respuesta = 0;
        } else {
            $respuesta = 1;
        }

        return $fila . '#' . $respuesta;
    }
    public static function validaMasterPack($fila, $columnas, $datos, $temporada) {

        $master = plan_compra::obtieneMasterPack($temporada, $datos[$columnas['DEPARTMENT CODE']], $datos[$columnas['LINE (*)']], $datos[$columnas['SUBLNE CODE']]);
        $fila++;
        return $fila . '#' . $master;
    }
    public static function validaCambosBMT($fila, $depto, $columnas, $datos) {

        $parametros = new parametros();
        $valida['COLOR NAME'] = strlen(array_search(trim($datos[$columnas['COLOR NAME']]), $parametros->obtieneColores()));
        $cod_linea = array_search(trim($datos[$columnas['LINE (*)']]), $parametros->obtieneLineas($depto));
        $valida['LINE (*)'] = strlen($cod_linea);
        if (strlen($cod_linea) > 0) {
            $valida['SUBLNE CODE'] = strlen(array_search($datos[$columnas['SUBLNE CODE']], $parametros->obtieneSubLineas($depto, $cod_linea)));
        } else {
            $valida['SUBLNE CODE'] = 0;
        }
        return $valida;
    }
    public static function validaClusterVenta($fila, $depto, $columnas, $datos, $temporada) {
        $clusters = explode("+", $datos[$columnas['CLUSTER']]);
        $parametros = new parametros();
        $marcas = $parametros->obtieneMarcas($depto);
        $fila++;
        for ($id_cl = 1; $id_cl <= count($clusters); $id_cl++) {
            $valida[$id_cl] = plan_compra::obtieneSegmentosTienda($fila, $depto, $id_cl, $marcas[$datos[$columnas['LOCAL BRAND']]], $temporada);
        }
        return $fila . '#' . (int) in_array('0', $valida);
    }
    public static function validaTipoCambio($fila, $columnas, $datos, $temporada) {

        $parametros = new parametros();
        $fila++;
        return $fila . '#' . count($parametros->obtieneTipoCambio($temporada, 2));
    }
    Public static function ValidaCurvasxtdasDebut($Curva,$debut_reorder){
        if($debut_reorder == "REORDER" ){
            $Curva = 0;
        }
        return $Curva;
    }
    Public static function Valida_DEBUT_REORDER($VAL,$debut_reorder,$CAMPO){
        if($debut_reorder == "REORDER" ){
            $VAL = "";
        }ELSE{
            IF($CAMPO == 'FORMATO' AND $VAL == ""){
                $VAL = "SIN FORMATO";
            }
        }


        return $VAL;
    }
#endregion

    public static function Val_CamposObligatorio($CamposArchivo,$tipo){
        $data = plan_compra::get_columnas_archivos($tipo);
        $_Mensaje = "";

        foreach ($data as $val){
            $_exist = false;
            for ($a = 0;$a < count($CamposArchivo);$a++){
                if ($val["COLUMNAS"] === $CamposArchivo[$a]){
                    $_exist = true;
                    break;
                }
            }
            if ($_exist == false){
                $_Mensaje = $_Mensaje. strval($val["COLUMNAS"])." ," ;
            }
        }
        if ($_Mensaje <> ""){
            $_Mensaje =substr($_Mensaje, 0, -1);
        }

        Return $_Mensaje;
    }

#region {*************Metodos Importar bmt*************}

    public static function Val_Seasonbmt($rows,$limite,$nom_columnas,$temporada){
        $filarow = "";
        $val = TRUE;
        for($i = 14;$i <= $limite; $i++){
            if ($rows[$i][$nom_columnas['PI SEASON']] != null ) {
                if ($rows[$i][$nom_columnas['PI SEASON']] != $temporada) {
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }
        }

        if ($val == FALSE ) {
            $array = array('Tipo' => $val,
                'Error'=> substr($filarow, 0, - 1));
        }else{
            $array = array('Tipo' => $val,
                'Error'=> $filarow);
        }
        return  $array;
    }
    public static function Val_deptobmt($rows,$limite,$nom_columnas,$depto){
        $val = false;

        for($i = 14;$i <= $limite; $i++){
            if ($rows[$i][$nom_columnas['DEPARTMENT CODE']] != null ) {
                if ($rows[$i][$nom_columnas['DEPARTMENT CODE']] == $depto) {
                    $val = true;
                    break;
                }
            }
        }

        if ($val == false ) {
            $array = array('Tipo' => $val,
                'Error'=> "");
        }else{
            $array = array('Tipo' => $val,
                'Error'=> "");
        }
        return  $array;
    }
    public static function Grupar_Depto($rows,$limite,$nom_columnas,$depto){

        $arrayinsert =[];
        array_push($arrayinsert,$rows[0]);
        for($i = 1;$i <= $limite; $i++) {
            if ($rows[$i][$nom_columnas['DEPARTMENT CODE']] == $depto) {
                array_push($arrayinsert
                    , array($rows[$i][$nom_columnas["ID C1"]]
                            ,$rows[$i][$nom_columnas["PURCHASE GROUP"]]
                            ,$rows[$i][$nom_columnas["CORPORATE BUYER NAME"]]
                            ,$rows[$i][$nom_columnas["DISIGNER NAME"]]
                            ,$rows[$i][$nom_columnas["PI SEASON"]]
                            ,$rows[$i][$nom_columnas["COD CORP"]]
                            ,$rows[$i][$nom_columnas["STYLE NUMBER"]]
                            ,$rows[$i][$nom_columnas["STYLE NAME"]]
                            ,$rows[$i][$nom_columnas["SHORT_NAME"]]
                            ,$rows[$i][$nom_columnas["PHOTOGRAF"]]
                            ,$rows[$i][$nom_columnas["DESCRIPCION INTERNET"]]
                            ,$rows[$i][$nom_columnas["COLOR CODE"]]
                            ,$rows[$i][$nom_columnas["COLOR NAME"]]
                            ,$rows[$i][$nom_columnas["COLECTION"]]
                            ,$rows[$i][$nom_columnas["COMPOSITION"]]
                            ,$rows[$i][$nom_columnas["LINING"]]
                            ,$rows[$i][$nom_columnas["TYPE OF FABRIC"]]
                            ,$rows[$i][$nom_columnas["DETAILS"]]
                            ,$rows[$i][$nom_columnas["BEFORE MEETING REMARKS"]]
                            ,$rows[$i][$nom_columnas["AFTER MEETING REMARKS"]]
                            ,$rows[$i][$nom_columnas["PRODUCT DESCRIPTION"]]
                            ,$rows[$i][$nom_columnas["STYLE GENDER"]]
                            ,$rows[$i][$nom_columnas["SEASON"]]
                            ,$rows[$i][$nom_columnas["TARGET VENDOR"]]
                            ,$rows[$i][$nom_columnas["VENDOR NICK NAME"]]
                            ,$rows[$i][$nom_columnas["VENDOR CODE"]]
                            ,$rows[$i][$nom_columnas["COUNTRY OF ORIGIN"]]
                            ,$rows[$i][$nom_columnas["HKO/NO HKO"]]
                            ,$rows[$i][$nom_columnas["TARGET COST"]]
                            ,$rows[$i][$nom_columnas["TARGET BUDGET"]]
                            ,$rows[$i][$nom_columnas["TOTAL QUANTITY"]]
                            ,$rows[$i][$nom_columnas["FINAL COST"]]
                            ,$rows[$i][$nom_columnas["FINAL BUDGET"]]
                            ,$rows[$i][$nom_columnas["LEAD TIME TYPE"]]
                            ,$rows[$i][$nom_columnas["LOCAL BUYER"]]
                            ,$rows[$i][$nom_columnas["LOCAL BRAND"]]
                            ,$rows[$i][$nom_columnas["DEPARTMENT"]]
                            ,$rows[$i][$nom_columnas["DEPARTMENT CODE"]]
                            ,$rows[$i][$nom_columnas["LINE (*)"]]
                            ,$rows[$i][$nom_columnas["SUBLINE"]]
                            ,$rows[$i][$nom_columnas["SUBLNE CODE"]]
                            ,$rows[$i][$nom_columnas["TYPE OF EXHIBITION"]]
                            ,$rows[$i][$nom_columnas["LIFE CICLE"]]
                            ,$rows[$i][$nom_columnas["PRODUCT SEASON"]]
                            ,$rows[$i][$nom_columnas["TYPE OF PRODUCT"]]
                            ,$rows[$i][$nom_columnas["PYRAMID MIX"]]
                            ,$rows[$i][$nom_columnas["CHANCE OF USER"]]
                            ,$rows[$i][$nom_columnas["RANKING OF SALE"]]
                            ,$rows[$i][$nom_columnas["LIFE STYLE"]]
                            ,$rows[$i][$nom_columnas["RETAIL PRICE"]]
                            ,$rows[$i][$nom_columnas["PRICE RANGE"]]
                            ,$rows[$i][$nom_columnas["2 X RETAIL PRICE"]]
                            ,$rows[$i][$nom_columnas["ANTES/AHORA"]]
                            ,$rows[$i][$nom_columnas["EVENTO"]]
                            ,$rows[$i][$nom_columnas["SHIPMENT MODE"]]
                            ,$rows[$i][$nom_columnas["VENTANA"]]
                            ,$rows[$i][$nom_columnas["mm/dd1"]]
                            ,$rows[$i][$nom_columnas["mm/dd2"]]
                            ,$rows[$i][$nom_columnas["mm/dd3"]]
                            ,$rows[$i][$nom_columnas["mm/dd4"]]
                            ,$rows[$i][$nom_columnas["mm/dd5"]]
                            ,$rows[$i][$nom_columnas["mm/dd6"]]
                            ,$rows[$i][$nom_columnas["mm/dd7"]]
                            ,$rows[$i][$nom_columnas["TOTAL QUANTITY CL"]]
                            ,$rows[$i][$nom_columnas["CLUSTER"]]
                            ,$rows[$i][$nom_columnas["SIZE"]]
                            ,$rows[$i][$nom_columnas["Size %1"]]
                            ,$rows[$i][$nom_columnas["Size %2"]]
                            ,$rows[$i][$nom_columnas["Size %3"]]
                            ,$rows[$i][$nom_columnas["Size %4"]]
                            ,$rows[$i][$nom_columnas["Size %5"]]
                            ,$rows[$i][$nom_columnas["Size %6"]]
                            ,$rows[$i][$nom_columnas["Size %7"]]
                            ,$rows[$i][$nom_columnas["Size %8"]]
                            ,$rows[$i][$nom_columnas["Size %9"]]
                            ,$rows[$i][$nom_columnas["Size %10"]]
                            ,$rows[$i][$nom_columnas["Size %11"]]
                            ,$rows[$i][$nom_columnas["Size %12"]]
                            ,$rows[$i][$nom_columnas["Size %13"]]
                            ,$rows[$i][$nom_columnas["Size %14"]]
                            ,$rows[$i][$nom_columnas["Size %15"]]
                            ,$rows[$i][$nom_columnas["Qty #1"]]
                            ,$rows[$i][$nom_columnas["Qty #2"]]
                            ,$rows[$i][$nom_columnas["Qty #3"]]
                            ,$rows[$i][$nom_columnas["Qty #4"]]
                            ,$rows[$i][$nom_columnas["Qty #5"]]
                            ,$rows[$i][$nom_columnas["Qty #6"]]
                            ,$rows[$i][$nom_columnas["Qty #7"]]
                            ,$rows[$i][$nom_columnas["Qty #8"]]
                            ,$rows[$i][$nom_columnas["Qty #9"]]
                            ,$rows[$i][$nom_columnas["Qty #10"]]
                            ,$rows[$i][$nom_columnas["Qty #11"]]
                            ,$rows[$i][$nom_columnas["Qty #12"]]
                            ,$rows[$i][$nom_columnas["Qty #13"]]
                            ,$rows[$i][$nom_columnas["Qty #14"]]
                            ,$rows[$i][$nom_columnas["Qty #15"]]
                            ,$rows[$i][$nom_columnas["PREPACK"]]
                            ,$rows[$i][$nom_columnas["HANDLING TYPE"]]
                            ,$rows[$i][$nom_columnas["HANDLING TYPE CD"]]
                            ,$rows[$i][$nom_columnas["SIZE STICKER"]]
                            ,$rows[$i][$nom_columnas["UNITS PER BOX"]]
                            ,$rows[$i][$nom_columnas["REORDER"]]
                            ,$rows[$i][$nom_columnas["COST LAST PURCHASE"]]
                            ,$rows[$i][$nom_columnas["VENDOR LAST PURCHASE"]]
                            ,$rows[$i][$nom_columnas["EXTENDED WARRANTY"]]
                            ,$rows[$i][$nom_columnas["RFID COST"]]
                            ,$rows[$i][$nom_columnas["INSPECTION COST"]]
                            ,$rows[$i][$nom_columnas["ROYALTY"]]
                            ,$rows[$i][$nom_columnas["SIZE SAMPLE"]]
                            ,$rows[$i][$nom_columnas["LOCAL BUYER P"]]
                            ,$rows[$i][$nom_columnas["LOCAL BRAND P"]]
                            ,$rows[$i][$nom_columnas["DEPARTMENT P"]]
                            ,$rows[$i][$nom_columnas["DEPARTMENT CODE P"]]
                            ,$rows[$i][$nom_columnas["LINE (*) P"]]
                            ,$rows[$i][$nom_columnas["SUBLINE P"]]
                            ,$rows[$i][$nom_columnas["SUBLNE CODE P"]]
                            ,$rows[$i][$nom_columnas["HIERARCHI P"]]
                            ,$rows[$i][$nom_columnas["LIFE CICLE P"]]
                            ,$rows[$i][$nom_columnas["PRODUCT SEASON P"]]
                            ,$rows[$i][$nom_columnas["PYRAMID MIX P"]]
                            ,$rows[$i][$nom_columnas["CHANCE OF USER P"]]
                            ,$rows[$i][$nom_columnas["RANKING OF SALE P"]]
                            ,$rows[$i][$nom_columnas["LIFE STYLE P"]]
                            ,$rows[$i][$nom_columnas["RETAIL PRICE P"]]
                            ,$rows[$i][$nom_columnas["PRICE RANGE P"]]
                            ,$rows[$i][$nom_columnas["2 X RETAIL PRICE P"]]
                            ,$rows[$i][$nom_columnas["ANTES/AHORA P"]]
                            ,$rows[$i][$nom_columnas["EVENTO P"]]
                            ,$rows[$i][$nom_columnas["SHIPMENT MODE P"]]
                            ,$rows[$i][$nom_columnas["VENTANA P"]]
                            ,$rows[$i][$nom_columnas["mm/dd1 P"]]
                            ,$rows[$i][$nom_columnas["mm/dd2 P"]]
                            ,$rows[$i][$nom_columnas["mm/dd3 P"]]
                            ,$rows[$i][$nom_columnas["mm/dd4 P"]]
                            ,$rows[$i][$nom_columnas["mm/dd5 P"]]
                            ,$rows[$i][$nom_columnas["mm/dd6 P"]]
                            ,$rows[$i][$nom_columnas["mm/dd7 P"]]
                            ,$rows[$i][$nom_columnas["TOTAL QUANTITY P"]]
                            ,$rows[$i][$nom_columnas["SIZE TYPE P"]]
                            ,$rows[$i][$nom_columnas["SIZE P"]]
                            ,$rows[$i][$nom_columnas["Size %1 P"]]
                            ,$rows[$i][$nom_columnas["Size %2 P"]]
                            ,$rows[$i][$nom_columnas["Size %3 P"]]
                            ,$rows[$i][$nom_columnas["Size %4 P"]]
                            ,$rows[$i][$nom_columnas["Size %5 P"]]
                            ,$rows[$i][$nom_columnas["Size %6 P"]]
                            ,$rows[$i][$nom_columnas["Size %7 P"]]
                            ,$rows[$i][$nom_columnas["Size %8 P"]]
                            ,$rows[$i][$nom_columnas["Size %9 P"]]
                            ,$rows[$i][$nom_columnas["Size %10 P"]]
                            ,$rows[$i][$nom_columnas["Size %11 P"]]
                            ,$rows[$i][$nom_columnas["Size %12 P"]]
                            ,$rows[$i][$nom_columnas["Size %13 P"]]
                            ,$rows[$i][$nom_columnas["Size %14 P"]]
                            ,$rows[$i][$nom_columnas["Size %15 P"]]
                            ,$rows[$i][$nom_columnas["Qty #1 P"]]
                            ,$rows[$i][$nom_columnas["Qty #2 P"]]
                            ,$rows[$i][$nom_columnas["Qty #3 P"]]
                            ,$rows[$i][$nom_columnas["Qty #4 P"]]
                            ,$rows[$i][$nom_columnas["Qty #5 P"]]
                            ,$rows[$i][$nom_columnas["Qty #6 P"]]
                            ,$rows[$i][$nom_columnas["Qty #7 P"]]
                            ,$rows[$i][$nom_columnas["Qty #8 P"]]
                            ,$rows[$i][$nom_columnas["Qty #9 P"]]
                            ,$rows[$i][$nom_columnas["Qty #10 P"]]
                            ,$rows[$i][$nom_columnas["Qty #11 P"]]
                            ,$rows[$i][$nom_columnas["Qty #12 P"]]
                            ,$rows[$i][$nom_columnas["Qty #13 P"]]
                            ,$rows[$i][$nom_columnas["Qty #14 P"]]
                            ,$rows[$i][$nom_columnas["Qty #15 P"]]
                            ,$rows[$i][$nom_columnas["PREPACK P"]]
                            ,$rows[$i][$nom_columnas["HANDLING TYPE P"]]
                            ,$rows[$i][$nom_columnas["SIZE STICKER P"]]
                            ,$rows[$i][$nom_columnas["UNITS PER BOX P"]]
                            ,$rows[$i][$nom_columnas["REORDER P"]]
                            ,$rows[$i][$nom_columnas["COST LAST PURCHASE P"]]
                            ,$rows[$i][$nom_columnas["VENDOR LAST PURCHASE P"]]
                            ,$rows[$i][$nom_columnas["EXTENDED WARRANTY P"]]
                            ,$rows[$i][$nom_columnas["INSPECTION NEEDED P"]]
                            ,$rows[$i][$nom_columnas["INSPECTION COST P"]]
                            ,$rows[$i][$nom_columnas["ROYALTY P"]]
                            ,$rows[$i][$nom_columnas["PERU DUMPING P"]]
                            ,$rows[$i][$nom_columnas["SIZE SAMPLE P"]]
                            ,$rows[$i][$nom_columnas["Unidades"]]
                    ));
            }
        }

        return $arrayinsert;
    }
    public static function val_cantidad_porTalla($rows,$limite,$nom_columnas,$depto){}
    public static function eliminardatosrowsbmt($rows,$limite,$nom_columnas){
        $val_delete = "";
		for($i = 0;$i <= $limite; $i++){
            if($i < 13){
                $val_delete = $val_delete .$i.",";
            }else{
                if ($rows[$i][$nom_columnas['ID C1']]           ==  null AND
                    $rows[$i][$nom_columnas['PURCHASE GROUP']]  ==  null AND
                    $rows[$i][$nom_columnas['LINE (*)']]        ==  null AND
                    $rows[$i][$nom_columnas['SUBLNE CODE']]     ==  null AND
                    $rows[$i][$nom_columnas['STYLE NAME']]      ==  null AND
                    $rows[$i][$nom_columnas['COLOR CODE']]      ==  null AND
                    $rows[$i][$nom_columnas['VENTANA']]         ==  null ) {
                    $val_delete = $val_delete .$i.",";
                }
            }
        }

        if ($val_delete <> ""){
            $val_delete = substr($val_delete, 0, - 1);
            $val_delete = explode(",", $val_delete);
            foreach ($val_delete as $var ){
                unset($rows[$var]);
            }
        }

        $rows = array_values($rows);// reordena los array

        return $rows;
    }
    public static function Val_campos_bmt($rows,$limite,$nom_columnas,$depto,$temporada){
        $filarow = "";$val = true;
      //$grupo_compra = valida_archivo_bmt::Distinct_Grupo_Compra($rows,$limite,$nom_columnas);

      /*Validacion Style name*/ $tipoVal = 1;
          for($i = 1;$i <= $limite; $i++){
             if ($rows[$i][$nom_columnas['STYLE NAME']] == null or $rows[$i][$nom_columnas['STYLE NAME']] == "0" or $rows[$i][$nom_columnas['STYLE NAME']] == ""){
                 $val = false;
                 $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
             }
          }

      /*Validacion grupo compra null*/
      if ($val == true){ $tipoVal = 2;
          for($i = 1;$i <= $limite; $i++){
              if ($rows[$i][$nom_columnas['PURCHASE GROUP']] == null or $rows[$i][$nom_columnas['PURCHASE GROUP']] == "0" or $rows[$i][$nom_columnas['PURCHASE GROUP']] == ""){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
              }
           }
      }

      /*Validacion grupo compra encontrado bd c1*/
      if ($val == true){ $tipoVal = 3; $dt_grup = plan_compra::list_grupocompraBD($temporada,$depto);
          for($i = 1;$i <= $limite; $i++){$_exist = false;
                foreach ($dt_grup as $vl){
                    if ($rows[$i][$nom_columnas['PURCHASE GROUP']] == $vl["GRUPO_COMPRA"] ){
                        $_exist = true; break;
                    }
                }
                if ($_exist == false){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }
            }
      }

      /*Validacion Id C1*/
      if ($val == true){ $tipoVal = 4;$_grup = "";$dtidcolor = [];
          for($i = 1;$i <= $limite; $i++){$_exist = false;
              if ($_grup <> $rows[$i][$nom_columnas['PURCHASE GROUP']]){
                  $dtidcolor = plan_compra::list_Idcolor3x_Grupo($temporada,$depto,$rows[$i][$nom_columnas['PURCHASE GROUP']]);
              }
              foreach ($dtidcolor as $var){
                  if ($var["ID_COLOR3"] == $rows[$i][$nom_columnas['ID C1']]){
                      $_exist = true; break;
                  }
              }
              if ($_exist == false ){
               $val = false;
               $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
              }
          }
      }

      /*Validacion Ventana*/
      if ($val == true) {$tipoVal = 5; $ventanas = array("A","B","C","D","E","F","G","H","I");
          for($i = 1;$i <= $limite; $i++){$_existe = false;
              foreach ($ventanas as $var) {
                  if ($var == $rows[$i][$nom_columnas['VENTANA']]) {
                      $_existe = true; break;
                  };
              }
              if($_existe == false ){
                  $val = false;
                  $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
              }

          }
      }

      /*Validacion cod Color*/
      if ($val == true) {$tipoVal = 6; $Colores = plan_compra::list_colores();
          for($i = 1;$i <= $limite; $i++){$_existe = false;
                foreach ($Colores as $var) {
                    if ($var["COD_COLOR"] == $rows[$i][$nom_columnas['COLOR CODE']]) {
                        $_existe = true; break;
                    };
                }
                if($_existe == false ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }
            }
      }

      /*Validacion PREPACK*/
      if ($val == true) {$tipoVal = 7; $PREPACK = array("CURVADO","SOLIDO");
          for($i = 1;$i <= $limite; $i++){$_existe = false;
                foreach ($PREPACK as $var) {
                    if ($var == $rows[$i][$nom_columnas['PREPACK']]) {
                        $_existe = true; break;
                    };
                }
                if($_existe == false ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }
          }
      }

      /*Validacion Unidades*/
      if ($val == true) {$tipoVal = 8;
            for($i = 1;$i <= $limite; $i++){
                if( $rows[$i][$nom_columnas['TOTAL QUANTITY CL']] == 0     or
                    $rows[$i][$nom_columnas['TOTAL QUANTITY CL']] == null or
                    $rows[$i][$nom_columnas['TOTAL QUANTITY CL']] == ""   or
                    $rows[$i][$nom_columnas['TOTAL QUANTITY CL']] == "0"  or
                    $rows[$i][$nom_columnas['TOTAL QUANTITY CL']] == " "){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }
            }
      }

        /*Validacion Paises*/
      if ($val == true) {$tipoVal = 9;$Paises= plan_compra::list_pais();
            for($i = 1;$i <= $limite; $i++){
                if( $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == null or
                    $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == ""   or
                    $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == "0"  or
                    $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == " "){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }else{
                    $val2 = false;
                    foreach ($Paises as $var){
                        if(strtoupper($var['DESCRIPCION'])== strtoupper($rows[$i][$nom_columnas['COUNTRY OF ORIGIN']])){
                            $val2 = true; break;
                        }
                    }
                    if ($val2 == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    }
                }
            }
      }

        /*Validacion VIA*/
        if ($val == true) {$tipoVal = 10;$VIA= array("MARITIMO","AREA","TERRESTRE");
            for($i = 1;$i <= $limite; $i++){
                if( $rows[$i][$nom_columnas['SHIPMENT MODE']] == null or
                    $rows[$i][$nom_columnas['SHIPMENT MODE']] == ""   or
                    $rows[$i][$nom_columnas['SHIPMENT MODE']] == "0"  or
                    $rows[$i][$nom_columnas['SHIPMENT MODE']] == " "){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }else{
                    $val2 = false;
                    foreach ($VIA as $var){
                        if($var == strtoupper($rows[$i][$nom_columnas['SHIPMENT MODE']])){
                            $val2 = true; break;
                        }
                    }
                    if ($val2 == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    }
                }
            }
        }

        /*Validacion CICLO DE VIDA*/
        if ($val == true) {$tipoVal = 11;$Ciclo_vida= plan_compra::list_ciclo_vida();
            for($i = 1;$i <= $limite; $i++){$val2 = false;
                if ($rows[$i][$nom_columnas['LIFE CICLE']] != null){
                    foreach ($Ciclo_vida as $var) {
                        if ($var['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['LIFE CICLE']])) {
                            $val2 = true; break;
                        }
                    }
                    if ($val2 == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    }
                }
            }
        }

        /*Validacion porcentaje*/
        if ($val == true) {$tipoVal = 12;
            for($i = 1;$i <= $limite; $i++){
                $countTalla= count(explode(",",$rows[$i][$nom_columnas['SIZE']]));
                $SumPorcent = 0;
                for ($x = 1; $x <= $countTalla; $x++){
                    $SumPorcent += $rows[$i][$nom_columnas['Size %'.$x]];
                }
                if (($SumPorcent*100) < 99.9){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }elseif(($SumPorcent*100) > 100.1 ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }
            }
        }

        /*Validacion impusto de costo*/
        if ($val == true) {$tipoVal = 13;
            for($i = 1;$i <= $limite; $i++){
                if(is_numeric($rows[$i][$nom_columnas['RFID COST']])) {
                } else {
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }

                if(is_numeric($rows[$i][$nom_columnas['INSPECTION COST']])) {
                } else {
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                }
            }
        }

        if ($val == false ) {
            if ($tipoVal == 1) {
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> El STYLE NAME no puede ser nulo.");
            }elseif ($tipoVal == 2){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> El PURCHASE GROUP no puede ser nulo.");
            }elseif ($tipoVal == 3){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> El PURCHASE GROUP no se encuentra(n) en el registro de compra.");
            }elseif ($tipoVal == 4){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> El (ID C1) no se encuentra(n) en el registro de compra.");
            }elseif ($tipoVal == 5){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> La ventana no se encuentra(n) en la BD C1.");
            }elseif ($tipoVal == 6){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> El Cod Color no se encuentra(n) en la BD PMM.");
            }elseif ($tipoVal == 7){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> El PREPACK tiene que ser CURVADO o SOLIDO.");
            }elseif ($tipoVal == 8){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> TOTAL QUANTITY CL no puede ser nulo o mayor que 0.");
            }elseif ($tipoVal == 9){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> COUNTRY OF ORIGIN no puede ser nulo o no se encuentra en PMM.");
            }elseif ($tipoVal == 10){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> SHIPMENT MODE no puede ser nulo o no se encuentra en BD C1.");
            }elseif ($tipoVal == 11){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> LIFE CICLE no se encuentra en BD C1.");
            }elseif ($tipoVal == 12){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> La suma de los porcentajes de compras tiene que sumar 100%.");
            }elseif ($tipoVal == 13){
                $array = array('Tipo' => $val,
                    'Error' => "(" . substr($filarow, 0, -1) . ") -> RFID COST o INSPECTION COST tienen que ser datos numéricos.");
            }
      }else{
        $array = array('Tipo' => $val,
        'Error'=> $filarow);
      }

    return  $array;
    }
    public static function Distinct_Grupo_Compra($rows,$limite,$nom_columnas){

        $dtgrup = [];
        for($i = 1;$i <= $limite; $i++){
            if ($rows[$i][$nom_columnas['PURCHASE GROUP']]!= null){
                array_push($dtgrup,$rows[$i][$nom_columnas['PURCHASE GROUP']] );
            }
        }
        //distinct de un array ()
        $dtgrup = array_unique($dtgrup);
        return $dtgrup;
    }





#endregion;

}