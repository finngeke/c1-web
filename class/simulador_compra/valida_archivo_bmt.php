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
                foreach ($dtjerarquia as $var  )  {
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
    public static function Val_Campos($rows,$limite,$nom_columnas,$cod_tempo,$depto,$f3,$nom_temporada){
        $filarow = "";
        $val = TRUE;
        $tipotemp = substr($nom_temporada,0,2);
        $msj = "";
        $dtTemp =[];$tipoVal = 1;/*Validacion temporada pv O OI*/
        if ($tipotemp == "OI"){
            $dtTemp = array("CL - INVIERNO","CL - OTOÑO","CL - TODA TEMPORADA");
            $msj ="CL - INVIERNO, CL - OTOÑO o CL - TODA TEMPORADA";
        }
        else{
            $dtTemp = array("CL - PRIMAVERA","CL - VERANO","CL - TODA TEMPORADA");
            $msj ="CL - INVIERNO, CL - OTOÑO o CL - TODA TEMPORADA";
        }

        for ($i = 3;$i <= $limite; $i++) {
            $val2 = false;
            foreach ($dtTemp as $var)  {
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
        }}//2 Validacion ciclo de vida
        if ($val == TRUE) {
            /*Validacion RNK VTA */ $tipoVal = 3; $dtrnkventa = plan_compra::list_rnk($f3);
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
        }}//3 Validacion RNK VTA
        if ($val == TRUE) {
            /*validacion clusterI*/ $tipoVal = 23;
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                if ($rows[$i][$nom_columnas['ClusterI']] == null or $rows[$i][$nom_columnas['ClusterI']] == "0" )  {
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }}//4 validacion clusterI no null
        if ($val == TRUE) {
            /*Validacion PIRAMIDE MIX */ $tipoVal = 4; $dtpiramidemix = plan_compra::list_piramidemix($f3);
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
            }}//23 Validacion PIRAMIDE MIX
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
            }}//5 Validacion cluster
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
            }}//7 Validacion via
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
            }}//8 Validacion pais
        if ($val == TRUE) {
            /*Validacion Ventana */ $tipoVal = 9; $ventanas = array("A","B","C","D","E","F","G","H","I");
            for($i = 3;$i <= $limite; $i++){
                $val2 = false;
                    foreach ($ventanas as $var)  {
                        if ($var == strtoupper($rows[$i][$nom_columnas['Ventana']])) {
                            $val2 = true;break;
                        };
                    }
                    if ($val2 == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
            }}//9 Validacion Ventana
        if ($val == TRUE) {
            /*Validacion Precio Blanco null*/ $tipoVal = 18;
            for($i = 3;$i <= $limite; $i++){
                $val2 = true;
                if (is_null($rows[$i][$nom_columnas['Precio']]) == true or $rows[$i][$nom_columnas['Precio']] == 0 or $rows[$i][$nom_columnas['Precio']] == " ") {
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }}//Validacion Precio Blanco null
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
            }}//Validacion Precio Blanco
        if ($val == TRUE) {
            /*Validacion debut reorder*/ $tipoVal = 25;
            for($i = 3;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['Debut o Reorder']] == "DEBUT" or $rows[$i][$nom_columnas['Debut o Reorder']]== "REORDER") {
                }else{
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }}//Validacion debut reorder
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
            }}//Validacion Tallas y Curvas
        if ($val == TRUE) {
            /*Validacion tipo empaque*/ $tipoVal = 12;
            for($i = 3;$i <= $limite; $i++){
                    if (strtoupper($rows[$i][$nom_columnas['Tipo de empaque']]) == "SOLIDO" or strtoupper($rows[$i][$nom_columnas['Tipo de empaque']])== "CURVADO") {
                    }else{
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
            }}//Validacion tipo empaque
        if ($val == TRUE) {
            /*Validacion tipo empaque no los reordes*/ $tipoVal = 24;
            for($i = 3;$i <= $limite; $i++){
                if($rows[$i][$nom_columnas['Debut o Reorder']] == "REORDER" and  $rows[$i][$nom_columnas['Tipo de empaque']] == "CURVADO"){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }}//Validacion tipo empaque no los reordes
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
                        if(floor($rows[$i][$nom_columnas['Size%'.$x]]) == 0 or floor($rows[$i][$nom_columnas['Size%'.$x]]) == 1) {
                            array_push($arraypocentaje, round(($rows[$i][$nom_columnas['Size%' . $x]] * 100), 3));
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

            }}//Validacion porcentaje
        if ($val == TRUE) {
            /*Validacion de Unidades*/ $tipoVal = 14;
            for($i = 3;$i <= $limite; $i++){
                $ventana =  $rows[$i][$nom_columnas['Ventana']] ;

                if ($rows[$i][$nom_columnas['UNIDADES']] == null or
                    $rows[$i][$nom_columnas['UNIDADES']] == "0" or
                    $rows[$i][$nom_columnas['UNIDADES']] == "") {
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }

            }}//Validacion de Unidades
        if ($val == TRUE) {
            /*Validacion short name vacios*/ $tipoVal = 15;
            for($i = 3;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['Estilo Corto']] == null or
                    $rows[$i][$nom_columnas['Estilo Corto']] == "0" or
                    $rows[$i][$nom_columnas['Estilo Corto']] == "") {
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }}//Validacion short name vacios
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
        }//Validacion tdas por cluster
        if ($val == TRUE) {
            /*Validacion tdas por formatos*/ $tipoVal = 18;
            $dtclusterformarto = [];
            //-guarda todos cluster -formato
            for($i = 3;$i <= $limite; $i++){
                $_exis = false;
                if (is_null($rows[$i][$nom_columnas['Formato']]) <> true and $rows[$i][$nom_columnas['Formato']] <> " " and $rows[$i][$nom_columnas['Formato']] <> "0" ){
                    foreach ($dtclusterformarto as $v ){
                        if ($v[0] == $rows[$i][$nom_columnas['Formato']] and $v[1] = $rows[$i][$nom_columnas['Cluster']]){
                            $_exis = true;break;
                        }
                    }
                    if($_exis == false){
                        array_push($dtclusterformarto, array($rows[$i][$nom_columnas['Formato']],$rows[$i][$nom_columnas['Cluster']],$rows[$i][$nom_columnas['Codigo Marca']]));
                    }
                }
            }
            if (count($dtclusterformarto) <> 0 ){
                foreach ($dtclusterformarto as $v2) {
                    $ntdas = plan_compra::list_tdas_con_formato($depto, $v2[2], $cod_tempo, strtoupper($v2[1]), strtoupper($v2[0]));
                    if ($ntdas['TIENDAS'] == 0) {
                        $val = FALSE;
                        $filarow = $filarow . "[" . $v2[1] . "/" . $v2[0] . "],";
                    }
                }
             }
        }//Validacion tdas por formatos
        if ($val == TRUE) {
            /*validacion del inner en blanco*/ $tipoVal = 19;
            for($i = 3;$i <= $limite; $i++){
                if (is_null($rows[$i][$nom_columnas['Inner']]) == true or $rows[$i][$nom_columnas['Inner']] == "" or  $rows[$i][$nom_columnas['Inner']] == "0" ){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }
        }//validacion del inner en blanco
        if ($val == TRUE) {
            /*validacion del inner suma por curva */ $tipoVal = 20;
            for($i = 3;$i <= $limite; $i++){
                $n_tallas = 0;
                for ($r = 1;$r <= 9; $r++){
                    if((is_null($rows[$i][$nom_columnas['Talla'.$r]]) <> true) and ($rows[$i][$nom_columnas['Talla'.$r]] <> "0")){
                        $n_tallas++;
                    }
                }

                $sum_curva = 0;
                for ($x =1;$x <= $n_tallas;$x++ ){
                    if(is_null($rows[$i][$nom_columnas['Curva'.$x]]) <> true){
                        $sum_curva = ($sum_curva + $rows[$i][$nom_columnas['Curva'.$x]]);
                    }
                }

                if ($sum_curva <> $rows[$i][$nom_columnas['Inner']] ){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";

                }
            }
        }//validacion del inner suma por curva
        if ($val == TRUE) {
            /*validacion del n° por cajas no puede estar null */$tipoVal = 21;
            for($i = 3;$i <= $limite; $i++){
                if (is_null($rows[$i][$nom_columnas['N curvas por caja curvadas']]) == true ){
                    $val = FALSE;
                    $filarow = $filarow . strval($i + 1) . ",";
                }
            }
        }//validacion del n° por cajas no puede estar null
        if ($val == TRUE) {
            /*validacion del n° por cajas no puede tener en un solido */$tipoVal = 22;
            for($i = 3;$i <= $limite; $i++){
               if ((strtoupper($rows[$i][$nom_columnas['Tipo de empaque']]) == "SOLIDO") and ($rows[$i][$nom_columnas['N curvas por caja curvadas']] > 0) ){
                   $val = FALSE;
                   $filarow = $filarow . strval($i + 1) . ",";
               }
            }
        }//validacion del n° por cajas no puede tener en un solido
        if ($val == TRUE) {
            /*Validacion fecha acordada*/ $tipoVal = 26;
            for($i = 3;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['Fecha de Embarque Acordada']] <> null or $rows[$i][$nom_columnas['Fecha de Embarque Acordada']]<> "") {
                    $fecha = str_replace("-","/",$rows[$i][$nom_columnas['Fecha de Embarque Acordada']]);
                    $dtfecha = explode('/', $fecha);
                    if (count($dtfecha)== 3){
                        if (is_numeric($dtfecha[0]) == false or is_numeric($dtfecha[1]) == false or is_numeric($dtfecha[2]) == false){
                            $val = FALSE;
                            $filarow = $filarow . strval($i + 1) . ",";
                        }else{
                            if (checkdate($dtfecha[1], $dtfecha[0], $dtfecha[2]) == false){
                                $val = FALSE;
                                $filarow = $filarow . strval($i + 1) . ",";
                            }
                        }
                    }else{
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }
        }//Validacion fecha acordada
        if ($val == TRUE) {
            /*Validacion evento*/ $tipoVal = 27;
            for($i = 3;$i <= $limite; $i++){
                if($rows[$i][$nom_columnas['Evento']] <> NULL and $rows[$i][$nom_columnas['Evento']] <> ''){
                    //$eventos = "MADRE,PADRE,NINO,NVIDAD\"; $dtevento = explode(\",\", $eventos)A;
                    $dtevento = plan_compra::List_Eventos();
                    $_exs = false;
                    foreach ($dtevento as $valor){
                        if ($valor['NOM_EVENTO'] == strtoupper($rows[$i][$nom_columnas['Evento']])){
                            $_exs = true; break;
                        }
                    }
                    if($_exs == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }
        }//Validacion evento
        if ($val == TRUE) {
            /*Validacion estilo de vida*/$tipoVal = 28;
            $dt = plan_compra::list_estiloVida();
            for($i = 3;$i <= $limite; $i++){
                if($rows[$i][$nom_columnas['Estilo de Vida']] <> NULL and $rows[$i][$nom_columnas['Estilo de Vida']] <> ''){
                    $_exs = false;
                    foreach ($dt as $var2){
                        if ($var2['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Estilo de Vida']])){
                            $_exs = true; break;
                        }
                    }
                    if($_exs == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }

        }//Validacion estilo de vida*
        if ($val == TRUE) {/*Validacion ocacion de uso*/$tipoVal = 29;
            $dt = plan_compra::list_ocacionuso();
            for($i = 3;$i <= $limite; $i++){
                if($rows[$i][$nom_columnas['Ocasion de uso']] <> NULL and $rows[$i][$nom_columnas['Ocasion de uso']] <> ''){
                    $_exs = false;
                    foreach ($dt as $var){
                        if ($var['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Ocasion de uso']])){
                            $_exs = true; break;
                        }
                    }
                    if($_exs == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }
        }//Validacion ocacion de uso
        if ($val == TRUE) {/*Validacion calidad*/$tipoVal = 30;
            $dt = plan_compra::list_calidad();
            for($i = 3;$i <= $limite; $i++){
                if($rows[$i][$nom_columnas['Calidad']] <> NULL and $rows[$i][$nom_columnas['Calidad']] <> ''){
                    $_exs = false;
                    foreach ($dt as $var){
                        if ($var['DESCRIPCION'] == strtoupper($rows[$i][$nom_columnas['Calidad']])){
                            $_exs = true; break;
                        }
                    }
                    if($_exs == false){
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }
            }
        }//Validacion calidad
         if ($val == TRUE) {/*Validacion combinacion fob&Proveedor debe tener datos*/$tipoVal = 31;
            for($i = 3;$i <= $limite; $i++){
                $_v = true;
                if($rows[$i][$nom_columnas['FOB USD']] <> null and $rows[$i][$nom_columnas['FOB USD']] <> 0) {
                    if (is_null($rows[$i][$nom_columnas['Proveedor']]) or ($rows[$i][$nom_columnas['Proveedor']] == '0')) {
                        $_v = false;
                        $val = FALSE;
                        $filarow = $filarow . strval($i + 1) . ",";
                    }
                }

                if ($_v == true){
                    if($rows[$i][$nom_columnas['Proveedor']] <> null and $rows[$i][$nom_columnas['Proveedor']] <> '0'){
                        if (is_null($rows[$i][$nom_columnas['FOB USD']]) or $rows[$i][$nom_columnas['FOB USD']] == '0') {
                            $val = FALSE;
                            $filarow = $filarow . strval($i + 1) . ",";
                        }
                    }
                }
            }
        }//Validacion combinacion fob&Proveedor debe tener datos


        if ($val == FALSE ) {
            if ($tipoVal == 1){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") -> La temporada del producto '".$tipotemp."' tiene que ser = ". $msj.".");
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
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El tipo empaque no encuentran bd C1.Ej(SOLIDO o CURVADO)");
            }
            elseif ($tipoVal == 13){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.Las cantidades de porcentajes no cuadran con las cantidades de tallas o la suma de los porcentajes son mayor o menor 100%.");
            }
            elseif ($tipoVal == 14){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.Las unidades no deben estar en 0.");
            }
            elseif ($tipoVal == 15){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.El estilo corto no debe estar en blanco.");
            }
            elseif ($tipoVal == 17){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->.No existen tdas configurada por clúster.");
            }
            elseif ($tipoVal == 18){
                $array = array('Tipo' => $val,
                    'Error'=> "(".$filarow.") ->.No hay intersección de tdas en cluster - formato.");
            }
            elseif ($tipoVal == 19){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El inner no puede estar en blanco o en 0.");
            }
            elseif ($tipoVal == 20){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->La suma de las curvas no corresponde al número de inner.");
            }
            elseif ($tipoVal == 21){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->N° curvas por cajas curvadas no puede estar nulo o en blanco, tiene que ser un valor númerico.");
            }
            elseif ($tipoVal == 22){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El tipo de empaque Sólido no puede tener N° curvas por cajas curvadas, deben estar en '0'.");
            }
            elseif ($tipoVal == 23){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El ClusterI no debe ser nulo o no debe esta en 0.");
            }
            elseif ($tipoVal == 24){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->Los Reorder's tiene un tipo de empaque Curvados.");
            }
            elseif ($tipoVal == 25){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El campo [Debut o Reorder] esta vacío o no se encuentra bd C1.");
            }
            elseif ($tipoVal == 26){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->El campo [Fecha de Embarque Acordada] el formato es incorrecto.Ej (dd/mm/yyyy o dd-mm-yyyy)");
            }
            elseif ($tipoVal == 27){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->Evento(s) no encuentrado(s) BD C1.");
            }
            elseif ($tipoVal == 28){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->Estilo de Vida no encuentran BD C1. Ej: TRADICIONAL,NEO TRADICIONAL
                                                                            ,NEO CASUAL,BOHEMIAN ROMANTIC,GLAMOUR,MAINSTREAM,TRENDY,ROMANTICO,CLUBER,ECO VINTAGE
                                                                            ,URBEN,SURF.");
            }
            elseif ($tipoVal == 29){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->Ocacion de uso no encuentran BD C1. Ej: 7/7 DRESS UP,7/7 DRESS DOWN,NIGHT
                                                                            ,CITY,WEEKEND.");
            }
            elseif ($tipoVal == 30){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->Calidad no encuentran BD C1. Ej: GOOD,BETTER,BEST.");
            }
            elseif ($tipoVal == 31){
                $array = array('Tipo' => $val,
                    'Error'=> "(".substr($filarow, 0, - 1).") ->La combinación FOB/PROOVEEDOR deben tener datos.");
            }
        }
        else{
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
    public static function val_grupo_compra_x_estado($cod_tempo,$depto,$grupo_compra,$marca){
    $plan = plan_compra::list_plan_compraxgrupo($cod_tempo,$depto,$grupo_compra,$marca);
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

    public static function eliminardatosrows2($rows,$limite,$nom_columnas){
        $val_delete = "";



        for($i = 0;$i <= $limite; $i++){
            if($i < 2) {
                $val_delete = $val_delete . $i . ",";
            }else{
            if ($rows[$i][$nom_columnas['Cod Linea']] == null or
                $rows[$i][$nom_columnas['Cod Sublinea']] ==  null or
                $rows[$i][$nom_columnas['Nombre Estilo']] ==  null or
                $rows[$i][$nom_columnas['Cod Color']] ==  null or
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

    public static function eliminardatosrows($rows,$limite){
        $val_delete = "";
        for($i = 0;$i <= $limite; $i++){
            if($i < 2) {
                $val_delete = $val_delete . $i . ",";
            }else{
            if ($rows[$i]['Cod Linea'] == null or
                $rows[$i]['Cod Sublinea']==  null or
                $rows[$i]['Nombre Estilo'] ==  null or
                $rows[$i]['Cod Color']==  null or
                $rows[$i]['Cod Dpto']==  null) {
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
    public static function Separacion_Data_Ventana2($rows,$nom_columnas,$cod_tempo,$depto){

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
        $dtplan_compra =  plan_compra::list_plan_compra_debut($cod_tempo,$depto,$rows[1][$nom_columnas["Grupo de compra"]]);


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
                                $_existedebut = valida_archivo_bmt::Valida_existe_debutDepto($dtplan_compra,$val2[$nom_columnas["Cod Linea"]]
                                                                                             ,$val2[$nom_columnas["Cod Sublinea"]]
                                                                                             ,$val2[$nom_columnas["Nombre Estilo"]]
                                                                                             ,$val2[$nom_columnas["Cod Color"]]);
                                if ($_existedebut == true){
                                    $debut ="REORDER";
                                }else{
                                    $debut ="DEBUT";
                                }
                            }
                            if($debut == "DEBUT"){
                                $ciclovida =$val2[$nom_columnas["Ciclo de Vida"]];
                            }
                            if($debut == "DEBUT" and strtoupper($val2[$nom_columnas["Tipo de empaque"]]) == strtoupper("Curvado")){
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
                                , $val2[$nom_columnas["Cod Opcion"]]
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


    public static function Limpieza_data_Assortment($rows,$limite){
        $dt1 = plan_compra::list_ocacionuso();
        $dt2 = plan_compra::list_estiloVida();
        $dt3 = plan_compra::list_calidad();
        for($i = 0;$i <= $limite; $i++){
            if($i<>0) {
                $debut = strtoupper($rows[$i]["Debut o Reorder"]);
                $rows[$i]["Cluster"] = valida_archivo_bmt::Valida_DEBUT_REORDER($rows[$i]["Cluster"], $debut, "CLUSTER");
                $rows[$i]["Formato"] = valida_archivo_bmt::Valida_DEBUT_REORDER($rows[$i]["Formato"], $debut, "FORMATO");
                $rows[$i]["Target USD"] = ($rows[$i]["Target USD"] <> null ? ($rows[$i]["Target USD"]) : 0);
                $rows[$i]["FOB USD"] = ($rows[$i]["FOB USD"] <> null ? ($rows[$i]["FOB USD"]) : 0);
                $rows[$i]["RFID USD"] = ($rows[$i]["RFID USD"] <> null ? ($rows[$i]["RFID USD"]) : 0);
                $rows[$i]["ClusterA"] = valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i]["ClusterA"], $debut);
                $rows[$i]["ClusterB"] = valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i]["ClusterB"], $debut);
                $rows[$i]["ClusterC"] = valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i]["ClusterC"], $debut);
                $rows[$i]["ClusterI"] = valida_archivo_bmt::ValidaCurvasxtdasDebut($rows[$i]["ClusterI"], $debut);
                $rows[$i]["cod_estilo_vida"] = plan_compra::get_codEstilovida($rows[$i]["Estilo de Vida"],$dt2);
                $rows[$i]["cod_ocacion_uso"] = plan_compra::get_codocacionuso($rows[$i]["Ocasion de uso"],$dt1);
                $rows[$i]["cod_calidad"] = plan_compra::get_calidad($rows[$i]["Calidad"],$dt3);
            }
        }
        return $rows;
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
    public static function Valida_existe_debutDepto($dt_plan,$linea,$sublinea,$estilo,$color){

        $_exist = false; $k = 0;
        foreach ($dt_plan as $val){
            if (($val["LINEA"] == $linea) and
                 ($val["COD_SUBLIN"] == $sublinea) and
                 (strtoupper($val["DES_ESTILO"]) == strtoupper($estilo)) and
                 ($val["COD_COLOR"]== $color) ){
                  $_exist = true;
                    $k = 1;
                   break;
            }
        }
        return $_exist;
    }
    public static function ValidaCodCorporativo($rows,$limite,$nom_columnas,$temporada,$coddepto,$cod_temporada)
    {
        $val3 = TRUE;
        $_Errorfile = "";
        $tipoVal = 1;
        $_mensaje = [];
        $dtexcel = [];
        $OpcNotExistetemp = [];
        $OpcNotExistenuevo = [];

        /*Validacion CodCorporativo 10 caracteres*/
        $tipoVal = 1;
        for ($i = 3; $i <= $limite; $i++) {
            array_push($dtexcel, array("Grupo de compra" => $rows[$i][$nom_columnas['Grupo de compra']],
                "Cod Linea" => $rows[$i][$nom_columnas['Cod Linea']],
                "Cod Sublinea" => $rows[$i][$nom_columnas['Cod Sublinea']],
                "Nombre Estilo" => $rows[$i][$nom_columnas['Nombre Estilo']],
                "Codigo corporativo" => $rows[$i][$nom_columnas['Codigo corporativo']]));
            if ($rows[$i][$nom_columnas['Codigo corporativo']] <> null or
                $rows[$i][$nom_columnas['Codigo corporativo']] <> "0" or
                $rows[$i][$nom_columnas['Codigo corporativo']] <> "") {

                if (strlen($rows[$i][$nom_columnas['Codigo corporativo']]) > 10) {
                   $val = FALSE;
                    $_Errorfile = $_Errorfile . ($i + 1) . ",";
                }
            }
        }

        /*
        //2.-validacion de CodCorporativo x BD los codigos sean iguales en todas las temporadas.
        if ($val3 == true){$tipoVal = 2;
            $msj = "";
            $dtdistinct =  array_unique($dtexcel, SORT_REGULAR);$dtrepeat =[];

            foreach ($dtdistinct as $mae){
                $repeat= false;
                foreach ($dtrepeat as $v){
                    if (($mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Codigo corporativo'])== $v){
                        $repeat = true; break;
                    }
                }
                if ($repeat == false){
                    $dtcodpor =  plan_compra::get_codcorporativo_porestilo($cod_temporada
                        ,$coddepto
                        ,$mae['Grupo de compra']
                        ,$mae['Cod Linea']
                        ,$mae['Cod Sublinea']
                        ,$mae['Nombre Estilo']);

                    if(count($dtcodpor) > 0){
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Codigo corporativo']);
                        if($mae['Codigo corporativo'] <> $dtcodpor[0]['COD_CORPORATIVO']){
                            $val3 = false;
                            $msj = $msj."|->(".$mae['Cod Linea'].",".$mae['Cod Sublinea'].",".$mae['Nombre Estilo']."(".$mae['Codigo corporativo'].")=".$dtcodpor[0]['COD_CORPORATIVO'].")";
                        }
                    }else{
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Codigo corporativo']);
                        array_push($OpcNotExistetemp,array("Grupo de compra"=>$mae['Grupo de compra'],
                                                                "Cod Linea"    =>$mae['Cod Linea'],
                                                                "Cod Sublinea" =>$mae['Cod Sublinea'],
                                                                "Nombre Estilo"=>$mae['Nombre Estilo'],
                                                                "Codigo corporativo" =>$mae['Codigo corporativo']));
                    }
                }
            }
        }

        //3.-validacion de CodCorporativo x BD ya se encuentra ocupada por otra CodCorporativo.
        if ($val3 == TRUE){$tipoVal = 3;
            $msj= "";$dtrepeat =[];
            foreach ($OpcNotExistetemp as $mae){
                $repeat= false;
                foreach ($dtrepeat as $v){
                    if (($mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Codigo corporativo'])== $v){
                        $repeat = true; break;
                    }
                }
                if ($repeat == false) {
                    $dtcodpor = plan_compra::get_codcorporativo_porjerarquia($cod_temporada
                        , $coddepto
                        , $mae['Grupo de compra']
                        , $mae['Codigo corporativo']);

                    if (count($dtcodpor) > 0) {
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Codigo corporativo']);
                        if ($mae['Cod Linea'] <> $dtcodpor[0]['COD_JER2'] or
                            $mae['Cod Sublinea'] <> $dtcodpor[0]['COD_SUBLIN'] or
                            $mae['Nombre Estilo'] <> $dtcodpor[0]['DES_ESTILO']) {
                            $val3 = false;
                            $msj = $msj . $mae['Codigo corporativo'] . ",";
                        }
                    } else {
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Codigo corporativo']);
                        array_push($OpcNotExistenuevo, array("Grupo de compra" => $mae['Grupo de compra'],
                            "Cod Linea" => $mae['Cod Linea'],
                            "Cod Sublinea" => $mae['Cod Sublinea'],
                            "Nombre Estilo" => $mae['Nombre Estilo'],
                            "Codigo corporativo" => $mae['Codigo corporativo']));
                    }
                }
            }
        }
*/
        //4.-validacion de CodCorporativo en el excel lo que son nuevos.
        if ($val3 == TRUE) {
            $tipoVal = 4;
            $msj = "";
            $dt = [];
            foreach ($dtexcel as $mae) {
                $_existe = 0;
                $paso = false;
                foreach ($dt as $vat) {
                    if ($mae['Codigo corporativo'] == $vat) {
                        $paso = true;
                    }
                }
                if ($paso == false) {
                    foreach ($dtexcel as $d) {
                        if ($mae['Codigo corporativo'] == $d['Codigo corporativo']) {
                            if ($mae['Cod Linea'] <> $d['Cod Linea'] or
                                $mae['Cod Sublinea']  <> $d['Cod Sublinea']  or
                                $mae['Nombre Estilo'] <> $d['Nombre Estilo']) {
                                $_existe++;
                            }
                        }
                    }
                    if ($_existe > 0) {
                        array_push($dt, $mae['Codigo corporativo']);
                        $val3 = false;
                        $msj = $msj . $mae['Codigo corporativo'] . ",";
                    } else {
                        array_push($dt, $mae['Codigo corporativo']);
                    }
                }
            }
        }
        //4.-validacion de mismas opciones con distintas cod_corporativo.
        if ($val3 == TRUE) {$tipoVal = 5;$msj = "";
            $dt = [];
            foreach ($dtexcel as $mae) {$_existe = 0;
                $paso = false;
                foreach ($dt as $vat) {
                    if ($mae['Cod Linea'] == $vat[0] and
                        $mae['Cod Sublinea'] == $vat[1] and
                        $mae['Nombre Estilo'] == $vat[2]) {
                        if ($mae['Codigo corporativo'] <> $vat[3]) {
                            $msj = $msj . $mae['Codigo corporativo'] . ",";
                        }
                        $paso = true;
                    }
                }
                if ($paso == false) {
                    foreach ($dtexcel as $d) {
                        if ($mae['Cod Linea'] == $d['Cod Linea'] and
                            $mae['Cod Sublinea'] == $d['Cod Sublinea'] and
                            $mae['Nombre Estilo'] == $d['Nombre Estilo']) {
                            if ($mae['Codigo corporativo'] <> $d['Codigo corporativo']) {
                                $_existe++;
                            }
                        }
                    }
                    if ($_existe > 0) {
                        array_push($dt, array($mae['Cod Linea'], $mae['Cod Sublinea'], $mae['Nombre Estilo'], $mae['Codigo corporativo']));
                        $val3 = false;
                        $msj = $msj . $mae['Codigo corporativo'] . ",";
                    } else {
                        array_push($dt, array($mae['Cod Linea'], $mae['Cod Sublinea'], $mae['Nombre Estilo'], $mae['Codigo corporativo']));
                    }
                }
            }
        }

        if ($val3 == false) {
            if ($tipoVal == 1) {
                $_mensaje = array('Tipo' => $val3,
                    'Error' => "(" . substr($_Errorfile, 0, -1) . ") ->.El Código corporativo tiene que ser máximo 10 caracteres.");
            } elseif ($tipoVal == 2) {
                $_mensaje = array('Tipo' => $val3,
                    'Error' => "Los siguientes estilos ya tienen código corporativo:" . $msj);
            } elseif ($tipoVal == 3) {
                $_mensaje = array('Tipo' => $val3,
                    'Error' => "Los siguientes códigos corporativos ya se encuentran utilizados por otros estilos:" . $msj);
            } elseif ($tipoVal == 4) {
                $_mensaje = array('Tipo' => $val3,
                    'Error' => "Códigos Corporativos duplicados en diferentes estilos:" . $msj);
            } elseif ($tipoVal == 5) {
                $_mensaje = array('Tipo' => $val3,
                    'Error' => "Distintos códigos corporativos en el mismo estilo:" . $msj);
            } else {
                $_mensaje = array('Tipo' => $val3,
                    'Error' => $_Errorfile);
            }
        }else{
            $_mensaje = array('Tipo' => $val3,
                'Error'=> $_Errorfile);
        }
        return  $_mensaje;
    }
    public static function ValidaCodOpcion($rows,$limite,$nom_columnas,$temporada,$coddepto,$cod_temporada){
        $val3 = TRUE;
        $_Errorfile = "";
        $tipoVal = 1;
        $_mensaje = [];
        $dtexcel= [];
        $OpcNotExistetemp = [];
        $OpcNotExistenuevo = [];

        //1.-validacion de num opcion en blanco
        for($i = 3;$i <= $limite; $i++) {
            array_push($dtexcel,array("Grupo de compra"=>$rows[$i][$nom_columnas['Grupo de compra']],
                                        "Cod Linea"=>$rows[$i][$nom_columnas['Cod Linea']],
                                        "Cod Sublinea"=>$rows[$i][$nom_columnas['Cod Sublinea']],
                                        "Nombre Estilo"=>$rows[$i][$nom_columnas['Nombre Estilo']],
                                        "Cod Color"=>$rows[$i][$nom_columnas['Cod Color']],
                                        "Cod Opcion"=>$rows[$i][$nom_columnas['Cod Opcion']]));

            if (is_null($rows[$i][$nom_columnas['Cod Opcion']])== true or
                $rows[$i][$nom_columnas['Cod Opcion']] == ""  or
                $rows[$i][$nom_columnas['Cod Opcion']] == " " or
                $rows[$i][$nom_columnas['Cod Opcion']] == "0") {

                $_Errorfile = $_Errorfile.($i+1) .",";
                $val3 = false;
            }
        }

        //2.-validacion 12 caracteres
        if ($val3 == TRUE){$tipoVal = 2; $_Errorfile = "";
            for($i = 3;$i <= $limite; $i++){

                if (strlen($rows[$i][$nom_columnas['Cod Opcion']]) <> 12){
                    $_Errorfile = $_Errorfile . ($i + 1) . ",";
                    $val3 = false;
                }
            }
        }

        //3.-validacion de SUBSTRING FW Y SS
        if ($val3 == TRUE){$tipoVal = 3;$_Errorfile = "";
            $_temp = "";
           if (substr($temporada, 0, 2) == "PV"){
               $_temp = "SS";
           }else{
               $_temp = "FW";
           }
            for($i = 3;$i <= $limite; $i++){
               $_FWSS = substr($rows[$i][$nom_columnas['Cod Opcion']], 0, 2);
                IF($_temp <> $_FWSS){
                    $_Errorfile = $_Errorfile.($i+1) .",";
                    $val3 = false;
                }
            }
        }

        /*
        //4.-validacion de codigo de opcion x BD los codigos sean igual.
        if ($val3 == true){$tipoVal = 4;
            $msj = "";
            $dtdistinct =  array_unique($dtexcel, SORT_REGULAR);$dtrepeat =[];
            foreach ($dtdistinct as $mae){
                $repeat= false;
                foreach ($dtrepeat as $v){
                    if (($mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Cod Color'].$mae['Cod Opcion'])== $v){
                        $repeat = true; break;
                    }
                }
                if ($repeat == false) {
                    $dtnumop = plan_compra::get_codopcion_poropcion($cod_temporada
                        , $coddepto
                        , $mae['Grupo de compra']
                        , $mae['Cod Linea']
                        , $mae['Cod Sublinea']
                        , $mae['Nombre Estilo']
                        , $mae['Cod Color']);

                    if (count($dtnumop) > 0) {
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Cod Color'].$mae['Cod Opcion']);
                        if ($mae['Cod Opcion'] <> $dtnumop[0]['COD_OPCION']) {
                            $val3 = false;
                            $msj = $msj . "|->(" . $mae['Cod Linea'] . "," . $mae['Cod Sublinea'] . "," . $mae['Nombre Estilo'] . "," . $mae['Cod Color']."(" .$mae['Cod Opcion']. ")=" . $dtnumop[0]['COD_OPCION'] . ")";
                        }
                    } else {
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Cod Color'].$mae['Cod Opcion']);
                        array_push($OpcNotExistetemp, array("Grupo de compra" => $mae['Grupo de compra'],
                            "Cod Linea" => $mae['Cod Linea'],
                            "Cod Sublinea" => $mae['Cod Sublinea'],
                            "Nombre Estilo" => $mae['Nombre Estilo'],
                            "Cod Color" => $mae['Cod Color'],
                            "Cod Opcion" => $mae['Cod Opcion']));
                    }
                }
            }
        }

        //5.-validacion de codigo de opcion x BD ya se encuentra ocupada por otra opcion.
        if ($val3 == TRUE){$tipoVal = 5;
            $msj= "";$dtrepeat =[];
            foreach ($OpcNotExistetemp as $mae){
                $repeat= false;
                foreach ($dtrepeat as $v){
                    if (($mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Cod Color'].$mae['Cod Opcion'])== $v){
                        $repeat = true; break;
                    }
                }
                if ($repeat == false) {
                    $dtnumop = plan_compra::get_codopcion_porjerarquia($cod_temporada
                        , $coddepto
                        , $mae['Grupo de compra']
                        , $mae['Cod Opcion']);
                    if (count($dtnumop) > 0) {
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Cod Color'].$mae['Cod Opcion']);
                        if ($mae['Cod Linea'] <> $dtnumop[0]['COD_JER2'] or
                            $mae['Cod Sublinea'] <> $dtnumop[0]['COD_SUBLIN'] or
                            $mae['Nombre Estilo'] <> $dtnumop[0]['DES_ESTILO'] or
                            $mae['Cod Color'] <> $dtnumop[0]['COD_COLOR']) {
                            $val3 = false;
                            $msj = $msj . $mae['Cod Opcion'] . ",";
                        }
                    } else {
                        array_push($dtrepeat,$mae['Cod Linea'].$mae['Cod Sublinea'].$mae['Nombre Estilo'].$mae['Cod Color'].$mae['Cod Opcion']);
                        array_push($OpcNotExistenuevo, array("Grupo de compra" => $mae['Grupo de compra'],
                            "Cod Linea" => $mae['Cod Linea'],
                            "Cod Sublinea" => $mae['Cod Sublinea'],
                            "Nombre Estilo" => $mae['Nombre Estilo'],
                            "Cod Color" => $mae['Cod Color'],
                            "Cod Opcion" => $mae['Cod Opcion']));
                    }
                }
            }
        }
        */


        //6.-validacion de mismas opciones con distintas codigo opciones
        if ($val3 == TRUE) {$tipoVal = 6;$msj= "";
            $dt=[];
            foreach ($dtexcel as $mae){
                $_existe = 0; $paso = false;
                foreach ($dt as $vat){
                    if($mae['Cod Opcion']== $vat){
                        $paso = true;
                    }
                }
                if($paso == false){
                    foreach ($dtexcel as $d){
                        if($mae['Cod Opcion']==$d['Cod Opcion']){
                            if($mae['Cod Linea']      <> $d['Cod Linea']     or
                                $mae['Cod Sublinea']  <> $d['Cod Sublinea']  or
                                $mae['Nombre Estilo'] <> $d['Nombre Estilo'] or
                                $mae['Cod Color']     <> $d['Cod Color']  ){
                                $_existe++;
                            }
                        }
                    }
                    if ($_existe > 0){
                        array_push($dt,$mae['Cod Opcion']);
                        $val3 = false;
                        $msj = $msj.$mae['Cod Opcion'].",";
                    }else{
                        array_push($dt,$mae['Cod Opcion']);
                    }
                }
            }
        }

        if ($val3 == TRUE) {$tipoVal = 7;$msj= "";
            $dt=[];
            foreach ($dtexcel as $mae){
                $_existe = 0; $paso = false;
                foreach ($dt as $vat){
                    if($mae['Cod Linea']    == $vat[0] and
                       $mae['Cod Sublinea'] == $vat[1] and
                       $mae['Nombre Estilo']== $vat[2] and
                       $mae['Cod Color']    == $vat[3]){

                        if($mae['Cod Opcion'] <> $vat[4]){
                            $msj = $msj.$mae['Cod Opcion'].",";
                        }
                        $paso = true;
                    }
                }
                if($paso == false){
                    foreach ($dtexcel as $d){
                        if($mae['Cod Linea']     == $d['Cod Linea']     and
                           $mae['Cod Sublinea']  == $d['Cod Sublinea']  and
                           $mae['Nombre Estilo'] == $d['Nombre Estilo'] and
                           $mae['Cod Color']     == $d['Cod Color']){
                            if($mae['Cod Opcion'] <> $d['Cod Opcion']){
                                $_existe++;
                            }
                        }
                    }
                    if ($_existe > 0){
                        array_push($dt,array($mae['Cod Linea'],$mae['Cod Sublinea'],$mae['Nombre Estilo'],$mae['Cod Color'],$mae['Cod Opcion']));
                        $val3 = false;
                        $msj = $msj.$mae['Cod Opcion'].",";
                    }else{
                        array_push($dt,array($mae['Cod Linea'],$mae['Cod Sublinea'],$mae['Nombre Estilo'],$mae['Cod Color'],$mae['Cod Opcion']));
                    }
                }
            }
        }

        if ($val3 == false ) {
            if($tipoVal == 1){
                $_mensaje = array('Tipo' => $val3,
                    'Error'=> "(".substr($_Errorfile, 0, - 1).") -> El Número de opción no puede estar en blanco o en 0.");
            }
            elseif ($tipoVal == 2){
                $_mensaje = array('Tipo' => $val3,
                    'Error'=> "(".substr($_Errorfile, 0, - 1).") -> El Número de opción tiene que ser 12 caracteres. Ej:(SS19INDH0001)");
            }
            elseif ($tipoVal == 3){
                $_mensaje = array('Tipo' => $val3,
                    'Error'=> "(".substr($_Errorfile, 0, - 1).") -> El Número de opción tiene otra temporada la que esta seleccionada EJ. OI = FW | PV = SS.");
            }
            elseif ($tipoVal == 4){
                $_mensaje = array('Tipo' => $val3,
                    'Error'=> "Las siguientes opciones ya tienen código de opción:".$msj);
            }
            elseif ($tipoVal == 5){
                $_mensaje = array('Tipo' => $val3,
                    'Error'=> "Los siguientes códigos de opcion ya se encuentra utilizado por otra Opción:".$msj);
            }
            elseif ($tipoVal == 6){
                $_mensaje = array('Tipo' => $val3,
                    'Error'=> "Códigos de opcion duplicados en diferentes opciones:".$msj);
            }elseif ($tipoVal == 7){
                $_mensaje = array('Tipo' => $val3,
                    'Error'=> "Distintos códigos de opciones en la misma opcion:".$msj);
            }
        }else{
            $_mensaje = array('Tipo' => $val3,
                'Error'=> $_Errorfile);
        }
        return  $_mensaje;
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
                if ($rows[$i][$nom_columnas['PURCHASE GROUP']]  ==  null AND
                    $rows[$i][$nom_columnas['LINE (*)']]        ==  null AND
                    $rows[$i][$nom_columnas['SUBLNE CODE']]     ==  null AND
                    $rows[$i][$nom_columnas['STYLE NAME']]      ==  null AND
                    $rows[$i][$nom_columnas['COLOR CODE']]      ==  null AND
                    $rows[$i][$nom_columnas['OPTION NUMBER']]   ==  null AND
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
    public static function Val_campos_bmt($rows,$limite,$nom_columnas,$depto,$temporada,$dtjerarquia,$f3){
        $filarow = ""; $val = true;$_ErrorMsj = "";
        /*Validacion Id C1
        if ($val == true){ $tipoVal = 18;$_grup = "";$dtidcolor = [];
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
*/

        /*Validacion mas 2 departamento*/
        if($val == true){
            $dtduplicado2 = []; $filarow = "";
            for($i = 1;$i <= $limite; $i++){
                $_exist1 = false;
                foreach ($dtduplicado2 as $val3){
                    if ($val3 == $rows[$i][$nom_columnas['DEPARTMENT CODE']]){
                        $_exist1 = true; break;
                    }
                }
                if ($_exist1 == false){
                    array_push($dtduplicado2,$rows[$i][$nom_columnas['DEPARTMENT CODE']]);
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> Existen más de un grupo de compra en el archivo.";
                }

                if (count($dtduplicado2) > 1){
                    $val = false;
                    break;
                }
            }
        }

        /*Validacion Marca <> null*/
        if ($val == true){$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['LOCAL BRAND']] == null){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> La marca no puede ser nulo. .";
                }
            }
        }

        /*Validacion Marca codigo.*/
        if ($val == true){$data = plan_compra::list_Marcas($depto);$dtpaso = [];$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                $key = false;
                foreach ($dtpaso as $t){
                    if ($t == $rows[$i][$nom_columnas['LOCAL BRAND']]){
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $key= true; break;
                    }
                }
                if($key == false){
                    $_exist = plan_compra::get_codMarca2($rows[$i][$nom_columnas['LOCAL BRAND']],$data);
                    if ($_exist == 0){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> La(s) Marca(s) no se encuentra(n) BD plan. .";
                    }
                }
            }
        }

        /*Validacion Grupo Compra <> null*/
        if ($val == true){$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['PURCHASE GROUP']] == null or $rows[$i][$nom_columnas['PURCHASE GROUP']] == "0" or $rows[$i][$nom_columnas['PURCHASE GROUP']] == ""){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> El PURCHASE GROUP no puede ser nulo.";
                }
            }
        }

        /*Validacion Grupo Compra 2 mas en el archivo*/
        if($val == true){$filarow = "";
            $dtduplicado = [];
            for($i = 1;$i <= $limite; $i++){
                $_exist1 = false;
                foreach ($dtduplicado as $val3){
                    if ($val3 == $rows[$i][$nom_columnas['PURCHASE GROUP']]){
                        $_exist1 = true; break;
                    }
                }
                if ($_exist1 == false){
                    array_push($dtduplicado,$rows[$i][$nom_columnas['PURCHASE GROUP']]);
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> Existen más de un grupo de compra en el archivo.";
                }

                if (count($dtduplicado) > 1){
                    $val = false;
                    break;
                }
            }
        }

        /*Validacion Grupo Compra se encuentra en el plan*/
        if ($val == true){$dt_grup = plan_compra::list_grupocompraBD($temporada,$depto);$filarow = "";
            for($i = 1;$i <= $limite; $i++){$_exist = false;
                foreach ($dt_grup as $vl){
                    if ($rows[$i][$nom_columnas['PURCHASE GROUP']] == $vl["GRUPO_COMPRA"] ){
                        $_exist = true; break;
                    }
                }
                if ($_exist == false){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> El PURCHASE GROUP no se encuentra(n) en el registro de compra.";
                }
            }
        }

        /*Validacion jer.. Linea/Sublinea*/
        if($val == true){$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                $_existe2 = false;
                foreach ($dtjerarquia as $Valor){
                    if ((strtoupper($rows[$i][$nom_columnas['LINE (*)']]) === strtoupper($Valor['LIN_DESCRIPCION'])) and
                        (strtoupper($rows[$i][$nom_columnas['SUBLNE CODE']]) === strtoupper($Valor['SLI_SUBLINEA']))){
                        $_existe2 = true; break;
                    }
                }

                if ($_existe2 == false){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> La combinación de Línea(s) y sublinea(s) no se encuentra(n) en PMM.";
                }
            }
        }

        /*Validacion jer.. Style name <> null*/
        if ($val == true) {$filarow = "";
            for ($i = 1; $i <= $limite; $i++) {
                if ($rows[$i][$nom_columnas['STYLE NAME']] == null or $rows[$i][$nom_columnas['STYLE NAME']] == "0" or $rows[$i][$nom_columnas['STYLE NAME']] == "") {
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> El STYLE NAME no puede ser nulo.";
                }
            }
        }

        /*Validacion Codigo de opcion <> null*/
        if ($val == true){$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['OPTION NUMBER']] == null or $rows[$i][$nom_columnas['OPTION NUMBER']] == "0" or $rows[$i][$nom_columnas['OPTION NUMBER']] == ""){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> OPTION NUMBER no puede ser nulo o 0.";
                }
            }
        }

        /*Validacion Codigo de opcion en plan*/
        if($val == true){$filarow = "";
            $grupo_compra = $rows[1][$nom_columnas['PURCHASE GROUP']];
            $dtoptionNumberPlan = plan_compra::List_NOpcion_plan($temporada,$depto,$grupo_compra);$dtexiste = [];
            for($i = 1;$i <= $limite; $i++){
                $_paso = false; $exist = false;
                foreach ($dtexiste as $val2){
                    if ($rows[$i][$nom_columnas['OPTION NUMBER']] == $val2){
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_paso = true;
                        break;
                    }
                }
                if ($_paso == false){
                    foreach ($dtoptionNumberPlan as $val1){
                        if ($rows[$i][$nom_columnas['OPTION NUMBER']] == $val1['NUM_OPCION']){
                            $exist = true;
                            break;
                        }
                    }
                    if ($exist == false){
                        array_push($dtexiste,$rows[$i][$nom_columnas['OPTION NUMBER']]);
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> OPTION NUMBER no se encuentra en plan de compra.";
                        $val = false;
                    }
                }
            }
        }

        /*Validacion jer.. Cod Color*/
        if ($val == true) {$Colores = plan_compra::list_colores();$filarow = "";
            for($i = 1;$i <= $limite; $i++){$_existe = false;
                foreach ($Colores as $var) {
                    if ($var["COD_COLOR"] == $rows[$i][$nom_columnas['COLOR CODE']]) {
                        $_existe = true; break;
                    };
                }
                if($_existe == false ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> El Cod Color no se encuentra(n) en la BD PMM.";
                }
            }
        }

        /*Validacion jer.. Ventana*/
        if ($val == true) {$ventanas = array("A","B","C","D","E","F","G","H","I");$filarow = "";
          for($i = 1;$i <= $limite; $i++){$_existe = false;
              foreach ($ventanas as $var) {
                  if ($var == $rows[$i][$nom_columnas['VENTANA']]) {
                      $_existe = true; break;
                  };
              }
              if($_existe == false ){
                  $val = false;
                  $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                  $_ErrorMsj = ") -> La VENTANA no se encuentra(n) en la BD C1. Ej= A..I.";
              }

          }
      }

        /*Validacion count rows archivo vs plan*/
        if ($val == true) {$filarow = "";$dt = [];
            for($i = 1;$i <= $limite; $i++){
                array_push($dt,plan_compra::get_codMarca(strtoupper($rows[$i][$nom_columnas['LOCAL BRAND']]),$depto));
            }
            $dt= array_unique($dt);
            $marcas = "";
            foreach ($dt as $y){
                $marcas = $marcas.$y.",";
            }
            $marcas = substr($marcas,0,-1);

            $countPlan =plan_compra::countPlan_compra($temporada
                ,$depto
                ,$rows[1][$nom_columnas['PURCHASE GROUP']]
                ,$marcas);

            $countArchivo = count($rows)-1;

            if ($countArchivo <> $countPlan ){
                $val = false;
                $filarow = $filarow . 0 . ",";
                $_ErrorMsj = ") -> No cuadra las cantidades de opciones del (plan compra vs Archivo).";
            }
        }

        /*Validacion Validacion si existe opcion en el plan*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){


                $v = plan_compra::existe_opcion_plan_compra($temporada
                    ,$depto
                    ,$rows[$i][$nom_columnas['PURCHASE GROUP']]
                    ,plan_compra::get_codMarca(strtoupper($rows[$i][$nom_columnas['LOCAL BRAND']]),$depto)
                    ,plan_compra::get_codLinea(strtoupper($rows[$i][$nom_columnas['LINE (*)']]),$dtjerarquia)
                    ,$rows[$i][$nom_columnas['SUBLNE CODE']]
                    ,$rows[$i][$nom_columnas['STYLE NAME']]
                    ,$rows[$i][$nom_columnas['VENTANA']]
                    ,$rows[$i][$nom_columnas['OPTION NUMBER']]
                    ,$rows[$i][$nom_columnas['COLOR CODE']]);
                if($v == 0){
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> La(s) opcione(s) no se encuentra(n) en el plan de compra.";
                    $val = false;
                }
            }
        }

        /*Validacion Estilo de vida*/
        if ($val == true) {$filarow = "";
            $dt = plan_compra::list_estiloVida();
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['LIFE STYLE']] <> null or $rows[$i][$nom_columnas['LIFE STYLE']] <> ""){
                    $_ex = false;
                    foreach ($dt as $val4){
                        if( strtoupper($val4['DESCRIPCION']) == strtoupper($rows[$i][$nom_columnas['LIFE STYLE']])){
                            $_ex = true;
                            break;
                        }
                    }
                    if ($_ex == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> El LIFE STYLE(s) no se encuentra(n) BD C1.";
                    }
                }
            }
        }

        /*Validacion Ocacion de uso*/
        if ($val == true) {$filarow = "";
            $dt = plan_compra::list_ocacionuso();
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['CHANCE OF USER']] <> null or $rows[$i][$nom_columnas['CHANCE OF USER']] <> ""){
                    $_ex = false;
                    foreach ($dt as $val4){
                        if( strtoupper($val4['DESCRIPCION']) == strtoupper($rows[$i][$nom_columnas['CHANCE OF USER']])){
                            $_ex = true;
                            break;
                        }
                    }
                    if ($_ex == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> El CHANCE OF USER no se encuentra(n) BD C1.";
                    }
                }
            }
        }

        /*Validacion RNK*/
        if ($val == true) {$filarow = "";
            $dt = plan_compra::list_rnk($f3);
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['RANKING OF SALE']] <> null or $rows[$i][$nom_columnas['RANKING OF SALE']] <> ""){
                    $_ex = false;
                    foreach ($dt as $val4){
                        if( strtoupper($val4['DESCRIPCION']) == strtoupper($rows[$i][$nom_columnas['RANKING OF SALE']])){
                            $_ex = true;
                            break;
                        }
                    }
                    if ($_ex == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> El RANKING OF SALE no se encuentra(n) BD C1.";
                    }
                }
            }
        }

        /*Validacion Ciclo de vida*/
        if ($val == true) {$filarow = "";
            $dt = plan_compra::list_ciclo_vida();
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['LIFE CICLE']] <> null or $rows[$i][$nom_columnas['LIFE CICLE']] <> ""){
                    $_ex = false;
                    foreach ($dt as $val4){
                        if( strtoupper($val4['DESCRIPCION']) == strtoupper($rows[$i][$nom_columnas['LIFE CICLE']])){
                            $_ex = true;
                            break;
                        }
                    }
                    if ($_ex == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> El LIFE CICLE no se encuentra(n) BD C1.";
                    }
                }
            }
        }

        /*Validacion Tipo Producto*/
        if ($val == true) {$filarow = "";
            $dt = plan_compra::list_tipoProducto();
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['TYPE OF PRODUCT']] <> null or $rows[$i][$nom_columnas['TYPE OF PRODUCT']] <> ""){
                    $_ex = false;
                    foreach ($dt as $val4){
                        if( strtoupper($val4['NOM_TIPOPRODUC']) == strtoupper($rows[$i][$nom_columnas['TYPE OF PRODUCT']])){
                            $_ex = true;
                            break;
                        }
                    }
                    if ($_ex == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> El TYPE OF PRODUCT no se encuentra(n) BD C1.";
                    }
                }
            }
        }

        /*Validacion Tipo Producto regular no tiene que tener tipo exhibicion*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if (strtoupper($rows[$i][$nom_columnas['TYPE OF PRODUCT']])=="REGULAR"){
                    $_ex = true;
                    if ($rows[$i][$nom_columnas['TYPE OF EXHIBITION']] <> null or $rows[$i][$nom_columnas['TYPE OF EXHIBITION']] <> ""){
                        $_ex = false;
                    }
                    if ($_ex == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> Los tipos de Productos REGULARES no tiene tipo de Exhibición.";
                    }
                }
            }
        }

        /*Validacion Tipo exhibicion*/
        if ($val == true) {$filarow = "";
            $dt = plan_compra::list_tipoexhibicion();
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['TYPE OF EXHIBITION']] <> null or $rows[$i][$nom_columnas['TYPE OF EXHIBITION']] <> ""){
                    $_ex = false;
                    foreach ($dt as $val4){
                        if( strtoupper($val4['NOM_EXHIBICION']) == strtoupper($rows[$i][$nom_columnas['TYPE OF EXHIBITION']])){
                            $_ex = true;
                            break;
                        }
                    }
                    if ($_ex == false){
                        $val = false;
                        $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                        $_ErrorMsj = ") -> El TYPE OF EXHIBITION no se encuentra(n) BD C1.";
                    }
                }
            }
        }

        /*Validacion Prepack*/
        if ($val == true) {$PREPACK = array("CURVADO","SOLIDO");$filarow = "";
          for($i = 1;$i <= $limite; $i++){$_existe = false;
                foreach ($PREPACK as $var) {
                    if ($var == $rows[$i][$nom_columnas['PREPACK']]) {
                        $_existe = true; break;
                    };
                }
                if($_existe == false ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> El PREPACK tiene que ser CURVADO o SOLIDO.";
                }
          }
      }

        /*Validacion Paises*/
        if ($val == true) {$Paises= plan_compra::list_pais();$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if( $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == null or
                    $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == ""   or
                    $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == "0"  or
                    $rows[$i][$nom_columnas['COUNTRY OF ORIGIN']] == " "){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> COUNTRY OF ORIGIN no puede ser nulo o no se encuentra en PMM.";
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
                        $_ErrorMsj = ") -> COUNTRY OF ORIGIN no puede ser nulo o no se encuentra en PMM.";
                    }
                }
            }
      }

        /*Validacion VIA*/
        if ($val == true) {$VIA= array("MARITIMO","AREA","TERRESTRE");$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if( $rows[$i][$nom_columnas['SHIPMENT MODE']] == null or
                    $rows[$i][$nom_columnas['SHIPMENT MODE']] == ""   or
                    $rows[$i][$nom_columnas['SHIPMENT MODE']] == "0"  or
                    $rows[$i][$nom_columnas['SHIPMENT MODE']] == " "){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> SHIPMENT MODE no puede ser nulo o no se encuentra en BD C1.ej= MARITIMO,AREA,TERRESTRE";
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
                        $_ErrorMsj = ") -> SHIPMENT MODE no puede ser nulo o no se encuentra en BD C1.ej= MARITIMO,AREA,TERRESTRE";
                    }
                }
            }
        }

        /*Validacion Ciclo de vida*/
        if ($val == true) {$Ciclo_vida= plan_compra::list_ciclo_vida();$filarow = "";
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
                        $_ErrorMsj = ") -> LIFE CICLE no se encuentra en BD C1.";
                    }
                }
            }
        }

        /*Validacion Tallas*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['SIZE']] == null ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> SIZE no tiene que ser nulo.";
                }
            }
        }

        /*Validacion Porcentajes de Compras*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                $countTalla= count(explode(",",$rows[$i][$nom_columnas['SIZE']]));
                $SumPorcent = 0;
                for ($x = 1; $x <= $countTalla; $x++){
                        $SumPorcent += $rows[$i][$nom_columnas['Size %'.$x]];
                }

                if (($SumPorcent) < 99.9){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> La suma de los porcentajes de compras tiene que sumar 100%.";
                }elseif(($SumPorcent) > 100.1 ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> La suma de los porcentajes de compras tiene que sumar 100%.";
                }
            }
        }

        /*Validacion Costo UNIDADES FINALES */
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['TOTAL QUANTITY CL']] == null or $rows[$i][$nom_columnas['TOTAL QUANTITY CL']] == 0){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> TOTAL QUANTITY CL tiene que ser mayor que 0.";
                }
            }
        }

        /*Validacion Costo RFID,INSP,FOB <> null*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if(is_numeric($rows[$i][$nom_columnas['FINAL COST']])) {
                } else {
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> FINAL COST o RFID COST o INSPECTION COST tienen que ser datos numéricos.";
                }

                if(is_numeric($rows[$i][$nom_columnas['RFID COST']])) {
                } else {
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> FINAL COST o RFID COST o INSPECTION COST tienen que ser datos numéricos.";
                }

                if(is_numeric($rows[$i][$nom_columnas['INSPECTION COST']])) {
                } else {
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> FINAL COST o RFID COST o INSPECTION COST tienen que ser datos numéricos.";
                }
            }
        }

        /*Validacion Costo FOB <> 0*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['FINAL COST']] == 0){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> FINAL COST tiene que ser mayor que 0.";
                }
            }
        }

        /*Validacion Costo PRECIO BLANCO <> 0*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['RETAIL PRICE']] == null or $rows[$i][$nom_columnas['RETAIL PRICE']] == 0){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> RETAIL PRICE tiene que ser mayor que 0.";
                }
            }
        }

        /*Validacion PROVEEDOR*/
        if ($val == true) {$filarow = "";
            for($i = 1;$i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['VENDOR NICK NAME']] == null ){
                    $val = false;
                    $filarow = $filarow . strval($rows[$i][$nom_columnas['ID_FILAS']]) . ",";
                    $_ErrorMsj = ") -> VENDOR NICK NAME no tiene que ser nulo..";
                }
            }
        }


        if ($val == false ) {
            $array = array('Tipo' => $val,
                'Error' => "(" . substr($filarow, 0, -1) .$_ErrorMsj);
        }else{
            $array = array('Tipo' => $val,
            'Error'=> $_ErrorMsj);
        }

    return  $array;
    }
    public static function del_idcolor3_plan_compra($rows,$limite,$nom_columnas,$depto,$temporada,$grupo_compra,$login){

        $dtid_color3 = plan_compra::list_Idcolor3x_Grupo2($temporada,$depto,$grupo_compra);
        $_delete = ""; $key = false;
        $_error = TRUE;
        //opciones que no se encuentran en el archivo vs plan
        foreach ($dtid_color3 as $val){
            $_existe = false;
            for ($i = 1; $i <= $limite; $i++){
                if ($rows[$i][$nom_columnas['ID C1']] == $val['ID_COLOR3']){
                    $_existe = true;
                    break;
                }
            }
            if ($_existe == false){$key = true;
                $_delete = $_delete.$val['ID_COLOR3'].",";
            }
        }

        if ($key == true){
            $_delete = substr($_delete, 0, -1);
            $_error = plan_compra::updateopcioneliminado($temporada,$depto,$grupo_compra,$_delete,$login);
        }

       return $_error;

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