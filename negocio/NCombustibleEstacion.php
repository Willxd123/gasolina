<?php
require_once __DIR__ . '/../datos/DCombustibleEstacion.php';
require_once __DIR__ . '/../datos/migraciones/Migrador.php';
Migrador::ejecutar();

class NCombustibleEstacion {
    private DCombustibleEstacion $DCombustibleEstacion;

    public function __construct() {
        $this->DCombustibleEstacion = new DCombustibleEstacion();
    }

    public function listarPorEstacion(int $estacion_id): array {
        return $this->DCombustibleEstacion->obtenerPorEstacion($estacion_id);
    }

    public function registrar(int $estacion_id, int $tipo_combustible_id, int $cantidad_bombas, float $litros): bool {
        if ($this->DCombustibleEstacion->existeRelacion($estacion_id, $tipo_combustible_id)) {
            return false; // ya existe
        }
        $this->DCombustibleEstacion->setEstacionId($estacion_id);
        $this->DCombustibleEstacion->setTipoCombustibleId($tipo_combustible_id);
        $this->DCombustibleEstacion->setCantidadBombas($cantidad_bombas);
        $this->DCombustibleEstacion->setLitrosDisponibles($litros);
        return $this->DCombustibleEstacion->registrar();
    }

    public function editar(int $id, int $cantidad_bombas, float $litros): bool {
        $this->DCombustibleEstacion->setId($id);
        $this->DCombustibleEstacion->setCantidadBombas($cantidad_bombas);
        $this->DCombustibleEstacion->setLitrosDisponibles($litros);
        return $this->DCombustibleEstacion->actualizar();
    }

    public function eliminar(int $id): bool {
        $this->DCombustibleEstacion->setId($id);
        return $this->DCombustibleEstacion->eliminar();
    }
}
