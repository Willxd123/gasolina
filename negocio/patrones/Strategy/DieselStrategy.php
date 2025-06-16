<?php

require_once __DIR__ . '/IDisponibilidadCombustibleStrategy.php';


class DieselStrategy implements IDisponibilidadCombustibleStrategy {
    
    public function estimar(int $estacion_id, int $tipo_combustible_id, float $promedio, DDisponibilidadCombustible $repo): float {
        
        $promedioDiesel = $promedio > 0 ? $promedio : 45.0; 
        
        $litrosDisponibles = $repo->obtenerLitrosDisponibles($estacion_id, $tipo_combustible_id);
        
        if ($promedioDiesel <= 0) return -1;
        
      
        $factorCorreccion = 0.9; 
        
        return floor(($litrosDisponibles / $promedioDiesel) * $factorCorreccion);
    }
}