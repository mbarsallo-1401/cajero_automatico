<?php
/**
 * Clase Cuenta - Representa una cuenta bancaria
 */
class Cuenta {
    private $numeroCuenta;
    private $saldo;
    private $usuario;

    /**
     * Constructor
     */
    public function __construct($numeroCuenta, $saldo = 0, $usuario = "") {
        $this->numeroCuenta = $numeroCuenta;
        $this->saldo = $saldo;
        $this->usuario = $usuario;
    }

    // Getters
    public function getNumeroCuenta() {
        return $this->numeroCuenta;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Consultar saldo
     */
    public function consultarSaldo() {
        return $this->saldo;
    }

    /**
     * Depositar dinero
     * @param float $monto
     * @return bool
     */
    public function depositar($monto) {
        if ($monto > 0) {
            $this->saldo += $monto;
            return true;
        }
        return false;
    }

    /**
     * Retirar dinero
     * @param float $monto
     * @return bool
     */
    public function retirar($monto) {
        if ($monto > 0 && $monto <= $this->saldo) {
            $this->saldo -= $monto;
            return true;
        }
        return false;
    }

    /**
     * Guardar cuenta en archivo
     */
    public function guardarCuenta($archivo = "datos/cuentas.txt") {
        // Leer todas las cuentas
        $cuentas = [];
        if (file_exists($archivo)) {
            $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
            foreach ($lineas as $linea) {
                $datos = explode("|", $linea);
                if (count($datos) >= 3 && $datos[1] !== $this->usuario) {
                    $cuentas[] = $linea;
                }
            }
        }

        // Agregar cuenta actualizada
        $cuentas[] = $this->numeroCuenta . "|" . $this->usuario . "|" . $this->saldo;

        // Guardar todas las cuentas
        file_put_contents($archivo, implode("\n", $cuentas) . "\n");
    }

    /**
     * Cargar cuenta desde archivo
     */
    public static function cargarCuenta($usuario, $archivo = "datos/cuentas.txt") {
        if (!file_exists($archivo)) {
            // Crear cuenta nueva con saldo inicial de 1000
            $cuenta = new Cuenta(uniqid(), 1000, $usuario);
            $cuenta->guardarCuenta($archivo);
            return $cuenta;
        }

        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
        foreach ($lineas as $linea) {
            $datos = explode("|", $linea);
            if (count($datos) >= 3 && $datos[1] === $usuario) {
                return new Cuenta($datos[0], floatval($datos[2]), $datos[1]);
            }
        }

        // Si no existe, crear cuenta nueva
        $cuenta = new Cuenta(uniqid(), 1000, $usuario);
        $cuenta->guardarCuenta($archivo);
        return $cuenta;
    }
}
?>