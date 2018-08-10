<?php

/**
 * CONTROLADOR de ALMACENAMIENTO CREACION DE REGISTROS
 * Descripción: 
 * Fecha: 2018-05-09
 * @author ROBERTO PÈREZ
 */

namespace jerarquia;

class ControlJerarquia extends \Control {

    // Llenar Tabla2
    public function almacenaMasterPack($f3) {
        echo \jerarquia\departamento::almacenaMasterPack($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.DIVISION'),$f3->get('GET.DEPARTAMENTO'),$f3->get('GET.LINEA'),$f3->get('GET.SUBLINEA'),$f3->get('GET.MASTERPACK'));
    }



// Termina Clase
}
