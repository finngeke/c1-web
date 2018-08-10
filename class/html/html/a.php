<?php

namespace html\html;

class a extends element {

    protected $tag = 'a';
    protected $cierre = true;

    /**
     * Método helper que establece el href como atributo
     * @param string|int $url Dirección URL relativa o canónica
     * @return \html\html\element
     */
    public function setHref($url) {
        return parent::setAtributo('href', $url);
    }

    /**
     * Método abstracto que establece el valor como un atributo
     * @param string|int $valor
     */
    public function setValor($valor) {
        
    }

}
