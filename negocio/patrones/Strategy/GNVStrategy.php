<?php

require_once __DIR__ . '/IDisponibilidadCombustibleStrategy.php';


class GNVStrategy implements IDisponibilidadCombustibleStrategy {
    
    public function estimar(int $estacion_id, int $tipo_combustible_id, float $promedio, DDisponibilidadCombustible $repo): float {
        
        $promedioGNV = $promedio > 0 ? $promedio : 17.5; // Promedio estándar para GNV
        
        $litrosDisponibles = $repo->obtenerLitrosDisponibles($estacion_id, $tipo_combustible_id);
        
        if ($promedioGNV <= 0) return -1;
        
    
        
        return floor($litrosDisponibles / $promedioGNV);
    }
}