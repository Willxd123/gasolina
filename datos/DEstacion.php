<?php
require_once __DIR__ . '/conexion.php';

class DEstacion {
    private int $id;
    private string $nombre;
    private string $direccion;
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

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function setUsuarioId(int $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    // Obtener estaciones del usuario
    public function obtenerPorUsuarioId(int $usuario_id): array {
        $sql = "SELECT * FROM estacion WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear estación
    public function registrar(): bool {
        $sql = "INSERT INTO estacion (nombre, direccion, usuario_id) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->nombre, $this->direccion, $this->usuario_id]);
    }

    // Editar estación
    public function editar(): bool {
        $sql = "UPDATE estacion SET nombre = ?, direccion = ? WHERE id = ? AND usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->nombre, $this->direccion, $this->id, $this->usuario_id]);
    }

    // Eliminar estación
    public function eliminar(): bool {
        $sql = "DELETE FROM estacion WHERE id = ? AND usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->id, $this->usuario_id]);
    }
}
