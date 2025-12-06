<?php
/**
 * Clase Nodo - Representa un nodo del árbol de decisiones
 */
class Nodo {
    public $valor;
    public $izquierda;
    public $derecha;

    /**
     * Constructor del nodo
     * @param string $valor - Valor o descripción del nodo
     */
    public function __construct($valor) {
        $this->valor = $valor;
        $this->izquierda = null;
        $this->derecha = null;
    }
}
?>