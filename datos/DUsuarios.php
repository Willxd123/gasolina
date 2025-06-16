<?php
require_once __DIR__ . '/conexion.php';

class DUsuarios {
    // Atributos (representan columnas de la tabla usuarios)
    private int $id;
    private string $nombre;
    private string $correo;
    private string $clave;

    private PDO $conexion;

    // Constructor: obtiene la conexión
    public function __construct() {
        $this->conexion = Conexion::obtenerInstancia()->obtenerConexion();
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function setCorreo(string $correo): void {
        $this->correo = $correo;
    }

    public function setClave(string $clave): void {
        $this->clave = password_hash($clave, PASSWORD_DEFAULT);
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getCorreo(): string {
        return $this->correo;
    }

    public function getClave(): string {
        return $this->clave;
    }

    // Método: Registrar Usuario
    public function registrarUsuario(): bool {
        try {
            $consulta = $this->conexion->prepare(
                "INSERT INTO usuarios (nombre, correo, clave) VALUES (?, ?, ?)"
            );
            return $consulta->execute([$this->nombre, $this->correo, $this->clave]);
        } catch (PDOException $e) {
            error_log("Error en registrarUsuario: " . $e->getMessage());
            return false;
        }
    }

    // Método: Verificar si el correo ya existe
    public function existeCorreo(string $correo): bool {
        try {
            $consulta = $this->conexion->prepare(
                "SELECT COUNT(*) FROM usuarios WHERE correo = ?"
            );
            $consulta->execute([$correo]);
            return $consulta->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error en existeCorreo: " . $e->getMessage());
            return false;
        }
    }

    // Método: Obtener usuario por correo
    public function obtenerUsuarioPorCorreo(string $correo): array|false {
        try {
            $consulta = $this->conexion->prepare(
                "SELECT * FROM usuarios WHERE correo = ? LIMIT 1"
            );
            $consulta->execute([$correo]);
            return $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerUsuarioPorCorreo: " . $e->getMessage());
            return false;
        }
    }
}
