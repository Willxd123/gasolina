<?php
// datos/conexion.php
require_once __DIR__ . '/../config/database.php';

class Conexion {
    private static $instancia = null;
    private $conexion;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NOMBRE . ";charset=" . DB_CHARSET;
            $this->conexion = new PDO(
                $dsn,
                DB_USUARIO,
                DB_CLAVE,
                DB_OPCIONES
            );
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
    
    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }
    
    public function obtenerConexion() {
        return $this->conexion;
    }
}