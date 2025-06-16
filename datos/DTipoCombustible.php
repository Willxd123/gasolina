<?php
require_once __DIR__ . '/conexion.php';

class DTipoCombustible {
    private int $id;
    private string $nombre;
    private ?string $descripcion;
    private int $usuario_id;
    private PDO $conexion;

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

    public function setDescripcion(?string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function setUsuarioId(int $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    // Get all by user
    public function obtenerTodos(): array {
        $sql = "SELECT * FROM tipo_combustible WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$this->usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear
    public function registrar(): bool {
        $sql = "INSERT INTO tipo_combustible (nombre, descripcion, usuario_id) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->nombre, $this->descripcion, $this->usuario_id]);
    }

    // Editar
    public function editar(): bool {
        $sql = "UPDATE tipo_combustible SET nombre = ?, descripcion = ? WHERE id = ? AND usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->nombre, $this->descripcion, $this->id, $this->usuario_id]);
    }

    // Eliminar
    public function eliminar(): bool {
        $sql = "DELETE FROM tipo_combustible WHERE id = ? AND usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->id, $this->usuario_id]);
    }
}