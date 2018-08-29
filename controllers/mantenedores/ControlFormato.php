<?php
/*
 * CONTROLADOR de AJAX
 * Descripción: Permite consultar y posteriormente listar, información asociada a tiendas disponibles y asignadas 
 * Fecha: 23-03-2018
 * @author ROBERTO PÉREZ
 */

namespace mantenedores;

class ControlFormato extends \Control {

    // Llenar ListBox de Disponible
    public function obtiene_disponible($f3) {
           echo json_encode(\simulador_compra\formato::getDisponibles($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.FORMATO')));
    }
    
    // Llenar ListBox de Asignado
    public function obtiene_asignado($f3) {
       echo json_encode(\simulador_compra\formato::getAsignados($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.FORMATO')));
    }
    
     // Quitar Formato
    public function quitar_formato($f3) {
       echo \simulador_compra\formato::quitarFormato($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.FORMATO'),$f3->get('GET.ASIGNADO'),$f3->get('SESSION.login'));
    }

    // Quitar Formato para dejar sin registros
    public function quitar_formato_noasignados($f3) {
        echo \simulador_compra\formato::quitar_formato_noasignados($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.FORMATO'),$f3->get('GET.ASIGNADO'),$f3->get('SESSION.login'));
    }

    // Quitar Todos Formato
    public function quitar_todo_formato($f3) {
        echo \simulador_compra\formato::quitarTodoFormato($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.FORMATO'),$f3->get('GET.ASIGNADO'),$f3->get('SESSION.login'));
    }
    
    // Guardar Formato
    public function agrega_formato($f3) {
       echo \simulador_compra\formato::almacenaFormato($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.FORMATO'),$f3->get('GET.ASIGNADO'),$f3->get('SESSION.login'));
    }

    // Guardar Nuevo Formato
    public function agrega_nuevo_formato($f3) {
        echo \simulador_compra\formato::almacenaNuevoFormato($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO'),$f3->get('GET.NUEVO_FORMATO'),$f3->get('SESSION.login'));
    }

    // Llenar ListBox de Formatos (Esta llamada se utiliza luego de agregar un nuevo registro)
    public function obtiene_formato($f3) {
        echo json_encode(\simulador_compra\formato::getFormatos($f3->get('SESSION.COD_TEMPORADA'),$f3->get('SESSION.COD_DEPTO')));
    }

}
