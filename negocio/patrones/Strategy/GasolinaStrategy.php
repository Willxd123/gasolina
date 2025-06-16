<?php

require_once __DIR__ . '/IDisponibilidadCombustibleStrategy.php';


class GasolinaStrategy implements IDisponibilidadCombustibleStrategy {
    
    public function estimar(int $estacion_id, int $tipo_combustible_id, float $promedio, DDisponibilidadCombustible $repo): float {
      
        $promedioGasolina = $promedio > 0 ? $promedio : 27.5; // Promedio estándar para gasolina
        
        $litrosDisponibles = $repo->obtenerLitrosDisponibles($estacion_id, $tipo_combustible_id);
        
        if ($promedioGasolina <= 0) return -1;
        
        return floor($litrosDisponibles / $promedioGasolina);
    }
}