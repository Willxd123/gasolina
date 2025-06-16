<?php

interface IDisponibilidadCombustibleStrategy {
    public function estimar(int $estacion_id, int $tipo_combustible_id, float $promedio, DDisponibilidadCombustible $repo): float;
}
