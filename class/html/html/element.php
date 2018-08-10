<?php

namespace html\html;

abstract class element {

    protected $tag;
    protected $cierre = true;
    private $atributos = [];
    private $contenido = '';

    /**
     * Añade atributos al elemento HTML
     * @param array $atributos Arreglo construido como [atributo => valor]
     * @return \html\html\element
     */
    public function setAtributos($atributos = []) {
        $this->atributos = array_merge($this->atributos, $atributos);
        return $this;
    }

    /**
     * Método helper para setAtributos
     * @see element::setAtributos
     * @param string     $atributo Nombre del atributo
     * @param string|int $valor    Valor del atributo
     * @return \html\html\element
     */
    public function setAtributo($atributo, $valor) {
        return $this->setAtributos([$atributo => $valor]);
    }

    /**
     * Obtiene el HTML resultante
     * @param bool $borrar true si hay qeu borrar los atributos
     * @return string
     */
    public function getHTML($borrar = true) {
        $atributos = [];
        foreach (array_keys($this->atributos) as $atributo) {
            $atributos[] = sprintf('%s="%s"', $atributo, $this->atributos[$atributo]);
        }
        $texto = sprintf('<%s %s>%s', $this->tag, implode(" ", $atributos), $this->contenido);
        if ($this->cierre === true)
            $texto .= sprintf("</%s>", $this->tag);
        if ($borrar === true) {
            $this->atributos = [];
            $this->contenido = '';
        }
        return $texto;
    }

    /**
     * Método helper de setAtributos para establecer el nombre
     * @param string $nombre
     * @return \html\html\element
     */
    public function setNombre($nombre) {
        return $this->setAtributo('name', $nombre);
    }

    /**
     * Método helper de setAtributos para establecer la clase
     * @param string $nombre
     * @return \html\html\element
     */
    public function setClass($class) {
        return $this->setAtributo('class', $class);
    }

    /**
     * Método helper de setAtributos para establecer el id
     * @param string $nombre
     * @return \html\html\element
     */
    public function setId($id) {
        return $this->setAtributo('id', $id);
    }

    /**
     * Método helper de setAtributos para establecer el contenido
     * @param string $nombre
     * @return \html\html\element
     */
    public function setContenido($contenido) {
        $this->contenido = $contenido;
        return $this;
    }

    /**
     * Obtiene el atributo del elementos
     * @param string       $atributo Nombre del atributo
     * @return string|null Valor del atributo o nulo
     */
    public function getAtributo($atributo) {
        return isset($this->atributos[$atributo]) ? $this->atributos[$atributo] : null;
    }

    /**
     * Borra varios atributos 
     * @param                     string $atributos arreglo de atributos a borrar
     * @return \html\html\element
     */
    public function doBorrarAtributos($atributos = array()) {
        foreach ($atributos as $atr)
            if (isset($this->atributos[$atr]))
                unset($this->atributos[$atr]);
        return $this;
    }

    /**
     * Método helper de borrar atributos
     * @param       string $atributo atributo a borrar
     * @return \html\html\element
     */
    public function doBorrarAtributo($atributo) {
        return $this->doBorrarAtributos([$atributo]);
    }

    /**
     * Método abstracto que permite establecer el valor según la etiqueta
     * @param string $nombre
     * @return \html\html\element
     */
    abstract public function setValor($valor);

    /**
     * Método mágico 
     * 
     * Obtiene automáticamente el texto que se renderizará sin eliminar el contenido
     * @return string
     */
    public function __toString() {
        return $this->getHTML(false);
    }

}
