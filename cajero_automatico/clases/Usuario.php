<?php
/**
 * Clase Usuario - Representa un usuario del sistema
 */
class Usuario {
    private $id;
    private $nombre;
    private $password;
    private $email;

    /**
     * Constructor
     */
    public function __construct($id, $nombre, $password, $email = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->email = $email;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Autenticar usuario
     * @param string $passwordIngresada
     * @return bool
     */
    public function autenticar($passwordIngresada) {
        return $this->password === $passwordIngresada;
    }

    /**
     * Guardar usuario en archivo
     */
    public static function guardarUsuario($usuario, $archivo = "datos/usuarios.txt") {
        $linea = $usuario->getId() . "|" . 
                 $usuario->getNombre() . "|" . 
                 $usuario->getPassword() . "|" . 
                 $usuario->getEmail() . "\n";
        file_put_contents($archivo, $linea, FILE_APPEND);
    }

    /**
     * Buscar usuario por nombre
     */
    public static function buscarUsuario($nombre, $archivo = "datos/usuarios.txt") {
        if (!file_exists($archivo)) {
            return null;
        }

        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
        foreach ($lineas as $linea) {
            $datos = explode("|", $linea);
            if (count($datos) >= 3 && $datos[1] === $nombre) {
                return new Usuario($datos[0], $datos[1], $datos[2], $datos[3] ?? "");
            }
        }
        return null;
    }

    /**
     * Verificar si el usuario existe
     */
    public static function existeUsuario($nombre, $archivo = "datos/usuarios.txt") {
        return self::buscarUsuario($nombre, $archivo) !== null;
    }
}
?>