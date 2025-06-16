<?php
require_once __DIR__ . '/conexion.php';

class DTiempoEspera {
    private PDO $conexion;

    public function __construct() {
        $this->conexion = Conexion::obtenerInstancia()->obtenerConexion();
    }

    public function obtenerBombasPorEstacionYCombustible(int $estacion_id, int $tipo_combustible_id): int {
        $sql = "SELECT cantidad_bombas FROM combustible_estacion 
                WHERE estacion_id = ? AND tipo_combustible_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$estacion_id, $tipo_combustible_id]);
        return (int) $stmt->fetchColumn();
    }
}
