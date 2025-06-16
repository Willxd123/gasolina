<?php
require_once __DIR__ . '/conexion.php';

class DCombustibleEstacion {
    private int $id;
    private int $estacion_id;
    private int $tipo_combustible_id;
    private int $cantidad_bombas;
    private float $litros_disponibles;
    private PDO $conexion;

    public function __construct() {
        $this->conexion = Conexion::obtenerInstancia()->obtenerConexion();
    }

    public function setId(int $id): void { $this->id = $id; }
    public function setEstacionId(int $estacion_id): void { $this->estacion_id = $estacion_id; }
    public function setTipoCombustibleId(int $tipo_combustible_id): void { $this->tipo_combustible_id = $tipo_combustible_id; }
    public function setCantidadBombas(int $cantidad): void { $this->cantidad_bombas = $cantidad; }
    public function setLitrosDisponibles(float $litros): void { $this->litros_disponibles = $litros; }

    public function registrar(): bool {
        $sql = "INSERT INTO combustible_estacion (estacion_id, tipo_combustible_id, cantidad_bombas, litros_disponibles) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->estacion_id, $this->tipo_combustible_id, $this->cantidad_bombas, $this->litros_disponibles]);
    }

    public function actualizar(): bool {
        $sql = "UPDATE combustible_estacion SET cantidad_bombas = ?, litros_disponibles = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->cantidad_bombas, $this->litros_disponibles, $this->id]);
    }

    public function eliminar(): bool {
        $sql = "DELETE FROM combustible_estacion WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    public function obtenerPorEstacion(int $estacion_id): array {
        $sql = "SELECT ce.id, ce.cantidad_bombas, ce.litros_disponibles, tc.nombre AS tipo_combustible 
                FROM combustible_estacion ce 
                JOIN tipo_combustible tc ON ce.tipo_combustible_id = tc.id 
                WHERE ce.estacion_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$estacion_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeRelacion(int $estacion_id, int $tipo_combustible_id): bool {
        $sql = "SELECT COUNT(*) FROM combustible_estacion WHERE estacion_id = ? AND tipo_combustible_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$estacion_id, $tipo_combustible_id]);
        return $stmt->fetchColumn() > 0;
    }
}

