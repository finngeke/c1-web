<?php
/**
 * CONTROLADOR de AJAX Formulario de TEMPORADA DE COMPRA
 * Descripción:
 * Fecha: 2018-02-15
 * @author RODRIGO RIOSECO
 */

namespace temporada;

class ControlAjax extends \Control
{

    public function elimina_temporada($f3)
    {
        try {
            temporada::eliminaTemporada($f3->get('SESSION.login'), $f3->get('GET.temporada'), $f3->get('GET.estado_hidden'));
        } catch (Exception $ex) {
            echo 'ERROR-En el update PLC_TEMPORADA.';
        }
        echo 'OK-La tempora de Compra [' . strtoupper($f3->get('GET.temporada')) . '] fue modificada con éxito..';
    }


    public function quitar_temporada($f3)
    {
        try {
            temporada::quitarTemporada($f3->get('SESSION.login'), $f3->get('GET.temporada'));
        } catch (Exception $ex) {
            echo 'ERROR - Al quitar Temporda.';
        }
        echo 'OK - La tempora de Compra [' . strtoupper($f3->get('GET.temporada')) . '] fue eliminada.';
    }




    // Llenar
    public function listar_temporada($f3) {
        echo json_encode(temporada::listarTemporada());
    }



// Fin de la clase
}

