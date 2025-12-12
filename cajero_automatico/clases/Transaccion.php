<?php
/**
 * Clase Transaccion - Representa una transacción bancaria
 */
class Transaccion {
    private $id;
    private $tipo;
    private $monto;
    private $fecha;
    private $usuario;
    private $saldoAnterior;
    private $saldoNuevo;

    /**
     * Constructor
     */
    public function __construct($tipo, $monto, $usuario, $saldoAnterior, $saldoNuevo) {
        $this->id = uniqid();
        $this->tipo = $tipo;
        $this->monto = $monto;
        $this->fecha = date("Y-m-d H:i:s");
        $this->usuario = $usuario;
        $this->saldoAnterior = $saldoAnterior;
        $this->saldoNuevo = $saldoNuevo;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getSaldoAnterior() {
        return $this->saldoAnterior;
    }

    public function getSaldoNuevo() {
        return $this->saldoNuevo;
    }

    /**
     * Registrar transacción en archivo
     */
    public function registrar($archivo = "datos/transacciones.txt") {
        $linea = $this->id . "|" . 
                 $this->fecha . "|" . 
                 $this->usuario . "|" . 
                 $this->tipo . "|" . 
                 $this->monto . "|" . 
                 $this->saldoAnterior . "|" . 
                 $this->saldoNuevo . "\n";
        file_put_contents($archivo, $linea, FILE_APPEND);
    }

    /**
     * Obtener historial de transacciones de un usuario
     */
    public static function obtenerHistorial($usuario, $archivo = "datos/transacciones.txt") {
        $transacciones = [];

        if (!file_exists($archivo)) {
            return $transacciones;
        }

        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
        foreach ($lineas as $linea) {
            $datos = explode("|", $linea);
            if (count($datos) >= 7 && $datos[2] === $usuario) {
                $transacciones[] = [
                    'id' => $datos[0],
                    'fecha' => $datos[1],
                    'usuario' => $datos[2],
                    'tipo' => $datos[3],
                    'monto' => $datos[4],
                    'saldoAnterior' => $datos[5],
                    'saldoNuevo' => $datos[6]
                ];
            }
        }

        return array_reverse($transacciones); // Más recientes primero
    }
}
?>