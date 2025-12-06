<?php
require_once 'Nodo.php';

/**
 * Clase ArbolDecision - Representa el árbol de decisiones del cajero automático
 */
class ArbolDecision {
    private $raiz;

    public function __construct() {
        $this->raiz = null;
    }

    /**
     * Construir el árbol de decisiones del cajero
     */
    public function construirArbol() {
        // Raíz: Inicio
        $this->raiz = new Nodo("Inicio");

        // Nivel 1: Login y Registro
        $this->raiz->izquierda = new Nodo("Login");
        $this->raiz->derecha = new Nodo("Registro");

        // Nivel 2: Menú Principal (desde Login)
        $this->raiz->izquierda->izquierda = new Nodo("Menu Principal");

        // Nivel 3: Operaciones
        $menuPrincipal = $this->raiz->izquierda->izquierda;
        $menuPrincipal->izquierda = new Nodo("Consultar Saldo");
        $menuPrincipal->derecha = new Nodo("Operaciones");

        // Nivel 4: Depósitos y Retiros
        $operaciones = $menuPrincipal->derecha;
        $operaciones->izquierda = new Nodo("Depositar");
        $operaciones->derecha = new Nodo("Retirar");
    }

    /**
     * Recorrido en Preorden (Raíz - Izquierda - Derecha)
     */
    public function recorridoPreorden($nodo = null, &$recorrido = null) {
        if ($recorrido === null) {
            $recorrido = [];
        }

        if ($nodo === null) {
            $nodo = $this->raiz;
        }

        if ($nodo !== null) {
            $recorrido[] = $nodo->valor;
            if ($nodo->izquierda !== null) {
                $this->recorridoPreorden($nodo->izquierda, $recorrido);
            }
            if ($nodo->derecha !== null) {
                $this->recorridoPreorden($nodo->derecha, $recorrido);
            }
        }

        return $recorrido;
    }

    /**
     * Recorrido en Inorden (Izquierda - Raíz - Derecha)
     */
    public function recorridoInorden($nodo = null, &$recorrido = null) {
        if ($recorrido === null) {
            $recorrido = [];
        }

        if ($nodo === null) {
            $nodo = $this->raiz;
        }

        if ($nodo !== null) {
            if ($nodo->izquierda !== null) {
                $this->recorridoInorden($nodo->izquierda, $recorrido);
            }
            $recorrido[] = $nodo->valor;
            if ($nodo->derecha !== null) {
                $this->recorridoInorden($nodo->derecha, $recorrido);
            }
        }

        return $recorrido;
    }

    /**
     * Recorrido en Postorden (Izquierda - Derecha - Raíz)
     */
    public function recorridoPostorden($nodo = null, &$recorrido = null) {
        if ($recorrido === null) {
            $recorrido = [];
        }

        if ($nodo === null) {
            $nodo = $this->raiz;
        }

        if ($nodo !== null) {
            if ($nodo->izquierda !== null) {
                $this->recorridoPostorden($nodo->izquierda, $recorrido);
            }
            if ($nodo->derecha !== null) {
                $this->recorridoPostorden($nodo->derecha, $recorrido);
            }
            $recorrido[] = $nodo->valor;
        }

        return $recorrido;
    }

    /**
     * Obtener la raíz del árbol
     */
    public function getRaiz() {
        return $this->raiz;
    }
}
?>