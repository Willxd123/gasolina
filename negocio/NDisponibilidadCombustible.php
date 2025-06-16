
<?php

require_once __DIR__ . '/../datos/DDisponibilidadCombustible.php';

class NDisponibilidadCombustible {
    private DDisponibilidadCombustible $DDisponibilidadCombustible;

    public function __construct() {
        $this->DDisponibilidadCombustible = new DDisponibilidadCombustible();
    }

    public function estimarDisponibilidad(int $estacion_id, int $tipo_combustible_id, float $promedioLitros): int {
        $litros = $this->DDisponibilidadCombustible->obtenerLitrosDisponibles($estacion_id, $tipo_combustible_id);
        if ($promedioLitros <= 0) return -1;
        return (int) floor($litros / $promedioLitros);
    }
}