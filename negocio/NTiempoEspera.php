<?php
require_once __DIR__ . '/../datos/DTiempoEspera.php';

class NTiempoEspera {
    private DTiempoEspera $DTiempoEspera;

    public function __construct() {
        $this->DTiempoEspera = new DTiempoEspera();
    }

    public function calcularEspera(int $estacion_id, int $tipo_combustible_id, float $distancia): float {
        $bombas = $this->DTiempoEspera->obtenerBombasPorEstacionYCombustible($estacion_id, $tipo_combustible_id);
        if ($bombas <= 0) return -1;

        $long_vehiculo = 4.5;
        $separacion = 0.5;
        $long_total = $long_vehiculo + $separacion;
        $tiempo_promedio = 3;

        $nro_vehiculos = floor($distancia / $long_total);
        $tiempo_estimado = ($nro_vehiculos / $bombas) * $tiempo_promedio;

        return round($tiempo_estimado, 2);
    }
}
