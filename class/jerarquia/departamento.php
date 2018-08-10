<?php

/**
 * CLASS Departamento
 * Descripción: Obtiene temporadas de la tabla PLC_TEMPORADA
 * Fecha: 2018-02-19
 * @author EDUARDO PACHECO
 */

namespace jerarquia;

use database;

class departamento extends \parametros {

    protected static $_table = 'GST_MAEDIVISI';
    protected static $_pk = 'DIV_DIVISION';
    protected static $_parametro = 'DIV_DESCRIPCION';

    /**
     * Constructor de clase     
     */
    public function __construct() {
        call_user_func_array(array('parent', '__construct'), func_get_args());
    }
    
     Public static function getDepartament(){
        
        $data = \database::getInstancia()->getFilas("SELECT DISTINCT DEP_DEPTO
                                                         ,DEP_DESCRIPCION 
                                                    FROM GST_MAEDEPTOS
                                                    WHERE DEP_COC_DVS NOT IN ('G05','G08','G07','G10')");

        return $data;
    }
    
		public static function getDepartamentSorted() {
			
			$data = \database::getInstancia()->getFilas("SELECT DISTINCT DEP_DEPTO
                                                         ,DEP_DESCRIPCION
                                                    FROM GST_MAEDEPTOS
                                                    WHERE DEP_COC_DVS NOT IN ('G05','G08','G07','G10')
                                                    ORDER BY DEP_DESCRIPCION");
			
			return $data;
		}
		
		
public static function getDepartamentoDivision($division, $depto) {
			
        /*$sql = "begin PLC_PKG_INSEASON.PRC_LIST_MSTPACK(" . $Cod_temporada . ",'" . $division . "', :data); end;";
        $data = \database::getInstancia()->getConsultaSP($sql,1);
        return $data;*/

        $sql = "SELECT RANK() OVER (PARTITION BY P1.PRD_LVL_NUMBER ORDER BY P1.PRD_LVL_NUMBER) NUMERO,
                           P5.PRD_LVL_NUMBER          AS COD_DIV,
                           P5.PRD_NAME_FULL           AS DIVISION,
                           P3.PRD_LVL_NUMBER          AS COD_DEPTO,
                           P3.PRD_NAME_FULL           AS DEPTO,
                           P2.PRD_LVL_NUMBER          AS COD_LINEA,
                           P2.PRD_NAME_FULL           AS LINEA,
                           P1.PRD_LVL_NUMBER          AS COD_SUBLINEA,
                           P1.PRD_NAME_FULL           AS SUBLINEA,
                            NVL((SELECT X.MSTPACK
                                 FROM PLC_MSTPACK X
                                 WHERE  TRIM(P3.PRD_LVL_NUMBER)   =X.COD_DEPTO      
                                 AND    TRIM(P2.PRD_LVL_NUMBER)   =X.COD_LIN        
                                 AND    TRIM(P1.PRD_LVL_NUMBER)   =X.COD_SUBLIN),0) AS MSTPACK
                          ,''ACTION                                 
                    FROM PRDMSTEE P1,
                         PRDMSTEE P2,
                         PRDMSTEE P3,
                         PRDMSTEE P4,
                         PRDMSTEE P5
                    WHERE P1.PRD_LVL_ID       =2
                    AND   P1.PRD_STATUS       =0
                    AND   P1.PRD_LVL_PARENT   =P2.PRD_LVL_CHILD
                    AND   P2.PRD_STATUS       =0   
                    AND   P2.PRD_LVL_PARENT   =P3.PRD_LVL_CHILD
                    AND   P3.PRD_STATUS       =0
                    AND   P3.PRD_LVL_PARENT   =P4.PRD_LVL_CHILD
                    AND   P4.PRD_STATUS       =0
                    AND   P4.PRD_LVL_PARENT   =P5.PRD_LVL_CHILD
                    AND   P5.PRD_STATUS       =0
                    AND   P5.PRD_LVL_NUMBER  = '".$division."' 
                    AND   P3.PRD_LVL_NUMBER  = '".$depto."' 
                    ORDER BY MSTPACK DESC
                    ";


        return \database::getInstancia()->getFilas($sql);



    }

    public static function getDepartamentosPorDivision($division) {

        $sql = "select DEP_DEPTO,DEP_DESCRIPCION from gst_maedeptos where dep_coc_dvs='" . $division . "'"
                . " ORDER BY DEP_DESCRIPCION ASC";


        return \database::getInstancia()->getFilas($sql);
    }

    public static function getLineas($depto) {
        $sql = "begin PLC_PKG_GENERAL.PRC_GET_LINEAS('" . $depto . "','0', :data); end;";
        return \database::getInstancia()->getConsultaSP($sql,1);
    }

    public static function getSubLineas($linea) {
        $sql = "begin PLC_PKG_GENERAL.PRC_GET_SUBLINEAS('0','0','" . $linea . "', :data); end;";
        return \database::getInstancia()->getConsultaSP($sql,1);
    }

    public static function almacenaDeptoMaster($depto, $linea, $sublinea) {

        $sql = "select 1 from plc_mstpack  WHERE COD_TEMPORADA=7"
                . " AND COD_DIV='1' AND COD_DEPTO='" . $depto . "' AND COD_LIN='" . $linea . "'"
                . " AND COD_SUBLIN='" . $sublinea . "'";

        $existe = (int) \database::getInstancia()->getFila($sql);

        if ($existe == 1) {
            echo 'ERROR- Los registros ya existen en el MasterPack.';
        } else {

            $sql = " INSERT INTO PLC_MSTPACK VALUES (7,1,'" . $depto . "','" . $linea . "','" . $sublinea . "',0,'')";
            try {
                \database::getInstancia()->getConsulta($sql);
            } catch (Exception $ex) {
                echo 'ERROR- Los registros ya existen en el MasterPack.';
            }
             echo 'OK- Se cargaron exitosamente los registros : [' . $depto . ' ' . $linea . ' ' . $sublinea . ']';
        }
    }

    public static function almacenaMasterPack($temporada, $depto, $division, $departamento, $linea,$sublinea,$masterpack) {

        $sql_existe = "SELECT 1 FROM plc_mstpack  
                WHERE COD_TEMPORADA = 7
                AND COD_DEPTO='" . $departamento . "' 
                AND COD_LIN='" . $linea . "'
                AND COD_SUBLIN='" . $sublinea . "'
            ";

        $existe = (int) \database::getInstancia()->getFila($sql_existe);

        if ($existe == 1) { $existe = 2; }else{ $existe = 1; }

    $sql = "begin PLC_PKG_DESARROLLO.PRC_ADD_MSTPACK2('" . $departamento . "','" . $linea . "','" . $sublinea . "','" . $masterpack . "',$existe, :error, :data); end;";

    $data = \database::getInstancia()->getConsultaSP($sql, 2);


    }





// fin de la clase
}
