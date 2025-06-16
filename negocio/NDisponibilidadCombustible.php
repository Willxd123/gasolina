<?php

require_once __DIR__ . '/../datos/DDisponibilidadCombustible.php';
require_once __DIR__ . '/patrones/Strategy/DisponibilidadCombustibleContext.php';
require_once __DIR__ . '/patrones/Strategy/GasolinaStrategy.php';
require_once __DIR__ . '/patrones/Strategy/DieselStrategy.php';
require_once __DIR__ . '/patrones/Strategy/GNVStrategy.php';


class NDisponibilidadCombustible
{
    private DDisponibilidadCombustible $DDisponibilidadCombustible;
    private DisponibilidadCombustibleContext $context;

    public function __construct()
    {
        $this->DDisponibilidadCombustible = new DDisponibilidadCombustible();
        $this->context = new DisponibilidadCombustibleContext();
    }

    public function estimarDisponibilidad(int $estacion_id, int $tipo_combustible_id, float $promedio, string $tipoNombre = ''): array
    {
        try {

            $tipoNombreLower = strtolower($tipoNombre);


            $strategy = null;
            $algoritmoInfo = '';

            if (strpos($tipoNombreLower, 'gasolina') !== false) {
                $strategy = new GasolinaStrategy();
                $algoritmoInfo = "Algoritmo Gasolina: Promedio 27.5L por vehículo, optimizado para vehículos ligeros.";
            } elseif (strpos($tipoNombreLower, 'diesel') !== false) {
                $strategy = new DieselStrategy();
                $algoritmoInfo = "Algoritmo Diesel: Promedio 45L por vehículo + factor corrección 0.9 para vehículos pesados.";
            } elseif (strpos($tipoNombreLower, 'gnv') !== false || strpos($tipoNombreLower, 'gas') !== false) {
                $strategy = new GNVStrategy();
                $algoritmoInfo = "Algoritmo GNV: Promedio 17.5 m³ por vehículo, optimizado para gas natural vehicular.";
            } else {

                $strategy = new GasolinaStrategy();
                $algoritmoInfo = "Algoritmo por defecto (Gasolina): Promedio 27.5L por vehículo.";
            }


            $this->context->setStrategy($strategy);

            $cantidad = $this->context->ejecutarEstrategia($estacion_id, $tipo_combustible_id, $promedio, $this->DDisponibilidadCombustible);

            return [
                'exito' => true,
                'cantidad' => $cantidad,
                'algoritmo' => $algoritmoInfo,
                'estrategia' => get_class($strategy)
            ];
        } catch (Exception $e) {
            return [
                'exito' => false,
                'mensaje' => $e->getMessage(),
                'cantidad' => -1,
                'algoritmo' => '',
                'estrategia' => ''
            ];
        }
    }

    public function getContextInfo(): array
    {
        $strategy = $this->context->getStrategy();
        return [
            'context_configurado' => $strategy !== null,
            'estrategia_actual' => $strategy ? get_class($strategy) : 'ninguna'
        ];
    }
}
