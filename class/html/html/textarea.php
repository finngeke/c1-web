<?php

namespace html\html;

class textarea extends element {

    protected $tag = 'textarea';
    protected $cierre = true;

    /**
     * Método abstracto que establece el valor como un atributo
     * @param string|int $valor
     */
    public function setValor($valor) {
        return parent::setContenido($valor);
    }

}
