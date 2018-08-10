<?php

namespace html\html;

class input extends element {

    protected $tag = 'input';
    protected $cierre = false;
    public $seleccionado = null;

    /**
     * Constructor de clase
     * @param string $tipo Determina el tipo de input
     */
    public function __construct($tipo = 'text') {
        $this->setAtributo('type', $tipo);
    }

    /**
     * Método abstracto que establece el valor como un atributo
     * @param string|int $valor
     * @return \html\html\element
     */
    public function setValor($valor) {
        return parent::setAtributo('value', $valor);
    }

    /**
     * Método que permite establecer el valor del radio que estamos imprimiendo
     * @param                   mixed $valor valor que se imprimirá en el select
     * @return \html\html\input
     */
    public function setValorSeleccionado($valor) {
        if ($this->getAtributo('type') == 'radio')
            $this->seleccionado = $valor;
        return $this;
    }

    /**
     * Override de parent::getHTML para generar el input con radio
     * @param       bool $borrar Si borrar el contenido en memoria
     * @return string
     */
    public function getHTML($borrar = true) {
        if ($this->getAtributo('type') == 'radio') {
            if ($this->getAtributo('value') == $this->seleccionado) {
                $this->setAtributo('checked', 'checked');
            } else {
                $this->doBorrarAtributo('checked');
            }
        }
        return parent::getHTML($borrar);
    }

}
