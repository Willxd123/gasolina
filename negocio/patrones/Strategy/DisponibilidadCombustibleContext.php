<?php

require_once __DIR__ . '/IDisponibilidadCombustibleStrategy.php';


class DisponibilidadCombustibleContext {
    private ?IDisponibilidadCombustibleStrategy $strategy;

    public function __construct() {
        $this->strategy = null;
    }

   
    public function setStrategy(IDisponibilidadCombustibleStrategy $strategy): void {
        $this->strategy = $strategy;
    }

   
    public function ejecutarEstrategia(int $estacion_id, int $tipo_combustible_id, float $promedio, DDisponibilidadCombustible $repo): float {
        if ($this->strategy === null) {
            throw new Exception("No se ha configurado una estrategia de cálculo");
        }

        return $this->strategy->estimar($estacion_id, $tipo_combustible_id, $promedio, $repo);
    }

   
    public function getStrategy(): ?IDisponibilidadCombustibleStrategy {
        return $this->strategy;
    }
}