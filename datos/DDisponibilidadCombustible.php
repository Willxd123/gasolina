<?php


require_once __DIR__ . '/conexion.php';

class DDisponibilidadCombustible {
    private PDO $conexion;

    public function __construct() {
        $this->conexion = Conexion::obtenerInstancia()->obtenerConexion();
    }

    public function obtenerLitrosDisponibles(int $estacion_id, int $tipo_combustible_id): float {
        $sql = "SELECT litros_disponibles FROM combustible_estacion 
                WHERE estacion_id = ? AND tipo_combustible_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$estacion_id, $tipo_combustible_id]);
        return (float) $stmt->fetchColumn();
    }
}